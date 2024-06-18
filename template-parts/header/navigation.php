<?php
defined( 'ABSPATH' ) || exit;
$logo = get_field('primary_logo', 'option') ? get_field('primary_logo', 'option')['ID'] : get_option('site_icon');
?>
<div class="site-header__navigation--top container">
    <nav id="secondary-site-navigation" class="secondary-navigation">
        <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'secondary',
                    'container' => false,
                )
            );
        ?>
    </nav>
</div>

<div class="site-header__navigation--bottom container">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__logo">
        <?php image($logo, 'full', "", $alt = 'Logo', $loading = 'eager'); ?>
    </a>
    <nav id="site-navigation" class="main-navigation">
        <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container' => false,
                )
            );
        ?>
    </nav>
    <div class="site-header__mobile-toggle">
        <div class="site-header__mobile-toggle-line"></div>
        <div class="site-header__mobile-toggle-line"></div>
        <div class="site-header__mobile-toggle-line"></div>
    </div>
    <?php get_template_part( 'template-parts/search/searchform' ); ?>
</div>
