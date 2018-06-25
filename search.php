<?php get_header(); ?>

	<div id="primary" class="container">
		<main id="main" class="site-main container padtb4">
			<?php
			if ( have_posts() ) { ?>
				<div class="row text-center content-center">
					<div class="os os-md-6">
						<header class="page-header">
							<h1 class="page-title"><?php
								printf( 'Search Results for: %s', '<span>' . get_search_query() . '</span>' );
							?></h1>
						</header>
						<?php get_search_form(); ?>
					</div>
				</div>

				<hr>

				<?php
				while ( have_posts() ) { the_post();
					get_template_part( 'template-parts/search', 'result' );
				}

				the_posts_navigation();

			} else {
				get_template_part( 'template-parts/404' );
			} ?>

		</main>
	</div>

<?php
get_footer();
?>