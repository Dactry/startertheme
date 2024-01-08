<form class="search row g-0 align-items-center" method="get" action="/" role="search">
	<div class="col">
		<input class="search-input" type="search" value="<?php the_search_query(); ?>" name="s" placeholder="<?php _e('Search', 'html5blank'); ?>">
	</div>
	<div class="col-auto">
		<button class="button button--square" aria-label="Search"><?php get_template_part('components/site-icon', null, ['icon' => 'search', 'class' => 'fs-lg']); ?></button>
	</div>
</form>