<?php
/**
 * Shortcode [nasa_products_masonry ...]
 * 
 * @global type $nasa_opt
 * @global int $nasa_sc
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_products_masonry($atts = array(), $content = null) {
    global $nasa_opt, $nasa_sc;
    
    if (!isset($nasa_sc) || !$nasa_sc) {
        $nasa_sc = 1;
    }
    $GLOBALS['nasa_sc'] = $nasa_sc + 1;
    
    if (!NASA_WOO_ACTIVED) {
        return $content;
    }
    
    $dfAttr = array(
        'cat' => '',
        'type' => 'recent_product',
        'layout' => '1',
        'loadmore' => 'no',
        'sc' => $nasa_sc,
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    if ($type == '') {
        return $content;
    }
    
    /**
     * Masonry isotope
     */
    if (!wp_script_is('jquery-masonry-isotope')) {
        wp_enqueue_script('jquery-masonry-isotope', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.masonry-isotope.min.js', array('jquery'), null, true);
    }
    
    /**
     * Cache shortcode
     */
    $key = false;
    if (isset($nasa_opt['nasa_cache_shortcodes']) && $nasa_opt['nasa_cache_shortcodes']) {
        $key = nasa_key_shortcode('nasa_products_masonry', $dfAttr, $atts);
        $content = nasa_get_cache_shortcode($key);
    }
    
    if (!$content) {
        $limit = 18;
        if ($layout == 2) :
            $limit = 16;
        endif;

        $loop = nasa_woocommerce_query($type, $limit, $cat, 1);
        $_total = $loop->post_count;
        if ($_total) :
            $attributeWrap = '';
            if ($loadmore === 'yes') :
                $attributeWrap = 
                    'data-next_page="2" ' .
                    'data-layout="' . $layout . '" ' .
                    'data-product_type="' . $type . '" ' .
                    'data-limit="' . $limit . '" ' .
                    'data-max_pages="' . $loop->max_num_pages . '" ' .
                    'data-cat="' . esc_attr($cat) . '"';
            endif;
            
            $nasa_args = array(
                'nasa_opt' => $nasa_opt,
                'cat' => $cat,
                'type' => $type,
                'layout' => $layout,
                'loadmore' => $loadmore,
                'sc' => $sc,
                'el_class' => $el_class,
                'limit' => $limit,
                'loop' => $loop
            );

            ob_start();
            ?>
            <div class="nasa-wrap-products-masonry<?php echo ($el_class != '') ? ' ' . esc_attr($el_class) : ''; ?>">
                <div class="nasa-products-masonry products woocommerce"<?php echo $attributeWrap; ?>>
                    <?php nasa_template('products/nasa_products_masonry/masonry-' . $layout . '.php', $nasa_args); ?>
                </div>

                <?php if ($loadmore === 'yes' && $loop->max_num_pages > 1) :
                    echo '<div class="nasa-relative text-center desktop-margin-top-40 margin-bottom-20 nasa-clear-both">';
                    echo '<a class="load-more-masonry" href="javascript:void(0);" title="' . esc_attr__('LOAD MORE ...', 'nasa-core') . '" data-nodata="' . esc_attr__('ALL PRODUCTS LOADED', 'nasa-core') . '" rel="nofollow">' .
                        esc_html__('LOAD MORE ...') .
                    '</a>';
                    echo '</div>';
                endif; ?>
            </div>
            <?php
            $content = ob_get_clean();
        endif;
        
        if ($content) {
            nasa_set_cache_shortcode($key, $content);
        }
    }
    
    return $content;
}

// **********************************************************************// 
// ! Register New Element: nasa products
// **********************************************************************//
function nasa_register_products_masonry(){
    vc_map(array(
        "name" => esc_html__("Products Masonry", 'nasa-core'),
        "base" => "nasa_products_masonry",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display products as masonry layout.", 'nasa-core'),
        "class" => "",
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Type Show", 'nasa-core'),
                "param_name" => "type",
                "value" => array(
                    esc_html__('Recent Products', 'nasa-core') => 'recent_product',
                    esc_html__('Best Selling', 'nasa-core') => 'best_selling',
                    esc_html__('Featured Products', 'nasa-core') => 'featured_product',
                    esc_html__('Top Rate', 'nasa-core') => 'top_rate',
                    esc_html__('On Sale', 'nasa-core') => 'on_sale',
                    esc_html__('Recent Review', 'nasa-core') => 'recent_review',
                    esc_html__('Product Deals') => 'deals'
                ),
                'std' => 'recent_product',
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Layout", 'nasa-core'),
                "param_name" => "layout",
                "value" => array(
                    esc_html__('Layout type 1 (Limit 18 items)', 'nasa-core') => '1',
                    esc_html__('Layout type 2 (Limit 16 items)', 'nasa-core') => '2'
                ),
                'std' => '1',
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Load More", 'nasa-core'),
                "param_name" => "loadmore",
                "value" => array(
                    esc_html__('Yes', 'nasa-core') => 'yes',
                    esc_html__('No', 'nasa-core') => 'no'
                ),
                'std' => 'no',
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