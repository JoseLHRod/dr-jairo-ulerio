<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="<?php if ($openEdit == true) {
               echo 'open-edit ';
            } ?>lead-wrapper" <?php if (isset($lead) && ($lead->junk == 1 || $lead->lost == 1)) {
                                 echo 'lead-is-junk-or-lost';
                              } ?>>
   <?php if (isset($lead)) { ?>
      <?php require('modules/appointly/assets/js/index_main_js.php'); ?>
      <?php hooks()->do_action('lead_modal_profile_bottom', ($lead->id)); ?>
      <div class="btn-group pull-left lead-actions-left">
         <a href="#" lead-edit class="mright10 font-medium-xs pull-left<?php if ($lead_locked == true) {
                                                                           echo ' hide';
                                                                        } ?>">
            <?php echo _l('edit'); ?>
            <i class="fa fa-pencil-square-o"></i>
         </a>
         <a href="#" class="font-medium-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="lead-more-btn">
            <?php echo _l('more'); ?>
            <span class="caret"></span>
         </a>
         <ul class="dropdown-menu dropdown-menu-left" id="lead-more-dropdown">
            <?php if ($lead->junk == 0) {
               if ($lead->lost == 0 && (total_rows(db_prefix() . 'clients', array('leadid' => $lead->id)) == 0)) { ?>
                  <li>
                     <a href="#" onclick="lead_mark_as_lost(<?php echo $lead->id; ?>); return false;">
                        <i class="fa fa-mars"></i>
                        <?php echo _l('lead_mark_as_lost'); ?>
                     </a>
                  </li>
               <?php } else if ($lead->lost == 1) { ?>
                  <li>
                     <a href="#" onclick="lead_unmark_as_lost(<?php echo $lead->id; ?>); return false;">
                        <i class="fa fa-smile-o"></i>
                        <?php echo _l('lead_unmark_as_lost'); ?>
                     </a>
                  </li>
               <?php } ?>
            <?php } ?>
            <!-- mark as junk -->
            <?php if ($lead->lost == 0) {
               if ($lead->junk == 0 && (total_rows(db_prefix() . 'clients', array('leadid' => $lead->id)) == 0)) { ?>
                  <li>
                     <a href="#" onclick="lead_mark_as_junk(<?php echo $lead->id; ?>); return false;">
                        <i class="fa fa fa-times"></i>
                        <?php echo _l('lead_mark_as_junk'); ?>
                     </a>
                  </li>
               <?php } else if ($lead->junk == 1) { ?>
                  <li>
                     <a href="#" onclick="lead_unmark_as_junk(<?php echo $lead->id; ?>); return false;">
                        <i class="fa fa-smile-o"></i>
                        <?php echo _l('lead_unmark_as_junk'); ?>
                     </a>
                  </li>
               <?php } ?>
            <?php } ?>
            <?php if (((is_lead_creator($lead->id) || has_permission('leads', '', 'delete')) && $lead_locked == false) || is_admin()) { ?>
               <li>
                  <a href="<?php echo admin_url('leads/delete/' . $lead->id); ?>" class="text-danger delete-text _delete" data-toggle="tooltip" title="">
                     <i class="fa fa-remove"></i>
                     <?php echo _l('lead_edit_delete_tooltip'); ?>
                  </a>
               </li>
            <?php } ?>
         </ul>
      </div>
      <a data-toggle="tooltip" class="btn btn-default pull-right lead-print-btn lead-top-btn lead-view mleft5" onclick="print_lead_information(); return false;" data-placement="top" title="<?php echo _l('print'); ?>" href="#">
         <i class="fa fa-print"></i>
      </a>
      <?php
      $client = false;
      $convert_to_client_tooltip_email_exists = '';
      if (total_rows(db_prefix() . 'contacts', array('email' => $lead->email)) > 0 && total_rows(db_prefix() . 'clients', array('leadid' => $lead->id)) == 0) {
         $convert_to_client_tooltip_email_exists = _l('lead_email_already_exists');
         $text = _l('lead_convert_to_client');
         $textToForm = _l('lead_convert_to_client_form');
      } else if (total_rows(db_prefix() . 'clients', array('leadid' => $lead->id))) {
         $client = true;
      } else {
         $text = _l('lead_convert_to_client');
         $textToForm = _l('lead_convert_to_client_form');
      }
      ?>
      <?php if ($lead_locked == false) { ?>
         <div class="lead-edit<?php if (isset($lead)) {
                                 echo ' hide';
                              } ?>">
            <button type="button" class="btn btn-info pull-right mleft5 lead-top-btn lead-save-btn" onclick="document.getElementById('lead-form-submit').click();">
               <?php echo _l('submit'); ?>
            </button>
         </div>
      <?php } ?>
      <?php if ($client && (has_permission('customers', '', 'view') || is_customer_admin(get_client_id_by_lead_id($lead->id)))) { ?>
         <a data-toggle="tooltip" class="btn btn-success pull-right lead-top-btn lead-view" data-placement="top" title="<?php echo _l('lead_converted_edit_client_profile'); ?>" href="<?php echo admin_url('clients/client/' . get_client_id_by_lead_id($lead->id)); ?>">
            <i class="fa fa-user-o"></i>
         </a>
      <?php } ?>
      <?php if (total_rows(db_prefix() . 'clients', array('leadid' => $lead->id)) == 0) { ?>
         <form action="<?php echo base_url('clinicHistory/convert_patient2/' . $lead->id); ?>" method="post">
         <input type="submit" name="convert" data-toggle="tooltip" data-title="<?php echo $convert_to_client_tooltip_email_exists; ?>" class="btn btn-success pull-right lead-convert-to-customer lead-top-btn lead-view" value="<?php echo $text; ?>">   
         </form>
         <!-- <a href="#" id="createNewAppointment" class="btn pull-right lead-convert-to-customer lead-top-btn lead-view">
            <i class="fa fa-user-o"></i>
            <?php echo _l('appointment_new_appointment'); ?>
      </a> -->
      <?php } ?>
   <?php } ?>
   <div class="clearfix no-margin"></div>

   <?php if (isset($lead)) { ?>

      <div class="row mbot15">
         <hr class="no-margin" />
      </div>

      <div class="alert alert-warning hide mtop20" role="alert" id="lead_proposal_warning">
         <?php echo _l('proposal_warning_email_change', array(_l('lead_lowercase'), _l('lead_lowercase'), _l('lead_lowercase'))); ?>
         <hr />
         <a href="#" onclick="update_all_proposal_emails_linked_to_lead(<?php echo $lead->id; ?>); return false;">
            <?php echo _l('update_proposal_email_yes'); ?>
         </a>
         <br />
         <a href="#" onclick="init_lead_modal_data(<?php echo $lead->id; ?>); return false;">
            <?php echo _l('update_proposal_email_no'); ?>
         </a>
      </div>
   <?php } ?>
   <?php
      if (!isset($lead)) {
         echo '<form method="POST" id="lead_form" enctype="multipart/form-data">';
      } else {
         echo form_open_multipart((isset($lead) ? admin_url('leads/lead/' . $lead->id) : admin_url('leads/lead')), array('id' => 'lead_form'));
      }
   ?>
   <div class="row">
      <div class="lead-view<?php if (!isset($lead)) {
                              echo ' hide';
                           } ?>" id="leadViewWrapper">
         <div class="col-md-4 col-xs-12 lead-information-col">
            <div class="lead-info-heading">
               <h4 class="no-margin font-medium-xs bold">
                  <?php echo _l('lead_info'); ?>
               </h4>
            </div>
            <p class="text-muted lead-field-heading no-mtop"><?php echo _l('lead_add_edit_name'); ?></p>
            <p class="bold font-medium-xs lead-name"><?php echo (isset($lead) && $lead->name != '' ? $lead->name : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_title'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->title != '' ? $lead->title : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_add_edit_email'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->email != '' ? '<a href="https://drjairoulerio.net/dash/admin/mailbox/compose?to_email=' . $lead->email . '">' . $lead->email . '</a>' : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_website'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->website != '' ? '<a href="' . maybe_add_http($lead->website) . '" target="_blank">' . $lead->website . '</a>' : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_add_edit_phonenumber'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->phonenumber != '' ? '<a href="https://wa.me/1' . preg_replace('/\D*/mi','',$lead->phonenumber) . '" target="_blank">' . $lead->phonenumber . '</a>' : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_value'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->lead_value != 0 ? app_format_money($lead->lead_value, $base_currency->symbol) : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_company'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->company != '' ? $lead->company : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_address'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->address != '' ? $lead->address : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_city'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->city != '' ? $lead->city : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_state'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->state != '' ? $lead->state : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_country'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->country != 0 ? get_country($lead->country)->short_name : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_zip'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->zip != '' ? $lead->zip : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_age'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->age != '' ? $lead->age : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_weight'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->weight != '' ? $lead->weight : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_height'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->heightfeet != '' && $lead->heightinches != '' ? $lead->heightfeet."'".$lead->heightinches."''" : '-') ?></p>
            <p class="text-muted lead-field-heading">BMI</p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->bmi != '' ? number_format(floatval($lead->bmi), 2, '.', '') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_diabetes'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->diabetes != null ? ($lead->diabetes == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_asm'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->asthma != null ? ($lead->asthma == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_smoke'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->smoke != null ? ($lead->smoke == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_surgery'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->surgeries != null ? ($lead->surgeries == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_desease'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->disease != null ? ($lead->disease == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_alergy'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->allergies != null ? ($lead->allergies == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_meds'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->meds != '' ? $lead->meds : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_anti'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->contraceptives != null ? ($lead->contraceptives == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_hospitalized'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->hospitalized != null ? ($lead->hospitalized == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_relatives'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->relatives != null ? ($lead->relatives == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_children'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->children != null ? ($lead->children == 1) ? _l('add_client_true') : _l('add_client_false') : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_precedure'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->procedures != '' ? $lead->procedures : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_date'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->surgery_date != '' ? $lead->surgery_date : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('add_client_find_us'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->howYouFindUs != '' ? $lead->howYouFindUs : '-') ?></p>
         </div>
         <div class="col-md-4 col-xs-12 lead-information-col">
            <div class="lead-info-heading">
               <h4 class="no-margin font-medium-xs bold">
                  <?php echo _l('lead_general_info'); ?>
               </h4>
            </div>
            <p class="text-muted lead-field-heading no-mtop"><?php echo _l('lead_add_edit_status'); ?></p>
            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->status_name != '' ? $lead->status_name : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_add_edit_source'); ?></p>
            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->source_name != '' ? $lead->source_name : '-') ?></p>
            <?php if (get_option('disable_language') == 0) { ?>
               <p class="text-muted lead-field-heading"><?php echo _l('localization_default_language'); ?></p>
               <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->default_language != '' ? ucfirst($lead->default_language) : _l('system_default_string')) ?></p>
            <?php } ?>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_add_edit_assigned'); ?></p>
            <p class="bold font-medium-xs mbot15"><?php echo (isset($lead) && $lead->assigned != 0 ? get_staff_full_name($lead->assigned) : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('tags'); ?></p>
            <p class="bold font-medium-xs mbot10">
               <?php
               if (isset($lead)) {
                  $tags = get_tags_in($lead->id, 'lead');
                  if (count($tags) > 0) {
                     echo render_tags($tags);
                     echo '<div class="clearfix"></div>';
                  } else {
                     echo '-';
                  }
               }
               ?>
            </p>
            <p class="text-muted lead-field-heading"><?php echo _l('leads_dt_datecreated'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->dateadded != '' ? '<span class="text-has-action" data-toggle="tooltip" data-title="' . _dt($lead->dateadded) . '">' . time_ago($lead->dateadded) . '</span>' : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('leads_dt_last_contact'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->lastcontact != '' ? '<span class="text-has-action" data-toggle="tooltip" data-title="' . _dt($lead->lastcontact) . '">' . time_ago($lead->lastcontact) . '</span>' : '-') ?></p>
            <p class="text-muted lead-field-heading"><?php echo _l('lead_public'); ?></p>
            <p class="bold font-medium-xs mbot15">
               <?php if (isset($lead)) {
                  if ($lead->is_public == 1) {
                     echo _l('lead_is_public_yes');
                  } else {
                     echo _l('lead_is_public_no');
                  }
               } else {
                  echo '-';
               }
               ?>
            </p>
            <!-- start user image -->
            <?php $filePath =  "/uploads/leads/user_" . $lead->id . "/"; ?>

            <p class="text-muted lead-field-heading"><?php echo _l('front_image'); ?></p>
            <p class="bold font-medium-xs">
               <?php if (isset($lead) && $lead->frontPic != null && !(substr($lead->frontPic, 0, strlen('http')) === 'http') ) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $lead->frontPic); ?>" data-fancybox="gallery" data-caption="Lead Front Picture">
                     <img class="fancyImg" src="<?php echo base_url($filePath . $lead->frontPic); ?>" alt="front-img">
                  </a>
               <?php }elseif (isset($lead) && $lead->frontPic != null && (substr($lead->frontPic, 0, strlen('http')) === 'http')) { ?>
                  <a class="fancyWrapper" href="<?php echo $lead->frontPic; ?>" data-fancybox="gallery" data-caption="Lead Front Picture">
                     <img class="fancyImg" src="<?php echo $lead->frontPic; ?>" alt="front-img">
                  </a>
               <?php } else {
                  echo _l('no_image');
               } ?>
            </p>

            <p class="text-muted lead-field-heading"><?php echo _l('lat_image_l'); ?></p>
            <p class="bold font-medium-xs">
               <?php if (isset($lead) && $lead->latPicLeft != null && !(substr($lead->latPicLeft, 0, strlen('http')) === 'http') ) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $lead->latPicLeft); ?>" data-fancybox="gallery" data-caption="Lead left side Picture">
                     <img class="fancyImg" src="<?php echo base_url($filePath . $lead->latPicLeft); ?>" alt="lateral-left-img">
                  </a>
               <?php }elseif (isset($lead) && $lead->latPicLeft != null && (substr($lead->latPicLeft, 0, strlen('http')) === 'http') ) { ?>
                  <a class="fancyWrapper" href="<?php echo $lead->latPicLeft; ?>" data-fancybox="gallery" data-caption="Lead left side Picture">
                     <img class="fancyImg" src="<?php echo $lead->latPicLeft; ?>" alt="lateral-left-img">
                  </a>
               <?php } else {
                  echo _l('no_image');
               } ?>
            </p>

            <p class="text-muted lead-field-heading"><?php echo _l('lat_image_r'); ?></p>
            <p class="bold font-medium-xs">
               <?php if (isset($lead) && $lead->latPicRight != null && !(substr($lead->latPicRight, 0, strlen('http')) === 'http') ) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $lead->latPicRight); ?>" data-fancybox="gallery" data-caption="Lead right side Picture">
                     <img class="fancyImg" src="<?php echo base_url($filePath . $lead->latPicRight); ?>" alt="lateral-left-img">
                  </a>
               <?php }elseif (isset($lead) && $lead->latPicRight != null && (substr($lead->latPicRight, 0, strlen('http')) === 'http') ) { ?>
                  <a class="fancyWrapper" href="<?php echo $lead->latPicRight; ?>" data-fancybox="gallery" data-caption="Lead right side Picture">
                     <img class="fancyImg" src="<?php echo $lead->latPicRight; ?>" alt="lateral-left-img">
                  </a>
               <?php } else {
                  echo _l('no_image');
               } ?>
            </p>

            <p class="text-muted lead-field-heading"><?php echo _l('back_image'); ?></p>
            <p class="bold font-medium-xs">
               <?php if (isset($lead) && $lead->backPic != null && !(substr($lead->backPic, 0, strlen('http')) === 'http') ) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $lead->backPic); ?>" data-fancybox="gallery" data-caption="Lead back Picture">
                     <img class="fancyImg" src="<?php echo base_url($filePath . $lead->backPic); ?>" alt="lateral-left-img">
                  </a>
               <?php }elseif (isset($lead) && $lead->backPic != null && (substr($lead->backPic, 0, strlen('http')) === 'http') ) { ?>
                  <a class="fancyWrapper" href="<?php echo $lead->backPic; ?>" data-fancybox="gallery" data-caption="Lead back Picture">
                     <img class="fancyImg" src="<?php echo $lead->backPic; ?>" alt="lateral-left-img">
                  </a>
               <?php } else {
                  echo _l('no_image');
               } ?>
            </p>

            <!-- end user image -->

            <?php if (isset($lead) && $lead->from_form_id != 0) { ?>
               <p class="text-muted lead-field-heading"><?php echo _l('web_to_lead_form'); ?></p>
               <p class="bold font-medium-xs mbot15"><?php echo $lead->form_data->name; ?></p>
            <?php } ?>
         </div>
         <div class="col-md-4 col-xs-12 lead-information-col">
            <?php if (total_rows(db_prefix() . 'customfields', array('fieldto' => 'leads', 'active' => 1)) > 0 && isset($lead)) { ?>
               <div class="lead-info-heading">
                  <h4 class="no-margin font-medium-xs bold">
                     <?php echo _l('custom_fields'); ?>
                  </h4>
               </div>
               <?php
               $custom_fields = get_custom_fields('leads');
               foreach ($custom_fields as $field) {
                  $value = get_custom_field_value($lead->id, $field['id'], 'leads'); ?>
                  <p class="text-muted lead-field-heading no-mtop"><?php echo $field['name']; ?></p>
                  <p class="bold font-medium-xs"><?php echo ($value != '' ? $value : '-') ?></p>
               <?php } ?>
            <?php } ?>
         </div>
         <div class="clearfix"></div>
         <div class="col-md-12">
            <p class="text-muted lead-field-heading"><?php echo _l('lead_description'); ?></p>
            <p class="bold font-medium-xs"><?php echo (isset($lead) && $lead->description != '' ? $lead->description : '-') ?></p>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="lead-edit<?php if (isset($lead)) {
                              echo ' hide';
                           } ?>">
         <div class="col-md-4">
            <?php
            $selected = '';
            if (isset($lead)) {
               $selected = $lead->status;
            } else if (isset($status_id)) {
               $selected = $status_id;
            }
            $statuses = array_filter($statuses, function($status){ return $status['statustype'] == 'leads'; });
            echo render_leads_status_select($statuses, $selected, 'lead_add_edit_status');
            ?>
         </div>
         <div class="col-md-4">
            <?php
            $selected = (isset($lead) ? $lead->source : get_option('leads_default_source'));
            echo render_leads_source_select($sources, $selected, 'lead_add_edit_source');
            ?>
         </div>
         <div class="col-md-4">
            <?php
            $assigned_attrs = array();
            $selected = (isset($lead) ? $lead->assigned : get_staff_user_id());
            if (
               isset($lead)
               && $lead->assigned == get_staff_user_id()
               && $lead->addedfrom != get_staff_user_id()
               && !is_admin($lead->assigned)
               && !has_permission('leads', '', 'view')
            ) {
               $assigned_attrs['disabled'] = true;
            }
            echo render_select('assigned', $members, array('staffid', array('firstname', 'lastname')), 'lead_add_edit_assigned', $selected, $assigned_attrs); ?>
         </div>
         <div class="clearfix"></div>
         <hr class="mtop5 mbot10" />
         <div class="col-md-12">
            <div class="form-group no-mbot" id="inputTagsWrapper">
               <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
               <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($lead) ? prep_tags_input(get_tags_in($lead->id, 'lead')) : ''); ?>" data-role="tagsinput">
            </div>
         </div>
         <div class="clearfix"></div>
         <hr class="no-mtop mbot15" />

         <div class="col-md-6">
            <?php $value = (isset($lead) ? $lead->name : ''); ?>
            <?php echo render_input('name', 'lead_add_edit_name', $value); ?>
            <?php $value = (isset($lead) ? $lead->title : ''); ?>
            <?php echo render_input('title', 'lead_title', $value); ?>
            <?php $value = (isset($lead) ? $lead->email : ''); ?>
            <?php echo render_input('email', 'lead_add_edit_email', $value); ?>
            <?php if ((isset($lead) && empty($lead->website)) || !isset($lead)) {
               $value = (isset($lead) ? $lead->website : '');
               echo render_input('website', 'lead_website', $value);
            } else { ?>
               <div class="form-group">
                  <label for="website"><?php echo _l('lead_website'); ?></label>
                  <div class="input-group">
                     <input type="text" name="website" id="website" value="<?php echo $lead->website; ?>" class="form-control">
                     <div class="input-group-addon">
                        <span>
                           <a href="<?php echo maybe_add_http($lead->website); ?>" target="_blank" tabindex="-1">
                              <i class="fa fa-globe"></i>
                           </a>
                        </span>
                     </div>
                  </div>
               </div>
            <?php }
            $value = (isset($lead) ? $lead->phonenumber : ''); ?>
            <?php echo render_input('phonenumber', 'lead_add_edit_phonenumber', $value); ?>
            <div class="form-group">
               <label for="lead_value"><?php echo _l('lead_value'); ?></label>
               <div class="input-group" data-toggle="tooltip" title="<?php echo _l('lead_value_tooltip'); ?>">
                  <input type="number" class="form-control" name="lead_value" value="<?php if (isset($lead)) {
                                                                                          echo $lead->lead_value;
                                                                                       } ?>">
                  <div class="input-group-addon">
                     <?php echo $base_currency->symbol; ?>
                  </div>
               </div>
               </label>
            </div>
            <?php $value = (isset($lead) ? $lead->company : ''); ?>
            <?php echo render_input('company', 'lead_company', $value); ?>

            <?php echo render_yes_no_option_no_settings('diabetes', 'add_client_diabetes'); ?>

            <?php echo render_yes_no_option_no_settings('asthma', 'add_client_asm'); ?>

            <?php echo render_yes_no_option_no_settings('smoke', 'add_client_smoke'); ?>

            <?php echo render_yes_no_option_no_settings('surgeries', 'add_client_surgery'); ?>

            <?php echo render_yes_no_option_no_settings('disease', 'add_client_desease'); ?>

            <?php echo render_yes_no_option_no_settings('allergies', 'add_client_alergy'); ?>

            <?php echo render_yes_no_option_no_settings('contraceptives', 'add_client_anti'); ?>
         </div>
         <div class="col-md-6">
            <?php $value = (isset($lead) ? $lead->address : ''); ?>
            <?php echo render_textarea('address', 'lead_address', $value, array('rows' => 1, 'style' => 'height:36px;font-size:100%;')); ?>
            <?php $value = (isset($lead) ? $lead->city : ''); ?>
            <?php echo render_input('city', 'lead_city', $value); ?>

            <?php $value = (isset($lead) ? $lead->age : ''); ?>
            <?php echo render_input('age', 'add_client_age', $value); ?>

            <?php $value = (isset($lead) ? $lead->weight : ''); ?>
            <?php echo render_input('weight', 'add_client_weight', $value); ?>        

            <div class="form-group" app-field-wrapper="height">

            <label for="height" class="control-label"><?php echo _l('add_client_height'); ?></label>
            <div>
            <label for="heightfeet" style="display: inline-block;float: none;">Feet:</label>
            <?php $value = (isset($lead) ? $lead->heightfeet : ''); ?>
            <input type="number" class="form-control" name="heightfeet" value="<?php echo $value; ?>" min="0" size="2" style="display: inline-block;float: none;width: 15%;border-bottom: 1px solid #DDDDDD;text-align:center;
" required>
            <label for="heightfeet" style="display: inline-block;float: none;">'</label>
            <label for="heightinches" style="display: inline-block;float: none;">Inches:</label>
            <?php $value = (isset($lead) ? $lead->heightinches : ''); ?>
            <input type="number" class="form-control" name="heightinches" value="<?php echo $value; ?>" min="0" size="3" style="display: inline-block;float: none;width: 15%;border-bottom: 1px solid #DDDDDD;text-align:center;
" required>        
            <label for="heightinches" style="display: inline-block;float: none;">''</label> 
            </div>   

            </div>

            <?php $value = (isset($lead) ? $lead->meds : ''); ?>
            <?php echo render_input('meds', 'add_client_meds', $value); ?>

            <?php $value = (isset($lead) ? $lead->state : ''); ?>
            <?php echo render_input('state', 'lead_state', $value); ?>

            <?php
            $countries = get_all_countries();
            $customer_default_country = get_option('customer_default_country');
            $selected = (isset($lead) ? $lead->country : $customer_default_country);
            echo render_select('country', $countries, array('country_id', array('short_name')), 'lead_country', $selected, array('data-none-selected-text' => _l('dropdown_non_selected_tex')));
            ?>
            <?php $value = (isset($lead) ? $lead->zip : ''); ?>
            <?php echo render_input('zip', 'lead_zip', $value); ?>
            <?php if (get_option('disable_language') == 0) { ?>
               <div class="form-group">
                  <label for="default_language" class="control-label"><?php echo _l('localization_default_language'); ?></label>
                  <select name="default_language" data-live-search="true" id="default_language" class="form-control selectpicker" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                     <option value=""><?php echo _l('system_default_string'); ?></option>
                     <?php foreach ($this->app->get_available_languages() as $availableLanguage) {
                        $selected = '';
                        if (isset($lead)) {
                           if ($lead->default_language == $availableLanguage) {
                              $selected = 'selected';
                           }
                        }
                     ?>
                        <option value="<?php echo $availableLanguage; ?>" <?php echo $selected; ?>><?php echo ucfirst($availableLanguage); ?></option>
                     <?php } ?>
                  </select>
               </div>

               <?php echo render_yes_no_option_no_settings('hospitalized', 'add_client_hospitalized'); ?>

               <?php echo render_yes_no_option_no_settings('relatives', 'add_client_relatives'); ?>

               <?php echo render_yes_no_option_no_settings('children', 'add_client_children'); ?>

               <?php $value = (isset($lead) ? $lead->surgery_date : ''); ?>
               <?php echo render_date_input('surgery_date', 'add_client_date', $value); ?>

            <?php } ?>
         </div>
         <div class="col-md-12 form-group">
            <?php $value = (isset($lead) ? $lead->meds : ''); ?>
            <?php echo render_textarea('procedures', 'add_client_precedure', $value); ?>

            <?php $value = (isset($lead) ? $lead->meds : ''); ?>
            <?php echo render_textarea('howYouFindUs', 'add_client_find_us', $value); ?>

            <?php $value = (isset($lead) ? $lead->description : ''); ?>
            <?php echo render_textarea('description', 'lead_description', $value); ?>
            <div class="row">
               <div class="col-md-12">
                  <?php if (!isset($lead)) { ?>
                     <div class="lead-select-date-contacted hide">
                        <?php echo render_datetime_input('custom_contact_date', 'lead_add_edit_datecontacted', '', array('data-date-end-date' => date('Y-m-d'))); ?>
                     </div>
                  <?php } else { ?>
                     <?php echo render_datetime_input('lastcontact', 'leads_dt_last_contact', _dt($lead->lastcontact), array('data-date-end-date' => date('Y-m-d'))); ?>
                  <?php } ?>
                  <div class="checkbox-inline checkbox checkbox-primary<?php if (isset($lead)) {
                                                                           echo ' hide';
                                                                        } ?><?php if (isset($lead) && (is_lead_creator($lead->id) || has_permission('leads', '', 'edit'))) {
                                                                                 echo ' lead-edit';
                                                                              } ?>">
                     <input type="checkbox" name="is_public" <?php if (isset($lead)) {
                                                                  if ($lead->is_public == 1) {
                                                                     echo 'checked';
                                                                  }
                                                               }; ?> id="lead_public">
                     <label for="lead_public"><?php echo _l('lead_public'); ?></label>
                  </div>
                  <?php if (!isset($lead)) { ?>
                     <div class="checkbox-inline checkbox checkbox-primary">
                        <input type="checkbox" name="contacted_today" id="contacted_today" checked>
                        <label for="contacted_today"><?php echo _l('lead_add_edit_contacted_today'); ?></label>
                     </div>
                  <?php } ?>
               </div>
            </div>
         </div>

         <div class="col-md-6">
            <div class="falseInputContainer form-group">
               <span class="falseInputLabel"><?php echo _l('add_client_img_front'); ?></span>

               <input class="file_input simpleFormUpload" name="frontPic" accept="image/*" type="file" />
            </div>

            <div class="falseInputContainer form-group">
               <span class="falseInputLabel"><?php echo _l('add_client_img_lat_1'); ?></span>

               <input class="file_input simpleFormUpload" name="latPicLeft" accept="image/*" type="file" />
            </div>
         </div>

         <div class="col-md-6 form-group">
            <div class="falseInputContainer form-group">
               <span class="falseInputLabel"><?php echo _l('add_client_img_lat_2'); ?></span>

               <input class="file_input simpleFormUpload" name="latPicRight" accept="image/*" type="file" />
            </div>

            <div class="falseInputContainer form-group">
               <span class="falseInputLabel"><?php echo _l('add_client_img_back'); ?></span>
               <input class="file_input simpleFormUpload" name="backPic" accept="image/*" type="file" />
            </div>
         </div>

         <div class="col-md-12 mtop15">
            <?php $rel_id = (isset($lead) ? $lead->id : false); ?>
            <?php echo render_custom_fields('leads', $rel_id); ?>
         </div>
         <div class="clearfix"></div>
      </div>
   </div>
   <?php if (isset($lead)) { ?>
      <div class="lead-latest-activity lead-view">
         <div class="lead-info-heading">
            <h4 class="no-margin bold font-medium-xs"><?php echo _l('lead_latest_activity'); ?></h4>
         </div>
         <div id="lead-latest-activity" class="pleft5"></div>
      </div>
   <?php } ?>
   <?php if ($lead_locked == false) { ?>
      <div class="lead-edit<?php if (isset($lead)) {
                              echo ' hide';
                           } ?>">
         <hr />
         <button type="submit" class="btn btn-info pull-right lead-save-btn" id="lead-form-submit"><?php echo _l('submit'); ?></button>
         <button type="button" class="btn btn-default pull-right mright5" data-dismiss="modal"><?php echo _l('close'); ?></button>
      </div>
   <?php } ?>
   <div class="clearfix"></div>
   <?php
      if (!isset($lead)) {
         echo '</form>';
      } else {
         echo form_close();
      }
   ?>
</div>
<div id="modal_wrapper"></div>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/form.css">
<script src="<?= base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>
<script>
   $(".file_input").change(function(e) {
      e.preventDefault();
      $(this).parent().children('.falseInputLabel').text($(this)[0].files[0].name);
   });

   $("#lead-form-submit").click(function() {

      var data = new FormData($('#lead_form')[0]);

      if( $("input[name='frontPic']")[0].files.length != 0 ){
         data.append('frontPic', $("input[name='frontPic']")[0].files[0]);
      }

      if( $("input[name='latPicLeft']")[0].files.length != 0 ){
         data.append('latPicLeft', $("input[name='latPicLeft']")[0].files[0]);
      }

      if( $("input[name='latPicRight']")[0].files.length != 0 ){
         data.append('latPicRight', $("input[name='latPicRight']")[0].files[0]);
      }

      if( $("input[name='backPic']")[0].files.length != 0 ){
         data.append('backPic', $("input[name='backPic']")[0].files[0]);
      }

      weight = $("[name='weight']").val();
      heightfeet = $("[name='heightfeet']").val();
      heightinches = $("[name='heightinches']").val();
      weight2 = parseFloat(weight); 
      heightfeet2 = parseFloat(heightfeet);
      heightinches2 = parseFloat(heightinches);
      bmi = ((weight2) / (((heightfeet2*12)+(heightinches2)) ** 2)) * 703;
      data.append('bmi', bmi);
      if( bmi >= 30 ){
         data.append('status', 6);
      }
      if($("[name='status']").val()==''){
         data.append('status', 5);
      }
      
      data.append('source', 3);
      

      $.ajax({
         type: "POST",
         url: "<?php echo (isset($lead) ? admin_url('leads/lead/' . $lead->id) : admin_url('leads/lead')); ?>",
         cache: false,
         contentType: false,
         processData: false,
         data: data,
         beforeSend: function(objeto) {
            console.log("Enviando...");
         },
         success: function(response) {
            console.log(response);
            window.location = 'leads';
         },
         error: function(xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText;
            alert('Error - ' + errorMessage);

         }
      });

      return false;
   });
</script>
<script type="text/javascript">
// Initialize our function when the document is ready for events.
jQuery(document).ready(function(){
	// Listen for the input event.
	jQuery("#phonenumber").on('input', function (evt) {
		// Allow only numbers.
		jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
	});
   jQuery("#age").on('input', function (evt) {
		// Allow only numbers.
		jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
	});
   jQuery("#weight").on('input', function (evt) {
		// Allow only numbers.
		jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
	});
});
</script>
<?php if (isset($lead) && $lead_locked == true) { ?>
   <script>
      $(function() {
         /* input file on upload */

         // Set all fields to disabled if lead is locked
         $.each($('.lead-wrapper').find('input, select, textarea'), function() {
            $(this).attr('disabled', true);
            if ($(this).is('select')) {
               $(this).selectpicker('refresh');
            }
         });
      });
   </script>
<?php } ?>