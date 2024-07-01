<?php
defined( 'ABSPATH' ) || exit;
$themeurl = get_template_directory_uri();
$scripts = get_field('scripts', 'option');
?>
	</main>

	<footer id="colophon" class="site-footer">
		<div class="site-footer__container container">
			<?php 
				get_template_part('template-parts/footer/site-info');
				get_template_part('template-parts/forms/newsletter-signup');
				get_template_part('template-parts/footer/navigation');
			?>
			<div class="shape shape--2"></div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
<?php if ($scripts) {
	foreach ($scripts as $script) {
		if ($script['insert'] == 'footer') {
			echo $script['script'];
		}
	}
} ?>
</body>
</html>
