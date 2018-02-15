<?php
////////////////////////////////////////////////
// ACF Auto Activation 
//////////////////////////////////////////////// 
add_filter('acf/settings/path', 'my_acf_settings_path');		// 1. customize ACF path
function my_acf_settings_path( $path ) {
    $path = get_stylesheet_directory() . '/atlas/acf/';
    return $path;
}

add_filter('acf/settings/dir', 'my_acf_settings_dir');			// 2. customize ACF dir
function my_acf_settings_dir( $dir ) {
    $dir = get_stylesheet_directory_uri() . '/atlas/acf/'; 
    return $dir;
}

add_filter('acf/settings/show_admin', '__return_false'); 		// 3. Hide ACF field group menu item
include_once( get_stylesheet_directory() . '/atlas/acf/acf.php' ); 	// 4. Include ACF

class AutoActivator {											// 5. Activate it with our pro key
	const ACTIVATION_KEY = 'b3JkZXJfaWQ9MTI0ODIyfHR5cGU9ZGV2ZWxvcGVyfGRhdGU9MjAxOC0wMi0xNCAxNjoyOTo0OQ==';

	public function __construct() {
		if (function_exists( 'acf' ) && is_admin() && !acf_pro_get_license_key() ) {
			acf_pro_update_license(self::ACTIVATION_KEY);
		}
	}
}
new AutoActivator();

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

// additional image sizes
add_image_size( '120-thumb', 120, 120);
add_image_size( '300-thumb', 300, 300);
add_image_size( '640-thumb', 640, 640, true, array("left", "top"));

add_image_size( 'slide-image', 1200, 600, true, array("center", "top"));
add_image_size( 'slide-image-preview', 600, 300, true, array("center", "top"));

add_image_size( 'hero-image', 1040, 500, true, array("center", "top"));
add_image_size( 'hero-image-preview', 520, 250, true, array("center", "top"));

////////////////////////////////////////////////
// Set Default Theme Elements
////////////////////////////////////////////////
// Default Menus
function register_my_menus() {
	register_nav_menus( array(
		'main_menu' => __( 'Main Menu' ),
		'sidebar_menu' => __( 'Sidebar Menu' ),
		'footer_menu' => __( 'Footer Menu' )
	));
}
add_action( 'init', 'register_my_menus' );

// Default Sidebars
function atlas_sidebars() {
	register_sidebar(
		array (
			'name' => 'Posts sidebar',
			'id' => 'atlas_sidebar-1',
			'before_widget' => '<div id="%1$s" class="widget content %2$s">',
			'after_widget' => "</div></div>",
			'before_title' => '<div class="title_container"><h3 class="title">',
			'after_title' => '</h3></div><div class="widget_content_outer">',
		)
	);
}
add_action( 'widgets_init', 'atlas_sidebars' );

////////////////////////////////////////////////
// Tweaks
////////////////////////////////////////////////
// optimize
add_action('init', function() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );                      // Category Feeds
	remove_action( 'wp_head', 'feed_links', 2 );                            // Post and Comment Feeds
	remove_action( 'wp_head', 'rsd_link' );                                 // EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );                         // Windows Live Writer
	remove_action( 'wp_head', 'index_rel_link' );                           // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );              // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );               // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );   // Links for Adjacent Posts
	remove_action( 'wp_head', 'wp_generator' );                             // WP version
	if (!is_admin()) {
		wp_deregister_script('jquery');                                     // De-Register jQuery
		wp_register_script('jquery', '', '', '', true);                     // Register as 'empty', because we manually insert our script in header.php
	}
});

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
	add_submenu_page("options-general.php", "Themes", "Themes", "administrator", "theme.php");
}

add_action( 'admin_menu', 'remove_menus');

// include tiny MCE editor css
add_editor_style('css/tinymce.css');
function add_editor_styles() {add_editor_style( 'css/tinymce.css' );}
add_action( 'admin_init', 'add_editor_styles' );
function plugin_mce_css( $mce_css ) {
	if ( !empty( $mce_css ) )
		$mce_css .= ',';
		$mce_css .= (get_stylesheet_directory() . '/css/tinymce.css');
		return $mce_css;
	}
add_filter( 'mce_css', 'plugin_mce_css' );
add_filter('show_admin_bar','__return_false'); // remove admin bar

function remove_footer_admin () {echo '<em>Theme developed by <a href="http://www.claypotcreative.com">Clay Pot Creative</a></em>';} // remove footer spam
add_filter('admin_footer_text', 'remove_footer_admin');

function wpb_remove_version() {return '';} // remove version number
add_filter('the_generator', 'wpb_remove_version');
remove_action('wp_head', 'wp_generator');

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets'); // add help link in dashboard
function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_help_widget', 'Wordpress Support', 'custom_dashboard_help');
}

function custom_dashboard_help() { // custom dashboard widget
	echo '<p>Need help? Contact us at <a href="http://www.claypotcreative.com">ClayPotCreative.com</a>.</p>';
}

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
	$theme_name = next( explode( '/themes/', get_stylesheet_directory() ));
	global $wp_rewrite;
	$atlas_new_non_wp_rules = array(
		'css/(.*)' => 'wp-content/themes/'.$theme_name.'/css/$1',
		'js/(.*)'  => 'wp-content/themes/'.$theme_name.'/js/$1',
		'img/(.*)' => 'wp-content/themes/'.$theme_name.'/img/$1',
	);
	$wp_rewrite->non_wp_rules += $atlas_new_non_wp_rules;
}

// add custom css into admin area
function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/wpadmin.css');
}
add_action('admin_enqueue_scripts', 'admin_style', 9999);

// Add ACF Options
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Site Wide Settings',
		'menu_title'	=> 'Site Wide Settings',
		'menu_slug' 	=> 'site-wide-settings',
		'icon_url'	 	=> "dashicons dashicons-slides",
	));
}

// gravity forms fix
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() { return true; }

// for including template files while passing variable scope
add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
	$GLOBALS['current_theme_template'] = basename($t);
	return $t;
}
function get_current_template( $echo = false ) {
	if( !isset( $GLOBALS['current_theme_template'] ) )
		return false;
	if( $echo )
		echo $GLOBALS['current_theme_template'];
	else
		return $GLOBALS['current_theme_template'];
}


////////////////////////////////////////////////
// Shortcodes
////////////////////////////////////////////////
add_shortcode( 'button', 'button_func' );
function button_func( $atts, $content = "" ) {
	$a = new SimpleXMLElement($content);

	$class = $a['class'];
	$target = $a['target'];
	$href = $a['href'];
	$rel = $a['rel'];
	$text = $a[0];
	return '<a href="'.$href.'" target="'.$target.'" rel="'.$rel.'" class="btn btn-primary '.$class.'">'.$text.'</a>';
}

add_shortcode('breadcrumb_simple', 'breadcrumb_simple');
function breadcrumb_simple() {
	global $post;
	$separator = '<span class="sep">></span>';
	
	echo '<div class="breadcrumb">';
	if (!is_front_page()) {
		echo '<a href="';
		echo get_option('home');
		echo '">';
		bloginfo('name');
		echo "</a> ".$separator;
		if ( is_category() || is_single() ) {
			the_category(', ');
			if ( is_single() ) {
				echo $separator;
				the_title();
			}
		} elseif ( is_page() && $post->post_parent ) {
			$home = get_page(get_option('page_on_front'));
			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
				if (($home->ID) != ($post->ancestors[$i])) {
					echo '<a href="';
					echo get_permalink($post->ancestors[$i]); 
					echo '">';
					echo get_the_title($post->ancestors[$i]);
					echo "</a>".$separator;
				}
			}
			echo '<a href="'.get_permalink().'">'.the_title('','',false).'</a>';
		} elseif (is_page()) {
			echo '<a href="'.get_permalink().'">'.the_title('','',false).'</a>';
		} elseif (is_404()) {
			echo "404";
		}
	} else {
		bloginfo('name');
	}
	echo '</div>';
}


/////////////////////////////////////////////////////////
// Theme functions for better display
/////////////////////////////////////////////////////////
function getYoutubeID($link) {
	$matches = array();
	
	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu‌​\.be\/|youtube\.com\‌​/(?:(?:watch)?\?(?:.‌​*&)?v(?:i)?=|(?:embe‌​d|v|vi|user)\/))([^\‌​?#&\"'>]+)/", $url, $matches);
	
	return $matches[1];
}

function getVimeoID($link) {
	return substr(parse_url($link, PHP_URL_PATH), 1);
}

function atlas_posted_on($link = true) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	if ($link) {
		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
	} else {
		$posted_on = $time_string;
	}
	echo '<span class="posted-on">' . $posted_on . '</span>';

}

function atlas_author($link = true) {
	if ($link) {
		$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';
	} else {
		$byline = '<span class="author vcard">'.esc_html( get_the_author() ) .'</span>';
	}

	echo '<span class="byline"> ' . $byline . '</span>';
}

function atlas_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) { ?>

		<div class="post_thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>

	<?php } else { ?>

		<a class="post_thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
			?>
		</a>

	<?php }
}

function atlas_categories($sep = ", ") {
	if ( 'post' === get_post_type() ) {
		$categories_list = get_the_category_list( $sep );
		if ( $categories_list ) {
			print_r($categories_list);
		}
	}
}

function atlas_tags() {
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'atlas' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'atlas' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
}

function atlas_comments() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'atlas' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}
}

function atlas_content($limit, $rm = "Read More &raquo;", $nl = false) {
	$content_stripped = strip_tags(get_the_content());
	$content = explode(' ', $content_stripped, $limit);

	if (count($content) >= $limit) {
		array_pop($content);
		$content = implode(" ", $content) . '... ';
		if (! $nl) {
			$content = $content.' <a href="'.get_the_permalink().'">'.$rm.'</a>';
		} else {
			$content = $content.'<br><br><a href="'.get_the_permalink().'">'.$rm.'</a>';
		}
	} else {
		$content = implode(" ", $content);
	}

	//$content = preg_replace('/\[.+\]/','', $content);
	//$content = apply_filters('the_content', $content); 
	//$content = str_replace(']]>', ']]&gt;', $content);

	return $content;
}

?>