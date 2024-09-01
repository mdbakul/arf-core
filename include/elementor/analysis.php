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
class TP_Analysis extends Widget_Base {

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
		return 'tp-analysis';
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
		return __( 'Analysis', 'tpcore' );
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
                    'layout-3' => esc_html__('Layout 3', 'tpcore'),
                    'layout-4' => esc_html__('Layout 4', 'tpcore'),
                    'layout-5' => esc_html__('Layout 5', 'tpcore'),
                    'layout-6' => esc_html__('Layout 6', 'tpcore'),
                    'layout-7' => esc_html__('Layout 7', 'tpcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // tp_section_title
        $this->tp_section_title_render_controls('analysis', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);

        $this->tp_button_render('analysis', 'Button', ['layout-1', 'layout-2', 'layout-3']);
        
        // _tp_image
		$this->start_controls_section(
            '_tp_image',
            [
                'label' => esc_html__('Thumbnail', 'tp-core'),
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']
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

        
		$this->start_controls_section(
        'tp_list_sec',
            [
                'label' => esc_html__( 'Info List', 'tpcore' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tp_design_style' => 'layout-4'
                ]
            ]
        );
        
        $this->add_control(
        'tp_orange_switch',
            [
                'label'        => esc_html__( 'Orange', 'tpcore' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'tpcore' ),
                'label_off'    => esc_html__( 'Hide', 'tpcore' ),
                'return_value' => 'yes',
                'default'      => 0,
            ]
        );

        $repeater = new \Elementor\Repeater();
        
        if (tp_is_elementor_version('<', '2.6.0')) {
            $repeater->add_control(
                'tp_box_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-star',
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
                    ]
                ]
            );
        }
        
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
                'tp_text_list_title'   => esc_html__( 'Audit', 'tpcore' ),
                ],
                [
                'tp_text_list_title'   => esc_html__( 'Seo Optimized', 'tpcore' ),
                ],
                [
                'tp_text_list_title'   => esc_html__( 'Local Seo', 'tpcore' ),
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
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-2', 'layout-3', 'layout-5', 'layout-6', 'layout-7']
                ]
            ]
        );

        $this->add_control(
            'analysis_number', [
                'label' => esc_html__( 'Number', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '01' , 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'tp_design_style' => ['layout-5', 'layout-6', 'layout-7']
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
                    'tp_design_style' => ['layout-1', 'layout-2', 'layout-5', 'layout-6', 'layout-7'],
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
                    'tp_design_style' => ['layout-2', 'layout-5', 'layout-6'],
                    'tp_design_style!' => 'layout-7'
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
                    'tp_design_style' => 'layout-6'
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
        $this->tp_section_style_controls('analysis_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_basic_style_controls('section_num', 'Section - Number', '.tp-el-num', ['layout-5', 'layout-6', 'layout-7']);
        $this->tp_link_controls_style('section_btn', 'Section - Button', '.tp-el-btn', ['layout-1', 'layout-2', 'layout-3']);
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', 'layout-4');
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', 'layout-4');
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

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
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
    
    // Link
    if ('2' == $settings['tp_analysis_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_analysis_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'radient-btn tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_analysis_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_analysis_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'radient-btn tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'feature-title mb-10 tp-el-title');        
?>

<div class="feature-item-3 mb-90 tp-el-section">
    <div class="feature-item">
        <div class="feature-thumb p-relative mb-40">
            <?php if(!empty($tp_image)) : ?>
            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
            <?php endif; ?>
            <?php if(!empty($tp_shape_image2)) : ?>
            <div class="feature-shape-three">
                <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_shape_image3)) : ?>
            <div class="feature-shape-four">
                <img src="<?php echo esc_url($tp_shape_image3); ?>" alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="feature-shape-five">
                <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
            </div>
            <?php endif; ?>
        </div>
        <div class="feature-content">
            <?php if ( !empty($settings['tp_analysis_sub_title']) ) : ?>
            <p class="text-white tp-el-subtitle"><?php echo tp_kses($settings['tp_analysis_sub_title']); ?></p>
            <?php endif; ?>
            <?php
            if ( !empty($settings['tp_analysis_title' ]) ) :
                printf( '<%1$s %2$s>%3$s</%1$s>',
                tag_escape( $settings['tp_analysis_title_tag'] ),
                $this->get_render_attribute_string( 'title_args' ),
                tp_kses( $settings['tp_analysis_title' ] )
                );
            endif;
            ?>
            <?php if ( !empty($settings['tp_analysis_description']) ) : ?>
            <span class="tp-el-content"><?php echo tp_kses( $settings['tp_analysis_description'] ); ?></span>
            <?php endif; ?>
        </div>
        <?php if ( !empty($settings['tp_analysis_btn_text']) ) : ?>
        <div class="feature-btn">
            <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_analysis_btn_text']); ?></a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : 

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }

    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }

    // Link
    if ('2' == $settings['tp_analysis_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_analysis_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'radient-btn tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_analysis_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_analysis_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'radient-btn tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'feature-title mb-10 tp-el-title');       
?>

<div class="feature-item mb-90 tp-el-section">
    <div class="feature-thumb p-relative mb-40">
        <?php if(!empty($tp_image)) : ?>
        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
        <?php endif; ?>
        <?php if(!empty($tp_shape_image)) : ?>
        <div class="feature-shape-six">
            <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
        <?php endif; ?>
    </div>
    <div class="feature-content">
        <?php if ( !empty($settings['tp_analysis_sub_title']) ) : ?>
        <p class="text-white tp-el-subtitle"><?php echo tp_kses($settings['tp_analysis_sub_title']); ?></p>
        <?php endif; ?>
        <?php
        if ( !empty($settings['tp_analysis_title' ]) ) :
            printf( '<%1$s %2$s>%3$s</%1$s>',
            tag_escape( $settings['tp_analysis_title_tag'] ),
            $this->get_render_attribute_string( 'title_args' ),
            tp_kses( $settings['tp_analysis_title' ] )
            );
        endif;
        ?>
        <?php if ( !empty($settings['tp_analysis_description']) ) : ?>
        <span class="tp-el-content"><?php echo tp_kses( $settings['tp_analysis_description'] ); ?></span>
        <?php endif; ?>
    </div>
    <?php if ( !empty($settings['tp_analysis_btn_text']) ) : ?>
    <div class="feature-btn">
        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_analysis_btn_text']); ?></a>
    </div>
    <?php endif; ?>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-4' ) : 
    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
        $tp_image_alt = get_post_meta($settings["tp_image"]["id"], "_wp_attachment_image_alt", true);
    }     
    $this->add_render_attribute('title_args', 'class', 'feature-5-content-title mb-50 tp-el-title');   
?>

<div class="feature-5-item mb-55 tp-el-section  <?php echo $settings['tp_orange_switch'] ? 'feature-5-item-2' : NULL; ?>">
    <div class="feature-5-icon p-relative mb-40">
        <?php if(!empty($tp_image)) : ?>
        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
        <?php endif; ?>
        <div class="feature-5-icon-shape">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/feature-5-shape-1.png" alt="shape">
        </div>
        <span></span>
    </div>
    <div class="feature-5-content">

        <?php if ( !empty($settings['tp_analysis_sub_title']) ) : ?>
        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_analysis_sub_title']); ?></span>
        <?php endif; ?>
        <?php
        if ( !empty($settings['tp_analysis_title' ]) ) :
            printf( '<%1$s %2$s>%3$s</%1$s>',
            tag_escape( $settings['tp_analysis_title_tag'] ),
            $this->get_render_attribute_string( 'title_args' ),
            tp_kses( $settings['tp_analysis_title' ] )
            );
        endif;
        ?>
        <?php if ( !empty($settings['tp_analysis_description']) ) : ?>
        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_analysis_description'] ); ?></p>
        <?php endif; ?>

        <ul class="feature-5-list">

            <?php foreach ($settings['tp_text_list_list'] as $key => $item) : ?>
            <li class="tp-el-rep-icon"><?php !empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value']) ? tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon') : NULL; ?>
                <span class="tp-el-rep-title"><?php echo $item['tp_text_list_title'] ? tp_kses($item['tp_text_list_title']) : NULL; ?></span>
            </li>
            <?php endforeach; ?>

        </ul>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-5' ) : 

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
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

    $this->add_render_attribute('title_args', 'class', 'seo-analysis-title fs-18 tp-el-title');   
?>

<div class="seo-analysis-wrap mb-40 tp-el-section">
    <div class="seo-analysis-thumb">
        <div class="seo-analysis-bg p-relative">
            <?php if(!empty($tp_image)) : ?>
            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
            <?php endif; ?>
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="seo-analysis-shape-2">
                <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_shape_image2)) : ?>
            <div class="seo-analysis-shape-3">
                <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
            </div>
            <?php endif; ?>
        </div>
        <?php if(!empty($tp_shape_image3)) : ?>
        <div class="seo-analysis-shape">
            <div class="seo-analysis-shape-1">
                <img src="<?php echo esc_url($tp_shape_image3); ?>" alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
            </div>
        </div>
        <?php endif; ?>
        <?php if(!empty($settings['analysis_number'])) : ?>
        <div class="seo-analysis-thumb-count">
            <span class="tp-el-num"><?php echo esc_html($settings['analysis_number']); ?></span>
        </div>
        <?php endif; ?>
    </div>
    <div class="seo-analysis-content ele-content-align">
        <?php if ( !empty($settings['tp_analysis_sub_title']) ) : ?>
        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_analysis_sub_title']); ?></span>
        <?php endif; ?>
        <?php
        if ( !empty($settings['tp_analysis_title' ]) ) :
            printf( '<%1$s %2$s>%3$s</%1$s>',
            tag_escape( $settings['tp_analysis_title_tag'] ),
            $this->get_render_attribute_string( 'title_args' ),
            tp_kses( $settings['tp_analysis_title' ] )
            );
        endif;
        ?>
        <?php if ( !empty($settings['tp_analysis_description']) ) : ?>
        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_analysis_description'] ); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-6' ) : 

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
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
    if ( !empty($settings['tp_shape_image_4']['url']) ) {
        $tp_shape_image4 = !empty($settings['tp_shape_image_4']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_4']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_4']['url'];
        $tp_shape_image_alt4 = get_post_meta($settings["tp_shape_image_4"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'seo-analysis-title fs-18 tp-el-title');   
    
?>

<div class="seo-analysis-wrap seo-analysis-wrap-2 mb-40 tp-el-section">
    <div class="seo-analysis-thumb text-center">
        <div class="seo-analysis-bg-2 p-relative">
            <?php if(!empty($tp_image)) : ?>
            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
            <?php endif; ?>
            <?php if(!empty($tp_shape_image2)) : ?>
            <div class="seo-analysis-shape-5">
                <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_shape_image3)) : ?>
            <div class="seo-analysis-shape-6">
                <img src="<?php echo esc_url($tp_shape_image3); ?>" alt="<?php echo esc_attr($tp_shape_image_alt3); ?>">
            </div>
            <?php endif; ?>
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="seo-analysis-shape-7">
                <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
            </div>
            <?php endif; ?>
        </div>
        <?php if(!empty($tp_shape_image4)) : ?>
        <div class="seo-analysis-shape">
            <div class="seo-analysis-shape-4">
                <img src="<?php echo esc_url($tp_shape_image4); ?>" alt="<?php echo esc_attr($tp_shape_image_alt4); ?>">
            </div>
        </div>
        <?php endif; ?>
        <?php if(!empty($settings['analysis_number'])) : ?>
        <div class="seo-analysis-thumb-count seo-analysis-thumb-count-2">
            <span class="tp-el-num"><?php echo esc_html($settings['analysis_number']); ?></span>
        </div>
        <?php endif; ?>
    </div>
    <div class="seo-analysis-content ele-content-align">
        <?php if ( !empty($settings['tp_analysis_sub_title']) ) : ?>
        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_analysis_sub_title']); ?></span>
        <?php endif; ?>
        <?php
        if ( !empty($settings['tp_analysis_title' ]) ) :
            printf( '<%1$s %2$s>%3$s</%1$s>',
            tag_escape( $settings['tp_analysis_title_tag'] ),
            $this->get_render_attribute_string( 'title_args' ),
            tp_kses( $settings['tp_analysis_title' ] )
            );
        endif;
        ?>
        <?php if ( !empty($settings['tp_analysis_description']) ) : ?>
        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_analysis_description'] ); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php elseif ( $settings['tp_design_style']  == 'layout-7' ) : 

    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
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

    $this->add_render_attribute('title_args', 'class', 'seo-analysis-title fs-18 tp-el-title');   
    
?>

<div class="seo-analysis-wrap mb-40 tp-el-section">
    <div class="seo-analysis-thumb">
        <div class="seo-analysis-bg-3 p-relative">
            <?php if(!empty($tp_image)) : ?>
            <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
            <?php endif; ?>
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="seo-analysis-shape-8">
                <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
            </div>
            <?php endif; ?>
        </div>
        <?php if(!empty($tp_shape_image2)) : ?>
        <div class="seo-analysis-shape">
            <div class="seo-analysis-shape-9">
                <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
            </div>
        </div>
        <?php endif; ?>
        <?php if(!empty($settings['analysis_number'])) : ?>
        <div class="seo-analysis-thumb-count">
            <span class="tp-el-num"><?php echo esc_html($settings['analysis_number']); ?></span>
        </div>
        <?php endif; ?>
    </div>
    <div class="seo-analysis-content ml-35 ele-content-align">
        <?php if ( !empty($settings['tp_analysis_sub_title']) ) : ?>
        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_analysis_sub_title']); ?></span>
        <?php endif; ?>
        <?php
        if ( !empty($settings['tp_analysis_title' ]) ) :
            printf( '<%1$s %2$s>%3$s</%1$s>',
            tag_escape( $settings['tp_analysis_title_tag'] ),
            $this->get_render_attribute_string( 'title_args' ),
            tp_kses( $settings['tp_analysis_title' ] )
            );
        endif;
        ?>
        <?php if ( !empty($settings['tp_analysis_description']) ) : ?>
        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_analysis_description'] ); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php else : 
    // thumbnail
    if ( !empty($settings['tp_image']['url']) ) {
        $tp_image = !empty($settings['tp_image']['id']) ? wp_get_attachment_image_url( $settings['tp_image']['id'], $settings['tp_image_size_size']) : $settings['tp_image']['url'];
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
    
    // Link
    if ('2' == $settings['tp_analysis_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_analysis_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'radient-btn tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_analysis_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_analysis_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'radient-btn tp-el-btn');
        }
    } 

    $this->add_render_attribute('title_args', 'class', 'feature-title mb-10 tp-el-title');    
?>

<div class="feature-item mb-90 tp-el-section">
    <div class="feature-thumb p-relative mb-40">
        <?php if(!empty($tp_image)) : ?>
        <img src="<?php echo esc_url($tp_image); ?>" alt="<?php echo esc_attr($tp_image_alt); ?>">
        <?php endif; ?>
        <?php if(!empty($tp_shape_image)) : ?>
        <div class="feature-shape-one">
            <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
        <?php endif; ?>
        <?php if(!empty($tp_shape_image2)) : ?>
        <div class="feature-shape-two">
            <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
        </div>
        <?php endif; ?>
    </div>
    <div class="feature-content">
        <?php if ( !empty($settings['tp_analysis_sub_title']) ) : ?>
        <p class="text-white tp-el-subtitle"><?php echo tp_kses($settings['tp_analysis_sub_title']); ?></p>
        <?php endif; ?>
        <?php
        if ( !empty($settings['tp_analysis_title' ]) ) :
            printf( '<%1$s %2$s>%3$s</%1$s>',
            tag_escape( $settings['tp_analysis_title_tag'] ),
            $this->get_render_attribute_string( 'title_args' ),
            tp_kses( $settings['tp_analysis_title' ] )
            );
        endif;
        ?>
        <?php if ( !empty($settings['tp_analysis_description']) ) : ?>
        <span class="tp-el-content"><?php echo tp_kses( $settings['tp_analysis_description'] ); ?></span>
        <?php endif; ?>
    </div>
    <?php if ( !empty($settings['tp_analysis_btn_text']) ) : ?>
    <div class="feature-btn">
        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_analysis_btn_text']); ?></a>
    </div>
    <?php endif; ?>
</div>

<?php endif;  
	}
}

$widgets_manager->register( new TP_Analysis() );