<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}
if (! comments_open() && ! get_comments_number() ) {
	return;
}
?>
<div id="comments" class="comments-area section dark">
	<?php //the_comments_navigation(); ?>
	<div class="post_nav row">
		<div class="os">
			<? previous_post_link(); ?>
		</div>
		<div class="os text-right">
			<? next_post_link(); ?>
		</div>
	</div>
	<?php if ( have_comments() ) { ?>
		<h3>Discussion</h3>
		<div class="comment-list ">
			<?php
			function comment_display($comment, $args, $depth) { 
				$author_id = $comment->user_id;
				$class = getClassFromUser($author_id);
				?>

				<div id="comment-<?php comment_ID() ?>" class="comment row">
					<div class="os-min avatar"><? echo get_avatar( $comment, 24 ); ?></div>
					<div class="os-min datetime"><? echo get_comment_time(); ?></div>
					<div class="os-min name <? echo $class; ?>"><? echo get_comment_author(); ?></div>
					<div class="os message"><? comment_text(); ?></div>
					<div class="os-min text-right edit"><? echo edit_comment_link(); ?></div>
				</div>
				<?
			}

			echo strip_tags(wp_list_comments( array(
				'callback' => "comment_display"
			)), "<p><a><blockquote><div><img>"); ?>
		</div>
		<?
	}

	comment_form(array(
		"logged_in_as" => "",
		"title_reply" => "",
		"comment_field" => '<input id="comment" name="comment" class="comment_input" aria-required="true" required="true" placeholder="Discuss #'.sanitize_title(get_the_title()).'" />',
		"label_submit" => "&raquo;",
		"must_log_in" => '<p class="must-log-in">You must be <a href="/login">logged in</a> to post a comment.</p>',
	));
	?>

</div>
