<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="entry__header<?php echo !has_post_thumbnail() ? ' no-thumbnail' : ''; ?>">
    <p class="entry__meta">
        <?php 
        if (get_post_type() == 'tribe_events') {
          $event_categories = get_the_term_list( get_the_ID(), 'tribe_events_cat', '', ', ' );
          if ( ! is_wp_error( $event_categories ) ) {
              echo 'Event | ';
              echo tribe_get_start_date(null, true, 'F j, Y');
              echo tribe_get_start_time() ? ' | ' . tribe_get_start_time() : '';
              echo tribe_get_end_time() ? ' - ' . tribe_get_end_time() : '';
          }
        } else {
            the_category(', ');
        } ?>
    </p>
    <h1 class="entry__title"><?php the_title(); ?></h1>
    <?php if (has_excerpt()) : ?>
        <div class="entry__excerpt">
            <?php the_excerpt(); ?>
        </div>
    <?php endif; ?>
    <?php if (has_post_thumbnail()) : ?>
        <div class="entry__thumbnail">
            <?php image(get_post_thumbnail_id(), 'full', 'entry__thumbnail-image load--media', get_the_title()); ?>
            <?php 
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_caption = wp_get_attachment_caption($thumbnail_id);
            if (!empty($thumbnail_caption)) : ?>
                <div class="entry__thumbnail-caption">
                    <?php echo esc_html($thumbnail_caption); ?>
                </div>
            <?php endif; ?>
            <div class="shape shape--4"></div>
        </div>
    <?php endif; ?>
</div>