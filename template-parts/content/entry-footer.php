<?php
defined( 'ABSPATH' ) || exit; 
?>
<div class="entry__footer">
    <span class="entry__footer-tags">
        <?php the_tags( '', ', ', '' ); ?>
    </span>
    <div class="entry__footer-navigation">
        <?php
            previous_post_link( '%link', 'Previous: %title' );
            next_post_link( '%link', 'Next: %title' );
        ?>
    </div>
</div>