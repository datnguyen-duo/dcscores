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