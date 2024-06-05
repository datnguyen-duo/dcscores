<?php
defined( 'ABSPATH' ) || exit;
if (have_rows('sections')) {
    while (have_rows('sections')) {
        the_row();
        $layout = get_row_layout();
        $section_path = 'template-parts/sections/' . $layout;
        $background_color = get_sub_field('background_color');
        $text_color = get_sub_field('text_color');
        $variation = get_sub_field('variation') ? " --" . get_sub_field('variation') : null;
        $format = get_sub_field('format') ? " --" . get_sub_field('format') : null;

        $settings = get_sub_field('settings');
        $show_filter = is_array($settings) && $settings['show_filter'] ? " --has-filter" : null;
        $show_pagination = is_array($settings) && $settings['show_pagination'] ? " --has-pagination" : null;
        
        $style = ($background_color ? '--color-background: ' . $background_color . ';' : '') . ($text_color ? '--color-text: ' . $text_color . ';' : '');
        ?>
        <section class="<?php echo $layout . $variation . $format . $show_filter . $show_pagination; ?>"<?php echo $style ? ' style="' . $style . '"' : ''; ?>>
            <div class="container">
                <?php get_template_part($section_path, null, array('layout' => $layout)); ?>
            </div>
        </section>
        <?php
    }
}
?>