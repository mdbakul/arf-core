<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Repeater;
use \Elementor\Control_Media;
use \Elementor\Utils;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Advanced_Pricing_2 extends Widget_Base {

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
		return 'tp-advanced-pricing-2';
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
		return __( 'Advanced Pricing 2', 'tpcore' );
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


        $this->start_controls_section(
            '_section_design_title',
            [
                'label' => __('Design Style', 'tpcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
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

        // pricing top
        $this->start_controls_section(
            '_section_pricing_top',
            [
                'label' => __('Pricing Header', 'tpcore'),
            ]
        );

        $this->add_control(
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
            ]
        );
        $this->add_control(
            'tp_box_icon_svg',
            [
                'show_label' => false,
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__('SVG Code Here', 'tpcore'),
                'condition' => [
                    'tp_box_icon_type' => 'svg',
                ]
            ]
        );

        $this->add_control(
            'tp_box_icon_image',
            [
                'label' => esc_html__('Upload Icon Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_box_icon_type' => 'image',
                ]
            ]
        );

        if (tp_is_elementor_version('<', '2.6.0')) {
            $this->add_control(
                'tp_box_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-star',
                    'condition' => [
                        'tp_box_icon_type' => 'icon',
                    ]
                ]
            );
        } else {
            $this->add_control(
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
                    ]
                ]
            );
        }

        $this->add_control(
            'tp_head_title',
            [
                'label' => __('Title', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Features', 'tpcore'),
                'label_block' => true,
                'description' => tp_get_allowed_html_desc( 'basic' ),
            ]
        );

        // button
        $this->add_control(
            'tp_top_link_switcher',
            [
                'label' => esc_html__( 'Add About link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        
        $this->add_control(
        'top_btn_text',
            [
                'label'   => esc_html__( 'Button Text', 'tpcore' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Read More', 'tpcore' ),
                'label_block' => true,
                'condition' => [
                    'tp_top_link_switcher' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tp_top_link_type',
            [
                'label' => esc_html__( 'About Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_top_link_switcher' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tp_top_link',
            [
                'label' => esc_html__( 'About Link link', 'tpcore' ),
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
                    'tp_top_link_type' => '1',
                    'tp_top_link_switcher' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'tp_top_page_link',
            [
                'label' => esc_html__( 'Select About Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_top_link_type' => '2',
                    'tp_top_link_switcher' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();

        // pricing heading
        $this->start_controls_section(
            '_section_pricing_heading',
            [
                'label' => __('Pricing', 'tpcore'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tp_pricing_active',
            [
                'label' => __('Active', 'tpcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'tpcore'),
                'label_off' => __('Hide', 'tpcore'),
                'return_value' => 'yes',
                'default' => '0',
                'style_transfer' => true,
            ]
        );
        
        $repeater->add_control(
            'tp_badge_title',
            [
                'label' => __('Badge Title', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Beginner', 'tpcore'),
                'label_block' => true
            ]
        );
        
        $repeater->add_control(
            'tp_price_title',
            [
                'label' => __('Title', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Business', 'tpcore'),
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'tp_price_currency',
            [
                'label' => __('Currency', 'tpcore'),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    '' => __('None', 'tpcore'),
                    'baht' => '&#3647; ' . _x('Baht', 'Currency Symbol', 'tpcore'),
                    'bdt' => '&#2547; ' . _x('BD Taka', 'Currency Symbol', 'tpcore'),
                    'dollar' => '&#36; ' . _x('Dollar', 'Currency Symbol', 'tpcore'),
                    'euro' => '&#128; ' . _x('Euro', 'Currency Symbol', 'tpcore'),
                    'franc' => '&#8355; ' . _x('Franc', 'Currency Symbol', 'tpcore'),
                    'guilder' => '&fnof; ' . _x('Guilder', 'Currency Symbol', 'tpcore'),
                    'krona' => 'kr ' . _x('Krona', 'Currency Symbol', 'tpcore'),
                    'lira' => '&#8356; ' . _x('Lira', 'Currency Symbol', 'tpcore'),
                    'peso' => '&#8369; ' . _x('Peso', 'Currency Symbol', 'tpcore'),
                    'pound' => '&#163; ' . _x('Pound Sterling', 'Currency Symbol', 'tpcore'),
                    'real' => 'R$ ' . _x('Real', 'Currency Symbol', 'tpcore'),
                    'ruble' => '&#8381; ' . _x('Ruble', 'Currency Symbol', 'tpcore'),
                    'indian_rupee' => '&#8377; ' . _x('Rupee (Indian)', 'Currency Symbol', 'tpcore'),
                    'shekel' => '&#8362; ' . _x('Shekel', 'Currency Symbol', 'tpcore'),
                    'won' => '&#8361; ' . _x('Won', 'Currency Symbol', 'tpcore'),
                    'yen' => '&#165; ' . _x('Yen/Yuan', 'Currency Symbol', 'tpcore'),
                    'custom' => __('Custom', 'tpcore'),
                ],
                'default' => 'dollar',
            ]
        );

        $repeater->add_control(
            'tp_price_custom_currency',
            [
                'label' => __('Custom Symbol', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'tp_price_currency' => 'custom',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'tp_price_currency' => 'custom'
                ]
            ]
        );

        $repeater->add_control(
            'tp_price',
            [
                'label' => __('Price', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => '19',
                'dynamic' => [
                    'active' => true
                ],
                'description' => tp_get_allowed_html_desc( 'basic' ),
            ]
        );

        $repeater->add_control(
            'tp_pricing_link_switcher',
            [
                'label' => esc_html__( 'Add Services link', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'tpcore' ),
                'label_off' => esc_html__( 'No', 'tpcore' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'tp_pricing_btn_text',
            [
                'label' => esc_html__('Button Text', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Button Text', 'tpcore'),
                'title' => esc_html__('Enter button text', 'tpcore'),
                'label_block' => true,
                'condition' => [
                    'tp_pricing_link_switcher' => 'yes',
                ],
            ]
        );
        $repeater->add_control(
            'tp_pricing_link_type',
            [
                'label' => esc_html__( 'Service Link Type', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'condition' => [
                    'tp_pricing_link_switcher' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'tp_pricing_link',
            [
                'label' => esc_html__( 'Service Link link', 'tpcore' ),
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
                    'tp_pricing_link_type' => '1',
                    'tp_pricing_link_switcher' => 'yes',
                ]
            ]
        );

        $repeater->add_control(
            'tp_pricing_page_link',
            [
                'label' => esc_html__( 'Select Service Link Page', 'tpcore' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => tp_get_all_pages(),
                'condition' => [
                    'tp_pricing_link_type' => '2',
                    'tp_pricing_link_switcher' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'pricing_pricing_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false,
                'default' => [
                    [ 
                        'tp_badge_title' => __('Beginner', 'tpcore'),
                    ],
                    [
                        'tp_badge_title' => __('Future', 'tpcore'),
                    ],
                    [
                        'tp_badge_title' => __('Midilize', 'tpcore'),
                    ],
                ],
                'title_field' => '<# print((tp_badge_title)); #>',
            ]
        );

        $this->end_controls_section();


	}

    private static function get_currency_symbol($symbol_name)
    {
        $symbols = [
            'baht' => '&#3647;',
            'bdt' => '&#2547;',
            'dollar' => '&#36;',
            'euro' => '&#128;',
            'franc' => '&#8355;',
            'guilder' => '&fnof;',
            'indian_rupee' => '&#8377;',
            'pound' => '&#163;',
            'peso' => '&#8369;',
            'peseta' => '&#8359',
            'lira' => '&#8356;',
            'ruble' => '&#8381;',
            'shekel' => '&#8362;',
            'rupee' => '&#8360;',
            'real' => 'R$',
            'krona' => 'kr',
            'won' => '&#8361;',
            'yen' => '&#165;',
        ];

        return isset($symbols[$symbol_name]) ? $symbols[$symbol_name] : '';
    }

    private static function get_currency_symbol_text($symbol_text)
    {
        $symbols =[
            'baht' => 'THB',
            'bdt' => 'BDT',
            'dollar' => 'USD',
            'euro' => 'EUR',
            'franc' => 'EUR',
            'guilder' => 'GLD',
            'indian_rupee' => 'INR',
            'pound' => 'GBP',
            'peso' => 'MXN',
            'lira' => 'TRY',
            'ruble' => 'RUB',
            'shekel' => 'ILS',
            'real' => 'BRL',
            'krona' => 'KR',
            'won' => 'KRW',
            'yen' => 'JPY',
        ];

        return isset($symbols[$symbol_text]) ? $symbols[$symbol_text] : '';
    }

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('pricing_section', 'Section - Style', '.tp-el-section');
        $this->tp_icon_style('header_icon', 'Header Icon/Image/SVG', '.tp-el-head-icon');
        $this->tp_basic_style_controls('header_title', 'Header Title', '.tp-el-head-title');
        $this->tp_link_controls_style('header_btn', 'Header Button', '.tp-el-head-btn');
        #repeater
        $this->tp_basic_style_controls('rep_badge_title', 'Repeater Badge Title', '.tp-el-rep-badge-title');
        $this->tp_basic_style_controls('rep_title', 'Repeater Title', '.tp-el-rep-title');
        $this->tp_basic_style_controls('rep_price', 'Repeater Price', '.tp-el-rep-price');
        $this->tp_link_controls_style('rep_btn', 'Repeater Button', '.tp-el-rep-btn');

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
    $this->add_render_attribute('title_args', 'class', 'tp-section-title tp-el-title');
?>

<!-- default style -->
<?php else:

    // Link
    if ('2' == $settings['tp_top_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_top_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'pricing-btn tp-el-head-btn');
    } else {
        if ( ! empty( $settings['tp_top_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_top_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'pricing-btn tp-el-head-btn');
        }
    } 
?>

<div class="pricing-inner tp-el-section">
    <div class="row">

        <div class="col-lg-3 col-md-3">
            <div class="pricing-custom text-center">
                <div class="pricing-custom-icon">

                    <?php if($settings['tp_box_icon_type'] == 'icon') : ?>
                    <?php if (!empty($settings['tp_box_icon']) || !empty($settings['tp_box_selected_icon']['value'])) : ?>
                    <span class="tp-el-head-icon">
                        <?php tp_render_icon($settings, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                    </span>
                    <?php endif; ?>
                    <?php elseif( $settings['tp_box_icon_type'] == 'image' ) : ?>
                    <?php if (!empty($settings['tp_box_icon_image']['url'])): ?>
                    <span class="tp-el-head-icon">
                        <img src="<?php echo $settings['tp_box_icon_image']['url']; ?>"
                            alt="<?php echo get_post_meta(attachment_url_to_postid($settings['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                    </span>
                    <?php endif; ?>
                    <?php else : ?>
                    <?php if (!empty($settings['tp_box_icon_svg'])): ?>
                    <span class="tp-el-head-icon">
                        <?php echo $settings['tp_box_icon_svg']; ?>
                    </span>
                    <?php endif; ?>
                    <?php endif; ?>

                </div>
                <div class="pricing-custom-content">
                    <?php if(!empty($settings['tp_head_title'])) : ?>
                    <span class="tp-el-head-title"><?php echo tp_kses($settings['tp_head_title']); ?></span>
                    <?php endif; ?>
                    <?php if ( !empty($settings['top_btn_text']) ) : ?>
                    <div class="pricing-inner-btn">
                        <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['top_btn_text']); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php foreach($settings['pricing_pricing_list'] as $key => $item) : 
            // currency
            if ($item['tp_price_currency'] === 'custom') {
                $top_currency = $item['tp_price_custom_currency'];
            } else {
                $top_currency = self::get_currency_symbol($item['tp_price_currency']);
            }    
            // Link
            if ('2' == $item['tp_pricing_link_type']) {
                $link = get_permalink($item['tp_pricing_page_link']);
                $target = '_self';
                $rel = 'nofollow';
            } else {
                $link = !empty($item['tp_pricing_link']['url']) ? $item['tp_pricing_link']['url'] : '';
                $target = !empty($item['tp_pricing_link']['is_external']) ? '_blank' : '';
                $rel = !empty($item['tp_pricing_link']['nofollow']) ? 'nofollow' : '';
            }   
        ?>
        <div class="col-lg-3 col-md-3">
            <div class="pricing-inner-item text-center <?php echo $item['tp_pricing_active'] ? 'active' : NULL; ?>">
                <?php if(!empty($item['tp_badge_title'])) : ?>
                <div class="pricing-inner-head">
                    <span class="tp-el-rep-badge-title"><?php echo tp_kses($item['tp_badge_title']); ?></span>
                </div>
                <?php endif; ?>
                <?php if(!empty($item['tp_price_title'])) : ?>
                <div class="pricing-inner-title">
                    <span class="tp-el-rep-title"><?php echo tp_kses($item['tp_price_title']); ?></span>
                </div>
                <?php endif; ?>
                <div class="pricing-inner-price">
                    <h4 class="pricing-inner-price-count tp-el-rep-price"><span><?php echo $top_currency ? esc_html($top_currency) : NULL; ?></span><?php echo $item['tp_price'] ? tp_kses($item['tp_price']) : NULL; ?></h4>
                </div>
                <?php if(!empty($item['tp_pricing_btn_text'])) : ?>
                <div class="pricing-inner-btn">
                    <a class="tp-el-rep-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" rel="<?php echo esc_attr($rel); ?>" class="pricing-btn"><?php echo tp_kses($item['tp_pricing_btn_text']); ?></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<?php endif;
    }
}

$widgets_manager->register( new TP_Advanced_Pricing_2() );