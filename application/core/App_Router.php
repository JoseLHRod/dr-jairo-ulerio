<?php

defined('BASEPATH') or exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . 'third_party/MX/Router.php';

class App_Router extends MX_Router
{
    protected function _parse_routes()
    {
        // Language detection over URL
        if($this->uri->segments[1] == $this->config->config['language']) {
            unset($this->uri->segments[1]);
        }   

        if(array_search($this->uri->segments[1], $this->config->config['languages'])) {
            $this->config->config['language'] = array_search($this->uri->segments[1], $this->config->config['languages']);
            unset($this->uri->segments[1]);
        }
        
        // Return default function
        return parent::_parse_routes();
    }  
}
