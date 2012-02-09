<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Andy Walpole
 * 
 * 
 */

if (!function_exists('main_menu')) {

    function main_menu($menu) {


        foreach ($menu as $main_menu) {

            $main_front = '<li>';

            $main_front .= '<a href="';

            if ($main_menu['menu_id'] === "C") {

                $main_front .= site_url('category/' . url_title(strtolower($main_menu['name'])));

            }

            if ($main_menu['menu_id'] === "M") {

                /**
                 * LOOK AT BELOW - REMOVE DIRECT CALL TO DATABASE MODEL
                 */

                $CI = &get_instance();

                $menu_url = $CI->menu_model->menu_url($main_menu['id']);

                $url = parse_url($menu_url->url);

                if ($menu_url->url !== "") {

                    if (isset($url["scheme"]) && $url["scheme"] == "http" || "https") {

                        $main_front .= $menu_url->url;

                    } else {

                        $main_front .= site_url($menu_url->url);

                    }


                } else {

                    $main_front .= site_url();

                }


            }

            $main_front .= '">';

            $main_front .= $main_menu['name'];

            $main_front .= '</a>';

            $main_front .= '</li>';

            echo $main_front;

        }


    }


}
