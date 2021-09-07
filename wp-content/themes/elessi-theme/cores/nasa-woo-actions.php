<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Disable default Yith Woo wishlist button
 */
if (NASA_WISHLIST_ENABLE && function_exists('YITH_WCWL_Frontend')) {
    remove_action('init', array(YITH_WCWL_Frontend(), 'add_button'));
}

/**
 * Remove action woocommerce
 */
add_action('init', 'elessi_remove_action_woo');
if (!function_exists('elessi_remove_action_woo')) :
    function elessi_remove_action_woo() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt, $yith_woocompare;
        
        /* UNREGISTRER DEFAULT WOOCOMMERCE HOOKS */
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_show_messages', 10);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
        
        remove_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        
        if (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) {
            remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
            remove_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
            remove_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
        }
        
        remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
        remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);

        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        
        /**
         * Remove compare default
         */
        if ($yith_woocompare) {
            $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
            remove_action('woocommerce_after_shop_loop_item', array($nasa_compare, 'add_compare_link'), 20);
            remove_action('woocommerce_single_product_summary', array($nasa_compare, 'add_compare_link'), 35);
        }
        
        /**
         * For content-product
         */
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
        
        /**
         * Shop page
         */
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        
        /**
         * Sale-Flash
         */
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
        
        /**
         * Mini Cart
         */
        remove_action('woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10);
        
        /**
         * Remove Relate Products
         */
        if (isset($nasa_opt['relate_product']) && !$nasa_opt['relate_product']) {
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        }
    }
endif;

/**
 * Add action woocommerce
 */
add_action('init', 'elessi_add_action_woo');
if (!function_exists('elessi_add_action_woo')) :
    function elessi_add_action_woo() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt, $yith_woocompare, $nasa_loadmore_style;
        
        // add_action('nasa_root_cats', 'elessi_get_root_categories');
        add_action('nasa_child_cat', 'elessi_get_childs_category', 10, 2);
        
        // Results count in shop page
        $disable_ajax_product = false;
        if ((isset($nasa_opt['disable_ajax_product']) && $nasa_opt['disable_ajax_product'])) :
            $disable_ajax_product = true;
        endif;
        
        $pagination_style = isset($nasa_opt['pagination_style']) ? $nasa_opt['pagination_style'] : 'style-2';
        
        if (isset($_REQUEST['paging-style']) && in_array($_REQUEST['paging-style'], $nasa_loadmore_style)) {
            $pagination_style = $_REQUEST['paging-style'];
        }
        
        if ($disable_ajax_product) :
            $pagination_style = $pagination_style == 'style-2' ? 'style-2' : 'style-1';
        else :
            add_action('woocommerce_before_main_content', 'elessi_open_woo_main');
            add_action('woocommerce_after_main_content', 'elessi_close_woo_main');
        endif;
        
        if (in_array($pagination_style, $nasa_loadmore_style)) {
            add_action('nasa_shop_category_count', 'elessi_result_count', 20);
        } else {
            add_action('nasa_shop_category_count', 'woocommerce_result_count', 20);
        }
        
        add_action('woocommerce_archive_description', 'elessi_before_archive_description', 1);
        add_action('woocommerce_archive_description', 'elessi_get_cat_top', 5);
        add_action('woocommerce_archive_description', 'elessi_after_archive_description', 999);
        
        add_action('woocommerce_after_shop_loop', 'elessi_get_cat_bottom', 1000);
        
        add_action('nasa_change_view', 'elessi_nasa_change_view', 10, 3);

        add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');
        add_action('popup_woocommerce_after_cart', 'woocommerce_cross_sell_display');
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_loop_rating', 10);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_price', 15);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_excerpt', 20);
        
        // Deal time for Quickview product
        if (!isset($nasa_opt['single-product-deal']) || $nasa_opt['single-product-deal']) {
            add_action('woocommerce_single_product_lightbox_summary', 'elessi_deal_time_quickview', 29);
        }
        
        if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) {
            add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_add_to_cart', 30);
        }
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_meta', 40);
        add_action('woocommerce_single_product_lightbox_summary', 'elessi_combo_in_quickview', 31);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_sharing', 50);
        
        add_action('nasa_single_product_layout', 'elessi_single_product_layout', 1);

        add_action('woocommerce_after_single_product_summary', 'elessi_clearboth', 11);
        add_action('woocommerce_after_single_product_summary', 'elessi_open_wrap_12_cols', 11);
        add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 11);
        add_action('woocommerce_after_single_product_summary', 'elessi_close_wrap_12_cols', 11);
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        add_action('woocommerce_single_product_summary', 'elessi_next_prev_single_product', 6);

        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15);
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 25);
        
        // Deal time for Single product
        if (!isset($nasa_opt['single-product-deal']) || $nasa_opt['single-product-deal']) {
            add_action('woocommerce_single_product_summary', 'elessi_deal_time_single', 29);
        }
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 40);
        
        /**
         * Remove heading Description tab
         */
        add_filter('woocommerce_product_description_heading', '__return_false');
        
        /**
         * Add compare product
         */
        if ($yith_woocompare) {
            if (get_option('yith_woocompare_compare_button_in_product_page') == 'yes') {
                add_action('nasa_single_buttons', 'elessi_add_compare_in_detail', 20);
            }
            
            if (get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
                add_action('nasa_show_buttons_loop', 'elessi_add_compare_in_list', 50);
            }
        }
        
        /**
         * Single Product Ajax Call
         */
        add_action('woocommerce_after_single_product', 'elessi_ajax_single_product_tag');
        
        /**
         * Add to Cart in list - Loop
         */
        add_action('nasa_show_buttons_loop', 'elessi_add_to_cart_in_list', 10);
        
        add_action('nasa_show_buttons_loop', 'elessi_add_wishlist_in_list', 20);
        if (!isset($nasa_opt['disable-quickview']) || !$nasa_opt['disable-quickview']) {
            add_action('nasa_show_buttons_loop', 'elessi_quickview_in_list', 40);
        }
        add_action('nasa_show_buttons_loop', 'elessi_bundle_in_list', 60, 1);
        
        /**
         * Notice in Archive Products Page | Single Product Page
         */
        add_action('woocommerce_before_main_content', 'woocommerce_output_all_notices', 10);
        
        // Nasa ADD BUTTON BUY NOW
        add_action('woocommerce_after_add_to_cart_button', 'elessi_add_buy_now_btn');
        
        // Nasa Add Custom fields
        add_action('woocommerce_after_add_to_cart_button', 'elessi_add_custom_field_detail_product', 25);
        
        // nasa_top_sidebar_shop
        add_action('nasa_top_sidebar_shop', 'elessi_top_sidebar_shop', 10, 1);
        add_action('nasa_sidebar_shop', 'elessi_side_sidebar_shop', 10 , 1);
        
        // For Product content
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_loop_countdown');
        
        /**
         * Custom filters woocommerce_post_class
         */
        add_filter('woocommerce_post_class', 'elessi_custom_woocommerce_post_class');
        
        add_action('nasa_get_content_products', 'elessi_get_content_products', 10, 1);
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_loop_product_content_btns', 15);
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_gift_featured', 15);
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_loop_product_content_thumbnail', 20);
        
        add_action('woocommerce_after_shop_loop_item', 'elessi_content_show_in_list');
        
        /**
         * Sale flash
         */
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_add_custom_sale_flash', 10);
        add_action('woocommerce_before_single_product_summary', 'elessi_add_custom_sale_flash', 11);
        
        add_action('woocommerce_shop_loop_item_title', 'elessi_loop_product_cats', 5, 1);
        add_action('woocommerce_shop_loop_item_title', 'elessi_loop_product_content_title', 10);
        add_action('woocommerce_after_shop_loop_item_title', 'elessi_loop_product_description', 15, 1);
        
        /**
         * Add to wishlist in Single Product
         */
        add_action('nasa_single_buttons', 'elessi_add_wishlist_in_detail', 15);
        
        // for woo 3.3
        if (version_compare(WC()->version, '3.3.0', ">=")) {
            if (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized']) {
                add_filter('woocommerce_product_subcategories_args', 'elessi_hide_uncategorized');
            }
        }
        
        /**
         * Share icon in Single Product
         */
        add_action('woocommerce_share', 'elessi_before_woocommerce_share', 5);
        add_action('woocommerce_share', 'elessi_woocommerce_share', 10);
        add_action('woocommerce_share', 'elessi_after_woocommerce_share', 15);
        
        /**
         * Mini Cart
         */
        add_action('woocommerce_widget_shopping_cart_total', 'elessi_widget_shopping_cart_subtotal', 10);
        
        /**
         * Add src image large for variation
         */
        add_filter('woocommerce_available_variation', 'elessi_src_large_image_single_product');
        
        /**
         * Add class Sub Categories
         */
        add_filter('product_cat_class', 'elessi_add_class_sub_categories');
        
        /**
         * Filter redirect checkout buy now
         */
        add_filter('woocommerce_add_to_cart_redirect', 'elessi_buy_now_to_checkout');
        
        /**
         * Filter Single Stock
         */
        if (!isset($nasa_opt['enable_progess_stock']) || $nasa_opt['enable_progess_stock']) {
            add_filter('woocommerce_get_stock_html', 'elessi_single_stock', 10, 2);
        }
        
        /**
         * Disable redirect Search one product to single product
         */
        add_filter('woocommerce_redirect_single_search_result', '__return_false');
        
        /**
         * Custom Tabs in Single product
         */
        add_filter('woocommerce_product_tabs', 'elessi_custom_tabs_single_product');
        
        /**
         * Checkout - Layout
         */
        add_action('nasa_checkout_form_layout', 'elessi_checkout_form_layout', 10, 1);
        
        /**
         * Actions for Checkout Modern
         */
        if (defined('NASA_CHECKOUT_LAYOUT') && NASA_CHECKOUT_LAYOUT == 'modern') {
            add_filter('woocommerce_update_order_review_fragments', 'elessi_update_order_review_fragments');
            add_filter('woocommerce_checkout_fields', 'elessi_checkout_email_first');
            
            add_action('woocommerce_checkout_after_customer_details', 'elessi_step_billing', 15);
            
            add_action('woocommerce_checkout_after_customer_details', 'elessi_checkout_shipping', 20);
            
            remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
            
            add_action('woocommerce_review_order_before_payment', 'elessi_checkout_payment_open', 5);
            add_action('woocommerce_review_order_before_payment', 'elessi_checkout_payment_headling');
            add_action('woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 25);
            add_action('woocommerce_review_order_after_payment', 'elessi_checkout_payment_close', 100);
            
            // remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
            add_action('woocommerce_review_order_after_cart_contents', 'elessi_checkout_coupon_form_clone');
        }
        
        /**
         * Support Yith WooCommerce Product Add-ons in Quick view
         */
        if (class_exists('YITH_WAPO')) {
            $yith_wapo = YITH_WAPO::instance();
            $yith_wapo_frontend = $yith_wapo->frontend;
            add_action('woocommerce_single_product_lightbox_summary', array($yith_wapo_frontend, 'check_variable_product'));
        }
        
        /**
         * Compatible with WC_Vendor plugin
         */
        if (class_exists('WCV_Vendor_Shop')) {
            if (has_action('woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9)) {
                remove_action('woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
                add_action('woocommerce_after_shop_loop_item_title', 'elessi_wc_vendor_template_loop_sold_by');
            }
            
            if (has_action('woocommerce_product_meta_start', array('WCV_Vendor_Cart', 'sold_by_meta'))) {
                remove_action('woocommerce_product_meta_start', array('WCV_Vendor_Cart', 'sold_by_meta'));
                add_action('woocommerce_product_meta_start', 'elessi_wc_vendor_sold_by_meta');
            }
        }
        
        /**
         * Compatible with Dokan plugin
         */
        if (NASA_DOKAN_ACTIVED) {
            add_action('woocommerce_after_shop_loop_item_title', 'elessi_dokan_loop_sold_by');
            
            if (version_compare(WC()->version, '3.3.0', ">=")) {
                if (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized']) {
                    add_filter('dokan_category_widget', 'elessi_hide_uncategorized');
                }
            }
        }
        
        /**
         * woocommerce_form_field_args
         */
        add_filter('woocommerce_form_field_args', 'elessi_wc_form_field_args');
    }
endif;

/**
 * Custom Content show in list view archive page
 */
if (!function_exists('elessi_content_show_in_list')) :
    function elessi_content_show_in_list($show_in_list) {
        global $product, $nasa_opt;
        
        if ($show_in_list && (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile'])) {
            $availability = $product->get_availability();
            if (!empty($availability['availability'])) {
                $stock_class = $availability['class'];
                $stock_label = $availability['availability'];
                ?>
                <!-- Clone Group btns for layout List -->
                <div class="hidden-tag nasa-list-stock-wrap">
                    <p class="nasa-list-stock-status <?php echo esc_attr($stock_class); ?>">
                        <?php echo $stock_label; ?>
                    </p>
                </div>
                <?php
            }
        }
    }
endif;

/**
 * Custom woocommerce_post_class
 */
if (!function_exists('elessi_custom_woocommerce_post_class')) :
    function elessi_custom_woocommerce_post_class($classes) {
        global $nasa_opt, $product, $nasa_time_sale;
        
        $product_id = $product->get_id();
        
        $classes[] = 'product-item grid';
        
        /**
         * Animate class
         */
        if (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile']) {
            $classes[] = 'wow fadeInUp';
        }
        
        /**
         * Hover effect products in grid
         */
        if (isset($nasa_opt['animated_products']) && $nasa_opt['animated_products']) {
            $classes[] = $nasa_opt['animated_products'];
        }
        
        /**
         * Out of Stock
         */
        if ("outofstock" == $product->get_stock_status()) {
            $classes[] = 'out-of-stock';
        }
        
        /**
         * Deal class
         */
        if (!isset($nasa_time_sale[$product_id])) {
            $nasa_time_sale[$product_id] = false;
            if ($product->is_on_sale() && $product->get_type() != 'variable') {
                $time_from = get_post_meta($product_id, '_sale_price_dates_from', true);
                $time_to = get_post_meta($product_id, '_sale_price_dates_to', true);
                $nasa_time_sale[$product_id] = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
            }
            
            $GLOBALS['nasa_time_sale'] = $nasa_time_sale;
        }
        
        if ($nasa_time_sale[$product_id]) {
            $classes[] = 'product-deals';
        }
        
        return $classes;
    }
endif;

/**
 * Deal time for loop
 */
if (!function_exists('elessi_loop_countdown')) :
    function elessi_loop_countdown() {
        global $product, $nasa_time_sale;
        
        $product_id = $product->get_id();
        
        /**
         * Deal class
         */
        if (!isset($nasa_time_sale[$product_id])) {
            $nasa_time_sale[$product_id] = false;
            if ($product->is_on_sale() && $product->get_type() != 'variable') {
                $time_from = get_post_meta($product_id, '_sale_price_dates_from', true);
                $time_to = get_post_meta($product_id, '_sale_price_dates_to', true);
                $nasa_time_sale[$product_id] = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
            }
            
            $GLOBALS['nasa_time_sale'] = $nasa_time_sale;
        }
        
        echo $nasa_time_sale[$product_id] ? elessi_time_sale($nasa_time_sale[$product_id]) : '<div class="nasa-sc-pdeal-countdown hidden-tag"></div>';
    }
endif;

/**
 * Compatible with DOKAN plugin
 * 
 * sold-by in loop
 */
if (!function_exists('elessi_dokan_loop_sold_by')) :
    function elessi_dokan_loop_sold_by() {
        if (!NASA_DOKAN_ACTIVED) {
            return;
        }
        
        global $post, $nasa_dokan_vendors;
        
        if (!$post) {
            return;
        }
        
        if (!isset($nasa_dokan_vendors[$post->post_author])) {
            $author = get_user_by('id', $post->post_author);
            $store_info = dokan_get_store_info($author->ID);
            
            if (!empty($store_info['store_name'])) {
                $nasa_dokan_vendors[$post->post_author]['name'] = $store_info['store_name'];
                $nasa_dokan_vendors[$post->post_author]['url'] = dokan_get_store_url($author->ID);
            } else {
                $nasa_dokan_vendors[$post->post_author] = null;
            }
            
            $GLOBALS['nasa_dokan_vendors'] = $nasa_dokan_vendors;
        }
        
        if (isset($nasa_dokan_vendors[$post->post_author]) && $nasa_dokan_vendors[$post->post_author]) {
            echo '<small class="nasa-dokan-sold_by_in_loop">';
                echo esc_html__('Sold By: ', 'elessi-theme');
                echo '<a ' .
                'href="' . esc_url($nasa_dokan_vendors[$post->post_author]['url']) . '" ' .
                'class="nasa-dokan-sold_by_href" ' .
                'title="' . esc_attr($nasa_dokan_vendors[$post->post_author]['name']) . '">';
                    echo $nasa_dokan_vendors[$post->post_author]['name'];
                echo '</a>';
            echo '</small>';
        }
    }
endif;

/**
 * Compatible with WC_Vendor plugin
 * 
 * sold-by in loop
 */
if (!function_exists('elessi_wc_vendor_template_loop_sold_by')) :
    function elessi_wc_vendor_template_loop_sold_by() {
        global $product;
        
        if (!class_exists('WCV_Vendor_Shop') || !$product) {
            return;
        }

        
        WCV_Vendor_Shop::template_loop_sold_by($product->get_id());
    }
endif;

/**
 * Compatible with WC_Vendor plugin
 * 
 * Meta in single product
 */
if (!function_exists('elessi_wc_vendor_sold_by_meta')) :
    function elessi_wc_vendor_sold_by_meta() {
        if (!class_exists('WCV_Vendor_Cart')) {
            return;
        }
        
        echo '<span class="nasa-wc-vendor-single-meta">';
        WCV_Vendor_Cart::sold_by_meta();
        echo '</span>';
    }
endif;

/**
 * Single Product stock Progress bar
 */
if (!function_exists('elessi_single_stock')) :
    function elessi_single_stock($html, $product) {
        if ($html == '' || !$product) {
            return $html;
        }
        
        $product_id = $product->get_id();
        $stock = get_post_meta($product_id, '_stock', true);
        
        if (!$stock) {
            return $html;
        }
        
        $total_sales = get_post_meta($product_id, 'total_sales', true);
        $stock_sold = $total_sales ? round($total_sales) : 0;
        $stock_available = $stock ? round($stock) : 0;
        $percentage = $stock_available > 0 ? round($stock_sold/($stock_available + $stock_sold) * 100) : 0;
        
        $new_html = '<div class="stock nasa-single-product-stock">';
        $new_html .= '<span class="stock-sold">';
        $new_html .= sprintf(esc_html__('Only %s item(s) left in stock.', 'elessi-theme'), '<b>' . $stock_available . '</b>');
        $new_html .= '</span>';
        $new_html .= '<div class="nasa-product-stock-progress">';
        $new_html .= '<span class="nasa-product-stock-progress-bar" style="width:' . $percentage . '%"></span>';
        $new_html .= '</div>';
        $new_html .= '</div>';
        
        return $new_html;
    }
endif;

/**
 * Buy Now button
 */
if (!function_exists('elessi_add_buy_now_btn')) :
    function elessi_add_buy_now_btn() {
        global $nasa_opt, $product;
        
        if (
            (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) ||
            (isset($nasa_opt['enable_buy_now']) && !$nasa_opt['enable_buy_now']) ||
            'external' == $product->get_type() // Disable with External Product
        ) {
            return;
        }
        
        $class = 'nasa-buy-now';
        if (isset($nasa_opt['enable_fixed_buy_now_desktop']) && $nasa_opt['enable_fixed_buy_now_desktop']) {
            $class .= ' has-sticky-in-desktop';
        }
        
        echo '<input type="hidden" name="nasa_buy_now" value="0" />';
        echo '<button class="' . $class . '">' . esc_html__('BUY NOW', 'elessi-theme') . '</button>';
    }
endif;

/**
 * Redirect to Checkout page after click buy now
 */
if (!function_exists('elessi_buy_now_to_checkout')) :
    function elessi_buy_now_to_checkout($redirect_url) {
        if (isset($_REQUEST['nasa_buy_now']) && $_REQUEST['nasa_buy_now'] === '1') {
            $redirect_url = wc_get_checkout_url();
        }

        return $redirect_url;
    }
endif;

/**
 * Add class Sub Categories
 */
if (!function_exists('elessi_add_class_sub_categories')) :
    function elessi_add_class_sub_categories($classes) {
        $classes[] = 'product-warp-item';
        
        return $classes;
    }
endif;

/**
 * Deal time in Single product page
 */
if (!function_exists('elessi_deal_time_single')) :
    function elessi_deal_time_single() {
        global $product;
        
        if ($product->get_stock_status() == 'outofstock') {
            return;
        }
        
        $product_type = $product->get_type();
        
        // For variation of Variation product
        if ($product_type == 'variable') {
            echo '<div class="countdown-label nasa-detail-product-deal-countdown-label nasa-crazy-inline hidden-tag">' .
            '<i class="nasa-icon pe-7s-alarm pe7-icon"></i>&nbsp;&nbsp;' .
                esc_html__('Hurry up! Sale end in:', 'nasa-core') .
            '</div>';
            echo '<div class="nasa-detail-product-deal-countdown nasa-product-variation-countdown"></div>';
            
            return;
        }
        
        if ($product_type != 'simple') {
            return;
        }
        
        $productId = $product->get_id();

        $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
        $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
        $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
        if (!$time_sale) {
            return;
        }
        echo '<div class="countdown-label nasa-crazy-inline">' .
            '<i class="nasa-icon pe-7s-alarm pe7-icon"></i>&nbsp;&nbsp;' .
            esc_html__('Hurry up! Sale end in:', 'nasa-core') .
        '</div>';
        echo '<div class="nasa-detail-product-deal-countdown">';
        echo elessi_time_sale($time_sale);
        echo '</div>';
    }
endif;

/**
 * Deal time in Quick view product
 */
if (!function_exists('elessi_deal_time_quickview')) :
    function elessi_deal_time_quickview() {
        global $product;
        
        if ($product->get_stock_status() == 'outofstock') {
            return;
        }
        
        $product_type = $product->get_type();
        
        // For variation of Variation product
        if ($product_type == 'variable') {
            echo '<div class="nasa-quickview-product-deal-countdown nasa-product-variation-countdown"></div>';
            return;
        }
        
        if ($product_type != 'simple') {
            return;
        }
        
        $productId = $product->get_id();

        $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
        $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
        $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
        if (!$time_sale) {
            return;
        }
        
        echo '<div class="nasa-quickview-product-deal-countdown">';
        echo elessi_time_sale($time_sale);
        echo '</div>';
    }
endif;

/**
 * Main Image of Variation
 */
if (!function_exists('elessi_src_large_image_single_product')) :
    function elessi_src_large_image_single_product($variation) {
        if (!isset($variation['image_single_page'])) {
            $image = wp_get_attachment_image_src($variation['image_id'], 'shop_single');
            $variation['image_single_page'] = isset($image[0]) ? $image[0] : '';
        }
        
        return $variation;
    }
endif;

/**
 * Results count in archive page in top
 */
if (!function_exists('elessi_result_count')) :
    function elessi_result_count() {
        if (! wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
            return;
        }
        
        $total = wc_get_loop_prop('total');
        $per_page = wc_get_loop_prop('per_page');
        
        echo '<p class="woocommerce-result-count">';
        if ( $total <= $per_page || -1 === $per_page ) {
            printf(_n('Showing the single result', 'Showing all %d results', $total, 'elessi-theme'), $total);
	} else {
            $current = wc_get_loop_prop('current_page');
            $showed = $per_page * $current;
            if ($showed > $total) {
                $showed = $total;
            }
            
            printf(_n('Showing the single result', 'Showing %d results', $total, 'elessi-theme'), $showed);
	}
        echo '</p>';
    }
endif;

/**
 * Get Top Content category products page
 */
if (!function_exists('elessi_get_cat_top')):
    function elessi_get_cat_top() {
        global $wp_query, $nasa_opt;
        
        $catId = null;
        $nasa_cat_obj = $wp_query->get_queried_object();
        if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
            $catId = (int) $nasa_cat_obj->term_id;
        }
        
        $content = '<div class="nasa-cat-header">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $block = get_term_meta($catId, 'cat_header', true);
            
            if ($block === '-1') {
                return;
            }
            
            if ($block) {
                $do_content = elessi_get_block($block);
            }
        }

        if (trim($do_content) === '') {
            if (isset($nasa_opt['cat_header_content']) && $nasa_opt['cat_header_content'] != '') {
                $do_content = elessi_get_block($nasa_opt['cat_header_content']);
            }
        }

        if (trim($do_content) === '') {
            return;
        }

        $content .= $do_content . '</div>';

        echo $content;
    }
endif;

/**
 * Get Bottom Content category products page
 */
if (!function_exists('elessi_get_cat_bottom')):
    function elessi_get_cat_bottom() {
        global $wp_query, $nasa_opt;
        
        $catId = null;
        $nasa_cat_obj = $wp_query->get_queried_object();
        if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
            $catId = (int) $nasa_cat_obj->term_id;
        }
        
        $content = '<div class="nasa-cat-footer padding-top-20 padding-bottom-50">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $block = get_term_meta($catId, 'cat_footer_content', true);
            
            if ($block === '-1') {
                return;
            }
            
            if ($block) {
                $do_content = elessi_get_block($block);
            }
        }

        if (trim($do_content) === '') {
            if (isset($nasa_opt['cat_footer_content']) && $nasa_opt['cat_footer_content'] != '') {
                $do_content = elessi_get_block($nasa_opt['cat_footer_content']);
            }
        }

        if (trim($do_content) === '') {
            return;
        }

        $content .= $do_content . '</div>';

        echo $content;
    }
endif;

/**
 * Nasa childs category in Shop Top bar
 */
if (!function_exists('elessi_get_childs_category')):
    function elessi_get_childs_category($term = null, $instance = array()) {
        $content = '';
        
        if (NASA_WOO_ACTIVED){
            global $wp_query;
            
            $term = $term == null ? $wp_query->get_queried_object() : $term;
            $parent_id = is_numeric($term) ? $term : (isset($term->term_id) ? $term->term_id : 0);
            
            $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => $parent_id,
                'hierarchical' => true,
                'hide_empty' => false,
                'orderby' => 'name'
            )));
            
            if (!$nasa_terms) {
                $term_root = get_ancestors($parent_id, 'product_cat');
                $term_parent = isset($term_root[0]) ? $term_root[0] : 0;
                $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                    'taxonomy' => 'product_cat',
                    'parent' => $term_parent,
                    'hierarchical' => true,
                    'hide_empty' => false,
                    'orderby' => 'name'
                )));
            }
            
            if ($nasa_terms) {
                $show = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;
                $content .= '<ul class="nasa-children-cat product-categories nasa-product-child-cat-top-sidebar">';
                $items = 0;
                foreach ($nasa_terms as $v) {
                    $class_active = $parent_id == $v->term_id ? ' nasa-active' : '';
                    $class_li = ($show && $items >= $show) ? ' nasa-show-less' : '';
                    
                    $icon = '';
                    if (isset($instance['cat_' . $v->slug]) && trim($instance['cat_' . $v->slug]) != '') {
                        $icon = '<i class="' . $instance['cat_' . $v->slug] . '"></i>';
                        $icon .= '&nbsp;&nbsp;';
                    }
                    
                    $content .= '<li class="cat-item cat-item-' . esc_attr($v->term_id) . ' cat-item-accessories root-item' . $class_li . '">';
                    $content .= '<a href="' . esc_url(get_term_link($v)) . '" data-id="' . esc_attr($v->term_id) . '" class="nasa-filter-by-cat' . $class_active . '" title="' . esc_attr($v->name) . '" data-taxonomy="product_cat">';
                    $content .= '<div class="nasa-cat-warp">';
                    $content .= '<h5 class="nasa-cat-title">';
                    $content .= $icon . esc_attr($v->name);
                    $content .= '</h5>';
                    $content .= '</div>';
                    $content .= '</a>';
                    $content .= '</li>';
                    $items++;
                }
                
                if ($show && ($items > $show)) {
                    $content .= '<li class="nasa_show_manual"><a data-show="1" class="nasa-show" href="javascript:void(0);" data-text="' . esc_attr__('- Show less', 'elessi-theme') . '" rel="nofollow">' . esc_html__('+ Show more', 'elessi-theme') . '</a></li>';
                }
                
                $content .= '</ul>';
            }
        }
        
        echo $content;
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('elessi_checkout_form_layout')) :
    function elessi_checkout_form_layout($checkout) {
        $name = defined('NASA_CHECKOUT_LAYOUT') ? NASA_CHECKOUT_LAYOUT : 'default';
        $layout = 'nasa-checkout-' . $name;
        
        $file = ELESSI_CHILD_PATH . '/includes/' . $layout . '.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/' . $layout . '.php';
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('elessi_checkout_coupon_form_clone')) :
    function elessi_checkout_coupon_form_clone() {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-checkout-coupon-modern.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-checkout-coupon-modern.php';
    }
endif;

/**
 * Add action elessi_step_billing.
 */
if (!function_exists('elessi_step_billing')) :
    function elessi_step_billing() {
        echo '<div id="nasa-step_billing">';
        echo '<div class="nasa-checkout-step">';
        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="nasa-back-to-cart nasa-back-step" title="' . esc_attr__('Return to Cart', 'elessi-theme') . '">' . esc_html__('RETURN TO CART', 'elessi-theme') . '</a>';
        echo '<a href="javascript:void(0);" rel="nofollow" class="button nasa-shipping-step nasa-switch-step">' . esc_html__('Continue To Shipping', 'elessi-theme') . '</a>';
        echo '</div>';
        echo '<p class="nasa-require-notice hidden-tag">' . esc_html__('This field is required.', 'elessi-theme') . '</p>';
        echo '<p class="nasa-email-notice hidden-tag">' . esc_html__('Email incorrect format.', 'elessi-theme') . '</p>';
        echo '<p class="nasa-phone-notice hidden-tag">' . esc_html__('Phone incorrect format.', 'elessi-theme') . '</p>';
        echo '</div>';
    }
endif;

/**
 * Add action Checkout shipping.
 */
if (!function_exists('elessi_checkout_shipping')) :
    function elessi_checkout_shipping() {
        echo '<div id="nasa-billing-info">';
        
        echo '<div class="customer-info-wrap">';
        
        echo '<div class="customer-info customer-info-email">';
        echo '<span class="customer-info-left">' . esc_html__('Contact', 'elessi-theme') . '</span>';
        echo '<span class="customer-info-right"></span>';
        echo '<a href="javascript:void(0);" class="customer-info-change nasa-billing-step rtl-text-left">' . esc_html__('Change', 'elessi-theme') . '</a>';
        echo '</div>';
        
        echo '<div class="customer-info customer-info-addr">';
        echo '<span class="customer-info-left">' . esc_html__('Ship to', 'elessi-theme') . '</span>';
        echo '<span class="customer-info-right"><p class="nasa-ct-info-addr"></p></span>';
        echo '<a href="javascript:void(0);" class="customer-info-change nasa-billing-step rtl-text-left">' . esc_html__('Change', 'elessi-theme') . '</a>';
        echo '</div>';
        
        echo '<div class="customer-info customer-info-method hidden-tag">';
        echo '<span class="customer-info-left">' . esc_html__('Method', 'elessi-theme') . '</span>';
        echo '<span class="customer-info-right"></span>';
        echo '<a href="javascript:void(0);" class="customer-info-change nasa-shipping-step rtl-text-left">' . esc_html__('Change', 'elessi-theme') . '</a>';
        echo '</div>';
        
        echo '</div>';
        
        echo '</div>';
        
        echo '<div id="nasa-shipping-methods" class="hidden-tag">';
        echo '<h3 class="nasa-box-headling">';
        echo esc_html__('Shipping Methods', 'elessi-theme');
        echo '</h3>';
        echo '<div class="shipping-wrap-modern"></div>';
        echo '</div>';
        
        echo '<div id="nasa-step_payment">';
        echo '<div class="nasa-checkout-step">';
        echo '<a href="javascript:void(0);" rel="nofollow" class="nasa-billing-step nasa-back-step">' . esc_html__('RETURN TO INFORMATION', 'elessi-theme') . '</a>';
        echo '<a href="javascript:void(0);" rel="nofollow" class="button nasa-payment-step nasa-switch-step">' . esc_html__('Continue To Payment', 'elessi-theme') . '</a>';
        echo '</div>';
        echo '</div>';
    }
endif;

/**
 * Modern Shipping html
 */
if (!function_exists('elessi_modern_shipping_html')) :
    function elessi_modern_shipping_html() {
        ob_start();
        wc_cart_totals_shipping_html();
        $shipping = ob_get_clean();
        
        return $shipping;
    }
endif;

/**
 * Add action Payments Headling.
 */
if (!function_exists('elessi_checkout_payment_headling')) :
    function elessi_checkout_payment_headling() {
        echo '<h3 class="nasa-box-headling payment-method-step">';
        echo esc_html__('Payment Methods', 'elessi-theme');
        echo '</h3>';
        echo '<p class="nasa-box-desc payment-method-step">' . esc_html__('All transactions are secure and encrypted.', 'elessi-theme') . '</p>';
    }
endif;

/**
 * Add Filter 'woocommerce_checkout_fields'.
 */
if (!function_exists('elessi_checkout_email_first')) :
    function elessi_checkout_email_first($checkout_fields) {
        $checkout_fields['billing']['billing_email']['priority'] = 5;
        
        return $checkout_fields;
    }
endif;

/**
 * Add Filter 'woocommerce_update_order_review_fragments'.
 */
if (!function_exists('elessi_update_order_review_fragments')) :
    function elessi_update_order_review_fragments($fragments) {
        $packages = WC()->shipping->get_packages();
        
        if (isset($packages[0]) && $packages[0]['destination']) {
            $fragments['.nasa-ct-info-addr'] = '<p class="nasa-ct-info-addr">' . WC()->countries->get_formatted_address($packages[0]['destination'], ', ') . '</p>';
        }
        
        /**
         * Total price
         */
        ob_start();
        wc_cart_totals_order_total_html();
        $total = ob_get_clean();
        $fragments['.your-order-price'] = '<span class="your-order-price">' . $total . '</span>';
        
        /**
         * Shipping Method
         */
        ob_start();
        wc_cart_totals_shipping_html();
        $shipping = ob_get_clean();
        $fragments['.shipping-wrap-modern'] = $shipping;
        
        return $fragments;
    }
endif;

/**
 * Add action before Payments.
 */
if (!function_exists('elessi_checkout_payment_open')) :
    function elessi_checkout_payment_open() {
        echo '<div id="nasa-payment-wrap">';
    }
endif;

/**
 * Add action after Payments.
 */
if (!function_exists('elessi_checkout_payment_close')) :
    function elessi_checkout_payment_close() {
        echo '</div>';
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('elessi_bc_checkout_modern')) :
    function elessi_bc_checkout_modern() {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-get-content-products.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-get-content-products.php';
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('elessi_get_content_products')) :
    function elessi_get_content_products($nasa_sidebar = 'top') {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-get-content-products.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-get-content-products.php';
    }
endif;

/**
 * Next - Prev Single Product
 */
if (!function_exists('elessi_next_prev_single_product')) :
    function elessi_next_prev_single_product() {
        echo '<div class="products-arrow">';
        do_action('next_prev_product');
        echo '</div>';
    }
endif;

/*
 * Wishlist in list
 */
if (!function_exists('elessi_add_wishlist_in_list')) :
    function elessi_add_wishlist_in_list() {
        if (NASA_WISHLIST_IN_LIST) {
            elessi_add_wishlist_button('left');
        }
    }
endif;

/*
 * Wishlist in single
 */
if (!function_exists('elessi_add_wishlist_in_detail')) :
    function elessi_add_wishlist_in_detail() {
        elessi_add_wishlist_button('right');
    }
endif;

/**
 * Quick view in list
 */
if (!function_exists('elessi_quickview_in_list')) :
    function elessi_quickview_in_list($echo = true) {
        global $product;
        $type = $product->get_type();
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('nasa_icon_quickview', '<i class="nasa-icon pe-7s-look"></i>');
        
        $quickview = '<a ' .
            'href="javascript:void(0);" ' .
            'class="quick-view btn-link quick-view-icon nasa-tip nasa-tip-left" ' .
            'data-prod="' . absint($product->get_id()) . '" ' .
            'data-icon-text="' . ($type !== 'woosb' ? esc_attr__('Quick View', 'elessi-theme') : esc_attr__('View', 'elessi-theme')) . '" ' .
            'title="' . ($type !== 'woosb' ? esc_attr__('Quick View', 'elessi-theme') : esc_attr__('View', 'elessi-theme')) . '" ' .
            'data-product_type="' . esc_attr($type) . '" ' .
            'data-href="' . get_the_permalink() . '" rel="nofollow">' .
            $icon .
        '</a>';
        
        if (!$echo) {
            return $quickview;
        }
        
        echo $quickview;
    }
endif;

/**
 * add to cart in list
 */
if (!function_exists('elessi_add_to_cart_in_list')) :
    function elessi_add_to_cart_in_list() {
        global $nasa_opt;
        
        if (!isset($nasa_opt['loop_add_to_cart']) || $nasa_opt['loop_add_to_cart']) {
            elessi_add_to_cart_btn();
        }
    }
endif;

/**
 * elessi gift icon in list
 */
if (!function_exists('elessi_bundle_in_list')) :
    function elessi_bundle_in_list($combo_show_type) {
        global $product;
        if (!defined('YITH_WCPB') || $product->get_type() != NASA_COMBO_TYPE) {
            return;
        }
        ?>
        <a href="javascript:void(0);" class="btn-combo-link btn-link gift-icon nasa-tip nasa-tip-left" data-prod="<?php echo (int) $product->get_id(); ?>" data-tip="<?php esc_attr_e('Promotion Gifts', 'elessi-theme'); ?>" title="<?php esc_attr_e('Promotion Gifts', 'elessi-theme'); ?>" data-icon-text="<?php esc_attr_e('Promotion Gifts', 'elessi-theme'); ?>" data-show_type="<?php echo esc_attr($combo_show_type); ?>" rel="nofollow">
            <i class="nasa-icon pe-7s-gift"></i>
        </a>
        <?php
    }
endif;

/**
 * Nasa Gift icon Featured
 */
if (!function_exists('elessi_gift_featured')) :
    function elessi_gift_featured() {
        global $product, $nasa_opt;
        
        if (isset($nasa_opt['enable_gift_featured']) && !$nasa_opt['enable_gift_featured']) {
            return;
        }
        
        $product_type = $product->get_type();
        if (!defined('YITH_WCPB') || $product_type != NASA_COMBO_TYPE) {
            return;
        }
        
        echo 
        '<div class="nasa-gift-featured-wrap">' .
            '<div class="nasa-gift-featured">' .
                '<div class="gift-icon">' .
                    '<a href="javascript:void(0);" class="nasa-gift-featured-event nasa-transition" title="' . esc_attr__('View the promotion gifts', 'elessi-theme') . '" rel="nofollow">' .
                        '<span class="pe-icon pe-7s-gift"></span>' .
                        '<span class="hidden-tag nasa-icon-text">' . 
                            esc_html__('Promotion Gifts', 'elessi-theme') . 
                        '</span>' .
                    '</a>' .
                '</div>' .
            '</div>' .
        '</div>';
    }
endif;

/**
 * elessi add compare in list
 */
if (!function_exists('elessi_add_compare_in_list')) :
    function elessi_add_compare_in_list() {
        global $product, $nasa_opt;
        $productId = $product->get_id();
        
        $nasa_compare = (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare']) ? true : false;
        
        $class_btn = 'btn-compare btn-link compare-icon nasa-tip nasa-tip-left';
        $class_btn .= $nasa_compare ? ' nasa-compare' : '';
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('nasa_icon_compare', '<i class="nasa-icon icon-nasa-refresh"></i>');
        ?>
        <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-icon-text="<?php esc_attr_e('Compare', 'elessi-theme'); ?>" title="<?php esc_attr_e('Compare', 'elessi-theme'); ?>" rel="nofollow">
            <?php echo $icon; ?>
        </a>
        
        <?php if (!$nasa_compare) : ?>
            <div class="add-to-link woocommerce-compare-button hidden-tag">
                <?php echo do_shortcode('[yith_compare_button]'); ?>
            </div>
        <?php endif;
    }
endif;

/**
 * elessi add compare in single
 */
if (!function_exists('elessi_add_compare_in_detail')) :
    function elessi_add_compare_in_detail() {
        global $product, $nasa_opt;
        $productId = $product->get_id();
        
        $nasa_compare = (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare']) ? true : false;
        
        $class_btn = 'btn-compare btn-link compare-icon nasa-tip nasa-tip-right';
        $class_btn .= $nasa_compare ? ' nasa-compare' : '';
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('nasa_icon_compare_in_detail', '<span class="nasa-icon icon-nasa-compare-2"></span>');
        ?>
        <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-tip="<?php esc_attr_e('Compare', 'elessi-theme'); ?>" title="<?php esc_attr_e('Compare', 'elessi-theme'); ?>" rel="nofollow">
            <?php echo $icon; ?>
            <span class="nasa-icon-text"><?php esc_html_e('Add to Compare', 'elessi-theme'); ?></span>
        </a>

        <?php if (!$nasa_compare) : ?>
            <div class="add-to-link woocommerce-compare-button hidden-tag">
                <?php echo do_shortcode('[yith_compare_button]'); ?>
            </div>
        <?php endif; ?>
    <?php
    }
endif;

/**
 * custom fields single product
 */
if (!function_exists('elessi_add_custom_field_detail_product')) :
    function elessi_add_custom_field_detail_product() {
        global $product, $product_lightbox;
        if ($product_lightbox) {
            $product = $product_lightbox;
        }
        
        $product_type = $product->get_type();
        // 'woosb' Bundle product
        if (!in_array($product_type, array('simple', 'variable', 'variation'))) {
            return;
        }
        
        global $nasa_opt;

        $nasa_btn_ajax_value = '0';
        if (
            'yes' !== get_option('woocommerce_cart_redirect_after_add') &&
            'yes' === get_option('woocommerce_enable_ajax_add_to_cart') &&
            (!isset($nasa_opt['enable_ajax_addtocart']) || $nasa_opt['enable_ajax_addtocart'] == '1')
        ) {
            $nasa_btn_ajax_value = '1';
        }
        
        echo '<div class="nasa-custom-fields hidden-tag">';
        echo '<input type="hidden" name="nasa-enable-addtocart-ajax" value="' . $nasa_btn_ajax_value . '" />';
        echo '<input type="hidden" name="data-product_id" value="' . esc_attr($product->get_id()) . '" />';
        echo '<input type="hidden" name="data-type" value="' . esc_attr($product_type) . '" />';
        
        if (NASA_WISHLIST_ENABLE) {
            $nasa_has_wishlist = (isset($_REQUEST['nasa_wishlist']) && $_REQUEST['nasa_wishlist'] == '1') ? '1' : '0';
            echo '<input type="hidden" name="data-from_wishlist" value="' . esc_attr($nasa_has_wishlist) . '" />';
        }
        
        echo '</div>';
    }
endif;

/**
 * Images in content product
 */
if (!function_exists('elessi_loop_product_content_thumbnail')) :
    function elessi_loop_product_content_thumbnail() {
        global $nasa_opt, $product;
        
        /**
         * Hover effect products in grid
         */
        $nasa_animated_products = isset($nasa_opt['animated_products']) && $nasa_opt['animated_products'] ? $nasa_opt['animated_products'] : '';
        
        $nasa_link = $product->get_permalink(); // permalink
        $nasa_title = $product->get_name(); // Title
        $attachment_ids = false;
        $sizeLoad = 'shop_catalog';
        
        $backImageMobile = isset($nasa_opt['mobile_back_image']) && $nasa_opt['mobile_back_image'] ? true : false;
        
        /**
         * Mobile detect
         */
        if (
            !in_array($nasa_animated_products, array('', 'hover-zoom', 'hover-to-top')) && 
            (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile'] || ($nasa_opt['nasa_in_mobile'] && $backImageMobile))
        ) {
            $attachment_ids = $product->get_gallery_image_ids();
        }
        
        $image_size = apply_filters('single_product_archive_thumbnail_size', $sizeLoad);
        $main_img = $product->get_image($image_size);
        
        $class_wrap = 'product-img';
        if (!$attachment_ids && !in_array($nasa_animated_products, array('hover-zoom', 'hover-to-top'))) {
            $class_wrap .= ' nasa-no-effect';
        }
        
        $class_wrap .= defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT ? ' nasa-ajax-call' : '';
        ?>
        <a class="<?php echo esc_attr($class_wrap); ?>" href="<?php echo esc_url($nasa_link); ?>" title="<?php echo esc_attr($nasa_title); ?>">
            <div class="main-img">
                <?php echo $main_img; ?>
            </div>

            <?php
            /**
             * Back image
             */
            if ($attachment_ids) :
                foreach ($attachment_ids as $attachment_id) :
                    printf('<div class="back-img back">%s</div>', wp_get_attachment_image($attachment_id, $image_size));
                    break;
                endforeach;
            endif; ?>
        </a>
    <?php
    }
endif;

/**
 * Ajax Single Product Page
 */
if (!function_exists('elessi_ajax_single_product_tag')) :
    function elessi_ajax_single_product_tag() {
        global $nasa_opt;
        
        echo defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT ? '<div id="nasa-single-product-ajax" class="hidden-tag"></div>' : '';
    }
endif;

/**
 * Buttons in content product
 */
if (!function_exists('elessi_loop_product_content_btns')) :
    function elessi_loop_product_content_btns() {
        echo '<div class="nasa-product-grid nasa-group-btns nasa-btns-product-item">';
        echo elessi_product_group_button('popup');
        echo '</div>';
    }
endif;

/**
 * Categories in content product
 */
if (!function_exists('elessi_loop_product_cats')) :
    function elessi_loop_product_cats($cat_info = true) {
        if (!$cat_info) {
            return;
        }
        
        global $product;
        
        echo '<div class="nasa-list-category hidden-tag">';
        echo wc_get_product_category_list($product->get_id(), ', ');
        echo '</div>';
    }
endif;

/**
 * Title in content product
 */
if (!function_exists('elessi_loop_product_content_title')) :
    function elessi_loop_product_content_title() {
        global $product, $nasa_opt;
        
        $nasa_link = $product->get_permalink(); // permalink
        $nasa_title = $product->get_name(); // Title
        $class_title = 'name';
        $class_title .= (!isset($nasa_opt['cutting_product_name']) || $nasa_opt['cutting_product_name']) ? ' nasa-show-one-line' : '';
        
        $class_title .= defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT ? ' nasa-ajax-call' : '';
        ?>
        
        <a class="<?php echo esc_attr($class_title); ?>" href="<?php echo esc_url($nasa_link); ?>" title="<?php echo esc_attr($nasa_title); ?>">
            <?php echo $nasa_title; ?>
        </a>
    <?php
    }
endif;

/**
 * Description in content product
 */
if (!function_exists('elessi_loop_product_description')) :
    function elessi_loop_product_description($desc_info = true) {
        if (!$desc_info) {
            return;
        }
        
        global $post;
        
        $short_desc = apply_filters('woocommerce_short_description', $post->post_excerpt);
        
        echo $short_desc ? '<div class="info_main product-des-wrap product-des">' . $short_desc . '</div>' : '';
    }
endif;

/**
 * nasa product budles in quickview
 */
if (!function_exists('elessi_combo_in_quickview')) :
    function elessi_combo_in_quickview() {
        global $woocommerce, $nasa_opt, $product;

        if (!$woocommerce || !$product || $product->get_type() != NASA_COMBO_TYPE || !($combo = $product->get_bundled_items())) {
            echo '';
        }
        else {
            $file = ELESSI_CHILD_PATH . '/includes/nasa-combo-products-quickview.php';
            $file = is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-combo-products-quickview.php';

            include $file;
        }
    }
endif;

/**
 * Top side bar shop
 */
if (!function_exists('elessi_top_sidebar_shop')) :
    function elessi_top_sidebar_shop($type = '') {
        $type_top = !$type ? '1' : $type;
        $class = 'nasa-relative hidden-tag';
        $class .= $type_top == '1' ? ' large-12 columns nasa-top-sidebar' : ' nasa-top-sidebar-' . $type_top;
        
        $attributes = '';
        if ($type_top == '2') {
            $attributes .= ' data-columns="' . apply_filters('nasa_top_bar_2_cols', '4') . '"';
            $attributes .= ' data-columns-small="' . apply_filters('nasa_top_bar_2_cols_small', '2') . '"';
            $attributes .= ' data-columns-tablet="' . apply_filters('nasa_top_bar_2_cols_medium', '3') . '"';
            $attributes .= ' data-switch-tablet="' . elessi_switch_tablet() . '"';
            $attributes .= ' data-switch-desktop="' . elessi_switch_desktop() . '"';
        }
        
        $sidebar_run = 'shop-sidebar';
        
        if (is_tax('product_cat')) {
            global $wp_query;
            $query_obj = $wp_query->get_queried_object();
            $sidebar_cats = get_option('nasa_sidebars_cats');
            
            if (isset($sidebar_cats[$query_obj->slug])) {
                $sidebar_run = $query_obj->slug;
            }
            else {
                global $nasa_root_term_id;
                
                if (!$nasa_root_term_id) {
                    $ancestors = get_ancestors($query_obj->term_id, 'product_cat');
                    $nasa_root_term_id = $ancestors ? end($ancestors) : 0;
                }
                
                if ($nasa_root_term_id) {
                    $GLOBALS['nasa_root_term_id'] = $nasa_root_term_id;
                    $rootTerm = get_term_by('term_id', $nasa_root_term_id, 'product_cat');
                    if ($rootTerm && isset($sidebar_cats[$rootTerm->slug])) {
                        $sidebar_run = $rootTerm->slug;
                    }
                }
            }
        } ?>

        <div class="<?php echo esc_attr($class); ?>"<?php echo $attributes; ?>>
            <?php if ($type_top == '1') : ?>
                <span class="nasa-close-sidebar-wrap hidden-tag">
                    <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'elessi-theme'); ?>" class="hidden-tag nasa-close-sidebar" rel="nofollow"><?php echo esc_html__('Close', 'elessi-theme'); ?></a>
                </span>
            <?php endif; ?>
            <?php
            if (is_active_sidebar($sidebar_run)) :
                dynamic_sidebar($sidebar_run);
            endif;
            ?>
        </div>
    <?php
    }
endif;

/**
 * Side bar shop
 */
if (!function_exists('elessi_side_sidebar_shop')) :
    function elessi_side_sidebar_shop($nasa_sidebar = 'left') {
        $sidebar_run = 'shop-sidebar';
        if (is_tax('product_cat')) {
            global $wp_query;
            $query_obj = $wp_query->get_queried_object();
            $sidebar_cats = get_option('nasa_sidebars_cats');
            
            if (isset($sidebar_cats[$query_obj->slug])) {
                $sidebar_run = $query_obj->slug;
            }
            
            else {
                global $nasa_root_term_id;
                
                if (!$nasa_root_term_id) {
                    $ancestors = get_ancestors($query_obj->term_id, 'product_cat');
                    $nasa_root_term_id = $ancestors ? end($ancestors) : 0;
                }
                
                if ($nasa_root_term_id) {
                    $GLOBALS['nasa_root_term_id'] = $nasa_root_term_id;
                    $rootTerm = get_term_by('term_id', $nasa_root_term_id, 'product_cat');
                    if ($rootTerm && isset($sidebar_cats[$rootTerm->slug])) {
                        $sidebar_run = $rootTerm->slug;
                    }
                }
            }
        }
        
        switch ($nasa_sidebar) :
            case 'right' :
                $class = 'nasa-side-sidebar nasa-sidebar-right';
                break;
            
            case 'left-classic' :
                $class = 'large-3 left columns col-sidebar';
                break;
            
            case 'right-classic' :
                $class = 'large-3 right columns col-sidebar';
                break;
            
            case 'left' :
            default:
                $class = 'nasa-side-sidebar nasa-sidebar-left';
                break;
        endswitch;
        ?>
        
        <div class="<?php echo esc_attr($class); ?>">
            <?php if (is_active_sidebar($sidebar_run)) : ?>
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'elessi-theme'); ?>" class="hidden-tag nasa-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'elessi-theme'); ?>
                </a>
                <div class="nasa-sidebar-off-canvas">
                    <?php dynamic_sidebar($sidebar_run); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php
    }
endif;

/**
 * Sale flash | Badges
 */
if (!function_exists('elessi_add_custom_sale_flash')) :
    function elessi_add_custom_sale_flash() {
        global $nasa_opt, $product;
        
        $badges = '';
        
        /**
         * Featured
         */
        if (isset($nasa_opt['featured_badge']) && $nasa_opt['featured_badge'] && $product->is_featured()):
            $badges .= '<span class="badge featured-label">' . esc_html__('Featured', 'elessi-theme') . '</span>';
        endif;

        /**
         * On Sale Badge
         */
        if ($product->is_on_sale()) :
            global $post;
            
            /**
             * Sale
             */
            $product_type = $product->get_type();
            $badges_sale = '';
            if ($product_type == 'variable') :
                $badges_sale = '<span class="badge sale-label sale-variable">' . esc_html__('Sale', 'elessi-theme') . '</span>';
                
            else :
                $maximumper = 0;
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                if (is_numeric($sale_price)) :
                    $percentage = $regular_price ? round(((($regular_price - $sale_price) / $regular_price) * 100), 0) : 0;
                    if ($percentage > $maximumper) :
                        $maximumper = $percentage;
                    endif;
                    
                    $badges_sale = '<span class="badge sale-label">' . sprintf(esc_html__('&#45;%s&#37;', 'elessi-theme'), $maximumper) . '</span>';
                endif;
            endif;
            
            /**
             * Hook onsale WooCommerce
             */
            $badges .= apply_filters('woocommerce_sale_flash', $badges_sale, $post, $product);
            
            /**
             * Style show with Deal product
             */
            $badges .= '<span class="badge deal-label">' . esc_html__('Limited', 'elessi-theme') . '</span>';
        endif;
        
        /**
         * Out of stock
         */
        $stock_status = $product->get_stock_status();
        if ($stock_status == "outofstock"):
            $badges_outofstock = '<span class="badge out-of-stock-label">' . esc_html__('Sold Out', 'elessi-theme') . '</span>';
            $badges .= apply_filters('nasa_badge_outofstock', $badges_outofstock);
        endif;
        
        $badges_content = apply_filters('nasa_badges', $badges);
        
        echo ('' !== $badges_content) ? '<div class="nasa-badges-wrap">' . $badges_content . '</div>' : '';
    }
endif;

/**
 * Change View
 */
if (!function_exists('elessi_nasa_change_view')) :
    function elessi_nasa_change_view($nasa_change_view = true, $typeShow = 'grid-4', $nasa_sidebar = 'no') {
        global $nasa_opt;
        
        if (!$nasa_change_view) :
            return;
        endif;
        
        $classic = in_array($nasa_sidebar, array('left-classic', 'right-classic', 'top-push-cat'));
        echo ($classic) ? '<input type="hidden" name="nasa-data-sidebar" value="' . esc_attr($nasa_sidebar) . '" />' : '';
        $col_2 = isset($nasa_opt['option_2_cols']) && $nasa_opt['option_2_cols'] ? true : false;
        $col_6 = isset($nasa_opt['option_6_cols']) && $nasa_opt['option_6_cols'] ? true : false;
        $class_wrap = 'filter-tabs nasa-change-view';
        $number_view = $col_2 || $col_6 ? true : false;
        $class_wrap .= $number_view ? ' nasa-show-number' : '';
        
        $list_view = isset($nasa_opt['products_layout_style']) && $nasa_opt['products_layout_style'] == 'masonry-isotope' ? false : true;
        ?>
        <ul class="<?php echo $class_wrap; ?>">
            <?php if ($number_view) : ?>
                <li class="nasa-label-change-view">
                    <span class="nasa-text-number hidden-tag nasa-bold-700">
                        <?php echo esc_html__('See', 'elessi-theme'); ?>
                    </span>
                </li>
            <?php endif; ?>
            <?php if (isset($nasa_opt['option_6_cols']) && $nasa_opt['option_6_cols']) : ?>
                <li class="nasa-change-layout productGrid grid-6<?php echo ($typeShow == 'grid-6') ? ' active' : ''; ?>" data-columns="6">
                    <span class="nasa-text-number hidden-tag">
                        <?php echo esc_html__('6', 'elessi-theme'); ?>
                    </span>
                </li>
            <?php endif; ?>
            
            <li class="nasa-change-layout productGrid grid-5<?php echo ($typeShow == 'grid-5') ? ' active' : ''; ?>" data-columns="5">
                <?php if ($number_view) : ?>
                    <span class="nasa-text-number hidden-tag">
                        <?php echo esc_html__('5', 'elessi-theme'); ?>
                    </span>
                <?php endif; ?>
                
                <i class="icon-nasa-5column"></i>
            </li>
            
            <li class="nasa-change-layout productGrid grid-4<?php echo ($typeShow == 'grid-4') ? ' active' : ''; ?>" data-columns="4">
                <?php if ($number_view) : ?>
                    <span class="nasa-text-number hidden-tag">
                        <?php echo esc_html__('4', 'elessi-theme'); ?>
                    </span>
                <?php endif; ?>
                
                <i class="icon-nasa-4column"></i>
            </li>
            
            <li class="nasa-change-layout productGrid grid-3<?php echo ($typeShow == 'grid-3') ? ' active' : ''; ?>" data-columns="3">
                <?php if ($number_view) : ?>
                    <span class="nasa-text-number hidden-tag">
                        <?php echo esc_html__('3', 'elessi-theme'); ?>
                    </span>
                <?php endif; ?>
                
                <i class="icon-nasa-3column"></i>
            </li>
            
            <?php if (isset($nasa_opt['option_2_cols']) && $nasa_opt['option_2_cols']) : ?>
                <li class="nasa-change-layout productGrid grid-2<?php echo ($typeShow == 'grid-2') ? ' active' : ''; ?>" data-columns="2">
                    <?php if ($number_view) : ?>
                        <span class="nasa-text-number hidden-tag">
                            <?php echo esc_html__('2', 'elessi-theme'); ?>
                        </span>
                    <?php endif; ?>
                    
                    <i class="icon-nasa-2column"></i>
                </li>
            <?php endif; ?>
            
            <?php if ($list_view) : ?>
                <li class="nasa-change-layout productList list<?php echo ($typeShow == 'list') ? ' active' : ''; ?>" data-columns="1">
                    <?php if ($number_view) : ?>
                        <span class="nasa-text-number hidden-tag">
                            <?php echo esc_html__('List', 'elessi-theme'); ?>
                        </span>
                    <?php endif; ?>

                    <i class="icon-nasa-list"></i>
                </li>
            <?php endif; ?>
        </ul>
        <?php
        
        /**
         * Grid - List view cookie name
         */
        $grid_cookie_name = 'archive_grid_view';
        $siteurl = get_option('siteurl');
        $grid_cookie_name .= $siteurl ? '_' . md5($siteurl) : '';
        echo '<input type="hidden" name="nasa_archive_grid_view" value="' . esc_attr($grid_cookie_name) . '" />';
    }
endif;

/**
 * Single Product Layout
 */
if (!function_exists('elessi_single_product_layout')) :
    function elessi_single_product_layout() {
        global $product, $nasa_opt;

        /**
         * Layout: New | Classic
         */
        $nasa_opt['product_detail_layout'] = isset($nasa_opt['product_detail_layout']) && in_array($nasa_opt['product_detail_layout'], array('new', 'classic', 'full')) ? $nasa_opt['product_detail_layout'] : 'new';
        
        $nasa_opt['product_thumbs_style'] = isset($nasa_opt['product_thumbs_style']) && $nasa_opt['product_thumbs_style'] == 'hoz' ? $nasa_opt['product_thumbs_style'] : 'ver';

        /**
         * Image Layout Style
         */
        $image_layout = 'single';
        $image_style = 'slide';
        if ($nasa_opt['product_detail_layout'] == 'new') {
            $image_layout = (!isset($nasa_opt['product_image_layout']) || $nasa_opt['product_image_layout'] == 'double') ? 'double' : 'single';
            $image_style = (!isset($nasa_opt['product_image_style']) || $nasa_opt['product_image_style'] == 'slide') ? 'slide' : 'scroll';
        }
        
        $nasa_opt['product_image_layout'] = $image_layout;
        $nasa_opt['product_image_style'] = $image_style;
        
        $nasa_sidebar = isset($nasa_opt['product_sidebar']) ? $nasa_opt['product_sidebar'] : 'no';
        
        /**
         * Override with single product options
         */
        $productId = $product->get_id();
        $single_layout = elessi_get_product_meta_value($productId, 'nasa_layout');
        $single_imageLayouts = elessi_get_product_meta_value($productId, 'nasa_image_layout');
        $single_imageStyle = elessi_get_product_meta_value($productId, 'nasa_image_style');
        $single_thumbStyle = elessi_get_product_meta_value($productId, 'nasa_thumb_style');
        
        if ($single_layout) {
            if (in_array($single_layout, array('new', 'classic', 'full'))) {
                $nasa_opt['product_detail_layout'] = $single_layout;
            }
            
            if ($single_layout == 'new') {
                $nasa_opt['product_image_layout'] = $single_imageLayouts ? $single_imageLayouts : $nasa_opt['product_image_layout'];
                
                $nasa_opt['product_image_style'] = $single_imageStyle ? $single_imageStyle : $nasa_opt['product_image_style'];
            }

            if ($single_layout == 'classic') {
                $nasa_opt['product_image_style'] = 'slide';
                $nasa_opt['product_thumbs_style'] = $single_thumbStyle ? $single_thumbStyle : $nasa_opt['product_thumbs_style'];
            }

            if ($single_layout == 'full') {
                $nasa_opt['product_image_style'] = 'slide';
            }

            $GLOBALS['nasa_opt'] = $nasa_opt;
        } else {
            /**
             * Override with root Category
             */
            $rootCatId = elessi_get_root_term_id();
            if ($rootCatId) {
                $_product_layout = get_term_meta($rootCatId, 'single_product_layout', true);

                if (in_array($_product_layout, array('new', 'classic', 'full'))) {
                    $nasa_opt['product_detail_layout'] = $_product_layout;
                }

                if ($_product_layout == 'new') {
                    $product_image_layout = get_term_meta($rootCatId, 'single_product_image_layout', true);
                    $nasa_opt['product_image_layout'] = $product_image_layout ? $product_image_layout : $nasa_opt['product_image_layout'];

                    $product_image_style = get_term_meta($rootCatId, 'single_product_image_style', true);
                    $nasa_opt['product_image_style'] = $product_image_style ? $product_image_style : $nasa_opt['product_image_style'];
                }

                if ($_product_layout == 'classic') {
                    $nasa_opt['product_image_style'] = 'slide';

                    $product_thumbs_style = get_term_meta($rootCatId, 'single_product_thumbs_style', true);
                    $nasa_opt['product_thumbs_style'] = $product_thumbs_style ? $product_thumbs_style : $nasa_opt['product_thumbs_style'];
                }

                if ($_product_layout == 'full') {
                    $nasa_opt['product_image_style'] = 'slide';
                }

                $GLOBALS['nasa_opt'] = $nasa_opt;
            }
        }
        
        $in_mobile = false;
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] && isset($nasa_opt['single_product_mobile']) && $nasa_opt['single_product_mobile']) {
            $nasa_actsidebar = false;
            $in_mobile = true;
        } else {
            $nasa_actsidebar = is_active_sidebar('product-sidebar');
        }

        // Class
        switch ($nasa_sidebar) :
            case 'right' :
                if ($nasa_opt['product_detail_layout'] == 'classic') {
                    $main_class = 'large-9 columns left';
                    $bar_class = 'large-3 columns col-sidebar desktop-padding-left-20 product-sidebar-right right';
                }
                else {
                    $main_class = '';
                    $bar_class = 'nasa-side-sidebar nasa-sidebar-right';
                }

                break;

            case 'no' :
                $main_class = $nasa_opt['product_detail_layout'] == 'classic' ? 'large-12 columns' : '';
                $bar_class = '';
                break;

            default:
            case 'left' :
                if ($nasa_opt['product_detail_layout'] == 'classic') {
                    $main_class = 'large-9 columns right';
                    $bar_class = 'large-3 columns col-sidebar desktop-padding-right-20 product-sidebar-left left';
                } 
                else {
                    $main_class = '';
                    $bar_class = 'nasa-side-sidebar nasa-sidebar-left';
                }

                break;

        endswitch;
        
        $main_class .= $main_class != '' ? ' ' : '';
        $main_class .= 'nasa-single-product-' . $nasa_opt['product_image_style'];
        $main_class .= $nasa_opt['product_image_style'] == 'scroll' && $nasa_opt['product_image_layout'] == 'double' ? ' nasa-single-product-2-columns': '';
        
        $main_class .= $in_mobile ? ' nasa-single-product-in-mobile' : '';
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-single-product-' . $nasa_opt['product_detail_layout'] . '.php';
        
        include_once is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-single-product-' . $nasa_opt['product_detail_layout'] . '.php';
    }
endif;

/**
 * Custom Tabs
 */
function elessi_custom_tabs_single_product($tabs) {
    global $nasa_opt;
    
    /**
     * Remove Additional tab
     */
    if (
        isset($tabs['additional_information']) &&
        isset($nasa_opt['hide_additional_tab']) &&
        $nasa_opt['hide_additional_tab']
    ) {
        unset($tabs['additional_information']);
    }
    
    return $tabs;
}

/**
 * Hide Uncategorized
 */
if (!function_exists('elessi_hide_uncategorized')) :
    function elessi_hide_uncategorized($args) {
        $args['exclude'] = get_option('default_product_cat');
        return $args;
    }
endif;

/**
 * Before Share WooCommerce
 */
if (!function_exists('elessi_before_woocommerce_share')) :
    function elessi_before_woocommerce_share() {
        echo '<hr class="nasa-single-hr" /><div class="nasa-single-share">';
    }
endif;

/**
 * Custom Share WooCommerce
 */
if (!function_exists('elessi_woocommerce_share')) :
    function elessi_woocommerce_share() {
        echo shortcode_exists('nasa_share') ? do_shortcode('[nasa_share label="1"]') : '';
    }
endif;

/**
 * After Share WooCommerce
 */
if (!function_exists('elessi_after_woocommerce_share')) :
    function elessi_after_woocommerce_share() {
        echo '</div>';
    }
endif;

/**
 * Before desc of Archive
 */
if (!function_exists('elessi_before_archive_description')) :
    function elessi_before_archive_description() {
        echo '<div class="nasa_shop_description page-description padding-top-20">';
    }
endif;

/**
 * After desc of Archive
 */
if (!function_exists('elessi_after_archive_description')) :
    function elessi_after_archive_description() {
        echo '</div>';
    }
endif;

/**
 * Open wrap 12 columns
 */
if (!function_exists('elessi_open_wrap_12_cols')) :
    function elessi_open_wrap_12_cols() {
        echo '<div class="row"><div class="large-12 columns">';
    }
endif;

/**
 * Close wrap 12 columns
 */
if (!function_exists('elessi_close_wrap_12_cols')) :
    function elessi_close_wrap_12_cols() {
        echo '</div></div>';
    }
endif;

/**
 * shopping cart subtotal
 */
if (!function_exists('elessi_widget_shopping_cart_subtotal')) :
    function elessi_widget_shopping_cart_subtotal() {
        echo '<span class="total-price-label">' . esc_html__('Subtotal', 'elessi-theme') . '</span>';
        echo '<span class="total-price right">' . WC()->cart->get_cart_subtotal() . '</span>';
    }
endif;

/**
 * elessi_wc_form_field_args
 */
if (!function_exists('elessi_wc_form_field_args')) :
    function elessi_wc_form_field_args($args) {
        if (isset($args['label']) && (!isset($args['placeholder']) || $args['placeholder'] == '')) {
            $args['placeholder'] = $args['label'];
        }
    
        return $args;
    }
endif;

/**
 * Hook woocommerce_before_main_content
 */
if (!function_exists('elessi_open_woo_main')) :
    function elessi_open_woo_main() {
        global $nasa_opt;

        $class = 'nasa-ajax-store-content';
        $class .= !isset($nasa_opt['crazy_load']) || $nasa_opt['crazy_load'] ? ' nasa-crazy-load crazy-loading' : '';

        echo '<!-- Begin Ajax Store Wrap --><div class="nasa-ajax-store-wrapper"><div id="nasa-ajax-store" class="' . $class . '">';
        
        if (!isset($nasa_opt['disable_ajax_product_progress_bar']) || $nasa_opt['disable_ajax_product_progress_bar'] != 1) :
            echo '<div class="nasa-progress-bar-load-shop"><div class="nasa-progress-per"></div></div>';
        endif;
        
        /**
         * For Ajax in Single Product Page
         */
        if (defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT) :
            wp_enqueue_script('wc-add-to-cart-variation');
        endif;
    }
endif;

/**
 * Hook woocommerce_after_main_content
 */
if (!function_exists('elessi_close_woo_main')) :
    function elessi_close_woo_main() {
        echo '</div></div><!-- End Ajax Store Wrap -->';
    }
endif;
