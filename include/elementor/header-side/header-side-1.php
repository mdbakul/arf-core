<?php
    namespace TPCore\Widgets;
?>

<div class="offcanvas__area">
   <div class="offcanvas__wrapper">
      <div class="offcanvas__close">
         <button class="offcanvas__close-btn offcanvas-close-btn">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
               <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
            </svg>
         </button>
      </div>
      <div class="offcanvas__content">
         <div class="offcanvas__top mb-50 d-flex justify-content-between align-items-center">
               <?php if(!empty($tp_side_logo)) : ?>
               <div class="offcanvas__logo logo">
                  <a class="tp-el-off-logo" href="<?php print esc_url( home_url( '/' ) );?>">
                     <img src="<?php echo esc_url($tp_side_logo); ?>" alt="<?php echo esc_attr($tp_side_logo_alt); ?>">
                  </a>
               </div>
               <?php endif; ?>
         </div>
         
         <div class="tp-main-menu-mobile mb-35"></div>

         <?php if(!empty($settings['tp_ofcBtn_text'])) : ?>
         <div class="offcanvas__btn">
            <a <?php echo $this->get_render_attribute_string( 'tp-button-arg3' ); ?>><?php echo tp_kses($settings['tp_ofcBtn_text']);?></a>
         </div>
         <?php endif; ?>
         <div class="offcanvas__contact mb-40">
               <?php if(!empty($settings['tp_ofc_phone'])) : ?>
            <p class="offcanvas__contact-call"><a class="tp-el-off-num" href="tel:<?php echo esc_attr($settings['tp_ofc_phone']); ?>"><?php echo tp_kses($settings['tp_ofc_phone']); ?></a></p>
            <?php endif; ?>
               <?php if(!empty($settings['tp_ofc_email'])) : ?>
            <p class="offcanvas__contact-mail"><a class="tp-el-off-mail" href="mailto:<?php echo esc_attr($settings['tp_ofc_email']); ?>"><?php echo tp_kses($settings['tp_ofc_email']); ?></a></p>
            <?php endif; ?>
         </div>
         <div class="offcanvas__social">
            <?php foreach($settings['tp_ofc_social_list'] as $item) : if(!empty($item['tp_ofc_social_link'])) : ?>
            <a class="tp-el-off-social" href="<?php echo esc_url($item['tp_ofc_social_link']); ?>">
               <?php if($item['tp_box_icon_type'] == 'icon') : ?>
                  <?php if (!empty($item['tp_box_icon']) || !empty($item['tp_box_selected_icon']['value'])) : ?>
                  <?php tp_render_icon($item, 'tp_box_icon', 'tp_box_selected_icon'); ?>
                  <?php endif; ?>
               <?php elseif( $item['tp_box_icon_type'] == 'image' ) : ?>
                  <?php if (!empty($item['tp_box_icon_image']['url'])): ?>
                  <img src="<?php echo $item['tp_box_icon_image']['url']; ?>" alt="<?php echo get_post_meta(attachment_url_to_postid($item['tp_box_icon_image']['url']), '_wp_attachment_image_alt', true); ?>">
                  <?php endif; ?>
               <?php else : ?>
                  <?php if (!empty($item['tp_box_icon_svg'])): ?>
                  <?php echo $item['tp_box_icon_svg']; ?>
                  <?php endif; ?>
               <?php endif; ?>
            </a>
            <?php endif; endforeach; ?>
         </div>
      </div>
   </div>
</div>
<div class="body-overlay"></div>