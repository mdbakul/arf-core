<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
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
class TP_About_Tab extends Widget_Base {

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
        return 'tp-about-tab';
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
        return __( 'About Tab', 'tpcore' );
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

        $this->tp_section_title_render_controls('abtab', 'Section Title', 'Sub Title', 'your title here', 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', 'layout-1');

        // About Tab group
        $this->start_controls_section(
            'tp_abtab',
            [
                'label' => esc_html__('About Tab List', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tp_tab_active',
            [
                'label' => esc_html__( 'Active This', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 0,
                'separator' => 'before',
            ]
        );

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
            'tp_abtab_rep_title', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('About Tab Title', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        // img
        $repeater->add_control(
            'tp_image',
            [
                'label' => esc_html__('Upload Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_image2',
            [
                'label' => esc_html__('Upload Image 2', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_image3',
            [
                'label' => esc_html__('Upload Image 3', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_image4',
            [
                'label' => esc_html__('Upload Image 4', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'tp_image5',
            [
                'label' => esc_html__('Upload Image 5', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tp_image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                'default' => 'full',
            ]
        );

        $this->add_control(
            'tp_abtab_list',
            [
                'label' => esc_html__('About Tab - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_abtab_rep_title' => esc_html__('Business Stratagy', 'tpcore'),
                    ],
                    [
                        'tp_abtab_rep_title' => esc_html__('Website Development', 'tpcore')
                    ],
                    [
                        'tp_abtab_rep_title' => esc_html__('Marketing & Reporting', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_abtab_rep_title }}}',
            ]
        );
        
        $this->end_controls_section();


    }

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('abtab_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', 'layout-1');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', 'layout-1');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', 'layout-1');
        $this->tp_basic_style_controls('rep_title', 'Repeater Title', '.tp-el-rep-title', 'layout-1');
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
    $this->add_render_attribute('title_args', 'class', 'section-title-4 fs-54 tp-el-title');
?>

<section class="about-area pb-20 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 order-lg-1 order-2">
                <div class="about-inner-thums mb-60">
                    <div class="d-flex align-items-start">
                        <div class="tab-content" id="tool-v-pills-tabContent">

                            <?php foreach($settings['tp_abtab_list'] as $key => $item) :

                                $active_show = $item['tp_tab_active'] ? 'active show' : NULL ; 
                                
                                // thumbnail
                                if ( !empty($item['tp_image']['url']) ) {
                                    $tp_image = !empty($item['tp_image']['id']) ? wp_get_attachment_image_url( $item['tp_image']['id'], $item['tp_image_size']) : $item['tp_image']['url'];
                                    $tp_image_alt = get_post_meta($item["tp_image"]["id"], "_wp_attachment_image_alt", true);
                                }   
                                if ( !empty($item['tp_image2']['url']) ) {
                                    $tp_image2 = !empty($item['tp_image2']['id']) ? wp_get_attachment_image_url( $item['tp_image2']['id'], $item['tp_image_size']) : $item['tp_image2']['url'];
                                    $tp_image_alt2 = get_post_meta($item['tp_image2']["id"], "_wp_attachment_image_alt", true);
                                }  
                                if ( !empty($item['tp_image3']['url']) ) {
                                    $tp_image3 = !empty($item['tp_image3']['id']) ? wp_get_attachment_image_url( $item['tp_image3']['id'], $item['tp_image_size']) : $item['tp_image3']['url'];
                                    $tp_image_alt3 = get_post_meta($item['tp_image3']["id"], "_wp_attachment_image_alt", true);
                                }   
                                if ( !empty($item['tp_image4']['url']) ) {
                                    $tp_image4 = !empty($item['tp_image4']['id']) ? wp_get_attachment_image_url( $item['tp_image4']['id'], $item['tp_image_size']) : $item['tp_image4']['url'];
                                    $tp_image_alt4 = get_post_meta($item['tp_image4']["id"], "_wp_attachment_image_alt", true);
                                } 
                                if ( !empty($item['tp_image5']['url']) ) {
                                    $tp_image5 = !empty($item['tp_image5']['id']) ? wp_get_attachment_image_url( $item['tp_image5']['id'], $item['tp_image_size']) : $item['tp_image5']['url'];
                                    $tp_image_alt5 = get_post_meta($item['tp_image5']["id"], "_wp_attachment_image_alt", true);
                                }       
                            ?>
                            <div class="tab-pane fade <?php echo esc_attr($active_show); ?>" id="tool-v-pills-<?php echo esc_attr($key+1); ?>" role="tabpanel"
                                aria-labelledby="tool-v-pills-<?php echo esc_attr($key+1); ?>-tab" tabindex="0">
                                <div class="seo-5-thumb seo-inner-shape p-relative mb-40">
                                    <?php if(!empty($tp_image)) : ?>
                                    <div class="seo-5-main-bg">
                                        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                                    </div>
                                    <?php endif; ?>
                                    <div class="seo-5-shape d-none d-md-block">
                                        <?php if(!empty($tp_image2)) : ?>
                                        <div class="seo-5-shape-one" data-parallax='{"x": -100, "smoothness": 20}'>
                                            <img src="<?php echo esc_url($tp_image2); ?>" alt="<?php echo esc_attr($tp_image_alt2); ?>">
                                        </div>
                                        <?php endif; ?>
                                        <?php if(!empty($tp_image3)) : ?>
                                        <div class="seo-5-shape-two" data-parallax='{"y": -80, "smoothness": 20}'>
                                            <img src="<?php echo esc_url($tp_image3); ?>" alt="<?php echo esc_attr($tp_image_alt3); ?>">
                                        </div>
                                        <?php endif; ?>
                                        <?php if(!empty($tp_image4)) : ?>
                                        <div class="seo-5-shape-three">
                                            <img src="<?php echo esc_url($tp_image4); ?>" alt="<?php echo esc_attr($tp_image_alt4); ?>">
                                        </div>
                                        <?php endif; ?>
                                        <?php if(!empty($tp_image5)) : ?>
                                        <div class="seo-5-shape-four" data-parallax='{"x": -50, "smoothness": 20}'>
                                            <img src="<?php echo esc_url($tp_image5); ?>" alt="<?php echo esc_attr($tp_image_alt5); ?>">
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-1">
                <div class="about-inner-wrapper mb-60 mt-25">
                    <div class="optimize-subtitle pl-100 mb-50">
                        <?php if ( !empty($settings['tp_abtab_sub_title']) ) : ?>
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_abtab_sub_title']); ?></span>
                        <?php endif; ?>
                        <?php
                            if ( !empty($settings['tp_abtab_title' ]) ) :
                                printf( '<%1$s %2$s>%3$s</%1$s>',
                                tag_escape( $settings['tp_abtab_title_tag'] ),
                                $this->get_render_attribute_string( 'title_args' ),
                                tp_kses( $settings['tp_abtab_title' ] )
                                );
                            endif;
                        ?>
                        <?php if ( !empty($settings['tp_abtab_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_abtab_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="nav flex-column nav-pills nav-tab-area pr-170 pl-40" id="tool-v-pills-tab"
                        role="tablist" aria-orientation="vertical">

                        <?php foreach($settings['tp_abtab_list'] as $key => $item) : 
                            $active = $item['tp_tab_active'] ? 'active' : NULL ;    
                            $aria = $item['tp_tab_active'] ? 'false' : 'true' ;    
                        ?>
                        <button class="nav-link tp-el-rep-title <?php echo esc_attr($active); ?>" id="tool-v-pills-<?php echo esc_attr($key+1); ?>-tab" data-bs-toggle="pill"
                            data-bs-target="#tool-v-pills-<?php echo esc_attr($key+1); ?>" type="button" role="tab"
                            aria-controls="tool-v-pills-<?php echo esc_attr($key+1); ?>" aria-selected="<?php echo esc_attr($aria); ?>">
                            <span>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 7H1" stroke="#010F1C" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M7 1L1 7L7 13" stroke="#010F1C" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <?php echo $item['tp_abtab_rep_title' ] ? tp_kses($item['tp_abtab_rep_title' ]) : NULL; ?></button>
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

$widgets_manager->register( new TP_About_Tab() ); 