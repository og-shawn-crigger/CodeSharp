<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

class Admin extends Controller {

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

    public function index() {

        $data = array();

        $data['full_cats'] = $this->category_model->get_cat_title_mutli();

        $data['content'] = "admin-page";

        $this->load->view("includes/template.php", $data);


    }
    

}

?>