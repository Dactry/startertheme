<?php
$args = wp_parse_args(
    $args,
    array(
        'modifier' => null,
        'class' => null
    )
);
extract($args);

//Modifier
if ($modifier) {
    $modifier = CONTENT_BLOCK_MODIFIER . $modifier;
}

$outher_class = get_core_filter_implode([
    CONTENT_BLOCK_CLASS,
    $modifier,
    get_core_spacer(),
    get_core_height(),
    get_core_color_text_white(),
    $class
]);

$content_class = get_core_filter_implode([
    CONTENT_BLOCK_CONTENT,
    get_core_container_width()
]);
?>
<div class="<?= $outher_class ?>">
    <?php get_template_part('components/background'); ?>
    <div class="<?= $content_class ?>">