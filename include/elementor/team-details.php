<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Control_Media;
use Elementor\Core\Utils\ImportExport\Url;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Team_Details extends Widget_Base {

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
        return 'tp-team-details';
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
        return __( 'Team Details', 'tpcore' );
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
             'facebook' => esc_html__('Facebook', 'tpcore'),
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

        $this->tp_section_title_render_controls('team', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.');

        $this->start_controls_section(
         'tp_image_sec',
             [
               'label' => esc_html__( 'Thumbnail', 'tpcore' ),
               'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
             ]
        );
        
        $this->add_control(
         'tp_image',
         [
           'label'   => esc_html__( 'Upload Image', 'tpcore' ),
           'type'    => \Elementor\Controls_Manager::MEDIA,
             'default' => [
               'url' => \Elementor\Utils::get_placeholder_image_src(),
           ],
         ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                // 'default' => 'tp-post-thumb',
            ]
        );
        
        $this->end_controls_section();

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
                ],
                'default' => 'style_1',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

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
            'tp_contact_info',
            [
                'label' => esc_html__('Contact Info', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('seomy@gmail.com', 'tpcore'),
                'label_block' => true,
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
                'default' => __('seomy@gmail.com', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'link_type' => 'email'
                ]
            ]
        );  

        $this->add_control(
            'tp_contact_list',
            [
                'label' => esc_html__('Contact - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_contact_info' => esc_html__('email@gmail.com', 'tpcore'),
                    ],
                    [
                        'tp_contact_info' => esc_html__('gmail@email.com', 'tpcore')
                    ],
                ],
                'title_field' => '{{{ tp_contact_info }}}',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            '_section_social',
            [
                'label' => esc_html__('Social Profiles', 'tpcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_profiles',
            [
                'label' => esc_html__('Show Profiles', 'tpcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'tpcore'),
                'label_off' => esc_html__('Hide', 'tpcore'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
                'style_transfer' => true,
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
                        'name' => 'facebook'
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

        $this->start_controls_section(
        'tp_bio_info',
            [
                'label' => esc_html__( 'Biography', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'bio_part1',
			[
				'label' => esc_html__( 'Biogaphy Part 1', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
            'bio_title',
            [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('About Me', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'bio_des',
            [
                'label' => esc_html__('Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat.', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
			'bio_part2',
			[
				'label' => esc_html__( 'Biogaphy Part 2', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
            'bio_title2',
            [
                'label' => esc_html__('Title 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Background & Experience', 'tpcore'),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            'bio_des2',
            [
                'label' => esc_html__('Description 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat.', 'tpcore'),
                'label_block' => true,
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
                    'tp_shape_switch' => 'yes'
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

        $this->add_control(
            'tp_shape_image_3',
            [
                'label' => esc_html__( 'Choose Shape Image 3', 'tp-core' ),
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
                    'tp_shape_switch' => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();

    }

    protected function style_tab_content(){
        $this->tp_section_style_controls('team_details_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content');
        $this->tp_basic_style_controls('contact_title', 'Contact Title', '.tp-el-con-title');
        $this->tp_basic_style_controls('contact_info', 'Contact Info', '.tp-el-con-info');
        $this->tp_link_controls_style('td_social', 'Social Icon', '.tp-el-social');
        $this->tp_basic_style_controls('bio_title', 'Biography Title', '.tp-el-bio-title');
        $this->tp_basic_style_controls('bio_des', 'Biography Description', '.tp-el-bio-des');
        $this->tp_basic_style_controls('bio_list', 'Biography List', '.tp-el-bio-list');
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

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image_url = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['thumbnail_size']) : $settings['tp_image']['url'];
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
    if ( !empty($settings['tp_shape_image_3']['url']) ) {
        $tp_shape_image3 = !empty($settings['tp_shape_image_3']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_3']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_3']['url'];
        $tp_shape_image_alt3 = get_post_meta($settings["tp_shape_image_3"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'team-details-title tp-el-title');
?>

<section class="team-area team-details-bg pt-200 pb-100 ele-section" >
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10 col-md-11 col-12">
                <div class="team-details p-relative">
                    <div class="team-details-info d-flex align-items-center mb-50">
                        <?php if(!empty($tp_image_url)) : ?>
                        <div class="team-details-thumb">
                            <img src="<?php echo esc_url($tp_image_url); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
                        </div>
                        <?php endif; ?>
                        <div class="team-details-content">
                            <?php if ( !empty($settings['tp_team_sub_title']) ) : ?>
                            <span class="team-details-position tp-el-subtitle"><?php echo tp_kses( $settings['tp_team_sub_title'] ); ?></span>
                            <?php endif; ?>
                            <?php
                                if ( !empty($settings['tp_team_title' ]) ) :
                                    printf( '<%1$s %2$s>%3$s</%1$s>',
                                        tag_escape( $settings['tp_team_title_tag'] ),
                                        $this->get_render_attribute_string( 'title_args' ),
                                        tp_kses( $settings['tp_team_title' ] )
                                        );
                                endif;
                            ?>
                            <?php if(!empty($settings['tp_team_description' ])) : ?>
                            <p class="tp-el-content"><?php echo tp_kses($settings['tp_team_description']); ?></p>
                            <?php endif; ?>

                            <?php foreach ($settings['tp_contact_list'] as $key => $item) :

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
                            <div class="contact-info">
                                <?php if(!empty($item['tp_contact_info_title'])) : ?>
                                    <span class="tp-el-con-title"><?php echo $item['tp_contact_info_title'] ? tp_kses($item['tp_contact_info_title']) : NULL; ?></span>
                                <?php endif; ?>
                                <?php if(!empty($item['link_type'])) : ?>
                                <a class="team-details-email tp-el-con-info" href="<?php echo esc_url($contact_link); ?>"><?php echo $item['tp_contact_info'] ? tp_kses($item['tp_contact_info']) : NULL; ?></a>
                                <?php else : ?>
                                <p class="tp-el-con-info"><?php echo $item['tp_contact_info'] ? tp_kses($item['tp_contact_info']) : NULL; ?></p>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>

                            <div class="team-details-social mt-30">
                                <?php
                                    foreach ($settings['profiles'] as $profile) :
                                        $icon = $profile['name'];
                                        $url = esc_url($profile['link']['url']);
                                        
                                        printf('<a class="tp-el-social" target="_blank" rel="noopener"  href="%s" ><i class="fa-brands fa-%s"></i></a>',
                                            $url,
                                            esc_attr($icon)
                                        );
                                    endforeach; 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="team-details-about mb-45">
                        <?php if(!empty($settings['bio_title'])) : ?>
                        <h3 class="team-details-about-title tp-el-bio-title"><?php echo tp_kses($settings['bio_title']); ?></h3>
                        <?php endif; ?>
                        <?php if(!empty($settings['bio_des'])) : ?>
                        <p class="tp-el-bio-des"><?php echo tp_kses($settings['bio_des']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="team-details-exprience">
                        <?php if(!empty($settings['bio_title2'])) : ?>
                        <h3 class="team-details-exprience-title tp-el-bio-title"><?php echo tp_kses($settings['bio_title2']); ?></h3>
                        <?php endif; ?>
                        <?php if(!empty($settings['bio_des2'])) : ?>
                        <p class="tp-el-bio-des"><?php echo tp_kses($settings['bio_des2']); ?></p>
                        <?php endif; ?>
                        <ul>
                            <?php foreach ($settings['tp_text_list_list'] as $key => $item) : if(!empty($item['tp_text_list_title'])) : ?>
                            <li class="tp-el-bio-list"><?php echo tp_kses($item['tp_text_list_title']); ?></li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                    <div class="team-details-shape">
                        <?php if(!empty($tp_shape_image)) : ?>
                        <img class="team-details-shape-1" src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image2)) : ?>
                        <img class="team-details-shape-2" src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image3)) : ?>
                        <img class="team-details-shape-3" src="<?php echo esc_url($tp_shape_image3); ?>" alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif;
    }
}

$widgets_manager->register( new TP_Team_Details() );