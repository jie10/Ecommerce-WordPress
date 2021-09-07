<?php
/**
 * Shortcode [vc_row]
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_vc_row($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'el_class'              => '',
        'css_animation'         => '',
        'equal_height'          => '',
        'content_placement'     => '',
        'fullwidth'             => '0',
        'parallax'              => '',
        'parallax_speed_bg'     => '1',
        'parallax_speed_video'  => '1',
        'parallax_image'        => '',
        'css'                   => '',
        'disable_element'       => '',
        'el_id'                 => ''
    ), $atts));
    
    $output = '';
    $wrapper_attributes = array();
    $css_classes = array(
        'section-element',
        nasa_vc_shortcode_custom_css_class($css)
    );

    if ($el_id != '') {
        $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    }
    
    if ($el_class != '') {
        $css_classes[] = $el_class;
    }
    
    if ($disable_element == 'yes') {
        $css_classes[] = 'hidden-tag';
    }
    
    if (!empty($equal_height)) {
        $css_classes[] = 'nasa-row-cols-equal-height';
    }
    
    $wrapper_attributes[] = !empty($content_placement) ?
        'data-content_placement="' . $content_placement . '"' : 'data-content_placement="top"';
    
    $css_class = preg_replace(
        '/\s+/',
        ' ',
        apply_filters(
            'nasa_shortcodes_css_class',
            implode(' ', array_filter(array_unique($css_classes))),
            'vc_row',
            $atts
        )
    );
    
    $wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';
    
    $output .= '<div ' . implode(' ', $wrapper_attributes) . '>';
    $output .= ($fullwidth == '1') ? '<div class="nasa-row fullwidth clearfix">' : '<div class="row">';
    $output .= do_shortcode(shortcode_unautop($content));
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
}

/**
 * Shortcode [vc_row_inner]
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_vc_row_inner($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'el_class'              => '',
        'el_id'                 => ''
    ), $atts));
    
    $wrapper_attributes = array();
    if ($el_id) {
        $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    }
    
    $classes = 'row';
    $classes .= $el_class ? ' ' . $el_class : '';
    $wrapper_attributes[] = 'class="' . esc_attr($classes). '"';
    
    $output = '<div ' . implode(' ', $wrapper_attributes) . '>';
    $output .= do_shortcode(shortcode_unautop($content));
    $output .= '</div>';
    
    return $output;
}
