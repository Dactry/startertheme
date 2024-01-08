<?php
global $wp_query;
$found_posts = $wp_query->found_posts;
$result_title = $found_posts  > 1 ? 's' : '';

$search_query = get_search_query();
$title = 'Search';
if ($search_query) {
	$title = sprintf(esc_html__('%s search result%s for ‘%s’', 'core'), $found_posts, $result_title, esc_html($search_query));
}
get_header();
?>
<header class="bg-surface section-py">
	<div class="container-md">
		<h1 class="h6"><?= $title ?></h1>
		<?php get_search_form(); ?>
	</div>
</header>

<div class="container-md section-py">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<article class="row align-items-center">
				<div class="col-md">
					<h2 class="h4">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<?php the_excerpt(); ?>
				</div>
				<?php if (has_post_thumbnail()) : ?>
					<div class="col-md-auto">
						<a href="<?php the_permalink(); ?>" tabindex="-1">
							<?php the_post_thumbnail(IMG_SIZE_XS); ?>
						</a>
					</div>
				<?php endif; ?>
			</article>
			<hr>
		<?php
		endwhile;
		get_template_part('components/pagination');
		?>
	<?php else : ?>
		<h2 class="h4">Nothing Found</h2>
		<p>Please try again with some different keywords</p>
	<?php endif; ?>
</div>
<?php
get_footer();
