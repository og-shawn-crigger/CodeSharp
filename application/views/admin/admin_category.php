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
  <header>  <?php

echo top_admin_menu();
// function to be found in admin_top_menu_helper


?> </header>
  <section  id="column-one"> <?php

echo admin_menu();
// above is a helper - admin_menu_helper


?> </section>
  <!-- End column one-->
  <section id="column-two">
    <section id="inner-column-one">
      <section id="add-category">
        <h1>Add a menu item or edit an existing one in the right hand column</h1>
        <?php

if (isset($_POST['submit'])) {

    if (isset($success_error)) {

        echo $success_error;

        echo validation_errors();

    }

}

?>
        <?php

$attributes = array('id' => "addCategory", 'name' => "addCategory");

$form = form_open_multipart('admin-category/add-category', $attributes);

$form .= form_fieldset('<span>Add content</span>');

$form .= form_label('Name:', 'nameAdd');

$form .= form_input(array('name' => 'nameAdd', 'id' => 'nameAdd', 'maxlength' =>
    '40', 'type' => 'text', 'value' => set_value('nameAdd')));

$form .= form_label('Publish', 'publish');

$form .= form_hidden('publishAdd', '0');

$form .= form_checkbox(array('name' => 'publishAdd', 'id' => 'publish',
    'checked' => isset($_POST['publishAdd']) ? $_POST['publishAdd'] : null, 'value' =>
    "1"));

$form .= form_fieldset_close();

$form .= form_submit('submit', 'submit');

$form .= form_close();

echo $form;

?>
      </section>
      <!-- end add category -->
    </section>
    <!-- end inner column one -->
    <section id="inner-column-two">
      <section id="edit-category">
        <h1>Edit the categories below</h1>
        <?php

foreach ($categories as $category) {

    $del_id = 'delete' . $category->id;
    $delete = 'deleteButton' . $category->id;
    $cat_id = 'submit' . $category->id;
    $hide_id = 'hidden' . $category->id;
    $orig_name = 'hidden' . '00' . $category->id;
    $publish = 'publish' . $category->id;
    $name = 'name' . $category->id;

    echo '<div id="category-block-result-' . $category->id .
        '" style="clear: both">';

    if (isset($_POST[$cat_id])) {

        if (isset($success_error)) {

            echo $success_error;

            echo validation_errors();

        }

    } // end isset


    if (isset($finalDelete)) {

        $attributes = array('id' => "delete-category", 'name' => "deleteCategory");

        $form = form_open_multipart('admin-category/delete-category', $attributes);

        $form .= form_fieldset('<span>Are you sure you want to delete this category?</span>');

        $form .= form_hidden('id', $finalDelete);

        $form .= form_submit('submit', 'delete');

        $form .= form_fieldset_close();

        $form .= form_close();

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

    $form = form_open_multipart("admin-category/validate-cat#category-block-result-$category->id",
        $attributes);

    $fattributes = array('id' => "legend{$category->id}");

    $form .= form_fieldset("<span>Edit: {$category->name}</span>", $fattributes);

    $form .= form_label("Name: {$category->name}", $name);

    $form .= form_input(array('name' => $name, 'id' => $name, 'maxlength' => '40',
        'type' => 'text', 'value' => isset($_POST[$name]) ? $_POST[$name] : $category->
        name));

    $form .= form_label('Publish', $publish);

    $form .= form_hidden($publish, '0');

    $form .= form_checkbox(array('name' => $publish, 'id' => $publish, 'checked' =>
        isset($_POST[$publish]) ? $_POST[$publish] : $category->visible, 'value' => "1"));

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
      </section>
      <!-- end edit category -->
    </section>
    <!-- end inner column two -->
  </section>
  <!-- End column two -->
</div>
<!-- End content -->
