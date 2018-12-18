<?php get_header(); ?>
	<? if ( have_posts() ) { ?>
		<? // lets get homepage templates in here
		if (( is_home() && is_front_page() ) || (is_home() && ! is_front_page()) || is_archive()) {
			// blog homepage, or home is 'default' posts
			if (is_archive()) {
				get_template_part( 'template-parts/home', get_post_type());
			} else {
				get_template_part( 'template-parts/home', 'post');
			}
		} else {
			// now pull in a post loop, eg. post.php, post-post.php, post-page.php
			$index = 0;
			while ( have_posts() ) { the_post(); $index++;
				if (is_page()) {
					// include page templates
					if ( ! is_home() && is_front_page() ) {
						get_template_part( 'template-parts/home', 'page' );
					} else {
						if (locate_template(array("template-parts/page-".$post->post_name.".php"))) {
							get_template_part( 'template-parts/page', $post->post_name );
						} else {
							get_template_part( 'template-parts/page' );
						}
					}
				} else {
					if (get_post_type() === 'post') {
						// include basic posts/search templates
						if (is_single()) {
							get_template_part( 'template-parts/single', 'post');
						} else {
							get_template_part( 'template-parts/single', get_post_format());
						}
					} else {
						// include custom post types if needed
						get_template_part( 'template-parts/single', get_post_type());
					}	
				} // end if page / post
			} //  end while have posts

			the_posts_navigation();
		}
	} else {
		// attempt to query 
		// nothing exists here (blank search or no content)
		get_template_part( 'template-parts/404' );
	} ?>


<?php get_footer(); ?>