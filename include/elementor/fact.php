<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;

use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;
use TPCore\Elementor\Controls\Group_Control_TPBGGradient;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Fact extends Widget_Base {

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
		return 'tp-fact';
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
		return __( 'Fact', 'tpcore' );
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
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // fact group
        $this->start_controls_section(
            'tp_fact',
            [
                'label' => esc_html__('Fact List', 'tpcore'),
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
                    'style_2' => __( 'Style 2', 'tpcore' ),
                    'style_3' => __( 'Style 3', 'tpcore' ),
                    'style_4' => __( 'Style 4', 'tpcore' ),
                    'style_5' => __( 'Style 5', 'tpcore' ),
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
                    'repeater_condition' => ['style_2', 'style_3', 'style_4', 'style_5']
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
                    'repeater_condition' => ['style_2', 'style_3', 'style_4', 'style_5']
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
                    'repeater_condition' => ['style_2', 'style_3', 'style_4', 'style_5']
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
                        'repeater_condition' => ['style_2', 'style_3', 'style_4', 'style_5']
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
                        'repeater_condition' => ['style_2', 'style_3', 'style_4', 'style_5']
                    ]
                ]
            );
        }

        $repeater->add_control(
            'tp_fact_number', [
                'label' => esc_html__('Number', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('17', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_fact_after',
            [
                'label' => esc_html__('After Content', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'repeater_condition' => ['style_2', 'style_3', 'style_4', 'style_5']
                ]
            ]
        );

        $repeater->add_control(
            'tp_border_percentage',
            [
                'label' => esc_html__('Bottom Border Percentage', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'default' => esc_html__('60', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'repeater_condition' => 'style_4'
                ]
            ]
        );

        $repeater->add_control(
            'tp_fact_title',
            [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Food', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'tp_fact_list',
            [
                'label' => esc_html__('Fact - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_fact_number' => esc_html__('600', 'tpcore'),
                        'tp_fact_title' => esc_html__('Business', 'tpcore'),
                    ],
                    [
                        'tp_fact_number' => esc_html__('700', 'tpcore'),
                        'tp_fact_title' => esc_html__('Website', 'tpcore')
                    ],
                    [
                        'tp_fact_number' => esc_html__('800', 'tpcore'),
                        'tp_fact_title' => esc_html__('Marketing', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_fact_title }}}',
            ]
        );
        $this->end_controls_section();

        // section column
        $this->tp_columns('col', ['layout-1', 'layout-2', 'layout-5']);

	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('fact_section', 'Section - Style', '.tp-el-section');
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', ['layout-2', 'layout-3', 'layout-4', 'layout-5']);
        $this->tp_link_controls_style('rep_num_style', 'Repeater Number', '.tp-el-rep-num', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5']);
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5']);
        $this->tp_progressbar_style_controls('rep_progress_style', 'Repeater Progressbar', '.tp-el-rep-progress', 'layout-4');
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

<?php if ( $settings['tp_design_style']  == 'layout-2' ): ?>


<div class="container tp-el-section">
    <div class="row">

        <?php foreach ($settings['tp_fact_list'] as $key => $item) : 
        $key +=1;
        
        $count = count($settings['tp_fact_list']);

        $lastClass = $key == $count ? 'justify-content-end' : NULL; 
    ?>
        <div class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
            <div class="funfact d-flex align-items-start mb-30 <?php echo esc_attr($lastClass); ?>">
                <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                <div class="funfact-icon tp-el-rep-icon">
                    <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                </div>
                <?php endif; ?>
                <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                <div class="funfact-icon tp-el-rep-icon">
                    <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                        alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                </div>
                <?php endif; ?>
                <?php else : ?>
                <?php if (!empty($item['tp_box_icon_svg'])): ?>
                <div class="funfact-icon tp-el-rep-icon">
                    <?php echo $item['tp_box_icon_svg']; ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <div class="funfact-content">
                    <h3 class="funfact-count tp-el-rep-num">
                        <span data-purecounter-duration="1"
                            data-purecounter-end="<?php echo esc_attr($item['tp_fact_number']); ?>"
                            class="purecounter"></span>
                        <?php echo $item['tp_fact_after'] ? tp_kses($item['tp_fact_after']) : NULL; ?>
                    </h3>
                    <?php if(!empty($item['tp_fact_title'])) : ?>
                    <p class="tp-el-rep-title"><?php echo tp_kses($item['tp_fact_title']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ): ?>

<section class="counter-area pb-140 tp-el-section">
    <div class="container">
        <div class="counter-bg-4 p-relative fix  tp-el-section">
            <div class="counter-shape-4  d-none d-md-block">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/counter-shape-4-1.png" alt=""
                    class="counter-shape-4-1">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/counter-shape-4-2.png" alt=""
                    class="counter-shape-4-2">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/counter-shape-4-3.png" alt=""
                    class="counter-shape-4-3">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/counter-shape-4-4.png" alt=""
                    class="counter-shape-4-4">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/counter-shape-4-5.png" alt=""
                    class="counter-shape-4-5">
            </div>
            <div class="counter-wrapper d-flex align-items-center justify-content-between">

                <?php foreach ($settings['tp_fact_list'] as $key => $item) : ?>
                <div class="counter-item-4 d-flex">
                    <div class="counter-item-4-icon">
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
                    <div class="counter-item-4-content">
                        <h3 class="counter-item-4-count tp-el-rep-num">
                            <span data-purecounter-duration="1"
                                data-purecounter-end="<?php echo esc_attr($item['tp_fact_number']); ?>"
                                class="purecounter"></span><?php echo $item['tp_fact_after'] ? tp_kses($item['tp_fact_after']) : NULL; ?>
                        </h3>

                        <?php if(!empty($item['tp_fact_title'])) : ?>
                        <p class="tp-el-rep-title"><?php echo tp_kses($item['tp_fact_title']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-4' ): ?>

<div class="counter-area pb-90 tp-el-section">
    <div class="container">
        <div class="row">

            <?php foreach ($settings['tp_fact_list'] as $key => $item) : ?>
            <div class="col-lg-3 col-sm-6">
                <div class="counter-5 d-flex mb-30 counter-5-<?php echo esc_attr($key+1); ?>">
                    <div class="counter-5-icon">
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
                    <div class="counter-5-content">
                        <b class="counter-5-count mb-10 tp-el-rep-num">
                            <span data-purecounter-duration="1"
                                data-purecounter-end="<?php echo esc_attr($item['tp_fact_number']); ?>"
                                class="purecounter"><?php echo tp_kses($item['tp_fact_number']); ?></span>
                            <?php echo $item['tp_fact_after'] ? tp_kses($item['tp_fact_after']) : NULL; ?>
                        </b>
                        <?php if(!empty($item['tp_fact_title'])) : ?>
                        <p class="tp-el-rep-title"><?php echo tp_kses($item['tp_fact_title']); ?></p>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_border_percentage'])) : ?>
                        <div class="counter-5-bar">
                            <div class="progress">
                                <div class="progress-bar tp-el-rep-progress" role="progressbar" aria-label="Example with label"
                                    style="width: <?php echo esc_attr($item['tp_border_percentage']); ?>%;"
                                    aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-5' ): ?>

<div class="counter-area pb-120 tp-el-section">
    <div class="container">
        <div class="counter-border">
            <div class="row">
                <?php foreach ($settings['tp_fact_list'] as $key => $item) : ?>
                <div
                    class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
                    <div
                        class="inner-counter <?php echo $key == 1 ? 'ml-70' : NULL; echo $key == 2 ? 'd-flex justify-content-lg-end' : NULL; ?>">

                        <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                        <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                        <div class="inner-counter-shape tp-el-rep-icon inner-counter-shape-<?php echo esc_attr($key+1); ?>">
                            <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                        </div>
                        <?php endif; ?>
                        <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                        <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                        <div class="inner-counter-shape tp-el-rep-icon inner-counter-shape-<?php echo esc_attr($key+1); ?>">
                            <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                        </div>
                        <?php endif; ?>
                        <?php else : ?>
                        <?php if (!empty($item['tp_box_icon_svg'])): ?>
                        <div class="inner-counter-shape tp-el-rep-icon inner-counter-shape-<?php echo esc_attr($key+1); ?>">
                            <?php echo $item['tp_box_icon_svg']; ?>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>

                        <div
                            class="inner-counter-count d-flex align-items-center <?php echo $key == 0 ? 'ml-45' : NULL; ?>">

                            <div class="inner-counter-list tp-el-rep-num">
                                <span data-purecounter-duration="1"
                                    data-purecounter-end="<?php echo esc_attr($item['tp_fact_number']); ?>"
                                    class="purecounter"><?php echo tp_kses($item['tp_fact_number']); ?></span>
                                <?php echo $item['tp_fact_after'] ? tp_kses($item['tp_fact_after']) : NULL; ?>
                            </div>

                            <?php if(!empty($item['tp_fact_title'])) : ?>
                            <div class="inner-counter-info">
                                <span class="tp-el-rep-title"><?php echo tp_kses($item['tp_fact_title']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php else : ?>

<div class="tpanalysis__wrapper tp-el-section">
    <div class="row">
        <?php foreach ($settings['tp_fact_list'] as $key => $item) : ?>
        <div
            class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
            <div class="tpanalysis__catagory ml-20 mb-40">
                <div class="tpanalysis__item">
                    <h3 class="tpanalysis__count mb-10 tp-el-rep-num"><span data-purecounter-duration="1"
                            data-purecounter-end="<?php echo esc_attr($item['tp_fact_number']); ?>"
                            class="purecounter"><?php echo tp_kses($item['tp_fact_number']); ?></span></h3>
                    <?php if(!empty($item['tp_fact_title'])) : ?>
                    <p class="tp-el-rep-title"><?php echo tp_kses($item['tp_fact_title']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php endif; 
        
	}
}

$widgets_manager->register( new TP_Fact() );