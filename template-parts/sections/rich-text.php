<?php 
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$content = get_sub_field('content');

?>

<div class="<?php echo $layout . '__content'; ?> editor">
    <?php if ($content): ?>
        <?php echo $content; ?>
    <?php endif; ?>
</div>