<?php
/**
 * Widget for Elementor
 */

/**
 * Nasa Countdown
 */
class Nasa_Countdown_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_countdown';
        $this->widget_cssclass = 'nasa_countdown_wgsc';
        $this->widget_description = esc_html__('Displays Countdown Time', 'nasa-core');
        $this->widget_id = 'nasa_countdown_sc';
        $this->widget_name = esc_html__('Nasa Countdown', 'nasa-core');
        $this->settings = array(
            'date' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Date (Format: YYYY-mm-dd HH:mm:ss | YYYY/mm/dd HH:mm:ss)', 'nasa-core')
            ),
            
            'style' => array(
                'type' => 'select',
                'std' => 'digital',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    'digital' => esc_html__('Digital', 'nasa-core'),
                    'text' => esc_html__('Text', 'nasa-core')
                )
            ),
            
            'align' => array(
                'type' => 'select',
                'std' => 'center',
                'label' => esc_html__('Date align (with Style: Text)', 'nasa-core'),
                'options' => array(
                    'center' => esc_html__('Center', 'nasa-core'),
                    'left' => esc_html__('Left', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'size' => array(
                'type' => 'select',
                'std' => 'small',
                'label' => esc_html__('Font size (with Style: Text)', 'nasa-core'),
                'options' => array(
                    'small' => esc_html__('Small', 'nasa-core'),
                    'large' => esc_html__('Large', 'nasa-core')
                )
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );

        parent::__construct();
    }
}

/**
 * Nasa Service Box
 */
class Nasa_Service_Box_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_service_box';
        $this->widget_cssclass = 'nasa_service_box_wgsc';
        $this->widget_description = esc_html__('Displays Service Box', 'nasa-core');
        $this->widget_id = 'nasa_service_box';
        $this->widget_name = esc_html__('Nasa Service Box', 'nasa-core');
        $this->settings = array(
            'service_title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Service Title', 'nasa-core')
            ),
            
            'service_desc' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Service Description', 'nasa-core')
            ),
            
            'service_icon' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Service Icon. Enter icon class name. Support FontAwesome, Font Pe 7 Stroke (https://themes-pixeden.com/font-demos/7-stroke/), Font Nasa (https://elessi.nasatheme.com/wp-content/themes/elessi-theme/assets/font-nasa/icons-reference.html)', 'nasa-core')
            ),
            
            'service_link' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Service link', 'nasa-core')
            ),
            
            'service_blank' => array(
                'type' => 'select',
                'std' => '',
                'label' => esc_html__('Link Target', 'nasa-core'),
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '_blank' => esc_html__('Blank - New Window', 'nasa-core')
                )
            ),
            
            'service_style' => array(
                'type' => 'select',
                'std' => 'style-1',
                'label' => esc_html__('Service Style', 'nasa-core'),
                'options' => array(
                    'style-1' => esc_html__('Style 1', 'nasa-core'),
                    'style-2' => esc_html__('Style 2', 'nasa-core'),
                    'style-3' => esc_html__('Style 3', 'nasa-core'),
                    'style-4' => esc_html__('Style 4', 'nasa-core')
                )
            ),
            
            'service_hover' => array(
                'type' => 'select',
                'std' => 'small',
                'label' => esc_html__('Service Hover Effect', 'nasa-core'),
                'options' => array(
                    '' => esc_html__('None', 'nasa-core'),
                    'fly_effect' => esc_html__('Fly', 'nasa-core'),
                    'buzz_effect' => esc_html__('Buzz', 'nasa-core'),
                    'rotate_effect' => esc_html__('Rotate', 'nasa-core')
                )
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );

        parent::__construct();
    }
}

/**
 * Nasa Image Box
 */
class Nasa_Image_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_image';
        $this->widget_cssclass = 'nasa_image_wgsc';
        $this->widget_description = esc_html__('Displays Image', 'nasa-core');
        $this->widget_id = 'nasa_image';
        $this->widget_name = esc_html__('Nasa Image', 'nasa-core');
        $this->settings = array(
            'alt' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('ALT - Title', 'nasa-core')
            ),
            
            'link_text' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('URL', 'nasa-core')
            ),
            
            'link_target' => array(
                'type' => 'select',
                'std' => '',
                'label' => esc_html__('Link Target', 'nasa-core'),
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '_blank' => esc_html__('Blank - New Window', 'nasa-core')
                )
            ),
            
            'image' => array(
                'type' => 'attach_image',
                'std' => '',
                'label' => esc_html__('Image', 'nasa-core')
            ),
            
            'align' => array(
                'type' => 'select',
                'std' => '',
                'label' => esc_html__('Align', 'nasa-core'),
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    'left' => esc_html__('Left', 'nasa-core'),
                    'center' => esc_html__('Center', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'hide_in_m' => array(
                'type' => 'select',
                'std' => '',
                'label' => esc_html__('Hide in Mobile - Mobile Layout', 'nasa-core'),
                'options' => array(
                    '' => esc_html__('No, Thanks!', 'nasa-core'),
                    '1' => esc_html__('Yes, Please!', 'nasa-core')
                )
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );

        parent::__construct();
    }
}

/**
 * Nasa Header Icons
 * 
 * Mini Cart
 * Mini Compare
 * Mini Wishlist
 */
class Nasa_Icons_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_sc_icons';
        $this->widget_cssclass = 'nasa_icons_wgsc';
        $this->widget_description = esc_html__('Displays Header Icons', 'nasa-core');
        $this->widget_id = 'nasa_sc_icons';
        $this->widget_name = esc_html__('Nasa Header Icons', 'nasa-core');
        $this->settings = array(
            
            'show_mini_cart' => array(
                'type' => 'select',
                'std' => 'yes',
                'options' => $this->array_bool_YN()
            ),
            
            'show_mini_compare' => array(
                'type' => 'select',
                'std' => 'yes',
                'options' => $this->array_bool_YN()
            ),
            
            'show_mini_wishlist' => array(
                'type' => 'select',
                'std' => 'yes',
                'options' => $this->array_bool_YN()
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );

        parent::__construct();
    }
}
