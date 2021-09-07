<?php
/**
 * Shortcode [vc_column_text]
 */
function nasa_sc_vc_column_text($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'el_class' => '',
        'el_id'    => '',
    ), $atts));
    
    $wrapper_attributes = array();
    if (!empty($el_id)) {
        $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    }
    
    $classes = 'wpb_text_column wpb_content_element';
    $classes .= !empty($el_class) ? ' ' . $el_class : '';
    $wrapper_attributes[] = ' class="' . $classes . '"';

    $content = $content ? wpautop(preg_replace('/<\/?p\>/', "\n", $content) . "\n") : $content;
    $output = '<div ' . implode( ' ', $wrapper_attributes ) . '>';
    $output .= do_shortcode(shortcode_unautop($content));
    $output .= '</div>';
    
    return $output;
}

/**
 * Shortcode [vc_single_image]
 */
function nasa_sc_vc_single_image($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'image' => '',
        'link' => '',
        'img_link_target' => '',
        'alignment' => '',
        'el_class' => '',
    ), $atts));
    
    $argc = array(
        'link_text' => $link,
        'link_target' => $img_link_target,
        'alt' => '',
        'image' => $image,
        'align' => $alignment,
        'el_class' => $el_class
    );
    
    return nasa_sc_image($argc, $content);
}
