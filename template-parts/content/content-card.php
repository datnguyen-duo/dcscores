<?php
defined('ABSPATH') || exit;

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

$layout = 'card';
$ID = get_the_ID();
$post_type = get_post_type();
$permalink = get_field('external_link') ? get_field('external_link') : get_the_permalink();
$target = get_field('external_link') ? 'target="_blank"' : '';
shuffle($colors);
$random_color = $colors[0];
?>
<article class="<?php echo $layout . '__item post'; ?>" style="--color-background: <?php echo $random_color; ?>">
    <div class="<?php echo $layout . '__item-image'; ?> post__image">
        <?php if (has_post_thumbnail()): ?>
            <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                <?php the_post_thumbnail('thumbnail--dcs'); ?>
            </a>
        <?php else: ?>
            <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                <img src="<?php echo get_template_directory_uri() . '/assets/fallback-image.webp'; ?>" alt="Thumbnail" loading="lazy">
            </a>
        <?php endif; ?>
    </div>
    <p class="<?php echo $layout . '__item-meta'; ?> post__meta">
    <?php 
        $post_type = get_post_type();
        if ($post_type == 'tribe_events') {
            $post_type = 'Event';
        }
        
        if ($post_type != 'post') {
            echo $post_type . " | ";
        }

        $taxonomy = $post_type == 'post' ? 'category' : 'source';
        $terms = get_the_terms(get_the_ID(), $taxonomy);

        if ($terms && !is_wp_error($terms)) {
            echo implode(', ', array_map(function($term) {
                return '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
            }, $terms));
            echo " | "; 
        }
        if ($post_type == 'tribe_events') {
            echo tribe_get_start_date(null, true, 'F j, Y');
            echo tribe_get_start_time() ? ' | ' . tribe_get_start_time() : '';
            echo tribe_get_end_time() ? ' - ' . tribe_get_end_time() : '';
        } else {
            echo get_the_date();
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
    <?php if (get_the_excerpt()): ?>
        <div class="<?php echo $layout . '__item-excerpt'; ?> post__excerpt">
            <p><?php echo wp_trim_words( get_the_excerpt(), 20, '[...]' ); ?></p>
        </div>
    <?php endif; ?>
</article>