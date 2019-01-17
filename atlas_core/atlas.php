<?php
ini_set("display_errors", 1);
error_reporting(E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);

require_once("helpers.php"); // smtp auto configuration
require_once("smtp.php"); // smtp auto configuration
require_once("theme_support.php"); // 
require_once("performance.php"); // 
require_once("images.php"); // 
require_once("search.php"); // 
// require_once("blocks/blocks.php"); // 
// require_once("mega/mega.php"); // 

// stop logged non admin users from accessing dashboard
add_action( 'admin_init', 'bdg_block_dashboard_access', 2 );
function bdg_block_dashboard_access() {
	if ( !current_user_can( 'admin_access' ) && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}


////////////////////////////////////////////////
// Set Default Theme Elements
////////////////////////////////////////////////
// Default Menus
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus( array(
		'main_menu' => 'Main Menu'
		, 'footer_menu' => 'Footer Menu'
	));
}

// tinymce css
add_filter('mce_css', 'plugin_mce_css');
function plugin_mce_css( $mce_css ) {
	if ( !empty( $mce_css ) ) {
		$mce_css .= ',';
		$mce_css .= (get_template_directory_uri() . '/css/editor_css.php');
		return $mce_css;
	}
}

add_filter('show_admin_bar','__return_false'); // remove admin bar
add_filter('admin_footer_text', '__return_false'); // remove footer text
add_filter('the_generator', '__return_false'); // remove version #
remove_action('wp_head', 'wp_generator');

function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_help_widget', 'Wordpress Support', 'custom_dashboard_help');
	remove_meta_box('dashboard_quick_press','dashboard','side'); //Quick Press widget
	remove_meta_box('dashboard_recent_drafts','dashboard','side'); //Recent Drafts
	remove_meta_box('dashboard_primary','dashboard','side'); //WordPress.com Blog
	remove_meta_box('dashboard_secondary','dashboard','side'); //Other WordPress News
	remove_meta_box('dashboard_incoming_links','dashboard','normal'); //Incoming Links
	remove_meta_box('dashboard_plugins','dashboard','normal'); //Plugins
	remove_meta_box('dashboard_right_now','dashboard', 'normal'); //Right Now
	remove_meta_box('rg_forms_dashboard','dashboard','normal'); //Gravity Forms
	remove_meta_box('dashboard_recent_comments','dashboard','normal'); //Recent Comments
	remove_meta_box('icl_dashboard_widget','dashboard','normal'); //Multi Language Plugin
	remove_meta_box('dashboard_activity','dashboard', 'normal'); //Activity
	remove_action('welcome_panel','wp_welcome_panel');
}
function custom_dashboard_help() { // custom dashboard widget
	echo '<p>Need help? Contact us at <a href="http://www.claypotcreative.com">ClayPotCreative.com</a>.</p>';
}
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets'); // add help link in dashboard


function goodbye_dolly() { // remove hello dolly...
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
	$theme_info = explode( '/themes/', get_stylesheet_directory());
	$theme_name = end( $theme_info );
	global $wp_rewrite;
	$atlas_new_non_wp_rules = array(
		'css/(.*)' => 'wp-content/themes/'.$theme_name.'/css/$1',
		'js/(.*)'  => 'wp-content/themes/'.$theme_name.'/js/$1',
		'img/(.*)' => 'wp-content/themes/'.$theme_name.'/img/$1',
		'lib/(.*)' => 'wp-content/themes/'.$theme_name.'/lib/$1',
	);
	$wp_rewrite->non_wp_rules += $atlas_new_non_wp_rules;
}

// add custom css into admin area
function admin_style() {
	wp_enqueue_style('admin-styles', '/css/admin_css.php');
}
add_action('admin_enqueue_scripts', 'admin_style', 9999);

// gravity forms fix
add_filter("gform_init_scripts_footer", "__return_true");

// for including template files while passing variable scope
add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
	$GLOBALS['current_theme_template'] = basename($t);
	return $t;
}

// pulls id out of youtube url
function getYoutubeID($link) {
	$matches = array();
	
	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu‌​\.be\/|youtube\.com\‌​/(?:(?:watch)?\?(?:.‌​*&)?v(?:i)?=|(?:embe‌​d|v|vi|user)\/))([^\‌​?#&\"'>]+)/", $url, $matches);
	
	return $matches[1];
}

// pulls id out of vimeo url
function getVimeoID($link) {
	return substr(parse_url($link, PHP_URL_PATH), 1);
}

// Removed wordpress logo on top bar
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );
function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'collapse-menu' );
}

// Collapses sidebar at all times
// add_action( 'admin_head', 'wpdocs_always_collapse_menu' );
function wpdocs_always_collapse_menu() {
    if ( 'f' != get_user_setting( 'mfold' ) ) {
        set_user_setting( 'mfold', 'f' );
    }
}

?>