<?php get_header(); ?>

	<div id="primary" class="container">
		<main id="main" class="site-main container">

		<?php
		if ( have_posts() ) { ?>

			<header class="page-header">
				<h1 class="page-title"><?php
					printf( 'Search Results for: %s', '<span>' . get_search_query() . '</span>' );
				?></h1>
			</header>

			<?php
			while ( have_posts() ) { the_post();
				get_template_part( 'template-parts/content', 'search' );
			}

			the_posts_navigation();

		} else {
			get_template_part( 'template-parts/content', 'none' );
		} ?>

		</main>
	</div>

<?php
get_footer();
