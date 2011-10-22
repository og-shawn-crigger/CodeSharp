<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011
 * 
 */


/**
 * THIS PAGE NEED REFACTORING
 */


class Content extends Controller {

    function __constructor() {

        parent::Controller();

    }


    function index() {

        $config['base_url'] = base_url() . 'index.php/admin_edit_content/index';

        $config['total_rows'] = $this->db->get('content')->num_rows();

        $config['per_page'] = 3;

        $config['num_links'] = 10;

        $this->pagination->initialize($config);

        $data = array();

        // PLACE THE MENU IN ITS OWN CLASS

        $data['full_menu'] = $this->menu_model->display_menu();

        if ($this->uri->segment(1) === "content" || !$this->uri->segment(0)) {

            $data['records'] = $this->content_model->get_all_content($config['per_page'], $this->
                uri->segment(3));

            //This array is needed in order to find the category name when
            // the nodes are summarised

            $data['query_result'][] = $this->category_model->get_cat_title();

        }

        $data['content'] = "main-page";

        $this->load->view("includes/template.php", $data);

    }


    public function node($id = "") {

        $data = array();

        if (ctype_digit($this->uri->segment(3))) {

            $node = $this->uri->segment(3);

        } else {

            /**
             * IF NON DIGIT OR EMPTY A 404 MESSAGE IS THROWN
             */

            get_404();

        }

        // Place the menu data in its own class

        $data['full_menu'] = $this->menu_model->display_menu();

        if ($this->uri->segment(2) === "node") {

            $data['full_node'] = $this->content_model->get_node_content($node);

            if (!empty($data['full_node'])) {

                // find full author name from database call above
                $data['author_name'] = $this->author_model->node_author($data['full_node'][0]->
                    user_id);

                // find full category from database call above
                $data['cat_name'] = $this->category_model->get_categories_by_id($data['full_node'][0]->
                    category_id);

            }


        } // end $this->uri->segment(2) === "node"

        $data['content'] = "main-page";

        $this->load->view("includes/template.php", $data);

    } //


    public function category() {

        $data = array();

        if (ctype_digit($this->uri->segment(3))) {

            $category = $this->uri->segment(3);

        } else {

            /**
             * IF NON DIGIT OR EMPTY A 404 MESSAGE IS THROWN
             */

            get_404();

        }

        // Place the menu data in its own class

        $data['full_menu'] = $this->menu_model->display_menu();


        if ($this->uri->segment(2) === "category" && $this->uri->segment(3) !== "") {

            $data['category_records'] = $this->category_model->get_categories_by_id($category);

            $data['category_details'] = $this->category_model->get_cat_content($category);

        }

        $data['content'] = "main-page";

        $this->load->view("includes/template.php", $data);

    }


} // end of class


?>