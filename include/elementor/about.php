<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Control_Media;
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
class TP_About extends Widget_Base {

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
		return 'about';
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
		return __( 'About', 'tp-core' );
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
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        $this->tp_section_title_render_controls('about', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7', 'layout-8']);

        // Features Sections
        $this->start_controls_section(
        'about_features_list_sec',
            [
                'label' => esc_html__( 'Features List', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-8', 'layout-9']
                ]
            ]
        );

        $this->add_control(
            'tp_light_switcher',
            [
                'label' => esc_html__( 'Light Version', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => '0',
                'separator' => 'before',
                'condition' => [
                    'tp_design_style' => 'layout-2'
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
                    'style_2' => __( 'Style 2', 'tpcore' ),                    
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
        'about_features_title',
            [
            'label'   => esc_html__( 'About List Title', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'See the action in live', 'tpcore' ),
            'label_block' => true,
            'condition' => [
                'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_4', 'style_6', 'style_8', 'style_9']
            ]
            ]
        );
        
        $repeater->add_control(
        'about_features_des',
            [
            'label'   => esc_html__( 'Description', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => esc_html__( 'Understand how your keyword/group is ranking specific cases.', 'tpcore' ),
            'label_block' => true,
            'condition' => [
                'repeater_condition' => ['style_2', 'style_4', 'style_5', 'style_6', 'style_8', 'style_9']
            ]
            ]
        );

        $repeater->add_control(
            'tp_about_link_switcher',
            [
                'label' => esc_html__( 'Add About link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2', 'style_8']
                ]
            ]
        );
        
        $repeater->add_control(
        'about_features_btn_text',
            [
                'label'   => esc_html__( 'Button Text', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Read More', 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'tp_about_link_switcher' => 'yes',
                    'repeater_condition' => ['style_2', 'style_8']
                ]
            ]
        );

        $repeater->add_control(
            'tp_about_link_type',
            [
                'label' => esc_html__( 'About Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_about_link_switcher' => 'yes',
                    'repeater_condition' => ['style_1', 'style_2', 'style_8']
                ]
            ]
        );

        $repeater->add_control(
            'tp_about_link',
            [
                'label' => esc_html__( 'About Link link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'tpcore' ),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'tp_about_link_type' => '1',
                    'tp_about_link_switcher' => 'yes',
                    'repeater_condition' => ['style_1', 'style_2', 'style_8']
                ]
            ]
        );
        $repeater->add_control(
            'tp_about_page_link',
            [
                'label' => esc_html__( 'Select About Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_about_link_type' => '2',
                    'tp_about_link_switcher' => 'yes',
                    'repeater_condition' => ['style_1', 'style_2', 'style_8']
                ]
            ]
        );
        
        $this->add_control(
            'about_features_list',
            [
            'label'       => esc_html__( 'About List', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                'about_features_title'   => esc_html__( 'See the action in live', 'tpcore' ),
                ],
                [
                'about_features_title'   => esc_html__( 'Intuitive dashboard', 'tpcore' ),
                ],
            ],
            'title_field' => '{{{ about_features_title }}}',
            ]
        );
        
        $this->end_controls_section();
        
        $this->tp_button_render('about', 'Button', ['layout-3', 'layout-6', 'layout-7']);  

        // _tp_image
		$this->start_controls_section(
            'tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
            ]
        );

        $this->add_control(
            'tp_image1',
            [
                'label' => esc_html__( 'Image 1', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'tp_image2',
            [
                'label' => esc_html__( 'Image 2', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],                
            ]
        );

        $this->add_control(
            'tp_image3',
            [
                'label' => esc_html__( 'Image 3', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ]               
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'shape_image_size',
                'default' => 'full',
                'exclude' => [
                    'custom'
                ]
            ]
        );
        
        $this->add_control(
        'about_vid_url',
            [
                'label'   => esc_html__( 'Video URL', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'https://www.youtube.com/watch?v=EW4ZYb3mCZk', 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'tp_design_style' => 'layout-5'
                ]
            ]
        );

        $this->end_controls_section();

        // Button
        $this->start_controls_section(
            'button',
            [
                'label' => esc_html__( 'About Button', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );    

        $this->add_control(
			'show_button_switch',
			[
				'label' => esc_html__( 'Show Button', 'tpcore' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpcore' ),
				'label_off' => esc_html__( 'Hide', 'tpcore' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
            
		);

        $this->add_control(
            'tp_btn_btn_text',
            [
                'label' => esc_html__('Button Text', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Button Text', 'tpcore'),
                'title' => esc_html__('Enter button text', 'tpcore'),
                'label_block' => true,  

                'condition' => [
                    'show_button_switch' => 'yes',
                ]            
            ]

            

        );
        $this->add_control(
            'tp_btn_link_type',
            [
                'label' => esc_html__( 'Button Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1', 
                'condition' => [
                    'show_button_switch' => 'yes',
                ]             
            ]
            
        );
        
        $this->add_control(
            'tp_btn_link',
            [
                'label' => esc_html__( 'Button Link link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'tpcore' ),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ], 
                'condition' => [
                    'show_button_switch' => 'yes',
                ]
            ]
            
        );

        $this->add_control(
            'tp_btn_page_link',
            [
                'label' => esc_html__( 'Select Button Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_btn_link_type' => '2',
                    'tp_btn_link_switcher' => 'yes',
                ],
                'condition' => [
                    'show_button_switch' => 'yes',
                ]
            ]
            
        );
        
        $this->end_controls_section();

	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('about_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7', 'layout-8']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7', 'layout-8']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7', 'layout-8']);
        $this->tp_link_controls_style('section_btn', 'Section - Button', '.tp-el-btn', ['layout-3', 'layout-6', 'layout-7']);
        $this->tp_link_controls_style('section_play_btn', 'Section - Play Button', '.tp-el-play', 'layout-5');
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-8', 'layout-9']);
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-6', 'layout-8', 'layout-9']);
        $this->tp_basic_style_controls('rep_des_style', 'Repeater Description', '.tp-el-rep-des', ['layout-2', 'layout-4', 'layout-5', 'layout-6', 'layout-8', 'layout-9']);
        $this->tp_link_controls_style('rep_btn_style', 'Repeater Button', '.tp-el-rep-btn', ['layout-1', 'layout-2', 'layout-8']);
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

<?php if ( $settings['tp_design_style']  == 'layout-2' ) : ?>

<?php else:
    // thumbnail
    if ( !empty($settings['tp_image1']['url']) ) {
        $tp_image = !empty($settings['tp_image1']['id']) ? wp_get_attachment_image_url( $settings['tp_image1']['id'], $settings['shape_image_size_size']) : $settings['tp_image1']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image1"]["id"], "_wp_attachment_image_alt", true);
    }    
    if ( !empty($settings['tp_image2']['url']) ) {
        $tp_image2 = !empty($settings['tp_image2']['id']) ? wp_get_attachment_image_url( $settings['tp_image2']['id'], $settings['shape_image_size_size']) : $settings['tp_image2']['url'];
        $tp_image2_alt = get_post_meta($settings["tp_image2"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image3']['url']) ) {
        $tp_image3 = !empty($settings['tp_image3']['id']) ? wp_get_attachment_image_url( $settings['tp_image3']['id'], $settings['shape_image_size_size']) : $settings['tp_image3']['url'];
        $tp_image3_alt = get_post_meta($settings["tp_image3"]["id"], "_wp_attachment_image_alt", true);
    }

    // btn Link
    if ('2' == $settings['tp_btn_link_type']) {
        $link = get_permalink($settings['tp_btn_page_link']);
        $target = '_self';
        $rel = 'nofollow';
    } else {
        $link = !empty($settings['tp_btn_link']['url']) ? $settings['tp_btn_link']['url'] : '';
        $target = !empty($settings['tp_btn_link']['is_external']) ? '_blank' : '';
        $rel = !empty($settings['tp_btn_link']['nofollow']) ? 'nofollow' : '';
    }  
    $this->add_render_attribute('title_args', 'class', 'tp-el-title');
    
?>

<section class="feature-area pt-40 pb-80 tp-el-section d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="tpchoose-thumb p-relative mb-50">
                    <?php if(!empty($tp_image)) : ?>
                    <img class="tpchoose-border-anim" src="<?php echo esc_url($tp_image); ?>"
                        alt="<?php echo esc_attr($tp_image_alt); ?>">
                    <?php endif; ?>
                    <div class="tpchoose-shape d-none d-lg-block">
                        <?php if(!empty($tp_shape_image)) : ?>
                        <div class="tpchoose-shape-one d-none d-md-block">
                            <img src="<?php echo esc_url($tp_shape_image); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image2)) : ?>
                        <div class="tpchoose-shape-two">
                            <img src="<?php echo esc_url($tp_shape_image2); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
                        </div>
                        <?php endif; ?>
                        <div class="tpchoose-shape-three">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/choose-shape-3.png"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-content-4 pl-70">
                    <div class="section-wrapper mb-40">

                        <?php if ( !empty($settings['tp_about_sub_title']) ) : ?>
                            <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_about_sub_title']); ?></span>
                        <?php endif; ?>

                        <?php
                            if ( !empty($settings['tp_about_title' ]) ) :
                                printf( '<%1$s %2$s>%3$s</%1$s>',
                                tag_escape( $settings['tp_about_title_tag'] ),
                                $this->get_render_attribute_string( 'title_args' ),
                                tp_kses( $settings['tp_about_title' ] )
                                );
                            endif;
                        ?>

                        <?php if ( !empty($settings['tp_about_description']) ) : ?>
                            <p class="tp-el-content"><?php echo tp_kses( $settings['tp_about_description'] ); ?></p>
                        <?php endif; ?>

                    </div>
                    <ul class="feature-list-4">

                    <?php foreach($settings['about_features_list'] as $key => $item) : ?>
                        <li>
                            <div
                                class="feature-list-4-item p-relative d-flex <?php echo $key == 1 ? 'pl-100' : NULL; echo $key == 2 ? 'pl-30' : NULL; ?>">
                                <div class="feature-list-4-icon ">
                                    <div class="feature-list-bg p-relative">
                                        <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                        <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                        <i class="tp-el-rep-icon">
                                            <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                        </i>
                                        <?php endif; ?>
                                        <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                        <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                        <i class="tp-el-rep-icon">
                                            <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                                alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                        </i>
                                        <?php endif; ?>
                                        <?php else : ?>
                                        <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                        <i class="tp-el-rep-icon">
                                            <?php echo $item['tp_box_icon_svg']; ?>
                                        </i>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <b><?php echo $key < 10 ? '0' . esc_html($key+1) : $key+1; ?></b>
                                        <span class="feature-bg-border-1"></span>
                                        <span class="feature-bg-border-2"></span>
                                        <span class="feature-bg-border-3"></span>
                                        <span class="feature-bg-border-4"></span>
                                    </div>
                                </div>
                                <div class="feature-list-4-content">

                                    <?php if(!empty($item['about_features_title'])) : ?>
                                        <h4 class="title tp-el-rep-title"><?php echo tp_kses($item['about_features_title']); ?></h4>
                                    <?php endif; ?>

                                    <?php if(!empty($item['about_features_des'])) : ?>
                                        <p class="tp-el-rep-des"><?php echo tp_kses($item['about_features_des']); ?></p>
                                    <?php endif; ?>

                                </div>
                                <div class="feature-4-shape-<?php echo esc_attr($key+1); ?> d-none d-md-block">
                                    <?php if($key == 0) : ?>
                                    <svg class="line-dash-path" width="38" height="122" viewBox="0 0 38 122" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.279297 1C41.9846 20.0005 55.1988 87.9525 2.74393 121.294"
                                            stroke="#A7ACB3" stroke-dasharray="4 4" />
                                    </svg>
                                    <?php elseif($key == 1) : ?>
                                    <svg class="line-dash-path" width="42" height="122" viewBox="0 0 42 122" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M41.3076 1.22192C-1.33493 18.0137 -18.0874 85.181 32.5507 121.222"
                                            stroke="#A7ACB3" stroke-dasharray="4 4"></path>
                                    </svg>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- about section start here -->
<section class="about bg-white padding-block">
    <div class="container">
        <div class="row align-items-center g-4 justify-content-center">
            <div class="col-xl-5">
                <div class="section__header">
                    <div class="col-md-12">                                                 
                        <?php if ( !empty($settings['tp_about_sub_title']) ) : ?>
                            <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_about_sub_title']); ?></span>
                        <?php endif; ?>  
                        <?php
                            if ( !empty($settings['tp_about_title' ]) ) :
                                printf( '<%1$s %2$s>%3$s</%1$s>',
                                tag_escape( $settings['tp_about_title_tag'] ),
                                $this->get_render_attribute_string( 'title_args' ),
                                tp_kses( $settings['tp_about_title' ] )
                                );
                            endif;
                        ?>
                    </div>
                </div>
                <div class="section__wrapper about__content">
                        <?php if ( !empty($settings['tp_about_description']) ) : ?>
                            <p class="tp-el-content"><?php echo tp_kses( $settings['tp_about_description'] ); ?></p>
                        <?php endif; ?>

                    <ul>
                        <?php foreach($settings['about_features_list'] as $key => $item) : ?>
                        <li>
                            <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                            <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                            <span class="tp-el-rep-icon">
                                <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                            </span>
                            <?php endif; ?>
                            <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                            <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                            <span class="tp-el-rep-icon">
                                <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                    alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                            </span>
                            <?php endif; ?>
                            <?php else : ?>
                            <?php if (!empty($item['tp_box_icon_svg'])): ?>
                            <span class="tp-el-rep-icon">
                                <?php echo $item['tp_box_icon_svg']; ?>
                            </span>
                            <?php endif; ?>
                            <?php endif; ?> 

                            <?php if(!empty($item['about_features_title'])) : ?>
                                <?php echo tp_kses($item['about_features_title']); ?>
                            <?php endif; ?>
                        </li>  
                        <?php endforeach; ?>
                    </ul> 
                    <?php if (!empty($link)) : ?>                                        
                        <div class="bannerbtn">
                            <a class="custom-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" rel="<?php echo esc_attr($rel); ?>">
                                <?php echo tp_kses($settings['tp_btn_btn_text']); ?>
                            </a>                                       
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="row g-4">
                    <div class="col-xl-12">
                        <div class="about__rightimg imghover">
                            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt);?>">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about__rightimg imghover d-xl-block d-none">
                            <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image2_alt); ?>">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about__rightimg imghover d-xl-block d-none">
                            <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image3_alt);?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
<!--about section end here -->      



<?php endif; 
        
	}
}

$widgets_manager->register( new TP_About() );