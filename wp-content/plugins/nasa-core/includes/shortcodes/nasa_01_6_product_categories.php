<?php
/**
 * Shortcode [nasa_product_categories ...]
 * 
 * @global type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_product_categories($atts = array(), $content = null) {
    global $nasa_opt;
    
    if (!NASA_WOO_ACTIVED) {
        return $content;
    }
    
    $dfAttr = array(
        'number' => '0',
        'title' => '',
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => 1,
        'parent' => '0',
        'root_cat' => '',
        'list_cats' => '',
        'disp_type' => 'Horizontal4',
        'columns_number' => '4',
        'columns_number_small' => '2',
        'columns_number_tablet' => '4',
        'number_vertical' => '2',
        'auto_slide' => 'true',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    if ($disp_type == 'Vertical') {
        /**
         * Vertical slick
         */
        wp_enqueue_script('nasa-vertical-slicks', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa-vertical-slick.min.js', array('jquery-slick'), null, true);
    }

    /**
     * Cache short-code
     */
    $key = false;
    if (isset($nasa_opt['nasa_cache_shortcodes']) && $nasa_opt['nasa_cache_shortcodes']) {
        $key = nasa_key_shortcode('nasa_product_categories', $dfAttr, $atts);
        $content = nasa_get_cache_shortcode($key);
    }
    
    if (!$content) {
        $_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
        $delay_animation_product = $_delay_item;
        $el_class = trim($el_class) != '' ? ' ' . esc_attr($el_class) : '';
        $auto_slide = $auto_slide == 'true' ? 'true' : 'false';

        $product_categories = array();
        if ($list_cats) {
            $cats = explode(',', trim($list_cats));

            if ($cats) {
                foreach ($cats as $cat) {
                    $cat = trim($cat);
                    if ($cat != '') {
                        $field = is_numeric($cat) ? 'term_id' : 'slug';
                        $term_include = get_term_by($field, $cat, 'product_cat');

                        if ($term_include) {
                            $product_categories[] = $term_include;
                        }
                    }
                }
            }
        }
        
        else {
            $hide_empty = (bool) $hide_empty ? 1 : 0;

            $args = array(
                'taxonomy' => 'product_cat',
                'orderby' => $orderby,
                'order' => $order,
                'hide_empty' => $hide_empty,
                'pad_counts' => true
            );

            if ($parent != 'false') {
                $args['parent'] = 0;
            } elseif ($root_cat) {
                if (!(int) $root_cat && trim($root_cat) !== '') {
                    $itemRoot = get_term_by('slug', trim($root_cat), 'product_cat');

                    if ($itemRoot && isset($itemRoot->term_id)) {
                        $root_cat = $itemRoot->term_id;
                    }
                }

                $args['parent'] = $root_cat;
            }

            if (
                version_compare(WC()->version, '3.3.0', ">=") &&
                (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized'])
            ) {
                $args['exclude'] = get_option('default_product_cat');
            }

            $product_categories = get_terms(apply_filters('woocommerce_product_attribute_terms', $args));
            $product_categories = (int) $number ? array_slice($product_categories, 0, (int) $number) : $product_categories;
        }

        if ($product_categories) :
            ob_start();

            if ($title): ?>
                <h3 class="section-title">
                    <?php echo esc_attr($title); ?>
                </h3>
            <?php endif; ?>

            <?php
            $disp_type = $disp_type ? strtolower($disp_type) : $disp_type;
            
            $template = 'products/nasa_product_categories/content-product_cat_' . $disp_type . '.php';
            $nasa_args = array(
                'number' => $number,
                'title' => $title,
                'orderby' => $orderby,
                'order' => $order,
                'hide_empty' => $hide_empty,
                'parent' => $parent,
                'root_cat' => $root_cat,
                'list_cats' => $list_cats,
                'disp_type' => $disp_type,
                'columns_number' => $columns_number,
                'columns_number_small' => $columns_number_small,
                'columns_number_tablet' => $columns_number_tablet,
                'number_vertical' => $number_vertical,
                'auto_slide' => $auto_slide,
                'el_class' => $el_class,
                'product_categories' => $product_categories,
                '_delay_item' => $_delay_item,
                'delay_animation_product' => $delay_animation_product,
            );

            nasa_template($template, $nasa_args);
            $content = ob_get_clean();
        endif;
        
        if ($content) {
            nasa_set_cache_shortcode($key, $content);
        }
    }
    
    return $content;
}

// **********************************************************************// 
// ! Register New Element: Product Categories
// **********************************************************************//    
function nasa_register_product_categories(){
    $products_categories_list_params = array(
        "name" => "Product Categories",
        "base" => "nasa_product_categories",
        "icon" => "icon-wpb-nasatheme",
        'description' => esc_html__("Display categories as images slide.", 'nasa-core'),
        "category" => "Nasa Core",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__('Title', 'nasa-core'),
                "param_name" => 'title'
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__('Categories Included List', 'nasa-core'),
                "param_name" => 'list_cats',
                "value" => '',
                "admin_label" => true,
                "description" => esc_html__('Input list ID or Slug, separated by ",". Ex: 1, 2 or slug-1, slug-2', 'nasa-core')
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__('Categories number for display', 'nasa-core'),
                "param_name" => 'number',
                "value" => '0'
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Display type', 'nasa-core'),
                "param_name" => 'disp_type',
                "value" => array(
                    esc_html__('Horizontal 1', 'nasa-core') => 'Horizontal1',
                    esc_html__('Horizontal 2', 'nasa-core') => 'Horizontal2',
                    esc_html__('Horizontal 3', 'nasa-core') => 'Horizontal3',
                    esc_html__('Horizontal 4', 'nasa-core') => 'Horizontal4',
                    esc_html__('Horizontal 5', 'nasa-core') => 'Horizontal5',
                    esc_html__('Horizontal 6', 'nasa-core') => 'Horizontal6',
                    esc_html__('Vertical', 'nasa-core') => 'Vertical',
                    esc_html__('Grid', 'nasa-core') => 'grid',
                ),
                "std" => 'Horizontal4',
                "admin_label" => true
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Only Show top level', 'nasa-core'),
                "param_name" => 'parent',
                "value" => array(
                    esc_html__('Yes, Please!', 'nasa-core') => 'true',
                    esc_html__('No, Thanks!', 'nasa-core') => 'false'
                ),
                "std" => 'true'
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__('Only show child of (Product category id or slug)', 'nasa-core'),
                "param_name" => "root_cat",
                "std" => '',
                "dependency" => array(
                    "element" => "parent",
                    "value" => array(
                        "false"
                    )
                )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Hide empty categories', 'nasa-core'),
                "param_name" => 'hide_empty',
                "value" => array(
                    esc_html__('Yes, Please!', 'nasa-core') => '1',
                    esc_html__('No, Thanks!', 'nasa-core') => '0'
                ),
                "std" => '1'
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Columns Number', 'nasa-core'),
                "param_name" => 'columns_number',
                "value" => array(10, 9, 8, 7, 6, 5, 4, 3, 2),
                "std" => 4,
                "dependency" => array(
                    "element" => "disp_type",
                    "value" => array(
                        "Horizontal1",
                        "Horizontal2",
                        "Horizontal3",
                        "Horizontal4",
                        "Horizontal5",
                        "Horizontal6",
                        "grid"
                    )
                )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Small", 'nasa-core'),
                "param_name" => "columns_number_small",
                "value" => array(3, 2, 1),
                "std" => 2,
                "dependency" => array(
                    "element" => "disp_type",
                    "value" => array(
                        "Horizontal1",
                        "Horizontal2",
                        "Horizontal3",
                        "Horizontal4",
                        "Horizontal5",
                        "Horizontal6",
                        "grid"
                    )
                )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Tablet", 'nasa-core'),
                "param_name" => "columns_number_tablet",
                "value" => array(4, 3, 2, 1),
                "std" => 4,
                "dependency" => array(
                    "element" => "disp_type",
                    "value" => array(
                        "Horizontal1",
                        "Horizontal2",
                        "Horizontal3",
                        "Horizontal4",
                        "Horizontal5",
                        "Horizontal6",
                        "grid"
                    )
                )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Items show vertical', 'nasa-core'),
                "param_name" => 'number_vertical',
                "value" => array(4, 3, 2, 1),
                "dependency" => array(
                    "element" => "disp_type",
                    "value" => array(
                        "Vertical"
                    )
                )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Slide Auto', 'nasa-core'),
                "param_name" => 'auto_slide',
                "value" => array(
                    esc_html__('Yes, Please!', 'nasa-core') => 'true',
                    esc_html__('No, Thanks!', 'nasa-core') => 'false'
                ),
                "std" => 'true'
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nasa-core')
            )
        )
    );

    vc_map($products_categories_list_params);
}
