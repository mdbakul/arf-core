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
class TP_Comparison_Features extends Widget_Base {

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
        return 'tp-comparison-features';
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
        return __( 'Comparison Features', 'tpcore' );
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
            'tp_heading', [
                'label' => esc_html__('Heading Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Blank Link', 'tpcore'),
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        // features group
        $this->start_controls_section(
            'tp_features',
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
                ],
                'default' => 'style_1',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_features_title1', [
                'label' => esc_html__('Score Title 1', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 1', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_features_tooltip', [
                'label' => esc_html__('Tooltip Text', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Add gradient heading, button, pricing.', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_features_title2', [
                'label' => esc_html__('Score Title 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 2', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_features_title3', [
                'label' => esc_html__('Score Title 3', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 3', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_features_title4', [
                'label' => esc_html__('Score Title 4', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title 4', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'tp_features_list',
            [
                'label' => esc_html__('Server Score - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_features_title1' => esc_html__('Business Stratagy', 'tpcore'),
                    ],
                    [
                        'tp_features_title1' => esc_html__('Website Development', 'tpcore')
                    ],
                    [
                        'tp_features_title1' => esc_html__('Marketing & Reporting', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_features_title1 }}}',
            ]
        );
        
        $this->end_controls_section();

    }

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('features_section', 'Section - Style', '.tp-el-section');
        $this->start_controls_section(
            'tp_additional_styling',
            [
                'label' => esc_html__('Additional Style', 'tp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'dot_color',
			[
				'label' => esc_html__( 'Dot Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-title span' => 'background: {{VALUE}}',
				],
			]
		);
        $this->add_control(
			'dot_before',
			[
				'label' => esc_html__( 'Dot Before Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-title span::before' => 'background: {{VALUE}}',
				],
			]
		);
        $this->end_controls_section();
        $this->tp_link_controls_style('feature_title', 'Section - Title', '.tp-el-title');
        # repeater
        $this->tp_link_controls_style('score_head', 'Repeater Score Heading', '.tp-el-rep-head');
        $this->tp_link_controls_style('score_title', 'Repeater Score Title', '.tp-el-rep-title');
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

<section class="comparison-area tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if(!empty($settings['tp_heading'])) : ?>
                <div class="pricing-comparison-tag">
                    <h5 class="pricing-comparison-tag-title tp-el-title"><span></span><?php echo tp_kses($settings['tp_heading']); ?></h5>
                </div>
                <?php endif; ?>

                <div class="pricing-comparison mb-35">
                    <div class="pricing-comparison-scroll">

                        <?php foreach($settings['tp_features_list'] as $key => $item) :?>
                        <div class="pricing-comparison-item">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-4">
                                    <div class="pricing-comparison-item-text d-flex align-items-center">
                                        <?php if(!empty($item['tp_features_title1'])) : ?>
                                        <h4 class="pricing-comparison-item-title tp-el-rep-head"><?php echo tp_kses($item['tp_features_title1']); ?></h4>
                                        <?php endif; ?>
                                        <?php if(!empty($item['tp_features_tooltip'])) : ?>
                                        <div class="pricing-feature-info">
                                            <span>
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.2"
                                                        d="M7 0.5C10.5761 0.5 13.5 3.42386 13.5 7C13.5 10.5761 10.5761 13.5 7 13.5C3.42386 13.5 0.5 10.5761 0.5 7C0.5 3.42386 3.42386 0.5 7 0.5Z"
                                                        stroke="#010F1C" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M7 9.59998V6.59998" stroke="#3A3A42" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M6.99609 4.59998H7.00148" stroke="#3A3A42"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <div class="pricing-feature-info-tooltip">
                                                <p><?php echo tp_kses($item['tp_features_tooltip']); ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-8">
                                    <div class="pricing-comparison-price text-center">
                                        <div class="row">
                                            <div class="col-lg-4 col-4">
                                                <?php if(!empty($item['tp_features_title2'])) : ?>
                                                <div class="pricing-comparison-price-item pricing-comparison-price-item-1">
                                                    <span class="tp-el-rep-title"><?php echo tp_kses($item['tp_features_title2']); ?></span>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-lg-4 col-4">
                                                <?php if(!empty($item['tp_features_title3'])) : ?>
                                                <div class="pricing-comparison-price-item pricing-comparison-price-item-2">
                                                    <span class="tp-el-rep-title"><?php echo tp_kses($item['tp_features_title3']); ?></span>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-lg-4 col-4">
                                                <?php if(!empty($item['tp_features_title4'])) : ?>
                                                <div class="pricing-comparison-price-item pricing-comparison-price-item-3">
                                                    <span class="tp-el-rep-title"><?php echo tp_kses($item['tp_features_title4']); ?></span>
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
            </div>
        </div>
    </div>
</section>


<?php endif; 
    }
}

$widgets_manager->register( new TP_Comparison_Features() ); 