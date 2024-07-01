<?php
/**
 * View: Top Bar Navigation Next Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/month/top-bar/nav/next.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @var string $next_url The URL to the next page, if any, or an empty string.
 *
 * @version 5.3.0
 *
 */
?>
<li class="tribe-events-c-top-bar__nav-list-item">
	<a
		href="<?php echo esc_url( $next_url ); ?>"
		class="tribe-common-c-btn-icon tribe-common-c-btn-icon--caret-right tribe-events-c-top-bar__nav-link tribe-events-c-top-bar__nav-link--next"
		aria-label="<?php esc_attr_e( 'Next month', 'the-events-calendar' ); ?>"
		title="<?php esc_attr_e( 'Next month', 'the-events-calendar' ); ?>"
		data-js="tribe-events-view-link"
		rel="<?php echo esc_attr( $next_rel ); ?>"
	>
		<svg class="tribe-common-c-svgicon tribe-common-c-svgicon--caret-right tribe-common-c-btn-icon__icon-svg tribe-events-c-top-bar__nav-link-icon-svg" width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M7.83708 1.18014C7.90457 1.24755 7.9581 1.3276 7.99463 1.41571C8.03115 1.50382 8.04995 1.59827 8.04995 1.69365C8.04995 1.78903 8.03115 1.88348 7.99463 1.97159C7.9581 2.0597 7.90457 2.13975 7.83708 2.20716L2.54323 7.5001L16.7591 7.5001C16.9516 7.5001 17.1362 7.57657 17.2723 7.71268C17.4084 7.8488 17.4849 8.03341 17.4849 8.22591C17.4849 8.4184 17.4084 8.60301 17.2723 8.73913C17.1362 8.87524 16.9516 8.95171 16.7591 8.95171L2.54323 8.95171L7.83708 14.2447C7.97328 14.3808 8.04979 14.5656 8.04979 14.7582C8.04979 14.9508 7.97328 15.1355 7.83708 15.2717C7.70089 15.4079 7.51618 15.4844 7.32358 15.4844C7.13097 15.4844 6.94626 15.4079 6.81007 15.2717L0.27781 8.73942C0.210327 8.67201 0.156793 8.59196 0.120267 8.50385C0.0837414 8.41574 0.0649411 8.32129 0.0649411 8.22591C0.0649411 8.13053 0.0837414 8.03608 0.120267 7.94797C0.156793 7.85986 0.210327 7.77981 0.27781 7.7124L6.81007 1.18014C6.87748 1.11266 6.95752 1.05912 7.04564 1.0226C7.13375 0.986071 7.22819 0.967271 7.32358 0.967271C7.41896 0.967271 7.51341 0.986071 7.60152 1.0226C7.68963 1.05912 7.76968 1.11266 7.83708 1.18014Z" fill="white"/>
		</svg>
	</a>
</li>
