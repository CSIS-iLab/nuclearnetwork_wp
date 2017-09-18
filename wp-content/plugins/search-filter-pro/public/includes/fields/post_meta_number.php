<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Field_Post_Meta_Number
 * @author    Ross Morsali
 * @link      http://www.designsandcode.com/
 * @copyright 2015 Designs & Code
 */

class Search_Filter_Field_Post_Meta_Number {
	
	public function __construct($plugin_slug, $sfid) {

		$this->plugin_slug = $plugin_slug;
		$this->sfid = $sfid;
		$this->create_input = new Search_Filter_Generate_Input($this->plugin_slug, $sfid);
		
		global $wpdb;
		$this->cache_table_name = $wpdb->prefix . 'search_filter_cache';
		$this->term_results_table_name = $wpdb->prefix . 'search_filter_term_results';
	}
	
	public function get($field_name, $args, $fields_defaults)
	{
		$returnvar = "";
		$defaults = $fields_defaults;
		
		global $wpdb;

		if($args['range_min_detect']==1)
		{
            $min_field_name = '_sfm_'.$args['number_start_meta_key'];

			$field_options = $wpdb->get_results( 
				"
				SELECT field_value
				FROM $this->cache_table_name
				WHERE field_name = '$min_field_name' AND field_value!=''
				ORDER BY cast(field_value AS UNSIGNED) ASC 
				LIMIT 0, 1
				"
			);
			
			foreach($field_options as $field_option)
			{
				$args['range_min'] = $field_option->field_value;
			}
		}
		
		if($args['range_max_detect']==1)
		{
            $max_field_name = '_sfm_'.$args['number_start_meta_key'];
            $use_same_as_start = $args['number_use_same_toggle'];
            if(!$use_same_as_start)
            {
                $max_field_name = '_sfm_'.$args['number_end_meta_key'];
            }

			$field_options = $wpdb->get_results( 
				"
				SELECT field_value
				FROM $this->cache_table_name
				WHERE field_name = '$max_field_name' AND field_value!=''
				ORDER BY cast(field_value AS UNSIGNED) DESC 
				LIMIT 0, 1 
				"
			);
			
			foreach($field_options as $field_option)
			{
				$args['range_max'] = $field_option->field_value;
			}
		}
		
		
		if(is_array($defaults))
		{
			if(!isset($defaults[0]))
			{
				$defaults[0] = $args['range_min'];
			}
			if(!isset($defaults[1]))
			{
				$defaults[1] = $args['range_max'];
			}				
		}
		else
		{
			$defaults = array($args['range_min'], $args['range_max']);
		}
		
		$input_args = array(
			'name' 						=>	$field_name,
			'range_min' 				=>	$args['range_min'],
			'range_max' 				=>	$args['range_max'],
			'range_step' 				=>	$args['range_step'],
			'default_min' 				=>	$defaults[0],
			'default_max'				=>	$defaults[1],
			'range_value_prefix'		=>	$args['range_value_prefix'],
			'range_value_postfix'		=>	$args['range_value_postfix'],
			'number_is_decimal'			=>	$args['number_is_decimal'],
			'accessibility_label'		=>	$args['number_accessibility_label'],
			
			'thousand_seperator'		=> $args['thousand_seperator'],
			'decimal_seperator'		    => $args['decimal_seperator'],
			'decimal_places'			=> $args['decimal_places'],
			'number_values_seperator'	=> $args['number_values_seperator'],
			'number_display_values_as'	=> $args['number_display_values_as']
		);
		
		$option_args = array(
			'name_sf' 					=> $field_name,
			'min'						=> $args['range_min'],
			'max'						=> $args['range_max'],
			'step'						=> $args['range_step'],
			
			'thousand_seperator'		=> $args['thousand_seperator'],
			'decimal_seperator'		    => $args['decimal_seperator'],
			'decimal_places'			=> $args['decimal_places'],
			
			'prefix'					=> $args['range_value_prefix'],
			'postfix'					=> $args['range_value_postfix']
		);
		
		
		if($args['all_items_label_number']=="")
		{
			$option_args['show_option_all_sf'] = __("All Items", $this->plugin_slug);
		}
		else
		{
			$option_args['show_option_all_sf'] = $args['all_items_label_number'];
		}
		
		if($args['number_input_type']=="range-slider")
		{
			$returnvar .= $this->create_input->range_slider($input_args);
		}
		else if($args['number_input_type']=="range-number")
		{
			$returnvar .= $this->create_input->range_number($input_args);
		}
		else if($args['number_input_type']=="range-select")
		{
			if($args['number_display_input_as']=="fromtofields")
			{
				$input_args['options'] = $this->get_range_options($option_args);
				$returnvar .= $this->create_input->range_select($input_args);
			}
			else if($args['number_display_input_as']=="singlefield")
			{
				//setup any custom attributes
				$attributes = array();
				
				//finalise input args object
				$option_args['show_default_option_sf'] = true;
				$input_args['options'] = $this->get_range_single_options($option_args);
				$input_args['attributes'] = $attributes;
				
				$select_defaults = array($defaults[0]."+".$defaults[1]);
				$input_args['defaults'] = $select_defaults;
				
				$returnvar .= $this->create_input->select($input_args);
			}
		}
		else if($args['number_input_type']=="range-radio")
		{
			//setup any custom attributes
			$attributes = array();
			
			if($args['number_display_input_as']=="fromtofields")
			{
				$input_args['options'] = $this->get_range_options($option_args);
				$returnvar .= $this->create_input->range_radio($input_args);
			}
			else if($args['number_display_input_as']=="singlefield")
			{
				$defaults = array("");
				if(count($fields_defaults)>0)
				{
					$defaults = array(implode("+", $fields_defaults));
				}
				
				$input_args['defaults'] = $defaults;
				
				//finalise input args object
				$option_args['show_default_option_sf'] = true;
				//$option_args['show_count_format_sf'] = 'html';
				
				$input_args['options'] = $this->get_range_single_options($option_args);
				$input_args['attributes'] = $attributes;
								
				$returnvar .= $this->create_input->radio($input_args);
			}
		}
		else if($args['number_input_type']=="range-checkbox")
		{
			$returnvar .= $this->create_input->generate_range_checkbox($field_name, $args['range_min'], $args['range_max'], $args['range_step'], $args['range_min'], $args['range_max'], $args['range_value_prefix'], $args['range_value_postfix']);
		}
		
		return $returnvar;
	}
	
	private function get_range_single_options($args)
	{
		//options is passed by ref, so when `wp_list_categories` is finished running, it will contain an object of all options for this field.
		$options = array();
		$name = $args['name_sf'];
				
		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$this->auto_count = $searchform->settings("enable_auto_count");
		$this->auto_count_deselect_emtpy = $searchform->settings("auto_count_deselect_emtpy");
		
		
		$min = $args['min'];
		$max = $args['max'];
		$step = $args['step'];
		$thousand_seperator = $args['thousand_seperator'];
        $decimal_point = $args['decimal_seperator'];
		$decimal_places = $args['decimal_places'];
		
		$diff = $max - $min;
		$istep = ceil($diff/$step);
		
		$input_class = SF_CLASS_PRE."input-select";
		
		$value_prefix = $args['prefix'];
		$value_postfix = $args['postfix'];
		
		/*if(isset($all_items_label))
		{
			if($all_items_label!="")
			{//check to see if all items has been registered in field then use this label
				$returnvar .= '<option class="level-0" value="">'.esc_html($all_items_label).'</option>';
			}
		}*/
		
		
		$show_option_all_sf = $args['show_option_all_sf'];
		$show_default_option_sf = $args['show_default_option_sf'];
		
		if((isset($show_option_all_sf))&&($show_default_option_sf==true))
		{
			$default_option = new stdClass();
			$default_option->label = $show_option_all_sf;
			$default_option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '.SF_ITEM_CLASS_PRE.'0'
			);
			$default_option->value = "";
			
			array_push($options, $default_option);
		}
		
		
		
		$value = $min;
		
		for($value=$min; $value<=$max; $value+=$step)
		{
			$min_val = (float) $value;
			$max_val = (float) $min_val + $step;
			
			/*if($decimal_places==0)
			{
				$max_val = $max_val - 1;
			}
			else if($decimal_places > 0)
			{
				$max_val = $max_val - (1/pow(10, $decimal_places));
			}*/
			
			if($max_val>$max)
			{
				$max_val = (float) $max;
			}
			
			$min_label = number_format( (float)$min_val, $decimal_places, $decimal_point, $thousand_seperator );
			$max_label = number_format( (float)$max_val, $decimal_places, $decimal_point, $thousand_seperator );
			
			$option = new stdClass();
			$option->label = $value_prefix.$min_label.$value_postfix." - ".$value_prefix.$max_label.$value_postfix;
			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);
			
			
			$option->value = $min_val.'+'.$max_val;
			array_push($options, $option);
			
		}
		
		
		
		return $options;
	}
	
	private function get_range_options($args)
	{
		//options is passed by ref, so when `wp_list_categories` is finished running, it will contain an object of all options for this field.
		$options = array();
		$name = $args['name_sf'];

		global $searchandfilter;
		$searchform = $searchandfilter->get($this->sfid);
		$this->auto_count = $searchform->settings("enable_auto_count");
		$this->auto_count_deselect_emtpy = $searchform->settings("auto_count_deselect_emtpy");
		
		
		$min = $args['min'];
		$max = $args['max'];
		$step = $args['step'];
		$thousand_seperator = $args['thousand_seperator'];
        $decimal_point = $args['decimal_seperator'];
		$decimal_places = $args['decimal_places'];

		$value = $min;
		
		for($value=$min; $value<=$max; $value+=$step)
		{
			$value_formatted = number_format( (float)$value, $decimal_places, $decimal_point, $thousand_seperator );
			
			$option = new stdClass();
			$option->label = $value_formatted;
			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);
			
			
			$option->value = $value;
			array_push($options, $option);
		}
		
		
		
		if(($value-$step)!=$max)
		{
			$option = new stdClass();

			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);

            $value_formatted = number_format( (float)$max, $decimal_places, $decimal_point, $thousand_seperator );
            $option->label = $value_formatted;
            $option->value = $max;
			array_push($options, $option);
		}
		
		//$i = 0;
		/*while($value<$max)
		{			
			$value = $min + ($step * $i);
			$i++;
			
			$option = new stdClass();
			$option->label = $value;
			$option->attributes = array(
				'class' => SF_CLASS_PRE.'level-0 '
			);
			$option->value = $value;
			
			array_push($options, $option);
		}
		*/
		
		return $options;
	}
}
