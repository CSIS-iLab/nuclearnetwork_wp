<style id="ap-label-font-style"></style>
<style id="ap-button-font-style"></style>
<div class="ap-tabs-board" id="board-formstyle-settings" style="display: none;">
 <h2><?php _e('Form Styling Settings','anonymous-post-pro');?></h2>
 
 <div class="ap-form-styling-settings-wrapper">
   <!--Option to enable/disable plugin styles in frontend-->
   <div class="ap-tab-wrapper">
     <div class="ap-option-wrapper">
      <label class="ap-check-login"><?php _e('Plugin Styles:','anonymous-post-pro');?></label>
      <div class="ap-option-field">
        <div class="ap-option-checkbox-field">
          <div class="ap-checkbox-form"><input type="checkbox" name="plugin_styles" value="1" <?php if($ap_settings['plugin_styles']=='1'){?>checked="checked"<?php }?>/></div>
          <div class="ap-option-note"><?php _e('Check if you want to use the plugin styles in frontend form','anonymous-post-pro');?></div>
          <div class="ap-option-note ap-option-width"><?php _e('<b>Note</b>: Unchecking will exclude all the plugin styles from frontend','anonymous-post-pro');?></div>
        </div>
      </div>
      
    </div><!--ap-option-wrapper-->
    <div class="ap-option-wrapper">
        <label><?php _e('Plugin Style Type :','anonymous-post-pro');?></label>
        <div class="ap-option-field">
         <select name="plugin_style_type">
            <option value="template" <?php if($ap_settings['plugin_style_type']=='template'){?>selected="selected"<?php }?>>Form Template</option>
            <option value="form-styler" <?php if($ap_settings['plugin_style_type']=='form-styler'){?>selected="selected"<?php }?>>Form Styler</option>
         </select>
        </div>
      </div>
      <div class="ap-option-wrapper template-selector" <?php if($ap_settings['plugin_style_type']!='template'){?>style="display:none"<?php }?>>
        <div class="ap-option-field">
        <label><?php _e('Built in Form Templates','anonymous-post-pro');?></label>
        <div class="ap-option-field">
          <select name="form_template">
            <option value="">Default</option>
            <option value="template1" <?php  if($ap_settings['form_template']=='template1'){?>selected="selected"<?php }?>>Template 1</option>
            <option value="template2" <?php if($ap_settings['form_template']=='template2'){?>selected="selected"<?php }?>>Template 2</option>
            <option value="template3" <?php if($ap_settings['form_template']=='template3'){?>selected="selected"<?php }?>>Template 3</option>
            <option value="template4" <?php if($ap_settings['form_template']=='template4'){?>selected="selected"<?php }?>>Template 4</option>
          </select>
          </div>
        </div>
      </div>
  </div><!--ap-tab-wrapper-->
  <!--Option to enable/disable plugin styles in frontend-->
  <div class="ap-form-styler-wrapper" <?php if($ap_settings['plugin_style_type']!='form-styler'){?>style="display: none;"<?php }?>>
  <h1>Form Styler</h1>
  <!--Label Styling Options-->
  <div class="ap-form-label-styles">
   <div class="line"></div>
   <h2><?php _e('Label Styles','anonymous-post-pro');?></h2>
   <div class="ap-tab-wrapper">
     <div class="ap-option-wrapper">
       <label><?php _e('Label Fonts','anonymous-post-pro');?></label>
       <div class="ap-option-field">
        <select name="form_styles[label][font]" class="form-style-label-font">
         <?php $this->print_google_fonts_dropdown();?>
       </select>
       <div class="ap-label-font-text">The Quick Brown Fox Jumps Over The Lazy Dog. 1234567890</div>
       <input type="hidden" id="ap-label-font" value="<?php echo $ap_settings['form_styles']['label']['font'];?>"/>
     </div>
   </div><!--ap-option-wrapper-->

   <div class="ap-option-wrapper">
     <label><?php _e('Label Font Size','anonymous-post-pro');?></label>
     <div class="ap-option-field">
       <select name="form_styles[label][font_size]">
         <option value="">Choose Font Size</option>
         <?php 
         for($i=12;$i<=30;$i=$i+2)
         {
          ?>
          <option value="<?php echo $i;?>" <?php if($ap_settings['form_styles']['label']['font_size']==$i){?>selected="selected"<?php }?>><?php echo $i;?></option>
          <?php 
        }
        ?>
      </select>
    </div>
  </div><!--ap-option-wrapper-->

  <div class="ap-option-wrapper">
   <label><?php _e('Label Color','anonymous-post-pro');?></label>
   <div class="ap-option-field">
     <input type="text" name="form_styles[label][label_color]" class="ap-color-field" value="<?php echo esc_attr($ap_settings['form_styles']['label']['label_color']);?>"/>
   </div>
 </div>

</div><!--ap-form-label-styles-->
</div><!--Label Styling Options-->


<!--Form Field Styling Options-->
<div class="ap-form-label-styles">
 <div class="line"></div>
 <h2><?php _e('Form Field Styles','anonymous-post-pro');?></h2>

 <div class="ap-tab-wrapper">
   <div class="ap-option-wrapper">
     <label><?php _e('Field Color','anonymous-post-pro');?></label>
     <div class="ap-option-field">
       <input type="text" name="form_styles[field][color]" class="ap-color-field" value="<?php echo esc_attr($ap_settings['form_styles']['field']['color']);?>"/>
     </div>
   </div><!--ap-option-wrapper-->

   <div class="ap-option-wrapper">
     <label><?php _e('Field Border Thickness','anonymous-post-pro');?></label>
     <div class="ap-option-field">
       <input type="number" name="form_styles[field][border_thickness]" value="<?php echo esc_attr($ap_settings['form_styles']['field']['border_thickness']);?>"/>
     </div>
   </div><!--ap-option-wrapper-->

   <div class="ap-option-wrapper">
     <label><?php _e('Field Border Color','anonymous-post-pro')?></label>
     <div class="ap-option-field">
       <input type="text" name="form_styles[field][border_color]" class="ap-color-field" value="<?php echo esc_attr($ap_settings['form_styles']['field']['border_color']);?>"/>
     </div>
   </div>
 </div><!--ap-tab-wrapper-->
</div><!--ap-form-label-styles-->
<!--Form Field Styling Options-->


<!--Form Button Styling Option-->
<div class="ap-form-button-styles">
 <div class="line"></div>
 <h2><?php _e('Form Button Styles','anonymous-post-pro');?></h2>
 <div class="ap-tab-wrapper">
   <div class="ap-option-wrapper">
     <label><?php _e('Button Text Font','anonymous-post-pro');?></label>
     <div class="ap-option-field">
       <select name="form_styles[button][font]" class="form-styles-button-font">
         <?php $this->print_google_fonts_dropdown();?>
       </select>
       <div class="ap-button-font-text">The Quick Brown Fox Jumps Over The Lazy Dog. 1234567890</div>
       <input type="hidden" value="<?php echo esc_attr($ap_settings['form_styles']['button']['font']);?>" id="ap-form-button-font"/>
     </div>
   </div>

   <div class="ap-option-wrapper">
     <label><?php _e('Button Font Size','anonymous-post-pro');?></label>
     <div class="ap-option-field">
       <select name="form_styles[button][font_size]">
        <option value="">Choose font size</option>
        <?php for($i=12;$i<=30;$i=$i+2)
        {

          ?>
          <option value="<?php echo $i;?>" <?php if($ap_settings['form_styles']['button']['font_size']==$i){?>selected="selected"<?php }?>><?php echo $i;?></option>
          <?php 
        }
       
        ?>
      </select>
    </div>
  </div>

  <div class="ap-option-wrapper">
   <label><?php _e('Button Font Color','anonymous-post-pro')?></label>
   <div class="ap-option-field">
     <input type="text" name="form_styles[button][font_color]" class="ap-color-field" value="<?php echo esc_attr($ap_settings['form_styles']['button']['font_color']);?>"/>
   </div>
 </div>

 <div class="ap-option-wrapper">
   <label><?php _e('Button Background Color','anonymous-post-pro');?></label>
   <div class="ap-option-field">
     <input type="text" name="form_styles[button][button_background]" class="ap-color-field" value="<?php echo esc_attr($ap_settings['form_styles']['button']['button_background']);;?>"/>
   </div>
 </div>
</div><!--ap-tab-wrapper-->
</div><!--ap-form-button-styles-->
<!--Form Button Styling Option-->


<!--Form Styling Options-->
<div class="ap-form-styles">
  <div class="line"></div>
  <h2><?php _e('Form Styles','anonymous-post-pro');?></h2>
  <div class="ap-tab-wrapper">
  <div class="ap-option-wrapper">
    <label><?php _e('Form Width','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <input type="text" name="form_styles[form][width]" value="<?php echo esc_attr($ap_settings['form_styles']['form']['width']);?>"/>
      <div class="width-type">
        <div class="ap-radio-field"><input type="radio" name="form_styles[form][width_type]" value="px" <?php if(isset($ap_settings['form_styles']['form']['width_type']) && $ap_settings['form_styles']['form']['width_type']=='px'){?>checked="checked"<?php }?>/><span>Pixels</span></div>
        <div class="ap-radio-field"><input type="radio" name="form_styles[form][width_type]" value="per" <?php if(isset($ap_settings['form_styles']['form']['width_type']) && $ap_settings['form_styles']['form']['width_type']=='per'){?>checked="checked"<?php }?>/><span>Percentage</span></div>
      </div>
    </div>
  </div>

  <div class="ap-option-wrapper">
    <label><?php _e('Show Form Border','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <div class="ap-radio-field"><input type="radio" name="form_styles[form][border]" value="yes" <?php if(isset($ap_settings['form_styles']['form']['border']) && $ap_settings['form_styles']['form']['border']=='yes'){?>checked="checked"<?php }?>/><span>Yes</span></div>
      <div class="ap-radio-field"><input type="radio" name="form_styles[form][border]" value="no" <?php if(isset($ap_settings['form_styles']['form']['border']) && $ap_settings['form_styles']['form']['border']=='no'){?>checked="checked"<?php }?>/><span>No</span></div>
    </div>
  </div>
   <div class="ap-option-wrapper">
     <label><?php _e('Form Border Color','anonymous-post-pro')?></label>
     <div class="ap-option-field">
       <input type="text" name="form_styles[form][border_color]" class="ap-color-field" value="<?php  if(isset($ap_settings['form_styles']['form']['border_color'])){echo esc_attr($ap_settings['form_styles']['form']['border_color']);}?>"/>
     </div>
   </div>
   
  <div class="ap-option-wrapper">
     <label><?php _e('Form Border Thickness','anonymous-post-pro');?></label>
     <div class="ap-option-field">
       <input type="number" name="form_styles[form][border_thickness]" value="<?php if(isset($ap_settings['form_styles']['form']['border_thickness'])){echo esc_attr($ap_settings['form_styles']['form']['border_thickness']);}?>"/>
     </div>
   </div><!--ap-option-wrapper-->

  

  <div class="ap-option-wrapper">
    <label><?php _e('Show Round Corners','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <div class="ap-radio-field"><input type="radio" name="form_styles[form][round_corners]" value="yes" <?php if(isset($ap_settings['form_styles']['form']['round_corners']) && $ap_settings['form_styles']['form']['round_corners']=='yes'){?>checked="checked"<?php }?>/><span>Yes</span></div>
      <div class="ap-radio-field"><input type="radio" name="form_styles[form][round_corners]" value="no" <?php if(isset($ap_settings['form_styles']['form']['round_corners']) && $ap_settings['form_styles']['form']['round_corners']=='no'){?>checked="checked"<?php }?>/><span>No</span></div>
    </div>
  </div>

  <div class="ap-option-wrapper">
    <label><?php _e('Form Background','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <div class="ap-radio-field"><input type="radio" name="form_styles[form][form_background]" value="yes" <?php if(isset($ap_settings['form_styles']['form']['form_background']) && $ap_settings['form_styles']['form']['form_background']=='yes'){?>checked="checked"<?php }?>/><span>Yes</span></div>
      <div class="ap-radio-field"><input type="radio" name="form_styles[form][form_background]" value="no" <?php if(isset($ap_settings['form_styles']['form']['form_background']) && $ap_settings['form_styles']['form']['form_background']=='no'){?>checked="checked"<?php }?>/><span>No</span></div>
    </div>
  </div>

  <div class="ap-option-wrapper">
    <label><?php _e('Form Background Type','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <div class="ap-radio-field"><input type="radio" name="form_styles[form][form_background_type]" value="color" <?php if(isset($ap_settings['form_styles']['form']['form_background_type']) && $ap_settings['form_styles']['form']['form_background_type']=='color'){?>checked="checked"<?php }?>/><span>Color</span></div>
      <div class="ap-radio-field"><input type="radio" name="form_styles[form][form_background_type]" value="image" <?php if(isset($ap_settings['form_styles']['form']['form_background_type']) && $ap_settings['form_styles']['form']['form_background_type']=='image'){?>checked="checked"<?php }?>/><span>image</span></div>
    </div>
  </div>

  
   <div class="ap-form-background-switch ap-option-wrapper" id="ap-form-background-color">
     <label><?php _e('Background Color','anonymous-post-pro')?></label>
     <div class="ap-option-field">
       <input type="text" name="form_styles[form][form_background_color]" class="ap-color-field" value="<?php echo $ap_settings['form_styles']['form']['form_background_color'];?>"/>
     </div>
   </div>
   <div class="ap-form-background-switch ap-option-wrapper" id="ap-form-background-image">
     <label><?php _e('Background Image','anonymous-post-pro');?></label>
     
       <div class="ap-radio-field"><input id="ap-background-image" type="text" name="form_styles[form][background_image]" value="<?php echo $ap_settings['form_styles']['form']['background_image'];?>" /><input id="ap-background-upload-button" type="button" value="Upload Image" /></div>
   </div> 
   <div class="ap-option-wrapper ap-option-wrapper" id="ap-form-background-repeat">
    <label><?php _e('Background Repeat Type','anonymous-post-pro');?></label>
    <div class="ap-option-field">
      <select name="form_styles[form][background_repeat]">
        <option value="repeat" <?php if($ap_settings['form_styles']['form']['background_repeat']=='repeat'){?>selected="selected"<?php }?>>Repeat</option>
        <option value="no-repeat" <?php if($ap_settings['form_styles']['form']['background_repeat']=='no-repeat'){?>selected="selected"<?php }?>>No Repeat</option>
        <option value="repeat-x" <?php if($ap_settings['form_styles']['form']['background_repeat']=='repeat-x'){?>selected="selected"<?php }?>>Repeat X</option>
        <option value="repeat-y" <?php if($ap_settings['form_styles']['form']['background_repeat']=='repeat-y'){?>selected="selected"<?php }?>>Repeat Y</option>
      </select>
    </div>
  
  </div><!--ap-tab-wrapper-->
</div>

</div><!--ap-form-styles-->
<!--Form Styling Options-->
</div><!--ap-form-styler-wrapper-->
<div class="ap-template-preview-wrapper" <?php if($ap_settings['plugin_style_type']!='template'){?>style="display:none"<?php }?>>
<h1>Template Preview</h1>
 <div class="ap-template-image-wrapper template1-preview" <?php if($ap_settings['form_template']!='template1'){?>style="display:none;"<?php }?>>
   <h3>Template 1 Preview</h3>
   <img src="<?php echo AP_PRO_IMAGE_DIR.'/template1.png'?>"/> 
 </div>
 <div class="ap-template-image-wrapper template2-preview" <?php if($ap_settings['form_template']!='template2'){?>style="display:none;"<?php }?>>
   <h3>Template 2 Preview</h3>
   <img src="<?php echo AP_PRO_IMAGE_DIR.'/template2.png'?>"/> 
 </div>
 <div class="ap-template-image-wrapper template3-preview" <?php if($ap_settings['form_template']!='template3'){?>style="display:none;"<?php }?>>
   <h3>Template 3 Preview</h3>
   <img src="<?php echo AP_PRO_IMAGE_DIR.'/template3.png'?>"/> 
 </div>
 <div class="ap-template-image-wrapper template4-preview" <?php if($ap_settings['form_template']!='template4'){?>style="display:none;"<?php }?>>
   <h3>Template 4</h3>
   <img src="<?php echo AP_PRO_IMAGE_DIR.'/template4.png'?>"/> 
 </div>
</div>
</div><!--ap-form-styling-settings-wrapper-->

</div><!--ap-tabs-board-->
