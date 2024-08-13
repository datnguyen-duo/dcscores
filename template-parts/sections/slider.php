<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$variation = get_sub_field('variation');
$settings = get_sub_field('settings');
$slides = get_sub_field('slides');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
get_template_part('template-parts/sections/section', 'header', $header_args);
if ($slides || $variation == 'team'): ?>
    <div class="<?php echo $layout . '__slides'; ?> swiper"
    <?php
    if (!empty($variation)) {
        echo ' data-variation="' . $variation . '"';
    }
    $attributes = array(
        'transition' => 'transition_effect',
        'transition-speed' => 'transition_speed',
        'loop' => 'loop',
        'arrows' => 'arrows',
        'scrollbar' => 'scrollbar',
        'pagination' => 'pagination',
        'autoplay' => 'autoplay',
        'autoplay-speed' => 'autoplay_speed',
    );
    foreach ($attributes as $attribute => $setting) {
        if (!empty($settings[$setting])) {
            echo ' data-attribute-' . $attribute . '="' . $settings[$setting] . '"';
        }
    }
    ?>>
        <?php if ($variation == 'timeline'): ?>
            <div class="<?php echo $layout . '__slides--alt --images'; ?>">
                <?php foreach($slides as $key => $slide): 
                    $image = $slide['image'];
                    if ($image): ?>
                        <div class="<?php echo $layout . '__slide--alt --image' . ($key === 0 ? ' active' : ''); ?>">
                            <?php image($image['ID'], 'full', $layout . '__slide-image', $image['alt']); ?>
                        </div>
                    <?php else: ?>
                        <div class="<?php echo $layout . '__slide--alt --image' . ($key === 0 ? ' active' : ''); ?>">
                            <div class="<?php echo $layout . '__slide-image'; ?>">
                                <?php
                                    $image_url = get_template_directory_uri() . '/assets/fallback-image.webp';
                                    echo '<img src="' . esc_url($image_url) . '" alt="Thumbnail">';
                                ?>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
                <div class="<?php echo $layout . '__items-shape shape--sparkle --primary'; ?>"><?php icon_dcs_star_1("#FAC831"); ?></div>
                <div class="<?php echo $layout . '__items-shape shape--sparkle --secondary'; ?>"><?php icon_dcs_star_2("#FAC831"); ?></div>
                <div class="shape shape--6"></div>
            </div>
            <div class="swiper-wrapper">
                <?php foreach($slides as $key => $slide): 
                    $image = $slide['image'];
                    $pre_title = $slide['pre_title'];
                    $title = $slide['title'];
                    $description = $slide['description'];
                    $cta = $slide['cta'];
                    ?>
                    <div class="<?php echo $layout . '__slide swiper-slide'; ?>">
                        <?php if ($pre_title): ?>
                            <p class="<?php echo $layout . '__slide-pre-title'; ?>"><?php echo $pre_title; ?></p>
                        <?php endif; ?>
                        <?php if ($title): ?>
                            <p class="<?php echo $layout . '__slide-title'; ?>"><?php echo $title; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="<?php echo $layout . '__slides--alt --content'; ?>">
                <?php foreach($slides as $key => $slide): 
                    $description = $slide['description'];
                    $cta = $slide['cta'];
                    if ($description): ?>
                        <div class="<?php echo $layout . '__slide--alt' . ($key === 0 ? ' active' : ''); ?>">
                            <p class="<?php echo $layout . '__slide-description'; ?>"><?php echo $description; ?></p>
                            <?php if ($cta): ?>
                                <a href="<?php echo $cta['url']; ?>" class="<?php echo $layout . '__slide-cta'; ?> button button--primary"><?php echo $cta['title']; ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php elseif ($variation == 'team'):
            $group = get_sub_field('group');
            $args = array(
                'post_type' => 'person',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'group',
                        'field' => 'slug',
                        'terms' => $group,
                    ),
                ),
            );
            $query = new WP_Query($args);
            
            if ($query->have_posts()): ?>
                <div class="swiper-wrapper">
                    <?php while ($query->have_posts()): $query->the_post();
                        $image = get_field('photo_secondary') ? get_field('photo_secondary') : get_field('photo_primary');
                        $name = get_the_title();
                        $title = get_field('title');
                        ?>
                        <div class="<?php echo $layout . '__slide swiper-slide'; ?>">
                            <?php if ($image) {
                                image($image['ID'], 'thumbnail', $layout . '__slide-image', $image['alt']);
                            } ?>
                            <?php if ($name): ?>
                                <p class="<?php echo $layout . '__slide-title'; ?>">
                                    <?php
                                        $lastSpacePosition = strrpos($name, ' ');
                                        $lastName = $lastSpacePosition === false ? $name : substr($name, $lastSpacePosition + 1);
                                        $lastName = str_replace('-', ' ', $lastName);
                                        echo $lastName;
                                    ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($title): ?>
                                <p class="<?php echo $layout . '__slide-description'; ?>"><?php echo $title; ?></p>
                            <?php endif; ?>
                            <div class="<?php echo $layout . '__slide-icon'; ?>">
                                <?php icon_dcs_caret(); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; wp_reset_postdata(); 
            if ($query->have_posts()): ?>
                <div class="<?php echo $layout . '__slides-container'; ?>">
                    <div class="<?php echo $layout . '__slides--alt --images'; ?>">
                        <?php 
                            $imageCounter = 0;
                            while ($query->have_posts()): $query->the_post();
                            $image = get_field('photo_primary');
                            if ($image): ?>
                                <div class="<?php echo $layout . '__slide--alt --image'. ($imageCounter === 0 ? ' active' : ''); ?>">
                                    <?php image($image['ID'], 'full', $layout . '__slide-image--alt', $image['alt']); ?>
                                </div>
                            <?php else: ?>
                                <div class="<?php echo
                                $layout . '__slide--alt --image' . ($imageCounter === 0 ? ' active' : ''); ?>">
                                    <div class="<?php echo $layout . '__slide-image'; ?>">
                                        <?php
                                            $image_url = get_template_directory_uri() . '/assets/fallback-image.webp';
                                            echo '<img src="' . esc_url($image_url) . '" alt="Thumbnail">';
                                        ?>
                                    </div>
                                </div>
                            <?php endif;
                            $imageCounter++;
                            endwhile; ?>
                    </div>
                    <div class="<?php echo $layout . '__slides--alt --content'; ?>">
                        <?php 
                            $contentCounter = 0;
                            while ($query->have_posts()): $query->the_post();
                            $name = get_the_title();
                            $title = get_field('title');
                            $bio = get_field('bio');
                            $email = get_field('email');
                            ?>
                            <div class="<?php echo $layout . '__slide--alt --content-inner' . ($contentCounter === 0 ? ' active' : ''); ?>">
                                <?php if ($name): ?>
                                    <p class="<?php echo $layout . '__slide-title--alt'; ?>"><?php echo str_replace('-', ' ', $name); ?></p>
                                <?php endif; ?>
                                <?php if ($title): ?>
                                    <p class="<?php echo $layout . '__slide-pre-title--alt'; ?>"><?php echo $title; ?></p>
                                <?php endif; ?>
                                <?php if ($bio): ?>
                                    <p class="<?php echo $layout . '__slide-description--alt'; ?>"><?php echo $bio; ?></p>
                                <?php endif; ?>
                                <?php if ($email): ?>
                                    <a href="mailto:<?php echo $email; ?>" class="<?php echo $layout . '__slide-email'; ?>"><?php icon_mail(); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php 
                            $contentCounter++;
                        endwhile; ?>
                    </div>
                </div>
            <?php endif; wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="swiper-wrapper">
                <?php foreach($slides as $key => $slide): 
                    $image = $slide['image'];
                    $pre_title = $slide['pre_title'];
                    $title = $slide['title'];
                    $description = $slide['description'];
                    $cta = $slide['cta'];
                    ?>
                    <div class="<?php echo $layout . '__slide swiper-slide'; ?>">
                        <?php if ($image) {
                            image($image['ID'], 'full', $layout . '__slide-image', $image['alt']);
                        } ?>
                        <?php if ($pre_title): ?>
                            <p class="<?php echo $layout . '__slide-pre-title'; ?>"><?php echo $pre_title; ?></p>
                        <?php endif; ?>
                        <?php if ($title): ?>
                            <p class="<?php echo $layout . '__slide-title'; ?>"><?php echo $title; ?></p>
                        <?php endif; ?>
                        <?php if ($description): ?>
                            <p class="<?php echo $layout . '__slide-description'; ?>"><?php echo $description; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($settings['pagination'])): ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>
        <?php if (!empty($settings['arrows'])): ?>
            <div class="swiper-buttons">
                <div class="swiper-button swiper-button-prev">
                    <?php icon_arrow_1(); ?>
                </div>
                <div class="swiper-button swiper-button-next">
                    <?php icon_arrow_1(); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!empty($settings['scrollbar'])): ?>
            <div class="swiper-scrollbar"></div>
        <?php endif; ?>
    </div>
<?php endif; ?>