<?php
/**
 * Pricing Table Widget
 *
 * @package ThemeREX Addons
 * @since v2.30.0
 */

namespace TrxAddons\ElementorWidgets\Widgets\PricingTable;

use TrxAddons\ElementorWidgets\BaseWidget;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Pricing Table Widget
 */
class PricingTableWidget extends BaseWidget {

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */
	protected function register_controls() {
		/* Content Tab */
		$this->register_content_header_controls();
		$this->register_content_pricing_controls();
		$this->register_content_features_controls();
		$this->register_content_ribbon_controls();
		$this->register_content_tooltip_controls();
		$this->register_content_button_controls();
		$this->register_content_help_docs_controls();

		/* Style Tab */
		$this->register_style_table_controls();
		$this->register_style_header_controls();
		$this->register_style_pricing_controls();
		$this->register_style_features_controls();
		$this->register_style_tooltip_controls();
		$this->register_style_ribbon_controls();
		$this->register_style_button_controls();
		$this->register_style_footer_controls();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_content_header_controls() {
		/**
		 * Content Tab: Header
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_header',
			[
				'label'                 => __( 'Header', 'trx_addons' ),
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label'                 => esc_html__( 'Icon Type', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'none'        => [
						'title'   => esc_html__( 'None', 'trx_addons' ),
						'icon'    => 'eicon-ban',
					],
					'icon'        => [
						'title'   => esc_html__( 'Icon', 'trx_addons' ),
						'icon'    => 'eicon-star',
					],
					'image'       => [
						'title'   => esc_html__( 'Image', 'trx_addons' ),
						'icon'    => 'eicon-image-bold',
					],
				],
				'default'               => 'none',
			]
		);

		$this->add_control(
			'select_table_icon',
			[
				'label'                 => __( 'Icon', 'trx_addons' ),
				'type'                  => Controls_Manager::ICONS,
				'fa4compatibility'      => 'table_icon',
				'default'               => [
					'value'     => 'fas fa-star',
					'library'   => 'fa-solid',
				],
				'condition'             => [
					'icon_type'     => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_image',
			[
				'label'                 => __( 'Image', 'trx_addons' ),
				'type'                  => Controls_Manager::MEDIA,
				'default'               => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'             => [
					'icon_type'  => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'image', // Usage: '{name}_size' and '{name}_custom_dimension', in this case 'image_size' and 'image_custom_dimension'.
				'default'               => 'full',
				'separator'             => 'none',
				'condition'             => [
					'icon_type'  => 'image',
				],
			]
		);

		$this->add_control(
			'table_title',
			[
				'label'                 => __( 'Title', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => __( 'Title', 'trx_addons' ),
				'title'                 => __( 'Enter table title', 'trx_addons' ),
			]
		);

		$this->add_control(
			'title_html_tag',
			array(
				'label'   => __( 'Title HTML Tag', 'trx_addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => array(
					'h1'   => __( 'H1', 'trx_addons' ),
					'h2'   => __( 'H2', 'trx_addons' ),
					'h3'   => __( 'H3', 'trx_addons' ),
					'h4'   => __( 'H4', 'trx_addons' ),
					'h5'   => __( 'H5', 'trx_addons' ),
					'h6'   => __( 'H6', 'trx_addons' ),
					'div'  => __( 'div', 'trx_addons' ),
					'span' => __( 'span', 'trx_addons' ),
					'p'    => __( 'p', 'trx_addons' ),
				),
			)
		);

		$this->add_control(
			'table_subtitle',
			[
				'label'                 => __( 'Subtitle', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => __( 'Subtitle', 'trx_addons' ),
				'title'                 => __( 'Enter table subtitle', 'trx_addons' ),
			]
		);

		$this->add_control(
			'subtitle_html_tag',
			array(
				'label'   => __( 'Subtitle HTML Tag', 'trx_addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => array(
					'h1'   => __( 'H1', 'trx_addons' ),
					'h2'   => __( 'H2', 'trx_addons' ),
					'h3'   => __( 'H3', 'trx_addons' ),
					'h4'   => __( 'H4', 'trx_addons' ),
					'h5'   => __( 'H5', 'trx_addons' ),
					'h6'   => __( 'H6', 'trx_addons' ),
					'div'  => __( 'div', 'trx_addons' ),
					'span' => __( 'span', 'trx_addons' ),
					'p'    => __( 'p', 'trx_addons' ),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function register_content_pricing_controls() {
		/**
		 * Content Tab: Pricing
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_pricing',
			[
				'label'                 => __( 'Pricing', 'trx_addons' ),
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label'                 => __( 'Currency Symbol', 'trx_addons' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					''             => __( 'None', 'trx_addons' ),
					'dollar'       => '&#36; ' . __( 'Dollar', 'trx_addons' ),
					'euro'         => '&#128; ' . __( 'Euro', 'trx_addons' ),
					'baht'         => '&#3647; ' . __( 'Baht', 'trx_addons' ),
					'franc'        => '&#8355; ' . __( 'Franc', 'trx_addons' ),
					'guilder'      => '&fnof; ' . __( 'Guilder', 'trx_addons' ),
					'krona'        => 'kr ' . __( 'Krona', 'trx_addons' ),
					'lira'         => '&#8356; ' . __( 'Lira', 'trx_addons' ),
					'peseta'       => '&#8359 ' . __( 'Peseta', 'trx_addons' ),
					'peso'         => '&#8369; ' . __( 'Peso', 'trx_addons' ),
					'pound'        => '&#163; ' . __( 'Pound Sterling', 'trx_addons' ),
					'real'         => 'R$ ' . __( 'Real', 'trx_addons' ),
					'ruble'        => '&#8381; ' . __( 'Ruble', 'trx_addons' ),
					'rupee'        => '&#8360; ' . __( 'Rupee', 'trx_addons' ),
					'indian_rupee' => '&#8377; ' . __( 'Rupee (Indian)', 'trx_addons' ),
					'shekel'       => '&#8362; ' . __( 'Shekel', 'trx_addons' ),
					'yen'          => '&#165; ' . __( 'Yen/Yuan', 'trx_addons' ),
					'won'          => '&#8361; ' . __( 'Won', 'trx_addons' ),
					'custom'       => __( 'Custom', 'trx_addons' ),
				],
				'default'               => 'dollar',
			]
		);

		$this->add_control(
			'currency_symbol_custom',
			[
				'label'                 => __( 'Custom Symbol', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => '',
				'condition'             => [
					'currency_symbol'   => 'custom',
				],
			]
		);

		$this->add_control(
			'table_price',
			[
				'label'                 => __( 'Price', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => '49.99',
			]
		);

		$this->add_control(
			'currency_format',
			[
				'label'                 => __( 'Currency Format', 'trx_addons' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'raised',
				'options'               => [
					'raised' => __( 'Raised', 'trx_addons' ),
					''       => __( 'Normal', 'trx_addons' ),
				],
			]
		);

		$this->add_control(
			'discount',
			[
				'label'                 => __( 'Discount', 'trx_addons' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => __( 'On', 'trx_addons' ),
				'label_off'             => __( 'Off', 'trx_addons' ),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'table_original_price',
			[
				'label'                 => __( 'Original Price', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => '69',
				'condition'             => [
					'discount' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_duration',
			[
				'label'                 => __( 'Duration', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'default'               => __( 'per month', 'trx_addons' ),
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_features_controls() {
		/**
		 * Content Tab: Features
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_features',
			[
				'label'                 => __( 'Features', 'trx_addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_features_content' );

		$repeater->start_controls_tab(
			'tab_features_content',
			[
				'label' => __( 'Content', 'trx_addons' ),
			]
		);

		$repeater->add_control(
			'feature_text',
			array(
				'label'       => __( 'Text', 'trx_addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => '3',
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => __( 'Feature', 'trx_addons' ),
				'default'     => __( 'Feature', 'trx_addons' ),
			)
		);

		$repeater->add_control(
			'exclude',
			array(
				'label'        => __( 'Exclude', 'trx_addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'trx_addons' ),
				'label_off'    => __( 'No', 'trx_addons' ),
				'return_value' => 'yes',
			)
		);

		$repeater->add_control(
			'select_feature_icon',
			array(
				'label'            => __( 'Icon', 'trx_addons' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'default'          => array(
					'value'   => 'far fa-arrow-alt-circle-right',
					'library' => 'fa-regular',
				),
				'fa4compatibility' => 'feature_icon',
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_features_tooltip',
			[
				'label' => __( 'Tooltip', 'trx_addons' ),
			]
		);

		$repeater->add_control(
			'tooltip_content',
			array(
				'label'       => __( 'Tooltip Content', 'trx_addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __( 'This is a tooltip', 'trx_addons' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_features_style',
			[
				'label' => __( 'Style', 'trx_addons' ),
			]
		);

		$repeater->add_control(
			'feature_icon_color',
			array(
				'label'     => __( 'Icon Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .trx-addons-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .trx-addons-icon svg' => 'fill: {{VALUE}}',
				),
				'condition' => array(
					'select_feature_icon[value]!' => '',
				),
			)
		);

		$repeater->add_control(
			'feature_text_color',
			array(
				'label'     => __( 'Text Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'feature_bg_color',
			array(
				'name'      => 'feature_bg_color',
				'label'     => __( 'Background Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'table_features',
			array(
				'label'       => '',
				'type'        => Controls_Manager::REPEATER,
				'default'     => array(
					array(
						'feature_text'        => __( 'Feature #1', 'trx_addons' ),
						'select_feature_icon' => 'fa fa-check',
					),
					array(
						'feature_text'        => __( 'Feature #2', 'trx_addons' ),
						'select_feature_icon' => 'fa fa-check',
					),
					array(
						'feature_text'        => __( 'Feature #3', 'trx_addons' ),
						'select_feature_icon' => 'fa fa-check',
					),
				),
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ feature_text }}}',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Pricing Table Tooltip Controls
	 *
	 * @since 2.2.5
	 * @return void
	 */
	protected function register_content_tooltip_controls() {
		$this->start_controls_section(
			'section_tooltip',
			[
				'label'                 => __( 'Tooltip', 'trx_addons' ),
			]
		);

		$this->add_control(
			'show_tooltip',
			[
				'label'                 => __( 'Enable Tooltip', 'trx_addons' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => __( 'Yes', 'trx_addons' ),
				'label_off'             => __( 'No', 'trx_addons' ),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'tooltip_display_on',
			array(
				'label'   => __( 'Display On', 'trx_addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => array(
					'text' => __( 'Text', 'trx_addons' ),
					'icon' => __( 'Icon', 'trx_addons' ),
				),
				'frontend_available' => true,
				'condition' => [
					'show_tooltip' => 'yes',
				],
			)
		);

		$this->add_control(
			'tooltip_icon',
			[
				'label'     => __( 'Icon', 'trx_addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-info-circle',
					'library' => 'fa-solid',
				],
				'condition' => [
					'show_tooltip'       => 'yes',
					'tooltip_display_on' => 'icon',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_ribbon_controls() {
		/**
		 * Content Tab: Ribbon
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_ribbon',
			[
				'label'                 => __( 'Ribbon', 'trx_addons' ),
			]
		);

		$this->add_control(
			'show_ribbon',
			[
				'label'                 => __( 'Show Ribbon', 'trx_addons' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => __( 'Yes', 'trx_addons' ),
				'label_off'             => __( 'No', 'trx_addons' ),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'ribbon_style',
			[
				'label'                => __( 'Style', 'trx_addons' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => '1',
				'options'              => [
					'1'         => __( 'Default', 'trx_addons' ),
					'2'         => __( 'Circle', 'trx_addons' ),
					'3'         => __( 'Flag', 'trx_addons' ),
				],
				'condition'             => [
					'show_ribbon'  => 'yes',
				],
			]
		);

		$this->add_control(
			'ribbon_title',
			[
				'label'                 => __( 'Title', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => __( 'New', 'trx_addons' ),
				'condition'             => [
					'show_ribbon'  => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_size',
			[
				'label'                 => __( 'Size', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', 'em' ],
				'range'                 => [
					'px' => [
						'min'   => 1,
						'max'   => 200,
					],
					'em' => [
						'min'   => 1,
						'max'   => 15,
					],
				],
				'default'               => [
					'size'      => 4,
					'unit'      => 'em',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-ribbon-2' => 'min-width: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_ribbon'  => 'yes',
					'ribbon_style' => [ '2' ],
				],
			]
		);

		$this->add_responsive_control(
			'top_distance',
			[
				'label'                 => __( 'Distance from Top', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'size_units'            => [ 'px', '%' ],
				'range'                 => [
					'px' => [
						'min'   => 1,
						'max'   => 200,
					],
				],
				'default'               => [
					'size'      => 20,
					'unit'      => '%',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-ribbon' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'show_ribbon'  => 'yes',
					'ribbon_style' => [ '2', '3' ],
				],
			]
		);

		$ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

		$this->add_responsive_control(
			'ribbon_distance',
			[
				'label'                 => __( 'Distance', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-ribbon-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
				],
				'condition'             => [
					'show_ribbon'  => 'yes',
					'ribbon_style' => [ '1' ],
				],
			]
		);

		$this->add_control(
			'ribbon_position',
			[
				'label'                 => __( 'Position', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'toggle'                => false,
				'label_block'           => false,
				'options'               => [
					'left'  => [
						'title' => __( 'Left', 'trx_addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'trx_addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'               => 'right',
				'condition'             => [
					'show_ribbon'  => 'yes',
					'ribbon_style' => [ '1', '2', '3' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_button_controls() {
		/**
		 * Content Tab: Button
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_button',
			[
				'label'                 => __( 'Button', 'trx_addons' ),
			]
		);

		$this->add_control(
			'table_button_position',
			[
				'label'                => __( 'Button Position', 'trx_addons' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'below',
				'options'              => [
					'above'    => __( 'Above Features', 'trx_addons' ),
					'below'    => __( 'Below Features', 'trx_addons' ),
					'none'    => __( 'None', 'trx_addons' ),
				],
			]
		);

		$this->add_control(
			'table_button_text',
			[
				'label'                 => __( 'Button Text', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => __( 'Get Started', 'trx_addons' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'                 => __( 'Link', 'trx_addons' ),
				'label_block'           => true,
				'type'                  => Controls_Manager::URL,
				'dynamic'               => [
					'active'   => true,
				],
				'placeholder'           => 'https://www.your-link.com',
				'default'               => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'table_additional_info',
			[
				'label'                 => __( 'Additional Info', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXTAREA,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => __( 'Enter additional info here', 'trx_addons' ),
				'title'                 => __( 'Additional Info', 'trx_addons' ),
			]
		);

		$this->end_controls_section();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_style_table_controls() {
		/**
		 * Content Tab: Table
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_table_style',
			[
				'label'                 => __( 'Table', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_align',
			[
				'label'                 => __( 'Alignment', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'trx_addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'trx_addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'trx_addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'               => '',
				'prefix_class'      => 'trx-addons-pricing-table-align-',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_header_controls() {
		/**
		 * Style Tab: Header
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_table_header_style',
			[
				'label'                 => __( 'Header', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_title_bg_color',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'global'                => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-head' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'table_header_border',
				'label'                 => __( 'Border', 'trx_addons' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-head',
			]
		);

		$this->add_responsive_control(
			'table_title_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-head' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_title_icon',
			[
				'label'                 => __( 'Icon', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'icon_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'table_icon_size',
			[
				'label'                 => __( 'Size', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'unit' => 'px',
					'size' => 26,
				],
				'range'                 => [
					'px' => [
						'min'   => 5,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px', 'em' ],
				'condition'             => [
					'icon_type'   => 'icon',
					'select_table_icon[value]!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_icon_image_width',
			[
				'label'                 => __( 'Width', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size' => 120,
					'unit' => 'px',
				],
				'range'                 => [
					'px' => [
						'min'   => 1,
						'max'   => 1200,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px', '%' ],
				'condition'             => [
					'icon_type'        => 'image',
					'icon_image[url]!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-icon' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'table_icon_bg_color',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'condition'             => [
					'icon_type!' => 'none',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-icon' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_icon_color',
			[
				'label'                 => __( 'Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#ffffff',
				'condition'             => [
					'icon_type'   => 'icon',
					'select_table_icon[value]!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .trx-addons-pricing-table-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_icon_margin',
			[
				'label'                 => __( 'Margin', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'condition'             => [
					'icon_type!' => 'none',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_icon_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'condition'             => [
					'icon_type!' => 'none',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'table_icon_border',
				'label'                 => __( 'Border', 'trx_addons' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'condition'             => [
					'icon_type!' => 'none',
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-icon',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'                 => __( 'Border Radius', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em' ],
				'condition'             => [
					'icon_type!' => 'none',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-icon, {{WRAPPER}} .trx-addons-pricing-table-icon img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_title_heading',
			[
				'label'                 => __( 'Title', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'table_title_color',
			[
				'label'                 => __( 'Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#fff',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'table_title_typography',
				'label'                 => __( 'Typography', 'trx_addons' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-title',
			]
		);

		$this->add_control(
			'table_subtitle_heading',
			[
				'label'                 => __( 'Sub Title', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'table_subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'table_subtitle_color',
			[
				'label'                 => __( 'Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#fff',
				'condition'             => [
					'table_subtitle!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-subtitle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'table_subtitle_typography',
				'label'                 => __( 'Typography', 'trx_addons' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'condition'             => [
					'table_subtitle!' => '',
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-subtitle',
			]
		);

		$this->add_responsive_control(
			'table_subtitle_spacing',
			[
				'label'                 => __( 'Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px', '%' ],
				'condition'             => [
					'table_subtitle!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-subtitle' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_pricing_controls() {
		/**
		 * Style Tab: Pricing
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_table_pricing_style',
			[
				'label'                 => __( 'Pricing', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'table_pricing_typography',
				'label'                 => __( 'Typography', 'trx_addons' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-price',
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'table_price_color_normal',
			[
				'label'                 => __( 'Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_price_bg_color_normal',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'price_border_normal',
				'label'                 => __( 'Border', 'trx_addons' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-price',
			]
		);

		$this->add_control(
			'pricing_border_radius',
			[
				'label'                 => __( 'Border Radius', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_pricing_width',
			[
				'label'                 => __( 'Width', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'%' => [
						'min'   => 1,
						'max'   => 100,
						'step'  => 1,
					],
					'px' => [
						'min'   => 25,
						'max'   => 1200,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_price_margin',
			[
				'label'                 => __( 'Margin', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_price_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'pa_logo_wrapper_shadow',
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-price',
			]
		);

		$this->add_control(
			'table_curreny_heading',
			[
				'label'                 => __( 'Currency Symbol', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition' => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'currency_size',
			[
				'label'                 => __( 'Size', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price-prefix' => 'font-size: calc({{SIZE}}em/100)',
				],
				'condition'             => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'currency_position',
			[
				'label'                 => __( 'Position', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'default'               => 'before',
				'options'               => [
					'before' => [
						'title' => __( 'Before', 'trx_addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'after' => [
						'title' => __( 'After', 'trx_addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
			]
		);

		$this->add_control(
			'currency_vertical_position',
			[
				'label'                 => __( 'Vertical Position', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'top'       => [
						'title' => __( 'Top', 'trx_addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle'    => [
						'title' => __( 'Middle', 'trx_addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'    => [
						'title' => __( 'Bottom', 'trx_addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'               => 'top',
				'selectors_dictionary'  => [
					'top'      => 'flex-start',
					'middle'   => 'center',
					'bottom'   => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price-prefix' => 'align-self: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_duration_heading',
			[
				'label'                 => __( 'Duration', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'duration_position',
			[
				'label'                => __( 'Duration Position', 'trx_addons' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'wrap',
				'options'              => [
					'nowrap'    => __( 'Same Line', 'trx_addons' ),
					'wrap'      => __( 'Next Line', 'trx_addons' ),
				],
				'prefix_class' => 'trx-addons-pricing-table-price-duration-',
			]
		);

		$this->add_control(
			'duration_text_color',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price-duration' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'duration_typography',
				'label'                 => __( 'Typography', 'trx_addons' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-price-duration',
			]
		);

		$this->add_responsive_control(
			'duration_spacing',
			[
				'label'                 => __( 'Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}}.trx-addons-pricing-table-price-duration-wrap .trx-addons-pricing-table-price-duration' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'duration_position' => 'wrap',
				],
			]
		);

		$this->add_control(
			'table_original_price_style_heading',
			[
				'label'                 => __( 'Original Price', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'discount' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_original_price_text_color',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'condition'             => [
					'discount' => 'yes',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price-original' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_original_price_text_size',
			[
				'label'                 => __( 'Font Size', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 5,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px', 'em' ],
				'condition'             => [
					'discount' => 'yes',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-price-original' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_features_controls() {
		/**
		 * Style Tab: Features
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_table_features_style',
			[
				'label'                 => __( 'Features', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_features_align',
			[
				'label'                 => __( 'Alignment', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'trx_addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'trx_addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'trx_addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features'   => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_features_bg_color',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_features_text_color',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'global'                => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_features_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'default'               => [
					'top'       => '20',
					'right'     => '',
					'bottom'    => '20',
					'left'      => '',
					'unit'      => 'px',
					'isLinked'  => false,
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_features_margin',
			[
				'label'                 => __( 'Margin Bottom', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 60,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'table_features_typography',
				'label'                 => __( 'Typography', 'trx_addons' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-features',
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'table_features_icon_heading',
			[
				'label'                 => __( 'Icon', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'table_features_icon_color',
			[
				'label'                 => __( 'Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-fature-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .trx-addons-pricing-table-fature-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_features_icon_size',
			[
				'label'                 => __( 'Size', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 5,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px', 'em' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-fature-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_features_icon_spacing',
			[
				'label'                 => __( 'Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'default'               => [
					'size' => 5,
					'unit' => 'px',
				],
				'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-fature-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_features_rows_heading',
			[
				'label'                 => __( 'Rows', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_responsive_control(
			'table_features_spacing',
			[
				'label'                 => __( 'Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'unit' => 'px',
					'size' => 10,
				],
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_features_alternate',
			[
				'label'                 => __( 'Striped Rows', 'trx_addons' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => __( 'Yes', 'trx_addons' ),
				'label_off'             => __( 'No', 'trx_addons' ),
				'return_value'          => 'yes',
			]
		);

		$this->add_responsive_control(
			'table_features_rows_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_features_style' );

		$this->start_controls_tab(
			'tab_features_even',
			[
				'label'                 => __( 'Even', 'trx_addons' ),
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_features_bg_color_even',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features li:nth-child(even)' => 'background-color: {{VALUE}}',
				],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_features_text_color_even',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features li:nth-child(even)' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_features_odd',
			[
				'label'                 => __( 'Odd', 'trx_addons' ),
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_features_bg_color_odd',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features li:nth-child(odd)' => 'background-color: {{VALUE}}',
				],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_features_text_color_odd',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-features li:nth-child(odd)' => 'color: {{VALUE}}',
				],
				'condition'             => [
					'table_features_alternate' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'table_divider_heading',
			[
				'label'                 => __( 'Divider', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'table_feature_divider',
				'label'                 => __( 'Divider', 'trx_addons' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-features li',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Tooltip Style Controls
	 *
	 * @since 2.2.5
	 * @return void
	 */
	protected function register_style_tooltip_controls() {

		$this->start_controls_section(
			'section_tooltips_style',
			[
				'label'     => __( 'Tooltip', 'trx_addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_bg_color',
			[
				'label'     => __( 'Background Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} [data-tooltip-text]:after' => 'background-color: {{VALUE}};border-color: {{VALUE}};',
					'{{WRAPPER}} [data-tooltip-text]:before' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'show_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_color',
			[
				'label'     => __( 'Text Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} [data-tooltip-text]:after' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_tooltip' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'tooltip_typography',
				'label'     => __( 'Typography', 'trx_addons' ),
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} [data-tooltip-text]:after',
				'condition' => [
					'show_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_border_radius',
			[
				'label'      => __( 'Border Radius', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} [data-tooltip-text]:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'show_tooltip' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'tooltip_padding',
			[
				'label'      => __( 'Padding', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					//'{{WRAPPER}} [data-tooltip-text]:after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} [data-tooltip-text]' => '--trx-addons-tooltip-padding-top: {{TOP}}{{UNIT}}; --trx-addons-tooltip-padding-bottom: {{BOTTOM}}{{UNIT}}; --trx-addons-tooltip-padding-left: {{LEFT}}{{UNIT}}; --trx-addons-tooltip-padding-right: {{RIGHT}}{{UNIT}};',
				),
				'condition'  => [
					'show_tooltip' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'tooltip_box_shadow',
				'selector'  => '{{WRAPPER}} [data-tooltip-text]:after, {{WRAPPER}} [data-tooltip-text]:before',
				'condition' => [
					'show_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_icon_style_heading',
			[
				'label'     => __( 'Tooltip Icon', 'trx_addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_tooltip'       => 'yes',
					'tooltip_display_on' => 'icon',
				],
			]
		);

		$this->add_control(
			'tooltip_icon_color',
			[
				'label'     => __( 'Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .trx-addons-pricing-table-features .trx-addons-pricing-table-tooltip-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_tooltip'       => 'yes',
					'tooltip_display_on' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'tooltip_icon_size',
			[
				'label'      => __( 'Size', 'trx_addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'   => 5,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .trx-addons-pricing-table-features .trx-addons-pricing-table-tooltip-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'show_tooltip'       => 'yes',
					'tooltip_display_on' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'tooltip_icon_spacing',
			array(
				'label'      => __( 'Icon Spacing', 'trx_addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
						'step' => 1,
					),
					'em' => array(
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-pricing-table-tooltip-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => [
					'show_tooltip'       => 'yes',
					'tooltip_display_on' => 'icon',
				],
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_ribbon_controls() {
		/**
		 * Style Tab: Ribbon
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_table_ribbon_style',
			[
				'label'                 => __( 'Ribbon', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ribbon_bg_color',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-ribbon .trx-addons-pricing-table-ribbon-inner' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .trx-addons-pricing-table-ribbon-3.trx-addons-pricing-table-ribbon-right:before' => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .trx-addons-pricing-table-ribbon-3.trx-addons-pricing-table-ribbon-left:before' => 'border-right-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ribbon_text_color',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#ffffff',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-ribbon .trx-addons-pricing-table-ribbon-inner' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'ribbon_typography',
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-ribbon .trx-addons-pricing-table-ribbon-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'box_shadow',
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-ribbon .trx-addons-pricing-table-ribbon-inner',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_button_controls() {
		/**
		 * Style Tab: Button
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_table_button_style',
			[
				'label'                 => __( 'Button', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'table_button_text!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'                 => __( 'Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size'      => 20,
					'unit'      => 'px',
				],
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-button-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'table_button_text!' => '',
					'table_button_position' => 'above',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'                 => __( 'Normal', 'trx_addons' ),
				'condition'             => [
					'table_button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_bg_color_normal',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'global'                => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-button' => 'background-color: {{VALUE}}',
				],
				'condition'             => [
					'table_button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_color_normal',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_normal',
				'label'                 => __( 'Border', 'trx_addons' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-button',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'button_typography',
				'label'                 => __( 'Typography', 'trx_addons' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'condition'             => [
					'table_button_text!' => '',
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-button',
			]
		);

		$this->add_responsive_control(
			'table_button_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'condition'             => [
					'table_button_text!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => __( 'Border Radius', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em' ],
				'condition'             => [
					'table_button_text!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'pa_pricing_table_button_shadow',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'                 => __( 'Hover', 'trx_addons' ),
				'condition'             => [
					'table_button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_hover',
				'label'                 => __( 'Border', 'trx_addons' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'condition'             => [
					'table_button_text!' => '',
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-button:hover',
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'                 => __( 'Animation', 'trx_addons' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
				'condition'             => [
					'table_button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_footer_controls() {
		/**
		 * Style Tab: Footer
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_table_footer_style',
			[
				'label'                 => __( 'Footer', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_footer_bg_color',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-footer' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_footer_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'default'               => [
					'top'       => '30',
					'right'     => '30',
					'bottom'    => '30',
					'left'      => '30',
					'unit'      => 'px',
					'isLinked'  => true,
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_additional_info_heading',
			[
				'label'                 => __( 'Additional Info', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => [
					'table_additional_info!' => '',
				],
			]
		);

		$this->add_control(
			'additional_info_color',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'global'                => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'default'               => '',
				'condition'             => [
					'table_additional_info!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-additional-info' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'additional_info_bg_color',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'condition'             => [
					'table_additional_info!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-additional-info' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'additional_info_margin',
			[
				'label'                 => __( 'Margin Top', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size'      => 20,
					'unit'      => 'px',
				],
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-additional-info' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition'             => [
					'table_additional_info!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'additional_info_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'condition'             => [
					'table_additional_info!' => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-pricing-table-additional-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'additional_info_typography',
				'label'                 => __( 'Typography', 'trx_addons' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'condition'             => [
					'table_additional_info!' => '',
				],
				'selector'              => '{{WRAPPER}} .trx-addons-pricing-table-additional-info',
			]
		);

		$this->end_controls_section();

	}

	private function render_currency_symbol( $symbol, $location ) {
		$currency_position = $this->get_settings( 'currency_position' );
		$location_setting = ! empty( $currency_position ) ? $currency_position : 'before';
		if ( ! empty( $symbol ) && $location === $location_setting ) {
			$symbol = apply_filters( 'ppe_pricing_table_currency', $symbol, $this->get_id() );

			echo '<span class="trx-addons-pricing-table-price-prefix">' . $symbol . '</span>';
		}
	}

	private function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar'         => '&#36;',
			'euro'           => '&#128;',
			'franc'          => '&#8355;',
			'pound'          => '&#163;',
			'ruble'          => '&#8381;',
			'shekel'         => '&#8362;',
			'baht'           => '&#3647;',
			'yen'            => '&#165;',
			'won'            => '&#8361;',
			'guilder'        => '&fnof;',
			'peso'           => '&#8369;',
			'peseta'         => '&#8359',
			'lira'           => '&#8356;',
			'rupee'          => '&#8360;',
			'indian_rupee'   => '&#8377;',
			'real'           => 'R$',
			'krona'          => 'kr',
		];
		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

	/**
	 * Add tooltip attributes
	 */
	protected function get_tooltip_attributes( $item, $tooltip_key ) {
		$this->add_render_attribute(
			$tooltip_key,
			array(
				'class'             => 'trx-addons-pricing-table-tooptip',
				'data-tooltip-text' => $item['tooltip_content'],
			)
		);
	}

	/**
	 * Render pricing table widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$symbol = '';

		if ( ! empty( $settings['currency_symbol'] ) ) {
			if ( 'custom' !== $settings['currency_symbol'] ) {
				$symbol = $this->get_currency_symbol( $settings['currency_symbol'] );
			} else {
				$symbol = $settings['currency_symbol_custom'];
			}
		}

		if ( ! isset( $settings['table_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['table_icon'] = 'fa fa-star';
		}

		$has_icon = ! empty( $settings['table_icon'] );

		if ( $has_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['table_icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		if ( ! $has_icon && ! empty( $settings['select_table_icon']['value'] ) ) {
			$has_icon = true;
		}
		$migrated = isset( $settings['__fa4_migrated']['select_table_icon'] );
		$is_new = ! isset( $settings['table_icon'] ) && Icons_Manager::is_migration_allowed();

		$this->add_inline_editing_attributes( 'table_title', 'none' );
		$this->add_render_attribute( 'table_title', 'class', 'trx-addons-pricing-table-title' );

		$this->add_inline_editing_attributes( 'table_subtitle', 'none' );
		$this->add_render_attribute( 'table_subtitle', 'class', 'trx-addons-pricing-table-subtitle' );

		$this->add_render_attribute( 'table_price', 'class', 'trx-addons-pricing-table-price-value' );

		$this->add_inline_editing_attributes( 'table_duration', 'none' );
		$this->add_render_attribute( 'table_duration', 'class', 'trx-addons-pricing-table-price-duration' );

		$this->add_inline_editing_attributes( 'table_additional_info', 'none' );
		$this->add_render_attribute( 'table_additional_info', 'class', 'trx-addons-pricing-table-additional-info' );

		$this->add_render_attribute( 'pricing-table', 'class', 'trx-addons-pricing-table' );

		$this->add_render_attribute( 'feature-list-item', 'class', '' );

		$this->add_inline_editing_attributes( 'table_button_text', 'none' );

		$this->add_render_attribute( 'table_button_text', 'class', [
			'trx-addons-pricing-table-button',
			'elementor-button',
		] );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'table_button_text', $settings['link'] );
		}

		$this->add_render_attribute( 'pricing-table-duration', 'class', 'trx-addons-pricing-table-price-duration' );
		if ( 'wrap' === $settings['duration_position'] ) {
			$this->add_render_attribute( 'pricing-table-duration', 'class', 'next-line' );
		}

		if ( $settings['button_hover_animation'] ) {
			$this->add_render_attribute( 'table_button_text', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
		}

		if ( 'raised' === $settings['currency_format'] ) {
			$price = explode( '.', $settings['table_price'] );
			$intvalue = $price[0];
			$fraction = '';
			if ( 2 === count( $price ) ) {
				$fraction = $price[1];
			}
		} else {
			$intvalue = $settings['table_price'];
			$fraction = '';
		}
		?>
		<div class="trx-addons-pricing-table-container">
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'pricing-table' ) ); ?>>
				<div class="trx-addons-pricing-table-head">
					<?php if ( 'none' !== $settings['icon_type'] ) { ?>
						<div class="trx-addons-pricing-table-icon-wrap">
							<?php if ( 'icon' === $settings['icon_type'] && $has_icon ) { ?>
								<span class="trx-addons-pricing-table-icon trx-addons-icon">
									<?php
									if ( $is_new || $migrated ) {
										Icons_Manager::render_icon( $settings['select_table_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( ! empty( $settings['table_icon'] ) ) {
										?><i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i><?php
									}
									?>
								</span>
							<?php } elseif ( 'image' === $settings['icon_type'] ) { ?>
								<?php $image = $settings['icon_image'];
								if ( $image['url'] ) { ?>
									<span class="trx-addons-pricing-table-icon trx-addons-pricing-table-icon-image">
										<?php echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'icon_image' ) ); ?>
									</span>
								<?php } ?>
							<?php } ?>
						</div>
					<?php } ?>
					<div class="trx-addons-pricing-table-title-wrap">
						<?php
						if ( $settings['table_title'] ) {
							$title_tag = $settings['title_html_tag'];
							?>
							<<?php echo esc_html( $title_tag ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'table_title' ) ); ?>>
								<?php echo wp_kses_post( $settings['table_title'] ); ?>
							</<?php echo esc_html( $title_tag ); ?>>
							<?php
						}

						if ( $settings['table_subtitle'] ) {
							$subtitle_tag = $settings['subtitle_html_tag'];
							?>
							<<?php echo esc_html( $subtitle_tag ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'table_subtitle' ) ); ?>>
								<?php echo wp_kses_post( $settings['table_subtitle'] ); ?>
							</<?php echo esc_html( $subtitle_tag ); ?>>
							<?php
						}
						?>
					</div>
				</div>
				<div class="trx-addons-pricing-table-price-wrap">
					<div class="trx-addons-pricing-table-price">
						<?php if ( 'yes' === $settings['discount'] && $settings['table_original_price'] ) { ?>
							<span class="trx-addons-pricing-table-price-original">
								<?php
									$this->render_currency_symbol( $symbol, 'before' );
									$this->print_unescaped_setting( 'table_original_price' );
									$this->render_currency_symbol( $symbol, 'after' );
								?>
							</span>
						<?php } ?>
						<?php $this->render_currency_symbol( $symbol, 'before' ); ?>
						<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'table_price' ) ); ?>>
							<span class="trx-addons-pricing-table-integer-part">
								<?php
									// PHPCS - the main text of a widget should not be escaped.
									echo $intvalue; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</span>
							<?php if ( $fraction ) { ?>
								<span class="trx-addons-pricing-table-after-part">
									<?php echo esc_attr( $fraction ); ?>
								</span>
							<?php } ?>
						</span>
						<?php $this->render_currency_symbol( $symbol, 'after' ); ?>
						<?php if ( $settings['table_duration'] ) { ?>
							<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'table_duration' ) ); ?>>
								<?php echo wp_kses_post( $settings['table_duration'] ); ?>
							</span>
						<?php } ?>
					</div>
				</div>
				<?php if ( 'above' === $settings['table_button_position'] ) { ?>
					<div class="trx-addons-pricing-table-button-wrap">
						<?php if ( $settings['table_button_text'] ) { ?>
							<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'table_button_text' ) ); ?>>
								<?php echo wp_kses_post( $settings['table_button_text'] ); ?>
							</a>
						<?php } ?>
					</div>
				<?php } ?>
				<ul class="trx-addons-pricing-table-features">
					<?php foreach ( $settings['table_features'] as $index => $item ) : ?>
						<?php
						$fallback_defaults = [
							'fa fa-check',
							'fa fa-times',
							'fa fa-dot-circle-o',
						];

						$migration_allowed = Icons_Manager::is_migration_allowed();

						// add old default
						if ( ! isset( $item['feature_icon'] ) && ! $migration_allowed ) {
							$item['feature_icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
						}

						$migrated = isset( $item['__fa4_migrated']['select_feature_icon'] );
						$is_new = ! isset( $item['feature_icon'] ) && $migration_allowed;

						$feature_list_key = $this->get_repeater_setting_key( 'feature_list_key', 'table_features', $index );
						$this->add_render_attribute( $feature_list_key, 'class', 'elementor-repeater-item-' . $item['_id'] );

						$feature_content_key = $this->get_repeater_setting_key( 'feature_content_key', 'table_features', $index );
						$this->add_render_attribute( $feature_content_key, 'class', 'trx-addons-pricing-table-feature-content' );

						$tooltip_icon_key = $this->get_repeater_setting_key( 'tooltip_icon_key', 'table_features', $index );
						$this->add_render_attribute( $tooltip_icon_key, 'class', ['trx-addons-pricing-table-tooltip-icon', 'trx-addons-icon'] );

						if ( 'yes' === $settings['show_tooltip'] && $item['tooltip_content'] ) {
							if ( 'text' === $settings['tooltip_display_on'] ) {
								$this->get_tooltip_attributes( $item, $feature_content_key );
							} else {
								$this->get_tooltip_attributes( $item, $tooltip_icon_key );
							}
						}

						$feature_key = $this->get_repeater_setting_key( 'feature_text', 'table_features', $index );
						$this->add_render_attribute( $feature_key, 'class', 'trx-addons-pricing-table-feature-text' );
						$this->add_inline_editing_attributes( $feature_key, 'none' );

						if ( 'yes' === $item['exclude'] ) {
							$this->add_render_attribute( $feature_list_key, 'class', 'excluded' );
						}
						?>
						<li <?php echo wp_kses_post( $this->get_render_attribute_string( $feature_list_key ) ); ?>>
							<div <?php echo wp_kses_post( $this->get_render_attribute_string( $feature_content_key ) ); ?>>
								<?php
								if ( ! empty( $item['feature_icon'] ) || ( ! empty( $item['select_feature_icon']['value'] ) && $is_new ) ) : ?>
									<span class="trx-addons-pricing-table-fature-icon trx-addons-icon">
										<?php
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $item['select_feature_icon'], [ 'aria-hidden' => 'true' ] );
										} else { ?>
											<i class="<?php echo esc_attr( $item['feature_icon'] ); ?>" aria-hidden="true"></i>
											<?php
										}
										?>
									</span>
									<?php
									endif;
								?>
								<?php if ( $item['feature_text'] ) { ?>
									<span <?php echo wp_kses_post( $this->get_render_attribute_string( $feature_key ) ); ?>>
										<?php echo wp_kses_post( $item['feature_text'] ); ?>
									</span>
								<?php } ?>
								<?php if ( 'yes' === $settings['show_tooltip'] && $item['tooltip_content'] ) { ?>
									<?php if ( 'icon' === $settings['tooltip_display_on'] ) { ?>
										<span <?php echo wp_kses_post( $this->get_render_attribute_string( $tooltip_icon_key ) ); ?>>
											<?php \Elementor\Icons_Manager::render_icon( $settings['tooltip_icon'], array( 'aria-hidden' => 'true' ) ); ?>
										</span>
									<?php } ?>
								<?php } ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="trx-addons-pricing-table-footer">
					<?php if ( 'below' === $settings['table_button_position'] ) { ?>
						<?php if ( $settings['table_button_text'] ) { ?>
							<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'table_button_text' ) ); ?>>
								<?php echo wp_kses_post( $settings['table_button_text'] ); ?>
							</a>
						<?php } ?>
					<?php } ?>
					<?php if ( $settings['table_additional_info'] ) { ?>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'table_additional_info' ) ); ?>>
							<?php echo wp_kses_post( $this->parse_text_editor( $settings['table_additional_info'] ) ); ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php if ( 'yes' === $settings['show_ribbon'] && $settings['ribbon_title'] ) { ?>
				<?php
					$classes = [
						'trx-addons-pricing-table-ribbon',
						'trx-addons-pricing-table-ribbon-' . $settings['ribbon_style'],
						'trx-addons-pricing-table-ribbon-' . $settings['ribbon_position'],
					];
					$this->add_render_attribute( 'ribbon', 'class', $classes );
					?>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ribbon' ) ); ?>>
					<div class="trx-addons-pricing-table-ribbon-inner">
						<div class="trx-addons-pricing-table-ribbon-title">
							<?php echo wp_kses_post( $settings['ribbon_title'] ); ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Render pricing table widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
	protected function content_template() {
		?><#
		var buttonClasses = 'trx-addons-pricing-table-button elementor-button elementor-animation-' + settings.button_hover_animation;
		
		var $i = 1,
			symbols = {
				dollar: '&#36;',
				euro: '&#128;',
				franc: '&#8355;',
				pound: '&#163;',
				ruble: '&#8381;',
				shekel: '&#8362;',
				baht: '&#3647;',
				yen: '&#165;',
				won: '&#8361;',
				guilder: '&fnof;',
				peso: '&#8369;',
				peseta: '&#8359;',
				lira: '&#8356;',
				rupee: '&#8360;',
				indian_rupee: '&#8377;',
				real: 'R$',
				krona: 'kr'
			},
			symbol = '',
			iconHTML = {},
			iconsHTML = {},
			migrated = {},
			iconsMigrated = {},
			tooltipIconHTML = {};

		if ( settings.currency_symbol ) {
			if ( 'custom' !== settings.currency_symbol ) {
				symbol = symbols[ settings.currency_symbol ] || '';
			} else {
				symbol = settings.currency_symbol_custom;
			}
		}
		
		if ( settings.currency_format == 'raised' ) {
			var table_price = settings.table_price.toString(),
				price = table_price.split( '.' ),
				intvalue = price[0],
				fraction = price[1];
		} else {
			var intvalue = settings.table_price,
				fraction = '';
		}

		function get_tooltip_attributes( item, toolTipKey ) {
			view.addRenderAttribute(
				toolTipKey,
				{
					'class': 'trx-addons-pricing-table-tooptip',
					'data-tooltip-text': item.tooltip_content,
				}
			);
		}
		#>
		<div class="trx-addons-pricing-table-container">
			<div class="trx-addons-pricing-table">
				<div class="trx-addons-pricing-table-head">
					<# if ( settings.icon_type != 'none' ) { #>
						<div class="trx-addons-pricing-table-icon-wrap">
							<# if ( settings.icon_type == 'icon' ) {
								if ( settings.table_icon || settings.select_table_icon ) {
									iconHTML = elementor.helpers.renderIcon( view, settings.select_table_icon, { 'aria-hidden': true }, 'i', 'object' );
									migrated = elementor.helpers.isIconMigrated( settings, 'select_table_icon' );
									#>
									<span class="trx-addons-pricing-table-icon trx-addons-icon">
										<# if ( iconHTML && iconHTML.rendered && ( ! settings.table_icon || migrated ) ) { #>
											{{{ iconHTML.value }}}
										<# } else { #>
											<i class="{{ settings.table_icon }}" aria-hidden="true"></i>
										<# } #>
									</span>
								<# } #>
							<# } else if ( settings.icon_type == 'image' ) { #>
								<span class="trx-addons-pricing-table-icon trx-addons-pricing-table-icon-image">
									<# if ( settings.icon_image.url != '' ) { #>
										<#
										var image = {
											id: settings.icon_image.id,
											url: settings.icon_image.url,
											size: settings.image_size,
											dimension: settings.image_custom_dimension,
											model: view.getEditModel()
										};
										var image_url = elementor.imagesManager.getImageUrl( image );
										#>
										<img src="{{ _.escape( image_url ) }}" />
									<# } #>
								</span>
							<# } #>
						</div>
					<# } #>
					<div class="trx-addons-pricing-table-title-wrap">
						<# if ( settings.table_title ) { #>
							<# var titleHTMLTag = elementor.helpers.validateHTMLTag( settings.title_html_tag ); #>
							<{{{ titleHTMLTag }}} class="trx-addons-pricing-table-title elementor-inline-editing" data-elementor-setting-key="table_title" data-elementor-inline-editing-toolbar="none">
								{{{ settings.table_title }}}
							</{{{ titleHTMLTag }}}>
						<# } #>
						<# if ( settings.table_subtitle ) { #>
							<# var subtitleHTMLTag = elementor.helpers.validateHTMLTag( settings.subtitle_html_tag ); #>
							<{{{ subtitleHTMLTag }}} class="trx-addons-pricing-table-subtitle elementor-inline-editing" data-elementor-setting-key="table_subtitle" data-elementor-inline-editing-toolbar="none">
								{{{ settings.table_subtitle }}}
							</{{{ subtitleHTMLTag }}}>
						<# } #>
					</div>
				</div>
				<div class="trx-addons-pricing-table-price-wrap">
					<div class="trx-addons-pricing-table-price">
						<# if ( settings.discount === 'yes' && settings.table_original_price > 0 ) { #>
							<span class="trx-addons-pricing-table-price-original">
								<# if ( ! _.isEmpty( symbol ) && 'after' == settings.currency_position ) { #>
									{{{ settings.table_original_price + symbol }}}
								<# } else { #>
									{{{ symbol + settings.table_original_price }}}
								<# } #>
							</span>
						<# } #>
						<# if ( ! _.isEmpty( symbol ) && ( 'before' == settings.currency_position || _.isEmpty( settings.currency_position ) ) ) { #>
							<span class="trx-addons-pricing-table-price-prefix">{{{ symbol }}}</span>
						<# } #>
						<span class="trx-addons-pricing-table-price-value">
							<span class="trx-addons-pricing-table-integer-part">
								{{{ intvalue }}}
							</span>
							<# if ( fraction ) { #>
								<span class="trx-addons-pricing-table-after-part">
									{{{ fraction }}}
								</span>
							<# } #>
						</span>
						<# if ( ! _.isEmpty( symbol ) && 'after' == settings.currency_position ) { #>
							<span class="trx-addons-pricing-table-price-prefix">{{{ symbol }}}</span>
						<# } #>
						<# if ( settings.table_duration ) { #>
							<span class="trx-addons-pricing-table-price-duration elementor-inline-editing" data-elementor-setting-key="table_duration" data-elementor-inline-editing-toolbar="none">
								{{{ settings.table_duration }}}
							</span>
						<# } #>
					</div>
				</div>
				<# if ( settings.table_button_position == 'above' ) { #>
					<div class="trx-addons-pricing-table-button-wrap">
						<#
						if ( settings.table_button_text ) {
							var button_text = settings.table_button_text;

							view.addRenderAttribute( 'table_button_text', 'class', buttonClasses );

							view.addInlineEditingAttributes( 'table_button_text' );

							var button_text_html = '<a ' + 'href="' + _.escape( settings.link.url ) + '"' + view.getRenderAttributeString( 'table_button_text' ) + '>' + button_text + '</a>';

							print( button_text_html );
						}
						#>
					</div>
				<# } #>
				<ul class="trx-addons-pricing-table-features">
					<#
					var i = 1;
					_.each( settings.table_features, function( item, index ) {
						var  tooltipContentId = view.$el.data('id') + '-' + item._id;

						var featureContentKey = view.getRepeaterSettingKey( 'feature_content_key', 'table_features', index );
						view.addRenderAttribute( featureContentKey, 'class', 'trx-addons-pricing-table-feature-content' );

						var tooltipIconKey = view.getRepeaterSettingKey( 'tooltip_icon_key', 'table_features', index ),
							tooltipContentKey = view.getRepeaterSettingKey( 'tooltip_content', 'hot_spots', index );

						view.addRenderAttribute( tooltipIconKey, 'class', 'trx-addons-pricing-table-tooltip-icon' );

						view.addRenderAttribute(
							tooltipContentKey,
							{
								'class': [ 'trx-addons-tooltip-content', 'trx-addons-tooltip-content-' + tooltipContentId ],
								'id': 'trx-addons-tooltip-content-' + tooltipContentId,
							}
						);

						if ( 'yes' === settings.show_tooltip && item.tooltip_content ) {
							if ( 'text' === settings.tooltip_display_on ) {
								get_tooltip_attributes( item, featureContentKey );
							} else {
								get_tooltip_attributes( item, tooltipIconKey );
							}
						} #>
						<li class="elementor-repeater-item-{{ item._id }} <# if ( item.exclude == 'yes' ) { #> excluded <# } #>">
							<div {{{ view.getRenderAttributeString( featureContentKey ) }}}>
								<# if ( item.feature_icon || item.select_feature_icon.value ) { #>
									<span class="trx-addons-pricing-table-fature-icon trx-addons-icon">
									<#
										iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.select_feature_icon, { 'aria-hidden': true }, 'i', 'object' );
										iconsMigrated[ index ] = elementor.helpers.isIconMigrated( item, 'select_feature_icon' );
										if ( iconsHTML[ index ] && iconsHTML[ index ].rendered && ( ! item.feature_icon || iconsMigrated[ index ] ) ) { #>
											{{{ iconsHTML[ index ].value }}}
										<# } else { #>
											<i class="{{ item.feature_icon }}" aria-hidden="true"></i>
										<# } #>
									</span>
								<# } #>

								<#
									var feature_text = item.feature_text;

									view.addRenderAttribute( 'table_features.' + (i - 1) + '.feature_text', 'class', 'trx-addons-pricing-table-feature-text' );

									view.addInlineEditingAttributes( 'table_features.' + (i - 1) + '.feature_text' );

									var feature_text_html = '<span' + ' ' + view.getRenderAttributeString( 'table_features.' + (i - 1) + '.feature_text' ) + '>' + feature_text + '</span>';

									print( feature_text_html );

								if ( 'yes' === settings.show_tooltip && item.tooltip_content ) {
									if ( 'icon' === settings.tooltip_display_on) {
										tooltipIconHTML = elementor.helpers.renderIcon( view, settings.tooltip_icon, { 'aria-hidden': true }, 'i', 'object' );
										var tooltip_icon_html = '<span' + ' ' + view.getRenderAttributeString( tooltipIconKey ) + '>' + tooltipIconHTML.value + '</span>';
										print( tooltip_icon_html );
									}
								}
								#>
							</div>
						</li>
					<# i++ } ); #>
				</ul>
				<div class="trx-addons-pricing-table-footer">
					<#
					if ( settings.table_button_position == 'below' ) {
						if ( settings.table_button_text ) {
							var button_text = settings.table_button_text;

							view.addRenderAttribute( 'table_button_text', 'class', buttonClasses );

							view.addInlineEditingAttributes( 'table_button_text' );

							var button_text_html = '<a ' + 'href="' + _.escape( settings.link.url ) + '"' + view.getRenderAttributeString( 'table_button_text' ) + '>' + button_text + '</a>';

							print( button_text_html );
						}
					}

					if ( settings.table_additional_info ) {
						var additional_info_text = settings.table_additional_info;

						view.addRenderAttribute( 'table_additional_info', 'class', 'trx-addons-pricing-table-additional-info' );

						view.addInlineEditingAttributes( 'table_additional_info' );

						var additional_info_text_html = '<div ' + view.getRenderAttributeString( 'table_additional_info' ) + '>' + additional_info_text + '</div>';

						print( additional_info_text_html );
					}
					#>
				</div>
			</div>
			<# if ( settings.show_ribbon == 'yes' && settings.ribbon_title != '' ) { #>
				<div class="trx-addons-pricing-table-ribbon trx-addons-pricing-table-ribbon-{{ settings.ribbon_style }} trx-addons-pricing-table-ribbon-{{ settings.ribbon_position }}">
					<div class="trx-addons-pricing-table-ribbon-inner">
						<div class="trx-addons-pricing-table-ribbon-title">
							<# print( settings.ribbon_title ); #>
						</div>
					</div>
				</div>
			<# } #>
		</div>
		<?php
	}
}
