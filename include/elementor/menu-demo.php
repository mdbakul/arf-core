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
class TP_Menu_Demo extends Widget_Base {

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
		return 'tp-menu-demo';
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
		return __( 'Mega Menu Demo', 'tpcore' );
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


		$this->start_controls_section(
		 'tp_list_sec',
			 [
			   'label' => esc_html__( 'Image List', 'tpcore' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			 ]
		);
		
		$repeater = new \Elementor\Repeater();
		
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
            'tp_image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => __( 'Image', 'tpcore' ),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );  

		$repeater->add_control(
		'tp_button_title',
		  [
			'label'   => esc_html__( 'Button Title', 'tpcore' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Button 1', 'tpcore' ),
			'label_block' => true,
		  ]
		);

		$repeater->add_control(
		'tp_menu_multi_page_url',
		  [
			'label'   => esc_html__( 'Multipage URL', 'tpcore' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( '#', 'tpcore' ),
			'label_block' => true,
		  ]
		);	

		$repeater->add_control(
		'tp_button_title2',
		  [
			'label'   => esc_html__( 'Button Title 2', 'tpcore' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Button 2', 'tpcore' ),
			'label_block' => true,
		  ]
		);	

		$repeater->add_control(
		'tp_menu_one_page_url',
		  [
			'label'   => esc_html__( 'Onepage URL', 'tpcore' ),
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

    protected function style_tab_content(){
        $this->tp_section_style_controls('menu_section', 'Section - Style', '.tp-el-section');
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG/Image/SVG', '.tp-el-rep-icon');
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title');
        $this->tp_link_controls_style('rep_btn1_style', 'Repeater Button 1', '.tp-el-rep-btn1');
        $this->tp_link_controls_style('rep_btn2_style', 'Repeater Button 2', '.tp-el-rep-btn2');
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
        <div class='tp-submenus submenus has-homemenu tp-mega-menu tp-el-section'>
        <div class="row gx-6 row-cols-1 row-cols-md-2 row-cols-xl-5">
            <?php foreach ($settings['tp_menu_list'] as $key => $item) :
                if ( !empty($item['tp_image']['url']) ) {
                    $tp_image_url = !empty($item['tp_image']['id']) ? wp_get_attachment_image_url( $item['tp_image']['id'], $settings['thumbnail_size']) : $item['tp_image']['url'];
                    $tp_image_alt = get_post_meta($item["tp_image"]["id"], "_wp_attachment_image_alt", true);
                } 
                
            ?>
            <div class="col homemenu active">
                <div class="homemenu-thumb tp-el-rep-icon">
                    <img src="<?php echo esc_url($tp_image_url); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                </div>
                <div class="homemenu-btn">
					<?php if(!empty($item['tp_button_title'])) : ?>
                    <a class="menu-btn mb-5 tp-el-rep-btn1" href="<?php echo esc_url($item['tp_menu_multi_page_url']); ?>"><?php echo tp_kses($item['tp_button_title']); ?></a>
					<?php endif; ?>
					<?php if(!empty($item['tp_button_title2'])) : ?>
                    <a class="menu-btn tp-el-rep-btn2" href="<?php echo esc_url($item['tp_menu_one_page_url']); ?>"><?php echo tp_kses($item['tp_button_title2']); ?></a>
					<?php endif; ?>
                </div>
                <div class="demo-name">
                    <span class="tp-el-rep-title"><?php echo esc_html($item['tp_menu_title']) ?></span>
                </div>
            </div>
            <?php endforeach; ?>   
        </div>
        </div>



<?php 
	}
}

$widgets_manager->register( new TP_Menu_Demo() );