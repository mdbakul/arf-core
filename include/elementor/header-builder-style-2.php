<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Header_02 extends Widget_Base {

    use \TPCore\Widgets\TPCoreElementFunctions;
    use \TPCore\Widgets\tpTraitBuilder;

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
		return 'tp-header-2';
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
		return __( 'Header Builder 2', 'tpcore' );
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
     * Menu index.
     *
     * @access protected
     * @var $nav_menu_index
     */
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

    /**
     * Retrieve the list of available menus.
     *
     * Used to get the list of available menus.
     *
     * @since 1.3.0
     * @access private
     *
     * @return array get WordPress menus list.
     */
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

	protected function register_controls_section() {

       

        // layout Panel
        $this->start_controls_section(
            'tp_header_top',
            [
                'label' => esc_html__('Header Info', 'tpcore'),
            ]
        ); 
            
        $this->add_control(
            'tp_header_right_switch',
            [
                'label' => esc_html__( 'Header Right Switch', 'tpcore' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tpcore' ),
                'label_off' => esc_html__( 'Hide', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 0,
            ]
        );        

        $this->add_control(
            'tp_header_search_switch',
            [
                'label' => esc_html__( 'Header Search Switch', 'tpcore' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tpcore' ),
                'label_off' => esc_html__( 'Hide', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 0,
            ]
        );   

        $this->add_control(
            'tp_header_trans_switch',
            [
                'label' => esc_html__( 'Header Transparent Switch', 'tpcore' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tpcore' ),
                'label_off' => esc_html__( 'Hide', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 0,
            ]
        );  

        $this->add_control(
            'tp_header_one_active',
            [
                'label' => esc_html__( 'Header One Page Active?', 'tpcore' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tpcore' ),
                'label_off' => esc_html__( 'Hide', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 0,
            ]
        );  
        $this->end_controls_section();

		// _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Site Logo', 'tp-core'),
            ]
        );

        $this->add_control(
            'tp_image',
            [
                'label' => esc_html__( 'Choose Logo', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'tp_image_size',
				'label'   => __( 'Image Size', 'header-footer-elementor' ),
				'default' => 'medium',
			]
		);

        $this->end_controls_section();


		$this->start_controls_section(
            'section_menu',
            [
                'label' => __( 'Menu', 'header-footer-elementor' ),
            ]
        );

        $menus = $this->get_available_menus();

        if ( ! empty( $menus ) ) {
            $this->add_control(
                'menu',
                [
                    'label'        => __( 'Menu', 'header-footer-elementor' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys( $menus )[0],
                    'save_default' => true,
                    /* translators: %s Nav menu URL */
                    'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'header-footer-elementor' ), admin_url( 'nav-menus.php' ) ),
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    /* translators: %s Nav menu URL */
                    'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'header-footer-elementor' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        $this->add_control(
            'menu_last_item',
            [
                'label'     => __( 'Last Menu Item', 'header-footer-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'none' => __( 'Default', 'header-footer-elementor' ),
                    'cta'  => __( 'Button', 'header-footer-elementor' ),
                ],
                'default'   => 'none',
                'condition' => [
                    'layout!' => 'expandible',
                ],
            ]
        );

        $this->end_controls_section();

        $this->tp_builder_button_links('rBtn1', 'Right Button 1');


        $this->start_controls_section(
         'tp_offcanvas_secs',
             [
               'label' => esc_html__( 'Offcanvas Controls', 'tpcore' ),
               'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
             ]
        );
        

        $this->add_control(
               'tp_side_logo',
               [
                  'label' => esc_html__( 'Choose Logo', 'tp-core' ),
                  'type' => \Elementor\Controls_Manager::MEDIA,
                  'default' => [
                     'url' => \Elementor\Utils::get_placeholder_image_src(),
                  ],
               ]
         );
         
         $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
               'name'    => 'tp_side_logo_size',
               'label'   => __( 'Image Size', 'header-footer-elementor' ),
               'default' => 'medium',
            ]
         );

        $this->add_control(
            'tp_ofc_phone',
            [
                'label' => esc_html__('Phone Number', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('0123456789', 'tpcore'),
                'label_block' => true,
                'description' => tp_get_allowed_html_desc( 'basic' ),
            ]
        );


        $this->add_control(
            'tp_ofc_email',
            [
                'label' => esc_html__('Email Address', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('seomy@gmail.com', 'tpcore'),
                'label_block' => true,
                'description' => tp_get_allowed_html_desc( 'basic' ),
            ]
        );

        $this->end_controls_section();

        $this->tp_builder_button_links2('ofcBtn', 'Offcanvas Button');

        // Social Icon
        $this->start_controls_section(
        'tp_ofc_social_sec',
            [
                'label' => esc_html__( 'Offcanvas Social', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
            'tp_ofc_social_link',
            [
                'label' => esc_html__('Social Link', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('#', 'tpcore'),
                'label_block' => true,
                'description' => tp_get_allowed_html_desc( 'basic' ),
            ]
        );
            
        $this->add_control(
            'tp_ofc_social_list',
            [
            'label'       => esc_html__( 'Social Icon List', 'tpcore' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                'tp_ofc_social_link'   => esc_html__( 'fb.com', 'tpcore' ),
                ],
                [
                'tp_ofc_social_link'   => esc_html__( 'tw.com', 'tpcore' ),
                ],
            ],
            ]
        );
           
        $this->end_controls_section();
   

	}


    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('header_section', 'Section - Style', '.tp-el-section');
        $this->tp_icon_style('logo_style', 'Logo', '.tp-el-logo');
        $this->tp_link_controls_style('menu_style', 'Menu', '.tp-el-menu a');
        $this->tp_icon_style('search_style', 'Search', '.tp-el-search');
        $this->tp_link_controls_style('btn1_style', 'Button 1', '.tp-el-btn1');
        # offcanvas
        $this->tp_icon_style('off_logo_style', 'Offcanvas Logo', '.tp-el-off-logo');
        $this->tp_link_controls_style('off_btn_style', 'Offcanvas Button', '.tp-el-off-btn');
        $this->tp_link_controls_style('off_num_style', 'Offcanvas Number', '.tp-el-off-num');
        $this->tp_link_controls_style('off_mail_style', 'Offcanvas Email', '.tp-el-off-mail');
        $this->tp_link_controls_style('off_social_style', 'Offcanvas Social', '.tp-el-off-social');
    }

    protected function tp_search_form(){
        ?>

        <div class="tp-search-area p-relative">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="tp-search-form p-relative">
                            <form action="<?php print esc_url( home_url( '/' ) );?>">
                                <input type="search" name="s" value="<?php print esc_attr( get_search_query() )?>" placeholder="<?php print esc_attr__( 'Type here to search...', 'seomy' );?>">
                                <button type="submit" class="search-submit-icon">
                                    <i>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M19.0001 19L17.2001 17.2" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
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

        $one_page_active = $settings['tp_header_one_active'] ? 'tp-onepage-menu' : NULL;

      
        $menus = $this->get_available_menus();

        if ( empty( $menus ) ) {
            return false;
        }

        require_once get_parent_theme_file_path(). '/inc/class-navwalker.php';

        $args = [
            'echo'        => false,
            'menu'        => $settings['menu'],
            'menu_class' => 'tp-nav-menu ' . $one_page_active ,
            'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'fallback_cb' => 'Seomy_Navwalker_Class::fallback',
            'container'   => '',
            'walker'         => new Seomy_Navwalker_Class,
        ];

        $menu_html = wp_nav_menu( $args );

        // group image size
        $size = $settings['tp_image_size_size'];        

		if ( 'custom' !== $size ) {
			$image_size = $size;
		} else {
        	require_once ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php';
			$image_dimension = $settings['tp_image_size_custom_dimension'];
			$image_size = [
				// Defaults sizes.
				0           => null, // Width.
				1           => null, // Height.

				'bfi_thumb' => true,
				'crop'      => true,
			];
			$has_custom_size = false;
			if ( ! empty( $image_dimension['width'] ) ) {
				$has_custom_size = true;
				$image_size[0]   = $image_dimension['width'];
			}

			if ( ! empty( $image_dimension['height'] ) ) {
				$has_custom_size = true;
				$image_size[1]   = $image_dimension['height'];
			}

			if ( ! $has_custom_size ) {
				$image_size = 'full';
			}
		}

        // side logo image size
        $side_logo_image_size = $settings['tp_side_logo_size_size'];    

	    if ( !empty($settings['tp_image']['url']) ) {
	        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $image_size, true) : $settings['tp_image']['url'];
	        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
	    }	
        
	    if ( !empty($settings['tp_side_logo']['url']) ) {
	        $tp_side_logo = !empty($settings['tp_side_logo']['id']) ? wp_get_attachment_image_url( $settings['tp_side_logo']['id'], $side_logo_image_size, true) : $settings['tp_side_logo']['url'];
	        $tp_side_logo_alt = get_post_meta($settings["tp_side_logo"]["id"], "_wp_attachment_image_alt", true);
	    }
       
        // Link 1
        if ('2' == $settings['tp_rBtn1_link_type']) {
            $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_rBtn1_page_link']));
            $this->add_render_attribute('tp-button-arg', 'target', '_self');
            $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
            $this->add_render_attribute('tp-button-arg', 'class', 'tp-header-btn tp-el-btn1');
        } else {
            if ( ! empty( $settings['tp_rBtn1_link']['url'] ) ) {
                $this->add_link_attributes( 'tp-button-arg', $settings['tp_rBtn1_link'] );
                $this->add_render_attribute('tp-button-arg', 'class', 'tp-header-btn tp-el-btn1');
            }
        }

        // Link 3
        if ('2' == $settings['tp_ofcBtn_link_type']) {
            $this->add_render_attribute('tp-button-arg3', 'href', get_permalink($settings['tp_ofcBtn_page_link']));
            $this->add_render_attribute('tp-button-arg3', 'target', '_self');
            $this->add_render_attribute('tp-button-arg3', 'rel', 'nofollow');
            $this->add_render_attribute('tp-button-arg3', 'class', 'tp-btn w-100 tp-el-off-btn');
        } else {
            if ( ! empty( $settings['tp_ofcBtn_link']['url'] ) ) {
                $this->add_link_attributes( 'tp-button-arg3', $settings['tp_ofcBtn_link'] );
                $this->add_render_attribute('tp-button-arg3', 'class', 'tp-btn w-100 tp-el-off-btn');
            }
        }    

		?>


<header>
    <div id="header-sticky" class="<?php echo $settings['tp_header_trans_switch'] ? "tptransparent__header" : NULL; ?> header-1 tp-el-section builder-header-2">
        <div class="tp-header-top">
            <div class="container">
                <div class="tp-mega-menu-wrapper">
                    <div class="row align-items-center">
                        <div class="col-xxl-2 col-xl-2 col-lg-6 col-6">
                            <?php if(!empty($tp_image)) : ?>
                            <div class="tplogo__area">
                                <a class="header-logo tp-el-logo" href="<?php print esc_url( home_url( '/' ) );?>">
                                    <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-xxl-8 col-xl-7 col-lg-7 d-none d-xl-block">
                            <div class="tpmenu__area main-mega-menu text-center">
                                <nav class="tp-main-menu-content tp-el-menu">
                                    <?php echo $menu_html; ?>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-3 col-lg-6 col-6">
                            <div class="tpheader__right d-flex align-items-center justify-content-end">

                                <?php if(!empty($settings['tp_header_right_switch'])) : ?>
                                <?php if(!empty($settings['tp_header_search_switch'])) : ?>
                                <div class="search-btn-wrap">
                                    <button class="button-search-toggle">
                                        <i class="header_search-button far fa-search d-none tp-el-search"></i>
                                        <i class="header_search-button tp-el-search">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                                    stroke="#271D3A" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M19.0001 19L17.2001 17.2" stroke="#271D3A" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </i>
                                        <i class="header_search-close far fa-times"></i>
                                    </button>
                                </div>
                                <?php endif; ?>
                                <?php if(!empty($settings['tp_rBtn1_text'])) : ?>
                                <div class="tpheader__btn ml-25 d-none d-sm-block">
                                    <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?> ><?php echo tp_kses($settings['tp_rBtn1_text']); ?></a>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>

                                <div class="offcanvas-btn d-xl-none ml-20">
                                    <button class="offcanvas-open-btn"><i class="fa-solid fa-bars"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->tp_search_form(); ?>
    </div>
</header>

<?php include(TPCORE_ELEMENTS_PATH . '/header-side/header-side-1.php'); 

	}
}

$widgets_manager->register( new TP_Header_02() );