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
class TP_Server_Score extends Widget_Base {

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
        return 'tp-server-score';
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
        return __( 'Server Score', 'tpcore' );
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
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // Heading
        $this->start_controls_section(
            'tp_heading_sec',
            [
                'label' => esc_html__('Heading', 'tp-core'),
            ]
        );

        $this->add_control(
            'tp_heading1', [
                'label' => esc_html__('Heading Title 1', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Blank Link', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tp_heading2', [
                'label' => esc_html__('Heading Title 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Score', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tp_heading3', [
                'label' => esc_html__('Heading Title 3', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Keyword', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tp_heading4', [
                'label' => esc_html__('Heading Title 4', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Domain', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tp_heading5', [
                'label' => esc_html__('Heading Title 5', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Type', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // Service group
        $this->start_controls_section(
            'tp_scores',
            [
                'label' => esc_html__('Server Score List', 'tpcore'),
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
                    'l1_style_2' => __( 'Layout 1 Style 2', 'tpcore' ),
                ],
                'default' => 'style_1',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_score_title1', [
                'label' => esc_html__('Score Title 1', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 1', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_score_title2', [
                'label' => esc_html__('Score Title 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 2', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_score_title3', [
                'label' => esc_html__('Score Title 3', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 3', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_score_title4', [
                'label' => esc_html__('Score Title 4', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 4', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_score_title5', [
                'label' => esc_html__('Score Title 5', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 5', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => 'style_1'
                ]
            ]
        );
        
        $repeater->add_control(
            'tp_rank', [
                'label' => esc_html__('Rank Position', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('1', 'tpcore'),
                'condition' => [
                    'repeater_condition' => 'l1_style_2'
                ]
            ]
        );

        $repeater->add_control(
            'tp_visitor', [
                'label' => esc_html__('Visitors', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('3', 'tpcore'),
                'condition' => [
                    'repeater_condition' => 'l1_style_2'
                ]
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
                'condition' => [
                    'repeater_condition' => 'l1_style_2'
                ]
            ]
        );

        $repeater->add_control(
            'tp_scores_link_switcher',
            [
                'label' => esc_html__( 'Add Server Score Link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        
        $repeater->add_control(
            'tp_score_btn_text', [
                'label' => esc_html__('Button Text', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'tp_scores_link_switcher' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'tp_scores_link_type',
            [
                'label' => esc_html__( 'Score Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_scores_link_switcher' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'tp_scores_link',
            [
                'label' => esc_html__( 'Score Link link', 'tpcore' ),
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
                    'tp_scores_link_type' => '1',
                    'tp_scores_link_switcher' => 'yes',
                ]
            ]
        );
        $repeater->add_control(
            'tp_scores_page_link',
            [
                'label' => esc_html__( 'Select Score Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_scores_link_type' => '2',
                    'tp_scores_link_switcher' => 'yes',
                ]
            ]
        );
        
        $this->add_control(
            'tp_score_list',
            [
                'label' => esc_html__('Server Score - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_score_title1' => esc_html__('Business Stratagy', 'tpcore'),
                    ],
                    [
                        'tp_score_title1' => esc_html__('Website Development', 'tpcore')
                    ],
                    [
                        'tp_score_title1' => esc_html__('Marketing & Reporting', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_score_title1 }}}',
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
        
        $this->end_controls_section();

    }

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('services_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_heading', 'Heading', '.tp-el-heading', 'layout-1');
        $this->tp_basic_style_controls('list_title', 'List Title', '.tp-el-list-title', 'layout-1');
        $this->tp_link_controls_style('list_btn', 'List Button', '.tp-el-list-btn', 'layout-1');
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
    $this->add_render_attribute('title_args', 'class', 'tpsection__title mb-15');
?>

<div class="services-seo p-relative mt-20 tp-el-section">
    <div class="services-seo-scroll">
        <div class="services-seo-head">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-5">
                    <?php if(!empty($settings['tp_heading1'])) : ?>
                    <div class="services-seo-heading">
                        <h4 class="services-seo-heading-title">
                            <input id="remeber" type="checkbox">
                            <label for="remeber" class="tp-el-heading"><?php echo tp_kses($settings['tp_heading1']); ?></label>
                        </h4>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-xl-8 col-lg-7 col-7">
                    <div class="services-seo-catagory">
                        <div class="row">
                            <div class="col-lg-3 col-3">
                                <?php if(!empty($settings['tp_heading2'])) : ?>
                                <div class="services-seo-heading-item services-seo-catagory-one">
                                    <span class="tp-el-heading"><?php echo tp_kses($settings['tp_heading2']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-3 col-3">
                                <?php if(!empty($settings['tp_heading3'])) : ?>
                                <div class="services-seo-heading-item services-seo-catagory-two">
                                    <span class="tp-el-heading"><?php echo tp_kses($settings['tp_heading3']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-3 col-3">
                                <?php if(!empty($settings['tp_heading4'])) : ?>
                                <div class="services-seo-heading-item services-seo-catagory-three">
                                    <span class="tp-el-heading"><?php echo tp_kses($settings['tp_heading4']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-3 col-3">
                                <?php if(!empty($settings['tp_heading5'])) : ?>
                                <div class="services-seo-heading-item services-seo-catagory-four">
                                    <span class="tp-el-heading"><?php echo tp_kses($settings['tp_heading5']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="services-seo-info">

            <?php foreach($settings['tp_score_list'] as $key => $item) :
                // Link
                if ('2' == $item['tp_scores_link_type']) {
                    $link = get_permalink($item['tp_scores_page_link']);
                    $target = '_self';
                    $rel = 'nofollow';
                } else {
                    $link = !empty($item['tp_scores_link']['url']) ? $item['tp_scores_link']['url'] : '';
                    $target = !empty($item['tp_scores_link']['is_external']) ? '_blank' : '';
                    $rel = !empty($item['tp_scores_link']['nofollow']) ? 'nofollow' : '';
                }    
            ?>
            <div class="services-seo-item">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-5 col-5">
                        <div class="services-seo-link d-flex">
                            <div class="services-seo-link-check">
                                <?php if(!empty($item['tp_score_title1'])) : ?>
                                <input id="seo-link-check-<?php echo esc_attr($key+1); ?>" type="checkbox">
                                <label for="seo-link-check-<?php echo esc_attr($key+1); ?>" class="tp-el-list-title"><?php echo tp_kses($item['tp_score_title1']); ?></label>
                                <?php endif; ?>
                                <?php if(!empty($item['tp_score_btn_text'])) : ?>
                                <span><a class="tp-el-list-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" rel="<?php echo esc_attr($rel); ?>"><?php echo tp_kses($item['tp_score_btn_text']); ?></a></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 col-7">
                        <div class="services-seo-catagory">
                            <div class="row">
                                <div class="col-lg-3 col-3">
                                    <?php if(!empty($item['tp_score_title2'])) : ?>
                                    <div class="services-seo-catagory-item services-seo-catagory-one">
                                        <span class="tp-el-list-title"><?php echo tp_kses($item['tp_score_title2']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 col-3">
                                    <?php if(!empty($item['tp_score_title3'])) : ?>
                                    <div class="services-seo-catagory-item services-seo-catagory-two">
                                        <span class="tp-el-list-title"><?php echo tp_kses($item['tp_score_title3']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 col-3">
                                    <?php if(!empty($item['tp_score_title4'])) : ?>
                                    <div class="services-seo-catagory-item services-seo-catagory-three">
                                        <span class="tp-el-list-title"><?php echo tp_kses($item['tp_score_title4']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 col-3">
                                    <?php if($item['repeater_condition'] == 'style_1') : ?>
                                    <?php if(!empty($item['tp_score_title5'])) : ?>
                                    <div class="services-seo-catagory-item services-seo-catagory-four tp-el-list-title">
                                        <?php echo tp_kses($item['tp_score_title5']); ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php elseif($item['repeater_condition'] == 'l1_style_2') : ?>

                                    <div class="services-seo-catagory-item services-seo-catagory-four d-flex align-items-center">
                                        <div class="stable-rank"><span><?php echo strlen($item['tp_rank']) >= 1 ? tp_kses($item['tp_rank']) : NULL; ?></span></div>

                                        <?php if(empty($item['tp_visitor'])) : ?>
                                        <div class="incridable-rank">
                                            <i>
                                                <svg width="6" height="6" viewBox="0 0 6 6" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="3" cy="3" r="3" fill="#D9D9D9" />
                                                </svg>
                                            </i>
                                        </div>
                                        <?php elseif($item['tp_visi_status'] == 'up') : ?>
                                        <div class="incridable-rank">
                                            <i>
                                                <svg width="10" height="5" viewBox="0 0 10 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                    d="M10 5L5.70711 0.707108C5.31658 0.316583 4.68342 0.316583 4.29289 0.707107L0 5"
                                                    fill="#0DC167" />
                                                </svg>
                                            </i>
                                            <?php if(!empty($item['tp_visitor'])) : ?>
                                            <span><?php echo tp_kses($item['tp_visitor']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php elseif($item['tp_visi_status'] == 'down') : ?>
                                        <div class="incridable-rank incridable-rank-y">
                                            <i>
                                                <svg width="10" height="5" viewBox="0 0 10 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                    d="M10 5L5.70711 0.707108C5.31658 0.316583 4.68342 0.316583 4.29289 0.707107L0 5"
                                                    fill="#FFB72E" />
                                                </svg>
                                            </i>
                                            <?php if(!empty($item['tp_visitor'])) : ?>
                                            <span><?php echo tp_kses($item['tp_visitor']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                            
                                        <?php endif; ?>

                                    </div>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
    <?php if(!empty($settings['tp_shape_switch'])) : ?>
    <div class="analysis-chart-shape-wrap">
        <div class="analysis-chart-shape-1  d-none d-md-block">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/services/analysis/analysis-dots.png" alt="">
        </div>
        <div class="analysis-chart-shape-2">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/services/analysis/analysis-round.png" alt="">
        </div>
        <div class="analysis-chart-shape-3 d-none d-md-block">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/services/analysis/analysis-round-2.png" alt="">
        </div>
        <div class="analysis-chart-shape-4 wow bounceIn" data-wow-duration=".4s" data-wow-delay=".6s">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/services/analysis/analysis-line-1.png" alt="">
        </div>
        <div class="analysis-chart-shape-5 wow bounceIn" data-wow-duration=".4s" data-wow-delay=".4s">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/services/analysis/analysis-line-2.png" alt="">
        </div>
        <div class="analysis-chart-shape-6 wow bounceIn" data-wow-duration=".4s" data-wow-delay=".6s">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/services/analysis/analysis-line-3.png" alt="">
        </div>
    </div>
    <?php endif; ?>
</div>


<?php endif; 
    }
}

$widgets_manager->register( new TP_Server_Score() ); 