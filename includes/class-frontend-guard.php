<?php
/**
 * Handles the frontend maintenance page display
 *
 * @package BuildMode
 * @version 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shows maintenance page to visitors when enabled
 *
 * @since 0.1.0
 */
final class Themeist_Build_Mode_Frontend_Guard {

	/**
	 * Option key.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private string $option_key;

	/**
	 * Capability to bypass Build Mode.
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

		add_action( 'template_redirect', array( $this, 'maybe_render_maintenance_page' ), 0 );
	}

	/**
	 * Check if we should show maintenance page to this visitor
	 *
	 * @since 0.1.0
	 * @return int|false Page ID if should intercept, false otherwise.
	 */
	private function should_intercept() {
		$options = get_option( $this->option_key, array() );
		$enabled = ! empty( $options['enabled'] );
		$page_id = isset( $options['maintenance_page_id'] ) ? (int) $options['maintenance_page_id'] : 0;

		if ( ! $enabled || $page_id <= 0 ) {
			return false;
		}

		// Admins bypass.
		if ( is_user_logged_in() && current_user_can( $this->capability ) ) {
			return false;
		}

		// Admin/cron/ajax/customizer bypass.
		if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || is_customize_preview() ) {
			return false;
		}

		// REST/XML-RPC/feeds/embed bypass.
		if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) ) {
			return false;
		}
		if ( is_feed() || is_embed() ) {
			return false;
		}

		// Login & admin paths bypass.
		$request_uri = isset( $_SERVER['REQUEST_URI'] )
			? sanitize_text_field( wp_unslash( (string) $_SERVER['REQUEST_URI'] ) )
			: '';
		if ( false !== strpos( $request_uri, 'wp-login.php' ) || false !== strpos( $request_uri, 'wp-admin/' ) ) {
			return false;
		}

		// Static assets bypass (rough check).
		if ( preg_match( '#\.(?:css|js|map|jpe?g|png|gif|webp|svg|ico|woff2?|ttf|eot)(?:\?.*)?$#i', $request_uri ) ) {
			return false;
		}

		// robots.txt & sitemap.* bypass.
		$path     = wp_parse_url( $request_uri, PHP_URL_PATH );
		$basename = strtolower( basename( $path ?? '' ) );
		if ( 'robots.txt' === $basename || 0 === strpos( $basename, 'sitemap' ) ) {
			return false;
		}

		return $page_id;
	}

	/**
	 * Show the maintenance page to visitors
	 *
	 * @since 0.1.0
	 */
	public function maybe_render_maintenance_page(): void {
		$page_id = $this->should_intercept();
		if ( ! $page_id ) {
			return;
		}

		// Send headers (default 1 day; clamp to 60..1 day).
		$retry_after = (int) apply_filters( 'build_mode_retry_after', DAY_IN_SECONDS );
		$retry_after = max( 60, min( $retry_after, DAY_IN_SECONDS ) );

		status_header( 503 );
		if ( ! headers_sent() ) {
			header( 'Retry-After: ' . $retry_after );
		}
		nocache_headers();

		// Get post object.
		$post = get_post( $page_id );
		if ( ! $post || 'page' !== $post->post_type ) {
			wp_die( esc_html__( 'Maintenance page not found.', 'build-mode' ), 503 );
		}

		// Prepare content (blocks/shortcodes/embeds).
		setup_postdata( $post );
		$content = apply_filters( 'the_content', $post->post_content );
		wp_reset_postdata();

		// Output minimal HTML wrapper (keeps wp_head/wp_footer for styles/scripts).
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<head>
			<meta charset="<?php bloginfo( 'charset' ); ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<?php wp_head(); ?>
		</head>
		<body <?php body_class( 'build-mode' ); ?>>
			<?php
			// Output rendered content. This mirrors core `the_content()` usage:
			// escaping here would break HTML produced by shortcodes/blocks.
			// KSES is enforced on save for users without `unfiltered_html`.
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $content;
			?>
			<?php wp_footer(); ?>
		</body>
		</html>
		<?php

		exit;
	}
}
