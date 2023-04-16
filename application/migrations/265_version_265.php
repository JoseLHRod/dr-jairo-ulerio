<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_265 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    
    public function up()
    {  
        $fields = array(
            'paccepted_postsirurgical' => array('type' => 'TINYINT'),
            'paccepted_changeflight' => array('type' => 'TINYINT'),
            'accept_certify_info' => array('type' => 'TINYINT'),
        );
        $this->dbforge->add_column('clients', $fields);
        // Executes: ALTER TABLE table_name ADD preferences TEXT
    }

    public function down()
    {
        $this->dbforge->drop_table('clients');
    }
}