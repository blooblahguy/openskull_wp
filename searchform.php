<form role="search" method="get" class="search-form os" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="row">

		<input type="search" class="os search-field" placeholder="Search &hellip;" value="<?php echo get_search_query(); ?>" name="s" />
		<button type="submit" class="os-search-submit"><i class="material-icons">search</i></button>
	</div>
</form>