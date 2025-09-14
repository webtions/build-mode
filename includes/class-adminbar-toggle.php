<?php
/**
 * Adds toggle button to admin bar
 *
 * @package BuildMode
 * @version 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the admin bar toggle button
 *
 * @since 0.1.0
 */
final class Themeist_Build_Mode_Adminbar_Toggle {

	/**
	 * Option key.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private string $option_key;

	/**
	 * Capability to manage Build Mode.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private string $capability;

	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param string $option_key Option key.
	 * @param string $capability Capability string.
	 */
	public function __construct( string $option_key, string $capability ) {
		$this->option_key = $option_key;
		$this->capability = $capability;

		add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_node' ), 90 );
		add_action( 'admin_post_themeist_build_mode_toggle', array( $this, 'handle_toggle' ) );
	}

	/**
	 * Add the toggle button to admin bar
	 *
	 * @since 0.1.0
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar Admin bar instance.
	 */
	public function add_admin_bar_node( $wp_admin_bar ): void {
		if ( ! is_user_logged_in() || ! current_user_can( $this->capability ) ) {
			return;
		}

		$options = get_option( $this->option_key, array() );
		$enabled = ! empty( $options['enabled'] );

		$nonce  = wp_create_nonce( 'themeist_build_mode_toggle' );
		$action = $enabled ? 'disable' : 'enable';

		$url = add_query_arg(
			array(
				'action'   => 'themeist_build_mode_toggle',
				'state'    => $action,
				'_wpnonce' => $nonce,
			),
			admin_url( 'admin-post.php' )
		);

		$title = $enabled ? __( 'Build Mode: ON', 'build-mode' ) : __( 'Build Mode: OFF', 'build-mode' );
		$meta  = array(
			'class' => $enabled ? 'build-mode-on' : 'build-mode-off',
			'title' => $enabled ? __( 'Click to disable', 'build-mode' ) : __( 'Click to enable', 'build-mode' ),
		);

		$wp_admin_bar->add_node(
			array(
				'id'    => 'build-mode',
				'title' => esc_html( $title ),
				'href'  => esc_url( $url ),
				'meta'  => $meta,
			)
		);
	}

	/**
	 * Process the toggle button click
	 *
	 * @since 0.1.0
	 */
	public function handle_toggle(): void {
		if ( ! is_user_logged_in() || ! current_user_can( $this->capability ) ) {
			wp_die( esc_html__( 'You do not have permission to perform this action.', 'build-mode' ) );
		}

		check_admin_referer( 'themeist_build_mode_toggle' );

		$state   = isset( $_GET['state'] ) ? sanitize_key( wp_unslash( (string) $_GET['state'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$options = get_option( $this->option_key, array() );

		if ( 'enable' === $state ) {
			$options['enabled'] = 1;
		} elseif ( 'disable' === $state ) {
			$options['enabled'] = 0;
		}

		update_option( $this->option_key, $options );

		$redirect = wp_get_referer();
		if ( ! $redirect ) {
			$redirect = admin_url();
		}
		wp_safe_redirect( $redirect );
	}
}
