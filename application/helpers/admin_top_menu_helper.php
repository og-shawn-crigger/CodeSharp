<?php

/**
 * @author Andy Walpole
 * @date 7/11/2011
 * 
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('top_admin_menu')) {

    function top_admin_menu() {
        
    $menu = '<a href="' . site_url("admin-config") . '">Global Settings</a>';
    
    $menu .= " / ";
    
    $menu .= '<a href="' .  site_url("login/letmeout") . '">Logout</a>';
    
    return $menu;
    
	}

}

