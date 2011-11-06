<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

?>
<div id="wrapper">
<header class="clearfix">
  <h1><?php echo SITENAME; ?> / admin</h1>
</header>
<!-- End header -->
<div id="content" class="clearfix">
  <header> <a href="admin-config">Global Settings</a> / <a href="login/letmeout">Logout</a> </header>
  <section id="column-one"> <?php echo admin_menu();
 // above is a helper - admin_menu_helper
 ?></section>
  <!-- End column one -->
  <section id="column-two">
    <section id="admin-various">
      <h1>Explanation here</h1>
      <?php

//echo $_POST['metaDescription'];

if (isset($error_success)) {

    echo $error_success;
    
    echo validation_errors();
    
}

?>
      <!-- Change the name of the site -->
      <?php


$attributes = array('id' => "submit-various", 'name' => "submitVarious");

$form = form_open('admin-config/submit-form', $attributes);

$form .= form_fieldset();

$form .= form_label('Name of site:', 'name-form');

$form .= form_input(array('name' => 'nameForm', 'id' => 'name-form', 'maxlength' =>
    '100', 'type' => 'text', 'value' => isset($_POST['nameForm']) ? $_POST['nameForm'] :
    SITENAME));

$form .= form_fieldset_close();

?>
      <!-- Change the slogan of the site -->
      <?php

$form .= form_fieldset();

$form .= form_label('Slogan:', 'slogan-form');

$form .= form_input(array('name' => 'sloganForm', 'id' => 'slogan-form',
    'maxlength' => '250', 'type' => 'text', 'value' => isset($_POST['sloganForm']) ?
    $_POST['sloganForm'] : SLOGAN));

$form .= form_fieldset_close();

?>
      <!-- Central email address -->
      <?php

$form .= form_fieldset();

$form .= form_label('Email:', 'email-form');

$form .= form_input(array('name' => 'emailForm', 'id' => 'email-form',
    'maxlength' => '50', 'type' => 'text', 'value' => isset($_POST['emailForm']) ? $_POST['emailForm'] :
    EMAIL));

$form .= form_fieldset_close();

?>
      <!-- declare whether the user wants meta description tags -->
      <!-- declare whether the user wants meta keywords tags -->
      <?php


$form .= form_fieldset('');

$form .= form_hidden('metaDescription','0');

$form .= form_label('Use meta descriptions:','meta-description');

$form .= form_checkbox(array('name' => 'metaDescription', 'id' => 'meta-description','checked' => 
isset($_POST['metaDescription'])? $_POST['metaDescription'] : DESCRIPTION, 'value' => "1"
));

$form .= form_fieldset_close();

$form .= form_fieldset('');

$form .= form_hidden('metaKeywords','0');

$form .= form_label('Use meta keywords:', 'meta-keywords');

$form .= form_checkbox(array('name' => 'metaKeywords', 'id' => 'meta-keywords','checked' => 
isset($_POST['metaKeywords'])? $_POST['metaKeywords'] : KEYWORDS, 'value' => "1"
));

$form .= form_fieldset_close();

?>
      <!-- the level of error reporting -->
      <?php

$form .= form_fieldset("<span>Report errors to logs: </span>");

$form .= form_label('Error reporting', 'report-error');

$form .= form_hidden('errorReporting','0');

$form .= form_checkbox(array('name' => 'errorReporting', 'id' => 'report-error','checked' => 
isset($_POST['errorReporting'])? $_POST['errorReporting'] : ERROR_REPORTING, 'value' => "1"
));

$form .= form_fieldset_close();

$form .= form_fieldset("");

$form .= form_label('Change error reporting levels here:', 'error-level');

$options = array('2' => 'All', '1' => 'Most', '0' => 'None');

$form .= form_dropdown('errorLevel', $options, (isset($_POST['errorLevel']) ? $_POST['errorLevel'] :
    ERROR_LEVEL), 'id="error-level"');

$form .= form_fieldset_close();

$form .= form_fieldset("<span>Send email message to admin when error produced</span>");

$form .= form_label('Error email', 'email-error');

$form .= form_hidden('errorEmail','0');

$form .= form_checkbox(array('name' => 'errorEmail', 'id' => 'email-error','checked' => 
isset($_POST['errorEmail'])? $_POST['errorEmail'] : ERROR_EMAIL, 'value' => "1"
));

$form .= form_fieldset_close();

$form .= form_submit("submit", "submit");

$form .= form_close();

echo $form;

?>
    </section>
    <!-- End admin-various -->
  </section>
  <!-- End column two -->
</div>
<!-- End content -->
