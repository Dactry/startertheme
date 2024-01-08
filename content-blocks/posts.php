<?php
$args = wp_parse_args($args, [
    'numberposts' => 4,
    'class' => null
]);
extract($args);

$loop = get_posts([
    'numberposts' => $numberposts,
    'exclude' => get_the_ID(),
]);
if (!$loop) return;

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
    'class' => $class
];
get_template_part('components/block', 'start', $block_args);
?>
<div class="container" data-animate>
    <div class="row align-items-center">
        <div class="col">
            <h2>Latest Posts</h2>
        </div>
        <?php if (intval(wp_count_posts()->publish) > $numberposts) : ?>
            <div class="col-auto">
                <a href="<?= esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="button">View All</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="row gy-3 row-cols-md-<?= $numberposts; ?>">
        <?php
        foreach ($loop as $post) :
            setup_postdata($post); ?>
            <div class="col-12">
                <?php get_template_part('components/card-post'); ?>
            </div>
        <?php
        endforeach;
        wp_reset_postdata(); ?>
    </div>
</div>
<?php
get_template_part('components/block', 'end'); ?>