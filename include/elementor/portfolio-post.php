<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Portfolio_Post extends Widget_Base {

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
		return 'tp-portfolio-post';
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
		return __( 'Portfolio Post', 'tpcore' );
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
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();


        $this->tp_section_title_render_controls('portfolio', 'Section Title', 'Sub Title', 'Your title here', 'Hic nesciunt galisum aut dolorem aperiam eum soluta quod ea cupiditate.', ['layout-1', 'layout-2']);

        
        // Product Query

        $this->tp_query_controls('portfolio', 'Portfolio', 'tp-portfolios', '6', '10', 'portfolios-cat');

        // tp_post__columns_section
        $this->tp_columns('col', ['layout-1', 'layout-2']);

        // layout Panel
        $this->start_controls_section(
            'add_features_sec',
            [
                'label' => esc_html__('Additional Features', 'tpcore'),
            ]
        );

        $this->add_control(
            'tp_all_work', [
                'label' => esc_html__('Default Button', 'tpcore'),
                'description' => tp_get_allowed_html_desc( 'basic' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('All Items', 'tpcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
        'tp_post_pagination',
        [
            'label'        => esc_html__( 'Pagination On/Off', 'tpcore' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'tpcore' ),
            'label_off'    => esc_html__( 'Hide', 'tpcore' ),
            'return_value' => 'yes',
            'default'      => '0',
        ]
        );

        $this->end_controls_section();
        

	}

    // style_tab_content
    protected function style_tab_content(){
        $this->tp_section_style_controls('portfolio_section', 'Section Style', '.ele-section');
        $this->tp_basic_style_controls('section_subtitle', 'Section - Subtitle', '.tp-el-subtitle', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_title', 'Section - Title', '.tp-el-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('section_desc', 'Section - Description', '.tp-el-content', ['layout-1', 'layout-2']);
        # repeate
        $this->tp_basic_style_controls('rep_cat', 'Repeater Category', '.tp-el-rep-cat', 'layout-1');
        $this->tp_link_controls_style('rep_title', 'Repeater Title', '.tp-el-rep-title', ['layout-1', 'layout-2']);
        $this->tp_basic_style_controls('rep_des', 'Repeater Description', '.tp-el-rep-des', ['layout-1', 'layout-2']);
        $this->tp_link_controls_style('rep_cat_link', 'Repeater Category', '.tp-el-rep-cat-link', 'layout-2');


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

        /**
         * Setup the post arguments.
        */
        $query_args = TP_Helper::get_query_args('tp-portfolios', 'portfolios-cat', $this->get_settings());

        // The Query
        $query = new \WP_Query($query_args);

        $cat_list = $settings['category'];

        ?>

<?php if ( $settings['tp_design_style']  == 'layout-2' ): 
    $this->add_render_attribute('title_args', 'class', 'portfolio-inner-2-head tp-el-title');
?>

<section class="portfolio-area pt-190 pb-110 ele-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="portfolio-inner-2 text-center mb-50">
                    <?php if ( !empty($settings['tp_portfolio_sub_title']) ) : ?>
                    <p class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_portfolio_sub_title'] ); ?></p>
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
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portfolio-inner-masonary portfolio-inner-masonary-2 text-center masonary-menu mb-60">
                    <?php if(!empty($cat_list)) : ?>
                    <?php if(!empty($settings['tp_all_work'])) : ?>
                    <button class="active" data-filter="*"><span><?php echo esc_html__('All Work', 'seomy'); ?></span></button>
                    <?php endif; ?>
                    <?php foreach($cat_list as $key => $cat) : ?>
                    <button class="<?php echo empty($settings['tp_all_work']) && $key == 0 ? 'active' : NULL; ?>"
                        data-filter=".<?php echo esc_attr($cat); ?>"><span><?php echo esc_html($cat); ?></span></button>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
        <div class="row grid">

            <?php if ($query->have_posts()) :
                while ($query->have_posts()) : 
                $query->the_post();
                global $post;
                $categories = get_the_terms( $post->ID, 'portfolios-cat' );
            ?>
            <div class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?> grid-item <?php foreach($categories as $cat){ echo $cat->slug.' '; } ?>">
                <div class="portfolio-inner-item-2 mb-40">

                    <?php if(has_post_thumbnail()) : ?>
                    <div class="portfolio-inner-thumb-2">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php endif; ?>

                    <div class="portfolio-inner-content-2">
                        <div class="portfolio-inner-title-2"><a class="tp-el-rep-title" href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a></div>
                        <?php if (!empty($settings['tp_post_content'])):
                            $tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
                        ?>
                        <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?></p>
                        <?php endif; ?>

                        <div class="portfolio-inner-tag-2">
                            <?php 
                                foreach($categories as $key => $cat){
                                    echo "<a class='mr-5 tp-el-rep-cat-link' href='".esc_url(get_category_link($cat->term_id))."'>".$cat->name."</a>";
                                } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_query(); endif; ?>

        </div>

        <?php if($settings['tp_post_pagination'] == 'yes' && '-1' != $settings['posts_per_page']) :?>
        <div class="basic-pagination mt-30">
            <?php
            $big = 999999999;

            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } else if (get_query_var('page')) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }

            echo paginate_links( array(
                'base'       => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                'format'     => '?paged=%#%',
                'current'    => $paged,
                'total'      => $query->max_num_pages,
                'type'       =>'list',
                'prev_text'  =>'<i>
                                          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M11 6H1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                             <path d="M6 11L1 6L6 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          </svg>
                                       </i> Prev Page',
                'next_text'  =>'Next page <i>
                                          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M1 6H11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                             <path d="M6 11L11 6L6 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          </svg>
                                       </i>',
                'show_all'   => false,
                'end_size'   => 1,
                'mid_size'   => 4,
            ) );
            ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<?php else: 
    $this->add_render_attribute('title_args', 'class', 'portfolio-inner-head tp-el-title');   
    
?>

<section class="portfolio-area pt-100 pb-110 ele-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="portfolio-inner mb-50">
                    <?php if ( !empty($settings['tp_portfolio_sub_title']) ) : ?>
                    <p class="tp-el-subtitle"><?php echo tp_kses( $settings['tp_portfolio_sub_title'] ); ?></p>
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
            <div class="col-lg-6 align-self-end">
                <div class="portfolio-inner-masonary masonary-menu mb-50">

                    <?php if(!empty($cat_list)) : ?>
                    <?php if(!empty($settings['tp_all_work'])) : ?>
                    <button class="active"
                        data-filter="*"><span><?php echo esc_html__('All Work', 'seomy'); ?></span></button>
                    <?php endif; ?>
                    <?php foreach($cat_list as $key => $cat) : ?>
                    <button class="<?php echo empty($settings['tp_all_work']) && $key == 0 ? 'active' : NULL; ?>"
                        data-filter=".<?php echo esc_attr($cat); ?>"><span><?php echo esc_html($cat); ?></span></button>
                    <?php endforeach; endif; ?>

                </div>
            </div>
        </div>
        <div class="row grid">

            <?php if ($query->have_posts()) :
                while ($query->have_posts()) : 
                $query->the_post();
                global $post;
                $categories = get_the_terms( $post->ID, 'portfolios-cat' );
            ?>
            <div
                class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?> grid-item <?php foreach($categories as $cat){ echo $cat->slug.' '; } ?>">
                <div class="portfolio-inner-item mb-60">
                    <?php if(has_post_thumbnail()) : ?>
                    <div class="portfolio-inner-thumb">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php endif; ?>
                    <div class="portfolio-inner-content">
                        <span class="tp-el-rep-cat"><?php echo esc_html($categories[0]->name); ?></span>
                        <h4 class="portfolio-inner-title"><a class="tp-el-rep-title" href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a>
                        </h4>
                        <?php if (!empty($settings['tp_post_content'])):
                            $tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
                        ?>
                        <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_query(); endif; ?>
        </div>

        <?php if($settings['tp_post_pagination'] == 'yes' && '-1' != $settings['posts_per_page']) :?>
        <div class="basic-pagination mt-30">
            <?php
            $big = 999999999;

            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } else if (get_query_var('page')) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }

            echo paginate_links( array(
                'base'       => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                'format'     => '?paged=%#%',
                'current'    => $paged,
                'total'      => $query->max_num_pages,
                'type'       =>'list',
                'prev_text'  =>'<i>
                                          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M11 6H1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                             <path d="M6 11L1 6L6 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          </svg>
                                       </i> Prev Page',
                'next_text'  =>'Next page <i>
                                          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M1 6H11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                             <path d="M6 11L11 6L6 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          </svg>
                                       </i>',
                'show_all'   => false,
                'end_size'   => 1,
                'mid_size'   => 4,
            ) );
            ?>
        </div>
        <?php endif; ?>

    </div>
</section>


<?php endif;
	}

}

$widgets_manager->register( new TP_Portfolio_Post() );