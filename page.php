<?php

get_header(); ?>

	<div id="primary" class="container">
		<?php
		if (is_front_page()) {
			get_template_part( 'template-parts/content', 'home' );
		} else {
			while ( have_posts() ) { the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				};

			} // End of the loop.
		}
		?>

	</div><!-- #primary -->

<?php
get_footer();
