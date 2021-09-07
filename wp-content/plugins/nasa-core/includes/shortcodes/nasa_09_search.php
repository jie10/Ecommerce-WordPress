<?php
/**
 * Shortcode [nasa_search_posts ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_search_post($atts = array(), $content = null) {
    $dfAttr = array(
        "label_search" => 'Search Posts',
        "btn_text" => 'Search',
        "post_type" => 'post',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    global $nasa_pin_sc;
    
    if (!isset($nasa_pin_sc) || !$nasa_pin_sc) {
        $nasa_pin_sc = 1;
    }
    $GLOBALS['nasa_pin_sc'] = $nasa_pin_sc + 1;
    
    $el_class = $el_class != '' ? 'nasa-search-form-warp ' . $el_class : 'nasa-search-form-warp';
    
    $_id = rand();
    
    $content =
    '<div class="' . esc_attr($el_class) . '">' .
        '<form method="get" action="' . esc_url(home_url('/')) . '" class="nasa-search-post-form">' .
            '<div class="nasa-search-post-wrap">' .
                '<label class="nasa-search-post-label">' .
                    $label_search .
                '</label>' .
                '<input id="nasa-input-' . esc_attr($nasa_pin_sc) . '" type="text" class="nasa-search-input" value="' . get_search_query() . '" name="s" placeholder="' . esc_attr__("Search ...", 'nasa-core') . '" />' .
                '<input type="hidden" name="post_type" value="' . esc_attr($post_type) . '" />' .
                '<span class="nasa-icon-submit-page">' .
                    '<input type="submit" name="page" value="' . esc_attr($btn_text) . '" />' .
                '</span>' .
            '</div>' .
        '</form>' .
    '</div>';
    
    return $content;
}
 
function nasa_register_search_posts(){
    $params = array(
        "name" => esc_html__("Search", 'nasa-core'),
        "base" => "nasa_search_posts",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display form search.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__('Label', 'nasa-core'),
                "param_name" => "label_search",
                "std" => 'Search'
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__('Button text', 'nasa-core'),
                "param_name" => "btn_text",
                "std" => 'Search'
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Post Type", 'nasa-core'),
                "param_name" => "post_type",
                "value" => array(
                    esc_html__('Products - WooCommerce', 'nasa-core') => 'product',
                    esc_html__('Posts - Blogs', 'nasa-core') => 'post'
                ),
                "std" => 'post'
            ),
        )
    );

    vc_map($params);
}
