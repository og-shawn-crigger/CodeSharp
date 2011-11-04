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

<h1>Admin section</h1>

<div id="admin-add-content-result">

<?php

if (isset($success_fail)) {

    echo $success_fail;

}



if (isset($file_error)) {

    echo $file_error;

}

echo validation_errors();

$attributes = array('id' => "admin-add-content", 'name' => "adminAddContent");

$form = form_open_multipart('admin-content/admin-add-content', $attributes);

$form .= form_fieldset('Add content');

$form .= form_label('Title', 'title');

$form .= form_input(array('name' => 'title', 'id' => 'title', 'maxlength' =>
    '100', 'type' => 'text', 'value' => form_prep(set_value('title'))));

$form .= form_label('Please pick a category', 'category');

// $full_cats is the associative array created in the model
$form .= form_dropdown('select', $full_cats, '0', 'id="category"');

$form .= form_label('Add content', 'body');

$form .= form_textarea(array('name' => 'body', 'id' => 'body', 'value' =>
    form_prep(set_value('body'))));

if (DESCRIPTION === "1") {

    $form .= form_label('Meta description', 'meta-description');

    $form .= form_textarea(array('name' => 'metaDescription', 'id' =>
        'meta-description', 'value' => form_prep(set_value('metaDescription')),
        'maxlength' => '255'));

}

if (KEYWORDS === "1") {

    $form .= form_label('Meta keywords', 'meta-keywords');

    $form .= form_textarea(array('name' => 'metaKeywords', 'id' => 'meta-keywords',
        'value' => form_prep(set_value('metaKeywords')), 'maxlength' => '255'));

}

$form .= form_fieldset_close();

$form .= form_fieldset('Upload file');

$form .= form_label('Add image', 'file_upload');

$form .= '<input type="file" name="file_upload" id="file_upload" />';

$form .= form_fieldset_close();

$form .= form_fieldset('Published?');

$form .= form_label('Publish', 'publish');

$form .= form_radio(array('name' => 'publish', 'id' => 'publish', 'value' =>
    'YES', 'checked' => (isset($_POST['publish']) && $_POST['publish'] == "YES") ?
    'checked' : ''));

$form .= form_label('Not publish', 'not-publish');

$form .= form_radio(array('name' => 'publish', 'id' => 'not-publish', 'value' =>
    'NO', 'checked' => (isset($_POST['publish']) && $_POST['publish'] == "NO") ?
    'checked' : ''));

$form .= form_fieldset_close();

$form .= form_submit('submit', 'submit');

$form .= form_close();

echo $form;

?>

</div><!-- end admin-add-content-result -->

</section>
<!-- End column one -->

<section  id="column-two">


</section><!-- End column two -->

<section id="column-three">



</section><!-- End column three -->



</div><!-- End content -->