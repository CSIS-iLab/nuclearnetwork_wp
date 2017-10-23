<?php
/**
 * Extend the WP Rest API to add a new route for guest authors.
 *
 * @package Nuclear_Network
 */
class NuclearNetwork_Rest_Routes extends WP_REST_Controller {

	var $namespace = 'guest-author/v';
	var $version   = '1';

	public function register_routes() {
		$namespace = $this->namespace . $this->version;
		$base      = 'email';
		register_rest_route( $namespace, '/' . $base, array(
			array(
				'methods'         => WP_REST_Server::READABLE,
				'callback'        => array( $this, 'get_author_info' ),
			),
		) );
	}

	/**
	 * Register REST route.
	 */
	public function hook_rest_server() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Get the author's information from the provided email.
	 *
	 * @param  WP_REST_Request $request Request object.
	 * @return json                   Post array.
	 */
	public function get_author_info( WP_REST_Request $request ) {
		$email = $request->get_param( 'email' );
		$args = array(
			'post_type'     => 'guest-author',
			'meta_query' => array(
				array(
					'key' => 'cap-user_email',
					'value' => $email,
				),
			),
		);

		$results = new WP_Query( $args );

		if ( ! $results->have_posts() ) {
			return null;
		}

		// Get biography field.
		$biography = get_post_meta( $results->posts[0]->ID, 'cap-description', true );
		$results->posts[0]->biography = $biography;

		return $results->posts[0];
	}

}

$nuclearnetwork_rest = new NuclearNetwork_Rest_Routes();
$nuclearnetwork_rest->hook_rest_server();
