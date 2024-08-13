<?php
defined( 'ABSPATH' ) || exit;
$ID = get_the_ID();
$layout = 'entry__related';
$post_type = get_post_type();

if ($post_type === 'tribe_events') {
    $categories = wp_get_post_terms($ID, 'tribe_events_cat');
    $taxonomy = 'tribe_events_cat';
} else {
    $categories = get_the_category();
    $taxonomy = 'category';
}

if (!function_exists('is_dark_color')) {
    function is_dark_color($hexColor) {
        $hexColor = str_replace("#", "", $hexColor);
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        $luminance = (0.299*$r + 0.587*$g + 0.114*$b)/255;
        return $luminance <= 0.5;
    }
}

if (!function_exists('get_colors')) {
    function get_colors($field_name) {
        $field_colors = get_field($field_name, 'option');
        if(!$field_colors) {
            return array();
        }
        return array_filter(array_map(function($color) {
            return is_dark_color($color['color']) ? $color['color'] : null;
        }, $field_colors));
    }
}

$colors = array_merge(get_colors('primary_colors'), get_colors('secondary_colors'));

if ( $categories ) {
    $category_ids = array_map(function($category) {
        return $category->term_id;
    }, $categories);

    $args = array(
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 4,
        'ignore_sticky_posts' => 1,
    );
    if ($post_type === 'tribe_events') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $category_ids,
            ),
        );
    } else {
        $args['category__in'] = $category_ids;
    }
    $related_query = new WP_Query( $args );

    if ( $related_query->have_posts() ) : ?>
        <div class="entry__related">
            <h3 class="entry__related-title">Explore More</h3>
            <div class="posts posts--related" style="--posts-per-slide: 4">
                <?php while ( $related_query->have_posts() ){
                    $related_query->the_post();
                    $ID = get_the_ID();
                    $permalink = get_field('external_link') ? get_field('external_link') : get_the_permalink();
                    $target = get_field('external_link') ? 'target="_blank"' : 'target="_self"';
                    $terms = wp_get_post_terms( get_the_ID(), 'category');
                    $term_id = !empty( $terms ) && is_array( $terms ) ? $terms[0]->term_id : '';
                    shuffle($colors);
                    $random_color = $colors[0];
                    ?>
                        <article class="<?php echo $layout . '__item post'; ?>" data-term-id="<?php echo $term_id; ?>" style="--color-background: <?php echo $random_color; ?>">
                            <div class="<?php echo $layout . '__item-image'; ?> post__image">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                                        <?php the_post_thumbnail('thumbnail--dcs'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <p class="<?php echo $layout . '__item-meta'; ?> post__meta">
                                <?php 
                                    if (get_post_type() == 'tribe_events') {
                                        $event_categories = get_the_term_list( get_the_ID(), 'tribe_events_cat', '', ', ' );
                                        if ( ! is_wp_error( $event_categories ) ) {
                                            echo 'Event | ';
                                            echo tribe_get_start_date(null, false, 'F j, Y');
                                            echo tribe_get_start_time(null, false, ' - g:i a') ? ' | ' . tribe_get_start_time(null, false, ' - g:i a') : '';
                                            echo tribe_get_end_time(null, false, ' - g:i a') ? ' - ' . tribe_get_end_time(null, false, 'g:i a') : '';
                                        }
                                    } else {
                                        $taxonomy = get_post_type() == 'post' ? 'category' : 'source';
                                        $terms = get_the_terms(get_the_ID(), $taxonomy);
                                        if ($terms) {
                                            echo implode(', ', array_map(function($term) {
                                                return '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                                            }, $terms));
                                        }
                                        echo " | "; 
                                        the_date(); 
                                    }
                                ?>
                            </p>
                            <h5 class="<?php echo $layout . '__item-title'; ?> post__title">
                                <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                                    <?php the_title(); ?>
                                </a>
                            </h5>
                            <div class="<?php echo $layout . '__item-excerpt'; ?> post__excerpt">
                                <p><?php echo wp_trim_words( get_the_excerpt(), 20, '[...]' ); ?></p>
                            </div> 
                        </article>
                    <?php
                }; wp_reset_postdata(); ?>
            </div>

        </div>
    <?php endif; 
}
?>