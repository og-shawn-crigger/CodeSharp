<?php

/**
 * @author Andy Walpole
 * @date 25/10/2011
 * 
 */
    
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Andy Walpole
 * @date 20/10/2011
 * 
 */


if (!function_exists('utf8_special')) {

    function utf8_special($str) {

        $str = mb_convert_encoding($str, 'UTF-8', 'UTF-8');
     
        return $str;

    }

}

 

?>