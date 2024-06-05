<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$pre_heading = $args['pre_heading'];
$heading = $args['heading'];
$description = $args['description'];
$cta = $args['cta'];
if (empty($pre_heading) && empty($heading) && empty($description) && empty($cta)) {
    return;
}
?>
<!-- <div class="<?php echo $layout . '__header'; ?>"> -->
    <?php if ($pre_heading): ?>
        <p class="<?php echo $layout . '__pre-heading'; ?>"><?php echo $pre_heading; ?></p>
    <?php endif; ?>
    <?php if ($heading): ?>
        <?php if ($layout == 'hero'): ?>
            <h1 class="<?php echo $layout . '__heading'; ?>"><?php echo $heading; ?></h1>
        <?php else: ?>
            <h2 class="<?php echo $layout . '__heading'; ?>"><?php echo $heading; ?></h2>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($description): ?>
        <p class="<?php echo $layout . '__description'; ?>"><?php echo $description; ?></p>
    <?php endif; ?>
    <?php if (!empty($cta)): ?>
        <div class="<?php echo $layout . '__cta'; ?>">
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
<!-- </div> -->