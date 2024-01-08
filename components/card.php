<?php
$link = get_sub_field('link');

$args = wp_parse_args(
    $args,
    array(
        'image_id' => get_sub_field('image'),
        'title' => get_sub_field('title'),
        'content' => get_sub_field('content'),
        'link_title' => $link ? $link['title'] : null,
        'link_url' => $link ? $link['url'] : null,
        'link_target' => $link ? $link['target'] : null,
    )
);
extract($args);

//disable link wrap if content contains link 
if (str_contains($content, '</a>')) {
    $link_title = $link_url = $link_target_blank = false;
}

$card_tag = 'div';
$card_attributes = "class='card' data-animate";
if ($link_url) {
    $card_tag = 'a';
    $card_attributes .= sprintf(' href="%1$s"%2$s', esc_url($link_url), $link_target === '_blank' ? " target='_blank'" : null);
};

echo "<$card_tag $card_attributes>";
?>
<?php if ($image_id) : ?>
    <div class="bg-surface ratio-4-3">
        <?= get_core_remove_width_height_attr(wp_get_attachment_image($image_id, IMG_SIZE_SM, false, ['class' => 'stretch', 'loading' => 'lazy'])); ?>
    </div>
<?php endif; ?>
<div class="card__content">
    <?php
    if ($title) echo "<h3 class='h4'>" . esc_html($title) . "</h3>";
    echo $content;
    if ($link_title && $link_url) : ?>
        <div class="card__link"><?= esc_html($link_title); ?><?php get_template_part('components/site-icon', null, ['icon' => 'chevron', 'class' => 'card__link-icon rotate-270']); ?></div>
    <?php endif; ?>
</div>
<?= "</$card_tag>";
