<?php
 if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
 * Install
 *
 * @package		CodeSharp
 * @subpackage	Application
 * @category	Controllers
 * @author		Andy Walpole
 * 
 */

class Install extends CI_Controller {


    function __constructor() {

        parent::__construct();


    }
    
        // --------------------------------------------------------------------

    /**
     * add_theme function
     * Adds category menu and template to all pages
     * Also adds list of all users for every page
     *
     * @access	private
     * @param	string
     * @return	string
     */



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