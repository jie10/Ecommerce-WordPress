<?php
/**
 * Shortcode [nasa_pin_material_banner ...]
 * 
 * @global type $nasa_pin_sc
 * @global type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_pin_material_banner($atts = array(), $content = null) {
    global $nasa_opt, $nasa_pin_sc;
    
    if (!isset($nasa_pin_sc) || !$nasa_pin_sc) {
        $nasa_pin_sc = 1;
    }
    $GLOBALS['nasa_pin_sc'] = $nasa_pin_sc + 1;
    
    $dfAttr = array(
        'pin_slug' => '',
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
    
    $post_pin_banner = get_posts(array(
        'name'              => $pin_slug,
        'post_status'       => 'publish',
        'post_type'         => 'nasa_pin_mb',
        'numberposts'       => 1
    ));
    if (!$post_pin_banner) {
        return $content;
    }
    
    /**
     * enqueue Js
     */
    wp_enqueue_script('jquery-easing', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.easing.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-easypin', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.easypin.min.js', array('jquery'), null, true);
    
    $pin = $post_pin_banner[0];
    $content = '';
    // Get current image.
    $attachment_id = get_post_meta($pin->ID, 'nasa_pin_mb_image_url', true);
    if ($attachment_id) {
        // Get image source.
        $image_src = wp_get_attachment_url($attachment_id);
        $pin_rand_id = 'nasa_pin_' . $nasa_pin_sc;
        $data = array(
            $pin_rand_id => array()
        );
        $_width = get_post_meta($pin->ID, 'nasa_pin_mb_image_width', true);
        $_height = get_post_meta($pin->ID, 'nasa_pin_mb_image_height', true);
        $_options = get_post_meta($pin->ID, 'nasa_pin_mb_options', true);

        $_optionsArr = json_decode($_options);
        
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
        
        $icon = '<i class="nasa-marker-icon fa fa-plus"' . $icon_style . '></i>';
        $popover = ' popover-plus-wrap';

        $k = 0;
        if (is_array($_optionsArr) && !empty($_optionsArr)) {
            foreach ($_optionsArr as $option) {
                if (!isset($option->coords) || !isset($option->content)) {
                    continue;
                }
                
                $position_show = isset($option->position_show) ? $option->position_show : 'top';

                $data[$pin_rand_id][$k] = array(
                    'marker_pin' => $icon,
                    'position' => 'nasa-' . $position_show,
                    'content_material' => $option->content,
                    'coords' => $option->coords
                );

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

        $content .= '<div class="nasa-inner-wrap nasa-pin-wrap nasa-pin-material-banner-wrap' . $effect_class . '" data-pin="' . esc_attr($data_pin) . '">';

        $content .= '<span class="nasa-wrap-relative-image">' .
            '<img width="' . $_width . '" height="' . $_height . '" class="nasa_pin_mb_image" src="' . esc_url($image_src) . '" data-easypin_id="' . $pin_rand_id . '" alt="' . esc_attr($pin->post_title) . '" />' .
        '</span>';
        $content .= '<div style="display:none;" id="tpl-' . $pin_rand_id . '" class="nasa-easypin-tpl">';
        $content .= 
        '<div class="nasa-popover-clone">' .
            '<div class="{[position]}' . $popover . '">' .
                '<div class="nasa-material-pin text-center">' .
                    '{[content_material]}' .
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
// ! Register New Element: Material banner
// **********************************************************************//
function nasa_register_material_banner(){
    $material_banner_params = array(
        "name" => "Material Banner",
        "base" => "nasa_pin_material_banner",
        "icon" => "icon-wpb-nasatheme",
        'description' => esc_html__("Display material pin banner.", 'nasa-core'),
        "category" => "Nasa Core",
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Select Pin', 'nasa-core'),
                "param_name" => 'pin_slug',
                "value" => nasa_get_pin_arrays('nasa_pin_mb'),
                "std" => '',
                "admin_label" => true
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
    vc_map($material_banner_params);
}
