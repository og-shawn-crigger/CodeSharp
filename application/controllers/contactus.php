<?php

class ContactUs extends CI_Controller {


    function __construct() {

        parent::__construct();
    }


    public function theme($array) {

        $data = $array;

        $data['menu'] = $this->menu_model->menu_order("where visible = 1");

        $data['content'] = "contact_us";

        $this->load->view("includes/template.php", $data);


    }


    function index() {

        $data = array();

        $this->theme($data);

    }


    function mail() {


        $data = array();
        
         /**
         * validation rule to be found in config -> form_validation.php
         */

        if ($this->form_validation->run("contactus") == false) {

            $data['error_success'] = "<p>Opps, there have been problems with the form:</p>";
            
            $this->theme($data);

            sleep(2);

        } else {

            $data['error_success'] = "<p>Thanks for getting in touch. We will return your enquiry as soon as possible</p>";
            
            $this->theme($data);


            // Email contacts to admin
            // Need to set universal admin email

            $this->email->from($_POST['contactName']);
            $this->email->to(EMAIL);

            $this->email->subject('Email from ... ');

            // Build the email message body up below
            // Find if there is a CodeIngitor-friendly way of building up the message

            $body = 'Somebody has sent you an email on ' . date(DATE_W3C) . "<br />";
            $body .= '<strong>' . 'Name: ' . '</strong>' . "<br />";
            $body .= strip_form($_POST['contactName']) . "<br />";
            $body .= '<strong>' . 'Email: ' . '</strong>' . "<br />";
            $body .= strip_form($_POST['contactEmail']) . "<br />";
            $body .= '<strong>' . 'Phone: ' . '</strong>' . "<br />";
            if (isset($_POST['contactPhone'])) {
                $body .= strip_form($_POST['contactPhone']) . "<br />";
                $body .= '<strong>' . 'Details: ' . '</strong>' . "<br />";
            }
            $body .= strip_form($_POST['contactDetails']) . "<br />";
            $body .= '<strong>' . 'IP Address: ' . '</strong>' . "<br />";
            $body .= $_SERVER['REMOTE_ADDR'] . "<br />";
            $body .= '<strong>' . 'Spam: ' . '</strong>' . "<br />";

            $body = stripslashes($body);

            $this->email->message($body);

            $this->email->send();

            sleep(2);

            //echo $this->email->print_debugger();


        }

        

    }


}
