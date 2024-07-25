<?php 
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$columns = get_sub_field('columns');
if ($columns):
?>
<div class="<?php echo $layout . '__grid'; ?>">
    <?php foreach ($columns as $column):
        $background_color = $column['background_color'];
        $text_color = $column['text_color'];
        $style = ($background_color ? '--color-background: ' . $background_color . ';' : '') . ($text_color ? '--color-text: ' . $text_color . ';' : '');

        ?>
        <div class="<?php echo $layout . '__item'; ?>" style="<?php echo $style; ?>" >
            <?php 
                $rich_text = $column['rich_text']; 
                if ($rich_text): ?>
                <div class="<?php echo $layout . '__item-content'; ?> editor">
                    <?php if ($rich_text): ?>
                        <?php echo $rich_text; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>