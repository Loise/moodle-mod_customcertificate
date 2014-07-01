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

$id = optional_param('id', $USER->id, PARAM_INT);

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/pending.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));
echo html_writer::tag('p', "Your picture is being validated, please wait.", array('style' => 'text-align:center'));


if (!$certificate = $DB->get_record('customcertificate', array('id'=> $id))) {
    print_error('course module is incorrect');
}

$certificate->addphoto = false;
$DB->update_record('customcertificate', $certificate);

//Send event
customcertificate_send_event($certificate);


echo $OUTPUT->footer();
