<?php 
// Default Menus
function register_my_menus() {
	register_nav_menus( array(
		'main_menu' => __( 'Main Menu' ),
		'sidebar_menu' => __( 'Sidebar Menu' ),
		'footer_menu' => __( 'Footer Menu' )
	));
}
add_action( 'init', 'register_my_menus' );

// Default Sidebar
function atlas_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Custom', 'atlas_sidebar' ),
            'id' => 'atlas_sidebar-1',
            'description' => __( 'Custom Sidebar', 'atlas_sidebar' ),
            'before_widget' => '<div class="widget content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'atlas_sidebar' );

/*-------------------------------------------------------
	TWEAKS
--------------------------------------------------------*/
// Remove things from the admin sidebar that will let them break the site
function remove_menus(){
	if (!is_super_admin()) {
		//remove_menu_page('index.php'); // dashboard
		remove_menu_page('edit-comments.php'); // comments
		remove_menu_page('tools.php'); // tools
	}
	remove_menu_page('cptui_manage_post_types');
	remove_menu_page('themes.php'); // appearance
	// move the useful parts of appearance out
	add_menu_page("Widgets", "Widgets", "administrator", "widgets.php", '', 'dashicons-welcome-widgets-menus', 21);
	add_menu_page("Menus", "Menus", "administrator", "nav-menus.php", '', 'dashicons-menu', 20);
}

add_action( 'admin_menu', 'remove_menus');

// include tiny MCE editor css
function add_editor_styles() {add_editor_style( 'tinymce.css' );}
add_action( 'admin_init', 'add_editor_styles' );

// remove admin bar
add_filter('show_admin_bar','__return_false');

// addition image sizes
add_image_size( '120-thumb', 120, 120, false);
add_image_size( '200-thumb', 200, 200, false);
add_image_size( '500-thumb', 500, 500, false);

// remove welcome display that encourages users to break their perfectly good site
remove_action('welcome_panel', 'wp_welcome_panel');

// let's be a little more secure..
add_filter('xmlrpc_enabled', '__return_false');

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');

// remove footer spam
function remove_footer_admin () {echo '<em>Theme developed by <a href="http://www.claypotcreative.com">Clay Pot Creative</a></em>';}
add_filter('admin_footer_text', 'remove_footer_admin');

// remove version number
function wpb_remove_version() {return '';}
add_filter('the_generator', 'wpb_remove_version');
remove_action('wp_head', 'wp_generator');

// add help link in dashboard
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_help_widget', 'Wordpress Support', 'custom_dashboard_help');
}

// custom dashboard widget
function custom_dashboard_help() {
	echo '<p>Need help? Contact us at <a href="http://www.claypotcreative.com">ClayPotCreative.com</a>.</p>';
}

// remove hello dolly... (i mean seriously)
function goodbye_dolly() {
    if (file_exists(WP_PLUGIN_DIR.'/hello.php')) {
        require_once(ABSPATH.'wp-admin/includes/plugin.php');
        require_once(ABSPATH.'wp-admin/includes/file.php');
        delete_plugins(array('hello.php'));
    }
}
add_action('admin_init','goodbye_dolly');


// we do this in htaccess, but we're gonna do it here so that we don't have to copy that every time
// credit to roots theme
add_action( 'generate_rewrite_rules', 'atlas_add_rewrites' );
function atlas_add_rewrites($content) {
	$theme_name = next( explode( '/themes/', get_stylesheet_directory() ));
	global $wp_rewrite;
	$atlas_new_non_wp_rules = array(
		'css/(.*)' => 'wp-content/themes/'.$theme_name.'/css/$1',
		'js/(.*)'  => 'wp-content/themes/'.$theme_name.'/js/$1',
		'img/(.*)' => 'wp-content/themes/'.$theme_name.'/img/$1',
	);
	$wp_rewrite->non_wp_rules += $atlas_new_non_wp_rules;
}

?>