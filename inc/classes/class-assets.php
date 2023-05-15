<?php
/**
 * Register and Enqueue required assets.
 *
 * @package gravityforms-organic-vs-direct
 */

/**
 * class Assets
 */
class Assets {

	/**
	 * Assets Versioning.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Construct method.
	 */
	public function __construct() {
		$this->setup_hooks();
		$this->version = '1.0.0';
	}

	/**
	 * Function to setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {

		// Actions.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ], 10 );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function enqueue_assets(): void {

		// Enqueue Script.

		wp_register_script(
			'gform-capture-traffic',
			GFORMS_ORGANIC_VS_DIRECT_TRAFFIC_FEATURES_URL . '/assets/js/gform-capture-traffic.js',
			array(),
			$this->version,
			true
		);

		if ( class_exists( 'GF_Organic_Vs_Direct_Addon' ) ) {
			$brand_name = GF_Organic_Vs_Direct_Addon::retrive_form_settings( 'gforms_organic_vs_direct_traffic' );
		}

		wp_localize_script(
			'gform-capture-traffic',
			'gFormCaptureTraffic',
			array(
				'brandName' => $brand_name,
			)
		);

		wp_enqueue_script( 'gform-capture-traffic' );
	}

}
