<?php

////////////////////////////////////////////////
// Set Theme Support
////////////////////////////////////////////////
add_theme_support( 'title-tag' ); // have WP provide <title> tag
add_theme_support( 'post-thumbnails' ); // post thumbnails support
add_theme_support( 'customize-selective-refresh-widgets' ); // Add theme support for selective refresh for widgets.
remove_action('welcome_panel', 'wp_welcome_panel'); // remove welcome display that encourages users to break their perfectly good site
add_filter('xmlrpc_enabled', '__return_false'); // let's be a little more secure..
add_filter('widget_text','do_shortcode'); // Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode'); /* Allow shortcodes in widget areas */
add_theme_support( 'html5', array( // witch default core markup for search form, comment form, and comments to output valid HTML5.
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
));

add_action( 'wp_enqueue_scripts', 'atlas_scripts' ); //Enqueue scripts and styles.
function atlas_scripts() {
	wp_enqueue_script( 'atlas-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'atlas-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

?>