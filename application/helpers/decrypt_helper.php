<?php

/**
 * @author Andy Walpole
 * @date 6/11/2011
 * 
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('decrypt')) {

    function decrypt($text= "", $key ="") {
        
        $result = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
        return trim($result);

    }

}

?>