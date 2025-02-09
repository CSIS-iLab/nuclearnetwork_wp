<?php

/**
 * Nuclear Network Custom Blocks
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

function nuclearnetwork_keep_plugins_blocks( $allowed_block_types, $post ) {

	if ( $post->post_type !== 'post' ) {
		return $allowed_block_types;
	}

	// get widget blocks and registered by plugins blocks
	$registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

	// in case we do not need widgets
	unset( $registered_blocks[ 'core/latest-comments' ] );
	unset( $registered_blocks[ 'core/archives' ] );
	unset( $registered_blocks[ 'core/categories' ] );
	unset( $registered_blocks[ 'core/latest-posts' ] );
	unset( $registered_blocks[ 'core/calendar' ] );
	unset( $registered_blocks[ 'core/rss' ] );
	unset( $registered_blocks[ 'core/search' ] );
	unset( $registered_blocks[ 'core/tag-cloud' ] );


	// now $registered_blocks contains only blocks registered by plugins, but we need keys only
	$registered_blocks = array_keys( $registered_blocks );

	// merge the whitelist with plugins blocks
	return array_merge( array(
		// 'core/image',
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/gallery',
		'core/table',
		'core/freeform',
		'core/html',
		'core/shortcode'
	), $registered_blocks );

}

add_filter( 'allowed_block_types', 'nuclearnetwork_keep_plugins_blocks', 10, 2 );

// Add `csis-block` class to all blocks
function nuclearnetwork_lzb_block_render_attributes( $attributes, $content, $block, $context ) {
		$attributes['className'] .= 'csis-block';

    return $attributes;
}

add_filter( 'lzb/block_render/attributes', 'nuclearnetwork_lzb_block_render_attributes', 10, 4 );


// Set Aside size class if Image is aligned to left or right
function nuclearnetwork_lzb_block_post_image_render_attributes( $attributes, $content, $block, $context ) {
	if ($attributes['align'] === 'left' || $attributes['align'] === 'right') {
		$attributes['className'] .= ' csis-block--' . $attributes['aside-size'];
	}

	return $attributes;
}

add_filter( 'lazyblock/post-image/attributes', 'nuclearnetwork_lzb_block_post_image_render_attributes', 10, 4 );


// Create Handlebars Helper for Images
function nuclearnetwork_lazyblock_handlebars_helper_img ( $handlebars ) {

  $handlebars->registerHelper('display-img', function($img) {
		$srcset = wp_get_attachment_image_srcset($img['id']);
		$info = wp_get_attachment_image_src($img['id'], 'large');
		// $width = $info['width'];
		$width = $info[1];

		return '<img src="' . $img['url'] . '" alt="' . $img['alt'] . '" class="wp-image-' . $img['id'] . '" srcset="' . $srcset . '" sizes="(max-width: ' . $width . 'px) 100vw, ' . $width . 'px" />';

	});
}
add_action( 'lzb/handlebars/object', 'nuclearnetwork_lazyblock_handlebars_helper_img' );

// Create Handlebars Helper for Image Source
function nuclearnetwork_lazyblock_handlebars_helper_img_source ( $handlebars ) {

  $handlebars->registerHelper('img-source', function($img) {
		$source = get_field('source', $img['id']);

		if ( !$source ) {
			return;
		}

		return '<span class="caption__source">' . $source . '</span>';

	});
}

add_action( 'lzb/handlebars/object', 'nuclearnetwork_lazyblock_handlebars_helper_img_source' );


