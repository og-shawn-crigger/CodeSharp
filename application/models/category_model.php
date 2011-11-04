<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011
 */

class Category_Model extends CI_Model {

    function get_categories_by_id($id) {

        $query = $this->db->get_where('category', array('id' => $id));

        return $query->result();

    }

    function get_cat_title() {

        $this->db->select('id,name');

        $query = $this->db->get("category");

        return $query->result();

    }

    // This is essential for fetching an mutli-dimensional array from the database to be
    // use in the add content form
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

    function get_cat_content($id) {

        // Find all items of the content node where third item equals the third segment
        $this->db->where('category_id', $id);

        $this->db->where('visible', 1);

        $this->db->order_by("date", "desc");

        $query = $this->db->get("content");

        return $query->result();

    }

    function add_category($name = "", $publish = "") {

        // date('Y-m-d H:i:s') = MySQL now() function
        $data = array('menu_id' => 'C', 'name' => $name, 'date' => date('Y-m-d H:i:s'),
            'visible' => $publish);

        return $this->db->insert('category', $data);

    }

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

    public function update_category($name, $visibility, $id) {

        if ($visibility === "YES") {

            $visibility = 1;

        } else {

            $visibility = 0;

        }

        $data = array('name' => $name, 'visible' => $visibility);

        $this->db->limit(1);

        $this->db->where('id', $id);

        return $this->db->update('category', $data);

    }

    public function delete_category($id = "") {

        $this->db->limit(1);

        $this->db->where('id', $id);

        return $this->db->delete('category');

    }


}

?>