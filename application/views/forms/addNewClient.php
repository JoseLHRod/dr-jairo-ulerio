<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
// $name = $_GET['name'];
// $mail = $_GET['email'];
// $age = $_GET['age'];
// $weight = $_GET['weight'];
// $height = $_GET['height'];
// $phone = $_GET['phonenumber'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= _l('add_client_title'); ?></title>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/form.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.css">
</head>

<style>
  .close {
    position: absolute;
    top: 5%;
    right: -20%;
  }

  .d-flex-column {
    display: flex;
    flex-direction: column;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #5cb85c;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #5cb85c;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  .slider.round {
    border-radius: 34px;
    margin-bottom: 0px;
  }

  .slider.round:before {
    border-radius: 50%;
  }



  .btn-default {
    color: #333;
    background-color: #e6e6e6;
    border-color: #adadad;
  }
</style>

<body>
  <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
  <?php echo form_open_multipart($actual_link, array('class' => 'newClientForm', 'id' => 'newClientForm')); ?>
  <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
  <div class="stepsContainer">
    <h2 class="formTitle"><?= _l('add_client_title'); ?></h2>

    <div class="customRow">
      <div class="inputExternal">
        <label for="full_name"><?php echo _l('add_client_name'); ?> <span class="inputReq">*</span></label>
        <input type="text" name="name" value="<?php echo $name; ?>" required>
      </div>

      <div class="inputExternal">
        <label for="phonenumber"><?php echo _l('add_client_number'); ?> <span class="inputReq">*</span></label>
        <input type="text" name="phonenumber" value="<?php echo $phone; ?>" required  onkeypress="return valideKey(event);">
      </div>

      <div class="inputExternal">
        <label for="email"><?php echo _l('add_client_email'); ?> <span class="inputReq">*</span></label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>
      </div>
    </div>

    <div class="customRow">
      <div class="inputExternal">
        <label for="input"><?php echo _l('add_client_age'); ?> <span class="inputReq">*</span></label>
        <input type="text" name="age" value="<?php echo $age; ?>" required  onkeypress="return valideKey(event);">
      </div>

      <div class="inputExternal">
        <label for="weight"><?php echo _l('add_client_weight'); ?> <span class="inputReq">*</span></label>
        <input type="number" name="weight" value="<?php echo $weight; ?>" min="0" size="2" required>
      </div>

      <div class="inputExternal" style="min-height: 48.28px;">
        <label for="height"><?php echo _l('add_client_height'); ?> <span class="inputReq">*</span></label>
        <label for="heightfeet" style="display: inline-block;float: none;">Feet:</label>
        <input type="number" name="heightfeet" value="<?php echo $heightfeet; ?>" min="0" size="2" style="display: inline-block;float: none;width: 15%;border-bottom: 1px solid #DDDDDD;text-align:center;
" required>
        <label for="heightfeet" style="display: inline-block;float: none;">'</label>
        <label for="heightinches" style="display: inline-block;float: none;">Inches:</label>
        <input type="number" name="heightinches" value="<?php echo $heightinches; ?>" min="0" size="3" style="display: inline-block;float: none;width: 15%;border-bottom: 1px solid #DDDDDD;text-align:center;
" required>        
        <label for="heightinches" style="display: inline-block;float: none;">''</label>        
      </div>
    </div>

    <div class="customRow">
      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_diabetes'); ?></span>

        <label class="switch">
          <input type="checkbox" name="diabetes" id="diabetes">
          <span class="slider round"></span>
        </label>
      </div>

      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_asm'); ?></span>

        <label class="switch">
          <input type="checkbox" name="asthma" id="asthma">
          <span class="slider round"></span>
        </label>
      </div>

      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_smoke'); ?></span>

        <label class="switch">
          <input type="checkbox" name="smoke" id="smoke">
          <span class="slider round"></span>
        </label>
      </div>
    </div>

    <div class="customRow">
      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_surgery'); ?></span>

        <label class="switch">
          <input type="checkbox" name="surgeries" id="surgeries">
          <span class="slider round"></span>
        </label>
      </div>

      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_desease'); ?></span>

        <label class="switch">
          <input type="checkbox" name="disease" id="disease">
          <span class="slider round"></span>
        </label>
      </div>

      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_alergy'); ?></span>

        <label class="switch">
          <input type="checkbox" name="allergies" id="allergies">
          <span class="slider round"></span>
        </label>
      </div>
    </div>

    <div class="customRow customRow-1">
      <div class="inputExternal">
        <label for="meds"><?php echo _l('add_client_meds'); ?></label>
        <input type="text" name="meds">
      </div>
    </div>

    <div class="customRow customRow-4">
      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_anti'); ?></span>

        <label class="switch">
          <input type="checkbox" name="contraceptives" id="contraceptives">
          <span class="slider round"></span>
        </label>
      </div>

      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_hospitalized'); ?></span>

        <label class="switch">
          <input type="checkbox" name="hospitalized" id="hospitalized">
          <span class="slider round"></span>
        </label>
      </div>

      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_relatives'); ?></span>

        <label class="switch">
          <input type="checkbox" name="relatives" id="relatives">
          <span class="slider round"></span>
        </label>
      </div>

      <div class="form-group d-flex-column">
        <span><?php echo _l('add_client_children'); ?></span>

        <label class="switch">
          <input type="checkbox" name="children" id="children">
          <span class="slider round"></span>
        </label>
      </div>
    </div>

    <div class="customRow customRow-1">
      <div class="inputExternal">
        <label for="meds"><?php echo _l('add_client_precedure'); ?> <span class="inputReq">*</span></label>
        <textarea name="procedures" cols="30" customRows="10" required></textarea>
      </div>
    </div>

    <div class="customRow">
      <div class="inputExternal">
        <label for="surgery_date"><?php echo _l('add_client_date'); ?> <span class="inputReq">*</span></label>
        <input type="date" name="surgery_date" required>
      </div>
    </div>

    <div class="customRow customRow-1">
      <div class="form-group">
        <span><?php echo _l('add_client_find_us'); ?></span>

        <div class="input-group checkboxGroup">
          <label><input type="checkbox" name="howYouFindUs[]" value="socialMedia" /> <?php echo _l('add_client_social'); ?></label>
          <label><input type="checkbox" name="howYouFindUs[]" value="google" /> <?php echo _l('add_client_google'); ?></label>
          <label><input type="checkbox" name="howYouFindUs[]" value="press" /> <?php echo _l('add_client_news'); ?></label>
          <label><input type="checkbox" name="howYouFindUs[]" value="friends" /> <?php echo _l('add_client_friends'); ?></label>
          <label><input type="checkbox" name="howYouFindUs[]" value="ads" /> <?php echo _l('add_client_ads'); ?></label>
          <label><input type="checkbox" name="howYouFindUs[]" value="other" /> <?php echo _l('add_client_other'); ?></label>
          <label><input type="checkbox" name="howYouFindUs[]" value="withRelatives" /> <?php echo _l('add_client_rel'); ?></label>
          <label><input type="checkbox" name="howYouFindUs[]" value="withAcquaintances" /> <?php echo _l('add_client_acc'); ?></label>
        </div>
      </div>
    </div>

    <div class="filesContainer">
      <div class="falseInputContainer">
        <span class="falseInputLabel"><?php echo _l('add_client_img_front'); ?></span>
        <input class="file_input simpleFormUpload" name="frontPic" accept="image/png, image/jpeg" type="file" />

        <!-- Image preview -->
        <div style="position: relative;">
          <a class="fancyWrapper" id="frontPicLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
            <img class="fancyImg" id="frontPic" alt="front-img" />
          </a>

          <button id="frontPicButton" type="button" class="close" aria-label="Close" style="display: none">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>

      <div class="falseInputContainer">
        <span class="falseInputLabel"><?php echo _l('add_client_img_lat_1'); ?></span>
        <input class="file_input simpleFormUpload" name="latPicLeft" accept="image/png, image/jpeg" type="file" />

        <!-- Image preview -->
        <div style="position: relative;">
          <a class="fancyWrapper" id="latPicLeftLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
            <img class="fancyImg" id="latPicLeft" alt="lateral-left-img" />
          </a>

          <button id="latPicLeftButton" type="button" class="close" aria-label="Close" style="display: none">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>

      <div class="falseInputContainer">
        <span class="falseInputLabel"><?php echo _l('add_client_img_lat_2'); ?></span>
        <input class="file_input simpleFormUpload" name="latPicRight" accept="image/png, image/jpeg" type="file" />

        <!-- Image preview -->
        <div style="position: relative;">
          <a class="fancyWrapper" id="latPicRightLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
            <img class="fancyImg" id="latPicRight" alt="lateral-right-img" />
          </a>

          <button id="latPicRightButton" type="button" class="close" aria-label="Close" style="display: none">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>

      <div class="falseInputContainer">
        <span class="falseInputLabel"><?php echo _l('add_client_img_back'); ?></span>
        <input class="file_input simpleFormUpload" name="backPic" accept="image/png, image/jpeg" type="file" />

        <!-- Image preview -->
        <div style="position: relative;">
          <a class="fancyWrapper" id="backPicLink" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none;">
            <img class="fancyImg" id="backPic" alt="lateral-back-img" />
          </a>

          <button id="backPicButton" type="button" class="close" aria-label="Close" style="display: none">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    </div>

    <div class="customRow customRow-1">
      <input class="formMainBtn" type="submit" value="<?php echo _l('add_client_send'); ?>">
    </div>
  </div>
  <?php echo form_close(); ?>

  <script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>
  <script>
		function valideKey(evt){
			
			// code is the decimal ASCII representation of the pressed key.
			var code = (evt.which) ? evt.which : evt.keyCode;
			
			if(code==8) { // backspace.
			  return true;
			} else if(code>=48 && code<=57) { // is a number.
			  return true;
			} else{ // other keys.
			  return false;
			}
		}
	</script>
  <script>
    var validator = $('form.newClientForm').validate();

    const fileTypes = [
        "image/jpeg",
        "image/pjpeg",
        "image/png",
      ],
      textInputFile = {
        "frontPic": '<?php echo _l('add_client_img_front'); ?>',
        "latPicLeft": '<?php echo _l('add_client_img_lat_1'); ?>',
        "latPicRight": '<?php echo _l('add_client_img_lat_2'); ?>',
        "backPic": '<?php echo _l('add_client_img_back'); ?>'
      };

    let TempImage = {
        "frontPic": null,
        "latPicLeft": null,
        "latPicRight": null,
        "backPic": null
      },
      validImages = true;

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

    // clear the input file and image preview
    $(".close").click(function(e) {
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
    $("body").on('submit', '#newClientForm', function() {
      var data = new FormData($(this)[0]);

      if (validImages == false) {
        alert("the images are invalid, can not be save the data. need to be select another images");
      } else {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('form'); ?>",
          cache: false,
          contentType: false,
          processData: false,
          data: data,
          beforeSend: function(objeto) {
            console.log("Enviando...");
          },
          success: function(response) {
            response = JSON.parse(response);

            if (response.code == 1) {
              window.location = response.redirect;
            } else {
              alert(response.msg);
              window.location = response.redirect;
            }
          },
          error: function(xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText;
            alert('Error - ' + errorMessage);

          }
        });
      }

      return false;
    });
  </script>
</body>

</html>