<?php
/**
 * Addon file to register settings to gravity forms.
 *
 * @package gravityforms-organic-vs-direct
 */

/**
 * Class GF_Organic_Vs_Direct_Addon
 */
class GF_Organic_Vs_Direct_Addon extends GFAddOn {

	/**
	 * The version of this add-on.
	 *
	 * @var string
	 */
	protected $_version = '1.0';

	/**
	 * A short, lowercase, URL-safe unique identifier for the add-on. This will be used in option keys, filter, actions, URLs, and text-domain localization. The maximum size allowed for the slug is 33 characters.
	 *
	 * @var string
	 */
	protected $_slug = 'gforms-organic-vs-direct-traffic';

	/**
	 * Same slug as `$_slug` to fetch settings statically.
	 *
	 * @var string
	 */
	protected static $settings_slug = 'gforms-organic-vs-direct-traffic';


	/**
	 * Relative path to the plugin from the plugins folder. Example “gravityforms/gravityforms.php”
	 *
	 * @var string
	 */
	protected $_path = 'gravityforms-organic-vs-direct/gravityforms-organic-vs-direct.php';

	/**
	 * The physical path to the main plugin file. Set this to __FILE__
	 *
	 * @var string
	 */
	protected $_full_path = __FILE__;

	/**
	 * The complete title of the Add-On.
	 *
	 * @var string
	 */
	protected $_title = 'Gravity Forms Organic vs Direct Traffic Addon';

	/**
	 * The short title of the Add-On to be used in limited spaces.
	 *
	 * @var string
	 */
	protected $_short_title = 'GF Organic Vs Direct';

	/**
	 * Current instance on class.
	 *
	 * @var object
	 */
	private static $_instance = null;

	/**
	 * Create an instance of the class.
	 *
	 * @return object
	 */
	public static function get_instance() {

		if ( self::$_instance == null ) {
			self::$_instance = new GF_Organic_Vs_Direct_Addon();
		}

		return self::$_instance;
	}

	/**
	 * Initialise the parent class.
	 *
	 * @return void
	 */
	public function init(): void {

		parent::init();
	}

	/**
	 * Plugin Addon Settings.
	 *
	 * @return array
	 */
	public function plugin_settings_fields(): array {

		return array(
			array(
				'title'  => esc_html__( 'Add Brand Name', 'gravityforms-organic-vs-direct' ),
				'fields' => array(
					array(
						'name'              => 'gforms_organic_vs_direct_traffic',
						'tooltip'           => esc_html__( 'Enter Brand Name here to set the traffic as brandname_web_direct etc.', 'gravityforms-organic-vs-direct' ),
						'label'             => esc_html__( 'Enter Brand Name', 'gravityforms-organic-vs-direct' ),
						'type'              => 'text',
						'class'             => 'small',
						'feedback_callback' => array( $this, 'is_valid_setting' ),
					)
				)
			)
		);
	}

	/**
	 * Function to fetch the setting.
	 *
	 * @param string $name Name of settings to fetch.
	 * @return string
	 */
	public static function retrive_form_settings( string $name ): string {
		$settings =  get_option( 'gravityformsaddon_' . self::$settings_slug . '_settings' );

		return isset( $settings[ $name ] ) ? $settings[ $name ] : null;
	}
}
