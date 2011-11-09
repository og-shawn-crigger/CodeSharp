<?php

/**
 * @author Andy Walpole
 * @date 9/10/2011
 * 
 */

class Admin_Config extends CI_Controller {

    var $admin_config;

    function __constructor() {

        parent::__construct();


    }


    function _remap($method) {

        switch ($method) {
            case 'submit-form':
                $this->submit_form();
                break;

            default:
                $this->index();
                break;

        }

    }


    // universal to all functions
    private function add_theme($array) {

        $data = $array;

        $data['content'] = "admin/admin_various";

        $this->load->view("admin/includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }


    public function submit_form() {

        $data = array();
        
        /**
         * validation rule to be found in config -> form_validation.php
         */

        if ($this->form_validation->run("adminconfig") === false) {

            $data['error_success'] = "<p>There are problems with your form submission:</p>";

        } else {

            $this->admin_config_model->update_admin($_POST);

            $data['error_success'] = "<p>You have successfully updated the database.</p>";

        }


        $this->add_theme($data);

    }

}
