<?php
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$variation = get_sub_field('variation');
$logos = get_sub_field('logos');
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
    <?php foreach($logos as $key => $item):        
        $logo = $item['logo'];
            image($logo['ID'], 'thumbnail--dcs-auto', $layout . '__logo', $logo['alt']);
        endforeach; ?>
</div>