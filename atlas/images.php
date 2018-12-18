<?php

// additional image sizes
add_image_size( 'thumb-sm', 192, 192, true, array("left", "top"));
add_image_size( 'thumb-md', 384, 384, true, array("left", "top"));
add_image_size( 'thumb-lg', 768, 768, true, array("left", "top"));

add_image_size( 'slide-image', 1400, '', false);
add_image_size( 'slide-image-preview', 600, '', false);

add_image_size( 'hero-image', 1400, '', false);
add_image_size( 'hero-image-preview', 600, '', false);


// function cc_mime_types($mimes) {
// 	$mimes['svg'] = 'image/svg+xml';
// 	return $mimes;
// }
// add_filter('upload_mimes', 'cc_mime_types');
// function svg_meta_data($data, $id){
// 	$attachment = get_post($id); // Filter makes sure that the post is an attachment
// 	$mime_type = $attachment->post_mime_type; // The attachment mime_type

// 	if($mime_type == 'image/svg+xml'){

// 		//If the svg metadata are empty or the width is empty or the height is empty
// 		//then get the attributes from xml.
// 		if(empty($data) || empty($data['width']) || empty($data['height'])){

// 			$xml = simplexml_load_file(wp_get_attachment_url($id));
// 			$attr = $xml->attributes();
// 			$viewbox = explode(' ', $attr->viewBox);
// 			$data['width'] = isset($attr->width) && preg_match('/\d+/', $attr->width, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[2] : null);
// 			$data['height'] = isset($attr->height) && preg_match('/\d+/', $attr->height, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[3] : null);
// 		}
// 	}
// 	return $data;
// }
// add_filter('wp_update_attachment_metadata', 'svg_meta_data', 10, 2);

// function fix_svg() {
// 	echo '<style>
// 		td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail
// 		{ width: 100% !important; height: auto !important; }
// 	</style>
// 		';
// }
// add_action('admin_head', 'fix_svg');

?>