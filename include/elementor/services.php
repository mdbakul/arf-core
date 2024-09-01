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
class TP_Services extends Widget_Base {

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
        return 'services';
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
        return __( 'Services', 'tpcore' );
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

        $this->tp_section_title_render_controls('services', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-3', 'layout-5']);

        // Service group
        $this->start_controls_section(
            'tp_services',
            [
                'label' => esc_html__('Services List', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_border',
            [
                'label' => esc_html__( 'Border Active', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
                'condition' => [
                    'tp_design_style' => 'layout-1'
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
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5', 'style_6']
                ]
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
                    'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5', 'style_6']
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
                    'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5', 'style_6']
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
                        'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5', 'style_6']
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
                        'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5', 'style_6']
                    ]
                ]
            );
        }

        $repeater->add_control(
            'tp_rep_shape',
            [
                'label' => esc_html__('Upload Shape Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'repeater_condition' => ['style_3', 'style_5', 'style_6'],
                ]
            ]
        );
        
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tp_rep_shape_size',
                'default' => 'full',
                'exclude' => [
                    'custom'
                ],
                'condition' => [
                    'repeater_condition' => ['style_3', 'style_5', 'style_6']
                ]
            ]
        );

        
        $repeater->add_control(
            'tp_box_bg',
            [
                'label' => esc_html__('Upload Background Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'repeater_condition' => 'style_4'
                ]
            ]
        );
        
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tp_box_bg_size',
                'default' => 'full',
                'exclude' => [
                    'custom'
                ],
                'condition' => [
                    'repeater_condition' => 'style_4',
                ]
            ]
        );

        $repeater->add_control(
            'tp_service_subtitle', [
                'label' => esc_html__('Sub Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Subtitle', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_4']
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
            ]
        );

        $repeater->add_control(
            'tp_service_des', [
                'label' => esc_html__('Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('With SEOMY, you get everything you need for a fast website', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_2', 'style_3', 'style_5', 'style_6', 'style_7']
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
            ]
        );
        
        $repeater->add_control(
            'tp_service_btn_text', [
                'label' => esc_html__('Button Text', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_2', 'style_3', 'style_4', 'style_5', 'style_7'],
                    'tp_services_link_switcher' => 'yes'
                ]
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
                    'tp_services_link_switcher' => 'yes'
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
                ]
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
                        'tp_service_title' => esc_html__('Business Stratagy', 'tpcore'),
                    ],
                    [
                        'tp_service_title' => esc_html__('Website Development', 'tpcore')
                    ],
                    [
                        'tp_service_title' => esc_html__('Marketing & Reporting', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_service_title }}}',
            ]
        );
        
        $this->end_controls_section();

        // section column
        $this->tp_columns('col', ['layout-2', 'layout-3', 'layout-5', 'layout-6', 'layout-7']);

    }

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('services_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle',[ 'layout-1', 'layout-3', 'layout-5']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title',[ 'layout-1', 'layout-3', 'layout-5']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content',[ 'layout-1', 'layout-3', 'layout-5']);

        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', ['layout-1', 'layout-2', 'layout-3', 'layout-5', 'layout-6']);
        $this->tp_basic_style_controls('rep_subtitle_style', 'Repeater Subtitle', '.tp-el-rep-subtitle', ['layout-1', 'layout-4']);
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_basic_style_controls('rep_des_style', 'Repeater Description', '.tp-el-rep-des', ['layout-2', 'layout-3', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_link_controls_style('rep_btn_style', 'Repeater Button', '.tp-el-rep-btn', ['layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
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


<div class="container tp-el-section">
    <div class="row">


        <?php foreach ($settings['tp_service_list'] as $key => $item) :
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
    ?>
        <div
            class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
            <div class="tpseo p-relative mb-40">
                <div class="tpseo-bg tpseo-bg<?php echo esc_attr($key+1); ?>"></div>
                <div class="tpseo-content">
                    <?php if (!empty($item['tp_service_title' ])): ?>
                    <h4 class="tpseo-title mb-15 tp-el-rep-title">
                        <?php if ($item['tp_services_link_switcher'] == 'yes') : ?>
                        <a href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_service_title' ]); ?></a>
                        <?php else : ?>
                        <?php echo tp_kses($item['tp_service_title' ]); ?>
                        <?php endif; ?>
                    </h4>
                    <?php endif; ?>
                    <div class="tpseo-info">
                        <?php if(!empty($item['tp_service_des'])) : ?>
                        <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_service_des']); ?></p>
                        <?php endif; ?>
                        <?php if(!empty($link)) : ?>
                        <div class="tpseo-details">
                            <a class="tp-el-rep-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
                                rel="<?php echo esc_attr($rel); ?>"><?php echo tp_kses($item['tp_service_btn_text']); ?>
                                <i class="fa-light fa-arrow-right"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                <div class="tpseo-thumb w-img tp-el-rep-icon">
                    <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                </div>
                <?php endif; ?>
                <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                <div class="tpseo-thumb w-img tp-el-rep-icon">
                    <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                        alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                </div>
                <?php endif; ?>
                <?php else : ?>
                <?php if (!empty($item['tp_box_icon_svg'])): ?>
                <div class="tpseo-thumb w-img tp-el-rep-icon">
                    <?php echo $item['tp_box_icon_svg']; ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : 
    $this->add_render_attribute('title_args', 'class', 'section-title-4 tp-el-title');
?>


<section class="services-area pb-120 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-wrapper text-center mb-60">
                    <?php if ( !empty($settings['tp_services_sub_title']) ) : ?>
                    <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_services_sub_title']); ?></span>
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
                </div>
            </div>
        </div>
        <div class="row">

            <?php foreach ($settings['tp_service_list'] as $key => $item) :
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
                if ( !empty($item['tp_rep_shape']['url']) ) {
                    $tp_rep_shape = !empty($item['tp_rep_shape']['id']) ? wp_get_attachment_image_url( $item['tp_rep_shape']['id'], $item['tp_rep_shape_size_size']) : $item['tp_rep_shape']['url'];
                    $tp_rep_shape_alt = get_post_meta($item["tp_rep_shape"]["id"], "_wp_attachment_image_alt", true);
                }
            ?>
            <div
                class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
                <div class="services-item-4 text-center mb-55">
                    <div class="services-icon-4 mb-30">
                        <?php if(!empty($tp_rep_shape)) : ?>
                        <img src="<?php echo esc_url($tp_rep_shape); ?>"
                            alt="<?php echo esc_attr($tp_rep_shape_alt); ?>">
                        <?php endif; ?>

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
                    </div>
                    <div class="services-content-4">

                        <?php if (!empty($item['tp_service_title' ])): ?>
                        <h5 class="title mb-20 tp-el-rep-title"><?php echo tp_kses($item['tp_service_title' ]); ?></h5>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_service_des'])) : ?>
                        <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_service_des']); ?></p>
                        <?php endif; ?>

                        <?php if(!empty($item['tp_service_btn_text'])) : ?>
                        <div class="services-btn-4 p-relative">
                            <a class="tp-el-rep-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
                                rel="<?php echo esc_attr($rel); ?>">
                                <span><?php echo tp_kses($item['tp_service_btn_text']); ?></span>
                                <i>
                                    <svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.2871 1L17 6.71285L11.2871 12.4257" stroke="currentColor"
                                            stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M1 6.71313H16.8397" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </i>
                            </a>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="services-bottom text-center">
                    <div class="servics-details-4 d-flex align-items-center justify-content-center">
                        <?php if ( !empty($settings['tp_services_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_services_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-4' ) : 
    $this->add_render_attribute('title_args', 'class', 'section-title-4');
?>

<div class="protfolio-wrapper-4 portfolio-4-active tp-el-section">

    <?php foreach ($settings['tp_service_list'] as $key => $item) :
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
        // background image
        if ( !empty($item['tp_box_bg']['url']) ) {
            $tp_box_bg = !empty($item['tp_box_bg']['id']) ? wp_get_attachment_image_url( $item['tp_box_bg']['id'], $item['tp_box_bg_size_size']) : $item['tp_box_bg']['url'];
            $tp_box_bg_alt = get_post_meta($item["tp_box_bg"]["id"], "_wp_attachment_image_alt", true);
        }
    ?>
    <div class="portfolio-4-item-single">
        <div class="portfolio-4-item p-relative">
            <?php if(!empty($tp_box_bg)) : ?>
            <div class="portfolio-4-thumb">
                <img src="<?php echo esc_url($tp_box_bg); ?>" alt="<?php echo esc_attr($tp_box_bg_alt); ?>">
            </div>
            <?php endif; ?>
            <div class="portfolio-4-content">
                <div class="portfolio-4-content-top">
                    <?php if (!empty($item['tp_service_subtitle' ])): ?>
                    <span class="tp-el-rep-subtitle"><?php echo tp_kses($item['tp_service_subtitle' ]); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($item['tp_service_title' ])): ?>
                    <h4 class="title tp-el-rep-title"><?php echo tp_kses($item['tp_service_title' ]); ?></h4>
                    <?php endif; ?>
                </div>
                <?php if(!empty($item['tp_service_btn_text'])) : ?>
                <div class="portfolio-4-content-bottom">
                    <a class="tp-el-rep-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
                        rel="<?php echo esc_attr($rel); ?>"><?php echo tp_kses($item['tp_service_btn_text']); ?> <i
                            class="fa-light fa-plus"></i></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-5' ) : 
    $this->add_render_attribute('title_args', 'class', 'section-title-4 fs-54 tp-el-title');
?>

<section class="services-area pb-120 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="optimize-subtitle text-center mb-50">
                    <?php if(!empty($settings['tp_services_sub_title'])) : ?>
                    <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_services_sub_title']); ?></span>
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

            <?php foreach ($settings['tp_service_list'] as $key => $item) :
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
                if ( !empty($item['tp_rep_shape']['url']) ) {
                    $tp_rep_shape = !empty($item['tp_rep_shape']['id']) ? wp_get_attachment_image_url( $item['tp_rep_shape']['id'], $item['tp_rep_shape_size_size']) : $item['tp_rep_shape']['url'];
                    $tp_rep_shape_alt = get_post_meta($item["tp_rep_shape"]["id"], "_wp_attachment_image_alt", true);
                }
            ?>
            <div
                class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
                <div class="services-item-4 text-center mb-55">
                    <div class="services-icon-4 mb-30">
                        <?php if(!empty($tp_rep_shape)) : ?>
                        <img src="<?php echo esc_url($tp_rep_shape); ?>"
                            alt="<?php echo esc_attr($tp_rep_shape_alt); ?>">
                        <?php endif; ?>

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
                    </div>
                    <div class="services-content-4">

                        <?php if (!empty($item['tp_service_title' ])): ?>
                        <h5 class="title mb-20 tp-el-rep-title"><?php echo tp_kses($item['tp_service_title' ]); ?></h5>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_service_des'])) : ?>
                        <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_service_des']); ?></p>
                        <?php endif; ?>

                        <?php if(!empty($item['tp_service_btn_text'])) : ?>
                        <div class="services-inner-btn p-relative">
                            <a class="tp-el-rep-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
                                rel="<?php echo esc_attr($rel); ?>">
                                <?php echo tp_kses($item['tp_service_btn_text']); ?>
                                <span>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6H11" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M6 1L11 6L6 11" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-6' ) : 
    $this->add_render_attribute('title_args', 'class', 'section-title-4');
?>

<section class="service-layout-6 tp-el-section">
    <div class="container">
        <div class="row">

            <?php foreach ($settings['tp_service_list'] as $key => $item) :
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
                if ( !empty($item['tp_rep_shape']['url']) ) {
                    $tp_rep_shape = !empty($item['tp_rep_shape']['id']) ? wp_get_attachment_image_url( $item['tp_rep_shape']['id'], $item['tp_rep_shape_size_size']) : $item['tp_rep_shape']['url'];
                    $tp_rep_shape_alt = get_post_meta($item["tp_rep_shape"]["id"], "_wp_attachment_image_alt", true);
                }
            ?>
            <div
                class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
                <div class="services-inner-item mb-30">
                    <div class="services-inner-content">

                        <?php if (!empty($item['tp_service_title' ])): ?>
                        <h4 class="services-inner-title tp-el-rep-title">
                            <?php if ($item['tp_services_link_switcher'] == 'yes') : ?>
                            <a href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_service_title' ]); ?></a>
                            <?php else : ?>
                            <?php echo tp_kses($item['tp_service_title' ]); ?>
                            <?php endif; ?>
                        </h4>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_service_des'])) : ?>
                        <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_service_des']); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                    <div class="services-inner-thumb tp-el-rep-icon">
                        <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                    </div>
                    <?php endif; ?>
                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                    <div class="services-inner-thumb tp-el-rep-icon">
                        <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                    </div>
                    <?php endif; ?>
                    <?php else : ?>
                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                    <div class="services-inner-thumb tp-el-rep-icon">
                        <?php echo $item['tp_box_icon_svg']; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(!empty($tp_rep_shape)) : ?>
                    <div class="services-inner-shape-1">
                        <img src="<?php echo esc_url($tp_rep_shape); ?>"
                            alt="<?php echo esc_attr($tp_rep_shape_alt); ?>">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-7' ) : 
    $this->add_render_attribute('title_args', 'class', 'section-title-4');
?>

<section class="services-area tp-el-section">
    <div class="container">
        <div class="row">
            <?php foreach ($settings['tp_service_list'] as $key => $item) :
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
            ?>
            <div
                class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
                <div class="services-inner-2 mb-30">
                    <div class="services-inner-2-content text-center">
                        <?php if (!empty($item['tp_service_title' ])): ?>
                        <h4 class="services-inner-2-title tp-el-rep-title"><?php echo tp_kses($item['tp_service_title' ]); ?></h4>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_service_des'])) : ?>
                        <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_service_des']); ?></p>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_service_btn_text'])) : ?>
                        <a class="tp-el-rep-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
                            rel="<?php echo esc_attr($rel); ?>"><?php echo tp_kses($item['tp_service_btn_text']); ?>
                            <span>
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6 1L11 6L6 11" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php else:
    $this->add_render_attribute('title_args', 'class', 'tpsection__title mb-15 tp-el-title');
?>

<section class="services-area pb-110 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tpsection__content text-center mb-70">
                    <?php if ( !empty($settings['tp_services_sub_title']) ) : ?>
                    <div class="tpbanner__sub-title mb-15">
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_services_sub_title']); ?></span>
                        <i>
                            <svg width="126" height="37" viewBox="0 0 126 37" fill="none"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="126" height="37" fill="url(#pattern4)" fill-opacity="0.08"></rect>
                                <defs>
                                    <pattern id="pattern4" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_859_2751"
                                            transform="translate(-0.0507936) scale(0.00603175 0.0205405)"></use>
                                    </pattern>
                                    <image id="image0_859_2751" width="180" height="50"
                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==">
                                    </image>
                                </defs>
                            </svg>
                        </i>
                    </div>
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
                <div class="tpservices">
                    <div class="tpservices-list">
                        <ul>
                            <?php foreach ($settings['tp_service_list'] as $key => $item) :
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
                            ?>
                            <li class="<?php echo $settings['tp_border'] ? NULL : 'border-0' ; ?>">
                                <div class="tpservices-wrapper tpservices-item<?php echo esc_attr($key+1); ?>">

                                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                    <div class="tpservices-img mb-35 tp-el-rep-icon">
                                        <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                    <div class="tpservices-img mb-35 tp-el-rep-icon">
                                        <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                    </div>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                    <div class="tpservices-img mb-35 tp-el-rep-icon">
                                        <?php echo $item['tp_box_icon_svg']; ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                    <div class="tpservices-content">
                                        <?php if(!empty($item['tp_service_subtitle'])) : ?>
                                        <span class="tp-el-rep-subtitle"><?php echo tp_kses($item['tp_service_subtitle']); ?></span>
                                        <?php endif; ?>

                                        <?php if (!empty($item['tp_service_title' ])): ?>
                                        <h4 class="tpservices-title tp-el-rep-title">
                                            <?php if ($item['tp_services_link_switcher'] == 'yes') : ?>
                                            <a href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_service_title' ]); ?></a>
                                            <?php else : ?>
                                            <?php echo tp_kses($item['tp_service_title' ]); ?>
                                            <?php endif; ?>
                                        </h4>
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

$widgets_manager->register( new TP_Services() ); 