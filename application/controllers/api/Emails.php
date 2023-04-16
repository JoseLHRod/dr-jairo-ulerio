<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Emails extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('emails_model');
    }

    public function add()
    {

    /*     if (!has_permission('email_templates', '', 'view')) {
            access_denied('email_templates');
        } */

        $data = [];
        
        
        if ($this->input->post()) {
            if (!has_permission('email_templates', '', 'edit')) {
                access_denied('email_templates');
            }
            
            $data = json_decode($this->input->post());

            var_dump($data);

            // create_email_template($data[0][''], , 'staff', 'Event Notification (Calendar)', 'event-notification-to-staff');
        }
        // English is not included here
        echo json_encode($data);
    }
}
