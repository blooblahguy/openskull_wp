<?php
$debug = false;
if ($_SERVER['SERVER_NAME'] == 'localhost') { // development
	$debug = true;
}
function debug(...$params) {
	foreach ($params as $p) {
		echo "<pre>";
		print_r($p);
		echo "</pre>";
	}
}

// our mega widget
include("theme_support.php"); // our page layout editor
include("performance.php"); // our page layout editor
include("images.php"); // our page layout editor
include("search.php"); // our page layout editor
include("acf_autoload.php"); // our page layout editor
include("mega/mega.php"); // our page layout editor


////////////////////////////////////////////////
// Set Default Theme Elements
////////////////////////////////////////////////
// Default Menus
function register_my_menus() {
	register_nav_menus( array(
		'main_menu' => 'Main Menu'
		, 'sidebar_menu' => 'Sidebar Menu'
		, 'footer_menu' => 'Footer Menu'
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



function plugin_mce_css( $mce_css ) {
	if ( !empty( $mce_css ) ) {
		$mce_css .= ',';
		$mce_css .= (get_template_directory_uri() . '/css/tinymce.css');
		return $mce_css;
	}
}
add_filter('mce_css', 'plugin_mce_css');
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

// gravity forms fix
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() { return true; }

// for including template files while passing variable scope
add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
	$GLOBALS['current_theme_template'] = basename($t);
	return $t;
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


add_action('admin_head', function() {
	echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/atlas/css/admin_css.php">';
});

add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );
function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'collapse-menu' );
}

function wpdocs_always_collapse_menu() {
    if ( 'f' != get_user_setting( 'mfold' ) ) {
        set_user_setting( 'mfold', 'f' );
    }
}
// add_action( 'admin_head', 'wpdocs_always_collapse_menu' );

?>