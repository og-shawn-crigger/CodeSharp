<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Andy Walpole
 * @date 20/10/2011
 * 
 */


if (!function_exists('create_json')) {

    function create_json($name, $array) {

        $directory = FCPATH . 'json';

        if (!is_dir($directory)) {

            mkdir($directory);
            chmod($directory, 0777);

        }

        // Create json file for use in JavaScript
        $jsonFile = $name . ".json";

        // create file
        $fileHandle = fopen($directory . DIRECTORY_SEPARATOR . $jsonFile, 'w');

        // write to file
        fwrite($fileHandle, json_encode($array));

        // close file
        fclose($fileHandle);

    }

}

?>