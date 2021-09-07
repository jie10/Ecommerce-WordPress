<?php
/**
 * Widget for Elementor
 */
class Nasa_Pin_Products_Banner_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_pin_products_banner';
        $this->widget_cssclass = 'nasa_pin_products_banner_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Pin Products Banner', 'nasa-core');
        $this->widget_id = 'nasa_pin_products_banner_sc';
        $this->widget_name = esc_html__('Nasa Pin Products Banner', 'nasa-core');
        $this->settings = array(
            'pin_slug' => array(
                'type' => 'pin_slug',
                'pin' => 'nasa_pin_pb',
                'std' => '',
                'label' => esc_html__('Slug Pin', 'nasa-core')
            ),
            
            'marker_style' => array(
                'type' => 'select',
                'std' => 'price',
                'label' => esc_html__('Marker Style', 'nasa-core'),
                'options' => array(
                    'price' => esc_html__('Price icon', 'nasa-core'),
                    'plus' => esc_html__('Plus icon', 'nasa-core')
                )
            ),
            
            'full_price_icon' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Marker Full Price', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'price_rounding' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Price Rounding', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'show_img' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Show Image', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'show_price' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Show Price', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'pin_effect' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Effect icons', 'nasa-core'),
                'options' => array(
                    'default' => esc_html__('Default', 'nasa-core'),
                    'yes' => esc_html__('Yes', 'nasa-core'),
                    'no' => esc_html__('No', 'nasa-core')
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
