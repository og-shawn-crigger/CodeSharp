<?php
 if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Andy Walpole
 * @date 6/11/2011
 * 
 */

class Install extends CI_Controller {


    function __constructor() {

        parent::__construct();


    }


    // universal to all functions
    private function add_theme($array) {

        $data = $array;

        $data['content'] = "admin/install_view";

        $this->load->view("admin/includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }


}

?>