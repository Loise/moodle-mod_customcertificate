<?php

/**
 * Provides some custom settings for the certificate module
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  Carlos Alexandre S. da Fonseca <carlos.alexandre@outlook.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once("$CFG->dirroot/mod/customcertificate/lib.php");

    //--- general settings -----------------------------------------------------------------------------------




    $settings->add(new admin_setting_configtext('customcertificate/width', get_string('defaultwidth', 'customcertificate'),
        get_string('size_help', 'customcertificate'), 297, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/height', get_string('defaultheight', 'customcertificate'),
        get_string('size_help', 'customcertificate'), 210, PARAM_INT));

    $settings->add(new admin_setting_configtext('customcertificate/certificatetextx', get_string('defaultcertificatetextx', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 50, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/certificatetexty', get_string('defaultcertificatetexty', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 50, PARAM_INT));

    $settings->add(new admin_setting_configtext('customcertificate/introcertificatetextx', get_string('defaultintrocertificatetextx', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 50, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/introcertificatetexty', get_string('defaultintrocertificatetexty', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 50, PARAM_INT));

    $settings->add(new admin_setting_configtext('customcertificate/conclucertificatetextx', get_string('defaultconclucertificatetextx', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 50, PARAM_INT));
    $settings->add(new admin_setting_configtext('customcertificate/conclucertificatetexty', get_string('defaultconclucertificatetexty', 'customcertificate'),
        get_string('textposition_help', 'customcertificate'), 50, PARAM_INT));

    $settings->add(new admin_setting_configcheckbox('customcertificate/savecert',
        get_string('savecert', 'customcertificate'), get_string('savecert_help', 'customcertificate'), 1));

    $settings->add(new admin_setting_configselect('customcertificate/certdate', get_string('printdate', 'customcertificate'),
        get_string('printdate_help', 'customcertificate'), 2, customcertificate_get_date_options()));


    $settings->add(new admin_setting_configtext('customcertificate/certlifetime', get_string('certlifetime', 'customcertificate'),
        get_string('certlifetime_help', 'customcertificate'), 60, PARAM_INT));

	//Certificate back page
    $settings->add(new admin_setting_configcheckbox('customcertificate/enablesecondpage',
    		get_string('enablesecondpage', 'customcertificate'), get_string('enablesecondpage_help', 'customcertificate'), 0));
    
}

?>
