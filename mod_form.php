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
