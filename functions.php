<?php
	// inclcude atlas core
	require_once("atlas_core/atlas.php");

	// Register Sidebars in Bulk
	$sidebars = array();

	foreach ($sidebars as $sidebar) {
		register_sidebar(array(
			"name" => $sidebar
			, "id" => sanitize_title($sidebar)
			, 'before_widget' => '<div id="%1$s" class="widget %2$s">'
			, 'after_widget' => '</div></div>'
			, 'before_title' => '<div class="title">'
			, 'after_title' => '</div><div class="content">'
		));
	}
	add_filter( 'dynamic_sidebar_params', 'check_sidebar_params' );
	function check_sidebar_params( $params ) {
		global $wp_registered_widgets;

		$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
		$settings = $settings_getter->get_settings();
		$settings = $settings[ $params[1]['number'] ];

		if ( $params[0][ 'after_widget' ] == '</div></div>' && isset( $settings[ 'title' ] ) && empty( $settings[ 'title' ] ) )
			$params[0][ 'before_widget' ] .= '<div class="content">';

		return $params;
	}
?>