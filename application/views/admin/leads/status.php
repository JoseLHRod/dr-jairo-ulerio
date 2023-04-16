<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="status" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <?php echo form_open(admin_url('leads/status'), array('id' => 'leads-status-form')); ?>
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
               <span class="edit-title"><?php echo _l('edit_status'); ?></span>
               <span class="add-title"><?php echo _l('lead_new_status'); ?></span>
            </h4>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <div id="additional"></div>
                  <?php echo render_input('name', 'leads_status_add_edit_name'); ?>
                  <?php echo render_color_picker('color', _l('leads_status_color')); ?>
                  <?php echo render_input('statusorder', 'leads_status_add_edit_order', total_rows(db_prefix() . 'leads_status') + 1, 'number'); ?>
                  <?php echo render_select('statustype', 
                        [['id'=>'leads','name'=>'Leads'],['id'=>'patients','name'=>'Patients']], 
                        ['id','name'],
                        'type',
                        'leads',
                        [],[],'','', false
                    ); ?>
                  <?php
                    $this->load->model('emails_model');
                    $lead_templates = $this->emails_model->get(['type' => 'leads', 'language' => 'english']);
                  ?>
                  <div class="form-group">
                     <label for="emailTemplates">Select Email Template</label>
                     <select name="emailTemplates" class="selectpicker">
                        <?php foreach ($lead_templates as $lead_template) { ?>
                           <option value="<?php echo $lead_template['emailtemplateid']; ?>" >
                              <span>
                                 <?php echo $lead_template['name']; ?>
                              </span>
                           </option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
         </div>
      </div>
      <!-- /.modal-content -->
      <?php echo form_close(); ?>
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
   window.addEventListener('load', function() {
      appValidateForm($("body").find('#leads-status-form'), {
         name: 'required'
      }, manage_leads_statuses);
      $('#status').on("hidden.bs.modal", function(event) {
         $('#additional').html('');
         $('#status input[name="name"]').val('');
         $('#status input[name="color"]').val('');
         $('.add-title').removeClass('hide');
         $('.edit-title').removeClass('hide');
        $('#status select[name="statustype"]').selectpicker('val', 'leads');
         $('#status input[name="statusorder"]').val($('table tbody tr').length + 1);
      });
   });

   // Create lead new status
   function new_status() {
      $('#status select[name="statustype"]').selectpicker('val', 'leads');
      $('#status').modal('show');
      $('.edit-title').addClass('hide');
   }

   // Edit status function which init the data to the modal
   function edit_status(invoker, id) {
      console.log($(invoker).data('type'));
      $('#additional').append(hidden_input('id', id));
      $('#status input[name="name"]').val($(invoker).data('name'));
      $('#status .colorpicker-input').colorpicker('setValue', $(invoker).data('color'));
      $('#status input[name="statusorder"]').val($(invoker).data('order'));
      $('#status .colorpicker-input').colorpicker('setValue', $(invoker).data('color'));
      $('#status select[name="emailTemplates"] option[value="'+ $(invoker).data('status') +'"]').attr('selected', 'selected');
      $('#status .dropdown-toggle .filter-option .filter-option-inner .filter-option-inner-inner').text($('#status select[name="emailTemplates"] option[value="'+ $(invoker).data('status') +'"]').text());
      $('#status select[name="statustype"]').selectpicker('val', $(invoker).data('type'));
      $('#status').modal('show');
      $('.add-title').addClass('hide');
   }

   // Form handler function for leads status
   function manage_leads_statuses(form) {
      var data = $(form).serialize();
      var url = form.action;
      $.post(url, data).done(function(response) {
         window.location.reload();
      });
      return false;
   }
</script>