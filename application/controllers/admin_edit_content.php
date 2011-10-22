<?php

/**
 * @author Andy Walpole
 * @date 4/10/2011
 * 
 */

class Admin_Edit_Content extends Controller {

    function __constructor() {

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

    // universal to all functions
    private function add_theme($array = "") {

        $data = $array;

        $data['edit'] = $this->content_model->get_content_by_id($this->uri->segment(3));

        $data['full_users'] = $this->author_model->get_users_title_mutli();

        $data['full_cats'] = $this->category_model->get_cat_title_mutli();

        $data['content'] = "edit_content_view";

        $this->load->view("includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $config['base_url'] = base_url() . 'index.php/admin_edit_content/index';

        // place below into its own model
        $config['total_rows'] = $this->db->get('content')->num_rows();

        $config['per_page'] = 3;

        $config['num_links'] = 10;

        $this->pagination->initialize($config);

        $data['cats'] = $this->user_model->find_all_users();

        $data['nodes_all'] = $this->content_model->get_all_content_edit($config['per_page'],
            $this->uri->segment(3));

        $this->add_theme($data);

    }
    
    


    public function edit_node() {

        $data = array();

        if (ctype_digit($this->uri->segment(3))) {

            $node = $this->uri->segment(3);

        } else {

            /**
             * IF NON DIGIT OR EMPTY A 404 MESSAGE IS THROW
             */

            get_404();

        }

        $this->add_theme($data);


    }


    public function isValidDateTime($datetime) {

        if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/",
            $datetime, $matches)) {

            if (checkdate($matches[2], $matches[3], $matches[1])) {

                return true;

            }

        } else {

            $this->form_validation->set_message('isValidDateTime',
                'The date format is incorrent. Please makes sure it is exactly the same format as: ' .
                date("Y-m-d H:i:s"));

            return false;

        }

    } // End form_validation_isValidDateTime() method


    // see routies.php -> $route['admin_edit_content/edit_node/:num/submit'] = "admin_edit_content/submit";
    public function submit() {

        $data = array();

        $file_result = null;

        if ($this->input->post("submit") == "submit") {

            $this->form_validation->set_rules('title', 'Title',
                'trim|required|max_length[100]');

            $this->form_validation->set_rules('body', 'Content', 'trim|required');

            if ($this->input->post('metaDescription')) {

                $this->form_validation->set_rules('metaDescription', 'Meta Description',
                    'trim|max_length[255]');

            }

            $this->form_validation->set_rules('date', 'date',
                'trim|required|callback_isValidDateTime');

            $meta_keywords = null;

            $result = $this->form_validation->run();

            if ($_FILES["file_upload"]['name'] !== "") {

                $file_result = $this->image_model->upload_image();

            }

            if (!$result || $file_result !== null) {

                // form validation NOT okay
                $data['success_error'] = "<p>You have problems with your form:</p>";

                $data['file_error'] = $file_result;

            } else {


                // If file upload is okay then make sure that file is
                // 1. Resize and placed into thumbnail folder
                // 2. New image row is created
                // 3. Old image details are deleted from database and file system

                if ($_FILES["file_upload"]['name'] !== "") {

                    $image_result = $this->image_model->update_image($this->input->post("orig_image"));


                } else {

                    $image_result = $this->input->post("orig_name");


                }

                // form validation okay

                // create database update here

                if ($this->content_model->update_content($this->input->post('title'), $this->
                    input->post('select'), $this->input->post('contentAuthor'), $image_result, $this->
                    input->post('date'), $this->input->post('body'), $this->input->post('publish'),
                    $this->input->post('metaDescription'), $meta_keywords, $this->uri->segment(3))) {

                    $data['success'] = '<p>You have successfully edited the content item</p>';

                }

            }

        }


        if ($this->input->post("submit") == "delete") {

            $data['delete_content'] = 1;

        }

        $this->add_theme($data);
    }


    public function delete_content() {

        $data = array();

        if ($this->content_model->delete_content($this->input->post("delete_this"))) {

            header('Location: ' . base_url() . 'index.php/admin_edit_content/');
            exit;

        }

        $this->add_theme($data);

    }

}

?>
