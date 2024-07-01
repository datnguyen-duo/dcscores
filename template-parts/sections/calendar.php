<?php
defined( 'ABSPATH' ) || exit;
$themeurl = get_template_directory_uri();
$layout = $args['layout'];
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
get_template_part('template-parts/sections/section', 'header', $header_args); 
?>
<div class="<?php echo $layout . '__container'; ?>">
    <div id="calendar" class="load--media">
        <?php echo do_shortcode('[tribe_events]'); ?>
    </div>
</div>