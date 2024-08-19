<?php

/**
 * Tabs Widget
 *
 * @package ThemeREX Addons
 * @since v2.30.0
 */

namespace TrxAddons\ElementorWidgets\Widgets\Tabs;

use TrxAddons\ElementorWidgets\BaseWidget;

// Elementor Classes.
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Control_Media;
use \Elementor\Icons_Manager;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Plugin;
use \Elementor\Repeater;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Tabs Widget
 */
class TabsWidget extends BaseWidget
{

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */
	protected function register_controls()
	{
		/* Content Tab */
		$this->register_content_tabs_controls();
		$this->register_content_help_docs_controls();

		/* Style Tab */
		$this->register_style_tabs_controls();
		$this->register_style_tabs_icon_controls();
		$this->register_style_tabs_content_controls();
		$this->register_style_tabs_content_image_controls();
		$this->register_style_tabs_content_button_controls();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Register tabs content controls
	 */
	protected function register_content_tabs_controls() {

		$this->start_controls_section(
			'section_tabs_content_settings',
			[
				'label' => esc_html__('Content', 'trx_addons')
			]
		);

		$tabs_repeater = new Repeater();

		$tabs_repeater->add_control(
			'tabs_show_as_default',
			[
				'label'        => __('Active as Default', 'trx_addons'),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'active'
			]
		);

		$tabs_repeater->add_control(
			'tabs_icon_type',
			[
				'label'       => esc_html__('Icon Type', 'trx_addons'),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'label_block' => false,
				'options'     => [
					'none'      => [
						'title' => esc_html__('None', 'trx_addons'),
						'icon'  => 'eicon-ban'
					],
					'icon'      => [
						'title' => esc_html__('Icon', 'trx_addons'),
						'icon'  => 'eicon-info-circle'
					],
					'image'     => [
						'title' => esc_html__('Image', 'trx_addons'),
						'icon'  => 'eicon-image-bold'
					]
				],
				'default'       => 'none'
			]
		);

		$tabs_repeater->add_control(
			'tabs_title_icon',
			[
				'label'     => esc_html__('Icon', 'trx_addons'),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-home',
					'library' => 'fa-solid'
				],
				'condition' => [
					'tabs_icon_type' => 'icon'
				]
			]
		);

		$tabs_repeater->add_control(
			'tabs_title_image',
			[
				'label'   => esc_html__('Image', 'trx_addons'),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'tabs_icon_type' => 'image'
				]
			]
		);

		$tabs_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'tabs_navigation_image_size',
				'default' => 'medium_large'
			]
		);

		$tabs_repeater->add_control(
			'tabs_content_type',
			[
				'label'   => __('Content Type', 'trx_addons'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => [
					'content'       => __('Content', 'trx_addons'),
					'save_template' => __('Save Template', 'trx_addons'),
					'shortcode'     => __('ShortCode', 'trx_addons')
				]
			]
		);

		$tabs_repeater->add_control(
			'tabs_content_save_template',
			[
				'label'     => __('Select Section', 'trx_addons'),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_saved_template('section'),
				'default'   => '-1',
				'condition' => [
					'tabs_content_type' => 'save_template'
				]
			]
		);

		$tabs_repeater->add_control(
			'tabs_content_shortcode',
			[
				'label'       => __('Enter your shortcode', 'trx_addons'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __('[gallery]', 'trx_addons'),
				'condition'   => [
					'tabs_content_type' => 'shortcode'
				]
			]
		);

		$tabs_repeater->add_control(
			'tabs_title',
			[
				'label'   => esc_html__('Title', 'trx_addons'),
				'type'    => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Tab Title', 'trx_addons'),
				'dynamic' => ['active' => true],
			]
		);

		$tabs_repeater->add_control(
			'tabs_content',
			[
				'label'   => esc_html__('Content', 'trx_addons'),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'trx_addons'),
				'condition' => [
					'tabs_content_type' => 'content'
				]
			]
		);

		$tabs_repeater->add_control(
			'tabs_detail_btn_switcher',
			[
				'label'        => __('Details Button?', 'trx_addons'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition' => [
					'tabs_content_type' => 'content'
				]
			]
		);

		$tabs_repeater->add_control(
			'tabs_detail_btn',
			[
				'label'     => __('Details Button Text', 'trx_addons'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Read More', 'trx_addons'),
				'condition' => [
					'tabs_detail_btn_switcher' => 'yes',
					'tabs_content_type' => 'content'
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$tabs_repeater->add_control(
			'tabs_detail_btn_link',
			[
				'label'   => __('Details Button Link', 'trx_addons'),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '#',
					'is_external' => ''
				],
				'show_external' => true,
				'condition' => [
					'tabs_detail_btn_switcher' => 'yes',
					'tabs_content_type' => 'content'
				]
			]
		);

		$tabs_repeater->add_control(
			'tabs_image',
			[
				'label' => esc_html__('Choose Image', 'trx_addons'),
				'type'  => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'tabs_content_type' => 'content'
				]
			]
		);

		$tabs_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'tabs_image_size',
				'label'   => esc_html__('Image Type', 'trx_addons'),
				'default' => 'medium'
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'   => esc_html__('Tabs', 'trx_addons'),
				'type'      => Controls_Manager::REPEATER,
				'fields'  => $tabs_repeater->get_controls(),
				'seperator' => 'before',
				'default'   => [
					[
						'tabs_title' => esc_html__('Tab Title 1', 'trx_addons'),
						'tabs_show_as_default' => 'active'
					],
					[
						'tabs_title'   => esc_html__('Tab Title 2', 'trx_addons'),
						'tabs_content' => esc_html__('A quick brown fox jumps over the lazy dog. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'trx_addons')
					],
					['tabs_title' => esc_html__('Tab Title 3', 'trx_addons')]
				],
				'title_field' => '{{tabs_title}}'
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register tabs style controls
	 *
	 * @return void
	 */
	protected function register_style_tabs_controls() {

		$accent_color = apply_filters( 'trx_addons_filter_get_theme_accent_color', '#efa758' );

		$this->start_controls_section(
			'section_tabs_navigation_style_settings',
			[
				'label' => esc_html__('Tab Navigation', 'trx_addons'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'tabs_orientation',
			[
				'label'   => esc_html__('Tab Orientation', 'trx_addons'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'trx-addons-tabs-horizontal-full-width',
				'options' => [
					'trx-addons-tabs-horizontal'            => esc_html__('Horizontal', 'trx_addons'),
					'trx-addons-tabs-horizontal-full-width' => esc_html__('Horizontal Full Width', 'trx_addons'),
					'trx-addons-tabs-vertical'              => esc_html__('Vertical', 'trx_addons')
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_navigation_typography',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li span.trx-addons-tabs-title',
				'fields_options'   => [
					'font_size'    => [
						'default'  => [
							'unit' => 'px',
							'size' => 16
						]
					]
				]
			]
		);

		$this->add_control(
			'tabs_navigation_bg',
			[
				'label'     => esc_html__('Navigation Container Background', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'tabs_navigation_alignment',
			[
				'label'   => __('Alignment', 'trx_addons'),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'trx-addons-tabs-align-center',
				'options' => [
					'trx-addons-tabs-align-left'   => [
						'title' => __('Left', 'trx_addons'),
						'icon'  => 'eicon-text-align-left'
					],
					'trx-addons-tabs-align-center' => [
						'title' => __('Center', 'trx_addons'),
						'icon'  => 'eicon-text-align-center'
					],
					'trx-addons-tabs-align-right'  => [
						'title' => __('Right', 'trx_addons'),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'condition' => [
					'tabs_orientation!' => 'trx-addons-tabs-vertical'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_list_padding',
			[
				'label'        => __('Padding', 'trx_addons'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%', 'em'],
				'default'      => [
					'top'      => '16',
					'right'    => '24',
					'bottom'   => '16',
					'left'     => '24',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_list_margin',
			[
				'label'      => __('Margin', 'trx_addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_list_width',
			[
				'label'       => __('List Item Width', 'trx_addons'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px', '%'],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					],
					'%'       => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 200
				],
				'selectors'   => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs-vertical > .trx-addons-tabs-nav li' => 'width: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'tabs_orientation' => 'trx-addons-tabs-vertical'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_list_border_radius',
			[
				'label'      => __('Border Radius', 'trx_addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs('tabs_navigation_tabs');

		// Normal State Tab
		$this->start_controls_tab('tabs_navigation_normal', ['label' => esc_html__('Normal', 'trx_addons')]);

		$this->add_control(
			'tabs_navigation_list_normal_text_color',
			[
				'label'     => __('Text Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8a8d91',
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tabs_navigation_list_normal_background',
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .trx-addons-tabs-nav li'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                 => 'tabs_navigation_list_normal_border',
				'fields_options'       => [
					'border'           => [
						'default'      => 'solid'
					],
					'width'            => [
						'default'      => [
							'top'      => '0',
							'right'    => '0',
							'bottom'   => '1',
							'left'     => '0',
							'isLinked' => false
						]
					],
					'color'            => [
						'default'      => '#e5e5e5'
					]
				],
				'selector'             => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_navigation_list_box_shadow',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li'
			]
		);

		$this->end_controls_tab();

		// Active State Tab
		$this->start_controls_tab('tabs_navigation_active', ['label' => esc_html__('Active/Hover', 'trx_addons')]);

		$this->add_control(
			'tabs_navigation_list_hover_text_color',
			[
				'label'     => __('Text Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0a1724',
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li.active, {{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tabs_navigation_list_active_background',
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li.active, {{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li:hover, {{WRAPPER}} .trx-addons-tabs-nav-item-with-triangle.active:before'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                 => 'tabs_navigation_list_active_border',
				'fields_options'       => [
					'border'           => [
						'default'      => 'solid'
					],
					'width'            => [
						'default'      => [
							'top'      => '0',
							'right'    => '0',
							'bottom'   => '1',
							'left'     => '0',
							'isLinked' => false
						]
					],
					'color'            => [
						'default'      => $accent_color
					]
				],
				'selector'             => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li.active, {{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li:hover'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_navigation_list_active_box_shadow',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li.active, {{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li:hover'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'tabs_list_triangle',
			[
				'label'        => esc_html__('Enable Arrow (in active tab)', 'trx_addons'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'separator'    => 'before',
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'tabs_list_triangle_color',
			[
				'label'     => __('Arrow Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0a1724',
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li.active:before' => 'border-color: {{VALUE}};'
				],
				'condition'    => [
					'tabs_list_triangle' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_list_triangle_size',
			[
				'label'       => __('Arrow Size', 'trx_addons'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px'],
				'range'       => [
					'px'      => [
						'min' => 5,
						'max' => 30
					],
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 14
				],
				'selectors'   => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li.active' => '--trx-addons-tabs-triangle-size: {{SIZE}}{{UNIT}};'
				],
				'condition'   => [
					'tabs_list_triangle' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_list_triangle_margin',
			[
				'label'      => __('Margin', 'trx_addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li.active:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register tabs icon style controls
	 *
	 * @return void
	 */
	protected function register_style_tabs_icon_controls() {
		$this->start_controls_section(
			'section_tabs_icon_style_settings',
			[
				'label' => esc_html__('Navigation Icon/Image', 'trx_addons'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'tabs_navigation_icon_style',
			[
				'label'     => esc_html__('Icon', 'trx_addons'),
				'type'      => Controls_Manager::HEADING,
				'separator' =>  'before'
			]
		);

		$this->add_control(
			'tabs_icon_box_show',
			[
				'label'        => esc_html__('Icon Box', 'trx_addons'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);

		$this->add_responsive_control(
			'tabs_icon_box_height',
			[
				'label'        => __('Icon Box Height', 'trx_addons'),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => ['px'],
				'range'        => [
					'px' 	   => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1
					],
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 100
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li i' => 'height: {{SIZE}}{{UNIT}};'
				],
				'condition'    => [
					'tabs_icon_box_show' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_icon_box_width',
			[
				'label'        => __('Icon Box Width', 'trx_addons'),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => ['px'],
				'range'        => [
					'px' 	   => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1
					],
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 100
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li i' => 'width: {{SIZE}}{{UNIT}};'
				],
				'condition'    => [
					'tabs_icon_box_show' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_icon_size',
			[
				'label'        => __('Icon Size', 'trx_addons'),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => ['px'],
				'range'        => [
					'px' 	   => [
						'min'  => 10,
						'max'  => 100,
						'step' => 1
					],
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 24
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li i' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_icon_box_line_height',
			[
				'label'        => __('Icon Line Height', 'trx_addons'),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => ['px'],
				'range'        => [
					'px' 	   => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1
					],
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 50
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li i' => 'line-height: {{SIZE}}{{UNIT}};'
				],
				'condition'    => [
					'tabs_icon_box_show' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_icon_margin',
			[
				'label'        => __('Margin', 'trx_addons'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%', 'em'],
				'default'      => [
					'top'      => '0',
					'right'    => '10',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_icon_offset',
			[
				'label'        => __('Icon Offset', 'trx_addons'),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => ['px'],
				'range'        => [
					'px' 	   => [
						'min'  => -50,
						'max'  => 50,
						'step' => 1
					],
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 0
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li i' => 'top: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs('tabs_icon_style_tabs');

		// Normal State Tab
		$this->start_controls_tab('tabs_icon_normal', ['label' => esc_html__('Normal', 'trx_addons')]);

		$this->add_control(
			'tabs_navigation_icon_normal_color',
			[
				'label'     => esc_html__('Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0a1724',
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li i' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

		// Active State Tab
		$this->start_controls_tab('tabs_icon_active', ['label' => esc_html__('Active', 'trx_addons')]);

		$this->add_control(
			'tabs_navigation_icon_active_color',
			[
				'label'     => esc_html__('Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0a1724',
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li.active i, {{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li:hover i' => 'color: {{VALUE}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'tabs_navigation_image_style',
			[
				'label'     => esc_html__('Image', 'trx_addons'),
				'type'      => Controls_Manager::HEADING,
				'separator' =>  'before'
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_image_height',
			[
				'label'        => __('Image Height', 'trx_addons'),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => ['px', 'em'],
				'range'        => [
					'px' 	   => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1
					],
					'em' 	   => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1
					],
				],
				'default'      => [
					'unit'     => 'em',
					'size'     => 2
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li img' => 'max-height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_image_margin',
			[
				'label'        => __('Margin', 'trx_addons'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%', 'em'],
				'default'      => [
					'top'      => '0',
					'right'    => '10',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_navigation_image_offset',
			[
				'label'        => __('Image Offset', 'trx_addons'),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => ['px'],
				'range'        => [
					'px' 	   => [
						'min'  => -50,
						'max'  => 50,
						'step' => 1
					],
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 0
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-nav li img' => 'top: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register tabs content style controls
	 *
	 * @return void
	 */
	protected function register_style_tabs_content_controls() {
		$this->start_controls_section(
			'section_tabs_content_style_settings',
			[
				'label' => esc_html__('Content Area', 'trx_addons'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'tabs_content_description_color',
			[
				'label'     => esc_html__('Text Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0a1724',
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-content-description' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_content_description_typography',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-content-description'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tabs_content_background',
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content'
			]
		);

		$this->add_responsive_control(
			'tabs_content_padding',
			[
				'label'      => __('Padding', 'trx_addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'    => '30',
					'right'  => '30',
					'bottom' => '30',
					'left'   => '30'
				],
				'selectors'  => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_description_margin',
			[
				'label'        => __('Margin', 'trx_addons'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%', 'em'],
				'default'      => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-content-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'tabs_content_border',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content'
			]
		);

		$this->add_responsive_control(
			'tabs_content_radius',
			[
				'label'      => __('Border Radius', 'trx_addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0'
				],
				'selectors'  => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register tabs content image style controls
	 *
	 * @return void
	 */
	protected function register_style_tabs_content_image_controls() {

		$this->start_controls_section(
			'section_tabs_image_style_settings',
			[
				'label' => esc_html__('Content Image', 'trx_addons'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'tabs_image_align',
			[
				'label'   => esc_html__('Image Position', 'trx_addons'),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'options' => [
					'trx-addons-tabs-image-left' => [
						'title' => esc_html__('Left', 'trx_addons'),
						'icon'  => 'eicon-arrow-left'
					],
					'trx-addons-tabs-image-right' => [
						'title' => esc_html__('Right', 'trx_addons'),
						'icon'  => 'eicon-arrow-right'
					]
				],
				'default' => 'trx-addons-tabs-image-right'
			]
		);

		$this->add_responsive_control(
			'tabs_image_width',
			[
				'label'        => __('Image Width', 'trx_addons'),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => ['px', 'em', '%'],
				'range'        => [
					'px' 	   => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1
					],
					'em' 	   => [
						'min'  => 0,
						'max'  => 20,
						'step' => 0.1
					],
					'%' 	   => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1
					],
				],
				'default'      => [
					'unit'     => '%',
					'size'     => 30
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-content-thumb' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-content-element' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'tabs_image_css_filter',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-content-thumb img',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register tabs content button style controls
	 *
	 * @return void
	 */
	protected function register_style_tabs_content_button_controls() {

		$accent_color = apply_filters( 'trx_addons_filter_get_theme_accent_color', '#efa758' );

		$this->start_controls_section(
			'section_tabs_btn_style_settings',
			[
				'label' => esc_html__('Content Button', 'trx_addons'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_details_btn_typography',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-btn'
			]
		);

		$this->add_responsive_control(
			'tabs_details_btn_padding',
			[
				'label'        => __('Padding', 'trx_addons'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%', 'em'],
				'default'      => [
					'top'      => '12',
					'right'    => '35',
					'bottom'   => '12',
					'left'     => '35',
					'isLinked' => false
				],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_details_btn_margin',
			[
				'label'        => __('Margin', 'trx_addons'),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => ['px', '%', 'em'],
				'selectors'    => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'tabs_details_btn_radius',
			[
				'label'      => __('Border Radius', 'trx_addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'    => '50',
					'right'  => '50',
					'bottom' => '50',
					'left'   => '50'
				],
				'selectors'  => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs('tabs_details_btn_tabs');

		// Normal state tab
		$this->start_controls_tab('tabs_details_btn_normal', ['label' => esc_html__('Normal', 'trx_addons')]);

		$this->add_control(
			'tabs_details_btn_normal_text_color',
			[
				'label'     => esc_html__('Text Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => $accent_color,
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'tabs_details_btn_normal_bg',
			[
				'label'     => esc_html__('Background Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'            => 'tabs_details_btn_normal_border',
				'fields_options'  => [
					'border'      => [
						'default' => 'solid'
					],
					'width'       => [
						'default' => [
							'top'    => '1',
							'right'  => '1',
							'bottom' => '1',
							'left'   => '1'
						]
					],
					'color'       => [
						'default' => $accent_color
					]
				],
				'selector'        => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_details_btn_normal_box_shadow',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn'
			]
		);

		$this->end_controls_tab();

		// Hover state tab
		$this->start_controls_tab('tabs_details_btn_hover', ['label' => esc_html__('Hover', 'trx_addons')]);

		$this->add_control(
			'tabs_details_btn_hover_text_color',
			[
				'label'     => esc_html__('Text Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'tabs_details_btn_hover_bg',
			[
				'label'     => esc_html__('Background Color', 'trx_addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => $accent_color,
				'selectors' => [
					'{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn:hover' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'tabs_details_btn_hover_border',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn:hover'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_details_btn_hover_box_shadow',
				'selector' => '{{WRAPPER}} .trx-addons-tabs-{{ID}}.trx-addons-tabs > .trx-addons-tabs-content .trx-addons-tabs-btn:hover'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	/**
	 *  Get Saved Widgets
	 *
	 *  @param string $type  Type of template.
	 * 
	 *  @return string  Saved Widgets
	 */
	public function get_saved_template($type = 'page') {
		$saved_widgets = $this->get_post_template( $type );
		$options[-1]   = __( 'Select', 'trx_addons' );
		if ( count( $saved_widgets ) ) {
			foreach ( $saved_widgets as $saved_row ) {
				$options[ $saved_row['id'] ] = $saved_row['name'];
			}
		} else {
			$options['no_template'] = __('No section template is added.', 'trx_addons');
		}
		return $options;
	}

	/**
	 *  Get Templates based on category
	 *
	 *  @param string $type  Type of template.
	 * 
	 *  @return string  Template content
	 */
	public function get_post_template($type = 'page') {

		$posts = get_posts(array(
			'post_type'        => 'elementor_library',
			'orderby'          => 'title',
			'order'            => 'ASC',
			'posts_per_page'   => '-1',
			'tax_query'        => array(
				array(
					'taxonomy' => 'elementor_library_type',
					'field'    => 'slug',
					'terms'    => $type
				)
			)
		) );

		$templates = array();

		if ( is_array( $posts ) ) {
			foreach ( $posts as $post ) {
				$templates[] = array(
					'id'   => $post->ID,
					'name' => $post->post_title
				);
			}
		}

		return $templates;
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'tabs_wrapper',
			[
				'class'	 => [
					'trx-addons-tabs',
					'trx-addons-tabs-' . $this->get_id(),
					esc_attr($settings['tabs_orientation']),
					esc_attr($settings['tabs_navigation_alignment'])
				]
			]
		);
		?>
		<div <?php echo $this->get_render_attribute_string('tabs_wrapper'); ?> data-tabs>

			<ul class="trx-addons-tabs-nav">
				<?php foreach ( $settings['tabs'] as $tab ) { ?>
					<li data-tab class="trx-addons-tabs-nav-item <?php
						echo esc_attr( $tab['tabs_show_as_default'] );
						if ( 'yes' == $settings['tabs_list_triangle'] ) {
							echo ' trx-addons-tabs-nav-item-with-triangle';
						}
					?>"><?php
						if ( 'icon' === $tab['tabs_icon_type'] && ! empty( $tab['tabs_title_icon']['value'] ) ) {
							Icons_Manager::render_icon( $tab['tabs_title_icon'] );
						} else if ( $tab['tabs_icon_type'] === 'image' ) {
							if ( $tab['tabs_title_image']['url'] || $tab['tabs_title_image']['id'] ) {
								echo Group_Control_Image_Size::get_attachment_image_html($tab, 'tabs_navigation_image_size', 'tabs_title_image');
							}
						}
						?><span class="trx-addons-tabs-title"><?php echo wp_kses( $tab['tabs_title'], 'trx_addons_kses_content' ); ?></span>
					</li>
				<?php } ?>
			</ul>

			<?php foreach ($settings['tabs'] as $key => $tab) {
				$has_image = !empty($tab['tabs_image']['url']) ? 'yes' : 'no';
				$link_key  = 'link_' . $key;

				if ('content' === $tab['tabs_content_type']) {
					$tabs_btn_link = $tab['tabs_detail_btn_link']['url'];

					$this->add_render_attribute($link_key, 'class', 'trx-addons-tabs-btn');
					if (!empty($tabs_btn_link)) {
						$this->add_render_attribute($link_key, 'href', esc_url($tabs_btn_link));
						if ($tab['tabs_detail_btn_link']['is_external']) {
							$this->add_render_attribute($link_key, 'target', '_blank');
						}
						if ($tab['tabs_detail_btn_link']['nofollow']) {
							$this->add_render_attribute($link_key, 'rel', 'nofollow');
						}
					}
				}
				?>
				<div class="trx-addons-tabs-content trx-addons-tabs-image-has-<?php echo esc_attr($has_image); ?> <?php echo esc_attr($tab['tabs_show_as_default']); ?> <?php echo esc_attr($settings['tabs_image_align']); ?>">
					<?php if ('save_template' === $tab['tabs_content_type']) { ?>
						<div class="trx-addons-tabs-content-element">
							<?php echo Plugin::$instance->frontend->get_builder_content_for_display( wp_kses_post( $tab['tabs_content_save_template'] ) ); ?>
						</div>
					<?php } else if ('shortcode' === $tab['tabs_content_type']) { ?>
						<?php echo do_shortcode($tab['tabs_content_shortcode']); ?>
					<?php } else { ?>
						<div class="trx-addons-tabs-content-element">
							<div class="trx-addons-tabs-content-description"><?php echo wp_kses_post( $tab['tabs_content'] ); ?></div>
							<?php
							if ('yes' === $tab['tabs_detail_btn_switcher']) {
								echo '<a ' . $this->get_render_attribute_string($link_key) . '>';
								echo esc_html($tab['tabs_detail_btn']);
								echo '</a>';
							}
							?>
						</div>
						<?php if (!empty($tab['tabs_image']['url'])) { ?>
							<div class="trx-addons-tabs-content-thumb">
								<?php echo Group_Control_Image_Size::get_attachment_image_html( $tab, 'tabs_image_size', 'tabs_image' ); ?>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
		<?php
	}
}
