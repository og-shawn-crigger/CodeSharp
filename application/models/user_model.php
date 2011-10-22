<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011
 * 
 */

class User_Model extends Model {

    public function insert_user($name = "", $password = "", $email = "", $admin_rights =
        "", $member = "", $dbsalt = DBSALT) {

        // membership number
        $member = rand(1, 9999999999999);

        // Add fixed salt and unique user salt to the password
        $password = hash_hmac('sha1', $password, SALT . $dbsalt);

        // date('Y-m-d H:i:s') = MySQL now() function
        $data = array('created' => date('Y-m-d H:i:s'), 'username' => $name, 'password' =>
            $password, 'email' => $email, 'member' => $member, 'admin_rights' => $admin_rights,
            'dbsalt' => $dbsalt);

        return $this->db->insert('user', $data);

    } // End method insert_user


    public function find_all_users() {

        $query = $this->db->get("user");

        return $query->result();

    }

    // Method used on admin-add-user.inc.php
    public function update_user($username = "", $password = "", $email = "", $admin_rights =
        "", $id = "", $dbsalt = DBSALT) {

        if ($admin_rights === "YES") {

            $admin = 1;

        } else {

            $admin = 0;

        }

        if ($password !== "") {

            // Add fixed salt and unique user salt to the password
            $password = hash_hmac('sha1', $password, SALT . $dbsalt);

            $data = array('username' => $username, 'password' => $password, 'email' => $email,
                'admin_rights' => $admin, 'dbsalt' => $dbsalt);

            $this->db->limit(1);

            $this->db->where('id', $id);

            return $this->db->update('user', $data);

        } else {

            $data = array('username' => $username, 'email' => $email, 'admin_rights' => $admin);

            $this->db->limit(1);

            $this->db->where('id', $id);

            return $this->db->update('user', $data);

        }

    } // end method update_category


    public function delete_user($id = "") {

        $this->db->limit(1);

        $this->db->where('id', $id);

        return $this->db->delete('user');

    }


    // Method used on admin-login.inc.php
    public function admin_login($username = "", $password = "") {

        $error = "<p>Sorry the username or password does not exist</p>";
        $error .= '<p>If you have forgotten your username or password then <a href="' .
            base_url() . INDEX . 'login/forgotten_userdetails">please click on here</a></p>';

        /**
         * First checks to see is usename exists
         * If it exists then grab it dbsalt value. This is needed for the passport
         * If it doesn't exist then display an error message
         */

        $this->db->select('dbsalt');

        $this->db->where('username', $username);

        $query = $this->db->get("user");

        $result = $query->row();

        if ($result) {

            // if username exists

            /**
             * If username exists then grab login with password supplied by user PLUS
             * dbsalt from database and salt constant
             */

            // Add fixed salt and unique user salt to the password
            $password = hash_hmac('sha1', $password, SALT . $result->dbsalt);

            $this->db->select('id, username');

            $this->db->where('username', $username);
            $this->db->where('password', $password);

            $query = $this->db->get("user");

            $user = $query->row();

            /**
             * If the password is wrong then display an error message
             * But if it is correct then return the user values as an object
             */

            if ($user) {

                return $user;

            } else {

                return $error;

            }

        } else {

            // if username does not exist

            return $error;

        }

    } // end admin_login method


    // Method used on admin-newpassword.inc.php
    public function new_password($username = "", $email = "") {

        //$STH = $this->db->prepare("SELECT email,member,username FROM user WHERE email = :email OR username = :username");

        $this->db->select('email, member, username');

        $this->db->where('username', $username);
        $this->db->or_where('email', $email);

        $query = $this->db->get("user");

        $user = $query->row();

        if (!empty($user)) {


            // Email contacts to admin
            // Need to set universal admin email

            $this->email->from(SITENAME);
            $this->email->to($user->email);

            $this->email->subject('Email from SITENAME. Change password details.');

            // Build the email message body up below
            // Find if there is a CodeIngitor-friendly way of building up the message

            $body = 'Your username is ' . $user->username . "<br />";
            $body .= 'For your new password please visit: ';
            $body .= '<a href="';
            $body .= base_url() . INDEX . 'login/' . 'new_password/' . $user->member . "/1";
            $body .= '">' . SITENAME . '</a>';

            $body = stripslashes($body);

            $this->email->message($body);

            if ($this->email->send()) {

                //$sql = "UPDATE user SET newpass = 1 WHERE email = :email_two AND username = :username_two LIMIT 1";

                /**
                 * This sets the user field newpass to 1 which is changed to 0 once the email is clicked through.
                 * This ensures greater security because only users with 1 for the newpass field will be able to reset their password
                 */
                $data = array('newpass' => 1);

                $this->db->limit(1);

                $this->db->where('email', $user->email);

                $this->db->where('username', $user->username);

                $this->db->update('user', $data);

            }

            // remove below
            echo $this->email->print_debugger();

            return "<p>We have sent you an email so you can reset your password. Please check your inbox</p>";

        } else {

            return '<p>Your username or email address cannot be found</p>';

        }


    } // End method new_password()


    /**
     * After users clicks on link to set new password then 
     */


    public function set_new_password($member) {


        // Add fixed salt and unique user salt to the password

        $this->db->select('id, dbsalt');

        $this->db->where('member', $member);

        $query = $this->db->get("user");

        if ($this->db->affected_rows() === 1) {

            /**
             * User membership number exists
             * From here on generate a new membership password and change the newpass column back to 0
             */

            $user = $query->row();

            // new password
            $new_password = uniqid();
            $password = "";

            // prepare the password for inclusion into the database
            $password = hash_hmac('sha1', $new_password, SALT . $user->dbsalt);

            // now run database update query

            $data = array('newpass' => 0, 'password' => $password);

            $this->db->limit(1);

            $this->db->where('id', $user->id);

            if($this->db->update('user', $data)) {
                
                return "<p>Your new password is " . $new_password . " Please log in below with your user details</p>";
                
            }// end if $this->db->update('user', $data)

        } else {
            
            return "<p>Your user details can not be found. Please contact the administrator for help.</p>";
            
        }
        
        
        // end if $this->db->affected_rows() === 1

    }

} // end of class


?>