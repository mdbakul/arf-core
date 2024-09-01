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
class TP_Pricing extends Widget_Base {

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
		return 'tp-pricing';
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
		return __( 'Pricing', 'tpcore' );
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
                    'layout-2' => esc_html__('Layout 2', 'tpcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->add_control(
            'active_price',
            [
                'label' => __('Active Price', 'tpcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'tpcore'),
                'label_off' => __('Hide', 'tpcore'),
                'return_value' => 'yes',
                'default' => false,
                'style_transfer' => true,
            ]
        );

        $this->end_controls_section();

        // Header
        $this->start_controls_section(
            '_section_header',
            [
                'label' => __('Header', 'tpcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
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
            'header_title',
            [
                'label' => __('Title', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Basic', 'tpcore'),
                'dynamic' => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_features',
            [
                'label' => __('Features', 'tpcore'),
            ]
        );

        $this->add_control(
            'show_features',
            [
                'label' => __('Show', 'tpcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'tpcore'),
                'label_off' => __('Hide', 'tpcore'),
                'return_value' => 'yes',
                'default' => 'yes',
                'style_transfer' => true,
            ]
        );


        $repeater = new Repeater();

        $repeater->add_control(
            'tp_feature_unavailable',
            [
                'label' => __('Feature Hide ?', 'bdevs-element'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'bdevs-element'),
                'label_off' => __('Hide', 'bdevs-element'),
                'return_value' => 'yes',
                'default' => 0,
                'style_transfer' => true,
            ]
        );

        $repeater->add_control(
            'tp_check_icon_type',
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
        $repeater->add_control(
            'tp_check_icon_svg',
            [
                'show_label' => false,
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__('SVG Code Here', 'tpcore'),
                'condition' => [
                    'tp_check_icon_type' => 'svg',
                ]
            ]
        );

        $repeater->add_control(
            'tp_check_icon_image',
            [
                'label' => esc_html__('Upload Icon Image', 'tpcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tp_check_icon_type' => 'image',
                ]
            ]
        );

        if (tp_is_elementor_version('<', '2.6.0')) {
            $repeater->add_control(
                'tp_check_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-check',
                    'condition' => [
                        'tp_check_icon_type' => 'icon',
                    ]
                ]
            );
        } else {
            $repeater->add_control(
                'tp_check_selected_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-check',
                        'library' => 'solid',
                    ],
                    'condition' => [
                        'tp_check_icon_type' => 'icon',
                    ]
                ]
            );
        }

        $repeater->add_control(
            'feature_text',
            [
                'label' => __('Feature Text', 'tpcore'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Exciting Feature', 'tpcore'),
                'dynamic' => [
                    'active' => true
                ]
            ]
        );
        
        $this->add_control(
            'features_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false,
                'default' => [
                    [
                        'feature_text' => __('Standard Feature', 'tpcore'),
                        'tp_check_icon' => 'fa fa-check',
                    ],
                    [
                        'feature_text' => __('Another Great Feature', 'tpcore'),
                        'tp_check_icon' => 'fa fa-check',
                    ],
                    [
                        'feature_text' => __('Obsolete Feature', 'tpcore'),
                        'tp_check_icon' => 'fa fa-close',
                    ],
                ],
                'title_field' => '{{{ feature_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_pricing',
            [
                'label' => __('Pricing', 'tpcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'currency',
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

        $this->add_control(
            'currency_custom',
            [
                'label' => __('Custom Symbol', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'currency' => 'custom',
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => __('Price', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => '9.99',
                'dynamic' => [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'month_year',
            [
                'label' => __('Month / Year', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => 'This Is For 1 Month',
                'dynamic' => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();
        
        $this->tp_button_render('pricing', 'Button'); 


	}

    

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('pricing_section', 'Section - Style', '.tp-el-section');
        $this->tp_icon_style('section_icon', 'Section Icon/Image/SVG', '.tp-el-icon');
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title');
        $this->tp_basic_style_controls('section_price', 'Section Price', '.tp-el-rice');
        $this->tp_basic_style_controls('section_dura', 'Section Duration', '.tp-el-dura');
        $this->tp_link_controls_style('section_btn', 'Section - Button', '.tp-el-btn');
        # repeater 
        $this->tp_icon_style('rep_icon_style', 'Repeater Icon/Image/SVG', '.tp-el-rep-icon');
        $this->tp_basic_style_controls('rep_title_style', 'Repeater Title', '.tp-el-rep-title');
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
    // Link
    if ('2' == $settings['tp_pricing_btn_link_type']) {
        $this->add_render_attribute('tp-button-arg', 'href', get_permalink($settings['tp_pricing_btn_page_link']));
        $this->add_render_attribute('tp-button-arg', 'target', '_self');
        $this->add_render_attribute('tp-button-arg', 'rel', 'nofollow');
        $this->add_render_attribute('tp-button-arg', 'class', 'tp-btn-blue tp-el-btn');
    } else {
        if ( ! empty( $settings['tp_pricing_btn_link']['url'] ) ) {
            $this->add_link_attributes( 'tp-button-arg', $settings['tp_pricing_btn_link'] );
            $this->add_render_attribute('tp-button-arg', 'class', 'tp-btn-blue tp-el-btn');
        }
    }
    if ($settings['currency'] === 'custom') {
        $currency = $settings['currency_custom'];
    } else {
        $currency = self::get_currency_symbol($settings['currency']);
    }
    $item_active = $settings['active_price'] ? 'active' : '';
?>


<div class="tppricing mb-30 tp-el-section">
    <div class="tppricing-head">
        <div class="tppricing-icon mb-30">
            <?php if($settings['tp_box_icon_type'] == 'icon') : ?>
                <?php if (!empty($settings['tp_box_icon']) || !empty($settings['tp_box_selected_icon']['value'])) : ?>
                <i class="tp-el-icon">
                    <?php tp_render_icon($settings, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                </i>
                <?php endif; ?>
            <?php elseif( $settings['tp_box_icon_type'] == 'image' ) : ?>
                <?php if (!empty($settings['tp_box_icon_image']['url'])): ?>
                <i class="tp-el-icon">
                    <img src="<?php echo $settings['tp_box_icon_image']['url']; ?>" alt="<?php echo get_post_meta(attachment_url_to_postid($settings['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                </i>
                <?php endif; ?>
            <?php else : ?>
                <?php if (!empty($settings['tp_box_icon_svg'])): ?>
                <i class="tp-el-icon">
                    <?php echo $settings['tp_box_icon_svg']; ?>
                </i>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if(!empty($settings['header_title'])) : ?>
        <h3 class="tppricing-title mb-50 tp-el-title"><?php echo tp_kses($settings['header_title']); ?></h3>
        <?php endif; ?>
    </div>
    <div class="tppricing-content">
        <div class="tppricing-feature mb-45">
            <ul>
                <?php foreach ($settings['features_list'] as $index => $item) : ?>
                <li class="tp-el-rep-icon tp-el-rep-title <?php echo $item['tp_feature_unavailable'] ? "tppricing-inactive" : NULL; ?>">
                <?php if($item['tp_check_icon_type'] == 'icon') : ?>
                    <?php if (!empty($item['tp_check_icon']) || !empty($item['tp_check_selected_icon']['value'])) : ?>
                    <?php tp_render_icon($item, 'tp_check_icon', 'tp_check_selected_icon'); ?>
                    <?php endif; ?>
                <?php elseif( $item['tp_check_icon_type'] == 'image' ) : ?>
                    <?php if (!empty($item['tp_check_icon_image']['url'])): ?>
                    <img src="<?php echo $item['tp_check_icon_image']['url']; ?>" alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_check_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                    <?php endif; ?>
                <?php else : ?>
                    <?php if (!empty($item['tp_check_icon_svg'])): ?>
                    <?php echo $item['tp_check_icon_svg']; ?>
                    <?php endif; ?>
                <?php endif; ?><?php echo tp_kses($item['feature_text']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="tppricing-price mb-40">
            <h4 class="tppricing-price-title tp-el-rice"><?php echo esc_html($currency); ?><?php echo tp_kses($settings['price']); ?></h4>
            <?php if(!empty($settings['month_year'])) : ?>
            <span class="tp-el-dura"><?php echo tp_kses($settings['month_year']); ?></span>
            <?php endif; ?>
        </div>
        <?php if ( !empty($settings['tp_pricing_btn_text']) ) : ?>
        <div class="<?php echo $settings['active_price'] ? 'tppricing-btn-two' : NULL; ?>">
            <a <?php echo $this->get_render_attribute_string( 'tp-button-arg' ); ?>><?php echo tp_kses($settings['tp_pricing_btn_text']); ?></a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php endif;  
    }
}

$widgets_manager->register( new TP_Pricing() );