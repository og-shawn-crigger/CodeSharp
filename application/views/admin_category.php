<?php

/**
 * @author Andy Walpole
 * @date 29/9/2011
 * 
 */

?>

<div id="wrapper" class="admin">

<header class="clearfix">

<h1>Pinprick CMS - Admin</h1>

</header><!-- End header -->

<div id="content" class="clearfix">

<section  id="column-one">

<h1>Admin section</h1>

<?php

//echo $adCat->get_name();


?>

<div id="admin-add-content-result">
<h1>Add a menu item or edit an existing one below</h1>

<div id="admin-addCategories-category-result">

<?php

if (isset($success)) {

    echo $success;

    echo validation_errors();

}

if (isset($error)) {

    echo $error;

    echo validation_errors();

}

?>

</div><!-- End admin-add-category-result -->

<?php

$attributes = array('id' => "addCategory", 'name' => "addCategory");

$form = form_open_multipart('admin_category/add_category', $attributes);

$form .= form_fieldset('Add content');

$form .= form_label('Name:', 'nameAdd');

$form .= form_input(array('name' => 'nameAdd', 'id' => 'nameAdd', 'maxlength' =>
    '40', 'type' => 'text', 'value' => set_value('nameAdd')));

$form .= form_label('Publish', 'publish');

$form .= form_radio(array('name' => 'publishAdd', 'id' => 'publish', 'value' =>
    'YES', 'checked' => (isset($_POST['publishAdd']) && $_POST['publishAdd'] ==
    "YES") ? 'checked' : ''));

$form .= form_label('Not publish', 'not-publish');

$form .= form_radio(array('name' => 'publishAdd', 'id' => 'not-publish', 'value' =>
    'NO', 'checked' => (isset($_POST['publishAdd']) && $_POST['publishAdd'] == "NO") ?
    'checked' : ''));

$form .= form_fieldset_close();

$form .= form_submit('submit', 'submit');

$form .= form_close();

echo $form;

?>

<div></div>
<h2>Edit the categories below</h2>

<?php

foreach ($categories as $category) {

    $del_id = 'delete' . $category->id;
    $delete = 'deleteButton' . $category->id;
    $cat_id = 'submit' . $category->id;
    $hide_id = 'hidden' . $category->id;
    $orig_name = 'hidden' . '00' . $category->id;
    $publish = 'publish' . $category->id;
    $name = 'name' . $category->id;

    echo '<div id="category-block-result-' . $category->id . '" style="clear: both">';

    if (isset($_POST[$cat_id])) {

        if (isset($success_error)) {

            echo $success_error;

            echo validation_errors();

        }

    } // end isset


    if (isset($finalDelete)) {

        $attributes = array('id' => "delete-category", 'name' => "deleteCategory");

        $form = form_open_multipart('admin_category/delete_category', $attributes);

        $form .= form_fieldset('Are you sure you want to delete this category?');

        $form .= form_hidden('id', $finalDelete);

        $form .= form_submit('submit', 'delete');

        $form .= form_fieldset_close();

        $form .= form_close();

        //$form .= '<p></p><p></p>';

        echo $form;

    }


    echo '</div>';

    echo '<div id="category-block-' . $category->id . '">';

    echo '<div class="category-title">' . $category->name . '</div>';

    $form = '<div id="category-block-' . $category->id . '">';

    $form .= '<div class="category-title">';

    $form .= $category->name;

    $form .= '</div>';

    $attributes = array('id' => "admin-add-category-{$category->id}", 'name' =>
        "adminAddCategory{$category->id}");

    $form = form_open_multipart("admin_category/validate_cat#category-block-result-$category->id",
        $attributes);

    $fattributes = array('id' => "legend{$category->id}");

    $form .= form_fieldset("Edit: {$category->name}", $fattributes);

    $form .= form_label("Name: {$category->name}", $name);

    $form .= form_input(array('name' => $name, 'id' => $name, 'maxlength' => '40',
        'type' => 'text', 'value' => isset($_POST[$name]) ? $_POST[$name] : $category->
        name));

    $form .= form_label('Publish', $publish);

    $form .= form_radio(array('name' => $publish, 'id' => $publish, 'value' => 'YES',
        'class' => 'admin-top', 'checked' => $category->visible == 1 || (isset($_POST[$publish]) &&
        $_POST[$publish] == "YES") ? 'checked' : ''));

    $form .= form_label('Not publish', "not-" . $publish);

    $form .= form_radio(array('name' => $publish, 'id' => "not-{$publish}", 'value' =>
        'NO', 'class' => 'admin-top', 'checked' => $category->visible == 0 || (isset($_POST[$publish]) &&
        $_POST[$publish] == "NO") ? 'checked' : ''));

    $form .= form_fieldset_close();

    $form .= form_submit($del_id, 'delete');

    $form .= form_submit($cat_id, 'submit');

    $form .= form_hidden($hide_id, $category->id);

    $form .= form_hidden($orig_name, $category->name);

    $form .= form_close();

    echo $form;

    echo '</div>';


}

?>



</div><!-- end admin-add-content-result -->

</section>
<!-- End column one -->

<section  id="column-two">


</section><!-- End column two -->

<section id="column-three">



</section><!-- End column three -->



</div><!-- End content -->