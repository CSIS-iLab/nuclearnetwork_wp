<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter_Taxonomy_Walker
 * @author    Ross Morsali
 * @link      http://www.designsandcode.com/
 * @copyright 2015 Designs & Code
 */
 
class Search_Filter_Taxonomy_Object_Walker extends Walker_Category {

	
	private $type = '';
	private $auto_count = 0;
	private $defaults = array();
	private $multidepth = 0; //manually calculate depth on multiselects
	private $multilastid = 0;
	private $multilastdepthchange = 0;
	private $elementno = 0; //internal counter of which element we are on
    private $term_rewrite_depth = 0;
    private $parents_names = array();

	function __construct($defaults = array(), &$options_obj)  {

		$type = 'checkbox';
		$this->type = $type;
		
		$this->options = array();
		$this->options_obj = $options_obj;
	}
	
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
	
	
	function start_el( &$output, $taxonomy_term, $depth = 0, $args = array(), $id = 0 )
	{
		global $searchandfilter;
		
		//extract($args);
		
		$sfid = $args['sfid'];
		$defaults = $args['defaults'];
		$hide_empty = $args['hide_empty'];
		$show_option_all_sf = $args['show_option_all_sf'];
		$show_default_option_sf = $args['show_default_option_sf'];
		$show_count = $args['show_count'];
		$show_count_format_sf = $args['show_count_format_sf'];
		
		$searchform = $searchandfilter->get($sfid);
		$this->auto_count = $searchform->settings("enable_auto_count");
		$this->auto_count_deselect_emtpy = $searchform->settings("auto_count_deselect_emtpy");
		
		
		$field_name = $args['sf_name'];
		
		//insert a default "select all" or "choose category: " at the start of the options
		//should only do this on radio or select field types as they are single select
		
		if($this->elementno==0)
		{//we are on the first element, so insert a default element first
			
			if((isset($show_option_all_sf))&&($show_default_option_sf==true))
			{
				$default_option = new stdClass();
				$default_option->label = $show_option_all_sf;
				$default_option->attributes = array(
					'class' => SF_CLASS_PRE.'level-0 '.SF_ITEM_CLASS_PRE.'0'
				);
				$default_option->value = "";
				$default_option->count = 0;
				array_push($this->options, $default_option);
			}
			
			$this->elementno++;
		}
		
		
		$option = new stdClass();
		$option->label = '';
		$option->attributes = array(
			'class' => ''
		);
		$option->value = '';
		
		
		//setup taxonomy term defaults
		$taxonomy_term_name = esc_attr( $taxonomy_term->name );
		$taxonomy_term_id = esc_attr( $taxonomy_term->term_id );
		$taxonomy_term_slug = esc_attr( $taxonomy_term->slug );
		$taxonomy_term_name = apply_filters( 'list_cats', $taxonomy_term_name, $taxonomy_term );
				
		//check a default has been set and set it
		/*if($defaults)
		{
			$no_selected_options = count($defaults);

			if(($no_selected_options>0)&&(is_array($defaults)))
			{
				if(in_array($taxonomy_term_id, $defaults))
				{
					$option->attributes['selected'] = 'selected';
				}
			}
		}*/
		
		//get the count var (either from S&F cache, or from WP)
		if($this->auto_count==1)
		{	
			$option_count = $searchform->get_count_var($field_name, $taxonomy_term->slug);
		}
		else
		{
			$option_count = intval($taxonomy_term->count);
		}
		
		if($args['hierarchical']==1)
		{
			// Custom  depth calculations! :/ 
			if($taxonomy_term->parent == 0)
			{//then this has no parent so reset depth
				$this->multidepth = 0;
			}
			else if($taxonomy_term->parent == $this->multilastid)
			{
				$this->multidepth++;
				$this->multilastdepthchange = $this->multilastid;
			}
			else if($taxonomy_term->parent == $this->multilastdepthchange)
			{//then this is also a child with the same parent so don't change depth
				
			}
			else
			{//then this has a different parent so must be lower depth
				if($this->multidepth>0)
				{
					$this->multidepth--;
					
					$this->multilastdepthchange = $taxonomy_term->parent;
				}
			}
		}


        $this->parents_names[$this->multidepth] = $taxonomy_term->slug;

		if((intval($hide_empty)!=1)||($option_count!=0))
		{
			
			$option->value = $taxonomy_term_slug;
			//$option->selected_value = $taxonomy_term_id; //we want to match defaults based on ID
			$option->label = $taxonomy_term_name;
			$option->depth = $this->multidepth;
			$option->count = $option_count;

            //we only want to grab the term rewrite template once for each depth
            if($option->depth==$this->term_rewrite_depth)
            {
                Search_Filter_TTT::add_template($this->get_term_link_template($taxonomy_term, $this->parents_names), $this->term_rewrite_depth, $taxonomy_term->taxonomy);
                $this->term_rewrite_depth++;
            }

			//add classes
			$option->attributes['class'] = SF_CLASS_PRE."level-".$this->multidepth.' '.SF_ITEM_CLASS_PRE.$taxonomy_term_id;
			
			if ( !empty($show_count) )
			{
				if($show_count_format_sf=="inline")
				{
					$option->label .= '&nbsp;&nbsp;(' . number_format_i18n($option_count) . ')';
				}
				else if($show_count_format_sf=="html")
				{
					$option->label .= '<span class="sf-count">(' . number_format_i18n($option_count) . ')</span>';
				}
			}
						
			//always last, after everything init
			array_push($this->options, $option);
		}
		
		$this->options_obj->set($this->options);
		
		$this->multilastid = $taxonomy_term_id;
				
		$output = '';
	}
    private function get_term_link_template($term, $term_names)
    {
        $taxonomy_name = $term->taxonomy;
        $term_slug = $term->slug;
        $term_link = get_term_link($term);
        //$term_template_link = str_replace($taxonomy_name, "[taxonomy]", $term_link);
        $term_template_link = $term_link;

        $term_index = 0;
        foreach($term_names as $term_name)
        {
            $term_template_link = str_replace($term_name, "[$term_index]", $term_template_link);
            $term_index++;
        }
        $term_template_link = str_replace($term_slug, "[term]", $term_template_link);

        return $term_template_link;
    }
	function end_el( &$output, $page, $depth = 0, $args = array() )
	{
		
	}
	
	function start_lvl( &$output, $depth = 0, $args = array() )
	{
		
	}


    function end_lvl( &$output, $depth = 0, $args = array() )
    {

    }

}
