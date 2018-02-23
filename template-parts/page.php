<? if ($_SERVER['SERVER_NAME'] == 'localhost') { echo basename(__FILE__); } ?>

<div class="page_title_outer">
	<header class="page_title container">
		<h1><? the_title(); ?></h1>
	</header>
</div>
<div class="page_content_outer">
	<article id="page-<?php the_ID(); ?>" class="container page_content">
		<? the_content(); ?>
	</article>
</div>
