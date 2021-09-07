<?php
/**
 * Shortcode [nasa_products_special_deal ...]
 * 
 * @global type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_products_special_deal($atts = array(), $content = null) {
    global $nasa_opt, $nasa_sc;
    
    if (!NASA_WOO_ACTIVED) {
        return $content;
    }
    
    if (!isset($nasa_sc) || !$nasa_sc) {
        $nasa_sc = 1;
    }
    $GLOBALS['nasa_sc'] = $nasa_sc + 1;
    
    $dfAttr = array(
        'title' => '',
        'desc_shortcode' => '',
        'limit' => '4',
        'columns_number' => '1',
        'columns_number_small' => '1',
        'columns_number_tablet' => '1',
        'cat' => '',
        'style' => 'simple',
        'date_sc' => '',
        'statistic' => '1',
        'arrows' => 1,
        'auto_slide' => 'true',
        'el_class' => '',
        'sc' => $nasa_sc,
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    $deal_time = $date_sc ? strtotime($date_sc) : 0;
    if ($style == 'for_time' && $deal_time < NASA_TIME_NOW) {
        return;
    }
    
    $style = in_array($style, array('simple', 'multi', 'multi-2', 'for_time')) ? $style : 'simple';
    
    $load_slick = in_array($style, array('multi', 'multi-2')) ? true : false;
    if ($load_slick) {
        /**
         * Open slick
         */
        wp_enqueue_script('nasa-open-slicks', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa-open-slick.min.js', array('jquery-slick'), null, true);
    }
    
    /**
     * Cache shortcode
     */
    $key = false;
    if (isset($nasa_opt['nasa_cache_shortcodes']) && $nasa_opt['nasa_cache_shortcodes']) {
        $key = nasa_key_shortcode('nasa_products_special_deal', $dfAttr, $atts);
        $content = nasa_get_cache_shortcode($key);
    }
    
    if (!$content) {
        $number = (int) $limit ? (int) $limit : 4;
        $specials = nasa_woocommerce_query('deals', $number, $cat, '', array(), $deal_time);
        $_total = $specials->post_count;
        
        $nasa_args = array(
            'nasa_opt' => $nasa_opt,
            'title' => $title,
            'desc_shortcode' => $desc_shortcode,
            'limit' => $limit,
            'columns_number' => $columns_number,
            'columns_number_small' => $columns_number_small,
            'columns_number_tablet' => $columns_number_tablet,
            'cat' => $cat,
            'style' => $style,
            'date_sc' => $date_sc,
            'statistic' => $statistic,
            'arrows' => $arrows,
            'auto_slide' => $auto_slide,
            'el_class' => $el_class,
            'number' => $number,
            'specials' => $specials,
            'deal_time' => $deal_time,
            '_total' => $_total,
            'sc' => $sc,
        );
        
        $file_include = 'products/nasa_products_deal/product_special_deal_' . $style . '.php';

        if ($_total) :
            ob_start();
            ?>
            <div class="nasa-sc woocommerce nasa-products-special-deal<?php echo ' nasa-products-special-deal-' . $style . ($el_class != '' ? ' ' . $el_class : ''); ?>">
                <?php nasa_template($file_include, $nasa_args); ?>
            </div>
        <?php
            $content = ob_get_clean();
            wp_reset_postdata();
        endif;

        if ($content) {
            nasa_set_cache_shortcode($key, $content);
        }
    }
    
    return $content;
}

function nasa_register_product_special_deals(){
    // **********************************************************************// 
    // ! Register New Element: Products Deal
    // **********************************************************************//
    vc_map(array(
        "name" => esc_html__("Products Deal", 'nasa-core'),
        "base" => "nasa_products_special_deal",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display products deal.", 'nasa-core'),
        "class" => "",
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Limit products", 'nasa-core'),
                "param_name" => "limit",
                "std" => '4'
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Product Category", 'nasa-core'),
                "param_name" => "cat",
                "value" => nasa_get_cat_product_array(),
                "admin_label" => true,
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Style", 'nasa-core'),
                "param_name" => "style",
                "value" => array(
                    esc_html__('No Nav Items', 'nasa-core') => 'simple',
                    esc_html__('Has Nav 2 Items', 'nasa-core') => 'multi',
                    esc_html__('Has Nav 4 Items', 'nasa-core') => 'multi-2',
                    esc_html__('Deal Before Time', 'nasa-core') => 'for_time',
                ),
                'std' => 'simple',
                "admin_label" => true,
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__('Title', 'nasa-core'),
                "param_name" => 'title',
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        'simple',
                        'multi-2',
                        'for_time'
                    )
                ),
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__('Short Description', 'nasa-core'),
                "param_name" => 'desc_shortcode',
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        'for_time'
                    )
                ),
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__('End date show deals (yyyy-mm-dd | yyyy/mm/dd)', 'nasa-core'),
                "param_name" => 'date_sc',
                'std' => '',
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        'for_time'
                    )
                ),
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number", 'nasa-core'),
                "param_name" => "columns_number",
                "value" => array(6, 5, 4, 3, 2, 1),
                "std" => 1,
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        "simple",
                        'for_time'
                    )
                ),
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Small", 'nasa-core'),
                "param_name" => "columns_number_small",
                "value" => array('2', '1.5', '1'),
                "std" => 1,
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        "simple",
                        'for_time'
                    )
                ),
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Tablet", 'nasa-core'),
                "param_name" => "columns_number_tablet",
                "value" => array(4, 3, 2, 1),
                "std" => 1,
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        "simple",
                        'for_time'
                    )
                ),
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Show Available - Sold', 'nasa-core'),
                "param_name" => 'statistic',
                "value" => array(
                    esc_html__('No, Thanks!', 'nasa-core') => '0',
                    esc_html__('Yes, Please!', 'nasa-core') => '1'
                ),
                "std" => '1',
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        'simple',
                        'multi',
                        'multi-2'
                    )
                )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Arrows', 'nasa-core'),
                "param_name" => 'arrows',
                "value" => array(
                    esc_html__('Yes, Please!', 'nasa-core') => 1,
                    esc_html__('No, Thanks!', 'nasa-core') => 0
                ),
                "std" => 1
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Auto Slide', 'nasa-core'),
                "param_name" => 'auto_slide',
                "value" => array(
                    esc_html__('Yes, Please!', 'nasa-core') => 'true',
                    esc_html__('No, Thanks!', 'nasa-core') => 'false'
                ),
                "std" => 'true'
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
