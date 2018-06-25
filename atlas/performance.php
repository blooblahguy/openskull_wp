<?php

////////////////////////////////////////////////
// Tweaks
////////////////////////////////////////////////
// optimize

	remove_action( 'wp_head', 'feed_links_extra', 3 );                      // Category Feeds
	remove_action( 'wp_head', 'feed_links', 2 );                            // Post and Comment Feeds
	remove_action( 'wp_head', 'rsd_link' );                                 // EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );                         // Windows Live Writer
	remove_action( 'wp_head', 'index_rel_link' );                           // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );              // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );               // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );   // Links for Adjacent Posts
	remove_action( 'wp_head', 'wp_generator' );                             // WP version
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
	remove_action('wp_head', 'rel_canonical');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

	if (! is_admin()) {
		wp_deregister_script('jquery');                                     // De-Register jQuery
		wp_register_script('jquery', '', '', '', true);                     // Register as 'empty', because we manually insert our script in header.php
	}


// Remove things from the admin sidebar that will let them break the site
function remove_menus(){
	if (!is_super_admin()) {
		remove_menu_page('index.php'); // dashboard
		remove_menu_page('tools.php'); // tools
	}
	remove_menu_page('edit-comments.php'); // comments
	remove_menu_page('cptui_manage_post_types');
	remove_menu_page('themes.php'); // appearance
	remove_menu_page('edit-comments.php'); // comments
	// move the useful parts of appearance out to other locations
	add_menu_page("Widgets", "Widgets", "administrator", "widgets.php", '', 'dashicons-welcome-widgets-menus', 21);
	add_menu_page("Menus", "Menus", "administrator", "nav-menus.php", '', 'dashicons-menu', 20);
	add_submenu_page("options-general.php", "Themes", "Themes", "administrator", "themes.php");
	add_submenu_page("options-general.php", "Custom Fields", "Custom Fields", "administrator", "edit.php?post_type=acf-field-group");
}
add_action( 'admin_menu', 'remove_menus');

?>