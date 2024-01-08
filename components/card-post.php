<a href="<?php the_permalink(); ?>" class="card-post" data-animate>
    <div class="card-post__img-holder bg-surface ratio-4-3">
        <?= get_core_remove_width_height_attr(get_the_post_thumbnail(get_the_ID(), IMG_SIZE_SM, ['class' => 'card-post__img stretch', 'loading' => 'lazy'])); ?>
    </div>
    <h3 class="card-post__title h5"><?php the_title(); ?></h3>
    <?php if (get_post_type() === 'post') : ?>
        <span class="fs-sm"><?= esc_html(get_the_date()); ?></span>
    <?php endif; ?>
</a>