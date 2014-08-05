<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/lib/formslib.php');


class validation_form extends moodleform {
    public function definition() {
        global $CFG, $COURSE, $DB;

        $id   = required_param('id', PARAM_INT);

        $mform =& $this->_form;

        //General options
        $mform->addElement('header', 'general', get_string('general', 'form'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }


        if (!$cm = get_coursemodule_from_id('customcertificate', $id)) {
            print_error('Course Module ID was incorrect');
        }

        if (!$certificate = $DB->get_record('customcertificate', array('id'=> $cm->instance))) {
            print_error('course module is incorrect');
        }

        $groupmode = groups_get_activity_groupmode($cm);
        $users = customcertificate_get_userphoto($certificate->id, $groupmode, $cm);
        foreach ($users as $user) {
            if(!$issueuserphoto = $DB->get_record('customcertificate_userphoto', array('userid' => $user->id, 'certificateid' => $certificate->id)))
            {
                print_error("userphoto pas dans la bdd");
            }
            //$fs = get_file_storage();
            //$imagefileuser = $fs->get_file($issueuserphoto->contextid, $issueuserphoto->component, $issueuserphoto->filearea, $issueuserphoto->itemid, $issueuserphoto->filepath, $issueuserphoto->userphoto);


            // Read contents
            if (true) {
               //print_error("filepath : ".$imagefileuser->get_filepath());
               /*$dir = $CFG->tempdir;
               $prefix = "mod_customcertificate";

                if (substr($dir, -1) != '/') {
                    $dir .= '/';
                }

                do {
                    $path = $dir . $prefix . mt_rand(0, 9999999);
                } while (file_exists($path));

                check_dir_exists($path);

                $fullfilepath = $path . '/' . $imagefileuser->get_filename();
                $imagefileuser->copy_content_to($fullfilepath);

                */

                $fs = get_file_storage();
                $imagefileuser = $fs->get_file($issueuserphoto->contextid, $issueuserphoto->component, $issueuserphoto->filearea, $issueuserphoto->itemid, $issueuserphoto->filepath, $issueuserphoto->userphoto);

                if ($imagefileuser) {
                    $contents = $imagefileuser->get_content();
                    //echo $contents;
                    
                    $racine = "./pix/userphoto";
                    if(!is_dir($racine)){
                        mkdir($racine, 0700);
                    }

                    $dir = $CFG->tempdir;
                    $prefix = "mod_customcertificate";

                    //$imagefileuser->copy_content_to($fullfilepath);

                    file_put_contents($racine.'/'.$user->id.'.pdf', $contents);

                    $url = moodle_url::make_pluginfile_url($imagefileuser->get_contextid(), $imagefileuser->get_component(), $imagefileuser->get_filearea(), $imagefileuser->get_itemid(), $imagefileuser->get_filepath(), $imagefileuser->get_filename());
                    $mform->addElement('html', '<img src="'.$racine.'/'.$user->id.'.pdf"/>');
                } else {
                    // file doesn't exist - do something
                }

                //$files = $fs->get_area_files($issueuserphoto->contextid, $issueuserphoto->contextid, $issueuserphoto->filearea, $issueuserphoto->itemid);
                //$files = $fs->get_area_files($context->id, 'mod_mymodname', 'imagearea', $par->id, 'id', false);


                //$fileurl = moodle_url::make_file_url('/pluginfile.php', '/'.$issueuserphoto->contextid.'/'.$issueuserphoto->contextid.'/'.$issueuserphoto->filearea.'/'.$issueuserphoto->userphoto);

                //$url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
                //$mform->addElement('html', '<img src="'.$fileurl.'"/>');
                
                //echo html_writer::empty_tag('img', array('src' => $fileurl));
                /*
                $fs = get_file_storage();
                $files = $fs->get_area_files($issueuserphoto->contextid, $issueuserphoto->component, $issueuserphoto->filearea, $issueuserphoto->itemid);
                 
                foreach ($files as $file) {
                    $filename = $file->get_filename();
                    $url = moodle_url::make_file_url('/pluginfile.php', array($file->get_contextid(), $issueuserphoto->component, $issueuserphoto->filearea,
                            $file->get_itemid(), $file->get_filepath(), $filename));
                    
                    $out = html_writer::link($url, $filename);
                    $mform->addElement('html', $out);
                }
                */

                //$mform->addElement('html', '<img src="'.$fullfilepath.'"/>');
                $mform->addElement('checkbox', 'validationphoto'.$user->id, $user->firstname.' '.$user->lastname);

               //$temp_manager = customcertificate::move_temp_dir($imagefileuser);
            } else {
                print_error(get_string('filenotfound', 'customcertificate', $issueuserphoto->userphoto));
            }

            
        }
        
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
    }

    //Custom validation should be added here
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        return $errors;
    }



}