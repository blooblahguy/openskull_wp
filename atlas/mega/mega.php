<?php
	function mega_init() {
		global $wp_customize;
		$wp_customize->remove_panel( 'themes' );
		$wp_customize->remove_section( 'site_title' );
	}

?>