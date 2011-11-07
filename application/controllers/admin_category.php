<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

class Admin_Category extends CI_Controller {

    function __construct() {

        parent::__construct();

    }


    function _remap($method) {

        switch ($method) {

            case 'form-success':
                $this->form_success();
                break;

            case 'form-failure':
                $this->form_failure();
                break;

            case 'add-category':
                $this->add_category();
                break;

            case 'delete-category':
                $this->delete_category();
                break;

            case 'check-duplicates':
                $this->check_duplicates();
                break;

            case 'validate-cat':
                $this->validate_cat();
                break;

            default:
                $this->index();
                break;

        }

    }


    private function add_theme($array) {

        $data = $array;

        $data['categories'] = $this->category_model->get_cats();

        $data['content'] = "admin/admin_category";

        $this->load->view("admin/includes/template.php", $data);

    }

    public function index() {

        $data = array();

        $this->add_theme($data);

    }

    private function form_success() {

        $data = array();

        $data['success_error'] = "<p>You have successfully added another category</p>";

        $this->add_theme($data);

    }


    private function form_failure() {

        $data = array();

        $data['success_error'] = "<p>Unfortunately there have been some errors:</p>";

        $this->add_theme($data);

    }


    public function add_category() {

        $data = array();

        $this->form_validation->set_rules('nameAdd', 'Name',
            'trim|required|max_length[40]');

        $this->form_validation->set_rules('publishAdd', 'Publish article', 'required');

        if ($this->form_validation->run() === false) {

            // errors here

            $this->form_failure();

        } else {

            // success here

            $this->category_model->add_category($this->input->post('nameAdd'), $this->input->post('publishAdd'));

            $this->form_success();

        }

    }


    public function delete_category() {

        $data = array();

        if ($this->category_model->delete_category($this->input->post("id"))) {

            $data['success'] = '<p class="message">You have now deleted the category</p>';

        }

        $this->add_theme($data);

    }


    public function check_duplicates($form_input = "", $orig_form = "") {

        if ($orig_form === "") {

            $result = $this->category_model->get_cats();

        } else {

            $result = $this->category_model->get_cats($orig_form);

        } // end if


        foreach ($result as $row) {

            if ($row->name == $form_input) {

                $this->form_validation->set_message('check_duplicates',
                    'The %s field already exists. Please pick a unique name');

                return false;

            }

            // and if

        } // foreach

    }


    public function validate_cat() {

        $data = array();

        // the rewrite keys in the correct order
        $newkeys = array('one', 'two', 'three', 'four', 'five');

        // change the associative array of the form results - VALUES
        $new_form = array_key_change($_POST, $newkeys);

        // change the associative array forms results - KEYS
        $array_keys = array_key_change(array_keys($_POST), $newkeys);

        if ($new_form['three'] === "submit") {

            $this->form_validation->set_rules($array_keys['one'], 'category name',
                'trim|required|max_length[40]|callback_check_duplicates[' . $new_form['five'] .
                ']');

            $this->form_validation->set_rules($array_keys['two'], 'published', 'required');

            if ($this->form_validation->run() !== false) {

                // successful validation

                if ($this->category_model->update_category($new_form['one'], $new_form['two'], $new_form['four'])) {

                    $data['success_error'] = "<p>You have successfully updated the category</p>";

                }

            } else {

                // if problems with validation

                $data['success_error'] = "<p>There have been problems with the form:</p>";

            }

        }

        if ($new_form['three'] === "delete") {

            $data['finalDelete'] = $new_form['four'];

        }

        $this->add_theme($data);

    }


}
