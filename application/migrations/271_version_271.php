<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_271 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'pinstagram' => array('type' => 'LONGTEXT'),
        );
        $this->dbforge->add_column('clients', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_table('clients');
    }
}
