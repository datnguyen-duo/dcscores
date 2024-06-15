<?php
defined( 'ABSPATH' ) || exit; 
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
    ?>
</nav>