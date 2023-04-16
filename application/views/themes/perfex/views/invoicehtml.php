<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="mtop15 preview-top-wrapper">
   <div class="row">
      <div class="col-md-3">
         <div class="mbot30">
            <div class="invoice-html-logo">
               <?php echo get_dark_company_logo(); ?>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
   </div>
   <div class="top" data-sticky data-sticky-class="preview-sticky-header">
      <div class="container preview-sticky-container">
         <div class="row">
            <div class="col-md-12">
               <div class="pull-left">
                  <h3 class="bold no-mtop invoice-html-number no-mbot">
                     <span class="sticky-visible hide">
                     <?php echo format_invoice_number($invoice->id); ?>
                     </span>
                  </h3>
                  <h4 class="invoice-html-status mtop7">
                     <?php echo format_invoice_status($invoice->status,'',true); ?>
                  </h4>
               </div>
               <div class="visible-xs">
                  <div class="clearfix"></div>
               </div>
               <a href="#"
                  class="btn btn-success pull-right mleft5 mtop5 action-button invoice-html-pay-now-top hide sticky-hidden
                  <?php if (($invoice->status != Invoices_model::STATUS_PAID && $invoice->status != Invoices_model::STATUS_CANCELLED
                     && $invoice->total > 0) && found_invoice_mode($payment_modes,$invoice->id, false)){ echo ' pay-now-top'; } ?>">
               <?php echo _l('invoice_html_online_payment_button_text'); ?>
               </a>
               <?php echo form_open($this->uri->uri_string()); ?>
               <button type="submit" name="invoicepdf" value="invoicepdf" class="btn btn-default pull-right action-button mtop5">
               <i class='fa fa-file-pdf-o'></i>
               <?php echo _l('clients_invoice_html_btn_download'); ?>
               </button>
               <?php echo form_close(); ?>
               <?php if(is_client_logged_in() && has_contact_permission('invoices')){ ?>
               <a href="<?php echo site_url('clients/invoices/'); ?>" class="btn btn-default pull-right mtop5 mright5 action-button go-to-portal">
               <?php echo _l('client_go_to_dashboard'); ?>
               </a>
               <?php } ?>
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="clearfix"></div>
<div class="panel_s mtop20">
   <div class="panel-body">
      <div class="col-md-10 col-md-offset-1">
         <div class="row mtop20">
            <div class="col-md-6 col-sm-6 transaction-html-info-col-left">
               <h4 class="bold invoice-html-number"><?php echo format_invoice_number($invoice->id); ?></h4>
               <address class="invoice-html-company-info">
                  <?php echo format_organization_info(); ?>
               </address>
            </div>
            <div class="col-sm-6 text-right transaction-html-info-col-right">
               <span class="bold invoice-html-bill-to"><?php echo _l('invoice_bill_to'); ?>:</span>
               <address class="invoice-html-customer-billing-info">
                  <?php echo format_customer_info($invoice, 'invoice', 'billing'); ?>
               </address>
               <!-- shipping details -->
               <?php if($invoice->include_shipping == 1 && $invoice->show_shipping_on_invoice == 1){ ?>
               <span class="bold invoice-html-ship-to"><?php echo _l('ship_to'); ?>:</span>
               <address class="invoice-html-customer-shipping-info">
                  <?php echo format_customer_info($invoice, 'invoice', 'shipping'); ?>
               </address>
               <?php } ?>
               <p class="no-mbot invoice-html-date">
                  <span class="bold">
                  <?php echo _l('invoice_data_date'); ?>
                  </span>
                  <?php echo _d($invoice->date); ?>
               </p>
               <?php if(!empty($invoice->duedate)){ ?>
               <p class="no-mbot invoice-html-duedate">
                  <span class="bold"><?php echo _l('invoice_data_duedate'); ?></span>
                  <?php echo _d($invoice->duedate); ?>
               </p>
               <?php } ?>
               <?php if($invoice->sale_agent != 0 && get_option('show_sale_agent_on_invoices') == 1){ ?>
               <p class="no-mbot invoice-html-sale-agent">
                  <span class="bold"><?php echo _l('sale_agent_string'); ?>:</span>
                  <?php echo get_staff_full_name($invoice->sale_agent); ?>
               </p>
               <?php } ?>
               <?php if($invoice->project_id != 0 && get_option('show_project_on_invoice') == 1){ ?>
               <p class="no-mbot invoice-html-project">
                  <span class="bold"><?php echo _l('project'); ?>:</span>
                  <?php echo get_project_name_by_id($invoice->project_id); ?>
               </p>
               <?php } ?>
               <?php $pdf_custom_fields = get_custom_fields('invoice',array('show_on_pdf'=>1,'show_on_client_portal'=>1));
                  foreach($pdf_custom_fields as $field){
                    $value = get_custom_field_value($invoice->id,$field['id'],'invoice');
                    if($value == ''){continue;} ?>
               <p class="no-mbot">
                  <span class="bold"><?php echo $field['name']; ?>: </span>
                  <?php echo $value; ?>
               </p>
               <?php } ?>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="table-responsive">
                  <?php
                     $items = get_items_table_data($invoice, 'invoice');
                     echo $items->table();
                     ?>
               </div>
            </div>
            <div class="col-md-6 col-md-offset-6">
               <table class="table text-right">
                  <tbody>
                     <tr id="subtotal">
                        <td><span class="bold"><?php echo _l('invoice_subtotal'); ?></span>
                        </td>
                        <td class="subtotal">
                           <?php echo app_format_money($invoice->subtotal, $invoice->currency_name); ?>
                        </td>
                     </tr>
                     <?php if(is_sale_discount_applied($invoice)){ ?>
                     <tr>
                        <td>
                           <span class="bold"><?php echo _l('invoice_discount'); ?>
                           <?php if(is_sale_discount($invoice,'percent')){ ?>
                           (<?php echo app_format_number($invoice->discount_percent,true); ?>%)
                           <?php } ?></span>
                        </td>
                        <td class="discount">
                           <?php echo '-' . app_format_money($invoice->discount_total, $invoice->currency_name); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php
                        foreach($items->taxes() as $tax){
                          echo '<tr class="tax-area"><td class="bold">'.$tax['taxname'].' ('.app_format_number($tax['taxrate']).'%)</td><td>'.app_format_money($tax['total_tax'], $invoice->currency_name).'</td></tr>';
                        }
                        ?>
                     <?php if((int)$invoice->adjustment != 0){ ?>
                     <tr>
                        <td>
                           <span class="bold"><?php echo _l('invoice_adjustment'); ?></span>
                        </td>
                        <td class="adjustment">
                           <?php echo app_format_money($invoice->adjustment, $invoice->currency_name); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php if($invoice->payment_deposited==1 && $invoice->paymentamount>0){ ?>
                     <tr>
                        <td>
                           <span class="bold">Payment Deposited</span>
                        </td>
                        <td class="paymentamount">
                           <?php echo '-'.app_format_money($invoice->paymentamount, $invoice->currency_name); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <tr>
                        <td><span class="bold"><?php echo _l('invoice_total'); ?></span>
                        </td>
                        <td class="total">
                           <?php echo app_format_money($invoice->total, $invoice->currency_name); ?>
                        </td>
                     </tr>
                     <?php if(count($invoice->payments) > 0 && get_option('show_total_paid_on_invoice') == 1){ ?>
                     <tr>
                        <td><span class="bold"><?php echo _l('invoice_total_paid'); ?></span></td>
                        <td>
                           <?php echo '-' . app_format_money(sum_from_table(db_prefix().'invoicepaymentrecords',array('field'=>'amount','where'=>array('invoiceid'=>$invoice->id))), $invoice->currency_name); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php if(get_option('show_credits_applied_on_invoice') == 1 && $credits_applied = total_credits_applied_to_invoice($invoice->id)){ ?>
                     <tr>
                        <td><span class="bold"><?php echo _l('applied_credits'); ?></span></td>
                        <td>
                           <?php echo '-' . app_format_money($credits_applied, $invoice->currency_name); ?>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php if(get_option('show_amount_due_on_invoice') == 1 && $invoice->status != Invoices_model::STATUS_CANCELLED) { ?>
                     <tr>
                        <td><span class="<?php if($invoice->total_left_to_pay > 0){echo 'text-danger ';} ?>bold"><?php echo _l('invoice_amount_due'); ?></span></td>
                        <td>
                           <span class="<?php if($invoice->total_left_to_pay > 0){echo 'text-danger';} ?>">
                           <?php echo app_format_money($invoice->total_left_to_pay, $invoice->currency_name); ?>
                           </span>
                        </td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
            <?php if(get_option('total_to_words_enabled') == 1){ ?>
            <div class="col-md-12 text-center invoice-html-total-to-words">
               <p class="bold no-margin">
                  <?php echo  _l('num_word').': '.$this->numberword->convert($invoice->total, $invoice->currency_name); ?>
               </p>
            </div>
            <?php } ?>
            <?php if(count($invoice->attachments) > 0 && $invoice->visible_attachments_to_customer_found == true){ ?>
            <div class="clearfix"></div>
            <div class="invoice-html-files">
               <div class="col-md-12">
                  <hr />
                  <p class="bold mbot15 font-medium"><?php echo _l('invoice_files'); ?></p>
               </div>
               <?php foreach($invoice->attachments as $attachment){
                  // Do not show hidden attachments to customer
                  if($attachment['visible_to_customer'] == 0){continue;}
                  $attachment_url = site_url('download/file/sales_attachment/'.$attachment['attachment_key']);
                  if(!empty($attachment['external'])){
                  $attachment_url = $attachment['external_link'];
                  }
                  ?>
               <div class="col-md-12 mbot10">
                  <div class="pull-left"><i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i></div>
                  <a href="<?php echo $attachment_url; ?>"><?php echo $attachment['file_name']; ?></a>
               </div>
               <?php } ?>
            </div>
            <?php } ?>
            <?php if(!empty($invoice->clientnote)){ ?>
            <div class="col-md-12 invoice-html-note">
               <b><?php echo _l('invoice_note'); ?></b><br /><br /><?php echo $invoice->clientnote; ?>
            </div>
            <?php } ?>
            <?php if(!empty($invoice->terms)){ ?>
            <div class="col-md-12 invoice-html-terms-and-conditions">
               <hr />
               <b><?php echo _l('terms_and_conditions'); ?></b><br /><br /><?php echo $invoice->terms; ?>
            </div>
            <?php } ?>
            <div class="col-md-12">
               <hr />
            </div>
            <div class="col-md-12 invoice-html-payments">
               <?php
                  $total_payments = count($invoice->payments);
                  if($total_payments > 0){ ?>
               <p class="bold mbot15 font-medium"><?php echo _l('invoice_received_payments'); ?></p>
               <table class="table table-hover invoice-payments-table">
                  <thead>
                     <tr>
                        <th><?php echo _l('invoice_payments_table_number_heading'); ?></th>
                        <th><?php echo _l('invoice_payments_table_mode_heading'); ?></th>
                        <th><?php echo _l('invoice_payments_table_date_heading'); ?></th>
                        <th><?php echo _l('invoice_payments_table_amount_heading'); ?></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($invoice->payments as $payment){ ?>
                     <tr>
                        <td>
                           <span class="pull-left"><?php echo $payment['paymentid']; ?></span>
                           <?php echo form_open($this->uri->uri_string()); ?>
                           <button type="submit" value="<?php echo $payment['paymentid']; ?>" class="btn btn-icon btn-default pull-right" name="paymentpdf"><i class="fa fa-file-pdf-o"></i></button>
                           <?php echo form_close(); ?>
                        </td>
                        <td><?php echo $payment['name']; ?> <?php if(!empty($payment['paymentmethod'])){echo ' - '.$payment['paymentmethod']; } ?></td>
                        <td><?php echo _d($payment['date']); ?></td>
                        <td><?php echo app_format_money($payment['amount'], $invoice->currency_name); ?></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
               <hr />
               <?php } else { ?>
               <h5 class="bold pull-left"><?php echo _l('invoice_no_payments_found'); ?></h5>
               <div class="clearfix"></div>
               <hr />
               <?php } ?>
            </div>
            <?php
               // No payments for paid and cancelled
               if (($invoice->status != Invoices_model::STATUS_PAID
               && $invoice->status != Invoices_model::STATUS_CANCELLED
               && $invoice->total > 0)){ ?>
            <div class="col-md-12">
               <div class="row">
                  <?php
                     $found_online_mode = false;
                     if(found_invoice_mode($payment_modes,$invoice->id,false)) {
                       $found_online_mode = true;
                       ?>
                  <?php if($invoice->status!=7 && $invoice->status!=8) { ?>
                  <div class="col-md-6 text-left">
                     <p class="bold mbot15 font-medium">Payment Method</p>
                     <div style="max-width: 300px;">
                        <div class="row">
                        <div class="col-sm-12 text-left">
                        <p>To save your surgery and ensure your place in the operating room, All patients must deposit U$500 dollars, which can be formalized in the following ways :</p>
                        </div>
                        <div class="col-sm-6 text-center">
                        <a href="#" data-toggle="tooltip" title="Pay with paypal" class="payment-paypal-modal btn btn-default btn-with-tooltip" data-placement="bottom">
                           <img src="<?php echo base_url('uploads/paypal.png'); ?>" alt="" style="width: 100%;">
                        </a>
                        </div>
                        <div class="col-sm-6 text-center">
                        <a href="#" data-toggle="tooltip" title="Pay with zelle" class="payment-zelle-modal btn btn-default btn-with-tooltip" data-placement="bottom">
                           <img src="<?php echo base_url('uploads/zelle.png'); ?>" alt="" style="width: 100%;">
                        </a>
                        </div>
                        </div>
                     </div>
                     <br>
                     <p class="bold mbot15 font-medium">Record Payment</p>
                     <form action="<?php echo base_url('invoice') . '/payment/' . $invoice->id . '/' . $invoice->hash;?>" id="online_payment_form" novalidate="1" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                     <div class="form-group mbot15">
                        <label for="paymentmode" class="control-label">Payment Method:</label>
                        <select id="paymentmode" name="paymentmode" required>
                           <option value="PayPal">PayPal</option>
                           <option value="Zelle">Zelle</option>
                        </select>                        
                     </div>
                     <div class="form-group mbot15">
                        <label for="amount" class="control-label">Payment Amount :</label>
                        <input type="number" required min="0" id="paymentamount" name="paymentamount" value="500.00">
                     </div>
                     <div class="form-group mbot15">
                        <label class="control-label">Upload Payment Screenshot:</label>
                        <input id="paymentpic" class="file_input" name="paymentpic" accept="image/*" type="file" required="required">
                     </div>
                     <style>
                        input[type="number"]:focus, input[type="file"]:focus {
                        border-color: rgb(255, 144, 0);
                        box-shadow: 0 1px 1px rgba(229, 103, 23, 0.075)inset, 0 0 8px rgba(255,144,0,0.6);
                        outline: 0 none;
                        }
                     </style>
                     <div class="row">
                        <div class="col-sm-12 text-left">
                        <p style="font-size: 11px;">By paying this deposit you not only save the date of your surgery, but also the quoted price. This value is deducted from the surgery total and is refundable only if the surgery is cancelled by Dr. Ulerio. If the patient presents any health condition prior to the surgery that contraindicates its execution on that date(i.e. anemia, fever, sickness of any kind, etc.) the deposit will be used to save a new date.</p>
                        <p style="font-size: 11px;">This deposit will be lost if the date is changed by the patient 14 days or less before the surgery. The patient is entitled to two (2) reschedules, always with at least 14 days in advance and the new date must be within the range of twelve (12) months after the date the deposit was made.</p>
                        </div>
                     </div>
                     <div  class="form-group mbot15">
                        <input
                           id="send_payment"
                           type="submit"
                           name="send_payment"
                           class="btn btn-success"
                           value="Send Record Payment">
                     </div>
                     </form>
                  </div>
                  <?php } ?>
                  <?php } ?>
                  <?php if(found_invoice_mode($payment_modes,$invoice->id)) { ?>
                  <div class="invoice-html-offline-payments <?php if($found_online_mode == true){echo 'col-md-6 text-right';}else{echo 'col-md-12';};?>">
                     <p class="bold mbot15 font-medium"><?php echo _l('invoice_html_offline_payment'); ?></p>
                     <?php foreach($payment_modes as $mode){
                        if(is_numeric($mode['id'])) {
                          if(!is_payment_mode_allowed_for_invoice($mode['id'],$invoice->id)){
                            continue;
                         }
                         ?>
                     <p class="bold"><?php echo $mode['name']; ?></p>
                     <?php if(!empty($mode['description'])){ ?>
                     <div class="mbot15">
                        <?php echo $mode['description']; ?>
                     </div>
                     <?php }
                        }
                        } ?>
                  </div>
                  <?php } ?>
               </div>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" data-editor-id=".<?php echo 'tinymce-'.$invoice->id; ?>" id="payment_paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                Pay with PayPal
                </h4>
            </div>
            <div class="modal-body">
            <img src="<?php echo base_url('uploads/pago_paypal.jpg'); ?>" alt="" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" data-editor-id=".<?php echo 'tinymce-'.$invoice->id; ?>" id="payment_zelle_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                Pay with Zelle
                </h4>
            </div>
            <div class="modal-body">
               <img src="<?php echo base_url('uploads/pago_zelle.jpg'); ?>" alt="" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<script>
   $("body").on("click",".payment-paypal-modal",function(e){
      e.preventDefault();
      $("#payment_paypal_modal").modal("show");
   });
   $("body").on("click",".payment-zelle-modal",function(e){
      e.preventDefault();
      $("#payment_zelle_modal").modal("show");
   });
</script>
<script>
        /* 
            queries
        */
        const allElemntsQuery = ".inputContainer.active-panel .inputsWrapper .inputExternal input, .inputContainer.active-panel .inputsWrapper .inputExternal select, .inputContainer.active-panel .inputsWrapper .inputExternal textarea";
        const currentTabQuery = ".selectorContainer .tab a.active";

        const fileTypes = [
            "image/jpeg",
            "image/pjpeg",
            "image/png",
        ];

        let TempImage = {
                "frontPic": null,
                "latPicLeft": null,
                "latPicRight": null,
                "backPic": null
            },
            validImages = true;

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

        /* ajax request */
        $(document).on('submit', '#online_payment_form', function(e) {
         e.preventDefault();  
         
         if($('input#paymentamount').val()==0){
            $("input#paymentamount").focus();
            return false;
         }       
         if($('input#paymentpic')[0].files.length == 0){
            $("input#paymentpic").focus();
            return false;
         }
         
         var data = new FormData($(this)[0]);

            $.ajax({
                type: "POST",
                url: this.action,
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                success: function() {
                  location.reload();
               }
            });

            return false; 
            
        });

        function validate(elements) {
            var valid = true;

            var validator = $('form#online_payment_form').validate();

            elements.each(function() {
                if (!validator.element(this) && valid) {
                    valid = false;
                }
            });

            return valid;
        }
        /**
         * validate the file type(png, pjg, pjpeg)
         * 
         * @param input file
         */
        function validFileType(file) {
            return fileTypes.includes(file.type);
        }

        /**
         * return the size of the image
         * 
         * @param number int
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
    </script>
