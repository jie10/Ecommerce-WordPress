<?php
/**
 * Shortcode [vc_column]
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_vc_column($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'font_color' => '',
        'width' => '1/1',
        'width_side' => '',
        'css' => '',
        'offset' => '',
        'css_animation' => '',
        'parallax' => '',
        'parallax_speed_bg' => '1',
        'parallax_speed_video' => '1',
        'parallax_image' => '',
        'el_class' => '',
        'el_id' => ''
    ), $atts));
    
    $output = '';
    $wrapper_attributes = array();
    if ($el_id != '') {
        $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    }

    $width = nasa_vc_translateColumnWidthToSpan($width);
    $width = nasa_vc_column_offset_class_merge($offset, $width);
    
    $css_classes = array(
        'wpb_column',
        'vc_column_container',
        $width,
        nasa_vc_shortcode_custom_css_class($css)
    );

    if ($el_class != '') {
        $css_classes[] = $el_class;
    }
    
    /**
     * Add class Full width to side
     */
    if ($width_side != '') {
        $css_classes[] = 'nasa-full-to-' . esc_attr($width_side);
    }
    
    $css_class = preg_replace(
        '/\s+/',
        ' ',
        apply_filters(
            'nasa_shortcodes_css_class',
            implode(' ', array_filter(array_unique($css_classes))),
            'vc_column',
            $atts
        )
    );

    $wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';

    $output .= '<div ' . implode(' ', $wrapper_attributes) . '>';
    $output .= do_shortcode(shortcode_unautop($content));
    $output .= '</div>';
    
    return $output;
}

/**
 * Shortcode [vc_column_inner]
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_vc_column_inner($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'width' => '1/1',
        'css' => '',
        'offset' => '',
        'el_class' => '',
        'el_id' => ''
    ), $atts));
    
    $output = '';
    $wrapper_attributes = array();
    if ($el_id != '') {
        $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    }

    $width = nasa_vc_translateColumnWidthToSpan($width);
    $width = nasa_vc_column_offset_class_merge($offset, $width);
    
    $css_classes = array(
        'wpb_column',
        'vc_column_container',
        $width,
        nasa_vc_shortcode_custom_css_class($css)
    );

    if ($el_class != '') {
        $css_classes[] = $el_class;
    }
    
    $css_class = preg_replace(
        '/\s+/',
        ' ',
        apply_filters(
            'nasa_shortcodes_css_class',
            implode(' ', array_filter(array_unique($css_classes))),
            'vc_column',
            $atts
        )
    );

    $wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';

    $output .= '<div ' . implode(' ', $wrapper_attributes) . '>';
    $output .= do_shortcode(shortcode_unautop($content));
    $output .= '</div>';
    
    return $output;
}
