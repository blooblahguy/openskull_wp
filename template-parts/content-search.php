<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Atlas
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('entry', 'border', 'pad20', 'row', 'search')); ?>>
	<?php atlas_post_thumbnail(); ?>

	<header class="entry-header">
		<?php the_title( sprintf( '<h4 class="entry_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		
		<?php endif; ?>
	</header><!-- .entry-header -->


	<div class="entry-summary">
		<?php echo atlas_content(20); ?>
		<div class="entry-meta">
			<?php atlas_posted_on(); ?>
		</div><!-- .entry-meta -->
	</div><!-- s.entry-summary -->

	<!-- <footer class="entry-footer">
		<?php //atlas_entry_footer(); ?>
	</footer> -->
</article><!-- #post-<?php the_ID(); ?> -->
