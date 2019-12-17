<style>
  
  .ap-front-form-styler .ap-pro-form-field-wrapper label,
.ap-front-form-styler .ap-form-field-wrapper label{
    font-family: '<?php echo $ap_settings['form_styles']['label']['font']?>', sans-serif;
    color:#000;
    color: <?php echo $ap_settings['form_styles']['label']['label_color'];?>;
    font-size: <?php echo $ap_settings['form_styles']['label']['font_size'].'px';?>;
    line-height: 1.4; 
}
.ap-front-form-styler .ap-pro-info-notes-icon{
    font-size: 12px;
    height: 14px;
    width: 14px;
    padding: 0;
    text-align: center;
    line-height: 14px;
    margin-top: 0;
}
.ap-front-form-styler .ap-pro-info-wrap{
    line-height: 20px;
    vertical-align: bottom;
    margin-bottom: 2px;
}
.ap-front-form-styler .ap-pro-info-wrap span:hover + .ap-pro-info-notes{
    top: -7px;
}
.ap-front-form-styler .ap-pro-form-field input[type="text"],
.ap-front-form-styler .ap-pro-form-field textarea,
.ap-front-form-styler .ap-pro-form-field select{
    border-style: solid;
    border-color: <?php echo $ap_settings['form_styles']['field']['border_color'];?>;
    border-width: <?php echo $ap_settings['form_styles']['field']['border_thickness'].'px';?>;
    color: <?php echo $ap_settings['form_styles']['field']['color'];?>;
    padding-left: 10px;
    width: 100%;
}
.ap-front-form-styler .ap-pro-form-field-wrapper input[type="submit"]{
    background-color: <?php echo $ap_settings['form_styles']['button']['button_background']?>;
    font-family: '<?php echo $ap_settings['form_styles']['button']['font']?>', sans-serif;
    font-weight: 700;
    font-size: <?php echo $ap_settings['form_styles']['button']['font_size'].'px'?>; 
    color: <?php echo $ap_settings['form_styles']['button']['font_color']?>;
    padding: 5px 15px;
    box-sizing: content-box;
    -moz-box-sizing: content-box;
    -webkit-box-sizing: content-box;
    line-height: 1;
}
.ap-form-wrapper.ap-front-form-styler{
    width: 100%;
    width:<?php echo $ap_settings['form_styles']['form']['width'];?><?php echo ($ap_settings['form_styles']['form']['width_type']=='px')?'px':'%'?>;
    background-color: #EEE;
    <?php if($ap_settings['form_styles']['form']['form_background']=='yes'){
        if($ap_settings['form_styles']['form']['form_background_type']=='color')
        {
         ?>
         background-color: <?php echo $ap_settings['form_styles']['form']['form_background_color']?>;
         padding:20px;
         <?php     
        }
        else
        {
         ?>
         background-image: url(<?php echo $ap_settings['form_styles']['form']['background_image']?>);
        background-repeat:<?php echo $ap_settings['form_styles']['form']['background_repeat']?>;
        padding:20px;
         <?php         
        }
       }
       if($ap_settings['form_styles']['form']['border']=='yes')
       {
        ?>
        border-style: solid;
    border-color: <?php echo $ap_settings['form_styles']['form']['border_color'];?>;
    border-width: <?php echo $ap_settings['form_styles']['form']['border_thickness'].'px';?>;
        padding:20px;
        <?php 
       }
         if($ap_settings['form_styles']['form']['round_corners']=='yes')
         {?>
         border-radius:5px;
         <?php 
            
         }
       ?>
     
}
</style>