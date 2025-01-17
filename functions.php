<?php
defined( 'ABSPATH' ) || exit;

function theme_setup() {
	$primary_color = get_field('primary_color', 'option');
	$secondary_color = get_field('secondary_color', 'option');
	$background_color = get_field('background_color', 'option');
	$text_color = get_field('text_color', 'option');
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
    remove_theme_support('core-block-patterns');
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'theme' ),
			'secondary' => esc_html__( 'Secondary', 'theme' ),
			'footer' => esc_html__( 'Footer', 'theme' ),
		),
	);
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Primary Color', 'theme' ),
            'slug'  => 'color-primary',
            'color' => $primary_color,
        ),
        array(
            'name'  => __( 'Secondary Color', 'theme' ),
            'slug'  => 'color-secondary',
            'color' => $secondary_color,
        ),
		array(
			'name'  => __( 'Background Color', 'theme' ),
			'slug'  => 'color-background',
			'color' => $background_color,
		),
		array(
			'name'  => __( 'Text Color', 'theme' ),
			'slug'  => 'color-text',
			'color' => $text_color,
		),
		array(
			'name'  => __( 'Black', 'theme' ),
			'slug'  => 'black',
			'color' => '#000000',
		),
		array(
			'name'  => __( 'White', 'theme' ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
    ) );

	add_image_size( 'thumbnail--dcs', 350, 215, true );
	add_image_size( 'thumbnail--dcs-v', 0, 600, false );
	add_image_size( 'thumbnail--dcs-auto', 200, 200, false );
}
add_action( 'after_setup_theme', 'theme_setup' );

function remove_menus_and_submenus(){
	remove_submenu_page( 'themes.php', 'edit.php?post_type=wp_block' );
}

add_action( 'admin_menu', 'remove_menus_and_submenus' );

function theme_upload_mimes($mimes) {
	$mimes['otf'] = 'font/otf';
	$mimes['ttf'] = 'font/ttf';
	$mimes['woff'] = 'font/woff';
	$mimes['woff2'] = 'font/woff2';
	return $mimes;
}
add_filter('upload_mimes', 'theme_upload_mimes');

function theme_scripts() {
	$theme_version = wp_get_theme()->get('Version');

	$sections = get_field('sections');
	$primary_font = get_field('primary_font', 'option');
	$secondary_font = get_field('secondary_font', 'option');
	$tertiary_font = get_field('tertiary_font', 'option');
	if ($primary_font['upload_type'] == 'url') {
		wp_enqueue_style( 'primary-font', $primary_font['url'], array(), false, 'all' );
	}
	if ($secondary_font['upload_type'] == 'url') {
		wp_enqueue_style( 'secondary-font', $secondary_font['url'], array(), false, 'all' );
	}
	if ($tertiary_font['upload_type'] == 'url') {
		wp_enqueue_style( 'tertiary-font', $tertiary_font['url'], array(), false, 'all' );
	}
	wp_enqueue_style( 'variables', get_stylesheet_directory_uri() . '/theme-variables.css', array(), wp_get_theme()->get('Version') . '/theme-variables.css');
	wp_enqueue_style( 'stylesheet', get_stylesheet_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version') . '/style.css');
	wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', true);
	wp_enqueue_script(
		'gsap',
		get_stylesheet_directory_uri() . '/scripts/libs/gsap.min.js',
		array(),
		wp_get_theme()->get('Version') . '/scripts/libs/gsap.min.js',
		array(
			'strategy' => 'defer'
		)
	);
	wp_enqueue_script(
		'scrollTrigger',
		get_stylesheet_directory_uri() . '/scripts/libs/ScrollTrigger.min.js',
		array(),
		wp_get_theme()->get('Version') . '/scripts/libs/ScrollTrigger.min.js',
		array(
			'strategy' => 'defer'
		)
	);
	wp_enqueue_script(
		'draw-svg',
		get_stylesheet_directory_uri() . '/scripts/libs/DrawSVGPlugin.min.js',
		array(),
		wp_get_theme()->get('Version') . '/scripts/libs/DrawSVGPlugin.min.js',
		array(
			'strategy' => 'defer'
		)
	);
	wp_enqueue_script(
		'scroll-to',
		get_stylesheet_directory_uri() . '/scripts/libs/ScrollToPlugin.min.js',
		array(),
		wp_get_theme()->get('Version') . '/scripts/libs/ScrollToPlugin.min.js',
		array(
			'strategy' => 'defer'
		)
	);
	wp_enqueue_script(
		'global-script',
		get_stylesheet_directory_uri() . '/scripts/global.min.js',
		array(),
		wp_get_theme()->get('Version') . '/scripts/global.min.js',
		array(
			'strategy' => 'defer'
		)
	);
	if ($sections && array_filter($sections, function($section) { return $section['acf_fc_layout'] == 'map'; })) {
		wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css');
		wp_enqueue_script(
			'mapbox',
			'https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js',
			array(),
			wp_get_theme()->get('Version') . '/https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js',
			array(
				'strategy' => 'defer'
			)
		);
		wp_enqueue_script(
			'map-script',
			get_stylesheet_directory_uri() . '/scripts/map.js',
			array(),
			wp_get_theme()->get('Version') . '/scripts/map.js',
			array(
				'strategy' => 'defer'
			)
		);
		foreach ($sections as $section) {
			if ($section['acf_fc_layout'] == 'map') {
				$map_settings = array(
					'themeurl' => get_template_directory_uri(),
					'access_token' => 'pk.eyJ1IjoiZHVvc3R1ZGlvIiwiYSI6ImNsdjc0cnNkdjA2Y2Yyam8ybHMxdGI3MzcifQ.nXyLj636H-QJ1XJz0w7uRA',
					'map' => $section['map'],
				);
				wp_localize_script('map-script', 'mapSettings', $map_settings);
				break;
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

function dequeue_scripts(){
	if ( ! (is_singular('post') || is_singular('tribe_events')) ) {        
		wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style( 'wc-block-style' );
        wp_dequeue_style( 'global-styles' );
    }
	if (!is_admin()) {
        wp_dequeue_style('dashicons');
    }
}
add_action( 'wp_enqueue_scripts', 'dequeue_scripts', 100 );

function disable_gutenberg( $is_enabled, $post_type ) {
    if ( in_array( $post_type, array( 'page', 'press', 'person' ) ) ) {
        return false;
    }
    return $is_enabled;
}
add_filter( 'use_block_editor_for_post_type', 'disable_gutenberg', 10, 2 );

function keep_published_date( $data, $postarr ) {
    $post = get_post($postarr['ID']);
    if ( $post ) {
        $data['post_date'] = $post->post_date;
        $data['post_date_gmt'] = $post->post_date_gmt;
    }
    return $data;
}
// add_filter( 'wp_insert_post_data', 'keep_published_date', 99, 2 );

function modify_search_query($query) {
    if ($query->is_main_query() && $query->is_search() && empty(get_search_query())) {
        $query->set('post_type', array('post', 'page'));
    } elseif ($query->is_main_query() && $query->is_search()) {
        $post_types = get_post_types(array('public' => true), 'names');
        unset($post_types['person']);
        $query->set('post_type', $post_types);
    }
}
add_action('pre_get_posts', 'modify_search_query');

function remove_dashicons_from_frontend() {
    if (!is_admin() && !is_customize_preview() && !current_user_can('edit_posts')) {
        wp_dequeue_style('dashicons');
        wp_deregister_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'remove_dashicons_from_frontend', 100);

function add_custom_role() {
    add_role(
        'content_manager', 
        'Content Manager', 
        array(
            'list_users' => true,
            'create_users' => true,
            'edit_users' => true,
            'delete_users' => true,
            'promote_users' => true,
            'remove_users' => true,
            'manage_options' => true,

            'edit_posts' => true,
            'delete_posts' => true,
            'publish_posts' => true,
            'edit_others_posts' => true,
            'delete_others_posts' => true,
            'edit_pages' => true,
            'delete_pages' => true,
            'publish_pages' => true,
            'edit_others_pages' => true,
            'delete_others_pages' => true,
            'edit_published_posts' => true,
            'delete_published_posts' => true,
            'edit_published_pages' => true,
            'delete_published_pages' => true,
        )
    );
}
add_action('init', 'add_custom_role');

require_once('inc/login.php');
require_once('inc/acf.php');
require_once('inc/icons.php');
require_once('inc/elements.php');
require_once('inc/load-more.php');