<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}


require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->libdir . '/filelib.php');


class mod_customcertificate_mod_form extends moodleform_mod {

    function definition() {
        global $CFG, $COURSE;


        $mform =& $this->_form;

        //General options
        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text', 'name', get_string('certificatename', 'customcertificate'), array('size'=>'64'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addHelpButton('name', 'certificatename', 'customcertificate');

        $this->add_intro_editor(false, get_string('intro', 'customcertificate'));


        //--------------------------------------- Design Options----------------------------------------------------
        $mform->addElement('header', 'designoptions', get_string('designoptions', 'customcertificate'));

        $maxbytes = get_max_upload_file_size($CFG->maxbytes, $COURSE->maxbytes);

        //Certificate image file
        $mform->addElement('filepicker', 'certificateimage', get_string('certificateimage','customcertificate'), null,
                array('maxbytes' => $maxbytes, 'accepted_types' =>  array('image')));
        $mform->addHelpButton('certificateimage', 'certificateimage', 'customcertificate');
        $mform->addRule('certificateimage', get_string('error'), 'required', null, 'client');

        //Certificate Text HTML editor
        $mform->addElement('editor', 'certificatetext', get_string('certificatetext', 'customcertificate'),
                customcertificate_get_editor_options($this->context));
        $mform->setType('certificatetext',PARAM_RAW);
        $mform->addRule('certificatetext', get_string('error'), 'required', null, 'client');
        $mform->addHelpButton('certificatetext', 'certificatetext', 'customcertificate');

        //Certificate Width
        $mform->addElement('text', 'width', get_string('width', 'customcertificate'), array('size'=>'5'));
        $mform->setType('width', PARAM_INT);
        $mform->setDefault('width', get_config('customcertificate', 'width'));
        $mform->setAdvanced('width');
        $mform->addHelpButton('width', 'size', 'customcertificate');


        //Certificate Height
        $mform->addElement('text', 'height', get_string('height', 'customcertificate'), array('size'=>'5'));
        $mform->setType('height', PARAM_INT);
        $mform->setDefault('height', get_config('customcertificate', 'height'));
        $mform->setAdvanced('height');
        $mform->addHelpButton('height', 'size', 'customcertificate');

        //Certificate Position X
        $mform->addElement('text', 'certificatetextx', get_string('certificatetextx', 'customcertificate'), array('size'=>'5'));
        $mform->setType('certificatetextx',PARAM_INT);
        $mform->setDefault('certificatetextx', get_config('customcertificate', 'certificatetextx'));
        $mform->setAdvanced('certificatetextx');
        $mform->addHelpButton('certificatetextx', 'textposition', 'customcertificate');

        //Certificate Position Y
        $mform->addElement('text', 'certificatetexty', get_string('certificatetexty', 'customcertificate'), array('size'=>'5'));
        $mform->setType('certificatetexty',PARAM_INT);
        $mform->setDefault('certificatetexty', get_config('customcertificate', 'certificatetexty'));
        $mform->setAdvanced('certificatetexty');
        $mform->addHelpButton('certificatetexty', 'textposition', 'customcertificate');
	
	//Introduction Certificate Text HTML editor
        $mform->addElement('editor', 'introcertificatetext', get_string('introcertificatetext', 'customcertificate'),
                customcertificate_get_editor_options($this->context));
        $mform->setType('introcertificatetext',PARAM_RAW);
        //$mform->addRule('introcertificatetext', get_string('error'), 'required', null, 'client');
        $mform->addHelpButton('introcertificatetext', 'introcertificatetext', 'customcertificate');

	//Introduction Certificate Position X
        $mform->addElement('text', 'introcertificatetextx', get_string('introcertificatetextx', 'customcertificate'), array('size'=>'5'));
        $mform->setType('introcertificatetextx',PARAM_INT);
        $mform->setDefault('introcertificatetextx', get_config('customcertificate', 'introcertificatetextx'));
        $mform->setAdvanced('introcertificatetextx');
        $mform->addHelpButton('introcertificatetextx', 'textposition', 'customcertificate');

        //Introduction Certificate Position Y
        $mform->addElement('text', 'introcertificatetexty', get_string('introcertificatetexty', 'customcertificate'), array('size'=>'5'));
        $mform->setType('introcertificatetexty',PARAM_INT);
        $mform->setDefault('introcertificatetexty', get_config('customcertificate', 'introcertificatetexty'));
        $mform->setAdvanced('introcertificatetexty');
        $mform->addHelpButton('introcertificatetexty', 'textposition', 'customcertificate');

	//Conclusion Certificate Text HTML editor
        $mform->addElement('editor', 'conclucertificatetext', get_string('conclucertificatetext', 'customcertificate'),
                customcertificate_get_editor_options($this->context));
        $mform->setType('conclucertificatetext',PARAM_RAW);
        //$mform->addRule('conclucertificatetext', get_string('error'), 'required', null, 'client');
        $mform->addHelpButton('conclucertificatetext', 'conclucertificatetext', 'customcertificate');

        //Conclusion Certificate Position X
        $mform->addElement('text', 'conclucertificatetextx', get_string('conclucertificatetextx', 'customcertificate'), array('size'=>'5'));
        $mform->setType('conclucertificatetextx',PARAM_INT);
        $mform->setDefault('conclucertificatetextx', get_config('customcertificate', 'conclucertificatetextx'));
        $mform->setAdvanced('conclucertificatetextx');
        $mform->addHelpButton('conclucertificatetextx', 'textposition', 'customcertificate');

        //Conclusion Certificate Position Y
        $mform->addElement('text', 'conclucertificatetexty', get_string('conclucertificatetexty', 'customcertificate'), array('size'=>'5'));
        $mform->setType('conclucertificatetexty',PARAM_INT);
        $mform->setDefault('conclucertificatetexty', get_config('customcertificate', 'conclucertificatetexty'));
        $mform->setAdvanced('conclucertificatetexty');
        $mform->addHelpButton('conclucertificatetexty', 'textposition', 'customcertificate');

        //-----------------------------------------Second page
        $mform->addElement('header', 'secondpageoptions', get_string('secondpageoptions', 'customcertificate'));
        //Enable back page text

        $mform->addElement('selectyesno', 'enablesecondpage', get_string('enablesecondpage', 'customcertificate'));
        $mform->setDefault('enablesecondpage', get_config('customcertificate', 'enablesecondpage'));
        $mform->addHelpButton('enablesecondpage', 'enablesecondpage', 'customcertificate');

        //Certificate secondimage file
        $mform->addElement('filepicker', 'secondimage', get_string('secondimage','customcertificate'), null,
                array('maxbytes' => $maxbytes, 'accepted_types' =>  array('image')));
        $mform->addHelpButton('secondimage', 'secondimage', 'customcertificate');
        $mform->disabledIf('secondimage', 'enablesecondpage', 'eq', 0);
         
        //Certificate secondText HTML editor
        $mform->addElement('editor', 'secondpagetext', get_string('secondpagetext', 'customcertificate'),
                customcertificate_get_editor_options($this->context));
        $mform->setType('secondpagetext',PARAM_RAW);
        $mform->addHelpButton('secondpagetext', 'certificatetext', 'customcertificate');
        $mform->disabledIf('secondpagetext', 'enablesecondpage', 'eq', 0);

        //Certificate Position X
        $mform->addElement('text', 'secondpagex', get_string('secondpagex', 'customcertificate'), array('size'=>'5'));
        $mform->setType('secondpagex',PARAM_INT);
        $mform->setDefault('secondpagex', get_config('customcertificate', 'certificatetextx'));
        $mform->setAdvanced('secondpagex');
        $mform->addHelpButton('secondpagex', 'secondtextposition', 'customcertificate');
        $mform->disabledIf('secondpagex', 'enablesecondpage', 'eq', 0);

        //Certificate Position Y
        $mform->addElement('text', 'secondpagey', get_string('secondpagey', 'customcertificate'), array('size'=>'5'));
        $mform->setType('secondpagey',PARAM_INT);
        $mform->setDefault('secondpagey', get_config('customcertificate', 'certificatetexty'));
        $mform->setAdvanced('secondpagey');
        $mform->addHelpButton('secondpagey', 'secondtextposition', 'customcertificate');
        $mform->disabledIf('secondpagey', 'enablesecondpage', 'eq', 0);


        /*


        //--------------------Variable options
        $mform->addElement('header', 'variablesoptions', get_string('variablesoptions', 'customcertificate'));
        //Certificate Alternative Course Name
        $mform->addElement('text', 'coursename', get_string('coursename', 'customcertificate'), array('size'=>'64'));
        $mform->setType('coursename', PARAM_TEXT);
        $mform->setAdvanced('coursename');
        $mform->addHelpButton('coursename', 'coursename', 'customcertificate');

        //Certificate Course Hours
        $mform->addElement('text', 'coursehours', get_string('coursehours', 'customcertificate'), array('size'=>'5'));
        $mform->setType('coursehours', PARAM_INT);
        $mform->setAdvanced('coursehours');
        $mform->addHelpButton('coursehours', 'coursehours', 'customcertificate');

        //Certificate Outcomes
        $outcomeoptions = customcertificate_get_outcomes();
        $mform->addElement('select', 'outcome', get_string('printoutcome', 'customcertificate'), $outcomeoptions);
        $mform->setDefault('outcome', 0);
        $mform->addHelpButton('outcome', 'printoutcome', 'customcertificate');


        */

       /* //Certificate date options
        $mform->addElement('select', 'certdate', get_string('printdate', 'customcertificate'), customcertificate_get_date_options());
        $mform->setDefault('certdate', get_config('customcertificate', 'certdate'));
        $mform->addHelpButton('certdate', 'printdate', 'customcertificate');


        //Certificate date format
        $mform->addElement('text', 'certdatefmt', get_string('datefmt', 'customcertificate'));
        $mform->setDefault('certdatefmt', '');
        $mform->setType('certdatefmt', PARAM_TEXT);
        $mform->addHelpButton('certdatefmt', 'datefmt', 'customcertificate');
        $mform->setAdvanced('certdatefmt');*/

        /*

        //Certificare grade Options
        $mform->addElement('select', 'certgrade', get_string('printgrade', 'customcertificate'), customcertificate_get_grade_options());
        $mform->setDefault('certgrade', 0);
        $mform->addHelpButton('certgrade', 'printgrade', 'customcertificate');

        //Certificate grade format
        $gradeformatoptions = array( 1 => get_string('gradepercent', 'customcertificate'), 2 => get_string('gradepoints', 'customcertificate'),
                3 => get_string('gradeletter', 'customcertificate'));
        $mform->addElement('select', 'gradefmt', get_string('gradefmt', 'customcertificate'), $gradeformatoptions);
        $mform->setDefault('gradefmt', 0);
        $mform->addHelpButton('gradefmt', 'gradefmt', 'customcertificate');

        //Required Time
        $mform->addElement('text', 'requiredtime', get_string('coursetimereq', 'customcertificate'), array('size'=>'3'));
        $mform->setType('requiredtime', PARAM_INT);
        $mform->addHelpButton('requiredtime', 'coursetimereq', 'customcertificate');

        //QR code
        $mform->addElement('selectyesno', 'disablecode', get_string('disablecode', 'customcertificate'));
        $mform->setDefault('disablecode', get_config('customcertificate', 'disablecode'));
        $mform->addHelpButton('disablecode', 'disablecode', 'customcertificate');

        $mform->addElement('text', 'codex', get_string('codex', 'customcertificate'), array('size'=>'5'));
        $mform->setType('codex',PARAM_INT);
        $mform->setDefault('codex', get_config('customcertificate', 'codex'));
        $mform->setAdvanced('codex');
        $mform->addHelpButton('codex', 'qrcodeposition', 'customcertificate');

        $mform->addElement('text', 'codey', get_string('codey', 'customcertificate'), array('size'=>'5'));
        $mform->setType('codey',PARAM_INT);
        $mform->setDefault('codey', get_config('customcertificate', 'codey'));
        $mform->setAdvanced('codey');
        $mform->addHelpButton('codey', 'qrcodeposition', 'customcertificate');

        */

        //-------------------------------Issue options----------------------------------

        $mform->addElement('header', 'issueoptions', get_string('issueoptions', 'customcertificate'));

        //Email to teachers ?
        $mform->addElement('selectyesno', 'emailteachers', get_string('emailteachers', 'customcertificate'));
        $mform->setDefault('emailteachers', 0);
        $mform->addHelpButton('emailteachers', 'emailteachers', 'customcertificate');

        //Email Others
        $mform->addElement('text', 'emailothers', get_string('emailothers', 'customcertificate'), array('size'=>'40', 'maxsize'=>'200'));
        $mform->setType('emailothers', PARAM_TEXT);
        $mform->addHelpButton('emailothers', 'emailothers', 'customcertificate');

        //Email From
        $mform->addElement('text', 'emailfrom', get_string('emailfrom', 'customcertificate'), array('size'=>'40', 'maxsize'=>'200'));
        $mform->setDefault('emailfrom', $CFG->supportname);
        $mform->setType('emailfrom', PARAM_EMAIL);
        $mform->addHelpButton('emailfrom', 'emailfrom', 'customcertificate');
        $mform->setAdvanced('emailfrom');

        //Delivery Options (Email, Download,...)
        $deliveryoptions = array( 0 => get_string('openbrowser', 'customcertificate'), 1 => get_string('download', 'customcertificate'), 2 => get_string('emailcertificate', 'customcertificate'));
        $mform->addElement('select', 'delivery', get_string('delivery', 'customcertificate'), $deliveryoptions);
        $mform->setDefault('delivery', 0);
        $mform->addHelpButton('delivery', 'delivery', 'customcertificate');

        //Save Certificarte
        $mform->addElement('selectyesno', 'savecert', get_string('savecert', 'customcertificate'));
        $mform->setDefault('savecert', get_config('customcertificate', 'savecert'));
        $mform->addHelpButton('savecert', 'savecert', 'customcertificate');

        //Report Cert
        //TODO acredito que seja para verificar o certificado pelo código, se for isto pode remover.
        $reportfile = "$CFG->dirroot/customcertificates/index.php";
        if (file_exists($reportfile)) {
            $mform->addElement('selectyesno', 'reportcert', get_string('reportcert', 'customcertificate'));
            $mform->setDefault('reportcert', 0);
            $mform->addHelpButton('reportcert', 'reportcert', 'customcertificate');
        }

        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }

    /**
     * Prepares the form before data are set
     *
     * Additional wysiwyg editor are prepared here, the introeditor is prepared automatically by core.
     * Grade items are set here because the core modedit supports single grade item only.
     *
     * @param array $data to be set
     * @return void
     */
    public function data_preprocessing(&$data) {
        global $CFG;
        require_once(dirname(__FILE__) . '/locallib.php');
        if ($this->current->instance) {
            // editing an existing certificate - let us prepare the added editor elements (intro done automatically), and files
            $imagedraftitemid = file_get_submitted_draft_itemid('certificateimage');
            $imagefileinfo = customcertificate::get_certificate_image_fileinfo($this->context);
            file_prepare_draft_area($imagedraftitemid, $imagefileinfo['contextid'], $imagefileinfo['component'], $imagefileinfo['filearea'], $imagefileinfo['itemid']);
            $data['certificateimage'] = $imagedraftitemid;
            $data['certificatetext'] = array('text' =>$data['certificatetext'], 'format'=> FORMAT_HTML);
	    $data['introcertificatetext'] = array('text' =>$data['introcertificatetext'], 'format'=> FORMAT_HTML); 
            $data['conclucertificatetext'] = array('text' =>$data['conclucertificatetext'], 'format'=> FORMAT_HTML); 
	
            //Second page
            $secondimagedraftitemid = file_get_submitted_draft_itemid('secondimage');
            $secondimagefileinfo = customcertificate::get_certificate_secondimage_fileinfo($this->context);
            file_prepare_draft_area($secondimagedraftitemid, $secondimagefileinfo['contextid'], $secondimagefileinfo['component'], $secondimagefileinfo['filearea'], $secondimagefileinfo['itemid']);
            $data['secondimage'] = $secondimagedraftitemid;

            if (!empty($data['secondpagetext'])) {
                $data['secondpagetext'] = array('text' =>$data['secondpagetext'], 'format'=> FORMAT_HTML);
            } else {
                $data['secondpagetext'] = array('text' =>'', 'format'=> FORMAT_HTML);
            }
        } else { //Load default
            $data['certificatetext'] = array('text' =>'', 'format'=> FORMAT_HTML);
	    $data['introcertificatetext'] = array('text' =>'', 'format'=> FORMAT_HTML);
            $data['secondpagetext'] = array('text' =>'', 'format'=> FORMAT_HTML);
        }
    }

    /**
     * Some basic validation
     *
     * @param $data
     * @param $files
     * @return array
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        /*

        // Check that the required time entered is valid
        if ((!is_number($data['requiredtime']) || $data['requiredtime'] < 0)) {
            $errors['requiredtime'] = get_string('requiredtimenotvalid', 'customcertificate');
        }
        
        */
        
        return $errors;
    }
}
