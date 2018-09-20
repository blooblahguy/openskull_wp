<?php
	////////////////////////////////////////////////
	// ACF Auto Activation 
	//////////////////////////////////////////////// 
	/*
	add_filter('acf/settings/load_json', 'my_acf_json_load_point');
	function my_acf_json_load_point( $paths ) {
		unset($paths[0]);
		$paths[] = get_template_directory() . '/atlas/acf_json';
		return $paths;
	}
	$acf_key = 'b3JkZXJfaWQ9MTI0ODIyfHR5cGU9ZGV2ZWxvcGVyfGRhdGU9MjAxOC0wMi0xNCAxNjoyOTo0OQ==';
	// 1. customize ACF path
	add_filter('acf/settings/path', 'my_acf_settings_path');
	function my_acf_settings_path( $path ) {
		$path = get_stylesheet_directory() . '/atlas/acf/';
		return $path;
	}
	// 2. customize ACF dir
	add_filter('acf/settings/dir', 'my_acf_settings_dir');
	function my_acf_settings_dir( $dir ) {
		$dir = get_stylesheet_directory_uri() . '/atlas/acf/'; 
		return $dir;
	}
	// 3. Hide ACF field group menu item
	add_filter('acf/settings/show_admin', '__return_false');
	// 4. Include ACF
	include_once( get_stylesheet_directory() . '/atlas/acf/acf.php' ); 
	// 5. Activate pro key
	if (function_exists( 'acf' ) && is_admin() && !acf_pro_get_license_key() ) {
		acf_pro_update_license($acf_key);
	}
	
	*/
	
	// Add ACF Options
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page(array(
			'page_title' 	=> 'Site Wide Content',
			'menu_title'	=> 'Site Wide Content',
			'menu_slug' 	=> 'site-wide-content',
			'icon_url'	 	=> "dashicons-tablet",
		));
	}
	
?>