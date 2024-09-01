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
class TP_Dashboard extends Widget_Base {

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
		return 'tp-dashboard';
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
		return __( 'Dashboard', 'tp-core' );
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

        
        // brand section
		$this->start_controls_section(
            'tp_brand_section',
            [
                'label' => __( 'Brand Item', 'tpcore' ),
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
            'tp_brand_image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => __( 'Image', 'tpcore' ),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'tp_brand_slides',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => esc_html__( 'Brand Item', 'tpcore' ),
                'default' => [
                    [
                        'tp_brand_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'tp_brand_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ]
            ]
        );

        $this->end_controls_section();

        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
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
                'label' => esc_html__( 'Choose Inner Background Image', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'tp_image3',
            [
                'label' => esc_html__( 'Choose Section Background Image', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_design_style' => 'layout-1'
                ]
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
        $this->tp_section_style_controls('dashboard_section', 'Section - Style', '.tp-el-section');
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
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image2']['url']) ) {
        $tp_image2 = !empty($settings['tp_image2']['id']) ? wp_get_attachment_image_url( $settings['tp_image2']['id'], $settings['tp_image_size_size']) : $settings['tp_image2']['url'];
        $tp_image_alt2 = get_post_meta($settings["tp_image2"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image3']['url']) ) {
        $tp_image3 = !empty($settings['tp_image3']['id']) ? wp_get_attachment_image_url( $settings['tp_image3']['id'], $settings['tp_image_size_size']) : $settings['tp_image3']['url'];
        $tp_image_alt3 = get_post_meta($settings["tp_image3"]["id"], "_wp_attachment_image_alt", true);
    }
?>

<div class="dashbord-area theme-bg-4 tp-el-section dash-board-shape-wrap p-relative">
    <div class="dashbord-bg-shape">
        <?php if(!empty($tp_image3)) : ?>
        <div class="dashbord-bg-shape-1 d-none d-md-block">
            <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image_alt3); ?>">
        </div>
        <?php endif; ?>
        <div class="dashbord-bg-shape-2">
            <span></span>
        </div>
        <div class="dashbord-bg-shape-3">
            <span></span>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="dashbord-bg" style="background: url(<?php echo esc_url($tp_image2); ?>);">
                    <div class="dashbord-thumb">
                        <?php if(!empty($tp_image)) : ?>
                        <div class="dashbord-thumb-one text-center">
                            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                        </div>
                        <?php endif; ?>
                        <div class="dashbord-thumb-two text-center d-none d-sm-block">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/dashbord-shape-one.jpg" alt="">
                        </div>
                        <div class="dashbord-thumb-shape">
                            <div class="row gx-8">

                                <?php foreach ($settings['tp_brand_slides'] as $key => $item) : 
                                    if ( !empty($item['tp_brand_image']['url']) ) {
                                        $tp_brand_image_url = !empty($item['tp_brand_image']['id']) ? wp_get_attachment_image_url( $item['tp_brand_image']['id'], $settings['thumbnail_size']) : $item['tp_brand_image']['url'];
                                        $tp_brand_image_alt = get_post_meta($item["tp_brand_image"]["id"], "_wp_attachment_image_alt", true);
                                    }
                                ?>
                                <div class="col-xl-4 col-lg-4 col-md-4">
                                    <div class="dashbord-thumb-shape-img">
                                        <span>
                                            <img src="<?php echo esc_url($tp_brand_image_url); ?>" alt="<?php echo esc_attr($tp_brand_image_alt); ?>">
                                        </span>
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
</div>


<?php endif; 
        
	}
}

$widgets_manager->register( new TP_Dashboard() );