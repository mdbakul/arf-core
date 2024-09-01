<?php get_header();
    global $post;
    use \Etn\Utils\Helper;
    $single_event_id = get_the_id();
    $categories = get_the_terms($single_event_id, 'etn_category');
    $etn_terms = get_the_terms($single_event_id, 'etn_tags');
    $event_options  = get_option("etn_event_options");
    $data = Helper::single_template_options( $single_event_id );
    $start_date         = get_post_meta( $single_event_id, 'etn_start_date', true );
    $start_date_year_month = date("F d, Y", strtotime($start_date));


       // contact button


?>

    <!-- event details area start -->
    <section class="event__details-area event__area pt-120 pb-65">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="event__details-wrapper">
                    <div class="event__details-content mb-50">
                        <?php if(isset($categories[0]->name) && !empty($categories[0]->name)) : ?>
                        <div class="event__details-tag mb-10">
                            <span><?php echo esc_html__($categories[0]->name);?></span>
                        </div>
                            <?php endif; ?>
                        <h3 class="event__details-title"><?php the_title(); ?></h3>

                        <div class="event__meta-wrapper event__details-meta mb-55 d-sm-flex flex-wrap align-items-center">
                            <div class="event__meta-item">
                            <?php if(!isset($event_options["etn_hide_date_from_details"]) && !empty($data['event_start_date'])): ?>
                                <span> 
                                    <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.5 1V3.1" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.1 1V3.1" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.35001 5.96295H13.25" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.6 5.54999V11.5C13.6 13.6 12.55 15 10.1 15H4.5C2.05 15 1 13.6 1 11.5V5.54999C1 3.44999 2.05 2.04999 4.5 2.04999H10.1C12.55 2.04999 13.6 3.44999 13.6 5.54999Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.88629 9.18997H9.89257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.88629 11.2899H9.89257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.29684 9.18997H7.30313" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.29684 11.2899H7.30313" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.70602 9.18997H4.71231" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.70602 11.2899H4.71231" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>                                                                             
                                    <?php echo $data['event_start_date']; ?>
                                </span>
                                <?php endif; ?>

                                <?php 
                                    if ( !isset($event_options["etn_hide_time_from_details"]) && ( !empty( $data['event_start_time'] ) || !empty( $data['event_end_time'] ) )) :
                                        $separate = !empty($data['event_end_time']) ? ' - ' : '';
                                ?>
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 8C15 11.864 11.864 15 8 15C4.136 15 1 11.864 1 8C1 4.136 4.136 1 8 1C11.864 1 15 4.136 15 8Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.5826 10.2259L8.41256 8.93093C8.03456 8.70693 7.72656 8.16793 7.72656 7.72693V4.85693" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>                                            
                                    <?php echo esc_html($data['event_start_time'] . $separate . $data['event_end_time']); ?>
                                </span>
                                <?php endif; ?>

                                <?php if(!empty($data['etn_event_location'])) : ?>
                                <span>
                                    <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.09464 10.0239H4.56643V15.7834C4.56643 17.1273 5.29436 17.3993 6.18229 16.3914L12.2378 9.51196C12.9817 8.67203 12.6697 7.97609 11.5418 7.97609H9.07003V2.21659C9.07003 0.87271 8.3421 0.600734 7.45417 1.60865L1.3987 8.48804C0.662767 9.33597 0.97474 10.0239 2.09464 10.0239Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>                                                                                                                          
                                    <?php echo esc_html($data['etn_event_location']); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if(has_post_thumbnail()) : ?>
                        <div class="event__details-thumb m-img mb-60">
                        <?php the_post_thumbnail(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="event__details-inner">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="event__details-left pr-35">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            <div class="col-lg-4">



                            <?php do_action("etn_before_single_event_meta", $single_event_id); ?>

                            
                            <!-- event schedule meta end -->
                            <?php do_action("etn_single_event_meta", $single_event_id); ?>
                            <!-- event schedule meta end -->
                           

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- event details area end -->


<?php get_footer();