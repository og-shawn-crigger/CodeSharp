<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

// NEED TO MAKE SURE CATEGORY NAME IS UNIQUE

class Admin_Category extends Controller {

    function __construct() {

        parent::Controller();

    }


    /*

    function _remap($method) {

    switch ($method) {
    case 'admin-add':
    $this->admin_add();
    break;
    
    case 'index':
    $this->index();
    break;

    }

    }
    
    */

    private function add_theme($array) {

        $data = $array;

        $data['categories'] = $this->category_model->get_cats();

        $data['content'] = "admin_category";

        $this->load->view("includes/template.php", $data);

    }

    public function index() {

        $data = array();

        $this->add_theme($data);

    }

    private function form_success() {

        $data = array();

        $data['success'] = "<p>You have successfully added another category</p>";

        $this->add_theme($data);

    }


    private function form_failure() {

        $data = array();

        $data['error'] = "<p>Unfortunately there have been some errors:</p>";

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

            if ($this->input->post('publishAdd') === "YES") {

                $visibility = 1;

            } else {

                $visibility = 0;

            }

            // success here

            $this->category_model->add_category($this->input->post('nameAdd'), $visibility);

            $this->form_success();

        }

    }


    public function delete_category() {

        $data = array();

        $form = $_POST;

        if ($this->category_model->delete_category($form['id'])) {

            $data['success'] = '<p class="message">You have now deleted the category</p>';

        }

        $this->add_theme($data);

    }


    private function check_duplicates($form_input) {

        $result = $this->category_model->get_cats();

        foreach ($result as $row) {

            if ($row['name'] === $form_input) {

                $this->form_validation->set_message('check_duplicates',
                    'The %s field already exists. Please pick a unique name');
                    
                return false;

            } else {

                return true;

            }

        }

    }


    public function validate_cat() {

        $data = array();

        foreach ($_POST as $name => $value) {

            if (empty($_POST[$name])) {

                $data['empty'] = "<p>Please make sure all required fields are not empty</p>";
                break;

            } else {

                if ($this->category_model->update_cat($_POST) === true) {

                    $data['success'] = "<p>Congratulations, you have updated the category</p>";

                } else {

                    // Offer fullback to ask whether they REALLY want to delete the category item

                    $data['form'] = 'Delete form here';

                }


            } // end if

            break;

        } // end foreach


        $this->add_theme($data);

    }


}

?>