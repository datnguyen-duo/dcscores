<?php
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$variation = get_sub_field('variation');
$file = get_sub_field('file');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
$has_header = !empty($header_args['heading']) || !empty($header_args['description']) || !empty($header_args['cta']);
if ($variation == 'featured-post') {
    $featured_post = get_sub_field('featured_post');
    if ($featured_post) {
        $post = $featured_post[0];
        setup_postdata($post);
    } else {
        $args = [
            'post_type' => $slug == 'events' ? 'events' : 'post',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
        ];
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $query->the_post();
        }
    }
    $ID = get_the_ID();
    $header_args = [
        'layout' => $layout,
        'pre_heading' => get_the_category_list(', ', '', $ID),
        'heading' => get_the_title(),
        'description' => strtok(get_the_excerpt(), '.') . '.',
        'cta' => [
            [
                'link' => [
                    'url' => get_the_permalink(),
                    'title' => 'Read More',
                    'target' => '_self',
                ],
            ],
        ],
        'ctaClass' => 'secondary',
    ];
    $featured_image = get_the_post_thumbnail($ID, 'full');    
    wp_reset_postdata();
}
?>
<div class="<?php echo $layout . '__files'; ?>">
    <?php 
        if ($variation == 'featured-post') {
            if (!empty($featured_image)) {
                echo $featured_image;
            } else {
                $image_url = get_template_directory_uri() . '/assets/fallback-image.webp';
                echo '<img src="' . esc_url($image_url) . '" alt="Thumbnail" loading="lazy">';
            }
        } else {
            if (!empty($file)):
                if ($file['type'] == 'video'): 
                    video($file['url'], $file['mime_type'], $layout . '__file', 'autoplay muted loop playsinline');
                elseif ($file['type'] == 'image'):
                    image($file['ID'], 'full', $layout . '__file', $file['alt'] ? $file['alt'] : 'Banner Image');
                endif; 
            endif;
        }
    ?>
</div>

<?php if ($has_header): ?>
    <div class="<?php echo $layout . '__content'; ?> load--media">
        <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
    </div>
<?php endif; ?>