<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

class Admin_Content extends CI_Controller {


    function __constructor() {

        parent::__construct();

    }


    function _remap($method) {

        switch ($method) {

            case 'admin-add-content':
                $this->admin_add_content();
                break;

            default:
                $this->index();
                break;

        }

    }


    // universal to all functions
    private function add_theme($array) {

        $data = $array;

        $data['full_cats'] = $this->category_model->get_cat_title_mutli();

        $data['content'] = "admin/admin_new_content";

        $this->load->view("admin/includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }

    private function form_success() {

        return "<p>You have successfully created a new article!</p>";

    }


    private function form_failure() {

        return "<p>Unforunately there have been some errors:</p>";

    }


    public function admin_add_content() {

        $data = array();
        
         /**
         * validation rule to be found in config -> form_validation.php
         */

        if ($this->input->post('metaDescription')) {

            $this->form_validation->set_rules('metaDescription', 'Meta Description',
                'trim|max_length[255]');

        }

        if ($this->input->post('metaKeywords')) {

            $this->form_validation->set_rules('metaKeywords', 'Meta Keywords',
                'trim|max_length[255]');

        }


        /**
         * There's a problem here because I couldn't integrate the file upload errors into
         * the form validation so I had to keep them separate
         * There's too many branches here. Needs attention
         */

        if ($this->form_validation->run("addnode") !== false) {

            if ($_FILES["file_upload"]['error'] !== 4) {

                // do file upload validation here
                // add to the rest of the form validation rule

                $data['file_error'] = $this->image_model->upload_image();

                if (isset($data['file_error'])) {

                    $data['success_fail'] = $this->form_failure();

                } else {

                    $data['success_fail'] = $this->form_success();
                    // ultimate success here

                    $target_file = $this->image_model->update_image();

                    // Update content table

                    $this->content_model->insert_content($this->input->post('select'), 1,
                        // Need to change user value based on cookie value
                        $target_file, $this->input->post('title'), $this->input->post('body'), $this->
                        input->post('metaDescription'), $this->input->post('metaKeywords'), $this->
                        input->post('publish'));

                }

            } else {

                $data['success_fail'] = $this->form_success();
                // ultimate success here

                $target_file = $this->image_model->update_image();

                // Update content table

                $this->content_model->insert_content($this->input->post('select'), 1,
                    // Need to change user value based on cookie value
                    $target_file, $this->input->post('title'), $this->input->post('body'), $this->
                    input->post('metaDescription'), $this->input->post('metaKeywords'), $this->
                    input->post('publish'));

            }

        } else {

            $data['success_fail'] = $this->form_failure();

        }

        $this->add_theme($data);

    }

}
