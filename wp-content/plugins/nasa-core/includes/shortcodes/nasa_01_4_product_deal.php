<?php
/**
 * Shortcode [nasa_product_deal ...]
 * 
 * @global type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_product_deal($atts = array(), $content = null) {
    global $woocommerce, $nasa_opt;
    
    if (!$woocommerce) {
        return $content;
    }
    
    $dfAttr = array(
        'id' => '',
        'title' => 'Deal for',
        'btn_shop_now' => 'yes',
        'btn_text' => 'SHOP NOW',
        'btn_url' => '',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    if (!(int) $id) {
        return $content;
    }
    
    /**
     * Cache shortcode
     */
    $key = false;
    if (isset($nasa_opt['nasa_cache_shortcodes']) && $nasa_opt['nasa_cache_shortcodes']) {
        $key = nasa_key_shortcode('nasa_product_deal', $dfAttr, $atts);
        $content = nasa_get_cache_shortcode($key);
    }
    
    $product = nasa_get_product_deal($id);
    
    if ($product && $product->is_visible()) :
        ob_start();
        
        $product_error = false;
        $product_id = $product->get_id();
        $product_type = $product->get_type();
        $post_id = $product_type == 'variation' ? $product->parent_id : $product_id;
        if (!$post_id) {
            $product_error = true;
        }

        $stock_available = $stock_sold = $percentage = false;
        $manager_product = get_post_meta($post_id, '_manage_stock', 'no');
        $real_id = $post_id;
        if ($product_type == 'variation') :
            $manager = get_post_meta($product_id, '_manage_stock', 'no');

            if ($manager === 'yes') :
                $manager_product = $manager;
                $real_id = $product_id;
            endif;
        endif;

        if ($manager_product === 'yes') :
            $total_sales = get_post_meta($real_id, 'total_sales', true);
            $stock_sold = $total_sales ? round($total_sales) : 0;

            $stock = get_post_meta($real_id, '_stock', true);
            $stock_available = $stock ? round($stock) : 0;

            $percentage = $stock_available > 0 ?
                round($stock_sold/($stock_available + $stock_sold) * 100) : 0;
        endif;

        $time_sale = $product->time_sale;

        $product_link = $product_error ? '#' : $product->get_permalink();
        $product_name = $product->get_name() . ($product_error ? esc_html__(' - Has been an error. You need to rebuild this product.', 'nasa-core') : '');
        
        if ($btn_shop_now == 'yes') :
            if ($btn_url == ''):
                $shop_page_id = get_option('woocommerce_shop_page_id', 0);

                if ($shop_page_id && get_option('page_on_front') !== $shop_page_id) {
                    $btn_url = get_permalink($shop_page_id);
                }
            endif; 
        else:
            $btn_url = '';
        endif;
        
        $class_wrap = 'nasa-sc woocommerce nasa-product-deal text-center';
        $class_wrap .= $el_class != '' ? ' ' . $el_class : '';
        
        $nasa_args = array(
            'title' => $title,
            'product' => $product,
            'product_name' => $product_name,
            'product_link' => $product_link,
            'time_sale' => $time_sale,
            'stock_available' => $stock_available,
            'stock_sold' => $stock_sold,
            'percentage' => $percentage,
            'btn_shop_now' => $btn_shop_now,
            'btn_text' => $btn_text,
            'btn_url' => $btn_url
        );
        ?>
        <div class="<?php echo esc_attr($class_wrap); ?>">
            <?php nasa_template('products/nasa_products_deal/product_deal.php', $nasa_args); ?>
        </div>
    <?php
        wp_reset_postdata();
        $content = ob_get_clean();
    endif;
    
    if ($content) {
        nasa_set_cache_shortcode($key, $content);
    }

    return $content;
}

// **********************************************************************// 
// ! Register New Element: Nasa product Deal
// **********************************************************************//
function nasa_register_product_deal(){
    vc_map(array(
        "name" => esc_html__("Product Deal Schedule", 'nasa-core'),
        "base" => "nasa_product_deal",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Only one product deal.", 'nasa-core'),
        "class" => "",
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Select a product deal", 'nasa-core'),
                "param_name" => "id",
                "value" => nasa_get_list_products_deal(),
                "admin_label" => true
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Title", 'nasa-core'),
                "param_name" => "title",
                "value" => 'Deal for',
                "admin_label" => true
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Button Store", 'nasa-core'),
                "param_name" => "btn_shop_now",
                "value" => array(
                    esc_html__('Yes', 'nasa-core') => 'yes',
                    esc_html__('No', 'nasa-core') => 'no'
                ),
                "std" => 'yes',
                "admin_label" => true
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Text Button", 'nasa-core'),
                "param_name" => "btn_text",
                "value" => 'SHOP NOW',
                "admin_label" => true
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("URL button (default shop page)", 'nasa-core'),
                "param_name" => "btn_url",
                "value" => '',
                "admin_label" => true
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    ));
}
