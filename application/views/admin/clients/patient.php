<div class="col-md-12">
  <div class="horizontal-scrollable-tabs">
    <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
    <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
    <div class="horizontal-tabs">
      <ul class="nav nav-tabs profile-tabs row customer-profile-tabs nav-tabs-horizontal" role="tablist">
        <li role="presentation" class="<?php if (!$this->input->get('tab')) {
                                          echo 'active';
                                        }; ?>">
          <a href="#contact_info" aria-controls="contact_info" role="tab" data-toggle="tab">
            <?php echo _l('customer_profile_details'); ?>
          </a>
        </li>
        <?php
        $customer_custom_fields = false;
        if (total_rows(db_prefix() . 'customfields', array('fieldto' => 'customers', 'active' => 1)) > 0) {
          $customer_custom_fields = true;
        ?>
          <li role="presentation" class="<?php if ($this->input->get('tab') == 'custom_fields') {
                                            echo 'active';
                                          }; ?>">
            <a href="#custom_fields" aria-controls="custom_fields" role="tab" data-toggle="tab">
              <?php echo hooks()->apply_filters('customer_profile_tab_custom_fields_text', _l('custom_fields')); ?>
            </a>
          </li>
        <?php } ?>
        <li role="presentation">
          <a href="#services_info" aria-controls="services_info" role="tab" data-toggle="tab">
            <?php echo _l('customer_profile_services'); ?>
          </a>
        </li>
        <li role="presentation">
          <a href="#question_and_submit" aria-controls="question_and_submit" role="tab" data-toggle="tab">
            <?php echo _l('customer_profile_question_and_submit'); ?>
          </a>
        </li>
        <li role="presentation">
          <a href="#billing_and_shipping" aria-controls="billing_and_shipping" role="tab" data-toggle="tab">
            <?php echo _l('billing_shipping'); ?>
          </a>
        </li>

        <?php hooks()->do_action('after_customer_billing_and_shipping_tab', isset($client) ? $client : false); ?>
        <?php if (isset($client)) { ?>
          <li role="presentation">
            <a href="#customer_admins" aria-controls="customer_admins" role="tab" data-toggle="tab">
              <?php echo _l('customer_admins'); ?>
            </a>
          </li>
          <?php hooks()->do_action('after_customer_admins_tab', $client); ?>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="tab-content mtop15">
    <?php hooks()->do_action('after_custom_profile_tab_content', isset($client) ? $client : false); ?>
    <?php if ($customer_custom_fields) { ?>
      <div role="tabpanel" class="tab-pane <?php if ($this->input->get('tab') == 'custom_fields') {
                                              echo ' active';
                                            }; ?>" id="custom_fields">
        <?php $rel_id = (isset($client) ? $client->userid : false); ?>
        <?php echo render_custom_fields('customers', $rel_id); ?>
      </div>
    <?php } ?>
    <div role="tabpanel" class="tab-pane<?php if (!$this->input->get('tab')) {
                                          echo ' active';
                                        }; ?>" id="contact_info">
      <div class="row">
        <div class="col-md-12 mtop15 <?php if (isset($client) && (!is_empty_customer_company($client->userid) && total_rows(db_prefix() . 'contacts', array('userid' => $client->userid, 'is_primary' => 1)) > 0)) {
                                        echo '';
                                      } else {
                                        echo ' hide';
                                      } ?>" id="client-show-primary-contact-wrapper">
          <div class="checkbox checkbox-info mbot20 no-mtop">
            <input type="checkbox" name="show_primary_contact" <?php if (isset($client) && $client->show_primary_contact == 1) {
                                                                  echo ' checked';
                                                                } ?> value="1" id="show_primary_contact">
            <label for="show_primary_contact"><?php echo _l('show_primary_contact', _l('invoices') . ', ' . _l('estimates') . ', ' . _l('payments') . ', ' . _l('credit_notes')); ?></label>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <?php
            $client->p_formAntecesor;
            $msg = '';

            if ($client->p_formAntecesor === '3') {
              $msg = ' (added with the third form)';
            }
            ?>

            <h4>Patient Info <?= $msg; ?></h4>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->patient_type : ''); ?>
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"> <?php echo _l('client_patient_type'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="patient_type">
                  <option value="0" <?php echo  $value == 0 ? 'selected="selected"' : '' ?>>External</option>
                  <option value="1" <?php echo  $value == 1 ? 'selected="selected"' : '' ?>>Internal</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->client_email : ''); ?>
            <?php echo render_input('client_email', 'client_client_email', $value, 'email'); ?>
          </div>
        </div>


        <div class="col-md-12">
          <div class="col-md-12">
            <h4>Contact Info</h4>
          </div>
          <div class="col-md-3">
            <?php $value = (isset($client) ? $client->first_name : ''); ?>
            <?php echo render_input('first_name', 'client_first_name', $value); ?>
          </div>
          <div class="col-md-3">
            <?php $value = (isset($client) ? $client->last_name : ''); ?>
            <?php echo render_input('last_name', 'client_last_name', $value); ?>
          </div>
          <div class="col-md-3">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_gender'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="gender">
                  <option value="0" <?= ($client->gender === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->gender === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <?php $value = (isset($client) ? $client->age : ''); ?>
            <?php echo render_input('age', 'client_age', $value); ?>
          </div>
          <div class="col-md-3">
            <?php $value = (isset($client) ? $client->birthday_date : ''); ?>
            <?php echo render_input('birthday_date', 'client_birthday_date', $value, 'date'); ?>
          </div>
          <div class="col-md-3">
            <?php $value = (isset($client) ? $client->phonenumber : ''); ?>
            <?php echo render_input('phonenumber', 'client_phonenumber', $value); ?>
          </div>
          <div class="col-md-3">
            <?php $value = (isset($client) ? $client->city : ''); ?>
            <?php echo render_input('city', 'client_city', $value); ?>
          </div>
          <div class="col-md-3">
            <?php $countries = get_all_countries();
            $customer_default_country = get_option('customer_default_country');
            $selected = (isset($client) ? $client->country : $customer_default_country);
            echo render_select('country', $countries, array('country_id', array('short_name')), 'clients_country', $selected, array('data-none-selected-text' => _l('dropdown_non_selected_tex')));
            ?>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <h4>Health Info</h4>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pweight : ''); ?>
            <?php echo render_input('pweight', 'client_pweight', $value); ?>
          </div>
          <div class="col-md-6">
            <div class="form-group" app-field-wrapper="pheight">
            <label for="pheight" class="control-label"><?php echo _l('client_pheight'); ?></label>
            <div>
            <label for="pheightfeet" style="display: inline-block;float: none;">Feet:</label>
            <?php $value = (isset($client) ? $client->pheightfeet : ''); ?>
            <input type="number" class="form-control" name="pheightfeet" value="<?php echo $value; ?>" min="0" size="2" style="display: inline-block;float: none;width: 15%;border-bottom: 1px solid #DDDDDD;text-align:center;
" required>
            <label for="pheightfeet" style="display: inline-block;float: none;">'</label>
            <label for="pheightinches" style="display: inline-block;float: none;">Inches:</label>
            <?php $value = (isset($client) ? $client->pheightinches : ''); ?>
            <input type="number" class="form-control" name="pheightinches" value="<?php echo $value; ?>" min="0" size="3" style="display: inline-block;float: none;width: 15%;border-bottom: 1px solid #DDDDDD;text-align:center;
" required>        
            <label for="pheightinches" style="display: inline-block;float: none;">''</label> 
            </div>   
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_panemic'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="panemic">
                  <option value="0" <?= ($client->panemic === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->panemic === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_pasthma'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pasthma">
                  <option value="0" <?= ($client->pasthma === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pasthma === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_pdiabetes'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pdiabetes">
                  <option value="0" <?= ($client->pdiabetes === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pdiabetes === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_pbloodp'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pbloodp">
                  <option value="0" <?= ($client->pbloodp === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pbloodp === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_pkids'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pkids">
                  <option value="0" <?= ($client->pkids === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pkids === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_pbreastf'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pbreastf">
                  <option value="0" <?= ($client->pbreastf === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pbreastf === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_phookah'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="phookah">
                  <option value="0" <?= ($client->phookah === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->phookah === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_psmoker'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="psmoker">
                  <option value="0" <?= ($client->psmoker === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->psmoker === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->ptimesmoke : ''); ?>
            <?php echo render_input('ptimesmoke', 'client_ptimesmoke', $value); ?>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_palcohol'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="palcohol">
                  <option value="0" <?= ($client->palcohol === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->palcohol === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pdrugs : ''); ?>
            <?php echo render_input('pdrugs', 'client_pdrugs', $value); ?>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_phiv'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="phiv">
                  <option value="0" <?= ($client->phiv === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->phiv === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('client_phepbc'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="phepbc">
                  <option value="0" <?= ($client->phepbc === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->phepbc === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('b_transf'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pblood_transf">
                  <option value="0" <?= ($client->pblood_transf === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pblood_transf === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pconditions : ''); ?>
            <?php echo render_input('pconditions', 'client_pconditions', $value); ?>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pallergies : ''); ?>
            <?php echo render_input('pallergies', 'client_pallergies', $value); ?>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->psurgeries : ''); ?>
            <?php echo render_input('psurgeries', 'client_psurgeries', $value); ?>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pvitamins : ''); ?>
            <?php echo render_input('pvitamins', 'client_pvitamins', $value); ?>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pprocedures : ''); ?>
            <?php echo render_input('pprocedures', 'client_pprocedures', $value, 'date'); ?>
          </div>
          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->phearaboutus : ''); ?>
            <?php echo render_input('phearaboutus', 'client_phearaboutus', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pquestion : ''); ?>
            <?php echo render_textarea('pdiagnosis', 'p_diagnosis', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pg : ''); ?>
            <?php echo render_input('pg', 'p_g', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pa : ''); ?>
            <?php echo render_input('pa', 'p_a', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pp : ''); ?>
            <?php echo render_input('pp', 'p_p', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pc : ''); ?>
            <?php echo render_input('pc', 'p_c', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pconditions : ''); ?>
            <?php echo render_input('pconditions', 'client_pconditions', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pvitamins : ''); ?>
            <?php echo render_input('pvitamins', 'client_pvitamins', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pfather_hist : ''); ?>
            <?php echo render_input('pfather_hist', 'f_hist', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pmother_hist : ''); ?>
            <?php echo render_input('pmother_hist', 'm_hist', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pchildren_hist : ''); ?>
            <?php echo render_input('pchildren_hist', 'c_hist', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pbrother_hist : ''); ?>
            <?php echo render_input('pbrother_hist', 'b_hist', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->ppartner_hist : ''); ?>
            <?php echo render_input('ppartner_hist', 'wh_hist', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->pcollateral_hist : ''); ?>
            <?php echo render_input('pcollateral_hist', 'c_hist', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->ppathological_meds : ''); ?>
            <?php echo render_input('ppathological_meds', 'p_h_meds', $value); ?>
          </div>

          <div class="col-md-6">
            <?php $value = (isset($client) ? $client->ppsychiatric : ''); ?>
            <?php echo render_input('ppsychiatric', 'psy_hist', $value); ?>
          </div>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane<?php if (!$this->input->get('tab')) {
                                          echo ' active';
                                        }; ?>" id="services_info">
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">
            <h4>Body Contouring</h4>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="parmlift" id="parmlift" value="1" <?php if (isset($client) && $client->parmlift)  echo 'checked="checked"'; ?>>
              <label for="parmlift"><?php echo _l('client_parmlift'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pbcmwloss" id="pbcmwloss" value="1" <?php if (isset($client) && $client->pbcmwloss)  echo 'checked="checked"'; ?>>
              <label for="pbcmwloss"><?php echo _l('client_pbcmwloss'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pbaugmentation" id="pbaugmentation" value="1" <?php if (isset($client) && $client->pbaugmentation)  echo 'checked="checked"'; ?>>
              <label for="pbaugmentation"><?php echo _l('client_pbaugmentation'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pliposuction" id="pliposuction" value="1" <?php if (isset($client) && $client->pliposuction)  echo 'checked="checked"'; ?>>
              <label for="pliposuction"><?php echo _l('client_pliposuction'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pthighlift" id="pthighlift" value="1" <?php if (isset($client) && $client->pthighlift)  echo 'checked="checked"'; ?>>
              <label for="pthighlift"><?php echo _l('client_pthighlift'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="ptummytuck" id="ptummytuck" value="1" <?php if (isset($client) && $client->ptummytuck)  echo 'checked="checked"'; ?>>
              <label for="ptummytuck"><?php echo _l('client_ptummytuck'); ?></label>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <h4>Facial and cervical procedures</h4>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pblepharoplasty" id="pblepharoplasty" value="1" <?php if (isset($client) && $client->pblepharoplasty)  echo 'checked="checked"'; ?>>
              <label for="pblepharoplasty"><?php echo _l('client_pblepharoplasty'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pcervicalp" id="pcervicalp" value="1" <?php if (isset($client) && $client->pcervicalp)  echo 'checked="checked"'; ?>>
              <label for="pcervicalp"><?php echo _l('client_pcervicalp'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pcheiloplasty" id="pcheiloplasty" value="1" <?php if (isset($client) && $client->pcheiloplasty)  echo 'checked="checked"'; ?>>
              <label for="pcheiloplasty"><?php echo _l('client_pcheiloplasty'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="potoplasty" id="potoplasty" value="1" <?php if (isset($client) && $client->potoplasty)  echo 'checked="checked"'; ?>>
              <label for="potoplasty"><?php echo _l('client_potoplasty'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="prhinoplasty" id="prhinoplasty" value="1" <?php if (isset($client) && $client->prhinoplasty)  echo 'checked="checked"'; ?>>
              <label for="prhinoplasty"><?php echo _l('client_prhinoplasty'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="prhytidectomy" id="prhytidectomy" value="1" <?php if (isset($client) && $client->prhytidectomy)  echo 'checked="checked"'; ?>>
              <label for="prhytidectomy"><?php echo _l('client_prhytidectomy'); ?></label>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <h4>Breast surgery</h4>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pbreastaugs" id="pbreastaugs" value="1" <?php if (isset($client) && $client->pbreastaugs)  echo 'checked="checked"'; ?>>
              <label for="pbreastaugs"><?php echo _l('client_pbreastaugs'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pbreastlift" id="pbreastlift" value="1" <?php if (isset($client) && $client->pbreastlift)  echo 'checked="checked"'; ?>>
              <label for="pbreastlift"><?php echo _l('client_pbreastlift'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pbreastreduction" id="pbreastreduction" value="1" <?php if (isset($client) && $client->pbreastreduction)  echo 'checked="checked"'; ?>>
              <label for="pbreastreduction"><?php echo _l('client_pbreastreduction'); ?></label>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="col-md-12">
            <h4>Reconstructive surgery</h4>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pbreastreconstruction" id="pbreastreconstruction" value="1" <?php if (isset($client) && $client->pbreastreconstruction)  echo 'checked="checked"'; ?>>
              <label for="pbreastreconstruction"><?php echo _l('client_pbreastreconstruction'); ?></label>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <h4><?php echo _l('step6'); ?></h4>
          </div>

          <div class="col-md-4">
            <?php $value = (isset($client) ? $client->preason : ''); ?>
            <?php echo render_textarea('preason', 'reason_consult', $value); ?>
          </div>

          <div class="col-md-4">
            <?php $value = (isset($client) ? $client->pphysical_exam : ''); ?>
            <?php echo render_textarea('pphysical_exam', 'physic_exam', $value); ?>
          </div>

          <div class="col-md-4">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('hematimetry_exam'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="phematimetry">
                  <option value="0" <?= ($client->phematimetry === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->phematimetry === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('homoglob_exam'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="phomoglobinometry">
                  <option value="0" <?= ($client->phomoglobinometry === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->phomoglobinometry === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('tcoag_exam'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pcoagulation">
                  <option value="0" <?= ($client->pcoagulation === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pcoagulation === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('homoglob_exam'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pbleeding">
                  <option value="0" <?= ($client->pbleeding === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pbleeding === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('hematocrit_exam'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="phematocrit">
                  <option value="0" <?= ($client->phematocrit === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->phematocrit === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('xrays_exam'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="pxrays">
                  <option value="0" <?= ($client->pxrays === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->pxrays === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group  row">
              <label class="col-lg-12 col-form-label"><?php echo _l('sonography_exam'); ?></label>
              <div class="col-lg-12">
                <select class="form-control" name="psonography">
                  <option value="0" <?= ($client->psonography === '0') ? 'selected="selected"' : '' ?>>No</option>
                  <option value="1" <?= ($client->psonography === '1') ? 'selected="selected"' : '' ?>>Yes</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <?php $value = (isset($client) ? $client->pother_exams : ''); ?>
            <?php echo render_textarea('pother_exams', 'other_exams', $value); ?>
          </div>

          <div class="col-md-4">
            <?php $value = (isset($client) ? $client->psirugical_plan : ''); ?>
            <?php echo render_input('psirugical_plan', 'sirurgical_plan', $value); ?>
          </div>

          <div class="col-md-4">
            <?php $value = (isset($client) ? $client->ppricing : ''); ?>
            <?php echo render_input('ppricing', 'sir_price', $value); ?>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <h4>Other(s)</h4>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pscarrevision" id="pscarrevision" value="1" <?php if (isset($client) && $client->pscarrevision)  echo 'checked="checked"'; ?>>
              <label for="pscarrevision"><?php echo _l('client_pscarrevision'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" name="pstaypackages" id="pstaypackages" value="1" <?php if (isset($client) && $client->pstaypackages)  echo 'checked="checked"'; ?>>
              <label for="pstaypackages"><?php echo _l('client_pstaypackages'); ?></label>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="col-md-12">
            <h4>Client Image(s)</h4>
          </div>
          <!-- passport -->
          <div class="col-md-12">
            <div class="row">
              <!-- start user image -->
              <?php $filePath = (isset($client)) ? "/uploads/clients/client_" . $client->userid . "/" : ""; ?>
              <p class="text-muted lead-field-heading"><?php echo _l('passport_id_pic'); ?></p>
              <p class="bold font-medium-xs" style="position: relative">              
                <?php if (isset($client) && $client->ppassport_pic != null && !(substr($client->ppassport_pic, 0, strlen('http')) === 'http') ) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $client->ppassport_pic); ?>" data-fancybox="gallery" data-caption="Client Passport Picture">
                    <img class="fancyImg" src="<?php echo base_url($filePath . $client->ppassport_pic); ?>" alt="passport-img">
                  </a>

                  <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->ppassport_pic); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                    <i class="fa fa-remove"></i>
                  </a>
                <?php } elseif(isset($client) && $client->ppassport_pic != null && (substr($client->ppassport_pic, 0, strlen('http')) === 'http') ) {  ?>
                  <a class="fancyWrapper" href="<?php echo $client->ppassport_pic; ?>" data-fancybox="gallery" data-caption="Client Passport Picture">
                  <img class="fancyImg" src="<?php echo $client->ppassport_pic; ?>" alt="passport-img">
                </a>
                <?php } else {
                  echo _l('no_image');
                } ?>
              </p>

              <div class="falseInputContainer">
                <span class="falseInputLabel"><?php echo _l('passport_id_pic'); ?></span>
                <input class="file_input simpleFormUpload" name="ppassport_pic" accept="image/png, image/jpeg" type="file" />

                <div style="position: relative;">
                  <a class="fancyWrapper" id="ppassport_picLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                    <img class="fancyImg" id="ppassport_pic" alt="front-img" />
                  </a>

                  <button id="ppassport_picButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <h3 class="text-center">before</h3>
            <div class="row">
              <!-- start user image -->
              <?php $filePath = (isset($client)) ? "/uploads/clients/client_" . $client->userid . "/" : ""; ?>
              <?php $filePath2 = (isset($client)) ? "/uploads/leads/user_" . $client->leadid . "/" : ""; ?>

              <p class="text-muted lead-field-heading"><?php echo _l('front_image'); ?></p>
              <p class="bold font-medium-xs" style="position: relative">              
                <?php if (isset($client) && $client->pfront_pic != null && !(substr($client->pfront_pic, 0, strlen('http')) === 'http') ) { ?>
              <div style="position: relative">
                <a class="fancyWrapper" href="<?php echo base_url($filePath . $client->pfront_pic); ?>" data-base64="<?= $client->pfront_pic; ?>" data-fancybox="gallery" data-caption="Client Front Picture">
                  <img class="fancyImg" src="<?php echo base_url($filePath . $client->pfront_pic); ?>" alt="front-img">
                </a>

                <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->pfront_pic); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                  <i class="fa fa-remove"></i>
                </a>
              </div>
              <?php } elseif (isset($client) && $client->pfront_pic != null && (substr($client->pfront_pic, 0, strlen('http')) === 'http') ) { ?>                
                <div style="position: relative">
                <a class="fancyWrapper" href="<?php echo $client->pfront_pic; ?>" data-base64="<?= $client->pfront_pic; ?>" data-fancybox="gallery" data-caption="Client Front Picture">
                  <img class="fancyImg" src="<?php echo $client->pfront_pic; ?>" alt="front-img">
                </a>
              </div>
                <?php } else {
                  echo _l('no_image');
                } ?>
            </p>

            <div class="falseInputContainer" style="width: 90%">
              <span class="falseInputLabel"><?php echo _l('add_client_img_front'); ?></span>
              <input class="file_input simpleFormUpload" name="pfront_pic" accept="image/png, image/jpeg" type="file" />

              <div style="position: relative;">
                <a class="fancyWrapper" id="pfront_picLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                  <img class="fancyImg" id="pfront_pic" alt="front-img" />
                </a>

                <button id="pfront_picButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>

            <p class="text-muted lead-field-heading"><?php echo _l('lat_image_l'); ?></p>
            <p class="bold font-medium-xs" style="position: relative">            
              <?php if (isset($client) && $client->pl_side_pic != null && !(substr($client->pl_side_pic, 0, strlen('http')) === 'http') ) { ?>
                <a class="fancyWrapper" href="<?php echo $client->pl_side_pic; ?>" data-base64="<?= $client->pl_side_pic; ?>" data-fancybox="gallery" data-caption="Client left side Picture">
                  <img class="fancyImg" src="<?php echo base_url($filePath . $client->pl_side_pic); ?>" alt="lateral-left-img">
                </a>

                <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->pl_side_pic); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                  <i class="fa fa-remove"></i>
                </a>
              <?php } elseif(isset($client) && $client->pl_side_pic != null && (substr($client->pl_side_pic, 0, strlen('http')) === 'http') ) { ?>
                <a class="fancyWrapper" href="<?php echo $client->pl_side_pic; ?>" data-base64="<?= $client->pl_side_pic; ?>" data-fancybox="gallery" data-caption="Client Front Picture">
                  <img class="fancyImg" src="<?php echo $client->pl_side_pic; ?>" alt="front-img">
                </a>
              <?php } else {
                echo _l('no_image');
              } ?>
            </p>

            <div class="falseInputContainer" style="width: 90%">
              <span class="falseInputLabel"><?php echo _l('add_client_img_lat_1'); ?></span>
              <input class="file_input simpleFormUpload" name="pl_side_pic" accept="image/png, image/jpeg" type="file" />

              <div style="position: relative;">
                <a class="fancyWrapper" id="pl_side_picLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                  <img class="fancyImg" id="pl_side_pic" alt="front-img" />
                </a>

                <button id="pl_side_picButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>

            <p class="text-muted lead-field-heading"><?php echo _l('lat_image_r'); ?></p>
            <p class="bold font-medium-xs" style="position: relative">            
              <?php if (isset($client) && $client->pr_side_pic != null && !(substr($client->pr_side_pic, 0, strlen('http')) === 'http') ) { ?>

                <a class="fancyWrapper" href="<?php echo base_url($filePath . $client->pr_side_pic); ?>" data-base64="<?= $client->pr_side_pic; ?>" data-fancybox="gallery" data-caption="Client right side Picture">
                  <img class="fancyImg" src="<?php echo base_url($filePath . $client->pr_side_pic); ?>" alt="lateral-right-img">
                </a>

                <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->pr_side_pic); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                  <i class="fa fa-remove"></i>
                </a>
              <?php } elseif(isset($client) && $client->pr_side_pic != null && (substr($client->pr_side_pic, 0, strlen('http')) === 'http') ) { ?>
                <a class="fancyWrapper" href="<?php echo $client->pr_side_pic; ?>" data-base64="<?= $client->pr_side_pic; ?>" data-fancybox="gallery" data-caption="Client right side Picture">
                  <img class="fancyImg" src="<?php echo $client->pr_side_pic; ?>" alt="lateral-right-img">
                </a>
              <?php } else {
                echo _l('no_image');
              } ?>
            </p>

            <div class="falseInputContainer" style="width: 90%">
              <span class="falseInputLabel"><?php echo _l('add_client_img_lat_2'); ?></span>
              <input class="file_input simpleFormUpload" name="pr_side_pic" accept="image/png, image/jpeg" type="file" />

              <div style="position: relative;">
                <a class="fancyWrapper" id="pr_side_picLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                  <img class="fancyImg" id="pr_side_pic" alt="front-img" />
                </a>

                <button id="pr_side_picButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>

            <p class="text-muted lead-field-heading"><?php echo _l('back_image'); ?></p>
            <p class="bold font-medium-xs" style="position: relative">            
              <?php if (isset($client) && $client->pback_pic != null && !(substr($client->pback_pic, 0, strlen('http')) === 'http') ) { ?>
                <a class="fancyWrapper" href="<?php echo base_url($filePath . $client->pback_pic); ?>" data-base64="<?= $client->pback_pic; ?>" data-fancybox="gallery" data-caption="Lead back Picture">
                  <img class="fancyImg" src="<?php echo base_url($filePath . $client->pback_pic); ?>" alt="lateral-back-img">
                </a>

                <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->pback_pic); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                  <i class="fa fa-remove"></i>
                </a>
              <?php } elseif(isset($client) && $client->pback_pic != null && (substr($client->pback_pic, 0, strlen('http')) === 'http') ) { ?>
                <a class="fancyWrapper" href="<?php echo $client->pback_pic; ?>" data-base64="<?= $client->pback_pic; ?>" data-fancybox="gallery" data-caption="Lead back Picture">
                  <img class="fancyImg" src="<?php echo $client->pback_pic; ?>" alt="lateral-back-img">
                </a>
              <?php } else {
                echo _l('no_image');
              } ?>
            </p>

            <div class="falseInputContainer" style="width: 90%">
              <span class="falseInputLabel"><?php echo _l('add_client_img_back'); ?></span>
              <input class="file_input simpleFormUpload" name="pback_pic" accept="image/png, image/jpeg" type="file" />

              <div style="position: relative;">
                <a class="fancyWrapper" id="pback_picLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                  <img class="fancyImg" id="pback_pic" alt="front-img" />
                </a>

                <button id="pback_picButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>

            <!-- end user image -->
            </div>
          </div>

          <div class="col-md-6">
            <h3 class="text-center">after</h3>
            <div class="row">
              <!-- start user image -->
              <?php $filePath = (isset($client)) ? "/uploads/clients/client_" . $client->userid . "/" : ""; ?>

              <p class="text-muted lead-field-heading"><?php echo _l('front_image'); ?></p>
              <p class="bold font-medium-xs" style="position: relative">
                <?php if (isset($client) && $client->pfront_pic_after  != null) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $client->pfront_pic_after); ?>" data-base64="<?= $client->pfront_pic_after; ?>" data-fancybox="gallery" data-caption="Client Front Picture">
                    <img class="fancyImg" src="<?php echo base_url($filePath . $client->pfront_pic_after); ?>" alt="front-img">
                  </a>

                  <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->pfront_pic_after); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                    <i class="fa fa-remove"></i>
                  </a>
                <?php } else {
                  echo _l('no_image');
                } ?>
              </p>

              <div class="falseInputContainer" style="width: 90%">
                <span class="falseInputLabel"><?php echo _l('add_client_img_front'); ?></span>
                <input class="file_input simpleFormUpload" name="pfront_pic_after" accept="image/png, image/jpeg" type="file" />

                <div style="position: relative;">
                  <a class="fancyWrapper" id="pfront_pic_afterLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                    <img class="fancyImg" id="pfront_pic_after" alt="front-img" />
                  </a>

                  <button id="pfront_pic_afterButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>

              <p class="text-muted lead-field-heading"><?php echo _l('lat_image_l'); ?></p>
              <p class="bold font-medium-xs" style="position: relative">
                <?php if (isset($client) && $client->pl_side_pic_after != null) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $client->pl_side_pic_after); ?>" data-base64="<?= $client->pl_side_pic_after; ?>" data-fancybox="gallery" data-caption="Client left side Picture">
                    <img class="fancyImg" src="<?php echo base_url($filePath . $client->pl_side_pic_after); ?>" alt="lateral-left-img">
                  </a>

                  <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->pl_side_pic_after); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                    <i class="fa fa-remove"></i>
                  </a>
                <?php } else {
                  echo _l('no_image');
                } ?>
              </p>

              <div class="falseInputContainer" style="width: 90%">
                <span class="falseInputLabel"><?php echo _l('add_client_img_lat_1'); ?></span>
                <input class="file_input simpleFormUpload" name="pl_side_pic_after" accept="image/png, image/jpeg" type="file" />

                <div style="position: relative;">
                  <a class="fancyWrapper" id="pl_side_pic_afterLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                    <img class="fancyImg" id="pl_side_pic_after" alt="front-img" />
                  </a>

                  <button id="pl_side_pic_afterButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>

              <p class="text-muted lead-field-heading"><?php echo _l('lat_image_r'); ?></p>
              <p class="bold font-medium-xs" style="position: relative">
                <?php if (isset($client) && $client->pr_side_pic_after != null) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $client->pr_side_pic_after); ?>" data-base64="<?= $client->pr_side_pic_after; ?>" data-fancybox="gallery" data-caption="Client right side Picture">
                    <img class="fancyImg" src="<?php echo base_url($filePath . $client->pr_side_pic_after); ?>" alt="lateral-right-img">
                  </a>

                  <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->pl_side_pic_after); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                    <i class="fa fa-remove"></i>
                  </a>
                <?php } else {
                  echo _l('no_image');
                } ?>
              </p>

              <div class="falseInputContainer" style="width: 90%">
                <span class="falseInputLabel"><?php echo _l('add_client_img_lat_2'); ?></span>
                <input class="file_input simpleFormUpload" name="pr_side_pic_after" accept="image/png, image/jpeg" type="file" />

                <div style="position: relative;">
                  <a class="fancyWrapper" id="pr_side_pic_afterLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                    <img class="fancyImg" id="pr_side_pic_after" alt="front-img" />
                  </a>

                  <button id="pr_side_pic_afterButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>

              <p class="text-muted lead-field-heading"><?php echo _l('back_image'); ?></p>
              <p class="bold font-medium-xs" style="position: relative">
                <?php if (isset($client) && $client->pback_pic_after != null) { ?>
                  <a class="fancyWrapper" href="<?php echo base_url($filePath . $client->pback_pic_after); ?>" data-base64="<?= $client->pback_pic_after; ?>" data-fancybox="gallery" data-caption="Lead back Picture">
                    <img class="fancyImg" src="<?php echo base_url($filePath . $client->pback_pic_after); ?>" alt="lateral-back-img">
                  </a>

                  <a href="<?php echo admin_url('patients/delete_image/' . $client->userid . '/' . $client->pback_pic_after); ?>" class="btn btn-danger only-save customer-form-submiter" style="position: absolute; top: 0; left: 160px;">
                    <i class="fa fa-remove"></i>
                  </a>
                <?php } else {
                  echo _l('no_image');
                } ?>
              </p>

              <div class="falseInputContainer" style="width: 90%">
                <span class="falseInputLabel"><?php echo _l('add_client_img_back'); ?></span>
                <input class="file_input simpleFormUpload" name="pback_pic_after" accept="image/png, image/jpeg" type="file" />

                <div style="position: relative;">
                  <a class="fancyWrapper" id="pback_pic_afterLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                    <img class="fancyImg" id="pback_pic_after" alt="front-img" />
                  </a>

                  <button id="pback_pic_afterButton" type="button" class="close close-custom" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>

              <!-- end user image -->
            </div>
          </div>

          <!-- signature -->
          <div class="col-md-12">
            <div class="row">
              <p class="text-muted lead-field-heading"><?php echo _l('p_signature'); ?></p>
              <p class="bold font-medium-xs">
                <?php if (isset($client) && $client->pfirm_pic != null) { ?>
              <div id="firm" class="fancyWrapper">
              </div>
            <?php } else {
                  echo _l('no_image');
                } ?>
            </p>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane<?php if (!$this->input->get('tab')) {
                                          echo ' active';
                                        }; ?>" id="question_and_submit">
      <div class="row">
        <div class="col-md-12">
          <?php $value = (isset($client) ? $client->pquestion : ''); ?>
          <?php echo render_textarea('pquestion', 'client_pquestion', $value); ?>
        </div>
      </div>
    </div>
    <?php if (isset($client)) { ?>
      <div role="tabpanel" class="tab-pane" id="customer_admins">
        <?php if (has_permission('customers', '', 'create') || has_permission('customers', '', 'edit')) { ?>
          <a href="#" data-toggle="modal" data-target="#customer_admins_assign" class="btn btn-info mbot30"><?php echo _l('assign_admin'); ?></a>
        <?php } ?>
        <table class="table dt-table">
          <thead>
            <tr>
              <th><?php echo _l('staff_member'); ?></th>
              <th><?php echo _l('customer_admin_date_assigned'); ?></th>
              <?php if (has_permission('customers', '', 'create') || has_permission('customers', '', 'edit')) { ?>
                <th><?php echo _l('options'); ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($customer_admins as $c_admin) { ?>
              <tr>
                <td><a href="<?php echo admin_url('profile/' . $c_admin['staff_id']); ?>">
                    <?php echo staff_profile_image($c_admin['staff_id'], array(
                      'staff-profile-image-small',
                      'mright5'
                    ));
                    echo get_staff_full_name($c_admin['staff_id']); ?></a>
                </td>
                <td data-order="<?php echo $c_admin['date_assigned']; ?>"><?php echo _dt($c_admin['date_assigned']); ?></td>
                <?php if (has_permission('customers', '', 'create') || has_permission('customers', '', 'edit')) { ?>
                  <td>
                    <a href="<?php echo admin_url('clients/delete_customer_admin/' . $client->userid . '/' . $c_admin['staff_id']); ?>" class="btn btn-danger _delete btn-icon"><i class="fa fa-remove"></i></a>
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>
    <div role="tabpanel" class="tab-pane" id="billing_and_shipping">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <h4 class="no-mtop"><?php echo _l('billing_address'); ?> <a href="#" class="pull-right billing-same-as-customer"><small class="font-medium-xs"><?php echo _l('customer_billing_same_as_profile'); ?></small></a></h4>
              <hr />
              <?php $value = (isset($client) ? $client->billing_street : ''); ?>
              <?php echo render_textarea('billing_street', 'billing_street', $value); ?>
              <?php $value = (isset($client) ? $client->billing_city : ''); ?>
              <?php echo render_input('billing_city', 'billing_city', $value); ?>
              <?php $value = (isset($client) ? $client->billing_state : ''); ?>
              <?php echo render_input('billing_state', 'billing_state', $value); ?>
              <?php $value = (isset($client) ? $client->billing_zip : ''); ?>
              <?php echo render_input('billing_zip', 'billing_zip', $value); ?>
              <?php $selected = (isset($client) ? $client->billing_country : ''); ?>
              <?php echo render_select('billing_country', $countries, array('country_id', array('short_name')), 'billing_country', $selected, array('data-none-selected-text' => _l('dropdown_non_selected_tex'))); ?>
            </div>
            <div class="col-md-6">
              <h4 class="no-mtop">
                <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?php echo _l('customer_shipping_address_notice'); ?>"></i>
                <?php echo _l('shipping_address'); ?> <a href="#" class="pull-right customer-copy-billing-address"><small class="font-medium-xs"><?php echo _l('customer_billing_copy'); ?></small></a>
              </h4>
              <hr />
              <?php $value = (isset($client) ? $client->shipping_street : ''); ?>
              <?php echo render_textarea('shipping_street', 'shipping_street', $value); ?>
              <?php $value = (isset($client) ? $client->shipping_city : ''); ?>
              <?php echo render_input('shipping_city', 'shipping_city', $value); ?>
              <?php $value = (isset($client) ? $client->shipping_state : ''); ?>
              <?php echo render_input('shipping_state', 'shipping_state', $value); ?>
              <?php $value = (isset($client) ? $client->shipping_zip : ''); ?>
              <?php echo render_input('shipping_zip', 'shipping_zip', $value); ?>
              <?php $selected = (isset($client) ? $client->shipping_country : ''); ?>
              <?php echo render_select('shipping_country', $countries, array('country_id', array('short_name')), 'shipping_country', $selected, array('data-none-selected-text' => _l('dropdown_non_selected_tex'))); ?>
            </div>
            <?php if (
              isset($client) &&
              (total_rows(db_prefix() . 'invoices', array('clientid' => $client->userid)) > 0 || total_rows(db_prefix() . 'estimates', array('clientid' => $client->userid)) > 0 || total_rows(db_prefix() . 'creditnotes', array('clientid' => $client->userid)) > 0)
            ) { ?>
              <div class="col-md-12">
                <div class="alert alert-warning">
                  <div class="checkbox checkbox-default">
                    <input type="checkbox" name="update_all_other_transactions" id="update_all_other_transactions">
                    <label for="update_all_other_transactions">
                      <?php echo _l('customer_update_address_info_on_invoices'); ?><br />
                    </label>
                  </div>
                  <b><?php echo _l('customer_update_address_info_on_invoices_help'); ?></b>
                  <div class="checkbox checkbox-default">
                    <input type="checkbox" name="update_credit_notes" id="update_credit_notes">
                    <label for="update_credit_notes">
                      <?php echo _l('customer_profile_update_credit_notes'); ?><br />
                    </label>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .close-custom {
    position: absolute;
    top: 5%;
    right: -20%;
  }
</style>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/form.css">
<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>

<script>
  /* add images */
  $(document).ready(function() {
    var img = new Image();
    img.src = "data: image/svg+xml;base64," + "<?= $client->pfirm_pic; ?>";
    $('#firm').append(img);
  });


  const fileTypes = [
      "image/jpeg",
      "image/pjpeg",
      "image/png",
    ],
    textInputFile = {
      "pfront_pic": '<?php echo _l('add_client_img_front'); ?>',
      "pl_side_pic": '<?php echo _l('add_client_img_lat_1'); ?>',
      "pr_side_pic": '<?php echo _l('add_client_img_lat_2'); ?>',
      "pback_pic": '<?php echo _l('add_client_img_back'); ?>',
      "pfront_pic_after": '<?php echo _l('add_client_img_front'); ?>',
      "pl_side_pic_after": '<?php echo _l('add_client_img_lat_1'); ?>',
      "pr_side_pic_after": '<?php echo _l('add_client_img_lat_2'); ?>',
      "pback_pic_after": '<?php echo _l('add_client_img_back'); ?>'
    };

  let TempImage = {
      "pfront_pic": null,
      "pl_side_pic": null,
      "pr_side_pic": null,
      "pback_pic": null,
      "pfront_pic_after": null,
      "pl_side_pic_after": null,
      "pr_side_pic_after": null,
      "pback_pic_after": null,
    },
    validImages = true;

  /**
   * validate the file type(png, pjg, pjpeg)
   * 
   * @param input file
   * @returns boolean
   */
  function validFileType(file) {
    return fileTypes.includes(file.type);
  }

  /**
   * return the size of the image
   * 
   * @param number int
   * @return string
   */
  function returnFileSize(number) {
    if (number < 1024) {
      return number + ' bytes';
    } else if (number >= 1024 && number < 1048576) {
      return (number / 1024).toFixed(1) + ' KB';
    } else if (number >= 1048576) {
      return (number / 1048576).toFixed(1) + ' MB';
    }
  }

  function maxSizeFile(size) {
    return (size >= 8192000) ? true : false;
  }

  function maxDimensionFile(file) {
    let status;
    let width;
    let height;
    var reader = new FileReader();
    reader.readAsDataURL(file);

    reader.onload = function(e) {
      //Initiate the JavaScript Image object.
      var image = new Image();

      //Set the Base64 string return from FileReader as source.
      image.src = e.target.result;

      //Validate the File Height and Width.
      image.onload = function() {
        height = this.height;
        width = this.width;
        if (height > 1768 || width > 2024) {
          status = false;
        }
        status = true;
      };
    }

    return {
      status: status,
      height: height,
      width: width
    }
  }

  /* input file on upload */
  $(".file_input").change(function(e) {
    e.preventDefault();

    // prevent error for calling $(this)[0].files[0] as array when is empty
    if ($(this)[0].files.length > 0) {
      $(this).parent().children('.falseInputLabel').text($(this)[0].files[0].name);

      if (!validFileType($(this)[0].files[0])) {
        alert(`File name ${$(this)[0].files[0].name}: Is not a valid file type. Only jpg, jpeg and png image are valid.`);
        validImages = false;
      }

      if (maxSizeFile($(this)[0].files[0].size)) {
        alert(`File name ${$(this)[0].files[0].name}: Exceeds the size limit of 8 mb. the file size is ${returnFileSize($(this)[0].files[0].size)}. select another file`);
        validImages = false;
      }

      if (maxDimensionFile($(this)[0].files[0]).status == false) {
        alert(`File name ${$(this)[0].files[0].name}: Exceeds the size limit of height 1768 pixels or width 2024 pixels. the file height is ${maxDimensionFile($(this)[0].files[0]).height} and the width is ${maxDimensionFile($(this)[0].files[0]).width}. select another file`);
        validImages = false;
      }

      // preview the image under the current input file
      if (validImages != false) {
        let idName = $(this).prop('name');
        let imgTag = document.getElementById(idName);
        let imgLinkTag = document.getElementById(idName + 'Link');
        let imgLinkButton = document.getElementById(idName + 'Button');

        TempImage[idName] = URL.createObjectURL($(this)[0].files[0]);

        imgTag.src = TempImage[idName];
        imgTag.style.display = "flex";

        imgLinkTag.href = TempImage[idName];
        imgLinkTag.dataset.base64 = $(this)[0].files[0].name;
        imgLinkTag.style.display = "flex";

        imgLinkButton.style.display = 'inline';
      }
    }
  });

  // clear the input file and image preview
  $(".close-custom").click(function(e) {
    if ($(this).parent().parent().children('.file_input').val() != '') {
      // get the name of the current input file
      let file_inputName = $(this).parent().parent().children('.file_input').prop('name');
      let imgTag = document.getElementById(file_inputName);
      let imgLinkTag = document.getElementById(file_inputName + 'Link');
      // reset the current input file
      $(this).parent().parent().children('.file_input').val('');
      // clear
      $(this).parent().parent().children('.falseInputLabel').text(textInputFile[file_inputName]);
      // hide the current button
      $(this).css("display", "none");

      // clear the source of the image tag
      imgTag.src = "#";
      imgTag.style.display = "none";
      imgLinkTag.href = "#";
      imgLinkTag.dataset.base64 = "";
      imgLinkTag.style.display = "none";

      // delete the image f the current input from the memory
      URL.revokeObjectURL(TempImage[file_inputName]);
    }
  });
</script>