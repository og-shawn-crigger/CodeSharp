<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011
 * 
 */

class Menu_Model extends Model {

    var $cat_menu;

    public function __construct() {

        parent::Model();
        // load model file below in order to gain access to their constants
        $this->load->model('admin_config_model');
        $this->set_menu();
        
    }

    public function fetch_cat_menu() {

        $this->db->select('okay');
        
        $this->db->where('name', "cat_menu");

        $query = $this->db->get("admin");

        return $query->row();

    }

    public function add_categories_to_menu() {
        
        if ($_POST['categoriesAdd'] == "YES") {

            $value = 1;

        } else {

            $value = 0;

        }

        $data = array('okay' => $value);
        $this->db->where('name', "cat_menu");
        $this->db->limit(1);

        if ($this->db->update('admin', $data)) {

            if ($value == 1) {

                $this->cat_menu = true;
                
                return true;

            } else {


                $this->cat_menu = false;
                
                return false;

            }
        }
    }


    function display_menu() {

        $query = $this->db->get("menu");
        return $query->result();

    }

    // Constant notes whether the categories will be included in the user menu
    public function set_menu() {   

        if (CATMENU == 1) {

            $this->cat_menu = true;

        } else {

            $this->cat_menu = false;

        }
        
    }


    public function menu_order() {

        if ($this->cat_menu === true) {

            $sql = ' SELECT id, menu_id, name, number from category ';
            $sql .= ' UNION ';
            $sql .= ' SELECT id, menu_id, name, number from menu ';
            $sql .= ' ORDER by number DESC ';

            $result = $this->db->query($sql);

            return $result->result_array();

        } else {

            $sql = ' SELECT id, menu_id, name, number from menu ';
            $sql .= ' ORDER by number DESC ';

            $result = $this->db->query($sql);

            return $result->result_array();
        }

    }
    
    


    /**
     * MAKE SURE MENU NAME IS UNIQUE
     */

    function insert_menu($name, $url, $visibility) {

        if ($visibility === "YES") {

            $visibility = 1;

        } else {

            $visibility = 0;

        }

        $data = array('name' => $name, 'url' => $url, 'date' => date('Y-m-d H:i:s'),
            'visible' => $visibility, 'menu_id' => 'M');

        return $this->db->insert('menu', $data);

    }

}

?>