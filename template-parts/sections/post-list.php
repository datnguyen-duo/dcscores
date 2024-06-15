<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$settings = get_sub_field('settings');
$show_pagination = $settings['show_pagination'];
$show_filter = $settings['show_filter'];
$posts_per_slide = $show_pagination ? $settings['posts_per_slide'] : 4;

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

$query_args = array(
    'post_type' => $settings['post_type'],
    'posts_per_page' => $settings['posts_per_page'],
    'orderby' => $settings['order_by'],
    'order' => $settings['order'],
);
$posts_query = new WP_Query($query_args);
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
); 

get_template_part('template-parts/sections/section', 'header', $header_args);

?>

<?php if ($settings['show_filter']):
    $terms = get_terms( array(
        'taxonomy'   => $settings['filter_terms'],
        'hide_empty' => false,
    ) );
    ?>
    <ul class="<?php echo $layout . '__filter'; ?>">
        <?php foreach ($terms as $term): ?>
            <li class="<?php echo $layout . '__filter-item'; ?>" data-term-id=<?php echo $term->term_id; ?>><?php echo $term->name; ?></li>
        <?php endforeach; ?>
    </ul>
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
            $terms = wp_get_post_terms( get_the_ID(), $settings['filter_terms']);
            $term_id = ! empty( $terms ) && is_array( $terms ) ? $terms[0]->term_id : '';
            shuffle($colors);
            $random_color = $colors[0];
            if ($show_pagination && $counter % $posts_per_slide == 0 && $counter != 0) {
                echo '</div><div class="swiper-slide">'; 
            }
            $counter++; 
        ?>
        <article class="<?php echo $layout . '__item post'; ?>" data-term-id="<?php echo $term_id; ?>" style="--color-background: <?php echo $random_color; ?>">
            <div class="<?php echo $layout . '__image'; ?> post__image">
                <?php if (has_post_thumbnail()): ?>
                    <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                        <?php the_post_thumbnail('thumbnail--dcs'); ?>
                    </a>
                <?php endif; ?>
            </div>
            <p class="<?php echo $layout . '__meta'; ?> post__meta">
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
            <h5 class="<?php echo $layout . '__title'; ?> post__title">
                <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                    <?php the_title(); ?>
                </a>
            </h5>
            <div class="<?php echo $layout . '__excerpt'; ?> post__excerpt">
                <p><?php echo wp_trim_words( get_the_excerpt(), 20, '[...]' ); ?></p>
            </div> 
        </article>
        <?php 
        endwhile; 
        if ($show_pagination) {
            echo '</div>';
            echo '</div>';
            echo '<div class="swiper-pagination"></div>';
            echo '<div class="swiper-button-prev swiper-button icon--arrow">';
            icon_arrow();
            echo '</div>';
            echo '<div class="swiper-button-next swiper-button icon--arrow">';
            icon_arrow();
            echo '</div>';
        }
        wp_reset_postdata();
        ?>
    </div>
<?php endif; ?>