<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Background;
use \Elementor\Control_Media;
use \Elementor\Repeater;
use \Elementor\Utils;
use TPCore\Elementor\Controls\Group_Control_TPBGGradient;
use TPCore\Elementor\Controls\Group_Control_TPGradient;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Hero_Banner extends Widget_Base {

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
		return 'hero-banner';
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
		return __( 'Hero Banner', 'tp-core' );
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
		return [ 'tp-core' ];
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
                'label' => esc_html__('Design Layout', 'tp-core'),
            ]
        );
        $this->add_control(
            'tp_design_style',
            [
                'label' => esc_html__('Select Layout', 'tp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'layout-1' => esc_html__('Layout 1', 'tp-core'),
                    'layout-2' => esc_html__('Layout 2', 'tp-core'),
                    'layout-3' => esc_html__('Layout 3', 'tp-core'),
                    'layout-4' => esc_html__('Layout 4', 'tp-core'),
                    'layout-5' => esc_html__('Layout 5', 'tp-core'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // tp_section_title
        $this->tp_section_title_render_controls('banner', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5']);

        $this->tp_button_render('banner', 'Button', ['layout-2', 'layout-4', 'layout-5']);  

        // Contact group
        $this->start_controls_section(
            '_TP_contact_info',
            [
                'label' => esc_html__('Contact List', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tp_design_style' => 'layout-4'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'repeater_condition',
            [
                'label' => __( 'Field condition', 'tpcore' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style_1' => __( 'Style 1', 'tpcore' ),
                ],
                'default' => 'style_1',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

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
                    'tp_box_icon_type' => 'svg'
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
                        'tp_box_icon_type' => 'icon'
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
                        'tp_box_icon_type' => 'icon'
                    ]
                ]
            );
        }

        $repeater->add_control(
            'tp_contact_info_subtitle',
            [
                'label' => esc_html__('Sub Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Subtitle Here',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_contact_info_title',
            [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Title Here',
                'label_block' => true,
            ]
        );  

        $repeater->add_control(
            'link_type',
            [
                'label' => __( 'Link Type', 'tpcore' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'None', 'tpcore' ),
                    'url' => __( 'URL', 'tpcore' ),
                    'tell' => __( 'Phone Number', 'tpcore' ),
                    'email' => __( 'Email', 'tpcore' ),
                ],
                'default' => '',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        // url
        $repeater->add_control(
            'tp_contact_url',
            [
                'label' => esc_html__('URL', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '#',
                'label_block' => true,
                'condition' => [
                    'link_type' => 'url'
                ]
            ]
        );  

        // tell
        $repeater->add_control(
            'tp_contact_tell',
            [
                'label' => esc_html__('Phone Number', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '012345',
                'label_block' => true,
                'condition' => [
                    'link_type' => 'tell'
                ]
            ]
        );  

        // email
        $repeater->add_control(
            'tp_contact_email',
            [
                'label' => esc_html__('Email Address', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('softec@gmail.com', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'link_type' => 'email'
                ]
            ]
        );  

        $this->add_control(
            'tp_contact_list',
            [
                'label' => esc_html__('Contact - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_contact_info_subtitle' => esc_html__('Got Question?', 'tpcore'),
                        'tp_contact_info_title' => esc_html__('+01089173947', 'tpcore'),
                    ],
                ],
                'title_field' => '{{{ tp_contact_info_title }}}',
            ]
        );
        $this->end_controls_section();
        
        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-2', 'layout-4', 'layout-5']
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
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-5']
                ]
            ]
        );

        $this->add_control(
            'tp_image3',
            [
                'label' => esc_html__( 'Choose Image 3', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-5']
                ]
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
                    'tp_design_style' => ['layout-1', 'layout-2', 'layout-5']
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
                    'tp_design_style' => ['layout-1', 'layout-2', 'layout-5']
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
                    'tp_design_style' => 'layout-5'
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
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => 'layout-5'
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
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => 'layout-5'
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
        
        $this->add_control(
        'bottom_text',
            [
                'label'   => esc_html__( 'Bottom Text', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Excellent Trustpilot', 'tpcore' ),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'label_block' => true,
                'condition' => [
                    'tp_design_style' => ['layout-2', 'layout-3', 'layout-5']
                ]
            ]
        );
        
        $this->end_controls_section();

        // subscriber form
        $this->start_controls_section(
            'tp_subs_sec',
            [
                'label' => esc_html__('Subscriber Section', 'tp-core'),
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-3']
                ]
            ]
        );
        
        $this->add_control(
        'form_shortcode',
            [
            'label'   => esc_html__( 'Newsletter Shortcode', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( '[enter shortcode here]', 'tpcore' ),
            'label_block' => true,
            ]
        );

        $this->end_controls_section();

	}

    // style_tab_content
    protected function style_tab_content(){

        $this->tp_section_style_controls('banner_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content');
        $this->tp_link_controls_style('section_btn', 'Button', '.tp-el-btn', ['layout-2', 'layout-4', 'layout-5']);
        $this->tp_basic_style_controls('section_bottom_text', 'Section - Bottom Text', '.tp-el-bottom-text', ['layout-2', 'layout-3', 'layout-5']);
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', 'layout-4');
        $this->tp_basic_style_controls('rep_subtitle_style', 'Repeater Subtitle', '.tp-el-rep-subtitle', 'layout-4');
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', 'layout-4');
        
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
    
    // Link
    if ('2' == $settings['tp_banner_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_banner_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'green-btn tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_banner_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_banner_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'green-btn tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'tpbanner-title-two mb-20 tp-el-title');
?>

<div class="banner-area tpbanner-space-two ele-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-7 order-2 order-md-1">
                <div class="tpbanner-content-two">
                    <?php if ( !empty($settings['tp_banner_sub_title']) ) : ?>
                    <div class="tpbanner__sub-title mb-15">
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_banner_sub_title']); ?></span>
                        <i>
                            <svg width="110" height="35" viewBox="0 0 110 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="110" height="34.1" fill="url(#pattern)" fill-opacity="0.08" />
                                <defs>
                                    <pattern id="pattern" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_831_2448"
                                            transform="translate(-0.06) scale(0.00611111 0.0197133)" />
                                    </pattern>
                                    <image id="image0_831_2448" width="180" height="50"
                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==" />
                                </defs>
                            </svg>
                        </i>
                    </div>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_banner_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_banner_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_banner_title' ] )
                        );
                    endif;
                    ?>
                    <?php if ( !empty($settings['tp_banner_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_banner_description'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( !empty($settings['tp_banner_btn_text']) ) : ?>
                    <div class="tpbanner-two-btn mb-35">
                        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_banner_btn_text']); ?></a>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($settings['bottom_text'])) : ?>
                    <div class="tpbanner-two-rating tp-el-bottom-text">
                        <?php echo tp_kses($settings['bottom_text']); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 order-1 order-md-2">
                <div class="tpbanner-two-shape p-relative" data-parallax='{"x": 15, "smoothness": 10}'>
                    <?php if(!empty($tp_image)) : ?>
                    <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                    <?php endif; ?>
                    <div class="tpbanner-two-shape-round">
                        <?php if(!empty($tp_shape_image)) : ?>
                        <div class="tpbanner-two-shape-one">
                            <img src="<?php echo esc_url($tp_shape_image); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image2)) : ?>
                        <div class="tpbanner-two-shape-two">
                            <img src="<?php echo esc_url($tp_shape_image2); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($tp_shape_image3)) : ?>
                    <div class="tpbanner-two-shape-three">
                        <img src="<?php echo esc_url($tp_shape_image3); ?>"
                            alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : 
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'tpbanner-three-title mb-20 tp-el-title');    
?>

<div class="banner-area banner-three p-relative theme-bg-4 ele-section">
    <div class="container">
        <?php if(!empty($tp_shape_image)) : ?>
        <div class="banner-three-shape">
            <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="tpbanner-three text-center">

                    <?php if ( !empty($settings['tp_banner_sub_title']) ) : ?>
                    <div class="tpbanner__sub-title mb-15">
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_banner_sub_title']); ?></span>
                        <i>
                            <svg width="110" height="35" viewBox="0 0 110 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="110" height="34.1" fill="url(#pattern)" fill-opacity="0.08" />
                                <defs>
                                    <pattern id="pattern" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_831_2448"
                                            transform="translate(-0.06) scale(0.00611111 0.0197133)" />
                                    </pattern>
                                    <image id="image0_831_2448" width="180" height="50"
                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==" />
                                </defs>
                            </svg>
                        </i>
                    </div>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_banner_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_banner_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_banner_title' ] )
                        );
                    endif;
                    ?>
                    <?php if ( !empty($settings['tp_banner_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_banner_description'] ); ?></p>
                    <?php endif; ?>
                    <div class="tpbanner-analysis-3 d-flex align-items-center justify-content-center mb-15">
                        <?php if( !empty($settings['form_shortcode']) ) : ?>
                        <?php echo do_shortcode( $settings['form_shortcode'] ); ?>
                        <?php else : ?>
                        <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($settings['bottom_text'])) : ?>
                    <div class="tpbanner-payment tp-el-bottom-text">
                        <?php echo tp_kses($settings['bottom_text']); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php elseif ( $settings['tp_design_style']  == 'layout-4' ) : 
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
    
    // Link
    if ('2' == $settings['tp_banner_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_banner_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'blue-btn tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_banner_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_banner_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'blue-btn tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'banner-4-title cd-headline clip is-full-width tp-el-title');    
?>

<div class="banner-area banner-4-spaces pt-150 pb-195 ele-section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-7 col-xl-10 col-lg-7">
                <div class="banner-4">
                    <div class="banner-4-content">
                        <?php if ( !empty($settings['tp_banner_sub_title']) ) : ?>
                        <div class="tpbanner__sub-title mb-15">
                            <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_banner_sub_title']); ?></span>
                            <i>
                                <svg width="110" height="35" viewBox="0 0 110 35" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="110" height="34.1" fill="url(#pattern)" fill-opacity="0.08" />
                                    <defs>
                                        <pattern id="pattern" patternContentUnits="objectBoundingBox" width="1"
                                            height="1">
                                            <use xlink:href="#image0_831_2448"
                                                transform="translate(-0.06) scale(0.00611111 0.0197133)" />
                                        </pattern>
                                        <image id="image0_831_2448" width="180" height="50"
                                            xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==" />
                                    </defs>
                                </svg>
                            </i>
                        </div>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_banner_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_banner_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            $settings['tp_banner_title' ] 
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_banner_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_banner_description'] ); ?></p>
                        <?php endif; ?>
                        <?php if ( !empty($settings['tp_banner_btn_text']) ) : ?>
                        <div class="banner-4-btn mb-30">
                            <a
                                <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_banner_btn_text']); ?></a>
                        </div>
                        <?php endif; ?>

                        <?php foreach($settings['tp_contact_list'] as $key => $item) : 

                            $link_type = $item['link_type'];
                            $url = $item['tp_contact_url'];
                            $tell = $item['tp_contact_tell'];
                            $email = $item['tp_contact_email'];

                            $contact_link;

                            if($link_type == 'url'){
                                $contact_link = $url;
                            } elseif($link_type == 'tell'){
                                $contact_link = 'tel:'.$tell;
                            } elseif($link_type == 'email'){
                                $contact_link = 'mailto:'.$email;
                            }
                        ?>
                        <div class="contact-4 d-flex align-items-center">
                            <div class="contact-4-icon">
                                <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                <i class="tp-el-rep-icon"><?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?></i>
                                <?php endif; ?>
                                <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                <i class="tp-el-rep-icon"><img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                        alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>"></i>
                                <?php endif; ?>
                                <?php else : ?>
                                <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                <i class="tp-el-rep-icon"><?php echo $item['tp_box_icon_svg']; ?></i>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <div class="contact-4-text">

                                <?php if(!empty($item['tp_contact_info_subtitle'])) : ?>
                                <span class="tp-el-rep-subtitle"><?php echo tp_kses($item['tp_contact_info_subtitle']); ?></span>
                                <?php endif; ?>

                                <?php if(!empty($item['link_type'])) : ?>
                                <a class="tp-el-rep-title" href="<?php echo esc_url($contact_link); ?>"><?php echo tp_kses($item['tp_contact_info_title']); ?></a>
                                <?php else : ?>
                                <h4 class="tp-el-rep-title"><?php echo tp_kses($item['tp_contact_info_title']); ?></h4>
                                <?php endif; ?>

                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="banner-4-shape d-none d-lg-block">
            <?php if(!empty($tp_image)) : ?>
            <div class="banner-4-shape-one">
                <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($settings['tp_shape_switch'])) : ?>
            <div class="banner-4-shape-two">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/banner-4-shape-1.png" alt="">
            </div>
            <div class="banner-4-shape-three">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/banner-4-shape-2.png" alt="">
            </div>
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="banner-4-shape-six">
                <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
            </div>
            <?php endif; ?>
            <div class="banner-4-shape-seven">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/banner-shape-4-2.png" alt="">
            </div>
            <div class="banner-4-shape-eight">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/banner-shape-4-3.png" alt="">
            </div>
            <div class="banner-4-shape-nine">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/banner-shape-4-4.png" alt="">
            </div>
            <div class="banner-4-shape-ten">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/banner-shape-4-5.png" alt="">
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-5' ) : 

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
        $tp_image3 = !empty($settings['tp_image3']['id']) ? wp_get_attachment_image_url( $settings['tp_image3']['id'], $settings['tp_image_size_size']) : $settings['tp_image3']['url'];
        $tp_image_alt3 = get_post_meta($settings["tp_image3"]["id"], "_wp_attachment_image_alt", true);
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
    if ( !empty($settings['tp_shape_image_5']['url']) ) {
        $tp_shape_image5 = !empty($settings['tp_shape_image_5']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_5']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_5']['url'];
        $tp_shape_image_alt5 = get_post_meta($settings["tp_shape_image_5"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_6']['url']) ) {
        $tp_shape_image6 = !empty($settings['tp_shape_image_6']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_6']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_6']['url'];
        $tp_shape_image_alt6 = get_post_meta($settings["tp_shape_image_6"]["id"], "_wp_attachment_image_alt", true);
    }
    
    // Link
    if ('2' == $settings['tp_banner_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_banner_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'light-blue-btn mr-20 tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_banner_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_banner_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'light-blue-btn mr-20 tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'banner-5-title tp-el-title');        
?>

<section class="banner-area banner-brand fix ele-section">
    <div class="banner-5 p-relative">
        <?php if(!empty($settings['tp_shape_switch'])) : ?>
        <div class="banner-5-content-shape">
            
            <?php if(!empty($tp_shape_image6)) : ?>
            <div class="banner-5-content-shape-one">
                <img src="<?php echo esc_url($tp_shape_image6); ?>" alt="<?php echo esc_attr($tp_shape_image_alt6); ?>">
            </div>
            <?php endif; ?>

            <div class="banner-5-content-shape-two">
                <i>
                    <svg width="1475" height="362" viewBox="0 0 1475 362" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path class="line-dash-path"
                            d="M1474 361C1451.67 263 1275 49 638.999 261C2.99927 473 -98.5012 187 79.4993 1"
                            stroke="url(#paint0_linear_434_178)" stroke-dasharray="4 5" />
                        <defs>
                            <linearGradient id="paint0_linear_434_178" x1="342" y1="152" x2="1623" y2="432"
                                gradientUnits="userSpaceOnUse">
                                <stop offset="1" stop-color="#010F1C" stop-opacity="0.4" />
                                <stop offset="1" stop-color="#010F1C" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                    </svg>
                </i>
            </div>
        </div>
        <?php endif; ?>
        <div class="container">
            <?php if(!empty($settings['tp_shape_switch'])) : ?>
            <div class="banner-5-shape">
                <div class="banner-5-shape-one">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/banner-5-shape-1.png" alt="">
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xl-7 col-lg-6 order-2 order-lg-1">
                    <div class="banner-5-content p-relative pt-80">
                        <?php if ( !empty($settings['tp_banner_sub_title']) ) : ?>
                        <div class="about-5-section mb-10">
                            <span class="sub-title tp-el-subtitle"><?php echo tp_kses($settings['tp_banner_sub_title']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_banner_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_banner_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_banner_title' ] )
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_banner_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_banner_description'] ); ?></p>
                        <?php endif; ?>
                        <div class="banner-5-btn">
                            <?php if ( !empty($settings['tp_banner_btn_text']) ) : ?>
                            <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_banner_btn_text']); ?></a>
                            <?php endif; ?>
                            <?php if(!empty($settings['bottom_text'])) : ?>
                            <span class="tp-el-bottom-text"><?php echo tp_kses($settings['bottom_text']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 order-1 order-lg-2">
                    <div class="banner-5-thumb p-relative">
                        <?php if(!empty($tp_image)) : ?>
                        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                        <?php endif; ?>
                        <div class="banner-5-thumb-shape d-none d-md-block">
                            <?php if(!empty($settings['tp_shape_switch'])) : ?>
                            <div class="banner-5-thumb-shape-one d-none d-lg-block">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/banner-5-shape-7.png" alt="">
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($tp_shape_image)) : ?>
                            <div class="banner-5-thumb-shape-two">
                                <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($tp_shape_image2)) : ?>
                            <div class="banner-5-thumb-shape-three">
                                <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($tp_shape_image3)) : ?>
                            <div class="banner-5-thumb-shape-four">
                                <img src="<?php echo esc_url($tp_shape_image3); ?>" alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($tp_shape_image4)) : ?>
                            <div class="banner-5-thumb-shape-five">
                                <img src="<?php echo esc_url($tp_shape_image4); ?>" alt="<?php echo esc_attr($tp_shape_image_alt4); ?>">
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($tp_shape_image5)) : ?>
                            <div class="banner-5-thumb-shape-six">
                                <img src="<?php echo esc_url($tp_shape_image5); ?>" alt="<?php echo esc_attr($tp_shape_image_alt5); ?>">
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($tp_image2)) : ?>
                            <div class="banner-5-thumb-shape-seven">
                                <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($tp_image3)) : ?>
                            <div class="banner-5-thumb-shape-eight">
                                <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image_alt3); ?>">
                            </div>
                            <?php endif; ?>
                        </div>
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
    if ( !empty($settings['tp_image2']['url']) ) {
        $tp_image2 = !empty($settings['tp_image2']['id']) ? wp_get_attachment_image_url( $settings['tp_image2']['id'], $settings['tp_image_size_size']) : $settings['tp_image2']['url'];
        $tp_image_alt2 = get_post_meta($settings["tp_image2"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image3']['url']) ) {
        $tp_image3 = !empty($settings['tp_image3']['id']) ? wp_get_attachment_image_url( $settings['tp_image3']['id'], $settings['tp_image_size_size']) : $settings['tp_image3']['url'];
        $tp_image_alt3 = get_post_meta($settings["tp_image3"]["id"], "_wp_attachment_image_alt", true);
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

    $this->add_render_attribute('title_args', 'class', 'tpbanner__title mb-25 pb-10 tp-el-title');

?>

<section class="banner__area tpbanner-space scene tpbanner-shape-wrapper fix tp-bg ele-section">
    <div class="tpbanner-shape-wrappers">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="tpbanner__content text-center">
                        <?php if ( !empty($settings['tp_banner_sub_title']) ) : ?>
                        <div class="tpbanner__sub-title mb-15">
                            <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_banner_sub_title']); ?></span>
                            <i>
                                <svg width="110" height="35" viewBox="0 0 110 35" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="110" height="34.1" fill="url(#pattern)" fill-opacity="0.08" />
                                    <defs>
                                        <pattern id="pattern" patternContentUnits="objectBoundingBox" width="1"
                                            height="1">
                                            <use xlink:href="#image0_831_2448"
                                                transform="translate(-0.06) scale(0.00611111 0.0197133)" />
                                        </pattern>
                                        <image id="image0_831_2448" width="180" height="50"
                                            xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==" />
                                    </defs>
                                </svg>
                            </i>
                        </div>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_banner_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_banner_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_banner_title' ] )
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_banner_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_banner_description'] ); ?></p>
                        <?php endif; ?>
                        <div class="tpbanner__search">
                            <?php if( !empty($settings['form_shortcode']) ) : ?>
                            <?php echo do_shortcode( $settings['form_shortcode'] ); ?>
                            <?php else : ?>
                            <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tpbanner-shape  d-none d-lg-block">
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="tpbanner-shape-one">
                <img class="layer" data-depth="0.3" src="<?php echo esc_url($tp_shape_image); ?>"
                    alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_shape_image2)) : ?>
            <div class="tpbanner-shape-three">
                <img class="layer" data-depth="0.4" src="<?php echo esc_url($tp_shape_image2); ?>"
                    alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_image2)) : ?>
            <div class="tpbanner-shape-four">
                <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_image)) : ?>
            <div class="tpbanner-shape-five">
                <img class="layer" data-depth="0.2" src="<?php echo esc_url($tp_image); ?>"
                    alt="<?php echo esc_attr($tp_image_alt); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_image3)) : ?>
            <div class="tpbanner-shape-six">
                <img class="layer" data-depth="0.3" src="<?php echo esc_url($tp_image3); ?>"
                    alt="<?php echo esc_attr($tp_image_alt3); ?>">
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if(!empty($tp_shape_image3)) : ?>
    <div class="tpbanner-shape-wrappers tpbanner-shape-y scene-y">
        <div class="tpbanner-shape  d-none d-lg-block">
            <div class="tpbanner-shape-two">
                <img class="layer" data-depth="0.6" src="<?php echo esc_url($tp_shape_image3); ?>"
                    alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>

<?php endif;
        
	}

}

$widgets_manager->register( new TP_Hero_Banner() );