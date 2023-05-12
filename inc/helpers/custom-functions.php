<?php
/**
 * Custom Helper Functions.
 *
 * @package gravityforms-organic-vs-direct
 */

/**
 * Function to check gravity forms exists or not.
 *
 * @return boolean
 */
function gfcpt_check_gravityforms_plugin(): bool {

	if ( ! class_exists( 'GFCommon' ) ) {
		return false;
	}
	return true;

}

/**
 * Function to render the notices.
 *
 * @return void
 */
function gfcpt_render_notices(): void {
	?>
	<div class="error">
		<p><strong><?php esc_html_e( 'GForms Traffic Capture Plugin Problem', 'gravityforms-organic-vs-direct' ); ?></strong></p>

		<p><?php esc_html_e( 'The minimum requirements for Gform Capture Traffic have not been met. Please fix the issue(s) below to use the plugin:', 'gravityforms-organic-vs-direct' ); ?></p>

		<ul style="padding-bottom: 0">
			<li style="padding-left: 20px;list-style: inside"><?php esc_html_e( 'Gravity Forms is required to use GForms Capture Traffic.', 'gravityforms-organic-vs-direct' ); ?></li>
		</ul>
	</div>
	<?php
}
