<?php
$block_args = [
    'modifier' => basename(__FILE__, '.php')
];
get_template_part('components/block', 'start', $block_args);
$global_content_blocks = get_sub_field('global_content_blocks');
if (!$global_content_blocks) return;
foreach ($global_content_blocks as $object_id) {
    get_template_part('components/content-blocks', null, ['object_id' => $object_id]);
}
get_template_part('components/block', 'end');
