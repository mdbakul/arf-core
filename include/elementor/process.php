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
class TP_Process extends Widget_Base {

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
		return 'process';
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
		return __( 'Process', 'tpcore' );
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
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        
        // tp_section_title
        $this->tp_section_title_render_controls('process', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2', 'layout-3']);

        // Process group
        $this->start_controls_section(
            'tp_process',
            [
                'label' => esc_html__('Process List', 'tpcore'),
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
                    'style_6' => __( 'Style 6', 'tpcore' ),
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
                    'repeater_condition' => ['style_3', 'style_4', 'style_5', 'style_6']
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
                    'repeater_condition' => ['style_3', 'style_4', 'style_5', 'style_6']
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
                    'repeater_condition' => ['style_3', 'style_4', 'style_5', 'style_6']
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
                        'repeater_condition' => ['style_3', 'style_4', 'style_5', 'style_6']
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
                        'repeater_condition' => ['style_3', 'style_4', 'style_5', 'style_6']
                    ]
                ]
            );
        }

        $repeater->add_control(
            'tp_process_word', [
                'label' => esc_html__('Single Word', 'tpcore'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('1', 'tpcore'),
                'condition' => [
                    'repeater_condition' => 'style_1'
                ]
            ]
        );

        $repeater->add_control(
            'tp_process_subtitle', [
                'label' => esc_html__('Sub Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Sub Title', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_2', 'style_3']
                ]
            ]
        );

        $repeater->add_control(
            'tp_process_title', [
                'label' => esc_html__('Title', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Process Title', 'tpcore'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tp_process_add1', [
                'label' => esc_html__('Additional Info 1', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Info One', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => 'style_2'
                ]
            ]
        );

        $repeater->add_control(
            'tp_process_add2', [
                'label' => esc_html__('Additional Info 2', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Info Two', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => 'style_2'
                ]
            ]
        );

        $repeater->add_control(
            'tp_process_des', [
                'label' => esc_html__('Description', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('This SEO is most reputed firm', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'repeater_condition' => ['style_4', 'style_5', 'style_6']
                ]
            ]
        );

        $this->add_control(
            'tp_process_list',
            [
                'label' => esc_html__('Processs - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_process_title' => esc_html__('Discover', 'tpcore'),
                    ],
                    [
                        'tp_process_title' => esc_html__('Define', 'tpcore')
                    ],
                    [
                        'tp_process_title' => esc_html__('Develop', 'tpcore')
                    ],
                ],
                'title_field' => '{{{ tp_process_title }}}',
            ]
        );
        
        $this->end_controls_section();

        // shape
        $this->start_controls_section(
        'tp_shape',
            [
                'label' => esc_html__( 'Shape Section', 'tpcore' ),
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-2', 'layout-3']
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
                    'tp_design_style' => ['layout-2', 'layout-3']
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
                    'tp_design_style' => 'layout-2'
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

        // section column
        $this->tp_columns('col', 'layout-5');

	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('process_section', 'Section - Style', '.tp-el-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2', 'layout-3']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2', 'layout-3']);

        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon', ['layout-3', 'layout-4', 'layout-5', 'layout-6']);
        $this->tp_link_controls_style('rep_num_style', 'Repeater Number', '.tp-el-rep-num', 'layout-1');
        $this->tp_basic_style_controls('rep_subtitle_style', 'Repeater Subtitle', '.tp-el-rep-subtitle', ['layout-2', 'layout-3']);
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6']);
        $this->tp_basic_style_controls('rep_des_style', 'Repeater Description', '.tp-el-rep-des', ['layout-4', 'layout-5', 'layout-6']);
        $this->tp_basic_style_controls('rep_addi_style', 'Repeater Additional Info', '.tp-el-rep-addi', 'layout-2');
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

    $this->add_render_attribute('title_args', 'class', 'tpsection-title tpsection-title-white mb-15 tp-el-title');
?>

<section class="funfact-area pb-80">
    <div class="container">
        <div class="tpfunfact p-relative">
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="tpfunfact-bg theme-bg-2"
                style="background-image: url(<?php echo esc_url($tp_shape_image); ?>);">
                <?php else : ?>
                <div class="tpfunfact-bg theme-bg-2 tp-el-section">
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tpsection__content feature-white-section text-center">
                                <?php if ( !empty($settings['tp_process_sub_title']) ) : ?>
                                <div class="tpbanner__sub-title mb-15">
                                    <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_process_sub_title']); ?></span>
                                    <i>
                                        <svg width="150" height="36" viewBox="0 0 150 36" fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect x="0.00012207" width="150" height="36" fill="url(#pattern5)"
                                                fill-opacity="0.1" />
                                            <defs>
                                                <pattern id="pattern5" patternContentUnits="objectBoundingBox" width="1"
                                                    height="1">
                                                    <use xlink:href="#image0_853_2637"
                                                        transform="translate(-0.0507936) scale(0.00603175 0.0205405)" />
                                                </pattern>
                                                <image id="image0_853_2637" width="180" height="50"
                                                    xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAAXNSR0IArs4c6QAAA8JJREFUeF7tnVFO41AMRa9TkIoEIqyA7GA6O2ALs9JZynR2UFZAEB9TCYhHfokhlSrkTqdpXd38pG2cxjk+eXnJjwWJlqcnrTFHfQE0CjSWuthacCuKWgU1FDUEtX33U/v4/atzFbSiaC1EBS2Gzxh+V+CxbANWAqzs8xuwuruS8pnLaRCQ00gDcFlnHRaVoNEK90VSoDFpXeBTyXechwluopv8MOE7PHaKlVRo39ZY3t1JuVC4HJ7ApEKbtJeXaLoZFiapAPcqWLi4hz/dIx1hEN1kd+FVsJR3tNfXsjxSVmd52IMIvSGu4BtMXsXilEfZo1a3n+Isywiv+O3TGk5pdq/K3kI//dFmBjwIxd2dfnAPn9IM60eb6/sI//qKFac0nyDDQvuoiwoPNr8F8GAjb3kI43J0AuN5fBEeKOL7XN6mN68ztOf+EBsS+mWtv6BYHL1qTOC/EfA3NeVh1hZ/m9NPe579QB/b7YcOrT3obkvCL5ivErx8R62z7QOgdqhRbW4rb7B8Gd5k2Vd7a3Uzlx9b84gQevmjGoljDAlMReDmSrYOxrERmkJPVSceJ0iAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHAQqdo07MMkiAQgdBMSwHgZxCj/pvO+aNPtx7st/ostT38f7surTnf3P3wxKYTOiNdmHjhvCj5u9+quMm8B+nv0Z7Co0kraGo5TRuReatx/xCGFo716VXo6A++xbPh3V0p3/fT+i1/izNHK1/nZSmjqW3nQlp7Xvt87k3dNyFtjUpxRz1BdBsXAQmvjUtVdR2UfCOsAvVIXbom34zl+/b9g61dfuHw3KXIAHv0GsNKU3wSvu1CG6L8FKaUZ59x97xnb10xVU827qzu/wwcEYGTQodFO8Uwmwa5FMgG/krQWNdVcuI7xdAf+vspz/DtslyH08x+460RUY7/lR3dwo9WbWPeyB/JrAsbCq0TzY+zfT/iIyc+xxvl33/AiWjt0Jf7u62AAAAAElFTkSuQmCC" />
                                            </defs>
                                        </svg>
                                    </i>
                                </div>
                                <?php endif; ?>
                                <?php
                                if ( !empty($settings['tp_process_title' ]) ) :
                                    printf( '<%1$s %2$s>%3$s</%1$s>',
                                    tag_escape( $settings['tp_process_title_tag'] ),
                                    $this->get_render_attribute_string( 'title_args' ),
                                    tp_kses( $settings['tp_process_title' ] )
                                    );
                                endif;
                                ?>
                                <?php if ( !empty($settings['tp_process_description']) ) : ?>
                                <p class="text-white tp-el-content"><?php echo tp_kses( $settings['tp_process_description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="tpfunfact-shape d-none d-md-block">
                        <?php if(!empty($tp_shape_image2)) : ?>
                        <div class="tpfunfact-shape-one"><img src="<?php echo esc_url($tp_shape_image2); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt2); ?>"></div>
                        <?php endif; ?>
                        <?php if(!empty($tp_shape_image3)) : ?>
                        <div class="tpfunfact-shape-two"><img src="<?php echo esc_url($tp_shape_image3); ?>"
                                alt="<?php echo esc_attr($tp_shape_image_alt3); ?>"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="tpfunfact-box">
                    <div class="row justify-content-center">

                        <?php foreach ($settings['tp_process_list'] as $key => $item) : 
                        $key = $key + 1;
                        $keyCount = count($settings['tp_process_list']);
                    ?>
                        <div class="col-lg-5">
                            <div class="tpfunfact-wrapper text-center mb-50">
                                <?php if(!empty($item['tp_process_subtitle'])) : ?>
                                <span class="tpfunfact-title tp-el-rep-subtitle"><?php echo tp_kses($item['tp_process_subtitle']); ?></span>
                                <?php endif; ?>
                                <?php if(!empty($item['tp_process_title'])) : ?>
                                <h5 class="tpfunfact-count mb-15 tp-el-rep-title"><?php echo tp_kses($item['tp_process_title']); ?></h5>
                                <?php endif; ?>
                                <div class="tpfunfact-tag">
                                    <?php if(!empty($item['tp_process_add1'])) : ?>
                                    <span class="tp-el-rep-addi"><?php echo tp_kses($item['tp_process_add1']); ?></span>
                                    <?php endif; ?>
                                    <?php if(!empty($item['tp_process_add2'])) : ?>
                                    <span class="tp-el-rep-addi"><?php echo tp_kses($item['tp_process_add2']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
</section>

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

    $this->add_render_attribute('title_args', 'class', 'tpsection-title-two tp-el-title');
    
?>

<section class="services-area tp-large-box services-bg-two p-relative fix tp-el-section">
    <div class="services-shape d-none d-xl-block">
        <?php if(!empty($tp_shape_image)) : ?>
        <div class="services-shape-one">
            <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
        </div>
        <?php endif; ?>
        <?php if(!empty($tp_shape_image2)) : ?>
        <div class="services-shape-two">
            <img src="<?php echo esc_url($tp_shape_image2); ?>" alt="<?php echo esc_attr($tp_shape_image_alt2); ?>">
        </div>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="tpsection-wrapper text-center mb-60">
                        <?php if ( !empty($settings['tp_process_sub_title']) ) : ?>
                        <p class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_process_sub_title'] ); ?></p>
                        <?php endif; ?>
                        <?php
                        if ( !empty($settings['tp_process_title' ]) ) :
                            printf( '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape( $settings['tp_process_title_tag'] ),
                            $this->get_render_attribute_string( 'title_args' ),
                            tp_kses( $settings['tp_process_title' ] )
                            );
                        endif;
                        ?>
                        <?php if ( !empty($settings['tp_process_description']) ) : ?>
                        <p class="tp-el-content"><?php echo tp_kses( $settings['tp_process_description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <?php foreach ($settings['tp_process_list'] as $key => $item) : ?>
            <div class="col-lg-6">
                <div class="services-two mb-30">
                    <div class="services-two-bg"></div>
                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                    <div class="services-two-icon tp-el-rep-icon">
                        <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                    </div>
                    <?php endif; ?>
                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                    <div class="services-two-icon tp-el-rep-icon">
                        <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                    </div>
                    <?php endif; ?>
                    <?php else : ?>
                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                    <div class="services-two-icon tp-el-rep-icon">
                        <?php echo $item['tp_box_icon_svg']; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <div class="services-two-content">
                        <?php if(!empty($item['tp_process_subtitle'])) : ?>
                        <span class="tp-el-rep-subtitle"><?php echo tp_kses($item['tp_process_subtitle']); ?></span>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_process_title'])) : ?>
                        <h4 class="services-two-title tp-el-rep-title"><?php echo tp_kses($item['tp_process_title']); ?></h4>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-4' ) : ?>

<section class="award-area pb-80 tp-el-section">
    <div class="container">
        <div class="row">

            <?php foreach ($settings['tp_process_list'] as $key => $item) : 
                $key = $key + 1;
                $keyCount = count($settings['tp_process_list']);
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="tpaward text-center mb-30 <?php echo $key % 2 == 0 ? 'tpaward-border' : NULL; ?>">

                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                    <div class="tpaward-icon mb-15 tp-el-rep-icon">
                        <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                    </div>
                    <?php endif; ?>
                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                    <div class="tpaward-icon mb-15 tp-el-rep-icon">
                        <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                    </div>
                    <?php endif; ?>
                    <?php else : ?>
                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                    <div class="tpaward-icon mb-15 tp-el-rep-icon">
                        <?php echo $item['tp_box_icon_svg']; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    <div class="tpaward-content">
                        <?php if(!empty($item['tp_process_title'])) : ?>
                        <h4 class="title mb-5 tp-el-rep-title"><?php echo tp_kses($item['tp_process_title']); ?></h4>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_process_des'])) : ?>
                        <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_process_des']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-5' ) : ?>

<section class="process-5 tp-el-section">
    <div class="container">
        <div class="row">

            <?php foreach ($settings['tp_process_list'] as $key => $item) : 
                $key = $key + 1;
                $keyCount = count($settings['tp_process_list']);
            ?>
            <div
                class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
                <div class="services-important-item mb-30">
                    <div class="services-important-icon">
                        <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                        <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                        <span class="tp-el-rep-icon">
                            <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                        </span>
                        <?php endif; ?>
                        <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                        <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                        <span class="tp-el-rep-icon">
                            <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                                alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                        </span>
                        <?php endif; ?>
                        <?php else : ?>
                        <?php if (!empty($item['tp_box_icon_svg'])): ?>
                        <span class="tp-el-rep-icon">
                            <?php echo $item['tp_box_icon_svg']; ?>
                        </span>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="services-important-content">
                        <?php if(!empty($item['tp_process_title'])) : ?>
                        <h4 class="services-important-title tp-el-rep-title"><?php echo tp_kses($item['tp_process_title']); ?></h4>
                        <?php endif; ?>
                        <?php if(!empty($item['tp_process_des'])) : ?>
                        <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_process_des']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-6' ) : ?>

<div class="map-wrap tp-el-section">
    <ul>

        <?php foreach ($settings['tp_process_list'] as $key => $item) : ?>
        <li>
            <div class="location">
                <div class="location-icon">
                    <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                    <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                    <span class="tp-el-rep-icon">
                        <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                    </span>
                    <?php endif; ?>
                    <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                    <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                    <span class="tp-el-rep-icon">
                        <img src="<?php echo $item['tp_box_icon_image']['url']; ?>"
                            alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                    </span>
                    <?php endif; ?>
                    <?php else : ?>
                    <?php if (!empty($item['tp_box_icon_svg'])): ?>
                    <span class="tp-el-rep-icon">
                        <?php echo $item['tp_box_icon_svg']; ?>
                    </span>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="location-content">
                    <?php if(!empty($item['tp_process_title'])) : ?>
                    <h4 class="location-title tp-el-rep-title"><?php echo tp_kses($item['tp_process_title']); ?></h4>
                    <?php endif; ?>
                    <?php if(!empty($item['tp_process_des'])) : ?>
                    <p class="tp-el-rep-des"><?php echo tp_kses($item['tp_process_des']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <?php endforeach; ?>

    </ul>
</div>

<?php else: 
    // shape image
    if ( !empty($settings['tp_shape_image_1']['url']) ) {
        $tp_shape_image = !empty($settings['tp_shape_image_1']['id']) ? wp_get_attachment_image_url( $settings['tp_shape_image_1']['id'], $settings['shape_image_size_size']) : $settings['tp_shape_image_1']['url'];
        $tp_shape_image_alt = get_post_meta($settings["tp_shape_image_1"]["id"], "_wp_attachment_image_alt", true);
    }

    $this->add_render_attribute('title_args', 'class', 'tpsection__title tp-el-title');
?>


<section class="process__area pt-120 pb-120 tp-el-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tpsection__wrapper text-center mb-70">
                    <?php if ( !empty($settings['tp_process_sub_title']) ) : ?>
                    <div class="tpbanner__sub-title mb-15">
                        <span class="tp-el-subtitle"><?php echo tp_kses($settings['tp_process_sub_title']); ?></span>
                        <i>
                            <svg width="124" height="38" viewBox="0 0 124 38" fill="none"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="124" height="38" fill="url(#pattern1)" fill-opacity="0.08" />
                                <defs>
                                    <pattern id="pattern1" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_933_1323"
                                            transform="translate(-0.0596774) scale(0.00612903 0.02)" />
                                    </pattern>
                                    <image id="image0_933_1323" width="180" height="50"
                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg==" />
                                </defs>
                            </svg>
                        </i>
                    </div>
                    <?php endif; ?>
                    <?php
                    if ( !empty($settings['tp_process_title' ]) ) :
                        printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['tp_process_title_tag'] ),
                        $this->get_render_attribute_string( 'title_args' ),
                        tp_kses( $settings['tp_process_title' ] )
                        );
                    endif;
                    ?>
                    <?php if ( !empty($settings['tp_process_description']) ) : ?>
                    <p class="tp-el-content"><?php echo tp_kses( $settings['tp_process_description'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="tpprocess__border-bottom p-relative pb-45">
            <?php if(!empty($tp_shape_image)) : ?>
            <div class="tpprocess-shape-four d-none d-md-block">
                <img src="<?php echo esc_url($tp_shape_image); ?>" alt="<?php echo esc_attr($tp_shape_image_alt); ?>">
            </div>
            <?php endif; ?>
            <div class="row">

                <?php foreach ($settings['tp_process_list'] as $key => $item) : 
                $key = $key + 1;
                $keyCount = count($settings['tp_process_list']);
                ?>
                <div class="col-lg-3 col-sm-6">
                    <div
                        class="tpprocess__item p-relative mb-40 <?php echo $key == 2 ? 'ml-30' : ($key == 3 ? 'ml-55' : ($key == 4 ? "d-flex justify-content-end" : NULL)); ?>">
                        <div class="tpprocess__wrapper  tpprocess__<?php echo esc_attr($key); ?>">
                            <?php if(!empty($item['tp_process_word'])) : ?>
                            <span class="tpprocess__count mb-25 tp-el-rep-num"><?php echo tp_kses($item['tp_process_word']); ?></span>
                            <?php endif; ?>
                            <?php if(!empty($item['tp_process_title'])) : ?>
                            <h4 class="tpprocess__title tp-el-rep-title"><?php echo tp_kses($item['tp_process_title']); ?></h4>
                            <?php endif; ?>
                        </div>
                        <?php if($key == 1) : ?>
                        <div class="tpprocess-shape-one d-none d-md-block">
                            <svg width="112" height="15" viewBox="0 0 112 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path class="line-dash-path" d="M1 8.56464C18.4695 1.84561 64.9267 -6.52437 111 13.7479"
                                    stroke="#A6A8B0" stroke-dasharray="4 5"></path>
                            </svg>
                        </div>
                        <?php elseif($key == 2) : ?>
                        <div class="tpprocess-shape-two d-none d-lg-block">
                            <svg width="112" height="15" viewBox="0 0 112 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path class="line-dash-path" d="M1 6.43536C18.4695 13.1544 64.9267 21.5244 111 1.25212"
                                    stroke="#A6A8B0" stroke-dasharray="4 5"></path>
                            </svg>
                        </div>
                        <?php elseif($key == 3) : ?>
                        <div class="tpprocess-shape-three d-none d-md-block">
                            <svg width="112" height="15" viewBox="0 0 112 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path class="line-dash-path" d="M1 8.56464C18.4695 1.84561 64.9267 -6.52437 111 13.7479"
                                    stroke="#A6A8B0" stroke-dasharray="4 5"></path>
                            </svg>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php endif; 
	}
}

$widgets_manager->register( new TP_Process() );