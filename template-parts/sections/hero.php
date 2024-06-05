<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$background_files = get_sub_field('background_files');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
$text_left = get_sub_field('text_left');
$text_right = get_sub_field('text_right');
?>
<div class="<?php echo $layout . '__files'; ?>">
    <?php if($background_files) {
        foreach($background_files as $key => $file):        
            if ($file['file']['type'] == 'video'): 
                video($file['file']['url'], $file['file']['mime_type'], $layout . '__file', 'autoplay muted loop playsinline');
                icon_volume();
            elseif ($file['file']['type'] == 'image'):
                image($file['file']['ID'], 'full', $layout . '__file', $file['file']['alt'] ? $file['file']['alt'] : 'Hero Image');
            endif;
        endforeach;
    } ?>
</div>
<div class="<?php echo $layout . '__content'; ?>">
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>

    <?php if ($text_left || $text_right): ?>
        <div class="<?php echo $layout . '__content-bottom'; ?>">
            <?php 
                echo $text_left ? '<p>' . $text_left . '</p>' : '';
                echo $text_right ? '<p>' . $text_right . '</p>' : '';    
            ?>
        </div>
    <?php endif; ?>

</div>