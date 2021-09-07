<?php
/**
 * Shortcode [vc_tta_tabs]
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_vc_tta_tabs($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'alignment' => '',
        'style' => '',
        'tabs_display_type' => '',
        'tabs_bg_color' => '',
        'tabs_text_color' => '',
        'el_class' => '',
    ), $atts));
    
    $title_top = $title;
    
    $alignment_class = $alignment ? ' text-' . $alignment : '';
    $el_class = (trim($el_class) != '') ? ' ' . $el_class : '';
    $tabs_slide = (isset($tabs_display_type) && $tabs_display_type == 'slide') ? true : false;
    $class_tabable = ' margin-bottom-15';
    $class_a_click = 'nasa-a-tab';
    $tab_bg = array();
    $class_title = false;
    $tab_color = $tab_color_h5 = array();
    
    if ($tabs_slide) :
        $el_class .= ' nasa-slide-style';
    else :
        $tabs_type = !isset($tabs_display_type) ? '2d-no-border' : $tabs_display_type;
        switch ($tabs_type) :
            case '2d':
                $tabs_type_class = ' nasa-classic-2d';
                break;
            
            case '3d':
                $tabs_type_class = ' nasa-classic-3d';
                break;
            
            case '2d-has-bg':
                $style_title = '';
                
                if ($title_top) {
                    if ($alignment !== 'center') {
                        $class_title = 'nasa-title-absolute';
                    }
                    
                    if ($class_title) {
                        $class_title .= $alignment == 'left' ? ' text-right' : ' text-left';
                    }
                }
                
                $tabs_type_class = ' nasa-classic-2d nasa-tabs-no-border nasa-tabs-has-bg';
                $class_tabable = ' margin-bottom-10';
                $class_tabable .= $alignment == 'left' ? ' mobile-text-right' : ' mobile-text-left';
                $tabs_bg_color = (!isset($tabs_bg_color) || $tabs_bg_color == '') ?
                    'transparent' : $tabs_bg_color;
                
                $tabs_type_class .= 'transparent' == $tabs_bg_color ? ' nasa-tabs-bg-transparent' : '';
                if ($tabs_bg_color != 'transparent') {
                    $tab_bg[] = 'background-color: ' . $tabs_bg_color;
                }
                
                if (isset($tabs_text_color) && $tabs_text_color != '') {
                    $tab_color[] = 'color: ' . $tabs_text_color;
                    $tab_color_h5[] = 'border-color: ' . $tabs_text_color;
                    $class_a_click .= ' nasa-custom-text-color';
                    
                    if ($class_title) {
                        $style_title = ' style="color: ' . $tabs_text_color . '"';
                    }
                }
                
                if ($class_title && $tabs_bg_color !== 'transparent') {
                    $class_title .= ' nasa-has-padding';
                }
                
                if ($class_title) {
                    $title_top = $class_title ? '<div class="' . esc_attr($class_title) . '"' . $style_title . '>' . $title_top . '</div>' : $title_top;
                }
                
                break;
                
            case '2d-radius':
                $tabs_type_class = ' nasa-classic-2d nasa-tabs-no-border nasa-tabs-radius';
                break;
            
            case '2d-no-border':
            default:
                $tabs_type_class = ' nasa-classic-2d nasa-tabs-no-border';
                break;
            
        endswitch;
        $el_class .= ' nasa-classic-style' . $tabs_type_class;
    endif;
    
    $class_tabable .= $alignment_class ? $alignment_class : '';
    
    $output = '';
    $output .= '<div class="nasa-tabs-not-set nasa-tabs-content' . esc_attr($el_class) . '">';
    $output .= '<div class="nasa-tabs-wrap' . esc_attr($class_tabable) . '">';
    
    $output .= '<ul class="nasa-tabs"' . (!empty($tab_bg) ? ' style="' . implode(';', $tab_bg) . '"' : '') . '>';
    $output .= $tabs_slide ? '<li class="nasa-slide-tab"></li>' : '';
    $output .= '</ul>';
    $output .= '</div>';
    
    $output .= '<div class="nasa-panels">';
    $output .= do_shortcode(shortcode_unautop($content)); // Content
    $output .= '</div>';
    
    $output .= '</div>';
    
    return $output;
}

/**
 * Shortcode [vc_tta_section]
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_vc_tta_section($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'tab_id' => '',
        'el_class' => '',
    ), $atts));
    
    $class_tab_str = 'nasa-panel hidden-tag nasa-section-' . esc_attr($tab_id);
    
    $output = '';
    
    $output .= '<div class="' . $class_tab_str . '">';
    $output .= '<div class="nasa-move-tab-title hidden-tag">';
    $output .= '<a class="nasa-a-tab" data-index="nasa-section-' . esc_attr($tab_id) . '" href="javascript:void(0);" rel="nofollow">' . $title . '</a>';
    $output .= '</div>';
    
    $output .= do_shortcode(shortcode_unautop($content)); // Content
    $output .= '</div>';
    
    return $output;
}
