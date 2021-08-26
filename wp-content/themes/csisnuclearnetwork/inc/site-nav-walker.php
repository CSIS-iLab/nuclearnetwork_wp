<?php
/**
 * Custom walker for main navigation
 *
 * @package Nuclear Network
 */

class NuclearNetwork_Menu extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
				// Only show the featured content if we have a URL.
        if ( $args->has_featured === true && $args->featured_post ) {
          $featured_post_id = $args->featured_post[0]->ID;
            $title = get_the_title($featured_post_id);
            $permalink = get_permalink($featured_post_id);
            $thumbnail = get_the_post_thumbnail_url($featured_post_id);
            $post_type = get_post_type($featured_post_id);

            
            if ( function_exists( 'coauthors' ) ) {
              $authors = coauthors_posts_links( ', ', ',&nbsp', null, null, false );
            } else {
              $authors = the_author_posts_link();
            }
            $author_list = '<div class="site-nav__feat-post-authors text--bold">' . $authors . '</div>';

            if ( !$authors || in_array( $post_type, array( 'events', 'programs', 'projects' ) ) ) {
              $author_list = '';
            }
            
            $featured_post_html = '<div class="site-nav__feat-post-terms-type text--bold">Featured</div>
            <a href="' . esc_url ( $permalink ) . '" class="site-nav__feat-post-title text--bold">' . $title . '</a>' .
            $author_list . '
            <div class="site-nav__feat-post-thumbnail"><a href="' . esc_url ( $permalink ) . '"> <img src="' . esc_url ( $thumbnail ) . '"></a></div>';
          }

        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='submenu-container row'>
            <div class='hidden-xs col-md-4 submenu-featured-post'>
                " . $featured_post_html . "
            </div>\n
            <div class='col-xs-12 col-md submenu-children'>\n
                <ul class='sub-menu'>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n
            </div>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $args->parent_title = $item->title;

        $args->has_featured = false;
        
        if (in_array('nav-menu__has-featured', $item->classes)) {
          $args->featured_post = get_field('featured_post_main_menu', $args->menu);
          $args->has_featured = true;
        }

        // var_dump($args);

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li' . $id . $class_names . '>';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $item_output = $args->before;
        if ( $args->walker->has_children && $depth == 0 ) {
          $item_output .= '<button>' . $attributes;
          $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
          $item_output .= '</button>';
        } else {
          $item_output .= '<a'. $attributes .'>';
          $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
          $item_output .= '</a>';
        }
        $item_output .= '';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}
