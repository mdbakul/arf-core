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
class TP_Features extends Widget_Base {

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
		return 'features';
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
		return __( 'Features', 'tp-core' );
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
                    'layout-2' => esc_html__('Layout 2', 'tp-core'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        $this->tp_section_title_render_controls('feature', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2']);
        
        $this->tp_button_render('feature', 'Button', ['layout-1', 'layout-2']);  


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
            'tp_image_2',
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
        $this->tp_section_style_controls('feature_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2']);
        $this->tp_link_controls_style('section_btn', 'Section - Button', '.tp-el-btn', ['layout-1', 'layout-2']);
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

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image_2']['url']) ) {
        $tp_image_2 = !empty($settings['tp_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_image_2']['id'], $settings['tp_image_size_size']) : $settings['tp_image_2']['url'];
        $tp_image_alt_2 = get_post_meta($settings["tp_image_2"]["id"], "_wp_attachment_image_alt", true);
    }

    // Link
    if ('2' == $settings['tp_feature_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_feature_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_feature_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_feature_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'feature-inner-title-2 tp-el-title');    
?>

<section class="feature-area pb-50 tp-el-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="feature-inner-thumb-wrap p-relative mb-50">
                    <?php if(!empty($tp_image)) : ?>
                    <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                    <?php endif; ?>
                    <div class="feature-inner-wrap-shape">
                        <?php if(!empty($tp_image_2)) : ?>
                        <div class="feature-inner-wrap-shape-2">
                            <img src="<?php echo esc_url($tp_image_2); ?>" alt="<?php echo esc_attr($tp_image_alt_2); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-inner-wrapper feature-inner-pl mb-50 pl-170">
                    <?php if ( !empty($settings['tp_feature_sub_title']) ) : ?>
                    <span class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_feature_sub_title'] ); ?></span>
                    <?php endif; ?>
                    <?php
                        if ( !empty($settings['tp_feature_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_feature_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_feature_title' ] )
                            );
                        endif;
                        ?>
                    <?php if ( !empty($settings['tp_feature_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_feature_description'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( !empty($settings['tp_feature_btn_text']) ) : ?>
                    <div class="feature-inner-btn">
                        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_feature_btn_text']); ?>
                            <span>
                                <svg width="12" height="13" viewBox="0 0 12 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6.55469H11" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6 1.55469L11 6.55469L6 11.5547" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else:
    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_image_2']['url']) ) {
        $tp_image_2 = !empty($settings['tp_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_image_2']['id'], $settings['tp_image_size_size']) : $settings['tp_image_2']['url'];
        $tp_image_alt_2 = get_post_meta($settings["tp_image_2"]["id"], "_wp_attachment_image_alt", true);
    }

    // Link
    if ('2' == $settings['tp_feature_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_feature_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_feature_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_feature_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'feature-inner-title-2 tp-el-title');
?>

<section class="feature-area pb-50 tp-el-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="feature-inner-wrapper mb-50">
                    <?php if ( !empty($settings['tp_feature_sub_title']) ) : ?>
                    <span class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_feature_sub_title'] ); ?></span>
                    <?php endif; ?>
                    <?php
                        if ( !empty($settings['tp_feature_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_feature_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_feature_title' ] )
                            );
                        endif;
                        ?>
                    <?php if ( !empty($settings['tp_feature_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_feature_description'] ); ?></p>
                    <?php endif; ?>
                    <div class="feature-inner-btn">


                        <?php if ( !empty($settings['tp_feature_btn_text']) ) : ?>
                        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_feature_btn_text']); ?>
                            <span>
                                <svg width="12" height="13" viewBox="0 0 12 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6.55469H11" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6 1.55469L11 6.55469L6 11.5547" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-inner-thumb-wrap p-relative mb-50">
                    <?php if(!empty($tp_image)) : ?>
                    <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                    <?php endif; ?>
                    <div class="feature-inner-wrap-shape">
                        <?php if(!empty($tp_image_2)) : ?>
                        <div class="feature-inner-wrap-shape-1">
                            <img src="<?php echo esc_url($tp_image_2); ?>"
                                alt="<?php echo esc_attr($tp_image_alt_2); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; 
        
	}
}

$widgets_manager->register( new TP_Features() );