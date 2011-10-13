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

        $data['admin_menu_order'] = $this->menu_model->menu_order();

        $data['cat_menu_result'] = $this->menu_model->fetch_cat_menu();

        $this->load->view("includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }

    public function change_menu_order() {
        
        // Need to loop through array
        
        var_dump(array_values($_POST['menu']));
        
        echo strlen(implode(array_values($_POST['menu']))) . '<br/ >';

        if (array_values($_POST['menu']) == "") {

            echo "EMPTY";

        } else {

            echo "NOT EMPTT";

        }


        if (strlen(array_values($_POST['menu']) > 2)) {

            echo "field is too long or not digit";
            
        } else {

            echo "field is fine";

        }


        $data = array();

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
            'trim|required|max_length[40]');

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


}

?>