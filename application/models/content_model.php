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
 * Content_Model Class
 *
 * @package		CodeSharp
 * @subpackage	Application
 * @category	Models
 * @author		Andy Walpole
 * 
 */
class Content_Model extends CI_Model {

    /**
     *  This is the database call for the abbreviated content on the index page
     * Find all items of the content node where third item equals the third segment
     */

    public function get_all_content($limit = null, $offset = null) {

        $this->db->where('visible', 1);

        $this->db->order_by("date", "desc");

        $query = $this->db->get("content", $limit, $offset);

        return $query->result();

    }

    public function find_content_rows($visible = true) {

        if ($visible === true) {

            $this->db->where('visible', 1);

        }

        return $this->db->get('content')->num_rows();

    }

    // --------------------------------------------------------------------

    /**
     * get_node_content function
     * get node content based on its id value
     * @access	public
     * @return	array
     */

    public function get_node_content($value) {

        // Find all items of the content node where third item equals the third segment
        $query = $this->db->get_where('content', array('id' => $value));

        return $query->result();

    }

    // --------------------------------------------------------------------

    /**
     * insert_content function
     * insert content - creates new content database entry
     * @access	public
     * @return	string
     */


    public function insert_content($category = "", $user_id = "", $image_id = "", $title =
        "", $body = "", $meta_description = "", $meta_keywords = "", $visibility = "") {

        // date('Y-m-d H:i:s') = MySQL now() function
        $data = array('category_id' => $category, 'user_id' => $user_id, 'image_id' => $image_id,
            'date' => date('Y-m-d H:i:s'), 'title' => $title, 'body' => $body,
            'meta_description' => $meta_description, 'meta_keywords' => $meta_keywords,
            'visible' => $visibility);

        return $this->db->insert('content', $data);

    } // End method insert_menu

    // --------------------------------------------------------------------

    /**
     * insert_content function
     * used for edit content list
     * @access	public
     * @param	string
     * @return	array
     */

    public function get_all_content_edit($limit = "", $offset = "") {

        $this->db->order_by("date", "desc");

        $query = $this->db->get("content", $limit, $offset);

        return $query->result();

    }


    /**
     * This is a duplicate for a method above. Find out where and replace
     */

    public function get_content_by_id($id) {

        $this->db->where('id', $id);

        $query = $this->db->get("content");

        return $query->result();

    }

   // --------------------------------------------------------------------

    /**
     * Update content row function
     * @access	public
     * @param	string
     * @return	array
     */
  
    public function update_content($title = "", $select = "", $user_id = "", $image_id =
        "", $date = "", $body = "", $visibility = "", $meta_description = "", $meta_keywords =
        "", $id = "") {


        $data = array('title' => $title, 'category_id' => $select, 'user_id' => $user_id,
            'image_id' => $image_id, 'date' => $date, 'body' => $body, 'meta_keywords' => $meta_keywords,
            'meta_description' => $meta_description, 'visible' => $visibility);

        $this->db->limit(1);

        $this->db->where('id', $id);

        return $this->db->update('content', $data);

    }
    
        // --------------------------------------------------------------------

    /**
     * delete_content function
     * used for edit content list
     * @access	public
     * @param	string
     * @return	string
     */


    public function delete_content($id = "") {

        $this->db->limit(1);

        $this->db->where('id', $id);

        return $this->db->delete('content');

    }

}
