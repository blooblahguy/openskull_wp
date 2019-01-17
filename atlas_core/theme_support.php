<?php

////////////////////////////////////////////////
// Set Theme Support
////////////////////////////////////////////////
add_theme_support( 'title-tag' ); // have WP provide <title> tag
add_theme_support( 'post-thumbnails' ); // post thumbnails support
add_theme_support( 'customize-selective-refresh-widgets' ); // Add theme support for selective refresh for widgets.
add_filter('xmlrpc_enabled', '__return_false'); // let's be a little more secure..
add_filter('widget_text','do_shortcode'); // Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode'); /* Allow shortcodes in widget areas */
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

add_theme_support( 'html5', array( // witch default core markup for search form, comment form, and comments to output valid HTML5.
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
));

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// add page slug to body classes - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}
add_filter('body_class', 'add_slug_to_body_class');

?>