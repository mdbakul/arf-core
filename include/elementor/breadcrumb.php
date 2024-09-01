<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Control_Media;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Breadcrumb extends Widget_Base {

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
		return 'tp-breadcrumb';
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
		return __( 'Breadcrumb', 'tpcore' );
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

    protected function register_controls_section(){
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
        

        $this->tp_section_title_render_controls('breadcrumb', 'Section Title', 'Sub Title', 'your title here', 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', 'layout-1');

        $this->start_controls_section(
        'tp_breadcrumb_sec',
            [
                'label' => esc_html__( 'Title & Description', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                'tp_design_style' => ['layout-1', 'layout-2']
                ]
            ]
        );

        $this->add_control(
        'tp_bread_title',
         [
            'label'       => esc_html__( 'Title', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => esc_html__( 'About Us', 'tpcore' ),
            'label_block' => true
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
        
        // breadcrumb shape
        $this->start_controls_section(
            'tp_bread_shape',
                [
                  'label' => esc_html__( 'Breadcrumb Shape', 'tpcore' ),
                  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
           );
   
           $this->add_control(
            'tp_bread_shape_switch',
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
                       'tp_bread_shape_switch' => 'yes'
                   ]
               ]
           );
   
           $this->add_group_control(
               Group_Control_Image_Size::get_type(),
               [
                   'name' => 'shape_image_size', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                   'exclude' => ['custom'],
                   'condition' => [
                       'tp_bread_shape_switch' => 'yes'
                   ]
               ]
           );
           
           $this->end_controls_section();  

    }

    protected function style_tab_content(){
        $this->tp_section_style_controls('breadcrumb_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', 'layout-1');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', 'layout-1');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', 'layout-1');
        $this->tp_basic_style_controls('page_title', 'Page Title', '.tp-el-page-title', 'layout-1');
        $this->tp_link_controls_style('page_link', 'Page Link', '.tp-el-page-link a', 'layout-1');
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

<?php else: 
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'about-inner-title tp-el-title');
?>

<div class="breadcrumb-about-area scene p-relative breadcrumb-bg tp-el-section">
    <?php if(!empty($settings['tp_bread_shape_switch'])) : ?>
    <div class="about-inner-shape">
        <div class="about-inner-shape-2 d-none d-md-block">
            <img class="layer" data-depth="0.5"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/about-inner-shape-1.png" alt="shape">
        </div>
        <div class="about-inner-shape-3 d-none d-md-block">
            <img class="layer" data-depth="0.5"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/about-inner-shape-2.png" alt="shape">
        </div>
    </div>
    <?php endif; ?>
    <?php if(!empty($tp_shape_image)) : ?>
    <div class="tpbanner-shape-y scene-y">
        <div class="about-inner-shape-4 d-none d-md-block">
            <img class="layer" data-depth="0.6" src="<?php echo esc_url($tp_shape_image); ?>"
                alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
    </div>
    <?php endif; ?>
    <!-- breadcrumb-area-start -->
    <section class="breadcrumb-area pb-115 pt-195">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <?php if(!empty($settings['tp_bread_title'])) : ?>
                        <h3 class="breadcrumb__title tp-el-page-title"><?php echo tp_kses($settings['tp_bread_title']); ?></h3>
                        <?php endif; ?>
                        <?php if(function_exists('bcn_display')) : ?>
                        <div class="breadcrumb__list tp-el-page-link">
                            <?php bcn_display(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <!-- about-area-start -->
    <section class="about-area pb-75 p-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <?php if(!empty($tp_image)) : ?>
                    <div class="about-inner-thumb">
                        <div class="about-inner-shape-1">
                            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6">
                    <div class="about-inner-content">
                        <?php if ( !empty($settings['tp_breadcrumb_sub_title']) ) : ?>
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_breadcrumb_sub_title']); ?></span>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_breadcrumb_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_breadcrumb_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_breadcrumb_title' ] )
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_breadcrumb_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_breadcrumb_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->
</div>

<?php endif;
	}
}

$widgets_manager->register( new TP_Breadcrumb() );