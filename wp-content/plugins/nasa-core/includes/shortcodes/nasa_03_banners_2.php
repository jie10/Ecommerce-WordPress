<?php
/**
 * Shortcode [nasa_banner_2]...[/nasa_banner_2]
 * 
 * @param type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_banners_2($atts = array(), $content = null) {
    global $nasa_opt;
    
    $dfAtts = array(
        'align' => 'left',
        'valign' => 'top',
        'move_x' => '',
        'link' => '',
        'hover' => '',
        'banner_style' => '',
        'img' => '',
        'img_src' => '',
        'text_align' => '',
        'content_width' => '',
        'effect_text' => 'fadeIn',
        'data_delay' => '0ms',
        'border_inner' => 'no',
        'border_outner' => 'no',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAtts, $atts));
    
    $image = wp_get_attachment_image_src($img_src, 'full');
    
    if (!$image) {
        return '';
    }
    
    $class_woo = (!isset($nasa_opt['disable_wow']) || !$nasa_opt['disable_wow']) ? '' : ' animated';

    $a_class = 'nasa-banner-content banner-content';
    $a_class .= $align != '' ? ' align-' . $align : '';
    $a_class .= $valign != '' ? ' valign-' . $valign : '';
    $a_class .= $text_align != '' ? ' ' . $text_align : '';
    
    $class_wrap = 'banner nasa-banner nasa-banner-v2';
    $class_wrap .= $border_outner == 'yes' ? ' has-border-outner' : '';
    $class_wrap .= $border_inner == 'yes' ? ' has-border-inner' : '';
    $class_wrap .= $hover != '' ? ' hover-' . $hover : '';
    $class_wrap .= $el_class != '' ? ' ' . $el_class : '';
    
    $data_attrs = $data_delay != '' ? ' data-wow-delay="' . $data_delay . '"' : '';
    if ($link != '') {
        $a_class .= ' cursor-pointer';
        $data_attrs .= ' onclick="window.location=\'' . esc_url($link) . '\'"';
    }
    
    $ct_attrs = array();
    
    if ($content_width != '') {
        $ct_attrs[] = 'width: ' . $content_width;
    }
    
    if ($move_x != '') {
        if ($align == 'left') {
            $ct_attrs[] = 'left: ' . $move_x;
        }
        
        if ($align == 'right') {
            $ct_attrs[] = 'right: ' . $move_x;
        }
    }
    
    $ct_attrs_str = !empty($ct_attrs) ? ' style="' . implode('; ', $ct_attrs) . '"' : '';
    
    /**
     * Image banner
     */
    $content_data = '<img class="banner-img nasa-banner-image" width="' . $image[1] . '" height="' . $image[2] . '" alt="' . trim(strip_tags(get_post_meta($img_src, '_wp_attachment_image_alt', true))) . '" src="' . esc_url($image[0]) . '" />';
    
    /**
     * Content Banner
     */
    $content_data .= trim($content) ?
        '<div class="' . $a_class . '"' . $ct_attrs_str . '>' .
            '<div class="banner-inner nasa-transition wow ' . $effect_text . $class_woo . '" data-animation="' . $effect_text . '">' . 
                nasa_fix_shortcode($content) .
            '</div>' .
        '</div>' : '';

    /**
     * Return Banner v2
     */
    return 
    '<div class="' . $class_wrap . '"'. $data_attrs . '>' .
        $content_data .
    '</div>';
}

// **********************************************************************// 
// ! Register New Element: Banner v2
// **********************************************************************//
function nasa_register_banner_2(){
    $banner_params = array(
        'name' => 'Banner v2',
        'base' => 'nasa_banner_2',
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display Banner v2", 'nasa-core'),
        'category' => 'Nasa Core',
        'as_parent' => array('except' => 'nasa_banner'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
        'params' => array(
            array(
                'type' => 'attach_image',
                "heading" => esc_html__("Banner Image", 'nasa-core'),
                "param_name" => "img_src",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Link", 'nasa-core'),
                "edit_field_class" => "vc_col-sm-6 vc_column",
                "param_name" => "link"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Content Width (%)", 'nasa-core'),
                "edit_field_class" => "vc_col-sm-6 vc_column",
                "param_name" => "content_width",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Horizontal Alignment", 'nasa-core'),
                "param_name" => "align",
                "edit_field_class" => "vc_col-sm-6 vc_column",
                "value" => array(
                    esc_html__("Left", 'nasa-core') => "left",
                    esc_html__("Center", 'nasa-core') => "center",
                    esc_html__("Right", 'nasa-core') => "right"
                )
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Move Horizontal a distance (%)", "nasa-core"),
                "param_name" => "move_x",
                "value" => "",
                "edit_field_class" => "vc_col-sm-6 vc_column",
                "dependency" => array(
                    "element" => "align",
                    "value" => array(
                        "left",
                        "right"
                    )
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Vertical Alignment", 'nasa-core'),
                "param_name" => "valign",
                "edit_field_class" => "vc_col-sm-6 vc_column",
                "value" => array(
                    esc_html__("Top", 'nasa-core') => "top",
                    esc_html__("Middle", 'nasa-core') => "middle",
                    esc_html__("Bottom", 'nasa-core') => "bottom"
                )
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Text Alignment", "nasa-core"),
                "param_name" => "text_align",
                "edit_field_class" => "vc_col-sm-6 vc_column",
                "value" => array(
                    esc_html__("Left", 'nasa-core') => "text-left",
                    esc_html__("Center", 'nasa-core') => "text-center",
                    esc_html__("Right", 'nasa-core') => "text-right"
                )
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Banner Content", 'nasa-core'),
                "param_name" => "content",
                "value" => "",
            ),
            array(
                "type" => "animation_style",
                "heading" => esc_html__("Effect Content", 'nasa-core'),
                "param_name" => "effect_text",
                "value" => "fadeIn"
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Animation Delay', 'nasa-core'),
                "param_name" => "data_delay",
                "value" => array(
                    esc_html__('None', 'nasa-core') => '',
                    esc_html__('0.1s', 'nasa-core') => '100ms',
                    esc_html__('0.2s', 'nasa-core') => '200ms',
                    esc_html__('0.3s', 'nasa-core') => '300ms',
                    esc_html__('0.4s', 'nasa-core') => '400ms',
                    esc_html__('0.5s', 'nasa-core') => '500ms',
                    esc_html__('0.6s', 'nasa-core') => '600ms',
                    esc_html__('0.7s', 'nasa-core') => '700ms',
                    esc_html__('0.8s', 'nasa-core') => '800ms',
                    esc_html__('0.9s', 'nasa-core') => '900ms',
                    esc_html__('1.0s', 'nasa-core') => '1000ms',
                )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Effect Image", 'nasa-core'),
                "param_name" => "hover",
                "value" => array(
                    esc_html__('None', 'nasa-core') => '',
                    esc_html__('Zoom', 'nasa-core') => 'zoom',
                    esc_html__('Zoom Out', 'nasa-core') => 'reduction',
                    esc_html__('Fade', 'nasa-core') => 'fade'
                )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Border Inner", 'nasa-core'),
                "param_name" => "border_inner",
                "value" => array(
                    esc_html__('Yes', 'nasa-core') => 'yes',
                    esc_html__('No', 'nasa-core') => 'no'
                ),
                "std" => 'no'
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Border Outner", 'nasa-core'),
                "param_name" => "border_outner",
                "value" => array(
                    esc_html__('Yes', 'nasa-core') => 'yes',
                    esc_html__('No', 'nasa-core') => 'no'
                ),
                "std" => 'no'
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nasa-core')
            )
        )
    );

    vc_map($banner_params);
}