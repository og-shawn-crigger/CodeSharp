<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

?>

<div id="wrapper" class="admin">

<header class="clearfix">

<h1>Pinhead CMS - CodeIgnitor Verson</h1>

</header><!-- End header -->

<div id="content" class="clearfix">

<section  id="column-one">

<div id="admin-add-user">
<h1>Add or edit existing users here</h1>

<?php


if(isset($_POST['submitAdd'])) {
    
if (isset($error)) {

    echo $error;

}

if (isset($success)) {

    echo $success;

}

echo validation_errors();

}

$attributes = array('id' => "add-user", 'name' => "addUser");

$form = form_open_multipart('admin_user/add_user', $attributes);

$form .= form_fieldset('Add user');

$form .= form_label('Username:', 'username');

$form .= form_input(array('name' => 'usernameAdd', 'id' => 'username',
    'maxlength' => '30', 'type' => 'text', 'value' => set_value('usernameAdd')));

$form .= form_label('Password:', 'password');

$form .= form_input(array('name' => 'passwordAdd', 'id' => 'password',
    'maxlength' => '40', 'type' => 'text', 'autocomplete' => 'off', 'value' =>
    set_value('passwordAdd')));

$form .= form_label('Password again:', 'password-two');

$form .= form_input(array('name' => 'passwordTwoAdd', 'id' => 'password-two',
    'maxlength' => '40', 'type' => 'text', 'autocomplete' => 'off', 'value' =>
    set_value('passwordTwoAdd')));

$form .= form_label('Email:', 'email');

$form .= form_input(array('name' => 'emailAdd', 'id' => 'email', 'maxlength' =>
    '50', 'type' => 'text', 'value' => set_value('emailAdd')));

$form .= form_label('Email again:', 'email-two');

$form .= form_input(array('name' => 'emailTwoAdd', 'id' => 'email-two',
    'maxlength' => '50', 'type' => 'text', 'value' => set_value('emailTwoAdd')));

$form .= form_fieldset_close();

$form .= form_fieldset('Give admin rights to the new user?');

$form .= form_label('Yes', 'admin-yes');

$form .= form_radio(array('name' => 'adminRightsAdd', 'id' => 'admin-yes',
    'value' => 'YES', 'checked' => (isset($_POST['adminRightsAdd']) && $_POST['adminRightsAdd'] ==
    "YES") ? 'checked' : ''));

$form .= form_label('No', 'admin-no');

$form .= form_radio(array('name' => 'adminRightsAdd', 'id' => 'admin-no',
    'value' => 'NO', 'checked' => (isset($_POST['adminRightsAdd']) && $_POST['adminRightsAdd'] ==
    "NO") ? 'checked' : ''));

$form .= form_fieldset_close();

$form .= form_submit('submitAdd', 'submit');

$form .= form_close();

echo $form;

?>

<h2>Edit the user details below</h2>

<?php

foreach ($query as $user) {
    
    $username = 'usernameOne' . $user->id;
    $email = 'emailEditOne' . $user->id;
    $emailTwo = 'emailEditTwo' . $user->id;
    $passwordOne = 'passwordOne' . $user->id;
    $passwordTwo = 'passwordTwo' . $user->id;
    $admin = 'adminRights' . $user->id;
    $id = 'hidden' . $user->id;
    $submit = 'submit' . $user->id;
    $delete = 'delete' . $user->id;
    $username = 'usernameOne' . $user->id;
    $finalDelete = 'finalDelete' . $user->id;
    $orig_name = 'hidden' . '00' . $user->id;
    $orig_email = 'hidden' . 'email' . $user->id;
    

    $form = '<div id="user-block-result-' . $user->id . '">';
    
    if(isset($finalDelete)) {
        
    $attributesD = array('id' => "delete-menu", 'name' => "deleteMenu");
        
    $form .= form_open_multipart('admin_user/delete_user', $attributesD);
    
    $form .= form_fieldset('Are you sure you want to delete this menu item? It will not be possible to undo this action.');
    
    $form .= form_hidden('delete_this', $finalDelete);

    $form .= form_submit('deleteFinal', 'delete');

    $form .= form_fieldset_close();

    $form .= form_close();
    
    }
    
    
    
    $form .= isset($error) && isset($_POST[$submit])? $error: null;
    
    $form .= isset($success) && isset($_POST[$submit])? $success: null;
  
    $form .= isset($_POST[$submit])? validation_errors(): null;

    $form .= '</div>';
    
    $form .= '<div id="user-block-' . $user->id  . '">';

    $form .= '<div class="username">' . $user->username . '</div>';

    $attributes = array('id' => "admin-add-user-{$user->id}", 'name' =>
        "adminAddUser", 'method' => 'post');

    $form .= form_open_multipart('admin_user/edit_users#user-block-result-' . $user->id, $attributes);

    $form .= form_fieldset('Edit ' . $user->username);

    $form .= form_label('Edit ' . $user->username, 'username' . $user->id);

    $form .= form_input(array('name' => $username, 'id' => 'username' . $user->id,
        'maxlength' => '30', 'type' => 'text', 'value' =>  isset($_POST["$username"]) ? $_POST["$username"] : $user->username));
        
    $form .= form_label('Email:', 'email-' . $user->id);

    $form .= form_input(array('name' => "$email", 'id' => 'email-' . $user->id,
        'maxlength' => '50', 'type' => 'text', 'value' => isset($_POST["$email"]) ? $_POST["$email"] : $user->email));
        
    $form .= form_label('Email again:', 'email-two-' . $user->id);

    $form .= form_input(array('name' => "$emailTwo", 'id' => 'email-two-' . $user->id,
        'maxlength' => '50', 'type' => 'text', 'value' => isset($_POST["$emailTwo"]) ? $_POST["$emailTwo"] : $user->email));
        
    $form .= form_label('Password:', 'password-one-' . $user->id);

    $form .= form_input(array('name' => "$passwordOne", 'id' => 'password-one-' . $user->
        id, 'maxlength' => '40', 'type' => 'text', 'value' => set_value("$passwordOne")));
    
    $form .= form_label('Password again:', 'password-two-' . $user->id);

    $form .= form_input(array('name' => "$passwordTwo", 'id' => 'password-two-' . $user->
        id, 'maxlength' => '40', 'type' => 'text', 'value' => set_value("$passwordTwo")));

    $form .= form_label('Admin rights:', 'admin-yes-' . $user->id);

    $form .= form_radio(array('name' => "$admin", 'id' => 'admin-yes-' . $user->
        id, 'value' => 'YES', 'checked' => $user->admin_rights == 1 || (isset($_POST["$admin"]) &&
        $_POST["$admin"] == "YES") ? 'checked' : ''));

    $form .= form_label('No admin rights', 'admin-yes-' . $user->id);

    $form .= form_radio(array('name' => "$admin", 'id' => 'admin-no-' . $user->
        id, 'value' => 'NO', 'checked' => $user->admin_rights == 0 || (isset($_POST["$admin"]) &&
        $_POST["$admin"] == "NO") ? 'checked' : ''));
        
    $form .= form_submit("$delete", 'delete');
    
    $form .= form_submit("$submit", 'submit');
    
    $form .= form_hidden("$id", $user->id);
    
    $form .= form_hidden("$orig_name", $user->username);
    
    $form .= form_hidden("$orig_email", $user->email);

    $form .= form_fieldset_close();

    $form .= form_close();
    
    $form .= '</div>';

    echo $form;

}

?>

</div>

</section>
<!-- End column one -->

<section  id="column-two">

</section><!-- End column two -->

<section id="column-three">

</section><!-- End column three -->

</div><!-- End content -->