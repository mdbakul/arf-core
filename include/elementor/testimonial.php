<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use TPCore\Elementor\Controls\Group_Control_TPBGGradient;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Testimonial extends Widget_Base {

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
		return 'tp-testimonial';
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
		return __( 'Testimonial', 'tpcore' );
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

        // title/content
        $this->tp_section_title_render_controls('testimonial', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Our Feedback', ['layout-1', 'layout-5', 'layout-7']);

        // Review group
        $this->start_controls_section(
            'review_list',
            [
                'label' => esc_html__( 'Review List', 'tpcore' ),
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
                ],
                'default' => 'style_1',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        // rating
        $repeater->add_control(
            'tp_testi_rating',
            [
                'label' => esc_html__('Select Rating Count', 'tpcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('Single Star', 'tpcore'),
                    '2' => esc_html__('2 Star', 'tpcore'),
                    '3' => esc_html__('3 Star', 'tpcore'),
                    '4' => esc_html__('4 Star', 'tpcore'),
                    '5' => esc_html__('5 Star', 'tpcore'),
                ],
                'default' => '5',
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2']
                ]
            ]
        );

        $repeater->add_control(
            'reviewer_image',
            [
                'label' => esc_html__( 'Reviewer Image', 'tpcore' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2']
                ]
            ]
        );
        $repeater->add_control(
            'review_content',
            [
                'label' => esc_html__( 'Review Content', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => 'Aklima The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections Bonorum et Malorum original.',
                'placeholder' => esc_html__( 'Type your review content here', 'tpcore' ),
            ]
        );
        $repeater->add_control(
            'reviewer_name', [
                'label' => esc_html__( 'Reviewer Name', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Rasalina William' , 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2']
                ]
            ]
        );

        $repeater->add_control(
            'reviewer_title', [
                'label' => esc_html__( 'Reviewer Designation', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'CEO at YES Germany' , 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2']
                ]
            ]
        );

        $this->add_control(
            'reviews_list',
            [
                'label' => esc_html__( 'Review List', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' =>  $repeater->get_controls(),
                'default' => [
                    [
                        'reviewer_name' => esc_html__( 'Rasalina William', 'tpcore' ),
                        'reviewer_title' => esc_html__( 'CEO at YES Germany', 'tpcore' ),
                        'review_content' => esc_html__( 'Construction can be defined as the art of building something. These construction quotes will put into perspective the fact that construction can be', 'tpcore' ),
                    ],
                    [
                        'reviewer_name' => esc_html__( 'Rasalina William', 'tpcore' ),
                        'reviewer_title' => esc_html__( 'CEO at YES Germany', 'tpcore' ),
                        'review_content' => esc_html__( 'Construction can be defined as the art of building something. These construction quotes will put into perspective the fact that construction can be', 'tpcore' ),
                    ],
                    [
                        'reviewer_name' => esc_html__( 'Rasalina William', 'tpcore' ),
                        'reviewer_title' => esc_html__( 'CEO at YES Germany', 'tpcore' ),
                        'review_content' => esc_html__( 'Construction can be defined as the art of building something. These construction quotes will put into perspective the fact that construction can be', 'tpcore' ),
                    ],

                ],
                'title_field' => '{{{ reviewer_name }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'default' => 'thumbnail',
                'exclude' => ['custom'],
                'separator' => 'none',
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-2']
                ]
            ]
        );
        

        $this->add_control(
            'tp_border_switch',
            [
                'label'        => esc_html__( 'Border On/Off', 'tpcore' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'tpcore' ),
                'label_off'    => esc_html__( 'Hide', 'tpcore' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'tp_design_style' => 'layout-6'
                ]
            ]
        );
    

        $this->end_controls_section();

        
        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
                'condition' => [
                    'tp_design_style' => 'layout-7'
                ]
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

        
        // shape
        $this->start_controls_section(
        'tp_shape',
            [
                'label' => esc_html__( 'Shape Section', 'tpcore' ),
                'condition' => [
                    'tp_design_style' => ['layout-4', 'layout-5', 'layout-7']
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
                    'tp_design_style' => ['layout-5', 'layout-7']
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
                    'tp_design_style' => 'layout-5'
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_4',
            [
                'label' => esc_html__( 'Choose Shape Image 4', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => 'layout-5'
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_5',
            [
                'label' => esc_html__( 'Choose Shape Image 5', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => 'layout-5'
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_6',
            [
                'label' => esc_html__( 'Choose Shape Image 6', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => 'layout-5'
                ]
            ]
        );

        $this->add_control(
            'tp_shape_image_7',
            [
                'label' => esc_html__( 'Choose Shape Image 7', 'tp-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_shape_switch' => 'yes',
                    'tp_design_style' => 'layout-5'
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

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('testi_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-4', 'layout-5', 'layout-7']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-4', 'layout-5', 'layout-7']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-4', 'layout-5', 'layout-7']);
        $this->start_controls_section(
            'tp_additional_styling',
            [
                'label' => esc_html__('Additional Style', 'tp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'tp_design_style' => 'layout-2'
                ]
            ]
        );
        $this->add_control(
			'dot_color',
			[
				'label' => esc_html__( 'Dot Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tptestimonial-active-two .slick-dots li.slick-active button' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .tptestimonial-two-nav button:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);
        $this->end_controls_section();
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', ['layout-1', 'layout-2', 'layout-4', 'layout-5', 'layout-6']);
        $this->tp_basic_style_controls('rep_content_style', 'Repeater Content', '.tp-el-rep-content', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_basic_style_controls('rep_name_style', 'Repeater Name', '.tp-el-rep-name', ['layout-1', 'layout-2', 'layout-3', 'layout-5', 'layout-7']);
        $this->tp_basic_style_controls('rep_desi_style', 'Repeater Designation', '.tp-el-rep-desi', ['layout-1', 'layout-2', 'layout-3', 'layout-5', 'layout-7']);
        $this->tp_icon_style('rep_star_style', 'Repeater Review Star', '.tp-el-rep-star', ['layout-4', 'layout-5', 'layout-6', 'layout-7']);
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

<!--	testimonial style 2 -->
<?php if ( $settings['tp_design_style']  == 'layout-2' ):
    $this->add_render_attribute('title_args', 'class', 'tp-section__title-2 mb-10 tp-el-title');
?>

<?php else:
    $this->add_render_attribute('title_args', 'class', 'tp-section-title tp-el-title');
?>
 <!-- testimonial section start here -->
 <section class="testmonial padding-block overflow-hidden bg-white">
    <div class="container">
        <div class="section__header testmonial__header">
            <div class="col-md-8">                    
                    <?php if(!empty($settings['tp_testimonial_sub_title'])): ?>
                        <span><?php echo tp_kses($settings['tp_testimonial_sub_title']) ?></span>
                    <?php endif ?>
                    <?php if(!empty(!empty($settings['tp_testimonial_title']))):?>
                        <h3><?php echo tp_kses($settings['tp_testimonial_title']) ?></h3>                        
                    <?php endif ?>                    
                    <?php if(!empty($settings['tp_testimonial_description'])): ?>
                        <p><?php echo tp_kses($settings['tp_testimonial_description']);?></p>
                    <?php endif ?>
            </div>
        </div>
        <div class="section__wrapper">
            <div class="testmonial__slider overflow-hidden">
                <div class="swiper-wrapper">
                    <?php foreach ($settings['reviews_list'] as $index => $item) :
                        if ( !empty($item['reviewer_image']['url']) ) {
                            $tp_reviewer_image = !empty($item['reviewer_image']['id']) ? wp_get_attachment_image_url( $item['reviewer_image']['id'], $settings['thumbnail_size_size']) : $item['reviewer_image']['url'];
                            $tp_reviewer_image_alt = get_post_meta($item["reviewer_image"]["id"], "_wp_attachment_image_alt", true);
                        }
                    ?>
                    <div class="swiper-slide">
                        <div class="testmonial__inner">
                            <div class="testmonial__item">
                                <div class="thum">
                                    <img src="<?php echo esc_url($tp_reviewer_image); ?>" alt="<?php echo esc_attr($tp_reviewer_image_alt);?>">
                                    <div class="quode">
                                        <i class="fa-solid fa-quote-right"></i>
                                    </div>
                                </div>
                                <div class="testmonial__content">                                    
                                    <?php if ( !empty($item['review_content']) ) : ?>
                                        <p><?php echo tp_kses($item['review_content']); ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="profile">
                                        <div class="name">                                            
                                            <?php if ( !empty($item['reviewer_name']) ) : ?>
                                                <h6><?php echo tp_kses($item['reviewer_name']); ?></h6>
                                            <?php endif; ?>

                                            <?php if(!empty($item['reviewer_title'])) : ?>
                                                <span><?php echo tp_kses($item['reviewer_title']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="star">
                                            <ul>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li>
                                                <li><i class="fa-solid fa-star"></i></li> 
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- testimonial section end here -->  

<?php endif; }
}

$widgets_manager->register( new TP_Testimonial() );