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
class TP_Mission extends Widget_Base {

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
		return 'tp-mission';
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
		return __( 'Mission', 'tp-core' );
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
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // Features 1
        $this->start_controls_section(
        'mission_features_list_sec',
            [
                'label' => esc_html__( 'Features 1', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_feature1_switcher',
            [
                'label' => esc_html__( 'Active Feature 1', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
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
        $this->add_control(
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

        $this->add_control(
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
            $this->add_control(
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
            $this->add_control(
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
    
        $this->add_control(
        'mission_features_des',
            [
                'label'   => esc_html__( 'Description', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Understand how your keyword/group is ranking specific cases.', 'tpcore' ),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // Features 2
        $this->start_controls_section(
        'mission_features_list_sec2',
            [
                'label' => esc_html__( 'Features 2', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_feature2_switcher',
            [
                'label' => esc_html__( 'Active Feature 1', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
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
        $this->add_control(
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

        $this->add_control(
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
            $this->add_control(
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
            $this->add_control(
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
    
        $this->add_control(
        'mission_features_des2',
            [
                'label'   => esc_html__( 'Description', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Understand how your keyword/group is ranking specific cases.', 'tpcore' ),
                'label_block' => true,
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

	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('mission_item1', 'Item 1 - Style', '.tp-el-item1');
        $this->tp_section_style_controls('mission_item2', 'Item 2 - Style', '.tp-el-item2');
        $this->tp_icon_style('mission_icon', 'Icon', '.tp-el-icon');
        $this->tp_basic_style_controls('mission_content', 'Content', '.tp-el-content');
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
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_3']['url']) ) {
        $tp_shape_image3 = !empty($settings['tp_shape_image_3']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_3']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_3']['url'];
        $tp_shape_image_alt3 = get_post_meta($settings["tp_shape_image_3"]["id"], "_wp_attachment_image_alt", true);
    }
?>

<div class="mission-area pb-120 pt-100 tp-el-section" id="our-misson">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <?php if(!empty($settings['tp_feature1_switcher'])) : ?>
                <div class="mission-content tp-el-item1">

                    <?php if($settings['tp_box_icon_type'] == 'icon') : ?>
                    <?php if (!empty($settings['tp_box_icon']) || !empty($settings['tp_box_selected_icon']['value'])) : ?>
                    <span class="tp-el-icon">
                        <?php tp_render_icon($settings, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                    </span>
                    <?php endif; ?>
                    <?php elseif( $settings['tp_box_icon_type'] == 'image' ) : ?>
                    <?php if (!empty($settings['tp_box_icon_image']['url'])): ?>
                    <span class="tp-el-icon">
                        <img src="<?php echo $settings['tp_box_icon_image']['url']; ?>"
                            alt="<?php echo get_post_meta(attachment_url_to_postid($settings['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                    </span>
                    <?php endif; ?>
                    <?php else : ?>
                    <?php if (!empty($settings['tp_box_icon_svg'])): ?>
                    <span class="tp-el-icon">
                        <?php echo $settings['tp_box_icon_svg']; ?>
                    </span>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(!empty($settings['mission_features_des'])) : ?>
                    <p class="tp-el-content"><?php echo tp_kses($settings['mission_features_des']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <?php if(!empty($tp_shape_image)) : ?>
                <div class="mission-shape p-relative d-none d-lg-block">
                    <div class="mission-shape-1">
                        <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mission-two">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mission-shape p-relative  d-none d-lg-block">
                        <?php if(!empty($tp_shape_image2)) : ?>
                        <div class="mission-shape-2">
                            <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image3)) : ?>
                        <div class="mission-shape-3">
                            <img src="<?php echo esc_url($tp_shape_image3); ?>" alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-8">
                    <?php if(!empty($settings['tp_feature2_switcher'])) : ?>
                    <div class="mission-content tp-el-item2 tp-el-icon">
                        <?php if($settings['tp_box_icon_type2'] == 'icon') : ?>
                        <?php if (!empty($settings['tp_box_icon2']) || !empty($settings['tp_box_selected_icon2']['value'])) : ?>
                        <span>
                            <?php tp_render_icon($settings, 'tp_box_ico2n', 'tp_box_selected_icon2'); ?>
                        </span>
                        <?php endif; ?>
                        <?php elseif( $settings['tp_box_icon_type2'] == 'image' ) : ?>
                        <?php if (!empty($settings['tp_box_icon_image2']['url'])): ?>
                        <span>
                            <img src="<?php echo $settings['tp_box_icon_image2']['url']; ?>"
                                alt="<?php echo get_post_meta(attachment_url_to_postid($settings['tp_box_icon_image2']['url']), '_wp_attachment_image_alt', true); ?>">
                        </span>
                        <?php endif; ?>
                        <?php else : ?>
                        <?php if (!empty($settings['tp_box_icon_svg2'])): ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if(!empty($settings['mission_features_des2'])) : ?>
                        <p class="tp-el-content"><?php echo tp_kses($settings['mission_features_des2']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="choose-area tpchoose-bottom pb-80 d-none">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-5">
                <div class="tpchoose-thumb mt-30 p-relative mb-50">
                    <?php if(!empty($tp_image)) : ?>
                    <img class="tpchoose-border-anim" src="<?php echo esc_url($tp_image); ?>"
                        alt="<?php echo esc_attr($tp_image_alt); ?>">
                    <?php endif; ?>
                    <div class="tpchoose-shape">
                        <?php if(!empty($tp_shape_image)) : ?>
                        <div class="tpchoose-shape-one d-none d-md-block">
                            <img src="<?php echo esc_url($tp_shape_image); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty( $tp_shape_image2)) : ?>
                        <div class="tpchoose-shape-two">
                            <img src="<?php echo esc_url( $tp_shape_image2); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image3)) : ?>
                        <div class="tpchoose-shape-three">
                            <img src="<?php echo esc_url($tp_shape_image3); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="tpchoose-wrapper mb-30">
                    <div class="tpsection__content mb-50">

                        <?php if ( !empty($settings['tp_mission_sub_title']) ) : ?>
                        <div class="tpbanner__sub-title mb-15">
                            <span><?php echo tp_kses($settings['tp_mission_sub_title']); ?></span>
                            <i>
                                <svg width="130" height="42" viewBox="0 0 130 42" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect y="0.941895" width="130" height="40.9551" fill="url(#pattern6)"
                                        fill-opacity="0.08" />
                                    <defs>
                                        <pattern id="pattern6" patternContentUnits="objectBoundingBox" width="1"
                                            height="1">
                                            <use xlink:href="#image0_868_3547"
                                                transform="translate(-0.0587762 0.0123052) scale(0.00611916 0.0198269)" />
                                        </pattern>
                                        <image id="image0_868_3547" width="180" height="50"
                                            xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==" />
                                    </defs>
                                </svg>
                            </i>
                        </div>
                        <?php endif; ?>

                        <?php
                        if ( !empty($settings['tp_mission_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_mission_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_mission_title' ] )
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_mission_description']) ) : ?>
                        <p><?php echo tp_kses( $settings['tp_mission_description'] ); ?></p>
                        <?php endif; ?>

                    </div>
                    <div class="row gx-6">

                        <?php foreach($settings['mission_features_list'] as $key => $item) : 
                            // Link
                            if ('2' == $item['tp_mission_link_type']) {
                                $link = get_permalink($item['tp_mission_page_link']);
                                $target = '_self';
                                $rel = 'nofollow';
                            } else {
                                $link = !empty($item['tp_mission_link']['url']) ? $item['tp_mission_link']['url'] : '';
                                $target = !empty($item['tp_mission_link']['is_external']) ? '_blank' : '';
                                $rel = !empty($item['tp_mission_link']['nofollow']) ? 'nofollow' : '';
                            }    
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <?php if(!empty($link)) : ?>
                            <a href="<?php echo esc_url($link); ?>" class="tpchoose mb-30">
                                <?php else : ?>
                                <div class="tpchoose mb-30">
                                    <?php endif; ?>

                                    <div class="tpchoose-icon mb-25">
                                        <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                        <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                        <span>
                                            <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                        </span>
                                        <?php endif; ?>
                                        <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                        <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                        <span>
                                            <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                                alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                        </span>
                                        <?php endif; ?>
                                        <?php else : ?>
                                        <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                        <span>
                                            <?php echo $item['tp_box_icon_svg']; ?>
                                        </span>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="tpchoose-text">
                                        <?php if(!empty($item['mission_features_title'])) : ?>
                                        <span
                                            class="tpchoose-title"><?php echo tp_kses($item['mission_features_title']); ?></span>
                                        <?php endif; ?>
                                        <?php if(!empty($link)) : ?>
                                        <div class="tparrow-right">
                                            <i>
                                                <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.930176 1L5.93018 6L0.930176 11" stroke="currentColor"
                                                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </i>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if(!empty($link)) : ?>
                            </a>
                            <?php else : ?>
                        </div>
                        <?php endif; ?>
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

$widgets_manager->register( new TP_Mission() );