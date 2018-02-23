<? if ($_SERVER['SERVER_NAME'] == 'localhost') { echo basename(__FILE__); } ?>


<?php 
$first = false;
if( $wp_query->current_post == 0 && !is_paged() ) {
	$first = "first";
} ?>

<div class="article_outer">

	<article id="post-<?php the_ID(); ?>" <?php post_class(array('container', 'row', 'entry', $first)); ?>>
		<? if (! $first) { ?>
			<?php atlas_post_thumbnail(); ?>
		<? } ?>


		<header class="entry_header">
			<?php if ( 'post' === get_post_type() ) { ?>
				<div class="entry_meta">
					<span class="entry_date"><? atlas_posted_on(false); ?></span>
					<span class="entry_author">By <? atlas_author(false); ?></span>
				</div>
			<? } ?>
			
			<?php
			if ( is_singular() ) {
				the_title( '<h1 class="entry_title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry_title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			} ?>

			<?php if ( 'post' === get_post_type() && $first ) { ?>
				<div class="entry_categories">
					<?php atlas_categories(' '); ?>
				</div>
			<?php } ?>
		</header>

		<? if ($first) { ?>
			<?php atlas_post_thumbnail(); ?>
		<? } ?>

		<div class="entry_content">
			<?php if( $wp_query->current_post == 0 && !is_paged() ) {
				echo atlas_content(50, "Continue Reading...", true);
			} else {
				echo atlas_content(20);
			} ?>
		</div>

		<?php if ( 'post' === get_post_type() && ! $first ) { ?>
			<div class="entry_categories">
				<?php atlas_categories(' '); ?>
			</div>
		<?php } ?>

	</article>

</div>