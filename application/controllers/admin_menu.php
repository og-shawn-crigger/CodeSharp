<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

class Admin_Menu extends Controller {


    function __constructor() {

        parent::Controller();

    }

    // universal to all functions
    private function add_theme($array) {

        $data = $array;

        $data['content'] = "admin_menu_view";

        $data['display_menu'] = $this->menu_model->display_menu_admin();

        $data['admin_menu_order'] = $this->menu_model->menu_order();

        $data['cat_menu_result'] = $this->menu_model->fetch_cat_menu();

        $this->load->view("includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }

    // When a new menu item is created make sure that the menu name is unique

    public function duplicate_menu_name($name) {

        $query = $this->menu_model->display_menu();

        foreach ($query as $row) {

            if ($row->name == $name) {

                $this->form_validation->set_message('duplicate_menu_name',
                    "The %s field already exists in the database. Please chose a new name");

                return false;

            }

        }

    }


    private function array_key_change($existing, $newkeys) {

        // a really simple check that the arrays are the same size
        if (count($existing) !== count($newkeys))
            return false; // or pipe out a useful message, or chuck exception

        $data = array(); // set up a return array
        $i = 0;
        foreach ($existing as $k => $v) {
            $data[$newkeys[$i]] = $v; // build up the new array
            $i++;
        }
        return $data; // return it

    }

    public function update_menu() {

        $data = array();

        // if form is posted then process validation
        if (!is_null($_POST)) {

            // the rewrite keys in the correct order
            $newkeys = array('one', 'two', 'three', 'four', 'five', 'six');

            // change the associative array of the form results - VALUES
            $new_form = $this->array_key_change($_POST, $newkeys);

            // change the associative array forms results - KEYS
            $array_keys = $this->array_key_change(array_keys($_POST), $newkeys);

            $this->form_validation->set_rules($array_keys['one'], 'menu name',
                'trim|required|max_length[40]');

            $this->form_validation->set_rules($array_keys['two'], 'menu url',
                'trim|required|max_length[40]');

            $this->form_validation->set_rules($array_keys['three'], 'publish',
                'trim|required');

            if ($this->form_validation->run() !== false) {

                if ($this->menu_model->update_menu($new_form['one'], $new_form['two'], $new_form['three'],
                    $new_form['five'])) {

                    $data['success_error'] = "<p>You have successfully submitted the form</p>";

                }

            } else {

                $data['success_error'] = "<p>There have been problems with the form:</p>";

            }

        } // end !is_null($_POST)

        $this->add_theme($data);
    }

    public function change_menu_order() {

        $data = array();

        $error = null;

        // Make sure validation only happens after from has been submitted
        if (!empty($_POST)) {

            // user array_map to create multidimensional arrays for the form result
            $array = array_map(null, $_POST['hidden_menu_id'], $_POST['hidden_menu_name'], $_POST['menu']);

            foreach ($array as $row) {

                // This should be made into a PHP regex
                if ($row[2] === "" || !ctype_digit($row[2]) || strlen($row[2]) > 2) {

                    $error = 1;
                    break;

                } // end foreach loop

            } // end isset


            if ($error === null) {

                // Form has no validation problems

                if ($this->menu_model->update_menu_order($array) > 0) {

                    $data['success_fail'] = '<p>Yes, the form is fine</p>';

                }

            } else {

                // Form has validation problems

                $data['success_fail'] = "<p>There have been some problems with the form</p>";
                $data['success_fail'] .=
                    '<p>Please make sure the value is a one or two digit number</p>';

            }


        } // end if post

        $this->add_theme($data);

    }

    public function add_categories_to_menu() {

        $data = array();

        if ($this->menu_model->add_categories_to_menu()) {

            $data['success_failure'] =
                "<p>You have successfully added the categories to the menu items</p>";

        }

        $this->add_theme($data);

    }


    public function menu_add() {

        $data = array();

        $this->form_validation->set_rules('nameAdd', 'Name',
            'trim|required|max_length[40]|callback_duplicate_menu_name');

        $this->form_validation->set_rules('urlAdd', 'URL',
            'trim|required|max_length[100]');

        $this->form_validation->set_rules('publishAdd', 'publish', 'required');

        if ($this->form_validation->run()) {

            // successful

            if ($this->menu_model->insert_menu($this->input->post('nameAdd'), $this->input->
                post('urlAdd'), $this->input->post('publishAdd'))) {

                $data['success'] = "<p>You have successfully create a new menu item</p>";

            }

        } else {

            // error

            $data['data'] = "<p>There have been some problems with your form submission: </p>";

        }

        $this->add_theme($data);

    }

    public function delete_menu() {

        $data = array();

        if ($this->menu_model->delete_menu($this->input->post("delete_this"))) {

            $data['success'] = "<p>You have successfully deleted the menu item</p>";

        }

        $this->add_theme($data);

    }

}

?>