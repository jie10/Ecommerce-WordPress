<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * WooCommerce - Function get Query
 */
function nasa_woocommerce_query($type = '', $post_per_page = -1, $cat = '', $paged = '', $not = array(), $deal_time = null) {
    if (!NASA_WOO_ACTIVED) {
        return array();
    }
    
    $page = $paged == '' ? ($paged = get_query_var('paged') ? (int) get_query_var('paged') : 1) : (int) $paged;
    
    $data = nasa_woocommerce_query_args($type, $post_per_page, $cat, $page, $not, $deal_time);
    remove_filter('posts_clauses', 'nasa_order_by_rating_post_clauses');
    remove_filter('posts_clauses', 'nasa_order_by_recent_review_post_clauses');
    
    return $data;
}

/**
 * Order by rating review
 * 
 * @global type $wpdb
 * @param type $args
 * @return array
 */
function nasa_order_by_rating_post_clauses($args) {
    global $wpdb;

    $args['fields'] .= ', AVG(' . $wpdb->commentmeta . '.meta_value) as average_rating';
    $args['where'] .= ' AND (' . $wpdb->commentmeta . '.meta_key = "rating" OR ' . $wpdb->commentmeta . '.meta_key IS null) AND ' . $wpdb->comments . '.comment_approved=1 ';
    $args['join'] .= ' LEFT OUTER JOIN ' . $wpdb->comments . ' ON(' . $wpdb->posts . '.ID = ' . $wpdb->comments . '.comment_post_ID) LEFT JOIN ' . $wpdb->commentmeta . ' ON(' . $wpdb->comments . '.comment_ID = ' . $wpdb->commentmeta . '.comment_id) ';
    $args['orderby'] = 'average_rating DESC, ' . $wpdb->posts . '.post_date DESC';
    $args['groupby'] = $wpdb->posts . '.ID';

    return $args;
}

/**
 * Order by recent review
 * 
 * @global type $wpdb
 * @param type $args
 * @return array
 */
function nasa_order_by_recent_review_post_clauses($args) {
    global $wpdb;

    $args['where'] .= ' AND ' . $wpdb->comments . '.comment_approved=1 ';
    $args['join'] .= ' LEFT JOIN ' . $wpdb->comments . ' ON(' . $wpdb->posts . '.ID = ' . $wpdb->comments . '.comment_post_ID)';
    $args['orderby'] = $wpdb->comments . '.comment_date DESC, ' . $wpdb->comments . '.comment_post_ID DESC';
    $args['groupby'] = $wpdb->posts . '.ID';

    return $args;
}

/**
 * Build query for Nasa WooCommerce Products
 * 
 * @param type $type
 * @param type $post_per_page
 * @param type $cat
 * @param type $paged
 * @param type $not
 * @param type $deal_time
 * @return type
 */
function nasa_woocommerce_query_args($type = '', $post_per_page = -1, $cat = '', $paged = 1, $not = array(), $deal_time = null) {
    if (!NASA_WOO_ACTIVED) {
        return array();
    }

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish',
        'paged' => $paged
    );

    $args['meta_query'] = array();
    $args['meta_query'][] = WC()->query->stock_status_meta_query();
    $args['tax_query'] = array('relation' => 'AND');
    
    $visibility_terms = wc_get_product_visibility_term_ids();
    $terms_not_in = array($visibility_terms['exclude-from-catalog']);

    // Hide out of stock products.
    if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
        $terms_not_in[] = $visibility_terms['outofstock'];
    }

    if (!empty($terms_not_in)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'term_taxonomy_id',
            'terms' => $terms_not_in,
            'operator' => 'NOT IN',
        );
    }
    
    switch ($type) {
        case 'best_selling':
            $args['ignore_sticky_posts'] = 1;
            
            $args['meta_key']   = 'total_sales';
            $args['order']      = 'DESC';
            $args['orderby']    = 'meta_value_num';
            
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            break;
        
        case 'featured_product':
            $args['ignore_sticky_posts'] = 1;
            $terms_in = isset($visibility_terms['featured']) && !empty($visibility_terms['featured']) ?
                array($visibility_terms['featured']) : null;

            $args['tax_query'][] = $terms_in ? array(
                'taxonomy' => 'product_visibility',
                'field' => 'term_taxonomy_id',
                'terms' => $terms_in,
                'operator' => 'IN',
            ) : array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured'
            );
            
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            break;
        
        case 'top_rate':
            add_filter('posts_clauses', 'nasa_order_by_rating_post_clauses');
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            break;
        
        case 'recent_review':
            // nasa_order_by_recent_review_post_clauses
            add_filter('posts_clauses', 'nasa_order_by_recent_review_post_clauses');
            $args['meta_query'][] = WC()->query->visibility_meta_query();

            break;
        
        case 'on_sale':
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            $args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
            
            break;
        
        case 'deals':
            $args['meta_query'][] = WC()->query->visibility_meta_query();
            
            $args['meta_query'][] = array(
                'key' => '_sale_price_dates_from',
                'value' => NASA_TIME_NOW,
                'compare' => '<=',
                'type' => 'numeric'
            );
            
            $args['meta_query'][] = array(
                'key' => '_sale_price_dates_to',
                'value' => NASA_TIME_NOW,
                'compare' => '>',
                'type' => 'numeric'
            );
            
            $args['post_type'] = array('product', 'product_variation');

            if ($deal_time > 0) {
                $args['meta_query'][] = array(
                    'key' => '_sale_price_dates_to',
                    'value' => $deal_time,
                    'compare' => '>=',
                    'type' => 'numeric'
                );
            }
            
            $args['post__in'] = array_merge(array(0), nasa_get_product_deal_ids($cat));
            
            $args['orderby'] = 'date ID';
            $args['order']   = 'DESC';

            break;

        case 'recent_product':
        default:
            $args['orderby'] = 'date ID';
            $args['order']   = 'DESC';
            
            break;
    }

    if (!empty($not)) {
        $args['post__not_in'] = $not;
        if (!empty($args['post__in'])) {
            $args['post__in'] = array_diff($args['post__in'], $args['post__not_in']);
        }
    }

    if ($type !== 'deals' && $cat) {
        
        // Find by cat id
        if (is_numeric($cat)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => array($cat)
            );
        }

        // Find by cat array id
        elseif (is_array($cat)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $cat
            );
        }

        // Find by slug
        elseif (is_string($cat)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $cat
            );
        }
    }
    
    if (empty($args['orderby']) || empty($args['order'])) {
        $ordering_args      = WC()->query->get_catalog_ordering_args();
        $args['orderby']    = empty($args['orderby']) ? $ordering_args['orderby'] : $args['orderby'];
        $args['order']      = empty($args['order']) ? $ordering_args['order'] : $args['order'];
    }

    return new WP_Query(apply_filters('nasa_woocommerce_query_args', $args));
}

/**
 * Get ids include for deal product
 * 
 * @global type $wpdb
 * @param type $cat
 * @return type
 */
function nasa_get_product_deal_ids($cat = null) {
    if (!NASA_WOO_ACTIVED) {
        return null;
    }
    
    $key = 'nasa_products_deal';
    if ($cat) {
        if (is_numeric($cat)) {
            $key .= '_cat_' . $cat;
        }
        
        if (is_array($cat)) {
            $key .= '_cats_' . implode('_', $cat);
        }
        
        if (is_string($cat)) {
            $key .= '_catslug_' . $cat;
        }
    }
    
    $product_ids = get_transient($key);
    
    if (!$product_ids) {
        // $v_ids = nasa_get_deal_product_variation_ids();
        
        $onsale_ids = array_merge(array(0), wc_get_product_ids_on_sale());
        
        $args = array(
            'post_type'         => array('product', 'product_variation'),
            'numberposts'       => -1,
            'post_status'       => 'publish',
            'fields'            => 'ids'
        );

        $args['tax_query'] = array('relation' => 'AND');

        $args['post__in'] = $onsale_ids;

        // Find by cat id
        if (is_numeric($cat) && $cat) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => array($cat)
            );
        }

        // Find by cat array id
        elseif (is_array($cat) && $cat) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $cat
            );
        }

        // Find by slug
        elseif (is_string($cat) && $cat) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $cat
            );
        }
        
        $args['meta_query'][] = WC()->query->visibility_meta_query();
            
        $args['meta_query'][] = array(
            'key' => '_sale_price_dates_from',
            'value' => NASA_TIME_NOW,
            'compare' => '<=',
            'type' => 'numeric'
        );

        $args['meta_query'][] = array(
            'key' => '_sale_price_dates_to',
            'value' => NASA_TIME_NOW,
            'compare' => '>',
            'type' => 'numeric'
        );

        $product_ids = get_posts($args);
        $product_ids_str = $product_ids ? implode(', ', $product_ids) : false;

        if ($product_ids_str) {
            global $wpdb;
            $variation_obj = $wpdb->get_results('SELECT ID FROM ' . $wpdb->posts . ' WHERE post_parent IN (' . $product_ids_str . ')');

            $variation_ids = $variation_obj ? wp_list_pluck($variation_obj, 'ID') : null;

            if ($variation_ids) {
                foreach ($variation_ids as $v_id) {
                    $product_ids[] = (int) $v_id;
                }
            }
        }

        set_transient($key, $product_ids, DAY_IN_SECONDS);
    }
    
    return $product_ids;
}

/**
 * Get product_ids variation
 */
function nasa_get_deal_product_variation_ids() {
    $key = 'nasa_variation_products_deal';
    $product_ids = get_transient($key);
    
    if (!$product_ids) {
        $v_args = array(
            'post_type'         => 'product_variation',
            'numberposts'       => -1,
            'post_status'       => 'publish',
            'fields'            => 'ids'
        );

        $v_args['tax_query'] = array('relation' => 'AND');
        $v_args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
        
        $v_args['meta_query'][] = WC()->query->visibility_meta_query();

        $v_args['meta_query'][] = array(
            'key' => '_sale_price_dates_from',
            'value' => NASA_TIME_NOW,
            'compare' => '<=',
            'type' => 'numeric'
        );

        $v_args['meta_query'][] = array(
            'key' => '_sale_price_dates_to',
            'value' => NASA_TIME_NOW,
            'compare' => '>',
            'type' => 'numeric'
        );

        $v_ids = get_posts($v_args);
        $product_ids = array(0);
        if ($v_ids) {
            foreach ($v_ids as $v_id) {
                $product_ids[] = (int) $v_id;
            }
        }
        
        set_transient($key, $product_ids, DAY_IN_SECONDS);
    }
    
    return empty($product_ids) ? null : $product_ids;
}

/**
 * Get Products by array id
 * 
 * @param type $ids
 * @return \WP_Query
 */
function nasa_get_products_by_ids($ids = array()) {
    if (!NASA_WOO_ACTIVED || empty($ids)) {
        return null;
    }
    
    $args = array(
        'post_type' => 'product',
        'post__in' => $ids,
        'posts_per_page' => count($ids),
        'post_status' => 'publish',
        'paged' => 1
    );
    
    return new WP_Query($args);
}

/**
 * Recommend product
 * @param type $cat
 */
add_action('nasa_recommend_product', 'nasa_get_recommend_product', 10, 1);
function nasa_get_recommend_product($cat = null) {
    global $nasa_opt;

    if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable_recommend_product']) && $nasa_opt['enable_recommend_product'] != '1')) {
        return '';
    }

    $columns_number = isset($nasa_opt['recommend_columns_desk']) ? (int) $nasa_opt['recommend_columns_desk'] : 5;

    $columns_number_small = isset($nasa_opt['recommend_columns_small']) ? $nasa_opt['recommend_columns_small'] : 2;
    $columns_number_small_slider = $columns_number_small == '1.5-cols' ? '1.5' : (int) $columns_number_small;
    
    $columns_number_tablet = isset($nasa_opt['recommend_columns_tablet']) ? (int) $nasa_opt['recommend_columns_tablet'] : 3;

    $number = (isset($nasa_opt['recommend_product_limit']) && ((int) $nasa_opt['recommend_product_limit'] >= $columns_number)) ? (int) $nasa_opt['recommend_product_limit'] : 9;

    $loop = nasa_woocommerce_query('featured_product', $number, (int) $cat ? (int) $cat : null, 1);
    if ($loop->found_posts) {
        ?>
        <div class="row margin-bottom-50 nasa-recommend-product">
            <div class="large-12 columns">
                <div class="woocommerce">
                    <?php
                    $type = null;
                    $height_auto = 'false';
                    $arrows = 1;
                    $title_shortcode = esc_html__('Recommend Products', 'nasa-core');
                    
                    $nasa_args = array(
                        'loop' => $loop,
                        'cat' => $cat,
                        'columns_number' => $columns_number,
                        'columns_number_small_slider' => $columns_number_small_slider,
                        'columns_number_tablet' => $columns_number_tablet,
                        'number' => $number,
                        'type' => $type,
                        'height_auto' => $height_auto,
                        'arrows' => $arrows,
                        'title_shortcode' => $title_shortcode,
                        'title_align' => 'center',
                        'nav_radius' => true,
                        'nasa_opt' => $nasa_opt
                    );
                    
                    nasa_template('products/nasa_products/carousel.php', $nasa_args);
                    ?>
                </div>
                <?php
                if (isset($nasa_opt['recommend_product_position']) && $nasa_opt['recommend_product_position'] == 'top') :
                    echo '<hr class="nasa-separator" />';
                endif;
                ?>
            </div>
        </div>
        <?php
    }
}

/**
 * Get product Deal by id
 * 
 * @param type $id
 * @return type
 */
function nasa_get_product_deal($id = null) {
    if (!(int) $id || !NASA_WOO_ACTIVED) {
        return null;
    }

    $product = wc_get_product((int) $id);

    if ($product) {
        $time_sale = get_post_meta((int) $id, '_sale_price_dates_to', true);
        $time_from = get_post_meta((int) $id, '_sale_price_dates_from', true);

        if ($time_sale > NASA_TIME_NOW && (!$time_from || $time_from < NASA_TIME_NOW)) {
            $product->time_sale = $time_sale;
            
            return $product;
        }
    }

    return null;
}

/**
 * Get products in grid
 * 
 * @param type $notid
 * @param type $catIds
 * @param type $type
 * @param type $limit
 * @return type
 */
function nasa_get_products_grid($notid = null, $catIds = null, $type = 'best_selling', $limit = 6) {
    $notIn = $notid ? array($notid) : array();
    
    return nasa_woocommerce_query($type, $limit, $catIds, 1, $notIn);
}

/**
 * Set cookie products viewed
 */
remove_action('template_redirect', 'wc_track_product_view', 25);
add_action('template_redirect', 'nasa_set_products_viewed', 20);
function nasa_set_products_viewed() {
    global $nasa_opt;

    if (!NASA_WOO_ACTIVED || !is_singular('product') || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
        return;
    }

    global $post;

    $product_id = isset($post->ID) ? (int) $post->ID : 0;
    if ($product_id) {
        $limit = !isset($nasa_opt['limit_product_viewed']) || !(int) $nasa_opt['limit_product_viewed'] ?
            12 : (int) $nasa_opt['limit_product_viewed'];

        $list_viewed = !empty($_COOKIE[NASA_COOKIE_VIEWED]) ? explode('|', $_COOKIE[NASA_COOKIE_VIEWED]) : array();
        if (!in_array((int) $product_id, $list_viewed)) {
            $new_array = array(0 => $product_id);
            
            for ($i = 1; $i < $limit; $i++) {
                if (isset($list_viewed[$i-1])) {
                    $new_array[$i] = $list_viewed[$i-1];
                }
            }
            
            $new_array_str = !empty($new_array) ? implode('|', $new_array) : '';
            setcookie(NASA_COOKIE_VIEWED, $new_array_str, 0, COOKIEPATH, COOKIE_DOMAIN, false, false);
        }
    }
}

/**
 * Get cookie products viewed
 */
function nasa_get_products_viewed() {
    global $nasa_opt;
    $query = null;

    if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
        return $query;
    }

    $viewed_products = !empty($_COOKIE[NASA_COOKIE_VIEWED]) ? explode('|', $_COOKIE[NASA_COOKIE_VIEWED]) : array();
    if (!empty($viewed_products)) {

        $limit = !isset($nasa_opt['limit_product_viewed']) || !(int) $nasa_opt['limit_product_viewed'] ? 12 : (int) $nasa_opt['limit_product_viewed'];

        $query_args = array(
            'posts_per_page' => $limit,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $viewed_products,
            'orderby' => 'post__in',
        );

        if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'name',
                    'terms' => 'outofstock',
                    'operator' => 'NOT IN',
                ),
            );
        }

        $query = new WP_Query($query_args);
    }

    return $query;
}

/**
 * Static Viewed Sidebar
 */
add_action('nasa_static_content', 'nasa_static_viewed_sidebar', 15);
function nasa_static_viewed_sidebar() {
    global $nasa_opt;
    if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
        return;
    }
    
    /**
     * Turn off Viewed Canvas
     */
    if ((isset($nasa_opt['viewed_canvas']) && !$nasa_opt['viewed_canvas'])) {
        return;
    }
    
    $nasa_viewed_style = isset($nasa_opt['style-viewed']) ? esc_attr($nasa_opt['style-viewed']) : 'style-1'; ?>
    <!-- viewed product -->
    <div id="nasa-viewed-sidebar" class="nasa-static-sidebar <?php echo esc_attr($nasa_viewed_style); ?>">
        <div class="viewed-close nasa-sidebar-close">
            <span class="nasa-tit-viewed nasa-sidebar-tit text-center">
                <?php echo esc_html__("Recently Viewed", 'nasa-core'); ?>
            </span>
            <a href="javascript:void(0);" title="<?php esc_attr_e('Close', 'nasa-core'); ?>" rel="nofollow"><?php esc_html_e('Close', 'nasa-core'); ?></a>
        </div>
        
        <div id="nasa-viewed-sidebar-content" class="nasa-absolute">
            <div class="nasa-loader"></div>
        </div>
    </div>
    <?php
}

/**
 * Viewed icon button
 */
add_action('nasa_static_group_btns', 'nasa_static_viewed_btns', 15);
function nasa_static_viewed_btns() {
    global $nasa_opt;
    if (!NASA_WOO_ACTIVED || (isset($nasa_opt['enable-viewed']) && !$nasa_opt['enable-viewed'])) {
        return;
    }
    
    /**
     * Turn off Viewed Canvas
     */
    if ((isset($nasa_opt['viewed_canvas']) && !$nasa_opt['viewed_canvas'])) {
        return;
    }
    ?>
    
    <?php
    $nasa_viewed_icon = 'nasa-tip nasa-tip-left ';
    $nasa_viewed_icon .= isset($nasa_opt['style-viewed-icon']) ? esc_attr($nasa_opt['style-viewed-icon']) : 'style-1';
    ?>
    <a id="nasa-init-viewed" class="<?php echo esc_attr($nasa_viewed_icon); ?>" href="javascript:void(0);" data-tip="<?php esc_attr_e('Recently Viewed', 'nasa-core'); ?>" title="<?php esc_attr_e('Recently Viewed', 'nasa-core'); ?>" rel="nofollow">
        <i class="pe-icon pe-7s-clock"></i>
    </a>
    <?php
}

/**
 * Get product meta value
 */
function nasa_get_product_meta_value($product_id = 0, $field = null) {
    $meta_value = '';
    
    if (!$product_id) {
        return $meta_value;
    }
    
    global $nasa_product_meta;
    
    if (isset($nasa_product_meta[$product_id])) {
        $meta_value = $nasa_product_meta[$product_id];
    } else {
        $get_meta_value = get_post_meta($product_id, 'wc_productdata_options', true);
        $meta_value = isset($get_meta_value[0]) ? $get_meta_value[0] : $get_meta_value;
        
        $nasa_product_meta = !$nasa_product_meta ? array() : $nasa_product_meta;
        $nasa_product_meta[$product_id] = $meta_value;
        
        $GLOBALS['nasa_product_meta'] = $nasa_product_meta;
    }
    
    if (is_array($meta_value) && $field) {
        return isset($meta_value[$field]) ? $meta_value[$field] : '';
    }

    return $meta_value;
}

/**
 * Get variation meta value
 */
function nasa_get_variation_meta_value($variation_id = 0, $field = null) {
    $meta_value = '';
    
    if (!$variation_id) {
        return $meta_value;
    }
    
    global $nasa_variation_meta;
    
    if (isset($nasa_variation_meta[$variation_id])) {
        $meta_value = $nasa_variation_meta[$variation_id];
    } else {
        $meta_value = get_post_meta($variation_id, 'wc_variation_custom_fields', true);
        
        $nasa_variation_meta = !$nasa_variation_meta ? array() : $nasa_variation_meta;
        $nasa_variation_meta[$variation_id] = $meta_value;
        
        $GLOBALS['nasa_variation_meta'] = $nasa_variation_meta;
    }
    
    if (is_array($meta_value) && $field) {
        return isset($meta_value[$field]) ? $meta_value[$field] : '';
    }

    return $meta_value;
}

/**
 * variation gallery images
 */
add_filter('woocommerce_available_variation', 'nasa_variation_gallery_images');
function nasa_variation_gallery_images($variation) {
    global $nasa_opt;
    if (!isset($nasa_opt['gallery_images_variation']) || $nasa_opt['gallery_images_variation']) {
        if (!isset($variation['nasa_gallery_variation'])) {
            $variation['nasa_gallery_variation'] = array();
            $variation['nasa_variation_back_img'] = '';
            $gallery = get_post_meta($variation['variation_id'], 'nasa_variation_gallery_images', true);

            if ($gallery) {
                $variation['nasa_gallery_variation'] = $gallery;
                $galleryIds = explode(',', $gallery);
                $back_id = isset($galleryIds[0]) && (int) $galleryIds[0] ? (int) $galleryIds[0] : false;
                $image_size = apply_filters('single_product_archive_thumbnail_size', 'shop_catalog');
                $image_back = $back_id ? wp_get_attachment_image_src($back_id, $image_size) : null;
                $variation['nasa_variation_back_img'] = isset($image_back[0]) ? $image_back[0] : '';
            }
        }
    }
    
    return $variation;
}

/**
 * Enable Gallery images variation in front-end
 */
add_action('woocommerce_after_add_to_cart_button', 'nasa_enable_variation_gallery_images', 30);
function nasa_enable_variation_gallery_images() {
    global $product, $nasa_opt;
    
    if (isset($nasa_opt['gallery_images_variation']) && !$nasa_opt['gallery_images_variation']) {
        return;
    }

    $productType = $product->get_type();
    if ($productType == 'variable' || $productType == 'variation') {
        $main_product = ($productType == 'variation') ?
            wc_get_product(wp_get_post_parent_id($product->get_id())) : $product;

        $variations = $main_product ? $main_product->get_available_variations() : null;
        if (!empty($variations)) {
            foreach ($variations as $vari) {
                if (isset($vari['nasa_gallery_variation']) && !empty($vari['nasa_gallery_variation'])) {
                    echo '<input type="hidden" name="nasa-gallery-variation-supported" class="nasa-gallery-variation-supported" value="1" />';
                    return;
                }
            }
        }
    }
}

/**
 * Size Guide Product - Delivery & Return
 */
add_action('woocommerce_single_product_summary', 'nasa_single_product_popup_nodes', 35);
function nasa_single_product_popup_nodes() {
    global $nasa_opt, $product;
    
    /**
     * Size Guide - New Feature get content from static Block
     */
    $single_product = false;
    $size_guide = false;
    
    /**
     * Get size_guide from category
     */
    $term_id = nasa_root_term_id();

    if ($term_id) {
        $size_guide_cat = get_term_meta($term_id, 'cat_size_guide_block', true);
        
        if ($size_guide_cat && $size_guide_cat != '-1') {
            $size_guide = nasa_get_block($size_guide_cat);
        }
        
        if ($size_guide_cat == '-1') {
            $size_guide = 'not-show';
        }
    }

    /**
     * Get size_guide from Theme Options
     */
    if (!$size_guide && isset($nasa_opt['size_guide_product']) && $nasa_opt['size_guide_product']) {
        $size_guide = nasa_get_block($nasa_opt['size_guide_product']);
    }
    
    /**
     * Not show from Category
     */
    if ($size_guide == 'not-show') {
        $size_guide = false;
    }
    
    /**
     * Delivery & Return
     */
    $delivery_return = false;
    if (isset($nasa_opt['delivery_return_single_product']) && $nasa_opt['delivery_return_single_product']) {
        $delivery_return = nasa_get_block($nasa_opt['delivery_return_single_product']);
    }
    
    /**
     * Ask a Question
     */
    $ask_a_question = false;
    if (isset($nasa_opt['ask_a_question']) && $nasa_opt['ask_a_question']) {
        $ask_a_question = shortcode_exists('contact-form-7') ? do_shortcode('[contact-form-7 id="' . ((int) $nasa_opt['ask_a_question']) . '"]') : false;
        
        if ($ask_a_question == '[contact-form-7 404 "Not Found"]') {
            $ask_a_question = false;
        }
        
        if ($ask_a_question) {
            global $product;
            $single_product = $product;
        }
    }
    
    /**
     * Request a Call Back
     */
    $request_a_callback = false;
    if (isset($nasa_opt['request_a_callback']) && $nasa_opt['request_a_callback']) {
        $request_a_callback = shortcode_exists('contact-form-7') ? do_shortcode('[contact-form-7 id="' . ((int) $nasa_opt['request_a_callback']) . '"]') : false;
        
        if ($request_a_callback == '[contact-form-7 404 "Not Found"]') {
            $request_a_callback = false;
        }
        
        if (!$single_product && $request_a_callback) {
            global $product;
            $single_product = $product;
        }
    }
    
    /**
     * Args Template
     */
    $nasa_args = array(
        'size_guide' => $size_guide,
        'delivery_return' => $delivery_return,
        'ask_a_question' => $ask_a_question,
        'request_a_callback' => $request_a_callback,
        'single_product' => $single_product
    );
    
    /**
     * Include template
     */
    nasa_template('products/nasa_single_product/nasa-single-product-popup-nodes.php', $nasa_args);
}

/**
 * Viewed icon button
 */
add_action('nasa_static_group_btns', 'nasa_static_request_callback', 12);
function nasa_static_request_callback() {
    global $nasa_opt;
    
    if (!isset($nasa_opt['request_a_callback']) || !$nasa_opt['request_a_callback']) {
        return;
    }
    
    if (!NASA_WOO_ACTIVED || !is_product()) {
        return;
    } ?>
    
    <a class="nasa-node-popup hidden-tag nasa-tip nasa-tip-left" href="javascript:void(0);" data-target="#nasa-content-request-a-callback" data-tip="<?php echo esc_attr__('Request a Call Back', 'nasa-core'); ?>" title="<?php echo esc_attr__('Request a Call Back', 'nasa-core'); ?>" rel="nofollow">
        <i class="nasa-icon icon-nasa-headphone"></i>
    </a>
    
    <?php
}

/**
 * After Add To Cart Button
 */
//add_action('woocommerce_after_add_to_cart_form', 'nasa_after_add_to_cart_form');
add_action('woocommerce_single_product_summary', 'nasa_after_add_to_cart_form', 50);
function nasa_after_add_to_cart_form() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_single_addtocart_form']) && $nasa_opt['after_single_addtocart_form']) {
        echo nasa_get_block($nasa_opt['after_single_addtocart_form']);
    }
}

/**
 * After Process To Checkout Button
 */
add_action('woocommerce_proceed_to_checkout', 'nasa_after_process_checkout_button', 100);
function nasa_after_process_checkout_button() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_process_checkout']) && $nasa_opt['after_process_checkout']) {
        echo nasa_get_block($nasa_opt['after_process_checkout']);
    }
}

/**
 * After Cart Table
 */
add_action('woocommerce_after_cart_table', 'nasa_after_cart_table');
function nasa_after_cart_table() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_cart_table']) && $nasa_opt['after_cart_table']) {
        echo nasa_get_block($nasa_opt['after_cart_table']);
    }
}

/**
 * After Cart content
 */
add_action('woocommerce_after_cart', 'nasa_after_cart', 5);
function nasa_after_cart() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_cart']) && $nasa_opt['after_cart']) {
        echo nasa_get_block($nasa_opt['after_cart']);
    }
}

/**
 * After Place Order Button
 */
add_action('woocommerce_review_order_after_payment', 'nasa_after_place_order_button');
function nasa_after_place_order_button() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_place_order']) && $nasa_opt['after_place_order']) {
        echo nasa_get_block($nasa_opt['after_place_order']);
    }
}

/**
 * After review order
 */
if (defined('NASA_THEME_ACTIVE') && NASA_THEME_ACTIVE) {
    add_action('nasa_checkout_after_order_review', 'nasa_after_review_order_payment');
} else {
    add_action('woocommerce_checkout_after_order_review', 'nasa_after_review_order_payment');
}
function nasa_after_review_order_payment() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_review_order']) && $nasa_opt['after_review_order']) {
        echo nasa_get_block($nasa_opt['after_review_order']);
    }
}

/**
 * After Checkout Customer Detail
 */
add_action('woocommerce_checkout_after_customer_details', 'nasa_checkout_after_customer_details', 100);
function nasa_checkout_after_customer_details() {
    global $nasa_opt;
    
    if (isset($nasa_opt['after_checkout_customer']) && $nasa_opt['after_checkout_customer']) {
        echo nasa_get_block($nasa_opt['after_checkout_customer']);
    }
}

/**
 * Custom Slug Nasa Custom Categories
 */
add_filter('nasa_taxonomy_custom_cateogory', 'nasa_custom_slug_categories');
function nasa_custom_slug_categories($slug) {
    global $nasa_opt;
    
    if (!NASA_WOO_ACTIVED || !isset($nasa_opt['enable_nasa_custom_categories']) || !$nasa_opt['enable_nasa_custom_categories'] || !isset($nasa_opt['nasa_custom_categories_slug']) || trim($nasa_opt['nasa_custom_categories_slug']) === '') {
        return $slug;
    }
    
    $new_slug = sanitize_title(trim($nasa_opt['nasa_custom_categories_slug']));
    
    return $new_slug;
}

/**
 * Custom nasa-taxonomy
 */
add_action('nasa_before_archive_products', 'nasa_custom_filter_taxonomies');
function nasa_custom_filter_taxonomies() {
    global $nasa_opt, $wp_query, $nasa_root_term_id;
    
    if (!NASA_WOO_ACTIVED || !isset($nasa_opt['enable_nasa_custom_categories']) || !$nasa_opt['enable_nasa_custom_categories']) {
        return;
    }
    
    if (!isset($nasa_root_term_id)) {
        $is_product_cat = is_product_category();
        $current_cat = null;

        $rootCatId = 0;

        if ($is_product_cat) {
            $current_cat = $wp_query->get_queried_object();
        }

        if ($current_cat && isset($current_cat->term_id)) {
            if (isset($current_cat->parent) && $current_cat->parent == 0) {
                $rootCatId = $current_cat->term_id;
            } else {
                $ancestors = get_ancestors($current_cat->term_id, 'product_cat');
                $rootCatId = end($ancestors);
            }
        }

        $GLOBALS['nasa_root_term_id'] = $rootCatId ? $rootCatId : 0;
        $nasa_root_term_id = $rootCatId;
    }
    
    $show = '';
    if ($nasa_root_term_id) {
        $show = get_term_meta($nasa_root_term_id, 'nasa_custom_tax', true);
    }
    
    if ($show == '') {
        $show = isset($nasa_opt['archive_product_nasa_custom_categories']) && $nasa_opt['archive_product_nasa_custom_categories'] ? 'show' : 'hide';
    }
    
    if ($show === 'hide') {
        return;
    }

    $class = 'large-12 columns';
    $max = isset($nasa_opt['max_level_nasa_custom_categories']) ? (int) $nasa_opt['max_level_nasa_custom_categories'] : 3;
    $max_level = $max > 3 || $max < 1 ? 3 : $max;
    echo '<div class="' . esc_attr($class) . '">';
    echo do_shortcode('[nasa_product_nasa_categories deep_level="' . esc_attr($max_level) . '" el_class="margin-top-15 mobile-margin-top-10"]');
    echo '</div>';
}

/**
 * 360 Degree Product Viewer
 */
add_action('nasa_single_buttons', 'nasa_360_product_viewer', 25);
function nasa_360_product_viewer() {
    global $nasa_opt, $product;
    if (isset($nasa_opt['product_360_degree']) && !$nasa_opt['product_360_degree']) {
        return;
    }
    
    /**
     * 360 Degree Product Viewer
     * 
     * jQuery lib
     */
    wp_enqueue_script('jquery-threesixty', NASA_CORE_PLUGIN_URL . 'assets/js/min/threesixty.min.js', array('jquery'), null, true);
    
    $idImgs = nasa_get_product_meta_value($product->get_id(), '_product_360_degree');
    $idImgs_str = $idImgs ? trim($idImgs, ',') : '';
    $idImgs_arr = $idImgs_str !== '' ? explode(',', $idImgs_str) : array();
    
    if (empty($idImgs_arr)) {
        return;
    }
    
    $img_src = array();
    $width = apply_filters('nasa_360_product_viewer_width_default', 500);
    $height = apply_filters('nasa_360_product_viewer_height_default', 500);
    $set = false;
    foreach ($idImgs_arr as $id) {
        $image_full = wp_get_attachment_image_src($id, 'full');
        if (isset($image_full[0])) {
            $img_src[] = $image_full[0];
            if (!$set) {
                $set = true;
                $width = isset($image_full[1]) ? $image_full[1] : $width;
                $height = isset($image_full[2]) ? $image_full[2] : $height;
                
            }
        } else {
            $img_src[] = wp_get_attachment_url($id);
        }
    }
    
    if (!empty($img_src)) {
        $img_src_json = wp_json_encode($img_src);
        $dataimgs = function_exists('wc_esc_json') ?
            wc_esc_json($img_src_json) : _wp_specialchars($img_src_json, ENT_QUOTES, 'UTF-8', true);
        
        echo '<a id="nasa-360-degree" class="nasa-360-degree-popup nasa-tip nasa-tip-right" href="javascript:void(0);" data-close="' . esc_attr__('Close', 'nasa-core') . '" data-imgs="' . $dataimgs . '" data-width="' . $width . '" data-height="' . $height . '" data-tip="' . esc_html__('360&#176; View', 'nasa-core') . '" rel="nofollow">' . esc_html__('360&#176;', 'nasa-core')  . '</a>';
    }
}

/**
 * Custom Badge
 */
add_filter('nasa_badges', 'nasa_custom_badges');
function nasa_custom_badges($badges) {
    global $nasa_opt, $product;
    
    $product_id = $product->get_id();
    
    $custom_badge = '';
    
    /**
     * Video Badge
     */
    if (isset($nasa_opt['nasa_badge_video']) && $nasa_opt['nasa_badge_video']) {
        $video_link = nasa_get_product_meta_value($product_id, '_product_video_link');
        $custom_badge .= $video_link ? '<span class="badge video-label nasa-icon pe-7s-play"></span>' : '';
    }
    
    /**
     * 360 Degree Badge
     */
    if (isset($nasa_opt['nasa_badge_360']) && $nasa_opt['nasa_badge_360']) {
        $idImgs = nasa_get_product_meta_value($product_id, '_product_360_degree');
        $idImgs_str = $idImgs ? trim($idImgs, ',') : '';
        $custom_badge .= $idImgs_str ? '<span class="badge b360-label">' . esc_html__('360&#176;', 'nasa-core') . '</span>' : '';
    }

    /**
     * Custom Badge
     */
    $badge_hot = nasa_get_product_meta_value($product_id, '_bubble_hot');
    $custom_badge .= $badge_hot ? '<span class="badge hot-label">' . $badge_hot . '</span>' : '';
    
    return $custom_badge . $badges;
}

/**
 *
 * Add tab Bought Together
 */
add_filter('woocommerce_product_tabs', 'nasa_accessories_product_tab');
function nasa_accessories_product_tab($tabs) {
    global $product;
    
    if ($product && 'simple' === $product->get_type()) {
        $productIds = get_post_meta($product->get_id(), '_accessories_ids', true);
        if (!empty($productIds)) {
            $GLOBALS['accessories_ids'] = $productIds;
            $tabs['accessories_content'] = array(
                'title'     => esc_html__('Bought Together', 'nasa-core'),
                'priority'  => apply_filters('nasa_bought_together_tab_priority', 5),
                'callback'  => 'nasa_accessories_product_tab_content'
            );
        }
    }

    return $tabs;
}

/**
 * Content Bought Together of the current Product
 */
function nasa_accessories_product_tab_content() {
    global $product, $accessories_ids, $nasa_opt;
    if (!$product || !$accessories_ids) {
        return;
    }

    $accessories = array();
    foreach ($accessories_ids as $accessories_id) {
        $product_acc = wc_get_product($accessories_id);
        if (
            is_object($product_acc) &&
            $product_acc->get_status() === 'publish' &&
            $product_acc->get_type() == 'simple'
        ) {
            $accessories[] = $product_acc;
        }
    }

    if (empty($accessories)) {
        return;
    }
    
    $nasa_args = array(
        'nasa_opt' => $nasa_opt,
        'product' => $product,
        'accessories_ids' => $accessories_ids,
        'accessories' => $accessories,
    );

    nasa_template('products/nasa_single_product/nasa-single-product-accessories-tab-content.php', $nasa_args);
}

/**
 *
 * Add tab Technical Specifications
 */
add_filter('woocommerce_product_tabs', 'nasa_specifications_product_tab');
function nasa_specifications_product_tab($tabs) {
    global $nasa_specifications, $product;
    if (!$product) {
        return;
    }
    
    $product_id = $product->get_id();
    if (!isset($nasa_specifications[$product_id])) {
        $specifications = nasa_get_product_meta_value($product_id, 'nasa_specifications');
        $nasa_specifications[$product->get_id()] = $specifications;
        $GLOBALS['nasa_specifications'] = $nasa_specifications;
    }
    
    if ($nasa_specifications[$product_id] == '') {
        return $tabs;
    }
    
    $tabs['specifications'] = array(
        'title'     => esc_html__('Specifications', 'nasa-core'),
        'priority'  => apply_filters('nasa_specifications_tab_priority', 15),
        'callback'  => 'nasa_specifications_product_tab_content'
    );

    return $tabs;
}

/**
 * Content Technical Specifications of the current Product
 */
function nasa_specifications_product_tab_content() {
    global $product, $nasa_specifications;
    if (!$product || !isset($nasa_specifications[$product->get_id()])) {
        return;
    }

    echo do_shortcode($nasa_specifications[$product->get_id()]);
}

/**
 * Loop layout buttons
 */
add_action('wp_head', 'nasa_loop_layout_buttons');
function nasa_loop_layout_buttons() {
    if (!NASA_WOO_ACTIVED) {
        return false;
    }
    
    global $nasa_opt;
    $root_term_id = nasa_root_term_id();
    
    /**
     * Category products
     */
    if ($root_term_id) {
        $type_override = get_term_meta($root_term_id, 'nasa_loop_layout_buttons', true);
        if ($type_override) {
            $nasa_opt['loop_layout_buttons'] = $type_override;
        }
    }
    
    /**
     * Pages
     */
    else {
        global $wp_query;
        
        $page_id = false;
        $is_shop = is_shop();
        $is_product_taxonomy = is_product_taxonomy();

        /**
         * Shop
         */
        if ($is_shop || $is_product_taxonomy) {
            $pageShop = wc_get_page_id('shop');

            if ($pageShop > 0) {
                $page_id = $pageShop;
            }
        }

        /**
         * Page
         */
        else {
            $page_id = $wp_query->get_queried_object_id();
        }

        /**
         * Swith header structure
         */
        if ($page_id) {
            $type_override = get_post_meta($page_id, '_nasa_loop_layout_buttons', true);
            if (!empty($type_override)) {
                $nasa_opt['loop_layout_buttons'] = $type_override;
            }
        }
    }
    
    $GLOBALS['nasa_opt'] = $nasa_opt;
}

/**
 * Attributes Brands Single Product Page
 */
add_action('woocommerce_single_product_summary', 'nasa_single_attributes_brands', 16);
add_action('woocommerce_single_product_lightbox_summary', 'nasa_single_attributes_brands', 11);
function nasa_single_attributes_brands() {
    global $nasa_opt, $product;
    
    if (!$product) {
        return;
    }
    
    $nasa_brands = isset($nasa_opt['attr_brands']) && !empty($nasa_opt['attr_brands']) ? $nasa_opt['attr_brands'] : array();
    $brands = array();
    if (!empty($nasa_brands)) {
        foreach ($nasa_brands as $key => $val) {
            if ($val === '1') {
                $brands[] = $key;
            }
        }
    }
    if (empty($brands)) {
        return;
    }
    
    $attributes = $product->get_attributes();
    if (empty($attributes)) {
        return;
    }
    
    $brands_output = array();
    foreach ($attributes as $attribute_name => $attribute) {
        $attr_name = 0 === strpos($attribute_name, 'pa_') ? substr($attribute_name, 3) : $attribute_name;
        
        if (!in_array($attr_name, $brands)) {
            continue;
        }
        
        $terms = $attribute->get_terms();
        $is_link = false;
        $this_name = false;
        if ($attribute->is_taxonomy()) {
            $attribute_taxonomy = $attribute->get_taxonomy_object();
            $is_link = $attribute_taxonomy->attribute_public ? true : false;
            $this_name = $attribute->get_name();
        }
        
        if (!empty($terms)) {
            $brands_output[$attribute_name] = array(
                'is_link' => $is_link,
                'attr_name' => $this_name,
                'terms' => $terms
            );
        }
    }
    
    $nasa_args = array(
        'brands' => $brands_output
    );
    
    nasa_template('products/nasa_single_product/nasa-single-brands.php', $nasa_args);
}

/**
 * Fake Sold
 */
add_action('woocommerce_single_product_summary', 'nasa_fake_sold', 22);
function nasa_fake_sold() {
    global $nasa_opt, $product;
    
    if (!isset($nasa_opt['fake_sold']) || !$nasa_opt['fake_sold'] || !$product) {
        return;
    }
    
    $product_type = $product->get_type();
    $types_allow = apply_filters('nasa_types_allow_fake', array('simple', 'variable', 'variation'));
    
    if (empty($types_allow) || in_array($product_type, $types_allow)) {
        $product_id = $product_type == 'variation' ? $product->get_parent_id() : $product->get_id();

        $key_name = 'nasa_fake_sold_' . $product_id;
        $fake_sold = get_transient($key_name);

        if (!$fake_sold) {
            /**
             * Build sold
             */
            $min = isset($nasa_opt['min_fake_sold']) && (int) $nasa_opt['min_fake_sold'] ? (int) $nasa_opt['min_fake_sold'] : 1;
            $max = isset($nasa_opt['max_fake_sold']) && (int) $nasa_opt['max_fake_sold'] ? (int) $nasa_opt['max_fake_sold'] : 20;
            $sold = rand($min, $max);

            /**
             * Build time
             */
            $min_time = isset($nasa_opt['min_fake_time']) && (int) $nasa_opt['min_fake_time'] ? (int) $nasa_opt['min_fake_time'] : 1;
            $max_time = isset($nasa_opt['max_fake_time']) && (int) $nasa_opt['max_fake_time'] ? (int) $nasa_opt['max_fake_time'] : 1;
            $times = rand($min_time, $max_time);

            /**
             * Live time - default 10 hours
             */
            $live_time = isset($nasa_opt['fake_time_live']) && (int) $nasa_opt['fake_time_live'] ? (int) $nasa_opt['fake_time_live'] : 36000;

            $fake_sold_data = '<div class="nasa-last-sold nasa-crazy-inline">';
            // $fake_sold_data .= '<i class="nasa-icon pe-7s-gleam pe-icon"></i>&nbsp;';
            $fake_sold_data .= '<i class="nasa-icon pe-7s-drop pe-icon"></i>&nbsp;';
            $fake_sold_data .= sprintf(
                esc_html__('%s sold in last %s hours', 'nasa-core'),
                $sold,
                $times
            );
            $fake_sold_data .= '</div>';

            /**
             * Apply content fake sold
             */
            $fake_sold = apply_filters('nasa_fake_sold_content', $fake_sold_data, $product_id);

            /**
             * Set transient
             */
            set_transient($key_name, $fake_sold, $live_time);
        }

        echo $fake_sold ? $fake_sold : '';
    }
}

/**
 * Estimated Delivery
 */
add_action('woocommerce_single_product_summary', 'nasa_estimated_delivery', 35);
function nasa_estimated_delivery() {
    global $nasa_opt, $product;
    
    if (!isset($nasa_opt['est_delivery']) || !$nasa_opt['est_delivery'] || !$product) {
        return;
    }
    
    $product_id = (int) $product->get_id();
    
    $min = isset($nasa_opt['min_est_delivery']) && (int) $nasa_opt['min_est_delivery'] ? (int) $nasa_opt['min_est_delivery'] : 3;
    $from = '+' . $min;
    $from .= ' ' . ($min = 1 ? 'day' : 'days');
    
    $max = isset($nasa_opt['max_est_delivery']) && (int) $nasa_opt['max_est_delivery'] ? (int) $nasa_opt['max_est_delivery'] : 7;
    $to = '+' . $max;
    $to .= ' ' . ($max = 1 ? 'day' : 'days');
    
    $now = get_date_from_gmt(date('Y-m-d H:i:s'), 'Y-m-d');
    $est_days = array();
    $est_days[] = date('M d', strtotime($now . $from));
    $est_days[] = date('M d', strtotime($now . $to));
    
    if (!empty($est_days)) {
        $est_view = '<div class="nasa-est-delivery nasa-promote-sales nasa-crazy-inline">';
        $est_view .= '<i class="nasa-icon icon-nasa-car-2"></i>&nbsp;&nbsp;';
        $est_view .= '<strong>' . esc_html__('Estimated Delivery:', 'nasa-core') . '</strong>&nbsp;';
        $est_view .= implode(' &ndash; ', $est_days);
        $est_view .= '</div>';
    
        /**
         * Output content estimated delivery view
         */
        echo apply_filters('nasa_estimated_delivery_content', $est_view, $product_id);
    }
}

/**
 * Fake Viewing
 */
add_action('woocommerce_single_product_summary', 'nasa_fake_view', 35);
function nasa_fake_view() {
    global $nasa_opt, $product;
    
    if ((isset($nasa_opt['fake_view']) && !$nasa_opt['fake_view']) || !$product) {
        return;
    }
    
    $product_id = (int) $product->get_id();
    
    $min = isset($nasa_opt['min_fake_view']) ? (int) $nasa_opt['min_fake_view'] : 10;
    $max = isset($nasa_opt['max_fake_view']) ? (int) $nasa_opt['max_fake_view'] : 50;
    $delay = isset($nasa_opt['delay_time_view']) ? (int) $nasa_opt['delay_time_view'] : 15;
    $change = isset($nasa_opt['max_change_view']) ? (int) $nasa_opt['max_change_view'] : 5;
    
    $allowed_html = array(
        'strong' => array()
    );
    
    $fake_view = '<div id="nasa-counter-viewing" class="nasa-viewing nasa-promote-sales nasa-crazy-inline" data-min="' . $min . '" data-max="' . $max . '" data-delay="' . ($delay * 1000) . '" data-change="' . $change . '" data-id="' . $product_id . '">';
    $fake_view .= '<i class="nasa-icon pe-7s-smile pe-icon"></i>&nbsp;&nbsp;<strong class="nasa-count">...</strong>&nbsp;';
    $fake_view .= wp_kses(__('<strong>people</strong>&nbsp;are viewing this right now', 'nasa-core'), $allowed_html);
    $fake_view .= '</div>';
    
    /**
     * Output content fake view
     */
    echo apply_filters('nasa_fake_view_content', $fake_view, $product_id);
}

/**
 * Get Root Term id
 * 
 * @global type $wp_query
 * @global type $nasa_root_term_id
 * @global type $product
 * @global type $post
 * @return boolean
 */
function nasa_root_term_id() {
    if (!NASA_WOO_ACTIVED) {
        return false;
    }
    
    global $wp_query, $nasa_root_term_id;
    
    if (!isset($nasa_root_term_id)) {
        $is_product = is_product();
        $is_product_cat = is_product_category();
        $current_cat = null;
        
        /**
         * For Quick view
         */
        if (isset($_REQUEST['wc-ajax']) && $_REQUEST['wc-ajax'] === 'nasa_quick_view') {
            global $product;
            if (!$product) {
                return false;
            }

            $is_product = true;
        }

        $rootCatId = 0;
        if ($is_product) {
            global $post;

            $product_cats = get_the_terms($post->ID, 'product_cat');
            if ($product_cats) {
                foreach ($product_cats as $cat) {
                    $current_cat = $cat;
                    if ($cat->parent == 0) {
                        break;
                    }
                }
            }
        }

        elseif ($is_product_cat) {
            $current_cat = $wp_query->get_queried_object();
        }

        if ($current_cat && isset($current_cat->term_id)) {
            if (isset($current_cat->parent) && $current_cat->parent == 0) {
                $rootCatId = $current_cat->term_id;
            } else {
                $ancestors = get_ancestors($current_cat->term_id, 'product_cat');
                $rootCatId = end($ancestors);
            }
        }

        $GLOBALS['nasa_root_term_id'] = $rootCatId ? $rootCatId : 0;
        $nasa_root_term_id = $rootCatId;
    }
    
    return $nasa_root_term_id;
}
