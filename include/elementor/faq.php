<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_FAQ extends Widget_Base {

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
		return 'tp-faq';
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
		return __( 'FAQ', 'tpcore' );
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
        $this->tp_section_title_render_controls('faq', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.');

		$this->start_controls_section(
            '_accordion',
            [
                'label' => esc_html__( 'Accordion', 'tpcore' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
            'tp_shape_active_switch',
            [
                'label' => esc_html__( 'Active Shape', 'tp-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tp-core' ),
                'label_off' => esc_html__( 'Hide', 'tp-core' ),
                'return_value' => 'yes',
                'default' => 0,
            ]
        );

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
            'tp_accordion_active_switch',
            [
                'label' => esc_html__( 'Show', 'tp-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'tp-core' ),
                'label_off' => esc_html__( 'Hide', 'tp-core' ),
                'return_value' => 'yes',
                'default' => '0',
            ]
        );

        $repeater->add_control(
            'accordion_title', [
                'label' => esc_html__( 'Accordion Item', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'This is accordion item title' , 'tpcore' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'accordion_description',
            [
                'label' => esc_html__('Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'intermediate' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Facilis fugiat hic ipsam iusto laudantium libero maiores minima molestiae mollitia repellat rerum sunt ullam voluptates? Perferendis, suscipit.',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'accordions',
            [
                'label' => esc_html__( 'Repeater Accordion', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'accordion_title' => esc_html__( 'This is accordion item title #1', 'tpcore' ),
                    ],
                    [
                        'accordion_title' => esc_html__( 'This is accordion item title #2', 'tpcore' ),
                    ],
                    [
                        'accordion_title' => esc_html__( 'This is accordion item title #3', 'tpcore' ),
                    ],
                    [
                        'accordion_title' => esc_html__( 'This is accordion item title #4', 'tpcore' ),
                    ],
                ],
                'title_field' => '{{{ accordion_title }}}',
            ]
        );

        $this->end_controls_section();

        // button
        $this->tp_button_render('faq', 'Button', 'layout-1');  
	}

	protected function style_tab_content(){
		$this->tp_section_style_controls('faq_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', 'layout-1');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', 'layout-1');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', 'layout-1');
        $this->tp_link_controls_style('section_btn', 'Section - Button', '.tp-el-btn', 'layout-1');
        # repeater 
        $this->tp_basic_style_controls('rep_title_style', 'Faq Title', '.tp-el-rep-title', 'layout-1');
        $this->tp_basic_style_controls('rep_des_style', 'Faq Description', '.tp-el-rep-des', 'layout-1');
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


<?php if ( $settings['tp_design_style']  == 'layout-2' ): ?>

<?php else : 
    
    // Link
    if ('2' == $settings['tp_faq_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_faq_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_faq_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_faq_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'tpsection-title-two mb-40 tp-el-title');
?>

<section class="faq-area pt-115 pb-15 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="tp-faq-wrapper mb-80">
                    <div class="tpsection-wrapper mb-25">
						<?php if ( !empty($settings['tp_faq_sub_title']) ) : ?>
						<p class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_faq_sub_title'] ); ?></p>
						<?php endif; ?>
						<?php
						if ( !empty($settings['tp_faq_title' ]) ) :
							printf( '<%1$s %2$s>%3$s</%1$s>',
							tag_escape( $settings['tp_faq_title_tag'] ),
							$this->get_render_attribute_string( 'title_args' ),
							tp_kses( $settings['tp_faq_title' ] )
							);
						endif;
						?>
						<?php if ( !empty($settings['tp_faq_description']) ) : ?>
						<p class="tp-el-content"><?php echo tp_kses( $settings['tp_faq_description'] ); ?></p>
						<?php endif; ?>
                    </div>
					<?php if(!empty($settings['tp_shape_active_switch'])) : ?>
                    <div class="tp-faq-img p-relative">
                        <span>
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4"
                                    d="M29.6447 26.693L30.3466 32.3807C30.5266 33.8746 28.9247 34.9186 27.6467 34.1446L20.105 29.6628C19.2771 29.6628 18.4671 29.6088 17.6752 29.5008C19.0071 27.9349 19.7991 25.9549 19.7991 23.813C19.7991 18.7012 15.3712 14.5615 9.89945 14.5615C7.81153 14.5615 5.88562 15.1554 4.28368 16.1994C4.22968 15.7494 4.21167 15.2994 4.21167 14.8314C4.21167 6.64172 11.3214 0 20.105 0C28.8887 0 35.9984 6.64172 35.9984 14.8314C35.9984 19.6912 33.4965 23.9931 29.6447 26.693Z"
                                    fill="white" />
                                <path
                                    d="M19.7992 23.8126C19.7992 25.9545 19.0073 27.9345 17.6753 29.5004C15.8934 31.6603 13.0675 33.0462 9.89961 33.0462L5.20179 35.8361C4.40982 36.3221 3.40186 35.6561 3.50985 34.7382L3.95984 31.1924C1.54793 29.5184 0 26.8365 0 23.8126C0 20.6447 1.69194 17.8549 4.28384 16.1989C5.88577 15.155 7.81169 14.561 9.89961 14.561C15.3714 14.561 19.7992 18.7008 19.7992 23.8126Z"
                                    fill="white" />
                            </svg>
                        </span>
                        <div class="tp-faq-shape">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/faq-shape-2.png" alt="">
                        </div>
                    </div>
					<?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tp-accordion tp-green-accordion">
                    <div class="accordion mb-35" id="accordionExample-<?php echo esc_attr($this->get_id()); ?>">
						
						<?php foreach ( $settings['accordions'] as $key => $item) : 
							$collapsed = $item['tp_accordion_active_switch'] ? '' : 'collapsed';
							$show = $item['tp_accordion_active_switch'] ? 'show' : '';
						?>
                        <div class="accordion-item">
                            <h2 class="accordion-header tp-el-rep-title" id="heading-<?php echo esc_attr($key+1); ?>">
                                <button class="accordion-button <?php echo esc_attr($collapsed); ?>" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-<?php echo esc_attr($key+1); ?>" aria-expanded="true" aria-controls="collapse-<?php echo esc_attr($key+1); ?>">
                                    <?php echo esc_html($item['accordion_title']); ?>
                                </button>
                            </h2>
                            <div id="collapse-<?php echo esc_attr($key+1); ?>" class="accordion-collapse collapse <?php echo esc_attr($show); ?>"
                                aria-labelledby="heading-<?php echo esc_attr($key+1); ?>" data-bs-parent="#accordionExample-<?php echo esc_attr($this->get_id()); ?>">
                                <div class="accordion-body tp-el-rep-des"><?php echo tp_kses($item['accordion_description']); ?></div>
                            </div>
                        </div>
						<?php endforeach; ?>
                    </div>
                    <?php if ( !empty($settings['tp_faq_btn_text']) ) : ?>
                    <div class="tp-accordion-btn">
                        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_faq_btn_text']); ?><i class="fa-light fa-arrow-right"></i></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif;
	}

}

$widgets_manager->register( new TP_FAQ() );