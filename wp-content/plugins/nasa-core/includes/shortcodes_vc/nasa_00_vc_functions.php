<?php
/**
 * Init Shortcodes
 */
add_action('init', 'nasa_init_vc_shortcodes');
function nasa_init_vc_shortcodes() {
    /**
     * Deactive WPBakery Page builder
     */
    add_shortcode('vc_column_text', 'nasa_sc_vc_column_text');
    add_shortcode('vc_single_image', 'nasa_sc_vc_single_image');
    add_shortcode('vc_row', 'nasa_sc_vc_row');
    add_shortcode('vc_row_inner', 'nasa_sc_vc_row_inner');
    add_shortcode('vc_column', 'nasa_sc_vc_column');
    add_shortcode('vc_column_inner', 'nasa_sc_vc_column_inner');
    add_shortcode('vc_tta_tabs', 'nasa_sc_vc_tta_tabs');
    add_shortcode('vc_tta_section', 'nasa_sc_vc_tta_section');
}

/**
 * @param $param_value
 * @param string $prefix
 *
 * @return string
 */
function nasa_vc_shortcode_custom_css_class($param_value, $prefix = '') {
    $css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value) ? $prefix . preg_replace('/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value) : '';

    return $css_class;
}

/**
 * @param $width
 *
 * @return bool|string
 */
function nasa_vc_translateColumnWidthToSpan($width) {
    $output = $width;
    preg_match('/(\d+)\/(\d+)/', $width, $matches);

    if (!empty($matches)) {
        $part_x = (int) $matches[1];
        $part_y = (int) $matches[2];
        if ($part_x > 0 && $part_y > 0) {
            $value = ceil($part_x / $part_y * 12);
            if ($value > 0 && $value <= 12) {
                $output = 'vc_col-sm-' . $value;
            }
        }
    }
    if (preg_match( '/\d+\/5$/', $width)) {
        $output = 'vc_col-sm-' . $width;
    }

    return apply_filters('vc_translate_column_width_class', $output, $width);
}

/**
 * @param $column_offset
 * @param $width
 *
 * @return mixed|string
 */
function nasa_vc_column_offset_class_merge($column_offset, $width) {
    if (preg_match('/vc_col\-sm\-\d+/', $column_offset)) {
        return $column_offset;
    }

    return $width . (empty($column_offset) ? '' : ' ' . $column_offset);
}
