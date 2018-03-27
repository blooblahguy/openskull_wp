<?php

// additional image sizes
add_image_size( '120-thumb', 120, 120);
add_image_size( '300-thumb', 300, 300);
add_image_size( '640-thumb', 640, 640, true, array("left", "top"));

add_image_size( 'slide-image', 1200, 600, true, array("center", "top"));
add_image_size( 'slide-image-preview', 600, 300, true, array("center", "top"));

add_image_size( 'hero-image', 1040, 500, true, array("center", "top"));
add_image_size( 'hero-image-preview', 520, 250, true, array("center", "top"));

?>