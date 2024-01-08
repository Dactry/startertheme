<?php
get_header();
$title = is_archive() ? get_the_archive_title() : get_the_title(get_option('page_for_posts', true));
$page_header_args = [
	'title' => $title,
	'img_id' => get_post_thumbnail_id(get_option('page_for_posts', true)),
];
get_template_part('components/page-header', null, $page_header_args);
?>
<div class="container section-pt">
	<div class="row">
		<div class="col-md section-pb">
			<?php if (have_posts()) : ?>
				<div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-lg-4">
					<?php while (have_posts()) : the_post(); ?>
						<div class="col">
							<?php get_template_part('components/card-post'); ?>
						</div>
					<?php endwhile; ?>
				</div>
				<?php get_template_part('components/pagination'); ?>
			<?php else : ?>
				<h2>Nothing Found</h2>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php
get_footer();
