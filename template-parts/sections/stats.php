<?php
defined( 'ABSPATH' ) || exit;
$themeurl = get_template_directory_uri();
$layout = $args['layout'];
$columns = get_sub_field('columns');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
get_template_part('template-parts/sections/section', 'header', $header_args); 
?>
<div class="<?php echo $layout . '__columns'; ?>">
    <?php foreach($columns as $column): 
        $image = $column['image'];
        $prefix = $column['prefix'];
        $number = $column['number'];
        $suffix = $column['suffix'];
        $description = $column['description'];
        $cta = $column['cta'];
        ?>
        <div class="<?php echo $layout . '__column'; ?>">
            <?php if ($image) {
                 image($image['ID'], 'full', $layout . '__column-image', $image['alt']);
            } ?>
            <div class="<?php echo $layout . '__column-stat'; ?>">
                <?php if ($prefix): ?>
                    <p class="<?php echo $layout . '__column-stat--prefix'; ?>"><?php echo $prefix; ?></p>
                <?php endif; ?>
                <?php if ($number): ?>
                    <p class="<?php echo $layout . '__column-stat--number'; ?>"><?php echo $number; ?></p>
                <?php endif; ?>
                <?php if ($suffix): ?>
                    <p class="<?php echo $layout . '__column-stat--suffix'; ?>"><?php echo $suffix; ?></p>
                <?php endif; ?>
            </div>

            <?php if ($description): ?>
                <p class="<?php echo $layout . '__column-description'; ?>"><?php echo $description; ?></p>
            <?php endif; ?>
            <?php if (!empty($cta)): ?>
                <div class="<?php echo $layout . '__column-cta'; ?>">
                <?php 
                foreach($cta as $key => $link) { 
                    if (!empty($link['link']['url']) && !empty($link['link']['title'])) {
                        $url = $link['link']['url'];
                        $target = $link['link']['target'];
                        $class = "primary";
                        $title = $link['link']['title'];
                        echo "<div class='" . $layout . "__cta-link'>";
                            button($title, $class, $url, $target);
                        echo "</div>";
                    } 
                }
                ?>
                </div>
            <?php endif; ?>
        </div>
     <?php endforeach; ?>
</div>
<?php icon_dcs_arrow_left(); ?>