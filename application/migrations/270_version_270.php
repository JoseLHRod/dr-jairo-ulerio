<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_270 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    
    public function up()
    {  
        $fields = array(
            'emailTemplates' => array('type' => 'INT'),
        );
        $this->dbforge->modify_column('leads_status', $fields);
        // Executes: ALTER TABLE table_name ADD preferences TEXT
    }

    public function down()
    {
        $this->dbforge->drop_table('leads_status');
    }
}
