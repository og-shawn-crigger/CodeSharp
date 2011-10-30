<?php

/**
 * @author Andy Walpole
 * @date 27/9/2011
 * 
 */


class Author_Model extends CI_Model {

    public function node_author($id) {

        $this->db->where('id', $id);

        $query = $this->db->get("user");

        return $query->result();

    }


    // This is essential for fetching an mutli-dimensional array from the database to be
    // use in the content edit form
    function get_users_title_mutli() {

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

?>