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
require_once('validation_form.php');

$id   = required_param('id', PARAM_INT); // Course module ID
$context = context_system::instance();
$PAGE->set_url('/mod/customcertificate/validation.php', array('id' => $id));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');

$mform = new validation_form($CFG->wwwroot.'/mod/customcertificate/validation.php?id='.$id);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('certificateverification', 'customcertificate'));

if (!$data = $mform->get_data()) {
   if (has_capability('mod/customcertificate:manage', $context)) {
      $mform->display();
      add_to_log($context->instanceid, 'customcertificate', 'verify', 'validation.php?id='.$id);
      $mform->set_data(array('id'=>$id));
   }else {
      print_error('You don\'t have the permission for access at this page');
   }
}
else
{
   if (!$cm = get_coursemodule_from_id('customcertificate', $id)) {
      print_error('Course Module ID was incorrect');
   }

   if (!$certificate = $DB->get_record('customcertificate', array('id'=> $cm->instance))) {
      print_error('course module is incorrect');
   }

   $groupmode = groups_get_activity_groupmode($cm);
   $users = customcertificate_get_userphoto($certificate->id, $groupmode, $cm);
   foreach ($users as $user) {
      $check = 'validationphoto'.$user->id;
      if(isset($data->{$check}))
      {
         echo html_writer::tag('p', 'the photo of the student '.$user->firstname.' '.$user->lastname.' have been valited.', array('style' => 'text-align:center'));
         $DB->set_field('customcertificate_userphoto', 'validationphoto', "validated", array('userid' => $user->id, 'certificateid' => $certificate->id));
      }
   }

   echo html_writer::tag('p', 'Please refresh the page for anoher validation.', array('style' => 'text-align:center'));

}

echo $OUTPUT->footer();
