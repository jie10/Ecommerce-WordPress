<?php
/**
 * Shortcode [nasa_pin_products_banner ...]
 * 
 * @global type $nasa_pin_sc
 * @global type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_pin_products_banner($atts = array(), $content = null) {
    global $nasa_opt, $nasa_pin_sc;
    
    if (!isset($nasa_pin_sc) || !$nasa_pin_sc) {
        $nasa_pin_sc = 1;
    }
    $GLOBALS['nasa_pin_sc'] = $nasa_pin_sc + 1;
    
    if (!NASA_WOO_ACTIVED) {
        return $content;
    }
    
    $dfAttr = array(
        'pin_slug' => '',
        'marker_style' => 'price',
        'full_price_icon' => 'no',
        'price_rounding' => 'yes',
        'show_img' => 'no',
        'show_price' => 'no',
        'pin_effect' => 'default',
        'bg_icon' => '',
        'txt_color' => '',
        'border_icon' => '',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));

    if ($pin_slug === '') {
        return $content;
    }
    
    $post_pin_product_banner = get_posts(array(
        'name'              => $pin_slug,
        'post_status'       => 'publish',
        'post_type'         => 'nasa_pin_pb',
        'numberposts'       => 1
    ));
    if (!$post_pin_product_banner) {
        return $content;
    }
    
    /**
     * Pin Banner
     */
    wp_enqueue_script('jquery-easing', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.easing.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-easypin', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.easypin.min.js', array('jquery'), null, true);
    
    $pin = $post_pin_product_banner[0];
    $content = '';
    // Get current image.
    $attachment_id = get_post_meta($pin->ID, 'nasa_pin_pb_image_url', true);
    if ($attachment_id) {
        // Get image source.
        $image_src = wp_get_attachment_url($attachment_id);
        $pin_rand_id = 'nasa_pin_' . $nasa_pin_sc;
        $data = array(
            $pin_rand_id => array()
        );
        $_width = get_post_meta($pin->ID, 'nasa_pin_pb_image_width', true);
        $_height = get_post_meta($pin->ID, 'nasa_pin_pb_image_height', true);
        $_options = get_post_meta($pin->ID, 'nasa_pin_pb_options', true);

        $_optionsArr = json_decode($_options);

        if (!isset($marker_style) || !in_array($marker_style, array('price', 'plus'))) {
            $marker_style = 'price';
        }

        $popover = '';
        $icon = '';
        $style = 'width:35px;height:35px;';
        $icon_style = '';
        if ($bg_icon != '' || $txt_color != '' || $border_icon != '') {
            $icon_style .= ' style="';
            $icon_style .= $bg_icon != '' ? 'background-color:' . $bg_icon . ';' : '';
            $icon_style .= $txt_color != '' ? 'color:' . $txt_color . ';' : '';
            $icon_style .= $border_icon != '' ? 'border-color:' . $border_icon . ';' : '';
            $icon_style .= '" ';
        }

        $effect_style = $bg_icon != '' ? ' style="background-color:' . $bg_icon . ';"' : '';

        switch ($marker_style) {
            case 'plus':
                $icon = '<i class="nasa-marker-icon fa fa-plus"' . $icon_style . '></i>';
                $popover = ' popover-plus-wrap';
                break;

            case 'price':
            default:
                $style = 'min-width:40px;height:40px;';
                break;
        }

        $k = 0;
        $price_html = array();
        if (is_array($_optionsArr) && !empty($_optionsArr)) {
            foreach ($_optionsArr as $option) {
                $product_id = $option->product_id;
                $product = wc_get_product($product_id);
                if (!isset($option->coords) || !$product || $product->get_status() !== 'publish') {
                    continue;
                }
                
                $position_show = isset($option->position_show) ? $option->position_show : 'top';

                if ($marker_style == 'price') {
                    if ($full_price_icon == 'yes') {
                        $icon = '<span class="nasa-marker-icon-bg"' . $icon_style . '>' . $product->get_price_html() . '</span>';
                    } else {
                        if ($product->get_type() == 'variable') {
                            $price_sale = $product->get_variation_sale_price();
                            $price = !$price_sale ? $product->get_variation_regular_price() : $price_sale;
                        } else {
                            $price_sale = $product->get_sale_price();
                            $price = !$price_sale ? $product->get_regular_price() : $price_sale;
                        }

                        $args_price = $price_rounding == 'yes' ? array('decimals' => 0) : array();
                        $icon = '<span class="nasa-marker-icon-bg"' . $icon_style . '>' . wc_price($price, $args_price) . '</span>';
                        
                    }
                }

                $data[$pin_rand_id][$k] = array(
                    'marker_pin' => $icon,
                    'position' => 'nasa-' . $position_show,
                    'id_product' => $product_id,
                    'title_product' => $product->get_name(),
                    'link_product' => esc_url($product->get_permalink()),
                    'img_product' => $product->get_image('shop_catalog'),
                    'coords' => $option->coords
                );

                if (!isset($price_html[$product_id])) {
                    $price_html[$product_id] = $product->get_price_html();
                }

                $k++;
            }
        }

        $canvas = array(
            'src' => $image_src,
            'width' => $_width,
            'height' => $_height
        );

        $data[$pin_rand_id]['canvas'] = $canvas;

        $data_pin = wp_json_encode($data);

        if ($pin_effect == 'default') {
            $effect_class = isset($nasa_opt['effect_pin_product_banner']) && $nasa_opt['effect_pin_product_banner'] ? ' nasa-has-effect' : '';
        } else {
            $effect_class = $pin_effect == 'yes' ? ' nasa-has-effect' : '';
        }

        $effect_class .= $el_class != '' ? ' ' . $el_class : '';

        $content .= '<div class="nasa-inner-wrap nasa-pin-wrap nasa-pin-banner-wrap' . $effect_class . '" data-pin="' . esc_attr($data_pin) . '">';
        if (!empty($price_html)) {
            foreach ($price_html as $k => $price_product) {
                $content .= '<div class="hidden-tag nasa-price-pin-' . $k . '">' . $price_product . '</div>';
            }
        }

        $content .= '<span class="nasa-wrap-relative-image">' .
            '<img width="' . $_width . '" height="' . $_height . '" class="nasa_pin_pb_image" src="' . esc_url($image_src) . '" data-easypin_id="' . $pin_rand_id . '" alt="' . esc_attr($pin->post_title) . '" />' .
        '</span>';
        $content .= '<div style="display:none;" id="tpl-' . $pin_rand_id . '" class="nasa-easypin-tpl">';
        $content .= 
        '<div class="nasa-popover-clone">' .
            '<div class="{[position]}' . $popover . '">' .
                '<div class="nasa-product-pin text-center">' .
                    '<a title="{[title_product]}" href="{[link_product]}">' .
                        ($show_img === 'yes' ? '<div class="image-wrap">{[img_product]}</div>' : '') .
                        '<h5 class="title-wrap">' .
                            '{[title_product]}' .
                        '</h5>' .
                    '</a>' .
                    ($show_price === 'yes' ? '<div class="price nasa-price-pin" data-product_id="{[id_product]}"></div>' : '') .
                '</div>' .
            '</div>' .
        '</div>' .
        '<div class="nasa-marker-clone">' .
            '<div style="' . $style . '">' .
                '<span class="nasa-marker-icon-wrap">{[marker_pin]}<span class="nasa-action-effect"' . $effect_style . '></span></span>' .
            '</div>' .
        '</div>'; 
        $content .= '</div>';
        $content .= '</div>';
    }
    
    return $content;
}

// **********************************************************************// 
// ! Register New Element: Products banner
// **********************************************************************//
function nasa_register_products_banner(){
    $products_banner_params = array(
        "name" => "Products Banner",
        "base" => "nasa_pin_products_banner",
        "icon" => "icon-wpb-nasatheme",
        'description' => esc_html__("Display products pin banner.", 'nasa-core'),
        "category" => "Nasa Core",
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Select Pin', 'nasa-core'),
                "param_name" => 'pin_slug',
                "value" => nasa_get_pin_arrays('nasa_pin_pb'),
                "std" => '',
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Marker Style", 'nasa-core'),
                "param_name" => "marker_style",
                "value" => array(
                    esc_html__('Price icon', 'nasa-core') => 'price',
                    esc_html__('Plus icon', 'nasa-core') => 'plus'
                ),
                "std" => 'price',
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Marker Full Price", 'nasa-core'),
                "param_name" => "full_price_icon",
                "value" => array(
                    esc_html__('No', 'nasa-core') => 'no',
                    esc_html__('Yes', 'nasa-core') => 'yes'
                ),

                "dependency" => array(
                    "element" => "marker_style",
                    "value" => array('price')
                ),

                "std" => 'no',
                "admin_label" => true
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Price Rounding", 'nasa-core'),
                "param_name" => "price_rounding",
                "value" => array(
                    esc_html__('No', 'nasa-core') => 'no',
                    esc_html__('Yes', 'nasa-core') => 'yes'
                ),

                "dependency" => array(
                    "element" => "marker_style",
                    "value" => array('price')
                ),

                "std" => 'yes',
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Show Image", 'nasa-core'),
                "param_name" => "show_img",
                "value" => array(
                    esc_html__('No', 'nasa-core') => 'no',
                    esc_html__('Yes', 'nasa-core') => 'yes'
                ),
                "std" => 'no'
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Show Price", 'nasa-core'),
                "param_name" => "show_price",
                "value" => array(
                    esc_html__('No', 'nasa-core') => 'no',
                    esc_html__('Yes', 'nasa-core') => 'yes'
                ),
                "std" => 'no'
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Effect icons", 'nasa-core'),
                "param_name" => "pin_effect",
                "value" => array(
                    esc_html__('Default', 'nasa-core') => 'default',
                    esc_html__('Yes', 'nasa-core') => 'yes',
                    esc_html__('No', 'nasa-core') => 'no'
                ),
                "std" => 'default'
            ),

            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Background icon", 'nasa-core'),
                "param_name" => "bg_icon",
                "value" => ""
            ),

            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Text color icon", 'nasa-core'),
                "param_name" => "txt_color",
                "value" => ""
            ),

            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Border color icon", 'nasa-core'),
                "param_name" => "border_icon",
                "value" => ""
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nasa-core')
            )
        )
    );
    vc_map($products_banner_params);
}
