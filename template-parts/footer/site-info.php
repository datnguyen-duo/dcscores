<?php
defined( 'ABSPATH' ) || exit;
$logo = get_field('submark', 'option') ? get_field('submark', 'option')['ID'] : get_option('site_icon');
$organization_description = get_field( 'organization_description', 'option' );
$entity_information = get_field( 'entity_information', 'option' );
$copyright = get_field( 'copyright', 'option' );
?>
<a href="<?php echo esc_url(home_url('/')); ?>" class="site-footer__logo">
    <?php image($logo, 'full', "", $alt = 'Logo', $loading = 'lazy'); ?>
</a>
<div class="site-footer__bottom">
    <?php
        echo $entity_information ? $entity_information . ' | ' : '';
        echo 'Copyright ' . date('Y') . ' | ';
        echo get_privacy_policy_url() ? '<a href="' . esc_url( get_privacy_policy_url() ) . '" class="site-footer__privacy">' . __( 'Privacy Policy', 'text-domain' ) . '</a>' : '';
        echo $organization_description ? ' | ' . $organization_description : '';
    ?>
</div>