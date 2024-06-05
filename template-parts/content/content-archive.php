<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="posts posts--archive">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); 
        get_template_part('template-parts/content/content', 'card');
        endwhile;
        the_posts_navigation();
    else :
        get_template_part('template-parts/content/content', 'none');
    endif; ?>
</div>