<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_264 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    
    public function up()
    {  
        $fields = array(
            'pcreate_date' => array('type' => 'DATETIME'),
            'pleave_date' => array('type' => 'DATETIME'),
            'pstaying_property' => array('type' => 'TEXT'),
            'pdob' => array('type' => 'DATETIME'),
            'ppassport' => array('type' => 'TEXT'),
            'poccupation' => array('type' => 'TEXT'),
            'preligion' => array('type' => 'TEXT'),
            'pemergency' => array('type' => 'TEXT'),
            'pmarital_status' => array('type' => 'TEXT'),
            'plast_mestruation' => array('type' => 'TEXT'),
            'pdiagnosis' => array('type' => 'TEXT'),
            'pblood_transf' => array('type' => 'TEXT'),
            'pg' => array('type' => 'TEXT'),
            'pa' => array('type' => 'TEXT'),
            'pp' => array('type' => 'TEXT'),
            'pc' => array('type' => 'TEXT'),
            'plast_pregancy' => array('type' => 'DATETIME'),
            'psicklemia' => array('type' => 'TINYINT'),
            'psicklemia_trait' => array('type' => 'TINYINT'),
            'pdepression' => array('type' => 'TINYINT'),
            'poral_cont' => array('type' => 'TINYINT'),
            'pfather_hist' => array('type' => 'TEXT'),
            'pmother_hist' => array('type' => 'TEXT'),
            'pbrother_hist' => array('type' => 'TEXT'),
            'pchildren_hist' => array('type' => 'TEXT'),
            'ppartner_hist' => array('type' => 'TEXT'),
            'pcollateral_hist' => array('type' => 'TEXT'),
            'ppathological_meds' => array('type' => 'TEXT'),
            'ppsychiatric' => array('type' => 'TEXT'),
            'preason' => array('type' => 'TEXT'),
            'pphysical_exam' => array('type' => 'TEXT'),
            'phematimetry' => array('type' => 'TINYINT'),
            'phomoglobinometry' => array('type' => 'TINYINT'),
            'pcoagulation' => array('type' => 'TINYINT'),
            'pbleeding' => array('type' => 'TINYINT'),
            'phematocrit' => array('type' => 'TINYINT'),
            'pxrays' => array('type' => 'TINYINT'),
            'psonography' => array('type' => 'TINYINT'),
            'pother_exam' => array('type' => 'TINYINT'),
            'pother_exams' => array('type' => 'TEXT'),
            'psirugical_plan' => array('type' => 'TEXT'),
            'ppricing' => array('type' => 'INT'),
            'ppassport_pic' => array('type' => 'TEXT'),
            'pfront_pic' => array('type' => 'TEXT'),
            'pr_side_pic' => array('type' => 'TEXT'),
            'pl_side_pic' => array('type' => 'TEXT'),
            'pback_pic' => array('type' => 'TEXT'),
            'pselected_hospital' => array('type' => 'TEXT'),
            'panesthesiologist' => array('type' => 'TEXT'),
        );
        $this->dbforge->add_column('clients', $fields);
        // Executes: ALTER TABLE table_name ADD preferences TEXT
    }

    public function down()
    {
        $this->dbforge->drop_table('clients');
    }
}