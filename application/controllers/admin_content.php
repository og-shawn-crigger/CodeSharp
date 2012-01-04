<?php
/**
 * CodeSharp
 *
 * A CMS based on CodeIgniter
 *
 * @package		CodeSharp
 * @author		Andy Walpole (unless stated to the contrary)
 * @copyright	Andy Walpole (unless stated to the contrary)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		https://github.com/TCotton/CodeSharp
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Admin_Content
 *
 * @package		CodeSharp
 * @subpackage	Application
 * @category	Controllers
 * @author		Andy Walpole
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
    
    // --------------------------------------------------------------------

    /**
     * add_theme function
     * Adds category menu and template to all pages
     *
     * @access	private
     * @param	string
     * @return	string
     */

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
    
        
    // --------------------------------------------------------------------

    /**
     * form_success function
     * Shows success message
     *
     * @access	private
     * @return	string
     */


    private function form_success() {

        return "<p>You have successfully created a new article!</p>";

    }
    
      // --------------------------------------------------------------------

    /**
     * form_failure function
     * Shows error message
     *
     * @access	private
     * @return	string
     */


    private function form_failure() {

        return "<p>Unforunately there have been some errors:</p>";

    }
    
    // --------------------------------------------------------------------

    /**
     * admin_add_content function
     * Adds new article, validates and then calls database query
     *
     * @access	public
     * @param	array
     * @return	string
     */

    public function admin_add_content() {

        $data = array();

        $data['file_error'] = null;

        /**
         * validation rule to be found in config -> form_validation.php
         */

        $this->form_validation->set_rules('title', 'title',
            'trim|required|max_length[100]');

        $this->form_validation->set_rules('body', 'content', 'required');

        if (isset($_POST['metaDescription'])) {

            $this->form_validation->set_rules('metaDescription', 'Meta Description',
                'trim|required|max_length[255]');

        }

        if (isset($_POST['metaKeywords'])) {

            $this->form_validation->set_rules('metaKeywords', 'Meta Keywords',
                'trim|required|max_length[255]');

        }

        if ($_FILES["file_upload"]['error'] != 4) {

            // If image uploaded then process file to see if there are any errors

            $data['file_error'] = $this->image_model->upload_image();

        }


        /**
         * There's a problem here because I couldn't integrate the file upload errors into
         * the form validation so I had to keep them separate
         * There's too many branches here. Needs attention
         */

        if ($this->form_validation->run() !== false && $data['file_error'] === null) {

            /**
             * Need to branch here.
             * One branch for database update if image uploaded
             * And the other branch for database update if image not uploaded
             */
            if ($_FILES["file_upload"]['error'] != 4) {

                $target_file = $this->image_model->update_image();

                $this->content_model->insert_content($this->input->post('select'), 1,
                    // Need to change user value based on cookie value
                    $target_file, $this->input->post('title'), $this->input->post('body'), $this->
                    input->post('metaDescription'), $this->input->post('metaKeywords'), $this->
                    input->post('publish'));

                $data['success_fail'] = $this->form_success();

            } else {

                // Here update database with image

                $target_file = null;

                // Here update database with NO image
                $this->content_model->insert_content($this->input->post('select'), 1,
                    // Need to change user value based on cookie value
                    $target_file, $this->input->post('title'), $this->input->post('body'), $this->
                    input->post('metaDescription'), $this->input->post('metaKeywords'), $this->
                    input->post('publish'));

                $data['success_fail'] = $this->form_success();

            }

        } else {

            // if validation errors then show error message

            $data['success_fail'] = $this->form_failure();

        }

        $this->add_theme($data);

    }

}
