<?php
	add_action( 'customize_register', 'mega_init' );
	function mega_init() {
		global $wp_customize;
		$wp_customize->remove_panel( 'themes' );
		$wp_customize->remove_section( 'site_title' );
	}

	// add_action( 'acf/init', 'nd_acf_add_local_field_groups' );
/**
 * Add Advanced Custom Fields programatically (Flexible Content field).
 *
 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * @link https://support.advancedcustomfields.com/forums/topic/register-two-locations-via-php-doesnt-work/
 * @link https://support.advancedcustomfields.com/forums/topic/adding-additional-layout-to-flexible_content-field-in-child-theme/
 *
 * @return void
 */
// function nd_acf_add_local_field_groups() {
	
function my_acf_add_local_field_groups() {
	
	acf_add_local_field_group(array(
		'key' => 'group_1',
		'title' => 'My Group',
		'fields' => array (
			array (
				'key' => 'field_1',
				'label' => 'Sub Title',
				'name' => 'sub_title',
				'type' => 'text',
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
	));
	
}

add_action('acf/init', 'my_acf_add_local_field_groups');
	
// }

?>