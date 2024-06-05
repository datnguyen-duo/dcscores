<?php
defined('ABSPATH') || exit;
?>
<article class="post">
    <?php if (has_post_thumbnail()) : ?>
        <div class="post__thumbnail">
            <?php image(get_post_thumbnail_id(), 'full', 'post__thumbnail-image', get_the_title()); ?>
        </div>
    <?php endif; ?>

    <div class="post__header">
        <h2 class="post__title"><?php the_title(); ?></h2>
    </div>

    <div class="post__content">
        <?php the_excerpt(); ?>
    </div>

    <div class="post__footer">
        <a href="<?php the_permalink(); ?>" class="read-more"><?php echo __('Read More', 'textdomain'); ?></a>
    </div>
</article>