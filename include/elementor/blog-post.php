<?php
namespace TPCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Tp Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TP_Blog_Post extends Widget_Base {

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
		return 'blogpost';
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
		return __( 'Blog Post', 'tpcore' );
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
        
        // Blog Query
        $this->tp_query_controls('blog', 'Blog','post');
        
        // section column
        $this->tp_columns('col', ['layout-1', 'layout-3', 'layout-4', 'layout-7']);

        // layout Panel
        $this->start_controls_section(
            'add_features_sec',
            [
                'label' => esc_html__('Additional Features', 'tpcore'),
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
		$this->tp_section_style_controls('blog_section', 'Section Style', '.tp-el-section');
        # repeater 
        $this->tp_link_controls_style('rep_cat_style', 'Blog Category', '.tp-el-rep-cat', ['layout-1', 'layout-2', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_link_controls_style('rep_title_style', 'Blog Title', '.tp-el-rep-title', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_basic_style_controls('rep_des_style', 'Blog Description', '.tp-el-rep-des', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_link_controls_style('rep_btn_style', 'Blog Button', '.tp-el-rep-btn', ['layout-1', 'layout-2', 'layout-6']);
        $this->tp_icon_style('rep_avatar_style', 'Blog Avatar Icon/Image/SVG', '.tp-el-rep-avatar', 'layout-1');
        $this->tp_basic_style_controls('rep_ava_name_style', 'Blog Avatar Name', '.tp-el-rep-ava-name', ['layout-1', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
        $this->tp_basic_style_controls('rep_date_style', 'Blog Date', '.tp-el-rep-date', ['layout-1', 'layout-2', 'layout-3', 'layout-4', 'layout-5', 'layout-6', 'layout-7']);
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
        $query_args = TP_Helper::get_query_args('post', 'category', $this->get_settings());

        // The Query
        $query = new \WP_Query($query_args);


        $filter_list = $settings['category'];

        ?>

<?php if ( $settings['tp_design_style']  == 'layout-2' ) : ?>

<?php if ($query->have_posts()) :
	$i = 0.0;
	while ($query->have_posts()) : 
	$query->the_post();
	global $post;
	$categories = get_the_category($post->ID);
	$author_id = get_the_author_meta('ID');
	$author_avatar_url = get_avatar_url($author_id);
	$i+=0.3;
?>
<div class="blog-single mb-40 p-relative tp-el-section">
    <?php if(!empty(has_post_thumbnail())) : ?>
    <div class="blog-single-thumb" style="background-image: url(<?php echo get_the_post_thumbnail_url()?>);"></div>
    <?php endif; ?>
    <div class="row align-items-center justify-content-end">
        <div class="col-lg-5 col-md-6">
            <div class="blog-single-content">
                <div class="blog-single-meta mb-20">
                    <?php if(!empty($categories[0]->name)) : ?>
                    <a class="tp-el-rep-cat" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo esc_html($categories[0]->name); ?></a>
                    <?php endif; ?>
                    <span class="meta-list tp-el-rep-date"><?php the_time( 'd M, Y' ); ?></span>
                </div>
                <h4 class="blog-single-title mb-20 tp-el-rep-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a>
                </h4>
                <?php if (!empty($settings['tp_post_content'])):
					$tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
						?>
                <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?></p>
                <?php endif; ?>
                <?php if(!empty($settings['tp_post_button'])) : ?>
                <a class="radient-btn tp-el-rep-btn" href="<?php the_permalink(); ?>"><?php echo tp_kses($settings['tp_post_button']); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endwhile; wp_reset_query(); endif; ?>

<?php if($settings['tp_post_pagination'] == 'yes' && '-1' != $settings['posts_per_page']) : ?>

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

<?php elseif ( $settings['tp_design_style']  == 'layout-3' ) : ?>

<div class="row">

    <?php if ($query->have_posts()) :
		$i = 0.0;
		while ($query->have_posts()) : 
		$query->the_post();
		global $post;
		$categories = get_the_category($post->ID);
		$author_id = get_the_author_meta('ID');
		$author_avatar_url = get_avatar_url($author_id);
		$i+=0.3;
	?>
    <div
        class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
        <div class="blog-item d-flex align-items-center mb-30 tp-el-section">
            <?php if(!empty(has_post_thumbnail())) : ?>
            <div class="blog-thumb">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            </div>
            <?php endif; ?>
            <div class="blog-content">
                <span class="tp-el-rep-date"><?php the_time( 'd M, Y' ); ?></span>
                <h4 class="blog-title tp-el-rep-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a>
                </h4>
                <?php if (!empty($settings['tp_post_content'])):
					$tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
						?>
                <p class="text-white tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endwhile; wp_reset_query(); endif; ?>


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

<?php elseif ( $settings['tp_design_style']  == 'layout-4' ) : ?>

<div class="row">
    <?php if ($query->have_posts()) :
		$i = 0.0;
		while ($query->have_posts()) : 
		$query->the_post();
		global $post;
		$categories = get_the_category($post->ID);
		$author_id = get_the_author_meta('ID');
		$author_avatar_url = get_avatar_url($author_id);
		$i+=0.3;
	?>
    <div
        class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
        <div class="tpblog-4 p-relative mb-60 tp-el-section">
            <?php if(!empty(has_post_thumbnail())) : ?>
            <div class="tpblog-4-thumb" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
            </div>
            <?php endif; ?>
            <div class="row justify-content-end">
                <div class="col-lg-7 col-md-7">
                    <div class="tpblog-4-content">

                        <h5 class="tpblog-4-content-sub-tilte tp-el-rep-cat"><?php echo esc_html($categories[0]->name); ?></h5>

                        <h4 class="tpblog-4-content-title tp-el-rep-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a>
                        </h4>
                        <?php if (!empty($settings['tp_post_content'])):
                            $tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
                                ?>
                        <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?></p>
                        <?php endif; ?>
                        <div class="tpblog-4-info">
                            <span class="tp-el-rep-date"><?php the_time( 'M d, Y' ); ?></span>
                            <span><a class="tp-el-rep-ava-name" href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><i><?php echo esc_html__('By', 'tpcore'); ?></i>
                                    <?php echo ucwords(get_the_author()); ?></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; wp_reset_query(); endif; ?>

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

<?php elseif ( $settings['tp_design_style']  == 'layout-5' ) : ?>

<section class="postbox__area pt-120 pb-90 tp-el-section">
    <div class="container container-lagre-box">
        <div class="row blog-masonry-active">


            <?php if ($query->have_posts()) :
                $i = 0;
                while ($query->have_posts()) : 
                $query->the_post();
                global $post;
                $categories = get_the_category($post->ID);
                $author_id = get_the_author_meta('ID');
                $author_avatar_url = get_avatar_url($author_id);
                $i+=1;

                $mas_col;

                if($i == 3 ) {
                    $mas_col = 'col-xl-6 col-lg-8 col-md-12 blog-masonry-item-active';
                } else {
                    $mas_col = 'col-xl-3 col-lg-4 col-md-6 blog-masonry-item-active';
                }

            ?>
            <div class="<?php echo esc_attr($mas_col); ?>">


                <?php  if($i == 3 ) { ?>

                <div class="tpblog-item-2 mb-30">
                    <?php if(has_post_thumbnail()) : ?>
                    <div class="tpmasonry-thumb">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    </div>
                    <?php endif; ?>
                    <div class="tpmasonry">

                        <?php 
                        if ( has_post_format( 'video' ) ) {
                            $seomy_video_url = function_exists('tpmeta_field')? tpmeta_field('seomy_post_video') : '';
                            if(!empty($seomy_video_url)) :
                            ?>
                        <div class="tpmasonry-video mb-30">
                            <a class="popup-video" href="<?php echo esc_url($seomy_video_url); ?>">
                                <span>
                                    <svg width="15" height="18" viewBox="0 0 15 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 9L0 17.6603L0 0.339746L15 9Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <?php 
                            endif;
                        }
                        ?>

                        <div class="tpmasonry-content">
                            <?php if(!empty($categories[0]->name)) : ?>
                            <div class="blog-list-tag">
                                <a class="tp-el-rep-cat" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo esc_html($categories[0]->name); ?></a>
                            </div>
                            <?php endif; ?>
                            <h4 class="tpmasonry-title tp-el-rep-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a>
                            </h4>

                            <?php if (!empty($settings['tp_post_content'])):
                                $tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
                            ?>
                            <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?>
                            </p>
                            <?php endif; ?>
                            <div class="tpblog-meta-2">
                                <span class="tp-el-rep-date">
                                    <i>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15 8C15 11.864 11.864 15 8 15C4.136 15 1 11.864 1 8C1 4.136 4.136 1 8 1C11.864 1 15 4.136 15 8Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path
                                                d="M10.5967 10.226L8.42672 8.93099C8.04872 8.70699 7.74072 8.16799 7.74072 7.72699V4.85699"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </i>
                                    <?php the_time( 'M d, Y' ); ?>
                                </span>
                                <span>
                                    <a class="tp-el-rep-ava-name" href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
                                        <i>
                                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.99976 7.98487C8.92858 7.98487 10.4922 6.42125 10.4922 4.49243C10.4922 2.56362 8.92858 1 6.99976 1C5.07094 1 3.50732 2.56362 3.50732 4.49243C3.50732 6.42125 5.07094 7.98487 6.99976 7.98487Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M13 14.9697C13 12.2665 10.3108 10.0803 7 10.0803C3.68917 10.0803 1 12.2665 1 14.9697"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </i>
                                        <?php echo ucwords(get_the_author()); ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } else { ?>

                <?php if ( has_post_format( 'quote' ) ) : ?>
                <div class="tpmasonry-item mb-30">
                    <div class="tpmasonry-icon mb-35">
                        <span>
                            <svg width="26" height="22" viewBox="0 0 26 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.36774 0C7.54839 0 9.19785 0.894621 10.3161 2.68387C11.2667 4.19355 11.7419 6.03871 11.7419 8.21936C11.7419 11.0151 11.0151 13.5312 9.56129 15.7677C8.16344 18.0043 6.01075 19.7936 3.10323 21.1355L2.34839 19.6258C4.08172 18.8989 5.56344 17.7527 6.79355 16.1871C8.07957 14.6215 8.72258 13.028 8.72258 11.4065C8.72258 10.7355 8.63871 10.1484 8.47097 9.64516C7.57634 10.372 6.54194 10.7355 5.36774 10.7355C3.85807 10.7355 2.57204 10.2602 1.50968 9.30968C0.503226 8.30323 0 6.98925 0 5.36774C0 3.85807 0.503226 2.6 1.50968 1.59355C2.57204 0.531181 3.85807 0 5.36774 0ZM19.6258 0C21.8065 0 23.4559 0.894621 24.5742 2.68387C25.5247 4.19355 26 6.03871 26 8.21936C26 11.0151 25.2731 13.5312 23.8194 15.7677C22.4215 18.0043 20.2688 19.7936 17.3613 21.1355L16.6065 19.6258C18.3398 18.8989 19.8215 17.7527 21.0516 16.1871C22.3376 14.6215 22.9806 13.028 22.9806 11.4065C22.9806 10.7355 22.8968 10.1484 22.729 9.64516C21.8344 10.372 20.8 10.7355 19.6258 10.7355C18.1161 10.7355 16.8301 10.2602 15.7677 9.30968C14.7613 8.30323 14.2581 6.98925 14.2581 5.36774C14.2581 3.85807 14.7613 2.6 15.7677 1.59355C16.8301 0.531181 18.1161 0 19.6258 0Z"
                                    fill="#4260FF" />
                            </svg>
                        </span>
                    </div>
                    <div class="tpmasonry-content-2">
                        <h4 class="tpmasonry-title-white"><?php echo str_replace('<p>', '<p class="tpmasonry-title-white">', get_the_content()) ?></h4>
                    </div>
                </div>
                <?php else : ?>
                <div class="tpblog-item-2 mb-30">

                    <?php if(has_post_thumbnail()) : ?>
                    <div class="tpblog-thumb-2">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    </div>
                    <?php endif; ?>
                    <div class="tpblog-wrap">
                        <div class="tpblog-content-2">

                            <?php if(!empty($categories[0]->name)) : ?>
                            <span>
                                <a class="tp-el-rep-cat" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo esc_html($categories[0]->name); ?></a>
                            </span>
                            <?php endif; ?>

                            <h4 class="tpblog-title-2 tp-el-rep-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a>
                            </h4>
                            <?php if (!empty($settings['tp_post_content'])):
                                    $tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
                                ?>
                            <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        <div class="tpblog-meta-2">
                            <span class="tp-el-rep-date">
                                <i>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15 8C15 11.864 11.864 15 8 15C4.136 15 1 11.864 1 8C1 4.136 4.136 1 8 1C11.864 1 15 4.136 15 8Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M10.5967 10.226L8.42672 8.93099C8.04872 8.70699 7.74072 8.16799 7.74072 7.72699V4.85699"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </i>
                                <?php the_time( 'M d, Y' ); ?>
                            </span>
                            <span>
                                <a class="tp-el-rep-ava-name" href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
                                    <i>
                                        <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.99976 7.98487C8.92858 7.98487 10.4922 6.42125 10.4922 4.49243C10.4922 2.56362 8.92858 1 6.99976 1C5.07094 1 3.50732 2.56362 3.50732 4.49243C3.50732 6.42125 5.07094 7.98487 6.99976 7.98487Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M13 14.9697C13 12.2665 10.3108 10.0803 7 10.0803C3.68917 10.0803 1 12.2665 1 14.9697"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </i>
                                    <?php echo ucwords(get_the_author()); ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php } ?>
            </div>
            <?php endwhile; wp_reset_query(); endif; ?>
        </div>

        <?php if($settings['tp_post_pagination'] == 'yes' && '-1' != $settings['posts_per_page']) :?>
        <div class="basic-pagination mt-30 text-center">
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
</section>

<?php elseif ( $settings['tp_design_style']  == 'layout-6' ) : ?>

<div class="blog-list-wrap">

    <?php if ($query->have_posts()) :
		$i = 0.0;
		while ($query->have_posts()) : 
		$query->the_post();
		global $post;
		$categories = get_the_category($post->ID);
		$author_id = get_the_author_meta('ID');
		$author_avatar_url = get_avatar_url($author_id);
		$i+=0.3;
	?>
    <div class="blog-list-item d-flex mb-30 tp-el-section">

        <?php format_post(); ?>

        <div class="blog-list-content">

            <?php if(!empty($categories[0]->name)) : ?>
            <div class="blog-list-tag">
                <a class="tp-el-rep-cat" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo esc_html($categories[0]->name); ?></a>
            </div>
            <?php endif; ?>

            <h4 class="blog-list-title tp-el-rep-title">
                <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a>
            </h4>
            <?php if (!empty($settings['tp_post_content'])):
                $tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
            ?>
            <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?></p>
            <?php endif; ?>
            <div class="tpblog-meta-2 mb-35">
                <span class="tp-el-rep-date">
                    <i>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 8C15 11.864 11.864 15 8 15C4.136 15 1 11.864 1 8C1 4.136 4.136 1 8 1C11.864 1 15 4.136 15 8Z"
                                stroke="#565764" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M10.5967 10.226L8.42672 8.93099C8.04872 8.70699 7.74072 8.16799 7.74072 7.72699V4.85699"
                                stroke="#565764" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </i>
                    <?php the_time( 'M d, Y' ); ?>
                </span>
                <span>
                    <a class="tp-el-rep-ava-name" href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
                        <i>
                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.99976 7.98487C8.92858 7.98487 10.4922 6.42125 10.4922 4.49243C10.4922 2.56362 8.92858 1 6.99976 1C5.07094 1 3.50732 2.56362 3.50732 4.49243C3.50732 6.42125 5.07094 7.98487 6.99976 7.98487Z"
                                    stroke="#565764" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M13 14.9697C13 12.2665 10.3108 10.0803 7 10.0803C3.68917 10.0803 1 12.2665 1 14.9697"
                                    stroke="#565764" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </i>
                        <?php echo ucwords(get_the_author()); ?>
                    </a>
                </span>
            </div>

            <?php if(!empty($settings['tp_post_button'])) : ?>
            <div class="blog-list-btn">
                <a class="tp-el-rep-btn" href="<?php the_permalink(); ?>"><?php echo tp_kses($settings['tp_post_button']); ?></a>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php endwhile; wp_reset_query(); endif; ?>

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

<?php elseif ( $settings['tp_design_style']  == 'layout-7' ) : ?>

<div class="blog-grid-wrapper tp-el-section">
    <div class="row">

        <?php if ($query->have_posts()) :
            $i = 0.0;
            while ($query->have_posts()) : 
            $query->the_post();
            global $post;
            $categories = get_the_category($post->ID);
            $author_id = get_the_author_meta('ID');
            $author_avatar_url = get_avatar_url($author_id);
            $i+=0.3;
        ?>
        <div class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
            <div class="tpblog-item-2 mb-30">
                <?php format_post2();?>
                <div class="tpblog-wrap">
                    <div class="tpblog-content-2">
                        <?php if(!empty($categories[0]->name)) : ?>
                        <span><a class="tp-el-rep-cat" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo esc_html($categories[0]->name); ?></a></span>
                        <?php endif; ?>
                        <h4 class="tpblog-title-2 tp-el-rep-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a></h4>
                        <?php if (!empty($settings['tp_post_content'])):
                            $tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
                        ?>
                        <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="tpblog-meta-2">
                        <span class="tp-el-rep-date">
                            <i>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15 8C15 11.864 11.864 15 8 15C4.136 15 1 11.864 1 8C1 4.136 4.136 1 8 1C11.864 1 15 4.136 15 8Z"
                                        stroke="#565764" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M10.5967 10.226L8.42672 8.93099C8.04872 8.70699 7.74072 8.16799 7.74072 7.72699V4.85699"
                                        stroke="#565764" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </i>
                            <?php the_time( 'M d, Y' ); ?>
                        </span>
                        <span>
                            <a class="tp-el-rep-ava-name" href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
                                <i>
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.99976 7.98487C8.92858 7.98487 10.4922 6.42125 10.4922 4.49243C10.4922 2.56362 8.92858 1 6.99976 1C5.07094 1 3.50732 2.56362 3.50732 4.49243C3.50732 6.42125 5.07094 7.98487 6.99976 7.98487Z"
                                            stroke="#565764" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M13 14.9697C13 12.2665 10.3108 10.0803 7 10.0803C3.68917 10.0803 1 12.2665 1 14.9697"
                                            stroke="#565764" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </i>
                                <?php echo ucwords(get_the_author()); ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; wp_reset_query(); endif; ?>

    </div>
    <?php if($settings['tp_post_pagination'] == 'yes' && '-1' != $settings['posts_per_page']) :?>
    <div class="basic-pagination">
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

<?php else : ?>

    <?php if ($query->have_posts()) :
		$i = 0.0;
		while ($query->have_posts()) : 
		$query->the_post();
		global $post;
		$categories = get_the_category($post->ID);
		$author_id = get_the_author_meta('ID');
		$author_avatar_url = get_avatar_url($author_id);
		$i+=0.3;
	?>
    <div class="col-xl-<?php echo esc_attr($settings['tp_col_for_desktop']); ?> col-lg-<?php echo esc_attr($settings['tp_col_for_laptop']); ?> col-md-<?php echo esc_attr($settings['tp_col_for_tablet']); ?> col-<?php echo esc_attr($settings['tp_col_for_mobile']); ?>">
        <div class="tpblog mb-30 tp-el-section">
            <?php if(!empty(has_post_thumbnail())) : ?>
            <div class="tpblog-thumb mb-25 fix">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            </div>
            <?php endif; ?>

            <div class="tpblog-content">
                <div class="tpblog-tag">
                    <?php if(!empty($categories[0]->name)) : ?>
                    <a class="tp-el-rep-cat" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo esc_html($categories[0]->name); ?></a>
                    <?php endif; ?>
                    <?php if(!empty($categories[1]->name)) : ?>
                    <a class="tp-el-rep-cat" href="<?php echo esc_url(get_category_link($categories[1]->term_id)); ?>"><?php echo esc_html($categories[1]->name); ?></a>
                    <?php endif; ?>
                </div>
                <h3 class="tpblog-title tp-el-rep-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), $settings['tp_blog_title_word'], ''); ?></a>
                </h3>
                <?php if (!empty($settings['tp_post_content'])):
					$tp_post_content_limit = (!empty($settings['tp_post_content_limit'])) ? $settings['tp_post_content_limit'] : '';
						?>
                <p class="tp-el-rep-des"><?php print wp_trim_words(get_the_excerpt(get_the_ID()), $tp_post_content_limit, ''); ?></p>
                <?php endif; ?>
                <?php if(!empty($settings['tp_post_button'])) : ?>
                <a class="tp-header-btn mb-20 tp-el-rep-des" href="<?php the_permalink(); ?>"><?php echo tp_kses($settings['tp_post_button']); ?></a>
                <?php endif; ?>
                <div class="tpblog-avatar d-flex align-items-center">
                    <?php if(!empty($author_avatar_url)) : ?>
                    <div class="tpblog-avatar-thub mr-10 tp-el-rep-avatar">
                        <img src="<?php echo esc_url($author_avatar_url); ?>"
                            alt="<?php echo esc_attr__('Avatar', 'tpcore'); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="tpblog-avatar-info">
                        <h5 class="tpblog-avatar-title tp-el-rep-ava-name"><?php echo ucwords(get_the_author()); ?></h5>
                        <span class="tp-el-rep-date"><?php the_time( 'F d, Y' ); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; wp_reset_query(); endif; ?>

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

<?php endif;  
	}

}

$widgets_manager->register( new TP_Blog_Post() );