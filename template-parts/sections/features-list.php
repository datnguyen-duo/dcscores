<?php
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$variation = get_sub_field('variation');
$columns = get_sub_field('columns');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
get_template_part('template-parts/sections/section', 'header', $header_args);

if ($variation == 'featured-posts') {
    $featured_posts = get_sub_field('featured_posts');
    if ($featured_posts): ?>
        <div class="<?php echo $layout . '__items posts'; ?>">
            <?php foreach($featured_posts as $post): 
                setup_postdata($post);
            ?>
                <a href="<?php the_permalink(); ?>" class="<?php echo $layout . '__item post'; ?>">
                    <div class="<?php echo $layout . '__item-image post__image'; ?>">
                        <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('thumbnail--dcs-v');
                            } else {
                                $image_url = get_template_directory_uri() . '/assets/fallback-image.webp';
                                echo '<img src="' . esc_url($image_url) . '" alt="Thumbnail">';
                            }
                        ?>
                    </div>
                    <div class="<?php echo $layout . '__item-inner'; ?>">
                        <h4 class="<?php echo $layout . '__item-title' . ' font__size-4--alt'?>"><?php echo get_the_title(); ?></h4>
                        <?php if (get_post_type() == 'tribe_events'): ?>
                            <p><?php echo tribe_get_start_date(null, false, 'F j, Y'); ?></p>
                            <p><?php
                                echo tribe_get_start_time(null, false, ' - g:i a') ? tribe_get_start_time(null, false, ' - g:i a') : '';
                                echo tribe_get_end_time(null, false, ' - g:i a') ? ' - ' . tribe_get_end_time(null, false, 'g:i a') : '';
                            ?></p>
                        <?php endif; ?>
                        <div class="icon--arrow">
                            <?php icon_arrow_1(); ?>
                        </div>
                    </div>
                </a>
            <?php endforeach;?>
        </div>
        <?php wp_reset_postdata(); ?>
        <div class="<?php echo $layout . '__items-shape shape--sparkle --primary'; ?>"><?php icon_dcs_star_1("#D92314"); ?></div>
        <div class="<?php echo $layout . '__items-shape shape--sparkle --secondary'; ?>"><?php icon_dcs_star_2("#D92314"); ?></div>
        <div class="<?php echo $layout . '__items-shape shape shape--3 --alt'; ?>"></div>
    <?php endif;
} else {
    echo "<div class='" . $layout . "__icon'>";
    icon_dcs_underline("#FFFFFF");
    echo "</div>";
    if ($columns): ?>
        <div class="<?php echo $layout . '__columns'; ?>">
            <?php foreach($columns as $column): 
                $is_collage = $column['is_collage'];
                $layers = $column['layers'];
                $image = $column['image'];
                $pre_title = $column['pre_title'];
                $title = $column['title'];
                $description = $column['description'];
                $cta = $column['cta'];
                if ($is_collage && !empty($cta)): ?>
                    <a class="<?php echo $layout . '__column'; ?>" href="<?php echo $cta['url']?>" aria-label="<?php echo $cta['title'] ?>">
                <?php else: ?>
                    <div class="<?php echo $layout . '__column'; ?>">
                <?php endif; ?>
                    <?php if ($is_collage): ?>
                        <div class="<?php echo $layout . '__collage'; ?>">
                            <?php foreach($layers as $layer): 
                                $layer_image = $layer['image'];
                                $centered = (isset($layer['position']['top']) && $layer['position']['top'] !== '' && isset($layer['position']['left']) && $layer['position']['left'] !== '') ? '' : ' position--centered';                            $layer_size_width = isset($layer['size']['width']) && $layer['size']['width'] !== '' ? $layer['size']['width'] . '%' : 'auto';
                                $layer_size_height = isset($layer['size']['height']) && $layer['size']['height'] !== '' ? $layer['size']['height'] . '%' : 'auto';
                                $layer_position_top = isset($layer['position']['top']) && $layer['position']['top'] !== '' ? $layer['position']['top'] . '%' : '50%';
                                $layer_position_left = isset($layer['position']['left']) && $layer['position']['left'] !== '' ? $layer['position']['left'] . '%' : '50%';
                                $layer_hover_animation = $layer['hover_animation'] ? ' hover-animation--' . $layer['hover_animation'] : '';
                                ?>
                                <div class="<?php echo $layout . '__collage-layer' . $centered . $layer_hover_animation; ?>"
                                    style="<?php echo 'width: ' . $layer_size_width . '; 
                                    height: ' . $layer_size_height . '; 
                                    top: ' . $layer_position_top . '; 
                                    left: ' . $layer_position_left . ';'; ?>"
                                >
                                    <div class="<?php echo $layout . '__collage-layer-container' ?>">
                                        <?php image($layer_image['ID'], 'full', $layout . '__collage-layer-image', $layer_image['alt']); ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                        </div>
                    <?php else: 
                        if ($image) {
                            image($image['ID'], 'full', $layout . '__column-image', $image['alt']);
                       }?>
                    <?php endif; ?>
                    <?php if ($pre_title): ?>
                        <p class="<?php echo $layout . '__column-pre-title'; ?>"><?php echo $pre_title; ?></p>
                    <?php endif; ?>
                    <?php if ($title): ?>
                        <p class="<?php echo $layout . '__column-title'; ?>"><?php echo $title; ?></p>
                    <?php endif; ?>
                    <?php if ($description): ?>
                        <p class="<?php echo $layout . '__column-description'; ?>"><?php echo $description; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($cta) && !$is_collage): ?>
                        <div class="<?php echo $layout . '__column-cta'; ?>">
                        <?php
                        if (!empty($cta['url']) && !empty($cta['title'])) {
                            $url = $cta['url'];
                            $target = $cta['target'];
                            $class = "primary";
                            $title = $cta['title'];
                            echo "<div class='" . $layout . "__cta-link'>";
                                button($title, $class, $url, $target);
                            echo "</div>";
                        }
                        ?>
                        </div>
                    <?php endif; ?>
                <?php if ($is_collage && !empty($cta)): ?>
                    </a>
                <?php else: ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; 
}

?>