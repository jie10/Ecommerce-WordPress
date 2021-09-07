<div class="widget_shopping_wishlist_content wishlist_sidebar">
    <?php
    /**
     * Yith WooCommerce Wishlist
     */
    if (NASA_WISHLIST_ENABLE) :
        echo shortcode_exists('nasa_yith_wcwl_wishlist') ? do_shortcode('[nasa_yith_wcwl_wishlist]') : '<p class="empty">' . esc_html__('Theme has not been installed or enabled Wishlist Feature.', 'elessi-theme') . '</p>';
    
    /**
     * Nasa Wishlist Sidebar Content
     */
    elseif (function_exists('elessi_woo_wishlist')) :
        $nasa_wishlist = elessi_woo_wishlist();
        if ($nasa_wishlist) :
            $nasa_wishlist->wishlist_html();
        endif;
    endif;
    ?>
</div>
