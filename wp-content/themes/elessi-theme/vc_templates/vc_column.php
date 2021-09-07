<?php
$output = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract(shortcode_atts(array(
    'font_color' => '',
    'width' => '1/1',
    'width_side' => '',
    'hide_in_mobile' => '0',
    'css' => '',
    'offset' => '',
    'css_animation' => '',
    'parallax' => '',
    'parallax_speed_bg' => '1',
    'parallax_speed_video' => '1',
    'parallax_image' => '',
    'video_bg' => false,
    'video_bg_url' => '',
    'video_bg_parallax' => '',
    'el_class' => '',
    'el_id' => ''
), $atts));

global $nasa_opt;
if ($hide_in_mobile && isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
    echo '<!-- Element Hide in Mobile -->';
}

else {
    $wrapper_attributes = array();
    if ($el_id != '') {
        $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    }

    $width = wpb_translateColumnWidthToSpan($width);
    $width = vc_column_offset_class_merge($offset, $width);
    $css_classes = array(
        'wpb_column',
        'vc_column_container',
        $width,
        vc_shortcode_custom_css_class($css)
    );

    $el_class = $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
    if ($el_class != '') {
        $css_classes[] = $el_class;
    }

    /**
     * Add class Full width to side
     */
    if ($width_side != '') {
        $css_classes[] = 'nasa-full-to-' . esc_attr($width_side);
    }

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
            $this->settings('base'),
            $atts
        )
    );

    $wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';

    $output .= '<div ' . implode(' ', $wrapper_attributes) . '>';
    $output .= wpb_js_remove_wpautop($content);
    $output .= '</div>';

    echo $output;
}
