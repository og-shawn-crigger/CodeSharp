<div id="wrapper">

<header class="clearfix">

<h1>Pinhead CMS CodeIgnitor Version</h1>

</header><!-- End header -->

<div id="content" class="clearfix">

<section id="column-one">

<?php

if (isset($error)) {

    echo $error;

}

if (isset($success)) {

    echo $success;

}

?>

	<?php

echo validation_errors();

$attributes = array('id' => "contact-us", 'name' => "contactUs");

$form = form_open('contactus/mail',$attributes);

$form .= form_fieldset('You can contact us through the form below - * required');

$form .= form_label('Your name', 'contact-name');

$form .= form_input(array('name' => 'contactName', 'id' => 'contact-name',
    'maxlength' => '100', 'type' => 'text', 'value' => set_value('contactName')));

$form .= form_label('Your email address', 'contact-email');

$form .= form_input(array('name' => 'contactEmail', 'id' => 'contact-email',
    'maxlength' => '100', 'type' => 'text', 'value' => set_value('contactEmail')));

$form .= form_label("Your phone number", 'contact-number');

$form .= form_input(array('name' => 'contactNumber', 'id' => 'contact-number',
    'maxlength' => '100', 'type' => 'text', 'value' => set_value('contactNumber')));

$form .= form_label('Your message here', 'contact-details');

$form .= form_textarea(array('name' => 'contactDetails', 'id' =>
    'contact-details', 'value' => set_value('contactDetails')));

$form .= '<span class="zipcode">';

$form .= form_label("Please leave this field empty", 'zipcode');

$form .= form_input(array('name' => 'zipcode', 'id' => 'zipcode',
    'maxlength' => '100', 'type' => 'text'));

$form .= '</span>';

$form .= form_submit('submit', 'submit');

$form .= form_fieldset_close(); 

$form .= form_close();

echo $form;

?>



</section>
<!-- End column one -->

<section id="column-two">

</section><!-- End column two -->

<section id="column-three">

</section><!-- End column three -->

</div><!-- End content -->

