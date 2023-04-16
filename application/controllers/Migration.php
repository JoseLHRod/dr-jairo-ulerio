<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration extends App_Controller
{
    public function index()
    {

        $this->load->library('migration');

        if ($this->config->current() === FALSE) {
            show_error($this->config->error_string());
        }
    }

    public function version($version)
    {
        $this->load->library('migration');
        if ($this->input->is_cli_request()) {
            $migration = $this->migration->version($version);
            if (!$migration) {
                echo $this->migration->error_string();
            } else {
                echo 'Migration(s) done' . PHP_EOL;
            }
        } else {
            show_error('You don\'t have permission for this action');;
        }
    }
}
