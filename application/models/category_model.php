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
class Category_Model extends CI_Model {

    function get_categories_by_id($id) {

        $query = $this->db->get_where('category', array('id' => $id));

        return $query->result();

    }


    // --------------------------------------------------------------------

    /**
     * get_cat_title function
     * lists category id and name 
     * @access	public
     * @param	array
     * @return	string
     */

    function get_cat_title() {

        $this->db->select('id,name');

        $query = $this->db->get("category");

        return $query->result();

    }

    // --------------------------------------------------------------------

    /**
     * get_cat_title_mutli function
     *  // This is essential for fetching an mutli-dimensional array from the database to be
     * // use in the add content form
     * @access	public
     * @param	array
     * @return	string
     */

    function get_cat_title_mutli() {

        $this->db->select('id,name');

        $query = $this->db->get("category");

        foreach ($query->result_array() as $row) {

            $data[$row['id']] = $row['name'];

        }

        // This adds a null choice at the beginning of the drop down
        //$data = array_merge(array("0" => ""), $data);

        return $data;

    }

    // --------------------------------------------------------------------

    /**
     * get_cat_content function
     *  // get all category content for display on the publicly accessed pages - visible is set to 1
     * @access	public
     * @param	array
     * @return	string
     */

    function get_cat_content($id, $limit = null, $offset = null) {

        // Find all items of the content node where second item equals the second segment
        $this->db->where('category_id', $id);

        $this->db->where('visible', 1);

        $this->db->order_by("date", "desc");

        $query = $this->db->get("content", $limit, $offset);

        return $query->result();

    }
    // --------------------------------------------------------------------

    /**
     * find_category_rows function
     *  find number of individual category items
     * @access	public
     * @param	string
     * @return	string
     */


    public function find_category_rows($visible = true, $id = "") {

        if ($visible === true) {

            $this->db->where('visible', 1);

        }

        $this->db->where('category_id', $id);

        return $this->db->get('content')->num_rows();

    }

    // --------------------------------------------------------------------

    /**
     * add_category function
     *  add category to the category database table
     * @access	public
     * @param	string
     * @return	string
     */


    function add_category($name = "", $publish = "") {

        // date('Y-m-d H:i:s') = MySQL now() function
        $data = array('menu_id' => 'C', 'name' => $name, 'date' => date('Y-m-d H:i:s'),
            'visible' => $publish);

        return $this->db->insert('category', $data);

    }

    // --------------------------------------------------------------------

    /**
     * get_cats function
     *  This is to make sure that the category name is unique 
     * @access	public
     * @param	string
     * @return	string
     */

    public function get_cats($value = "") {

        if ($value === "") {

            $query = $this->db->get("category");

            return $query->result();

        } else {

            /*
            This is to make sure that the category name is unique 
            */

            $query = $this->db->query('SELECT name FROM category WHERE name <> "' . $value .
                '"');

            return $query->result();

        }

    }

    // --------------------------------------------------------------------

    /**
     * update_categorys function
     * Update category
     * @access	public
     * @param	string
     * @return	string
     */

    public function update_category($name, $visibility, $id) {

        $data = array('name' => $name, 'visible' => $visibility);

        $this->db->limit(1);

        $this->db->where('id', $id);

        return $this->db->update('category', $data);

    }

    // --------------------------------------------------------------------

    /**
     * delete_categoryfunction
     * Delete category
     * @access	public
     * @param	string
     * @return	string
     */

    public function delete_category($id = "") {

        $this->db->limit(1);

        $this->db->where('id', $id);

        return $this->db->delete('category');

    }

}
