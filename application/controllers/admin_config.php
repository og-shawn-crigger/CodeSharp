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
    
    
    
    

    /*

    function _remap($method) {

    switch ($method) {
    case 'admin-add':
    $this->admin_add();
    break;
    
    case 'index':
    $this->index();
    break;

    }

    }
    
    */

    // universal to all functions
    private function add_theme($array) {

        $data = $array;

        $data['content'] = "admin_various";

        $this->load->view("includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }


    public function submit_form() {

        $data = array();

        $this->form_validation->set_rules('nameForm', 'website title',
            'trim|required|max_length[100]');

        $this->form_validation->set_rules('sloganForm', 'slogan',
            'trim|required|max_length[250]');

        $this->form_validation->set_rules('emailForm', 'email',
            'trim|required|max_length[50]|valid_email');
            
        if ($this->form_validation->run() === false) {

            $data['error_success'] = "<p>There are problems with your form submission:</p>";

        } else {

            $this->admin_config_model->update_admin($_POST);

            $data['error_success'] = "<p>You have successfully updated the database.</p>";

        }

        $this->add_theme($data);

    }

}

?>