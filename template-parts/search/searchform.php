<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="site-header__search-toggle icon--search"><?php icon_search(); ?></div>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'textdomain' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'textdomain' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit icon--search" aria-label="Search Button"><?php icon_search(); ?></button>
    <div class="site-header__search-close icon--close"><?php icon_close(); ?></div>
</form>