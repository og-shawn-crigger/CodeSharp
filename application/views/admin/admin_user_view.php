<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

?>

<div id="wrapper" class="admin">
<header class="clearfix">
  <h1><?php

echo SITENAME;

?> / admin</h1>
</header>
<!-- End header -->
<div id="content" class="clearfix">
  <header> <?php

echo top_admin_menu();
// function to be found in admin_top_menu_helper


?></header>
  <section id="column-one"> <?php

echo admin_menu();
// above is a helper - admin_menu_helper


?> </section>
  <!-- End column one -->
  <section id="column-two">
    <section id="inner-column-one">
      <section id="admin-add-user">
        <h1>Add a new user</h1>
        <?php

if (isset($_POST['submitAdd'])) {

    if (isset($success_error)) {

        echo $success_error;

    }

    echo validation_errors();

}

$attributes = array('id' => "add-user", 'name' => "addUser");

$form = form_open('admin-user/add-user', $attributes);

$form .= form_fieldset('<span>Add user</span>');

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

$form .= form_fieldset('<span>Give admin rights to the new user?</span>');

$form .= form_hidden('adminRightsAdd', '0');

$form .= form_label('Yes:', 'admin-yes');

$form .= form_checkbox(array('name' => 'adminRightsAdd', 'id' => 'admin-yes',
    'checked' => isset($_POST['adminRightsAdd']) ? $_POST['adminRightsAdd'] : null,
    'value' => "1"));

$form .= form_fieldset_close();

$form .= form_submit('submitAdd', 'submit');

$form .= form_close();

echo $form;

?>
      </section>
      <!-- admin-add-user -->
    </section>
    <!-- end inner column one-->
    <section id="inner-column-two">
      <section id="edit-users">
        <h1>Edit the user details below</h1>
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


    $form = '<div id="user-block-result-' . $user->id . '" style="clear:both">';

    if (isset($delete_now) && isset($_POST[$delete])) {

        $attributesD = array('id' => "delete-menu", 'name' => "deleteMenu");

        $form .= form_open('admin-user/delete-user', $attributesD);

        $form .= form_fieldset('<span>Are you sure you want to delete this menu item? It will not be possible to undo this action.</span>');

        $form .= form_hidden('delete_this', $finalDelete);

        $form .= form_submit('deleteFinal', 'delete');

        $form .= form_fieldset_close();

        $form .= form_close();

    }

    $form .= isset($error) && isset($_POST[$submit]) ? $error : null;

    $form .= isset($success) && isset($_POST[$submit]) ? $success : null;

    $form .= isset($_POST[$submit]) ? validation_errors() : null;

    $form .= '</div>';

    $form .= '<div id="user-block-' . $user->id . '">';

    $form .= '<div class="username">' . $user->username . '</div>';

    $attributes = array('id' => "admin-add-user-{$user->id}", 'name' =>
        "adminAddUser{$user->id}", 'method' => 'post');

    $form .= form_open('admin-user/edit-users#user-block-result-' . $user->
        id, $attributes);

    $form .= form_fieldset('<span>Edit ' . $user->username . '</span>');

    $form .= form_label('Edit ' . $user->username, 'username' . $user->id);

    $form .= form_input(array('name' => $username, 'id' => 'username' . $user->id,
        'maxlength' => '30', 'type' => 'text', 'value' => isset($_POST["$username"]) ? $_POST["$username"] :
        $user->username));

    $form .= form_label('Email:', 'email-' . $user->id);

    $form .= form_input(array('name' => "$email", 'id' => 'email-' . $user->id,
        'maxlength' => '50', 'type' => 'text', 'value' => isset($_POST["$email"]) ? $_POST["$email"] :
        $user->email));

    $form .= form_label('Email again:', 'email-two-' . $user->id);

    $form .= form_input(array('name' => "$emailTwo", 'id' => 'email-two-' . $user->
        id, 'maxlength' => '50', 'type' => 'text', 'value' => isset($_POST["$emailTwo"]) ?
        $_POST["$emailTwo"] : $user->email));

    $form .= form_label('Password:', 'password-one-' . $user->id);

    $form .= form_input(array('name' => "$passwordOne", 'id' => 'password-one-' . $user->
        id, 'maxlength' => '40', 'type' => 'text', 'value' => set_value("$passwordOne")));

    $form .= form_label('Password again:', 'password-two-' . $user->id);

    $form .= form_input(array('name' => "$passwordTwo", 'id' => 'password-two-' . $user->
        id, 'maxlength' => '40', 'type' => 'text', 'value' => set_value("$passwordTwo")));

    $form .= form_label('Admin rights:', 'admin-yes-' . $user->id);

    $form .= form_hidden($admin, '0');

    $form .= form_label('Yes:', 'admin-yes');

    $form .= form_checkbox(array('name' => $admin, 'id' => 'admin-yes-' . $user->id,
        'checked' => isset($_POST["$admin"]) ? $_POST["$admin"] : $user->admin_rights ==
        1, 'value' => "1"));

    $form .= form_submit("$delete", 'delete');

    $form .= form_submit("$submit", 'submit');

    $form .= form_hidden("$id", $user->id);

    $form .= form_hidden("$orig_name", $user->username);

    $form .= form_hidden("$orig_email", $user->email);

    $form .= form_fieldset_close();

    $form .= form_close();

    $form .= '</div>';

    echo $form;
    
    $json[] = array('id' => $user->id);

}
create_json('user', $json);
?>
      </section>
      <!-- End edit users -->
    </section>
    <!-- End inner column two -->
  </section>
  <!-- End column two-->
</div>
<!-- End content -->
