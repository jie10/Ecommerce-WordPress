<?php
/**
 * Shortcode [nasa_slider]...[/nasa_slider]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_carousel($atts = array(), $content = null) {
    $dfAttr = array(
        'title' => '',
        'align' => 'left',
        'column_number' => '1',
        'column_number_tablet' => '1',
        'column_number_small' => '1',
        'padding_item' => '',
        'padding_item_small' => '',
        'padding_item_medium' => '',
        'navigation' => 'true',
        'bullets' => 'true',
        'bullets_pos' => '',
        'bullets_align' => 'center',
        'paginationspeed' => '600',
        'autoplay' => 'false',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    $text_align = $align ? 'text-' . $align : 'text-left';
    
    $class_wrap = 'nasa-sc-carousel-main';
    $class_wrap .= $bullets_pos == 'inside' ? ' nasa-bullets-inside' : '';
    $class_wrap .= $bullets_pos == 'none' ? ' nasa-bullets-inherit' : '';
    $class_wrap .= $bullets_align ? ' nasa-bullets-' . $bullets_align : '';
    $class_wrap .= $el_class != '' ? ' ' . $el_class : '';
    
    $padding_array = array();
    if ($padding_item) {
        $padding_array[] = 'data-padding="' . esc_attr($padding_item) . '"';
    }
    
    if ($padding_item_small) {
        $padding_array[] = 'data-padding-small="' . esc_attr($padding_item_small) . '"';
    }
    
    if ($padding_item_medium) {
        $padding_array[] = 'data-padding-medium="' . esc_attr($padding_item_medium) . '"';
    }

    $padding_str = !empty($padding_array) ? ' ' . implode(' ', $padding_array) : '';
    
    $class_slider = 'nasa-slick-slider nasa-not-elementor-style';
    $class_slider .= $navigation === 'true' ? ' nasa-slick-nav' : '';
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($class_wrap); ?>">
        <?php if ($title): ?>
            <h3 class="section-title <?php echo esc_attr($text_align); ?>">
                <?php echo esc_attr($title); ?>
            </h3>
        <?php endif; ?>
        <div 
            class="<?php echo $class_slider; ?>"
            data-autoplay="<?php echo esc_attr($autoplay); ?>"
            data-speed="<?php echo esc_attr($paginationspeed); ?>"
            data-dot="<?php echo esc_attr($bullets); ?>"
            data-columns="<?php echo esc_attr($column_number); ?>"
            data-columns-small="<?php echo esc_attr($column_number_small); ?>"
            data-columns-tablet="<?php echo esc_attr($column_number_tablet); ?>"
            data-switch-tablet="<?php echo nasa_switch_tablet(); ?>"
            data-switch-desktop="<?php echo nasa_switch_desktop(); ?>"
            <?php echo $padding_str; ?>>
            <?php echo do_shortcode($content); ?>
        </div>
    </div>
    <?php
    
    return ob_get_clean();
}

// **********************************************************************// 
// ! Register New Element: Slider
// **********************************************************************//
function nasa_register_slider(){
    $slider_params = array(
        "name" => esc_html__("Slider", 'nasa-core'),
        "base" => "nasa_slider",
        "as_parent" => array('except' => 'nasa_slider'),
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display slider (images, products, ...)", 'nasa-core'),
        "content_element" => true,
        'category' => 'Nasa Core',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Title", 'nasa-core'),
                "param_name" => "title"
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Title Align", 'nasa-core'),
                "param_name" => "align",
                "value" => array(
                    esc_html__('Left', 'nasa-core') => 'left',
                    esc_html__('Center', 'nasa-core') => 'center',
                    esc_html__('Right', 'nasa-core') => 'right',
                )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Bullets', 'nasa-core'),
                "param_name" => "bullets",
                "value" => array(
                    esc_html__('Yes', 'nasa-core') => 'true',
                    esc_html__('No', 'nasa-core') => 'false'
                )
            ),
            
             array(
                "type" => "dropdown",
                "heading" => esc_html__('Bullets Postition', 'nasa-core'),
                "param_name" => "bullets_pos",
                "value" => array(
                    esc_html__('Outside', 'nasa-core') => '',
                    esc_html__('Inside', 'nasa-core') => 'inside',
                    esc_html__('Not Set', 'nasa-core') => 'none'
                )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Bullets Align', 'nasa-core'),
                "param_name" => "bullets_align",
                "std" => 'center',
                "value" => array(
                    esc_html__('Center', 'nasa-core') => 'center',
                    esc_html__('Left', 'nasa-core') => 'left',
                    esc_html__('Right', 'nasa-core') => 'right'
                )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Arrows', 'nasa-core'),
                "param_name" => "navigation",
                "value" => array(
                    esc_html__('Yes', 'nasa-core') => 'true',
                    esc_html__('No', 'nasa-core') => 'false'
                )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Columns Number', 'nasa-core'),
                "param_name" => "column_number",
                "value" => array(1, 2, 3, 4, 5, 6),
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Columns Number Small', 'nasa-core'),
                "param_name" => "column_number_small",
                "value" => array(1, 2, 3, 4, 5, 6),
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Columns Number Tablet', 'nasa-core'),
                "param_name" => "column_number_tablet",
                "value" => array(1, 2, 3, 4, 5, 6),
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Item Padding (px || %)", 'nasa-core'),
                "param_name" => "padding_item",
                "std" => '',
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Item Padding in Mobile (px || %)", 'nasa-core'),
                "param_name" => "padding_item_small",
                "std" => '',
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Item Padding in Tablet (px || %)", 'nasa-core'),
                "param_name" => "padding_item_medium",
                "std" => '',
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Auto Play', 'nasa-core'),
                "param_name" => "autoplay",
                "value" => array(
                    esc_html__('No', 'nasa-core') => 'false',
                    esc_html__('Yes', 'nasa-core') => 'true'
                )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Speed Slider', 'nasa-core'),
                "param_name" => "paginationspeed",
                "std" => '600',
                "value" => array(
                    esc_html__('0.3s', 'nasa-core') => '300',
                    esc_html__('0.4s', 'nasa-core') => '400',
                    esc_html__('0.5s', 'nasa-core') => '500',
                    esc_html__('0.6s', 'nasa-core') => '600',
                    esc_html__('0.7s', 'nasa-core') => '700',
                    esc_html__('0.8s', 'nasa-core') => '800',
                    esc_html__('0.9s', 'nasa-core') => '900',
                    esc_html__('1.0s', 'nasa-core') => '1000',
                    esc_html__('1.2s', 'nasa-core') => '1200',
                    esc_html__('1.4s', 'nasa-core') => '1400',
                    esc_html__('1.6s', 'nasa-core') => '1600'
                )
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        ),
        "js_view" => 'VcColumnView'
    );

    vc_map($slider_params);
}
