<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use TPCore\Elementor\Controls\Group_Control_TPBGGradient;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Main_Brand extends Widget_Base {

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
		return 'tp-brand';
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
		return __( 'Brand', 'tpcore' );
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
                    'layout-4' => esc_html__('Layout 4', 'tpcore'),
                    'layout-5' => esc_html__('Layout 5', 'tpcore'),
                    'layout-6' => esc_html__('Layout 6', 'tpcore'),
                    'layout-7' => esc_html__('Layout 7', 'tpcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        
        // tp_section_title
        $this->tp_section_title_render_controls('brand', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', 'layout-1');


        // brand section
		$this->start_controls_section(
            'tp_brand_section',
            [
                'label' => __( 'Brand Item', 'tpcore' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'tp_brand4_title', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Brand Title', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'tp_design_style' => ['layout-4', 'layout-5', 'layout-7']
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'repeater_condition',
            [
                'label' => __( 'Field condition', 'tpcore' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style_1' => __( 'Style 1', 'tpcore' ),
                    'style_2' => __( 'Style 2', 'tpcore' ),
                    'style_3' => __( 'Style 3', 'tpcore' ),
                    'style_4' => __( 'Style 4', 'tpcore' ),
                    'style_5' => __( 'Style 5', 'tpcore' ),
                    'style_6' => __( 'Style 6', 'tpcore' ),
                    'style_7' => __( 'Style 7', 'tpcore' ),
                ],
                'default' => 'style_1',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $repeater->add_control(
            'tp_brand_image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => __( 'Image', 'tpcore' ),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );      
        
        
        // creative animation
        $repeater->add_control(
			'tp_creative_anima_switcher',
			[
				'label' => esc_html__( 'Active Animation', 'tpcore' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'tpcore' ),
				'label_off' => esc_html__( 'No', 'tpcore' ),
				'return_value' => 'yes',
				'default' => '0',
                'separator' => 'before',
                'condition' => [
                    'repeater_condition' => 'style_1'
                ]
			]
		);

        $repeater->add_control(
            'tp_anima_type',
            [
                'label' => __( 'Animation Type', 'tpcore' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'bounceIn' => __( 'bounceIn', 'tpcore' ),
                    'bounceOut' => __( 'bounceOut', 'tpcore' ),
                ],
                'default' => 'bounceIn',
                'frontend_available' => true,
                'style_transfer' => true,
                'condition' => [
                    'tp_creative_anima_switcher' => 'yes',
                    'repeater_condition' => 'style_1'
                ],
            ]
        );
        
        $repeater->add_control(
            'tp_anima_dura', [
                'label' => esc_html__('Animation Duration', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('0.3s', 'tpcore'),
                'condition' => [
                    'tp_creative_anima_switcher' => 'yes',
                    'repeater_condition' => 'style_1'
                ],
            ]
        );
        
        $repeater->add_control(
            'tp_anima_delay', [
                'label' => esc_html__('Animation Delay', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('0.6s', 'tpcore'),
                'condition' => [
                    'tp_creative_anima_switcher' => 'yes',
                    'repeater_condition' => 'style_1'
                ],
            ]
        );

        $this->add_control(
            'tp_brand_slides',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => esc_html__( 'Brand Item', 'tpcore' ),
                'default' => [
                    [
                        'tp_brand_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'tp_brand_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ]
            ]
        );
        
        $this->add_control(
        'bread_scroll_title',
            [
                'label'   => esc_html__( 'Scroll Title', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Scroll down', 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'tp_design_style' => 'layout-6'
                ]
            ]
        );
        
        $this->add_control(
        'bread_scroll_id',
            [
                'label'   => esc_html__( 'Scroll ID', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '#ID', 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'tp_design_style' => 'layout-6'
                ]
            ]
        );
    

        $this->end_controls_section();

        // shape
        $this->start_controls_section(
        'tp_shape',
            [
                'label' => esc_html__( 'Shape Section', 'tpcore' ),
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-2']
                ]
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
                    'tp_shape_switch' => 'yes'
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
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'shape_image_size', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                'condition' => [
                    'tp_shape_switch' => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();

        
        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
                'condition' => [
                    'tp_design_style' => 'layout-2'
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

        $this->add_control(
            'tp_image2',
            [
                'label' => esc_html__( 'Choose Image 2', 'tp-core' ),
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

	}


    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('brand_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', 'layout-1');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-4', 'layout-5', 'layout-7']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', 'layout-1');
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

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image2']['url']) ) {
        $tp_image2 = !empty($settings['tp_image2']['id']) ? wp_get_attachment_image_url( $settings['tp_image2']['id'], $settings['tp_image_size_size']) : $settings['tp_image2']['url'];
        $tp_image_alt2 = get_post_meta($settings["tp_image2"]["id"], "_wp_attachment_image_alt", true);
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
    
?>

<div class="brand-area pb-30 pt-85 tp-el-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-10 col-xl-8 col-lg-10">
                <div class="tpbrand tpbrand-active">
                    <?php foreach ($settings['tp_brand_slides'] as $key => $item) : 
                        if ( !empty($item['tp_brand_image']['url']) ) {
                            $tp_brand_image_url = !empty($item['tp_brand_image']['id']) ? wp_get_attachment_image_url( $item['tp_brand_image']['id'], $settings['thumbnail_size']) : $item['tp_brand_image']['url'];
                            $tp_brand_image_alt = get_post_meta($item["tp_brand_image"]["id"], "_wp_attachment_image_alt", true);
                        }
                    ?>
                    <div class="tpbrand-item">
                        <img src="<?php echo esc_url($tp_brand_image_url); ?>"
                            alt="<?php echo esc_attr($tp_brand_image_alt); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-area pt-100 footer-bg2 p-relative">
    <?php if(!empty($settings['tp_shape_switch'])) : ?>
    <div class="footer-main-shape">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner/footer-2-bg-2.png" alt="">
    </div>
    <?php endif; ?>
    <div class="footer-shape-left d-none d-xl-block">
        <?php if(!empty($settings['tp_shape_switch'])) : ?>
        <div class="footer-shape-left-one">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-dew-shape.png"
                alt="footer-shape">
        </div>
        <div class="footer-shape-left-two">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-dot-1.png" alt="footer-shape">
        </div>
        <?php endif; ?>
        <?php if(!empty($tp_shape_image)) : ?>
        <div class="footer-shape-left-three">
            <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
        <?php endif; ?>
        <?php if(!empty($tp_image)) : ?>
        <div class="footer-shape-left-four">
            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
        </div>
        <?php endif; ?>
    </div>
    <div class="footer-shape-right d-none d-xl-block">
        <?php if(!empty($tp_image2)) : ?>
        <div class="footer-shape-right-one">
            <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
        </div>
        <?php endif; ?>
        <?php if(!empty($settings['tp_shape_switch'])) : ?>
        <div class="footer-shape-right-two">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-dot-1.png" alt="footer-shape">
        </div>
        <div class="footer-shape-right-three">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-plant.png" alt="footer-shape">
        </div>
        <?php endif; ?>
        <?php if(!empty($tp_shape_image2)) : ?>
        <div class="footer-shape-right-four">
            <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
        </div>
        <?php endif; ?>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : ?>

<div class="brand-area theme-bg-4 pb-120 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <div class="tpbrand tpbrand-active-2">

                    <?php foreach ($settings['tp_brand_slides'] as $key => $item) : 
                        if ( !empty($item['tp_brand_image']['url']) ) {
                            $tp_brand_image_url = !empty($item['tp_brand_image']['id']) ? wp_get_attachment_image_url( $item['tp_brand_image']['id'], $settings['thumbnail_size']) : $item['tp_brand_image']['url'];
                            $tp_brand_image_alt = get_post_meta($item["tp_brand_image"]["id"], "_wp_attachment_image_alt", true);
                        }
                    ?>
                    <div class="tpbrand-item-2">
                        <img src="<?php echo esc_url($tp_brand_image_url); ?>"
                            alt="<?php echo esc_attr($tp_brand_image_alt); ?>">
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-4' ) : ?>

<section class="brand-area brand-bg-3 mb-120 p-relative tp-el-section">
    <div class="brand-bg-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="brand-wrapper text-center">
                        <?php if(!empty($settings['tp_brand4_title'])) : ?>
                        <h5 class="title tp-el-title"><?php echo tp_kses($settings['tp_brand4_title']); ?></h5>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tpbrand tpbrand-active-4 mb-170">

                        <?php foreach ($settings['tp_brand_slides'] as $key => $item) : 
                            if ( !empty($item['tp_brand_image']['url']) ) {
                                $tp_brand_image_url = !empty($item['tp_brand_image']['id']) ? wp_get_attachment_image_url( $item['tp_brand_image']['id'], $settings['thumbnail_size']) : $item['tp_brand_image']['url'];
                                $tp_brand_image_alt = get_post_meta($item["tp_brand_image"]["id"], "_wp_attachment_image_alt", true);
                            }
                        ?>
                        <div class="tpbrand-item-4 mb-35">
                            <img src="<?php echo esc_url($tp_brand_image_url); ?>"
                                alt="<?php echo esc_attr($tp_brand_image_alt); ?>">
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- wave-animation -->
    <div class="wave-bg">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="wave wave-1">
            <title>Wave</title>
            <defs></defs>
            <path id="feel-the-wave" d="M1920.000,58.998 L1920.000,164.998 L0.000,164.998 L0.000,119.999
         C0.000,119.999 145.549,49.265 313.203,40.999 C525.449,30.533 672.724,94.775
         866.895,101.761 C907.604,103.225 957.454,99.228 1007.943,88.724 C1145.929,60.014
         1219.971,11.807 1403.910,2.999 C1450.093,0.787 1504.925,-13.381 1775.283,66.829
         C1844.663,87.411 1920.000,58.998 1920.000,58.998 Z" />
        </svg>

        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="wave">
            <title>Wave</title>
            <path id="wave-two" d="M1093.910,5.685 C1317.402,-23.097 1421.263,80.301 1608.427,83.440
         C1723.626,85.372 1799.711,52.828 1853.587,26.599 C1879.056,14.199
         1920.000,11.439 1920.000,11.439 L1920.000,190.998 L0.000,190.998 L0.000,53.998
         C0.000,53.998 27.746,55.576 50.698,61.929 C140.266,86.724 355.925,147.932
         523.203,133.999 C648.841,123.533 727.916,98.315 790.555,81.220 C937.278,41.176
         974.256,21.095 1093.910,5.685 Z" />
        </svg>
    </div>
    <!-- wave-animation-end -->
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-5' ) : ?>

<div class="barnda-area pb-195 banner-brand tp-el-section">
    <div class="container">
        <?php if(!empty($settings['tp_brand4_title'])) : ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="brand-content mb-50 text-center">
                    <h4 class="brand-title tp-el-title"><?php echo tp_kses($settings['tp_brand4_title']); ?></h4>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="barnd-5 tpbrand-active-5">

                    <?php foreach ($settings['tp_brand_slides'] as $key => $item) : 
                        if ( !empty($item['tp_brand_image']['url']) ) {
                            $tp_brand_image_url = !empty($item['tp_brand_image']['id']) ? wp_get_attachment_image_url( $item['tp_brand_image']['id'], $settings['thumbnail_size']) : $item['tp_brand_image']['url'];
                            $tp_brand_image_alt = get_post_meta($item["tp_brand_image"]["id"], "_wp_attachment_image_alt", true);
                        }
                    ?>
                    <div class="brand-5-item">
                        <img src="<?php echo esc_url($tp_brand_image_url); ?>"
                            alt="<?php echo esc_attr($tp_brand_image_alt); ?>">
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-6' ) : ?>

<section class="brand-area tp-el-section">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-2 offset-lg-5 col-md-4">
                <?php if(!empty($settings['bread_scroll_title'])) : ?>
                <div class="brand-wrapper ">
                    <div class="brand-inner-content">
                        <h4 class="brand-inner-title"><?php echo tp_kses($settings['bread_scroll_title']); ?></h4>
                        <?php if(!empty($settings['bread_scroll_id'])) : ?>
                        <a href="<?php echo esc_attr($settings['bread_scroll_id']); ?>">
                            <i>
                                <svg width="20" height="30" viewBox="0 0 20 30" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.75" y="0.75" width="18.5" height="28.5" rx="9.25" stroke="white"
                                        stroke-width="1.5" />
                                    <rect x="7.75" y="6.75" width="4.5" height="4.5" rx="2.25" stroke="white"
                                        stroke-width="1.5" />
                                </svg>
                            </i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-5 col-md-8">
                <div class="brand-inner-wrapper tpbrand-inner-active">

                    <?php foreach ($settings['tp_brand_slides'] as $key => $item) : 
                        if ( !empty($item['tp_brand_image']['url']) ) {
                            $tp_brand_image_url = !empty($item['tp_brand_image']['id']) ? wp_get_attachment_image_url( $item['tp_brand_image']['id'], $settings['thumbnail_size']) : $item['tp_brand_image']['url'];
                            $tp_brand_image_alt = get_post_meta($item["tp_brand_image"]["id"], "_wp_attachment_image_alt", true);
                        }
                    ?>
                    <div class="tpbrand-inner-item">
                        <img src="<?php echo esc_url($tp_brand_image_url); ?>"
                            alt="<?php echo esc_attr($tp_brand_image_alt); ?>">
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-7' ) : ?>

<section class="brand-area mb-110 tp-el-section">
    <div class="container">
        <div class="trusted-brand-bg pb-65">
            <?php if(!empty($settings['tp_brand4_title'])) : ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="trusted-brand text-center mt-60 mb-30">
                        <h3 class="trusted-brand-title tp-el-title"><?php echo tp_kses($settings['tp_brand4_title']); ?></h3>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper-container trusted-brand-active">
                        <div class="swiper-wrapper">
                            <?php foreach ($settings['tp_brand_slides'] as $key => $item) : 
                                if ( !empty($item['tp_brand_image']['url']) ) {
                                    $tp_brand_image_url = !empty($item['tp_brand_image']['id']) ? wp_get_attachment_image_url( $item['tp_brand_image']['id'], $settings['thumbnail_size']) : $item['tp_brand_image']['url'];
                                    $tp_brand_image_alt = get_post_meta($item["tp_brand_image"]["id"], "_wp_attachment_image_alt", true);
                                }
                            ?>
                            <div class="swiper-slide">
                                <div class="trusted-brand-item">
                                    <img src="<?php echo esc_url($tp_brand_image_url); ?>" alt="<?php echo esc_attr($tp_brand_image_alt); ?>">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else : 
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }   

    $this->add_render_attribute('title_args', 'class', 'tpsection-title-two tp-el-title'); 
?>

<section class="award-area tp-large-box award-bg pt-110 p-relative fix tp-el-section">
    <div class="award-shape d-none d-xl-block">
        <?php if(!empty($tp_shape_image)) : ?>
        <div class="award-shape-one">
            <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
        <?php endif; ?>
        <?php if(!empty($tp_shape_image2)) : ?>
        <div class="award-shape-two">
            <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
        </div>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="tpsection-wrapper text-center pb-60">
                    <?php if ( !empty($settings['tp_brand_sub_title']) ) : ?>
                    <p class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_brand_sub_title'] ); ?></p>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_brand_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_brand_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_brand_title' ] )
                        );
                    endif;
                    ?>
                    <?php if ( !empty($settings['tp_brand_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_brand_description'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="award-brand">
            <div class="row gx-7 gx-md-2 row-cols-4 tp-row-cols-md-7  tp-row-cols-xl-7">
                <?php foreach ($settings['tp_brand_slides'] as $key => $item) : 
                    if ( !empty($item['tp_brand_image']['url']) ) {
                        $tp_brand_image_url = !empty($item['tp_brand_image']['id']) ? wp_get_attachment_image_url( $item['tp_brand_image']['id'], $settings['thumbnail_size']) : $item['tp_brand_image']['url'];
                        $tp_brand_image_alt = get_post_meta($item["tp_brand_image"]["id"], "_wp_attachment_image_alt", true);
                    }
                ?>
                <div class="col">
                    <div class="award-anim <?php echo $item['tp_anima_type'] ? 'wow ' . esc_attr($item['tp_anima_type']) : NULL ; ?>"
                        <?php echo $item['tp_anima_dura'] ? "data-wow-duration='" . esc_attr($item['tp_anima_dura']) . "'" : NULL ; ?>
                        <?php echo $item['tp_anima_dura'] ? "data-wow-delay='" . esc_attr($item['tp_anima_delay']) . "'" : NULL ; ?>>
                        <?php if(!empty($tp_brand_image_url)) : ?>
                        <div class="award-item award-item<?php echo esc_attr($key+1); ?>">
                            <img src="<?php echo esc_url($tp_brand_image_url); ?>"
                                alt="<?php echo esc_attr($tp_brand_image_alt); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php endif;  
	}
}

$widgets_manager->register( new TP_Main_Brand() );