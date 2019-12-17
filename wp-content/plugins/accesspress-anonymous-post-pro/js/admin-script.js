(function ($) {
    $(function () {
        //All the backend js for the plugin

        /*
         Settings Tabs Switching
         */
        $('.ap-tabs-trigger').click(function () {
            $('.ap-tabs-trigger').removeClass('ap-active-tab');
            $(this).addClass('ap-active-tab');
            var board_id = 'board-' + $(this).attr('id');
            $('.ap-tabs-board').hide();
            $('#' + board_id).show();
            if (board_id == 'board-form-settings')
            {
                $('.ap-pro-custom-field-adder').show();
            } else
            {
                $('.ap-pro-custom-field-adder').hide();
            }
        });

        //Get all the terms from a taxonomy of the respective post type
        $('.ap-settings-form select[name="post_type"]').change(function () {
            var post_type = $(this).val();
            $('.ap-pro-form-taxonomies').remove();
            $('select[name="post_category"] optgroup').remove();
            $.ajax({
                type: 'post',
                url: ap_ajax_url,
                data: 'action=get_terms_by_post_type&post_type=' + post_type,
                success: function (res)
                {
                    res = $.parseJSON(res);

                    if (Object.getOwnPropertyNames(res).length != 0)
                    {

                        $('select[name="post_category"]').html(res.options);
                        var taxonomies = res.taxonomy;
                        var taxonomies_label = res.taxonomy_label;
                        var taxonomy_hierarchical = res.taxonomy_hierarchical;
                        var i;
                        var taxonomy_html = '';
                        var taxonomy_label_html = '';
                        var taxonomy_required_html = '';
                        var taxonomy_reference = taxonomies.join(',')
                        var taxonomy_texts = ap_pro_notes_obj.taxonomy_texts;
                        for (i = 0; i < taxonomies.length; i++)
                        {

                            taxonomy_html = taxonomy_html + '<li class="ap-pro-form-taxonomies ap-pro-li-sortable">' +
                                    '<div class="dragicon"></div><div class="ap-pro-labels-head">' + taxonomies_label[i] + '<span class="ap-arrow-down ap-arrow">Down</span></div>' +
                                    '<div class="ap-pro-labels-content" style="display: none;">' +
                                    '<ul class="ap-pro-inner-configs">' +
                                    '<li>' +
                                    '<label>' + ap_show_form + '</label>' +
                                    '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[' + taxonomies[i] + '][show_form]" value="1"/></div>' +
                                    '</li>' +
                                    '<li>' +
                                    '<label>' + ap_custom_required + '</label>' +
                                    '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[' + taxonomies[i] + '][required]" value="1"/></div>' +
                                    '</li>' +
                                    '<li>' +
                                    '<label>' + ap_custom_required_message + '</label>' +
                                    '<div class="ap-pro-textbox"><input type="text" name="form_fields[' + taxonomies[i] + '][required_message]" value=""/></div>' +
                                    '</li>' +
                                    '<li>' +
                                    '<label>' + ap_custom_label + '</label>' +
                                    '<div class="ap-pro-textbox"><input type="text" name="form_fields[' + taxonomies[i] + '][label]" value="' + taxonomies_label[i] + '"/></div>' +
                                    '</li>' +
                                    '<li>';


                            taxonomy_html += '<li>' +
                                    '<label>Show field as:</label>' +
                                    '<div class="ap-pro-select">' +
                                    '<select name="form_fields[' + taxonomies[i] + '][taxonomy_field_type]" class="ap-taxonomy-field-type">';

                            if (taxonomy_hierarchical[i] == 0)
                            {
                                taxonomy_html += '<option value="textfield">Textfield</option>';
                            }
                            taxonomy_html += '<option value="dropdown" selected="selected">Dropdown</option>\n\
                                              <option value="checkbox">Checkbox</option>' +
                                    '</select>' +
                                    '<div class="ap-option-note ap-option-width">' +
                                    '<p>' + taxonomy_texts.textfield_note + '</p>' +
                                    '<p>' + taxonomy_texts.checkbox_note + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</li>';
                            taxonomy_html += '<li class="ap-taxonomy-autocomplete" style="display:none">' +
                                    '<label>' + taxonomy_texts.auto_complete_label + '</label>' +
                                    '<div class="ap-pro-checkbox">' +
                                    '<input type="checkbox" name="form_fields[' + taxonomies[i] + '][auto_complete]" value="1">' +
                                    '<div class="ap-option-note ap-option-width">' + taxonomy_texts.auto_complete_note + '</div>' +
                                    '</div>' +
                                    '</li>';
                            taxonomy_html += '<li class="ap-taxonomy-multiple">' +
                                    '<label>' + taxonomy_texts.multiple_select_label + '</label>' +
                                    '<div class="ap-pro-checkbox">' +
                                    '<input type="checkbox" name="form_fields[' + taxonomies[i] + '][multiple_select]" value="1">' +
                                    '<div class="ap-option-note ap-option-width">' + taxonomy_texts.multiple_select_note + '</div>' +
                                    '</div>' +
                                    '</li>';
                            taxonomy_html += '<li class="ap-taxonomy-multiple">' +
                                    '<label>' + taxonomy_texts.dropdown_label + '</label>' +
                                    '<div class="ap-pro-checkbox">' +
                                    '<input type="text" name="form_fields[' + taxonomies[i] + '][first_option_label]"/>' +
                                    '<div class="ap-option-note ap-option-width">' + taxonomy_texts.dropdown_note + '</div>' +
                                    '</div>' +
                                    '</li>';
                            taxonomy_html += '<li>' +
                                    '<label>' + taxonomy_texts.exclude_category_label + '</label>' +
                                    '<div class="ap-pro-textbox">' +
                                    '<input type="text" name="form_fields[' + taxonomies[i] + '][exclude_terms]" />' +
                                    '<div class="ap-option-note ap-option-width">' + taxonomy_texts.exclude_category_label +
                                    '</div>' +
                                    '</div>' +
                                    '</li>';
                            taxonomy_html += '<label>' + ap_field_notes + '</label>' +
                                    '<div class="ap-pro-select">' +
                                    ' <select name="form_fields[' + taxonomies[i] + '][notes_type]">' +
                                    ' <option value="0">' + ap_pro_notes_obj.dont_show + '</option>' +
                                    '<option value="icon">' + ap_pro_notes_obj.icon + '</option>' +
                                    '<option value="tooltip">' + ap_pro_notes_obj.tooltip + '</option>' +
                                    ' </select>' +
                                    '</div>' +
                                    '</li>' +
                                    '<li>' +
                                    '<label>' + ap_field_notes_textfield + '</label>' +
                                    '<div class="ap-pro-textbox"><input type="text" name="form_fields[' + taxonomies[i] + '][notes]" value=""/></div>' +
                                    '<div class="ap-pro-notes">' + ap_field_notes_text + '</div>' +
                                    '</li>' +
                                    '</ul>' +
                                    '<input type="hidden" name="form_included_taxonomy[]" value="' + taxonomies[i] + '"/>' +
                                    '<input type="hidden" name="form_fields[' + taxonomies[i] + '][hierarchical]" value="' + taxonomy_hierarchical[i] + '"/>' +
                                    '<input type="hidden" name="form_field_order[]" value="' + taxonomies[i] + '|taxononmy"/>' +
                                    '<input type="hidden" name="form_fields[' + taxonomies[i] + '][field_type]" value="taxonomy"/>' +
                                    '<input type="hidden" name="form_fields[' + taxonomies[i] + '][taxonomy_label]" value="' + taxonomies_label[i] + '"/>' +
                                    '</div>' +
                                    '</li>';
                            //taxonomy_html = taxonomy_html+'<div class="ap-each-config-wrapper"><div class="ap-fields-label"><div class="ap-checkbox-form"><input type="checkbox" name="form_included_taxonomy[]" value="'+taxonomies[i]+'"/></div><span>'+taxonomies_label[i]+'</span>';
                            //taxonomy_required_html = taxonomy_required_html+'<div class="ap-checkbox-form"><input type="checkbox" name="form_required_fields[]" value="'+taxonomies[i]+'"/></div><span>'+taxonomies_label[i]+'</span>';
                            //taxonomy_label_html = taxonomy_label_html+'<div class="ap-option-wrapper"><label>'+taxonomies_label[i]+'</label><div class="ap-option-field"><input type="text" name="'+taxonomies[i]+'_label"/><div class="ap-option-note ap-option-width">This field will only show up in frontend if you have checked the taxonomy in included fields.</div></div></div>';
                        }
                        //$('.ap-taxonomy-required').html(taxonomy_required_html);
                        //console.log(taxonomy_html);
                        $('.ap-pro-fields').append(taxonomy_html);
                        //$('.ap-form-taxonomies-wrapper').html(taxonomy_html);
                        //$('.post-taxonomy-wrapper').html(taxonomy_label_html);
                        $('input[name="taxonomy_reference"]').val(taxonomy_reference);
                    } else
                    {

                    }




                }
            });//ajax complete
        });//change function complete

        //Captcha selection
        $('.ap-captcha-selector').click(function () {
            var captcha_type = $(this).val();
            $('.captcha-fields').hide();
            $('.ap-' + captcha_type + '-captcha-fields').show();
        });//captcha selection ends

        //admin email addition
        $('#ap-admin-email-add-trigger').click(function () {
            var email_counter = $('#ap-admin-email-counter').val();
            if (email_counter < 3)
            {
                email_counter++;
                var email_field_html = '<div class="ap-each-admin-email"><input type="text" name="admin_email_list[]" placeholder="' + ap_admin_list_placeholder + '" data-email-count="' + email_counter + '"/><span class="ap-remove-email-btn">X</span></div>';
                $('.ap-admin-email-list').append(email_field_html);
                $('input[data-email-count="' + email_counter + '"]').focus();
                $('#ap-admin-email-counter').val(email_counter);
            } else
            {
                $('.ap-admin-email-add-btn').hide();
            }
        });

        //removing admin email field
        $('.ap-admin-email-list').on('click', '.ap-remove-email-btn', function () {
            var email_counter = $('#ap-admin-email-counter').val();
            email_counter--;
            $('#ap-admin-email-counter').val(email_counter);
            if (email_counter < 3)
            {
                $('.ap-admin-email-add-btn').show();
            }
            $(this).parent().remove();
        });

        //initializing color picker
        $('.ap-color-field').wpColorPicker();

        //For uploading form background image
        jQuery('#ap-background-upload-button').click(function () {
            formfield = jQuery('#ap-background-image').attr('name');
            tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            return false;
        });
        window.send_to_editor = function (html) {
            imgurl = jQuery('img', html).attr('src');
            jQuery('#ap-background-image').val(imgurl);
            tb_remove();
        }

        //Form settings options show hide
        $('body').on('click', '.ap-pro-labels-head', function () {
            if ($(this).parent().find('.ap-arrow').hasClass('ap-arrow-down'))
            {
                $(this).parent().find('.ap-arrow').removeClass('ap-arrow-down').addClass('ap-arrow-up');
            } else
            {
                $(this).parent().find('.ap-arrow').removeClass('ap-arrow-up').addClass('ap-arrow-down');
            }
            $(this).parent().find('.ap-pro-labels-content').slideToggle(500);

        });
        //sortable form fields
        $('.ap-pro-fields').sortable({containment: "parent"});

        $('#ap-custom-field-submit').click(function () {
            var error_flag = 0;
            var label = $('#ap-custom-field-label').val();
            var key = $('#ap-custom-field-key').val();
            if (label == '')
            {
                $('#ap-custom-field-label').next('.ap-custom-error').html(ap_form_required_message);
                error_flag = 1;
            }
            if (key == '')
            {
                error_flag = 1;
                $('#ap-custom-field-key').next('.ap-custom-error').html(ap_form_required_message);
            }
            if (error_flag == 0)
            {
                var append_li = '<li class="ap-pro-li-sortable">' +
                        '<div class="dragicon"></div><div class="ap-pro-labels-head">' + label + '<span class="ap-arrow-down ap-arrow">Down</span><span class="ap-custom-li-delete">Delete</span></div>' +
                        '<div class="ap-pro-labels-content" style="display: none;">' +
                        ' <ul class="ap-pro-inner-configs">' +
                        ' <li>' +
                        ' <label>' + ap_show_form + '</label>' +
                        '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[' + key + '][show_form]" value="1" checked="checked"/></div>' +
                        '</li>' +
                        '<li>' +
                        ' <label>' + ap_custom_required + '</label>' +
                        '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[' + key + '][required]" value="1"/></div>' +
                        '</li>' +
                        '<li>' +
                        ' <label>' + ap_custom_required_message + '</label>' +
                        '<div class="ap-pro-textbox"><input type="text" name="form_fields[' + key + '][required_message]"/></div>' +
                        '</li>' +
                        '<li>' +
                        ' <label>' + ap_custom_label + '</label>' +
                        '<div class="ap-pro-textbox"><input type="text" name="form_fields[' + key + '][label]" value="' + label + '"/></div>' +
                        '</li>' +
                        '<li>' +
                        '<label>' + ap_custom_textbox_type + '</label>' +
                        '<div class="ap-pro-select">' +
                        '<select name="form_fields[' + key + '][textbox_type]" class="ap-pro-custom-field-type" data-key="' + key + '">' +
                        ' <option value="textfield">Text Field</option>' +
                        ' <option value="textarea">Text Area</option>' +
                        '<option value="datepicker">Date Picker</option>' +
                        '<option value="file_uploader">File Uploader</option>' +
                        '<option value="radio_button">Radio Button</option>' +
                        '<option value="checkbox">Checkbox</option>' +
                        '<option value="select">Select-option</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="ap-pro-option-value" style="display:none"><input type="button" class="button button-primary ap-add-option" value="Add Option" data-key="' + key + '"/><div class="ap-pro-option-wrap"></div></div>' +
                        '<div class="ap-pro-display-ref" style="display:none">\n\
                            <label>Display Type</label>\n\
                            <div class="ap-pro-select">\n\
                                <select name="form_fields[' + key + '][display_type]">\n\
                                    <option value="single">Show on single line </option>\n\
                                    <option value="multiple">Show on multiple line </option>\n\
                                </select>\n\
                            </div>\n\
                        </div>' +
                        '<div class="ap-pro-file-extensions" style="display:none"></div>' +
                        '<div class="ap-date-format" style="display:none;">' +
                        '<label>Date Format</label>' +
                        '<div class="ap-pro-select">' +
                        '<select name="form_fields[' + key + '][date_format]">' +
                        '<option value="yy-mm-dd" >ISO 8601 - yy-mm-dd</option>' +
                        '<option value="mm/dd/yy" >Default - mm/dd/yy</option>' +
                        '<option value="d M, y" >Short - d M, y</option>' +
                        '<option value="d MM, y" >Medium - d MM, y</option>' +
                        '<option value="DD, d MM, yy" >Full - DD, d MM, yy</option>' +
                        '<option value="\'day\' d \'of\' MM \'in the year\' yy" >With text - \'day\' d \'of\' MM \'in the year\' yy</option>' +
                        '</select>' +
                        '</div>' +
                        '</div>' +
                        '</li>' +
                        '<li class="ap-multiple-select" style="display:none">' +
                        '<label>Multiple Select</label>' +
                        '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[' + key + '][multiple_select]" value="1"/></div>' +
                        '<div class="ap-pro-notes">' + ap_pro_notes_obj.multiple_select + '</div>' +
                        '</li>' +
                        '<li>' +
                        '<label>' + ap_field_notes + '</label>' +
                        '<div class="ap-pro-select">' +
                        '<select name="form_fields[' + key + '][notes_type]" data-key="' + key + '">' +
                        '<option value="0">' + ap_pro_notes_obj.dont_show + '</option>' +
                        '<option value="icon">' + ap_pro_notes_obj.icon + '</option>' +
                        '<option value="tooltip">' + ap_pro_notes_obj.tooltip + '</option>' +
                        '</select>' +
                        '</div>' +
                        '</li>' +
                        '<li>' +
                        ' <label>' + ap_field_notes_textfield + '</label>' +
                        '<div class="ap-pro-textbox">' +
                        '<input type="text" name="form_fields[' + key + '][notes]"/>' +
                        '<div class="ap-option-note ap-option-width">' + ap_field_notes_text + '</div>' +
                        '</div>' +
                        '</li>' +
                        '<li>' +
                        '<li>' +
                        ' <label>' + ap_pro_notes_obj.field_class_label + '</label>' +
                        '<div class="ap-pro-textbox">' +
                        '<input type="text" name="form_fields[' + key + '][field_class]"/>' +
                        '</div>' +
                        '</li>' +
                        '<li>' +
                        '<label>' + ap_pro_notes_obj.frontend_show + '</label>' +
                        '<div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[' + key + '][frontend_show]" value="1" class="ap-frontend-show-checkbox"/>' +
                        '<div class="ap-option-note">' + ap_pro_notes_obj.frontend_show_note + '</div>' +
                        '</div>' +
                        '<div class="ap-frontend-display-reference" style="display: none;">' +
                        '<ul>' +
                        '<li>' +
                        '<label>' + ap_pro_notes_obj.frontend_label + '</label>' +
                        '<div class="ap-pro-checkbox">' +
                        '<input type="text" name="form_fields[' + key + '][frontend_show_label]"/>' +
                        '<div class="ap-pro-notes ap-option-width">' + ap_pro_notes_obj.frontend_show_label_note + '</div>' +
                        '</div>' +
                        '</li>' +
                        '<li class="ap-pro-file-reference" style="display: none;">' +
                        '<label>' + ap_pro_notes_obj.link_label + '</label>' +
                        '<div class="ap-pro-checkbox">' +
                        '<input type="checkbox" name="form_fields[' + key + '][show_link]" value="1" />' +
                        '<div class="ap-option-note">' + ap_pro_notes_obj.link_note + '</div>' +
                        '</div>' +
                        '</li>' +
                        '<li class="ap-pro-file-reference" style="display: none;">' +
                        '<label>' + ap_pro_notes_obj.image_label + '</label>' +
                        '<div class="ap-pro-textbox ap-half-textbox">' +
                        '<input type="text" name="form_fields[' + key + '][image_width]" placeholder="eg. 100px"/>' +
                        '<input type="text" name="form_fields[' + key + '][image_height]"  placeholder="eg. 100px"/>' +
                        '<div class="ap-option-note ap-option-width">' + ap_pro_notes_obj.image_note + '</div>' +
                        '</div>' +
                        '</li>' +
                        '<li class="ap-pro-file-reference" style="display: none;">' +
                        '<label>' + ap_pro_notes_obj.lightbox_label + '</label>' +
                        '<div class="ap-pro-checkbox">' +
                        '<input type="checkbox" name="form_fields[' + key + '][lightbox]" value="1"/>' +
                        '<div class="ap-option-note">' + ap_pro_notes_obj.lightbox_msg + '</div>' +
                        '<div class="ap-option-note ap-option-width">' + ap_pro_notes_obj.lightbox_note + '</div>' +
                        '</div>' +
                        '</li>' +
                        '</ul>' +
                        '</div>' +
                        '</li>' +
                        '</ul>' +
                        '<input type="hidden" name="form_field_order[]" value="' + key + '|custom"/>' +
                        '<input type="hidden" name="form_fields[' + key + '][field_type]" value="custom"/>' +
                        '<input type="hidden" name="form_fields[' + key + '][custom_label]" value="' + label + '"/>' +
                        '</div>' +
                        '</li>';
                $('.ap-pro-fields').append(append_li);
                $('#ap-custom-field-label').val('');
                $('#ap-custom-field-key').val('');
            }
        });

        $('body').on('click', '.ap-custom-li-delete', function () {
            if (confirm('Are you sure you want to delete this field?'))
            {
                var selector = $(this).closest('.ap-pro-li-sortable');
                $(this).closest('.ap-pro-li-sortable').fadeOut(500, function () {
                    selector.remove();
                });
            }
            return false;

        });

        $('.ap-login-type').click(function () {
            if ($(this).val() == 'login_message')
            {
                $('.ap-login-type-wrapper').show();
                $('.ap-login-form-wrapper').hide();
            } else
            {
                $('.ap-login-form-wrapper').show();
                $('.ap-login-type-wrapper').hide();
            }
        });
        //Google Font selecting
        if ($('#ap-label-font').length > 0)
        {
            var label_font = $('#ap-label-font').val();
            $('.form-style-label-font option[value="' + label_font + '"]').attr('selected', 'selected');
            var button_font = $('#ap-form-button-font').val();
            $('.form-styles-button-font option[value="' + button_font + '"]').attr('selected', 'selected');
            $("#ap-label-font-style").html('.ap-label-font-text { font-size: 16px; font-family: "' + label_font + '" !important; }');
            $("#ap-button-font-style").html('.ap-button-font-text { font-size: 16px; font-family: "' + button_font + '" !important; }');
            WebFont.load({
                google: {
                    families: [label_font, button_font]
                }
            });
        }


        //google font switching
        $('.form-style-label-font,.form-styles-button-font').change(function () {
            var label_font = $('.form-style-label-font').val();
            var button_font = $('.form-styles-button-font').val();
            $("#ap-label-font-style").html('.ap-label-font-text { font-size: 16px; font-family: "' + label_font + '" !important; }');
            $("#ap-button-font-style").html('.ap-button-font-text { font-size: 16px; font-family: "' + button_font + '" !important; }');
            WebFont.load({
                google: {
                    families: [label_font, button_font]
                }
            });
        });
        $('select[name="plugin_style_type"]').change(function () {
            if ($(this).val() == 'template')
            {
                $('.template-selector,.ap-template-preview-wrapper').show();
                $('.ap-form-styler-wrapper').hide();
            } else
            {
                $('.template-selector,.ap-template-preview-wrapper').hide();
                $('.ap-form-styler-wrapper').show();
            }
        });

        $('select[name="form_template"]').change(function () {
            var template = $(this).val();
            $('.ap-template-image-wrapper').hide();
            $('.' + template + '-preview').show();
        });
        $('body').on('change', '.ap-pro-custom-field-type', function () {
            var field_type = $(this).val();
            var key = $(this).attr('data-key');
            switch (field_type) {
                case 'file_uploader':
                    $('.ap-extensions-clone input[type="checkbox"]').attr('name', 'form_fields[' + key + '][file_extension][]');
                    $('.ap-extensions-clone .ap-pro-upload-button-label').attr('name', 'form_fields[' + key + '][button_label]');
                    $('.ap-extensions-clone .ap-pro-file-upload-size').attr('name', 'form_fields[' + key + '][upload_size]');
                    $('.ap-extensions-clone .ap-pro-multiple-file-upload').attr('name', 'form_fields[' + key + '][multiple_upload]');
                    $('.ap-extensions-clone .ap-pro-file-upload-limit').attr('name', 'form_fields[' + key + '][upload_limit]');
                    $('.ap-extensions-clone .ap-pro-file-upload-limit-message').attr('name', 'form_fields[' + key + '][upload_limit_message]');
                    $('.ap-extensions-clone .ap-pro-attach-media').attr('name', 'form_fields[' + key + '][attach_media]');
                    $('.ap-extensions-clone .ap-pro-custom-extensions').attr('name', 'form_fields[' + key + '][custom_extensions]');
                    $('.ap-extensions-clone .ap-pro-custom-folder').attr('name', 'form_fields[' + key + '][custom_folder]');
                    var append_html = $('.ap-extensions-clone').html();
                    $(this).closest('li').find('.ap-pro-file-extensions').show().append(append_html);
                    $(this).closest('li').find('.ap-pro-option-wrap').html('');
                    $(this).closest('li').find('.ap-pro-option-value').hide();
                    $(this).closest('.ap-pro-inner-configs').find('.ap-multiple-select').hide();
                    $(this).closest('li').find('.ap-date-format').hide();
                    $(this).closest('.ap-pro-inner-configs').find('.ap-pro-file-reference').show();
                    $(this).closest('li').find('.ap-pro-display-ref').hide();
                    break;
                case 'radio_button':
                    $(this).closest('.ap-pro-inner-configs').find('.ap-multiple-select').hide();
                    $(this).closest('li').find('.ap-pro-file-extensions').hide().html('');
                    $(this).closest('li').find('.ap-pro-option-value').show();
                    $(this).closest('li').find('.ap-pro-display-ref').show();
                    $(this).closest('.ap-pro-inner-configs').find('.ap-pro-file-reference').hide();
                    $(this).closest('li').find('.ap-date-format').hide();
                    $(this).closest('li').find('.ap-pro-option-wrap').html('');
                    break;
                case 'checkbox':
                    $(this).closest('.ap-pro-inner-configs').find('.ap-multiple-select').hide();
                    $(this).closest('li').find('.ap-pro-file-extensions').hide().html('');
                    $(this).closest('li').find('.ap-pro-option-value').show();
                    $(this).closest('li').find('.ap-pro-display-ref').show();
                    $(this).closest('.ap-pro-inner-configs').find('.ap-pro-file-reference').hide();
                    $(this).closest('li').find('.ap-date-format').hide();
                    $(this).closest('li').find('.ap-pro-option-wrap').html('');
                    break;
                case 'select':
                    $(this).closest('.ap-pro-inner-configs').find('.ap-multiple-select').show();
                    $(this).closest('li').find('.ap-pro-file-extensions').hide().html('');
                    $(this).closest('li').find('.ap-pro-option-value').show();
                    $(this).closest('.ap-pro-inner-configs').find('.ap-pro-file-reference').hide();
                    $(this).closest('li').find('.ap-date-format').hide();
                    $(this).closest('li').find('.ap-pro-option-wrap').html('');
                    $(this).closest('li').find('.ap-pro-display-ref').hide();
                    break;

                default:
                    if (field_type == 'datepicker') {
                        $(this).closest('li').find('.ap-date-format').show();
                    } else {
                        $(this).closest('li').find('.ap-date-format').hide();
                    }
                    $(this).closest('li').find('.ap-pro-display-ref').hide();
                    $(this).closest('.ap-pro-inner-configs').find('.ap-multiple-select').hide();
                    $(this).closest('li').find('.ap-pro-option-wrap').html('');
                    $(this).closest('li').find('.ap-pro-option-value').hide();
                    $(this).closest('li').find('.ap-pro-file-extensions').hide().html('');
                    $(this).closest('.ap-pro-inner-configs').find('.ap-pro-file-reference').hide();
                    break;
            }


        });

        $('body').on('click', '.ap-add-option', function () {
            var key = $(this).attr('data-key');
            var field_type = $(this).closest('li').find('.ap-pro-custom-field-type').val();
            if (field_type == 'checkbox') {
                var append_html = '<div class="ap-each-option-value"><span class="ap-drap-arrow"></span>\n\
                                <input type="text" name="form_fields[' + key + '][option][]" placeholder="option"/>\n\
                                <input type="text" name="form_fields[' + key + '][value][]" placeholder="value"/>\n\
                                <input type="checkbox" class="ap-option-checked-trigger"/>\n\
                                <input type="hidden" name="form_fields[' + key + '][checked_option][]" value="0" class="ap-option-default-checked-ref"/> Checked\n\
                                <a href="javascript:void(0)" class="ap-remove-option-value">X</a>\n\
                            </div>';
            } else if (field_type == 'radio_button') {
                var append_html = '<div class="ap-each-option-value"><span class="ap-drap-arrow"></span>\n\
                                <input type="text" name="form_fields[' + key + '][option][]" placeholder="option"/>\n\
                                <input type="text" name="form_fields[' + key + '][value][]" placeholder="value"/>\n\
                                <input type="radio" class="ap-radio-checked-trigger" name="form_fields[' + key + '][checked_radio]"/>\n\
                                <input type="hidden" name="form_fields[' + key + '][checked_option][]" value="0" class="ap-option-default-checked-ref"/> Checked\n\
                                <a href="javascript:void(0)" class="ap-remove-option-value">X</a>\n\
                            </div>';

            } else {
                var append_html = '<div class="ap-each-option-value"><span class="ap-drap-arrow"></span>\n\
                                <input type="text" name="form_fields[' + key + '][option][]" placeholder="option"/>\n\
                                <input type="text" name="form_fields[' + key + '][value][]" placeholder="value"/>\n\
                                <input type="radio" class="ap-radio-checked-trigger" name="form_fields[' + key + '][checked_radio]"/>\n\
                                <input type="hidden" name="form_fields[' + key + '][checked_option][]" value="0" class="ap-option-default-checked-ref"/> Selected\n\
                                <a href="javascript:void(0)" class="ap-remove-option-value">X</a>\n\
                            </div>';
            }
            $(this).parent().find('.ap-pro-option-wrap').append(append_html);
            $('.ap-pro-option-wrap').sortable();
        });

        $('body').on('click', '.ap-remove-option-value', function () {
            $(this).parent().remove();
        });

        $('body').on('change', '.ap-taxonomy-field-type', function () {
            if ($(this).val() == 'dropdown')
            {
                $(this).closest('.ap-pro-inner-configs').find('.ap-taxonomy-multiple').show();
                $(this).closest('.ap-pro-inner-configs').find('.ap-taxonomy-autocomplete').hide();
            } else if ($(this).val() == 'textfield') {
                $(this).closest('.ap-pro-inner-configs').find('.ap-taxonomy-multiple').hide();
                $(this).closest('.ap-pro-inner-configs').find('.ap-taxonomy-autocomplete').show();

            } else
            {
                $(this).closest('.ap-pro-inner-configs').find('.ap-taxonomy-multiple').hide();
                $(this).closest('.ap-pro-inner-configs').find('.ap-taxonomy-autocomplete').hide();

            }
        });

        $('body').on('click', '.ap-frontend-show-checkbox', function () {
            if ($(this).is(':checked'))
            {
                $(this).closest('li').find('.ap-frontend-display-reference').show();
            } else
            {
                $(this).closest('li').find('.ap-frontend-display-reference').hide();
            }
        });

        $('#ap-pro-pre-meta').change(function () {
            var meta_key = $(this).val();
            $('#ap-custom-field-key').val(meta_key);

        });

        $('select[name="google_captcha_version"]').change(function () {
            if ($(this).val() == 'v1') {
                $('.ap-recaptcha-v2-ref').hide();
                $('.ap-recaptcha-v1-ref').show();
            } else {
                $('.ap-recaptcha-v2-ref').show();
                $('.ap-recaptcha-v1-ref').hide();
            }

        });

        $('.ap-pro-option-wrap').sortable();

        $('body').on('click', '.ap-option-checked-trigger', function () {
            if ($(this).is(':checked')) {
                $(this).closest('.ap-each-option-value').find('.ap-option-default-checked-ref').val(1);
            } else {
                $(this).closest('.ap-each-option-value').find('.ap-option-default-checked-ref').val(0);

            }
        });
        $('body').on('click', '.ap-radio-checked-trigger', function () {
            $(this).closest('.ap-pro-option-wrap').find('.ap-option-default-checked-ref').val(0);
            $(this).closest('.ap-each-option-value').find('.ap-option-default-checked-ref').val(1);

        });

        $('.ap-advance-uploader-trigger').change(function () {
            if ($(this).is(':checked')) {
                $('.ap-advance-uploader-wrap').show();
            } else {
                $('.ap-advance-uploader-wrap').hide();
            }
        });


    });
}(jQuery));
