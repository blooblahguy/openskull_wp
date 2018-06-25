<?php get_header(); ?>
	<? if ( have_posts() ) { ?>

		<? // lets get homepage templates in here
		if (( is_home() && is_front_page() ) ||(is_home() && ! is_front_page())) {
			// blog homepage, or home is 'default' posts
			get_template_part( 'template-parts/post', 'home');
		} ?>

		<?php
		// now pull in a post loop, eg. post.php, post-post.php, post-page.php
		$index = 0;
		while ( have_posts() ) { the_post(); $index++;
			if (is_page()) {
				// include page templates
				if ( ! is_home() && is_front_page() ) {
					get_template_part( 'template-parts/page', 'home' );
				} else {
					get_template_part( 'template-parts/page' );
				}

			} else {
				if (get_post_type() === 'post') {
					// include basic posts/search templates
					if (is_single()) {
						get_template_part( 'template-parts/post', 'single');
					} else {
						get_template_part( 'template-parts/post', get_post_format() );
					}
				} else {
					// include custom post types if needed
					
				}	
			} // end if page / post
		} //  end while have posts

		the_posts_navigation();
		?>
	<? } else {
		// nothing exists here (blank search or no content)
		get_template_part( 'template-parts/404' );
	} ?>


<?php get_footer(); ?>