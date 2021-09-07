<?php
defined('ABSPATH') or die(); // Exit if accessed directly

if (class_exists('WC_AJAX')) :
    class NASA_WC_AJAX extends WC_AJAX {

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
                'nasa_call_variations_product',
                'nasa_render_variables',
                'nasa_more_product',
                'nasa_more_products_masonry',
                'nasa_custom_taxomomies_child',
                'nasa_viewed_sidebar_content',
                'nasa_refresh_accessories_price',
                'nasa_add_to_cart_accessories',
                'nasa_render_bulk_dsct_variation'
            );

            foreach ($ajax_events as $ajax_event) {
                add_action('wp_ajax_woocommerce_' . $ajax_event, array(__CLASS__, $ajax_event));
                add_action('wp_ajax_nopriv_woocommerce_' . $ajax_event, array(__CLASS__, $ajax_event));

                // WC AJAX can be used for frontend ajax requests.
                add_action('wc_ajax_' . $ajax_event, array(__CLASS__, $ajax_event));
            }
        }
        
        /**
         * Viewed sidebar Content
         */
        public static function nasa_viewed_sidebar_content() {
            global $nasa_opt;
            
            $data = array('success' => '0', 'content' => '');
            
            if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
                wp_send_json($data);
                
                return;
            }
            
            $shortcode = apply_filters('nasa_shortcode_viewed_sidebar', '[nasa_products_viewed columns_number="1" columns_small="1" columns_number_tablet="1" default_rand="false" display_type="sidebar" animation="0"]');
            
            $data['content'] = do_shortcode($shortcode);
            if (!empty($data['content'])) {
                $data['success'] = '1';
            }
            
            wp_send_json($data);
        }

        /**
         * Render variations
         */
        public static function nasa_render_variables() {
            $data = array('empty' => '1');
            
            if (!empty($_POST['pids'])) {
                $uxObject = Nasa_WC_Attr_UX::getInstance();
                $products = $uxObject->render_variables($_POST['pids']);
                if (!empty($products)) {
                    $data = array('empty' => '0', 'products' => $products);
                }
            }
            
            wp_send_json($data);
        }
        
        /**
         * Call Variations after Click Select Options
         */
        public static function nasa_call_variations_product() {
            $data = array('empty' => '1');
            
            if (isset($_POST['pid']) && $_POST['pid']) {
                $product = wc_get_product($_POST['pid']);
            
                if ($product->get_type() == 'variable') {
                    $GLOBALS['product'] = $product;
                    
                    $uxObject = Nasa_WC_Attr_UX::getInstance();
                    $variable_str = $uxObject->product_content_variations_ux_loop(true, true);
                    if (!empty($variable_str)) {
                        $data = array('empty' => '0', 'variable_str' => $variable_str);
                    }
                }
            }
            
            wp_send_json($data);
        }
        
        /**
         * Load more products
         */
        public static function nasa_more_product() {
            $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
            $post_per_page = isset($_REQUEST['post_per_page']) ? $_REQUEST['post_per_page'] : 10;
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $cat = (isset($_REQUEST['cat']) && $_REQUEST['cat'] != '') ? $_REQUEST['cat'] : null;
            
            $data = array('success' => '0');

            $loop = nasa_woocommerce_query($type, $post_per_page, $cat, $page);
            if ($loop->found_posts):
                global $nasa_opt;
            
                // Use in row_layout.php
                $is_deals = isset($_REQUEST['is_deals']) ?
                    $_REQUEST['is_deals'] : false;
                $columns_number = isset($_REQUEST['columns_number']) ?
                    $_REQUEST['columns_number'] : 5;
                $columns_number_tablet = isset($_REQUEST['columns_number_medium']) ?
                    $_REQUEST['columns_number_medium'] : 2;
                $columns_number_small = isset($_REQUEST['columns_number_small']) ?
                    $_REQUEST['columns_number_small'] : 1;
                $start_row = '';
                $end_row = '';
                
                $style_item = isset($_REQUEST['style']) ? $_REQUEST['style'] : '';
                if ($style_item !== '') :
                    $nasa_opt['loop_layout_buttons'] = $style_item;
                endif;
                
                ob_start();
                
                $nasa_args = array(
                    'nasa_opt' => $nasa_opt,
                    'loop' => $loop,
                    'type' => $type,
                    'post_per_page' => $post_per_page,
                    'page' => $page,
                    'cat' => $cat,
                    'is_deals' => $is_deals,
                    'columns_number' => $columns_number,
                    'columns_number_small' => $columns_number_small,
                    'start_row' => $start_row,
                    'end_row' => $end_row,
                );
                
                nasa_template('products/globals/row_layout.php', $nasa_args);
                
                $data['content'] = ob_get_clean();
            endif;
            
            wp_reset_postdata();
            
            if (isset($data['content'])) {
                $data['success'] = '1';
            }
            
            wp_send_json($data);
        }
        
        /**
         * Load more products MASONRY
         */
        public static function nasa_more_products_masonry() {
            $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
            $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 18;
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $cat = (isset($_REQUEST['cat']) && $_REQUEST['cat'] != '') ? $_REQUEST['cat'] : null;
            $layout = (isset($_REQUEST['layout']) && $_REQUEST['layout'] != '') ? $_REQUEST['layout'] : '1';
            
            $data = array('success' => '0');
            
            $file = 'products/nasa_products_masonry/masonry-' . $layout . '.php';
            $loop = nasa_woocommerce_query($type, $limit, $cat, $page);
            if ($loop->found_posts):
                global $nasa_opt;
                $custom_class = "nasa-opacity-0";

                ob_start();
                
                $nasa_args = array(
                    'nasa_opt' => $nasa_opt,
                    'loop' => $loop,
                    'type' => $type,
                    'limit' => $limit,
                    'page' => $page,
                    'cat' => $cat,
                    'layout' => $layout,
                    'custom_class' => $custom_class,
                );
                
                nasa_template($file, $nasa_args);

                $data['content'] = ob_get_clean();
            endif;
            
            wp_reset_postdata();

            if (isset($data['content'])) {
                $data['success'] = '1';
            }
            
            wp_send_json($data);
        }
        
        /**
         * Render select Nasa Categories
         */
        public static function nasa_custom_taxomomies_child() {
            $key = isset($_REQUEST['key']) ? $_REQUEST['key'] : 0;
            $data = array('success' => false);
            if (!$key) {
                wp_send_json($data);
                
                return;
            }
            
            $slug = isset($_REQUEST['slug']) ? $_REQUEST['slug'] : null;
            $hide_empty = isset($_REQUEST['hide_empty']) ? $_REQUEST['hide_empty'] : '0';
            $count_items = isset($_REQUEST['show_count']) ? $_REQUEST['show_count'] : '0';
            $actived = isset($_REQUEST['actived']) ? $_REQUEST['actived'] : null;
            $data_select = isset($_REQUEST['select_text']) ? $_REQUEST['select_text'] : nasa_render_select_nasa_cats_empty();

            $emptySelect = $data_select;
            $content = '';
            if (!$slug) {
                $content .= '<option value="">' . $emptySelect . '</option>';

                $data = array(
                    'success' => true,
                    'content' => $content,
                    'empty' => true,
                    'has_active' => false
                );
            } else {
                $nasa_taxonomy = apply_filters('nasa_taxonomy_custom_cateogory', Nasa_WC_Taxonomy::$nasa_taxonomy);
                $currentTerm = get_term_by('slug', $slug, $nasa_taxonomy);

                if (isset($currentTerm->term_id)) {
                    $content .= '<option value="">' . $emptySelect . '</option>';

                    $childTerms = get_terms( 
                        array(
                            'taxonomy' => $nasa_taxonomy,
                            'parent' => $currentTerm->term_id,
                            'hide_empty' => $hide_empty,
                            'menu_order' => 'asc'
                        )
                    );

                    if ($childTerms) {
                        $hasActive = false;
                        foreach ($childTerms as $item) {
                            if ($actived && $item->slug == $actived) {
                                $hasActive = true;
                            }

                            $label = $count_items ? $item->name . ' (' . $item->count . ')' : $item->name;
                            $content .= '<option value="' . $item->slug . '">' . $label .  '</option>';
                        }

                        $data = array(
                            'success' => true,
                            'content' => $content,
                            'empty' => false,
                            'has_active' => $hasActive
                        );
                    } else {
                        $data = array(
                            'success' => true,
                            'content' => $content,
                            'empty' => true,
                            'has_active' => false
                        );
                    }
                }
            }
            
            wp_send_json($data);
        }
        
        /**
         * Get Total Price Accessories
         */
        public static function nasa_refresh_accessories_price() {
            $price = 0;
            if (isset($_REQUEST['total_price']) && $_REQUEST['total_price']) {
                $price = $_REQUEST['total_price'];
            }
            
            wp_send_json(array('total_price' => wc_price($price)));
        }
        
        /**
         * Add To Cart All Product + Accessories
         */
        public static function nasa_add_to_cart_accessories() {
            $error = array(
                'error' => true,
                'message' => '<p>' . esc_html__('Sorry, Maybe a product empty in stock.', 'nasa-core') . '</p>'
            );
            
            if (!isset($_REQUEST['product_ids']) || empty($_REQUEST['product_ids'])) {
                wp_send_json($error);
                
                return;
            }
            
            foreach ($_REQUEST['product_ids'] as $productId) {
                $product_id = (int) $productId;
                $product = wc_get_product($product_id);
                
                /**
                 * Check Product
                 */
                if (!$product) {
                    wp_send_json($error);
                
                    return;
                }
                
                $type = $product->get_type();
                
                /**
                 * Check type
                 */
                if (!in_array($type, array('simple'))) {
                    wp_send_json($error);
                
                    return;
                }
                
                $quantity = 1;
                $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
                $product_status    = get_post_status($product_id);
                
                /**
                 * Add To Cart
                 */
                if (
                    $passed_validation &&
                    'publish' === $product_status &&
                    false !== WC()->cart->add_to_cart($product_id, $quantity)
                ) {
                    do_action('woocommerce_ajax_added_to_cart', $product_id);
		} else {
                    $errors = wc_get_notices();
                    if ($errors && !empty($errors['error'])) {
                        $error['message'] = '';
                        foreach ($errors['error'] as $notices) {
                            if (isset($notices['notice'])) {
                                $error['message'] .= '<p>' . $notices['notice'] . '</p>';
                            }
                        }
                    }
                    
                    wc_clear_notices();
                    
                    wp_send_json($error);
                
                    return;
		}
            }
            
            self::get_refreshed_fragments();
        }
        
        /**
         * Bulk Discount for Variation Product
         */
        public static function nasa_render_bulk_dsct_variation() {
            $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : null;
            
            $data = array('success' => '0');
            
            /**
             * Build content
             */
            if (class_exists('Nasa_WC_Bulk_Discount') && $product_id) {
                $bulk_dsct = Nasa_WC_Bulk_Discount::getInstance();
                
                if ($bulk_dsct) {
                    global $product, $post;
                
                    $post_object = get_post($product_id);
                    setup_postdata($GLOBALS['post'] =& $post_object);

                    $GLOBALS['product'] = wc_get_product($product_id);
                    
                    ob_start();
                    $bulk_dsct->single_product_bulk_discount();
                    $data['content'] = ob_get_clean();
                }
            }

            if (isset($data['content']) && $data['content']) {
                $data['success'] = '1';
            }
            
            wp_send_json($data);
        }
    }

    /**
     * Init NASA WC AJAX
     */
    if (isset($_REQUEST['wc-ajax'])) {
        add_action('init', 'nasa_init_wc_ajax');
        if (!function_exists('nasa_init_wc_ajax')) :
            function nasa_init_wc_ajax() {
                NASA_WC_AJAX::nasa_init();
            }
        endif;
    }

endif;
