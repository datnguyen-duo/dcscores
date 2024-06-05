<?php 

function custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' .  get_template_directory_uri() . '/login/style.css" />';
}
add_action('login_head', 'custom_login');

function login_logo_url() {
    return get_bloginfo('url') . '/';
}
add_filter('login_headerurl', 'login_logo_url');

function login_logo_text() {
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'login_logo_text');

?>