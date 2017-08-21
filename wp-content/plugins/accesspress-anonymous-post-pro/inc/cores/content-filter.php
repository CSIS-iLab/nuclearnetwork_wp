<?php

$form_id = get_post_meta(get_the_ID(), 'ap_form_id', true);
if(empty($form_id)){
    return ;
}
if (!empty($form_id)) {
    $custom_content = '<div class="ap-custom-wrapper">';
    $ap_settings = $this->get_ap_settings($form_id);
    //$content .='<pre>' . print_r($ap_settings, true) . '</pre>';
    $form_fields_order = $ap_settings['form_field_order'];
    foreach ($form_fields_order as $form_field) {
        $form_field_array = explode('|', $form_field);
        $field_name = $form_field_array[0];
        $field_type = $form_field_array[1];
        $author_details = array('author_name', 'author_url', 'author_email');
        if (in_array($field_name, $author_details)) {
            if (isset($ap_settings['form_fields'][$field_name]['frontend_show']) && $ap_settings['form_fields'][$field_name]['frontend_show'] == 1) {
                $custom_field_value = get_post_meta(get_the_ID(), 'ap_' . $field_name, true);
                if (!empty($custom_field_value)) {
                    $custom_field_label = (isset($ap_settings['form_fields'][$field_name]['frontend_show_label'])) ? $ap_settings['form_fields'][$field_name]['frontend_show_label'] : '';
                    if (isset($ap_settings['form_fields'][$field_name]['show_link']) && $ap_settings['form_fields'][$field_name]['show_link'] == '1' && $field_name == 'author_url') {
                        $custom_field_value = esc_url($custom_field_value);
                        $custom_field_value = '<a href="' . $custom_field_value . '" target="_blank">' . $custom_field_value . '</a>';
                    }
                    $custom_content .='<div class="ap-each-custom">'
                            . '<div class="ap-custom-label">' . $custom_field_label . '</div><!--ap-custom-label-->'
                            . '<div class="ap-custom-value">' . $custom_field_value . '</div><!--ap-custom-value-->'
                            . '</div><!--ap-each-custom-->';
                }
            }
        } else if ($form_field_array[1] == 'custom') {
            if (isset($ap_settings['form_fields'][$field_name]['frontend_show']) && $ap_settings['form_fields'][$field_name]['frontend_show'] == 1) {
                $custom_field_value = get_post_meta(get_the_ID(), $field_name, true);
                if (!empty($custom_field_value)) {
                    $custom_field_label = (isset($ap_settings['form_fields'][$field_name]['frontend_show_label'])) ? $ap_settings['form_fields'][$field_name]['frontend_show_label'] : '';
                    if (isset($ap_settings['form_fields'][$field_name]['textbox_type']) && $ap_settings['form_fields'][$field_name]['textbox_type'] == 'file_uploader') {
                        $custom_field_value_array = explode(',', $custom_field_value);
                        $custom_field_value = '';
                        foreach ($custom_field_value_array as $custom_field_single_value) {
                            $custom_field_url = $custom_field_single_value;
                            if($this->is_image($custom_field_url))
                            {
                                $image_height = (isset($ap_settings['form_fields'][$field_name]['image_height']))?$ap_settings['form_fields'][$field_name]['image_height']:'auto';
                                $image_width = (isset($ap_settings['form_fields'][$field_name]['image_width']))?$ap_settings['form_fields'][$field_name]['image_width']:'';
                                $custom_field_single_value = '<img src="'.$custom_field_url.'" height="'.$image_height.'" width="'.$image_width.'"/>';
                                if((isset($ap_settings['form_fields'][$field_name]['lightbox']) && $ap_settings['form_fields'][$field_name]['lightbox'] == '1') || (isset($ap_settings['form_fields'][$field_name]['show_link']) && $ap_settings['form_fields'][$field_name]['show_link'] == '1'))
                                {
                                   $lightbox = (isset($ap_settings['form_fields'][$field_name]['lightbox']) && $ap_settings['form_fields'][$field_name]['lightbox'] == '1')?'data-lightbox="ap-pro-lightbox-images"':'';
                                   $custom_field_value .= '<div class="ap-each-image" style="height:'.$image_height.';width:'.$image_width.'"><a href="'.$custom_field_url.'" '.$lightbox.' target="_blank">'.$custom_field_single_value.'</a></div>';
                                }
                                else
                                {
                                    $custom_field_value .= '<div class="ap-each-image" style="height:'.$image_height.';width:'.$image_width.'">'. $custom_field_single_value . '</div>';
                                }
                                
                            }
                            else
                            {
                                if(isset($ap_settings['form_fields'][$field_name]['show_link']) && $ap_settings['form_fields'][$field_name]['show_link'] == '1')
                                {
                                   $custom_field_value .= '<div class="ap-each-file"><a href="'.$custom_field_single_value.'" target="_blank">'.$custom_field_single_value.'</a></div>';
                                }
                                else
                                {
                                    $custom_field_value .= '<div class="ap-each-file">'. $custom_field_single_value . '</div>';
                                }
                            }
                                
                                
                                
                            }
                        
                        
                    }

                    $custom_content .='<div class="ap-each-custom">'
                            . '<div class="ap-custom-label">' . $custom_field_label . '</div><!--ap-custom-label-->'
                            . '<div class="ap-custom-value">' . $custom_field_value . '</div><!--ap-custom-value-->'
                            . '</div><!--ap-each-custom-->';
                }
            }
        }
    }
    $custom_content .='</div><!--ap-custom-wrapper-->';
    $content .=$custom_content;
}