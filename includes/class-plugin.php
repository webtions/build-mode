<?php
/**
 * Main plugin class
 *
 * @package BuildMode
 * @version 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class that loads all the other parts
 *
 * @since 0.1.0
 */
final class Themeist_Build_Mode_Plugin {

	/**
	 * Keep only one instance running
	 *
	 * @since 0.1.0
	 * @var Themeist_Build_Mode_Plugin|null
	 */
	private static ?Themeist_Build_Mode_Plugin $instance = null;

	/**
	 * Where we store our settings in the database
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private string $option_key = 'themeist_build_mode_settings';

	/**
	 * Who can manage the plugin (default: admins only)
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private string $capability = 'manage_options';

	/**
	 * Get the plugin instance (singleton pattern)
	 *
	 * @since 0.1.0
	 * @return Themeist_Build_Mode_Plugin
	 */
	public static function instance(): Themeist_Build_Mode_Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Set up the plugin when it's created
	 *
	 * @since 0.1.0
	 */
	private function __construct() {
		$this->capability = apply_filters( 'build_mode_capability', $this->capability );

		// Load components.
		require_once __DIR__ . '/class-settings.php';
		require_once __DIR__ . '/class-frontend-guard.php';
		require_once __DIR__ . '/class-adminbar-toggle.php';
		require_once __DIR__ . '/class-patterns.php';
		require_once __DIR__ . '/class-onboarding.php';

		// Instantiate components.
		new Themeist_Build_Mode_Settings( $this->option_key, $this->capability );
		new Themeist_Build_Mode_Frontend_Guard( $this->option_key, $this->capability );
		new Themeist_Build_Mode_Adminbar_Toggle( $this->option_key, $this->capability );
		new Themeist_Build_Mode_Patterns();
	}
}
