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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_CTA extends Widget_Base {

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
		return 'tp-cta';
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
		return __( 'CTA', 'tpcore' );
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


	// controls file 
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

        // title/content
        $this->tp_section_title_render_controls('cta', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', 'layout-1');

        // subscriber form
        $this->start_controls_section(
            'tp_subs_sec',
            [
                'label' => esc_html__('Subscriber Section', 'tp-core'),
            ]
        );
        
        $this->add_control(
        'form_shortcode',
            [
            'label'   => esc_html__( 'Newsletter Shortcode', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( '[enter shortcode here]', 'tpcore' ),
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
        $this->tp_section_style_controls('cta_section', 'Section Style', '.ele-section'); 
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', 'layout-1');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', 'layout-1');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', 'layout-1');
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
    $this->add_render_attribute('title_args', 'class', 'tpsection-title-white-2 mb-35 tp-el-title');
?>


<section class="cta-area cta-bg p-relative theme-bg-4 pb-95 ele-section">
    <?php if(!empty($tp_shape_image)) : ?>
    <div class="tpcta-shape">
        <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="cta-wrapper text-center">
                    <div class="tpsection-wrapper">
                        <?php if ( !empty($settings['tp_cta_sub_title']) ) : ?>
                         <p class="text-white tp-el-subtitle"><?php echo tp_kses( $settings['tp_cta_sub_title'] ); ?></p>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_cta_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_cta_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_cta_title' ] )
                            );
                        endif;
                        ?>
                    </div>
                    <div class="tpbanner-analysis-3 d-flex align-items-center justify-content-center mb-15">
                        <?php if( !empty($settings['form_shortcode']) ) : ?>
                        <?php echo do_shortcode( $settings['form_shortcode'] ); ?>
                        <?php else : ?>
                        <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
                        <?php endif; ?>
                    </div>
                    <div class="tpbanner-payment tp-el-content">
                        <?php if ( !empty($settings['tp_cta_description']) ) : ?>
                        <?php echo tp_kses( $settings['tp_cta_description'] ); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(!empty($settings['tp_shape_switch'])) : ?>
<div class="p-relative">
    <div class="fw-left-shape-3 d-none d-lg-block">
        <div class="fw-shape-one">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-3-1.png" alt="">
        </div>
        <div class="fw-shape-two">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-3-2.png" alt="">
        </div>
        <div class="fw-shape-three">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-3-3.png" alt="">
        </div>
        <div class="fw-shape-four">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-3-4.png" alt="">
        </div>
        <div class="fw-shape-five d-none d-xl-block">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-3-5.png" alt="">
        </div>
        <div class="fw-shape-six">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-3-6.png" alt="">
        </div>
        <div class="fw-shape-seven">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-3-7.png" alt="">
        </div>
        <div class="fw-shape-eight d-none d-xl-block">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-3-8.png" alt="">
        </div>
        <div class="fw-shape-nine">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/footer-rocket.png" alt="">
        </div>
    </div>
</div>
<?php endif; ?>

<?php endif; 
	}
}

$widgets_manager->register( new TP_CTA() );