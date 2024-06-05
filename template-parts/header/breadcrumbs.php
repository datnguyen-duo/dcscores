<?php
defined( 'ABSPATH' ) || exit; 
echo '<div class="breadcrumbs">';
if (is_home() || is_front_page()) {
    echo '<a href="' . get_home_url() . '">Home</a>';
} else {
    echo '<a href="' . get_home_url() . '">Home</a>';
    echo '<span class="separator">/</span>';
    if (is_category() || is_tag() || is_date()) {
        echo single_term_title("", false);
    } elseif (is_single()) {
        $categories = get_the_category();
        if (!empty($categories)) {
            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
            echo '<span class="separator">/</span>';
        }
        echo get_the_title();
    } elseif (is_page()) {
        $post_id = get_the_ID(); 
        if ($post_id) {
            $ancestors = get_post_ancestors($post_id);
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                echo '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
                echo '<span class="separator">/</span>';
            }
        }
        echo get_the_title();
    } else {
        echo get_the_title();
    }
}
echo '</div>';
?>