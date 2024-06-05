<?php
defined( 'ABSPATH' ) || exit;
$themeurl = get_template_directory_uri();
$show_announcement_bar = get_field('show_announcement_bar', 'option');
$scripts = get_field('scripts', 'option');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php if ($scripts) {
		foreach ($scripts as $script) {
			if ($script['insert'] == 'head') {
				echo esc_html($script['script']);
			}
		}
	} ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ($scripts) {
	foreach ($scripts as $script) {
		if ($script['insert'] == 'body') {
			echo esc_html($script['script']);
		}
	}
} ?>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'theme' ); ?></a>
	<header id="masthead" class="site-header">
		<?php if ($show_announcement_bar): ?>
			<div class="site-header__announcement-bar">
				<div class="site-header__announcement-bar-inner">
					<div class="site-header__announcement-bar-container container">
						<div class="site-header__announcement-bar--content editor">
							<?php echo wp_kses_post(get_field('announcement_bar_text', 'option')); ?>
						</div>
						<div class="site-header__announcement-bar-close icon--close">
							<?php icon_close(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="site-header__navigation">
			<?php get_template_part('template-parts/header/navigation'); ?>

		</div>
	</header>

	<main id="main" class="site-main">