<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter_Post_Cache
 * @author    Ross Morsali
 * @link      http://www.designsandcode.com/
 * @copyright 2015 Designs & Code
 */

class Search_Filter_Post_Cache {

	private $sfid = 0;
	private $batch_size = 20;
	private $process_exec_time = 180;
	private $incl__post_types = array();
	private $incl__meta_keys = array();
	private $cache_options = array();
	public $WP_FILTER 				 	= null;

	public function __construct() {

		global $wpdb;
		$this->cache_table_name = $wpdb->prefix . 'search_filter_cache';
		$this->term_results_table_name = $wpdb->prefix . 'search_filter_term_results';
		$this->table_name_options = $wpdb->prefix . 'options';
		$this->option_name = "search-filter-cache";

		$cache_speed = get_option( 'search_filter_cache_speed' );

		if(empty($cache_speed))
		{
			$cache_speed = "slow";
		}

		if($cache_speed=="slow")
		{
			$this->batch_size = 10;
		}
		else if($cache_speed=="medium")
		{
			$this->batch_size = 20;
		}
		else if($cache_speed=="fast")
		{
			$this->batch_size = 40;
		}


		/* ajax */
		add_action( 'wp_ajax_cache_progress', array($this, 'cache_progress') ); //get progress
		add_action( 'wp_ajax_cache_restart', array($this, 'cache_restart') ); //get progress
        add_action( 'wp_ajax_cache_progress_manual', array($this, 'cache_progress_manual') ); //get progress
		add_action( 'wp_ajax_cache_restart_manual', array($this, 'cache_restart_manual') ); //get progress
		add_action( 'wp_ajax_refresh_cache', array($this, 'refresh_cache') );
		add_action( 'wp_ajax_nopriv_refresh_cache', array($this, 'refresh_cache') );

		add_action( 'wp_ajax_process_cache', array($this, 'process_cache') );
		add_action( 'wp_ajax_nopriv_process_cache', array($this, 'process_cache') );

		add_action( 'wp_ajax_build_term_results', array($this, 'build_term_results') );
		add_action( 'wp_ajax_nopriv_build_term_results', array($this, 'build_term_results') );

		add_action( 'wp_ajax_nopriv_test_remote_connection', array($this, 'test_remote_connection') );
		add_action( 'wp_ajax_test_remote_connection', array($this, 'test_remote_connection') );

		/* save post / re indexing hooks */
		add_action( 'save_post', 						array($this, 'post_updated'), 80, 3 ); //priority of 80 so it runs after the regular S&F form save
		add_filter( 'attachment_fields_to_edit', 			array($this, 'attachment_updated'), 80, 2 ); //priority of 80 so it runs after the regular S&F form save
		add_filter( 'set_object_terms', 			array($this, 'object_terms_updated'), 80, 3 ); //priority of 80 so it runs after the regular S&F form save
		add_filter( 'updated_postmeta', 			array($this, 'post_meta_updated'), 80, 4 ); //priority of 80 so it runs after the regular S&F form save
		//add_filter( 'updated_postmeta', 			array($this, 'post_meta_updated'), 80, 4 ); //priority of 80 so it runs after the regular S&F form save
		//add_filter( 'update_postmeta', 			array($this, 'post_meta_update'), 80, 4 ); //priority of 80 so it runs after the regular S&F form save
		//add_filter( 'deleted_postmeta', 			array($this, 'object_terms_updated'), 80, 3 ); //priority of 80 so it runs after the regular S&F form save

		/*add_action('new_to_publish', 				array($this, 'post_updated'), 10, 3);
		add_action('private_to_publish', 			array($this, 'post_updated'), 10, 3);
		add_action('draft_to_publish', 				array($this, 'post_updated'), 10, 3);
		add_action('auto-draft_to_publish', 		array($this, 'post_updated'), 10, 3);
		add_action('future_to_publish', 			array($this, 'post_updated'), 10, 3);
		add_action('pending_to_publish', 			array($this, 'post_updated'), 10, 3);
		add_action('inherit_to_publish', 			array($this, 'post_updated'), 10, 3);*/

		$this->init_cache_options();
		//$this->setup_cached_search_forms();
	}
	public function init_cache_options()
	{
		//check to see if there is a S&F options in the caching table

		//delete_option($this->option_name);
		$cache_options = get_option($this->option_name);

		if(!$cache_options)
		{//then lets init

			$cache_options = array();
			$cache_options['status'] = "ready";
			$cache_options['last_update'] = "";
			$cache_options['restart'] = true;
			$cache_options['cache_list'] = array(); //ids of posts to cache
			$cache_options['current_post_index'] = 0;
			$cache_options['progress_percent'] = 0;
			$cache_options['locked'] = false;
			$cache_options['error_count'] = 0; //the error here is from non-completed processing
			$cache_options['rc_status'] = ""; //this is a different error (remote connect) - and will try anotehr method of caching if the server cannot do a wp_remote_---, curl, etc etc
			$cache_options['process_id'] = 0;
			$cache_options['run_method'] = "automatic";

			$this->setup_cached_search_forms();

			//all the fields and options we need to cache
			//then grab the post types and the meta keys we need to index
			$cache_options['caching_data'] = array(
				"post_types" => $this->incl__post_types,
				"meta_keys" => $this->incl__meta_keys
			);

			//the fields and options from the last cache - compare this with new caching data to see if we need to trigger a reset
			//$cache_options['last_caching_data'] = $cache_options['caching_data'];

			update_option( $this->option_name, $cache_options, false );
		}
        if(!isset($cache_options['run_method']))
        {
            $cache_options['run_method'] = "automatic";
        }
		$this->cache_options = $cache_options;
	}

	public function get_real_option($option_name = "")
	{
		global $wpdb;

		$results = $wpdb->get_results( $wpdb->prepare( 
			"
			SELECT option_value
			FROM {$wpdb->options}
			WHERE option_name = '%s' LIMIT 0, 1
			",
			$option_name
		) );

		if(count($results)==0)
		{
			return false;
		}

		$result = unserialize($results[0]->option_value);

		return $result;
	}

	public function cache_restart()
	{
		$this->cache_options['restart'] = true;
		$this->cache_options['rc_status'] = "";
		$this->update_cache_options( $this->cache_options, true );

		$this->cache_progress();
	}
	public function cache_progress()
	{
		$cache_json = $this->cache_options;

		unset($cache_json['cache_list']);
		echo Search_Filter_Helper::json_encode($cache_json);

       // if($this->cache_options['run_method'] != "manual") {
            if ($this->cache_options['rc_status'] == "") {//then we need to test for a remote connection
                $this->can_wp_remote_post();
            }
        //}

        if($this->cache_options['run_method'] == "manual")
        {
            //manual, then do nothing, wait for initiated response

        }
		else if($this->cache_options['rc_status']=="connect_success")
		{//there is a remote connection error, so don't try remote call
			$query_args = array("action" => "refresh_cache");
			$url = add_query_arg($query_args, admin_url( 'admin-ajax.php' ));
			$this->wp_remote_post_with_cookie($url);//run in the background - calls refresh_cache()
		}
		else
		{
			$this->refresh_cache();
		}

		/*if(($this->cache_options['locked']==false)&&($this->cache_options['rc_status']))
		{
			//refresh_cache
		}*/

		exit;
	}

    public function cache_restart_manual()
    {
        if($this->cache_options['run_method'] == "manual") {

            $this->cache_options['restart'] = true;
            $this->cache_options['rc_status'] = "";

            $this->update_cache_options($this->cache_options, true);

            $this->cache_progress_manual();
        }
        exit;
    }

    public function cache_progress_manual()
    {
        /*$cache_json = $this->cache_options;

        unset($cache_json['cache_list']);
        echo Search_Filter_Helper::json_encode($cache_json);*/

        if($this->cache_options['run_method'] == "manual")
        {
            $this->refresh_cache();
        }


        $cache_json = $this->cache_options;
        unset($cache_json['cache_list']);
        echo Search_Filter_Helper::json_encode($cache_json);

        exit;
    }
	public function clean_query($query)
	{
		$query->set("tax_query", array());

	}
	public function refresh_cache()
	{//spawned from a wp_remote_get - so a background process

		ignore_user_abort(true); //allow script to carry on running
		set_time_limit($this->process_exec_time);
		ini_set('max_execution_time', $this->process_exec_time);

		if(($this->cache_options['status']=="error")&&($this->cache_options['restart']==false))
		{//if status = error, then caching can only resume based on user initiated response
            if($this->cache_options['run_method'] == "manual")
            {
                $cache_json = $this->cache_options;
                unset($cache_json['cache_list']);
                echo Search_Filter_Helper::json_encode($cache_json);
            }
			exit;
		}

		if((($this->cache_options['status']=="ready")||($this->cache_options['restart']==true)))
		{
			//then begin processing all the posts
			$this->cache_options['status'] = "inprogress";
			$this->cache_options['last_update'] = time();
			$this->cache_options['restart'] = false;
			$this->cache_options['current_post_index'] = 0;
			$this->cache_options['total_post_index'] = 0;
			$this->cache_options['progress_percent'] = 0;
			$this->cache_options['process_id'] = time();
			$this->cache_options['locked'] = false;
			$this->cache_options['error_count'] = 0;


			$this->setup_cached_search_forms();

			if(empty($this->incl__post_types))
			{

				$this->cache_options['status'] = "ready";
				$this->cache_options['restart'] = true;

				$this->update_cache_options( $this->cache_options, true );

				exit;
			}

			$query_args = array(
			   'post_type' 					=> $this->incl__post_types,
			   'posts_per_page' 			=> -1,
			   'paged' 						=> 1,
			   'fields' 					=> "ids",

			   'orderby' 					=> "ID",
			   'order' 						=> "ASC",

			   'post_status' 				=> array("publish", "pending", "draft", "future", "private"),

			   'suppress_filters' 			=> true,

			   /* speed improvements */
			   'no_found_rows' 				=> true,
			   'update_post_meta_cache' 	=> false,
			   'update_post_term_cache' 	=> false

			);

			if(in_array('attachment', $this->incl__post_types))
			{
				array_push($query_args['post_status'], "inherit");
			}


			if(has_filter('sf_edit_cache_query_args')) {
				$query_args = apply_filters('sf_edit_cache_query_args', $query_args, $this->sfid);
			}

			$this->hard_remove_filters();

			add_action('pre_get_posts', array($this, 'clean_query'), 100);
			$query = new WP_Query($query_args);
			
			remove_action('pre_get_posts', array($this, 'clean_query'), 100);

			$this->hard_restore_filters();

			if ( $query->have_posts() ){

				$this->cache_options['cache_list'] = $query->posts;
				$this->cache_options['total_post_index'] = count($this->cache_options['cache_list']);

			}
			else
			{//there were no posts to cache so set as complete or error


			}

			//clear cache
			$this->empty_cache();

			//update cache options in DB
			$this->update_cache_options( $this->cache_options, true );

            if($this->cache_options['run_method'] == "manual")
            {
                $this->process_cache($this->cache_options['process_id']);
            }
            else if($this->cache_options['rc_status']=="connect_success")
			{
				//$this->process_cache($this->cache_options['process_id']);
				$this->wp_remote_process_cache(array("process_id" => $this->cache_options['process_id']));
			}
			else
			{
				$this->process_cache($this->cache_options['process_id']);
			}
		}

		if($this->cache_options['status']=="inprogress")
		{//if its in progress, check when the last cycle started to see if there was a problem

			//if its been more than 5 minutes since the last cycle then start it again
			$current_time = time();
			$retry_limit = 2;
			$cycle_error_amount = 1 * 60; //3 minutes
			$error_time = $this->cache_options['last_update']+$cycle_error_amount;

			if($current_time >= $error_time)
			{//there was an error - so try to resume

				$this->cache_options['last_update'] = time();
				$this->cache_options['error_count']++;
				$this->cache_options['locked'] = false;

				if($this->cache_options['error_count']>$retry_limit)
				{//then there seems to be a serious issue, stop and show error message - allow user to restart

					$this->cache_options['status'] = "error";
					$this->cache_options['error_count'] = 0;
					$this->update_cache_options( $this->cache_options );
				}
				else
				{
					//try to continue the processing
					$this->cache_options['process_id'] = time();
					$this->update_cache_options( $this->cache_options );

                    if($this->cache_options['run_method'] == "manual")
                    {
                        $this->process_cache($this->cache_options['process_id']);
                    }
					else if($this->cache_options['rc_status']=="connect_success")
					{
						$this->wp_remote_process_cache(array("process_id" => $this->cache_options['process_id']));
					}
					else
					{
						$this->process_cache($this->cache_options['process_id']);
					}

				}

				//$this->process_cache();
			}
			else
			{//then just leave the scripts to carry on - we assume they are working

				//unless there is a remote connection error, which means we should try to manually resume

                if($this->cache_options['run_method'] == "manual")
                {
                    $this->process_cache($this->cache_options['process_id']);
                }
                else if($this->cache_options['rc_status']!="connect_success")
				{
					$this->process_cache($this->cache_options['process_id']);
				}
			}

		}
		else if($this->cache_options['status']=="termcache")
		{
			if($this->cache_options['rc_status']!="connect_success")
			{
				$this->process_cache($this->cache_options['process_id']);
			}
		}
		else
        {
            if($this->cache_options['run_method'] == "manual")
            {
                $cache_json = $this->cache_options;
                unset($cache_json['cache_list']);
                echo Search_Filter_Helper::json_encode($cache_json);
            }
        }

		exit;
	}
	public function hard_remove_filters()
	{
		$remove_posts_clauses = false;
		$remove_posts_where = false;

		if(isset($GLOBALS['wp_filter']['posts_clauses']))
		{
			$remove_posts_clauses = true;
		}

		if(isset($GLOBALS['wp_filter']['posts_where']))
		{
			$remove_posts_where = true;
		}

		//
		if(($remove_posts_clauses)||($remove_posts_where))
		{
			$this->WP_FILTER = $GLOBALS['wp_filter'];
		}

		if($remove_posts_clauses)
		{

			unset($GLOBALS['wp_filter']['posts_clauses']);
		}

		if($remove_posts_where)
		{

			unset($GLOBALS['wp_filter']['posts_where']);
		}
	}


	public function hard_restore_filters()
	{
		$remove_posts_clauses = false;
		$remove_posts_where = false;

		if(isset($this->WP_FILTER['posts_clauses']))
		{
			$remove_posts_clauses = true;
		}

		if(isset($this->WP_FILTER['posts_where']))
		{
			$remove_posts_where = true;
		}


		if(($remove_posts_clauses)||($remove_posts_where))
		{
			$GLOBALS['wp_filter'] = $this->WP_FILTER;
			unset($this->WP_FILTER);
		}

	}
	public function process_cache($process_id = 0)
	{
	    //$this->write_log("starting `process_cache`");
       /* $tcacheoptions = $this->cache_options;
        unset($tcacheoptions['cache_list']);
	    $this->write_log($tcacheoptions);*/

		ignore_user_abort(true); //allow script to carry on running
		set_time_limit($this->process_exec_time);
		ini_set('max_execution_time', $this->process_exec_time);

		//make sure we only run the same, valid process
		if($process_id==0)
		{
			if(isset($_GET['process_id']))
			{
				$process_id = (int)$_GET['process_id'];
			}
		}

        $live_options = $this->get_real_option($this->option_name);

		if((!$this->valid_process($process_id, $this->cache_options['current_post_index']))||($live_options['locked']==true))
		{
            if($this->cache_options['run_method'] == "manual")
            {
                $cache_json = $this->cache_options;
                unset($cache_json['cache_list']);
                echo Search_Filter_Helper::json_encode($cache_json);
            }
			exit;
		}

		if($this->cache_options['status']=="inprogress")
		{
            //$this->write_log("~~ locking [start for loop in `process_cache`]`". $this->cache_options['process_id']);
			$this->cache_options['locked'] = true;
			$this->update_cache_options( $this->cache_options );

			$this->setup_cached_search_forms();

			$cache_index = $this->cache_options['current_post_index'];
			$cache_list = $this->cache_options['cache_list'];
			$cache_length = count($cache_list);

			if(($cache_index + $this->batch_size)>$cache_length-1)
			{
				$batch_end = $cache_length - 1;
			}
			else
			{
				$batch_end = $cache_index + $this->batch_size - 1;
			}

			for($i=$cache_index; $i<=$batch_end; $i++)
			{
				//fetch a fresh copy of this value every time, in case another process in the bg has updated it since
				if(!$this->valid_process($process_id, $this->cache_options['current_post_index']))
				{
					exit;
				}

				$post_id = $cache_list[$i];
				$this->update_post_cache($post_id, "");
				//$this->update_post_cache($post_id, "", false); - don't update the term cache

				$this->cache_options['current_post_index'] = $i+1;
			}

			if(!$this->valid_process($process_id, $this->cache_options['current_post_index']))
			{
				exit;
			}

			$this->cache_options['last_update'] = time();
			$this->cache_options['progress_percent'] = round((100/$cache_length)*$this->cache_options['current_post_index']);
			$this->cache_options['locked'] = false;
			$this->cache_options['error_count'] = 0;


			if($this->cache_options['current_post_index']==$cache_length)
			{//complete

				//$this->cache_options['status'] = "termcache";
				//$this->cache_options['cache_list'] = array();
				//$this->update_cache_options( $this->cache_options );

				//$this->process_cache(); //one last time to get finished state

				//now its finished we also need to update the OTHER table... :/

				/*if($this->cache_options['rc_status']=="connect_success")
				{
					$this->wp_remote_build_term_results(array("process_id" => $this->cache_options['process_id'])); //make new async request
				}
				else
				{
					$this->build_term_results($this->cache_options['process_id']);
				}*/

				// if we're updating the term cache after every post then we just finish:

                //$this->write_log("~~ unlocking [finish list]`". $this->cache_options['process_id']);

				$this->cache_options['process_id'] = 0;
				$this->cache_options['status'] = "finished";
				$this->cache_options['locked'] = false;

				$this->cache_options['cache_list'] = array();
				$this->update_cache_options( $this->cache_options );

                if($this->cache_options['run_method'] == "manual")
                {
                    $cache_json = $this->cache_options;
                    unset($cache_json['cache_list']);
                    echo Search_Filter_Helper::json_encode($cache_json);
                }

			}
			else
			{//continue

                if($this->cache_options['run_method'] == "manual")
                {

                    //$this->write_log("~~ unlocking [finish batch | manual]`". $this->cache_options['process_id']);

                    $this->cache_options['locked'] = false;
                    $this->update_cache_options( $this->cache_options );

                    $cache_json = $this->cache_options;
                    unset($cache_json['cache_list']);
                    echo Search_Filter_Helper::json_encode($cache_json);
                }
                else
                {

                    $this->update_cache_options( $this->cache_options );

                    if ($this->cache_options['rc_status'] == "connect_success") {
                        sleep(2); //may not be essential, but might help on slower servers, give some delay between batches
                        $this->wp_remote_process_cache(array("process_id" => $this->cache_options['process_id'])); //make new async request
                    } else {
                        //don't do anything, wait for ajax initiated resum
                    }
                }


			}
		}
		else if($this->cache_options['status']=="termcache")
		{
			//$this->build_term_results($this->cache_options['process_id']);

		}
		else if($this->cache_options['status']!="finished")
		{
			$this->refresh_cache(); //check for any problems or restart/initialise
		}
		exit;
	}

	public function valid_process($process_id, $post_index)
	{
		$live_options = $this->get_real_option($this->option_name);

		//before making any more changes check to see if there has been a restart anywhere, or a new process spawned
		if((($process_id!=$live_options['process_id'])||($process_id==0)||$live_options['restart']==true)||($post_index<$live_options['current_post_index']))
		{//don't allow running of non active processes (should only be one anyway)
			//$live_options['locked'] = false;
			//$this->update_cache_options( $live_options );

			return false;
		}

		return true;

	}
	public function valid_term_process($process_id)
	{
		$live_options = $this->get_real_option($this->option_name);

		//before making any more changes check to see if there has been a restart anywhere, or a new process spawned
		if((($process_id!=$live_options['process_id'])||($process_id==0)||$live_options['restart']==true))
		{//don't allow running of non active processes (should only be one anyway)
			$live_options['locked'] = false;
			$this->update_cache_options( $live_options );

			return false;
		}

		return true;

	}

	public function wp_remote_process_cache($args = array())
	{
		$query_args = array("action" => "process_cache");
		$query_args = array_merge($query_args, $args);
		$url = add_query_arg($query_args, admin_url( 'admin-ajax.php' ));
		$remote_call = $this->wp_remote_post_with_cookie($url);//run in the background - calls refresh cache below
	}
	public function wp_remote_build_term_results($args = array())
	{
		$query_args = array("action" => "build_term_results");
		$query_args = array_merge($query_args, $args);
		$url = add_query_arg($query_args, admin_url( 'admin-ajax.php' ));
		$remote_call = $this->wp_remote_post_with_cookie($url);//run in the background - calls refresh cache below
	}
	public function can_wp_remote_post()
	{
		//check first to see if a user has bypassed this
		$cache_use_background_processes = get_option( 'search_filter_cache_use_background_processes' );

		if($cache_use_background_processes!=1)
		{
			$this->cache_options['rc_status'] = "user_bypass";
		}
		else
		{
			$args = array();
			$args['timeout'] = 5;

			$query_args = array("action" => "test_remote_connection");
			$url = add_query_arg($query_args, admin_url( 'admin-ajax.php' ));


			$remote_call = wp_remote_post($url, $args);
			//$this->cache_options['rc_status'] = "routing_error";

			if ( is_wp_error( $remote_call ) ) {
				$error_message = $remote_call->get_error_message();
				$this->cache_options['rc_status'] = "connect_error";

			} else {

				$success = false;

				if(isset($remote_call['body']))
				{
					$body = trim($remote_call['body']);
					if($body=="test_success")
					{
						$success = true;
					}
				}

				if($success)
				{
					$this->cache_options['rc_status'] = "connect_success";
				}
				else
				{//a response was received but not the one we wanted
					$this->cache_options['rc_status'] = "routing_error";
				}

			}
		}

        //$this->write_log("~~ can WP remote POST`". $this->cache_options['process_id']);
        $this->update_cache_option('rc_status', $this->cache_options['rc_status'] );
		//$this->update_cache_options( $this->cache_options );
	}
	public function test_remote_connection()
	{
		echo "test_success";
		//$this->update_cache_options( $this->cache_options );
		exit;

	}
	public function wp_remote_post_with_cookie($url, $args = array())
	{
		/*$args = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => array( 'username' => 'bob', 'password' => '1234xyz' ),
			'cookies' => array()
		);*/

		$args['timeout'] = 0.5;

		$remote_call = wp_remote_post($url);

		if ( is_wp_error( $remote_call ) ) {
			$error_message = $remote_call->get_error_message();
			//$this->cache_options['rc_status'] = "connect_error";

		} else {

		}

	}
	public function update_cache_options($cache_options, $bypass_real = false)
	{
		if(!$bypass_real)
		{
			$live_options = $this->get_real_option($this->option_name);
			if(isset($live_options['restart']));
			{
				$cache_options['restart'] = $live_options['restart'];
			}
		}

        //$this->write_log('Now doing `update_cache_options`.. setting locked to: '.$cache_options['locked'].' [pid: '.$this->cache_options['process_id'].']');
		update_option( $this->option_name, $cache_options, false );
	}
    public function update_cache_option($cache_option, $cache_value, $bypass_real = false)
	{
        $cache_options = $this->get_real_option($this->option_name);
        $cache_options[$cache_option] = $cache_value;

        //$this->write_log('Now doing `update_cache_option`.. setting locked to: '.$cache_options['locked'].' [pid: '.$this->cache_options['process_id'].']');
		update_option( $this->option_name, $cache_options, false );
	}

	public function empty_cache()
	{
		global $wpdb;

		$wpdb->query('TRUNCATE TABLE `'.$this->cache_table_name.'`');
		$wpdb->query('TRUNCATE TABLE `'.$this->term_results_table_name.'`');
	}

	public function build_term_results($process_id = 0)
	{
		ignore_user_abort(true); //allow script to carry on running
		set_time_limit(0);
		ini_set('max_execution_time', 0);

		//make sure we only run the same, valid process
		if($process_id==0)
		{
			if(isset($_GET['process_id']))
			{
				$process_id = (int)$_GET['process_id'];
			}
		}

		if((!$this->valid_term_process($process_id))||($this->cache_options['locked']==true))
		{
			exit;
		}

		$this->cache_options['locked'] = true;
		$this->update_cache_options( $this->cache_options );

		if($this->cache_options['status']=="termcache")
		{
			//empty terms first
			global $wpdb;
			$wpdb->query('TRUNCATE TABLE `'.$this->term_results_table_name.'`');
			$this->get_all_filters();
			$this->cache_options['process_id'] = 0;
			$this->cache_options['status'] = "finished";
			$this->cache_options['locked'] = false;

			$this->cache_options['cache_list'] = array();
			$this->update_cache_options( $this->cache_options );
		}
		else
		{
			//$this->refresh_cache(); //check for any problems or restart/initialise
		}
		exit;
	}

	public function get_all_filters()
	{
		$filters = array();

		$search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish,draft&posts_per_page=-1&suppress_filters=1');
		$search_forms = $search_form_query->get_posts();

		foreach($search_forms as $search_form)
		{
			$search_form_fields = $this->get_fields_meta($search_form->ID);

			foreach($search_form_fields as $key => $field)
			{
				$valid_filter_types = array("tag", "category", "taxonomy", "post_meta");

				if(in_array($field['type'], $valid_filter_types))
				{
					if(($field['type']=="tag")||($field['type']=="category")||($field['type']=="taxonomy"))
					{
						array_push($filters, "_sft_".$field['taxonomy_name']);
					}
					else if($field['type']=="post_meta")
					{
						if($field['meta_type']=="choice")
						{
							array_push($filters, "_sfm_".$field['meta_key']);
						}
					}
				}

			}
		}
		$filters = array_unique($filters);

		//now we have all the filters, get the filter terms/options

		$time_start = microtime(true);

		foreach($filters as $filter)
		{
			if($this->is_taxonomy_key($filter))
			{
				$source = "taxonomy";
			}
			else if($this->is_meta_value($filter))
			{
				$source = "post_meta";
			}

			$terms = $this->get_filter_terms($filter, $source);

			$filter_o = array("source"=>$source);

			foreach($terms as $term)
			{

				//echo $term->field_value." ";

				$term_ids = $this->get_cache_term_ids($filter, $term->field_value, $filter_o);
				//$save_term_ids = implode("," , $term_ids);

				$this->insert_term_results($filter, $term->field_value, $term_ids);

				//echo " ( ".count($term_ids)." ) , ";
			}
			//echo "</pre>";


		}

		$time_end = microtime(true);
		$total_time = $time_end - $time_start;

		//echo "========================<br />";
		//echo "Total time `get_all_filters`: $total_time seconds<br /><br />";


		return $filters;
	}

	public function insert_term_results($filter_name, $filter_value, $result_ids) {

		global $wpdb;

		$insert_data = array(
			'field_name' => $filter_name,
			'field_value' => $filter_value,
			'result_ids' => implode("," , $result_ids)
		);

		$wpdb->insert(
			$this->term_results_table_name,
			$insert_data
		);

	}
	public function get_cache_term_ids($filter_name, $filter_value, $filter) {

		global $wpdb;

		//test for speed

		$field_term_ids = array();

		$value_col = "field_value";
		if($filter['source']=="taxonomy")
		{
			$value_col = "field_value_num";
		}

		$field_terms_results = $wpdb->get_results( $wpdb->prepare( 
			"
			SELECT post_id, post_parent_id
			FROM $this->cache_table_name
			WHERE field_name = '%s'
				AND $value_col = '%s'
			",
			 $filter_name,
			 $filter_value
		) );

		/*
		global $searchandfilter;
		$sf_inst = $searchandfilter->get($sfid);

		//make sure this search form is tyring to use woocommerce
		if($sf_inst->settings("display_results_as")=="custom_woocommerce_store")
		{

		}
		$treat_child_posts_as_parent = (bool)$sf_inst->settings("treat_child_posts_as_parent");*/
		//$treat_child_posts_as_parent = false;

		foreach($field_terms_results as $field_terms_result)
		{

			array_push($field_term_ids, $field_terms_result->post_id);

		}

		return array_unique($field_term_ids);
	}


	public function get_filter_terms($field_name, $source) {

		global $wpdb;

		$field_col_select = "field_value";
		if($source=="taxonomy")
		{
			$field_col_select = "field_value_num as field_value";
		}

		$field_terms_result = $wpdb->get_results( $wpdb->prepare( 
			"
			SELECT DISTINCT $field_col_select
			FROM $this->cache_table_name
			WHERE field_name = '%s'
			",
			$field_name
		));

		return $field_terms_result;
	}
	public function setup_cached_search_forms()
	{
		$search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish,draft&posts_per_page=-1&suppress_filters=1');
		$search_forms = $search_form_query->get_posts();

		$this->cached_search_form_settings = array();
		$this->cached_search_form_fields = array();

		foreach($search_forms as $search_form)
		{
			$search_form_cache = $this->get_cache_meta($search_form->ID);

			//if(isset($search_form_cache['enabled']))
			//{
				//if($search_form_cache['enabled']==1)
				//{

					$search_form_settings = $this->get_settings_meta($search_form->ID);
					$search_form_fields = $this->get_fields_meta($search_form->ID);
					//then we have a search form with caching enabled

					array_push($this->cached_search_form_settings, $search_form_settings);
					array_push($this->cached_search_form_fields, $search_form_fields);
				//}

			//}
		}

		$this->calc_cache_data($this->cached_search_form_settings, $this->cached_search_form_fields);
	}
	public function calc_cache_data($search_form_settings, $search_form_fields)
	{
		$incl_post_types = array();
		$incl_meta_keys = array();
		$it = 0;

		//loop through each form, and get vars so we know what needs to be cached
		foreach($search_form_settings as $settings)
		{
			
			if($settings!="")
			{
				if(isset($settings['post_types']))
				{
					// post types
					$incl_post_types = array_merge(array_keys($settings['post_types']), $incl_post_types);

					if(isset($search_form_fields[$it]))
					{
						if(($search_form_fields[$it]))
						{

							foreach($search_form_fields[$it] as $search_form_field)
							{
								if($search_form_field['type']=="post_meta")
								{
									$is_single = true;

									if($search_form_field['meta_type']=="number")
									{
										if(isset($search_form_field['number_use_same_toggle']))
										{
											if($search_form_field['number_use_same_toggle']!=1)
											{
												array_push($incl_meta_keys, $search_form_field['number_end_meta_key']);
											}
										}

									}
									else if($search_form_field['meta_type']=="date")
									{
										if(isset($search_form_field['date_use_same_toggle']))
										{
											if($search_form_field['date_use_same_toggle']!=1)
											{
												array_push($incl_meta_keys, $search_form_field['date_end_meta_key']);
											}
										}
									}

									array_push($incl_meta_keys, $search_form_field['meta_key']);

								}
							}
						}
					}
				}
			}
			$it++;
		}


		$this->incl__post_types = array_unique($incl_post_types);
		$this->incl__meta_keys = array_unique($incl_meta_keys);

	}


	private function get_cache_meta($sfid)
	{

		$meta_key = '_search-filter-cache';


		//as we only want to update "enabled", then load all settings and update only this key
		$cache_settings = (get_post_meta( $sfid, $meta_key, true ));

		return $cache_settings;
	}
	private function get_settings_meta($sfid)
	{

		$meta_key = '_search-filter-settings';

		//as we only want to update "enabled", then load all settings and update only this key
		$search_form_settings = (get_post_meta( $sfid, $meta_key, true ));

		return $search_form_settings;
	}
	private function get_fields_meta($sfid)
	{

		$meta_key = '_search-filter-fields';

		//as we only want to update "enabled", then load all settings and update only this key
		$search_form_fields = (get_post_meta( $sfid, $meta_key, true ));

		return $search_form_fields;
	}

	public function post_meta_updated( $meta_id, $object_id, $meta_key, $meta_value  )
	{
		$post = get_post($object_id);
		$this->post_updated($post->ID, $post, false);
	}


	public function object_terms_updated( $postID, $terms, $taxonomy )
	{
		$post = get_post($postID);
		$this->post_updated($post->ID, $post, false);
	}

	public function attachment_updated( $form_fields, $post )
	{
		$this->post_updated($post->ID, $post, false);

		return $form_fields;
	}
	public function post_updated( $postID, $post, $update )
	{
		
		if( ! ( wp_is_post_revision( $postID ) && wp_is_post_autosave( $postID ) ) )
		{
			if($post->post_type!="search-filter-widget")
			{//then do some checks to see if we need to update the cache for this

				$this->setup_cached_search_forms();

				if(in_array($post->post_type, $this->incl__post_types))
				{
					$this->update_post_cache($postID, $post);
				}
			}
			else
			{//a Search & Filter form was updated...
				$this->check_cache_list_changed();
			}
		}

		//$end = microtime(true);
		//$tot = $end - $start;
	}

	private function check_cache_list_changed()
	{
		$restart_flag = false;

		$this->setup_cached_search_forms();

		$new_cache_data = array(
			"post_types" => $this->incl__post_types,
			"meta_keys" => $this->incl__meta_keys
		);

		$current_cache_data = $this->cache_options['caching_data'];
		//compare the new settings with the saved settings

		foreach($new_cache_data as $key => $value)
		{

			if((count($new_cache_data[$key]))==(count($current_cache_data[$key])))
			{
				if(is_array($value))
				{
					foreach($value as $cache_key)
					{
						if(!in_array($cache_key, $current_cache_data[$key]))
						{
							$restart_flag = true;
						}
					}
				}

			}
			else
			{
				$restart_flag = true;
			}

		}


		/*update_option( $this->option_name, $cache_options, false );

		$this->cache_options = $cache_options;

		var_dump($this->cache_options);*/

		if($restart_flag==true)
		{
			$this->cache_options['caching_data'] = $new_cache_data;
			$this->cache_options['restart'] = $restart_flag;
			update_option( $this->option_name, $this->cache_options, false );
		}
		else
		{//just trigger a rebuild of the terms - this should be done anytime someone changes a field which has terms (tag, cat, tax, meta)
			//need to improve to be "smarter"

			/*if($this->cache_options['status']!="inprogress")
			{// don't do anything if there it is already running, because the terms will be updated anyway when it finishes

				$this->cache_options['process_id'] = time();
				$this->cache_options['restart'] = false;
				$this->cache_options['status'] = "termcache";
				update_option( $this->option_name, $this->cache_options, false );
				$this->wp_remote_build_term_results(array("process_id" => $this->cache_options['process_id'])); //make new async request
			}*/

		}

	}


	public function update_post_cache($postID, $post = "", $update_term_cache = true)
	{
		global $wpdb;


		if($post=="")
		{
			$post = get_post($postID);
		}
		
		$this->post_delete_cache($postID, $post); //remove existing records from cache
		
		if(!$post)
		{
			return;
		}
		
		$post_type = $post->post_type;

		$fields_previous = array();

		$post_terms = $wpdb->get_results($wpdb->prepare( 
			"
			SELECT field_name, field_value, field_value_num
			FROM $this->cache_table_name
			WHERE post_id = '%d'
			",
			$postID
		));


		$cache_insert_array = array();

		//-----------------------
		//get taxonomy terms
		//$taxonomy_terms = ($this->get_post_taxonomy_terms($postID, $post));

		
		
		$tax_ins_count = $this->post_update_taxonomies($postID, $post); //add taxonomy data to the cache
		//$this->post_update_authors($postID, $post); //add taxonomy data to the cache
		//$this->post_update_post_types($postID, $post); //add taxonomy data to the cache
		$meta_ins_count = $this->post_update_post_meta($postID, $post); //add post_meta to the cache

		$total_insert_count = $tax_ins_count + $meta_ins_count;

		if($total_insert_count==0)
		{//then this post has no fields but should be able to still appear in unfiltered results - so add it to the index anyway

			$row_data = array(
				'post_id' => $postID,
				'post_parent_id' => $post->parent_id
			);

			$insert_data = array(
				'field_name' => '',
				'field_value' => ''
			);

			$insert_data = array_merge($row_data, $insert_data);
			//var_dump($insert_data);
			$wpdb->insert(
				$this->cache_table_name,
				$insert_data
			);

		}


		//echo $post_type;
		if($update_term_cache==false)
		{
			return;
		}


		$taxonomies_added = $this->get_post_taxonomy_terms_db_arr($postID, $post);
		$meta_added = $this->get_post_meta_terms_db_arr($postID, $post);

		$fields_added = array_merge($taxonomies_added, $meta_added);

		//var_dump($fields_added);

		//now get a list of all the fields in the DB

		if(count($post_terms)>0)
		{

			//is_taxonomy_key

			foreach ($post_terms as $post_term)
			{
				if(!isset($fields_previous[$post_term->field_name]))
				{
					$fields_previous[$post_term->field_name] = array();
				}

				$field_value = $post_term->field_value;
				if($this->is_taxonomy_key($post_term->field_name))
				{
					$field_value = $post_term->field_value_num;
				}

				array_push($fields_previous[$post_term->field_name], $field_value);
			}
		}

		//now we have 2 arrays $fields_added and $fields_previous

		//get a unique set of keys from the two of them
		//var_dump(array_unique(array_merge(array_keys($fields_previous), array_keys($fields_added))));

		$unique_keys = array_unique(array_merge(array_keys($fields_previous), array_keys($fields_added)));

		$field_differences = array();
		$combined_terms = array();

		foreach($unique_keys as $unique_key)
		{
			//if the keys are set in both, then merge them
			if((isset($fields_previous[$unique_key]))&&(isset($fields_added[$unique_key])))
			{ //we shoudl really check for differences in values and only update thos

				$combined_terms = array_unique(array_merge($fields_previous[$unique_key], $fields_added[$unique_key] ));
			}
			else if (isset($fields_previous[$unique_key]))
			{
				$combined_terms = $fields_previous[$unique_key];
			}
			else if (isset($fields_added[$unique_key]))
			{
				$combined_terms = $fields_added[$unique_key];
			}

			//push on to new array
			$field_differences[$unique_key] = $combined_terms;
		}

		foreach($field_differences as $filter => $terms)
		{
			$source = "";
			if($this->is_taxonomy_key($filter))
			{
				$source = "taxonomy";
			}
			else if($this->is_meta_value($filter))
			{
				$source = "post_meta";
			}

			if($source!="")
			{
				$filter_o = array("source"=>$source);

				foreach($terms as $term_value)
				{
					//echo $term_value." ";

					//delete existing value
					$wpdb->delete( $this->term_results_table_name, array(

						'field_name' => $filter,
						'field_value' => $term_value

					) );

					$term_ids = $this->get_cache_term_ids($filter, $term_value, $filter_o);
					//$save_term_ids = implode("," , $term_ids);

					$this->insert_term_results($filter, $term_value, $term_ids);

					//echo " ( ".count($term_ids)." ) , ";
				}
			}
		}
	}
	private function post_delete_cache($postID, $post){

		global $wpdb;

		$wpdb->delete( $this->cache_table_name, array( 'post_id' => $postID ) );
	}

	private function get_post_meta_terms_db_arr($postID, $post){

		//so we need to find out which meta keys are in use
		$insert_arr = array();

		foreach($this->incl__meta_keys as $meta_key)
		{

			$post_custom_values = get_post_custom_values($meta_key, $postID);


			if(is_array($post_custom_values))
			{
				$insert_arr["_sfm_".$meta_key] = array();

				foreach($post_custom_values as $post_custom_data)
				{
					if(is_serialized($post_custom_data))
					{
						$post_custom_data = unserialize($post_custom_data);

					}

					if(is_array($post_custom_data))
					{
						foreach($post_custom_data as $post_custom_value_a)
						{
							if(is_serialized($post_custom_value_a))
							{
								$post_custom_value_a = unserialize($post_custom_value_a);
							}

							if(is_array($post_custom_value_a))
							{
								foreach($post_custom_value_a as $post_custom_value_b)
								{
									array_push($insert_arr["_sfm_".$meta_key], $post_custom_value_b);
								}
							}
							else
							{
								array_push($insert_arr["_sfm_".$meta_key], $post_custom_value_a);
							}
						}
					}
					else
					{
						array_push($insert_arr["_sfm_".$meta_key], $post_custom_data);
					}

				}


			}
			/*$meta_value = get_post_meta($postID, $meta_key, true);

			if($meta_value!="")
			{
				$insert_arr["_sfm_".$meta_key] = array();


				if(!is_array($meta_value))
				{
					//then just add it to the array

					array_push($insert_arr["_sfm_".$meta_key], $meta_value);

				}
				else
				{
					//else loop through the array and add as value
					foreach($meta_value as $a_meta_value)
					{
						//if this is also an array, then something has gone wrong - its doubly nested, we don't want to cache this
						if(!is_array($a_meta_value))
						{
							array_push($insert_arr["_sfm_".$meta_key], $a_meta_value);
						}
						else
						{
							foreach($a_meta_value as $aa_meta_value)
							{
								array_push($insert_arr["_sfm_".$meta_key], $aa_meta_value);
							}
						}
					}
				}

			}*/
		}

		return $insert_arr;
	}
	private function post_update_post_meta($postID, $post){

		$insert_arr = $this->get_post_meta_terms_db_arr($postID, $post);

		//var_dump($this->incl__meta_keys);
		//now insert

		global $wpdb;

		$meta_insert_array = $insert_arr;

		$parent_id = 0;
		$wp_parent_id = wp_get_post_parent_id($postID);

		if($wp_parent_id)
		{
			$parent_id  = $wp_parent_id;
		}


		$row_data = array(
			'post_id' => $postID,
			'post_parent_id' => $parent_id
		);

		$meta_ins_count = 0;

		foreach($meta_insert_array as $field_name => $field_terms)
		{
			foreach($field_terms as $term_value)
			{
				$insert_data = array(
					'field_name' => $field_name,
					'field_value' => $term_value
				);

				$insert_data = array_merge($row_data, $insert_data);
				//var_dump($insert_data);
				$wpdb->insert(
					$this->cache_table_name,
					$insert_data
				);

				$meta_ins_count++;
			}

			//$insert_row_count++;
		}
		//exit;

		return $meta_ins_count;
	}
	private function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
				
				ob_start();
				var_dump($log);
				$result = ob_get_clean();

                error_log(  $result );
            } else {
                error_log( $log );
            }
        }
    }
	private function post_update_taxonomies($postID, $post){

		global $wpdb;
		
		$taxonomy_insert_array = $this->get_post_taxonomy_terms_db_arr($postID, $post);
		
		$parent_id = 0;
		$wp_parent_id = wp_get_post_parent_id($postID);

		if($wp_parent_id)
		{
			$parent_id  = $wp_parent_id;
		}


		$row_data = array(

			'post_id' => $postID,
			'post_parent_id' => $parent_id
		);

		$tax_ins_count = 0;

		foreach($taxonomy_insert_array as $field_name => $field_terms)
		{
			//find depth & parent of taxonomy term
			$taxonomy_name = "";
			if (strpos($field_name, SF_TAX_PRE) === 0)
			{
				$taxonomy_name = substr($field_name, strlen(SF_TAX_PRE));
			}
			
			foreach($field_terms as $term_id)
			{
				$term = get_term($term_id, $taxonomy_name);
				$term_parent_id = 0;
				// If there was an error, continue to the next term.
				if ( !is_wp_error( $term ) ) {
					$term_parent_id = $term->parent;
				}

				$insert_data = array(
					'field_name' 		=> $field_name,
					'field_value_num' 	=> $term_id,
					'term_parent_id' 	=> $term_parent_id

				);


				$insert_data = array_merge($row_data, $insert_data);
				
				$wpdb->insert(
					$this->cache_table_name,
					$insert_data
				);

				$tax_ins_count++;
			}

			//$insert_row_count++;
		}
		

		return $tax_ins_count;

	}

	private function get_post_taxonomy_terms_db_arr($postID, $post){

		$insert_arr = array();


		$post_type = $post->post_type;
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );


		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

			// get the terms related to post
			
			/*if(Search_Filter_Helper::has_wpml())
			{
				global $icl_adjust_id_url_filter_off;
				$icl_adjust_id_url_filter_off = true;
			}*/
			
			$terms = get_the_terms( $postID, $taxonomy_slug );
			
			/*if(Search_Filter_Helper::has_wpml())
			{
				$icl_adjust_id_url_filter_off = false;
			}*/
			
			$insert_arr["_sft_".$taxonomy_slug] = array();

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
					
					array_push($insert_arr["_sft_".$taxonomy_slug], $term_id);
				}
			}
		}

		return $insert_arr;

	}
	private function get_post_taxonomy_terms($postID, $post){

		$taxonomy_terms = array();

		//$taxonomy_terms
		$post_type = $post->post_type;
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		
		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

			// get the terms related to post
			$terms = get_the_terms( $postID, $taxonomy_slug );

			$taxonomy_terms[$taxonomy_slug] = array();

			if ( !empty( $terms ) ) {
				foreach ( $terms as $term ) {

					array_push($taxonomy_terms[$taxonomy_slug], $term->term_id);

				}
			}
		}
		
		return $taxonomy_terms;

	}


	private function custom_taxonomies_terms_links($postID){
		// get post by post id
		$post = get_post( $postID );

		// get post type by post
		$post_type = $post->post_type;

		// get post type taxonomies
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

		$out = array();
		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

			// get the terms related to post
			$terms = get_the_terms( $post->ID, $taxonomy_slug );

			if ( !empty( $terms ) ) {
				$out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
				foreach ( $terms as $term ) {
					/*$out[] =
						'  <li><a href="'
						.    get_term_link( $term->slug, $taxonomy_slug ) .'">'
						.    $term->name
						. "</a></li>\n";
					}
					$out[] = "</ul>\n";
					}*/
				}
			}

		return implode('', $out );
		}
	}

	public function is_meta_value($key)
	{
		if(substr( $key, 0, 5 )===SF_META_PRE)
		{
			return true;
		}
		return false;
	}

	public function is_taxonomy_key($key)
	{
		if(substr( $key, 0, 5 )===SF_TAX_PRE)
		{
			return true;
		}
		return false;
	}
}
