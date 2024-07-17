<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$pre_heading = $args['pre_heading'];
$heading = $args['heading'];
$description = $args['description'];
$cta = $args['cta'];
$ctaClass = $args['ctaClass'] ?? '';
if (empty($pre_heading) && empty($heading) && empty($description) && empty($cta)) {
    return;
}
?>
<?php if ($pre_heading): ?>
    <p class="<?php echo $layout . '__pre-heading font__size-4'; ?>"><?php echo $pre_heading; ?><?php $layout == 'stats' ? icon_dcs_circle() : "" ?></p>
<?php endif; ?>
<?php if ($heading): ?>
    <?php if ($layout == 'hero'): ?>
        <h1 class="<?php echo $layout . '__heading font__size-1--alt load--text'; ?>"><?php echo $heading; ?></h1>
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
            $class = $ctaClass ? $ctaClass : 'primary';
            $url = $link['link']['url'];
            $target = $link['link']['target'];
            $class = $class;
            $title = $link['link']['title'];
            echo "<div class='" . $layout . "__cta-link'>";
                button($title, $class, $url, $target);
            echo "</div>";
        } 
    }
    ?>
    </div>
<?php endif; ?>
