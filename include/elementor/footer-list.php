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
class TP_Footer_list extends Widget_Base {

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
        return 'tp-footer-list';
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
        return __( 'Footer List', 'tpcore' );
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
                    'layout-3' => esc_html__('Layout 3', 'tpcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // Service group
        $this->start_controls_section(
            'tp_services',
            [
                'label' => esc_html__('Footer List', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tp_footer_title', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Footer Title', 'tpcore'),
                'label_block' => true,
            ]
        );

        
        $this->add_control(
            'tp_footer_2_column',
            [
                'label' => esc_html__( 'Enable 2 Columns', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 0,
                'separator' => 'before',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tp_footer_link_switcher',
            [
                'label' => esc_html__( 'Add Footer link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'tp_footer_btn_text',
            [
                'label' => esc_html__('Link Text', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Link Text', 'tpcore'),
                'title' => esc_html__('Enter link text', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'tp_footer_link_switcher' => 'yes'
                ],
            ]
        );
        $repeater->add_control(
            'tp_footer_link_type',
            [
                'label' => esc_html__( 'Footer Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_footer_link_switcher' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'tp_footer_link',
            [
                'label' => esc_html__( 'Footer Link link', 'tpcore' ),
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
                    'tp_footer_link_type' => '1',
                    'tp_footer_link_switcher' => 'yes',
                ]
            ]
        );
        $repeater->add_control(
            'tp_footer_page_link',
            [
                'label' => esc_html__( 'Select Footer Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_footer_link_type' => '2',
                    'tp_footer_link_switcher' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tp_footer_list',
            [
                'label' => esc_html__('Footer - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_footer_btn_text' => esc_html__('Footer Link 1', 'tpcore'),
                    ],
                    [
                        'tp_footer_btn_text' => esc_html__('Footer Link 2', 'tpcore')
                    ],
                    [
                        'tp_footer_btn_text' => esc_html__('Footer Link 3', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_footer_btn_text }}}',
            ]
        );
        $this->end_controls_section();

    }

    protected function style_tab_content(){
        $this->tp_section_style_controls('footer_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_heading', 'Section - Title', '.tp-el-heading');
        $this->tp_link_controls_style('footer_title', 'Links', '.tp-el-title');
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
            $this->add_render_attribute('title_args', 'class', 'sectionTitle__big');
        ?>

        <div class="footer-widget footer-col-2 mb-40 tp-el-section <?php echo $settings['tp_footer_2_column'] ? "enable-2-columns" : NULL; ?>">
            <?php if (!empty($settings['tp_footer_title'])) : ?>
            <h4 class="footer-widget-title mb-15 tp-el-heading"><?php echo esc_html($settings['tp_footer_title']); ?></h4>
            <?php endif; ?>
            <div class="footer-widget-link">
                <ul>
                    <?php foreach ($settings['tp_footer_list'] as $key => $item) :
                        // Link
                        if ('2' == $item['tp_footer_link_type']) {
                            $link = get_permalink($item['tp_footer_page_link']);
                            $target = '_self';
                            $rel = 'nofollow';
                        } else {
                            $link = !empty($item['tp_footer_link']['url']) ? $item['tp_footer_link']['url'] : '';
                            $target = !empty($item['tp_footer_link']['is_external']) ? '_blank' : '';
                            $rel = !empty($item['tp_footer_link']['nofollow']) ? 'nofollow' : '';
                        }
                    ?>
                    <li>
                        <a class="tp-el-title" target="<?php echo esc_attr($target); ?>" rel="<?php echo esc_attr($rel); ?>" href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_footer_btn_text']); ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <?php elseif ( $settings['tp_design_style']  == 'layout-3' ):
            $this->add_render_attribute('title_args', 'class', 'sectionTitle__big');
        ?>

        <div class="footer-bg3">
            <div class="footer-widget footer-hover-two footer-3-col-2 tp-el-section pl-30 mb-40 <?php echo $settings['tp_footer_2_column'] ? "enable-2-columns" : NULL; ?>">
                <?php if (!empty($settings['tp_footer_title'])) : ?>
                <h4 class="footer-widget-title mb-15 tp-el-heading"><?php echo esc_html($settings['tp_footer_title']); ?></h4>
                <?php endif; ?>
                <div class="footer-widget-link">
                    <ul>
                        <?php foreach ($settings['tp_footer_list'] as $key => $item) :
                            // Link
                            if ('2' == $item['tp_footer_link_type']) {
                                $link = get_permalink($item['tp_footer_page_link']);
                                $target = '_self';
                                $rel = 'nofollow';
                            } else {
                                $link = !empty($item['tp_footer_link']['url']) ? $item['tp_footer_link']['url'] : '';
                                $target = !empty($item['tp_footer_link']['is_external']) ? '_blank' : '';
                                $rel = !empty($item['tp_footer_link']['nofollow']) ? 'nofollow' : '';
                            }
                        ?>
                        <li>
                            <a class="tp-el-title" target="<?php echo esc_attr($target); ?>" rel="<?php echo esc_attr($rel); ?>" href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_footer_btn_text']); ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <?php else:
            $this->add_render_attribute('title_args', 'class', 'title');
        ?>


        <div class="footer-widget tpfooter-hover footer-5-col-2 mb-40 tp-el-section <?php echo $settings['tp_footer_2_column'] ? "enable-2-columns" : NULL; ?>">
            <?php if (!empty($settings['tp_footer_title'])) : ?>
            <h4 class="footer-widget-title mb-15 tp-el-heading"><?php echo esc_html($settings['tp_footer_title']); ?></h4>
            <?php endif; ?>
            <div class="footer-widget-link">
                <ul>
                    <?php foreach ($settings['tp_footer_list'] as $key => $item) :
                        // Link
                        if ('2' == $item['tp_footer_link_type']) {
                            $link = get_permalink($item['tp_footer_page_link']);
                            $target = '_self';
                            $rel = 'nofollow';
                        } else {
                            $link = !empty($item['tp_footer_link']['url']) ? $item['tp_footer_link']['url'] : '';
                            $target = !empty($item['tp_footer_link']['is_external']) ? '_blank' : '';
                            $rel = !empty($item['tp_footer_link']['nofollow']) ? 'nofollow' : '';
                        }
                    ?>
                    <li>
                        <a class="tp-el-title" target="<?php echo esc_attr($target); ?>" rel="<?php echo esc_attr($rel); ?>" href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_footer_btn_text']); ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

<?php endif;
    }
}

$widgets_manager->register( new TP_Footer_list() );
