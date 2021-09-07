<?php
/**
 * Shortcode [nasa_brands ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_brands($atts = array(), $content = null) {
    $dfAttr = array(
        'custom_links' => '',
        'images' => '',
        'columns_number' => '6',
        'columns_number_small' => '2',
        'columns_number_tablet' => '4',
        'layout' => 'carousel',
        'auto_slide' => 'false',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    $custom_links = explode(',', $custom_links);
    $images = explode(',', $images);
    $layout = !in_array($layout, array('carousel', 'grid')) ? 'carousel' : $layout;

    if (count($images) > 0) {
        ob_start();
        
        $nasa_args = array(
            'images' => $images,
            'layout' => $layout,
            'auto_slide' => $auto_slide,
            'columns_number' => $columns_number,
            'columns_number_small' => $columns_number_small,
            'columns_number_tablet' => $columns_number_tablet,
            'custom_links' => $custom_links
        );
        
        nasa_template('brands/' . $layout . '.php', $nasa_args);
        
        $content = ob_get_clean();
    }
    
    return $content;
}

/* ==========================================================================
! Register New Element: Nasa Brands
========================================================================== */  
function nasa_register_brands(){
    vc_map(array(
        "name" => esc_html__("Brands", 'nasa-core'),
        "base" => "nasa_brands",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display brands logo", 'nasa-core'),
        "class" => "",
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Layout", 'nasa-core'),
                "param_name" => "layout",
                "value" => array(
                    esc_html__('Carousel', 'nasa-core') => 'carousel',
                    esc_html__('Grid', 'nasa-core') => 'grid',
                ),
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Slide Auto', 'nasa-core'),
                "param_name" => 'auto_slide',
                "value" => array(
                    esc_html__('Yes, Please!', 'nasa-core') => 'true',
                    esc_html__('No, Thanks!', 'nasa-core') => 'false'
                ),
                "std" => 'false',
                "dependency" => array(
                    "element" => "layout",
                    "value" => array(
                        "carousel"
                    )
                )
            ),
            array(
                'type' => 'attach_images',
                'heading' => esc_html__('Images', 'nasa-core'),
                'param_name' => 'images',
                'value' => ''
            ),
            array(
                'type' => 'exploded_textarea',
                'heading' => esc_html__('Custom links', 'nasa-core'),
                'param_name' => 'custom_links',
                'description' => esc_html__('Enter links for each slide here. Divide links with linebreaks (Enter).', 'nasa-core'),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number", 'nasa-core'),
                "param_name" => "columns_number",
                "value" => array(6, 5, 4, 3, 2, 1),
                "admin_label" => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Tablet", 'nasa-core'),
                "param_name" => "columns_number_tablet",
                "value" => array(4, 3, 2, 1),
                "admin_label" => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Columns Number Small", 'nasa-core'),
                "param_name" => "columns_number_small",
                "value" => array(3, 2, 1),
                "admin_label" => true,
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    ));
}
