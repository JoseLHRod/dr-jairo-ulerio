<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?= _l('email_templates'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <?php if(isset($success) && $success): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php
                                        echo '<p class="text-success">' . _l('template_add_sucess') . '</p><hr />';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php elseif(isset($success) && !$success): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php
                                        echo '<p class="text-danger">' . _l('template_add_failed') . '</p><hr />';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?= form_open($this->uri->uri_string()); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?= render_input('name', 'template_name', $template->name, 'text'); ?>
                                <?= render_input('subject[]', 'template_subject', $template->subject); ?>
                                <?= render_input('fromname', 'template_fromname', $template->fromname); ?>
                                <div style="<?= (!hooks()->apply_filters('show_deprecated_from_email_header_template_field', false)
                                                ? 'display:none;'
                                                : ''); ?>">
                                    <?php if ($template->slug != 'two-factor-authentication') : ?>
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-title="<?= _l('email_template_only_domain_email'); ?>"></i>
                                        <?= render_input('fromemail', 'template_fromemail', $template->fromemail, 'email'); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="plaintext" id="plaintext" <?= ($template->plaintext == 1) ? 'checked' : '' ?>>
                                    <label for="plaintext"><?= _l('send_as_plain_text'); ?></label>
                                </div>
                                <?php if ($template->slug != 'two-factor-authentication') : ?>
                                    <div class="checkbox checkbox-primary">
                                        <input type="checkbox" name="disabled" id="disabled" <?= ($template->active == 0) ? 'checked' : '' ?>>
                                        <label data-toggle="tooltip" title="<?= _l('disable_email_from_being_sent'); ?>" for="disabled">
                                            <?= _l('email_template_disabled'); ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="show_on_proposal" id="show_on_proposal" <?= ($template->show_on_proposal == 1) ? 'checked' : '' ?>>
                                    <label data-toggle="tooltip" title="Show in proprosals" for="show_on_proposal">Show in proprosals</label>
                                </div>
                                <hr />
                                <?php $editors = ['message[english]']; ?>
                                <h4 class="bold font-medium">English</h4>
                                <p class="bold"><?= _l('email_template_email_message'); ?></p>
                                <?= render_textarea(
                                    'message[english]',
                                    '',
                                    $template->message,
                                    array('data-url-converter-callback' => 'myCustomURLConverter', 'id' => 'english'),
                                    array(),
                                    '',
                                    'tinymce tinymce-manual'
                                ); ?>

                                <!-- Languages -->
                                <?php foreach ($available_languages as $availableLanguage) : ?>
                                    <?php array_push($editors, $availableLanguage); ?>
                                    <hr />
                                    <h4 class="font-medium pointer bold" onclick='slideToggle("#temp_<?= $availableLanguage; ?>");'>
                                        <?= ucfirst($availableLanguage); ?>
                                    </h4>
                                    <div id="temp_<?= $availableLanguage ?>" class="hide">
                                        <?= render_input(
                                            'subject['. $availableLanguage .']',
                                            'template_subject',
                                            ''
                                        ); ?>
                                        <p class="bold"><?= _l('email_template_email_message') ?></p>
                                        <?= render_textarea(
                                            'message['. $availableLanguage .']',
                                            '',
                                            '',
                                            array('data-url-converter-callback' => 'myCustomURLConverter', 'id' => $availableLanguage),
                                            array(),
                                            '',
                                            'tinymce tinymce-manual'
                                        ); ?>
                                    </div>
                                <?php endforeach; ?>
                                <!-- End languajes -->

                                <div class="btn-bottom-toolbar text-right">
                                    <button type="submit" class="btn btn-info"><?= _l('submit'); ?></button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?= _l('available_merge_fields'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="row">
                            <?php if ($template->type == 'ticket' || $template->type == 'project') : ?>
                                <div class=" col-md-12">
                                    <?php if ($template->type != 'project') : ?>
                                        <div class="alert alert-warning">
                                            <?= ($template->type == 'ticket') ? _l('email_template_ticket_warning') : _l('email_template_contact_warning') ?>
                                        </div>
                                    <?php else : ?>
                                        <?php if (
                                            $template->slug == 'new-project-discussion-comment-to-staff' ||
                                            $template->slug == 'new-project-discussion-comment-to-customer'
                                        ) : ?>
                                            <div class="alert alert-info">
                                                <?= _l('email_template_discussion_info'); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-12">
                                <div class="row available_merge_fields_container">
                                    <div class="col-md-6 merge_fields_col">
                                        <h5 class="bold"><?= ucfirst($template->type) ?></h5>
                                        <?php foreach ($available_merge_fields as $field) : ?>
                                            <?php if (count($field['available']) > 0) : ?>
                                                <p><?= $field['name'] ?> <a href="#" class="add_merge_field"><span><?= $field['key'] ?></span></a></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function() {
        <?php foreach ($editors as $id) { ?>
            init_editor('textarea[name="<?= $id; ?>"]', {
                urlconverter_callback: 'merge_field_format_url'
            });
        <?php } ?>
        $('.add_merge_field').on('click', function(e) {
            e.preventDefault();
            tinymce.activeEditor.execCommand('mceInsertContent', false, $(this).text());
        });
        appValidateForm($('form'), {
            name: 'required',
            fromname: 'required',
        });
    });
</script>
</body>

</html>