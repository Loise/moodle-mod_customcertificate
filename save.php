<?php

/**
 * Verify an issued certificate by code
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  Carlos Fonseca <carlos.alexandre@outlook.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__).'/lib.php');

$id   = required_param('id', PARAM_INT); // Course module ID
$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/save.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');

if (!$cm = get_coursemodule_from_id('customcertificate', $id)) {
   print_error('Course Module ID was incorrect');
}

if (!$certificate = $DB->get_record('customcertificate', array('id'=> $cm->instance))) {
   print_error('course module is incorrect');
}

$issuecertificates = $DB->get_records('customcertificate_issues', array('certificateid' => $certificate->id, 'timedeleted' => null));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));

$zip = new ZipArchive(); 

if($zip->open('backup_customcertificate_'.$certificate->id.'.zip', ZipArchive::CREATE) === true)
{
   foreach ($issuecertificates as $issuecertificate) 
   {
      $idCourse = $issuecertificate->certificateid;
      while(strlen($idCourse)<6)
      {
         $idCourse = '0'.$idCourse;
      }
      $idCode = $issuecertificate->id;
      $racine = "./save";
      $structure = $racine."/".$idCourse;

      $zip->addFile($structure.'/'.$issuecertificate->userid.'.pdf', $idCode.'.pdf');

      echo $structure.'/'.$issuecertificate->userid.'.pdf';
   }
   // Ajout d'un fichier
   $zip->addFile('save.php');

     // Et on referme l'archive
   $zip->close();
   echo 'Archive terminée<br/>';
}
else
{
   echo 'Impossible d&#039;ouvrir &quot;Zip.zip<br/>';
}



/*
foreach ($issuecertificates as $issuecertificate) 
{
   $fs = get_file_storage();

   // Prepare file record object
   $fileinfo = self::get_certificate_issue_fileinfo($issuecertificate->userid, $issuecertificate->id, $context->id);
   $fileinfo['filename'] = clean_filename($certificate->name . '.pdf');;

   // Check for file first
   if (!$fs->file_exists($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename'])) {
      $pdf=get_pdf($issuecertificate);
      $fs->create_file_from_string($fileinfo, $pdf->Output('', 'S'));
   }

   $imagefileuser = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']));


   $idCourse = "$this->course";
   while(strlen($idCourse)<6)
   {
      $idCourse = '0'.$idCourse;
   }
   $idCode = $this->get_issue_uuid();
   $racine = "./save";
   if(!is_dir($racine)){
      mkdir($racine, 0700);
   }
   $structure = "./".$racine."/".$idCourse;
   if(!is_dir($structure)){
      mkdir($structure, 0700);
   }

   $fullfilepath = $structure.'/'.$idCode.'.pdf';
   $imagefileuser->copy_content_to($fullfilepath);

   $zip->addFile($fullfilepath, $idCode.'.pdf');

   foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($racine, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $path) {
      $path->isDir() ? rmdir($path->getPathname()) : unlink($path->getPathname());
   }
   rmdir($racine);

     //file_put_contents($structure.'/'.$idCode.'.pdf', $pdf->Output('', 'S'));
}
*/


echo 'Archive crée à récuperer <a href="'.$CFG->wwwroot.'/mod/customcertificate/backup_customcertificate_'.$certificate->id.'.zip">ici</a>';

echo $OUTPUT->footer();


