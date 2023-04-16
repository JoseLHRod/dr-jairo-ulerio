<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= _l('clinic_hist'); ?></title>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/form.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/dropzone/min/basic.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.css">
</head>

<style>
    .close {
        position: absolute;
        top: 5%;
        right: -20%;
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
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .btn-default {
        color: #333;
        background-color: #e6e6e6;
        border-color: #adadad;
    }

    .inputExternal > label {
    font-size: 1.3rem;
    color: #000000;
    font-family: Arial, Helvetica;
    } 
    .inputExternal label.error {
        margin: 0;
        left: 0;
        bottom: -20px;
        padding: 0 10px;
        font-size: 12px;
        min-width: 200px;
        background: #ffffff;
        justify-content: left;
    }   
</style>

<body>
    <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
    <?php echo form_open_multipart($actual_link, array('class' => 'newPatitentForm', 'id' => 'patientForm')); ?>

    <div class="formContainer">
        <div class="selectorContainer">
            <?php for ($i = 0; $i < 6; $i++) { ?>
                <div class="tab">
                    <a href="#tab<?php echo $i + 1; ?>"><?= _l('tabs'); ?> <?php echo $i + 1; ?></a>
                </div>
            <?php } ?>
        </div>

        <div class="stepsContainer">
            <?php foreach ($forms as $formKey => $formStep) { ?>
                <div id="tab<?php echo $formKey; ?>" class="inputContainer">
                    <h1 class="containerTitle"><?= _l('clinic_hist'); ?></h1>
                    <h1 class="containerSubtitle"><?= _l('step' . $formKey); ?></h1>

                    <div class="inputsWrapper">
                        <?php foreach ($formStep as $field => $values) { ?>
                            <div class="inputExternal">
                                <label for="<?php echo $values['keyname']; ?>" <?php if($values['keyname'] == 'pheight'){ ?>style="float: none;max-width: 200px;"<?php } ?>>
                                    <?php
                                    echo _l($values['labelKey']);

                                    if ($values['required']) {
                                        echo ' <span class="inputReq">*</span>';
                                    }
                                    ?>
                                </label>

                                <?php
                                if (
                                    $values['inputType'] == 'date' ||
                                    $values['inputType'] == 'text' ||
                                    $values['inputType'] == 'email' ||
                                    $values['inputType'] == 'number'
                                ) { 
                                    if (
                                        $values['keyname'] == 'pheight'
                                    ) {?>  
                                    
                                    <label for="<?php echo $values['heightfeet']['keyname']; ?>" style="display: inline-block;float: none;"><?php echo $values['heightfeet']['labelKey']; ?>:</label>
                                    <input type="<?php echo $values['heightfeet']['inputType']; ?>" name="<?php echo $values['heightfeet']['keyname']; ?>" value="<?php echo $values['heightfeet']['inputValue']; ?>" min="0" size="2" style="display: inline-block;float: none;width: 15%;border-bottom: 1px solid #DDDDDD;text-align:center;
" <?php echo $values['heightfeet']['required']; ?>>
                                    <label for="<?php echo $values['heightfeet']['keyname']; ?>" style="display: inline-block;float: none;">'</label>
                                    
                                    <label for="<?php echo $values['heightinches']['keyname']; ?>" style="display: inline-block;float: none;"><?php echo $values['heightinches']['labelKey']; ?>:</label>
                                    <input type="<?php echo $values['heightinches']['inputType']; ?>" name="<?php echo $values['heightinches']['keyname']; ?>" value="<?php echo $values['heightinches']['inputValue']; ?>" min="0" size="3" style="display: inline-block;float: none;width: 15%;border-bottom: 1px solid #DDDDDD;text-align:center;
" <?php echo $values['heightinches']['required']; ?>>        
                                    <label for="<?php echo $values['heightinches']['keyname']; ?>" style="display: inline-block;float: none;">''</label>  
                                    
                                    <?php } else {?>                                   
                                    <input type="<?php echo $values['inputType']; ?>" name="<?php echo $values['keyname']; ?>" value="<?php echo $values['inputValue']; ?>" <?php echo $values['required']; ?> />
                                    <?php } ?>
                                    <?php } else {
                                    if ($values['inputType'] == 'textarea') { ?>
                                        <textarea name="<?php echo $values['keyname']; ?>" <?php echo $values['required']; ?>><?php echo $values['inputValue']; ?></textarea>
                                        <?php } else {
                                        if ($values['inputType'] == 'select') { ?>
                                            <select name="<?php echo $values['keyname']; ?>" <?php echo $values['required']; ?>>
                                                <?php
                                                foreach ($values['selectOptions'] as $option => $optionValue) { ?>
                                                    <option value="<?php echo $optionValue; ?>" <?php echo (intval($values['inputValue']) == $option) ? 'selected' : ''; ?>>
                                                        <?php
                                                        if ($values['selectDual']) {
                                                            echo $option;
                                                        } else {
                                                            echo $optionValue;
                                                        }
                                                        ?>
                                                    </option>
                                                <?php }
                                                ?>
                                            </select>
                                            <?php } else {
                                            if ($values['inputType'] == 'checkbox') { ?>
                                                <div class="checkboxContainer">
                                                    <label class="switch">
                                                        <input type="checkbox" name="<?php echo $values['keyname']; ?>" id="<?php echo $values['keyname']; ?>" <?php echo ($values['inputValue'] == 1) ? 'checked' : ''; ?> <?php echo $values['required']; ?> >
                                                        <span class="slider round" style="z-index: 1;"></span>
                                                    </label>
                                                </div>
                                                <?php } else {
                                                if ($values['inputType'] == 'file') { ?>
                                                    <div class="falseInputContainer">
                                                        <span class="falseInputLabel"><?= _l('drag_drop'); ?></span>

                                                        <input class="file_input simpleFormUpload" name="<?php echo $values['keyname']; ?>" accept="image/*" type="file" <?php echo $values['required']; ?> />

                                                        <div style="position: relative;">
                                                            <a class="fancyWrapper" id="<?php echo $values['keyname'] . 'Link'; ?>" href="" data-base64="" data-fancybox="gallery" data-caption="Lead back Picture" style="display: none">
                                                                <img class="fancyImg" id="<?php echo $values['keyname']; ?>" alt="" />
                                                            </a>

                                                            <button id="<?php echo $values['keyname'] . 'Button'; ?>" type="button" class="close" aria-label="Close" style="display: none">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <?php } else {
                                                    if ($values['inputType'] == 'signature') { ?>
                                                        <div id="signature"></div>
                                                        <div id="clear" class="formMainBtn">Clear</div>
                                <?php }
                                                }
                                            }
                                        }
                                    }
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="buttonContainer">
                <div id="prevBtn" class="formSecondaryBtn">
                    <?= _l('prev_btn'); ?>
                </div>

                <div id="nextBtn" class="formSecondaryBtn">
                    <?= _l('next_btn'); ?>
                </div>

                <button id="formSaveBtn" class="formMainBtn" type="submit">
                    <?= _l('patient_save'); ?>
                </button>
            </div>
        </div>
    </div>

    <?php echo form_close(); ?>

    <script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?= base_url(); ?>assets/plugins/jSignature/flashcanvas.js"></script>
    <script src="<?= base_url(); ?>assets/plugins/jSignature/jSignature.min.js"></script>
    <script src="<?= base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>

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

        $(document).ready(function() {
            var elements = $('body').find(allElemntsQuery);
            var currentTab = $(currentTabQuery).attr('href');

            /*
                check input elements on tab click 
            */
            $('.selectorContainer .tab a').click(function() {
                elements = $('body').find(allElemntsQuery);

                if (validate(elements)) {
                    if ($('.selectorContainer .tab').hasClass('tabDisable')) {
                        $('.selectorContainer .tab').removeClass('tabDisable');
                    }

                    $('.inputContainer').hide();
                    $(currentTabQuery).removeClass('active');
                    $(this).addClass('active');

                    var panel = $(this).attr('href');
                    $('.inputContainer').removeClass('active-panel');
                    $(panel).addClass('active-panel');
                    $(panel).fadeIn(1000);
                    showBtn();
                } else {
                    $('.selectorContainer .tab').addClass('tabDisable');
                }

                return false; // prevents link action
            }); // end click 

            /* $('.selectorContainer .tab:first a').click(); */
            $('.inputContainer').hide();
            $(currentTabQuery).removeClass('active');
            $('.selectorContainer .tab:first a').addClass('active');
            var panel1 = $('.selectorContainer .tab:first a').attr('href');
            $(panel1).addClass('active-panel');
            $(panel1).fadeIn(1000);

            showBtn();

            /* 
                initialize jsignature 
            */
            $(document).ready(function() {
                $("#signature").jSignature({
                    width: 235,
                    height: 150
                })
            });

            $('#clear').click(function() {
                $('#signature').jSignature("reset");
            });
        }); // end ready

        /* 
            prev button event
        */
        $('#prevBtn').click(function() {
            elements = $('body').find(allElemntsQuery);
            var prev = $(currentTabQuery).parent().prev('.tab');

            if (prev.length && validate(elements)) {
                if ($('.selectorContainer .tab').hasClass('tabDisable')) {
                    $('.selectorContainer .tab').removeClass('tabDisable');
                }

                prev.find('a').trigger('click');
            } else {
                $('.selectorContainer .tab').addClass('tabDisable');
            }
        });

        /* 
            prev button event 
        */
        $('#nextBtn').click(function() {
            elements = $('body').find(allElemntsQuery);
            var next = $(currentTabQuery).parent().next('.tab');

            if (next.length && validate(elements)) {
                next.find('a').trigger('click');
            } else {
                $('.selectorContainer .tab').addClass('tabDisable');
            }
        });

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
                $(this).parent().parent().children('.falseInputLabel').text('<?= _l('drag_drop'); ?>');
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
        $("body").on('submit', '#patientForm', function() {
            var data = new FormData($(this)[0]);

            const datapair = $("#signature").jSignature("getData", "svgbase64");
            data.append('pfirm_pic', datapair[1]);

            $.ajax({
                type: "POST",
                url: "<?php echo ($leadid != '') ? base_url('clinicHistory') . '/index/' . $leadid : base_url('clinicHistory'); ?>",
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
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);

                }
            });

            return false;
        });

        function validate(elements) {
            var valid = true;

            var validator = $('form.newPatitentForm').validate();

            elements.each(function() {
                if (!validator.element(this) && valid) {
                    valid = false;
                }
            });

            return valid;
        }

        function showBtn() {
            var currentTab = $(currentTabQuery).attr("href").match(/\d+/)[0];
            var tabsLenght = $('.selectorContainer .tab').length;

            if (+currentTab === tabsLenght) {
                $('#formSaveBtn').fadeIn(500);
            } else {
                $('#formSaveBtn').fadeOut(500);
            }
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
</body>

</html>