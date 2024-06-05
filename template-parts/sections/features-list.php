<?php 
defined( 'ABSPATH' ) || exit; 
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
<?php if ($columns): ?>
    <div class="<?php echo $layout . '__columns'; ?>">
        <?php foreach($columns as $column): 
            $image = $column['image'];
            $pre_title = $column['pre_title'];
            $title = $column['title'];
            $description = $column['description'];
            $cta = $column['cta'];
            ?>
            <div class="<?php echo $layout . '__column'; ?>">
                <?php if ($image) {
                     image($image['ID'], 'full', $layout . '__column-image', $image['alt']);
                } ?>
                <?php if ($pre_title): ?>
                    <p class="<?php echo $layout . '__column-pre-title'; ?>"><?php echo $pre_title; ?></p>
                <?php endif; ?>
                <?php if ($title): ?>
                    <p class="<?php echo $layout . '__column-title'; ?>"><?php echo $title; ?></p>
                <?php endif; ?>
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
<?php endif; ?>