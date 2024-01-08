<?php
$args = wp_parse_args(
    $args,
    array(
        'img_id' => get_post_thumbnail_id(),
        'curtain' => false,
    )
);
extract($args);
if (!$img_id) return;

$img_args = [
    'class' => 'stretch',
    'loading' => 'eager'
];

$image = wp_get_attachment_image($img_id, IMG_SIZE_3XL, false, $img_args);
echo get_core_remove_width_height_attr($image);
if ($curtain) {
    get_template_part('components/curtain');
}
