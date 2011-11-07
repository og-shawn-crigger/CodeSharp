<?php

/**
 * @author Andy Walpole
 * @date 6/11/2011
 * 
 */
 
 if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// DO NOT CHANGE THIS!


if (!function_exists('encrypt')) {

function encrypt($text = "", $key = "") {

   
        $result = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
        return trim(base64_encode($result));

}

}

?>