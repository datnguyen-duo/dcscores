<?php
defined( 'ABSPATH' ) || exit;
$logo = get_field('secondary_logo', 'option') ? get_field('secondary_logo', 'option')['ID'] : get_option('site_icon');
$organization_description = get_field( 'organization_description', 'option' );
$entity_information = get_field( 'entity_information', 'option' );
$copyright = get_field( 'copyright', 'option' );
?>
<a href="<?php echo esc_url(home_url('/')); ?>" class="site-footer__logo">
    <?php image($logo, 'full', "", $alt = 'Logo', $loading = 'lazy'); ?>
</a>
<div class="site-footer__bottom">
<?php
    echo $entity_information ? '<p>' . $entity_information . '</p>' : '';
    echo '<p>Copyright ' . date('Y') . '</p>';
    echo get_privacy_policy_url() ? '<p><a href="' . esc_url(get_privacy_policy_url()) . '" class="site-footer__privacy">' . __('Privacy Policy', 'text-domain') . '</a></p>' : '';
    echo $organization_description ? $organization_description : '';
?>
</div>