<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="error-404 not-found">
	<div class="container">
		<div class="error-404__column">
			<img src="<?php echo get_template_directory_uri() . '/assets/dcs-404.webp'; ?>" alt="404-image">
		</div>
		<div class="error-404__column">
			<h1>Page <span>not found</span></h1>
			<p>We couldn’t find the page you were looking for.</p>
			<a href="<?php echo esc_url(home_url('/')); ?>" class="button button--primary">Back to home</a>
		</div>
	</div>
</section>
<?php
get_footer();
