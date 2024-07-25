<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$variation = get_sub_field('variation');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);

$settings = get_sub_field('settings');
$show_pagination = $settings['show_pagination'];
$show_filter = $settings['show_filter'];
$posts_per_slide = $show_pagination ? $settings['posts_per_slide'] : 4;

get_template_part('template-parts/sections/section', 'header', $header_args);
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

if ($variation == 'query') {

    if ($show_filter) {

        if ($settings['post_type'] == 'person') {
            $staff_term = get_term_by('slug', 'staff', $settings['filter_term']);
            
            $exclude_terms = [];
            
            if ($staff_term) {
                $exclude_terms[] = $staff_term->term_id;
            }
            
            $terms = get_terms(array(
                'taxonomy' => $settings['filter_term'],
                'hide_empty' => true,
                'exclude' => $exclude_terms,
            ));
        } else {
            $terms = get_terms(array(
                'taxonomy' => $settings['filter_term'],
                'hide_empty' => true,
            ));
        }        
        
        $terms = array_values($terms);

        if (!is_wp_error($terms) && !empty($terms)) {
            $first_term = $terms[0]->slug;
        }
    }
    if ($settings['post_type'] == 'person') {
        $posts_per_slide = 6;
    }
    $filter_by = $settings['filter_by'];
    $filter_by_name = strtolower(str_replace(' ', '-', $settings['filter_by_name']));

    $query_args = array(
        'post_type' => $settings['post_type'],
        'posts_per_page' => $settings['posts_per_page'],
        'orderby' => $settings['order_by'],
        'order' => $settings['order'],
    );

    if (!empty($filter_by) && !empty($filter_by_name)) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => $filter_by,
                'field'    => 'slug',
                'terms'    => $filter_by_name,
            ),
        );
    }

    if ($settings['post_type'] == 'person') {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => $settings['filter_term'],
                'field'    => 'slug',
                'terms'    => $first_term,
            ),
        );
    }
    $posts_query = new WP_Query($query_args);

    ?>

    <?php if ($settings['show_filter']): ?>
        <ul class="<?php echo $layout . '__filter'; ?>">
            <?php if ($settings['post_type'] !== 'person'): ?>
                <li class="<?php echo $layout . '__filter-item active'; ?>" data-post-type="<?php echo $settings['post_type']; ?>" data-filter-term="<?php echo $settings['filter_term']; ?>" data-term-id="">All</li>
            <?php endif; ?>
            <?php foreach ($terms as $key => $term): ?>
                <li class="<?php echo $layout . '__filter-item' . ($settings['post_type'] == 'person' && $key == 0 ? ' active' : ''); ?>" data-post-type="<?php echo $settings['post_type']; ?>" data-filter-term="<?php echo $settings['filter_term']; ?>" data-term-id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="<?php echo $layout . '__filter-description'; ?>">
            <?php foreach ($terms as $key => $term): ?>
                <div class="<?php echo $layout . '__filter-description-item' . ($settings['post_type'] == 'person' && $key == 0 ? ' active' : ''); ?>" data-term-id="<?php echo $term->term_id; ?>">
                    <?php echo term_description($term->term_id, $settings['filter_term']); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; 
    if ($posts_query->have_posts()): 
        $counter = 0;
    ?>
        <div class="<?php echo $layout . '__items posts --' . $settings['post_type'] . ($show_pagination ? ' swiper' : ''); ?>" style="--posts-per-slide: <?php echo $posts_per_slide; ?>;" <?php echo $show_pagination ? 'data-attribute-arrows="true" data-attribute-pagination="true"' : ''; ?>>        
            <?php 
            if ($show_pagination) {
                echo '<div class="swiper-wrapper"><div class="swiper-slide">'; 
            }
            while($posts_query->have_posts()): $posts_query->the_post();
                $ID = get_the_ID();
                $permalink = get_field('external_link') ? get_field('external_link') : get_the_permalink();
                $target = get_field('external_link') ? 'target="_blank"' : 'target="_self"';
                $terms = wp_get_post_terms( get_the_ID(), $settings['filter_term']);
                $term_id = !empty( $terms ) && is_array( $terms ) ? $terms[0]->term_id : '';
                shuffle($colors);
                $random_color = $colors[0];
                if ($show_pagination && $counter % $posts_per_slide == 0 && $counter != 0) {
                    echo '</div><div class="swiper-slide">'; 
                }
                if (($counter < 12 && $show_filter) || !$show_filter || $settings['post_type'] == 'person'):
                    $counter++;

            ?>
            <article class="<?php echo $layout . '__item post'; ?>" data-term-id="<?php echo $term_id; ?>" style="--color-background: <?php echo $random_color; ?>">
                <div class="<?php echo $layout . '__item-image'; ?> post__image">
                    <?php if (has_post_thumbnail()): ?>
                        <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                            <?php image(get_post_thumbnail_id($ID), 'thumbnail--dcs', '', 'Featured Image', 'lazy'); ?>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                            <img src="<?php echo get_template_directory_uri() . '/assets/fallback-image.webp'; ?>" alt="Thumbnail">
                        </a>
                    <?php endif; ?>
                </div>
                <p class="<?php echo $layout . '__item-meta'; ?> post__meta">
                    <?php 
                    $taxonomy = get_post_type() == 'post' ? 'category' : 'source';
                    $terms = get_the_terms(get_the_ID(), $taxonomy);
                    if ($terms) {
                        echo implode(', ', array_map(function($term) {
                            return '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                        }, $terms));
                    }
                    if ($settings['post_type'] !== 'press') {
                        echo " | "; 
                        the_date(); 
                    }
        
                    ?>
                </p>
                <h5 class="<?php echo $layout . '__item-title'; ?> post__title">
                    <?php if ($settings['post_type'] == 'person'): 
                        if (get_field('external_link')): ?>
                            <a href="<?php echo get_field('external_link'); ?>" target="_blank">
                                <?php the_title(); ?>
                            </a>
                        <?php else:
                            the_title(); 
                        endif; else: ?>
                        <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                            <?php the_title(); ?>
                        </a>
                    <?php endif; ?>
                </h5>
                <?php if ($settings['post_type'] !== 'press'): ?>
                    <div class="<?php echo $layout . '__item-excerpt'; ?> post__excerpt">
                        <p><?php echo wp_trim_words( get_the_excerpt(), 20, '[...]' ); ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($settings['post_type'] == 'person'):
                    $title = get_field('title');
                    $company = get_field('company');
                    ?>
                    <div class="<?php echo $layout . '__item-excerpt'; ?> post__excerpt">
                        <p><?php echo $title ? $title . ', ' : ''; echo $company ? $company : ''; ?></p>
                    </div>
                <?php endif; ?>
            </article>

            <?php 
            endif; endwhile; 
            if ($show_pagination) {
                echo '</div>';
                echo '</div>';
                echo '<div class="swiper-pagination"></div>';
                echo '<div class="swiper-button-prev swiper-button icon--arrow">';
                icon_arrow_1();
                echo '</div>';
                echo '<div class="swiper-button-next swiper-button icon--arrow">';
                icon_arrow_1();
                echo '</div>';
            }
            wp_reset_postdata();
            ?>
        </div>
    <?php endif;
    if (($counter < 13 && $show_filter)) {
        echo '<button class="button button--primary load-more-btn" data-page="1" data-post-type="' . $settings['post_type'] . '">Load More</button>';
    }
} else {
    $posts = get_sub_field('posts');
    if ($posts): ?>
        <div class="<?php echo $layout . '__items posts --post'?>" style="--posts-per-slide: <?php echo $posts_per_slide; ?>;" <?php echo $show_pagination ? 'data-attribute-arrows="true" data-attribute-pagination="true"' : ''; ?>>        
        <?php foreach($posts as $post): 
                setup_postdata($post);
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
                                <?php image(get_post_thumbnail_id($ID), 'thumbnail--dcs', '', 'Featured Image', 'lazy'); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                                <img src="<?php echo get_template_directory_uri() . '/assets/fallback-image.webp'; ?>" alt="Thumbnail">
                            </a>
                        <?php endif; ?>
                    </div>
                    <p class="<?php echo $layout . '__item-meta'; ?> post__meta">
                        <?php 
                        $taxonomy = get_post_type() == 'post' ? 'category' : 'source';
                        $terms = get_the_terms(get_the_ID(), $taxonomy);
                        if ($terms) {
                            echo implode(', ', array_map(function($term) {
                                return '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                            }, $terms));
                        }
                        if ($settings['post_type'] !== 'press') {
                            echo " | "; 
                            the_date(); 
                        }
                        ?>
                    </p>
                    <h5 class="<?php echo $layout . '__item-title'; ?> post__title">
                        <?php if (get_field('external_link')): ?>
                            <a href="<?php echo get_field('external_link'); ?>" target="_blank">
                                <?php the_title(); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                                <?php the_title(); ?>
                            </a>
                        <?php endif; ?>
                    </h5>
                    <?php if ($settings['post_type'] !== 'press'): ?>
                        <?php if (get_the_excerpt()): ?>
                            <div class="<?php echo $layout . '__item-excerpt'; ?> post__excerpt">
                                <p><?php echo wp_trim_words( get_the_excerpt(), 20, '[...]' ); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </article>
            <?php endforeach;?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php endif;
}?>