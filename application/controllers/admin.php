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
 * Admin Class
 *
 * @package		CodeSharp
 * @subpackage	Application
 * @category	Controllers
 * @author		Andy Walpole
 * 
 */

class Admin extends CI_Controller {

    private $is_logged_in;

    function __construct() {

        parent::__construct();
        $this->is_logged_in();

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

    private function add_theme($array) {

        $data = $array;

        $data['full_cats'] = $this->category_model->get_cat_title_mutli();

        $data['content'] = "admin/admin-page";

        $this->load->view("admin/includes/template.php", $data);
    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }

    // --------------------------------------------------------------------

    /**
     * ais_logged_in function
     * If user is not logged in then they are returned to the login page
     *
     * @access	public
     * @param	string
     * @return	string
     */


    public function is_logged_in() {

        $is_logged_in = $this->session->userdata('is_logged_in');

        if (!isset($is_logged_in) || $is_logged_in != true) {

            redirect("login");

        }

    }


}
