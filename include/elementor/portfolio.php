<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Background;
use \Elementor\Control_Media;
use \Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Portfolio extends Widget_Base {

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
		return 'tp-portfolio';
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
		return __( 'Portfolio', 'tpcore' );
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

        // tp_section_title
        $this->tp_section_title_render_controls('portfolio', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2']);

        $this->tp_button_render('portfolio', 'Button', ['layout-1', 'layout-2']);  

        $this->start_controls_section(
         'tp_portfolio_sec',
             [
               'label' => esc_html__( 'Portfolio Slider', 'tpcore' ),
               'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
             ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
            'tp_portfolio_active',
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

        $repeater->add_control(
            'tp_portfolio_image',
            [
                'label' => esc_html__('Upload Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );
        
        $repeater->add_control(
         'tp_portfolio_box_title',
           [
             'label'   => esc_html__( 'Portfolio Title', 'tpcore' ),
             'type'        => \Elementor\Controls_Manager::TEXT,
             'description' => tp_get_allowed_html_desc( 'basic' ),
             'default'     => esc_html__( 'Title', 'tpcore' ),
             'label_block' => true,
           ]
        );
        
        $repeater->add_control(
         'tp_portfolio_box_sub_title',
           [
             'label'   => esc_html__( 'Sub Title', 'tpcore' ),
             'type'        => \Elementor\Controls_Manager::TEXT,
             'description' => tp_get_allowed_html_desc( 'basic' ),
             'default'     => esc_html__( 'Subtitle', 'tpcore' ),
             'label_block' => true,
           ]
        );
        
        $repeater->add_control(
         'tp_portfolio_box_sub_title2',
           [
             'label'   => esc_html__( 'Sub Title 2', 'tpcore' ),
             'type'        => \Elementor\Controls_Manager::TEXT,
             'description' => tp_get_allowed_html_desc( 'basic' ),
             'default'     => esc_html__( 'Subtitle 2', 'tpcore' ),
             'label_block' => true,
           ]
        );
         
        $repeater->add_control(
            'tp_portfolio_link_switcher',
            [
                'label' => esc_html__( 'Add Portfolio link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'tp_portfolio_link_type',
            [
                'label' => esc_html__( 'Portfolio Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_portfolio_link_switcher' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'tp_portfolio_link',
            [
                'label' => esc_html__( 'Portfolio Link link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'tpcore' ),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'tp_portfolio_link_type' => '1',
                    'tp_portfolio_link_switcher' => 'yes',
                ]
            ]
        );
        $repeater->add_control(
            'tp_portfolio_page_link',
            [
                'label' => esc_html__( 'Select Portfolio Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_portfolio_link_type' => '2',
                    'tp_portfolio_link_switcher' => 'yes',
                ]
            ]
        );
        
        $this->add_control(
        'tp_portfolio_list',
            [
                'label'       => esc_html__( 'Portfolio List', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                [
                    'tp_portfolio_box_title' => esc_html__('Business Stratagy', 'tpcore'),
                ],
                [
                    'tp_portfolio_box_title' => esc_html__('Website Development', 'tpcore')
                ],
                [
                    'tp_portfolio_box_title' => esc_html__('Marketing & Reporting', 'tpcore')
                ],
                ],
                'title_field' => '{{{ tp_portfolio_box_title }}}',
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

	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('services_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2']);
        $this->tp_link_controls_style('section_btn', 'Section - Button', '.tp-el-btn', ['layout-1', 'layout-2']);

        # repeater 
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('rep_subtitle_style', 'Repeater Subtitle', '.tp-el-rep-subtitle', ['layout-1', 'layout-2']);

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
    // Link
    if ('2' == $settings['tp_portfolio_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_portfolio_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'light-blue-btn tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_portfolio_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_portfolio_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'light-blue-btn tp-el-btn');
        }
    } 
    $this->add_render_attribute('title_args', 'class', 'tpsection-title-two mb-65 tp-el-title');
?>

<section class="project-area pt-110 ele-section">
    <div class="project-5 pb-120 p-relative fix">
        <div class="seo-shape-bg d-none d-md-block">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/seo-5-shape-bg-1.png" alt="">
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="tpsection-wrapper mb-20">
                        <?php if ( !empty($settings['tp_portfolio_sub_title']) ) : ?>
                        <p class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_portfolio_sub_title'] ); ?></p>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_portfolio_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_portfolio_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_portfolio_title' ] )
                            );
                        endif;
                        ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="tp-panel-top mb-30">

                        <?php if ( !empty($settings['tp_portfolio_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_portfolio_description'] ); ?></p>
                        <?php endif; ?>

                        <?php if ( !empty($settings['tp_portfolio_btn_text']) ) : ?>
                        <div class="tp-panel-btn">
                            <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_portfolio_btn_text']); ?></a>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <div class="row-custom">

                <?php foreach ($settings['tp_portfolio_list'] as $item) :
                        if ( !empty($item['tp_portfolio_image']['url']) ) {
                        $tp_portfolio_image_url = !empty($item['tp_portfolio_image']['id']) ? wp_get_attachment_image_url( $item['tp_portfolio_image']['id'], $settings['thumbnail_size']) : $item['tp_portfolio_image']['url'];
                        $tp_portfolio_image_alt = get_post_meta($item["tp_portfolio_image"]["id"], "_wp_attachment_image_alt", true);
                    }
                    // Link
                    if ('2' == $item['tp_portfolio_link_type']) {
                        $link = get_permalink($item['tp_portfolio_page_link']);
                        $target = '_self';
                        $rel = 'nofollow';
                    } else {
                        $link = !empty($item['tp_portfolio_link']['url']) ? $item['tp_portfolio_link']['url'] : '';
                        $target = !empty($item['tp_portfolio_link']['is_external']) ? '_blank' : '';
                        $rel = !empty($item['tp_portfolio_link']['nofollow']) ? 'nofollow' : '';
                    }
                ?>
                <div class="col-custom <?php echo $item['tp_portfolio_active'] ? 'active' : NULL; ?>">
                    <div class="tp-panel-item p-relative">

                        <?php if(!empty($tp_portfolio_image_url)) : ?>
                        <div class="tp-panel-thumb">
                            <img src="<?php echo esc_url($tp_portfolio_image_url); ?>"
                                alt="<?php echo esc_attr($tp_portfolio_image_alt); ?>">
                        </div>
                        <?php endif; ?>

                        <div class="tp-panel-content">
                            <div class="tp-panel-icon mb-15">
                                <span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/panel-icon-3.png" alt=""></span>
                            </div>
                            <div class="tp-panel-text">

                                <?php if(!empty($item['tp_portfolio_box_title'])) : ?>
                                <h4 class="tp-panel-title mb-15 tp-el-rep-title">
                                    <?php if(!empty($link)) : ?>
                                    <a href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_portfolio_box_title']); ?></a>
                                    <?php else : ?>
                                    <?php echo tp_kses($item['tp_portfolio_box_title']); ?>
                                    <?php endif; ?>
                                </h4>
                                <?php endif; ?>

                                <ul class="tp-panel-meta">
                                    <?php if(!empty($item['tp_portfolio_box_sub_title'])) : ?>
                                    <li class="tp-el-rep-subtitle"><?php echo tp_kses($item['tp_portfolio_box_sub_title']); ?></li>
                                    <?php endif; ?>
                                    <?php if(!empty($item['tp_portfolio_box_sub_title2'])) : ?>
                                    <li class="tp-el-rep-subtitle"><?php echo tp_kses($item['tp_portfolio_box_sub_title2']); ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>

<?php else:
    // Link
    if ('2' == $settings['tp_portfolio_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_portfolio_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'green-btn tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_portfolio_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_portfolio_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'green-btn tp-el-btn');
        }
    } 
    $this->add_render_attribute('title_args', 'class', 'tpsection-title-two mb-65 tp-el-title');
?>


<section class="project-area fix pt-105 ele-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="tpsection-wrapper mb-20">
                    <?php if ( !empty($settings['tp_portfolio_sub_title']) ) : ?>
                    <p class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_portfolio_sub_title'] ); ?></p>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_portfolio_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_portfolio_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_portfolio_title' ] )
                        );
                    endif;
                    ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="tp-panel-top mb-30">
                    <?php if ( !empty($settings['tp_portfolio_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_portfolio_description'] ); ?></p>
                    <?php endif; ?>

                    <?php if ( !empty($settings['tp_portfolio_btn_text']) ) : ?>
                    <div class="tp-panel-btn">
                        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_portfolio_btn_text']); ?></a>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="row-custom">

            <?php foreach ($settings['tp_portfolio_list'] as $item) :
                    if ( !empty($item['tp_portfolio_image']['url']) ) {
                    $tp_portfolio_image_url = !empty($item['tp_portfolio_image']['id']) ? wp_get_attachment_image_url( $item['tp_portfolio_image']['id'], $settings['thumbnail_size']) : $item['tp_portfolio_image']['url'];
                    $tp_portfolio_image_alt = get_post_meta($item["tp_portfolio_image"]["id"], "_wp_attachment_image_alt", true);
                }
                // Link
                if ('2' == $item['tp_portfolio_link_type']) {
                    $link = get_permalink($item['tp_portfolio_page_link']);
                    $target = '_self';
                    $rel = 'nofollow';
                } else {
                    $link = !empty($item['tp_portfolio_link']['url']) ? $item['tp_portfolio_link']['url'] : '';
                    $target = !empty($item['tp_portfolio_link']['is_external']) ? '_blank' : '';
                    $rel = !empty($item['tp_portfolio_link']['nofollow']) ? 'nofollow' : '';
                }
            ?>
            <div class="col-custom <?php echo $item['tp_portfolio_active'] ? 'active' : NULL; ?>">
                <div class="tp-panel-item p-relative">

                    <?php if(!empty($tp_portfolio_image_url)) : ?>
                    <div class="tp-panel-thumb">
                        <img src="<?php echo esc_url($tp_portfolio_image_url); ?>"
                            alt="<?php echo esc_attr($tp_portfolio_image_alt); ?>">
                    </div>
                    <?php endif; ?>

                    <div class="tp-panel-content">
                        <div class="tp-panel-icon mb-15">
                            <span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/panel-icon-3.png" alt=""></span>
                        </div>
                        <div class="tp-panel-text">

                            <?php if(!empty($item['tp_portfolio_box_title'])) : ?>
                            <h4 class="tp-panel-title mb-15 tp-el-rep-title">
                                <?php if(!empty($link)) : ?>
                                <a href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_portfolio_box_title']); ?></a>
                                <?php else : ?>
                                <?php echo tp_kses($item['tp_portfolio_box_title']); ?>
                                <?php endif; ?>
                            </h4>
                            <?php endif; ?>

                            <ul class="tp-panel-meta">
                                <?php if(!empty($item['tp_portfolio_box_sub_title'])) : ?>
                                <li class="tp-el-rep-subtitle"><?php echo tp_kses($item['tp_portfolio_box_sub_title']); ?></li>
                                <?php endif; ?>
                                <?php if(!empty($item['tp_portfolio_box_sub_title2'])) : ?>
                                <li class="tp-el-rep-subtitle"><?php echo tp_kses($item['tp_portfolio_box_sub_title2']); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php endif; 

	}

}

$widgets_manager->register( new TP_Portfolio() );