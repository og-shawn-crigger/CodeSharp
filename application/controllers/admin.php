<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

class Admin extends CI_Controller {

    private $is_logged_in;

    function __construct() {

        parent::__construct();
        $this->is_logged_in();

    }

    public function index() {

        $data = array();

        $data['full_cats'] = $this->category_model->get_cat_title_mutli();

        $data['content'] = "admin-page";

        $this->load->view("includes/template.php", $data);


    }

    public function is_logged_in() {

        $is_logged_in = $this->session->userdata('is_logged_in');

        if (!isset($is_logged_in) || $is_logged_in != true) {

            redirect("login");

        }

    }
    

}