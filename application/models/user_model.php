<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011<?php
 * ?>
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


}

?>