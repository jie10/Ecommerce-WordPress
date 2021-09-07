<?php
/**
 * Shortcode [nasa_mega_menu ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_mega_menu($atts = array(), $content = null) {
    $dfAttr = array(
        'title' => '',
        'menu' => '',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    $content = '';
    if ($menu) {
        $nasa_main_menu = wp_nav_menu(array(
            'echo' => false,
            'menu' => $menu,
            'container' => false,
            'items_wrap' => '%3$s',
            'depth' => 3,
            'walker' => new Nasa_Nav_Menu()
        ));
        
        $content .= '<div class="hide-for-small nasa-nav-sc-mega-menu' . ($el_class != '' ? ' ' . esc_attr($el_class) : '') . '">';
        if ($title) :
            $content .= 
            '<h5 class="section-title">' .
                esc_attr($title) .
            '</h5>';
        endif;

        $content .= '<div class="nasa-menus-wrapper-reponsive" data-padding_y="20" data-padding_x="15">';
        $content .= '<div class="nav-wrapper inline-block main-menu-warpper">';
        $content .= '<ul class="header-nav">';
        $content .= $nasa_main_menu;
        $content .= '</ul>';
        $content .= '</div><!-- nav-wrapper -->';
        $content .= '</div><!-- nasa-menus-wrapper-reponsive -->';
        $content .= '</div><!-- nasa-nav-sc-menu -->';
    }
    
    return $content;
}

// **********************************************************************// 
// ! Register New Element: Mega Menu
// **********************************************************************//   
function nasa_register_mega_menu_shortcode() {
    $params = array(
        "name" => esc_html__("Mega Menu", 'nasa-core'),
        "base" => "nasa_mega_menu",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display shortcode mega menu.", 'nasa-core'),
        "category" => 'Header Builder',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Title", 'nasa-core'),
                "param_name" => "title"
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Menu', 'nasa-core'),
                'param_name' => 'menu',
                "value" => nasa_get_menu_options(),
                "admin_label" => true
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nasa-core')
            )
        )
    );

    vc_map($params);
}
