<?php
/**
 * Widget for Elementor
 */
class Nasa_Pin_Material_Banner_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_pin_material_banner';
        $this->widget_cssclass = 'nasa_pin_material_banner_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Pin Material Banner', 'nasa-core');
        $this->widget_id = 'nasa_pin_material_banner_sc';
        $this->widget_name = esc_html__('Nasa Pin Material Banner', 'nasa-core');
        $this->settings = array(
            'pin_slug' => array(
                'type' => 'pin_slug',
                'pin' => 'nasa_pin_mb',
                'std' => '',
                'label' => esc_html__('Slug Pin', 'nasa-core')
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
