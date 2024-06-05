<?php 
function acf_generate_options_css($post_id) {
	if ($post_id !== 'options') {
		return;
	}
	$ss_dir = get_stylesheet_directory();
	ob_start(); 
	require($ss_dir . '/inc/theme-styles.php'); 
	$css = ob_get_clean(); 
	file_put_contents($ss_dir . '/styles/_variables.scss', $css, LOCK_EX);
}
add_action( 'acf/save_post', 'acf_generate_options_css', 20 );

function add_acf_class_to_menu_items($classes, $item, $args) {
    if (get_field('is_button', $item)) {
        $button_type = get_field('button_type', $item);
        $classes[] = 'button button--' . $button_type;
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'add_acf_class_to_menu_items', 10, 3);
function acf_input_admin_footer() {
	$primary_color = get_field('primary_color', 'option');
	$secondary_color = get_field('secondary_color', 'option');
	$background_color = get_field('background_color', 'option');
	$text_color = get_field('text_color', 'option');
	?>
	<script type="text/javascript">
		(function($) {
			acf.add_filter('color_picker_args', function( args, $field ){
				args.palettes = ['<?php echo $primary_color; ?>', '<?php echo $secondary_color; ?>', '<?php echo $background_color; ?>', '<?php echo $text_color; ?>', '#FFFFFF', '#000000' ];
				return args;
			});
		})(jQuery);
	</script>
	<?php
}
add_action('acf/input/admin_footer', 'acf_input_admin_footer');
function populate_post_types( $field ) {
    if ($field['key'] !== 'field_661d95966202d') {
        return $field;
    }
    $args = array(
        'public'   => true,
    );
    $post_types = get_post_types( $args, 'names', 'and' ); 
    foreach ( $post_types as $post_type ) {
        if ($post_type !== 'attachment') {
            $field['choices'][ $post_type ] = ucfirst($post_type);
        }
    }
    return $field;
}
add_filter('acf/load_field', 'populate_post_types');

function populate_taxonomies( $field ) {
    if ($field['key'] !== 'field_6621bc39852a1') {
        return $field;
    }
    $args = array(
        'public'   => true,
    );
    $taxonomies = get_taxonomies( $args, 'names', 'and' ); 
    foreach ( $taxonomies as $taxonomy ) {
        $taxonomy_object = get_taxonomy($taxonomy);
        $field['choices'][ $taxonomy ] = $taxonomy_object->labels->name;
    }
    return $field;
}
add_filter('acf/load_field', 'populate_taxonomies');
?>