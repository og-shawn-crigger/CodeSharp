<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011
 */

class Category_Model extends Model {

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

    public function get_cats() {

        $query = $this->db->get("category");

        return $query->result();

    }

    private function update_category($name, $visibility, $id) {

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
    
    public function update_cat($form) {

        /**
         *  This takes the form submission the as a $_POST associative array, creates a multidimensional array with array_map and then
         * uses the list function to take the values and place them into the database update function
         */


        $data = array();

        $submit = '/^submit/';

        $delete = '/^delete/';

        $number = array(1, 2, 3, 4, 5);

        $array_merge = array_map(null, $number, $form);

        foreach ($form as $key => $value) {

            // loop through $_POST keys to see whether the delete or submit button was clicked

            if (preg_match($submit, $key, $matches)) {

                // If the form subit button has been clicked then update the category table

                list($name, $visibility, $sub, $id, $org_name) = $array_merge;

                return $this->category_model->update_category($name[1], ($visibility[1] ===
                    "YES" ? 1 : 0), $id[1]);

            }

            if (preg_match($delete, $key, $matches)) {

                // If the form submit button has been clicked then delete the entry

                $delete2 = 1;

                return $delete2;

            }

        }

    }

}

?>