<? get_header(); ?>

<div id="primary" class="container">
	<header class="page-header">
		<?php if ( have_posts() ) { ?>
			<h1 class="page-title">Search Results for: <span><? echo get_search_query() ?></span></h1>
		<?php } else { ?>
			<h1 class="page-title">Nothing Found</h1>
		<?php } ?>
	</header><!-- .page-header -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) {
			while ( have_posts() ) { the_post(); ?>

				<div class="pad20 os-md-6">
					<a href="<? the_permalink(); ?>" class="result border block pad20"> 
						<span class="text-muted em"><? echo get_post_type(); ?> </span><span class="title"><? the_title() ?></span>
					</a>
				</div>
			<? } ?>
			<div class="clear"></div>
			<?
			the_posts_pagination( array(
				'prev_text' => "<",
				'next_text' => ">",
			//	'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );

		} else { ?>

			<p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
			<hr>
			<?php get_search_form(); ?>
		<? } ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
