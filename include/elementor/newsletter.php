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
class TP_Newsletter extends Widget_Base {

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
		return 'tp-newsletter';
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
		return __( 'Newsletter', 'tp-core' );
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
                    'layout-3' => esc_html__('Layout 3', 'tp-core'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        $this->tp_section_title_render_controls('newsletter', 'Section Title', 'Sub Title', 'your title here', 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2', 'layout-3']);

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
            'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // Category List
        $this->start_controls_section(
        'newsletter_category_list_sec',
            [
                'label' => esc_html__( 'Category List', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-3']
                ]
            ]
        );
        
        $this->add_control(
        'category_heading',
            [
                'label'   => esc_html__( 'Category Heading', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Try:', 'tpcore' ),
                'label_block' => true,
            ]
        );
        
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
        'repeater_condition',
            [
                'label' => __( 'Field condition', 'tpcore' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style_1' => __( 'Style 1', 'tpcore' ),
                    'style_2' => __( 'Style 2', 'tpcore' ),
                    'style_3' => __( 'Style 3', 'tpcore' ),
                ],
                'default' => 'style_1',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );
        
        $repeater->add_control(
        'category_title',
            [
                'label'   => esc_html__( 'Title', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'See the action in live', 'tpcore' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_newsletter_link_switcher',
            [
                'label' => esc_html__( 'Add About link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        
        $repeater->add_control(
            'tp_newsletter_link_type',
            [
                'label' => esc_html__( 'About Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_newsletter_link_switcher' => 'yes',
                ]
            ]
        );

        $repeater->add_control(
            'tp_newsletter_link',
            [
                'label' => esc_html__( 'About Link link', 'tpcore' ),
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
                    'tp_newsletter_link_type' => '1',
                    'tp_newsletter_link_switcher' => 'yes',
                ]
            ]
        );
        $repeater->add_control(
            'tp_newsletter_page_link',
            [
                'label' => esc_html__( 'Select About Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_newsletter_link_type' => '2',
                    'tp_newsletter_link_switcher' => 'yes',
                ]
            ]
        );
        
        $this->add_control(
            'newsletter_category_list',
            [
            'label'       => esc_html__( 'Cagegory List', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                'category_title'   => esc_html__( 'Design', 'tpcore' ),
                ],
                [
                'category_title'   => esc_html__( 'Development', 'tpcore' ),
                ],
            ],
            'title_field' => '{{{ category_title }}}',
            ]
        );
        
        $this->end_controls_section();

        // Process group
        $this->start_controls_section(
            'tp_process',
            [
                'label' => esc_html__('Process List', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tp_design_style' => 'layout-2'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

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
                    ]
                ]
            );
        }

        $repeater->add_control(
            'tp_process_title', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Process Title', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_process_des', [
                'label' => esc_html__('Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('This SEO is most reputed firm', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tp_process_list',
            [
                'label' => esc_html__('Processs - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_process_title' => esc_html__('Discover', 'tpcore'),
                    ],
                    [
                        'tp_process_title' => esc_html__('Define', 'tpcore')
                    ],
                    [
                        'tp_process_title' => esc_html__('Develop', 'tpcore')
                    ],
                ],
                'title_field' => '{{{ tp_process_title }}}',
            ]
        );
        
        $this->end_controls_section();

        
        // shape
        $this->start_controls_section(
        'tp_shape',
            [
                'label' => esc_html__( 'Shape Section', 'tpcore' ),
                'condition' => [
                    'tp_design_style' => 'layout-2'
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
        
        $this->end_controls_section();
        
	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('newsletter_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('cat_heading', 'Category Heading', '.tp-el-cat-head', ['layout-1', 'layout-3']);
        $this->tp_link_controls_style('cat_list', 'Category List', '.tp-el-cat-list', ['layout-1', 'layout-3']);
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', 'layout-2');
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', 'layout-2');
        $this->tp_basic_style_controls('rep_des_style', 'Repeater Description', '.tp-el-rep-des', 'layout-2');
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
    $this->add_render_attribute('title_args', 'class', 'cta-inner-title tp-el-title');    
?>

<section class="cta-area cta-inner-bg theme-bg-2 tp-el-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="cta-inner-wrapper text-center">
                    <div class="cta-inner">
                        <?php if ( !empty($settings['tp_newsletter_sub_title']) ) : ?>
                        <p class="text-white tp-el-subtitle"><?php echo tp_kses($settings['tp_newsletter_sub_title']); ?></p>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_newsletter_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_newsletter_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_newsletter_title' ] )
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_newsletter_description']) ) : ?>
                        <p class="text-white tp-el-content"><?php echo tp_kses( $settings['tp_newsletter_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="cta-inner-form">
                        <?php if( !empty($settings['form_shortcode']) ) : ?>
                        <?php echo do_shortcode( $settings['form_shortcode'] ); ?>
                        <?php else : ?>
                        <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
                        <?php endif; ?>
                    </div>
                    <div class="cta-inner-award d-flex align-items-center justify-content-between pl-70 pr-70">
                        <?php foreach ($settings['tp_process_list'] as $key => $item) : ?>
                        <div class="cta-award-item text-center mb-30">
                            <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                            <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                            <div class="cta-award-icon tp-el-rep-icon">
                                <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                            </div>
                            <?php endif; ?>
                            <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                            <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                            <div class="cta-award-icon tp-el-rep-icon">
                                <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                    alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                            </div>
                            <?php endif; ?>
                            <?php else : ?>
                            <?php if (!empty($item['tp_box_icon_svg'])): ?>
                            <div class="cta-award-icon tp-el-rep-icon">
                                <?php echo $item['tp_box_icon_svg']; ?>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                            <div class="cta-award-content">
                                <?php if(!empty($item['tp_process_title'])) : ?>
                                <h4 class="cta-award-title tp-el-rep-title"><?php echo tp_kses($item['tp_process_title']); ?></h4>
                                <?php endif; ?>
                                <?php if(!empty($item['tp_process_des'])) : ?>
                                <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_process_des']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($settings['tp_shape_switch'])) : ?>
    <div class="cta-inner-shape">
        <img class="cta-inner-shape-1"
            src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-1.png" alt="shape">
        <img class="cta-inner-shape-2"
            src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-2.png" alt="shape">
        <img class="cta-inner-shape-3"
            src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-3.png" alt="shape">
        <img class="cta-inner-shape-4"
            src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-4.png" alt="shape">
        <img class="cta-inner-shape-5"
            src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-5.png" alt="shape">
        <img class="cta-inner-shape-6"
            src="<?php echo get_template_directory_uri(); ?>/assets/img/cta/cta-inner-shape-6.png" alt="shape">
    </div>
    <?php endif; ?>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : 
    $this->add_render_attribute('title_args', 'class', 'keyword-inner-title tp-el-title');    
?>

<section class="keyword-area cta-position">
    <div class="keyword-inner-shape">
        <div class="container">
            <div class="keyword-inner-bg inner-cta-bg pt-70 pb-90 tp-el-section" >
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="keyword-inner text-center">
                            <div class="keyword-inner-content">
                                <?php if ( !empty($settings['tp_newsletter_sub_title']) ) : ?>
                                <p class="text-white tp-el-subtitle"><?php echo tp_kses($settings['tp_newsletter_sub_title']); ?></p>
                                <?php endif; ?>
                                <?php
                                if ( !empty($settings['tp_newsletter_title' ]) ) :
                                    printf( '<%1$s %2$s>%3$s</%1$s>',
                                    tag_escape( $settings['tp_newsletter_title_tag'] ),
                                    $this->get_render_attribute_string( 'title_args' ),
                                    tp_kses( $settings['tp_newsletter_title' ] )
                                    );
                                endif;
                                ?>
                                <?php if ( !empty($settings['tp_newsletter_description']) ) : ?>
                                <p class="text-white tp-el-content"><?php echo tp_kses( $settings['tp_newsletter_description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="keyword-search mb-20">
                                <div class="tpbanner__search">
                                    <?php if( !empty($settings['form_shortcode']) ) : ?>
                                    <?php echo do_shortcode( $settings['form_shortcode'] ); ?>
                                    <?php else : ?>
                                    <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="keyword-search-tag">
                                <?php if(!empty($settings['category_heading'])) : ?>
                                <span class="tp-el-cat-head"><?php echo tp_kses($settings['category_heading']); ?></span>
                                <?php endif; ?>
                                <?php foreach($settings['newsletter_category_list'] as $key => $item) : 
                                    // Link
                                    if ('2' == $item['tp_newsletter_link_type']) {
                                        $link = get_permalink($item['tp_newsletter_page_link']);
                                        $target = '_self';
                                        $rel = 'nofollow';
                                    } else {
                                        $link = !empty($item['tp_newsletter_link']['url']) ? $item['tp_newsletter_link']['url'] : '';
                                        $target = !empty($item['tp_newsletter_link']['is_external']) ? '_blank' : '';
                                        $rel = !empty($item['tp_newsletter_link']['nofollow']) ? 'nofollow' : '';
                                    }    
                                ?>
                                <?php if(!empty($link)) : ?>
                                <a class="tp-el-cat-list" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
                                    rel="<?php echo esc_attr($rel); ?>"><?php echo tp_kses($item['category_title']); ?></a>
                                <?php else : ?>
                                <h5 class="text-white mr-5 tp-el-cat-list"><?php echo tp_kses($item['category_title']); ?></h5>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else:
    $this->add_render_attribute('title_args', 'class', 'keyword-inner-title tp-el-title');
?>

<section class="keyword-area keyword-inner-wrapper keyword-inner-bg pt-105 pb-120 tp-el-section">
    <div class="keyword-inner-shape">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="keyword-inner text-center">
                        <div class="keyword-inner-content">
                            <?php if ( !empty($settings['tp_newsletter_sub_title']) ) : ?>
                            <p class="text-white tp-el-subtitle"><?php echo tp_kses($settings['tp_newsletter_sub_title']); ?></p>
                            <?php endif; ?>
                            <?php
                            if ( !empty($settings['tp_newsletter_title' ]) ) :
                                printf( '<%1$s %2$s>%3$s</%1$s>',
                                tag_escape( $settings['tp_newsletter_title_tag'] ),
                                $this->get_render_attribute_string( 'title_args' ),
                                tp_kses( $settings['tp_newsletter_title' ] )
                                );
                            endif;
                            ?>
                            <?php if ( !empty($settings['tp_newsletter_description']) ) : ?>
                            <p class="tp-el-content"><?php echo tp_kses( $settings['tp_newsletter_description'] ); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="keyword-search mb-25">
                            <div class="tpbanner__search">
                                <?php if( !empty($settings['form_shortcode']) ) : ?>
                                <?php echo do_shortcode( $settings['form_shortcode'] ); ?>
                                <?php else : ?>
                                <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="keyword-search-tag">
                            <?php if(!empty($settings['category_heading'])) : ?>
                            <span class="tp-el-cat-head"><?php echo tp_kses($settings['category_heading']); ?></span>
                            <?php endif; ?>

                            <?php foreach($settings['newsletter_category_list'] as $key => $item) : 
                                // Link
                                if ('2' == $item['tp_newsletter_link_type']) {
                                    $link = get_permalink($item['tp_newsletter_page_link']);
                                    $target = '_self';
                                    $rel = 'nofollow';
                                } else {
                                    $link = !empty($item['tp_newsletter_link']['url']) ? $item['tp_newsletter_link']['url'] : '';
                                    $target = !empty($item['tp_newsletter_link']['is_external']) ? '_blank' : '';
                                    $rel = !empty($item['tp_newsletter_link']['nofollow']) ? 'nofollow' : '';
                                }    
                            ?>
                            <?php if(!empty($link)) : ?>
                            <a class="tp-el-cat-list" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
                                rel="<?php echo esc_attr($rel); ?>"><?php echo tp_kses($item['category_title']); ?></a>
                            <?php else : ?>
                            <h5 class="text-white mr-5 tp-el-cat-list"><?php echo tp_kses($item['category_title']); ?></h5>
                            <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; 
        
	}
}

$widgets_manager->register( new TP_Newsletter() );