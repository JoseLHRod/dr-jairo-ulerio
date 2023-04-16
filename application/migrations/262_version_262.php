<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_262 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    
    public function up()
    {  
        $fields = array(
            'age' => array('type' => 'TEXT'),
            'age' => array('type' => 'TEXT'),
            'weight' => array('type' => 'TEXT'),
            'height' => array('type' => 'TEXT'),
            'diabetes' => array('type' => 'TINYINT'),
            'asthma' => array('type' => 'TINYINT'),
            'smoke' => array('type' => 'TINYINT'),
            'surgeries' => array('type' => 'TINYINT'),
            'disease' => array('type' => 'TINYINT'),
            'allergies' => array('type' => 'TINYINT'),
            'meds' => array('type' => 'TEXT'),
            'contraceptives' => array('type' => 'TINYINT'),
            'hospitalized' => array('type' => 'TINYINT'),
            'relatives' => array('type' => 'TINYINT'),
            'children' => array('type' => 'TINYINT'),
            'procedures' => array('type' => 'TEXT'),
            'surgery_date' => array('type' => 'DATETIME'),
            'howYouFindUs' => array('type' => 'TEXT'),
            'frontPic' => array('type' => 'TEXT'),
            'latPicLeft' => array('type' => 'TEXT'),
            'latPicRight' => array('type' => 'TEXT'),
            'backPic' => array('type' => 'TEXT'),
        );
        $this->dbforge->add_column('leads', $fields);
        // Executes: ALTER TABLE table_name ADD preferences TEXT
    }

    public function down()
    {
        $this->dbforge->drop_table('leads');
    }
}
