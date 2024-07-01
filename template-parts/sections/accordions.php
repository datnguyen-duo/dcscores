<?php
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$accordions = get_sub_field('accordions');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
get_template_part('template-parts/sections/section', 'header', $header_args); 
?>
<div class="<?php echo $layout . '__list'; ?>">
    <?php foreach($accordions as $key => $item):        
        $title = $item['title'];
        $content = $item['content'];
        ?>
        <div class="<?php echo $layout . '__item'; ?>">
            <p class="<?php echo $layout . '__item-title'; ?>"><?php echo $title; ?>
                <span class="<?php echo $layout . '__item-arrow'; ?>"><?php icon_caret(); ?></span>
            </p>
            <div class="<?php echo $layout . '__item-content editor'; ?>">
                <div class="<?php echo $layout . '__item-content-inner'?>">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>