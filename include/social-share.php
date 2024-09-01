<?php


// product single social share
function youlink_product_social_share(){

    
    $post_url = get_the_permalink();
    ?>    
    <div class="product__details-share">
        <span><?php echo esc_html__('Share:', 'ninico'); ?></span>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($post_url);?>" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url($post_url);?>" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($post_url);?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="https://twitter.com/share?url=<?php echo esc_url($post_url);?>" target="_blank"><i class="fa-brands fa-twitter"></i></a>
    </div>

    <?php

}



