<?php get_header(); ?>

	<div id="primary" class="container">
		<div class="os-md-9 main">
			<?php
			if ( have_posts() ) {
				if ( is_home() && ! is_front_page() ) { ?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
				<?php }

				/* Start the Loop */
				$index = 0;
				while ( have_posts() ) { the_post(); $index++;
					get_template_part( 'template-parts/content', get_post_format() );
				}

				the_posts_navigation();

			} else {

				get_template_part( 'template-parts/content', 'none' );

			} ?>
		</div>
		<aside id="secondary" class="widget-area os-md-3 sidebar">
			<?php dynamic_sidebar( 'atlas_sidebar-1' ); ?>
		</aside>
	</div>

<?php get_footer(); ?>