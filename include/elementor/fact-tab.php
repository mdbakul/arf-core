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
class TP_Fact_Tab extends Widget_Base {

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
		return 'tp-fact-tab';
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
		return __( 'Fact Tab', 'tpcore' );
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

        // title/content
        $this->tp_section_title_render_controls('section', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.');

        // fact group 1
        $this->start_controls_section(
            'tp_fact',
            [
                'label' => esc_html__('Fact List 1', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_fact_btn1',
            [
                'label' => esc_html__('Button 1 Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('BEFORE SEO', 'tpcore'),
                'label_block' => true,
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
            'tp_fact_number', [
                'label' => esc_html__('Number', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('17', 'tpcore'),
                'label_block' => true,
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

        $repeater->add_control(
            'tp_fact_after',
            [
                'label' => esc_html__('After', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
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

        // fact group 2
        $this->start_controls_section(
            'tp_fact2',
            [
                'label' => esc_html__('Fact List 2', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_fact_btn2',
            [
                'label' => esc_html__('Button 2 Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('AFTER SEO', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'repeater_condition2',
            [
                'label' => __( 'Field condition 2', 'tpcore' ),
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
            'tp_fact_number2', [
                'label' => esc_html__('Number 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('27', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_fact_title2',
            [
                'label' => esc_html__('Title 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Food', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_fact_after2',
            [
                'label' => esc_html__('After 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        
        $this->add_control(
            'tp_fact_list2',
            [
                'label' => esc_html__('Fact - List 2', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_fact_number2' => esc_html__('100', 'tpcore'),
                        'tp_fact_title2' => esc_html__('Design', 'tpcore'),
                    ],
                    [
                        'tp_fact_number2' => esc_html__('200', 'tpcore'),
                        'tp_fact_title2' => esc_html__('Development', 'tpcore')
                    ],
                    [
                        'tp_fact_number2' => esc_html__('300', 'tpcore'),
                        'tp_fact_title2' => esc_html__('Customization', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_fact_title2 }}}',
            ]
        );
        $this->end_controls_section();

        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
                'condition' => [
                    'tp_design_style' => 'layout-1'
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

	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('fact_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', 'layout-1');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', 'layout-1');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', 'layout-1');
        $this->tp_basic_style_controls('tab_title', 'Tab Button Title', '.tp-el-tab-title', 'layout-1');
        $this->tp_basic_style_controls('tab_num', 'Tab Number', '.tp-el-tab-num', 'layout-1');
        $this->tp_basic_style_controls('tab_content', 'Tab Content', '.tp-el-tab-content', 'layout-1');
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

    $this->add_render_attribute('title_args', 'class', 'tpsection__title mb-25 tp-el-title');       
?>

<section class="analysis__area pb-80 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tpsection__content text-center mb-70">
                    <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                    <div class="tpbanner__sub-title mb-15">
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_section_sub_title']); ?></span>
                        <i>
                            <svg width="200" height="43" viewBox="0 0 200 43" fill="none"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="200" height="42.2222" fill="url(#pattern2)" fill-opacity="0.06" />
                                <defs>
                                    <pattern id="pattern2" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_929_1201"
                                            transform="translate(-0.0596774) scale(0.00612903 0.02)" />
                                    </pattern>
                                    <image id="image0_929_1201" width="180" height="50"
                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==" />
                                </defs>
                            </svg>
                        </i>
                    </div>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_section_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_section_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_section_title' ] )
                        );
                    endif;
                    ?>
                    <?php if ( !empty($settings['tp_section_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="tpanalysis-chart p-relatives pb-60">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="tpanalysis-different">

                        <?php if(!empty($settings['tp_fact_btn1'])) : ?>
                        <label class="analisis-toggler  analisis-toggler--is-active tp-el-tab-title" id="filt-monthly-seo">
                            <?php echo tp_kses($settings['tp_fact_btn1']); ?>
                        </label>
                        <?php endif; ?>

                        <div class="analisis-toggle">
                            <input type="checkbox" id="switcher-seo" class="analisis-check">
                            <b class="analisis-switch"></b>
                        </div>

                        <?php if(!empty($settings['tp_fact_btn2'])) : ?>
                        <label class="analisis-toggler tp-el-tab-title" id="filt-yearly-seo">
                            <?php echo tp_kses($settings['tp_fact_btn2']); ?>
                        </label>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <div class="tpanalysis-shape d-none d-lg-block">
                <?php if(!empty($tp_image)) : ?>
                <div class="tpanalysis-shape-one">
                    <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                </div>
                <?php endif; ?>
                <?php if(!empty($tp_image2)) : ?>
                <div class="tpanalysis-shape-two">
                    <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                <div class="tpseo-analisis">
                    <div id="monthly-seo" class="wrapper-full">
                        <div class="tpanalysis__wrapper">
                            <div class="row">

                                <?php foreach ($settings['tp_fact_list'] as $key => $item) : ?>
                                <div class="col-lg-4 col-md-4">
                                    <div class="tpanalysis__catagory ml-20 mb-40">
                                        <div class="tpanalysis__item">
                                            <h3 class="tpanalysis__count mb-10 tp-el-tab-num"><span data-purecounter-duration="1"
                                                    data-purecounter-end="<?php echo esc_attr($item['tp_fact_number']); ?>"
                                                    class="purecounter"><?php echo tp_kses($item['tp_fact_number']); ?></span><?php echo $item['tp_fact_after'] ? $item['tp_fact_after'] : NULL;  ?></h3>
                                            <?php if(!empty($item['tp_fact_title'])) : ?>
                                            <p class="tp-el-tab-content"><?php echo tp_kses($item['tp_fact_title']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div id="hourly-seo" class="wrapper-full analisis-hide">
                        <div class="tpanalysis__wrapper">
                            <div class="row">

                                <?php foreach ($settings['tp_fact_list2'] as $key => $item) : ?>
                                <div class="col-lg-4 col-md-4">
                                    <div class="tpanalysis__catagory ml-20 mb-40">
                                        <div class="tpanalysis__item">
                                            <h3 class="tpanalysis__count mb-10 tp-el-tab-num"><span data-purecounter-duration="1"
                                                    data-purecounter-end="<?php echo esc_attr($item['tp_fact_number2']); ?>"
                                                    class="purecounter"><?php echo tp_kses($item['tp_fact_number2']); ?></span><?php echo $item['tp_fact_after2'] ? $item['tp_fact_after2'] : NULL;  ?></h3>
                                            <?php if(!empty($item['tp_fact_title2'])) : ?>
                                            <p class="tp-el-tab-content"><?php echo tp_kses($item['tp_fact_title2']); ?></p>
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
    </div>
</section>

<?php endif; 
        
	}
}

$widgets_manager->register( new TP_Fact_Tab() );