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
class TP_List extends Widget_Base {

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
		return 'tp-list';
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
		return __( 'List', 'tpcore' );
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
                    'layout-2' => esc_html__('Layout 2', 'tp-core'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
		 'tp_list_sec',
			 [
			   'label' => esc_html__( 'Info List', 'tpcore' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			 ]
		);

		$this->add_control(
			'tp_text_title',
			 [
				'label'       => esc_html__( 'Title', 'tpcore' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'TP Heading Control', 'tpcore' ),
				'placeholder' => esc_html__( 'Your Title', 'tpcore' ),
				'label_block' => true
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

		
    }

    protected function style_tab_content(){
        $this->tp_section_style_controls('list_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('list_title', 'Section Title', '.tp-el-title', 'layout-1');
        $this->tp_basic_style_controls('rep_title', 'Repeater Title', '.tp-el-rep-title');
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

	<div class="portfolio-details-result ele-section">
		<ul class="d-block">
			<?php foreach ($settings['tp_text_list_list'] as $key => $item) : if(!empty($item['tp_text_list_title'])) : ?>
			<li class="tp-el-rep-title"><span>
				<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="9" cy="9" r="9" fill="currentColor"></circle>
				<path d="M12.7539 6.75L7.59766 11.9062L5.25391 9.5625" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
				</span> <?php echo tp_kses($item['tp_text_list_title']); ?></li>
			<?php endif; endforeach; ?>
		</ul>
	</div>

<?php else: ?>	

	<div class="footer-widget footer-5-col-4 mb-40 ele-section">
		<?php if(!empty($settings['tp_text_title'])): ?>
		<h4 class="footer-widget-title mb-20 tp-el-title"><?php echo tp_kses($settings['tp_text_title']); ?></h4>
		<?php endif; ?>
		<div class="footer-widget-link">
			<ul>
				<?php foreach ($settings['tp_text_list_list'] as $key => $item) : if(!empty($item['tp_text_list_title'])) : ?>
				<li class="tp-el-rep-title"><?php echo tp_kses($item['tp_text_list_title']); ?></li>
				<?php endif; endforeach; ?>
			</ul>
		</div>
	</div>

<?php endif; 
	}
}

$widgets_manager->register( new TP_List() );