<?php

class ContactUs extends CI_Controller {


    function __construct() {
        parent::__construct();
    }

    function index($data = "") {

        $data['content'] = "contact_us";
        $this->load->view("includes/template.php", $data);

    }

    function mail() {

        $this->form_validation->set_rules('contactName', 'Name', 'trim|required');
        $this->form_validation->set_rules('contactNumber', 'Phone',
            'trim|max_length[100]');
        $this->form_validation->set_rules('contactEmail', 'Email',
            'trim|required|max_length[100]|valid_email');
        $this->form_validation->set_rules('contactDetails', 'Message', 'trim|required');

        // anti spam trap - it should be left empty
        $this->form_validation->set_rules('zipcode', 'zipcode', 'trim|exact_length[0]');

        if ($this->form_validation->run() == false) {

            $data['error'] = "Opps, there have been problems with the form:";
            $data['content'] = "contact_us";
            $this->load->view("includes/template.php", $data);
            
            sleep(2);

        } else {
          
            $data['success'] = "Thanks for getting in touch. We will return your enquiry as soon as possible ";
            $data['content'] = "contact_us";
            $this->load->view("includes/template.php", $data);

            // Email contacts to admin
            // Need to set universal admin email

            $this->email->from($_POST['contactName']);
            $this->email->to('andy@suburban-glory.com');

            $this->email->subject('Email from ... ');
            
            // Build the email message body up below
            // Find if there is a CodeIngitor-friendly way of building up the message

            $body = 'Somebody has sent you an email on ' . date(DATE_W3C) . "<br />";
            $body .= '<strong>' . 'Name: ' . '</strong>' . "<br />";
            $body .= strip_form($_POST['contactName']) . "<br />";
            $body .= '<strong>' . 'Email: ' . '</strong>' . "<br />";
            $body .= strip_form($_POST['contactEmail']) . "<br />";
            $body .= '<strong>' . 'Phone: ' . '</strong>' . "<br />";
            if(isset($_POST['contactPhone'])) {
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

?>