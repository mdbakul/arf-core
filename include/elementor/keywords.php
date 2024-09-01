<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
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
class TP_Keywords extends Widget_Base {

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
        return 'tp-keywords';
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
        return __( 'Keywords', 'tpcore' );
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
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        $this->tp_section_title_render_controls('keyword', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.');

        // Keyword group 1
        $this->start_controls_section(
            'tp_keyword',
            [
                'label' => esc_html__('Keywords List', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'key_title', [
                'label' => esc_html__('Keyword Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Keywords', 'tpcore'),
            ]
        );


        $this->add_control(
            'key_rank', [
                'label' => esc_html__('Keyword Rank', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Rank', 'tpcore'),
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
            'tp_flag_image',
            [
                'label' => esc_html__('Upload Flag Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_state_code', [
                'label' => esc_html__('State Code', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('EN', 'tpcore'),
            ]
        );

        $repeater->add_control(
            'tp_keyword_title', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Keyword Title', 'tpcore'),
                'label_block' => true,
            ]
        );


        $repeater->add_control(
            'tp_keyword_title2', [
                'label' => esc_html__('Secondary Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('/website-seo', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_rank', [
                'label' => esc_html__('Rank Position', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('1', 'tpcore'),
            ]
        );

        $repeater->add_control(
            'tp_visitor', [
                'label' => esc_html__('Visitors', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('3', 'tpcore'),
            ]
        );

        $repeater->add_control(
            'tp_visi_status',
            [
                'label' => __( 'Visitor Status', 'tpcore' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'up' => __( 'UP', 'tpcore' ),
                    'down' => __( 'DOWN', 'tpcore' ),
                ],
                'default' => 'up',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );
        
        $this->add_control(
            'tp_keyword_list',
            [
                'label' => esc_html__('Keywords - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_keyword_title' => esc_html__('WordPress SEO', 'tpcore'),
                    ],
                    [
                        'tp_keyword_title' => esc_html__('Shopify SEO', 'tpcore')
                    ],
                    [
                        'tp_keyword_title' => esc_html__('Joomla SEO', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_keyword_title }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tp_flag_image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                // 'default' => 'tp-post-thumb',
            ]
        );
        
        $this->end_controls_section();

        
        // Keyword group 2
        $this->start_controls_section(
            'tp_keyword2',
            [
                'label' => esc_html__('Keywords List 2', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'key_title2', [
                'label' => esc_html__('Keyword Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Keywords', 'tpcore'),
            ]
        );

        $this->add_control(
            'key_rank2', [
                'label' => esc_html__('Keyword Rank', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Rank', 'tpcore'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'repeater_condition2',
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
            'tp_box_icon_type2',
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
            'tp_box_icon_svg2',
            [
                'show_label' => false,
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__('SVG Code Here', 'tpcore'),
                'condition' => [
                    'tp_box_icon_type2' => 'svg',
                ]
            ]
        );

        $repeater->add_control(
            'tp_box_icon_image2',
            [
                'label' => esc_html__('Upload Icon Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_box_icon_type2' => 'image',
                ]
            ]
        );

        if (tp_is_elementor_version('<', '2.6.0')) {
            $repeater->add_control(
                'tp_box_icon2',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-star',
                    'condition' => [
                        'tp_box_icon_type2' => 'icon',
                    ]
                ]
            );
        } else {
            $repeater->add_control(
                'tp_box_selected_icon2',
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
                        'tp_box_icon_type2' => 'icon',
                    ]
                ]
            );
        }

        $repeater->add_control(
            'tp_flag_image2',
            [
                'label' => esc_html__('Upload Flag Image2', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_state_code2', [
                'label' => esc_html__('State Code', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('EN', 'tpcore'),
            ]
        );

        $repeater->add_control(
            'tp_keyword_title2', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Keyword Title', 'tpcore'),
                'label_block' => true,
            ]
        );


        $repeater->add_control(
            'tp_keyword_title22', [
                'label' => esc_html__('Secondary Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('/website-seo', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_rank2', [
                'label' => esc_html__('Rank Position', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('1', 'tpcore'),
            ]
        );

        $repeater->add_control(
            'tp_visitor2', [
                'label' => esc_html__('Visitors', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('3', 'tpcore'),
            ]
        );

        $repeater->add_control(
            'tp_visi_status2',
            [
                'label' => __( 'Visitor Status', 'tpcore' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'up' => __( 'UP', 'tpcore' ),
                    'down' => __( 'DOWN', 'tpcore' ),
                ],
                'default' => 'up',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );
        
        $this->add_control(
            'tp_keyword_list2',
            [
                'label' => esc_html__('Keywords - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_keyword_title2' => esc_html__('WordPress SEO', 'tpcore'),
                    ],
                    [
                        'tp_keyword_title2' => esc_html__('Shopify SEO', 'tpcore')
                    ],
                    [
                        'tp_keyword_title2' => esc_html__('Joomla SEO', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_keyword_title2 }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tp_flag_image2', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                // 'default' => 'tp-post-thumb',
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
        $this->tp_section_style_controls('keyword_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', 'layout-1');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', 'layout-1');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', 'layout-1');
        $this->tp_basic_style_controls('key_title', 'Keyword Title', '.tp-el-key-title', 'layout-1');
        $this->tp_basic_style_controls('key_rank', 'Keyword Rank', '.tp-el-key-rank', 'layout-1');
        
        # repeater
        $this->tp_basic_style_controls('list_title', 'List Title', '.tp-el-list-title', 'layout-1');

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
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'tpsection-title-white-2 mb-90 tp-el-title');
?>

<section class="rating-area theme-bg-4 tp-el-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="tpsection-wrapper rating-title-3 text-center">
                    
                    <?php if ( !empty($settings['tp_keyword_sub_title']) ) : ?>
                    <p class="text-white tp-el-subtitle"><?php echo tp_kses($settings['tp_keyword_sub_title']); ?></p>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_keyword_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_keyword_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_keyword_title' ] )
                        );
                    endif;
                    ?>
                    <span class="d-none d-sm-block">
                        <svg width="340" height="20" viewBox="0 0 340 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M144.402 1.89402C128.428 2.53338 112.643 3.31953 97.249 4.17899C75.4574 5.39482 53.6744 6.65259 32.0226 8.64403C25.2071 9.27291 18.2859 9.67118 11.513 10.4573C7.26139 10.9499 1.62388 11.652 0.884026 11.7988C0.497052 11.8826 0.328229 12.0085 0.273678 12.0504C-0.109886 12.3439 -0.0398999 12.6268 0.176601 12.8469C0.263542 12.9412 0.48339 13.1719 1.09368 13.2034C41.9083 15.352 83.6435 11.1595 124.508 10.7193C195.373 9.96465 268.387 12.9623 338.69 19.5026C339.303 19.555 339.9 19.2929 339.985 18.9051C340.088 18.5278 339.644 18.1609 339.031 18.1085C268.608 11.5577 195.475 8.54959 124.473 9.31472C86.3898 9.72349 47.5544 13.4025 9.41787 12.1447C10.2941 12.0399 11.1533 11.9351 11.9375 11.8407C18.6831 11.0546 25.5753 10.6669 32.3636 10.038C53.9693 8.04655 75.708 6.7888 97.4706 5.58345C124.474 4.07415 152.653 2.77446 181.053 2.16654C191.214 2.26087 201.34 2.35525 211.466 2.47054C233.371 2.72209 255.38 3.45579 277.234 4.44103C283.815 4.74498 290.395 5.0594 296.975 5.33191C299.157 5.42624 304.783 5.69871 305.567 5.67775C306.539 5.65678 306.726 5.15373 306.743 5.06988C306.794 4.88121 306.76 4.61917 306.283 4.39906C306.232 4.36762 305.925 4.26274 305.243 4.19985C265.506 0.489476 223.075 -0.128822 181.088 0.762087C136.799 0.374279 92.3393 0.206502 48.163 0.0283203C47.5305 0.0283203 47.014 0.342805 47.0089 0.730612C47.0055 1.11842 47.5151 1.43291 48.1476 1.4434C80.1351 1.56917 112.285 1.69487 144.402 1.89402Z"
                                fill="white" />
                        </svg>
                    </span>
                </div>
                <?php if ( !empty($settings['tp_keyword_description']) ) : ?>
                <span class="text-white tp-el-content" ><?php echo tp_kses( $settings['tp_keyword_description'] ); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="tprating-radient-bg p-relative">
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="tprating-radient-shape">
                <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
            </div>
            <?php endif; ?>
            <div class="row gx-10 justify-content-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="tprating p-relative mb-25">

                        <?php if(!empty($settings['tp_shape_switch'])) : ?>
                        <div class="rating-shape d-none d-sm-block">
                            <div class="rating-shape-one wow bounceIn" data-wow-duration=".4s" data-wow-delay=".6s">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/rating-3-shape-1.png" alt="">
                            </div>
                            <div class="rating-shape-two wow bounceIn" data-wow-duration=".4s" data-wow-delay=".4s">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/rating-3-shape-2.png" alt="">
                            </div>
                            <div class="rating-shape-three wow bounceIn" data-wow-duration=".4s" data-wow-delay=".6s">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/rating-3-shape-3.png" alt="">
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="tprating-heading d-flex align-items-center justify-content-between mb-15">
                            <?php if(!empty($settings['key_title'])) : ?>
                            <h4 class="title tp-el-key-title"><?php echo tp_kses($settings['key_title']); ?></h4>
                            <?php endif; ?>
                            <?php if(!empty($settings['key_rank'])) : ?>
                            <div class="rank ">
                                <span class="tp-el-key-rank"><?php echo tp_kses($settings['key_rank']); ?>
                                    <i class="fa-light fa-angle-up"></i>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.33239 1.14893H5.14742C2.18498 1.14893 1 2.3339 1 5.29634V8.85127C1 11.8137 2.18498 12.9987 5.14742 12.9987H8.70235C11.6648 12.9987 12.8498 11.8137 12.8498 8.85127V7.6663"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M9.31928 1.75319L4.65047 6.42199C4.47273 6.59974 4.29498 6.94931 4.25943 7.20408L4.00466 8.98747C3.90986 9.63328 4.36608 10.0836 5.01189 9.9947L6.79528 9.73993C7.04412 9.70438 7.39369 9.52663 7.57736 9.34889L12.2462 4.68008C13.052 3.8743 13.4311 2.93816 12.2462 1.75319C11.0612 0.568212 10.1251 0.947404 9.31928 1.75319Z"
                                            stroke="white" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M8.64893 2.42236C9.04589 3.83841 10.1538 4.94636 11.5758 5.34925"
                                            stroke="white" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <ul>

                            <?php foreach($settings['tp_keyword_list'] as $key => $item) :
                                // thumbnail
                                if ( !empty($item['tp_flag_image']['url']) ) {
                                    $tp_flag_image = !empty($item['tp_flag_image']['id']) ? wp_get_attachment_image_url( $item['tp_flag_image']['id'], $settings['tp_flag_image_size']) : $item['tp_flag_image']['url'];
                                    $tp_flag_image_alt = get_post_meta($item["tp_flag_image"]["id"], "_wp_attachment_image_alt", true);
                                }      
                            ?>
                            <li>
                                <div class="tprating-item d-flex align-items-center flex-wrap justify-content-between">
                                    <div class="tprating-content">
                                        <div class="tprating-content-wrap flex-wrap d-flex align-items-center">

                                        
                                            <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                            <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                            <div class="icon">
                                                <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                            </div>
                                            <?php endif; ?>
                                            <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                            <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                            <div class="icon">
                                                <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                                    alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <?php else : ?>
                                            <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                            <div class="icon">
                                                <?php echo $item['tp_box_icon_svg']; ?>
                                            </div>
                                            <?php endif; ?>
                                            <?php endif; ?>

                                            <div class="flag">
                                                <?php if(!empty($tp_flag_image)) : ?>
                                                <i>
                                                    <img src="<?php echo esc_url($tp_flag_image); ?>" alt="<?php echo esc_attr($tp_flag_image_alt); ?>">
                                                </i>
                                                <?php endif; ?>
                                                <?php if(!empty($item['tp_state_code'])) : ?>
                                                <span><?php echo tp_kses($item['tp_state_code']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if(!empty($item['tp_keyword_title'])) : ?>
                                            <p class="tp-el-list-title"><?php echo tp_kses($item['tp_keyword_title']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <?php if(!empty($item['tp_keyword_title2'])) : ?>
                                        <span><?php echo tp_kses($item['tp_keyword_title2']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="tprating-rank d-flex align-items-center mr-20">
                                        <?php if(!empty($item['tp_rank'])) : ?>
                                        <div class="tprating-rank-list mr-20">
                                            <span><?php echo tp_kses($item['tp_rank']); ?></span>
                                        </div>
                                        <?php endif; ?>
                                        <?php if(!empty($item['tp_visitor'])) : ?>
                                        <div class="tprating-rank-updaet">

                                            <?php if($item['tp_visi_status'] == 'up') : ?>
                                            <i>
                                                <svg width="10" height="5" viewBox="0 0 10 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M10 5L5.70711 0.707108C5.31658 0.316583 4.68342 0.316583 4.29289 0.707107L0 5"
                                                        fill="#0DC167" />
                                                </svg>
                                            </i>
                                            <?php elseif($item['tp_visi_status'] == 'down') : ?>
                                            <i>
                                                <svg width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 0L5.70711 4.29289C5.31658 4.68342 4.68342 4.68342 4.29289 4.29289L0 0" fill="#FFB866"></path>
                                                </svg>
                                            </i>
                                            <?php endif; ?>

                                            <span class="<?php echo $item['tp_visi_status'] == 'down' ? 'down' : NULL; ?>"> <?php echo tp_kses($item['tp_visitor']); ?></span>
                                        </div>
                                        <?php endif; ?>
                                        <?php if(empty($item['tp_visitor'])) : ?>
                                        <div class="tprating-rank-updaet">
                                            <b></b>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="tprating mb-25">
                        <div class="tprating-heading d-flex align-items-center justify-content-between mb-15">
                            <?php if(!empty($settings['key_title2'])) : ?>
                            <h4 class="title tp-el-key-title"><?php echo tp_kses($settings['key_title2']); ?></h4>
                            <?php endif; ?>
                            <?php if(!empty($settings['key_rank2'])) : ?>
                            <div class="rank">
                                <span class="tp-el-key-rank"><?php echo tp_kses($settings['key_rank2']); ?>
                                    <i class="fa-light fa-angle-up"></i>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.33239 1.14893H5.14742C2.18498 1.14893 1 2.3339 1 5.29634V8.85127C1 11.8137 2.18498 12.9987 5.14742 12.9987H8.70235C11.6648 12.9987 12.8498 11.8137 12.8498 8.85127V7.6663"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M9.31928 1.75319L4.65047 6.42199C4.47273 6.59974 4.29498 6.94931 4.25943 7.20408L4.00466 8.98747C3.90986 9.63328 4.36608 10.0836 5.01189 9.9947L6.79528 9.73993C7.04412 9.70438 7.39369 9.52663 7.57736 9.34889L12.2462 4.68008C13.052 3.8743 13.4311 2.93816 12.2462 1.75319C11.0612 0.568212 10.1251 0.947404 9.31928 1.75319Z"
                                            stroke="white" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M8.64893 2.42236C9.04589 3.83841 10.1538 4.94636 11.5758 5.34925"
                                            stroke="white" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <ul>

                        <?php foreach($settings['tp_keyword_list2'] as $key => $item2) :
                            // thumbnail
                            if ( !empty($item2['tp_flag_image2']['url']) ) {
                                $tp_flag_image2 = !empty($item2['tp_flag_image2']['id']) ? wp_get_attachment_image_url( $item2['tp_flag_image2']['id'], $settings['tp_flag_image2_size']) : $item2['tp_flag_image2']['url'];
                                $tp_flag_image_alt2 = get_post_meta($item2["tp_flag_image2"]["id"], "_wp_attachment_image_alt", true);
                            }      
                        ?>
                        <li>
                            <div class="tprating-item d-flex align-items-center flex-wrap justify-content-between">
                                <div class="tprating-content">
                                    <div class="tprating-content-wrap flex-wrap d-flex align-items-center">

                                    
                                        <?php if($item2['tp_box_icon_type2'] == 'icon') : ?>
                                        <?php if (!empty($item2['tp_box_icon2']) || !empty($item2['tp_box_selected_icon2']['value'])) : ?>
                                        <div class="icon">
                                            <?php tp_render_icon($item2, 'tp_box_icon2', 'tp_box_selected_icon2'); ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php elseif( $item2['tp_box_icon_type2'] == 'image' ) : ?>
                                        <?php if (!empty($item2['tp_box_icon_image2']['url'])): ?>
                                        <div class="icon">
                                            <img src="<?php echo $item2['tp_box_icon_image2']['url']; ?>"
                                                alt="<?php echo get_post_meta(attachment_url_to_postid($item2['tp_box_icon_image2']['url']), '_wp_attachment_image_alt', true); ?>">
                                        </div>
                                        <?php endif; ?>
                                        <?php else : ?>
                                        <?php if (!empty($item2['tp_box_icon_svg2'])): ?>
                                        <div class="icon">
                                            <?php echo $item2['tp_box_icon_svg2']; ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php endif; ?>

                                        <div class="flag">
                                            <?php if(!empty($tp_flag_image2)) : ?>
                                            <i>
                                                <img src="<?php echo esc_url($tp_flag_image2); ?>" alt="<?php echo esc_attr($tp_flag_image_alt2); ?>">
                                            </i>
                                            <?php endif; ?>
                                            <?php if(!empty($item2['tp_state_code2'])) : ?>
                                            <span><?php echo tp_kses($item2['tp_state_code2']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if(!empty($item2['tp_keyword_title2'])) : ?>
                                        <p class="tp-el-list-title"><?php echo tp_kses($item2['tp_keyword_title2']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <?php if(!empty($item2['tp_keyword_title22'])) : ?>
                                    <span><?php echo tp_kses($item2['tp_keyword_title22']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="tprating-rank d-flex align-items-center mr-20">
                                    <?php if(!empty($item2['tp_rank2'])) : ?>
                                    <div class="tprating-rank-list mr-20">
                                        <span><?php echo tp_kses($item2['tp_rank2']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(!empty($item2['tp_visitor2'])) : ?>
                                    <div class="tprating-rank-updaet">

                                        <?php if($item2['tp_visi_status2'] == 'up') : ?>
                                        <i>
                                            <svg width="10" height="5" viewBox="0 0 10 5" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10 5L5.70711 0.707108C5.31658 0.316583 4.68342 0.316583 4.29289 0.707107L0 5"
                                                    fill="#0DC167" />
                                            </svg>
                                        </i>
                                        <?php elseif($item2['tp_visi_status2'] == 'down') : ?>
                                        <i>
                                            <svg width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L5.70711 4.29289C5.31658 4.68342 4.68342 4.68342 4.29289 4.29289L0 0" fill="#FFB866"></path>
                                            </svg>
                                        </i>
                                        <?php endif; ?>

                                        <span class="<?php echo $item2['tp_visi_status2'] == 'down' ? 'down' : NULL; ?>"> <?php echo tp_kses($item2['tp_visitor2']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(empty($item2['tp_visitor2'])) : ?>
                                    <div class="tprating-rank-updaet">
                                        <b></b>
                                    </div>
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
    </div>
</section>

<?php endif; 
    }
}

$widgets_manager->register( new TP_Keywords() ); 