<?php
/**
 * Settings file to save default brand name.
 *
 * @package gravityforms-organic-vs-direct
 */

/**
 * Class Settings.
 */
class Settings {

	/**
	 * Settings values.
	 *
	 * @var array
	 */
	public $options;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Setup Actions and Filters.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {

		// Actions.
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_action( 'admin_menu', [ $this, 'settings_page' ] );
	}

	/**
	 * Register the settings, section and fields.
	 *
	 * @return void
	 */
	public function register_settings(): void {
		register_setting( 'gravity-forms-organic-vs-direct', 'gravity_forms_organic_vs_direct_brand_name' );

		add_settings_section(
			'gravity_forms_organic_vs_direct_section',
			__( 'Gravity Forms Organic Vs Direct Traffic', 'gravityforms-organic-vs-direct' ),
			'',
			'gravity-forms-organic-vs-direct'
		);

		add_settings_field(
			'gravity_forms_organic_vs_direct_brand_name',
			__( 'Enter Brand Name (to be prefix with utm : brand_web_direct)', 'gravity-forms-organic-vs-direct' ),
			[ $this, 'gravity_forms_organic_vs_direct_brand_name_callback' ],
			'gravity-forms-organic-vs-direct',
			'gravity_forms_organic_vs_direct_section',
		);
	}

	/**
	 * Callback for settings to enter brand name.
	 *
	 * @return void
	 */
	public function gravity_forms_organic_vs_direct_brand_name_callback(): void {

		// option value.
		$brand_name = get_option( 'gravity_forms_organic_vs_direct_brand_name' );
		?>

		<input type="text"
			id="gravity_forms_organic_vs_direct_brand_name"
			name="gravity_forms_organic_vs_direct_brand_name"
			value="<?php echo esc_attr( $brand_name ); ?>"
		>
		<?php
	}

	/**
	 * Function to add settings to `WordPress Settings` submenu
	 *
	 * @return void
	 */
	public function settings_page(): void {

		add_options_page(
			__( 'Gravityforms Organic Vs Direct Traffic Settings', 'gravityforms-organic-vs-direct' ),
			__( 'Gravityforms Organic Vs Direct', 'gravityforms-organic-vs-direct' ),
			'manage_options',
			'gravity_forms_organic_vs_direct',
			[ $this, 'settings_page_template' ]
		);
	}

	/**
	 * Top level menu callback function
	 *
	 * @return void
	 */
	public function settings_page_template(): void {

		// check if user can edit the setting.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		?>
		<div>
			<h1>
				<?php echo esc_html( get_admin_page_title() ); ?>
			</h1>
			<form action="options.php" method="post">
				<?php

				settings_fields( 'gravity-forms-organic-vs-direct' );

				do_settings_sections( 'gravity-forms-organic-vs-direct' );

				submit_button( __( 'Save Settings', 'gravityforms-organic-vs-direct' ) );

				?>
			</form>
		</div>
		<?php
	}
}
