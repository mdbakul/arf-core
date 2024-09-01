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
class TP_Services_Info_Tab extends Widget_Base {

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
        return 'services-info-tab';
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
        return __( 'Services Info Tab', 'tpcore' );
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

        $this->tp_section_title_render_controls('services', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2']);

        // Service group
        $this->start_controls_section(
            'tp_services',
            [
                'label' => esc_html__('Services List', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                    'l_style_1' => __( 'Layout Style 1', 'tpcore' ),
                    'l_style_2' => __( 'Layout Style 2', 'tpcore' ),
                    'l_style_3' => __( 'Layout Style 3', 'tpcore' ),
                    'l_style_4' => __( 'Layout Style 4', 'tpcore' ),
                    'l_style_5' => __( 'Layout Style 5', 'tpcore' ),
                    'style_2' => __( 'Style 2', 'tpcore' ),
                    'l2_style_1' => __( 'Layout 2 Style 1', 'tpcore' ),
                    'l2_style_2' => __( 'Layout 2 Style 2', 'tpcore' ),
                    'l2_style_3' => __( 'Layout 2 Style 3', 'tpcore' ),
                    'l2_style_4' => __( 'Layout 2 Style 4', 'tpcore' ),
                ],
                'default' => 'style_1',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $repeater->add_control(
            'tp_tab_active',
            [
                'label' => esc_html__( 'Active This', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 0,
                'separator' => 'before',
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
            'shape_image',
            [
                'label' => esc_html__('Upload Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'repeater_condition' => ['style_2', 'l2_style_1', 'l2_style_2', 'l2_style_3', 'l2_style_4']
                ]
            ]
        );

        $repeater->add_control(
            'tp_tab_title', [
                'label' => esc_html__('Tab Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Tab 1', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_tab_des', [
                'label' => esc_html__('Tab Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Dig into search results, SERP features, CTRs and 45+ SEO metrics', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_2', 'l2_style_1', 'l2_style_2', 'l2_style_3', 'l2_style_4']
                ]
            ]
        );

        $repeater->add_control(
            'tp_service_title', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Service Title', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_1', 'l_style_1', 'l_style_2', 'l_style_3', 'l_style_4', 'l_style_5' ]
                ]
            ]
        );

        $repeater->add_control(
            'tp_service_des', [
                'label' => esc_html__('Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('With over 1 million+ homes for sale available on the website, Trulia can match you with a house you will want', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_1', 'l_style_1', 'l_style_2', 'l_style_3', 'l_style_4', 'l_style_5' ]
                ]
            ]
        );

        $repeater->add_control(
            'tp_services_link_switcher',
            [
                'label' => esc_html__( 'Add Services link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
                'condition' => [
                    'repeater_condition' => ['style_1', 'l_style_1', 'l_style_2', 'l_style_3', 'l_style_4', 'l_style_5' ]
                ]
            ]
        );

        $repeater->add_control(
            'tp_services_btn_text',
            [
                'label' => esc_html__('Button Text', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Button Text', 'tpcore'),
                'title' => esc_html__('Enter button text', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'tp_services_link_switcher' => 'yes',
                    'repeater_condition' => ['style_1', 'l_style_1', 'l_style_2', 'l_style_3', 'l_style_4', 'l_style_5' ]
                ],
            ]
        );

        $repeater->add_control(
            'tp_services_link_type',
            [
                'label' => esc_html__( 'Service Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_services_link_switcher' => 'yes',
                    'repeater_condition' => ['style_1', 'l_style_1', 'l_style_2', 'l_style_3', 'l_style_4', 'l_style_5' ]
                ]
            ]
        );
        $repeater->add_control(
            'tp_services_link',
            [
                'label' => esc_html__( 'Service Link link', 'tpcore' ),
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
                    'tp_services_link_type' => '1',
                    'tp_services_link_switcher' => 'yes',
                    'repeater_condition' => ['style_1', 'l_style_1', 'l_style_2', 'l_style_3', 'l_style_4', 'l_style_5' ]
                ]
            ]
        );
        $repeater->add_control(
            'tp_services_page_link',
            [
                'label' => esc_html__( 'Select Service Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_services_link_type' => '2',
                    'tp_services_link_switcher' => 'yes',
                    'repeater_condition' => ['style_1', 'l_style_1', 'l_style_2', 'l_style_3', 'l_style_4', 'l_style_5' ]
                ]
            ]
        );

        // img
        $repeater->add_control(
            'tp_image',
            [
                'label' => esc_html__('Upload Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_image2',
            [
                'label' => esc_html__('Upload Image 2', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_image3',
            [
                'label' => esc_html__('Upload Image 3', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_image4',
            [
                'label' => esc_html__('Upload Image 4', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'repeater_condition' => ['style_2', 'l2_style_1', 'l2_style_2', 'l2_style_3', 'l2_style_4']
                ]
            ]
        );

        $repeater->add_control(
            'tp_image5',
            [
                'label' => esc_html__('Upload Image 5', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'repeater_condition' => 'l2_style_4'
                ]
            ]
        );

        $repeater->add_control(
            'tp_image6',
            [
                'label' => esc_html__('Upload Image 6', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'repeater_condition' => 'l2_style_4'
                ]
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tp_image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                'default' => 'full',
            ]
        );

        $this->add_control(
            'tp_service_list',
            [
                'label' => esc_html__('Services - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_tab_title' => esc_html__('Tab 1', 'tpcore'),
                        'tp_service_title' => esc_html__('Title 1', 'tpcore'),
                    ],
                    [
                        'tp_tab_title' => esc_html__('Tab 2', 'tpcore'),
                        'tp_service_title' => esc_html__('Title 2', 'tpcore')
                    ],
                    [
                        'tp_tab_title' => esc_html__('Tab 3', 'tpcore'),
                        'tp_service_title' => esc_html__('Title 3', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_tab_title }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                // 'default' => 'tp-post-thumb',
            ]
        );
        
        $this->end_controls_section();

    }

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('services_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2']);

        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', 'layout-2');
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('rep_des_style', 'Repeater Description', '.tp-el-rep-des', ['layout-1', 'layout-2']);
        $this->tp_link_controls_style('rep_btn_style', 'Repeater Button', '.tp-el-rep-btn', ['layout-1', 'layout-2']);
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
    $this->add_render_attribute('title_args', 'class', 'section-3-title mb-15 tp-el-title');
?>

<section class="toolest-area toolest-bg pt-105 pb-100 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-3 text-center mb-70">

                    <?php if ( !empty($settings['tp_services_sub_title']) ) : ?>
                    <p class="tp-el-subtitle"><?php echo tp_kses($settings['tp_services_sub_title']); ?></p>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_services_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_services_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_services_title' ] )
                        );
                    endif;
                    ?>
                    <?php if ( !empty($settings['tp_services_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_services_description'] ); ?></p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="tp-gradient-tab-details pt-75 tab-content services-tab-anim" id="v-pills-tabContent">

                    <?php foreach($settings['tp_service_list'] as $key => $item) : 
                        $active_show = $item['tp_tab_active'] ? 'active show' : NULL ;
                        
                        // thumbnail
                        if ( !empty($item['tp_image']['url']) ) {
                            $tp_image = !empty($item['tp_image']['id']) ? wp_get_attachment_image_url( $item['tp_image']['id'], $item['tp_image_size']) : $item['tp_image']['url'];
                            $tp_image_alt = get_post_meta($item["tp_image"]["id"], "_wp_attachment_image_alt", true);
                        }   
                        if ( !empty($item['tp_image2']['url']) ) {
                            $tp_image2 = !empty($item['tp_image2']['id']) ? wp_get_attachment_image_url( $item['tp_image2']['id'], $item['tp_image_size']) : $item['tp_image2']['url'];
                            $tp_image_alt2 = get_post_meta($item['tp_image2']["id"], "_wp_attachment_image_alt", true);
                        }  
                        if ( !empty($item['tp_image3']['url']) ) {
                            $tp_image3 = !empty($item['tp_image3']['id']) ? wp_get_attachment_image_url( $item['tp_image3']['id'], $item['tp_image_size']) : $item['tp_image3']['url'];
                            $tp_image_alt3 = get_post_meta($item['tp_image3']["id"], "_wp_attachment_image_alt", true);
                        } 
                        if ( !empty($item['tp_image4']['url']) ) {
                            $tp_image4 = !empty($item['tp_image4']['id']) ? wp_get_attachment_image_url( $item['tp_image4']['id'], $item['tp_image_size']) : $item['tp_image4']['url'];
                            $tp_image_alt4 = get_post_meta($item['tp_image4']["id"], "_wp_attachment_image_alt", true);
                        }   
                        if ( !empty($item['tp_image5']['url']) ) {
                            $tp_image5 = !empty($item['tp_image5']['id']) ? wp_get_attachment_image_url( $item['tp_image5']['id'], $item['tp_image_size']) : $item['tp_image5']['url'];
                            $tp_image_alt5 = get_post_meta($item['tp_image5']["id"], "_wp_attachment_image_alt", true);
                        }   
                        if ( !empty($item['tp_image6']['url']) ) {
                            $tp_image6 = !empty($item['tp_image6']['id']) ? wp_get_attachment_image_url( $item['tp_image6']['id'], $item['tp_image_size']) : $item['tp_image6']['url'];
                            $tp_image_alt6 = get_post_meta($item['tp_image6']["id"], "_wp_attachment_image_alt", true);
                        }   
                    ?>
                    <div class="tab-pane fade <?php echo esc_attr($active_show); ?>" id="v-pills-<?php echo esc_attr($key+1); ?>" role="tabpanel"
                        aria-labelledby="v-pills-<?php echo esc_attr($key+1); ?>-tab" tabindex="0">

                        <?php if($item['repeater_condition'] == 'style_2' || $item['repeater_condition'] == 'l2_style_1') : ?>
                        <div class="toolest-one-thumb toolest-thumb p-relative">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="toolest-one-thumb-one">
                                        <?php if(!empty($tp_image)) : ?>
                                        <div class="toolest-one-shape-one">
                                            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                                        </div>
                                        <?php endif; ?>
                                        <?php if(!empty($tp_image2)) : ?>
                                        <div class="toolest-one-shape-two mb-10">
                                            <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <?php if(!empty($tp_image3)) : ?>
                                    <div class="toolest-one-shape-three mb-30">
                                        <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                    </div>
                                    <?php endif; ?>
                                    <?php if(!empty($tp_image4)) : ?>
                                    <div class="toolest-one-shape-four d-none d-md-block">
                                        <img src="<?php echo esc_url($tp_image4); ?>" alt="<?php echo esc_attr($tp_image_alt4); ?>">
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="toolest-one-shape-five">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tool/tool-1-overlay-1.png" alt="">
                            </div>
                        </div>
                        <?php elseif($item['repeater_condition'] == 'l2_style_2') : ?>
                        <div class="toolest-thumb p-relative">
                            <?php if(!empty($tp_image)) : ?>
                                <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                            <?php endif; ?>
                            <div class="toolest-shape">

                                <?php if(!empty($tp_image2)) : ?>
                                <div class="toolest-shape-one">
                                    <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($tp_image3)) : ?>
                                <div class="toolest-shape-two">
                                    <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                </div>
                                <?php endif; ?>
                                
                                <?php if(!empty($tp_image4)) : ?>
                                <div class="toolest-shape-three">
                                    <img src="<?php echo esc_url($tp_image4); ?>" alt="<?php echo esc_attr($tp_image_alt4); ?>">
                                </div>
                                <?php endif; ?>
                                
                                <div class="toolest-shape-four d-none d-lg-block">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/tool-overly.png" alt="">
                                </div>
                                <div class="toolest-shape-five">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/tool-dots.png" alt="">
                                </div>
                            </div>
                        </div>
                        <?php elseif($item['repeater_condition'] == 'l2_style_3') : ?>
                        <div class="toolest-thumb p-relative">
                            <?php if(!empty($tp_image)) : ?>
                            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                            <?php endif; ?>
                            <div class="toolest-three-shape">

                                <?php if(!empty($tp_image2)) : ?>
                                <div class="toolest-three-shape-one d-none d-md-block">
                                    <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($tp_image3)) : ?>
                                <div class="toolest-three-shape-two">
                                    <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($tp_image4)) : ?>
                                <div class="toolest-shape-four d-none d-lg-block">
                                    <img src="<?php echo esc_url($tp_image4); ?>" alt="<?php echo esc_attr($tp_image_alt4); ?>">
                                </div>
                                <?php endif; ?>
                                <div class="toolest-shape-five">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/tool-dots.png" alt="">
                                </div>
                            </div>
                        </div>
                        <?php elseif($item['repeater_condition'] == 'l2_style_4') : ?>
                        <div class="toolest-thumb p-relative">
                            <?php if(!empty($tp_image)) : ?>
                            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                            <?php endif; ?>
                            <div class="toolest-four-shape">

                                <?php if(!empty($tp_image2)) : ?>
                                <div class="toolest-four-shape-one">
                                    <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($tp_image3)) : ?>
                                <div class="toolest-four-shape-two d-none d-md-block">
                                    <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                </div>
                                <?php endif; ?>

                                <?php if(!empty($tp_image4)) : ?>
                                <div class="toolest-four-shape-three">
                                    <img src="<?php echo esc_url($tp_image4); ?>" alt="<?php echo esc_attr($tp_image_alt4); ?>">
                                </div>
                                <?php endif; ?>

                                <div class="toolest-shape-four d-none d-lg-block">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/tool-overly.png" alt="">
                                </div>
                                
                                <?php if(!empty($tp_image5)) : ?>
                                <div class="toolest-shape-five">
                                    <img src="<?php echo esc_url($tp_image5); ?>" alt="<?php echo esc_attr($tp_image_alt5); ?>">
                                </div>
                                <?php endif; ?>
                                
                                <?php if(!empty($tp_image6)) : ?>
                                <div class="toolest-four-shape-six">
                                    <img src="<?php echo esc_url($tp_image6); ?>" alt="<?php echo esc_attr($tp_image_alt6); ?>">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="nav flex-column tp-gradient-tab-btn nav-pills me-3" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">

                    <?php foreach($settings['tp_service_list'] as $key => $item) : 
                        $active = $item['tp_tab_active'] ? 'active' : NULL ;    
                        $aria = $item['tp_tab_active'] ? 'false' : 'true' ;
                        
                        // thumbnail
                        if ( !empty($item['shape_image']['url']) ) {
                            $shape_image = !empty($item['shape_image']['id']) ? wp_get_attachment_image_url( $item['shape_image']['id'], 'full') : $item['shape_image']['url'];
                            $shape_image_alt = get_post_meta($item["shape_image"]["id"], "_wp_attachment_image_alt", true);
                        }
                    ?>
                    <div class="nav-link <?php echo esc_attr($active); ?>" id="v-pills-<?php echo esc_attr($key+1); ?>-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-<?php echo esc_attr($key+1); ?>" role="tab" aria-controls="v-pills-<?php echo esc_attr($key+1); ?>"
                        aria-selected="<?php echo esc_attr($aria); ?>">
                        <div class="tp-accordion-item tp-accordion-item-<?php echo esc_attr($key+1); ?>">
                            <div class="tp-accordion-head">
                                <div class="tp-accordion-icon p-relative">
                                    <?php if(!empty($shape_image)) : ?>
                                    <img src="<?php echo esc_url($shape_image); ?>" alt="<?php echo esc_attr($shape_image_alt); ?>">
                                    <?php endif; ?>
                                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                    <div class="tp-accordion-icon-shape tp-el-rep-icon">
                                        <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                    <div class="tp-accordion-icon-shape tp-el-rep-icon">
                                        <img class="w-100" src="<?php echo $item['tp_box_icon_image']['url']; ?>" alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                    </div>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                    <div class="tp-accordion-icon-shape tp-el-rep-icon"><?php echo $item['tp_box_icon_svg']; ?></div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <span></span>
                                </div>
                                <?php if(!empty($item['tp_tab_title'])) : ?>
                                <div class="tp-accordion-title pl-30">
                                    <h4 class="tp-toolest-title-info tp-el-rep-title"><?php echo tp_kses($item['tp_tab_title']); ?></h4>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if(!empty($item['tp_tab_des'])) : ?>
                            <div class="tp-accordion-content">
                                <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_tab_des']); ?></p>
                            </div>
                            <?php endif; ?>
                            <div class="tp-accordion-progress">
                                <div class="tp-accordion-progress-dark p-relative">
                                    <div class="tp-accordion-progress-active"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php else :
    $this->add_render_attribute('title_args', 'class', 'tpsection-title-white-2 mb-30 tp-el-title');
?>

<section class="services-area theme-bg-4 pb-120 fix tp-el-section">
    <div class="services-bg-wrapper pt-110 pb-20">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="tpsection-wrapper text-center">
                        <?php if ( !empty($settings['tp_services_sub_title']) ) : ?>
                        <p class="text-white tp-el-subtitle"><?php echo tp_kses($settings['tp_services_sub_title']); ?></p>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_services_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_services_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_services_title' ] )
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_services_description']) ) : ?>
                        <span class="text-white tp-el-content"><?php echo tp_kses( $settings['tp_services_description'] ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-3 order-2 order-lg-1 ">
                    <div class="services-nav">
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">

                                <?php foreach($settings['tp_service_list'] as $key => $item) : 
                                    $active = $item['tp_tab_active'] ? 'active' : NULL ;    
                                    $aria = $item['tp_tab_active'] ? 'false' : 'true' ;    
                                ?>
                                <button class="nav-link <?php echo esc_attr($active); ?>"
                                    id="v-pills-<?php echo esc_attr($key+1);  ?>-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-<?php echo esc_attr($key+1);  ?>" type="button" role="tab"
                                    aria-controls="v-pills-<?php echo esc_attr($key+1);  ?>"
                                    aria-selected="<?php echo esc_attr($aria); ?>">

                                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                    <i
                                        class="services-nav-icon mr-10"><?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?></i>
                                    <?php endif; ?>
                                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                    <i class="services-nav-icon mr-10"><img class="w-100"
                                            src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>"></i>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                    <i class="services-nav-icon mr-10"><?php echo $item['tp_box_icon_svg']; ?></i>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(!empty($item['tp_tab_title'])) : ?>
                                    <span class="tp-el-rep-title"><?php echo tp_kses($item['tp_tab_title']); ?></span>
                                    <?php endif; ?>
                                </button>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2 ">
                    <div class="services-tab">
                        <div class="tab-content services-tab-anim" id="v-pills-tabContent">

                            <?php foreach($settings['tp_service_list'] as $key => $item) : 
                                $active_show = $item['tp_tab_active'] ? 'active show' : NULL ;    
                                // Link
                                if ('2' == $item['tp_services_link_type']) {
                                    $link = get_permalink($item['tp_services_page_link']);
                                    $target = '_self';
                                    $rel = 'nofollow';
                                } else {
                                    $link = !empty($item['tp_services_link']['url']) ? $item['tp_services_link']['url'] : '';
                                    $target = !empty($item['tp_services_link']['is_external']) ? '_blank' : '';
                                    $rel = !empty($item['tp_services_link']['nofollow']) ? 'nofollow' : '';
                                } 
                                
                                // thumbnail
                                if ( !empty($item['tp_image']['url']) ) {
                                    $tp_image = !empty($item['tp_image']['id']) ? wp_get_attachment_image_url( $item['tp_image']['id'], $item['tp_image_size']) : $item['tp_image']['url'];
                                    $tp_image_alt = get_post_meta($item["tp_image"]["id"], "_wp_attachment_image_alt", true);
                                }   
                                if ( !empty($item['tp_image2']['url']) ) {
                                    $tp_image2 = !empty($item['tp_image2']['id']) ? wp_get_attachment_image_url( $item['tp_image2']['id'], $item['tp_image_size']) : $item['tp_image2']['url'];
                                    $tp_image_alt2 = get_post_meta($item['tp_image2']["id"], "_wp_attachment_image_alt", true);
                                }  
                                if ( !empty($item['tp_image3']['url']) ) {
                                    $tp_image3 = !empty($item['tp_image3']['id']) ? wp_get_attachment_image_url( $item['tp_image3']['id'], $item['tp_image_size']) : $item['tp_image3']['url'];
                                    $tp_image_alt3 = get_post_meta($item['tp_image3']["id"], "_wp_attachment_image_alt", true);
                                }   
                            ?>
                            <div class="tab-pane fade <?php echo esc_attr($active_show); ?>"
                                id="v-pills-<?php echo esc_attr($key+1); ?>" role="tabpanel"
                                aria-labelledby="v-pills-<?php echo esc_attr($key+1); ?>-tab" tabindex="0">
                                <div class="services-tab-wrapper d-flex align-items-center">
                                    <div class="services-tab-img p-relative">

                                        <div class="services-tab-main-img">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/tab-shape-3.png"
                                                alt="">
                                        </div>

                                        <?php if($item['repeater_condition'] == 'l_style_2') : ?>
                                        <div class="services-tab-one-shape">
                                            <?php if(!empty($tp_image)) : ?>
                                            <div class="services-tab-two-shape-one">
                                                <img src="<?php echo esc_url($tp_image); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($tp_image2)) : ?>
                                            <div class="services-tab-two-shape-two">
                                                <img src="<?php echo esc_url($tp_image2); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <div class="services-tab-two-shape-three d-none d-md-block">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/tab-1-bg-3.png"
                                                    alt="">
                                            </div>
                                            <?php if(!empty($tp_image3)) : ?>
                                            <div class="services-tab-two-shape-four d-none d-md-block">
                                                <img src="<?php echo esc_url($tp_image3); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php elseif($item['repeater_condition'] == 'l_style_3') : ?>
                                        <div class="services-tab-shape services-tab-angle-shape">
                                            <?php if(!empty($tp_image)) : ?>
                                            <div class="services-tab-angle-shape-one">
                                                <img src="<?php echo esc_url($tp_image); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($tp_image2)) : ?>
                                            <div class="services-tab-angle-shape-two">
                                                <img src="<?php echo esc_url($tp_image2); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($tp_image3)) : ?>
                                            <div class="services-tab-angle-shape-three d-none d-md-block">
                                                <img src="<?php echo esc_url($tp_image3); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <div class="services-tab-angle-shape-four d-none d-md-block">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/tab-shape-2.png"
                                                    alt="">
                                            </div>
                                            <div class="services-tab-angle-shape-five d-none d-md-block">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/tab-bg-3.png"
                                                    alt="">
                                            </div>
                                        </div>
                                        <?php elseif($item['repeater_condition'] == 'l_style_4') : ?>
                                        <div class="services-tab-four-shape">
                                            <?php if(!empty($tp_image)) : ?>
                                            <div class="services-tab-four-shape-one">
                                                <img src="<?php echo esc_url($tp_image); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($tp_image2)) : ?>
                                            <div class="services-tab-four-shape-two">
                                                <img src="<?php echo esc_url($tp_image2); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($tp_image3)) : ?>
                                            <div class="services-tab-four-shape-three d-none d-md-block">
                                                <img src="<?php echo esc_url($tp_image3); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <div class="services-tab-four-shape-four d-none d-md-block">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/tab-4-shape--1.png"
                                                    alt="">
                                            </div>
                                        </div>
                                        <?php elseif($item['repeater_condition'] == 'l_style_5') : ?>
                                        <div class="services-tab-five-shape">
                                            <?php if(!empty($tp_image)) : ?>
                                            <div class="services-tab-five-shape-one">
                                                <img src="<?php echo esc_url($tp_image); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($tp_image2)) : ?>
                                            <div class="services-tab-five-shape-two">
                                                <img src="<?php echo esc_url($tp_image2); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <div class="services-tab-five-shape-three d-none d-md-block">
                                                <span>
                                                    <svg width="49" height="111" viewBox="0 0 49 111" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path class="line-dash-path"
                                                            d="M0 1.5H41.5C44.8137 1.5 47.5 4.18629 47.5 7.5V111"
                                                            stroke="white" stroke-opacity="0.5" stroke-width="1.5"
                                                            stroke-dasharray="4 4" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <?php if(!empty($tp_image3)) : ?>
                                            <div class="services-tab-five-shape-four d-none d-md-block">
                                                <img src="<?php echo esc_url($tp_image3); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php elseif($item['repeater_condition'] == 'l_style_1' || $item['repeater_condition'] == 'style_1') : ?>
                                        <div class="services-tab-one-shape">
                                            <?php if(!empty($tp_image)) : ?>
                                            <div class="services-tab-one-shape-one">
                                                <img src="<?php echo esc_url($tp_image); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($tp_image2)) : ?>
                                            <div class="services-tab-one-shape-two">
                                                <img src="<?php echo esc_url($tp_image2); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                            </div>
                                            <?php endif; ?>
                                            <div class="services-tab-one-shape-three d-none d-md-block">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/tab-1-bg-3.png"
                                                    alt="">
                                            </div>
                                            <?php if(!empty($tp_image3)) : ?>
                                            <div class="services-tab-one-shape-four d-none d-md-block">
                                                <img src="<?php echo esc_url($tp_image3); ?>"
                                                    alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>

                                    </div>
                                    <div class="services-tab-content">
                                        <?php if(!empty($item['tp_service_title'])) : ?>
                                        <h4 class="services-tab-title mb-15 tp-el-rep-title">
                                            <?php echo tp_kses($item['tp_service_title']); ?></h4>
                                        <?php endif; ?>
                                        <?php if(!empty($item['tp_service_des'])) : ?>
                                        <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_service_des']); ?></p>
                                        <?php endif; ?>
                                        <?php if(!empty($item['tp_services_btn_text'])) : ?>
                                        <a class="tp-el-rep-btn" href="<?php echo esc_url($link); ?>"
                                            target="<?php echo esc_attr($target); ?>"
                                            rel="<?php echo esc_attr($rel); ?>"
                                            class="radient-btn"><?php echo tp_kses($item['tp_services_btn_text']); ?></a>
                                        <?php endif; ?>
                                    </div>
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

<?php endif; 
    }
}

$widgets_manager->register( new TP_Services_Info_Tab() ); 