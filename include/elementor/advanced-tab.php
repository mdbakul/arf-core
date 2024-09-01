<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Repeater;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Utils;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Advanced_Tab extends Widget_Base {

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
		return 'advanced-tab';
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
		return __( 'Advanced Tab', 'tpcore' );
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

        // title/content
        $this->tp_section_title_render_controls('section', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2']);

		$this->start_controls_section(
            '_section_price_tabs',
            [
                'label' => __('Advanced Tabs', 'tpcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

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
                'condition' => [
                    'repeater_condition' => 'style_2'
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
                    'repeater_condition' => 'style_2'
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
                    'repeater_condition' => 'style_2'
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
                        'repeater_condition' => 'style_2'
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
                        'repeater_condition' => 'style_2'
                    ]
                ]
            );
        }


        $repeater->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __('Title', 'tpcore'),
                'default' => __('Tab Title', 'tpcore'),
                'placeholder' => __('Type Tab Title', 'tpcore'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'template',
            [
                'label' => __('Section Template', 'tpcore'),
                'placeholder' => __('Select a section template for as tab content', 'tpcore'),

                'type' => Controls_Manager::SELECT2,
                'options' => get_elementor_templates()
            ]
        );

        $repeater->add_control(
            'tp_active_switcher',
            [
                'label' => esc_html__( 'Active', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 0,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'tabs',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{title}}',
                'default' => [
                    [
                        'title' => 'Tab 1',
                    ],
                    [
                        'title' => 'Tab 2',
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        // shape
        $this->start_controls_section(
        'tp_shape',
            [
                'label' => esc_html__( 'Shape Section', 'tpcore' ),
                'condition' => [
                    'tp_design_style' => 'layout-1'
                ]
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
        $this->tp_section_style_controls('advanced_tab_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2']);
        $this->tp_link_controls_style('tab_title', 'Tab Title', '.tp-el-tab-title', ['layout-1', 'layout-2']);
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
    $this->add_render_attribute('title_args', 'class', 'section-title-4 fs-54 tp-el-title');       
?>

<section class="quality-services-area quality-services-bg pb-125 pt-95 mb-120 ele-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="optimize-subtitle mb-60">
                    <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                    <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_section_sub_title']); ?></span>
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
        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="quality-services-nav">
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">

                            <?php foreach($settings['tabs'] as $key => $item) : ?>
                            <button class="nav-link <?php echo $item['tp_active_switcher'] ? 'active' : NULL ;?>" id="v-pills-<?php echo esc_attr($key+1); ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo esc_attr($key+1); ?>" type="button" role="tab" aria-controls="v-pills-<?php echo esc_attr($key+1); ?>" aria-selected="<?php echo $item['tp_active_switcher'] ? 'true' : 'false' ;?>">
                                <span class="tp-el-tab-title">
                                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                    <i>
                                        <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                    </i>
                                    <?php endif; ?>
                                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                    <i>
                                        <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                    </i>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                    <i>
                                        <?php echo $item['tp_box_icon_svg']; ?>
                                    </i>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <?php echo tp_kses($item['title']); ?>
                                </span>
                            </button>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="services-quality-tab">
                    <div class="tab-content" id="v-pills-tabContent">

                        <?php foreach($settings['tabs'] as $key => $item) : ?>
                        <div class="tab-pane fade <?php echo $item['tp_active_switcher'] ? 'show active' : NULL ;?>" id="v-pills-<?php echo esc_attr($key+1); ?>" role="tabpanel"
                            aria-labelledby="v-pills-<?php echo esc_attr($key+1); ?>-tab" tabindex="0">
                            <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content($item['template'], true); ?>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else :     
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    $this->add_render_attribute('title_args', 'class', 'section-title-4 section-title-4-2 tp-el-title');    
?>

<section class="portfolio-area portfolio-4-bg pb-140 mb-115 fix p-relative ele-section">
    <?php if(!empty($tp_shape_image)) : ?>
    <div class="portfolio-4-main-bg-shape">
        <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="portfolio-4-wrapper">
                    <div class="portfolio-4 mt-20">
                        <div class="section-wrapper mb-20">
                            <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                            <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_section_sub_title']); ?></span>
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
                    <div class="portfolio-tab-4 mb-35">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <?php foreach($settings['tabs'] as $key => $item) : ?>
                            <button class="nav-link tp-el-tab-title <?php echo $item['tp_active_switcher'] ? 'active' : NULL ;?>"
                                id="v-pills-<?php echo esc_attr($key+1); ?>-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-<?php echo esc_attr($key+1); ?>" type="button" role="tab"
                                aria-controls="v-pills-<?php echo esc_attr($key+1); ?>"
                                aria-selected="<?php echo $item['tp_active_switcher'] ? 'true' : 'false' ;?>"><?php echo tp_kses($item['title']); ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="nav-tab-slider-4">
                        <div class="tpnav-tab-4 p-relative d-none">
                            <button class="prv-nav-tab">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" fill="none"
                                        viewBox="0 0 8 14">
                                        <path fill-rule="evenodd"
                                            d="M7.707.293a1 1 0 0 1 0 1.414L2.414 7l5.293 5.293a1 1 0 0 1-1.414 1.414l-6-6a1 1 0 0 1 0-1.414l6-6a1 1 0 0 1 1.414 0z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                            </button>
                            <button class="next-nav-tab">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" fill="none"
                                        viewBox="0 0 8 14">
                                        <path fill-rule="evenodd"
                                            d="M.293 13.707a1 1 0 0 1 0-1.414L5.586 7 .293 1.707A1 1 0 1 1 1.707.293l6 6a1 1 0 0 1 0 1.414l-6 6a1 1 0 0 1-1.414 0z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="tab-content-4">
                    <div class="tab-content" id="v-pills-tabContent">
                        <?php foreach($settings['tabs'] as $key => $item) : ?>
                        <div class="tab-pane fade <?php echo $item['tp_active_switcher'] ? 'show active' : NULL ;?>"
                            id="v-pills-<?php echo esc_attr($key+1); ?>" role="tabpanel"
                            aria-labelledby="v-pills-<?php echo esc_attr($key+1); ?>-tab">
                            <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content($item['template'], true); ?>
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
$widgets_manager->register( new TP_Advanced_Tab() );