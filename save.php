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

$coursenode = $PAGE->settingsnav->add(get_string('pluginadministration', 'customcertificate'));
if ($coursenode) {
    $coursenode->add('Validation pictures of students', './validation.php?id='.$id)->make_active();
    $coursenode->add('Verification of certificate', './verify.php')->make_active();
    $coursenode->add('Archive', './save.php?id='.$id)->make_active();
}

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

     // Et on referme l'archive
   $zip->close();
   echo 'Archive terminée<br/>';
}
else
{
   echo 'Impossible d&#039;ouvrir &quot;Zip.zip<br/>';
}

echo 'Archive crée à récuperer <a href="'.$CFG->wwwroot.'/mod/customcertificate/backup_customcertificate_'.$certificate->id.'.zip">ici</a>';

echo $OUTPUT->footer();


