<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011
 * 
 */

class Content extends CI_Controller {

    function __constructor() {

        parent::__construct();

    }


    private function add_theme($array) {

        $data = $array;

        $data['categories'] = $this->category_model->get_cats();

        $data['query_result'] = $this->category_model->get_cat_title();
        
        $data['menu'] = $this->menu_model->menu_order("where visible = 1");

        $data['content'] = "main-page";

        $this->load->view("includes/template.php", $data);

    }


    function index() {
        
        /**
         * Below is the pagination for the index page / articles
         */

        $config['base_url'] = base_url() . INDEX . 'content/index/';

        $config['total_rows'] = $this->content_model->find_content_rows($visible = true);

        $config['per_page'] = 3;

        $config['num_links'] = 2;
        
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $data = array();

        $data['records'] = $this->content_model->get_all_content($config['per_page'], $this->
            uri->segment(3));

        $this->add_theme($data);
        
    }


    public function article() {

        $data = array();

        $error = null;

        /**
         * Loop through content rows to see if item exists and if so
         * set $node to the id of the row
         */

        foreach ($this->content_model->get_all_content() as $result) {

            if (url_title(strtolower($result->title)) == $this->uri->segment(2)) {

                $node = $result->id;
                $error = 1;
                break;

            }

        }

        if (is_null($error)) {

            /**
             * If segment title is not in the database then that means that the item does not exist
             * If so then throw a 404 message
             */

            get_404();

        }

        // Place the menu data in its own class

        if ($this->uri->segment(1) === "article") {

            $data['full_node'] = $this->content_model->get_node_content($node);

            if (!empty($data['full_node'])) {

                // find full author name from database call above
                $data['author_name'] = $this->author_model->node_author($data['full_node'][0]->
                    user_id);

                // find full category from database call above
                $data['cat_name'] = $this->category_model->get_categories_by_id($data['full_node'][0]->
                    category_id);

            } else {

                get_404();

            }


        } // end $this->uri->segment(2) === "node"

        $this->add_theme($data);

    } //


    public function category() {

        $data = array();

        $error = null;

        /**
         * Loop through category rows to see if item exists and if so
         * set $node to the id of the row
         */

        foreach ($this->category_model->get_cats() as $result) {

            if (url_title(strtolower($result->name)) == $this->uri->segment(2)) {

                $category = $result->id;
                $error = 1;
                break;

            }

        }

        if (is_null($error)) {

            /**
             * If segment title is not in the database then that means that the item does not exist
             * If so then throw a 404 message
             */

            get_404();

        }

        if ($this->uri->segment(1) === "category" && $this->uri->segment(2) !== "") {

            $data['category_records'] = $this->category_model->get_categories_by_id($category);

            $data['category_details'] = $this->category_model->get_cat_content($category);

        }

        $this->add_theme($data);

    }


} // end of class


?>