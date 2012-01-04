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
 * Admin_Config_Model Class
 *
 * @package		CodeSharp
 * @subpackage	Application
 * @category	Models
 * @author		Andy Walpole
 * 
 */

class Admin_Config_Model extends CI_Model {


    public function __construct() {

        parent::__construct();

        $this->add_admin();

    }

    /**
     * Look at placing the individual update database queries into one giant sql query
     */

    // --------------------------------------------------------------------

    /**
     * update_admin function
     * Updates admin table after admin config form submission
     *
     * @access	public
     * @param	array
     * @return	string
     */


    public function update_admin($form) {

        foreach ($form as $key => $value) {

            switch ($key) {

                case "nameForm":

                    $data = array('value' => $value);
                    $this->db->where('name', "name_of_site");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "sloganForm":

                    $data = array('value' => $value);
                    $this->db->where('name', "slogan");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "emailForm":

                    $data = array('value' => $value);
                    $this->db->where('name', "email");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "metaDescription":

                    $data = array('okay' => $value);
                    $this->db->where('name', "meta_description");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "metaKeywords":

                    $data = array('okay' => $value);
                    $this->db->where('name', "meta_keywords");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "errorReporting":

                    $data = array('okay' => $value);
                    $this->db->where('name', "error_reporting");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "errorLevel":

                    $data = array('okay' => $value);
                    $this->db->where('name', "error_level");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "errorEmail":

                    $data = array('okay' => $value);
                    $this->db->where('name', "error_email");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

            }
        }
    }


    /**
     * Look at placing the individual update database queries into one giant sql query
     */

    // --------------------------------------------------------------------

    /**
     * update_admin_ajax function
     * Updates admin table after admin config form submission
     * AJAX ONLY
     *
     * @access	public
     * @param	string
     * @return	string
     */


    public function update_admin_ajax($form) {

        $data = array('value' => $_POST['nameForm']);
        $this->db->where('name', "name_of_site");
        $this->db->limit(1);
        $this->db->update('admin', $data);

        $data = array('value' => $_POST['sloganForm']);
        $this->db->where('name', "slogan");
        $this->db->limit(1);
        $this->db->update('admin', $data);

        $data = array('value' => $_POST['emailForm']);
        $this->db->where('name', "email");
        $this->db->limit(1);
        $this->db->update('admin', $data);

        $data = array('okay' => $_POST['metaDescription']);
        $this->db->where('name', "meta_description");
        $this->db->limit(1);
        $this->db->update('admin', $data);

        $data = array('okay' => $_POST['metaKeywords']);
        $this->db->where('name', "meta_keywords");
        $this->db->limit(1);
        $this->db->update('admin', $data);

        $data = array('okay' => $_POST['errorReporting']);
        $this->db->where('name', "error_reporting");
        $this->db->limit(1);
        $this->db->update('admin', $data);

        $data = array('okay' => $_POST['errorLevel']);
        $this->db->where('name', "error_level");
        $this->db->limit(1);
        $this->db->update('admin', $data);

        $data = array('okay' => $_POST['errorEmail']);
        $this->db->where('name', "error_email");
        $this->db->limit(1);
        $this->db->update('admin', $data);

    }


    private function admin_list() {

        $query = $this->db->get("admin");

        return $query->result();

    }


    public function add_admin() {

        // Set constants for admin table
        foreach ($this->admin_list() as $admin_result) {

            $return = $admin_result->name;

            switch ($return) {

                case "cat_menu":
                    defined('CATMENU') ? null:
                    define('CATMENU', $admin_result->okay);
                    break;

                case "name_of_site":
                    defined('SITENAME') ? null:
                    define('SITENAME', $admin_result->value);
                    break;

                case "slogan":
                    defined('SLOGAN') ? null:
                    define('SLOGAN', $admin_result->value);
                    break;

                case "email";
                    defined('EMAIL') ? null:
                    define('EMAIL', $admin_result->value);
                    break;

                case "meta_description";
                    defined('DESCRIPTION') ? null:
                    define('DESCRIPTION', $admin_result->okay);
                    break;

                case "meta_keywords";
                    defined('KEYWORDS') ? null:
                    define('KEYWORDS', $admin_result->okay);
                    break;

                case "error_reporting";
                    defined('ERROR_REPORTING') ? null:
                    define('ERROR_REPORTING', $admin_result->okay);
                    break;

                case "error_level";
                    defined('ERROR_LEVEL') ? null:
                    define('ERROR_LEVEL', $admin_result->okay);
                    break;

                case "error_email";
                    defined('ERROR_EMAIL') ? null:
                    define('ERROR_EMAIL', $admin_result->okay);
                    break;

            } // end switch

        } // end foreach

    }

} // end class
