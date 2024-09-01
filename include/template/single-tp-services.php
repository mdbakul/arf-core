<?php
/**
 * The main template file
 *
 * @package  WordPress
 * @subpackage  tpcore
 */
get_header();

$post_column = is_active_sidebar( 'services-sidebar' ) ? '8' : '10';
$post_column_center = is_active_sidebar( 'services-sidebar' ) ? '' : 'justify-content-center';

?>

   <section class="services-details-area pt-120 pb-80">
      <div class="container">
         <div class="row <?php echo esc_attr($post_column_center); ?>">
            <div class="col-lg-<?php echo esc_attr($post_column); ?>">
               <div class="services-details-wrapper pr-20">
                  <?php if ( has_post_thumbnail() ): ?>
                  <div class="services-details-thumb m-img mb-35">
                     <?php the_post_thumbnail( 'full', ['class' => 'img-responsive'] );?>
                  </div>
                  <?php endif; ?>
                  <?php the_content(); ?>
               </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4">
               <div class="services-details-wrapper">
                  <?php dynamic_sidebar( 'services-sidebar' ); ?>
               </div>
            </div>
         </div>
      </div>
   </section>

<?php get_footer();  ?>
