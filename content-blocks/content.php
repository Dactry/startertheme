<?php
if (!get_the_content()) return;

$block_args = [
    'modifier' => basename(__FILE__, '.php')
];
get_template_part('components/block', 'start', $block_args);
the_content();
get_template_part('components/block', 'end');
