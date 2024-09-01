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
class TP_Advanced_Pricing extends Widget_Base {

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
		return 'tp-advanced-pricing';
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
		return __( 'Advanced Pricing', 'tpcore' );
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
            'tp_pricing_top_main_title',
            [
                'label' => __('Title', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Features & Services', 'tpcore'),
                'label_block' => true,
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'condition' => [
                    'tp_design_style' => 'layout-3'
                ]
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
            'tp_pricing_top_active',
            [
                'label' => __('Active Price', 'tpcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'tpcore'),
                'label_off' => __('Hide', 'tpcore'),
                'return_value' => 'yes',
                'default' => '0',
                'style_transfer' => true,
            ]
        );

        $repeater->add_control(
            'tp_pricing_top_title',
            [
                'label' => __('Pricing Title', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Exciting Pricing', 'tpcore'),
                'label_block' => true,
                'description' => tp_get_allowed_html_desc( 'basic' ),
            ]
        );

        $repeater->add_control(
            'tp_price_top_currency',
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
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2']
                ]
            ]
        );

        $repeater->add_control(
            'tp_price_top_custom_currency',
            [
                'label' => __('Custom Symbol', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'tp_price_top_currency' => 'custom',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2'],
                    'tp_price_top_currency' => 'custom'
                ]
            ]
        );

        $repeater->add_control(
            'tp_price_top_price',
            [
                'label' => __('Price', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => '19',
                'dynamic' => [
                    'active' => true
                ],
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'condition' => [
                    'repeater_condition' => ['style_1', 'style_2']
                ]
            ]
        );
        
        $this->add_control(
            'pricing_top_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false,
                'default' => [
                    [
                        'tp_pricing_top_title' => __('Standard', 'tpcore'),
                        'tp_price_top_price' => __('10.00', 'tpcore'),
                    ],
                    [
                        'tp_pricing_top_title' => __('Another Great', 'tpcore'),
                        'tp_price_top_price' => __('20.00', 'tpcore'),
                    ],
                    [
                        'tp_pricing_top_title' => __('Obsolete', 'tpcore'),
                        'tp_price_top_price' => __('30.00', 'tpcore'),
                    ],
                ],
                'title_field' => '<# print((tp_pricing_top_title)); #>',
            ]
        );

        $this->end_controls_section();

        // features heading
        $this->start_controls_section(
            '_section_features_heading',
            [
                'label' => __('Features', 'tpcore'),
                'condition' => [
                    'tp_design_style' => ['layout-1', 'layout-2']
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tp_features_active',
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
            'tp_features_head_title',
            [
                'label' => __('Feature Heading Title', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Exciting Feature', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'label_block' => true
            ]
        );
        
        $repeater->add_control(
            'tp_features_title1',
            [
                'label' => __('Feature Title 1', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Exciting Feature 1', 'tpcore'),
                'label_block' => true
            ]
        );
        $repeater->add_control(
            'tp_features_title2',
            [
                'label' => __('Feature Title 2', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Exciting Feature 2', 'tpcore'),
                'label_block' => true
            ]
        );
        $repeater->add_control(
            'tp_features_title3',
            [
                'label' => __('Feature Title 3', 'tpcore'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Exciting Feature 3', 'tpcore'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'features_head_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false,
                'default' => [
                    [ 
                        'tp_features_head_title' => __('Keyword Research', 'tpcore'),
                    ],
                    [
                        'tp_features_head_title' => __('On Page SEO', 'tpcore'),
                    ],
                    [
                        'tp_features_head_title' => __('Content Marketing', 'tpcore'),
                    ],
                ],
                'title_field' => '<# print((tp_features_head_title)); #>',
            ]
        );

        $this->end_controls_section();

        
        // buttons
        $this->start_controls_section(
            '_section_buttons_',
            [
                'label' => __('Buttons', 'tpcore'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tp_button_top_active',
            [
                'label' => __('Active Price', 'tpcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'tpcore'),
                'label_off' => __('Hide', 'tpcore'),
                'return_value' => 'yes',
                'default' => '0',
                'style_transfer' => true,
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
            'tp_buttons_list',
            [
                'label' => esc_html__('Buttons - List', 'tpcore'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tp_pricing_btn_text' => esc_html__('Button 1', 'tpcore'),
                    ],
                    [
                        'tp_pricing_btn_text' => esc_html__('Button 2', 'tpcore')
                    ],
                    [
                        'tp_pricing_btn_text' => esc_html__('Button 3', 'tpcore')
                    ]
                ],
                'title_field' => '{{{ tp_pricing_btn_text }}}',
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
        $this->tp_basic_style_controls('pricing_head_title', 'Header Title', '.tp-el-head-title', 'layout-1');
        $this->tp_basic_style_controls('pricing_price', 'Price', '.tp-el-price', 'layout-1');
        $this->tp_basic_style_controls('pricing_fea_heading', 'Features Heading', '.tp-el-fea-head', 'layout-1');
        $this->tp_basic_style_controls('pricing_fea_title', 'Features Title', '.tp-el-fea-title', 'layout-1');
        $this->tp_link_controls_style('pricing_btn', 'Button', '.tp-el-btn', 'layout-1');
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
    $this->add_render_attribute('title_args', 'class', 'tp-section-title-4 pb-25 tp-el-title');
?>

<div class="fix tp-el-section">
    <!-- priceing-top -->
    <div class="tppriceing-top">
        <div class="row gx-0">
            <div class="price-custom-col-1">
            </div>
            <div class="price-custom-col-2">
                <div class="row gx-0">
                    <?php foreach($settings['pricing_top_list'] as $key => $item) :
                        // currency
                        if ($item['tp_price_top_currency'] === 'custom') {
                            $top_currency = $item['tp_price_top_custom_currency'];
                        } else {
                            $top_currency = self::get_currency_symbol($item['tp_price_top_currency']);
                        }
                        $active_price = $item['tp_pricing_top_active'] ? 'active' : NULL;    
                    ?>
                    <div class="col-4">
                        <div class="tppricing-4-head text-center <?php echo $item['tp_pricing_top_active'] ? 'active' : NULL; ?>">
                            <span class="tp-el-head-title"><?php echo $item['tp_pricing_top_title'] ? tp_kses($item['tp_pricing_top_title']) : NULL; ?></span>
                            <?php echo $item['tp_pricing_top_active'] ? '<div class="big-price-shape"></div><div class="sm-price-shape"></div>' : NULL; ?>
                            <h4 class="title tp-el-price"><?php echo $top_currency ? esc_html($top_currency) : NULL; ?><?php echo $item['tp_price_top_price'] ? tp_kses($item['tp_price_top_price']) : NULL; ?></h4>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- priceing-top-end -->
    <!-- pricing-box -->
    <div class="pricing-box-4">

        <?php foreach($settings['features_head_list'] as $key => $item) : ?>
        <div class="row gx-0">
            <?php if(!empty($item['tp_features_head_title'])) : ?>
            <div class="price-custom-col-1">
                <div class="tppricing-4-title">
                    <h4 class="title tp-el-fea-head"><?php echo tp_kses($item['tp_features_head_title']); ?></h4>
                </div>
            </div>
            <?php endif; ?>
            <div class="price-custom-col-2">
                <div class="row gx-0">

                    <?php if(!empty($item['tp_features_title1'])) : ?>
                    <div class="col-4">
                        <div class="tppricing-4-price <?php echo $key == 0 ? 'tppricing-right' : NULL; ?> text-center">
                            <p class="tp-el-fea-title"><?php echo tp_kses($item['tp_features_title1']); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($item['tp_features_title2'])) : ?>
                    <div class="col-4">
                        <div class="tppricing-4-price <?php echo $item['tp_features_active'] ? 'active' : NULL; ?> text-center">
                            <p class="tp-el-fea-title"><?php echo tp_kses($item['tp_features_title2']); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($item['tp_features_title3'])) : ?>
                    <div class="col-4">
                        <div class="tppricing-4-price <?php echo $key == 0 ? 'tppricing-left' : NULL; ?> text-center">
                            <p class="tp-el-fea-title"><?php echo tp_kses($item['tp_features_title3']); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- pricing-item -->
        <div class="row gx-0">
            <div class="price-custom-col-1"></div>
            <div class="price-custom-col-2">
                <div class="row gx-0">

                    <?php foreach($settings['tp_buttons_list'] as $key => $item) : 
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
                    <div class="col-4">
                        <div class="tppricing-4-price <?php echo $item['tp_button_top_active'] ? 'active' : NULL; ?> tppricing-4-btn">
                            <p>
                                <?php if(!empty($item['tp_pricing_btn_text'])) : ?>
                                <a class="tp-el-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>"
                                rel="<?php echo esc_attr($rel); ?>"><?php echo tp_kses($item['tp_pricing_btn_text']); ?></a>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
        <!-- pricing-item-end -->
    </div>
    <!-- pricing-box-end -->
</div>


<?php endif;
    }
}

$widgets_manager->register( new TP_Advanced_Pricing() );