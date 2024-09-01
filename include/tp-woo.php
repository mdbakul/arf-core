<?php

namespace TPCore;

defined('ABSPATH') || die();

class TP_El_Woocommerce
{

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var BdevsElement The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @return BdevsElement An instance of the class.
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     */
    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    public static function tp_woo_add_to_cart( $args = array() ) {
        global $product;

            if ( $product ) {
                $defaults = array(
                    'quantity'   => 1,
                    'class'      => implode(
                        ' ',
                        array_filter(
                            array(
                                'cart-button icon-btn button',
                                'product_type_' . $product->get_type(),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                            )
                        )
                    ),
                    'attributes' => array(
                        'data-product_id'  => $product->get_id(),
                        'data-product_sku' => $product->get_sku(),
                        'aria-label'       => $product->add_to_cart_description(),
                        'rel'              => 'nofollow',
                    ),
                );

                $args = wp_parse_args( $args, $defaults );

                if ( isset( $args['attributes']['aria-label'] ) ) {
                    $args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
                }
            }


             // check product type 
             if( $product->is_type( 'simple' ) ){
                $btntext = esc_html__("Add to Cart",'harry');
             } elseif( $product->is_type( 'variable' ) ){
                $btntext = esc_html__("Select Options",'harry');
             } elseif( $product->is_type( 'external' ) ){
                $btntext = esc_html__("Buy Now",'harry');
             } elseif( $product->is_type( 'grouped' ) ){
                $btntext = esc_html__("View Products",'harry');
             }
             else{
                $btntext = "Add to Cart";
             } 

            echo sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                esc_attr( isset( $args['class'] ) ? $args['class'] : 'cart-button icon-btn button' ),
                isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.54431 4.80484L4.08701 11.2487C4.12661 11.7447 4.53251 12.1167 5.02841 12.1167H5.03201H14.8519H14.8537C15.3227 12.1167 15.7232 11.7681 15.7898 11.3053L16.6448 5.41221C16.6646 5.27205 16.6295 5.13189 16.544 5.01868C16.4594 4.90457 16.3352 4.8309 16.1948 4.81113C16.0067 4.81832 8.20092 4.80754 3.54431 4.80484ZM5.02647 13.4642C3.84117 13.4642 2.83766 12.5405 2.74136 11.359L1.91696 1.57098L0.560653 1.33738C0.192551 1.27269 -0.0531497 0.924974 0.00985058 0.557495C0.0746508 0.190017 0.430152 -0.0489788 0.790154 0.00852392L2.66216 0.331977C2.96366 0.384987 3.19316 0.634765 3.21926 0.940248L3.43076 3.45689C16.2792 3.46228 16.3206 3.46857 16.3827 3.47576C16.884 3.54854 17.325 3.80999 17.6256 4.21251C17.9262 4.61413 18.0522 5.1092 17.9802 5.60516L17.1261 11.4974C16.965 12.6187 15.9894 13.4642 14.8554 13.4642H14.8509H5.03367H5.02647Z" fill="currentColor"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4079 8.12567H10.9131C10.5396 8.12567 10.2381 7.82379 10.2381 7.45181C10.2381 7.07984 10.5396 6.77795 10.9131 6.77795H13.4079C13.7805 6.77795 14.0829 7.07984 14.0829 7.45181C14.0829 7.82379 13.7805 8.12567 13.4079 8.12567Z" fill="currentColor"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63943 15.9048C4.91033 15.9048 5.12903 16.1235 5.12903 16.3944C5.12903 16.6653 4.91033 16.8849 4.63943 16.8849C4.36763 16.8849 4.14893 16.6653 4.14893 16.3944C4.14893 16.1235 4.36763 15.9048 4.63943 15.9048Z" fill="currentColor"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63859 16.2097C4.53689 16.2097 4.45409 16.2925 4.45409 16.3942C4.45409 16.5985 4.82399 16.5985 4.82399 16.3942C4.82399 16.2925 4.74029 16.2097 4.63859 16.2097ZM4.6386 17.5569C3.996 17.5569 3.474 17.0349 3.474 16.3933C3.474 15.7518 3.996 15.2307 4.6386 15.2307C5.28121 15.2307 5.80411 15.7518 5.80411 16.3933C5.80411 17.0349 5.28121 17.5569 4.6386 17.5569Z" fill="currentColor"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7918 15.9048C15.0627 15.9048 15.2823 16.1235 15.2823 16.3944C15.2823 16.6653 15.0627 16.8849 14.7918 16.8849C14.52 16.8849 14.3013 16.6653 14.3013 16.3944C14.3013 16.1235 14.52 15.9048 14.7918 15.9048Z" fill="currentColor"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7906 16.2098C14.6898 16.2098 14.607 16.2926 14.607 16.3943C14.6079 16.6004 14.9769 16.5986 14.976 16.3943C14.976 16.2926 14.8923 16.2098 14.7906 16.2098ZM14.7909 17.5569C14.1483 17.5569 13.6263 17.0349 13.6263 16.3933C13.6263 15.7518 14.1483 15.2307 14.7909 15.2307C15.4344 15.2307 15.9573 15.7518 15.9573 16.3933C15.9573 17.0349 15.4344 17.5569 14.7909 17.5569Z" fill="currentColor"/>
                </svg>'.$btntext.' '
            );
    }

    // quick view
    public static function gharry_woosq_button_html( $output , $prodid ) {
        return $output = '<a href="#" class="icon-btn woosq-btn woosq-btn-' . esc_attr( $prodid ) . ' ' . get_option( 'woosq_button_class' ) . '" data-id="' . esc_attr( $prodid ) . '" data-effect="mfp-3d-unfold"><svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
       <path d="M9.49943 5.34978C8.23592 5.34978 7.20896 6.37595 7.20896 7.63732C7.20896 8.89774 8.23592 9.92296 9.49943 9.92296C10.7629 9.92296 11.7908 8.89774 11.7908 7.63732C11.7908 6.37595 10.7629 5.34978 9.49943 5.34978M9.49941 11.3456C7.45025 11.3456 5.78394 9.68213 5.78394 7.63738C5.78394 5.59169 7.45025 3.92725 9.49941 3.92725C11.5486 3.92725 13.2158 5.59169 13.2158 7.63738C13.2158 9.68213 11.5486 11.3456 9.49941 11.3456" fill="currentColor"/>
       
       <path d="M1.49145 7.63683C3.25846 11.5338 6.23484 13.8507 9.50001 13.8517C12.7652 13.8507 15.7416 11.5338 17.5086 7.63683C15.7416 3.7408 12.7652 1.42386 9.50001 1.42291C6.23579 1.42386 3.25846 3.7408 1.49145 7.63683V7.63683ZM9.50173 15.2742H9.49793H9.49698C5.56775 15.2714 2.03943 12.5219 0.0577129 7.91746C-0.0192376 7.73822 -0.0192376 7.53526 0.0577129 7.35601C2.03943 2.75248 5.5687 0.00306822 9.49698 0.000223018C9.49888 -0.000725381 9.49888 -0.000725381 9.49983 0.000223018C9.50173 -0.000725381 9.50173 -0.000725381 9.50268 0.000223018C13.4319 0.00306822 16.9602 2.75248 18.942 7.35601C19.0199 7.53526 19.0199 7.73822 18.942 7.91746C16.9612 12.5219 13.4319 15.2714 9.50268 15.2742H9.50173Z" fill="currentColor"/>

       </svg></a>';
    }




    public static function add_to_cart_button($product_id)
    {

        $product = wc_get_product($product_id);
        if ($product) {
            $defaults = array(
                'quantity' => 1,
                'class' => implode(' ', array_filter(array(
                    '',
                    'product_type_' . $product->get_type(),
                    $product->is_purchasable() && $product->is_in_stock() ? '' : '',
                    $product->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : ''
                )))
            );

            extract($defaults);

            return sprintf('<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s add_to_cart_button tp-btn"><i class="fal fa-shopping-cart"></i> Add To Cart</a>',
                esc_url($product->add_to_cart_url()),
                esc_attr(isset($quantity) ? $quantity : 1),
                esc_attr($product->get_id()),
                esc_attr($product->get_sku()),
                esc_attr(isset($class) ? $class : 'button')
            );
        }
    }

    public static function quick_view_button($product_id) {

        $product = wc_get_product($product_id);

        $button = '';
        if ( $product_id ) {
      
            $button = '<a href="#" class="button yith-wcqv-button" data-product_id="' . esc_attr( $product_id ) . '" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="fal fa-eye"></i></a>';
            $button = apply_filters( 'yith_add_quick_view_button_html', $button, '', $product );
        }

        return $button;
            
    }

    public static function yith_wishlist($product_id)
    {

        $product = wc_get_product($product_id);

        $cssclass = 'wishlist-rd';
        $mar = 'tanzim-mar-top';

        $id = $product->get_id();
        $type = $product->get_type();
        $link = get_site_url();

        $img = '<img src="' . $link . '/wp-content/plugins/yith-woocommerce-wishlist/assets/images/wpspin_light.gif" class="ajax-loading tanzim_wi_loder" alt="loading" width="16" height="16" style="visibility:hidden">';
        $markup = '';

        if (BDEVSEL_WISHLIST_ACTIVED) {

            $markup .= '<div class="yith-wcwl-add-to-wishlist ' . $mar . ' add-to-wishlist-' . $id . '">';
            $markup .= '<div class="yith-wcwl-add-button wishlist show" style="display:block">';
            $markup .= '<a href="' . $link . '/shop/?add_to_wishlist=' . $id . '" rel="nofollow" data-product-id="' . $id . '" data-product-type="' . $type . '" class="add_to_wishlist ' . $cssclass . '">';
            $markup .= '<i class="fal fa-heart"></i></a>';
            $markup .= $img;
            $markup .= '</div>';
            $markup .= '<div class="yith-wcwl-wishlistaddedbrowse wishlist hide" style="display:none;">';
            $markup .= '<a href="' . $link . '/wishlist/view/" rel="nofollow" class=" ' . $cssclass . '"><i class="fal fa-heart"></i></a>';
            $markup .= $img;
            $markup .= '</div>';
            $markup .= '<div class="yith-wcwl-wishlistexistsbrowse wishlist  hide" style="display:none">';
            $markup .= '<a href="' . $link . '/wishlist/view/" rel="nofollow" class=" ' . $cssclass . '"><i class="fal fa-heart"></i></a>';
            $markup .= $img;
            $markup .= '</div>';
            $markup .= '<div style="clear:both"></div>';
            $markup .= '<div class="yith-wcwl-wishlistaddresponse"></div>';
            $markup .= '</div>';
        }

        return $markup;
    }

    // product_price
    public static function product_price($product_id, $oldp = false)
    {

        $product = wc_get_product($product_id);

        return $product->get_price_html();

    }


    // product_price_sale
    public static function product_price_sale($product_id, $oldp = false)
    {

        $product = wc_get_product($product_id);
        $woo_sale_tag = get_theme_mod('woo_sale_tag', 'Sale');

        $price = $product->get_regular_price();
        $old = '';

        if ($product->get_sale_price() != '') {
            if ($oldp) {
                return '<span class="sale-text">' . $woo_sale_tag . '</span> ';
            }
            else{
                '';
            }
        }
        return false;
    }

    // bdevs_vc_product_thumb
    public static function bdevs_vc_product_thumb($size = array(370, 425))
    {

        $markup = '';
        global $post, $product, $woocommerce;

        $attachment_ids = $product->get_gallery_image_ids();
        $fea_image = array(get_post_thumbnail_id());
        $attachment_ids = array_merge($fea_image, $attachment_ids);
        $i = 1;

        if (!empty($attachment_ids)) {

            $markup .= '<a href="' . get_the_permalink() . '">';
            foreach ($attachment_ids as $attachment_id) {
                if ($i == 3) {
                    break;
                }
                $class = ($i == 1) ? 'front-img' : 'back-img';
                $image_attributes = wp_get_attachment_image_src($attachment_id, $size);
                if ($image_attributes[0] != '') {
                    $markup .= '<img class="' . $class . '" src="' . $image_attributes[0] . '" alt="' . esc_html__('image', 'bdevs-woocommerce') . '" >';
                }
                $i++;
            }
            $markup .= '</a>';
        }

        return $markup;
    }

    public static function bdevs_vc_loop_product_thumb()
    {

        $markup = '';
        global $post, $product, $woocommerce;
        $attachment_ids = $product->get_gallery_image_ids();
        $fea_image = array(get_post_thumbnail_id());
        $attachment_ids = array_merge($fea_image, $attachment_ids);
        $i = 1;
        if (!empty($attachment_ids)) {
            $markup .= '<a href="' . get_the_permalink() . '">';
            foreach ($attachment_ids as $attachment_id) {
                if ($i == 3) {
                    break;
                }
                $class = ($i == 1) ? 'front-img' : 'back-img';
                $image_attributes = wp_get_attachment_image_src($attachment_id, array(300, 300));
                if ($image_attributes[0] != '') {
                    $markup .= '<img class="' . $class . '" src="' . $image_attributes[0] . '" alt="' . esc_html__('image', 'bdevs-woocommerce') . '" >';
                }
                $i++;
            }
            $markup .= '</a>';
        }

        return $markup;
    }


    public static function product_rating($product_id)
    {

        $product = wc_get_product($product_id);
        $rating = $product->get_average_rating();
        $review = 'Rating ' . $rating . ' out of 5';
        $html   = '';
        $html   .= '<div class="details-rating mb-10" title="' . $review . '">';
        for ( $i = 0; $i <= 4; $i ++ ) {
            if ( $i < floor( $rating ) ) {
                $html .= '<i class="fas fa-star"></i>';
            } else {
                $html .= '<i class="far fa-star"></i>';
            }
        }

        $html .= '</div>';

        return $html;
    }

function sectox_woo_rating() {
    global $product;
    $rating = $product->get_average_rating();
    $review = 'Rating ' . $rating . ' out of 5';
    $html   = '';
    $html   .= '<div class="details-rating mb-10" title="' . $review . '">';
    for ( $i = 0; $i <= 4; $i ++ ) {
        if ( $i < floor( $rating ) ) {
            $html .= '<i class="fas fa-star"></i>';
        } else {
            $html .= '<i class="far fa-star"></i>';
        }
    }
    $html .= '<span>( ' . $rating . ' out of 5 )</span>';
    $html .= '</div>';
    print sectox_woo_rating_html( $html );
}

function sectox_woo_rating_html( $html ) {
    return $html;
}



    /**
     * taxonomy category
     */
    public static function product_get_terms($id, $tax)
    {

        $terms = get_the_terms(get_the_ID(), $tax);

        $list = '';
        if ($terms && !is_wp_error($terms)) :
            $i = 1;
            $cats_count = count($terms);

            foreach ($terms as $term) {
                $exatra = ($cats_count > $i) ? ', ' : '';
                $list .= $term->name . $exatra;
                $i++;
            }
        endif;

        return trim($list, ',');
    }

}

TP_El_Woocommerce::instance();