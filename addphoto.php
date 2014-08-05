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
require_once(dirname(__FILE__) . '/locallib.php');

$id = required_param('id', PARAM_INT);

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/addphoto.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');

$mform = new addphoto_form($CFG->wwwroot.'/mod/customcertificate/addphoto.php?id='.$id);


if (!$data = $mform->get_data()) {
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));
    $mform->display();
    add_to_log($context->instanceid, 'customcertificate', 'verify', 'addphoto.php?id='.$id);
    $mform->set_data(array('id'=>$id));
    echo $OUTPUT->footer();
} else {
    $fs = get_file_storage();
    $fileinfo=customcertificate::get_certificate_image_fileinfo($context->id);
    $fs->delete_area_files($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],$fileinfo['itemid']);
    
    $mform->save_stored_file('userphoto', $fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $mform->get_new_filename('userphoto'));
    //file_save_draft_area_files($data->userphoto, $context->id, 'course', 'courseimage', 0);

    //file_save_draft_area_files($data->userphoto, $context->id, 'mod_customcertificate', 'userphoto', 0, array('subdirs' => 0, 'maxbytes' => 102400, 'maxfiles' => 50));

    //file_save_draft_area_files($data->userphoto, $context->id, 'mod_customcertificate', 'userphoto', 0);

    if (!$certificate = $DB->get_record('customcertificate', array('id'=> $id))) {
        print_error('certificate module is incorrect');
    }

    if (!$userphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $USER->id, 'certificateid' => $id))) {
        print_error(get_string('invalidcode','customcertificate'));
    }
    else
    {
        //$issueuserphoto->userphoto = $mform->get_new_filename('userphoto');
        $DB->set_field('customcertificate_userphoto', 'userphoto', $mform->get_new_filename('userphoto'), array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'contextid', $fileinfo['contextid'], array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'component', $fileinfo['component'], array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'filearea', $fileinfo['filearea'], array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'itemid', $fileinfo['itemid'], array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'filepath', $fileinfo['filepath'], array('userid' => $USER->id, 'certificateid' => $id));
        
    }

    redirect($CFG->wwwroot.'/mod/customcertificate/pending.php?id=' . $id); 
}
