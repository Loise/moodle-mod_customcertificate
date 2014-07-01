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
//$code = optional_param('code', null,PARAM_ALPHANUMEXT); // Issed Code

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/addphoto.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));
$mform = new addphoto_form($CFG->wwwroot.'/mod/customcertificate/pending.php?id='. $id);
$mform->display();

if (!$mform->get_data()) {
    echo html_writer::tag('p', "error : no data", array('style' => 'text-align:center'));
    add_to_log($context->instanceid, 'customcertificate', 'verify', "addphoto.php?id=$id");
    $mform->set_data(array('id'=>$id));
} else {
    echo html_writer::tag('p', "data receive", array('style' => 'text-align:center'));
    echo html_writer::tag('p', $mform->get_new_filename('userphoto'), array('style' => 'text-align:center'));
    $fs = get_file_storage();
    $fileinfo=customcertificate::get_certificate_image_fileinfo($context->id);
    $fs->delete_area_files($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],$fileinfo['itemid']);
    $mform->save_stored_file('userphoto', $fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $mform->get_new_filename('userphoto'));
    //redirect($CFG->wwwroot.'/mod/customcertificate/pending.php?id=' . $id); 

}
echo $OUTPUT->footer();