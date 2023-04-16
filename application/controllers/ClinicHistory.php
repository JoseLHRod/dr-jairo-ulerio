<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ClinicHistory extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        /* load base_url */
        $this->load->helper('url');

        // access leads
        $this->load->model('leads_model');
        $this->load->model('clients_model');
    }

    public function index($id = '')
    {
        /* access lead if exists */
        $data['leadid'] = $id;
        if ($id != '') {
            $lead = $this->leads_model->get($id);

            if (!$lead) {
                header('HTTP/1.0 404 Not Found');
                echo _l('lead_not_found');
                die;
            }

            $data['lead'] = $lead;//heightfeet
        }else $lead = (object)["name" => "","age"=>"","phonenumber"=>"","email"=>"","weight"=>"","heightfeet"=>"","heightinches"=>"","children"=>"","asthma"=>"","allergies"=>"","diabetes"=>"","smoke"=>"","contraceptives"=>"","meds"=>"","procedures"=>"","surgery_date"=>""];

        $data['properties'] = [
            'Serenity I RH',
            'Serenity II RH',
            'Paradise RH',
            'Relax Recovery',
            'Arelis Recovery House',
            'Pedro RH',
            'Armonia RH',
            'Princess RH',
            'Dominican Republic RH',
            'Sweet Heart RH',
            'Kindness RH',
            'Bella Luna RH',
            'Healing Heavens RH',
            'De la Paz RH',
            'La casa Lucy',
            'Jade RH',
            'Other',
        ];

        $data['maritalStatus'] = [
            'Single',
            'Married',
            'Divorced',
            'Widow',
            'Other'
        ];

        $data['selectPos'] = [
            'Yes' => 1,
            'No' => 0
        ];

        $data['hosp'] = [
            'Plastimedic'
        ];

        $data['anesth'] = [
            'Dr. Cuesto',
            'Dra. Bueno',
            'Dra. Tousein',
            'Dra. Ramírez',
        ];

        $data['step1'] = array(
            'enterDate' => [
                'inputType' => 'date',
                'keyname' => 'pcreate_date',
                'labelKey' => 'this_date',
                'inputValue' => date('Y-m-d'),
                'required' => ''
            ],
            'leaveDate' => [
                'inputType' => 'date',
                'keyname' => 'pleave_date',
                'labelKey' => 'leave_date',
                'inputValue' => '',
                'required' => ''
            ],
            'staying' => [
                'inputType' => 'select',
                'keyname' => 'pstaying_property',
                'labelKey' => 'staying',
                'inputValue' => '',
                'selectDual' => false,
                'selectOptions' => $data['properties'],
                'required' => ''
            ],
            'firstname' => [
                'inputType' => 'text',
                'keyname' => 'first_name',
                'labelKey' => 'client_first_name',
                'inputValue' => $lead->name,
                'required' => 'required'
            ],
            'lastname' => [
                'inputType' => 'text',
                'keyname' => 'last_name',
                'labelKey' => 'client_last_name',
                'inputValue' => '',
                'required' => ''
            ],
            'instagram' => [
                'inputType' => 'text',
                'keyname' => 'pinstagram',
                'labelKey' => 'ig',
                'inputValue' => '',
                'required' => ''
            ],
            'age' => [
                'inputType' => 'number',
                'keyname' => 'age',
                'labelKey' => 'client_age',
                'inputValue' => $lead->age,
                'required' => 'required'
            ],
            'phone' => [
                'inputType' => 'number',
                'keyname' => 'phonenumber',
                'labelKey' => 'client_phonenumber',
                'inputValue' => $lead->phonenumber,
                'required' => 'required'
            ],
            'email' => [
                'inputType' => 'email',
                'keyname' => 'client_email',
                'labelKey' => 'client_client_email',
                'inputValue' => $lead->email,
                'required' => 'required'
            ],
            'dob' => [
                'inputType' => 'date',
                'keyname' => 'pdob',
                'labelKey' => 'Birthday',
                'inputValue' => '',
                'required' => 'required'
            ],
            'passport' => [
                'inputType' => 'text',
                'keyname' => 'ppassport',
                'labelKey' => 'passport_number',
                'inputValue' => '',
                'required' => ''
            ],
            'occupation' => [
                'inputType' => 'text',
                'keyname' => 'poccupation',
                'labelKey' => 'occupation',
                'inputValue' => '',
                'required' => ''
            ],
            'religion' => [
                'inputType' => 'text',
                'keyname' => 'preligion',
                'labelKey' => 'religion',
                'inputValue' => '',
                'required' => 'required'
            ],
            'emergency' => [
                'inputType' => 'textarea',
                'keyname' => 'pemergency',
                'labelKey' => 'e_contact',
                'inputValue' => '',
                'required' => ''
            ],
            'maritalStatus' => [
                'inputType' => 'select',
                'keyname' => 'pmarital_status',
                'labelKey' => 'm_status',
                'inputValue' => '',
                'selectDual' => false,
                'selectOptions' => $data['maritalStatus'],
                'required' => ''
            ],
            'weight' => [
                'inputType' => 'number',
                'keyname' => 'pweight',
                'labelKey' => 'client_pweight',
                'inputValue' => $lead->weight,
                'required' => 'required'
            ],
            'height' => [
                'inputType' => 'number',
                'keyname' => 'pheight',
                'labelKey' => 'client_pheight',
                'required' => 'required',
                'heightfeet' => [
                    'inputType' => 'number',
                    'keyname' => 'pheightfeet',
                    'labelKey' => 'feet',
                    'inputValue' => $lead->heightfeet,
                    'required' => 'required'
                ],
                'heightinches' => [
                    'inputType' => 'number',
                    'keyname' => 'pheightinches',
                    'labelKey' => 'inches',
                    'inputValue' => $lead->heightinches,
                    'required' => 'required'
                ],
            ],
            'lastMentruation' => [
                'inputType' => 'text',
                'keyname' => 'plast_mestruation',
                'labelKey' => 'l_menst',
                'inputValue' => '',
                'required' => ''
            ],
            'prevSurgeries' => [
                'inputType' => 'text',
                'keyname' => 'psurgeries',
                'labelKey' => 'p_surgeries',
                'inputValue' => '',
                'required' => ''
            ]
        );

        $data['step2'] = array(
            'diagnosis' => [
                'inputType' => 'textarea',
                'keyname' => 'pdiagnosis',
                'labelKey' => 'p_diagnosis',
                'inputValue' => '',
                'required' => ''
            ],
            'bloodTransfution' => [
                'inputType' => 'checkbox',
                'keyname' => 'pblood_transf',
                'labelKey' => 'b_transf',
                'inputValue' => '',
                'required' => ''
            ],
            'g' => [
                'inputType' => 'text',
                'keyname' => 'pg',
                'labelKey' => 'p_g',
                'inputValue' => '',
                'required' => ''
            ],
            'a' => [
                'inputType' => 'text',
                'keyname' => 'pa',
                'labelKey' => 'p_a',
                'inputValue' => '',
                'required' => ''
            ],
            'p' => [
                'inputType' => 'text',
                'keyname' => 'pp',
                'labelKey' => 'p_p',
                'inputValue' => '',
                'required' => ''
            ],
            'c' => [
                'inputType' => 'text',
                'keyname' => 'pc',
                'labelKey' => 'p_c',
                'inputValue' => '',
                'required' => ''
            ],
            'pregnancies' => [
                'inputType' => 'checkbox',
                'keyname' => 'pkids',
                'labelKey' => 'client_pkids',
                'inputValue' => $lead->children,
                'required' => ''
            ],
            'lastPregnancy' => [
                'inputType' => 'date',
                'keyname' => 'plast_pregancy',
                'labelKey' => 'date_last_pregnancy',
                'inputValue' => '',
                'required' => ''
            ],
            'asthma' => [
                'inputType' => 'checkbox',
                'keyname' => 'pasthma',
                'labelKey' => 'client_pasthma',
                'inputValue' => $lead->asthma,
                'required' => ''
            ],
            'allergies' => [
                'inputType' => 'checkbox',
                'keyname' => 'pallergies',
                'labelKey' => 'client_pallergies',
                'inputValue' => $lead->allergies,
                'required' => ''
            ],
            'hypertension' => [
                'inputType' => 'checkbox',
                'keyname' => 'pbloodp',
                'labelKey' => 'client_pbloodp',
                'inputValue' => '',
                'required' => ''
            ],
            'sicklemia' => [
                'inputType' => 'checkbox',
                'keyname' => 'psicklemia',
                'labelKey' => 'client_sicklemia',
                'inputValue' => '',
                'required' => ''
            ],
            'diabetes' => [
                'inputType' => 'checkbox',
                'keyname' => 'pdiabetes',
                'labelKey' => 'client_pdiabetes',
                'inputValue' => $lead->diabetes,
                'required' => ''
            ],
            'sicklemiaTrait' => [
                'inputType' => 'checkbox',
                'keyname' => 'psicklemia_trait',
                'labelKey' => 'client_sicklemia_trait',
                'inputValue' => '',
                'required' => ''
            ],
            'depression' => [
                'inputType' => 'checkbox',
                'keyname' => 'pdepression',
                'labelKey' => 'client_depression',
                'inputValue' => '',
                'required' => ''
            ],
            'smoke' => [
                'inputType' => 'checkbox',
                'keyname' => 'psmoker',
                'labelKey' => 'client_psmoker',
                'inputValue' => $lead->smoke,
                'required' => ''
            ],
            'hooka' => [
                'inputType' => 'checkbox',
                'keyname' => 'phookah',
                'labelKey' => 'client_phookah',
                'inputValue' => '',
                'required' => ''
            ],
            'alcohol' => [
                'inputType' => 'checkbox',
                'keyname' => 'palcohol',
                'labelKey' => 'client_palcohol',
                'inputValue' => '',
                'required' => ''
            ],
            'drugs' => [
                'inputType' => 'checkbox',
                'keyname' => 'pdrugs',
                'labelKey' => 'client_drugs',
                'inputValue' => '',
                'required' => ''
            ],
            'oralCont' => [
                'inputType' => 'checkbox',
                'keyname' => 'poral_cont',
                'labelKey' => 'oral_contraceptiv',
                'inputValue' => $lead->contraceptives,
                'required' => ''
            ],
            'lactation' => [
                'inputType' => 'checkbox',
                'keyname' => 'pbreastf',
                'labelKey' => 'client_pbreastf',
                'inputValue' => '',
                'required' => ''
            ],
            'hiv' => [
                'inputType' => 'checkbox',
                'keyname' => 'phiv',
                'labelKey' => 'client_phiv',
                'inputValue' => '',
                'required' => ''
            ],
            'hepatitis' => [
                'inputType' => 'checkbox',
                'keyname' => 'phepbc',
                'labelKey' => 'client_phepbc',
                'inputValue' => '',
                'required' => ''
            ],
            'others' => [
                'inputType' => 'text',
                'keyname' => 'pconditions',
                'labelKey' => 'client_pconditions',
                'inputValue' => '',
                'required' => ''
            ],
            'meds' => [
                'inputType' => 'text',
                'keyname' => 'pvitamins',
                'labelKey' => 'client_pvitamins',
                'inputValue' => $lead->meds,
                'required' => ''
            ],
            'histFather' => [
                'inputType' => 'text',
                'keyname' => 'pfather_hist',
                'labelKey' => 'f_hist',
                'inputValue' => '',
                'required' => ''
            ],
            'histMother' => [
                'inputType' => 'text',
                'keyname' => 'pmother_hist',
                'labelKey' => 'm_hist',
                'inputValue' => '',
                'required' => ''
            ],
            'histChildren' => [
                'inputType' => 'text',
                'keyname' => 'pchildren_hist',
                'labelKey' => 'c_hist',
                'inputValue' => '',
                'required' => ''
            ],
            'histBrother' => [
                'inputType' => 'text',
                'keyname' => 'pbrother_hist',
                'labelKey' => 'b_hist',
                'inputValue' => '',
                'required' => ''
            ],
            'histPartner' => [
                'inputType' => 'text',
                'keyname' => 'ppartner_hist',
                'labelKey' => 'wh_hist',
                'inputValue' => '',
                'required' => ''
            ],
            'histCollateral' => [
                'inputType' => 'text',
                'keyname' => 'pcollateral_hist',
                'labelKey' => 'c_hist',
                'inputValue' => '',
                'required' => ''
            ],
            'pathologMeds' => [
                'inputType' => 'text',
                'keyname' => 'ppathological_meds',
                'labelKey' => 'p_h_meds',
                'inputValue' => '',
                'required' => ''
            ],
            'psychiatric' => [
                'inputType' => 'text',
                'keyname' => 'ppsychiatric',
                'labelKey' => 'psy_hist',
                'inputValue' => '',
                'required' => ''
            ]
        );

        $data['step3'] = array(
            'reason' => [
                'inputType' => 'textarea',
                'keyname' => 'preason',
                'labelKey' => 'reason_consult',
                'inputValue' => $lead->procedures,
                'required' => 'required'
            ],
            'physicExam' => [
                'inputType' => 'textarea',
                'keyname' => 'pphysical_exam',
                'labelKey' => 'physic_exam',
                'inputValue' => '',
                'required' => 'required'
            ],
            'hematimetry' => [
                'inputType' => 'checkbox',
                'keyname' => 'phematimetry',
                'labelKey' => 'hematimetry_exam',
                'inputValue' => '',
                'required' => ''
            ],
            'homoglobinometry' => [
                'inputType' => 'checkbox',
                'keyname' => 'phomoglobinometry',
                'labelKey' => 'homoglob_exam',
                'inputValue' => '',
                'required' => ''
            ],
            'tCoagulation' => [
                'inputType' => 'checkbox',
                'keyname' => 'pcoagulation',
                'labelKey' => 'tcoag_exam',
                'inputValue' => '',
                'required' => ''
            ],
            'tBleeding' => [
                'inputType' => 'checkbox',
                'keyname' => 'pbleeding',
                'labelKey' => 'tbleed_exam',
                'inputValue' => '',
                'required' => ''
            ],
            'hematocrit' => [
                'inputType' => 'checkbox',
                'keyname' => 'phematocrit',
                'labelKey' => 'hematocrit_exam',
                'inputValue' => '',
                'required' => ''
            ],
            'xRays' => [
                'inputType' => 'checkbox',
                'keyname' => 'pxrays',
                'labelKey' => 'xrays_exam',
                'inputValue' => '',
                'required' => ''
            ],
            'sonography' => [
                'inputType' => 'checkbox',
                'keyname' => 'psonography',
                'labelKey' => 'sonography_exam',
                'inputValue' => '',
                'required' => ''
            ],
            'other' => [
                'inputType' => 'checkbox',
                'keyname' => 'pother_exam',
                'labelKey' => 'other_exam',
                'inputValue' => '',
                'required' => ''
            ],
            'otherExams' => [
                'inputType' => 'textarea',
                'keyname' => 'pother_exams',
                'labelKey' => 'other_exams',
                'inputValue' => '',
                'required' => ''
            ],
            'surgicalPlan' => [
                'inputType' => 'text',
                'keyname' => 'psirugical_plan',
                'labelKey' => 'sirurgical_plan',
                'inputValue' => '',
                'required' => ''
            ],
            'price' => [
                'inputType' => 'number',
                'keyname' => 'ppricing',
                'labelKey' => 'sir_price',
                'inputValue' => '5000',
                'required' => 'required'
            ],
            /* 'priority' => [
                'inputType' => 'custom',
                'keyname' => 'priority',
                'labelKey' => 'addPriority',
                'inputValue' => ''
            ] */
        );

        $data['step4'] = array(
            'iAcceptPostSurgical' => [
                'inputType' => 'checkbox',
                'keyname' => 'paccepted_postsirurgical',
                'labelKey' => 'accept_post_surgical',
                'inputValue' => '',
                'required' => 'required'
            ],
            'iAcceptChangeFlight' => [
                'inputType' => 'checkbox',
                'keyname' => 'paccepted_changeflight',
                'labelKey' => 'accept_change_flight',
                'inputValue' => '',
                'required' => ''
            ],
            'iCertify' => [
                'inputType' => 'checkbox',
                'keyname' => 'accept_certify_info',
                'labelKey' => 'accept_certify_info',
                'inputValue' => '',
                'required' => 'required'
            ],
            'signature' => [
                'inputType' => 'signature',
                'keyname' => 'signature',
                'labelKey' => 'p_signature',
                'required' => ''
            ]
        );

        $data['step5'] = array(
            'passportPic' => [
                'inputType' => 'file',
                'keyname' => 'ppassport_pic',
                'labelKey' => 'passport_id_pic',
                'inputValue' => '',
                'required' => ''
            ],
            'frontPic' => [
                'inputType' => 'file',
                'keyname' => 'pfront_pic',
                'labelKey' => 'front_image',
                'inputValue' => '',
                'required' => ''
            ],
            'latPicRight' => [
                'inputType' => 'file',
                'keyname' => 'pr_side_pic',
                'labelKey' => 'lat_image_r',
                'inputValue' => '',
                'required' => ''
            ],
            'latPicLeft' => [
                'inputType' => 'file',
                'keyname' => 'pl_side_pic',
                'labelKey' => 'lat_image_l',
                'inputValue' => '',
                'required' => ''
            ],
            'backPic' => [
                'inputType' => 'file',
                'keyname' => 'pback_pic',
                'labelKey' => 'back_image',
                'inputValue' => '',
                'required' => ''
            ]
        );

        $data['step6'] = array(
            'hospital' => [
                'inputType' => 'select',
                'keyname' => 'pselected_hospital',
                'labelKey' => 'select_hospital',
                'inputValue' => '',
                'selectDual' => false,
                'selectOptions' => $data['hosp'],
                'required' => ''
            ],
            /* 'currentDate' => [
                'inputType' => 'date',
                'keyname' => 'currentDate',
                'labelKey' => 'addcurrentDate',
                'inputValue' => ''
            ], */
            'surgeryDate' => [
                'inputType' => 'date',
                'keyname' => 'pprocedures',
                'labelKey' => 'surgery_date',
                'inputValue' => $lead->surgery_date,
                'required' => ''
            ],
            'Anesthesiologist' => [
                'inputType' => 'select',
                'keyname' => 'panesthesiologist',
                'labelKey' => 'select_anesthesiologist',
                'inputValue' => '',
                'selectDual' => false,
                'selectOptions' => $data['anesth'],
                'required' => ''
            ]
        );

        $data['forms'] = array(
            1 => $data['step1'],
            2 => $data['step2'],
            3 => $data['step3'],
            4 => $data['step4'],
            5 => $data['step5'],
            6 => $data['step6']
        );

        /* check form submit or not */
        if ($this->input->post()) {
            /* Convert to patient */
            $res = $this->convert_patient($this->input->post(),  $data['leadid']);

            echo json_encode($res);
        } else {
            $this->load->view('forms/addNewPatitent', $data);
        }
    }

    public function convert_patient($formData, $leadId)
    {
        $default_country  = get_option('customer_default_country');
        $data             = $this->input->post();
        /* $data['password'] = $this->input->post('password', false); */

        if ($leadId != '') {
            $lead = $this->leads_model->get($leadId);

            if (!$lead) {
                header('HTTP/1.0 404 Not Found');
                echo _l('lead_not_found');
                die;
            }
        }else{
            $leadId = $this->clients_model->add($data);
            return [
                'code' => 1,
                'msg' => 'client Created sucessfully',
                'redirect' => admin_url('patients/patient/' . $leadId . '?group=profile')
            ];
        }

        if ($lead) {
            $original_lead_email = isset($lead->email) ? $lead->email : false;
            if($original_lead_email == false) $original_lead_email = $lead->client_email;
            
            unset($data['original_lead_email']);

            if(isset($lead->howYouFindUs)) $data['phearaboutus'] = $lead->howYouFindUs;
            $data['leadid'] = $lead->id;

            if(isset($lead->frontPic)) $data['pfront_pic'] = $lead->frontPic;
            if(isset($lead->latPicRight)) $data['pr_side_pic'] = $lead->latPicRight;
            if(isset($lead->latPicLeft)) $data['pl_side_pic'] = $lead->latPicLeft;
            if(isset($lead->backPic)) $data['pback_pic'] = $lead->backPic;
        }

        // comes from second form
        $data['p_formAntecesor'] = '3';

        $default_status = $this->leads_model->get_status('', [
            'isdefault' => 1,
        ]);

        $this->db->where('id', $lead->id);
        $this->db->update(db_prefix() . 'leads', [
            'date_converted' => date('Y-m-d H:i:s'),
            'status'         => $default_status[0]['id'],
            'junk'           => 0,
            'lost'           => 0,
        ]);

        if ((!isset($data['country']) || $data['country'] == '') && $default_country != '') {
            $data['country'] = $default_country;
        }

        $data['company'] = 'Patient';
        $data['pblood_transf'] = $this->_valCheckBoxValueInArray($data['pblood_transf']);
        $data['pkids'] = $this->_valCheckBoxValueInArray($data['pkids']);
        $data['pasthma'] = $this->_valCheckBoxValueInArray($data['pasthma']);
        $data['pbloodp'] = $this->_valCheckBoxValueInArray($data['pbloodp']);
        $data['psicklemia'] = $this->_valCheckBoxValueInArray($data['psicklemia']);
        $data['pdiabetes'] = $this->_valCheckBoxValueInArray($data['pdiabetes']);
        $data['psicklemia_trait'] = $this->_valCheckBoxValueInArray($data['psicklemia_trait']);
        $data['pdepression'] = $this->_valCheckBoxValueInArray($data['pdepression']);
        $data['psmoker'] = $this->_valCheckBoxValueInArray($data['psmoker']);
        $data['phookah'] = $this->_valCheckBoxValueInArray($data['phookah']);
        $data['palcohol'] = $this->_valCheckBoxValueInArray($data['palcohol']);
        $data['pdrugs'] = $this->_valCheckBoxValueInArray($data['pdrugs']);
        $data['poral_cont'] = $this->_valCheckBoxValueInArray($data['poral_cont']);
        $data['pbreastf'] = $this->_valCheckBoxValueInArray($data['pbreastf']);
        $data['phiv'] = $this->_valCheckBoxValueInArray($data['phiv']);
        $data['phematimetry'] = $this->_valCheckBoxValueInArray($data['phematimetry']);
        $data['phomoglobinometry'] = $this->_valCheckBoxValueInArray($data['phomoglobinometry']);
        $data['pcoagulation'] = $this->_valCheckBoxValueInArray($data['pcoagulation']);
        $data['pbleeding'] = $this->_valCheckBoxValueInArray($data['pbleeding']);
        $data['phematocrit'] = $this->_valCheckBoxValueInArray($data['phematocrit']);
        $data['pxrays'] = $this->_valCheckBoxValueInArray($data['pxrays']);
        $data['psonography'] = $this->_valCheckBoxValueInArray($data['psonography']);
        $data['pother_exam'] = $this->_valCheckBoxValueInArray($data['pother_exam']);
        $data['paccepted_postsirurgical'] = $this->_valCheckBoxValueInArray($data['paccepted_postsirurgical']);
        $data['paccepted_changeflight'] = $this->_valCheckBoxValueInArray($data['paccepted_changeflight']);
        $data['accept_certify_info'] = $this->_valCheckBoxValueInArray($data['accept_certify_info']);

        /* $data['is_primary'] = 1; */
        $id  = $this->clients_model->add($data, true);
        if ($id) {
            $contactData = [
                'firstname' => $data['first_name'],
                'lastname' => $data['last_name'],
                'email' => $data['client_email'],
                'phonenumber' => $data['phonenumber'],
                'is_primary' => 1
            ];

            $client_id = $this->clients_model->add_contact($contactData, $id);

            if (!$client_id) {
                echo 'error on creating client contact';
                die;
            }

            $primary_contact_id = get_primary_contact_user_id($id);

            /* set the news files (images) */
            if (is_file($_FILES['ppassport_pic']['tmp_name']) && is_uploaded_file($_FILES['ppassport_pic']['tmp_name'])) {
                $this->upload_image('ppassport_pic', $id);
            }

            $this->_imageControl('pfront_pic', $id, $lead->id, $lead->frontPic);
            $this->_imageControl('pr_side_pic', $id, $lead->id, $lead->latPicRight);
            $this->_imageControl('pl_side_pic', $id, $lead->id, $lead->latPicLeft);
            $this->_imageControl('pback_pic', $id, $lead->id, $lead->backPic);

            if (!has_permission('customers', '', 'view') && get_option('auto_assign_customer_admin_after_lead_convert') == 1) {
                $this->db->insert(db_prefix() . 'customer_admins', [
                    'date_assigned' => date('Y-m-d H:i:s'),
                    'customer_id'   => $id,
                    'staff_id'      => get_staff_user_id(),
                ]);
            }

            if (isset($data['leadid'])) {
                $this->leads_model->log_lead_activity($data['leadid'], 'not_lead_activity_converted', false, serialize([
                    get_staff_full_name(),
                ]));

                // Check if lead email is different then client email
                $contact = $this->clients_model->get_contact(get_primary_contact_user_id($id));
                if ($contact->email != $original_lead_email) {
                    if ($original_lead_email != '') {
                        $this->leads_model->log_lead_activity($data['leadid'], 'not_lead_activity_converted_email', false, serialize([
                            $original_lead_email,
                            $contact->email,
                        ]));
                    }
                }

                // set the lead to status client in case is not status client
                $this->db->where('isdefault', 1);
                $status_client_id = $this->db->get(db_prefix() . 'leads_status')->row()->id;
                $this->db->where('id', $data['leadid']);
                $this->db->update(db_prefix() . 'leads', [
                    'status' => $status_client_id,
                ]);

                set_alert('success', _l('lead_to_client_base_converted_success'));

                if (is_gdpr() && get_option('gdpr_after_lead_converted_delete') == '1') {
                    // When lead is deleted
                    // move all proposals to the actual customer record
                    $this->db->where('rel_id', $data['leadid']);
                    $this->db->where('rel_type', 'lead');
                    $this->db->update('proposals', [
                        'rel_id'   => $id,
                        'rel_type' => 'customer',
                    ]);

                    $this->leads_model->delete($data['leadid']);

                    $this->db->where('userid', $id);
                    $this->db->update(db_prefix() . 'clients', ['leadid' => null]);
                }

                log_activity('Created Lead Client Profile [LeadID: ' . $data['leadid'] . ', ClientID: ' . $id . ']');
                hooks()->do_action('lead_converted_to_customer', ['lead_id' => $data['leadid'], 'customer_id' => $id]);
            }

            $response = [
                'code' => 1,
                'msg' => 'client Created sucessfully',
                'redirect' => admin_url('patients/patient/' . $id . '?group=profile')
            ];
        } else {
            $response = [
                'code' => 0,
                'msg' => 'error on creating client'
            ];
        }

        return $response;
    }

    public function convert_patient2($leadId)
    {
        if ($this->input->post()){

            $default_country  = get_option('customer_default_country');

            $data=[];

            if ($leadId != '') {
                $lead = $this->leads_model->get($leadId);

                if (!$lead) {
                    header('HTTP/1.0 404 Not Found');
                    echo _l('lead_not_found');
                    die;
                }
            }

            if ($lead) {
                $original_lead_email = $lead->email;

                $data['phearaboutus'] = $lead->howYouFindUs;
                $data['leadid'] = $lead->id;
                $data['first_name'] = $lead->name;
                $data['last_name'] = '';
                $data['age'] = empty($lead->age) ? 0 : $lead->age;
                $data['phonenumber'] = $lead->phonenumber;
                $data['client_email'] = $lead->email;
                $data['pweight'] = $lead->weight;
                $data['pheightfeet'] = $lead->heightfeet;
                $data['pheightinches'] = $lead->heightinches;
                $data['pkids'] = $lead->children;
                $data['pasthma'] = $lead->asthma;
                $data['pallergies'] = $lead->allergies;
                $data['pdiabetes'] = $lead->diabetes;
                $data['psmoker'] = $lead->smoke;
                $data['poral_cont'] = $lead->contraceptives;
                $data['pvitamins'] = $lead->meds;
                $data['preason'] = $lead->procedures;
                $data['pprocedures'] = $lead->surgery_date;
                $data['country'] = $default_country;          
                
                if ($lead->frontPic != null && !(substr($lead->frontPic, 0, strlen('http')) === 'http') ) {
                    $data['pfront_pic'] =  site_url("./uploads/leads/user_" . $lead->id . "/" . $lead->frontPic);
                }
                if ($lead->latPicRight != null && !(substr($lead->latPicRight, 0, strlen('http')) === 'http') ) {
                    $data['pr_side_pic'] =  site_url("./uploads/leads/user_" . $lead->id . "/" . $lead->latPicRight);
                }
                if ($lead->latPicLeft != null && !(substr($lead->latPicLeft, 0, strlen('http')) === 'http') ) {
                    $data['pl_side_pic'] =  site_url("./uploads/leads/user_" . $lead->id . "/" . $lead->latPicLeft);
                }
                if ($lead->backPic != null && !(substr($lead->backPic, 0, strlen('http')) === 'http') ) {
                    $data['pback_pic'] =  site_url("./uploads/leads/user_" . $lead->id . "/" . $lead->backPic);
                }
                
            }

            // comes from second form
            $data['p_formAntecesor'] = '3';

            $default_status = $this->leads_model->get_status('', [
                'isdefault' => 1,
            ]);

            $this->db->where('id', $lead->id);
            $this->db->update(db_prefix() . 'leads', [
                'date_converted' => date('Y-m-d H:i:s'),
                'status'         => 1,
                'junk'           => 0,
                'lost'           => 0,
            ]);

            /* $data['is_primary'] = 1; */
            
            $id  = $this->clients_model->add($data, true);
            if ($id) {
                $contactData = [
                    'firstname' => $data['first_name'],
                    'lastname' => $data['last_name'],
                    'email' => $data['client_email'],
                    'phonenumber' => $data['phonenumber'],
                    'is_primary' => 1
                ];

                $client_id = $this->clients_model->add_contact($contactData, $id);

                if (!$client_id) {
                    echo 'error on creating client contact';
                    die;
                }

                $primary_contact_id = get_primary_contact_user_id($id);            

                if (!has_permission('customers', '', 'view') && get_option('auto_assign_customer_admin_after_lead_convert') == 1) {
                    $this->db->insert(db_prefix() . 'customer_admins', [
                        'date_assigned' => date('Y-m-d H:i:s'),
                        'customer_id'   => $id,
                        'staff_id'      => get_staff_user_id(),
                    ]);
                }

                if (isset($data['leadid'])) {
                    $this->leads_model->log_lead_activity($data['leadid'], 'not_lead_activity_converted', false, serialize([
                        get_staff_full_name(),
                    ]));

                    // Check if lead email is different then client email
                    $contact = $this->clients_model->get_contact(get_primary_contact_user_id($id));
                    if ($contact->email != $original_lead_email) {
                        if ($original_lead_email != '') {
                            $this->leads_model->log_lead_activity($data['leadid'], 'not_lead_activity_converted_email', false, serialize([
                                $original_lead_email,
                                $contact->email,
                            ]));
                        }
                    }

                    // set the lead to status client in case is not status client
                    $this->db->where('isdefault', 1);
                    $status_client_id = $this->db->get(db_prefix() . 'leads_status')->row()->id;
                    $this->db->where('id', $data['leadid']);
                    $this->db->update(db_prefix() . 'leads', [
                        'status' => $status_client_id,
                    ]);

                    set_alert('success', _l('lead_to_client_base_converted_success'));

                    if (is_gdpr() && get_option('gdpr_after_lead_converted_delete') == '1') {
                        // When lead is deleted
                        // move all proposals to the actual customer record
                        $this->db->where('rel_id', $data['leadid']);
                        $this->db->where('rel_type', 'lead');
                        $this->db->update('proposals', [
                            'rel_id'   => $id,
                            'rel_type' => 'customer',
                        ]);

                        $this->leads_model->delete($data['leadid']);

                        $this->db->where('userid', $id);
                        $this->db->update(db_prefix() . 'clients', ['leadid' => null]);
                    }

                    log_activity('Created Lead Client Profile [LeadID: ' . $data['leadid'] . ', ClientID: ' . $id . ']');
                    hooks()->do_action('lead_converted_to_customer', ['lead_id' => $data['leadid'], 'customer_id' => $id]);
                }

                echo '<script>window.location.href = "'.admin_url('patients/patient/' . $id . '?group=profile').'";</script>';

            } 

        }
    }

    public function upload_image($fileKey, $clientID)
    {
        $filePath =  "./uploads/clients/client_" . $clientID . "/";

        if (!is_dir($filePath)) {
            $oldmask = umask(0);
            mkdir($filePath, 0777, TRUE);
            umask($oldmask);
        }

        $config = array(
            'upload_path' => $filePath,
            'allowed_types' => "jpg|png|jpeg|HEIC",
            'overwrite' => TRUE,
            'max_size' => "80000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "17680",
            'max_width' => "20240"
        );

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($fileKey)) {
            $data = array('upload_data' => $this->upload->data());

            $columnToUpdate = [
                $fileKey => $data['upload_data']['file_name']
            ];

            $this->db->where('userid', $clientID);
            $this->db->update(db_prefix() . 'clients', $columnToUpdate);

            log_message('successful', $this->upload->data());
        } else {
            log_message('error', $this->upload->display_errors());
        }
    }

    private function _valCheckBoxValueInArray($data)
    {
        return ($data != null) ? 1 : 0;
    }

    /**
     * upload the new image and delete the old one, or keep the old one if there is no new image
     * 
     * @param $imageName string
     * @param $ClientId string
     * @param $leadId string
     * @param $leadImage string
     * @return void
     */
    private function _imageControl($imageName, $ClientId, $leadId, $leadImage)
    {
        $newImage = false;
        if (is_file($_FILES[$imageName]['tmp_name']) && is_uploaded_file($_FILES[$imageName]['tmp_name'])) {
            $this->upload_image($imageName, $ClientId);
            $newImage = true;
        }

        // delete the old image if the new image exist
        if (is_file("uploads/leads/user_" . $leadId . "/" . $leadImage) && $newImage == true) {
            $unlink = unlink("uploads/leads/user_" . $leadId . "/" . $leadImage);

            if ($unlink == true) {
                log_message('successful', 'delete file: ' . $leadImage);
            } else {
                log_message('error', 'cannot delete file: ' . $leadImage);
            }

            clearstatcache();
        }
        
        if ($newImage == false) {
            $filePath =  "./uploads/leads/user_" . $leadId . "/" . $leadImage;
            $newPath = "./uploads/clients/client_" . $ClientId . "/" . $leadImage;

            $success = rename($filePath , $newPath);

            if ($success) {
                $this->db->where('userid', $ClientId);
                $this->db->update(db_prefix() . 'clients', [
                    $imageName => $leadImage
                ]);

                log_message('successful', 'moved file: ' . $leadImage);
            } else {
                log_message('error', 'cannot move file: ' . $leadImage);
            }
        }
    }
}

/* https://forms.zohopublic.com/surgicoordinator/form/ClinicHistory/publicrecord/-SrGhZEXv2K8pHCAAjywJzbrE6zQsTGvCkAbY3M27wA/save */