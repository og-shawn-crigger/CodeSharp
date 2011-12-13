<?php

/**
 * @author Andy Walpole
 * @date 9/10/2011
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
  <section id="column-one"> 
 <?php

echo admin_menu();
// above is a helper - admin_menu_helper


?>
  </section>
  <!-- End column one -->
  <section id="column-two">
    <section id="inner-column-one">
      <section id="add-menu">
        <?php

if (isset($_POST['deleteFinal'])) {

    if (isset($success)) {

        echo $success;

    }

}

if (isset($_POST['submit'])) {

    if (isset($error)) {

        echo $error;

    }

    if (isset($success)) {

        echo $success;

    }

    echo validation_errors();

}


$attributes = array('id' => "addMenu", 'name' => "addMenu");

$form = form_open('admin-menu/menu-add', $attributes);

$form .= form_fieldset('<span>Add a new menu item</span>');

$form .= form_label('Name:', 'name-add');

$form .= form_input(array('name' => 'nameAdd', 'id' => 'name-add', 'maxlength' =>
    '40', 'type' => 'text', 'value' => isset($_POST['nameAdd']) ? $_POST['nameAdd'] : null));

$form .= form_label('URL:', 'url-add');

$form .= form_input(array('name' => 'urlAdd', 'id' => 'url-add', 'maxlength' =>
    '100', 'type' => 'text', 'value' => set_value('urlAdd')));

$form .= form_label('Publish', 'publish');

$form .= form_hidden('publishAdd', '0');

$form .= form_checkbox(array('name' => 'publishAdd', 'id' => 'publish',
    'checked' => (isset($_POST["publishAdd"]) && $_POST["publishAdd"] == "1"),
    'value' => "1"));

$form .= form_submit("submit", "submit");

$form .= form_fieldset_close();

$form .= form_close();

echo $form;

?>
      </section>
      <!-- end add-menu -->
      <hr />
      <section id="add-categories">
        <p>Add a new menu item, edit an existing one or reorder the menu as it appears to the public.</p>
          <p>Also decide whether you would like to include categories in the main public menu</p>
          
          <div id="categories-result">
        <?php

if (isset($_POST['submitCat'])) {

    if (isset($success_failure)) {

        echo $success_failure;

    }

    echo validation_errors();

}

echo '</div>';

$attributes = array('id' => "addCategories", 'name' => "addCategories");

$form = form_open('admin-menu/add-categories-to-menu#categories-result', $attributes);

$form .= form_fieldset('<span>Add categories to the menus?</span>');

$form .= form_label('Yes', 'yes-categories');

$form .= form_hidden('categoriesAdd', '0');

$form .= form_checkbox(array('name' => 'categoriesAdd', 'id' => 'yes-categories', 
'checked' => isset($_POST["categoriesAdd"]) ? $_POST["categoriesAdd"] : $cat_menu_result->
    okay == 1, 'value' => "1"));

$form .= form_submit("submitCat", "submit");

$form .= form_fieldset_close();

$form .= form_close();

echo $form;

?>
      </section>
      <!-- end add-categories -->
      <hr />
      <section id="rearrange-menu">
        <h1>Rearrange the order of the main menu</h1>
        
        <div id="menu-order-result">
        <?php

if (isset($_POST['submitMenu'])) {

    if (isset($success_fail)) {

        echo $success_fail;

    }

}

?>
</div>
        <form id="menu-order" name="menuOrder" method="post" action="<?php

echo site_url("admin-menu/change-menu-order#menu-order-result");

?>">
          <fieldset>
          <legend><span>Change the number from 99 to 0. <br>
          The higher the number the higher it appears in the menu order</span></legend>
          <?php

/**
 *  VALUE FOR ARRAY IN INPUT FORM NOT STICKING AFTER ERROR AND FORM RELOAD - WHY?!
 */

$a = 1;
$b = 1;

foreach ($admin_menu_order as $menuItem) {

    $menuInput = 'menu[' . $a++ . ']';

    $menuFormControl = 'menu' . $b++;

    $result = '<label for="' . $menuFormControl . '">' . $menuItem['name'] .
        '</label>';

    $result .= '<input type="text" id="' . $menuFormControl . '" name="' . 'menu[' .
        $a++ . ']' . '" value="';

    $result .= isset($_POST['menu[' . $a++ . ']']) ? $_POST['menu[' . $a++ . ']'] :
        $menuItem['number'];

    $result .= '" maxlength="2" />';

    $result .= '<input type="hidden" name="hidden_menu_id[' . $a++ . ']" value="' .
        $menuItem['menu_id'] . '">';

    $result .= '<input type="hidden" name="hidden_menu_name[' . $a++ . ']" value="' .
        $menuItem['name'] . '">';

    echo $result;

}

?>
          <input name="submitMenu" value="submit" type="submit">
          </fieldset>
        </form>
      </section>
      <!-- rearrange-menu-->
    </section>
    <!-- end inner column one -->
    <section id="inner-column-two">
      <section id="edit-menu">
        <h1>Leave URL empty for link to home page</h1>
        <?php

foreach ($display_menu as $menu_page) {

    $id = $menu_page->id;

    // Set variables
    $submit = 'submit' . $id;
    $menu_name = 'menuName' . $id;
    $url = 'menuUrl' . $id;
    $publish = 'menuPublish' . $id;
    $orig_name = 'hidden' . '00' . $id;
    $delete = 'delete' . $id;
    $finalDelete = 'finalDelete' . $id;
    $id_item = 'hidden' . $id;
    $menu_number = 'menuOrder' . $id;

    // Create this block for the form action value
    echo '<div id="menu-block-result-' . $id . '">';

    if (isset($_POST["submit$id"])) {

        if (isset($success_error)) {

            echo $success_error;

            echo validation_errors();

        } //

    }


    if (isset($_POST[$delete])) {

        $attributesD = array('id' => "delete-menu_item", 'name' => "deleteMenuItem");

        $Dform = form_open_multipart('admin-menu/delete-menu', $attributesD);

        $Dform .= form_fieldset('<span>Are you sure you want to delete this menu item? <br />It will not be possible to undo this action.</span>');

        $Dform .= form_hidden('delete_this', $id);

        $Dform .= form_submit('deleteFinal', 'delete');

        $Dform .= form_fieldset_close();

        $Dform .= form_close();

        echo $Dform;

    }


    echo '</div>';

    /**
     * CHANGE THIS FORM TO THE CODEIGNITER HTML HELPER FOR THE SAKE OF CONSISTENCY
     */

    $form = '<div id="menu-block-full-' . $id . '" class="full-block">';

    $form .= '<div id="menu-block-result' . $id . '">';

    $form .= '<div class="menuname">';

    $form .= $menu_page->name;

    $form .= '</div>';

    $form .= '<form id="admin-add-menu-';

    $form .= $id;

    $form .= '" ';

    $form .= 'name="adminAddMenu';

    $form .= $id;

    $form .= '" ';

    $form .= 'method="post" action="';

    $form .= site_url("admin-menu/update-menu#menu-block-result-") . $id;

    $form .= '">';

    $form .= '<fieldset class="fieldset-hidden">';

    $form .= '<legend id="legend' . $id . '"><span>Edit:' . $menu_page->name .
        '</span></legend>';

    // Username form field

    $form .= '<label for="' . $menu_name . '">Edit ' . 'Menu name:' . '</label>';

    $form .= '<input type="text" maxlength="40" name="' . $menu_name . '" id="' . $menu_name .
        '" value="';

    $form .= isset($_POST[$menu_name]) ? $_POST[$menu_name] : $menu_page->name;

    $form .= '" />';

    // URL

    $form .= '<label for="' . $url . '">Edit ' . 'URL:' . '</label>';

    $form .= '<input type="text" maxlength="40" name="' . $url . '" id="' . $url .
        '" value="';

    $form .= isset($_POST[$url]) ? $_POST[$url] : $menu_page->url;

    $form .= '" />';

    // Publication settings settings

    $form .= '<label for="publishYes' . $id . '">Publish?</label>';

    $form .= form_hidden($publish, '0');

    $form .= form_checkbox(array('name' => $publish, 'id' => 'publishYes' . $id,
        'checked' => isset($_POST["$publish"]) ? $_POST["$publish"] : $menu_page->
        visible == 1, 'value' => "1"));


    // Delete button

    $form .= '<input type="submit" name="delete';

    $form .= $id . '" value="delete" />';

    // Submit button

    $form .= '<input type="submit" name="submit';

    $form .= $id . '" value="submit" />';

    // Hidden buttons

    $form .= '<input type="hidden" name="hidden';

    $form .= $id . '" value="';

    $form .= $id;

    $form .= '" />';

    $form .= '<input type="hidden" name="';

    $form .= $orig_name . '" value="';

    $form .= $menu_page->name;

    $form .= '" />';

    $form .= '</fieldset>';

    $form .= '</form>';

    $form .= '</div>';

    $form .= '</div>';

    echo $form;
    
    $json[] = array('id' => $id, 'name' => $menu_page->name);

}

create_json('menu', $json);

?>
      </section>
      <!-- End edit-meny -->
    </section>
    <!-- End inner column two -->
  </section>
  <!-- End column two -->
</div>
<!-- End content -->
