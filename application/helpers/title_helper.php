<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Andy Walpole
 * 
 * 
 */

if (!function_exists('title')) {

    function title($edit_node = null, $category = null, $display_node = null) {
        
    
	$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

if ($_SERVER["SERVER_PORT"] != "80") {

    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];

} else {

    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

}

$page = $pageURL;

switch ($page) {

    case "/admin":
        return "Administration section " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-config\/*/', $page) ? true : false):
        return "Main admin configuration " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-content\/*/', $page) ? true : false):
        return "Add a content page " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-edit-content$/', $page) ? true : false):
        return "Edit a content page " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-edit-content\/edit-node\/\d/', $page) ? true : false):
        return isset($_POST["title"]) ? $_POST["title"]:
        $edit_node . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-category\/*/', $page) ? true : false):
        return "Edit categories " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-user\/*/', $page) ? true : false):
        return "Add and edit user details " . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/admin-menu\/*/', $page) ? true : false):
        return "Add and edit menu details " . " / " . SITENAME;
        break;
        
    case (preg_match('/^.*\/article\/.*/', $page) ? true : false):
        return $display_node . " / " . SITENAME;
        break;

    case (preg_match('/^.*\/category\/.*/', $page) ? true : false):
        return $category . " / " . SITENAME;
        break;

    default:
        return SITENAME . " / " . SLOGAN;
        break;

}
	
	}//end function
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

        

}