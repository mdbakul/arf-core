<?php
/**
 * The main template file
 *
 * @package  WordPress
 * @subpackage  tpcore
 */
get_header();

$rep_values = function_exists('tpmeta_field') ? tpmeta_field('seomy_port_repeater') : '';
$image = function_exists('tpmeta_image_field') ? tpmeta_image_field('seomy_pro_img') : NULL;

$port_breadcrumb_shape = get_theme_mod('port_breadcrumb_shape', false);
$port_related_post = get_theme_mod('port_related_post', false);
$port_related_post_title = get_theme_mod('port_related_post_title', __('Related Portfolio Posts', 'seomy'));

?>

<div class="breadcrumb-services-area services-details-bg scene breadcrumb-bg p-relative">
    <?php if(!empty($port_breadcrumb_shape )) : ?>
    <div class="about-inner-shape">
        <div class="about-inner-shape-2 d-none d-md-block">
            <img class="layer" data-depth="0.5"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/about-inner-shape-1.png" alt="">
        </div>
        <div class="about-inner-shape-3 d-none d-md-block">
            <img class="layer" data-depth="0.5"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/about-inner-shape-2.png" alt="">
        </div>
    </div>
    <div class="tpbanner-shape-y scene-y">
        <div class="about-inner-shape-4 d-none d-lg-block">
            <img class="layer" data-depth="0.6"
                src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/inner-hand-1.png" alt="">
        </div>
    </div>
    <?php endif; ?>
</div>

<section class="portfolio-area-start ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="portfolio-details ">
                    <div class="portfolio-details-top text-center">
                        <h4 class="portfolio-details-title mb-50"><?php the_title(); ?></h4>
                    </div>
                    <ul class="portfolio-details-info text-center pl-170 pr-170">

                        <?php foreach($rep_values as $key => $value) : ?>
                        <li>
                            <div class="portfolio-details-info-item">
                                <?php if(!empty($value['seomy_pro_subtitle'])) : ?>
                                <span><?php echo seomy_kses($value['seomy_pro_subtitle']); ?></span>
                                <?php endif; ?>
                                <?php if(!empty($value['seomy_pro_title'])) : ?>
                                <p><?php echo seomy_kses($value['seomy_pro_title']); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                        <?php endforeach; ?>

                    </ul>

                    <?php if(!empty($image['url'])) : ?>
                    <div class="portfolio-details-thumb">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </div>
                    <?php else : ?>
                    <div class="portfolio-details-thumb">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- project-details-area start -->
<div class="tp-project-details-area pt-50 pb-90">
   <div class="container">
      <?php
            
      if( have_posts() ):
      while( have_posts() ): the_post(); ?>

      <?php the_content(); ?>

      <?php
         endwhile; wp_reset_query();
         endif;
         
         if ( get_previous_post_link() AND get_next_post_link() ) : 
         $prev_post = get_previous_post();
         $next_post = get_next_post();
      ?>
      <div class="portfolio-details-more d-flex align-items-center justify-content-between mt-65">
         <?php if ( get_previous_post_link() ): ?>
         <a href="<?php echo get_the_permalink($prev_post); ?>"
               class="portfolio-details-prev d-flex align-items-center">
               <div class="portfolio-details-prev-icon d-none d-md-block">
                  <span>
                     <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M7 13L1 7L7 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round" />
                     </svg>
                  </span>
               </div>
               <div class="portfolio-details-prev-content">
                  <span><?php print esc_html__( 'Prev', 'seomy' );?></span>
                  <p><?php echo get_the_title($prev_post); ?></p>
               </div>
         </a>
         <?php endif; ?>
         <a class="" href="<?php echo get_the_permalink(); ?>">
               <span>
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path
                           d="M21 7.52V2.98C21 1.57 20.36 1 18.77 1H14.73C13.14 1 12.5 1.57 12.5 2.98V7.51C12.5 8.93 13.14 9.49 14.73 9.49H18.77C20.36 9.5 21 8.93 21 7.52Z"
                           stroke="#0E1331" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                     <path opacity="0.4"
                           d="M21 18.77V14.73C21 13.14 20.36 12.5 18.77 12.5H14.73C13.14 12.5 12.5 13.14 12.5 14.73V18.77C12.5 20.36 13.14 21 14.73 21H18.77C20.36 21 21 20.36 21 18.77Z"
                           stroke="#0E1331" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                     <path opacity="0.4"
                           d="M9.5 7.52V2.98C9.5 1.57 8.86 1 7.27 1H3.23C1.64 1 1 1.57 1 2.98V7.51C1 8.93 1.64 9.49 3.23 9.49H7.27C8.86 9.5 9.5 8.93 9.5 7.52Z"
                           stroke="#0E1331" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                     <path
                           d="M9.5 18.77V14.73C9.5 13.14 8.86 12.5 7.27 12.5H3.23C1.64 12.5 1 13.14 1 14.73V18.77C1 20.36 1.64 21 3.23 21H7.27C8.86 21 9.5 20.36 9.5 18.77Z"
                           stroke="#0E1331" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
               </span>
         </a>
         <?php if ( get_next_post_link() ): ?>
         <a href="<?php echo get_the_permalink($next_post); ?>"
               class="portfolio-details-next d-flex align-items-center justify-content-md-end">
               <div class="portfolio-details-next-content text-md-end">
                  <span><?php print esc_html__( 'Next', 'seomy' );?></span>
                  <p><?php echo get_the_title($next_post); ?></p>
               </div>
               <div class="portfolio-details-next-icon d-none d-md-block">
                  <span>
                     <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M1 13L7 7L1 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round" />
                     </svg>
                  </span>
               </div>
         </a>
         <?php endif; ?>
      </div>
      <?php endif; ?>

      <?php if(!empty($port_related_post)) : ?>
      <div class="row mt-95">
         <div class="col-lg-12">
               <div class="portfolio-details-related">
                  <h4 class="portfolio-details-related-title"><?php echo $port_related_post_title ? seomy_kses($port_related_post_title) : NULL; ?></h4>
               </div>
         </div>
      </div>
      <?php
         global $post;
         $current_post_id = $post->ID;
         $post_type = 'tp-portfolios';
         $cat_texonomy = 'portfolios-cat';

         $related_portfolios = new RelatedPosts($current_post_id, $post_type, $cat_texonomy);
         $related_posts = $related_portfolios->get_related_posts();

         if (!empty($related_posts)) {
            echo '<div class="row">';
            foreach ($related_posts as $post) {
               setup_postdata($post);
               ?>
      <div class="col-lg-4 col-md-6">
         <div class="portfolio-inner-item-2 mb-40">
               <?php if(has_post_thumbnail()) : ?>
               <div class="portfolio-inner-thumb-2">
                  <?php the_post_thumbnail(); ?>
               </div>
               <?php endif; ?>
               <div class="portfolio-inner-content-2">
                  <div class="portfolio-inner-title-2"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></a>
                  </div>
                  <p><?php echo wp_trim_words(get_the_excerpt(), 14, '...'); ?></p>
                  <div class="portfolio-inner-tag-2">
                     <?php
                        
                        $categories = get_the_terms( $post->ID, 'portfolios-cat' );
                        foreach ($categories as $category) {
                           echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a> ';
                        }
                     ?>
                  </div>
               </div>
         </div>
      </div>
      <?php
            }
            echo '</div>';
            wp_reset_postdata(); // Reset the query
         } else {
            echo 'No related posts found.';
         }
      ?>
      <?php endif; ?>

   </div>
</div>
<!-- project-details-area end -->

<?php get_footer();  ?>