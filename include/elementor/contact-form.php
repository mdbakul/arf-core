<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Contact_Form extends Widget_Base {

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
		return 'tp-contact-form';
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
		return __( 'Contact Form', 'tpcore' );
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


    public function get_tp_contact_form(){
        if ( ! class_exists( 'WPCF7' ) ) {
            return;
        }
        $tp_cfa         = array();
        $tp_cf_args     = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
        $tp_forms       = get_posts( $tp_cf_args );
        $tp_cfa         = ['0' => esc_html__( 'Select Form', 'tpcore' ) ];
        if( $tp_forms ){
            foreach ( $tp_forms as $tp_form ){
                $tp_cfa[$tp_form->ID] = $tp_form->post_title;
            }
        }else{
            $tp_cfa[ esc_html__( 'No contact form found', 'tpcore' ) ] = 0;
        }
        return $tp_cfa;
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
        
        $this->tp_section_title_render_controls('contact', 'Section Title', 'Sub Title', 'your title here', 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2']);

        $this->start_controls_section(
            'tpcore_contact',
            [
                'label' => esc_html__('Contact Form', 'tpcore'),
            ]
        );

        $this->add_control(
            'tpcore_select_contact_form',
            [
                'label'   => esc_html__( 'Select Form', 'tpcore' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $this->get_tp_contact_form(),
            ]
        );

        $this->end_controls_section();

	}

    protected function style_tab_content(){
        $this->tp_section_style_controls('contact_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2']);
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

<?php if ( $settings['tp_design_style']  == 'layout-2' ):
    $this->add_render_attribute('title_args', 'class', 'contact-form-title tp-el-title');
?>

<div class="contact-form ele-section">
	<?php if ( !empty($settings['tp_contact_sub_title']) ) : ?>
	<div class="about-5-section ">
		<span class="sub-title tp-el-subtitle"><?php echo tp_kses( $settings['tp_contact_sub_title'] ); ?></span>
	</div>
	<?php endif; ?>
	<?php
		if ( !empty($settings['tp_contact_title' ]) ) :
			printf( '<%1$s %2$s>%3$s</%1$s>',
			tag_escape( $settings['tp_contact_title_tag'] ),
			$this->get_render_attribute_string( 'title_args' ),
			tp_kses( $settings['tp_contact_title' ] )
			);
		endif;
	?>
	<?php if ( !empty($settings['tp_contact_description']) ) : ?>
	<p class="mb-20 tp-el-content"><?php echo tp_kses( $settings['tp_contact_description'] ); ?></p>
	<?php endif; ?>
    <?php if( !empty($settings['tpcore_select_contact_form']) ) : ?>
    <?php echo do_shortcode( '[contact-form-7  id="'.$settings['tpcore_select_contact_form'].'"]' ); ?>
    <?php else : ?>
    <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
    <?php endif; ?>
</div>

<?php else :
    $this->add_render_attribute('title_args', 'class', 'traffic-item-content-title tp-el-title');
?>

<div class="traffic-item traffic-bg mb-55 ele-section">
    <div class="traffic-item-content">
        <?php if ( !empty($settings['tp_contact_sub_title']) ) : ?>
        <div class="about-5-section ">
            <span class="sub-title tp-el-subtitle"><?php echo tp_kses( $settings['tp_contact_sub_title'] ); ?></span>
        </div>
        <?php endif; ?>
        <?php
            if ( !empty($settings['tp_contact_title' ]) ) :
                printf( '<%1$s %2$s>%3$s</%1$s>',
                tag_escape( $settings['tp_contact_title_tag'] ),
                $this->get_render_attribute_string( 'title_args' ),
                tp_kses( $settings['tp_contact_title' ] )
                );
            endif;
        ?>
        <?php if ( !empty($settings['tp_contact_description']) ) : ?>
        <span class="tp-el-content"><?php echo tp_kses( $settings['tp_contact_description'] ); ?></span>
        <?php endif; ?>
    </div>
    <?php if( !empty($settings['tpcore_select_contact_form']) ) : ?>
    <?php echo do_shortcode( '[contact-form-7  id="'.$settings['tpcore_select_contact_form'].'"]' ); ?>
    <?php else : ?>
    <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
    <?php endif; ?>
</div>

<?php endif; 
	}
}

$widgets_manager->register( new TP_Contact_Form() );