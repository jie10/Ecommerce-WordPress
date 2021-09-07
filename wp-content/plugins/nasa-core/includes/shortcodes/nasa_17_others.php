<?php

/**
 * Shortcode [nasa_separator_link ...]
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_separator_link($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'title_text' => '',
        'link_text' => '#',
        'title_color' => '',
        'title_bg' => '',
        'title_type' => 'span',
        'title_hr' => 'simple',
        'title_desc' => '',
        'title_align' => '',
        'link_target' => '',
        'el_class' => ''
    ), $atts));
    
    if ($title_text == '' || $link_text == '') {
        return '';
    }
    
    $style_bg = array();
    $color_desc = $color_hr = '';
    if ($title_bg != '') {
        $style_bg[] = 'background: ' . $title_bg;
    }
    
    if ($title_color != '') {
        $style_bg[] = 'color: ' . $title_color;
        $color_desc = ' style="' . 'color: ' . $title_color . ';"';
        $color_hr = ' style="' . 'border-color: ' . $title_color . ';"';
    }
    
    $style_bg = !empty($style_bg) ? ' style="' . implode('; ', $style_bg) . ';"' : '';
    
    $hwrap = in_array($title_type, array('h1', 'h2', 'h3', 'h4', 'h5', 'span')) ? $title_type : 'span';
    $blank = $link_target === '_blank' ? ' target="' . $link_target . '"' : '';
    $title = $title_text ? '<a href="' . esc_url($link_text) . '" title="' . esc_attr($title_text) . '"' . $blank . $style_bg . '>' . $title_text . '</a>' : '';
    
    $title = '<' . $hwrap . ' class="nasa-heading-title"><span class="nasa-text-link-wrap nasa-title-wrap">' . $title . '</span><span class="nasa-title-hr"' . $color_hr . '></span></' . $hwrap . '>';
    
    $title_desc = trim($title_desc) != '' ? '<div class="nasa-title-desc"' . $color_desc . '>' . $title_desc . '</div>' : '';
    
    $style_output = 'nasa-title nasa-text-link clearfix';
    $style_output .= ($title_hr != '') ? ' hr-link hr-type-' . $title_hr : ''; 
    $style_output .= ($title_align != '') ? ' ' . $title_align : ''; 
    $style_output .= $el_class != '' ? ' ' . $el_class : '';
    
    return 
        '<div class="' . $style_output . '">' .
            $title .
            $title_desc .
        '</div>';
}

/**
 * Shortcode [nasa_countdown ...]
 * 
 * @param type $atts
 * @param string $content
 * @return string
 */
function nasa_countdown_time($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'date' => '',
        'style' => 'digital',
        'align' => 'center',
        'size' => 'small',
        'el_class' => ''
    ), $atts));
    
    if ($date == '') {
        return '';
    }
    
    $time_sale = strtotime($date);
    $time_sale = $time_sale < current_time('timestamp') ? false : $time_sale;
    if ($time_sale) :
        $wrap_class = array();
        
        if ($style == 'digital') {
            $wrap_class[] = 'nasa-custom-countdown';
            $wrap_class[] = 'text-' . trim($align);
            $wrap_class[] = 'nasa-' . trim($size);
        } else {
            $wrap_class[] = 'nasa-countdown-' . $style;
        }
        
        if ($el_class != '') :
            $wrap_class[] = $el_class;
        endif;
        
        $wrap_class_str = !empty($wrap_class) ? ' class="' . esc_attr(implode(' ', $wrap_class)) . '"' : '';
        
        $content =
        '<div' . $wrap_class_str . '>' .
            nasa_time_sale($time_sale, false) .
        '</div>';
    endif;
    
    return $content;
}

/**
 * Shortcode [nasa_service_box ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_service_box($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'service_icon' => '',
        'service_title' => '',
        'service_desc' => '',
        'service_link' => '',
        'service_blank' => '',
        'service_style' => 'style-1',
        'service_hover' => '',
        'el_class' => ''
    ), $atts));
    
    ob_start();
    
    $enable_link = (isset($service_link) && trim($service_link) != '') ? true : false;
    if ($enable_link) {
        $blank = $service_blank == '_blank' ? ' target="_blank"' : '';
        echo '<a href="' . esc_url($service_link) . '"' . $blank . '>';
    }
    ?>
    <div class="service-block <?php echo esc_attr($service_style . ($el_class ? ' ' . $el_class : '')); ?>">
        <div class="box">
            <div class="service-icon <?php echo esc_attr($service_hover); ?> <?php echo esc_attr($service_icon); ?>"></div>
            <div class="service-text">
                <?php if (isset($service_title) && $service_title != '') { ?>
                    <div class="service-title"><?php echo esc_attr($service_title); ?></div>
                <?php } ?>
                <?php if (isset($service_desc) && $service_desc != '') { ?>
                    <div class="service-desc"><?php echo esc_attr($service_desc); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    echo $enable_link ? '</a>' : '';
    
    $content = ob_get_clean();
    
    return $content;
}

/**
 * Shortcode [nasa_client ...]
 * 
 * Testimonials
 * 
 * @param type $atts
 * @param type $content
 * @return string
 */
function nasa_sc_client($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        "img_src" => '',
        "name" => '',
        'style' => 'full',
        "company" => '',
        "text_color" => '#fff',
        "content" => $content,
        'text_align' => 'center',
        'el_class' => ''
    ), $atts));

    $content = (trim($content) != '') ? nasa_fix_shortcode($content) : '';
    $el_class = (trim($el_class) != '') ? ' ' . asc_attr($el_class) : '';
    $style_mode = !isset($style) || $style !== 'simple' ? 'full' : 'simple';

    if ($style_mode !== 'simple') {
        switch ($text_align) {
            case 'right':
            case 'left':
            case 'justify':
                $el_class .= ' text-' . $text_align;
                break;

            case 'center':
            default:
                $el_class .= ' text-center';
                break;
        }
    }

    $image = '';
    if ($img_src != '') {
        $imageArr = wp_get_attachment_image_src($img_src, 'full');
        if (isset($imageArr[0])) {
            $image = '<img src="' . esc_url($imageArr[0]) . '" alt="' . esc_attr($name) . '" width="' . $imageArr[1] . '" height="' . $imageArr[2] . '" />';
        }
    }
    
    /**
     * Full style
     * 
     * Show avata - name - content - Company
     */
    if ($style_mode == 'full') {
        $style_text_color = $text_color ? ' style="color: ' . esc_attr($text_color) . '"' : '';
        
        $client = 
        '<div class="client' . $el_class . '">' .
            '<div class="client-inner"' . $style_text_color . '>' .
                '<div class="client-info wow fadeInUp" data-wow-delay="100ms" data-wow-duration="1s">' .
                    '<div class="client-content"' . $style_text_color . '>' . $content . '</div>' .
                    '<div class="client-img-info">' .
                        '<div class="client-img">' . $image . '</div>' .
                        '<div class="client-name-post">' .
                            '<h4 class="client-name">' . $name . '</h4>' .
                            '<span class="client-pos"' . $style_text_color . '>' . $company . '</span>' .
                        '</div>' .
                    '</div>' .
                '</div>' .
            '</div>' .
        '</div>';
    }
    
    /**
     * Simple style
     * 
     * Show avata - name - content
     */
    if ($style_mode == 'simple') {
        $client = 
        '<div class="client client-simple wow fadeInUp' . $el_class . '" data-wow-delay="100ms" data-wow-duration="1s">' .
            '<div class="client-img-info">' .
                '<div class="client-img">' . $image . '</div>' .
                '<p class="client-name">' . $name . '</p>' .
            '</div>' .
            '<div class="client-content padding-left-15 rtl-padding-left-0 rtl-padding-right-15 rtl-text-right">' . $content . '</div>' .
        '</div>';
    }

    return $client;
}

/**
 * Shortcode [nasa_contact_us ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_contact_us($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'contact_address' => '',
        'contact_phone' => '',
        'service_desc' => '',
        'contact_email' => '',
        'contact_website' => '',
        'el_class' => ''
    ), $atts));
    
    $content = '';
    
    if (isset($contact_address) && $contact_address) {
        $content .=
        '<li class="media">' .
            '<span class="contact-text">' . $contact_address . '</span>' .
        '</li>';
    }
    
    if (isset($contact_phone) && $contact_phone) {
        $content .=
        '<li class="media">' .
            '<span class="contact-text">' . $contact_phone . '</span>' .
        '</li>';
    }
    
    if (isset($contact_email) && $contact_email) {
        $content .=
        '<li class="media">' .
            '<a class="contact-text" href="mailto:' . esc_attr($contact_email) . '" title="' . esc_attr__('Email', 'nasa-core') . '">' . $contact_email . '</a>' .
        '</li>';
    }
    
    if (isset($contact_website) && $contact_website) {
        $content .=
        '<li class="media">' .
            '<a class="contact-text" href="' . esc_url($contact_website) . '" title="' . esc_attr($contact_website) . '">' . $contact_website . '</a>' .
        '</li>';
    }
    
    if ($content) {
        $class = 'contact-information';
        $class .= $el_class ? ' ' . $el_class : '';
        $content = '<ul class="' . esc_attr($class) . '">' . $content . '</ul>';
    }
    
    return $content;
}

/**
 * Shortcode [nasa_opening_time ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_opening_time($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'weekdays_start' => '08:00',
        'weekdays_end' => '20:00',
        'sat_start' => '09:00',
        'sat_end' => '21:00',
        'sun_start' => '13:00',
        'sun_end' => '22:00',
        'el_class' => ''
    ), $atts));

    $class = 'nasa-opening-time';
    $class .= $el_class ? ' ' . $el_class : '';
    
    $content = '<ul class="' . $class . '">';
        $content .= '<li><span class="nasa-day-open">' . esc_html__('Monday - Friday', 'nasa-core') . '</span><span class="nasa-time-open">' . $weekdays_start . ' - ' . $weekdays_end . '</span></li>';
        $content .= '<li><span class="nasa-day-open">' . esc_html__('Saturday', 'nasa-core') . '</span><span class="nasa-time-open">' . $sat_start . ' - ' . $sat_end . '</span></li>';
        $content .= '<li><span class="nasa-day-open">' . esc_html__('Sunday', 'nasa-core') . '</span><span class="nasa-time-open">' . $sun_start . ' - ' . $sun_end . '</span></li>';
    $content .= '</ul>';

    return $content;
}

/**
 * Shortcode [nasa_image ...]
 * 
 * @global type $nasa_opt
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_image($atts = array(), $content = null) {
    $dfAttr = array(
        'link_text' => '',
        'link_target' => '',
        'alt' => '',
        'image' => '',
        'align' => '',
        'hide_in_m' => '',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    if (isset($hide_in_m) && $hide_in_m) {
        global $nasa_opt;
        
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
            return '';
        }
    }

    if ($image) {
        $el_class = isset($el_class) ? trim($el_class) : '';
        $img = wp_get_attachment_image_src($image, 'full');
        if (!$img) {
            return $content;
        }
        
        $alt = empty($alt) ? get_post_meta($img, '_wp_attachment_image_alt', true) : $alt;
        $open = $close = '';
        if ($link_text) {
            $blank = $link_target ? ' target="' . $link_target . '"' : '';
            $title = $alt ? ' title="' . esc_attr($alt) . '"' : '';
            
            $class_a = 'nasa-link-image';
            $open = '<a class="' . esc_attr($class_a) . '" href="' . esc_url($link_text) . '"' . $blank . $title . '>';
            $close = '</a>';
        }
        
        $class = 'nasa-image';
        $class .= isset($hide_in_m) && $hide_in_m ? ' hide-for-mobile' : '';
        $class .= $el_class ? ' ' . $el_class : '';
        $img_html = '<img class="' . esc_attr($class) . '" src="' . esc_url($img[0]) . '" alt="' . esc_attr($alt) . '" width="' . absint($img[1]) . '" height="' . absint($img[2]) . '" />';
        
        $content = $open . $img_html . $close;
        
        if ($align != '') {
            $wrap_open = '<div class="nasa-image-wrap text-' . esc_attr($align) . '">';
            $wrap_close = '</div>';
            
            $content = $wrap_open . $content . $wrap_close;
        }
    }
    
    return $content;
}

/**
 * Boot Rate
 * 
 * Shortcode [nasa_boot_rate ...]
 * <div class="star-rating"><span></span></div>
 */
function nasa_sc_boot_rate($atts = array(), $content = null) {
    $dfAttr = array(
        'text' => '',
        'name' => '',
        'el_class' => ''
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    $content = '';
    
    if (trim($text) == '' && trim($name) == '') {
        return $content;
    }
    
    /**
     * Say
     */
    if ($text) {
        $content .= '<p class="nasa-text">' . $text . '</p>';
    }
    
    /**
     * Rating
     */
    $content .= '<div class="star-rating"><span></span></div>';
    
    /**
     * Author
     */
    if ($name) {
        $content .= '<p class="nasa-customer">' . $name . '</p>';
    }
    
    $class = 'nasa-boot-rate';
    $class .= $el_class ? ' ' . $el_class : '';
    
    return '<div class="' . $class . '">' . $content . '</div>';
}

/**
 * Register Params
 */
function nasa_register_others(){
    // **********************************************************************// 
    // ! Register New Element: Service Box
    // **********************************************************************//
    $service_box_params = array(
        "name" => esc_html__("Service Box", 'nasa-core'),
        "base" => "nasa_service_box",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Create sevice box.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Service Title", 'nasa-core'),
                "param_name" => "service_title",
                "admin_label" => true,
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Service Description", 'nasa-core'),
                "param_name" => "service_desc",
                "admin_label" => true,
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Icon", 'nasa-core'),
                "param_name" => "service_icon",
                "description" => esc_html__("Enter icon class name. Support FontAwesome, Font Pe 7 Stroke (https://themes-pixeden.com/font-demos/7-stroke/), Font Nasa (https://elessi.nasatheme.com/wp-content/themes/elessi-theme/assets/font-nasa/icons-reference.html)", 'nasa-core')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Service link", 'nasa-core'),
                "param_name" => "service_link",
                "admin_label" => true,
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Link Target", 'nasa-core'),
                "param_name" => "service_blank",
                "description" => esc_html__("Target", 'nasa-core'),
                "value" => array(
                    esc_html__('Default', 'nasa-core') => '',
                    esc_html__('Blank - New Window', 'nasa-core') => '_blank'
                )
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__("Service Style", 'nasa-core'),
                "param_name" => "service_style",
                "value" => array(
                    esc_html__('Style 1', 'nasa-core') => 'style-1',
                    esc_html__('Style 2', 'nasa-core') => 'style-2',
                    esc_html__('Style 3', 'nasa-core') => 'style-3',
                    esc_html__('Style 4', 'nasa-core') => 'style-4'
                ),
                "admin_label" => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Service Hover Effect", 'nasa-core'),
                "param_name" => "service_hover",
                "value" => array(
                    esc_html__('None', 'nasa-core') => '',
                    esc_html__('Fly', 'nasa-core') => 'fly_effect',
                    esc_html__('Buzz', 'nasa-core') => 'buzz_effect',
                    esc_html__('Rotate', 'nasa-core') => 'rotate_effect',
                )
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );
    vc_map($service_box_params);

    // **********************************************************************// 
    // ! Register New Element: Testimonials
    // **********************************************************************//
    $client_params = array(
        "name" => esc_html__("Testimonials", 'nasa-core'),
        "base" => "nasa_client",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Ex: Customers say about us.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "attach_image",
                "heading" => esc_html__("Avatar", 'nasa-core'),
                "param_name" => "img_src",
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Name", 'nasa-core'),
                "param_name" => "name",
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Style', 'nasa-core'),
                "param_name" => 'style',
                "value" => array(
                    esc_html__('Full', 'nasa-core') => "full",
                    esc_html__('Simple', 'nasa-core') => "simple"
                ),
                'std' => 'full'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Job", 'nasa-core'),
                "param_name" => "company",
                "dependency" => array(
                    "element" => "style",
                    "value" => array('full')
                )
            ),
            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Testimonials Text Color", 'nasa-core'),
                "param_name" => "text_color",
                "value" => "#fff",
                "dependency" => array(
                    "element" => "style",
                    "value" => array('full')
                )
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Testimonials Content Say", 'nasa-core'),
                "param_name" => "content",
                "value" => "Some promo text",
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Align', 'nasa-core'),
                "param_name" => 'text_align',
                "value" => array(
                    esc_html__('Center', 'nasa-core') => 'center',
                    esc_html__('Left', 'nasa-core') => 'left',
                    esc_html__('Right', 'nasa-core') => 'right',
                    esc_html__('Justify', 'nasa-core') => 'justify'
                ),
                'std' => 'center',
                
                "dependency" => array(
                    "element" => "style",
                    "value" => array('full')
                )
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );
    vc_map($client_params);

    // **********************************************************************// 
    // ! Register New Element: Contact Footer
    // **********************************************************************//
    $contact_us_params = array(
        "name" => esc_html__("Contact info", 'nasa-core'),
        'base' => 'nasa_contact_us',
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Create info contact, introduce.", 'nasa-core'),
        'category' => 'Nasa Core',
        'params' => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Address", 'nasa-core'),
                "param_name" => "contact_address",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Phone", 'nasa-core'),
                "param_name" => "contact_phone",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Email", 'nasa-core'),
                "param_name" => "contact_email",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Website", 'nasa-core'),
                "param_name" => "contact_website",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'nasa-core'),
                "param_name" => "el_class"
            )
        )
    );
    vc_map($contact_us_params);

    // **********************************************************************// 
    // ! Register New Element: Opening Time
    // **********************************************************************//
    $opening = array(
        "name" => esc_html__("Opening time", 'nasa-core'),
        "base" => "nasa_opening_time",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Create info opening time of shop.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__('Weekdays Start Time', 'nasa-core'),
                "param_name" => 'weekdays_start',
                "std" => '08:00'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Weekdays End Time', 'nasa-core'),
                "param_name" => 'weekdays_end',
                "std" => '20:00'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Saturday Start Time', 'nasa-core'),
                "param_name" => 'sat_start',
                "std" => '09:00'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Saturday End Time', 'nasa-core'),
                "param_name" => 'sat_end',
                "std" => '21:00'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Sunday Start Time', 'nasa-core'),
                "param_name" => 'sun_start',
                "std" => '13:00'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Sunday End Time', 'nasa-core'),
                "param_name" => 'sun_end',
                "std" => '22:00'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );
    vc_map($opening);

    // **********************************************************************// 
    // ! Register New Element: nasa Text link
    // **********************************************************************//
    $nasa_title_separator_link_params = array(
        "name" => esc_html__("Text Link", 'nasa-core'),
        "base" => "nasa_separator_link",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Create text link custom.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title text', 'nasa-core'),
                'param_name' => 'title_text',
                'admin_label' => true,
                'value' => '',
                'description' => ''
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Link text', 'nasa-core'),
                'param_name' => 'link_text',
                'admin_label' => true,
                'value' => '',
                'description' => ''
            ),
            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Color title", 'nasa-core'),
                "param_name" => "title_color",
                "value" => ""
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Title heading', 'nasa-core'),
                "param_name" => 'title_type',
                "value" => array(
                    esc_html__('No heading', 'nasa-core') => 'span',
                    esc_html__('H1', 'nasa-core') => 'h1',
                    esc_html__('H2', 'nasa-core') => 'h2',
                    esc_html__('H3', 'nasa-core') => 'h3',
                    esc_html__('H4', 'nasa-core') => 'h4',
                    esc_html__('H5', 'nasa-core') => 'h5'
                ),
                'std' => 'span',
                'admin_label' => true
            ),
            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Background title", 'nasa-core'),
                "param_name" => "title_bg",
                "value" => "#FFFFFF"
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Title HR', 'nasa-core'),
                "param_name" => 'title_hr',
                "value" => array(
                    esc_html__('Simple', 'nasa-core') => 'simple',
                    esc_html__('Full', 'nasa-core') => 'full',
                    esc_html__('None', 'nasa-core') => 'none'
                ),
                'std' => 'simple',
                'admin_label' => true
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title Description', 'nasa-core'),
                'param_name' => 'title_desc',
                'admin_label' => true,
                'value' => '',
                'description' => ''
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Title Alignment', 'nasa-core'),
                "param_name" => 'title_align',
                "value" => array(
                    esc_html__('Left', 'nasa-core') => '',
                    esc_html__('Center', 'nasa-core') => 'text-center',
                    esc_html__('Right', 'nasa-core') => 'text-right'
                ),
                "dependency" => array(
                    "element" => "title_hr",
                    "value" => array(
                        'simple', 'full', 'none'
                    )
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Target', 'nasa-core'),
                "param_name" => 'link_target',
                "value" => array(
                    esc_html__('Default', 'nasa-core') => '',
                    esc_html__('Blank', 'nasa-core') => '_blank'
                ),
                'std' => ''
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );
    vc_map($nasa_title_separator_link_params);

    // **********************************************************************// 
    // ! Register New Element: nasa Countdown
    // **********************************************************************//
    $nasa_countdown_params = array(
        "name" => esc_html__("Countdown Time", 'nasa-core'),
        "base" => "nasa_countdown",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Create Countdown time.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Date text', 'nasa-core'),
                'param_name' => 'date',
                'admin_label' => true,
                'value' => '',
                'description' => 'Format: YYYY-mm-dd HH:mm:ss | YYYY/mm/dd HH:mm:ss'
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Style', 'nasa-core'),
                "param_name" => 'style',
                "value" => array(
                    esc_html__('Digital', 'nasa-core') => 'digital',
                    esc_html__('Text', 'nasa-core') => 'text'
                ),
                'std' => 'digital',
                'admin_label' => true
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Date align', 'nasa-core'),
                "param_name" => 'align',
                "value" => array(
                    esc_html__('Center', 'nasa-core') => 'center',
                    esc_html__('Left', 'nasa-core') => 'left',
                    esc_html__('Right', 'nasa-core') => 'right'
                ),
                'std' => 'center',
                'admin_label' => true,
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        'digital'
                    )
                ),
            ),

            array(
                "type" => "dropdown",
                "heading" => esc_html__('Font size', 'nasa-core'),
                "param_name" => 'size',
                "value" => array(
                    esc_html__('Small', 'nasa-core') => 'small',
                    esc_html__('Large', 'nasa-core') => 'large'
                ),
                'std' => 'small',
                'admin_label' => true,
                "dependency" => array(
                    "element" => "style",
                    "value" => array(
                        'digital'
                    )
                ),
            ),

            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );

    vc_map($nasa_countdown_params);
    
    // **********************************************************************// 
    // ! Register New Element: nasa Image
    // **********************************************************************//
    $nasa_image_params = array(
        "name" => esc_html__("Image", 'nasa-core'),
        "base" => "nasa_image",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Create image.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('ALT - Title', 'nasa-core'),
                'param_name' => 'alt',
                'admin_label' => true,
                'value' => '',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('URL', 'nasa-core'),
                'param_name' => 'link_text',
                'admin_label' => true,
                'value' => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Target', 'nasa-core'),
                "param_name" => 'link_target',
                "value" => array(
                    esc_html__('Default', 'nasa-core') => '',
                    esc_html__('Blank', 'nasa-core') => '_blank'
                ),
                'std' => ''
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Image', 'nasa-core'),
                'param_name' => 'image',
                'value' => '',
                'admin_label' => true,
                'description' => esc_html__('Select images from media library.', 'nasa-core')
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Align', 'nasa-core'),
                "param_name" => 'align',
                "value" => array(
                    esc_html__('Default', 'nasa-core') => '',
                    esc_html__('Left', 'nasa-core') => 'left',
                    esc_html__('Center', 'nasa-core') => 'center',
                    esc_html__('Right', 'nasa-core') => 'right',
                ),
                'std' => ''
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Hide in Mobile - Mobile Layout', 'nasa-core'),
                "param_name" => 'hide_in_m',
                "value" => array(
                    esc_html__('No, Thanks!', 'nasa-core') => '',
                    esc_html__('Yes, Please!', 'nasa-core') => '1'
                ),
                'std' => ''
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );
    vc_map($nasa_image_params);
    
    // **********************************************************************// 
    // ! Register New Element: nasa Boot rate
    // **********************************************************************//
    $nasa_params = array(
        "name" => esc_html__("Boot Rate", 'nasa-core'),
        "base" => "nasa_boot_rate",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Boot Rate", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "params" => array(
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Customer Says', 'nasa-core'),
                'param_name' => 'text',
                'admin_label' => true,
                'value' => '',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Customer Name', 'nasa-core'),
                'param_name' => 'name',
                'admin_label' => true,
                'value' => '',
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );
    vc_map($nasa_params);
}
