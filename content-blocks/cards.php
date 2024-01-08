<?php
$block_args = [
	'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);
get_template_part('components/block', 'header');
$row_class = get_core_filter_implode([
	'row',
	'g-3',
	get_core_items_per_row(),
	get_core_horizontal_align(null)
]);
if (have_rows('cards')) : ?>
	<div class="<?= $row_class; ?>">
		<?php while (have_rows('cards')) : the_row(); ?>
			<div class="col-12">
				<?php get_template_part('components/card'); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php
endif;
get_template_part('components/block', 'footer');
get_template_part('components/block', 'end');
