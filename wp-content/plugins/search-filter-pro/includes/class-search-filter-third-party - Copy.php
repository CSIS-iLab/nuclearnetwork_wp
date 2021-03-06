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
            //add_filter('sf_query_cache_field_terms_results', array($this, 'sf_woocommerce_convert_term_results'), 11, 3); //
            add_filter('sf_admin_filter_settings_save', array($this, 'sf_woocommerce_filter_settings_save'), 11, 2); // ***************************************
            add_filter('sf_query_cache_register_all_ids', array($this, 'sf_woocommerce_register_all_result_ids'), 11, 2); //
            //add_filter('search_filter_cache_filter_names', array($this, 'sf_woocommerce_cache_filter_names'), 11, 2); //

            // -- relevanssi
            add_filter('sf_edit_query_args_after_custom_filter', array($this, 'relevanssi_filter_query_args'), 12, 2);
            add_filter('sf_apply_custom_filter', array($this, 'relevanssi_add_custom_filter'), 10, 3);

            // -- polylang
            add_filter('sf_archive_results_url', array($this, 'pll_sf_archive_results_url'), 10, 3); //
            add_filter('sf_ajax_results_url', array($this, 'pll_sf_ajax_results_url'), 10, 2); //
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

	    // -- woo public + admin
	    add_action('search_filter_pre_update_post_cache', array($this, 'sf_woocommerce_update_post_cache'), 10, 2); //
	    add_filter('search_filter_post_cache_insert_data', array($this, 'sf_woo_post_cache_insert_data'), 10, 3); //
	    add_filter('search_filter_post_cache_data', array($this, 'sf_woocommerce_cache_data'), 11, 2); //

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


    public function sf_woo_post_cache_insert_data( $insert_data, $post_id, $type ) {

	    if (!$this->is_woo_enabled()) {
		    return $insert_data;
	    }


	    $post = get_post($post_id);

	    if(!$post) {
		    return $insert_data;
	    }

	    if($post->post_type !== 'product') {
		    return $insert_data;
	    }

	    $product = wc_get_product($post->ID);
	    if( $product->is_type('variable')) {

	    	//then remove `price`, and remove all taxonomy related attributes (as we want to add them manually, based on variations data)
		    if($type == 'taxonomy') {

		    	$product_attributes = $product->get_attributes();

		        foreach( $insert_data as $data_key => $data ) {

		            $attr_key = strpos($data_key, '_sft_pa_');
		            if( $attr_key !== false ) {

		            	$tax_name = str_replace("_sft_", "", $data_key);
		            	if(isset($product_attributes[$tax_name])) {

				            //now check to see if the attribute is used as variation, if not, then index it
		            		if($product_attributes[$tax_name]['variation'] === true) {
					            unset( $insert_data[ $data_key ] );
				            }
			            }



				    }
			    }
		    } else if($type == 'meta') {
		        if(isset($insert_data['_sfm__price'])) {
				    //unset($insert_data['_sfm__price']);
			        // no we need to leave in parent price, so it can be matched
			        // with other fields, such as attributes, that are not variations (so they are on the parent)
			    }
		    }

	    } else if( $product->is_type('simple')) {
	    	// then we need to add product attributes, that are not taxonomies
		    if($type == 'meta') {

			    $product_attributes = $product->get_attributes();

			    foreach($product_attributes as $product_attribute) {

			    	if(!$product_attribute->is_taxonomy()) {
						$attribute_name = $product_attribute->get_name();
						$sf_field_name = '_sfm_attribute_'.$attribute_name;
						$attribute_options = $product_attribute->get_options();

					    $insert_data[$sf_field_name] = $attribute_options;
				    }
			    }
		    }
	    }

	    return $insert_data;
    }


	private function sf_woo_get_product_terms_data($postID) {

		$insert_arr = array();

		if (!$this->is_woo_enabled()) {
			return $insert_arr;
		}


		$post = get_post($postID);

		$post_type = $post->post_type;
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );


		if(Search_Filter_Helper::has_wpml()&&(defined("ICL_LANGUAGE_CODE")))
		{
			$current_language = ICL_LANGUAGE_CODE;
			$post_language_details = apply_filters( 'wpml_post_language_details', null, $postID );

			if(!empty($post_language_details))
			{
				$language_code = $post_language_details['language_code'];
				if(($language_code!=="")&&(!empty($language_code)))
				{
					do_action( 'wpml_switch_language', $language_code );
				}

			}
		}


		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){


			//if($taxonomy_slug!=){
				$attr_key = strpos($taxonomy_slug, 'pa_');
				if( ( $attr_key === false ) && ( $attr_key !== 0 ) ) {

				// get the terms related to post
					$terms = get_the_terms( $postID, $taxonomy_slug );
					$insert_arr["_sft_".$taxonomy_slug] = array();
					$insert_arr["_sft_".$taxonomy_slug]['values'] = array();
					$insert_arr["_sft_".$taxonomy_slug]['type'] = 'number';

					if ( !empty( $terms ) ) {
						foreach ( $terms as $term ) {

							$term_id = $term->term_id;

							if(Search_Filter_Helper::has_wpml())
							{
								//we need to find the language of the post
								$post_lang_code = Search_Filter_Helper::wpml_post_language_code($postID);

								//then send this with object ID to ensure that WPML is not converting this back
								$term_id = Search_Filter_Helper::wpml_object_id($term->term_id , $term->taxonomy, true, $post_lang_code );
							}


							array_push($insert_arr["_sft_".$taxonomy_slug]['values'], (string)$term_id);
						}
					}

				}
			//}
		}

		if(Search_Filter_Helper::has_wpml()&&(defined("ICL_LANGUAGE_CODE")))
		{
			do_action( 'wpml_switch_language', $current_language );
		}

		return $insert_arr;

	}
	public function get_all_filters_names() {
		$filters = array();

		$search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish,draft&posts_per_page=-1&suppress_filters=1');
		$search_forms = $search_form_query->get_posts();

		foreach ($search_forms as $search_form) {
			$search_form_fields = $this->get_fields_meta($search_form->ID);

			foreach ($search_form_fields as $key => $field) {
				$valid_filter_types = array("tag", "category", "taxonomy", "post_meta");

				if (in_array($field['type'], $valid_filter_types)) {
					if (($field['type'] == "tag") || ($field['type'] == "category") || ($field['type'] == "taxonomy")) {
						array_push($filters, "_sft_" . $field['taxonomy_name']);
					} else if ($field['type'] == "post_meta") {
						if ($field['meta_type'] == "choice") {
							array_push($filters, "_sfm_" . $field['meta_key']);
						}
					}
				}

			}
		}
		$filters = array_unique($filters);

		return $filters;
	}
	private function get_fields_meta($sfid)
	{

		$meta_key = '_search-filter-fields';
		$search_form_fields = (get_post_meta($sfid, $meta_key, true));

		return $search_form_fields;
	}
	public function get_all_meta_key_names() {
		$filters = array();

		$search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish,draft&posts_per_page=-1&suppress_filters=1');
		$search_forms = $search_form_query->get_posts();

		foreach ($search_forms as $search_form) {
			$search_form_fields = $this->get_fields_meta($search_form->ID);

			foreach ($search_form_fields as $key => $field) {
				$valid_filter_types = array("tag", "category", "taxonomy", "post_meta");

				if ($field['type'] == "post_meta") {
					if ($field['meta_type'] == "choice") {
						array_push($filters, $field['meta_key']);
					}
				}
			}
		}
		$filters = array_unique($filters);

		return $filters;
	}
	public function sf_woo_get_variation_post_meta_values($variation_id) {

		$index_data = array();

		global $searchandfilter;
		$meta_key_fields = $this->get_all_meta_key_names();

		$wanted_meta_keys = array();
		foreach ( $meta_key_fields as $meta_key_field_name ) {

			if ( ( $meta_key_field_name !== '_price' ) && ( strpos( $meta_key_field_name, 'attribute_' ) === false ) ) {
				array_push($wanted_meta_keys, $meta_key_field_name);
			}
		}

		foreach($wanted_meta_keys as $wanted_meta_key){
			$post_meta_values = get_post_meta($variation_id, $wanted_meta_key);

			//var_dump($post_meta_values);

			if(!empty($post_meta_values)) {
				$index_data['_sfm_'.$wanted_meta_key] = array();
				$index_data['_sfm_'.$wanted_meta_key]['values'] = $post_meta_values;
				$index_data['_sfm_'.$wanted_meta_key]['type'] = 'string';
			}
		}

		return $index_data;
	}

    public function sf_woo_post_cache_add_variation_product_data( $post ) {

	    if (!$this->is_woo_enabled()) {
		    return;
	    }

	    //get the terms on the parent post, so we can add them to all the variations in our cache
	    $term_values = $this->sf_woo_get_product_terms_data($post->ID);

	    $product_variable = new WC_Product_Variable( $post->ID );
	    $product_variations = $product_variable->get_available_variations();

	    //loop through the variations
	    foreach($product_variations as $product_variation) {

		    $variation_id = $product_variation['variation_id'];
		    $variation_price = $product_variation['display_price'];
		    $variation_attributes = $product_variation['attributes'];

		    //start by adding post meta / can be an empty array
		    //$variation_values = array();
		    $variation_values = $this->sf_woo_get_variation_post_meta_values($variation_id);

		    //loop through the variations attributes
		    foreach($variation_attributes as $variation_key => $variation_value) {

			    if ( strpos( $variation_key, 'attribute_' ) !== false ) {


				    if(!empty($variation_value)) {

					    //if the name begins with attribute_pa, then its a taxonomy
					    if ( strpos( $variation_key, 'attribute_pa' ) !== false ) {

						    $taxonomy_name = str_replace( 'attribute_', '', $variation_key );
						    $term = get_term_by( 'name', $variation_value, $taxonomy_name );

						    if ( ! is_wp_error( $term ) ) {
							    $field_name = '_sft_' . $taxonomy_name;
							    $variation_values[ $field_name ] = array();

							    $variation_values[ $field_name ]['values'] = array( $term->term_id );
							    $variation_values[ $field_name ]['type'] = 'number';

						    }
					    } else {
						    $meta_name = $variation_key;

						    $field_name = '_sfm_' . $meta_name;
						    $variation_values[ $field_name ] = array();
						    $variation_values[ $field_name ]['values'] = array( $variation_value );
						    $variation_values[ $field_name ]['type'] = 'string';
					    }

				    }

			    }
		    }

		    $variation_values['_sfm__price'] = array();
		    $variation_values['_sfm__price']['values'] = array($variation_price);
		    $variation_values['_sfm__price']['type'] = 'string';

		    
		    //combine parent taxonomies with variation attributes
		    $variation_insert_data = array_merge($term_values, $variation_values);

		    //add variation
		    do_action('search_filter_insert_post_data', $variation_id, $variation_insert_data, 'number');
	    }
    }
    public function sf_woo_post_cache_add_simple_product_data( $post ) {


    }
    public function sf_woocommerce_update_post_cache( $post ) {

	    if (!$this->is_woo_enabled()) {
		    return;
	    }

	    if($post->post_type=="product"){

		    $product = wc_get_product($post->ID);
		    if( $product->is_type('variable')) {
			    $this->sf_woo_post_cache_add_variation_product_data($post);
		    }
		    /*else if( $product->is_type('simple')) {
			    $this->sf_woo_post_cache_add_simple_product_data($post);
		    }*/
	    }
    }

    /*public function sf_woocommerce_get_tax_meta_variations_keys($add_prefix = true)
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
    }*/

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

	        $variation_position = array_search("product_variation", $cache_data['post_types'], true);

	        if($variation_position!==false){
		        unset($cache_data['post_types'][$variation_position]); //we don't want to index them, we hook into WC classes to grab the data
		        $cache_data['post_types'] = array_values($cache_data['post_types']);
	        }

            //then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list
            /*$meta_keys = $this->sf_woocommerce_get_tax_meta_variations_keys();
            if (!empty($meta_keys)) {
                $cache_data['meta_keys'] = array_unique(array_merge($cache_data['meta_keys'], $meta_keys));
            }*/
        }

        return $cache_data;

    }

    public function sf_woocommerce_is_woo_variations_query($sfid)
    {
	    if (!$this->is_woo_enabled()) {
		    return false;
	    }

        global $searchandfilter;
        $sf_inst = $searchandfilter->get($sfid);

        $post_types = array_keys($sf_inst->settings("post_types"));

        if ((in_array("product", $post_types)) && (in_array("product_variation", $post_types))) {
            //then we need to store the vairation data in the DB, variations (even when taxonomies) are actually stored as post meta on the variation itself, so add these to the meta list

            return true;
        }

        return false;

    }
    /*public function sf_woocommerce_cache_filter_names($field_names, $sfid)
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
    }*/

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

                    $tax = Search_Filter_Wp_Data::get_taxonomy_term_by("slug", $term_name, $woo_tax_name);

                    if (($tax) && (isset($filters["_sft_" . $woo_tax_name]))) {
                        /* REMOVE THE PARENT POST ID FROM THE CACHE_RESULT_IDS */

                        if (!isset($filters["_sft_" . $woo_tax_name]['terms'][$term_name])) {
                            $filters["_sft_" . $woo_tax_name]['terms'][$term_name] = array();
                            $filters["_sft_" . $woo_tax_name]['terms'][$term_name]['term_id'] = $tax->term_id;
                            $filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'] = array();
                        }


                        $filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'] = array_merge($filters["_sft_" . $woo_tax_name]['terms'][$term_name]['cache_result_ids'], $result_ids);
                    }
                }
            }
        }

        return $filters;
    }
    public function sf_woocommerce_register_all_result_ids($register, $sfid)
    {
	    if (!$this->is_woo_enabled()) {
		    return $register;
	    }

        //make sure this search form is tyring to use woocommerce
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
	    if (!$this->is_woo_enabled()) {
		    return $post_ids;
	    }

        global $searchandfilter;
        $sf_inst = $searchandfilter->get($sfid);

        //make sure this search form is tyring to use woocommerce
        if($this->sf_woocommerce_is_woo_variations_query($sfid)){

            $this->woo_all_results_ids_keys = $sf_inst->query->cache->get_registered_result_ids();
            $all_result_ids = array_keys($this->woo_all_results_ids_keys);

	        //run query to convert variation IDs to parent/product IDs
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

            //var_dump($this->woo_result_ids_map);
            foreach ($this->woo_result_ids_map as $child_id => $parent_id) {
                array_push($find, $child_id);
                array_push($replace, $parent_id);
            }

	        // what we want to do is find any IDs which belong to parent and child. in the post_ids..
	        // if child + parent exist, then likely we are on a product attribute, where both the parent (product)
	        // and variation get the attribute attached
	        // so we need to find and remove all parent IDs from teh post IDs list, as long their child exists in the
	        // post ids
	        // the problem is, taxonomies such as product_cat, get attached to the parent of a variation, but not hte children
	        //

	        /*$variation_ids = array_keys($this->woo_result_ids_map);
			$parents_to_remove = array();

			foreach($variation_ids as $variation_id){

				//we have an ID thats a variation
				if(in_array($variation_id, $post_ids)) {
					$parent_id = $this->woo_result_ids_map[$variation_id];
					array_push($parents_to_remove, $parent_id);
				}
			}

			//echo "\r\n ***** parents_to_remove ****\r\n";
			$parents_to_remove = array_unique($parents_to_remove);
			//var_dump($parents_to_remove);*/

            //first remove all the parent IDs because in variations we don't want any matches on the product post type itself
            //$post_ids = array_diff($post_ids, $this->woo_result_ids_map);

            //then convert variation IDs to the parent
            $post_ids = array_unique(str_replace($find, $replace, $post_ids));

        }

        return $post_ids;
    }

	public function sf_woocommerce_query_args($query_args,  $sfid)
	{
		if (!$this->is_woo_enabled()) {
			return $query_args;
		}

		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		//make sure this search form is tyring to use woocommerce
		if($sf_inst->settings("display_results_as")=="custom_woocommerce_store"){

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
