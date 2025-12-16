<?php
/**
 * Handles onboarding and one-click setup.
 *
 * @package BuildMode
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper to create pages with patterns.
 *
 * @since 1.0.0
 */
class Themeist_Build_Mode_Onboarding {

	/**
	 * Create the maintenance page.
	 *
	 * @return int|\WP_Error Page ID on success, WP_Error on failure.
	 */
	public static function create_maintenance_page() {
		$page_data = array(
			'post_title'   => __( 'Maintenance', 'build-mode' ),
			'post_status'  => 'publish',
			'post_type'    => 'page',
			// Use the pattern slug we registered in class-patterns.php.
			'post_content' => '<!-- wp:pattern {"slug":"build-mode/simple-maintenance"} /-->',
		);

		return wp_insert_post( $page_data );
	}
}
