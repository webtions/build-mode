<?php
/**
 * Settings page and registration.
 *
 * @package BuildMode
 * @version 0.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build Mode settings handler.
 *
 * @since 0.1.0
 */
final class Themeist_Build_Mode_Settings {

	/**
	 * Option key.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private string $option_key;

	/**
	 * Capability to manage settings.
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

		add_action( 'admin_menu', array( $this, 'add_settings_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add settings page under Settings → Build Mode.
	 *
	 * @since 0.1.0
	 */
	public function add_settings_menu(): void {
		add_options_page(
			__( 'Build Mode', 'build-mode' ),
			__( 'Build Mode', 'build-mode' ),
			$this->capability,
			'themeist-build-mode',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Register settings, sections, fields.
	 *
	 * @since 0.1.0
	 */
	public function register_settings(): void {
		register_setting( $this->option_key, $this->option_key, array( $this, 'sanitize_settings' ) );

		add_settings_section(
			'build_mode_main',
			__( 'Maintenance Settings', 'build-mode' ),
			function (): void {
				echo '<p>' . esc_html__( 'While enabled, visitors see the selected page. Logged-in administrators can browse the site normally.', 'build-mode' ) . '</p>';
			},
			$this->option_key
		);

		add_settings_field(
			'enabled',
			__( 'Enable Build Mode', 'build-mode' ),
			array( $this, 'field_enabled_checkbox' ),
			$this->option_key,
			'build_mode_main',
			array( 'key' => 'enabled' )
		);

		add_settings_field(
			'maintenance_page_id',
			__( 'Maintenance Page', 'build-mode' ),
			array( $this, 'field_page_dropdown' ),
			$this->option_key,
			'build_mode_main',
			array( 'key' => 'maintenance_page_id' )
		);
	}

	/**
	 * Sanitize settings before saving.
	 *
	 * @since 0.1.0
	 *
	 * @param array<string,mixed> $input Raw input.
	 * @return array<string,mixed>
	 */
	public function sanitize_settings( array $input ): array {
		$sanitised = array();

		$enabled              = ! empty( $input['enabled'] ) ? 1 : 0;
		$sanitised['enabled'] = ( 1 === (int) $enabled ) ? 1 : 0;

		$page_id = isset( $input['maintenance_page_id'] ) ? (int) $input['maintenance_page_id'] : 0;
		if ( $page_id > 0 && 'page' === get_post_type( $page_id ) ) {
			$sanitised['maintenance_page_id'] = $page_id;
		} else {
			$sanitised['maintenance_page_id'] = 0;
		}

		return $sanitised;
	}

	/**
	 * Render the enable/disable checkbox
	 *
	 * @since 0.1.0
	 *
	 * @param array{key:string} $args Field args.
	 */
	public function field_enabled_checkbox( array $args ): void {
		$options = get_option( $this->option_key, array() );
		$key     = $args['key'];
		$checked = ! empty( $options[ $key ] );

		printf(
			'<label><input type="checkbox" name="%1$s" value="1" %2$s /> %3$s</label>',
			esc_attr( $this->option_key . '[' . $key . ']' ),
			checked( $checked, true, false ),
			esc_html__( 'When enabled, visitors will see the selected maintenance page.', 'build-mode' )
		);
	}

	/**
	 * Render the page selection dropdown
	 *
	 * @since 0.1.0
	 *
	 * @param array{key:string} $args Field args.
	 */
	public function field_page_dropdown( array $args ): void {
		$options = get_option( $this->option_key, array() );
		$key     = $args['key'];
		$value   = isset( $options[ $key ] ) ? (int) $options[ $key ] : 0;

		$dropdown = wp_dropdown_pages(
			array(
				'name'              => esc_attr( $this->option_key ) . '[' . esc_attr( $key ) . ']',
				'echo'              => 0,
				'show_option_none'  => esc_html__( '-- Select --', 'build-mode' ),
				'option_none_value' => '0',
				'selected'          => absint( $value ),
				'post_status'       => array( 'publish', 'private' ),
			)
		);

		$allowed = array(
			'select' => array(
				'name'  => true,
				'id'    => true,
				'class' => true,
			),
			'option' => array(
				'value'    => true,
				'selected' => true,
			),
		);

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo wp_kses( $dropdown, $allowed );

		if ( $value > 0 ) {
			$edit_url = get_edit_post_link( $value );
			if ( $edit_url ) {
				printf(
					' <a href="%s" class="button" target="_blank">%s <span class="dashicons dashicons-external" style="line-height: 1.3;"></span></a>',
					esc_url( $edit_url ),
					esc_html__( 'Edit Page', 'build-mode' )
				);
			}
		}

		echo '<p class="description">' . esc_html__( 'Choose a page to display to visitors while Build Mode is enabled.', 'build-mode' ) . '</p>';
	}

	/**
	 * Render settings page.
	 *
	 * @since 0.1.0
	 */
	public function render_settings_page(): void {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Build Mode', 'build-mode' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( $this->option_key );
				do_settings_sections( $this->option_key );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
