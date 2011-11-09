<div id="wrapper">

<header class="clearfix">

<h1>Pinhead CMS CodeIgnitor Version</h1>

</header><!-- End header -->

<div id="content" class="clearfix">

<section id="column-one">


<?php

/**
 * BELOW IS FOR DISPLAYING THE MENU
 */

?>

<menu>
<ul>
<?php

//var_dump($menu);


foreach ($menu as $main_menu) {

    $main_front = '<li>';

    $main_front .= '<a href="';

    if ($main_menu['menu_id'] === "C") {

        $main_front .= site_url('category/' . url_title(strtolower($main_menu['name'])));

    }

    if ($main_menu['menu_id'] === "M") {

        /**
         * LOOK AT BELOW - REMOVE DIRECT CALL TO DATABASE MODEL
         */

        $menu_url = $this->menu_model->menu_url($main_menu['id']);

        if ($menu_url->url !== "") {

            $main_front .= site_url($menu_url->url);


        } else {

            $main_front .= site_url();

        }


    }

    $main_front .= '">';

    $main_front .= $main_menu['name'];

    $main_front .= '</a>';

    $main_front .= '</li>';

    echo $main_front;

}

?>

</ul>
</menu>


</section>
<!-- End column one -->

<section id="column-two">

<section id="contact-form">

<?php

if (isset($error_success)) {

    echo $error_success;

    echo validation_errors();

}

?>

	<?php

$attributes = array('id' => "contact-us", 'name' => "contactUs");

$form = form_open('contactus/mail', $attributes);

$form .= form_fieldset('<span>You can contact us through the form below - * required</span>');

$form .= form_label('Your name', 'contact-name');

$form .= form_input(array('name' => 'contactName', 'id' => 'contact-name',
    'maxlength' => '100', 'type' => 'text', 'value' => form_prep(set_value('contactName'))));

$form .= form_label('Your email address', 'contact-email');

$form .= form_input(array('name' => 'contactEmail', 'id' => 'contact-email',
    'maxlength' => '100', 'type' => 'text', 'value' => form_prep(set_value('contactEmail'))));

$form .= form_label("Your phone number", 'contact-number');

$form .= form_input(array('name' => 'contactNumber', 'id' => 'contact-number',
    'maxlength' => '100', 'type' => 'text', 'value' => form_prep(set_value('contactNumber'))));

$form .= form_label('Your message here', 'contact-details');

$form .= form_textarea(array('name' => 'contactDetails', 'id' =>
    'contact-details', 'value' => form_prep(set_value('contactDetails'))));

$form .= '<span class="zipcode">';

$form .= form_label("Please leave this field empty", 'zipcode');

$form .= form_input(array('name' => 'zipcode', 'id' => 'zipcode', 'maxlength' =>
    '100', 'type' => 'text'));

$form .= '</span>';

$form .= form_submit('submit', 'submit');

$form .= form_fieldset_close();

$form .= form_close();

echo $form;

?>


</section>

</section><!-- End column two -->

</div><!-- End content -->

