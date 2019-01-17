<? if (get_field("hero")) { ?>
	<div class="hero_outer">
		<img src="<? the_field("hero"); ?>" alt="<? the_title(); ?>">
		<div class="hero container">
			<h1 class="page_title"><? the_title(); ?></h1>
			<? if (get_field("subtitle")) { ?>
				<h2 class="subtitle"><? the_field("subtitle"); ?></h2>
			<? } ?>
		</div>
	</div>
<? } else { ?>
	<div class="page_title_outer">
		<header class="page_title container">
			<h1><? the_title(); ?></h1>
		</header>
	</div>
<? } ?>