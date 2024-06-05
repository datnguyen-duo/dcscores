<?php
defined( 'ABSPATH' ) || exit; 
?>
<article class="entry__content">
    <?php get_template_part( 'template-parts/content/entry', 'sidebar' ); ?>

    <div class="editor">
        <?php the_content(); ?>   
        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'textdomain' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>
</article>