<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Emails extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('emails_model');
        $this->load->helper('bmi_calculator');
    }

    /* List all email templates */
    public function index()
    {
        if (!has_permission('email_templates', '', 'view')) {
            access_denied('email_templates');
        }
        $langCheckings = get_option('email_templates_language_checks');
        if ($langCheckings == '') {
            $langCheckings = [];
        } else {
            $langCheckings = unserialize($langCheckings);
        }


        $this->db->where('language', 'english');
        $email_templates_english = $this->db->get(db_prefix() . 'emailtemplates')->result_array();
        foreach ($this->app->get_available_languages() as $avLanguage) {
            if ($avLanguage != 'english') {
                foreach ($email_templates_english as $template) {

                    // Result is cached and stored in database
                    // This page may perform 1000 queries per request
                    if (isset($langCheckings[$template['slug'] . '-' . $avLanguage])) {
                        continue;
                    }

                    $notExists = total_rows(db_prefix() . 'emailtemplates', [
                        'slug'     => $template['slug'],
                        'language' => $avLanguage,
                    ]) == 0;

                    $langCheckings[$template['slug'] . '-' . $avLanguage] = 1;

                    if ($notExists) {
                        $data              = [];
                        $data['slug']      = $template['slug'];
                        $data['type']      = $template['type'];
                        $data['language']  = $avLanguage;
                        $data['name']      = $template['name'] . ' [' . $avLanguage . ']';
                        $data['subject']   = $template['subject'];
                        $data['message']   = '';
                        $data['fromname']  = $template['fromname'];
                        $data['plaintext'] = $template['plaintext'];
                        $data['active']    = $template['active'];
                        $data['order']     = $template['order'];
                        $this->db->insert(db_prefix() . 'emailtemplates', $data);
                    }
                }
            }
        }

        update_option('email_templates_language_checks', serialize($langCheckings));

        $data['staff'] = $this->emails_model->get([
            'type'     => 'staff',
            'language' => 'english',
        ]);

        $data['credit_notes'] = $this->emails_model->get([
            'type'     => 'credit_note',
            'language' => 'english',
        ]);

        $data['tasks'] = $this->emails_model->get([
            'type'     => 'tasks',
            'language' => 'english',
        ]);
        $data['client'] = $this->emails_model->get([
            'type'     => 'client',
            'language' => 'english',
        ]);
        $data['tickets'] = $this->emails_model->get([
            'type'     => 'ticket',
            'language' => 'english',
        ]);
        $data['invoice'] = $this->emails_model->get([
            'type'     => 'invoice',
            'language' => 'english',
        ]);
        $data['estimate'] = $this->emails_model->get([
            'type'     => 'estimate',
            'language' => 'english',
        ]);
        $data['contracts'] = $this->emails_model->get([
            'type'     => 'contract',
            'language' => 'english',
        ]);
        $data['proposals'] = $this->emails_model->get([
            'type'     => 'proposals',
            'language' => 'english',
        ]);
        $data['projects'] = $this->emails_model->get([
            'type'     => 'project',
            'language' => 'english',
        ]);
        $data['leads'] = $this->emails_model->get([
            'type'     => 'leads',
            'language' => 'english',
        ]);
        $data['mailboxs'] = $this->emails_model->get([
            'type'     => 'mailbox',
            'language' => 'english',
        ]);

        $data['gdpr'] = $this->emails_model->get([
            'type'     => 'gdpr',
            'language' => 'english',
        ]);

        $data['subscriptions'] = $this->emails_model->get([
            'type'     => 'subscriptions',
            'language' => 'english',
        ]);

        $data['title'] = _l('email_templates');

        $data['hasPermissionEdit'] = has_permission('email_templates', '', 'edit');

        $this->load->view('admin/emails/email_templates', $data);
    }

    /* Edit email template */
    public function email_template($id)
    {
        if (!has_permission('email_templates', '', 'view')) {
            access_denied('email_templates');
        }
        if (!$id) {
            redirect(admin_url('emails'));
        }

        if ($this->input->post()) {
            if (!has_permission('email_templates', '', 'edit')) {
                access_denied('email_templates');
            }

            $data = $this->input->post();
            $data["show_on_proposal"] = !isset($data["show_on_proposal"]) ? 0 : ($data["show_on_proposal"] == 'on' ? 1 : 0);
            $tmp  = $this->input->post(null, false);

            foreach ($data['message'] as $key => $contents) {
                $data['message'][$key] = $tmp['message'][$key];
            }

            foreach ($data['subject'] as $key => $contents) {
                $data['subject'][$key] = $tmp['subject'][$key];
            }

            $data['fromname'] = $tmp['fromname'];

            $success = $this->emails_model->update($data, $id);

            if ($success) {
                set_alert('success', _l('updated_successfully', _l('email_template')));
            }

            redirect(admin_url('emails/email_template/' . $id));
        }

        // English is not included here
        $data['available_languages'] = $this->app->get_available_languages();

        if (($key = array_search('english', $data['available_languages'])) !== false) {
            unset($data['available_languages'][$key]);
        }

        $data['available_merge_fields'] = $this->app_merge_fields->all();

        $template = $this->emails_model->get_email_template_by_id($id);

        $data['template'] = $template;

        $title            = $data['template']->name;
        $data['title']    = $title;
        $this->load->view('admin/emails/template', $data);
    }

    public function enable_by_type($type)
    {
        if (has_permission('email_templates', '', 'edit')) {
            $this->emails_model->mark_as_by_type($type, 1);
        }
        redirect(admin_url('emails'));
    }

    public function disable_by_type($type)
    {
        if (has_permission('email_templates', '', 'edit')) {
            $this->emails_model->mark_as_by_type($type, 0);
        }
        redirect(admin_url('emails'));
    }

    public function enable($id)
    {
        if (has_permission('email_templates', '', 'edit')) {
            $template = $this->emails_model->get_email_template_by_id($id);
            $this->emails_model->mark_as($template->slug, 1);
        }
        redirect(admin_url('emails'));
    }

    public function disable($id)
    {
        if (has_permission('email_templates', '', 'edit')) {
            $template = $this->emails_model->get_email_template_by_id($id);
            $this->emails_model->mark_as($template->slug, 0);
        }

        redirect(admin_url('emails'));
    }

    public function delete($id)
    {
        if (has_permission('email_templates', '', 'edit')) $this->emails_model->did_delete_row($id);
        redirect(admin_url('emails'));
    }

    public function remove_from_proposal($id)
    {
        if (has_permission('email_templates', '', 'edit')) {
            $template = $this->emails_model->get_email_template_by_id($id);
            $this->emails_model->show_on_proposals($template->slug, 0);
        }
        redirect(admin_url('emails'));
    }

    public function add_to_proposal($id)
    {
        if (has_permission('email_templates', '', 'edit')) {
            $template = $this->emails_model->get_email_template_by_id($id);
            $this->emails_model->show_on_proposals($template->slug, 1);
        }
        redirect(admin_url('emails'));
    }

    /* Since version 1.0.1 - test your smtp settings */
    public function sent_smtp_test_email()
    {
        if ($this->input->post()) {
            $this->load->config('email');
            // Simulate fake template to be parsed
            $template           = new StdClass();
            $template->message  = get_option('email_header') . 'This is test SMTP email. <br />If you received this message that means that your SMTP settings is set correctly.' . get_option('email_footer');
            $template->fromname = get_option('companyname') != '' ? get_option('companyname') : 'TEST';
            $template->subject  = 'SMTP Setup Testing';

            $template = parse_email_template($template);

            hooks()->do_action('before_send_test_smtp_email');
            $this->email->initialize();
            if (get_option('mail_engine') == 'phpmailer') {

                $this->email->set_debug_output(function ($err) {
                    if (!isset($GLOBALS['debug'])) {
                        $GLOBALS['debug'] = '';
                    }
                    $GLOBALS['debug'] .= $err . '<br />';

                    return $err;
                });

                $this->email->set_smtp_debug(3);
            }

            $this->email->set_newline(config_item('newline'));
            $this->email->set_crlf(config_item('crlf'));

            $this->email->from(get_option('smtp_email'), $template->fromname);
            $this->email->to($this->input->post('test_email'));

            $systemBCC = get_option('bcc_emails');

            if ($systemBCC != '') {
                $this->email->bcc($systemBCC);
            }

            $this->email->subject($template->subject);
            $this->email->message($template->message);

            if ($this->email->send(true)) {
                set_alert('success', 'Seems like your SMTP settings is set correctly. Check your email now.');
                hooks()->do_action('smtp_test_email_success');
            } else {

                set_debug_alert('<h1>Your SMTP settings are not set correctly here is the debug log.</h1><br />' . $this->email->print_debugger() . (isset($GLOBALS['debug']) ? $GLOBALS['debug'] : ''));

                hooks()->do_action('smtp_test_email_failed');
            }
        }
    }

    public function add($type)
    {

        if (!has_permission('email_templates', '', 'view')) {
            access_denied('email_templates');
        }

        // English is not included here
        $available_languages = $this->app->get_available_languages();
        
        $english = array_search('english', $available_languages);
        
        if ($english) {
            unset($available_languages[$english]);
        }
        
        $data['available_languages'] = $available_languages;
        $available_merge_fields = $this->app_merge_fields->all(true);

        foreach ($available_merge_fields as $field) {
            foreach ($field as $key => $value) {
                if ($key == $type) {
                    $data['available_merge_fields'] = $value;
                }
            }
        }
        
        if($type === 'mailbox') $data['available_merge_fields'] = [];

        /* check form submit or not */
        if ($this->input->post()) {
            $postData = $this->input->post();

            $template = [
                'type' => $type,
                'slug' =>  $postData['name'],
                'name' =>  $postData['name'],
                'language' => 'english',
                'subject' => $postData['subject'][0],
                'message' =>  $postData['message']['english'],
                'fromname' => $postData['fromname'],
                'active' => '1',
                'show_on_proposal' => !isset($postData["show_on_proposal"]) ? 0 : ($postData["show_on_proposal"] == 'on' ? 1 : 0),
            ];
        }

        $data['template'] = (object)[
            'emailtemplateid' => '',
            'type' => $type,
            'slug' => '',
            'language' => '',
            'name' => '',
            'subject' => '',
            'message' => '',
            'fromname' => '',
            'fromemail' => '',
            'plaintext' => '',
            'active' => '1',
            ];

        if ($this->input->post()) {
            $success = $this->emails_model->add_template($template);
            $data['success'] = $success;
        }

        $this->load->view('admin/emails/email_templates_add', $data);
    }

    public function addToEmails($data)
    {
        $customData = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'phonenumber' => $data['phonenumber'],
            'status' => 4,
            'source' => 3,
            'age' => $data['age'],
            'weight' => $data['weight'],
            'height' => $data['height'],
            'diabetes' => $data['diabetes'],
            'asthma' => $data['asthma'],
            'smoke' => $data['smoke'],
            'surgeries' => $data['surgeries'],
            'disease' => $data['disease'],
            'allergies' => $data['allergies'],
            'meds' => $data['meds'],
            'contraceptives' => $data['contraceptives'],
            'hospitalized' => $data['hospitalized'],
            'relatives' => $data['relatives'],
            'children' => $data['children'],
            'procedures' => $data['procedures'],
            'surgery_date' => $data['surgery_date'],
            'bmi' => 24,
            'howYouFindUs' => implode(", ", $data['howYouFindUs'])
        );

        $id = $this->leads_model->add($customData);

        return json_encode([
            'success'  => $id ? true : false,
            'id'       => $id,
            'message'  => $id ? 'client added sucessfully.' : 'It has been an error.'
        ]);
    }
}
