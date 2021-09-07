<?php
/**
 * Shortcode [nasa_products_byids ...]
 * 
 * @global type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_products_byids($atts = array(), $content = null) {
    global $nasa_opt;
    
    if (!NASA_WOO_ACTIVED) {
        return $content;
    }
    
    $dfAttr = array(
        'ids' => '',
        'style' => 'grid',
        'columns_number' => '4',
        'columns_number_small' => '2',
        'columns_number_small_slider' => '2',
        'columns_number_tablet' => '3',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    /**
     * Cache shortcode
     */
    $key = false;
    if (isset($nasa_opt['nasa_cache_shortcodes']) && $nasa_opt['nasa_cache_shortcodes']) {
        $key = nasa_key_shortcode('nasa_products_byids', $dfAttr, $atts);
        $content = nasa_get_cache_shortcode($key);
    }
    
    if (!$content) {
        $ids = str_replace(' ', '', $ids);
        $ids = trim($ids, ',');
        if ($ids == '') {
            return $content;
        }

        $ids = explode(',', $ids);
        $byIds = array();
        if ($ids) {
            foreach ($ids as $id) {
                if (!in_array((int) $id, $byIds)) {
                    $byIds[] = (int) $id;
                }
            }
        }

        if (empty($byIds)) {
            return $content;
        }

        $loop = nasa_get_products_by_ids($byIds);
        if ($loop && $_total = $loop->post_count) :
            $type = 'recent_product';
            $nasa_args = array(
                'nasa_opt' => $nasa_opt,
                'ids' => $ids,
                'type' => $type,
                'style' => $style,
                'columns_number' => $columns_number,
                'columns_number_small' => $columns_number_small,
                'columns_number_small_slider' => $columns_number_small_slider,
                'columns_number_tablet' => $columns_number_tablet,
                'el_class' => $el_class,
                'loop' => $loop,
                '_total' => $_total,
            );
            
            $file = 'products/nasa_products/' . $style . '.php';
            ob_start();
            ?>
            <div class="nasa-sc products woocommerce<?php echo ($el_class != '') ? ' ' . esc_attr($el_class) : ''; ?>">
                <?php nasa_template($file, $nasa_args); ?>
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
// ! Register New Element: nasa products by ids
// **********************************************************************//
function nasa_register_products_byids(){
    vc_map(array(
        "name" => esc_html__("Products By Ids", 'nasa-core'),
        "base" => "nasa_products_byids",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display products by ids.", 'nasa-core'),
        "class" => "",
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Product Ids", 'nasa-core'),
                "param_name" => "ids",
                "value" => '',
                "admin_label" => true,
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Style", 'nasa-core'),
                "param_name" => "style",
                "value" => array(
                    esc_html__('Grid', 'nasa-core') => 'grid',
                    esc_html__('Slider', 'nasa-core') => 'carousel'
                ),
                'std' => 'grid',
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number", 'nasa-core'),
                "param_name" => "columns_number",
                "value" => array(6, 5, 4, 3, 2, 1),
                "std" => 4,
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Small", 'nasa-core'),
                "param_name" => "columns_number_small",
                "value" => array(2, 1),
                "std" => 2,
                "admin_label" => true,
                "dependency" => array(
                    "element" => "style",
                    "value" => array('grid')
                )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Small", 'nasa-core'),
                "param_name" => "columns_number_small_slider",
                "value" => array('2', '1.5', '1'),
                "std" => '2',
                "admin_label" => true,
                "dependency" => array(
                    "element" => "style",
                    "value" => array('carousel')
                )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Tablet", 'nasa-core'),
                "param_name" => "columns_number_tablet",
                "value" => array(4, 3, 2, 1),
                "std" => 3,
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
