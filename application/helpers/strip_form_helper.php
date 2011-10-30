<?php

/**
 * @author Andy Walpole
 * @date 22/10/2011
 * 
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('strip_form')) {

    function strip_form($value) {

        // Place this function on its own page

        // strips possible uses of form for sending junk mail

        $value = str_replace(array("\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:",
            "to:", "cc:", 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:'),
            ' ', $value);

        // Users filter to stript nasty tages

        $value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        // Returns sanitised info
        return $value;

    }

}

?>