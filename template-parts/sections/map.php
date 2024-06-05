<?php
defined( 'ABSPATH' ) || exit;
$themeurl = get_template_directory_uri();
$layout = $args['layout'];
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
    <div id="map">
        <div id="map-popup">
            <h3 id="map-popup-title"></h3>
            <p id="map-popup-address"></p>
            <a id="map-popup-url" target="_blank" href="">Open in Google Maps</a>
        </div>
    </div>
</div>