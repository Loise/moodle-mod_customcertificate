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
require_once('addphoto_form.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__) . '/locallib.php');

$id = required_param('id', PARAM_INT);
$retry = optional_param('retry', 0, PARAM_INT);

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/addphoto.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');

$mform = new addphoto_form($CFG->wwwroot.'/mod/customcertificate/addphoto.php?id='.$id);


if (!$data = $mform->get_data()) {
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));
    if($retry == 1)
    {
        echo html_writer::tag('p', "The name of your file contains special characters, thank you to fix that and try again.", array('style' => 'text-align:center'));
        $retry = 0;
    }
    $mform->display();
    add_to_log($context->instanceid, 'customcertificate', 'verify', 'addphoto.php?id='.$id);
    $mform->set_data(array('id'=>$id));
    echo $OUTPUT->footer();
} else {
    $fs = get_file_storage();
    $fileinfo=customcertificate::get_certificate_image_fileinfo($context->id);
    $fs->delete_area_files($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],$fileinfo['itemid']);
    
    $mform->save_stored_file('userphoto', $fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $mform->get_new_filename('userphoto'));

    if (!$certificate = $DB->get_record('customcertificate', array('id'=> $id))) {
        print_error('certificate module is incorrect');
    }

    if (!$userphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $USER->id, 'certificateid' => $id))) {
        print_error(get_string('invalidcode','customcertificate'));
    }
    else
    {
        $imagefileuser = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $mform->get_new_filename('userphoto'));
        $racine = "./pix/userphoto/";
        if(!is_dir($racine)){
            mkdir($racine, 0700);
        }

        if(!is_dir($racine.'/'.$userphoto->id)){
            mkdir($racine.'/'.$userphoto->id, 0700);
        }
                        
        $dir = $CFG->tempdir;
        $prefix = "mod_customcertificate";

        /*
        //Normalisation de la chaine utf8 en mode caractère + accents
        $filename = Normalizer::normalize($mform->get_new_filename('userphoto'), Normalizer::FORM_D);
        //Suppression des accents
        preg_replace('~\p{Mn}~u', '', $filename);
        */

        
        //$filename = htmlentities($mform->get_new_filename('userphoto'), ENT_NOQUOTES, 'utf-8');
        //$filename = utf8_encode ($mform->get_new_filename('userphoto'));
    
        /*$filename = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $filename);
        $filename = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $filename); // pour les ligatures e.g. '&oelig;'
        $filename = preg_replace('#&[^;]+;#', '', $filename); // supprime les autres caractères*/

        $filename =  $mform->get_new_filename('userphoto');

        $pattern = "#^[a-zA-Z0-9_.]+$#i";
        if (!(preg_match($pattern , $filename)))
        {
            header("Refresh: 0; url=addphoto.php?id=".$id."&retry=1");
            //print_error("Ton nom de fichier n'est pas valide du tout !!!");
        }
        else
        {
            $fullfilepath = $racine.'/'.$userphoto->id . '/' . $filename;
            $imagefileuser->copy_content_to($fullfilepath);

            $DB->set_field('customcertificate_userphoto', 'userphoto', $filename, array('userid' => $USER->id, 'certificateid' => $id));

            $role = $DB->get_record('role', array('shortname' => 'editingteacher'));
            $context = get_context_instance(CONTEXT_COURSE, $certificate->course);
            $teachers = get_role_users($role->id, $context);
            foreach ($teachers as $teacher) {
                email_to_user($teacher, format_string($teacher->email, true), "[Moodle] A user need a validation of photo !", "You can validation the users photos here : ".$CFG->wwwroot.'/mod/customcertificate/validation.php?id='.$id, '<font face="sans-serif"><p>You can validation the users photos here : '.$CFG->wwwroot.'/mod/customcertificate/validation.php?id='.$id.'">link</a></p></font>');
            }
            
            redirect($CFG->wwwroot.'/mod/customcertificate/pending.php?id=' . $id); 
        }
    }
}
