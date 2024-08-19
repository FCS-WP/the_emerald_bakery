<?php
/**
 * Testimonials Widget
 *
 * @package ThemeREX Addons
 * @since v2.30.0
 */

namespace TrxAddons\ElementorWidgets\Widgets\Testimonials;

use TrxAddons\ElementorWidgets\BaseWidget;
use TrxAddons\ElementorWidgets\Utils as TrxAddonsUtils;

// Elementor Classes.
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Testimonials Widget
 */
class TestimonialsWidget extends BaseWidget {

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */
	protected function register_controls() {
		/* Content Tab */
		$this->register_content_testimonials_controls();
		$this->register_content_display_options_controls();
		$this->register_content_slider_controls();
		$this->register_content_help_docs_controls();
		
		/* Style Tab */
		$this->register_style_container_controls();
		$this->register_style_heading_controls();
		$this->register_style_image_controls();
		$this->register_style_author_controls();
		$this->register_style_job_controls();
		$this->register_style_rating_controls();
		$this->register_style_content_controls();
		$this->register_style_quote_controls();
		$this->register_style_arrows_controls();
		$this->register_style_dots_controls();
	}

	/**
	 * Register testimonials controls
	 *
	 * @return void
	 */
	protected function register_content_testimonials_controls() {

		$this->start_controls_section(
			'testimonials_section',
			array(
				'label' => __( 'Testimonials', 'trx_addons' ),
			)
		);

		$repeater = new REPEATER();

		$repeater->add_control(
			'person_image',
			array(
				'label'      => __( 'Image', 'trx_addons' ),
				'type'       => Controls_Manager::MEDIA,
				// 'dynamic'    => array( 'active' => true ),
				'default'    => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'show_label' => true,
			)
		);

		// $repeater->add_group_control(
		// 	Group_Control_Image_Size::get_type(),
		// 	[
		// 		'name' => 'person_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `person_image_size` and `person_image_custom_dimension`.
		// 		'default' => 'thumbnail',
		// 		'condition' => [
		// 			'person_image[url]!' => '',
		// 		],
		// 	]
		// );

		$repeater->add_control(
			'heading',
			array(
				'label'       => __( 'Heading', 'trx_addons' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Leave empty if not needed.', 'trx_addons' ),
				// 'dynamic'     => array( 'active' => true ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'person_name',
			array(
				'label'       => __( 'Name', 'trx_addons' ),
				'type'        => Controls_Manager::TEXT,
				// 'dynamic'     => array( 'active' => true ),
				'default'     => __( 'Joseph L.Mabie', 'trx_addons' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'company_name',
			array(
				'label'       => __( 'Job Title', 'trx_addons' ),
				'type'        => Controls_Manager::TEXT,
				// 'dynamic'     => array( 'active' => true ),
				'default'     => __( 'Influencer', 'trx_addons' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => __( 'Link', 'trx_addons' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'is_external' => true,
				),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'rating',
			array(
				'label'       => __( 'Rating Score', 'trx_addons' ),
				'type'        => Controls_Manager::NUMBER,
                // 'dynamic'     => array( 'active' => true ),
				'description' => __( 'Leave empty if not needed.', 'trx_addons' ),
				'min'         => 0,
				'max'         => 5,
			)
		);

		$repeater->add_control(
			'content',
			array(
				'label'       => __( 'Content', 'trx_addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				// 'dynamic'     => array( 'active' => true ),
				'default'     => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.',
				'label_block' => true,
			)
		);

		$this->add_control(
			'testimonials',
			array(
				'label'       => __( 'Testimonials', 'trx_addons' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => array(
					array(
						'person_name'  => __( 'Joseph L.Mabie', 'trx_addons' ),
						'company_name' => __( 'Influencer', 'trx_addons' ),
						'heading'      => __( 'Great Support Team', 'trx_addons' ),
					),
					array(
						'person_name'  => __( 'Debra Campbell', 'trx_addons' ),
						'company_name' => __( 'Web Developer', 'trx_addons' ),
						'heading'      => __( 'Very Powerful', 'trx_addons' ),
					),
					array(
						'person_name'  => __( 'Joanne Ellis', 'trx_addons' ),
						'company_name' => __( 'Content Creator', 'trx_addons' ),
						'heading'      => __( 'Excellent Service', 'trx_addons' ),
					),
				),
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{person_name}}}',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register display options controls
	 *
	 * @return void
	 */
	protected function register_content_display_options_controls() {
		$this->start_controls_section(
			'display_option_section',
			array(
				'label' => __( 'Display Options', 'trx_addons' ),
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'              => __( 'Columns', 'trx_addons' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '3',
				'tablet_default'     => '2',
				'mobile_default'     => '1',
				'options'            => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'prefix_class'       => 'elementor-grid%s-',
				'render_type'        => 'template',
				'frontend_available' => true,
			)
		);

		$this->add_responsive_control(
			'spacing',
			array(
				'label'      => __( 'Spacing', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'    => 5,
					'right'  => 5,
					'bottom' => 5,
					'left'   => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-container' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}}; margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0',
				),
			)
		);

		$this->add_control(
			'equal_height',
			array(
				'label'        => __( 'Equal Height', 'trx_addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'This option searches for the testimonial with the largest height and applies that height to the other testimonials', 'trx_addons' ),
				'prefix_class' => 'trx-addons-testimonials-equal-height-',
			)
		);

		$this->add_responsive_control(
			'content_align',
			array(
				'label'                => __( 'Alignment', 'trx_addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'left'   => array(
						'title' => __( 'Left', 'trx_addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'trx_addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'trx_addons' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors_dictionary' => array(
					'left'   => 'align-items: flex-start; text-align: left',
					'center' => 'align-items: center; text-align: center',
					'right'  => 'align-items: flex-end; text-align: right',
				),
				'default'              => 'center',
				'selectors'            => array(
					'{{WRAPPER}} .trx-addons-testimonials-content-wrapper' => '{{VALUE}}',
				),
				'separator'            => 'before',
			)
		);

		$this->add_responsive_control(
			'content_valign',
			[
				'label'                 => __( 'Vertical Alignment', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'top' => [
						'title' => __( 'Top', 'trx_addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'trx_addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'trx_addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default'               => 'top',
				'selectors_dictionary'  => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-testimonials-content-wrapper' => 'justify-content: {{VALUE}}',
				],
				'condition'             => [
					'equal_height' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_image',
			array(
				'label'     => __( 'Show Image', 'trx_addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'person_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `person_image_size` and `person_image_custom_dimension`.
				'default' => 'thumbnail',
			]
		);

		$this->add_responsive_control(
			'image_position',
			[
				'label'                 => __( 'Image Position', 'trx_addons' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'left' => [
						'title' => __( 'Left', 'trx_addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'trx_addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => __( 'Right', 'trx_addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default'               => 'left',
				'selectors_dictionary'  => [
					'left' => 'row',
					'top' => 'column',
					'right' => 'row-reverse',
				],
				'selectors'             => [
					'{{WRAPPER}} .trx-addons-testimonials__img-info' => 'flex-direction: {{VALUE}}',
				],
				'condition'             => [
					'skin' => ['skin1', 'skin2'],
				],
			]
		);

		$this->add_control(
			'heading_size',
			array(
				'label'       => __( 'Heading HTML Tag', 'trx_addons' ),
				'label_block' => false,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'p'    => 'p',
				),
				'default'     => 'h4',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'person_name_size',
			array(
				'label'       => __( 'Name HTML Tag', 'trx_addons' ),
				'label_block' => false,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default'     => 'h5',
			)
		);

		$this->add_control(
			'company_name_size',
			array(
				'label'       => __( 'Job HTML Tag', 'trx_addons' ),
				'label_block' => false,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default'     => 'h6',
			)
		);

		$this->add_control(
			'skin',
			array(
				'label'              => __( 'Content Position', 'trx_addons' ),
				'label_block'        => false,
				'type'               => Controls_Manager::SELECT,
				'default'            => 'skin1',
				'options'            => array(
					'skin1' => __( 'Content / Image / Author', 'trx_addons' ),
					'skin2' => __( 'Image / Author / Content', 'trx_addons' ),
					'skin3' => __( 'Image / Content / Author', 'trx_addons' ),
				),
				'prefix_class'       => 'trx-addons-testimonials__',
				'render_type'        => 'template',
				'frontend_available' => true,
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'rating_position',
			array(
				'label'        => __( 'Rating Position', 'trx_addons' ),
				'label_block'  => false,
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'hide'   => __( 'Hide', 'trx_addons' ),
					'before' => __( 'Before Content', 'trx_addons' ),
					'after'  => __( 'After Content', 'trx_addons' ),
				),
				'default'      => 'after',
				'prefix_class' => 'trx-addons-testimonials-rating-position-',
			)
		);

		$this->add_control(
			'icon_show',
			array(
				'label'       => __( 'Quotation', 'trx_addons' ),
				'label_block' => false,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'hide'    => __( 'Hide', 'trx_addons' ),
					'top'     => __( 'Top', 'trx_addons' ),
					'bottom'  => __( 'Bottom', 'trx_addons' ),
					'both'    => __( 'Both', 'trx_addons' ),
				),
				'default'     => 'hide',
			)
		);

		$this->add_control(
			'icon_style',
			array(
				'label'       => __( 'Style', 'trx_addons' ),
				'label_block' => false,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'rounded' => __( 'Rounded', 'trx_addons' ),
					'sharp'   => __( 'Sharp', 'trx_addons' ),
				),
				'default'     => 'rounded',
				'condition'   => array(
					'icon_show!' => 'hide',
				),
			)
		);

		$this->end_controls_section();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Register container style controls
	 *
	 * @return void
	 */
	protected function register_style_container_controls() {
		$this->start_controls_section(
			'container_style_section',
			array(
				'label' => __( 'Container', 'trx_addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-content-wrapper',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-content-wrapper',
			)
		);

		$this->add_control(
			'container_border_radius',
			array(
				'label'      => __( 'Border Radius', 'trx_addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-content-wrapper' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'container_adv_radius!' => 'yes',
				),
			)
		);

		$this->add_control(
			'container_adv_radius',
			array(
				'label'       => __( 'Advanced Border Radius', 'trx_addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Apply custom radius values. Get the radius value from ', 'trx_addons' ) . '<a href="https://9elements.github.io/fancy-border-radius/" target="_blank">here</a>',
			)
		);

		$this->add_control(
			'container_adv_radius_value',
			array(
				'label'     => __( 'Border Radius', 'trx_addons' ),
				'type'      => Controls_Manager::TEXT,
				// 'dynamic'   => array( 'active' => true ),
				'selectors' => array(
					'{{WRAPPER}} .trx-addons-testimonials-content-wrapper' => 'border-radius: {{VALUE}};',
				),
				'condition' => array(
					'container_adv_radius' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-content-wrapper',
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => __( 'Padding', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Heading style controls
	 *
	 * @return void
	 */
	protected function register_style_heading_controls() {
		$this->start_controls_section(
			'heading_style_section',
			array(
				'label' => __( 'Heading', 'trx_addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => __( 'Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .trx-addons-testimonials-heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-heading',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'heading_shadow',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-heading',
			)
		);

		$this->add_responsive_control(
			'heading_margin',
			array(
				'label'      => __( 'Margin', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-heading' => 'margin: {{top}}{{UNIT}} {{right}}{{UNIT}} {{bottom}}{{UNIT}} {{left}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register image style controls
	 *
	 * @return void
	 */
	protected function register_style_image_controls() {
		$this->start_controls_section(
			'image_style',
			array(
				'label'     => __( 'Image', 'trx_addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_image' => 'yes',
				),
			)
		);

		$this->add_control(
			'img_size',
			array(
				'label'      => __( 'Size', 'trx_addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 100,
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 150,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-img-wrapper' => 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'img_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-img-wrapper',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'img_border',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-img-wrapper',
			)
		);

		$this->add_control(
			'img_border_radius',
			array(
				'label'      => __( 'Border Radius', 'trx_addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-img-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-img-wrapper',
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'hover_css_filters',
				'label'    => __( 'Hover CSS Filters', 'trx_addons' ),
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-container:hover .trx-addons-testimonials-img-wrapper',
			)
		);

		$this->add_responsive_control(
			'image_margin',
			array(
				'label'      => __( 'Margin', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-img-wrapper' => 'margin: {{top}}{{UNIT}} {{right}}{{UNIT}} {{bottom}}{{UNIT}} {{left}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Author name style controls
	 *
	 * @return void
	 */
	protected function register_style_author_controls() {
		$this->start_controls_section(
			'person_style_section',
			array(
				'label' => __( 'Name', 'trx_addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'person_name_color',
			array(
				'label'     => __( 'Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .trx-addons-testimonials-person-name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'author_name_typography',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-person-name',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'author_name_shadow',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-person-name',
			)
		);

		$this->add_responsive_control(
			'name_margin',
			array(
				'label'      => __( 'Margin', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-person-name' => 'margin: {{top}}{{UNIT}} {{right}}{{UNIT}} {{bottom}}{{UNIT}} {{left}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register job style controls
	 *
	 * @return void
	 */
	protected function register_style_job_controls() {
		$this->start_controls_section(
			'company_style_section',
			array(
				'label' => __( 'Job Title', 'trx_addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'job_align',
			array(
				'label'     => __( 'Alignment', 'trx_addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'trx_addons' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'trx_addons' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'trx_addons' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .trx-addons-testimonials-author-info' => 'align-items: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'company_name_color',
			array(
				'label'     => __( 'Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .trx-addons-testimonials-company-link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'company_name_typography',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-company-link',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'company_name_shadow',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-company-link',
			)
		);

		$this->add_responsive_control(
			'job_margin',
			array(
				'label'      => __( 'Margin', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-job' => 'margin: {{top}}{{UNIT}} {{right}}{{UNIT}} {{bottom}}{{UNIT}} {{left}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register rating style controls
	 *
	 * @return void
	 */
	protected function register_style_rating_controls() {
		$this->start_controls_section(
			'rating_style_section',
			array(
				'label' => __( 'Rating Score', 'trx_addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'rating_position!' => 'hide',
				),
			)
		);

		$this->add_control(
			'star_size',
			array(
				'label'   => __( 'Star Size', 'trx_addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 50,
				'default' => 15,
				'condition' => array(
					'rating_position!' => 'hide',
				),
			)
		);

		$this->add_control(
			'fill',
			array(
				'label'   => __( 'Star Color', 'trx_addons' ),
				'type'    => Controls_Manager::COLOR,
				'global'  => false,
				'default' => '#ffab40',
				'condition' => array(
					'rating_position!' => 'hide',
				),
			)
		);

		$this->add_control(
			'empty',
			array(
				'label'  => __( 'Empty Star Color', 'trx_addons' ),
				'type'   => Controls_Manager::COLOR,
				'global' => false,
				'condition' => array(
					'rating_position!' => 'hide',
				),
			)
		);

		$this->add_responsive_control(
			'rating_margin',
			array(
				'label'      => __( 'Margin', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials__rating-wrapper' => 'margin: {{top}}{{UNIT}} {{right}}{{UNIT}} {{bottom}}{{UNIT}} {{left}}{{UNIT}};',
				),
				'condition' => array(
					'rating_position!' => 'hide',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register content style controls
	 *
	 * @return void
	 */
	protected function register_style_content_controls() {
		$this->start_controls_section(
			'content_style_section',
			array(
				'label' => __( 'Content', 'trx_addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => __( 'Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}} .trx-addons-testimonials-text-wrapper' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .trx-addons-testimonials-text-wrapper',
			)
		);

		$this->add_responsive_control(
			'margin',
			array(
				'label'      => __( 'Margin', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-text-wrapper' => 'margin: {{top}}{{UNIT}} {{right}}{{UNIT}} {{bottom}}{{UNIT}} {{left}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register quotation icon style controls
	 *
	 * @return void
	 */
	protected function register_style_quote_controls() {
		$this->start_controls_section(
			'quotes_style_section',
			array(
				'label' => __( 'Quotation Icon', 'trx_addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'icon_show!' => 'hide',
				),
			)
		);

		$this->add_control(
			'quote_icon_color',
			array(
				'label'     => __( 'Color', 'trx_addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#58BFCA',
				'selectors' => array(
					'{{WRAPPER}} .trx-addons-testimonials-quote'   => 'fill: {{VALUE}};',
				),
				'condition' => array(
					'icon_show!' => 'hide',
				),
			)
		);

		$this->add_responsive_control(
			'quotes_size',
			array(
				'label'      => __( 'Size', 'trx_addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 250,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-upper-quote svg, {{WRAPPER}} .trx-addons-testimonials-lower-quote svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'icon_show!' => 'hide',
				),
			)
		);

		$this->add_responsive_control(
			'upper_quote_position',
			array(
				'label'      => __( 'Top Icon Position', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-upper-quote' => 'top: {{TOP}}{{UNIT}}; left:{{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'icon_show!' => 'hide',
				),
			)
		);

		$this->add_responsive_control(
			'lower_quote_position',
			array(
				'label'      => __( 'Bottom Icon Position', 'trx_addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .trx-addons-testimonials-lower-quote' => 'right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
				),
				'condition' => array(
					'icon_show!' => 'hide',
				),
			)
		);

		$this->end_controls_section();
	}


	/*-----------------------------------------------------------------------------------*/
	/*	RENDER FUNCTIONS
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Render Testimonials widget output on the frontend.
	 *
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$heading_tag = TrxAddonsUtils::validate_html_tag( $settings['heading_size'] );
		$person_title_tag = TrxAddonsUtils::validate_html_tag( $settings['person_name_size'] );
		$job_tag          = TrxAddonsUtils::validate_html_tag( $settings['company_name_size'] );

		$show_image = $settings['show_image'];

		if ( 'yes' === $show_image ) {
			$this->add_render_attribute( 'img_wrap', 'class', 'trx-addons-testimonials-img-wrapper' );
		}

		$testimonials = $settings['testimonials'];
		$carousel = 'yes' === $settings['slider'] ? true : false;

		$atts = array(
			'class' => 'trx-addons-testimonials-box multiple-testimonials'
		);
		if ( $carousel ) {
			$atts['data-carousel'] = $carousel;
			$atts['data-rtl'] = is_rtl();
			$atts['class'] .= ' swiper-container-wrap swiper'
								. ( ! empty( $settings['dots_position'] )
									? ' swiper-container-wrap-dots-' . $settings['dots_position']
									: ''
									);
		}
		$this->add_render_attribute( 'testimonials_container', $atts );

		if ( $carousel ) {
			$this->add_render_attribute( 'testimonials_carousel', array(
				'class' => 'trx-addons-testimonials-carousel trx-addons-swiper-slider swiper-container'
			) );
			$this->render_slider_settings( 'testimonials_carousel' );
		} else {
			$this->add_render_attribute( 'testimonials_carousel', array(
				'class' => 'trx-addons-elementor-grid trx-addons-testimonials-grid'
			) );
		}
		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'testimonials_container' ) ); ?>>
			
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'testimonials_carousel' ) ); ?>>
			<?php if ( $carousel ) { ?>
				<div class="swiper-wrapper">
			<?php } ?>

			<?php
			foreach ( $testimonials as $index => $testimonial ) :

				if ( 'yes' === $show_image ) {
					$testionial_image_html = $this->get_author_image( $testimonial, $settings );
				}

				if ( ! empty( $testimonial['link']['url'] ) ) {

					$this->add_render_attribute( 'link_' . $index, 'class', 'trx-addons-testimonials-company-link' );
					$this->add_link_attributes( 'link_' . $index, $testimonial['link'] );
				}

				?>

				<div class="trx-addons-testimonials-container<?php
					if ( $carousel ) {
						echo ' trx-addons-carousel-item-wrap swiper-slide';
					} else {
						echo ' trx-addons-grid-item-wrap';
					}
				?>">

					<?php if ( in_array( $settings['icon_show'], array( 'top', 'both' ) ) ) : ?>
						<div class="trx-addons-testimonials-upper-quote">
							<?php $this->render_quote_icon(); ?>
						</div>
					<?php endif; ?>

					<div class="trx-addons-testimonials-content-wrapper">

						<?php if ( ! empty( $testimonial['heading'] ) ) : ?>
							<<?php echo wp_kses_post( $heading_tag ); ?> class="trx-addons-testimonials-heading">
								<p <?php echo wp_kses_post( $this->get_render_attribute_string( 'heading' ) ); ?>>
									<?php echo wp_kses_post( $testimonial['heading'] ); ?>
								</p>
							</<?php echo wp_kses_post( $heading_tag ); ?>>
						<?php endif; ?>

						<div class="trx-addons-testimonials-text-wrapper">
							<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'testimonials_content' ) ); ?>>
								<?php echo $this->parse_text_editor( $testimonial['content'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>

						<?php if ( ! empty( $testimonial['rating'] ) && $settings['rating_position'] != 'hide' ) : ?>
							<div class="trx-addons-testimonials__rating-wrapper">
								<?php echo $this->render_rating_stars( $testimonial['rating'], $settings['fill'], $settings['empty'], $settings['star_size'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! in_array( $settings['skin'], array( 'skin3' ) ) ) : ?>
							<div class="trx-addons-testimonials__img-info">
						<?php endif; ?>

							<?php if ( ! empty( $testionial_image_html ) ) : ?>
								<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'img_wrap' ) ); ?>>
									<?php echo wp_kses_post( $testionial_image_html ); ?>
								</div>
							<?php endif; ?>

							<div class="trx-addons-testimonials-author-info">
								<<?php echo wp_kses_post( $person_title_tag ); ?> class="trx-addons-testimonials-person-name">
									<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'testimonials_person_name' ) ); ?>>
										<?php echo wp_kses_post( $testimonial['person_name'] ); ?>
									</span>
								</<?php echo wp_kses_post( $person_title_tag ); ?>>

								<?php if ( ! empty( $testimonial['company_name'] ) ) : ?>
									<<?php echo wp_kses_post( $job_tag ); ?> class="trx-addons-testimonials-job">
									<?php if ( ! empty( $testimonial['link']['url'] ) ) : ?>
										<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'link_' . $index ) ); ?>>
											<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'testimonials_company_name' ) ); ?>>
												<?php echo wp_kses_post( $testimonial['company_name'] ); ?>
											</span>
										</a>
									<?php else : ?>
										<span class="trx-addons-testimonials-company-link" <?php echo wp_kses_post( $this->get_render_attribute_string( 'testimonials_company_name' ) ); ?>>
											<?php echo wp_kses_post( $testimonial['company_name'] ); ?>
										</span>
									<?php endif; ?>
									</<?php echo wp_kses_post( $job_tag ); ?>>
								<?php endif; ?>
							</div>

						<?php if ( ! in_array( $settings['skin'], array( 'skin3' ) ) ) : ?>
							</div>
						<?php endif; ?>

					</div>

					<?php if ( in_array( $settings['icon_show'], array( 'bottom', 'both' ) ) ) : ?>
						<div class="trx-addons-testimonials-lower-quote">
							<?php $this->render_quote_icon(); ?>
						</div>
					<?php endif; ?>

				</div>

			<?php endforeach; ?>

			<?php if ( $carousel ) { ?>
				</div>
				<?php
				$this->render_dots();
				$this->render_arrows();
				?>
			<?php } ?>

			</div>

		</div>
		<?php
	}

	/**
	 * Render Quote Icon
	 *
	 * @since 4.10.13
	 * @access protected
	 */
	protected function render_quote_icon() {

		$svg_html = '';

		$settings = $this->get_settings_for_display();

		if ( 'rounded' === $settings['icon_style'] ) {

			$svg_html = '<svg id="Layer_1" class="trx-addons-testimonials-quote" xmlns="http://www.w3.org/2000/svg" width="48" height="37" viewBox="0 0 48 37"><path class="cls-1" d="m37,37c6.07,0,11-4.93,11-11s-4.93-11-11-11c-.32,0-.63.02-.94.05.54-4.81,2.18-9.43,4.79-13.52.19-.31.2-.7.03-1.01-.18-.32-.51-.52-.88-.52h-2c-.27,0-.54.11-.73.31-5.14,5.41-11.27,14.26-11.27,25.69,0,6.07,4.93,10.99,11,11h0Zm-26,0c6.07,0,11-4.93,11-11s-4.93-11-11-11c-.32,0-.63.02-.94.05.54-4.81,2.18-9.43,4.79-13.52.19-.31.2-.7.03-1.01-.18-.32-.51-.52-.87-.52h-2c-.27,0-.54.11-.73.31C6.13,5.72,0,14.57,0,26c0,6.07,4.93,10.99,11,11h0Zm0,0"/></svg>';

		} else if ( 'sharp' === $settings['icon_style'] ) {

			$svg_html = '<svg id="Layer_1" class="trx-addons-testimonials-quote" xmlns="http://www.w3.org/2000/svg" width="48" height="37.5" viewBox="0 0 48 37.5"><path class="cls-1" d="m21,16.5v21H0v-21.3C0,1.8,13.5,0,13.5,0l1.8,4.2s-6,.9-7.2,5.7c-1.2,3.6,1.2,6.6,1.2,6.6h11.7Zm27,0v21h-21v-21.3C27,1.8,40.5,0,40.5,0l1.8,4.2s-6,.9-7.2,5.7c-1.2,3.6,1.2,6.6,1.2,6.6h11.7Z"/></svg>';
		}

		if ( ! empty( $svg_html ) ) {
			echo $svg_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Render Rating Stars
	 *
	 * @param float  $rating rating score.
	 * @param string $fill_color fill color.
	 * @param string $empty_color empty color.
	 * @param float  $star_size star size.
	 */
	protected function render_rating_stars( $rating, $fill_color, $empty_color, $star_size ) {
		?><span class="trx-addons-fb-rev-stars"><?php
		foreach ( array( 1, 2, 3, 4, 5 ) as $val ) {
			$score = round( ( $rating - $val ), 2 );
			if ( $score >= -0.2 ) {
				?><span class="trx-addons-fb-rev-star"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="<?php echo esc_attr( $star_size ); ?>" height="<?php echo esc_attr( $star_size ); ?>" viewBox="0 0 1792 1792"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z" fill="<?php echo esc_attr( $fill_color ); ?>"></path></svg></span><?php
			} else if ( $score > -0.8 && $score < -0.2 ) {
				?><span class="trx-addons-fb-rev-star"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="<?php echo esc_attr( $star_size ); ?>" height="<?php echo esc_attr( $star_size ); ?>" viewBox="0 0 1792 1792"><path d="M1250 957l257-250-356-52-66-10-30-60-159-322v963l59 31 318 168-60-355-12-66zm452-262l-363 354 86 500q5 33-6 51.5t-34 18.5q-17 0-40-12l-449-236-449 236q-23 12-40 12-23 0-34-18.5t-6-51.5l86-500-364-354q-32-32-23-59.5t54-34.5l502-73 225-455q20-41 49-41 28 0 49 41l225 455 502 73q45 7 54 34.5t-24 59.5z" fill="<?php echo esc_attr( $fill_color ); ?>"></path></svg></span><?php
			} else {
				?><span class="trx-addons-fb-rev-star"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="<?php echo esc_attr( $star_size ); ?>" height="<?php echo esc_attr( $star_size ); ?>" viewBox="0 0 1792 1792"><path d="M1201 1004l306-297-422-62-189-382-189 382-422 62 306 297-73 421 378-199 377 199zm527-357q0 22-26 48l-363 354 86 500q1 7 1 20 0 50-41 50-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z" fill="<?php echo esc_attr( $empty_color ); ?>"></path></svg></span><?php
			}
		}
		?></span><?php
	}

	/**
	 * Get Author Image
	 *
	 * @since 4.10.13
	 * @access protected
	 */
	protected function get_author_image( $testimonial, $settings ) {

		$testionial_image_html = '';
		if ( ! empty( $testimonial['person_image']['url'] ) ) {

			// $image_src = $testimonial['person_image']['url'];
			// $image_id  = attachment_url_to_postid( $image_src );

			// $settings['image_data'] = TrxAddonsUtils::get_image_data( $image_id, $testimonial['person_image']['url'], 'thumbnail' );
			// $testionial_image_html  = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image_data' );

			$testionial_image_html  = Group_Control_Image_Size::get_attachment_image_html( array_merge( $settings, $testimonial ), 'person_image' );

		}

		return $testionial_image_html;
	}

}
