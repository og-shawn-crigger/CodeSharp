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

<div id="admin-edit-content-result">


<?php




if (isset($_POST['submit'])) {

    if (isset($success_error)) {

        echo $success_error;

    }


    if (isset($file_error)) {

        echo $file_error;

    }

    echo validation_errors();

}


if (isset($_POST['submit']) && isset($delete_content)) {

    $attributesD = array('id' => "delete-node", 'name' => "deleteNode");

    $form = form_open('admin_edit_content/delete_content', $attributesD);

    $form .= form_fieldset('Are you sure you want to delete this content item? <br />
    It will not be possible to undo this action.');

    $form .= form_hidden('delete_this', $this->uri->segment(3));

    $form .= form_submit('deleteFinal', 'delete');

    $form .= form_fieldset_close();

    $form .= form_close();

    echo $form;

}

if (isset($edit)):

?>

<?php

    foreach ($edit as $row) {

        $attributes = array('id' => "admin-edit-content", 'name' => "adminEditContent");

        $form = form_open_multipart('admin_edit_content/edit_node/' . $this->uri->
            segment(3) . '/submit', $attributes);

        $form .= form_fieldset('Edit article: ');

        $form .= form_label('Title:', 'title');

        $form .= form_input(array('name' => 'title', 'id' => 'title', 'maxlength' =>
            '100', 'type' => 'text', 'value' => isset($_POST["title"]) ? $_POST["title"] : $row->
            title));

        $form .= form_label('Date:', 'date');

        $form .= form_input(array('name' => 'date', 'id' => 'date', 'type' => 'text',
            'value' => isset($_POST["date"]) ? $_POST["date"] : $row->date));

        $form .= form_label('Please pick a category', 'category');

        // $full_cats is the associative array created in the model
        $form .= form_dropdown('select', $full_cats, $row->category_id, 'id="category"');

        $form .= form_label('Body text:', 'body');

        $form .= form_textarea(array('name' => 'body', 'id' => 'body', 'value' => isset
            ($_POST["body"]) ? $_POST["body"] : $row->body));

        $form .= '<p>Current image:</p>';
        
        $form .= '<img src="' . base_url() . 'images/thumbnail/' . $row->image_id . '" />';

        $form .= form_hidden('orig_name', $row->image_id);

        $form .= form_label('Add image', 'file_upload');

        $form .= '<input type="file" name="file_upload" id="file_upload" />';

        $form .= form_label('Meta description', 'meta-description');

        $form .= form_textarea(array('name' => 'metaDescription', 'id' =>
            'meta-description', 'value' => isset($_POST["metaDescription"]) ? $_POST["metaDescription"] :
            $row->meta_description, 'maxlength' => '255'));

        $form .= form_fieldset_close();

        $form .= form_fieldset('Author: ');

        $form .= form_label('Change author here: ', 'content-author');

        // $full_cats is the associative array created in the model
        $form .= form_dropdown('contentAuthor', $full_users, $row->user_id,
            'id="content-author"');

        $form .= form_fieldset_close();

        $form .= form_fieldset('Published?');

        $form .= form_label('Publish', 'publish');

        $form .= form_radio(array('name' => 'publish', 'id' => 'publish', 'value' =>
            'YES', 'checked' => $row->visible == 1 || (isset($_POST["publish"]) && $_POST["publish"] ==
            "YES") ? 'checked' : ''));

        $form .= form_label('Not publish', 'not-publish');

        $form .= form_radio(array('name' => 'publish', 'id' => 'not-publish', 'value' =>
            'NO', 'checked' => $row->visible == 0 || (isset($_POST["publish"]) && $_POST["publish"] ==
            "NO") ? 'checked' : ''));

        $form .= form_fieldset_close();

        $form .= form_fieldset('Update or delete');

        $form .= form_submit("submit", "delete");

        $form .= form_submit("submit", "submit");

        $form .= form_fieldset_close();

        $form .= form_close();

        echo $form;

    }

?>
   
<?php

endif;

?>


<?php

if (empty($edit) && isset($nodes_all)) {

    echo '<ul>';

    foreach ($nodes_all as $node) {

        $list = '<li>';

        $list .= '<a href="' . base_url() . 'index.php/admin_edit_content/edit_node/' .
            $node->id . '">';

        $list .= $node->title;

        $list .= '<br />';

        $list .= 'Date published: ';

        $list .= strftime("%M:%H %B %d, %Y", strtotime(strip_tags($node->date)));

        $list .= '<br />';

        $list .= 'Author: ';

        foreach ($cats as $row) {

            if ($row->id === $node->user_id) {

                $list .= $row->username;

            }

        }

        $list .= '</li>';

        echo $list;

    }

    echo '</ul>';

}

?>

<?php

?>

</div>


<?php

echo '<div id="pagination">';
echo $this->pagination->create_links();
echo '</div>';

?>

</section>
<!-- End column one -->

<section  id="column-two">


</section><!-- End column two -->

<section id="column-three">



</section><!-- End column three -->



</div><!-- End content -->