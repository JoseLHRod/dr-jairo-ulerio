<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_272 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'pfront_pic_after' => array('type' => 'TEXT'),
            'pr_side_pic_after' => array('type' => 'TEXT'),
            'pl_side_pic_after' => array('type' => 'TEXT'),
            'pback_pic_after' => array('type' => 'TEXT'),
        );
        $this->dbforge->add_column('clients', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_table('clients');
    }
}
