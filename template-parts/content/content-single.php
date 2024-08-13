<?php
defined( 'ABSPATH' ) || exit; 
?>
<section class="entry">
	<div class="container">
		<?php 
		get_template_part( 'template-parts/content/entry', 'header' );
		get_template_part( 'template-parts/content/entry', 'content' );		
		get_template_part( 'template-parts/content/entry', 'footer' );
        get_template_part( 'template-parts/content/entry', 'related' );
		?>
	</div>
</section>
<?php
if (get_post_type() == 'post'): ?>
    <style>
        #menu-item-5201::before {
            clip-path: inset(0 0% 0 0);
        }
    </style>
<?php elseif (get_post_type() == 'tribe_events'): ?>
    <style>
        #menu-item-4286::before {
            clip-path: inset(0 0% 0 0);
        }
    </style>
<?php endif; ?>