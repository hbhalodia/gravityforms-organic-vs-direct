<?php
/**
 * Gravity Forms Configuration.
 *
 * @package gravityforms-organic-vs-direct
 */

/**
 * Class GForms_Config
 */
class GForms_Config {

	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Setup Hooks and Actions.
	 *
	 * @return void
	 */
	public function setup_hooks(): void {

		// Filters.
		add_filter( 'gform_field_css_class', [ $this, 'add_custom_css_clas_hidden_field' ], 10, 2 );
	}

	/**
	 * Function to add classes to gravity form based on label.
	 * So that we can target hidden input field and change it's value runtime.
	 *
	 * @param string $classes The CSS classes to be filtered, separated by empty spaces
	 * @param Object $field   Current field
	 *
	 * @return string Modified Classes
	 */
	public function add_custom_css_clas_hidden_field( $classes, $field ): string {

		if ( ! property_exists( $field, 'type' ) || ! property_exists( $field, 'label' ) ) {
			return $classes;
		}

		if ( 'hidden' !== $field->type || empty( $field->label ) ) {
			return $classes;
		}

		if ( str_contains( $classes, $field->label ) ) {
			return $classes;
		}

		$classes .= ' ' . $field->label;

		return $classes;
	}
}
