<?php
/**
 * Since 1.6.5
 */
defined('ABSPATH') or die(); // Exit if accessed directly

if (class_exists('WC_AJAX')) :
    class ELESSI_WC_AJAX extends WC_AJAX {

        /**
         * Hook in ajax handlers.
         */
        public static function nasa_init() {
            add_action('init', array(__CLASS__, 'define_ajax'), 0);
            add_action('template_redirect', array(__CLASS__, 'do_wc_ajax'), 0);
            
            self::nasa_add_ajax_events();
        }

        /**
         * Hook in methods - uses WordPress ajax handlers (admin-ajax).
         */
        public static function nasa_add_ajax_events() {
            /**
             * Register ajax event
             */
            $ajax_events = array(
                'nasa_ajax_static_content',
                'nasa_quick_view',
                'nasa_quickview_gallery_variation',
                'nasa_get_gallery_variation',
                'nasa_get_deal_variation',
                'nasa_single_add_to_cart',
                'nasa_combo_products',
                'nasa_load_compare',
                'nasa_add_compare_product',
                'nasa_remove_compare_product',
                'nasa_remove_all_compare',
                'nasa_reload_fragments',
                'nasa_after_add_to_cart',
                'nasa_load_wishlist',
                'nasa_add_to_wishlist',
                'nasa_remove_from_wishlist',
                'nasa_remove_wishlist_hidden',
                'nasa_search_products',
                'nasa_quantity_mini_cart'
            );

            foreach ($ajax_events as $ajax_event) {
                add_action('wp_ajax_woocommerce_' . $ajax_event, array(__CLASS__, $ajax_event));
                add_action('wp_ajax_nopriv_woocommerce_' . $ajax_event, array(__CLASS__, $ajax_event));

                // WC AJAX can be used for frontend ajax requests.
                add_action('wc_ajax_' . $ajax_event, array(__CLASS__, $ajax_event));
            }
        }
        
        /**
         * Init WPBakery shortcodes
         */
        protected static function init_wpb_shortcodes() {
            if (class_exists('WPBMap')) {
                WPBMap::addAllMappedShortcodes();
            }
        }

        /**
	 * Reload a refreshed cart fragment, including the mini cart HTML.
	 */
	public static function nasa_reload_fragments() {
            self::get_refreshed_fragments();
	}

        /**
         * Static content
         * 
         * @global type $nasa_opt
         */
        public static function nasa_ajax_static_content() {
            $data = array('success' => '', 'content' => array());
            
            if (isset($_REQUEST['reload_yith_wishlist']) && $_REQUEST['reload_yith_wishlist']) {
                $yith_wishlist = true;
            }
            
            if (NASA_WISHLIST_ENABLE && $yith_wishlist) {
                $data['content']['#nasa-wishlist-sidebar-content'] = elessi_mini_wishlist_sidebar(true);
            }

            if (defined('NASA_PLG_CACHE_ACTIVE') && NASA_PLG_CACHE_ACTIVE) {
                if (NASA_WISHLIST_ENABLE && $yith_wishlist) {
                    $data['content']['.nasa-wishlist-count.wishlist-number'] = elessi_get_count_wishlist();
                }
            }
            
            // Reload logged in / out
            if (
                (NASA_CORE_USER_LOGGED && isset($_REQUEST['reload_my_account']) && $_REQUEST['reload_my_account']) ||
                (!NASA_CORE_USER_LOGGED && isset($_REQUEST['reload_login_register']) && $_REQUEST['reload_login_register'])) {
                $data['content']['.nasa-menus-account'] = elessi_tiny_account(true);
            }
            
            if (!empty($data['content'])) {
                $data['success'] = '1';
            }

            wp_send_json($data);
        }

        /**
         * Get a refreshed cart fragment, including the mini cart HTML.
         */
        public static function nasa_quick_view() {
            global $nasa_opt;
            
            $result = array(
                'content' => ''
            );

            if (isset($_REQUEST["product"])) {
                $qv_content = false;
                
                $style_quickview = isset($nasa_opt['style_quickview']) && in_array($nasa_opt['style_quickview'], array('sidebar', 'popup')) ? $nasa_opt['style_quickview'] : 'sidebar';
                
                $prod_id = intval($_REQUEST["product"]);
                $prod_id_org = $prod_id;
                $key_cache = false;
                if (function_exists('nasa_get_cache')) {
                    $currency = function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : null;
                    if ($currency) {
                        $key_cache = $prod_id_org  . '_' . $style_quickview . '_' . $currency;
                        $qv_content = nasa_get_cache($key_cache, 'nasa-quickview');
                    }
                }
                
                if (!$qv_content) {
                    global $product, $post;

                    self::init_wpb_shortcodes();
                    $post_object = get_post($prod_id);
                    setup_postdata($GLOBALS['post'] =& $post_object);

                    $GLOBALS['product'] = wc_get_product($prod_id);
                    $product_lightbox = $GLOBALS['product'];

                    if ($product_lightbox) {
                        $product_type = $product_lightbox->get_type();

                        if ($product_type == 'variation') {
                            $variation_data = wc_get_product_variation_attributes($prod_id);
                            $prod_id = wp_get_post_parent_id($prod_id);

                            $post_object = get_post($prod_id);
                            setup_postdata($GLOBALS['post'] =& $post_object);

                            $GLOBALS['product'] = wc_get_product($prod_id);

                            if (!empty($variation_data)) {
                                foreach ($variation_data as $key => $value) {
                                    if ($value != '') {
                                        $_REQUEST[$key] = $value;
                                    }
                                }
                            }
                        } 

                        if ($product_type == 'grouped') {
                            $GLOBALS['product_lightbox'] = $product_lightbox;
                        }

                        $file = ELESSI_CHILD_PATH . '/includes/nasa-single-product-lightbox.php';
                        ob_start();
                        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-single-product-lightbox.php';

                        $qv_content = ob_get_clean();
                        
                        if (function_exists('nasa_set_cache') && $key_cache) {
                            nasa_set_cache($key_cache, 'nasa-quickview', $qv_content);
                        }
                    }
                }
                
                $result['content'] = $qv_content;
            }

            wp_send_json($result);
        }

        /**
         * Quick view gallery variation
         */
        public static function nasa_quickview_gallery_variation() {
            $data = isset($_REQUEST['data']) ? $_REQUEST['data'] : array();

            if (!isset($data['variation_id'])) {
                die;
            }

            $productId = $data['variation_id'];

            $main_id = isset($data['main_id']) && (int) $data['main_id'] ? (int) $data['main_id'] : 0;
            $image_large = $main_id ? wp_get_attachment_image_src($main_id, 'shop_single') : null;
            $src_large = isset($image_large[0]) ? $image_large[0] : null;
            $imageMain = $src_large ? '<img src="' . esc_url($src_large) . '" />' : '';
            $hasThumb = (bool) $imageMain;

            $attachment_ids = array();
            if (isset($data['gallery'])) {
                $attachments = $data['gallery'] ? explode(',', $data['gallery']) : array();

                if ($attachments) {
                    foreach ($attachments as $img_id) {
                        $img_id = (int) trim($img_id);
                        if ($img_id) {
                            $attachment_ids[] = $img_id;
                        }
                    }
                }
            }

            $show_images = isset($data['show_images']) ? $data['show_images'] : apply_filters('nasa_quickview_number_imgs', 2);

            $result = array();

            /**
             * Main images
             */
            $file = ELESSI_CHILD_PATH . '/includes/nasa-single-product-lightbox-gallery.php';
            ob_start();
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-single-product-lightbox-gallery.php';

            $result['quickview_gallery'] = ob_get_clean();

            /**
             * Deal time
             */
            if (isset($data['is_purchasable']) && $data['is_purchasable'] && isset($data['is_in_stock']) && $data['is_in_stock']) {
                $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
                $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
                $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ?
                    false : (int) $time_to;

                if ($time_sale) {
                    $result['deal_variation'] = elessi_time_sale($time_sale);
                }
            }

            wp_send_json($result);
        }
        
        /**
         * Gallery variation
         */
        public static function nasa_get_gallery_variation() {
            $data = isset($_REQUEST['data']) ? $_REQUEST['data'] : array();

            if (!isset($data['variation_id'])) {
                die;
            }

            $productId = $data['variation_id'];

            $main_id = isset($data['main_id']) && (int) $data['main_id'] ? (int) $data['main_id'] : 0;
            $gallery_id = array();
            if (isset($data['gallery'])) {
                $attachments = $data['gallery'] ? explode(',', $data['gallery']) : array();

                if ($attachments) {
                    foreach ($attachments as $img_id) {
                        $img_id = (int) trim($img_id);
                        if ($img_id) {
                            $gallery_id[] = $img_id;
                        }
                    }
                }
            }

            $attachment_count = count($gallery_id);

            $result = array();

            /**
             * Main images
             */
            $file = ELESSI_CHILD_PATH . '/includes/nasa-variation-main-images.php';
            ob_start();
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-variation-main-images.php';

            $result['main_image'] = ob_get_clean();

            /**
             * Thumb images
             */
            $file2 = ELESSI_CHILD_PATH . '/includes/nasa-variation-thumb-images.php';
            ob_start();
            include is_file($file2) ? $file2 : ELESSI_THEME_PATH . '/includes/nasa-variation-thumb-images.php';

            $result['thumb_image'] = ob_get_clean();

            /**
             * Deal time
             */
            if (isset($data['deal_variation']) && $data['deal_variation']) {
                $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
                $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
                $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ?
                    false : (int) $time_to;

                if ($time_sale) {
                    $result['deal_variation'] = elessi_time_sale($time_sale);
                }
            }

            wp_send_json($result);
        }
        
        /**
         * Get Deal variation
         */
        public static function nasa_get_deal_variation() {
            $result = array('success' => '0');
            
            if (isset($_REQUEST["pid"])) {
                $productId = $_REQUEST["pid"];
                $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
                $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
                $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ?
                    false : (int) $time_to;

                $result['content'] = elessi_time_sale($time_sale);
                if ($result['content'] !== '') {
                    $result['success'] = '1';
                }
            }

            wp_send_json($result);
        }
        
        /**
         * validate variation
         */
        protected static function nasa_validate_variation($product, $variation_id, $variation, $quantity) {
            if (empty($variation_id) || empty($product)) {
                return array('validate' => false);
            }

            $missing_attributes = array();
            $variations         = array();
            $attributes         = $product->get_attributes();
            $variation_data     = wc_get_product_variation_attributes($variation_id);

            foreach ($attributes as $attribute) {
                if (!$attribute['is_variation']) {
                    continue;
                }

                $taxonomy = 'attribute_' . sanitize_title($attribute['name']);

                if (isset($variation[$taxonomy])) {
                    // Get value from post data
                    if ($attribute['is_taxonomy']) {
                        // Don't use wc_clean as it destroys sanitized characters
                        $value = sanitize_title(stripslashes($variation[$taxonomy]));
                    } else {
                        $value = wc_clean(stripslashes($variation[$taxonomy]));
                    }
                    
                    if (trim($value) == '') {
                        $missing_attributes[] = wc_attribute_label($attribute['name']);
                    } else {
                        // Get valid value from variation
                        $valid_value = isset($variation_data[$taxonomy]) ? $variation_data[$taxonomy] : '';

                        // Allow if valid or show error.
                        if ($valid_value === $value || (in_array($value, $attribute->get_slugs()))) {
                            $variations[$taxonomy] = $value;
                        } else {
                            return array('validate' => false);
                        }
                    }
                } else {
                    $missing_attributes[] = wc_attribute_label($attribute['name']);
                }
            }
            
            if (!empty($missing_attributes)) {
                return array(
                    'validate' => false,
                    'missing_attributes' => $missing_attributes
                );
            }

            $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product->get_id(), $quantity, $variation_id, $variations);

            return array(
                'validate' => $passed_validation
            );
        }

        /**
         * Single add to cart | Quick view add to cart
         */
        public static function nasa_single_add_to_cart() {
            /**
             * Clear Old Notices
             */
            wc_clear_notices();
            
            /**
             * Add to cart in single
             */
            if (isset($_REQUEST['add-to-cart']) && is_numeric(wp_unslash($_REQUEST['add-to-cart']))) {
                $error = (0 === wc_notice_count('error')) ? false : true;
                $product_id = wp_unslash($_REQUEST['add-to-cart']);
                
                /**
                 * Error Add to Cart
                 */
                if ($error) {
                    $data = array(
                        'error' => $error,
                        'message' => wc_print_notices(true),
                        'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
                    );
                }
                
                /**
                 * Added product success
                 */
                else {
                    // Return fragments
                    ob_start();
                    woocommerce_mini_cart();
                    $mini_cart = ob_get_clean();
                    
                    $woo_mess = wc_print_notices(true);
                    $woo_mess = empty($woo_mess) ? '<div class="woocommerce-message text-center" role="alert">' . esc_html__('Product added to cart successfully!', 'elessi-theme') . '</div>' : $woo_mess;

                    // Fragments and mini cart are returned
                    $data = array(
                        'fragments' => apply_filters(
                            'woocommerce_add_to_cart_fragments',
                            array(
                                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
                                '.woocommerce-message' => $woo_mess
                            )
                        ),
                        'cart_hash' => WC()->cart->get_cart_hash()
                    );
                }
                
                wp_send_json($data);
            }
            
            /**
             * Add to cart in Loop
             */
            else {
                if (!isset($_REQUEST['product_id']) || !is_numeric(wp_unslash($_REQUEST['product_id']))){
                    wc_add_notice(esc_html__('Sorry, Product is not existing.', 'elessi-theme'), 'error');
                    wp_send_json(array(
                        'error' => true,
                        'message' => wc_print_notices(true)
                    ));

                    wp_die();
                }

                $error      = false;
                $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_REQUEST['product_id']));
                $quantity   = empty($_REQUEST['quantity']) ? 1 : wc_stock_amount($_REQUEST['quantity']);
                $type       = (!isset($_REQUEST['product_type']) || !in_array($_REQUEST['product_type'], array('simple', 'variation', 'variable'))) ? false : $_REQUEST['product_type'];
                
                if (!$type) {
                    wc_add_notice(esc_html__('Sorry, Product is not existing.', 'elessi-theme'), 'error');
                    wp_send_json(array(
                        'error' => true,
                        'message' => wc_print_notices(true)
                    ));

                    wp_die();
                }

                $variation = isset($_REQUEST['variation']) ? $_REQUEST['variation'] : array();
                $validate_attr = array('validate' => true);
                if ($type == 'variation') {
                    if (!isset($_REQUEST['variation_id']) || !$_REQUEST['variation_id']) {
                        $variation_id = $product_id;
                        $product_id = wp_get_post_parent_id($product_id);
                        $type = 'variable';
                    } else {
                        $variation_id = (int) $_REQUEST['variation_id'];
                    }
                }

                $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
                $product_status    = get_post_status($product_id);

                $product = wc_get_product((int) $product_id);
                $product_type = false;

                if (!$product) {
                    $error = true;
                } else {
                    $product_type = $product->get_type();
                    if ((!$variation || !$variation_id) && $product_type == 'variable'){
                        $error = true;
                    }

                    if (!$error && $product_type == 'variable') {
                        $validate_attr = self::nasa_validate_variation($product, $variation_id, $variation, $quantity);
                    }
                }

                if (!$error && $validate_attr['validate'] && $passed_validation && 'publish' === $product_status && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation)) {

                    do_action('woocommerce_ajax_added_to_cart', $product_id);

                    if ('yes' !== get_option('woocommerce_cart_redirect_after_add')) {
                        // Return fragments
                        ob_start();
                        woocommerce_mini_cart();
                        $mini_cart = ob_get_clean();

                        // Fragments and mini cart are returned
                        $data = array(
                            'fragments' => apply_filters(
                                'woocommerce_add_to_cart_fragments',
                                array(
                                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
                                )
                            ),
                            'cart_hash' => WC()->cart->get_cart_hash()
                        );
                    } else {
                        wc_add_to_cart_message(array($product_id => $quantity), true);
                        $data = array(
                            'redirect' => wc_get_cart_url()
                        );
                    }

                    // Remove wishlist
                    if (NASA_WISHLIST_ENABLE && $product_type && $product_type != 'external' && get_option('yith_wcwl_remove_after_add_to_cart') == 'yes') {
                        $nasa_logined_id = get_current_user_id();
                        $detail = isset($_REQUEST['data_wislist']) ? $_REQUEST['data_wislist'] : array();
                        if (!empty($detail) && isset($detail['from_wishlist']) && $detail['from_wishlist'] == '1') {
                            $detail['remove_from_wishlist'] = $product_id;
                            $detail['user_id'] = $nasa_logined_id;

                            $data['wishlist'] = '';
                            $data['wishlistcount'] = 0;

                            /**
                             * WCWL 2.x or Lower
                             */
                            if (!NASA_WISHLIST_NEW_VER) {
                                if ($nasa_logined_id) {
                                    $nasa_wishlist = new YITH_WCWL($detail);
                                    if (elessi_remove_wishlist_item($nasa_wishlist)) {
                                        $data['wishlist'] = elessi_mini_wishlist_sidebar(true);
                                        $count = yith_wcwl_count_products();
                                        global $nasa_opt;
                                        if (!isset($nasa_opt['compact_number']) || $nasa_opt['compact_number']) {
                                            $count = (int) $count > 9 ? '9+' : (int) $count;
                                        }
                                        
                                        $data['wishlistcount'] = $count;
                                    }
                                }
                            }

                            /**
                             * WCWL 3x or Higher
                             */
                            else {
                                try {
                                    YITH_WCWL()->remove($detail);
                                    $data['wishlist'] = elessi_mini_wishlist_sidebar(true);
                                    $count = yith_wcwl_count_products();
                                    
                                    global $nasa_opt;
                                    if (!isset($nasa_opt['compact_number']) || $nasa_opt['compact_number']) {
                                        $count = (int) $count > 9 ? '9+' : (int) $count;
                                    }

                                    $data['wishlistcount'] = $count;
                                }
                                catch (Exception $e){
                                    // $data['message'] = $e->getMessage();
                                }
                            }
                        }
                    }

                    wp_send_json($data);
                } else {
                    // If there was an error adding to the cart, redirect to the product page to show any errors
                    if (isset($validate_attr['missing_attributes'])) {
                        wc_add_notice(sprintf(_n('%s is a required field', '%s are required fields', count($validate_attr['missing_attributes']), 'elessi-theme'), wc_format_list_of_items($validate_attr['missing_attributes'])), 'error');
                    } else {
                        wc_add_notice(esc_html__('Sorry, Maybe product empty in stock.', 'elessi-theme'), 'error');
                    }

                    $data = array(
                        'error' => true,
                        'message' => wc_print_notices(true),
                        'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
                    );

                    wp_send_json($data);
                }
            }
        }
        
        /**
         * Combo product
         */
        public static function nasa_combo_products(){
            $output = array();

            if (!defined('YITH_WCPB')) {
                wp_send_json($output);
            }

            global $woocommerce, $nasa_opt;

            if (!$woocommerce || !isset($_REQUEST['id']) || !(int) $_REQUEST['id']){
                wp_send_json($output);
            }

            $product = wc_get_product((int) $_REQUEST['id']);
            if ($product->get_type() != NASA_COMBO_TYPE || !$combo = $product->get_bundled_items()) {
                wp_send_json($output);
            }

            $file = ELESSI_CHILD_PATH . '/includes/nasa-combo-products.php';
            $file = is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-combo-products.php';
            
            ob_start();
            include $file;
            $output['content'] = ob_get_clean();

            wp_send_json($output);
        }
        
        /**
         * Load compare in bottom
         */
        public static function nasa_load_compare() {
            $data = array('success' => '0', 'content' => '');
            
            ob_start();
            do_action('nasa_show_mini_compare');
            $data['content'] = ob_get_clean();
            
            if (!empty($data['content'])) {
                $data['success'] = '1';
            }
            
            wp_send_json($data);
        }

        /**
         * Add compare item
         */
        public static function nasa_add_compare_product() {
            $result = array(
                'result_compare' => 'error',
                'mess_compare' => esc_html__('Error!', 'elessi-theme'),
                'mini_compare' => 'no-change',
                'count_compare' => 0
            );
            if (!isset($_REQUEST['pid']) || !(int) $_REQUEST['pid']) {
                wp_send_json($result);
                wp_die();
            }

            global $nasa_opt, $yith_woocompare;
            $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
            if (!$nasa_compare) {
                wp_send_json($result);
                wp_die();
            }

            $max_compare = isset($nasa_opt['max_compare']) ? (int) $nasa_opt['max_compare'] : 4;
            if (!in_array((int) $_REQUEST['pid'], $nasa_compare->products_list)) {
                if (count($nasa_compare->products_list) >= $max_compare) {
                    while (count($nasa_compare->products_list) >= $max_compare) {
                        array_shift($nasa_compare->products_list);
                    }
                }

                $nasa_compare->add_product_to_compare((int) $_REQUEST['pid']);
                $result['mess_compare'] = esc_html__('Product added to compare !', 'elessi-theme');

                ob_start();
                do_action('nasa_show_mini_compare');
                $result['mini_compare'] = ob_get_clean();

                if (isset($_REQUEST['compare_table']) && $_REQUEST['compare_table']) {
                    $result['result_table'] = elessi_products_compare_content();
                }
            } else {
                $result['mess_compare'] = esc_html__('Product already exists in Compare list !', 'elessi-theme');
            }

            $result['count_compare'] = count($nasa_compare->products_list);
            $result['result_compare'] = 'success';

            wp_send_json($result);
        }
        
        /**
         * Remove compare item
         */
        public static function nasa_remove_compare_product() {
            $result = array(
                'result_compare' => 'error',
                'mess_compare' => esc_html__('Error!', 'elessi-theme'),
                'mini_compare' => 'no-change',
                'count_compare' => 0
            );
            
            if (!isset($_REQUEST['pid']) || !(int) $_REQUEST['pid']) {
                wp_send_json($result);
                wp_die();
            }

            global $yith_woocompare;
            $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
            if (!$nasa_compare) {
                wp_send_json($result);
                wp_die();
            }

            if (in_array((int) $_REQUEST['pid'], $nasa_compare->products_list)) {
                $nasa_compare->remove_product_from_compare((int) $_REQUEST['pid']);
                $result['mess_compare'] = esc_html__('Removed product from compare !', 'elessi-theme');

                ob_start();
                do_action('nasa_show_mini_compare');
                $result['mini_compare'] = ob_get_clean();

                if (isset($_REQUEST['compare_table']) && $_REQUEST['compare_table']) {
                    $result['result_table'] = elessi_products_compare_content();
                }
            } else {
                $result['mess_compare'] = esc_html__('Product not already exists in Compare list !', 'elessi-theme');
            }

            $result['count_compare'] = count($nasa_compare->products_list);
            $result['result_compare'] = 'success';

            wp_send_json($result);
        }
        
        /**
         * Remove all item compare
         */
        public static function nasa_remove_all_compare() {
            $result = array(
                'result_compare' => 'error',
                'mess_compare' => esc_html__('Error!', 'elessi-theme'),
                'mini_compare' => 'no-change',
                'count_compare' => 0
            );

            global $yith_woocompare;
            $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
            if (!$nasa_compare) {
                wp_send_json($result);
                wp_die();
            }

            if (!empty($nasa_compare->products_list)) {
                $nasa_compare->remove_product_from_compare('all');
                $result['mess_compare'] = esc_html__('Removed all products from compare !', 'elessi-theme');
                ob_start();
                do_action('nasa_show_mini_compare');

                $result['mini_compare'] = ob_get_clean();
            } else {
                $result['mess_compare'] = esc_html__('Compare products were empty !', 'elessi-theme');
            }

            $result['count_compare'] = count($nasa_compare->products_list);
            $result['result_compare'] = 'success';
            if (isset($_REQUEST['compare_table']) && $_REQUEST['compare_table']) {
                $result['result_table'] = elessi_products_compare_content();
            }

            wp_send_json($result);
        }
        
        /**
         * After Add To Cart
         * 
         * Pop-up Cross-Sells product
         */
        public static function nasa_after_add_to_cart() {
            $result = array(
                'success' => '0',
                'content' => ''
            );
            
            $nasa_cart = WC()->cart;
            $cart_items = $nasa_cart->get_cart();
            
            /**
             * Empty items
             */
            if (empty($cart_items)) {
                wp_send_json($result);
                wp_die();
            }
            
            $file = ELESSI_CHILD_PATH . '/includes/nasa-after-add-to-cart.php';
            $file = is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-after-add-to-cart.php';
            
            ob_start();
            include $file;
            
            $result['content'] = ob_get_clean();
            $result['success'] = '1';
            
            wp_send_json($result);
        }
        
        /**
         * NasaTheme Load product of Nasa Wishlist
         */
        public static function nasa_load_wishlist() {
            $data = array('success' => '0', 'content' => '');
            
            if (function_exists('elessi_woo_wishlist')) {
                $nasa_wishlist = elessi_woo_wishlist();
                
                if ($nasa_wishlist) {
                    $data = array(
                        'success' => '1',
                        'content' => elessi_mini_wishlist_sidebar(true)
                    );
                }
            }
            
            wp_send_json($data);
        }
        
        /**
         * NasaTheme Add product to wishlist
         */
        public static function nasa_add_to_wishlist() {
            $data = array('success' => '0', 'mess' => '');
            
            if (function_exists('elessi_woo_wishlist') && isset($_REQUEST["product_id"])) {
                $nasa_wishlist = elessi_woo_wishlist();
                
                if ($nasa_wishlist->add_to_wishlist($_REQUEST["product_id"])) {
                    $data = array(
                        'success' => '1',
                        'mess' => apply_filters('nasa_wishlist_mess_add_success', sprintf(
                            '<div class="woocommerce-message text-center" role="alert">%s</div>',
                            esc_html__('Product added to wishlist successfully!', 'elessi-theme')
                        )),
                        'count' => $nasa_wishlist->count_items()
                    );
                    
                    if (isset($_REQUEST['show_content']) && $_REQUEST['show_content']) {
                        $data['content'] = elessi_mini_wishlist_sidebar(true);
                    }
                }
            }
            
            wp_send_json($data);
        }
        
        /**
         * NasaTheme Remove product from wishlist
         */
        public static function nasa_remove_from_wishlist() {
            $data = array('success' => '0', 'mess' => '');
            
            if (function_exists('elessi_woo_wishlist') && isset($_REQUEST["product_id"])) {
                $nasa_wishlist = elessi_woo_wishlist();
                
                if ($nasa_wishlist->remove_from_wishlist($_REQUEST["product_id"])) {
                    $data = array(
                        'success' => '1',
                        'mess' => apply_filters('nasa_wishlist_mess_remove_success', sprintf(
                            '<div class="woocommerce-message text-center" role="alert">%s</div>',
                            esc_html__('Product removed from wishlist successfully!', 'elessi-theme')
                        )),
                        'count' => $nasa_wishlist->count_items()
                    );
                    
                    if (isset($_REQUEST['show_content']) && $_REQUEST['show_content']) {
                        $data['content'] = elessi_mini_wishlist_sidebar(true);
                    }
                }
            }
            
            wp_send_json($data);
        }
        /**
         * NasaTheme Remove wishlist hidden
         */
        public static function nasa_remove_wishlist_hidden() {
            $data = array('success' => '0', 'mess' => '');
            
            if (function_exists('elessi_woo_wishlist') && isset($_REQUEST["product_ids"]) && !empty($_REQUEST["product_ids"])) {
                $nasa_wishlist = elessi_woo_wishlist();
                foreach ($_REQUEST["product_ids"] as $product_id) {
                    $nasa_wishlist->remove_from_wishlist($product_id);
                }
                
                $data = array(
                    'success' => '1',
                    'mess' => sprintf(
                        '<div class="woocommerce-message text-center" role="alert">%s</div>',
                        esc_html__('Product removed from wishlist successfully!', 'elessi-theme')
                    ),
                    'count' => $nasa_wishlist->count_items()
                );
            }
            
            wp_send_json($data);
        }
        
        /**
         * Live Search Products
         */
        public static function nasa_search_products() {
            global $nasa_opt;

            $data = array();
            if (!isset($_REQUEST['s']) || trim($_REQUEST['s']) == '') {
                wp_send_json($data);
                
                return;
            }

            $limit = (isset($nasa_opt['limit_results_search']) && (int) $nasa_opt['limit_results_search'] > 0) ? (int) $nasa_opt['limit_results_search'] : 5;

            $data_store = WC_Data_Store::load('product');
            $products = $data_store->get_products(
                array(
                    's' => $_REQUEST['s'],
                    'status' => array('publish'),
                    'limit' => $limit,
                    'orderby' => 'relevance'
                )
            );
            
            if ($products) {
                $image_size = apply_filters('single_product_archive_thumbnail_size', 'shop_catalog');
                
                foreach ($products as $product) {
                    $data[] = array(
                        'title' => $product->get_name(),
                        'url' => $product->get_permalink(),
                        'image' => $product->get_image($image_size),
                        'price' => $product->get_price_html()
                    );
                }
            }

            wp_send_json($data);
        }
        
        /**
         * Update quantity mini cart
         */
        public static function nasa_quantity_mini_cart() {
            // Set item key as the hash found in input.qty's name
            $cart_item_key = $_REQUEST['hash'];

            // Get the array of values owned by the product we're updating
            $product_values = WC()->cart->get_cart_item($cart_item_key);

            // Get the quantity of the item in the cart
            $product_quantity = apply_filters('woocommerce_stock_amount_cart_item', apply_filters('woocommerce_stock_amount', preg_replace("/[^0-9\.]/", '', filter_var($_REQUEST['quantity'], FILTER_SANITIZE_NUMBER_INT))), $cart_item_key);

            // Update cart validation
            $passed_validation  = apply_filters('woocommerce_update_cart_validation', true, $cart_item_key, $product_values, $product_quantity);

            // Update the quantity of the item in the cart
            if ($passed_validation) {
                WC()->cart->set_quantity($cart_item_key, $product_quantity, true);
            }

            // Return fragments
            ob_start();
            woocommerce_mini_cart();
            $mini_cart = ob_get_clean();

            $woo_mess = wc_print_notices(true);
            $woo_mess = empty($woo_mess) ? '<div class="woocommerce-message text-center" role="alert">' . esc_html__('Product quantity updated successfully!', 'elessi-theme') . '</div>' : $woo_mess;

            // Fragments and mini cart are returned
            $data = array(
                'fragments' => apply_filters(
                    'woocommerce_add_to_cart_fragments',
                    array(
                        'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
                        '.woocommerce-message' => $woo_mess
                    )
                ),
                'cart_hash' => WC()->cart->get_cart_hash()
            );

            wp_send_json($data);
        }
    }

    /**
     * Init ELESSI WC AJAX
     */
    if (isset($_REQUEST['wc-ajax'])) {
        add_action('init', 'elessi_init_wc_ajax');
        if (!function_exists('elessi_init_wc_ajax')) :
            function elessi_init_wc_ajax() {
                ELESSI_WC_AJAX::nasa_init();
            }
        endif;
    }

endif;
