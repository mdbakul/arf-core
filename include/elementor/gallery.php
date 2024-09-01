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
class TP_Gallery extends Widget_Base {

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
		return 'tp-gallery';
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
		return __( 'Gallery', 'tpcore' );
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
        $this->tp_section_title_render_controls('gallery', 'Section Title', 'Sub Title', 'your title here', 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', 'layout-1');

        $this->start_controls_section(
        'tp_list_sec',
            [
                'label' => esc_html__( 'Info List', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
   

        // gallery section
		$this->start_controls_section(
            'tp_gallery_section',
            [
                'label' => __( 'Brand Item', 'tpcore' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

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
            'tp_gallery_image',
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
        

        $this->add_control(
            'tp_gallery_slides',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => esc_html__( 'Brand Item', 'tpcore' ),
                'default' => [
                    [
                        'tp_gallery_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'tp_gallery_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                ]
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
        $this->tp_section_style_controls('gallery_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title');
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content');
        $this->tp_basic_style_controls('list_item', 'List Item', '.tp-el-list');
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


<?php else : 
    $this->add_render_attribute('title_args', 'class', 'about-inner-title-3 tp-el-title'); 
?>


<section class="about-area p-relative pt-170 pb-180 tp-el-section" >
    <div class="fix">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="about-inner-slide tpabout-inner-active">

                        <?php foreach ($settings['tp_gallery_slides'] as $key => $item) : 
                            if ( !empty($item['tp_gallery_image']['url']) ) {
                                $tp_gallery_image_url = !empty($item['tp_gallery_image']['id']) ? wp_get_attachment_image_url( $item['tp_gallery_image']['id'], $settings['thumbnail_size']) : $item['tp_gallery_image']['url'];
                                $tp_gallery_image_alt = get_post_meta($item["tp_gallery_image"]["id"], "_wp_attachment_image_alt", true);
                            }
                        ?>
                        <div class="about-inner-item">
                            <img src="<?php echo esc_url($tp_gallery_image_url); ?>" alt="<?php echo esc_attr($tp_gallery_image_alt); ?>">
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-inner-box">
        <div class="about-inner-content-3">

            <?php if ( !empty($settings['tp_gallery_sub_title']) ) : ?>
            <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_gallery_sub_title']); ?></span>
            <?php endif; ?>
            <?php
            if ( !empty($settings['tp_gallery_title' ]) ) :
                printf( '<%1$s %2$s>%3$s</%1$s>',
                tag_escape( $settings['tp_gallery_title_tag'] ),
                $this->get_render_attribute_string( 'title_args' ),
                tp_kses( $settings['tp_gallery_title' ] )
                );
            endif;
            ?>
            <?php if ( !empty($settings['tp_gallery_description']) ) : ?>
            <p class="tp-el-content"><?php echo tp_kses( $settings['tp_gallery_description'] ); ?></p>
            <?php endif; ?>
            <ul class="about-inner-list">
                <?php foreach($settings['tp_text_list_list'] as $key => $item) :?>
                <li class="tp-el-list"><i class="fa-sharp fa-solid fa-circle-check"></i> <?php echo tp_kses($item['tp_text_list_title']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<?php endif;  
	}
}

$widgets_manager->register( new TP_Gallery() );