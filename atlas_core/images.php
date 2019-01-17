<?php

// additional image sizes
add_image_size( 'hero-image', 1600, '', false);

// resize defaults
update_option( 'thumbnail_size_w', 160 );
update_option( 'thumbnail_size_h', 160 );

update_option( 'medium_size_w', 340 );
update_option( 'medium_size_h', 340 );

update_option( 'large_size_w', 1200 );
update_option( 'large_size_h', 1200 );

add_filter('intermediate_image_sizes', function($sizes) {
    return array_diff($sizes, ['medium_large']);
});
?>