<section class="no-results not-found container padtb4 text-center">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'atlas' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<div class="row content-center">
			<div class="os os-md-6">
			
				<?php if ( is_search() ) { ?>

					<p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
					<?php get_search_form();
				} else { ?>

					<p>It seems we can't find what you're looking for. Perhaps searching can help.</p>
					<?php get_search_form();
				} ?>
			</div>
		</div>
	</div><!-- .page-content -->
</section><!-- .no-results -->
