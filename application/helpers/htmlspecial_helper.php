<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Andy Walpole
 * @date 20/10/2011
 * 
 */


if (!function_exists('html_special')) {

    function html_special($str) {

        $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');

        return $str;

    }

}

?>