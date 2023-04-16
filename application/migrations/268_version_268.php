<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_268 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    
    public function up()
    {  
        $fields = array(
            'l_formAntecesor' => array('type' => 'TINYINT'),
        );
        $this->dbforge->add_column('leads', $fields);
        // Executes: ALTER TABLE table_name ADD preferences TEXT
    }

    public function down()
    {
        $this->dbforge->drop_table('leads');
    }
}
