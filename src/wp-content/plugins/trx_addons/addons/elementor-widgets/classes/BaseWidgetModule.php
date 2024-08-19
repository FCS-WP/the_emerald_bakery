<?php
/**
 * Base Module class
 *
 * @package ThemeREX Addons
 * @since v2.30.0
 */

namespace TrxAddons\ElementorWidgets;

use TrxAddons\ElementorWidgets\BaseModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Base module
 */
abstract class BaseWidgetModule extends BaseModule {

	protected $widget_class = '';
	protected $widget_name  = '';

	protected $assets = array(
		'css' => false,
		'js'  => false,
	);

	/**
	 * Constructor.
	 *
	 * Initializing the module base class.
	 */
	public function __construct() {
		parent::__construct();
		// Module and Widget class names
		$this->widget_class = $this->module_class . 'Widget';
		$this->widget_name  = ElementorWidgets::instance()->widget_data( $this->module_class, 'name' );
		// Register the widget
		add_action( 'elementor/init', array( $this, 'register_widget' ) );
		// Enqueue scripts and styles
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts_front' ), TRX_ADDONS_ENQUEUE_SCRIPTS_PRIORITY );
		add_action( 'trx_addons_action_pagebuilder_preview_scripts', array( $this, 'load_scripts_front' ), 10, 1 );
		// Merge styles to the single stylesheet
		add_filter( 'trx_addons_filter_merge_styles', array( $this, 'merge_styles' ) );
		// Merge scripts to the single file
		add_filter( 'trx_addons_filter_merge_scripts', array( $this, 'merge_scripts' ) );
	}
	
	/**
	 * Create and register widget
	 * 
	 * @hooked 'elementor/init'
	 */
	public function register_widget() {
		$widget = "TrxAddons\\ElementorWidgets\\Widgets\\{$this->module_class}\\{$this->widget_class}";
		trx_addons_elm_register_widget( new $widget() );
	}

	/**
	 * Get module relative path to the assets folder
	 * 
	 * @return string  Relative path to the assets folder in the module folder.
	 */
	public function get_assets_path( $file ) {
		return TRX_ADDONS_PLUGIN_ADDONS . 'elementor-widgets/classes/Widgets/' . $this->module_class . ( substr( $file, 0, 3 ) == '../' ? '/' : '/assets/' ) . $file;
	}

	/**
	 * Load required styles and scripts for the frontend
	 * 
	 * @hooked wp_enqueue_scripts
	 * @hooked trx_addons_action_pagebuilder_preview_scripts
	 * 
	 * @param bool $force  Optional. Force load scripts. Default is false.
	 */
	public function load_scripts_front( $force = false ) {
		if ( ! $this->assets['css'] && ! $this->assets['js'] ) {
			return;
		}
		$slug = str_replace( 'trx-elm-', 'trx-addons-elm-', str_replace( '_', '-', $this->widget_name ) );
		$assets = array(
			'check' => array(
				array( 'type' => 'elm', 'sc' => '"widgetType":"' . $this->widget_name . '"' ),
			)
		);
		if ( $this->assets['css'] ) {
			$assets['css'] = array(
				$slug => array( 'src' => $this->get_assets_path( "{$this->module_class}.css" ) ),
			);
		}
		if ( $this->assets['js'] ) {
			$assets['js'] = array(
				$slug => array( 'src' => $this->get_assets_path( "{$this->module_class}.js" ), 'deps' => 'jquery' ),
			);
		}
		if ( ! empty( $this->assets['localize'] ) && is_array( $this->assets['localize'] ) ) {
			$assets['localize'] = array(
				$slug => $this->assets['localize']
			);
		}
		if ( ! empty( $this->assets['lib'] ) && is_array( $this->assets['lib'] ) ) {
			$assets['lib'] = array();
			foreach ( array( 'js', 'css' ) as $type ) {
				if ( ! empty( $this->assets['lib'][ $type ] ) && is_array( $this->assets['lib'][ $type ] ) ) {
					foreach ( $this->assets['lib'][ $type ] as $handle => $params ) {
						if ( empty( $params['src'] ) ) {
							$assets['lib'][ $type ][ $handle ] = true;
						} else {
							$assets['lib'][ $type ][ $handle ] = array_merge( $params, array( 'src' => $this->get_assets_path( $params['src'] ) ) );
						}
					}
				}
			}
		}
		trx_addons_enqueue_optimized( $this->widget_name, $force, $assets );
	}

	/**
	 * Merge styles to the single stylesheet
	 * 
	 * @hooked trx_addons_filter_merge_styles
	 * 
	 * @param array $list  List of the styles
	 * 
	 * @return array  Modified list of the styles
	 */
	public function merge_styles( $list ) {
		if ( $this->assets['css'] ) {
			$list[ $this->get_assets_path( "{$this->module_class}.css" ) ] = false;
		}
		return $list;
	}
	
	/**
	 * Merge scripts to the single file
	 * 
	 * @hooked trx_addons_filter_merge_scripts
	 * 
	 * @param array $list  List of the scripts
	 * 
	 * @return array  Modified list of the scripts
	 */
	public function merge_scripts( $list ) {
		if ( $this->assets['js'] ) {
			$list[ $this->get_assets_path( "{$this->module_class}.js" ) ] = false;
		}
		return $list;
	}
}
