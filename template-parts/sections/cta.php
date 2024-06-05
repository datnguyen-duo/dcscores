<?php 
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$format = get_sub_field('format');
$file = get_sub_field('file');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
?>
<div class="<?php echo $layout . '__file'; ?>">
    <?php 
    if (!empty($file)):
        if ($file['type'] == 'video'): 
            video($file['url'], $file['mime_type'], $layout . '__file', 'autoplay muted loop playsinline');
        elseif ($file['type'] == 'image'):
            image($file['ID'], 'full', $layout . '__file', $file['alt'] ? $file['alt'] : 'CTA Image');
        endif; 
    endif;
    ?>
</div>
<div class="<?php echo $layout . '__content'; ?>">
    <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
</div>
