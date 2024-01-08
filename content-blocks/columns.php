<?php
$block_args = [
	'modifier' => basename(__FILE__, '.php'),
	'class' => get_core_height() ? get_core_vertical_align() : null,
];
get_template_part('components/block', 'start', $block_args);
$row_class = get_core_filter_implode([
	'row',
	get_core_horizontal_align(),
	get_core_vertical_align(),
	get_core_reverse_columns()
]);
if (have_rows('columns')) : ?>
	<div class="<?= $row_class; ?>">
		<?php while (have_rows('columns')) :
			the_row();
			$column_width = get_sub_field('column_width_responsive');
			$column_width_class = 'col-12';
			$breakpoints = $column_width['breakpoints'];
			if ($breakpoints) {
				$column_width_classes = [];
				foreach ($breakpoints as $breakpoint) {
					if (in_array($breakpoint, $breakpoints)) {
						$column_width_result = get_core_column_width($column_width[$breakpoint]['column_width'], $breakpoint);
						array_push($column_width_classes, $column_width_result);
					}
				}
				$column_width_class = implode(' ', $column_width_classes);
			}
		?>
			<div class="<?= $column_width_class ?>" data-animate>
				<?php the_sub_field('column'); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php
endif;
get_template_part('components/block', 'end');
