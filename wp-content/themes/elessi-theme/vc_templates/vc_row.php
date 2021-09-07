<?php
$output = '';
$base_row = $this->settings('base');
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract(shortcode_atts(array(
    'el_class'              => '',
    'css_animation'         => '',
    'equal_height'          => '',
    'content_placement'     => '',
    'fullwidth'             => '0',
    'hide_in_mobile'        => '0',
    'parallax'              => '',
    'parallax_speed_bg'     => '1',
    'parallax_speed_video'  => '1',
    'parallax_image'        => '',
    'video_bg'              => false,
    'video_bg_url'          => '',
    'video_bg_parallax'     => '',
    'css'                   => '',
    'disable_element'       => '',
    'el_id'                 => ''
), $atts));

global $nasa_opt;
if ($hide_in_mobile && isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
    echo '<!-- Element Hide in Mobile -->';
}

else {
    $wrapper_attributes = array();
    $css_classes = array(
        'section-element',
        vc_shortcode_custom_css_class($css)
    );

    if ($el_id != '') {
        $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    }

    $el_class = $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
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

    $has_video_bg = ($video_bg && $video_bg_url && vc_extract_youtube_id($video_bg_url)) ? true : false;
    $parallax_speed = $parallax_speed_bg;
    if ($has_video_bg) {
        $parallax = $video_bg_parallax;
        $parallax_speed = $parallax_speed_video;
        $parallax_image = $video_bg_url;
        $css_classes[] = 'vc_video-bg-container nasa-relative';
        wp_enqueue_script('vc_youtube_iframe_api_js');
    }

    // Support js parallax
    if (!empty($parallax)) {
        wp_enqueue_script('vc_jquery_skrollr_js');
        $wrapper_attributes[] = 'data-vc-parallax="' . esc_attr($parallax_speed) . '"'; // parallax speed
        $css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
        if (false !== strpos($parallax, 'fade')) {
            $css_classes[] = 'js-vc_parallax-o-fade';
            $wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
        } elseif (false !== strpos($parallax, 'fixed')) {
            $css_classes[] = 'js-vc_parallax-o-fixed';
        }
    }

    if (!empty($parallax_image)) {
        if ($has_video_bg) {
            $parallax_image_src = $parallax_image;
        } else {
            $parallax_image_id = preg_replace('/[^\d]/', '', $parallax_image);
            $parallax_image_src = wp_get_attachment_image_src($parallax_image_id, 'full');
            if (!empty($parallax_image_src[0])) {
                $parallax_image_src = $parallax_image_src[0];
            }
        }
        $wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr($parallax_image_src) . '"';
    }

    if (!$parallax && $has_video_bg) {
        $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr($video_bg_url) . '"';
    }

    $css_class = preg_replace(
        '/\s+/',
        ' ',
        apply_filters(
            VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
            implode(' ', array_filter(array_unique($css_classes))),
            $base_row,
            $atts
        )
    );

    $wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';

    if ($base_row === 'vc_row'){
        $output .='<div ' . implode(' ', $wrapper_attributes) . '>';
        $output .= ($fullwidth == '1') ? '<div class="nasa-row fullwidth clearfix">' : '<div class="row">';
        $output .= wpb_js_remove_wpautop($content);
        $output .= '</div>';
        $output .= '</div>';
    }

    else {
        $output .= '<div ' . implode(' ', $wrapper_attributes) . '>';
        $output .= '<div class="row">';
        $output .= wpb_js_remove_wpautop($content);
        $output .= '</div>';
        $output .= '</div>';
    }

    echo $output;
}
