<?php

/**
 * Shortcode [nasa_rev_slider ...]
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_rev_slider($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'alias' => '',
        'alias_m' => ''
    ), $atts));
    
    if (!class_exists('RevSlider') || (!$alias && !$alias_m)) {
        return '';
    }
    
    global $nasa_opt;
    $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
    $rev = $alias_m && $inMobile ? $alias_m : $alias;
    
    if (!$rev) {
        return '';
    }
    
    return do_shortcode('[rev_slider alias="' . esc_attr($rev) . '"][/rev_slider]');
}

/**
 * Register Params
 */
function nasa_register_rev_slider(){
    $params = array(
        "name" => esc_html__("Nasa - Revo Slider", 'nasa-core'),
        "base" => "nasa_rev_slider",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Revolution Slider.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Slider', 'nasa-core'),
                "param_name" => 'alias',
                "value" => nasa_get_revsliders_arrays(),
                "std" => '',
                "admin_label" => true
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Slider - Mobile layout', 'nasa-core'),
                "param_name" => 'alias_m',
                "value" => nasa_get_revsliders_arrays(),
                "std" => '',
                "admin_label" => true
            ),
        )
    );
    
    vc_map($params);
}
