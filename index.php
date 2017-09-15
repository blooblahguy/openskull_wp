<? 
get_header(); 
?>
<div class="container">
	<div class="pad20 os-md-9">
		<? if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
		
		<div class="post">
			<h4 class="post_title"><? the_title(); ?> <span class="post_date text-sm text-muted"><? the_date(); ?></span></h4>

			<? if (! $is_sub_cat) { ?> <div class="post_info"><? the_category(", "); ?></div> <? } ?>
			<div class="post_body">
				<? the_content(); ?>
			</div>
		</div>
	
		<? }} else { ?>
			<h2>Uh Oh</h2>
			<h5 class="em">Sorry, there are no posts for this category yet! <a href="/" class="text-muted">Back to Home</a></h5>
		<? } ?>
	</div>
	<div class="sidebar os-md-3">
		<? ?>
	</div>
</div>
<?
get_footer(); 
?>