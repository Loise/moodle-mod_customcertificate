<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');


class verify_form extends moodleform {

    /**
     * Prepares creating the form with the addition of fields
     * @return void
     */
    function definition () {
        global $CFG;

        $mform =& $this->_form;
        $mform->addElement('text', 'code', get_string('code', 'customcertificate'), array('size'=>'36'));
        $mform->setType('code', PARAM_ALPHANUMEXT);
        $mform->addRule('code', null, 'required', null, 'client');

        //Add recaptcha if enabeld
        if ($this->is_recaptcha_enabled()) {
            $mform->addElement('recaptcha', 'recaptcha_element', get_string('recaptcha', 'auth'), array('https' => $CFG->loginhttps));
            $mform->addHelpButton('recaptcha_element', 'recaptcha', 'auth');
        }


        $this->add_action_buttons(false, get_string('getcertificate','customcertificate'));
    }

    //Custom validation should be added here
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if ($this->is_recaptcha_enabled()) {
            $recaptcha_element = $this->_form->getElement('recaptcha_element');
            if (!empty($this->_form->_submitValues['recaptcha_challenge_field'])) {
                $challenge_field = $this->_form->_submitValues['recaptcha_challenge_field'];
                $response_field = $this->_form->_submitValues['recaptcha_response_field'];
                if (true !== ($result = $recaptcha_element->verify($challenge_field, $response_field))) {
                    $errors['recaptcha'] = $result;
                }
            } else {
                $errors['recaptcha'] = get_string('missingrecaptchachallengefield');
            }
        }
        return $errors;
    }

    /**
     * Verify if the recaptcha is enabled
     * @return bool
     */
    function is_recaptcha_enabled() {
        global $CFG;
        return (!empty($CFG->recaptchapublickey) && !empty($CFG->recaptchaprivatekey));
    }

}