<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="archive">
	<div class="container">
		<div class="archive__header">
			<h1 class="archive__title"><?php the_archive_title(); ?></h1>
			<?php if (get_the_archive_description()) : ?>
				<div class="archive__description"><?php the_archive_description(); ?></div>
			<?php endif; ?>

		</div>
		<?php get_template_part( 'template-parts/content/content', 'archive' ); ?>
	</div>
</section>
<?php get_footer(); ?>