<?php
/**
 * Shortcode [nasa_menu_vertical ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_menu_vertical($atts = array(), $content = null) {    
    $dfAttr = array(
        'title' => '',
        'menu' => '',
        'menu_align' => 'left',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    if ($menu) {
        $el_class .= $el_class ? ' ' : '';
        $el_class .= 'nasa-menu-ver-align-' . $menu_align;
        ob_start();
        ?>
        <div class="nasa-hide-for-mobile nasa-shortcode-menu vertical-menu<?php echo $el_class != '' ? ' ' . esc_attr($el_class) : ''; ?>">
            <?php if ($title != '') : ?>
                <h5 class="section-title">
                    <?php echo $title; ?>
                </h5>
            <?php endif; ?>
            
            <div class="vertical-menu-container">
                <ul class="vertical-menu-wrapper">
                    <?php
                    wp_nav_menu(array(
                        'menu' => $menu,
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'depth' => 3,
                        'walker' => new Nasa_Nav_Menu()
                    ));
                    ?>
                </ul>
            </div>
        </div>
        <?php
        $content = ob_get_clean();

        return $content;
    }
}

// **********************************************************************// 
// ! Register New Element: Menu vertical
// **********************************************************************//
function nasa_register_menuVertical() {
    $vertical_menu_params = array(
        "name" => esc_html__("Menu Vertical", 'nasa-core'),
        "base" => "nasa_menu_vertical",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display menu is vertical format.", 'nasa-core'),
        "category" => 'Nasa Core',
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
                "type" => "dropdown",
                "heading" => esc_html__("Alignment", 'nasa-core'),
                "param_name" => "menu_align",
                "value" => array(
                    esc_html__('Left', 'nasa-core') => 'left',
                    esc_html__('Right', 'nasa-core') => 'right'
                ),
                "std" => 'yes',
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
    vc_map($vertical_menu_params);
}
