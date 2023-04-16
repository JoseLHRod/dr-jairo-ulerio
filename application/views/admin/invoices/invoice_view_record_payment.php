<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" data-editor-id=".<?php echo 'tinymce-'.$invoice->id; ?>" id="invoice_view_record_payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    View Record Payment
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                    <form action="<?php echo base_url('invoice') . '/update_status3/' . $invoice->id ?>" id="online_payment_form3" novalidate="1" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <input
                           id="denied_payment"
                           type="submit"
                           name="denied_payment"
                           class="btn btn-danger"
                           value="denied Payment">
                    </form>
                    <form action="<?php echo base_url('invoice') . '/update_status/' . $invoice->id ?>" id="online_payment_form3" novalidate="1" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    
                    <div  class="form-group mbot15">
                        <input
                           id="accept_payment"
                           type="submit"
                           name="view_payment"
                           class="btn btn-success"
                           value="Accept Payment">
                    </div>
                    <div class="form-group mbot15">
                        <label class="control-label">Payment Method:</label>
                        <?php echo $invoice->paymentmode; ?>                  
                    </div>
                    <div class="form-group mbot15">
                        <label class="control-label">Payment Amount :</label>
                        <?php echo $invoice->paymentamount; ?> 
                    </div>
                    <div class="form-group mbot15">
                        <label class="control-label">Payment Screenshot:</label>
                        <a href="<?php echo base_url('uploads') . '/' . $invoice->paymentpic; ?>" style="cursor: pointer;" target="_blank">
                            <img src="<?php echo base_url('uploads') . '/' . $invoice->paymentpic; ?>" alt="" style="width: 100%;">
                        </a>
                    </div>
                    <div  class="form-group mbot15">
                        <input
                           id="accept_payment"
                           type="submit"
                           name="view_payment"
                           class="btn btn-success"
                           value="Accept Payment">
                    </div>
                    </form>
                    <form action="<?php echo base_url('invoice') . '/update_status3/' . $invoice->id ?>" id="online_payment_form3" novalidate="1" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <input
                           id="denied_payment"
                           type="submit"
                           name="denied_payment"
                           class="btn btn-danger"
                           value="denied Payment">
                    </form>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<script>
    /* ajax request */
    $(document).on('submit', '#online_payment_form3', function(e) {
        e.preventDefault();
         
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
</script>