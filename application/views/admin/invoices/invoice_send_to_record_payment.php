<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" data-editor-id=".<?php echo 'tinymce-'.$invoice->id; ?>" id="invoice_send_to_record_payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    Upload Record Payment
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                    <form action="<?php echo base_url('invoice') . '/payment_m/' . $invoice->id ?>" id="online_payment_form2" novalidate="1" method="post" accept-charset="utf-8" enctype="multipart/form-data">
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
                </div>
            </div>
        </div>
    </div>
</div>

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
        $(document).on('submit', '#online_payment_form2', function(e) {
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

            var validator = $('form#online_payment_form2').validate();

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
