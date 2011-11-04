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

            case 'form-success':
                $this->form_success();
                break;

            case 'form-failure':
                $this->form_failure();
                break;

            case 'admin-add-content':
                $this->admin_add_content();
                break;

            case 'index':
                $this->index();
                break;

        }

    }


    // universal to all functions
    private function add_theme($array) {

        $data = $array;

        $data['full_cats'] = $this->category_model->get_cat_title_mutli();

        $data['content'] = "admin_new_content";

        $this->load->view("includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }

    function form_success($array) {

        $data = array();

        $data = $array;

        $data['success-fail'] = "<p>You have successfully created a new article!</p>";

        $this->add_theme($data);

    }

    function form_failure($array) {

        $data = array();

        $data = $array;

        $data['success_fail'] = "<p>Unforunately there have been some errors:</p>";

        $this->add_theme($data);

    }

    public function admin_add_content() {

        $data = array();

        $this->form_validation->set_rules('title', 'Title',
            'trim|required|max_length[100]');

        $this->form_validation->set_rules('select', 'Category', 'required');

        $this->form_validation->set_rules('body', 'Content', 'required');

        $this->form_validation->set_rules('publish', 'Publish article', 'required');

        if ($this->input->post('metaDescription')) {

            $this->form_validation->set_rules('metaDescription', 'Meta Description',
                'trim|max_length[255]');

        }
        
        if ($this->input->post('metaKeywords')) {

            $this->form_validation->set_rules('metaKeywords', 'Meta Keywords',
                'trim|max_length[255]');

        }

        if ($this->input->post('publish') === "YES") {

            $visibility = 1;

        } else {

            $visibility = 0;

        }


        /**
         * There's a problem here because I couldn't integrate the file upload errors into
         * the form validation so I had to keep them separate
         * There's too many branches here. Needs attention
         */

        if ($this->form_validation->run() !== false) {

            if ($_FILES["file_upload"]['error'] !== 4) {

                // do file upload validation here
                // add to the rest of the form validation rule

                $data['file_error'] = $this->image_model->upload_image();

                if (isset($data['file_error'])) {

                    $this->form_failure($data);

                } else {

                    $this->form_success($data);
                    // ultimate success here

                    $target_file = $this->image_model->update_image();

                    // Update content table

                    $this->content_model->insert_content($this->input->post('select'), 1,
                        // Need to change user value based on cookie value
                        $target_file, $this->input->post('title'), $this->input->post('body'), $this->
                        input->post('metaDescription'), $this->input->post('metaKeywords'), $visibility);

                }

            } else {

                $this->form_success($data);
                // ultimate success here

                $target_file = $this->image_model->update_image();

                // Update content table

                $this->content_model->insert_content($this->input->post('select'), 1,
                    // Need to change user value based on cookie value
                    $target_file, $this->input->post('title'), $this->input->post('body'), $this->
                    input->post('metaDescription'), $this->input->post('metaKeywords'), $visibility);


            }

        } else {

            $this->form_failure($data);

        }

    }

}

?>