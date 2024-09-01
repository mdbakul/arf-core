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
class TP_Info_Card extends Widget_Base {

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
		return 'tp-info-card';
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
		return __( 'Info Card', 'tpcore' );
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
                    'layout-2' => esc_html__('Layout 2', 'tp-core'),
                    'layout-3' => esc_html__('Layout 3', 'tp-core'),
                    'layout-4' => esc_html__('Layout 4', 'tp-core'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // title/content
        $this->tp_section_title_render_controls('section', 'Section Title', 'Sub Title', 'your title here', 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2', 'layout-3', 'layout-4']);

        $this->start_controls_section(
        'tp_list_sec',
            [
                'label' => esc_html__( 'Info List', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tp_design_style' => 'layout-4'
                ]
            ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
        'tp_text_list_title',
            [
            'label'   => esc_html__( 'Title', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Default-value', 'tpcore' ),
            'label_block' => true,
            ]
        );
        
        $this->add_control(
            'tp_text_list_list',
            [
            'label'       => esc_html__( 'Features List', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                'tp_text_list_title'   => esc_html__( 'Neque sodales', 'tpcore' ),
                ],
                [
                'tp_text_list_title'   => esc_html__( 'Adipiscing elit', 'tpcore' ),
                ],
                [
                'tp_text_list_title'   => esc_html__( 'Mauris commodo', 'tpcore' ),
                ],
            ],
            'title_field' => '{{{ tp_text_list_title }}}',
            ]
        );
        $this->end_controls_section();

        // shape
        $this->start_controls_section(
        'tp_shape',
            [
                'label' => esc_html__( 'Shape Section', 'tpcore' ),
                'condition' => [
                    'tp_design_style' => ['layout-2', 'layout-3']
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

        
        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
                'condition' => [
                    'tp_design_style' => ['layout-2', 'layout-3', 'layout-4']
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

    protected function style_tab_content(){
        $this->tp_section_style_controls('info_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2', 'layout-3', 'layout-4']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2', 'layout-3', 'layout-4']);
        $this->tp_basic_style_controls('list_item', 'List Item', '.tp-el-list', 'layout-4');
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
    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }

    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'services-details-title tp-el-title');
?>

<div class="breadcrumb-services-area services-details-bg scene breadcrumb-bg p-relative tp-el-section">
    <div class="about-inner-shape">
        <?php if(!empty($tp_shape_image)) : ?>
        <div class="about-inner-shape-2">
            <img class="layer" data-depth="0.5" src="<?php echo esc_url($tp_shape_image); ?>"
                alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
        <?php endif; ?>
        <?php if(!empty($settings['tp_shape_switch'])) : ?>
        <div class="about-inner-shape-3">
            <img class="layer" data-depth="0.5"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/about-inner-shape-2.png" alt="">
        </div>
        <?php endif; ?>
    </div>
    <?php if(!empty($tp_shape_image2)) : ?>
    <div class="tpbanner-shape-y scene-y">
        <div class="about-inner-shape-4 d-none d-lg-block">
            <img class="layer" data-depth="0.6" src="<?php echo esc_url($tp_shape_image2); ?>"
                alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
        </div>
    </div>
    <?php endif; ?>
</div>
<!-- breadcrumb-services-area-end -->

<!-- service-details-area-start -->
<section class="services-details-area services-details ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="services-details">
                    <div class="services-details-section ml-95">
                        <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                        <span class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_section_sub_title'] ); ?></span>
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
                    <?php if(!empty($tp_image)) : ?>
                    <div class="services-details-thumb mb-50">
                        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : 
    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }

    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'markiting-title tp-el-title');    
?>

<!-- markiting-area-start -->
<section class="markiting-area markiting-wrap tp-el-section">
    <div class="markiting-shape services-inner-banner-shape-wrap">
        <?php if(!empty($tp_shape_image)) : ?>
        <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        <?php endif; ?>
        <div class="services-inner-banner-shape">
            <?php if(!empty($tp_shape_image2)) : ?>
            <img class="services-inner-banner-shape-1" src="<?php echo esc_url($tp_shape_image2); ?>"
                alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
            <?php endif; ?>
            <?php if(!empty($settings['tp_shape_switch'])) : ?>
            <img class="services-inner-banner-shape-2"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-2.png" alt="shape">
            <img class="services-inner-banner-shape-3"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-3.png" alt="shape">
            <img class="services-inner-banner-shape-4"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-4.png" alt="shape">
            <img class="services-inner-banner-shape-5"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-5.png" alt="shape">
            <img class="services-inner-banner-shape-6"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-6.png" alt="shape">
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-12">
                <div class="markiting-content">
                    <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                    <span class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_section_sub_title'] ); ?></span>
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
                    <p class="text-white mt-30 tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- markiting-area-end -->

<!-- markiting-area-start -->
<?php if(!empty($tp_image)) : ?>
<div class="pb-105">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="markiting-bg">
                    <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- markiting-area-end -->

<?php elseif ( $settings['tp_design_style']  == 'layout-4' ) : 

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'services-quality-title tp-el-title');      
?>

<div class="services-quality-wrapper tp-el-section">
    <?php if(!empty($tp_image)) : ?>
    <div class="services-quality-thumb">
        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
    </div>
    <?php endif; ?>
    <div class="services-quality-content">
        <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
        <span class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_section_sub_title'] ); ?></span>
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
        <ul>
            <?php foreach ($settings['tp_text_list_list'] as $key => $item) : if(!empty($item['tp_text_list_title'])) : ?>
            <li class="tp-el-list"><?php echo tp_kses($item['tp_text_list_title']); ?></li>
            <?php endif; endforeach; ?>
        </ul>
    </div>
</div>

<?php else: 
    $this->add_render_attribute('title_args', 'class', 'about-inner-title-2 tp-el-title');    
?>

<section class="about-area about-inner-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about-inner-wrap tp-el-section">
                    <div class="about-inner-content-2 d-flex align-items-center mb-45">
                        <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                        <span class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_section_sub_title'] ); ?></span>
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
                    </div>
                    <?php if ( !empty($settings['tp_section_description']) ) : ?>
                    <p class="pl-30 tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; 
	}
}

$widgets_manager->register( new TP_Info_Card() );