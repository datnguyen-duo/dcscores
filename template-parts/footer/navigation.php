<?php
defined( 'ABSPATH' ) || exit; 
?>
<nav id="footer-navigation" class="footer-navigation">
    
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