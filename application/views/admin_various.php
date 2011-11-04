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

<h1>List of added articles. Click on link to edit</h1>

<div id="admin-various">

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


$form .= form_fieldset('Use meta descriptions:');

$form .= form_hidden('metaDescription','0');

$form .= form_checkbox(array('name' => 'metaDescription', 'id' => 'meta-description','checked' => 
isset($_POST['metaDescription'])? $_POST['metaDescription'] : DESCRIPTION, 'value' => "1"
));

$form .= form_fieldset_close();

$form .= form_fieldset('Use meta keywords:');

$form .= form_hidden('metaKeywords','0');

$form .= form_checkbox(array('name' => 'metaKeywords', 'id' => 'meta-keywords','checked' => 
isset($_POST['metaKeywords'])? $_POST['metaKeywords'] : KEYWORDS, 'value' => "1"
));

$form .= form_fieldset_close();

?>

<!-- the level of error reporting -->

<?php

$form .= form_fieldset("Report errors to logs: ");

$form .= form_label('Error reporting', 'report-error');

$form .= form_hidden('errorReporting','0');

$form .= form_checkbox(array('name' => 'errorReporting', 'id' => 'report-error','checked' => 
isset($_POST['errorReporting'])? $_POST['errorReporting'] : ERROR_REPORTING, 'value' => "1"
));

$form .= form_fieldset_close();

$form .= form_fieldset("Change error reporting levels here");

$options = array('2' => 'All', '1' => 'Most', '0' => 'None');

$form .= form_dropdown('errorLevel', $options, (isset($_POST['errorLevel']) ? $_POST['errorLevel'] :
    ERROR_LEVEL), 'id="error-level"');

$form .= form_fieldset_close();

$form .= form_fieldset("Send email message to admin when error produced");

$form .= form_label('Error email', 'email-error');

$form .= form_hidden('errorEmail','0');

$form .= form_checkbox(array('name' => 'errorEmail', 'id' => 'meta-keywords','checked' => 
isset($_POST['errorEmail'])? $_POST['errorEmail'] : ERROR_EMAIL, 'value' => "1"
));

$form .= form_fieldset_close();

$form .= form_submit("submit", "submit");

$form .= form_close();

echo $form;

?>

</div>




</section>
<!-- End column one -->

<section  id="column-two">


</section><!-- End column two -->

<section id="column-three">



</section><!-- End column three -->



</div><!-- End content -->