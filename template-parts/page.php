<? get_template_part("template-parts/page", "title"); ?>

<div class="page_content_outer">
	<article id="page-<?php the_ID(); ?>" class="page_content">
		<div class="container">
			<? the_content(); ?>
		</div>
		<? get_template_part("template-parts/content", "mega"); ?>
	</article>
</div>
