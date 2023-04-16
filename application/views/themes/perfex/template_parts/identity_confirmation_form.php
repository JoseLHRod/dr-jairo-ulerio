<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" tabindex="-1" role="dialog" id="identityConfirmationModal">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <?php echo form_open((isset($formAction) ? $formAction : $this->uri->uri_string()), array('id'=>'identityConfirmationForm','class'=>'form-horizontal')); ?>
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?php echo _l('signature'); ?> &amp; <?php echo _l('confirmation_of_identity'); ?></h4>
  </div>
  <div class="modal-body">
  <p class="text-left text-muted e-sign-legal-text" style="font-size: 11px;">
    <b>Terms and Conditions</b><br>
    By paying this deposit, you not only lock in your date, you "lock in" your quoted price. This value is deducted from the total quoted and is refundable only if the surgery is canceled by Dr. Jairo Ulerio. If the patient presents any health condition before the surgery, which contraindicates its performance (anemia, fever, illness in any sense, etc.), the deposit will be used to reserve a new date in which the patient has recovered. This deposit will be forfeited if the date is changed or canceled less than fourteen (14) days in advance. In case of having to reschedule her surgery, the patient has the right to two (2) changes, always with a minimum anticipation of fourteen (14) days and the new date must be within the range of twelve (12) months counted from the date the deposit was made.
  </p>
  <p class="text-left text-muted e-sign-legal-text" style="font-size: 11px;">
    <b>Términos y Condiciones</b><br>
    Pagando este depósito, no solo resguarda su fecha, sino que "congela" su precio cotizado. Este valor es deducido del total cotizado y es reembolsable solo si la cirugía es cancelada por el Dr. Jairo Ulerio. Si el paciente presenta alguna condición de salud antes de la cirugía, que contraindique su ejecución (anemia, fiebre, enfermedad en cualquier sentido, etc.) el depósito será usado para reservar una nueva fecha donde el paciente se haya recuperado. Este depósito se perderá si la fecha es cambiada o cancelada con catorce (14) días menos de antelación. En caso de tener que reprogramar su cirugía, la paciente tiene derecho a dos (2) cambios, siempre con al menos catorce (14) días de anticipación y, la nueva fecha, debe estar dentro del rango de doce (12) meses desde la fecha que se realizó el depósito.
  </p>   
    <?php hooks()->do_action('before_confirmation_identity_fields'); ?>
    <?php if(isset($formData)){echo $formData;}; ?>
    <div id="identity_fields">
     <div class="form-group" style="margin: 0 !important;">
      <!--label for="acceptance_firstname" class="control-label col-sm-2">
        <span class="text-left inline-block full-width">
          <?php echo _l('client_firstname'); ?>
        </span>
      </label-->
      <div class="col-sm-10">
       <input type="hidden" name="acceptance_firstname" id="acceptance_firstname" class="form-control" required="true" value="<?php echo 'N/A';//echo (isset($contact) ? $contact->firstname : '') ?>">
     </div>
   </div>
   <div class="form-group" style="margin: 0 !important;">
    <!--label for="acceptance_lastname" class="control-label col-sm-2">
      <span class="text-left inline-block full-width">
        <?php echo _l('client_lastname'); ?>
      </span>
    </label-->
    <div class="col-sm-10">
     <input type="hidden" name="acceptance_lastname" id="acceptance_lastname" class="form-control" required="true" value="<?php echo 'N/A';//echo (isset($contact) ? $contact->lastname : '') ?>">
   </div>
 </div>
 <div class="form-group" style="margin: 0 !important;">
  <!--label for="acceptance_email" class="control-label col-sm-2">
    <span class="text-left inline-block full-width">
      <?php echo _l('client_email'); ?>
    </span>
  </label-->
  <div class="col-sm-10">
   <input type="hidden" name="acceptance_email" id="acceptance_email" class="form-control" required="true" value="<?php echo 'na@na.na';//echo (isset($contact) ? $contact->email : '') ?>">
 </div>
</div>
<p class="bold" id="signatureLabel" style="display:none;"><?php echo _l('signature'); ?></p>
<div class="signature-pad--body" style="display:none;">
  <canvas id="signature" height="130" width="550"></canvas>
</div>
<input type="text" style="width:1px; height:1px; border:0px;display:none;" tabindex="-1" name="signature" id="signatureInput">
<div class="dispay-block" style="display:none;">
  <button type="button" class="btn btn-default btn-xs clear" tabindex="-1" data-action="clear"><?php echo _l('clear'); ?></button>
  <button type="button" class="btn btn-default btn-xs" tabindex="-1" data-action="undo"><?php echo _l('undo'); ?></button>
</div>
<p class="text-left text-muted e-sign-legal-text">
<br>
<label for="cbox2"><input type="checkbox" id="cbox2" onclick="accept_tc()"> <?php echo _l(get_option('e_sign_legal_text'),'', false); ?></label>
</p>
</div>
<?php hooks()->do_action('after_confirmation_identity_fields'); ?>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('cancel'); ?></button>
 <button id="bcbox" type="submit" data-loading-text="<?php echo _l('wait_text'); ?>" autocomplete="off" data-form="#identityConfirmationForm" class="btn btn-success"><?php echo _l('e_signature_sign'); ?></button>
</div>
<?php echo form_close(); ?>
<script>
  document.getElementById("bcbox").disabled = true;
  function accept_tc() {
  var checkBox = document.getElementById("cbox2");
  if (checkBox.checked == true){
    document.getElementById("bcbox").disabled = false;
  } else {
    document.getElementById("bcbox").disabled = true;
  }
}
</script>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
  $this->app_scripts->theme('signature-pad','assets/plugins/signature-pad/signature_pad.min.js');
?>
<script>
  $(function(){
   SignaturePad.prototype.toDataURLAndRemoveBlanks = function() {
     var canvas = this._ctx.canvas;
       // First duplicate the canvas to not alter the original
       var croppedCanvas = document.createElement('canvas'),
       croppedCtx = croppedCanvas.getContext('2d');

       croppedCanvas.width = canvas.width;
       croppedCanvas.height = canvas.height;
       croppedCtx.drawImage(canvas, 0, 0);

       // Next do the actual cropping
       var w = croppedCanvas.width,
       h = croppedCanvas.height,
       pix = {
         x: [],
         y: []
       },
       imageData = croppedCtx.getImageData(0, 0, croppedCanvas.width, croppedCanvas.height),
       x, y, index;

       for (y = 0; y < h; y++) {
         for (x = 0; x < w; x++) {
           index = (y * w + x) * 4;
           if (imageData.data[index + 3] > 0) {
             pix.x.push(x);
             pix.y.push(y);

           }
         }
       }
       pix.x.sort(function(a, b) {
         return a - b
       });
       pix.y.sort(function(a, b) {
         return a - b
       });
       var n = pix.x.length - 1;

       w = pix.x[n] - pix.x[0];
       h = pix.y[n] - pix.y[0];
       var cut = croppedCtx.getImageData(pix.x[0], pix.y[0], w, h);

       croppedCanvas.width = w;
       croppedCanvas.height = h;
       croppedCtx.putImageData(cut, 0, 0);

       return croppedCanvas.toDataURL();
     };


     function signaturePadChanged() {

       var input = document.getElementById('signatureInput');
       var $signatureLabel = $('#signatureLabel');
       $signatureLabel.removeClass('text-danger');

       if (signaturePad.isEmpty()) {
         $signatureLabel.addClass('text-danger');
         input.value = '';
         return false;
       }

       $('#signatureInput-error').remove();
       var partBase64 = signaturePad.toDataURLAndRemoveBlanks();
       partBase64 = partBase64.split(',')[1];
       input.value = partBase64;
     }

     var canvas = document.getElementById("signature");
     var clearButton = wrapper.querySelector("[data-action=clear]");
     var undoButton = wrapper.querySelector("[data-action=undo]");
     var identityFormSubmit = document.getElementById('identityConfirmationForm');

     var signaturePad = new SignaturePad(canvas, {
      maxWidth: 2,
      onEnd:function(){
        signaturePadChanged();
      }
    });

     clearButton.addEventListener("click", function(event) {
       signaturePad.clear();
       signaturePadChanged();
     });

     undoButton.addEventListener("click", function(event) {
       var data = signaturePad.toData();
       if (data) {
           data.pop(); // remove the last dot or line
           signaturePad.fromData(data);
           signaturePadChanged();
         }
       });
      signaturePad.fromDataURL("data:image/gif;base64,R0lGODdhAQABAPAAAP8AAAAAACwAAAAAAQABAAACAkQBADs=", { ratio: 1, width: 1, height: 1, xOffset: 0, yOffset: 0 });

     $('#identityConfirmationForm').submit(function() {
       signaturePadChanged();
     });
   });
 </script>
