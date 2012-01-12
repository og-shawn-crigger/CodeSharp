<?php

/**
 * CodeSharp
 *
 * A CMS based on CodeIgniter
 *
 * @package		CodeSharp
 * @author		Andy Walpole (unless stated to the contrary)
 * @copyright	Andy Walpole (unless stated to the contrary)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		https://github.com/TCotton/CodeSharp
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Admin Config
 *
 * @package		CodeSharp
 * @subpackage	Application
 * @category	Controllers
 * @author		Andy Walpole
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


    // --------------------------------------------------------------------

    /**
     * add_theme function
     * Adds category menu and template to all pages
     *
     * @access	private
     * @param	string
     * @return	string
     */


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

    // --------------------------------------------------------------------

    /**
     * submit form function
     * Submits the admin config form, validates and then does database query
     *
     * @access	public
     * @param	array
     * @return	string
     */


    public function submit_form() {

        $data = array();

        /**
         * validation rule to be found in config -> form_validation.php
         */

        if ($this->form_validation->run("adminconfig") === false) {

            $data['error_success'] = "<p>There are problems with your form submission:</p>";

        } else {

            if (is_array($_POST)) {

                $this->admin_config_model->update_admin($_POST);

            } else {

                $this->admin_config_model->update_admin_ajax($_POST);

            }

            $data['error_success'] = "<p>You have successfully updated the database.</p>";

        }


        $this->add_theme($data);

    }

}
