<?php
defined( 'ABSPATH' ) || exit;
$seals = get_field('seals', 'option');
?>
<nav id="footer-navigation" class="site-footer__navigation">
    
    <?php
    	get_template_part('template-parts/content/social-links');

        wp_nav_menu(
            array(
                'theme_location' => 'footer',
                'container' => false,
            )
        );

        if ($seals) {
            echo '<div class="site-footer__seals">';
            foreach ($seals as $seal) {
                image($seal['image']['ID'], 'thumbnail', 'site-footer__seal');
            }
            echo '</div>';
        }
    ?>

</nav>