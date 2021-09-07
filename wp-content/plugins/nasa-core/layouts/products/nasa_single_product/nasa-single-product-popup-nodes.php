<?php
$content = '';

/**
 * Size Guide Block
 */
if ($size_guide) {
    $content .= '<li class="nasa-popup-node-item nasa-size-guide first">';
    
    /**
     * Dom click
     */
    $content .= '<a class="nasa-node-popup" href="javascript:void(0);" data-target="#nasa-content-size-guide" title="' . esc_attr__('Size Guide', 'nasa-core') . '" rel="nofollow"><i class="nasa-icon pe-7s-note2 pe-icon"></i>&nbsp;&nbsp;' . esc_html__('Size Guide', 'nasa-core') . '</a>';
    
    /**
     * Content Popup
     */
    $content .= '<div id="nasa-content-size-guide" class="zoom-anim-dialog nasa-node-content hidden-tag">' . $size_guide . '</div>';
    
    $content .= '</li>';
}

/**
 * Delivery & Return
 */
if ($delivery_return) {
    $content .= '<li class="nasa-popup-node-item nasa-delivery-return">';
    
    /**
     * Dom click
     */
    $content .= '<a class="nasa-node-popup" href="javascript:void(0);" data-target="#nasa-content-delivery-return" title="' . esc_attr__('Delivery &#38; Return', 'nasa-core') . '" rel="nofollow"><i class="nasa-icon pe-7s-next-2 pe-icon"></i>&nbsp;' . esc_html__('Delivery &#38; Return', 'nasa-core') . '</a>';
    
    /**
     * Content Popup
     */
    $content .= '<div id="nasa-content-delivery-return" class="zoom-anim-dialog nasa-node-content hidden-tag">' . $delivery_return . '</div>';
    
    $content .= '</li>';
}

/**
 * Ask a Question
 */
if ($ask_a_question) {
    $product_image = $single_product->get_image('thumbnail');
    $product_title = $single_product->get_name();
    $product_link = $single_product->get_permalink();
    $product_price = $single_product->get_price_html();
    $product_rating = wc_review_ratings_enabled() ?
        wc_get_rating_html($single_product->get_average_rating()) : '';
    
    $content .= '<li class="nasa-popup-node-item last nasa-ask-a-quetion">';
    
    /**
     * Dom click
     */
    $content .= '<a class="nasa-node-popup" href="javascript:void(0);" data-target="#nasa-content-ask-a-quetion" title="' . esc_attr__('Ask a Question', 'nasa-core') . '" rel="nofollow"><i class="nasa-icon pe-7s-help1 pe-icon"></i>&nbsp;' . esc_html__('Ask a Question', 'nasa-core') . '</a>';
    
    /**
     * Content Popup
     */
    $content .= '<div id="nasa-content-ask-a-quetion" class="zoom-anim-dialog nasa-node-content nasa-popup-content-contact hidden-tag">';
    
        /**
         * Product Info
         */
        $content .= '<div class="row nasa-product">';

            $content .= '<div class="large-2 medium-2 small-3 columns rtl-right nasa-product-img">';
                $content .= $product_image;
            $content .= '</div>';

            $content .= '<div class="large-10 medium-10 small-9 columns rtl-right nasa-product-info">';
                
                /**
                 * Product Name
                 */
                $content .= '<p class="name">' . $product_title . '</p>';
                
                /**
                 * Product Rating
                 */
                $content .= $product_rating;

                /**
                 * Product Price
                 */
                if ($product_price) :
                    $content .= '<div class="price">';
                    $content .= $product_price;
                    $content .= '</div>';
                endif;
                
                $content .= '<div class="hidden-tag nasa-info-add-form">';
                $content .= '<input type="hidden" name="product-name" value="' . esc_attr($product_title) . '" />';
                $content .= '<input type="hidden" name="product-url" value="' . esc_url($product_link) . '" />';
                $content .= '</div>';
            $content .= '</div>';

        $content .= '</div>';
    
        /**
         * Contact form 7
         */
        $content .= '<div class="nasa-wrap">';

            $content .= '<h3 class="nasa-headling-popup text-center nasa-bold-800">';
                $content .= esc_attr__('Ask a Question', 'nasa-core');
            $content .= '</h3>';

            $content .= $ask_a_question;
            
            $content .= '<div class="nasa-note">';
            $content .= wp_kses(__('<i class="pe-7s-info"></i> The administrator will get the request a call back<br />include this product information in the Dashboard', 'nasa-core'), array('i' => array('class' => array()), 'br' => array()));
            $content .= '</div>';

        $content .= '</div>';
    
    $content .= '</div>';
    
    $content .= '</li>';
}

/**
 * Request a Call Back
 */
if ($request_a_callback) {
    $product_image = isset($product_image) ? $product_image : $single_product->get_image('thumbnail');
    $product_title = isset($product_title) ? $product_title : $single_product->get_name();
    $product_link = isset($product_link) ? $product_link : $single_product->get_permalink();
    $product_price = isset($product_price) ? $product_price : $single_product->get_price_html();
    $product_rating = isset($product_rating) ? $product_rating : (
        wc_review_ratings_enabled() ? wc_get_rating_html($single_product->get_average_rating()) : ''
    );
    
    $content .= '<li class="nasa-popup-node-item hidden-tag nasa-request-a-callback">';
    
    /**
     * Content Popup
     */
    $content .= '<div id="nasa-content-request-a-callback" class="zoom-anim-dialog nasa-node-content nasa-popup-content-contact hidden-tag">';
    
        /**
         * Product Info
         */
        $content .= '<div class="row nasa-product">';

            $content .= '<div class="large-2 medium-2 small-3 columns rtl-right nasa-product-img">';
                $content .= $product_image;
            $content .= '</div>';

            $content .= '<div class="large-10 medium-10 small-9 columns rtl-right nasa-product-info">';
                /**
                 * Product Name
                 */
                $content .= '<p class="name">' . $product_title . '</p>';
                
                /**
                 * Product Rating
                 */
                $content .= $product_rating;

                /**
                 * Product Price
                 */
                if ($product_price) :
                    $content .= '<div class="price">';
                    $content .= $product_price;
                    $content .= '</div>';
                endif;
                
                $content .= '<div class="hidden-tag nasa-info-add-form">';
                $content .= '<input type="hidden" name="product-name" value="' . esc_attr($product_title) . '" />';
                $content .= '<input type="hidden" name="product-url" value="' . esc_url($product_link) . '" />';
                $content .= '</div>';
            $content .= '</div>';

        $content .= '</div>';
    
        /**
         * Contact form 7
         */
        $content .= '<div class="nasa-wrap">';

            $content .= '<h3 class="nasa-headling-popup text-center nasa-bold-800">';
                $content .= esc_attr__('Request a Call Back', 'nasa-core');
            $content .= '</h3>';

            $content .= $request_a_callback;
            
            $content .= '<div class="nasa-note">';
            $content .= wp_kses(__('<i class="pe-7s-info"></i> The administrator can manager<br />the message with this product information in the Dashboard', 'nasa-core'), array('i' => array('class' => array()), 'br' => array()));
            $content .= '</div>';

        $content .= '</div>';
    
    $content .= '</div>';
    
    $content .= '</li>';
}

/**
 * Output
 */
$output = apply_filters('nasa_single_product_popup_nodes', $content);

/**
 * Echo Content
 */
if ($content) {
    echo '<ul class="nasa-wrap-popup-nodes">';
    echo $output;
    echo '</ul>';
}
