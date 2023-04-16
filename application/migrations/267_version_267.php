<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_267 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    
    public function up()
    {  
        $fields = array(
            'pfirm_pic' => array('type' => 'LONGTEXT'),
            'ppassport_pic' => array('type' => 'LONGTEXT'),
            'pfront_pic' => array('type' => 'LONGTEXT'),
            'pr_side_pic' => array('type' => 'LONGTEXT'),
            'pl_side_pic' => array('type' => 'LONGTEXT'),
            'pback_pic' => array('type' => 'LONGTEXT')
        );
        $this->dbforge->modify_column('clients', $fields);
        // Executes: ALTER TABLE table_name ADD preferences TEXT
    }

    public function down()
    {
        $this->dbforge->drop_table('clients');
    }
}