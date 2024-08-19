<?php
/**
 * Image Accordion Widget
 *
 * @package ThemeREX Addons
 * @since v2.30.0
 */

namespace TrxAddons\ElementorWidgets\Widgets\ImageAccordion;

use TrxAddons\ElementorWidgets\BaseWidget;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Accordion Widget
 */
class ImageAccordionWidget extends BaseWidget {

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */
	protected function register_controls() {
		/* Content Tab */
		$this->register_content_items_controls();
		$this->register_content_settings_controls();
		$this->register_content_help_docs_controls();

		/* Style Tab */
		$this->register_style_items_controls();
		$this->register_style_content_controls();
		$this->register_style_button_controls();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Register accordion items controls
	 */
	protected function register_content_items_controls() {

		$this->start_controls_section(
			'section_items',
			[
				'label'                 => esc_html__( 'Items', 'trx_addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'image_accordion_tabs' );

		$repeater->start_controls_tab( 'tab_content', [ 'label' => __( 'Content', 'trx_addons' ) ] );

		$repeater->add_control(
			'title',
			[
				'label'                 => esc_html__( 'Title', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'label_block'           => true,
				'default'               => esc_html__( 'Accordion Title', 'trx_addons' ),
				'dynamic'               => [
					'active'   => true,
				],
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'                 => esc_html__( 'Description', 'trx_addons' ),
				'type'                  => Controls_Manager::WYSIWYG,
				'label_block'           => true,
				'default'               => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'trx_addons' ),
				'dynamic'               => [
					'active'   => true,
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'tab_image', [ 'label' => __( 'Image', 'trx_addons' ) ] );

		$repeater->add_control(
			'image',
			[
				'label'                 => esc_html__( 'Choose Image', 'trx_addons' ),
				'type'                  => Controls_Manager::MEDIA,
				'label_block'           => true,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'tab_link', [ 'label' => __( 'Link', 'trx_addons' ) ] );

		$repeater->add_control(
			'show_button',
			[
				'label'                 => __( 'Show Button', 'trx_addons' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => __( 'Yes', 'trx_addons' ),
				'label_off'             => __( 'No', 'trx_addons' ),
				'return_value'          => 'yes',
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'                 => esc_html__( 'Link', 'trx_addons' ),
				'type'                  => Controls_Manager::URL,
				'label_block'           => true,
				'default'               => [
					'url'           => '#',
					'is_external'   => '',
				],
				'show_external'         => true,
				'condition'             => [
					'show_button'   => 'yes',
				],
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'                 => __( 'Button Text', 'trx_addons' ),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => __( 'Get Started', 'trx_addons' ),
				'condition'             => [
					'show_button'   => 'yes',
				],
			]
		);

		$repeater->add_control(
			'select_button_icon',
			[
				'label'                 => __( 'Button Icon', 'trx_addons' ),
				'type'                  => Controls_Manager::ICONS,
				'fa4compatibility'      => 'button_icon',
				'condition'             => [
					'show_button'   => 'yes',
				],
			]
		);

		$repeater->add_control(
			'button_icon_position',
			[
				'label'                 => __( 'Icon Position', 'trx_addons' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'after',
				'options'               => [
					'before'    => __( 'Before', 'trx_addons' ),
					'after'     => __( 'After', 'trx_addons' ),
				],
				'condition'             => [
					'show_button'   => 'yes',
					'select_button_icon[value]!'  => '',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'accordion_items',
			[
				'type'                  => Controls_Manager::REPEATER,
				'seperator'             => 'before',
				'default'               => [
					[
						'title'         => esc_html__( 'Accordion #1', 'trx_addons' ),
						'description'   => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'trx_addons' ),
						'image'         => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'title'         => esc_html__( 'Accordion #2', 'trx_addons' ),
						'description'   => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'trx_addons' ),
						'image'         => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'title'         => esc_html__( 'Accordion #3', 'trx_addons' ),
						'description'   => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'trx_addons' ),
						'image'         => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'title'         => esc_html__( 'Accordion #4', 'trx_addons' ),
						'description'   => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'trx_addons' ),
						'image'         => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
				],
				'fields'        => $repeater->get_controls(),
				'title_field' => '{{title}}',
			]
		);

		$this->add_control(
			'active_tab',
			[
				'label'                 => __( 'Default Active Item', 'trx_addons' ),
				'description'                 => __( 'Add item number to make that item active by default. For example: Add 1 to make first item active by default.', 'trx_addons' ),
				'type'                  => \Elementor\Controls_Manager::NUMBER,
				'min'                   => 1,
				'max'                   => 100,
				'step'                  => 1,
				'default'               => '',
				'separator'             => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register settings content controls
	 *
	 * @return void
	 */
	protected function register_content_settings_controls() {

		$this->start_controls_section(
			'section_image_accordion_settings',
			[
				'label'                 => esc_html__( 'Settings', 'trx_addons' ),
			]
		);

		$this->add_responsive_control(
			'accordion_height',
			[
				'label'                 => esc_html__( 'Height', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 50,
						'max'   => 1000,
						'step'  => 1,
					],
					'em'        => [
						'min'   => 5,
						'max'   => 100,
						'step'  => 0.1,
					],
					'vh'        => [
						'min'   => 1,
						'max'   => 100,
						'step'  => 0.1,
					],
				],
				'size_units'            => [ 'px', 'em', 'vh' ],
				'default'               => [
					'size' => 400,
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'                => __( 'Title HTML Tag', 'trx_addons' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'h2',
				'separator'             => 'before',
				'options'              => [
					'h1'     => __( 'H1', 'trx_addons' ),
					'h2'     => __( 'H2', 'trx_addons' ),
					'h3'     => __( 'H3', 'trx_addons' ),
					'h4'     => __( 'H4', 'trx_addons' ),
					'h5'     => __( 'H5', 'trx_addons' ),
					'h6'     => __( 'H6', 'trx_addons' ),
					'div'    => __( 'div', 'trx_addons' ),
					'span'   => __( 'span', 'trx_addons' ),
					'p'      => __( 'p', 'trx_addons' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'image',
				'label'                 => __( 'Image Size', 'trx_addons' ),
				'default'               => 'full',
			]
		);

		$this->add_control(
			'accordion_action',
			[
				'label'                 => esc_html__( 'Accordion Action', 'trx_addons' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'on-hover',
				'label_block'           => false,
				'options'               => [
					'on-hover'  => esc_html__( 'On Hover', 'trx_addons' ),
					'on-click'  => esc_html__( 'On Click', 'trx_addons' ),
				],
				'frontend_available'    => true,
			]
		);

		$this->add_control(
			'orientation',
			[
				'label'                 => esc_html__( 'Orientation', 'trx_addons' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'vertical',
				'label_block'           => false,
				'options'               => [
					'vertical'      => esc_html__( 'Vertical', 'trx_addons' ),
					'horizontal'    => esc_html__( 'Horizontal', 'trx_addons' ),
				],
				'frontend_available'    => true,
				'prefix_class'          => 'trx-addons-image-accordion-orientation-',
			]
		);

		$this->add_control(
			'stack_on',
			[
				'label'                 => esc_html__( 'Stack On', 'trx_addons' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'tablet',
				'label_block'           => false,
				'options'               => [
					'tablet'    => esc_html__( 'Tablet', 'trx_addons' ),
					'mobile'    => esc_html__( 'Mobile', 'trx_addons' ),
					'none'      => esc_html__( 'None', 'trx_addons' ),
				],
				'frontend_available'    => true,
				'prefix_class'          => 'trx-addons-image-accordion-stack-on-',
				'condition'             => [
					'orientation'   => 'vertical',
				],
			]
		);

		$this->add_control(
			'disable_body_click',
			[
				'label'                 => esc_html__( 'Disable Body Click', 'trx_addons' ),
				'description'           => esc_html__( 'Don\'t collapse accordion on body click', 'trx_addons' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'no',
				'label_block'           => false,
				'options'               => [
					'yes' => esc_html__( 'Yes', 'trx_addons' ),
					'no'  => esc_html__( 'No', 'trx_addons' ),
				],
				'frontend_available'    => true,
			]
		);

		$this->end_controls_section();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Style Tab
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Register items style controls
	 *
	 * @return void
	 */
	protected function register_style_items_controls() {

		$this->start_controls_section(
			'section_items_style',
			[
				'label'                 => esc_html__( 'Items', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'items_spacing',
			[
				'label'                 => esc_html__( 'Items Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 50,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'             => [
					'(desktop){{WRAPPER}}.trx-addons-image-accordion-orientation-vertical .trx-addons-image-accordion-item:not(:last-child)' => 'margin-right: {{SIZE}}px',
					'(desktop){{WRAPPER}}.trx-addons-image-accordion-orientation-horizontal .trx-addons-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px',
					'(tablet){{WRAPPER}}.trx-addons-image-accordion-orientation-vertical.trx-addons-image-accordion-stack-on-tablet .trx-addons-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px;',
					'(mobile){{WRAPPER}}.trx-addons-image-accordion-orientation-vertical.trx-addons-image-accordion-stack-on-mobile .trx-addons-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_items_style' );

		$this->start_controls_tab(
			'tab_items_normal',
			[
				'label'                 => __( 'Normal', 'trx_addons' ),
			]
		);

		$this->add_control(
			'accordion_img_overlay_color',
			[
				'label'                 => esc_html__( 'Overlay Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => 'rgba(0,0,0,0.3)',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-item .trx-addons-image-accordion-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'items_border',
				'label'                 => esc_html__( 'Border', 'trx_addons' ),
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion-item',
			]
		);

		$this->add_control(
			'items_border_radius',
			[
				'label'                 => __( 'Border Radius', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'items_box_shadow',
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion-item',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_items_hover',
			[
				'label'                 => __( 'Hover', 'trx_addons' ),
			]
		);

		$this->add_control(
			'accordion_img_hover_color',
			[
				'label'                 => esc_html__( 'Overlay Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => 'rgba(0,0,0,0.5)',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-item:hover .trx-addons-image-accordion-overlay' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .trx-addons-image-accordion-item.trx-addons-image-accordion-active .trx-addons-image-accordion-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'items_border_color_hover',
			[
				'label'                 => esc_html__( 'Border Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-item:hover, {{WRAPPER}} .trx-addons-image-accordion-item.trx-addons-image-accordion-active' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'items_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion-item:hover, {{WRAPPER}} .trx-addons-image-accordion-item.trx-addons-image-accordion-active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register content style controls
	 *
	 * @return void
	 */
	protected function register_style_content_controls() {

		$this->start_controls_section(
			'section_content_style',
			[
				'label'                 => esc_html__( 'Content', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label'                 => esc_html__( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'content_border',
				'label'                 => esc_html__( 'Border', 'trx_addons' ),
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-content',
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label'                 => __( 'Border Radius', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_vertical_align',
			[
				'label'                 => __( 'Vertical Align', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => 'middle',
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
				'selectors_dictionary'  => [
					'top'       => 'flex-start',
					'middle'    => 'center',
					'bottom'    => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-overlay' => '-webkit-align-items: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}};',
				],
				'separator'             => 'before',
			]
		);

		$this->add_responsive_control(
			'content_horizontal_align',
			[
				'label'                 => __( 'Horizontal Align', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => true,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'trx_addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'           => [
						'title' => __( 'Center', 'trx_addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'            => [
						'title' => __( 'Right', 'trx_addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'               => 'center',
				'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'center'   => 'center',
					'right'    => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-overlay' => '-webkit-justify-content: {{VALUE}}; justify-content: {{VALUE}};',
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-content-wrap' => '-webkit-align-items: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'                 => __( 'Text Align', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => ' center',
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
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'                 => esc_html__( 'Width', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 400,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px', '%' ],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-content' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator'             => 'before',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_style_heading',
			[
				'label'                 => __( 'Title', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'                 => esc_html__( 'Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#fff',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'title_typography',
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'                 => esc_html__( 'Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 50,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-title' => 'margin-bottom: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'description_style_heading',
			[
				'label'                 => __( 'Description', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'                 => esc_html__( 'Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#fff',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'description_typography',
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion .trx-addons-image-accordion-description',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register button style controls
	 *
	 * @return void
	 */
	protected function register_style_button_controls() {

		$this->start_controls_section(
			'section_button_style',
			[
				'label'                 => __( 'Button', 'trx_addons' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'                 => esc_html__( 'Button Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 50,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'default'               => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-button' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'                 => __( 'Normal', 'trx_addons' ),
			]
		);

		$this->add_control(
			'button_bg_color_normal',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color_normal',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .trx-addons-image-accordion-button .trx-addons-icon svg' => 'fill: {{VALUE}}',
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
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => __( 'Border Radius', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion-button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'                 => __( 'Padding', 'trx_addons' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'                 => __( 'Hover', 'trx_addons' ),
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label'                 => __( 'Background Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'                 => __( 'Text Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-button:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .trx-addons-image-accordion-button:hover .trx-addons-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label'                 => __( 'Border Color', 'trx_addons' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-image-accordion-button:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'                 => __( 'Animation', 'trx_addons' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .trx-addons-image-accordion-button:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_icon_heading',
			[
				'label'                 => __( 'Icon', 'trx_addons' ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_responsive_control(
			'button_icon_spacing',
			[
				'label'                 => esc_html__( 'Icon Spacing', 'trx_addons' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 50,
						'step'  => 1,
					],
				],
				'size_units'            => [ 'px' ],
				'default'               => [
					'size' => 2,
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-button-icon-before .trx-addons-button-icon' => 'margin-right: {{SIZE}}px',
					'{{WRAPPER}} .trx-addons-button-icon-after .trx-addons-button-icon' => 'margin-left: {{SIZE}}px',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render_button_icon( $item ) {
		$settings = $this->get_settings_for_display();

		$migration_allowed = Icons_Manager::is_migration_allowed();

		// add old default
		if ( ! isset( $item['button_icon'] ) && ! $migration_allowed ) {
			$item['hotspot_icon'] = '';
		}

		$migrated = isset( $item['__fa4_migrated']['select_button_icon'] );
		$is_new = ! isset( $item['button_icon'] ) && $migration_allowed;

		if ( ! empty( $item['button_icon'] ) || ( ! empty( $item['select_button_icon']['value'] ) && $is_new ) ) {
			?>
			<span class="trx-addons-button-icon trx-addons-icon trx-addons-no-trans">
				<?php if ( $is_new || $migrated ) {
					Icons_Manager::render_icon( $item['select_button_icon'], [ 'aria-hidden' => 'true' ] );
				} else { ?>
					<i class="<?php echo esc_attr( $item['button_icon'] ); ?>" aria-hidden="true"></i>
				<?php } ?>
			</span>
			<?php
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'image-accordion', [
			'class' => [ 'trx-addons-image-accordion', 'trx-addons-image-accordion-' . $settings['accordion_action'] ],
			'id'    => 'trx-addons-image-accordion-' . $this->get_id(),
		] );

		if ( ! empty( $settings['accordion_items'] ) ) { ?>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'image-accordion' ) ); ?>>
				<?php foreach ( $settings['accordion_items'] as $index => $item ) { ?>
					<?php
						$item_key = $this->get_repeater_setting_key( 'item', 'accordion_items', $index );

						$this->add_render_attribute( $item_key, [
							'class' => [ 'trx-addons-image-accordion-item', 'elementor-repeater-item-' . esc_attr( $item['_id'] ) ],
						] );

					if ( $item['image']['url'] ) {

						$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'image', $settings );

						if ( ! $image_url ) {
							$image_url = $item['image']['url'];
						}

						$this->add_render_attribute( $item_key, [
							'style' => 'background-image: url(' . $image_url . ');',
						] );
					}

						$content_key = $this->get_repeater_setting_key( 'content', 'accordion_items', $index );

						$this->add_render_attribute( $content_key, 'class', 'trx-addons-image-accordion-content-wrap' );

					if ( 'yes' === $item['show_button'] && ! empty( $item['link']['url'] ) ) {
						$button_key = $this->get_repeater_setting_key( 'button', 'accordion_items', $index );

						$this->add_render_attribute( $button_key, 'class', [
							'trx-addons-image-accordion-button',
							'trx-addons-button-icon-' . $item['button_icon_position'],
							'elementor-button',
						] );

						if ( $settings['button_hover_animation'] ) {
							$this->add_render_attribute( $button_key, 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
						}

						$this->add_link_attributes( $button_key, $item['link'] );
					}

					if ( $settings['active_tab'] ) {
						$tab_count = $settings['active_tab'] - 1;
						if ( $index === $tab_count ) {
							$this->add_render_attribute( $item_key, [
								'class' => 'trx-addons-image-accordion-active',
								'style' => 'flex: 3 1 0;',
							] );
							$this->add_render_attribute( $content_key, [
								'class' => 'trx-addons-image-accordion-content-active',
							] );
						}
					}
					?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( $item_key ) ); ?>>
						<div class="trx-addons-image-accordion-overlay trx-addons-media-overlay">
							<div <?php echo wp_kses_post( $this->get_render_attribute_string( $content_key ) ); ?>>
								<div class="trx-addons-image-accordion-content">
									<?php $title_tag = $settings['title_html_tag']; ?>
									<<?php echo esc_html( $title_tag ); ?> class="trx-addons-image-accordion-title">
										<?php echo wp_kses_post( $item['title'] ); ?>
									</<?php echo esc_html( $title_tag ); ?>>
									<div class="trx-addons-image-accordion-description">
										<?php echo $this->parse_text_editor( $item['description'] ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</div>
									<?php if ( 'yes' === $item['show_button'] && $item['link']['url'] ) { ?>
										<div class="trx-addons-image-accordion-button-wrap">
											<a <?php echo wp_kses_post( $this->get_render_attribute_string( $button_key ) ); ?>>
												<?php
												if ( 'before' === $item['button_icon_position'] ) {
													$this->render_button_icon( $item );
												}
												?>
												<?php if ( ! empty( $item['button_text'] ) ) { ?>
													<span class="trx-addons-button-text">
														<?php echo wp_kses_post( $item['button_text'] ); ?>
													</span>
												<?php } ?>
												<?php
												if ( 'after' === $item['button_icon_position'] ) {
													$this->render_button_icon( $item );
												}
												?>
											</a>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php }
	}
}
