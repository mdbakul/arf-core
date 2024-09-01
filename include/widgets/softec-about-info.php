<?php
	/**
	 * Softec Footer full Widget
	 *
	 *
	 * @author 		ThemePure
	 * @category 	Widgets
	 * @package 	Softec/Widgets
	 * @version 	1.0.0
	 * @extends 	WP_Widget
	 */
	add_action('widgets_init', 'Softec_offer_Widget');
	function Softec_offer_Widget() {
		register_widget('Softec_offer_Widget');
	}
	
	
	class Softec_offer_Widget  extends WP_Widget{
		
		public function __construct(){
			parent::__construct('Softec_offer_Widget',esc_html__('Softec :: About (footer)','tpcore'),array(
				'description' => esc_html__('Softec About Widget For Footer','tpcore'),
			));
		}
		
		public function widget($args, $instance){
			extract($args);
			extract($instance);

			print $before_widget; 
			?>

<?php if( !empty($sidebar_offer_img) ): ?>
<?php if(!empty($img_link)) : ?>
<a href="<?php echo esc_url($img_link); ?>" class="tp-footer__widget-logo mb-10">
    <img src="<?php echo esc_url( $sidebar_offer_img ); ?>" alt="<?php echo esc_attr__('Softec Image', 'tpcore');?>">
</a>
<?php else : ?>
<img src="<?php echo esc_url( $sidebar_offer_img ); ?>" alt="<?php echo esc_attr__('Softec Image', 'tpcore');?>">
<?php endif; ?>
<?php endif; ?>
<div class="tp-footer__text">
    <?php if(!empty($short_description)) : ?>
    <p><?php echo esc_html($short_description); ?></p>
    <?php endif; ?>
</div>
<div class="tp-footer__social">
    <?php if(!empty($fb_link)) : ?>
    <a href="<?php echo esc_url($fb_link); ?>"><i class="fab fa-facebook-f"></i></a>
    <?php endif; ?>
    <?php if(!empty($tw_link)) : ?>
    <a href="<?php echo esc_url($tw_link); ?>"><i class="fab fa-twitter"></i></a>
    <?php endif; ?>
    <?php if(!empty($ig_link)) : ?>
    <a href="<?php echo esc_url($ig_link); ?>"><i class="fab fa-instagram"></i></a>
    <?php endif; ?>
    <?php if(!empty($ld_link)) : ?>
    <a href="<?php echo esc_url($ld_link); ?>"><i class="fab fa-linkedin-in"></i></a>
    <?php endif; ?>
    <?php if(!empty($yt_link)) : ?>
    <a href="<?php echo esc_url($yt_link); ?>"><i class="fab fa-youtube"></i></a>
    <?php endif; ?>
</div>
<?php print $after_widget; ?>
<?php 
		}
		

		/**
		 * widget function.
		 *
		 * @see WP_Widget
		 * @access public
		 * @param array $instance
		 * @return void
		 */
		public function form($instance){

			//Image
            if ( isset( $instance[ 'sidebar_offer_img' ] ) ) {
                $sidebar_offer_img = $instance[ 'sidebar_offer_img' ];
            }else {
                $sidebar_offer_img = '';
            }

			$short_description = isset($instance['short_description'])? $instance['short_description']:'';
			$img_link = isset($instance['img_link'])? $instance['img_link']:'';
			$fb_link = isset($instance['fb_link'])? $instance['fb_link']:'';
			$tw_link = isset($instance['tw_link'])? $instance['tw_link']:'';
			$ig_link = isset($instance['ig_link'])? $instance['ig_link']:'';
			$ld_link = isset($instance['ld_link'])? $instance['ld_link']:'';
			$yt_link = isset($instance['yt_link'])? $instance['yt_link']:'';

			?>

<p>
    <input value="<?php echo esc_attr( $sidebar_offer_img ); ?>"
        name="<?php echo $this->get_field_name( 'sidebar_offer_img' ); ?>" type="hidden" class="widefat img_val"
        type="text" />
    <img class="img_show" src="<?php echo esc_url( $sidebar_offer_img ); ?>" alt="">
</p>

<p>
    <button
        class="button about-up-btn"><?php ( empty( $sidebar_offer_img ) ) ?  esc_html_e( "Upload Image", "mechon" ) : esc_html_e( "Change Image", "mechon" ); ?></button>
</p>

<!-- img url -->
<p><label for="img_url"><?php esc_html_e('Image Link', 'tpcore'); ?></label></p>
<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('img_link')); ?>"
    name="<?php echo esc_attr($this->get_field_name('img_link')); ?>" value="<?php echo esc_attr($img_link); ?>">

<!-- short description -->
<p><label for="short_description"><?php esc_html_e('Short Description:','tpcore'); ?></p>
<textarea class="widefat" cols="15" rows="3" id="<?php echo esc_attr($this->get_field_id('short_description')); ?>"
    name="<?php echo esc_attr($this->get_field_name('short_description')); ?>"><?php print esc_attr($short_description); ?></textarea>

<h3><?php esc_html_e('Social Links :', 'tpcore'); ?></h3>
<hr>

<!-- facebook -->
<p><label for="fb_link"><?php esc_html_e('Facebook Link', 'tpcore'); ?></label></p>
<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('fb_link')); ?>"
    name="<?php echo esc_attr($this->get_field_name('fb_link')); ?>" value="<?php echo esc_attr($fb_link); ?>">
<!-- twitter -->
<p><label for="tw_link"><?php esc_html_e('Twitter Link', 'tpcore'); ?></label></p>
<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('tw_link')); ?>"
    name="<?php echo esc_attr($this->get_field_name('tw_link')); ?>" value="<?php echo esc_attr($tw_link); ?>">
<!-- instagram -->
<p><label for="ig_link"><?php esc_html_e('Instagram Link', 'tpcore'); ?></label></p>
<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('ig_link')); ?>"
    name="<?php echo esc_attr($this->get_field_name('ig_link')); ?>" value="<?php echo esc_attr($ig_link); ?>">
<!-- linkedin -->
<p><label for="ld_link"><?php esc_html_e('Linkedin Link', 'tpcore'); ?></label></p>
<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('ld_link')); ?>"
    name="<?php echo esc_attr($this->get_field_name('ld_link')); ?>" value="<?php echo esc_attr($ld_link); ?>">
<!-- youtube -->
<p><label for="yt_link"><?php esc_html_e('Youtube Link', 'tpcore'); ?></label></p>
<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('yt_link')); ?>"
    name="<?php echo esc_attr($this->get_field_name('yt_link')); ?>" value="<?php echo esc_attr($yt_link); ?>"
    style="margin-bottom: 10px;">

<script>
    jQuery(function ($) {
        'use strict';
        /**
         *
         * About Widget About Us upload
         *
         */
        $(function () {
            $(".img_show").css({
                "margin": "0 auto",
                "display": "block",
                "max-width": "80%"
            });
            $(document).on('widget-updated', function (event, widget) {
                var widget_id = $(widget).attr('id');
                if (widget_id.indexOf('mechon_aboutus_widget') != -1) {
                    $imgval = $(".img_val").val();
                    $(".img_show").attr("src", $imgval);
                    $(".img_show").css({
                        "margin": "0 auto",
                        "display": "block",
                        "max-width": "80%"
                    });
                }
            });
            $("body").off("click", ".about-up-btn");
            $("body").on("click", ".about-up-btn", function (e) {

                let frame = wp.media({
                    title: 'Select or Upload Media About Us',
                    button: {
                        text: 'Use this About Us'
                    },
                    multiple: false
                });

                frame.on("select", function () {
                    // Get media attachment details from the frame state
                    let $img = frame.state().get('selection').first().toJSON();

                    $(".img_show").attr("src", $img.url);
                    $(".img_val").val($img.url);

                    $(".img_val").trigger('change');

                    $(".about-up-btn").text("Change Image");
                });

                // Open Media Modal
                frame.open();
                e.preventDefault();
            });
        });
    });
</script>

<?php
		}
				
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['sidebar_offer_img'] = ( ! empty( $new_instance['sidebar_offer_img'] ) ) ? strip_tags( $new_instance['sidebar_offer_img'] ) : '';
			$instance['short_description'] = ( ! empty( $new_instance['short_description'] ) ) ? strip_tags( $new_instance['short_description'] ) : '';
			$instance['img_link'] = ( ! empty( $new_instance['img_link'] ) ) ? strip_tags( $new_instance['img_link'] ) : '';
			$instance['fb_link'] = ( ! empty( $new_instance['fb_link'] ) ) ? strip_tags( $new_instance['fb_link'] ) : '';
			$instance['tw_link'] = ( ! empty( $new_instance['tw_link'] ) ) ? strip_tags( $new_instance['tw_link'] ) : '';
			$instance['ig_link'] = ( ! empty( $new_instance['ig_link'] ) ) ? strip_tags( $new_instance['ig_link'] ) : '';
			$instance['ld_link'] = ( ! empty( $new_instance['ld_link'] ) ) ? strip_tags( $new_instance['ld_link'] ) : '';
			$instance['yt_link'] = ( ! empty( $new_instance['yt_link'] ) ) ? strip_tags( $new_instance['yt_link'] ) : '';
			return $instance;
		}
	}