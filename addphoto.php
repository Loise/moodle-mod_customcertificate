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

optional_param('id', $USER->id, PARAM_INT);
//$code = optional_param('code', null,PARAM_ALPHANUMEXT); // Issed Code

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/addphoto.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));
$mform = new addphoto_form();
$mform->display();

if (!$mform->get_data()) {
    echo html_writer::tag('p', "error : no data", array('style' => 'text-align:center'));
} else {
    echo html_writer::tag('p', "data receive", array('style' => 'text-align:center'));
}
echo $OUTPUT->footer();