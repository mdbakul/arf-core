<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Repeater;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Utils;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Pricing_Tab extends Widget_Base {

	use \TPCore\Widgets\TPCoreElementFunctions;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tp-pricing-tab';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Pricing Tab', 'tpcore' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'tp-icon';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'tpcore' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'tpcore' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */

    protected function register_controls(){
        $this->register_controls_section();
        $this->style_tab_content();
    } 

	protected function register_controls_section() {

        // layout Panel
        $this->start_controls_section(
            'tp_layout',
            [
                'label' => esc_html__('Design Layout', 'tpcore'),
            ]
        );
        $this->add_control(
            'tp_design_style',
            [
                'label' => esc_html__('Select Layout', 'tpcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'layout-1' => esc_html__('Layout 1', 'tpcore'),
                    'layout-2' => esc_html__('Layout 2', 'tpcore'),
                    'layout-3' => esc_html__('Layout 3', 'tpcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // title/content
        $this->tp_section_title_render_controls('section', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-3']);

        // pricing group 1
        $this->start_controls_section(
            'tp_pricing',
            [
                'label' => esc_html__('Pricing Tab 1', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_pricing_btn1',
            [
                'label' => esc_html__('Button 1 Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Monthly', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'template1',
            [
                'label' => __('Section Template', 'tpcore'),
                'placeholder' => __('Select a section template for as tab content', 'tpcore'),

                'type' => Controls_Manager::SELECT2,
                'options' => get_elementor_templates()
            ]
        );
        $this->end_controls_section();

        // pricing group 2
        $this->start_controls_section(
            'tp_pricing2',
            [
                'label' => esc_html__('Pricing Tab 2', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_pricing_btn2',
            [
                'label' => esc_html__('Button 2 Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Yearly', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'template2',
            [
                'label' => __('Section Template 2', 'tpcore'),
                'placeholder' => __('Select a section template for as tab content', 'tpcore'),
                'type' => Controls_Manager::SELECT2,
                'options' => get_elementor_templates()
            ]
        );
        $this->end_controls_section();

        
        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
                'condition' => [
                    'tp_design_style' => 'layout-1'
                ]
            ]
        );

        $this->add_control(
            'tp_image',
            [
                'label' => esc_html__( 'Choose Image', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tp_image_size',
                'default' => 'full',
                'exclude' => [
                    'custom'
                ]
            ]
        );
        $this->end_controls_section();
        
        
        // shape
        $this->start_controls_section(
        'tp_shape',
            [
                'label' => esc_html__( 'Shape Section', 'tpcore' ),
            ]
        );

        $this->add_control(
        'tp_shape_switch',
        [
            'label'        => esc_html__( 'Shape On/Off', 'tpcore' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'tpcore' ),
            'label_off'    => esc_html__( 'Hide', 'tpcore' ),
            'return_value' => 'yes',
            'default'      => '0',
        ]
        );

        $this->add_control(
            'tp_shape_image_1',
            [
                'label' => esc_html__( 'Choose Shape Image 1', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_2',
            [
                'label' => esc_html__( 'Choose Shape Image 2', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => ['layout-1', 'layout-3']
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_3',
            [
                'label' => esc_html__( 'Choose Shape Image 3', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => ['layout-1', 'layout-3']
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_4',
            [
                'label' => esc_html__( 'Choose Shape Image 4', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => ['layout-1', 'layout-3']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'shape_image_size', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                ]
            ]
        );
        
        $this->end_controls_section();
        
	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('advanced_tab_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-3']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-3']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-3']);
        $this->tp_basic_style_controls('tab_btn_title', 'Tab Button Title', '.tp-el-tab-btn', ['layout-1', 'layout-2', 'layout-3']);
    }

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>


<?php if ( $settings['tp_design_style']  == 'layout-2' ) : 
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
?>

<section class="pricing-area tp-price-parent tppricing-box-active pb-170 fix ele-section">
    <div class="container">
        <div class="tpprice-4-switch-box  p-relative z-index-1">
            <div class="tpprice-4-switch p-relative">
                <div class="tpprice-switch-wrapper tpprice-4-position tppricing-switch-2">
                    <div class="toggle">
                        <input type="checkbox" id="switcher-price" class="tp-check">
                        <b class="switch"></b>
                    </div>
                    <div class="label-text">

                        <?php if(!empty($settings['tp_pricing_btn1'])) : ?>
                        <label class="toggler toggler-price-active tp-el-tab-btn"
                            id="filt-monthly-price"><?php echo tp_kses($settings['tp_pricing_btn1']); ?></label>
                        <?php endif; ?>
                        <?php if(!empty($settings['tp_pricing_btn2'])) : ?>
                        <label class="toggler tp-el-tab-btn"
                            id="filt-yearly-price"><?php echo tp_kses($settings['tp_pricing_btn2']); ?></label>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="tppricing-shape-4">
                <div class="tppricing-shape-1">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/pricing-4-shape-3.png"
                        alt="">
                </div>
                <div class="tppricing-shape-3">
                    <svg width="86" height="59" viewBox="0 0 86 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1 39.5506C8 21.0506 23.7 -11.5494 30.5 6.05057C39 28.0506 33 68.5508 63 48.0508C71.5 44.0508 78 41.5508 85 58.0508"
                            stroke="currentColor" stroke-linejoin="round" stroke-dasharray="4 4" />
                    </svg>
                </div>
                <div class="tppricing-shape-2">
                    <img src="<?php echo esc_url($tp_shape_image); ?>"
                        alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="price-scroll">
            <div class="price-scroll-width">
                <div class="row gx-0">
                    <div class="col-12">
                        <div id="monthly-price" class="wrapper-full">
                            <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content($settings['template1'], true); ?>
                        </div>
                        <div id="hourly-price" class="wrapper-full price-is-hide">
                            <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content($settings['template2'], true); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : 
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_3']['url']) ) {
        $tp_shape_image3 = !empty($settings['tp_shape_image_3']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_3']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_3']['url'];
        $tp_shape_image_alt3 = get_post_meta($settings["tp_shape_image_3"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_4']['url']) ) {
        $tp_shape_image4 = !empty($settings['tp_shape_image_4']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_4']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_4']['url'];
        $tp_shape_image_alt4 = get_post_meta($settings["tp_shape_image_4"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'pricing-inner-top-title tp-el-title');    
?>

<div class="breadcrumb-services-area pricing-inner-bg scene breadcrumb-bg p-relative ele-section">
    <div class="about-inner-shape">
        <?php if(!empty($tp_shape_image)) : ?>
        <div class="about-inner-shape-2">
            <img class="layer" data-depth="0.5" src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
        <?php endif; ?>
        <?php if(!empty($tp_shape_image2)) : ?>
        <div class="about-inner-shape-3 d-none d-lg-block">
            <img class="layer" data-depth="0.5" src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
        </div>
        <?php endif; ?>
    </div>
    <?php if(!empty($tp_shape_image3)) : ?>
    <div class="tpbanner-shape-y scene-y">
        <div class="about-inner-shape-4 d-none d-lg-block">
            <img class="layer" data-depth="0.6" src="<?php echo esc_url($tp_shape_image3); ?>" alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
        </div>
    </div>
    <?php endif; ?>
    <?php if(!empty($tp_shape_image4)) : ?>
    <div class="about-inner-shape-5 d-none d-lg-block">
        <img src="<?php echo esc_url($tp_shape_image4); ?>" alt="<?php echo esc_attr($tp_shape_image_alt4); ?>">
    </div>
    <?php endif; ?>
</div>

<section class="pricing-area tp-inner-pricing-switch tp-price-parent mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="pricing-inner-wrapper text-center">
                    <div class="pricing-inner-top">
                        <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_section_sub_title']); ?></span>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_section_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_section_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_section_title' ] )
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_section_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tpprice-switch text-center p-relative mb-55">
                    <div class="tpprice-switch-wrapper d-flex align-items-center justify-content-center">
                        <div class="tppricing-switch-btn-switch">
                            <div class="toggle">
                                <input type="checkbox" id="switcher" class="check">
                                <b class="switch"></b>
                            </div>
                        </div>
                        <div class="tppricing-switch-btn-switch-item mt-10">

                            <?php if(!empty($settings['tp_pricing_btn1'])) : ?>
                            <label class="toggler toggler--is-active tp-el-tab-btn" id="filt-monthly"><?php echo tp_kses($settings['tp_pricing_btn1']); ?></label>
                            <?php endif; ?>
                            <?php if(!empty($settings['tp_pricing_btn2'])) : ?>
                            <label class="toggler  tp-el-tab-btn" id="filt-yearly"><?php echo tp_kses($settings['tp_pricing_btn2']); ?></label>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tp-price-toggle">
                    <div id="monthly" class="wrapper-full">
                        <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content($settings['template1'], true); ?>
                    </div>
                    <div id="hourly" class="wrapper-full hide">
                        <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content($settings['template2'], true); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else : 

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }
    
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_3']['url']) ) {
        $tp_shape_image3 = !empty($settings['tp_shape_image_3']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_3']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_3']['url'];
        $tp_shape_image_alt3 = get_post_meta($settings["tp_shape_image_3"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_4']['url']) ) {
        $tp_shape_image4 = !empty($settings['tp_shape_image_4']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_4']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_4']['url'];
        $tp_shape_image_alt4 = get_post_meta($settings["tp_shape_image_4"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'tpsection__title mb-25 tp-el-title');    
?>

<section class="pricing-area tp-price-parent pricing-shape-relative p-relative pt-40 pb-90 ele-section">
    <?php if(!empty($tp_image)) : ?>
    <div class="tpprice-shape-one d-none d-xl-block">
        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="tppricing-wrapper">
            <div class="tppricing-shape">
                <?php if(!empty($tp_shape_image)) : ?>
                <div class="tppricing-shape-one d-none d-md-block">
                    <img src="<?php echo esc_url($tp_shape_image); ?>"
                        alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="tpprice-switch p-relative mb-40">
                        <div class="tpsection__content pt-65 mb-20">
                            <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                            <div class="tpbanner__sub-title mb-15">
                                <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_section_sub_title']); ?></span>
                                <i>
                                    <svg width="114" height="37" viewBox="0 0 114 37" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <rect y="-0.000488281" width="114" height="37" fill="url(#pattern7)"
                                            fill-opacity="0.08" />
                                        <defs>
                                            <pattern id="pattern7" patternContentUnits="objectBoundingBox" width="1"
                                                height="1">
                                                <use xlink:href="#image0_936_1479"
                                                    transform="translate(-0.0507936) scale(0.00603175 0.0205405)" />
                                            </pattern>
                                            <image id="image0_936_1479" width="180" height="50"
                                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==" />
                                        </defs>
                                    </svg>
                                </i>
                            </div>
                            <?php endif; ?>
                            <?php
                            if ( !empty($settings['tp_section_title' ]) ) :
                                printf( '<%1$s %2$s>%3$s</%1$s>',
                                tag_escape( $settings['tp_section_title_tag'] ),
                                $this->get_render_attribute_string( 'title_args' ),
                                tp_kses( $settings['tp_section_title' ] )
                                );
                            endif;
                            ?>
                            <?php if ( !empty($settings['tp_section_description']) ) : ?>
                            <p class="tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="tpprice-switch-wrapper">
                            <?php if(!empty($settings['tp_pricing_btn1'])) : ?>
                            <label class="toggler toggler--is-active tp-el-tab-btn" id="filt-monthly"><?php echo tp_kses($settings['tp_pricing_btn1']); ?></label>
                            <?php endif; ?>
                            <div class="toggle">
                                <input type="checkbox" id="switcher" class="tp-check">
                                <b class="switch"></b>
                            </div>
                            <?php if(!empty($settings['tp_pricing_btn2'])) : ?>
                            <label class="toggler tp-el-tab-btn" id="filt-yearly"><?php echo tp_kses($settings['tp_pricing_btn2']); ?></label>
                            <?php endif; ?>
                        </div>
                        <div class="tpprice-shape">
                            <?php if(!empty($tp_shape_image2)) : ?>
                            <div class="tpprice-shape-two d-none d-lg-block">
                                <img src="<?php echo esc_url($tp_shape_image2); ?>"
                                    alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="tp-price-toggle">
                        <div id="monthly" class="wrapper-full">
                            <div class="tpprice pl-40">

                                <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content($settings['template1'], true); ?>

                                <div class="tpprice-shape d-none d-lg-block">
                                    <?php if(!empty($tp_shape_image3)) : ?>
                                    <div class="tpprice-shape-two">
                                        <img src="<?php echo esc_url($tp_shape_image3); ?>"
                                            alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
                                    </div>
                                    <?php endif; ?>
                                    <?php if(!empty($tp_shape_image4)) : ?>
                                    <div class="tpprice-shape-three">
                                        <img src="<?php echo esc_url($tp_shape_image4); ?>"
                                            alt="<?php echo esc_attr($tp_shape_image_alt4); ?>">
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div id="hourly" class="wrapper-full hide">
                            <div class="tpprice pl-40">

                                <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content($settings['template2'], true); ?>

                                <div class="tpprice-shape d-none d-lg-block">
                                    <?php if(!empty($tp_shape_image3)) : ?>
                                    <div class="tpprice-shape-two">
                                        <img src="<?php echo esc_url($tp_shape_image3); ?>"
                                            alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
                                    </div>
                                    <?php endif; ?>
                                    <?php if(!empty($tp_shape_image4)) : ?>
                                    <div class="tpprice-shape-three">
                                        <img src="<?php echo esc_url($tp_shape_image4); ?>"
                                            alt="<?php echo esc_attr($tp_shape_image_alt4); ?>">
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif;
	}

}
$widgets_manager->register( new TP_Pricing_Tab() );