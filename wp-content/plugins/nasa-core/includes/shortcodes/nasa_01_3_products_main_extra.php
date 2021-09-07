<?php
/**
 * Shortcode [nasa_products_main ...]
 * 
 * @global type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_products_main($atts = array(), $content = null) {
    global $nasa_opt;
    
    if (!NASA_WOO_ACTIVED) {
        return $content;
    }
    
    $dfAttr = array(
        'type_main' => 'deals',
        'type_extra' => 'recent_product',
        'cat' => '',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    if ($type_main == '') {
        return $content;
    }
    
    /**
     * Cache shortcode
     */
    $key = false;
    if (isset($nasa_opt['nasa_cache_shortcodes']) && $nasa_opt['nasa_cache_shortcodes']) {
        $key = nasa_key_shortcode('nasa_products_main', $dfAttr, $atts);
        $content = nasa_get_cache_shortcode($key);
    }
    
    if (!$content) {
        $type_extra = !isset($type_extra) ? 'recent_product' : $type_extra;
        $main = nasa_woocommerce_query($type_main, 1, $cat);
        if ($_total = $main->post_count) {
            $_id = rand();
            $post_notin = array();
            foreach ($main->posts as $item) {
                $post_notin[] = $item->ID;
            }
            $others = nasa_woocommerce_query($type_extra, 4, $cat, 1, $post_notin);
            
            $nasa_args = array(
                'nasa_opt' => $nasa_opt,
                'type_main' => $type_main,
                'type_extra' => $type_extra,
                'cat' => $cat,
                'style' => 'list',
                'el_class' => $el_class,
                'main' => $main,
                '_id' => $_id,
                'post_notin' => $post_notin,
                'others' => $others
            );

            ob_start();
            ?>
            <div class="woocommerce nasa-sc-main-extra-product<?php echo ($el_class != '') ? ' ' . $el_class : ''; ?>">
                <?php nasa_template('products/nasa_products_main/products_main_list.php', $nasa_args); ?>
            </div>
            <?php
            $content = ob_get_clean();
            wp_reset_postdata();
        }
        
        if ($content) {
            nasa_set_cache_shortcode($key, $content);
        }
    }
    
    return $content;
}

// **********************************************************************// 
// ! Register New Element: nasa products main
// **********************************************************************//
function nasa_register_products_main(){
    vc_map(array(
        "name" => esc_html__("Products Main Extra", 'nasa-core'),
        "base" => "nasa_products_main",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display 1 main and 4 extra products.", 'nasa-core'),
        "class" => "",
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Type Main", 'nasa-core'),
                "param_name" => "type_main",
                "std" => 'deals',
                "value" => array(
                    'Product Deals' => 'deals',
                    'Best Selling' => 'best_selling',
                    'Featured Products' => 'featured_product',
                    'Top Rate' => 'top_rate',
                    'Recent Products' => 'recent_product',
                    'On Sale' => 'on_sale',
                    'Recent Review' => 'recent_review'
                ),
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Type Extra", 'nasa-core'),
                "param_name" => "type_extra",
                "std" => 'recent_product',
                "value" => array(
                    'Product Deals' => 'deals',
                    'Best Selling' => 'best_selling',
                    'Featured Products' => 'featured_product',
                    'Top Rate' => 'top_rate',
                    'Recent Products' => 'recent_product',
                    'On Sale' => 'on_sale',
                    'Recent Review' => 'recent_review'
                ),
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Product Category", 'nasa-core'),
                "param_name" => "cat",
                "admin_label" => true,
                "value" => nasa_get_cat_product_array()
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
