<?php
$args = wp_parse_args($args, [
	'object_id' => get_the_ID(),
]);
$object_id = $args['object_id'];
if (have_rows('content_blocks', $object_id)) {
	while (have_rows('content_blocks', $object_id)) {
		the_row();
		if (get_core_hide_block()) {
			get_template_part('content-blocks/' . get_row_layout());
		}
	}
}
