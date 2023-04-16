<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Form extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        /* load base_url */
        $this->load->helper('url');
        $this->load->helper('bmi_calculator');

        // access leads
        $this->load->model('leads_model');
    }

    public function index($id = '')
    {
        if ($id != '') {
            $lead = $this->leads_model->get($id);

            if (!$lead) {
                header('HTTP/1.0 404 Not Found');
                show_404();
                die;
            }
        }

        /* check form submit or not */
        if ($this->input->post()) {
            /* Post data */
            $clientData = $this->input->post();
            /* Add Lead */
            $res = $this->addToLeads($clientData);
            echo $res;
        } else {
            $data = [
                'name' => $lead->name,
                'phone' => $lead->phonenumber,
                'age' => $lead->age,
                'weight' => $lead->weight,
                'heightfeet' => $lead->heightfeet,
                'heightinches' => $lead->heightinches,
                'email' => $lead->email
            ];
            $this->load->view('forms/addNewClient', $data);
        }
    }

    public function addToLeads($data) {

        $bmi = bmi_calculator($data);

        $customData = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'phonenumber' => $data['phonenumber'],
            'status' => bmi_calculator_status($bmi),
            'source' => 3,
            'age' => $data['age'],
            'weight' => $data['weight'],
            'heightfeet' => $data['heightfeet'],
            'heightinches' => $data['heightinches'],
            'diabetes' => $this->valCheckBoxValueInArray($data['diabetes']),
            'asthma' => $this->valCheckBoxValueInArray($data['asthma']),
            'smoke' => $this->valCheckBoxValueInArray($data['smoke']),
            'surgeries' => $this->valCheckBoxValueInArray($data['surgeries']),
            'disease' => $this->valCheckBoxValueInArray($data['disease']),
            'allergies' => $this->valCheckBoxValueInArray($data['allergies']),
            'meds' => $data['meds'],
            'contraceptives' => $this->valCheckBoxValueInArray($data['diabetes']),
            'hospitalized' => $this->valCheckBoxValueInArray($data['hospitalized']),
            'relatives' => $this->valCheckBoxValueInArray($data['relatives']),
            'children' => $this->valCheckBoxValueInArray($data['children']),
            'procedures' => $data['procedures'],
            'surgery_date' => $data['surgery_date'],
            'bmi' => $bmi,
            'howYouFindUs' => $data['howYouFindUs'] ? implode(", ", $data['howYouFindUs']) : '',
        );

        if (isset($data['id']) && $data['id']!='') {
            $id = $this->leads_model->update($customData, $data['id']);
            $message = $id ? 'Lead updated sucessfully.' : 'It has been an error updating the lead.';

            if ($id) {
                if (is_file($_FILES['frontPic']['tmp_name']) && is_uploaded_file($_FILES['frontPic']['tmp_name'])) {
                    $this->upload_image('frontPic', $id);
                }

                if (is_file($_FILES['latPicLeft']['tmp_name']) && is_uploaded_file($_FILES['latPicLeft']['tmp_name'])) {
                    $this->upload_image('latPicLeft', $id);
                }

                if (is_file($_FILES['latPicRight']['tmp_name']) && is_uploaded_file($_FILES['latPicRight']['tmp_name'])) {
                    $this->upload_image('latPicRight', $id);
                }

                if (is_file($_FILES['backPic']['tmp_name']) && is_uploaded_file($_FILES['backPic']['tmp_name'])) {
                    $this->upload_image('backPic', $id);
                }
            }

            $response = json_encode([
                'code'  => $id ? 0 : 1,
                'id'       => $id,
                'msg' => $message,
                'redirect' => admin_url('leads')
            ]);
        } else {
            $id = $this->leads_model->add($customData);
            $message = $id ? 'Lead added sucessfully.' : 'It has been an error.';

            if ($id) {
                if (is_file($_FILES['frontPic']['tmp_name']) && is_uploaded_file($_FILES['frontPic']['tmp_name'])) {
                    $this->upload_image('frontPic', $id);
                }

                if (is_file($_FILES['latPicLeft']['tmp_name']) && is_uploaded_file($_FILES['latPicLeft']['tmp_name'])) {
                    $this->upload_image('latPicLeft', $id);
                }

                if (is_file($_FILES['latPicRight']['tmp_name']) && is_uploaded_file($_FILES['latPicRight']['tmp_name'])) {
                    $this->upload_image('latPicRight', $id);
                }

                if (is_file($_FILES['backPic']['tmp_name']) && is_uploaded_file($_FILES['backPic']['tmp_name'])) {
                    $this->upload_image('backPic', $id);
                }
            }

            $response = json_encode([
                'code'  => $id ? 0 : 1,
                'id'       => $id,
                'msg' => $message,
                'redirect' => admin_url('leads')
            ]);
        }
        
        return $response;

    }

    public function upload_image($fileKey, $userId) {
        $filePath =  "./uploads/leads/user_" . $userId . "/";

        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, TRUE);
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

        if($this->upload->do_upload($fileKey))
        {
            $data = array('upload_data' => $this->upload->data());

            $columnToUpdate = [
                $fileKey => $data['upload_data']['file_name']
            ];

            $this->db->where('id', $userId);
            $this->db->update(db_prefix() . 'leads', $columnToUpdate); 

            log_message('successful', $this->upload->data());
        } else {
            log_message('error', $this->upload->display_errors());
        }
    }

    private function valCheckBoxValueInArray($data)
    {
        return ($data != null) ? 1 : 0;
    }
}