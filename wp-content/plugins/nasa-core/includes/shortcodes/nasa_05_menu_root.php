<?php
/**
 * Shortcode [nasa_menu ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_menu($atts = array(), $content = null) {
    $dfAttr = array(
        'title' => '',
        'menu' => '',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    if ($menu) {
        ob_start();
        ?>
        <div class="nasa-nav-sc-menu<?php echo $el_class != '' ? ' ' . esc_attr($el_class) : ''; ?>">
            <?php if ($title) : ?>
                <h5 class="section-title">
                    <?php echo esc_attr($title); ?>
                </h5>
            <?php endif; ?>
            <ul class="nasa-menu-wrapper">
                <?php
                wp_nav_menu(array(
                    'menu' => $menu,
                    'container' => false,
                    'items_wrap' => '%3$s',
                    'depth' => 1,
                    'walker' => new Nasa_Nav_Menu()
                ));
                ?>
            </ul>
        </div>
        <?php $content = ob_get_clean();
    }
    
    return $content;
}

// **********************************************************************// 
// ! Register New Element: Menu vertical
// **********************************************************************//   
function nasa_register_menu_shortcode() {
    $params = array(
        "name" => esc_html__("Menu 1 Level", 'nasa-core'),
        "base" => "nasa_menu",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display Menu Level Root.", 'nasa-core'),
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
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nasa-core')
            )
        )
    );

    vc_map($params);
}
