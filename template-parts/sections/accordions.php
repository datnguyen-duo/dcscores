<?php
defined( 'ABSPATH' ) || exit; 
$layout = $args['layout'];
$variation = get_sub_field('variation');
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
<?php if ($variation == 'toggles'): ?>
<div class="<?php echo $layout . '__container'; ?>">
    <div class="<?php echo $layout . '__list --images'; ?>">
        <?php foreach($accordions as $key => $item):        
            $image = $item['image'];
                image($image['ID'], 'full', $layout . '__image' . ($key === 0 ? ' active' : ''), $image['alt']);
            endforeach; ?>
    </div>
<?php endif; ?>
<div class="<?php echo $layout . '__list --content'; ?>">
    <?php foreach($accordions as $key => $item):        
        $title = $item['title'];
        $content = $item['content'];
        ?>
        <div class="<?php echo $layout . '__item' . ($key === 0 ? ' active' : ''); ?>">
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
<?php if ($variation == 'toggles'): ?>
</div>
<?php endif; ?>