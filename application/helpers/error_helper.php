<?php

/**
 * @author Andy Walpole
 * @date 22/10/2011
 * 
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('get_404')) {


    function get_404() {

        show_404();
        exit;

    }

}

?>