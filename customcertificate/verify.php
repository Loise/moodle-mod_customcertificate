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
require_once('verify_form.php');

//optional_param('id', $USER->id, PARAM_INT);
$code = optional_param('code', null,PARAM_ALPHANUMEXT); // Issed Code

$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/verify.php', array('code' => $code));
$PAGE->set_context($context);
$PAGE->set_title(get_string('certificateverification', 'customcertificate'));
$PAGE->set_heading(get_string('certificateverification', 'customcertificate'));
$PAGE->set_pagelayout('base');
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));
$verifyform = new verify_form();

if (!$verifyform->get_data()) {
    if ($code)
        $verifyform->set_data(array('code'=>$code));
    
    $verifyform->display();
    


} else {
    if (!$issuedcert = $DB->get_record("customcertificate_issues", array('code' => $code))) {
        print_error(get_string('invalidcode','customcertificate'));
    }

    if ($user = $DB->get_record('user', array('id'=>$issuedcert->userid))) {
        $username = fullname($user);
    } else {
        $username = $issuedcer->username;
    }
    $strto = get_string('awardedto', 'customcertificate');
    $strdate = get_string('issueddate', 'customcertificate');
    $strcourse = get_string('course');
    $strcode = get_string('code', 'customcertificate');
    //Add to log
    add_to_log($context->instanceid, 'customcertificate', 'verify', "verify.php?code=$code", '$issuedcert->id');

    $table = new html_table();
    $table->width = "95%";
    $table->tablealign = "center";
    $table->head  = array($strto, $strcourse, $strdate, $strcode);
    $table->align = array("center", "center", "center", "center");
    $table->data[] = array ($username, $issuedcert->coursename, userdate($issuedcert->timecreated), $issuedcert->code);
    echo html_writer::table($table);
}
echo $OUTPUT->footer();