<?php

/**
 * @author Andy Walpole
 * @date 3/10/2011
 * 
 */


class Admin_User extends Controller {

    function __construct() {

        parent::Controller();

    }

    private function add_theme($array) {

        $data = $array;

        $query = $this->user_model->find_all_users();

        $data['query'] = $query;

        $data['content'] = "admin_user_view";

        $this->load->view("includes/template.php", $data);

    }


    public function index() {

        $data = array();

        $this->add_theme($data);

    }


    // When a new user is created make sure that the username is unique

    public function duplicate_username($name = "") {

        $query = $this->user_model->find_all_users();

        foreach ($query as $row) {

            if ($row->username == $name) {

                $this->form_validation->set_message('duplicate_username',
                    "The %s field already exists in the database. Please chose a new name");

                return false;

            } else {

                return true;

            }

        }

    }


    public function duplicate_email($email = "") {

        $query = $this->user_model->find_all_users();

        foreach ($query as $row) {

            if ($row->email == $email) {

                $this->form_validation->set_message('duplicate_email',
                    "The %s field already exists in the database. Please chose a new email address");

                return false;

            } else {

                return true;

            }

        }


    }


    function add_user() {

        $data = array();

        $this->form_validation->set_rules('usernameAdd', 'username',
            'trim|required|max_length[30]|callback_duplicate_username');

        $this->form_validation->set_rules('passwordAdd', 'first password',
            'trim|required|max_length[40]');

        $this->form_validation->set_rules('passwordTwoAdd', 'second password',
            'trim|required|max_length[40]|matches[passwordAdd]');

        $this->form_validation->set_rules('emailAdd', 'first email',
            'trim|required|max_length[50]|valid_email|callback_duplicate_email');

        $this->form_validation->set_rules('emailTwoAdd', 'second email',
            'trim|required|max_length[50]|valid_email|matches[emailAdd]');

        $this->form_validation->set_rules('adminRightsAdd', 'admin rights', 'required');

        if ($this->form_validation->run() === false) {

            // form problems here

            $data['error'] = "<p>There have been some issues with your form: </p>";

        } else {

            if ($this->input->post('adminRightsAdd') === "YES") {

                $admin_rights = 1;

            } else {

                $admin_rights = 0;

            }

            // form success here


            if ($this->user_model->insert_user($this->input->post('usernameAdd'), $this->
                input->post('passwordAdd'), $this->input->post('emailAdd'), $admin_rights)) {

                $data['success'] = "<p>You have successfully created a new user.</p>";

                $this->index();

            }


        }


        $this->add_theme($data);

    }


    public function duplicate_username_edit($name = "", $orig_username = "") {

        $hiddenE = $orig_username;

        $query = $this->user_model->find_all_users();

        foreach ($query as $row) {

            if (($row->username == $name) && ($name != $hiddenE)) {

                $error = 1;
                break;

            } else {

                $error = 0;

            } // end if statement

        } // end foreach loop

        if ($error === 1) {

            $this->form_validation->set_message('duplicate_username_edit',
                "The %s field already exists in the database. Please chose a new name");

            return false;

        } else {

            return true;

        } // end if error statement

    }



    // checks to see if the new email chosen in the user edit field hasn't already been used
    public function duplicate_email_edit($email, $orig_email = "") {

        $hiddenE = $orig_email;

        $query = $this->user_model->find_all_users();

        foreach ($query as $row) {

            if (($row->email == $email) && ($email != $hiddenE)) {

                $error = 1;
                break;

            } else {

                $error = 0;

            } // end if statement

        } // end foreach loop

        if ($error === 1) {

            $this->form_validation->set_message('duplicate_email_edit',
                "The %s field already exists in the database. Please chose a new name");

            return false;

        } else {

            return true;

        } // end if error statement

    }


    public function edit_users() {

        $data = array();

        // the rewrite keys in the correct order
        $newkeys = array('one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight',
            'nine', 'ten');

        // change the associative array of the form results - VALUES
        $new_form = array_key_change($_POST, $newkeys);

        // change the associative array forms results - KEYS
        $array_keys = array_key_change(array_keys($_POST), $newkeys);

        if ($new_form['seven'] === "submit") {

            // If submitted then

            $this->form_validation->set_rules($array_keys['one'], 'username',
                'trim|required|max_length[30]|callback_duplicate_username_edit[' . $new_form['nine'] .
                ']');

            $this->form_validation->set_rules($array_keys['two'], 'first email',
                'trim|required|max_length[50]|callback_duplicate_email_edit[' . $new_form['ten'] .
                ']');

            $this->form_validation->set_rules($array_keys['three'], 'second email',
                'trim|required|max_length[50]||valid_email|matches[' . $array_keys['two'] . ']');

            if (isset($form[$array_keys['four']])) {

                $this->form_validation->set_rules($array_keys['four'], 'first password',
                    'trim|max_length[40]');

            }

            if (isset($form[$array_keys['five']])) {

                $this->form_validation->set_rules($array_keys['five'], 'second password',
                    'trim|max_length[40]|matches[' . $array_keys['four'] . ']');

            }

            $this->form_validation->set_rules($array_keys['six'], 'admin rights', 'required');

            if ($this->form_validation->run() === false) {

                $data['success_error'] = "<p>There have been problems with the form:</p>";

            } else {

                if ($this->user_model->update_user($new_form['one'], $new_form['four'], $new_form['two'],
                    $new_form['six'], $new_form['eight'])) {

                    $data['success_error'] = "<p>You have successfully submitted the form</p>";

                }

            }

        }

        if ($new_form['seven'] === "delete") {

            $data['delete_now'] = $new_form['eight'];

        }

        $this->add_theme($data);

    }


    public function delete_user() {

        $data = array();

        if ($this->user_model->delete_user($this->input->post("delete_this"))) {

            $data['success'] = "<p>You have successfully deleted the user</p>";

        }

        $this->add_theme($data);

    }
}

?>