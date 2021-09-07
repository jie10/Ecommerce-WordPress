<?php
/**
 * 
 * @param type $atts
 * @param string $content
 * @return string
 */
function nasa_sc_buttons($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'text' => '',
        'style' => '',
        'color' => '',
        'size' => '',
        'link' => '',
        'target' => ''
    ), $atts));

    $target = $target ? ' target="' . $target . '"' : '';
    $color = $color ? ' style="background-color: ' . $color . ' !important"' : '';
    $content = '<a href="' . ($link != '' ? $link : 'javascript:void(0);') . '" class="button ' . $size . ' ' . $style . '"' . $color . $target . ' rel="nofollow">' . $text . '</a>';
    
    return $content;
}
