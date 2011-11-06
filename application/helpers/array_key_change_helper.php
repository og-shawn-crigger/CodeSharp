<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Andy Walpole
 * @date 20/10/2011
 * 
 */

if (!function_exists('array_key_change')) {

    function array_key_change($existing, $newkeys) {

        // a really simple check that the arrays are the same size
        if (count($existing) !== count($newkeys))
            return false; // or pipe out a useful message, or chuck exception

        $data = array(); // set up a return array
        $i = 0;
        foreach ($existing as $k => $v) {
            $data[$newkeys[$i]] = $v; // build up the new array
            $i++;
        }
        return $data; // return it

    }

}