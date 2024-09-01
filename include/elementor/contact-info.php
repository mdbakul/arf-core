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
class TP_Contact_Info extends Widget_Base {

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
		return 'tp-contact-info';
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
		return __( 'Contact Info', 'tpcore' );
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

     
    private function get_tp_contact_form(){
        if ( ! class_exists( 'WPCF7' ) ) {
            return;
        }
        $tp_cfa         = array();
        $tp_cf_args     = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
        $tp_forms       = get_posts( $tp_cf_args );
        $tp_cfa         = ['0' => esc_html__( 'Select Form', 'tpcore' ) ];
        if( $tp_forms ){
            foreach ( $tp_forms as $tp_form ){
                $tp_cfa[$tp_form->ID] = $tp_form->post_title;
            }
        }else{
            $tp_cfa[ esc_html__( 'No contact form found', 'tpcore' ) ] = 0;
        }
        return $tp_cfa;
    }
     
    protected static function get_profile_names()
    {
        return [
            '500px' => esc_html__('500px', 'tpcore'),
            'apple' => esc_html__('Apple', 'tpcore'),
            'behance' => esc_html__('Behance', 'tpcore'),
            'bitbucket' => esc_html__('BitBucket', 'tpcore'),
            'codepen' => esc_html__('CodePen', 'tpcore'),
            'delicious' => esc_html__('Delicious', 'tpcore'),
            'deviantart' => esc_html__('DeviantArt', 'tpcore'),
            'digg' => esc_html__('Digg', 'tpcore'),
            'dribbble' => esc_html__('Dribbble', 'tpcore'),
            'email' => esc_html__('Email', 'tpcore'),
            'facebook-f' => esc_html__('Facebook', 'tpcore'),
            'flickr' => esc_html__('Flicker', 'tpcore'),
            'foursquare' => esc_html__('FourSquare', 'tpcore'),
            'github' => esc_html__('Github', 'tpcore'),
            'houzz' => esc_html__('Houzz', 'tpcore'),
            'instagram' => esc_html__('Instagram', 'tpcore'),
            'jsfiddle' => esc_html__('JS Fiddle', 'tpcore'),
            'linkedin' => esc_html__('LinkedIn', 'tpcore'),
            'medium' => esc_html__('Medium', 'tpcore'),
            'pinterest' => esc_html__('Pinterest', 'tpcore'),
            'product-hunt' => esc_html__('Product Hunt', 'tpcore'),
            'reddit' => esc_html__('Reddit', 'tpcore'),
            'slideshare' => esc_html__('Slide Share', 'tpcore'),
            'snapchat' => esc_html__('Snapchat', 'tpcore'),
            'soundcloud' => esc_html__('SoundCloud', 'tpcore'),
            'spotify' => esc_html__('Spotify', 'tpcore'),
            'stack-overflow' => esc_html__('StackOverflow', 'tpcore'),
            'tripadvisor' => esc_html__('TripAdvisor', 'tpcore'),
            'tumblr' => esc_html__('Tumblr', 'tpcore'),
            'twitch' => esc_html__('Twitch', 'tpcore'),
            'twitter' => esc_html__('Twitter', 'tpcore'),
            'vimeo' => esc_html__('Vimeo', 'tpcore'),
            'vk' => esc_html__('VK', 'tpcore'),
            'website' => esc_html__('Website', 'tpcore'),
            'whatsapp' => esc_html__('WhatsApp', 'tpcore'),
            'wordpress' => esc_html__('WordPress', 'tpcore'),
            'xing' => esc_html__('Xing', 'tpcore'),
            'yelp' => esc_html__('Yelp', 'tpcore'),
            'youtube' => esc_html__('YouTube', 'tpcore'),
        ];
    }

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
                    'layout-4' => esc_html__('Layout 4', 'tpcore'),
                    'layout-5' => esc_html__('Layout 5', 'tpcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // title/content
        $this->tp_section_title_render_controls('section', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-3', 'layout-4']);

        // Contact group
        $this->start_controls_section(
            '_TP_contact_info',
            [
                'label' => esc_html__('Contact List', 'tpcore'),
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
                    'style_2' => __( 'Style 2', 'tpcore' ),
                    'style_3' => __( 'Style 3', 'tpcore' ),
                    'style_4' => __( 'Style 4', 'tpcore' ),
                    'style_5' => __( 'Style 5', 'tpcore' ),
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
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5']
                ]

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
                    'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5']
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
                    'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5']
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
                        'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5']
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
                        'repeater_condition' => ['style_1', 'style_2', 'style_3', 'style_5']
                    ]
                ]
            );
        }

        $repeater->add_control(
            'tp_contact_info_title',
            [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Title Here', 'tpcore'),
                'label_block' => true,
            ]
        );  

        $repeater->add_control(
            'tp_contact_info_des',
            [
                'label' => esc_html__('Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('info@company.com', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => 'style_4'
                ]
            ]
        );  

        $repeater->add_control(
            'link_type',
            [
                'label' => __( 'Link Type', 'tpcore' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'None', 'tpcore' ),
                    'url' => __( 'URL', 'tpcore' ),
                    'tell' => __( 'Phone Number', 'tpcore' ),
                    'email' => __( 'Email', 'tpcore' ),
                ],
                'default' => '',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        // url
        $repeater->add_control(
            'tp_contact_url',
            [
                'label' => esc_html__('URL', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '#',
                'label_block' => true,
                'condition' => [
                    'link_type' => 'url'
                ]
            ]
        );  

        // tell
        $repeater->add_control(
            'tp_contact_tell',
            [
                'label' => esc_html__('Phone Number', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '012345',
                'label_block' => true,
                'condition' => [
                    'link_type' => 'tell'
                ]
            ]
        );  

        // email
        $repeater->add_control(
            'tp_contact_email',
            [
                'label' => esc_html__('Email Address', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('softec@gmail.com', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'link_type' => 'email'
                ]
            ]
        );  

        $this->add_control(
            'tp_list',
            [
                'label' => esc_html__('Contact - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_contact_info_title' => esc_html__('united states', 'tpcore'),
                    ],
                    [
                        'tp_contact_info_title' => esc_html__('south Africa', 'tpcore')
                    ],
                    [
                        'tp_contact_info_title' => esc_html__('United Kingdom', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_contact_info_title }}}',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            '_section_social',
            [
                'label' => esc_html__('Social Profiles', 'tpcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tp_design_style' => 'layout-3'
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Profile Name', 'tpcore'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'select2options' => [
                    'allowClear' => false,
                ],
                'options' => self::get_profile_names()
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__('Profile Link', 'tpcore'),
                'placeholder' => esc_html__('Add your profile link', 'tpcore'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'autocomplete' => false,
                'show_external' => false,
                'condition' => [
                    'name!' => 'email'
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );
        $this->add_control(
            'profiles',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '<# print(name.slice(0,1).toUpperCase() + name.slice(1)) #>',
                'default' => [
                    [
                        'link' => ['url' => 'https://facebook.com/'],
                        'name' => 'facebook-f'
                    ],
                    [
                        'link' => ['url' => 'https://linkedin.com/'],
                        'name' => 'linkedin'
                    ],
                    [
                        'link' => ['url' => 'https://twitter.com/'],
                        'name' => 'twitter'
                    ]
                ],
            ]
        );

        $this->end_controls_section();
        
        $this->tp_button_render('contact', 'Button', 'layout-4');  

        $this->start_controls_section(
            'tpcore_contact',
            [
                'label' => esc_html__('Contact Form', 'tpcore'),
                'condition' => [
                    'tp_design_style' => ['layout-3', 'layout-4']
                ]
            ]
        );

        $this->add_control(
            'tp_form_title', [
                'label' => esc_html__('Form Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Form Title', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'tp_design_style' => 'layout-3'
                ]
            ]
        );

        $this->add_control(
            'tpcore_select_contact_form',
            [
                'label'   => esc_html__( 'Select Form', 'tpcore' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $this->get_tp_contact_form(),
            ]
        );

        $this->end_controls_section();
        
        // shape
        $this->start_controls_section(
        'tp_shape',
            [
                'label' => esc_html__( 'Shape Section', 'tpcore' ),
                'condition' => [
                    'tp_design_style' => ['layout-3', 'layout-4']
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

	}

    // TAB_STYLE
    protected function style_tab_content(){
        $this->tp_section_style_controls('section_info', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-3', 'layout-4']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-3', 'layout-4']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-3', 'layout-4']); 
        $this->tp_link_controls_style('section_btn', 'Button', '.tp-el-btn', 'layout-4');
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', ['layout-1', 'layout-2', 'layout-3', 'layout-5']);
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5']);
        $this->tp_basic_style_controls('rep_des_style', 'Repeater Description', '.tp-el-rep-des', 'layout-4');
        $this->tp_link_controls_style('rep_social_style', 'Social Icon', '.tp-el-rep-social', 'layout-3');

        $this->tp_basic_style_controls('form_title', 'Form Title', '.tp-el-from-title', 'layout-3');
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

<div class="tpcontact-info-links tp-el-section">

    <?php foreach ($settings['tp_list'] as $key => $item) :

    $key = $key+1;

    $link_type = $item['link_type'];
    $url = $item['tp_contact_url'];
    $tell = $item['tp_contact_tell'];
    $email = $item['tp_contact_email'];

    $contact_link;

    if($link_type == 'url'){
        $contact_link = $url;
    } elseif($link_type == 'tell'){
        $contact_link = 'tel:'.$tell;
    } elseif($link_type == 'email'){
        $contact_link = 'mailto:'.$email;
    }

    if(!empty($item['tp_contact_info_title'])) :
    ?>
    <?php if(!empty($item['link_type'])) : ?>
    <a class="tp-el-rep-title" href="<?php echo esc_url($contact_link); ?>">
        <?php endif; ?>
        <?php if($item['tp_box_icon_type'] == 'icon') : ?>
        <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
        <i class="tp-el-rep-icon"><?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?></i>
        <?php endif; ?>
        <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
        <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
        <i class="tp-el-rep-icon"><img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>"></i>
        <?php endif; ?>
        <?php else : ?>
        <?php if (!empty($item['tp_box_icon_svg'])): ?>
        <i class="tp-el-rep-icon"><?php echo $item['tp_box_icon_svg']; ?></i>
        <?php endif; ?>
        <?php endif; ?> <?php echo tp_kses($item['tp_contact_info_title']); ?>
        <?php if(!empty($item['link_type'])) : ?>
    </a>
    <?php endif; ?>
    <?php endif; endforeach; ?>

</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : 

    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }
    
    $this->add_render_attribute('title_args', 'class', 'tpsection-title tpsection-title-white mb-50 tp-el-title');

?>

<section class="contact-area theme-bg-3 pt-120 pb-120 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="tpcontact-box pr-70 mb-30">
                    <div class="tpsection__content">
                        <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                        <div class="tpsection-sub-title tpsection-sub-title-white mb-30">
                            <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_section_sub_title']); ?></span>
                        </div>
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
                        <p class="text-white tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="tpcontact-info">
                        <div class="tpcontact-info-links">

                            <?php foreach ($settings['tp_list'] as $key => $item) :

                                $key = $key+1;

                                $link_type = $item['link_type'];
                                $url = $item['tp_contact_url'];
                                $tell = $item['tp_contact_tell'];
                                $email = $item['tp_contact_email'];

                                $contact_link;

                                if($link_type == 'url'){
                                    $contact_link = $url;
                                } elseif($link_type == 'tell'){
                                    $contact_link = 'tel:'.$tell;
                                } elseif($link_type == 'email'){
                                    $contact_link = 'mailto:'.$email;
                                }

                            ?>
                            <?php if(!empty($item['link_type'])) : ?>
                            <a class="tp-el-rep-title" href="<?php echo esc_url($contact_link); ?>">
                                <?php endif; ?>
                                <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                                <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                                <i class="tp-el-rep-icon"><?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?></i>
                                <?php endif; ?>
                                <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                                <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                                <i class="tp-el-rep-icon"><img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                        alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>"></i>
                                <?php endif; ?>
                                <?php else : ?>
                                <?php if (!empty($item['tp_box_icon_svg'])): ?>
                                <i class="tp-el-rep-icon"><?php echo $item['tp_box_icon_svg']; ?></i>
                                <?php endif; ?>
                                <?php endif; ?><?php echo tp_kses($item['tp_contact_info_title']); ?>
                                <?php if(!empty($item['link_type'])) : ?>
                            </a>
                            <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                        <div class="tpcontact-info-social">
                            <?php
                                foreach ($settings['profiles'] as $profile) :
                                    $icon = $profile['name'];
                                    $url = esc_url($profile['link']['url']);
                                    printf('<a target="_blank" rel="noopener"  href="%s" class="elementor-repeater-item-%s"><i class="tp-el-rep-social mr-5 tp-el-sicon fa-brands fa-%s" aria-hidden="true"></i></a>',
                                        $url,
                                        esc_attr($profile['_id']),
                                        esc_attr($icon)
                                    );
                                endforeach; 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="p-relative">
                    <div class="tpcontact-form p-relative ml-30">
                        <?php if(!empty($settings['tp_form_title'])) : ?>
                        <h4 class="tpcontact-form-title mb-35 tp-el-from-title"><?php echo tp_kses($settings['tp_form_title']); ?></h4>
                        <?php endif; ?>
                        <?php if( !empty($settings['tpcore_select_contact_form']) ) : ?>
                        <?php echo do_shortcode( '[contact-form-7  id="'.$settings['tpcore_select_contact_form'].'"]' ); ?>
                        <?php else : ?>
                        <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
                        <?php endif; ?>
                    </div>
                    <div class="tpcontact-shape d-none d-md-block">
                        <?php if(!empty($tp_shape_image)) : ?>
                        <div class="tpcontact-shape-one" data-parallax='{"y": -100, "smoothness": 20}'>
                            <img src="<?php echo esc_url($tp_shape_image); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image2)) : ?>
                        <div class="tpcontact-shape-two" data-parallax='{"y": -100, "smoothness": 20}'>
                            <img src="<?php echo esc_url($tp_shape_image2); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-4' ) : 
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }
    if ( !empty($settings['tp_shape_image_2']['url']) ) {
        $tp_shape_image2 = !empty($settings['tp_shape_image_2']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_2']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_2']['url'];
        $tp_shape_image_alt2 = get_post_meta($settings["tp_shape_image_2"]["id"], "_wp_attachment_image_alt", true);
    }

    // Link
    if ('2' == $settings['tp_contact_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_contact_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_contact_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_contact_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
        }
    } 
    
    $this->add_render_attribute('title_args', 'class', 'section-title-4 section-title-4-2 tp-el-title');    
?>


<section class="contact-area p-relative contact-bg-4 pb-65 mb-60 tp-el-section">
    <?php if(!empty($settings['tp_shape_switch'])) : ?>
    <?php if(!empty($tp_shape_image)) : ?>
    <div class="contact-main-shape-bg d-none d-md-block">
        <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
    </div>
    <?php endif; ?>
    <div class="contact-shape d-none d-lg-block">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/contact-4-shape-1.png" alt=""
            class="contact-shape-1">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/contact-4-shape-2.png" alt=""
            class="contact-shape-2">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/contact-4-shape-3.png" alt=""
            class="contact-shape-3">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/contact-4-shape-4.png" alt=""
            class="contact-shape-4">
        <?php if(!empty($tp_shape_image2)) : ?>
        <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>"
            class="contact-shape-5 d-none d-xxl-block">
        <?php endif; ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/contact-4-shape-6.png" alt=""
            class="contact-shape-6 d-none d-xxl-block">
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="tpcontact-4 mt-30 mb-50">
                    <div class="section-wrapper mb-20">
                        <?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_section_sub_title']); ?></span>
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
                    <div class="tpcontact-4-content">
                        <?php if ( !empty($settings['tp_section_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
                        <?php endif; ?>

                        <?php foreach ($settings['tp_list'] as $key => $item) :

                            $key = $key+1;

                            $link_type = $item['link_type'];
                            $url = $item['tp_contact_url'];
                            $tell = $item['tp_contact_tell'];
                            $email = $item['tp_contact_email'];

                            $contact_link;

                            if($link_type == 'url'){
                                $contact_link = $url;
                            } elseif($link_type == 'tell'){
                                $contact_link = 'tel:'.$tell;
                            } elseif($link_type == 'email'){
                                $contact_link = 'mailto:'.$email;
                            }

                        ?>
                        <?php if(!empty($item['link_type'])) : ?>
                        <a class="phone mb-5 tp-el-rep-title" href="<?php echo esc_url($contact_link); ?>"><?php echo $item['tp_contact_info_title'] ?  tp_kses($item['tp_contact_info_title']) : NULL; ?></a>
                        <?php else : ?>
                        <h4 class="tp-el-rep-title"><?php echo $item['tp_contact_info_title'] ?  tp_kses($item['tp_contact_info_title']) : NULL; ?>
                        </h4>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_contact_info_des'])) : ?>
                        <span class="tp-el-rep-des"><?php echo tp_kses($item['tp_contact_info_des']); ?></span> 
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <?php if ( !empty($settings['tp_contact_btn_text']) ) : ?>
                        <div class="tpcontact-4-content-btn">
                            <a
                                <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_contact_btn_text']); ?></a>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tpcontact-4-box mb-60">
                    <div class="tpcontact-4-box-wrapper">
                        <?php if( !empty($settings['tpcore_select_contact_form']) ) : ?>
                        <?php echo do_shortcode( '[contact-form-7  id="'.$settings['tpcore_select_contact_form'].'"]' ); ?>
                        <?php else : ?>
                        <?php echo '<div class="alert alert-info"><p class="m-0">' . __('Please Select contact form.', 'tpcore' ). '</p></div>'; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-5' ) : ?>


<?php foreach ($settings['tp_list'] as $key => $item) :

    $key = $key+1;

    $link_type = $item['link_type'];
    $url = $item['tp_contact_url'];
    $tell = $item['tp_contact_tell'];
    $email = $item['tp_contact_email'];

    $contact_link;

    if($link_type == 'url'){
        $contact_link = $url;
    } elseif($link_type == 'tell'){
        $contact_link = 'tel:'.$tell;
    } elseif($link_type == 'email'){
        $contact_link = 'mailto:'.$email;
    }

?>
<?php if(!empty($item['link_type'])) : ?>
<a href="<?php echo esc_url($contact_link); ?>" class="contact-mail mb-15 tp-el-rep-title">

    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
    <span class="tp-el-rep-icon"><?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?></span>
    <?php endif; ?>
    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
    <span class="tp-el-rep-icon"><img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>"></span>
    <?php endif; ?>
    <?php else : ?>
    <?php if (!empty($item['tp_box_icon_svg'])): ?>
    <span class="tp-el-rep-icon"><?php echo $item['tp_box_icon_svg']; ?></span>
    <?php endif; ?>
    <?php endif; ?>

    <?php echo tp_kses($item['tp_contact_info_title']); ?>
    <i>
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 7H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M7 1L13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </i>
</a>
<?php else : ?>
    <div class="d-block contact-mail mb-15 tp-el-rep-title">
        <?php if($item['tp_box_icon_type'] == 'icon') : ?>
        <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
        <span class="tp-el-rep-icon"><?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?></span>
        <?php endif; ?>
        <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
        <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
        <span class="tp-el-rep-icon"><img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>"></span>
        <?php endif; ?>
        <?php else : ?>
        <?php if (!empty($item['tp_box_icon_svg'])): ?>
        <span class="tp-el-rep-icon"><?php echo $item['tp_box_icon_svg']; ?></span>
        <?php endif; ?>
        <?php endif; ?>

        <?php echo tp_kses($item['tp_contact_info_title']); ?>
    </div>
<?php endif; ?>
<?php endforeach; ?>

<?php else:
    $this->add_render_attribute('title_args', 'class', 'contact-inner-title-sm tp-el-title');
?>

<?php foreach ($settings['tp_list'] as $key => $item) :

    $key = $key+1;

    $link_type = $item['link_type'];
    $url = $item['tp_contact_url'];
    $tell = $item['tp_contact_tell'];
    $email = $item['tp_contact_email'];

    $contact_link;

    if($link_type == 'url'){
        $contact_link = $url;
    } elseif($link_type == 'tell'){
        $contact_link = 'tel:'.$tell;
    } elseif($link_type == 'email'){
        $contact_link = 'mailto:'.$email;
    }

?>
<div class="footer-widget-btn">
    <div class="phone-call">
        <?php if(!empty($item['tp_contact_info_title'])) : ?>
        <?php if(!empty($item['link_type'])) : ?>
        <a href="<?php echo esc_url($contact_link); ?>">
            <?php endif; ?>
            <?php if($item['tp_box_icon_type'] == 'icon') : ?>
            <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
            <i class="tp-el-rep-icon"><?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?></i>
            <?php endif; ?>
            <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
            <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
            <i class="tp-el-rep-icon"><img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                    alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>"></i>
            <?php endif; ?>
            <?php else : ?>
            <?php if (!empty($item['tp_box_icon_svg'])): ?>
            <i class="tp-el-rep-icon"><?php echo $item['tp_box_icon_svg']; ?></i>
            <?php endif; ?>
            <?php endif; ?><span class="tp-el-rep-title"><?php echo tp_kses($item['tp_contact_info_title']); ?></span>
            <?php if(!empty($item['link_type'])) : ?>
        </a>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>

<?php endif;
	}
}

$widgets_manager->register( new TP_Contact_Info() );