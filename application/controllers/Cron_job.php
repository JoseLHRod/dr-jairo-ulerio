<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Cron_job extends CI_Controller 
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('input');
        $this->load->model('cron_job_model');
    }
    
    /**
     * This function is used to update the age of users automatically
     * This function is called by cron job once in a day at midnight 00:00
     */
    public function birthday()
    {            
        $this->cron_job_model->birthday();        
    }

    public function patient_review()
    {            
        $this->cron_job_model->patient_review();
    }     
    
    public function fbleads()
    {            
        $this->cron_job_model->fbleads();        
    }
}
?>