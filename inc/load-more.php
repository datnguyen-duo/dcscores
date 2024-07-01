<?php 
add_action('wp_ajax_fetch_posts', 'fetch_posts');
add_action('wp_ajax_nopriv_fetch_posts', 'fetch_posts');

function fetch_posts() {
    $action_type = isset($_POST['action_type']) ? sanitize_text_field($_POST['action_type']) : '';

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
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';
    $filter_term = isset($_POST['filter_term']) ? sanitize_text_field($_POST['filter_term']) : null;
    $term_id = isset($_POST['term_id']) ? intval($_POST['term_id']) : null;
    $next_page = $page + 1;

    if ($action_type === 'filter') {
        $paged = 1; 
    } else {
        $paged = $page + 1;
    }

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $post_type === 'person' ? -1 : 12,
        'paged' => $paged,
    );

    if ($term_id) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $filter_term,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        );
    }

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
        $posts_html = '';
        while ($the_query->have_posts()) {
            $the_query->the_post(); 
            $ID = get_the_ID();
            $permalink = get_field('external_link') ? get_field('external_link') : get_the_permalink();
            $target = get_field('external_link') ? 'target="_blank"' : 'target="_self"';
            $terms = wp_get_post_terms( get_the_ID(), $settings['filter_term']);
            $term_id = !empty( $terms ) && is_array( $terms ) ? $terms[0]->term_id : '';
            shuffle($colors);
            $random_color = $colors[0];
            $total_posts = $the_query->found_posts;
            $show_load_more = $paged * 12 < $total_posts ? true : false;
            ob_start();
            ?>
            <article class="<?php echo 'post-list__item post'; ?>" data-term-id="<?php echo $term_id; ?>" style="--color-background: <?php echo $random_color; ?>">
                <div class="<?php echo 'post-list__item-image'; ?> post__image">
                    <?php if (has_post_thumbnail()): ?>
                        <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                            <?php the_post_thumbnail('thumbnail--dcs'); ?>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                            <img src="<?php echo get_template_directory_uri() . '/assets/fallback-image.svg'; ?>" alt="Thumbnail">
                        </a>
                    <?php endif; ?>
                </div>
                <p class="<?php echo 'post-list__item-meta'; ?> post__meta">
                    <?php 
                    $taxonomy = get_post_type() == 'post' ? 'category' : 'source';
                    $terms = get_the_terms(get_the_ID(), $taxonomy);
                    if ($terms) {
                        echo implode(', ', array_map(function($term) {
                            return '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                        }, $terms));
                    }
                    echo " | "; 
                    the_date(); 
                    ?>
                </p>
                <h5 class="<?php echo 'post-list__item-title'; ?> post__title">
                    <?php if ($post_type == 'person'): 
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
                <?php if (get_the_excerpt()): ?>
                    <div class="<?php echo 'post-list__item-excerpt'; ?> post__excerpt">
                        <p><?php echo wp_trim_words( get_the_excerpt(), 20, '[...]' ); ?></p>
                    </div> 
                <?php endif; ?>
                <?php if ($post_type == 'person'): 
                    $title = get_field('title');
                    $company = get_field('company');
                ?>
                    <div class="<?php echo 'post-list__item-excerpt'; ?> post__excerpt">
                        <p><?php echo $title ? $title . ', ' : ''; echo $company ? $company : ''; ?></p>
                    </div>
                <?php endif; ?>
            </article>
            <?php $posts_html .= ob_get_clean();
        }
    } else {
        $posts_html = "<div class='post-list__item post__item post --no-post'>No posts</div>";
    }
    wp_reset_postdata();
    $response = array(
        'posts' => $posts_html, 
        'show_load_more' => $show_load_more,
    );
    echo json_encode($response);
    wp_die();
}

?>