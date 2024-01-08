<?php
$args = wp_parse_args($args,    [
    'title' => get_the_title(),
    'height' => 'min-height-sm',
    'img_id' => get_post_thumbnail_id(),
]);
extract($args);

$block_name = CONTENT_BLOCK_CLASS . ' ' . CONTENT_BLOCK_MODIFIER . basename(__FILE__, '.php');
$block_class = get_core_filter_implode([
    $block_name,
    'text-white',
    'bg-dark',
    $height
]);
?>
<div class="<?= $block_class;  ?>">
    <?php
    if ($img_id) {
        $img_args = [
            'curtain' => true,
            'img_id' => $img_id,
        ];
        get_template_part('components/background-image', null, $img_args);
    }
    ?>
    <div class="<?= CONTENT_BLOCK_CONTENT; ?> container section-py text-center" data-animate>
        <?php if (is_singular('post')) : ?>
            <p><?= esc_html(get_the_date()); ?></p>
        <?php endif; ?>
        <h1><?= esc_html(strip_tags($title)); ?></h1>
    </div>
</div>