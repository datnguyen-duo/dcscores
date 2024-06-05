<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
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
if ($slides): ?>
    <div class="<?php echo $layout . '__slides'; ?> swiper"
    <?php
    $attributes = array(
        'transition' => 'transition_effect',
        'transition-speed' => 'transition_speed',
        'loop' => 'loop',
        'arrows' => 'arrows',
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
        <?php if (!empty($settings['arrows'])): ?>
            <div class="swiper-button-next">
                <?php icon_arrow(); ?>
            </div>
            <div class="swiper-button-prev">
                <?php icon_arrow(); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($settings['pagination'])): ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>
    </div>
<?php endif; ?>