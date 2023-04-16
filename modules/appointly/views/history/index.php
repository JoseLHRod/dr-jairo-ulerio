<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
     'id',
     'subject',
     'description',
     'firstname as creator_firstname',
     'lastname as creator_lastname',
     'CONCAT(date, \' \', start_hour) as date',
     'finished',
     'source'
];


$sIndexColumn = 'id';
$sTable       = db_prefix() . 'appointly_appointments';

$where  = [];

if (!is_admin() && !staff_appointments_responsible()) {
     array_push($where, 'AND (' . db_prefix() . 'appointly_appointments.created_by=' . get_staff_user_id() . ') 
    OR ' . db_prefix() . 'appointly_appointments.id 
    IN (SELECT appointment_id FROM ' . db_prefix() . 'appointly_attendees WHERE staff_id=' . get_staff_user_id() . ')');
}

$where[] = 'AND finished = 1';

$join = [
     'LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'appointly_appointments.created_by',
];

$additionalSelect = [
     'approved',
     'created_by',
     'name',
     db_prefix() . 'appointly_appointments.email as contact_email',
     db_prefix() . 'appointly_appointments.phone',
     'cancelled',
     'contact_id',
     'google_calendar_link',
     'google_added_by_id',
     'outlook_calendar_link',
     'outlook_added_by_id',
     'outlook_event_id',
     'feedback'
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);
// var_dump(get_instance()->db->last_query());
// die;
$output  = $result['output'];
$rResult = $result['rResult'];

// var_dump(get_instance()->db->last_query());
// die;
foreach ($rResult as $aRow) {

     $label_class = 'primary';
     $tooltip = '';

     // Check with Perfex CRM default timezone configured in Setup->Settings->Localization
     if (date('Y-m-d H:i', strtotime($aRow['date'])) < date('Y-m-d H:i')) {
          $label_class = 'danger';
          $tooltip = 'data-toggle="tooltip" title="' . _l('appointment_missed') . '"';
     }

     $row = [];

     $row[] = $aRow['id'];
     $row[] = '<a href="' . admin_url('appointly/appointments/view?appointment_id=' . $aRow['id']) . '">' . $aRow['subject'] . '</a>';
     $row[] = '<span  ' . $tooltip . ' class="label label-' . $label_class . '">' . _dt($aRow['date']) . '</span>';

     if ($aRow['creator_firstname']) {
          $staff_fullname = $aRow['creator_firstname'] . ' ' . $aRow['creator_lastname'];

          $row[] = '<a class="initiated_by" target="_blank" href="' . admin_url() . "profile/" . $aRow["created_by"] . '"><img src="' . staff_profile_image_url($aRow["created_by"], "small") . '" data-toggle="tooltip" data-title="' . $staff_fullname . '" class="staff-profile-image-small mright5" data-original-title="" title="' . $staff_fullname . '">' . $staff_fullname . '</a>';
     } else {
          $row[] = $aRow['name'];
     }

     $row[] = $aRow['description'];

     if ($aRow['cancelled'] && $aRow['finished'] == 0) {

          $row[] = '<span class="label label-danger">' . strtoupper(_l('appointment_cancelled')) . '</span>';
     } else if (!$aRow['finished'] && !$aRow['cancelled'] && date('Y-m-d H:i', strtotime($aRow['date'])) < date('Y-m-d H:i')) {

          $row[] = '<span class="label label-danger">' . strtoupper(_l('appointment_missed_label')) . '</span>';
     } else if (!$aRow['finished'] && !$aRow['cancelled'] && $aRow['approved'] == 1) {

          $row[] = '<span class="label label-info">' . strtoupper(_l('appointment_upcoming')) . '</span>';
     } else if (!$aRow['finished'] && !$aRow['cancelled'] && $aRow['approved'] == 0) {

          $row[] = '<span class="label label-warning">' . strtoupper(_l('appointment_pending_approval')) . '</span>';
     } else {
          $row[] = '<span class="label label-success">' . strtoupper(_l('appointment_finished')) . '</span>';
     }


     if ($aRow['source'] == 'external') {
          $row[] = _l('appointments_source_external_label');
     }
     if ($aRow['source'] == 'internal') {
          $row[] = _l('appointments_source_internal_label');
     }
     if ($aRow['source'] == 'lead_related') {
          $row[] = _l('lead');
     }

     $options = '';

     // If contact id is not 0 then it means that contact is internal as for that dont show convert to lead
     $isContact = ($aRow['contact_id']) ? 0 : 1;
     $options .= '
                <div class="btn-group" data-toggle="tooltip" title="' . _l('appointments_select_option') . '">
                <button class="btn btn-primary-options btn-xs dropdown-toggle appointly_dropdown_options" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fa fa-tasks"></i>
                </button>
                <ul class="dropdown-menu">
                <li><a data-toggle="tooltip" title="' . _l('appointment_view_meeting') . '" href="' . admin_url('appointly/appointments/view?appointment_id=' . $aRow['id']) . '">' . _l('view') . '</a></li>';

     // If there is no feedback from client and if appintment is marked as finished
     if ($aRow['feedback'] !== NULL && $aRow['finished'] !== 1) {
          $options .= '  <li><a data-toggle="tooltip" title="' . _l('appointment_view_feedback') . '" href="' . admin_url('appointly/appointments/view?appointment_id=' . $aRow['id']) . '#feedback_wrapper">' . _l('appointment_view_feedback') . '</a></li>';
     } else if ($aRow['finished'] == 1) {
          $options .= '<li><a onclick="request_appointment_feedback(\'' . $aRow['id'] . '\')" data-toggle="tooltip" title="' . _l('appointments_request_feedback_from_client') . '" href="#">' . _l('appointments_request_feedback') . '</a></li>';
     }

     if (staff_can('delete', 'appointments') && $aRow['created_by'] == get_staff_user_id() || staff_appointments_responsible()) {
          $options .= '<li><a id="confirmDelete" data-toggle="tooltip" title="' . _l('appointment_dismiss_meeting') . '" href="" onclick="deleteAppointment(' . $aRow['id'] . ',this); return false;"><i class="fa fa-trash text-danger"></i> ' . _l('delete') . '</a></li>';
     }

     $options .= '</ul>';
     $options .= '</div>';

     if (staff_can('edit', 'appointments') || staff_appointments_responsible()) {
          $options .= '<button class="btn btn-primary btn-xs mleft5" data-toggle="tooltip" title="' . _l('appointment_edit_history_notes') . '" data-id="' . $aRow['id'] . '" onclick="editAppointmentNotes(this)"><i class="fa fa-edit"></i></button>';
     }

     if (
          $aRow['google_calendar_link'] !== null
          && $aRow['google_added_by_id'] == get_staff_user_id()
     ) {
          $options .= '<a data-toggle="tooltip" title="' . _l('appointment_open_google_calendar') . '" href="' . $aRow['google_calendar_link'] . '" target="_blank" class="btn btn-primary-google btn-xs mleft5"><i class="fa fa-google" aria-hidden="true"></i></a>';
     }

     if (
          $aRow['outlook_calendar_link'] !== null
          && $aRow['outlook_added_by_id'] == get_staff_user_id()
     ) {
          $options .= '<a data-outlook-id="' . $aRow['outlook_event_id'] . '" id="outlookLink" data-toggle="tooltip" title="' . _l('appointment_open_outlook_calendar') . '" href="' . $aRow['outlook_calendar_link'] . '" target="_blank" class="btn btn-primary-outlook btn-xs mleft5 float-right"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
     }


     $row[] = $options;

     $output['aaData'][] = $row;
}
