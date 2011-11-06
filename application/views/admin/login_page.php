<?php

/**
 * @author Andy Walpole
 * @date 26/9/2011
 * 
 */

?>

<div id="wrapper">
<header class="clearfix">
  <h1><?php echo SITENAME; ?> / admin</h1>
</header>
<!-- End header -->
<div id="content" class="clearfix">
  <div id="admin-login-box">
    <h1>Login</h1>
    <?php 


if(isset($error_404)) {
    
    echo $error_404;
    
}

if(isset($new_password)) {
    
    echo $new_password;
    
}

?>
    <div id="login-result">
      <?php

if (isset($success_error) && isset($_POST['Rsubmit'])) {

    echo $success_error;

    echo validation_errors();

}

?>
    </div>
    <!-- end admin-add-content-result -->
    <?php

if (isset($new_userdetails)) {

    $attributes = array('id' => "newPassdord", 'name' => "newPassword",
        "autocomplete" => "off");

    $form = form_open('login/valdidate_forgotten_userdetails', $attributes);

    $form .= form_fieldset('<span>Enter your username or email address and then click submit. <br>We will then send you a new password.</spam>');

    $form .= form_label('Username or email address:', 'Rusername');

    $form .= form_input(array('name' => 'username', 'id' => 'Rusername', 'maxlength' =>
        '50', 'type' => 'text', 'value' => set_value('username')));

    $form .= form_fieldset_close();

    $form .= form_submit('Rsubmit', 'submit');

    $form .= form_close();

    echo $form;

}


if (isset($success_error) && isset($_POST['submit'])) {

    if (is_string($success_error)) {

        echo $success_error;

        echo validation_errors();

    }

}

$attributes = array('id' => "admin-login", 'name' => "adminLogin", 'style' =>
    "clear : both");

$form = form_open('login/letmein', $attributes);

$form .= form_fieldset('<span>Log in to the admin section</span>');

$form .= form_label('Username:', 'username');

$form .= form_input(array('name' => 'username', 'id' => 'username', 'maxlength' =>
    '30', 'type' => 'text', 'value' => set_value('username')));

$form .= form_label('Password:', 'password');

$form .= form_input(array('name' => 'password', 'id' => 'password', 'maxlength' =>
    '40', 'type' => 'password', 'value' => set_value('password')));

$form .= form_fieldset_close();

$form .= form_submit('submit', 'submit');

$form .= form_close();

echo $form;

?>
  </div>
  <!-- End admin login -->
</div>
<!-- End content -->
