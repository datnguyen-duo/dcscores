<?php
defined( 'ABSPATH' ) || exit; 
if ( has_tag() ) :
?>
<div class="entry__footer">
    <div class="entry__footer-tags">
        <p class="entry__footer-tags-title font__size-6">Read more stories about</p>
        <div class="entry__footer-tags-inner">
            <?php the_tags( '', ' ', '' ); ?>
        </div>
    </div>
</div>
<?php endif; ?>