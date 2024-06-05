<?php
defined( 'ABSPATH' ) || exit;  
?>
<div class="entry__header">
    <p class="entry__meta"><?php the_category(', '); ?></p>
    <h1 class="entry__title"><?php the_title(); ?></h1>
    <?php if (has_excerpt()) : ?>
        <p class="entry__excerpt"><?php the_excerpt(); ?></p>
    <?php endif; ?>
    <?php if (has_post_thumbnail()) : ?>
        <div class="entry__thumbnail">
            <?php image(get_post_thumbnail_id(), 'full', 'entry__thumbnail-image', get_the_title()); ?>
        </div>
    <?php endif; ?>
</div>