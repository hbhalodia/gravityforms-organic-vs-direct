<?php
/**
 * Plugin Name: Gravity Forms Organic Vs Direct Traffic
 * Description: To capture the user traffic on form submission wether user has submitted the form is being acquired to website via direct or organic.
 * Plugin URI:  https://rtcamp.com
 * Author:      rtCamp
 * Author URI:  https://rtcamp.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.0.1
 * Text Domain: gravityforms-organic-vs-direct
 *
 * @package gravityforms-organic-vs-direct
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'GFORMS_ORGANIC_VS_DIRECT_TRAFFIC_FEATURES_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'GFORMS_ORGANIC_VS_DIRECT_TRAFFIC_FEATURES_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

require_once GFORMS_ORGANIC_VS_DIRECT_TRAFFIC_FEATURES_PATH . '/inc/helpers/custom-functions.php';

/**
 * Function to check plugin dependency on activation hook.
 *
 * @return void
 */
function check_plugin_dependency() {

	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	}

	$gform_exists = gfcpt_check_gravityforms_plugin();

	if ( ! $gform_exists ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );

		die( wp_kses_post( gfcpt_render_notices() ) );
	}

}
register_activation_hook( __FILE__, 'check_plugin_dependency' );

if ( ! class_exists( 'GForms_Config' ) ) {
	require_once GFORMS_ORGANIC_VS_DIRECT_TRAFFIC_FEATURES_PATH . '/inc/classes/class-gforms-config.php';

	new GForms_Config();
}

if ( ! class_exists( 'Assets' ) ) {
	require_once GFORMS_ORGANIC_VS_DIRECT_TRAFFIC_FEATURES_PATH . '/inc/classes/class-assets.php';

	new Assets();
}
