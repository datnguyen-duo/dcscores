<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$variation = get_sub_field('variation');
$files = get_sub_field('files');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
$text_left = get_sub_field('text_left');
$text_right = get_sub_field('text_right');
$slug = get_post_field( 'post_name', get_post() );
if ($variation == 'featured-post'):
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
    if ($slug == 'events') {
        $event_categories = get_the_term_list($ID, 'tribe_events_cat', '', ', ');
        if (!is_wp_error($event_categories)) {
            $pre_heading = 'Event | ';
            $pre_heading .= tribe_get_start_date(null, false, 'F j, Y');
            $pre_heading .= tribe_get_start_time(null, false, ' - g:i a') ? ' | ' . tribe_get_start_time(null, false, ' - g:i a') : '';
            $pre_heading .= tribe_get_end_time(null, false, ' - g:i a') ? ' - ' . tribe_get_end_time(null, false, 'g:i a') : '';
        }
    } else {
        $pre_heading = get_the_category_list(', ', '', $ID);
    }
    $header_args = [
        'layout' => $layout,
        'pre_heading' => $pre_heading,
        'heading' => '<a href="' . get_permalink() . '">' . get_the_title() . '</a>',
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
    $image_id = get_post_thumbnail_id($ID);
    wp_reset_postdata();
?>
    <div class="<?php echo $layout . '__columns'; ?>">
        <div class="<?php echo $layout . '__column --content'; ?>">
            <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
        </div>
        <div class="<?php echo $layout . '__column --image'; ?>">
            <div class="<?php echo $layout . '__image'; ?>">
                <?php image($image_id, 'full', '', 'Hero Image', 'eager'); ?>                
            </div>
            <div class="<?php echo $layout . '__column-shapes'; ?>">
                <div class="<?php echo $layout . '__column-shape --primary'; ?>"><?php icon_dcs_star_3(); ?></div>
            </div>
        </div>
        <div class="shape shape--3"></div>
    </div>
<?php elseif ($variation == 'anchors'): 
    $anchor_links = get_sub_field('anchor_links');
?> 
    <div class="<?php echo $layout . '__columns'; ?>">
        <div class="<?php echo $layout . '__column --content'; ?>">
            <?php get_template_part('template-parts/sections/section', 'header', $header_args); 
            if ($anchor_links): ?>
                <ul class="<?php echo $layout . '__anchors'; ?>">
                    <?php foreach($anchor_links as $key => $link): ?>
                        <li class="<?php echo $layout . '__anchor'; ?>">
                            <a href="<?php echo $link['link']['url']; ?>" class="<?php echo $layout . '__content-anchor-link font__size-6 has-underline'; ?>"><?php echo $link['link']['title']; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="<?php echo $layout . '__column --image'; ?>">
            <div class="<?php echo $layout . '__image'; ?>">
                <?php if ($files) {
                    foreach($files as $key => $file):        
                        if ($file['file']['type'] == 'video'): 
                            video($file['file']['url'], $file['file']['mime_type'], $layout . '__file', 'autoplay muted loop playsinline');
                            echo '<div class="' . $layout . '__files-icon">';
                            icon_play();
                            echo '</div>';
                        elseif ($file['file']['type'] == 'image'):
                            image($file['file']['ID'], 'full', $layout . '__file', $file['file']['alt'] ? $file['file']['alt'] : 'Hero Image', 'eager');
                        endif;
                    endforeach;
                } ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="<?php echo $layout . '__files'; ?>">
        <?php if($files) {
            foreach($files as $key => $file):        
                if ($file['file']['type'] == 'video'): 
                    video($file['file']['url'], $file['file']['mime_type'], $layout . '__file', 'autoplay muted loop playsinline');
                    echo '<div class="' . $layout . '__files-icon">';
                    icon_play();
                    echo '</div>';
                elseif ($file['file']['type'] == 'image'):
                    image($file['file']['ID'], 'full', $layout . '__file', $file['file']['alt'] ? $file['file']['alt'] : 'Hero Image', 'eager');
                endif;
            endforeach;
        } ?>
    </div>
    <div class="<?php echo $layout . '__content'; ?>">
        <?php
        $current_post = get_queried_object();
        if (isset($current_post->post_parent) && $current_post->post_parent > 0): ?>
            <a href="<?php echo esc_url(get_permalink($current_post->post_parent)); ?>" class="<?php echo $layout . '__content-breadcrumb'; ?>"><?php icon_arrow_1(); ?>Families Portal</a>
        <?php endif; ?>
        <div class="<?php echo $layout . '__content-inner'; ?>">
            <?php 
                get_template_part('template-parts/sections/section', 'header', $header_args); 
                echo '<div class="' . $layout . '__content-icon">';
                icon_dcs_arrow_down();
                echo '</div>';
            ?>
            <div class="<?php echo $layout . '__content-shape shape--sparkle --primary'; ?>"><?php icon_dcs_star_1(); ?></div>
            <div class="<?php echo $layout . '__content-shape shape--sparkle --secondary'; ?>"><?php icon_dcs_star_2(); ?></div>
        </div> 
        <?php if ($text_left || $text_right): ?>
            <div class="<?php echo $layout . '__content-bottom'; ?>">
                <?php 
                    echo $text_left ? '<p>' . $text_left . '</p>' : '';
                    echo $text_right ? '<p>' . $text_right . '</p>' : '';    
                ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if ($variation == 'modal'):
    $embed = get_sub_field('embed');
    if ($embed): ?>
        <div class="<?php echo $layout . '__modal'; ?>">
            <div class="<?php echo $layout . '__modal-inner'; ?>">
                <div class="<?php echo $layout . '__modal-content'; ?>">
                    <?php echo $embed; ?>
                </div>
            </div>
            <div class="<?php echo $layout . '__modal-close'; ?>">
                <div class="icon--close"><?php icon_close(); ?></div>
            </div>
        </div>
    <?php endif;
endif; ?>
<?php if ($variation == 'anchors-alt'): 
    $anchor_links = get_sub_field('anchor_links');
    if ($anchor_links): ?>
        <ul class="<?php echo $layout . '__anchors'; ?>">
            <?php foreach($anchor_links as $key => $link): ?>
                <li class="<?php echo $layout . '__anchor'; ?>">
                    <a href="<?php echo $link['link']['url']; ?>" class="<?php echo $layout . '__content-anchor-link font__size-6 has-underline'; ?>"><?php echo $link['link']['title']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif;
endif; ?>