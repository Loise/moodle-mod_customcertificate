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

$id = required_param('id', PARAM_INT);

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/pending.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));
echo html_writer::tag('p', "Your picture is being validated, please wait.", array('style' => 'text-align:center'));


if(!$issueuserphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $USER->id, 'certificateid' => $id)))
{
	print_error('course module is incorrect');
}
else
{	
	$DB->set_field('customcertificate_userphoto', 'validationphoto', "pending", array('userid' => $USER->id, 'certificateid' => $id));
}

echo $OUTPUT->footer();
