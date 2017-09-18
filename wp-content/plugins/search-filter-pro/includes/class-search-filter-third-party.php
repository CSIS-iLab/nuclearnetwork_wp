<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Third_Party
 * @author    Ross Morsali
 * @link      http://www.designsandcode.com/
 * @copyright 2015 Designs & Code
 */

class Search_Filter_Third_Party
{
    private $plugin_slug = '';
    private $form_data = '';
    private $count_table;
    private $cache;
    private $relevanssi_result_ids = array();
    private $query;
    private $woo_all_results_ids_keys = array();
    private $woo_all_results_ids = array();
    private $woo_result_ids_map = array();
    private $woo_meta_keys = array();
    private $woo_meta_keys_added = array();
    private $sfid = 0;

    private $woocommerce_enabled;

    function __construct($plugin_slug)
    {
        $this->plugin_slug = $plugin_slug;


        if(!is_admin()) {

            // -- woocommerce
            add_filter('sf_edit_query_args', array($this, 'sf_woocommerce_query_args'), 11, 2); //
            add_filter('sf_query_cache_post__in', array($this, 'sf_woocommerce_get_variable_product_ids'), 11, 2); //
            add_filter('sf_query_cache_count_ids', array($this, 'sf_woocommerce_conv_variable_ids'), 11, 2); //
            add_filter('sf_query_cache_field_terms_results', array($this, 'sf_woocommerce_convert_term_results'), 11, 3); //
            add_filter('sf_admin_filter_settings_save', array($this, 'sf_woocommerce_filter_settings_save'), 11, 2); //
            add_filter('sf_query_cache_register_all_ids', array($this, 'sf_woocommerce_register_all_result_ids'), 11, 2); //
            add_filter('search_filter_post_cache_data', array($this, 'sf_woocommerce_cache_data'), 11, 2); //
            add_filter('search_filter_cache_filter_names', array($this, 'sf_woocommerce_cache_filter_names'), 11, 2); //

            // -- relevanssi
            add_filter('sf_edit_query_args_after_custom_filter', array($this, 'relevanssi_filter_query_args'), 12, 2);
            add_filter('sf_apply_custom_filter', array($this, 'relevanssi_add_custom_filter'), 10, 3);

            // -- polylang
            add_filter('sf_archive_results_url', array($this, 'pll_sf_archive_results_url'), 10, 3); //

            //add_filter('sf_ajax_results_url', array($this, 'pll_sf_ajax_results_url'), 10, 2); //
        }

        //add_filter('fes_save_field_after_save_frontend', array($this, 'sf_edd_fes_field_save_frontend'), 11, 3); //
        //add_action('fes_submission_form_edit_published', array($this, 'sf_edd_fes_submission_form_published'), 20, 1);
        //add_action('fes_submission_form_new_published', array($this, 'sf_edd_fes_submission_form_published'), 20, 1);
        //add_action('fes_submission_form_edit_pending', array($this, 'sf_edd_fes_submission_form_published'), 20, 1);
        //add_action('fes_submission_form_new_pending', array($this, 'sf_edd_fes_submission_form_published'), 20, 1);

        // -- EDD
        //add_action( 'marketify_entry_before', array($this, 'marketify_entry_before_hook') );
        //add_filter('edd_downloads_query', array($this, 'edd_prep_downloads_sf_query'), 10, 2);
        //$searchform->query()->prep_query();

        // -- polylang
        add_filter('pll_get_post_types', array($this, 'pll_sf_add_translations'), 10, 2);
        add_filter('sf_edit_cache_query_args', array($this, 'poly_lang_sf_edit_cache_query_args'), 10, 3); //
        add_filter('sf_archive_slug_rewrite', array($this, 'pll_sf_archive_slug_rewrite'), 10, 3); //
        add_filter('sf_rewrite_query_args', array($this, 'pll_sf_rewrite_args'), 10, 3); //
        //add_filter('sf_pre_get_posts_admin_cache', array($this, 'sf_pre_get_posts_admin_cache'), 10, 3); //
        $this->init();
    }

    public function init()
    {

    }

    /* WooCommerce integration */
    public function is_woo_enabled()
    {
        if (!isset($this->woocommerce_enabled)) {
            if (!function_exists('is_plugin_active')) {
                require_once(ABSPATH . '/wp-admin/includes/plugin.php');
            }

            $this->woocommerce_enabled = is_plugin_active('woocommerce/woocommerce.php');
        }
        return $this->woocommerce_enabled;
    }

    public function sf_woocommerce_get_tax_meta_variations_keys($add_prefix = true)
    {
        $meta_keys = array();

        if (!$this->is_woo_enabled()) {
            return $meta_keys;
        }

        if(empty($this->woo_meta_keys))
        {
            $taxonomy_objects = get_object_taxonomies('product', 'objects');
            $exclude_taxonomies = array("product_type", "product_cat", "product_tag", "product_shipping_class");

            foreach ($taxonomy_objects as $taxonomy) {
                if (!in_array($taxonomy->name, $exclude_taxonomies)) {

                    $prefix = "";
                    if($add_prefix)
                    {
                        $prefix = "attribute_";
                    }
                    $meta_name = $prefix . $taxonomy->name;
                    array_push($meta_keys, $meta_name);
                }
            }

            $this->woo_meta_keys = $meta_keys;
        }

        return $this->woo_meta_keys;
    }
    public function sf_woocommerce_cache_data($cache_data)
    {
        //check to see if we are using woocommerce post types
        if (!$this->is_woo_enabled()) {
            return $cache_data;
        }

        if (empty($cache_data)) {
            return $cache_data;
        }

        if (empty($cache_data['post_types'])) {
            return $cache_data;
        }

        if ((in_array("product", $cache_data['post_types'])) && (in_array("product_variation", $cache_data['post_types']))) {
            //then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list

            $meta_keys = $this->sf_woocommerce_get_tax_meta_variations_keys();

            if (!empty($meta_keys)) {
                $cache_data['meta_keys'] = array_unique(array_merge($cache_data['meta_keys'], $meta_keys));
            }
        }

        return $cache_data;

    }

    public function sf_woocommerce_is_woo_variations_query($sfid)
    {
        global $searchandfilter;
        $sf_inst = $searchandfilter->get($sfid);

        $post_types = array_keys($sf_inst->settings("post_types"));

        if ((in_array("product", $post_types)) && (in_array("product_variation", $post_types))) {
            //then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list

            return true;
        }

        return false;

    }
    public function sf_woocommerce_cache_filter_names($field_names, $sfid)
    {
        if (!$this->is_woo_enabled()) {
            return $field_names;
        }

        if($this->sf_woocommerce_is_woo_variations_query($sfid))
        {
            $taxonomy_names = $this->sf_woocommerce_get_tax_meta_variations_keys(false);

            //now try to see which of the post variations post meta keys are in the current fields list (as taxonomies, and only then add them)
            $active_taxonomy_names = array();
            foreach ($field_names as $field_name)
            {
                //remove
                if(strpos($field_name, "_sft_")!== false)
                {
                    $tax_name = ltrim($field_name, '_sft_');
                    //$tax_name = str_replace("_sft_", "", $field_name);
                    array_push($active_taxonomy_names, $tax_name);
                }
            }

            //no we find which need to have meta fields also added to lookup tax values within variations
            $tax_meta_keys_needed = array_intersect($active_taxonomy_names, $taxonomy_names);

            //now convert them to field names:
            $this->woo_meta_keys_added = array();
            foreach($tax_meta_keys_needed as $tax_key)
            {
                $meta_key = "_sfm_attribute_".$tax_key;

                array_push($field_names, $meta_key);
                array_push($this->woo_meta_keys_added, $tax_key);

            }
        }

        return $field_names;
    }

    public function sf_woocommerce_convert_term_results($filters, $cache_term_results, $sfid)
    {
        //check to see if we are using woocommerce post types
        if(!$this->is_woo_enabled())
        {
            return $filters;
        }

        if(empty($filters))
        {
           return $filters;
        }

        foreach($this->woo_meta_keys_added as $woo_tax_name)
        {
            if(isset($cache_term_results["_sfm_attribute_".$woo_tax_name])) {
                $terms = $cache_term_results["_sfm_attribute_" . $woo_tax_name];

                foreach ($terms as $term_name => $result_ids) {
                    //echo "$term_name: ".implode(", ",$result_ids)."\r\n<br />";
                    //$result_ids = $term;.

                    //$taxonomy_name =

                    $tax = Search_Filter_Wp_Data::get_taxonomy_term_by("slug", $term_name, $woo_tax_name);

                    if (($tax) && (isset($filters["_sft_" . $woo_tax_name]))) {
                        /* REMOVE THE PARENT POST ID FROM THE CACHE_RESULT_IDS */

                        if (!isset($filters["_sft_" . $woo_tax_name]['terms'][$term_name])) {
                            $filters["_sft_" . $woo_tax_name]['terms'][$term_name] = array();
                            $filters["_sft_" . $woo_tax_name]['terms'][$term_name]['term_id'] = $tax->term_id;
                            $filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'] = array();
                        }


                        $filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'] = array_merge($filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'], $result_ids);

                        //$this->filters["_sft_".$woo_tax_name]['terms'][$tax->ID] = $result_ids;
                    }

                }
            }
        }

        return $filters;
    }
    public function sf_woocommerce_register_all_result_ids($register, $sfid)
    {
        //global $searchandfilter;
        //$sf_inst = $searchandfilter->get($sfid);
        
        //make sure this search form is tyring to use woocommerce
        //if($sf_inst->settings("display_results_as")=="custom_woocommerce_store") {
        if($this->sf_woocommerce_is_woo_variations_query($sfid)){
            return true;
        }

        return $register;

    }
    public function sf_woocommerce_is_filtered()
	{
		return true;
	}

	public function sf_woocommerce_get_variable_product_ids($post_ids, $sfid)
    {
        global $searchandfilter;
        $sf_inst = $searchandfilter->get($sfid);

        //make sure this search form is tyring to use woocommerce
        //if($sf_inst->settings("display_results_as")=="custom_woocommerce_store") {
        if($this->sf_woocommerce_is_woo_variations_query($sfid)){


            $this->woo_all_results_ids_keys = $sf_inst->query->cache->get_registered_result_ids();
            $all_result_ids = array_keys($this->woo_all_results_ids_keys);

            $parent_conv_args = array(
                'post_type' => 'product_variation',
                'posts_per_page' => -1,
                'paged' => 1,
                'post__in' => $all_result_ids,
                'fields' => "id=>parent",

                'orderby' => "", //remove sorting
                'meta_key' => "",
                'order' => "",

                // speed improvements
                'no_found_rows' => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false

            );

            // The Query
            $query_arr = new WP_Query($parent_conv_args);

            $new_ids = array();
            if ($query_arr->have_posts()) {
                foreach ($query_arr->posts as $post) {

                    if ($post->post_parent == 0) {
                        //$new_ids[$post->ID] = $post->ID;
                    } else {
                        $new_ids[$post->ID] = $post->post_parent;
                    }
                }
            }
            $this->woo_result_ids_map = ($new_ids);

            $post_ids = $this->sf_woocommerce_conv_variable_ids($post_ids, $sfid);
        }

        return $post_ids;
    }

	public function sf_woocommerce_conv_variable_ids($post_ids, $sfid)
    {
        global $searchandfilter;
        $sf_inst = $searchandfilter->get($sfid);

        //make sure this search form is tyring to use woocommerce
        //if($sf_inst->settings("display_results_as")=="custom_woocommerce_store"){
        if($this->sf_woocommerce_is_woo_variations_query($sfid)){

            $find = array();
            $replace = array();

            foreach ($this->woo_result_ids_map as $child_id => $parent_id)
            {
                array_push($find, $child_id);
                array_push($replace, $parent_id);
            }

            //first remove all the parent IDs because in variations we don't want any matches on the product post type itself
            $post_ids = array_diff($post_ids, $this->woo_result_ids_map);

            //then convert variation IDs to the parent
            $post_ids = array_unique(str_replace($find, $replace, $post_ids));

        }

        return $post_ids;
    }

	public function sf_woocommerce_query_args($query_args,  $sfid)
	{
		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		//make sure this search form is tyring to use woocommerce
		if($sf_inst->settings("display_results_as")=="custom_woocommerce_store"){
        //if(($this->sf_woocommerce_is_woo_variations_query($sfid))||($sf_inst->settings("display_results_as")=="custom_woocommerce_store")){

			$sf_current_query  = $sf_inst->current_query();
			if($sf_current_query->is_filtered())
			{
				add_filter('woocommerce_is_filtered', array($this, 'sf_woocommerce_is_filtered'));
			}

			return $query_args;
		}

		return $query_args;
	}

	//public function sf_edd_fes_field_save_frontend($field, $save_id, $value, $user_id)
	public function sf_edd_fes_field_save_frontend($field, $save_id, $value)
    {
        //FES has an issue where the same filter is used but with 3 args or 4 args
        //if the field is a digit, then actually this is the ID
        $post_id = 0;
        if(ctype_digit($field))
        {
            $post_id = $field;
        }
        else if(ctype_digit($save_id))
        {
            $post_id = $save_id;
        }

        //do_action('search_filter_update_post_cache', $save_id);
    }
    public function sf_edd_fes_submission_form_published($post_id)
    {
        do_action('search_filter_update_post_cache', $post_id);
    }
	public function sf_woocommerce_filter_settings_save($settings,  $sfid)
	{
		//make sure this search form is tyring to use woocommerce
		if(isset($settings['display_results_as']))
		{
			//if($settings["display_results_as"]=="custom_woocommerce_store"){
            if($this->sf_woocommerce_is_woo_variations_query($sfid)){

				$settings['treat_child_posts_as_parent'] = 1;
			}
			else
			{
				$settings['treat_child_posts_as_parent'] = 0;
			}
		}

		return $settings;
	}

	/* EDD integration */

	public function edd_prep_downloads_sf_query($query, $atts) {

		return $query;
	}


	/* pollylang integration */

	public function pll_sf_add_translations($types, $hide){

        $types['search-filter-widget'] = 'search-filter-widget';
		return $types;
		//return array_merge($types, array('search-filter-widget' => 'search-filter-widget'));
	}

	public function poly_lang_sf_edit_cache_query_args($query_args,  $sfid) {

		global $polylang;
		
		if(Search_Filter_Helper::has_polylang())
		{
			$langs = array();

			foreach ($polylang->model->get_languages_list() as $term)
			{
				array_push($langs, $term->slug);
			}

			$query_args["lang"] = $langs;
		}
		
		return $query_args;
	}
	/*
	public function sf_pre_get_posts_admin_cache($query,  $sfid) {

		$query->set("lang", "all");

		return $query;
	}
	*/

	function add_url_args($url, $str)
	{
		$query_arg = '?';
		if (strpos($url,'?') !== false) {

			//url has a question mark
			$query_arg = '&';
		}

		return $url.$query_arg.$str;

	}
	public function pll_sf_rewrite_args($args) {

		//if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		if(Search_Filter_Helper::has_polylang())
		{
            $args['lang'] = '';
		}

		return $args;
	}
	public function pll_sf_archive_slug_rewrite($newrules,  $sfid, $page_slug) {

		//if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		if(Search_Filter_Helper::has_polylang())
		{
			//takes into account language prefix
			//$newrules = array();
			$newrules["([a-zA-Z0-9_-]+)/".$page_slug.'$'] = 'index.php?&sfid='.$sfid; //regular plain slug
		}

		return $newrules;
	}
	public function pll_sf_ajax_results_url($ajax_url,  $sfid) {

		if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		{
			if(get_option('permalink_structure'))
			{
				$home_url = trailingslashit(pll_home_url());

				$ajax_url = $this->add_url_args($home_url, "sfid=$sfid&sf_action=get_data&sf_data=all");

			}
			else
			{
				$ajax_url = $this->add_url_args( pll_home_url(), "sfid=$sfid&sf_action=get_data&sf_data=all");
			}
		}

		return $ajax_url;
	}
	public function pll_sf_archive_results_url($results_url,  $sfid, $page_slug) {


		if((function_exists('pll_home_url'))&&(function_exists('pll_current_language')))
		{
			$results_url = pll_home_url(pll_current_language());

			if(get_option('permalink_structure'))
			{
				if($page_slug!="")
				{
					$results_url = trailingslashit(trailingslashit($results_url).$page_slug);
				}
				else
				{
					$results_url = trailingslashit($results_url);
					$results_url = $this->add_url_args( $results_url, "sfid=$sfid");
				}
			}
			else
			{
				$results_url .= "&sfid=".$sfid;
			}
		}

		return $results_url;
	}




	/* Relevanssi integration */

	public function remove_relevanssi_defaults()
	{
		remove_filter('the_posts', 'relevanssi_query');
		remove_filter('posts_request', 'relevanssi_prevent_default_request', 9);
		remove_filter('posts_request', 'relevanssi_prevent_default_request');
		remove_filter('query_vars', 'relevanssi_query_vars');
	}

	public function relevanssi_filter_query_args($query_args, $sfid) {

		//always remove normal relevanssi behaviour
		$this->remove_relevanssi_defaults();

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		if($sf_inst->settings("use_relevanssi")==1)
		{//ensure it is enabled in the admin

			if(isset($query_args['s']))
			{//only run if a search term has actually been set
				if(trim($query_args['s'])!="")
				{

					$search_term = $query_args['s'];
					$query_args['s'] = "";
				}
			}
		}

		return $query_args;
	}

	public function relevanssi_sort_result_ids($result_ids, $query_args, $sfid) {

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		if(count($result_ids)==1)
		{
			if(isset($result_ids[0]))
			{
				if($result_ids[0]==0) //it means there were no search results so don't even bother trying to change the sorting
				{
					return $result_ids;
				}
			}
		}

		if(($sf_inst->settings("use_relevanssi")==1)&&($sf_inst->settings("use_relevanssi_sort")==1))
		{//ensure it is enabled in the admin

			if(isset($this->relevanssi_result_ids['sf-'.$sfid]))
			{
				$return_ids_ordered = array();

				$ordering_array = $this->relevanssi_result_ids['sf-'.$sfid];

				$ordering_array = array_flip($ordering_array);

				foreach ($result_ids as $result_id) {
					$return_ids_ordered[$ordering_array[$result_id]] = $result_id;
				}

				ksort($return_ids_ordered);

				return $return_ids_ordered;
			}
		}

		return $result_ids;
	}

	public function relevanssi_add_custom_filter($ids_array, $query_args, $sfid) {

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		$this->remove_relevanssi_defaults();

		if($sf_inst->settings("use_relevanssi")==1)
		{//ensure it is enabled in the admin

			if(isset($query_args['s']))
			{//only run if a search term has actually been set

				if(trim($query_args['s'])!="")
				{
					//$search_term = $query_args['s'];

					if (function_exists('relevanssi_do_query'))
					{
						$expand_args = array(
						   'posts_per_page' 			=> -1,
						   'paged' 						=> 1,
						   'fields' 					=> "ids", //relevanssi only implemented support for this in 3.5 - before this, it would return the whole post object

						   //'orderby' 					=> "", //remove sorting
						   'meta_key' 					=> "",
						   //'order' 						=> "asc",

						   /* speed improvements */
						   'no_found_rows' 				=> true,
						   'update_post_meta_cache' 	=> false,
						   'update_post_term_cache' 	=> false

						);

						$query_args = array_merge($query_args, $expand_args);

						//$query_args['orderby'] = "relevance";
						//$query_args['order'] = "asc";
						unset($query_args['order']);
						unset($query_args['orderby']);

						// The Query
						$query_arr = new WP_Query( $query_args );
						relevanssi_do_query($query_arr);

						$ids_array = array();
						if ( $query_arr->have_posts() ){

							foreach($query_arr->posts as $post)
							{
								$postID = 0;

								if(is_numeric($post))
								{
									$postID = $post;
								}
								else if(is_object($post))
								{
									if(isset($post->ID))
									{
										$postID = $post->ID;
									}
								}

								if($postID!=0)
								{
									array_push($ids_array, $postID);
								}


							}
						}

						if($sf_inst->settings("use_relevanssi_sort")==1)
						{
							//keep a copy for ordering the results later
							$this->relevanssi_result_ids['sf-'.$sfid] = $ids_array;

							//now add the filter
							add_filter( 'sf_apply_filter_sort_post__in', array( $this, 'relevanssi_sort_result_ids' ), 10, 3);
						}

						return $ids_array;
					}
				}
			}
		}

		return array(false); //this tells S&F to ignore this custom filter
	}
}
