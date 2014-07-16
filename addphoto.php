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
$code = required_param('code', PARAM_ALPHANUMEXT);
//$code = optional_param('code', null,PARAM_ALPHANUMEXT); // Issed Code

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/addphoto.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');

$mform = new addphoto_form($CFG->wwwroot.'/mod/customcertificate/addphoto.php?id='.$id.'&code='.$code);
//$mform = new addphoto_form($CFG->wwwroot.'/mod/customcertificate/pending.php?id='. $id);


if (!$mform->get_data()) {
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));
    $mform->display();
    add_to_log($context->instanceid, 'customcertificate', 'verify', 'addphoto.php?id='.$id.'&code='.$code);
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
        //$issueuserphoto->userphoto = $mform->get_new_filename('userphoto');
        $DB->set_field('customcertificate_userphoto', 'userphoto', $mform->get_new_filename('userphoto'), array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'contextid', $fileinfo['contextid'], array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'component', $fileinfo['component'], array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'filearea', $fileinfo['filearea'], array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'itemid', $fileinfo['itemid'], array('userid' => $USER->id, 'certificateid' => $id));
        $DB->set_field('customcertificate_userphoto', 'filepath', $fileinfo['filepath'], array('userid' => $USER->id, 'certificateid' => $id));
        //$DB->update_record('customcertificate_userphoto', $issueuserphoto);
        //print_error($issueuserphoto->userphoto.'TEEEEST');
    }


    /*if (!$certrecord = $DB->get_record('customcertificate_issues', array('id'=> $issue))) {
        print_error('certificate issue module is incorrect');
    }*/

    /*if(!$certissue = $DB->get_record('customcertificate_issues', array('userid' => $USER->id, 'certificateid' => $id, 'timedeleted' => null)))
    {
        print_error('certificate issue module is incorrect');
    }*/

    //$certrecord = $customcertificate->get_issue($USER);

    /*if(!$certrecord = $customcertificate->get_issue($USER))
    {
        print_error('certificate issue module is incorrect');
    }*/

    /*
    if (!$certissue = $DB->get_record('customcertificate_issues', array('userid' => $USER->id, 'certificateid' => $id, 'timedeleted' => null))) {
        print_error('certificate issue module is incorrect');
    }*/
    //$certrecord->userphoto = $mform->get_new_filename('userphoto');
    

    /*if (!$DB->update_record('customcertificate_issues', $certissue)) {
        print_erro('impossible de sauvegarder');
    }*/

    //$DB->update_record('customcertificate', $certrecord);
    //customcertificate_send_event($certificate);
    redirect($CFG->wwwroot.'/mod/customcertificate/pending.php?id=' . $id); 
}
