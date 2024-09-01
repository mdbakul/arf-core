<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Control_Media;

use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Heading extends Widget_Base {

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
		return 'tp-heading';
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
		return __( 'Heading', 'tpcore' );
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
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // title/content
        $this->tp_section_title_render_controls('section', 'Section Title', 'Sub Title', 'your title here', $default_description = 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2', 'layout-3']);

	}

    protected function style_tab_content(){
        $this->tp_section_style_controls('heading_section', 'Section - Style', '.tp-el-section');

        $this->tp_basic_style_controls('heading_subtitle', 'Section - Subtitle', '.tp-el-subtitle');
        $this->tp_basic_style_controls('heading_title', 'Section - Title', '.tp-el-title');
        $this->tp_basic_style_controls('heading_desc', 'Section - Description', '.tp-el-content'); 
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

<?php if ( $settings['tp_design_style']  == 'layout-2' ):
	$this->add_render_attribute('title_args', 'class', 'tpsection-title-two tp-el-title');
?>

<?php if ( !empty($settings['tp_section_section_title_show']) ) : ?>
<div class="tpsection-wrapper ele-content-align tp-el-section">
	<?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
	<p class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_section_sub_title'] ); ?></p>
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
	<p class="tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ):
	$this->add_render_attribute('title_args', 'class', 'section-title-4 section-title-4-2 tp-el-title');
?>

<?php if ( !empty($settings['tp_section_section_title_show']) ) : ?>
<div class="section-wrapper ele-content-align tp-el-section">
	<?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
	<span class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_section_sub_title'] ); ?></span>
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
	<p class="tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php else:
	$this->add_render_attribute('title_args', 'class', 'tpsection__title mb-15 tp-el-title');
?>

<?php if ( !empty($settings['tp_section_section_title_show']) ) : ?>
<div class="tpsection__content ele-content-align tp-el-section">
	<?php if ( !empty($settings['tp_section_sub_title']) ) : ?>
	<div class="tpbanner__sub-title mb-15">
		<span class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_section_sub_title'] ); ?></span>
		<i>
			<svg width="126" height="37" viewBox="0 0 126 37" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<rect width="126" height="37" fill="url(#pattern4)" fill-opacity="0.08"/>
				<defs>
				<pattern id="pattern4" patternContentUnits="objectBoundingBox" width="1" height="1">
				<use xlink:href="#image0_859_2751" transform="translate(-0.0507936) scale(0.00603175 0.0205405)"/>
				</pattern>
				<image id="image0_859_2751" width="180" height="50" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAAyCAYAAAD1JPH3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDcuMS1jMDAwIDc5LmVkYTJiM2ZhYywgMjAyMS8xMS8xNy0xNzoyMzoxOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUMyMzkwQTczMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUMyMzkwQTYzMTM3MTFFRDg3NUZBOUZCRDk1MThFMTMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDIzLjEgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjFBQkIwMjIzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjFBQkIwMjMzMTA2MTFFREEzRkNBQzVFOTRFRTVERTgiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5lgZ3iAAAB2ElEQVR42uzd7U3CUBiA0Wr4DxvQDWQE4gS6gSO6ibhB2aBMoCG5ja83pVRaSSnnJE2/MII+t7386sPz21dxQ1ZpKdNSpPUynItL/nNd6rSc2t6n/Sot+TYTsJhgrJsU6TqLt7zS779EE3ad1vuwvwuDg5kF3QQao92E47fq3ICrQ/RN8LsQPBMPOob7lEV8j5o7z6Yj+Cbwzyx+U5orB32MdCvcwcFv0/ZLx5SmubrHAVCZ0lwW9CrEu07rcsC8k/GmNPk8vg7hx2P13K/4fYP+6LhdcjvR5wMgrmP0h5bXxdecmjadu1N0ffFuOxc/zzKcP65fhwQt5nkOgGJu08NH/1cEDYIGQYOgETQIGgQNggZBI2gQNAgaBA2CRtAgaBA0CBoEjaBB0CBoEDQIGkGDoEHQIGgQNIIGQYOgQdAgaAQNE7aY+Ptre7JSn6ct9VWe2UfQvx4XFuPbZ+fz1/5HsGPEHh831mw359bhWH6OCQf9Xvw8v67OQmyLcg6GfJ4Yd769Dvviv+yuXQ0N+tXf8aKpUtUz/rJlvWw5Pmf5RfIQ7vJV0fO55wvtTSL+3R+mQasTd4BlyzRpdeWBEKeL+aC+yt1d0PczDSpH/PJbjfi+RvUtwADssXzgKiX3gwAAAABJRU5ErkJggg=="/>
				</defs>
			</svg>
		</i>
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
	<p class="tp-el-content"><?php echo tp_kses( $settings['tp_section_description'] ); ?></p>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php endif;
	}
}

$widgets_manager->register( new TP_Heading() );