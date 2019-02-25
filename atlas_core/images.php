<?php

// additional image sizes
add_image_size( 'hero-image', 1600, '', false);

add_filter('intermediate_image_sizes', function($sizes) {
    return array_diff($sizes, ['medium_large']);
});

?>