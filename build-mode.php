<?php
/**
 * Plugin Name:       Build Mode
 * Plugin URI:        https://themeist.com/plugins/wordpress/build-mode/#utm_source=wp-plugin&utm_medium=plugins-page&utm_campaign=build-mode
 * Description:       Maintenance Mode Without the Mess – Pick a page, and Build Mode takes care of the rest.
 * Version:           0.1.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Harish Chouhan
 * Author URI:        https://harishchouhan.com/
 * Author Email:      me@harishchouhan.com
 * Text Domain:       build-mode
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 *
 * @package           BuildMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load the main plugin class
require_once __DIR__ . '/includes/class-plugin.php';

add_action( 'plugins_loaded', function() {
	// Start the plugin
	Themeist_Build_Mode_Plugin::instance();
});

// Clean up when plugin is deleted
function themeist_build_mode_uninstall() {
	delete_option( 'themeist_build_mode_settings' );
}
register_uninstall_hook( __FILE__, 'themeist_build_mode_uninstall' );
