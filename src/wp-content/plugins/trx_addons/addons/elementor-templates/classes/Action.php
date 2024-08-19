<?php
/**
 * Add custom control for Elementor.
 *
 * @package ThemeREX Addons
 * @since v2.30.0
 */

namespace TrxAddons\ElementorTemplates;

use Elementor\Base_Data_Control;

/**
 * Action class.
 */
class Action extends Base_Data_Control {
	/**
	 * Get control type.
	 * Retrieve the control type.
	 *
	 * @access public
	 */
	public function get_type() {
		return 'trx_addons_elementor_extension_action';
	}

	/**
	 * Get data control value.
	 * Retrieve the value of the data control from a specific Controls_Stack settings.
	 *
	 * @param array $control  Control.
	 * @param array $settings Element settings.
	 *
	 * @access public
	 *
	 * @return bool
	 */
	public function get_value( $control, $settings ) {
		return false;
	}

	/**
	 * Get data control default value.
	 *
	 * Retrieve the default value of the data control. Used to return the default
	 * values while initializing the data control.
	 *
	 * @access public
	 * @return string Control default value.
	 */
	public function get_default_value() {
		return '';
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'trx_addons_elementor_extension_action', trx_addons_get_file_url( TRX_ADDONS_PLUGIN_ADDONS . 'elementor-templates/js/action.js' ), array( 'jquery' ), null, false );

		$schemes = trx_addons_get_theme_color_schemes();
		if ( empty( $schemes ) || ! is_array( $schemes ) ) {
			$schemes = array();
		}

		// $fonts = trx_addons_get_theme_fonts();
		// if ( empty( $fonts ) || ! is_array( $fonts ) ) {
		// 	$fonts = array();
		// }
		
		wp_localize_script( 'trx_addons_elementor_extension_action', 'TRX_ADDONS_ELEMENTOR_EXTENSION_ACTION', array(
				'cssDir'          => \Elementor\Core\Files\Base::get_base_uploads_url() . \Elementor\Core\Files\Base::DEFAULT_FILES_DIR,
				'globalKit'       => get_option( 'elementor_active_kit' ),
				'schemes'         => $schemes,
				//'fonts'           => $fonts,
				'translate'       => array(
					'resetHeader'                  => __( 'Are you sure?', 'trx_addons' ),
					'resetGlobalColorsMessage'     => __( 'This will revert the color palette and the color labels to their defaults. You can undo this action from the revisions tab.', 'trx_addons' ),
					'resetGlobalFontsMessage'      => __( 'This will revert the global font labels & values to their defaults. You can undo this action from the revisions tab.', 'trx_addons' ),
				)
			)
		);
	}

	/**
	 * Get default control settings.
	 *
	 * @since 1.6.0
	 * @return array
	 */
	protected function get_default_settings() {
		return array(
			'button_type' => 'success',
		);
	}

	/**
	 * Control Content template.
	 *
	 * {@inheritDoc}
	 *
	 * @since 1.6.0 Added data.button_type class to button.
	 * @return void
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<button
					data-action="{{ data.action }}"
					style="padding:7px 10px"
					class="elementor-button elementor-button-{{{ data.button_type }}}"
				>
				{{{ data.action_label }}}</button>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
