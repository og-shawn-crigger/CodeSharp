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
 * Author_Model Class
 *
 * @package		CodeSharp
 * @subpackage	Application
 * @category	Models
 * @author		Andy Walpole
 * 
 */

class Author_Model extends CI_Model {

    public function node_author($id) {

        $this->db->where('id', $id);

        $query = $this->db->get("user");

        return $query->result();

    }

    // --------------------------------------------------------------------

    /**
     * get_users_title_mutli function
     *  // This is essential for fetching an mutli-dimensional array from the database to be
     * // use in the content edit form
     *
     * @access	public
     * @param	array
     * @return	string
     */


    public function get_users_title_mutli() {

        $this->db->select('id,username');

        $query = $this->db->get("user");

        foreach ($query->result_array() as $row) {

            $data[$row['id']] = $row['username'];

        }

        // This adds a null choice at the beginning of the drop down
        //$data = array_merge(array("0" => ""), $data);

        return $data;

    }

}
