<?php
$products = get_sub_field('products');
if (!$products) return;

$products_ids = implode(',', $products);

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args); ?>
<div class="container" data-animate>
    <?php
    get_template_part('components/block', 'header');
    echo do_shortcode("[products ids='$products_ids']");
    get_template_part('components/block', 'footer');
    ?>
</div>
<?php get_template_part('components/block', 'end');
