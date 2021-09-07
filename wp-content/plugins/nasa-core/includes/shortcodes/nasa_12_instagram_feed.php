<?php
/**
 * Shortcode [nasa_instagram_feed ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_instagram_feed($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'limit_items' => '6',
        'img_size' => 'full',
        'disp_type' => 'default',
        'auto_slide' => 'false',
        'columns_number' => '6',
        'columns_number_tablet' => '3',
        'columns_number_small' => '3',
        'username_show' => '',
        'instagram_link' => '',
        'el_class_img' => '',
        'el_class' => ''
    ), $atts));
    
    if (!shortcode_exists('instagram-feed')) {
        return '<div class="nasa-error text-center nasa-bold padding-top-20 padding-bottom-20">' . esc_html__('Please install "Smash Balloon Instagram Feed" plugin to use this feature.', 'nasa-core') . '</div>';
    }
    
    /**
     * Nasa Instagram Feed
     */
    wp_enqueue_script('nasa-instagram-feed', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa-instagram-feed.min.js', array('jquery'), null, true);
        
    if ((int) $limit_items <= 0) {
        $limit_items = 6;
    }

    /**
     * auto - 640x640
     * medium - 320x320
     * thumb - 150x150
     */
    if (!isset($img_size) || !in_array($img_size, array('full', 'medium', 'thumb'))) {
        $img_size = 'full';
    }
    
    switch ($img_size) {
        case 'thumb':
            $width = '150';
            $height = '150';
            break;
        
        case 'medium':
            $width = '320';
            $height = '320';
            break;
        
        case 'full':
        default:
            $width = '640';
            $height = '640';
            break;
    }

    $shortcode_text = '[instagram-feed showheader=false showbutton=false showfollow=false num=' . $limit_items . ' imageres=' . $img_size . ']';

    $nasa_args = array(
        'limit_items' => $limit_items,
        'img_size' => $img_size,
        'disp_type' => $disp_type,
        'auto_slide' => $auto_slide,
        'columns_number' => $columns_number,
        'columns_number_tablet' => $columns_number_tablet,
        'columns_number_small' => $columns_number_small,
        'username_show' => $username_show,
        'instagram_link' => $instagram_link,
        'el_class_img' => $el_class_img,
        'el_class' => $el_class,
        'shortcode_text' => $shortcode_text,
        'width' => $width,
        'height' => $height
    );

    ob_start();
    nasa_template('instagram/instagram_' . $disp_type . '.php', $nasa_args);
    
    return ob_get_clean();
}

/**
 * Register Params
 */
function nasa_register_instagram_feed() {
    $instagram_params = array(
        "name" => esc_html__("Instagram Feed", 'nasa-core'),
        'base' => 'nasa_instagram_feed',
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Create info Instagram.", 'nasa-core'),
        'category' => 'Nasa Core',
        'params' => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("User name for display show", 'nasa-core'),
                "param_name" => "username_show",
                "value" => "",
                "admin_label" => true,
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Link Follow", 'nasa-core'),
                "param_name" => "instagram_link",
                "value" => "",
                "admin_label" => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Image Size', 'nasa-core'),
                "param_name" => 'img_size',
                "value" => array(
                    esc_html__('Large', 'nasa-core') => 'full',
                    esc_html__('Medium', 'nasa-core') => 'medium',
                    esc_html__('Thumbnail', 'nasa-core') => 'thumb'
                ),
                "std" => 'full',
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Display type', 'nasa-core'),
                "param_name" => 'disp_type',
                "value" => array(
                    esc_html__('Grid', 'nasa-core') => 'defalut',
                    esc_html__('Slider', 'nasa-core') => 'slide',
                    esc_html__('Zic Zac', 'nasa-core') => 'zz'
                ),
                "std" => 'defalut',
                "admin_label" => true
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Slide Auto', 'nasa-core'),
                "param_name" => 'auto_slide',
                "value" => array(
                    esc_html__('No, Thanks!', 'nasa-core') => 'false',
                    esc_html__('Yes, Please!', 'nasa-core') => 'true'
                ),
                "std" => 'false',
                "dependency" => array(
                    "element" => "disp_type",
                    "value" => array(
                        "slide"
                    )
                )
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Photos Limit", 'nasa-core'),
                "param_name" => "limit_items",
                'std' => '6',
                "admin_label" => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Show on DeskTop", 'nasa-core'),
                "param_name" => "columns_number",
                "value" => array(4, 5, 6, 7, 8, 9, 10),
                "admin_label" => true,
                'std' => 6
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Show on Tablet", 'nasa-core'),
                "param_name" => "columns_number_tablet",
                "value" => array(1, 2, 3, 4, 5, 6),
                "admin_label" => true,
                'std' => 3
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Show on Mobile", 'nasa-core'),
                "param_name" => "columns_number_small",
                "value" => array(1, 2, 3, 4, 5, 6),
                "admin_label" => true,
                'std' => 3
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class images", 'nasa-core'),
                "param_name" => "el_class_img"
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'nasa-core'),
                "param_name" => "el_class"
            )
        )
    );

    vc_map($instagram_params);
}
