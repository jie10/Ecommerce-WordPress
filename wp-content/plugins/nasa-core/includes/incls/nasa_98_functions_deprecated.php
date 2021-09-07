<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Deprecated
 * 
 * @param type $atts
 * @return string
 */
function nasa_shortcode_vars($atts) {
    $variables = array();
    
    if (!empty($atts)) {
        $old_key = '';
        foreach ($atts as $value) {
            $value = explode('=', $value);
            $count = count($value);
            
            if ($count == 2) {
                $old_key = $value[0];
                $variables[$old_key] = str_replace('"', '', $value[1]);
            } 
            
            if ($count == 1) {
                $variables[$old_key] .= ' ' . str_replace('"', '', $value[0]);
            }
        }
    }

    return $variables;
}

/**
 * Deprecated
 * 
 * @param type $atts
 * @return string
 */
function nasa_shortcode_text($name = '', $atts = array(), $content = '') {
    global $id_shortcode;
    $GLOBALS['id_shortcode'] = (!isset($id_shortcode) || !$id_shortcode) ? 1 : $id_shortcode + 1;
    $height = (isset($atts['min_height']) && (int) $atts['min_height']) ? (int) $atts['min_height'] . 'px;' : '200px;';
    $height .= (isset($atts['height']) && (int) $atts['height']) ? 'height:' . (int) $atts['height'] . 'px;' : '';
    $attsSC = array();
    if (!empty($atts)) {
        foreach ($atts as $key => $value) {
            $attsSC[] = $key . '="' . $value . '"';
        }
    }

    $result = '<div class="nasa_load_ajax" data-id="' . $id_shortcode . '" id="nasa_sc_' . $id_shortcode . '" data-shortcode="' . $name . '" style="min-height: ' . $height . '">';

    $result .= '<div class="nasa-loader"></div>';
    $result .= '<div class="nasa-shortcode-content hidden-tag">[' . $name;
    $result .= !empty($attsSC) ? ' ' . implode(' ', $attsSC) : '';
    $result .= trim($content) != '' ? ']' . esc_html($content) . '[/' . $name : '';
    $result .= ']</div></div>';

    return $result;
}
