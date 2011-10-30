<?php

/**
 * @author Andy Walpole
 * @date 9/10/2011
 * 
 */

?>


<?php

class Admin_Config_Model extends Model {


    public function __construct() {

        parent::Model();
        $this->add_admin();
    
    }

    /**
     * Look at placing the individual update database queries into one giant sql query
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

                    $data = array('okay' => ($value == "YES" ? 1 : 0));
                    $this->db->where('name', "meta_description");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "metaKeywords":

                    $data = array('okay' => ($value == "YES" ? 1 : 0));
                    $this->db->where('name', "meta_keywords");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

                case "errorReporting":

                    $data = array('okay' => ($value == "YES" ? 1 : 0));
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

                    $data = array('okay' => ($value == "YES" ? 1 : 0));
                    $this->db->where('name', "error_email");
                    $this->db->limit(1);
                    $this->db->update('admin', $data);
                    break;

            }

        }

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


?>