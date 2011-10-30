<?php ob_start(); ?>
<!DOCTYPE html>
<!--[if IE]><![endif]-->
<html>
<head lang="en">
<meta charset="utf-8" />
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<title><?php

if (isset($_SERVER['PATH_INFO'])) {

    $page = $_SERVER['PATH_INFO'];

} else {

    $page = "index page";

}

switch ($page) {

    case (preg_match('/^\/article\/.*/', $page) ? true : false):
        echo $full_node[0]->title . " / " . SITENAME;
        break;

    case (preg_match('/^\/category\/.*/', $page) ? true : false):
        echo $category_records[0]->name . " / " . SITENAME;
        break;

    case "/admin":
        echo "Administration section " . " / " . SITENAME;
        break;

    case (preg_match('/^\/admin_config\/*/', $page) ? true : false):
        echo "Main admin configuration " . " / " . SITENAME;
        break;

    case (preg_match('/^\/admin_content\/*/', $page) ? true : false):
        echo "Add a content page " . " / " . SITENAME;
        break;

    case (preg_match('/^\/admin_edit_content$/', $page) ? true : false):
        echo "Edit a content page " . " / " . SITENAME;
        break;

    case (preg_match('/^\/admin_edit_content\/edit_node\/\d/', $page) ? true : false):
        echo isset($_POST["title"]) ? $_POST["title"] : $edit[0]->title . " / " . SITENAME;
        break;

    case (preg_match('/^\/admin_category\/*/', $page) ? true : false):
        echo "Edit categories " . " / " . SITENAME;
        break;

    case (preg_match('/^\/admin_user\/*/', $page) ? true : false):
        echo "Add and edit user details " . " / " . SITENAME;
        break;
        
    case (preg_match('/^\/admin_menu\/*/', $page) ? true : false):
        echo "Add and edit menu details " . " / " . SITENAME;
        break;

    default:
        echo SITENAME . " / " . SLOGAN;
        break;

}

?></title>
<link type="text/css" rel="stylesheet" media="all" href="<?php

echo base_url();

?>css/styles.css" />

<!-- meta description here -->
<?php

if(isset($full_node)) {

if($full_node[0]->meta_description !== "") {
    
    $meta = '<meta name="description" content="';
    
    $meta .= $full_node[0]->meta_description;
    
    $meta .= '" />';
    
    echo $meta;
    
}

/**
 * NEED TO SORT OUT KEYWORDS BOX IN ADD AND EDIT NODE
 */

if($full_node[0]->meta_keywords !== "") {
    
    $meta = '<meta name="keywords" content="';
    
    $meta .= $full_node[0]->meta_keywords;
    
    $meta .= '" />';
    
    echo $meta;
    
}

}

?></head>
<body>



<?php


?>



