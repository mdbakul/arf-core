<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Background;
use \Elementor\Control_Media;
use \Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Portfolio_Slider extends Widget_Base {

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
		return 'tp-portfolio-slider';
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
		return __( 'Portfolio Slider', 'tpcore' );
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
        $this->tp_section_title_render_controls('portfolio', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.');

        $this->start_controls_section(
         'tp_portfolio_sec',
             [
               'label' => esc_html__( 'Portfolio Slider', 'tpcore' ),
               'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
             ]
        );
        
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tp_portfolio_image',
            [
                'label' => esc_html__('Upload Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );
        
        $repeater->add_control(
         'tp_portfolio_box_sub_title',
           [
             'label'   => esc_html__( 'Portfolio Sub Title', 'tpcore' ),
             'type'        => \Elementor\Controls_Manager::TEXT,
             'description' => tp_get_allowed_html_desc( 'basic' ),
             'default'     => esc_html__( 'Subtitle', 'tpcore' ),
             'label_block' => true,
           ]
        );
        
        $repeater->add_control(
         'tp_portfolio_box_title',
           [
             'label'   => esc_html__( 'Portfolio Title', 'tpcore' ),
             'type'        => \Elementor\Controls_Manager::TEXT,
             'description' => tp_get_allowed_html_desc( 'basic' ),
             'default'     => esc_html__( 'Title', 'tpcore' ),
             'label_block' => true,
           ]
        );
         
        $repeater->add_control(
            'tp_portfolio_link_switcher',
            [
                'label' => esc_html__( 'Add Portfolio link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'tp_portfolio_link_type',
            [
                'label' => esc_html__( 'Portfolio Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_portfolio_link_switcher' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'tp_portfolio_link',
            [
                'label' => esc_html__( 'Portfolio Link link', 'tpcore' ),
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
                    'tp_portfolio_link_type' => '1',
                    'tp_portfolio_link_switcher' => 'yes',
                ]
            ]
        );
        $repeater->add_control(
            'tp_portfolio_page_link',
            [
                'label' => esc_html__( 'Select Portfolio Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_portfolio_link_type' => '2',
                    'tp_portfolio_link_switcher' => 'yes',
                ]
            ]
        );
        
        $this->add_control(
        'tp_portfolio_list',
            [
                'label'       => esc_html__( 'Portfolio List', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                [
                    'tp_portfolio_box_title' => esc_html__('Business Stratagy', 'tpcore'),
                ],
                [
                    'tp_portfolio_box_title' => esc_html__('Website Development', 'tpcore')
                ],
                [
                    'tp_portfolio_box_title' => esc_html__('Marketing & Reporting', 'tpcore')
                ],
                ],
                'title_field' => '{{{ tp_portfolio_box_title }}}',
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

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('portfolio_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content');

        # repeater 
        $this->tp_basic_style_controls('rep_subtitle_style', 'Repeater Subtitle', '.tp-el-rep-subtitle');
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title');

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
    $this->add_render_attribute('title_args', 'class', 'tp-section__title ele-heading');
?>


<?php else:
    $this->add_render_attribute('title_args', 'class', 'tpsection__title tp-el-title');
?>

<section class="case-area pb-140 fix ele-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <div class="tpsection__wrapper mb-45">
                    <?php if ( !empty($settings['tp_portfolio_sub_title']) ) : ?>
                    <div class="tpbanner__sub-title mb-15">
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_portfolio_sub_title']); ?></span>
                        <i>
                            <svg width="150" height="40" viewBox="0 0 150 40" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="150" height="40" fill="url(#pattern3)" fill-opacity="0.1"/>
                                <defs>
                                <pattern id="pattern3" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_859_3410" transform="translate(-0.0584971) scale(0.00611611 0.0203396)"/>
                                </pattern>
                                <image id="image0_859_3410" width="180" height="50" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg=="/>
                                </defs>
                            </svg>
                        </i>
                    </div>
                    <?php endif; ?>
                    <?php
                        if ( !empty($settings['tp_portfolio_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                                tag_escape( $settings['tp_portfolio_title_tag'] ),
                                $this->get_render_attribute_string( 'title_args' ),
                                tp_kses( $settings['tp_portfolio_title' ] )
                                );
                        endif;
                    ?>
                    <?php if ( !empty($settings['tp_portfolio_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_portfolio_description'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="tpcase-arrow text-end">
                    <div class="tpcase-nav p-relative">
                    <button class="prev-slide prev-slide-case">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" fill="none"
                                viewBox="0 0 8 14">
                                <path fill-rule="evenodd"
                                d="M7.707.293a1 1 0 0 1 0 1.414L2.414 7l5.293 5.293a1 1 0 0 1-1.414 1.414l-6-6a1 1 0 0 1 0-1.414l6-6a1 1 0 0 1 1.414 0z"
                                fill="#9f9fa9"></path>
                            </svg>
                        </span>
                    </button>
                    <button class="next-slide next-slide-case">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" fill="none"
                                viewBox="0 0 8 14">
                                <path fill-rule="evenodd"
                                d="M.293 13.707a1 1 0 0 1 0-1.414L5.586 7 .293 1.707A1 1 0 1 1 1.707.293l6 6a1 1 0 0 1 0 1.414l-6 6a1 1 0 0 1-1.414 0z"
                                fill="#9f9fa9"></path>
                            </svg>
                        </span>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row tpcase-active">

            <?php foreach ($settings['tp_portfolio_list'] as $item) :
                if ( !empty($item['tp_portfolio_image']['url']) ) {
                    $tp_portfolio_image_url = !empty($item['tp_portfolio_image']['id']) ? wp_get_attachment_image_url( $item['tp_portfolio_image']['id'], $settings['thumbnail_size']) : $item['tp_portfolio_image']['url'];
                    $tp_portfolio_image_alt = get_post_meta($item["tp_portfolio_image"]["id"], "_wp_attachment_image_alt", true);
                }
                // Link
                if ('2' == $item['tp_portfolio_link_type']) {
                    $link = get_permalink($item['tp_portfolio_page_link']);
                    $target = '_self';
                    $rel = 'nofollow';
                } else {
                    $link = !empty($item['tp_portfolio_link']['url']) ? $item['tp_portfolio_link']['url'] : '';
                    $target = !empty($item['tp_portfolio_link']['is_external']) ? '_blank' : '';
                    $rel = !empty($item['tp_portfolio_link']['nofollow']) ? 'nofollow' : '';
                }
            ?>
            <div class="col-lg-6">
                <div class="tpcase">
                    <?php if(!empty($tp_portfolio_image_url)) : ?>
                    <div class="tpcase-thumb w-img">
                        <img src="<?php echo esc_url($tp_portfolio_image_url); ?>" alt="<?php echo esc_attr($tp_portfolio_image_alt); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="tpcase-content">
                        <?php if(!empty($item['tp_portfolio_box_sub_title'])) : ?>
                        <div class="tpcase-tag mb-15 tp-el-rep-subtitle">
                            <?php echo tp_kses($item['tp_portfolio_box_sub_title']); ?>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_portfolio_box_title'])) : ?>
                        <h3 class="tpcase-title tp-el-rep-title">
                            <?php if(!empty($link)) : ?>
                            <a href="<?php echo esc_url($link); ?>"><?php echo tp_kses($item['tp_portfolio_box_title']); ?></a>
                            <?php else : ?>
                            <?php echo tp_kses($item['tp_portfolio_box_title']); ?>
                            <?php endif; ?>
                        </h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php endif; 

	}

}

$widgets_manager->register( new TP_Portfolio_Slider() );