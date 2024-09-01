<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Repeater;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Box_Shadow;
use TPCore\Elementor\Controls\Group_Control_TPBGGradient;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Performance_Info extends Widget_Base {

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
		return 'performance-info';
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
		return __( 'Performance Info', 'tpcore' );
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

		// performance info
		$this->start_controls_section(
            'tp_performance_sec',
            [
                'label' => esc_html__('Performace Info', 'tpcore'),
            ]
		);
        
        $this->add_control(
            'tp_per_subtitle',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__( 'Performance Subtitle', 'tpcore' ),
                'default' => esc_html__( 'Subtitle', 'tpcore' ),
                'placeholder' => esc_html__( 'Type Subtitle Here', 'tpcore' ),
                'label_block' => true
            ]
        );
        
        $this->add_control(
            'tp_per_title',
            [
                'type' => Controls_Manager::TEXTAREA,
                'label' => esc_html__( 'Performance Title', 'tpcore' ),
                'default' => esc_html__( 'Performance Info Title', 'tpcore' ),
                'placeholder' => esc_html__( 'Type Title Here', 'tpcore' ),
                'label_block' => true
            ]
        );
        
        $this->add_control(
            'tp_per_des',
            [
                'type' => Controls_Manager::TEXTAREA,
                'label' => esc_html__( 'Performance Description', 'tpcore' ),
                'default' => esc_html__( 'So I said down the you owt to do with me absolutely bladdered, amongst what a plonker', 'tpcore' ),
                'placeholder' => esc_html__( 'Type Description Here', 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'tp_design_style' => 'layout-2'
                ]
            ]
        );

        // thumbnail
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

        // shape
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

        $this->add_control(
			'performance_bar_heading',
			[
				'label' => esc_html__( 'Performance Progress Bar', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
            'tp_box_icon_type',
            [
                'label' => esc_html__('Select Icon Type', 'tpcore'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'image' => esc_html__('Image', 'tpcore'),
                    'icon' => esc_html__('Icon', 'tpcore'),
                    'svg' => esc_html__('SVG', 'tpcore'),
                ],
            ]
        );

        $repeater->add_control(
            'tp_box_icon_svg',
            [
                'show_label' => false,
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__('SVG Code Here', 'tpcore'),
                'condition' => [
                    'tp_box_icon_type' => 'svg',
                ]
            ]
        );

        $repeater->add_control(
            'tp_box_icon_image',
            [
                'label' => esc_html__('Upload Icon Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_box_icon_type' => 'image',
                ]
            ]
        );

        if (tp_is_elementor_version('<', '2.6.0')) {
            $repeater->add_control(
                'tp_box_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-star',
                    'condition' => [
                        'tp_box_icon_type' => 'icon',
                    ]
                ]
            );
        } else {
            $repeater->add_control(
                'tp_box_selected_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'solid',
                    ],
                    'condition' => [
                        'tp_box_icon_type' => 'icon',
                    ]
                ]
            );
        }

        $repeater->add_control(
            'tp_performance_box_title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__( 'Skill Title', 'tpcore' ),
                'default' => esc_html__( 'Design', 'tpcore' ),
                'placeholder' => esc_html__( 'Type a performance name', 'tpcore' ),
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'tp_performance_num',
            [
                'label'       => esc_html__( 'Skill Number', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '85', 'tpcore' ),
                'placeholder' => esc_html__( 'Your Number', 'tpcore' ),
            ]
        );

        $this->add_control(
            'tp_performance_list',
            [
                'label' => esc_html__('Progress Bar - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_performance_box_title' => esc_html__('Design', 'tpcore'),
                        'tp_performance_num' => '70',
                    ],
                    [
                        'tp_performance_box_title' => esc_html__('Development', 'tpcore'),
                        'tp_performance_num' => '80',
                    ],
                ],
                'title_field' => '{{{ tp_performance_box_title }}}',
            ]
        );

		$this->end_controls_section();

        // about info
		$this->start_controls_section(
            'tp_about_sec',
            [
                'label' => esc_html__('About Info', 'tpcore'),
                'condition' => [
                    'tp_design_style' => 'layout-1'
                ]
            ]
        );
        
        $this->add_control(
            'tp_about_subtitle',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__( 'About Subtitle', 'tpcore' ),
                'default' => esc_html__( 'Subtitle', 'tpcore' ),
                'placeholder' => esc_html__( 'Type Subtitle Here', 'tpcore' ),
                'label_block' => true
            ]
        );
        
        $this->add_control(
            'tp_about_title',
            [
                'type' => Controls_Manager::TEXTAREA,
                'label' => esc_html__( 'About Title', 'tpcore' ),
                'default' => esc_html__( 'About Info Title', 'tpcore' ),
                'placeholder' => esc_html__( 'Type Title Here', 'tpcore' ),
                'label_block' => true
            ]
        );
        
        $this->add_control(
            'tp_about_des',
            [
                'type' => Controls_Manager::TEXTAREA,
                'label' => esc_html__( 'Description', 'tpcore' ),
                'default' => esc_html__( 'Hundreds of reviews from our customers say so. Our in-house support team is friendly & professional', 'tpcore' ),
                'placeholder' => esc_html__( 'Type Description Here', 'tpcore' ),
                'label_block' => true
            ]
        );

        // thumbnail
        $this->add_control(
            'tp_image3',
            [
                'label' => esc_html__( 'Choose Image 3', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tp_image_size2',
                'default' => 'full',
                'exclude' => [
                    'custom'
                ]
            ]
        );

        // shape
        $this->add_control(
        'tp_shape_switch2',
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
            'tp_shape_image_3',
            [
                'label' => esc_html__( 'Choose Shape Image 3', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch2' => 'yes'
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
                    'tp_shape_switch2' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_5',
            [
                'label' => esc_html__( 'Choose Shape Image 5', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch2' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_6',
            [
                'label' => esc_html__( 'Choose Shape Image 6', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch2' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'shape_image_size2', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                'condition' => [
                    'tp_shape_switch' => 'yes'
                ]
            ]
        );

		$this->end_controls_section();

        $this->tp_button_render('about', 'About Button', ['layout-1', 'layout-2']);  
        

	}

    protected function style_tab_content(){
        $this->tp_section_style_controls('performance_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('per_subtitle', 'Performance - Subtitle', '.tp-el-per-subtitle', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('per_title', 'Performance - Title', '.tp-el-per-title', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('per_des', 'Performance - Description', '.tp-el-per-des', 'layout-2');
        $this->tp_icon_style('per_progress_icon', 'Performance Progress Icon/Image/SVG', '.tp-el-per-pro-icon', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('per_progress_title', 'Performance Progress Title', '.tp-el-per-pro-title', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_progressbar_style_controls('per_progress_bg', 'Performance Progress Background', '.tp-el-per-pro-bg', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('about_subtitle', 'About - Subtitle', '.tp-el-about-subtitle', 'layout-1');
        $this->tp_basic_style_controls('about_title', 'About - Title', '.tp-el-about-title', 'layout-1');
        $this->tp_basic_style_controls('about_des', 'About - Description', '.tp-el-about-des', 'layout-1');
        $this->tp_link_controls_style('about_btn', 'About Button', '.tp-el-about-btn', ['layout-1', 'layout-2']);
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
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image_2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt_2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image2']['url']) ) {
        $tp_image2 = !empty($settings['tp_image2']['id']) ? wp_get_attachment_image_url( $settings['tp_image2']['id'], $settings['tp_image_size_size']) : $settings['tp_image2']['url'];
        $tp_image_alt2 = get_post_meta($settings["tp_image2"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'section-title-4 section-title-4-2');    

    // Link
    if ('2' == $settings['tp_about_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_about_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'blue-btn tp-el-about-btn');
    } else {
        if ( ! empty( $settings['tp_about_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_about_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'blue-btn tp-el-about-btn');
        }
    } 
?>

<section class="optimize-area optimize-wrapper pb-140 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="optimize-wrapperp pt-35">
                    <div class="section-wrapper mb-40">

                        <?php if(!empty($settings['tp_per_subtitle'])) : ?>
                        <span class="tp-el-per-subtitle"><?php echo tp_kses($settings['tp_per_subtitle']); ?></span>
                        <?php endif; ?>
                        <?php if(!empty($settings['tp_per_title'])) : ?>
                        <h5 class="section-title-4 section-title-4-2 tp-el-per-title"><?php echo tp_kses($settings['tp_per_title']); ?>
                        </h5>
                        <?php endif; ?>
                        <?php if(!empty($settings['tp_per_title'])) : ?>
                        <p class="tp-el-per-des"><?php echo tp_kses($settings['tp_per_des']); ?></p>
                        <?php endif; ?>

                    </div>
                    <div class="tpdrive-progress mb-25 pr-150">
                        <?php foreach ( $settings['tp_performance_list'] as $key => $item ) : 
                            $color;
                            if($item['tp_performance_num'] < '40'){
                                $color = 'red-bar';
                            } elseif($item['tp_performance_num'] < '70'){
                                $color = 'yellow-bar';
                            } else{
                                $color = '';
                            }
                        ?>
                        <div class="tpdrive-bar-item mb-30 <?php echo esc_attr($color); ?>">
                            <h4 class="tpdrive-bar-title mb-15 tp-el-per-pro-title">
                                <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                <span class="tp-el-per-pro-icon">
                                    <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                </span>
                                <?php endif; ?>
                                <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                <span class="tp-el-per-pro-icon">
                                    <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                        alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                </span>
                                <?php endif; ?>
                                <?php else : ?>
                                <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                <span class="tp-el-per-pro-icon">
                                    <?php echo $item['tp_box_icon_svg']; ?>
                                </span>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php echo $item['tp_performance_box_title'] ? tp_kses($item['tp_performance_box_title']) : NULL; ?>
                            </h4>
                            <div class="tpdrive-bar-progress">
                                <div class="progress">
                                    <div class="progress-bar tp-el-per-pro-bg wow slideInLeft" data-wow-delay=".1s"
                                        data-wow-duration="1.3s" role="progressbar"
                                        data-width="<?php echo esc_attr($item['tp_performance_num']); ?>%"
                                        aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"
                                        style="width: <?php echo esc_attr($item['tp_performance_num']); ?>%;">
                                        <span><?php echo tp_kses($item['tp_performance_num']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ( !empty($settings['tp_about_btn_text']) ) : ?>
                    <div class="optimize-btn">
                        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_about_btn_text']); ?></a>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="optimize-thumb text-end p-relative pt-35">
                    <?php if(!empty($tp_image2)) : ?>
                    <div class="optimize-thumb-img">
                        <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="optimize-shape">
                        <?php if(!empty($tp_image)) : ?>
                        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>"
                            class="optimize-shape-1">
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image)) : ?>
                        <img src="<?php echo esc_url($tp_shape_image); ?>"
                            alt="<?php echo esc_attr($tp_shape_image_alt); ?>"
                            class="optimize-shape-2 d-none d-md-block" data-parallax='{"y": 50, "smoothness": 20}'>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image_2)) : ?>
                        <img src="<?php echo esc_url($tp_shape_image_2); ?>"
                            alt="<?php echo esc_attr($tp_shape_image_alt_2); ?>"
                            class="optimize-shape-3 d-none d-md-block" data-parallax='{"y": 50, "smoothness": 20}'>
                        <?php endif; ?>
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
        $tp_shape_image_2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt_2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image2']['url']) ) {
        $tp_image2 = !empty($settings['tp_image2']['id']) ? wp_get_attachment_image_url( $settings['tp_image2']['id'], $settings['tp_image_size_size']) : $settings['tp_image2']['url'];
        $tp_image_alt2 = get_post_meta($settings["tp_image2"]["id"], "_wp_attachment_image_alt", true);
    } 
?>

<section class="optimize-area optimize-bottom pb-100 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="optimize-thumb p-relative pt-35">
                    <?php if(!empty($tp_image)) : ?>
                    <div class="optimize-thumb-img">
                        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="optimize-shape">
                        <?php if(!empty($tp_image2)) : ?>
                        <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>"
                            class="optimize-shape-4">
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image)) : ?>
                        <img src="<?php echo esc_url($tp_shape_image); ?>"
                            alt="<?php echo esc_attr($tp_shape_image_alt); ?>"
                            class="optimize-shape-5 d-none d-lg-block">
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image_2)) : ?>
                        <img src="<?php echo esc_url($tp_shape_image_2); ?>"
                            alt="<?php echo esc_attr($tp_shape_image_alt_2); ?>"
                            class="optimize-shape-6 d-none d-md-block">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="offset-lg-1 col-lg-6">
                <div class="optimize-wrapper optimize-seo pt-35">
                    <div class="optimize-subtitle mb-50">

                        <?php if(!empty($settings['tp_per_subtitle'])) : ?>
                        <span class="tp-el-per-subtitle"><?php echo tp_kses($settings['tp_per_subtitle']); ?></span>
                        <?php endif; ?>
                        <?php if(!empty($settings['tp_per_title'])) : ?>
                        <h5 class="section-title-4 fs-40 tp-el-per-title"><?php echo tp_kses($settings['tp_per_title']); ?></h5>
                        <?php endif; ?>

                    </div>
                    <div class="tpdrive-progress mb-25 pr-150">

                        <?php foreach ( $settings['tp_performance_list'] as $key => $item ) : 
                            $color;
                            if($item['tp_performance_num'] <= '40'){
                                $color = 'purple-bar';
                            } elseif($item['tp_performance_num'] <= '70'){
                                $color = 'yellow-bar';
                            } else{
                                $color = '';
                            }
                        ?>
                        <div class="tpdrive-bar-item mb-25 <?php echo esc_attr($color); ?>">
                            <h4 class="tpdrive-bar-title mb-15 tp-el-per-pro-title">
                                <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                <span class="tp-el-per-pro-icon">
                                    <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                </span>
                                <?php endif; ?>
                                <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                <span class="tp-el-per-pro-icon">
                                    <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                        alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                </span>
                                <?php endif; ?>
                                <?php else : ?>
                                <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                <span class="tp-el-per-pro-icon">
                                    <?php echo $item['tp_box_icon_svg']; ?>
                                </span>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php echo $item['tp_performance_box_title'] ? tp_kses($item['tp_performance_box_title']) : NULL; ?>
                            </h4>
                            <div class="tpdrive-bar-progress">
                                <div class="progress">
                                    <div class="progress-bar wow slideInLeft tp-el-per-pro-bg" data-wow-delay="0s"
                                        data-wow-duration=".8s" role="progressbar"
                                        data-width="<?php echo esc_attr($item['tp_performance_num']); ?>%"
                                        aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                        <span><?php echo tp_kses($item['tp_performance_num']); ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else:
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image_2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt_2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_3']['url']) ) {
        $tp_shape_image_3 = !empty($settings['tp_shape_image_3']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_3']['id'], $settings['shape_image_size2_size']) : $settings['tp_shape_image_3']['url'];
        $tp_shape_image_alt_3 = get_post_meta($settings["tp_shape_image_3"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_4']['url']) ) {
        $tp_shape_image_4 = !empty($settings['tp_shape_image_4']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_4']['id'], $settings['shape_image_size2_size']) : $settings['tp_shape_image_4']['url'];
        $tp_shape_image_alt_4 = get_post_meta($settings["tp_shape_image_4"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_5']['url']) ) {
        $tp_shape_image_5 = !empty($settings['tp_shape_image_5']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_5']['id'], $settings['shape_image_size2_size']) : $settings['tp_shape_image_5']['url'];
        $tp_shape_image_alt_5 = get_post_meta($settings["tp_shape_image_5"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_6']['url']) ) {
        $tp_shape_image_6 = !empty($settings['tp_shape_image_6']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_6']['id'], $settings['shape_image_size2_size']) : $settings['tp_shape_image_6']['url'];
        $tp_shape_image_alt_6 = get_post_meta($settings["tp_shape_image_6"]["id"], "_wp_attachment_image_alt", true);
    }

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image2']['url']) ) {
        $tp_image2 = !empty($settings['tp_image2']['id']) ? wp_get_attachment_image_url( $settings['tp_image2']['id'], $settings['tp_image_size_size']) : $settings['tp_image2']['url'];
        $tp_image_alt2 = get_post_meta($settings["tp_image2"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image3']['url']) ) {
        $tp_image3 = !empty($settings['tp_image3']['id']) ? wp_get_attachment_image_url( $settings['tp_image3']['id'], $settings['tp_image_size2_size']) : $settings['tp_image3']['url'];
        $tp_image_alt3 = get_post_meta($settings["tp_image3"]["id"], "_wp_attachment_image_alt", true);
    }

    // Link
    if ('2' == $settings['tp_about_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_about_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'green-btn tp-el-about-btn');
    } else {
        if ( ! empty( $settings['tp_about_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_about_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'green-btn tp-el-about-btn');
        }
    } 

?>

<div class="container tp-el-section">
    <div class="tp-drive-shape p-relative">
        <div class="row drive-section-bottom mb-200">
            <div class="col-lg-6">
                <div class="tpdrive-thumb p-relative ml-100 ">
                    <?php if(!empty($tp_image)) : ?>
                    <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                    <?php endif; ?>
                    <div class="tpdrive-thumb-shape">
                        <?php if(!empty($tp_shape_image)) : ?>
                        <div class="tpdrive-thumb-shape-five">
                            <img src="<?php echo esc_url($tp_shape_image); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image_2)) : ?>
                        <div class="tpdrive-thumb-shape-six">
                            <img src="<?php echo esc_url($tp_shape_image_2); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt_2); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_image2)) :  ?>
                        <div class="tpdrive-thumb-shape-seven">
                            <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tpdrive-wrapper mt-10 ml-55 mr-95">
                    <div class="tpdrive-content">
                        <?php if(!empty($settings['tp_per_subtitle'])) : ?>
                        <span class="tp-el-per-subtitle"><?php echo tp_kses($settings['tp_per_subtitle']); ?></span>
                        <?php endif; ?>
                        <?php if(!empty($settings['tp_per_title'])) : ?>
                        <h5 class="tpdrive-title mb-20 tp-el-per-title"><?php echo tp_kses($settings['tp_per_title']); ?></h5>
                        <?php endif; ?>
                    </div>
                    <div class="tpdrive-progress">

                        <?php foreach ( $settings['tp_performance_list'] as $key => $item ) : 
                        $color;
                        if($item['tp_performance_num'] <= '40'){
                            $color = 'red-bar';
                        } elseif($item['tp_performance_num'] <='70'){
                            $color = 'yellow-bar';
                        } else{
                            $color = '';
                        }
                    ?>
                        <div class="tpdrive-bar-item mb-30 <?php echo esc_attr($color); ?>">
                            <h4 class="tpdrive-bar-title mb-15 tp-el-per-pro-title">
                                <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                <span class="tp-el-per-pro-icon">
                                    <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                </span>
                                <?php endif; ?>
                                <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                <span class="tp-el-per-pro-icon">
                                    <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                        alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                </span>
                                <?php endif; ?>
                                <?php else : ?>
                                <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                <span class="tp-el-per-pro-icon">
                                    <?php echo $item['tp_box_icon_svg']; ?>
                                </span>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php echo $item['tp_performance_box_title'] ? tp_kses($item['tp_performance_box_title']) : NULL; ?>
                            </h4>
                            <div class="tpdrive-bar-progress">
                                <div class="progress">
                                    <div class="progress-bar tp-el-per-pro-bg wow slideInLeft" data-wow-delay=".1s"
                                        data-wow-duration="1.3s" role="progressbar"
                                        data-width="<?php echo esc_attr($item['tp_performance_num']); ?>%"
                                        aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"
                                        style="width: <?php echo esc_attr($item['tp_performance_num']); ?>%;">
                                        <span><?php echo tp_kses($item['tp_performance_num']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="drive-big-shape d-none d-lg-block">
            <svg width="1172" height="600" viewBox="0 0 1172 600" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="line-dash-path"
                    d="M1 0V280.251C1 291.296 9.95431 300.251 21 300.251H1151C1162.05 300.251 1171 309.205 1171 320.251V600"
                    stroke="#BDC1C6" stroke-dasharray="5 5" />
            </svg>
            <div class="drive-shape">
                <div class="drive-big-shape-one wow bounceIn" data-wow-delay=".5s" data-wow-duration=".3s">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/side-line-1.png" alt="">
                </div>
                <div class="drive-big-shape-two wow bounceIn" data-wow-duration=".5s" data-wow-delay=".3s">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/side-line-2.png" alt="">
                </div>
                <div class="drive-big-shape-three wow bounceIn" data-wow-duration=".5s" data-wow-delay=".3s">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/side-line-3.png" alt="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="tpdrive-wrapper ml-100">
                    <div class="tpdrive-content">
                        <?php if(!empty($settings['tp_about_subtitle'])) : ?>
                        <span class="tp-el-about-subtitle"><?php echo tp_kses($settings['tp_about_subtitle']); ?></span>
                        <?php endif; ?>
                        <?php if(!empty($settings['tp_about_title'])) : ?>
                        <h5 class="tpdrive-title mb-15 tp-el-about-title"><?php echo tp_kses($settings['tp_about_title']); ?></h5>
                        <?php endif; ?>
                        <?php if(!empty($settings['tp_about_des'])) : ?>
                        <p class="tp-el-about-des"><?php echo tp_kses($settings['tp_about_des']); ?></p>
                        <?php endif; ?>

                        <?php if ( !empty($settings['tp_about_btn_text']) ) : ?>
                        <div class="tpdrive-content-btn">
                            <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_about_btn_text']); ?></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tpdrive-thumb p-relative">
                    <?php if(!empty($tp_image3)) : ?>
                    <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image_alt3); ?>">
                    <?php endif; ?>
                    <div class="tpdrive-thumb-shape">
                        <?php if(!empty($tp_shape_image_3)) : ?>
                        <div class="tpdrive-thumb-shape-one">
                            <img src="<?php echo esc_url($tp_shape_image_3); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt_3); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image_4)) : ?>
                        <div class="tpdrive-thumb-shape-two">
                            <img src="<?php echo esc_url($tp_shape_image_4); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt_4); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image_5)) : ?>
                        <div class="tpdrive-thumb-shape-three">
                            <img src="<?php echo esc_url($tp_shape_image_5); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt_5); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image_6)) : ?>
                        <div class="tpdrive-thumb-shape-four">
                            <img src="<?php echo esc_url($tp_shape_image_6); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt_6); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php endif; 
	}

}

$widgets_manager->register( new TP_Performance_Info() );