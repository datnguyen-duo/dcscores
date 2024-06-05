<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$settings = get_sub_field('settings');
$show_pagination = $settings['show_pagination'];
$show_filter = $settings['show_filter'];

$posts_per_slide = $show_pagination ? $settings['posts_per_slide'] : 4;

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
); ?>
<div class="<?php echo $layout . '__header'; ?>">
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
</div>
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
    <div class="<?php echo $layout . '__items posts' . ($show_pagination ? ' swiper' : ''); ?>" style="--posts-per-slide: <?php echo $posts_per_slide; ?>;" <?php echo $show_pagination ? 'data-attribute-arrows="true" data-attribute-pagination="true"' : ''; ?>>        <?php 
        if ($show_pagination) {
            echo '<div class="swiper-wrapper"><div class="swiper-slide">'; 
        }
        while($posts_query->have_posts()): $posts_query->the_post();
            $ID = get_the_ID();
            $permalink = get_field('external_link') ? get_field('external_link') : get_the_permalink();
            $target = get_field('external_link') ? 'target="_blank"' : 'target="_self"';
            $terms = wp_get_post_terms( get_the_ID(), $settings['filter_terms']);
            $term_id = ! empty( $terms ) && is_array( $terms ) ? $terms[0]->term_id : '';
            if ($show_pagination && $counter % $posts_per_slide == 0 && $counter != 0) {
                echo '</div><div class="swiper-slide">'; 
            }
            $counter++; 
        ?>
        <article class="<?php echo $layout . '__item post'; ?>" data-term-id=<?php echo $term_id; ?>>
            <div class="<?php echo $layout . '__image'; ?>">
                <?php if (has_post_thumbnail()): ?>
                    <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                        <?php the_post_thumbnail('thumbnail--dcs'); ?>
                    </a>
                <?php endif; ?>
            </div>
            <p class="<?php echo $layout . '__meta'; ?>">
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
            <h3 class="<?php echo $layout . '__title'; ?>">
                <a href="<?php echo $permalink; ?>" <?php echo $target; ?>>
                    <?php the_title(); ?>
                </a>
            </h3>
            <div class="<?php echo $layout . '__excerpt'; ?>"><?php the_excerpt(); ?></div> 
        </article>
        <?php 
        endwhile; 
        if ($show_pagination) {
            echo '</div>';
            echo '</div>';
            echo '<div class="swiper-pagination"></div>';
            echo '<div class="swiper-button-next swiper-button">ARROW RIGHT</div>';
            echo '<div class="swiper-button-prev swiper-button">ARROW LEFT</div>';
        }
        wp_reset_postdata();
        ?>
    </div>
<?php endif; ?>