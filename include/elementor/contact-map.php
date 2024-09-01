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
class TP_Contact_Map extends Widget_Base {

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
		return 'tp-contact-map';
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
		return __( 'Contact Map', 'tpcore' );
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

        
        // tp_section_title
        $this->tp_section_title_render_controls('contact', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', 'layout-1');

        // Process group
        $this->start_controls_section(
            'tp_contact',
            [
                'label' => esc_html__('Process List', 'tpcore'),
                'description' => esc_html__( 'Control all the style settings from Style tab', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
            'tp_contact_title', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Process Title', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_contact_des', [
                'label' => esc_html__('Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('This SEO is most reputed firm', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tp_contact_list',
            [
                'label' => esc_html__('Processs - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_contact_title' => esc_html__('Discover', 'tpcore'),
                    ],
                    [
                        'tp_contact_title' => esc_html__('Define', 'tpcore')
                    ],
                ],
                'title_field' => '{{{ tp_contact_title }}}',
            ]
        );
        
        $this->end_controls_section();

        // layout Panel
        $this->start_controls_section(
            'tp_map',
            [
                'label' => esc_html__('Map', 'tpcore'),
            ]
        );

        $default_address = esc_html__( 'London Eye, London, United Kingdom', 'tpcore' );

        $this->add_control(
            'address',
            [
                'label' => esc_html__( 'Location', 'tpcore' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => $default_address,
                'default' => $default_address,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'zoom',
            [
                'label' => esc_html__( 'Zoom', 'tpcore' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'tpcore' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 40,
                        'max' => 1440,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', 'vh' ],
                'selectors' => [
                    '{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__( 'View', 'tpcore' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();


	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('contact_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', 'layout-1');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', 'layout-1');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', 'layout-1');
        # repeate
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', 'layout-1');
        $this->tp_link_controls_style('rep_title', 'Repeater Title', '.tp-el-rep-title', 'layout-1');
        $this->tp_basic_style_controls('rep_des', 'Repeater Description', '.tp-el-rep-des', 'layout-1');
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

    if ( empty( $settings['address'] ) ) {
        return;
    }

    if ( 0 === absint( $settings['zoom']['size'] ) ) {
        $settings['zoom']['size'] = 10;
    }

    $api_key = esc_html( get_option( 'elementor_google_maps_api_key' ) );

    $params = [
        rawurlencode( $settings['address'] ),
        absint( $settings['zoom']['size'] ),
    ];

    if ( $api_key ) {
        $params[] = $api_key;

        $url = 'https://www.google.com/maps/embed/v1/place?key=%3$s&q=%1$s&amp;zoom=%2$d';
    } else {
        $url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
    }

    $this->add_render_attribute('title_args', 'class', 'map-title tp-el-title');
?>

<section class="map-area map-wrapper tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="map-wrap">
                    <div class="map-content">
                        <?php if ( !empty($settings['tp_contact_sub_title']) ) : ?>
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_contact_sub_title']); ?></span>
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
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_contact_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <ul>

                        <?php foreach ($settings['tp_contact_list'] as $key => $item) : ?>
                        <li>
                            <div class="location">
                                <div class="location-icon">
                                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                    <span class="tp-el-rep-icon">
                                        <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                                    </span>
                                    <?php endif; ?>
                                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                    <span class="tp-el-rep-icon">
                                        <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                                    </span>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                    <span class="tp-el-rep-icon">
                                        <?php echo $item['tp_box_icon_svg']; ?>
                                    </span>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="location-content">
                                    <?php if(!empty($item['tp_contact_title'])) : ?>
                                    <h4 class="location-title tp-el-rep-title"><?php echo tp_kses($item['tp_contact_title']); ?></h4>
                                    <?php endif; ?>
                                    <?php if(!empty($item['tp_contact_des'])) : ?>
                                    <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_contact_des']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <?php if(!empty($settings['address'])) : ?>
                <div class="map-bg">
                    <iframe fr ameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="<?php echo esc_url( vsprintf( $url, $params ) ); ?>"
                            title="<?php echo esc_attr( $settings['address'] ); ?>"
                            aria-label="<?php echo esc_attr( $settings['address'] ); ?>"
                    ></iframe>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php endif; 
	}
}

$widgets_manager->register( new TP_Contact_Map() );