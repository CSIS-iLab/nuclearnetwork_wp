<!--Post Title-->
           <li class="ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Post Title','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_title][show_form]" value="1" checked="checked" onclick="return false;"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_title][required]" value="1"  checked="checked" onclick="return false;"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_title][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_title][label]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[post_title][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_title][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields and will show just below the field in the frontend form','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_field_order[]" value="post_title|field"/>
               <input type="hidden" name="form_fields[post_title][field_type]" value="field"/>
             </div>
           </li>
           <!---Post Title Ends-->
           
           <!--Post Content-->
           <li class="ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Post Content','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_content][show_form]" value="1"  checked="checked" onclick="return false;"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_content][required]" value="1"  checked="checked" onclick="return false;"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_content][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_content][label]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[post_content][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_content][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields','anonymous-post-pro');?></div>
                 </li>
                 <li>
                   <label><?php _e('Editor Type','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[post_content][editor_type]">
                       <option value="simple">Simple Textarea</option>
                       <option value="rich">Rich Text Editor</option>
                       <option value="visual">Visual Editor</option>
                       <option value="html">HTML Editor</option>
                     </select>
                   </div>
                 </li>
               </ul>
               <input type="hidden" name="form_field_order[]" value="post_content|field"/>
               <input type="hidden" name="form_fields[post_content][field_type]" value="field"/>
             </div>
           </li>
           <!--Post Content Ends---->
           
           <!--Post Excerpt-->
           <li class="ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Post Excerpt','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_excerpt][show_form]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_excerpt][required]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_excerpt][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_excerpt][label]"/></div>
                 </li>
                  <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[post_excerpt][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_excerpt][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields and will show just below the field in the frontend form','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_field_order[]" value="post_excerpt|field"/>
               <input type="hidden" name="form_fields[post_excerpt][field_type]" value="field"/>
             </div>
           </li>
           <!--Post Excerpt Ends-->
           
           <!--Post Thumbnail-->
           <li class="ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Post Image','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_image][show_form]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_image][required]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_image][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_image][label]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[post_image][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_image][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields and will show just below the field in the frontend form','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_field_order[]" value="post_image|field"/>
               <input type="hidden" name="form_fields[post_image][field_type]" value="field"/>
             </div>
           </li>
           <!--Post Thumbnail Ends-->
           
           <!--Author Name--->
           <li class="ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Author Name','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[author_name][show_form]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[author_name][required]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_name][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_name][label]"/></div>
                 </li>
                  <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[author_name][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>                
                 <li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_name][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields and will show just below the field in the frontend form','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_field_order[]" value="author_name|field"/>
               <input type="hidden" name="form_fields[author_name][field_type]" value="field"/>
             </div>
           </li>
           <!--Author Name Ends-->
           
           <!--Author URL-->
           <li class="ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Author URL','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[author_url][show_form]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[author_url][required]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_url][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_url][label]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[author_url][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_url][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields and will show just the way you have selected on above option.','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_field_order[]" value="author_url|field"/>
               <input type="hidden" name="form_fields[author_url][field_type]" value="field"/>
             </div>
           </li>
           <!--Author URL Ends-->
           
           <!--Author Email-->
           <li class="ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Author Email','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[author_email][show_form]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[author_email][required]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_email][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_email][label]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[author_email][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[author_email][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields and will show just below the field in the frontend form','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_field_order[]" value="author_email|field"/>
               <input type="hidden" name="form_fields[author_email][field_type]" value="field"/>
             </div>
           </li>
           <!--Author Email Ends-->
           
           <!--Post Taxonomies-->
           <li class="ap-pro-form-taxonomies ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Post Category','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[category][show_form]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[category][required]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[category][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[category][label]"/></div>
                 </li>
                 <li>
                 <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[category][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[category][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields and will show just below the textfield in the frontend form','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_included_taxonomy[]" value="category"/>
               <input type="hidden" name="form_fields[category][hierarchical]" value="1"/>
               <input type="hidden" name="form_field_order[]" value="category|taxononmy"/>
               <input type="hidden" name="form_fields[category][field_type]" value="taxonomy"/>
               <input type="hidden" name="form_fields[category][taxonomy_label]" value="Category"/>
             </div>
           </li>
           
           <li class="ap-pro-form-taxonomies ap-pro-li-sortable">
             <div class="ap-pro-labels-head"><?php _e('Post Tags','anonymous-post-pro');?></div>
             <div class="ap-pro-labels-content" style="display: none;">
               <ul class="ap-pro-inner-configs">
                 <li>
                   <label><?php _e('Show on form','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_tag][show_form]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Required','anonymous-post-pro');?></label>
                   <div class="ap-pro-checkbox"><input type="checkbox" name="form_fields[post_tag][required]" value="1"/></div>
                 </li>
                 <li>
                   <label><?php _e('Custom required message');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_tag][required_message]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Label','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_tag][label]"/></div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes','anonymous-post-pro');?></label>
                   <div class="ap-pro-select">
                     <select name="form_fields[post_tag][notes_type]">
                       <option value="0"><?php _e('Don\'t Show','anonymous-post-pro');?></option>
                       <option value="icon"><?php _e('Show as info icon','anonymous-post-pro');?></option>
                       <option value="tooltip"><?php _e('Show as tooltip','anonymous-post-pro');?></option>                                              
                     </select>
                   </div>
                 </li>
                 <li>
                   <label><?php _e('Field Notes Text','anonymous-post-pro');?></label>
                   <div class="ap-pro-textbox"><input type="text" name="form_fields[post_tag][notes]"/></div>
                   <div class="ap-pro-notes"><?php _e('These are extra notes for the front form fields and will show just below the textfield in the frontend form','anonymous-post-pro');?></div>
                 </li>
               </ul>
               <input type="hidden" name="form_included_taxonomy[]" value="post_tag"/>
               <input type="hidden" name="form_fields[post_tag][hierarchical]" value="0"/>
                <input type="hidden" name="form_field_order[]" value="post_tag|taxonomy"/>
                <input type="hidden" name="form_fields[post_tag][field_type]" value="taxonomy"/>
                <input type="hidden" name="form_fields[post_tag][taxonomy_label]" value="Post Tags"/>
             </div>
           </li>
           
           <!--Post Taxonomies-->