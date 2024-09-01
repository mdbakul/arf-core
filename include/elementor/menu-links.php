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
class TP_Menu_Links extends Widget_Base {

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
		return 'tp-menu-links';
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
		return __( 'Mega Menu Links', 'tpcore' );
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

    protected $nav_menu_index = 1;

    /**
     * Retrieve the menu index.
     *
     * Used to get index of nav menu.
     *
     * @since 1.3.0
     * @access protected
     *
     * @return string nav index.
     */
    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

    private function get_available_menus() {

        $menus = wp_get_nav_menus();

        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }

        return $options;
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
		
		$this->start_controls_section(
		 'tp_list_sec',
			 [
			   'label' => esc_html__( 'Services List', 'tpcore' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			 ]
		);
		
		$this->add_control(
		'tp_menu_link_title',
			[
			'label'   => esc_html__( 'Title', 'tpcore' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Services List', 'tpcore' ),
			'label_block' => true,
			]
		);
		
		$repeater = new \Elementor\Repeater();

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
		'tp_menu_title',
		  [
			'label'   => esc_html__( 'Title', 'tpcore' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Default-value', 'tpcore' ),
			'label_block' => true,
		  ]
		); 

		$repeater->add_control(
		'tp_menu_link',
		  [
			'label'   => esc_html__( 'URL', 'tpcore' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( '#', 'tpcore' ),
			'label_block' => true,
		  ]
		);	

		$this->add_control(
		  'tp_menu_list',
		  [
			'label'       => esc_html__( 'Menu List', 'tpcore' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
			  [
				'tp_menu_title'   => esc_html__( 'Menu Item 1', 'tpcore' ),
			  ],
			  [
				'tp_menu_title'   => esc_html__( 'Menu Item 2', 'tpcore' ),
			  ],
			  [
				'tp_menu_title'   => esc_html__( 'Menu Item 3', 'tpcore' ),
			  ],
			],
			'title_field' => '{{{ tp_menu_title }}}',
		  ]
		);
		
		$this->end_controls_section();

        // tp_section_title
        $this->tp_section_title_render_controls('banner', 'Banner Content',);

		// section btn
        $this->tp_button_render('banner', 'Button');  

        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Banner Thumbnail', 'tp-core'),
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

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('menu_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('ser_title_style', 'Service Title', '.tp-el-ser-title');
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon');
        $this->tp_basic_style_controls('rep_txt_style', 'Repeater Text', '.tp-el-rep-text');
        # section
        $this->tp_basic_style_controls('section_subtitle', 'Section Subtitle', '.tp-el-sub-title');
        $this->tp_basic_style_controls('section_title', 'Section Title', '.tp-el-title');
        $this->tp_basic_style_controls('section_des', 'Section Description', '.tp-el-des');
        $this->tp_link_controls_style('section_btn', 'Section Button', '.tp-el-btn');
        $this->tp_icon_style('section_banner', 'Section Banner', '.tp-el-banner');

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
		// thumbnail
		if ( !empty($settings['tp_image']['url']) ) {
			$tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
			$tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
		}

		// Link
		if ('2' == $settings['tp_banner_btn_link_type']) {
			$this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_banner_btn_page_link']));
			$this->add_render_attribute('tp-button-arg', 'target', '_self');
			$this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
			$this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
		} else {
			if ( ! empty( $settings['tp_banner_btn_link']['url'] ) ) {
				$this->add_link_attributes( 'tp-button-arg', $settings['tp_banner_btn_link'] );
                $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
			}
		} 

		$this->add_render_attribute('title_args', 'class', 'tp-menu-banner-title-2 tp-el-title');    
        
		?>
<div class="tp-mega-menu tp-el-section">
    <div class="row">
        <div class="col-xl-6">
            <div class="tp-menu-banner">
                <?php if(!empty($settings['tp_menu_link_title'])) : ?>
                <h5 class="tp-menu-banner-title tp-el-ser-title"><?php echo tp_kses($settings['tp_menu_link_title']); ?></h5>
                <?php endif; ?>
                <ul>

                    <?php foreach ($settings['tp_menu_list'] as $key => $item) : ?>
                    <li>
                        <a class="tp-el-rep-text" href="<?php echo esc_url($item['tp_menu_link']); ?>">
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
                            <?php echo $item['tp_menu_title'] ? tp_kses($item['tp_menu_title']) : NULL; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="tp-menu-banner-wrap">
                <div class="tp-menu-banner-content">
                    <?php if ( !empty($settings['tp_banner_sub_title']) ) : ?>
                    <span class="tp-el-sub-title"><?php echo tp_kses($settings['tp_banner_sub_title']); ?></span>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_banner_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_banner_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_banner_title' ] )
                        );
                    endif;
                    ?>
                    <?php if ( !empty($settings['tp_banner_description']) ) : ?>
                    <p class="tp-el-des"><?php echo tp_kses( $settings['tp_banner_description'] ); ?></p>
                    <?php endif; ?>

                    <div class="tp-menu-banner-btn">
                        <?php if ( !empty($settings['tp_banner_btn_text']) ) : ?>
                        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_banner_btn_text']); ?><span class="tp-arrow-link">
                                <svg width="9" height="10" viewBox="0 0 9 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1.5L8 8.5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M8 1.5V8.5H1" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span></a>
                        <?php endif; ?>
                    </div>

                </div>
                <?php if(!empty($tp_image)) : ?>
                <div class="tp-menu-banner-thumb tp-el-banner">
                    <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php 
	}
}

$widgets_manager->register( new TP_Menu_Links() );