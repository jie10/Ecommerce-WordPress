<?php
/**
 * Shortcode [nasa_products_viewed ...]
 * 
 * @global type $nasa_opt
 * @global int $nasa_sc
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_products_viewed($atts = array(), $content = null) {
    global $nasa_opt, $nasa_viewed_products;
    
    if (!NASA_WOO_ACTIVED) {
        return $content;
    }
    
    $dfAttr = array(
        'title' => '',
        'animation' => '1',
        'columns_number' => '5',
        'columns_number_small' => '1',
        'columns_number_tablet' => '2',
        'default_rand' => 'false',
        'auto_slide' => 'false',
        'display_type' => 'slide',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    if (!isset($nasa_viewed_products)) {
        $nasa_viewed_products = nasa_get_products_viewed();
        $GLOBALS['nasa_viewed_products'] = $nasa_viewed_products;
    }

    if ($default_rand === 'true' && empty($nasa_viewed_products)) {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => (isset($nasa_opt['limit_product_viewed']) && (int) $nasa_opt['limit_product_viewed']) ? (int) $nasa_opt['limit_product_viewed'] : 5,
            'post_status' => 'publish',
            'fields' => 'ids',
        );
        $args['meta_query'] = array();
        $args['meta_query'][] = WC()->query->stock_status_meta_query();
        $args['tax_query'] = array('relation' => 'AND');

        $product_visibility_terms = wc_get_product_visibility_term_ids();
        $arr_not_in = array($product_visibility_terms['exclude-from-catalog']);

        // Hide out of stock products.
        if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
            $arr_not_in[] = $product_visibility_terms['outofstock'];
        }

        if (!empty($arr_not_in)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $arr_not_in,
                'operator' => 'NOT IN',
            );
        }

        $args['orderby'] = 'rand';
        $args['order'] = '';
        $args['meta_key'] = '';

        $nasa_viewed_products = new WP_Query($args);
    }
    
    $nasa_args = array(
        'nasa_opt' => $nasa_opt,
        'title' => $title,
        'animation' => $animation,
        'columns_number' => $columns_number,
        'columns_number_small' => $columns_number_small,
        'columns_number_tablet' => $columns_number_tablet,
        'default_rand' => $default_rand,
        'auto_slide' => $auto_slide,
        'display_type' => $display_type,
        'el_class' => $el_class,
        'nasa_viewed_products' => $nasa_viewed_products,
    );

    ob_start();
    ?>
    <div class="products woocommerce<?php echo ($el_class != '') ? ' ' . esc_attr($el_class) : ''; ?>">
        <?php nasa_template('products/nasa_products/viewed.php', $nasa_args); ?>
    </div>
    <?php
    $content = ob_get_clean();
    wp_reset_postdata();
    
    return $content;
}

// **********************************************************************// 
// ! Register New Element: nasa products viewed
// **********************************************************************//
function nasa_register_products_viewed(){
    vc_map(array(
        "name" => esc_html__("Products Viewed", 'nasa-core'),
        "base" => "nasa_products_viewed",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display products as many format.", 'nasa-core'),
        "class" => "",
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__('Title', 'nasa-core'),
                "param_name" => "title",
                "std" => ''
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number", 'nasa-core'),
                "param_name" => "columns_number",
                "value" => array(6, 5, 4, 3, 2, 1),
                "std" => 5,
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Small", 'nasa-core'),
                "param_name" => "columns_number_small",
                "value" => array(3, 2, 1),
                "std" => 1,
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Tablet", 'nasa-core'),
                "param_name" => "columns_number_tablet",
                "value" => array(4, 3, 2, 1),
                "std" => 2,
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Slide Auto', 'nasa-core'),
                "param_name" => 'auto_slide',
                "value" => array(
                    esc_html__('Yes, Please!', 'nasa-core') => 'true',
                    esc_html__('No, Thanks!', 'nasa-core') => 'false'
                ),
                "std" => 'false'
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Loadding random products if had not exists list viewed products', 'nasa-core'),
                "param_name" => 'default_rand',
                "value" => array(
                    esc_html__('Yes', 'nasa-core') => 'true',
                    esc_html__('No', 'nasa-core') => 'false'
                ),
                "std" => 'false'
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