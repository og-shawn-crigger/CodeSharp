<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Andy Walpole
 * @date 20/10/2011
 * 
 */

if (!function_exists('admin_menu')) {

    function admin_menu() {
	
	$menu = '<nav>';
	$menu .= '<ul>';
	$menu .= '<li><a href="' . base_url() . INDEX . 'admin">Home</a></li>';
	$menu .= '<li><a href="' . base_url() . INDEX . 'admin-content">Add article</a></li>';
	$menu .= '<li><a href="' . base_url() . INDEX . 'admin-edit-content">Edit articles</a></li>';
	$menu .= '<li><a href="' . base_url() . INDEX . 'admin-category">Add / edit categories</a></li>';
	$menu .= '<li><a href="' . base_url() . INDEX . 'admin-user">Add / edit users</a></li>';
	$menu .= '<li><a href="' . base_url() . INDEX . 'admin-menu">Add / edit menu items</a></li>';
	$menu .= '</ul>';
	$menu .= '</nav>';
	
	return $menu;
	
	}

        

}