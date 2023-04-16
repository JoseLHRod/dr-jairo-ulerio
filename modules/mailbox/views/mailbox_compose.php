<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open_multipart($this->uri->uri_string(), ['id'=>'mailbox_compose_form']); ?>
<div class="clearfix mtop20"></div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">      
    <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('mailbox_multi_email_split'); ?>"></i>
    <?php
        $to      = '';
        $cc      = '';
        $subject = '';
        $body    = '';
    ?>
    <?php if (isset($mail)) {
        $to      = $mail->to;
        $cc      = $mail->cc;
        $subject = $mail->subject;
        $body    = $mail->body;
    }elseif(isset($_GET['to_email']) && !empty($_GET['to_email'])){
        $to      = $_GET['to_email'];
    }
    ?>
    <?php echo render_input('to', 'mailbox_to', $to); ?>
    <?php echo render_input('cc', 'CC', $cc); ?>
    <?php echo render_input('subject', 'mailbox_subject', $subject); ?>
	  <?php
        $CI = &get_instance();
        $CI->db->select()
            ->from(db_prefix().'staff')
            ->where(db_prefix().'staff.mail_password !=', '');
        $staffs = $CI->db->get()->result_array();
		
		    $myid = get_staff_user_id();
		
        $CI->db->select()
            ->from(db_prefix().'staff')
            ->where('staffid', $myid );
        $currentusers = $CI->db->get()->result_array();
		
        foreach ($currentusers as $currentuser) {
            $mail_signature = $currentuser['mail_signature'];
        }
    ?>
    <div class="preload-templates">
      <label for="preload-html" class="control-label"><?=_l('mailbox_plantillas')?></label>
      <select id="preload-html" name="preload-html" class="form-control" onchange="getPreload(this)">
        <option value="">-- Selecciona --</option>
        <?php foreach($mailboxs as &$mailbox): ?>
          echo <option value="<?=$mailbox['emailtemplateid']?>"><?=$mailbox['name']?></option>
          <?php 
            $mailbox['message'] = str_replace('"', '\\"', preg_replace('/(\r\n|\n|\r)/mi', '', $mailbox['message']));
          ?>
        <?php endforeach; ?>
      </select>
    </div>
    <hr />
    <?php echo render_textarea('body', '', $body.$mail_signature, [], [], '', 'tinymce tinymce-compose'); ?>    
    </div>
    <div class="attachments">
      <div class="attachment">
        <div class="mbot15">
          <div class="form-group">
            <label for="attachment" class="control-label"><?php echo _l('ticket_add_attachments'); ?></label>
            <div class="input-group">
              <input type="file" extension="<?php echo str_replace('.', '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
              <span class="input-group-btn">
                <button class="btn btn-success add_more_attachments p8-half" data-max="<?php echo get_option('maximum_allowed_ticket_attachments'); ?>" type="button"><i class="fa fa-plus"></i></button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="btn-group pull-left">
      <a href="<?php echo admin_url().'mailbox'; ?>" class="btn btn-warning close-send-template-modal"><?php echo _l('cancel'); ?></a>       
    </div>

    <div class="pull-right">   
      <?php if (!isset($mail)) {?>   
      <button type="submit" name="sendmail" value="draft" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-primary">
        <i class="fa fa-file-o menu-icon"></i> <?php echo _l('mailbox_save_draft'); ?></button>
      <?php } ?>
      <button type="submit" name="sendmail" value="outbox" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-info">
          <i class="fa fa-paper-plane menu-icon"></i>
          <?php echo _l('mailbox_send'); ?>          
        </button>
    </div>
</div>
</div>
<?php echo form_close(); ?>
<script>
  var plantillas = JSON.parse('<?=json_encode($mailboxs)?>');
      
  function getPreload(selected){
    if(!selected.value) return;
    let plantilla = plantillas.find( plantilla => plantilla.emailtemplateid === selected.value );
    tinymce.activeEditor.setContent(plantilla.message, {format: 'raw'});
  }
  
</script>