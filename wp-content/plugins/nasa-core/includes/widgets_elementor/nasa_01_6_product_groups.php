<?php
/**
 * Widget for Elementor
 */
class Nasa_Product_Groups_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_product_nasa_categories';
        $this->widget_cssclass = 'woocommerce nasa_product_groups_wgsc';
        $this->widget_description = esc_html__('Displays Product Groups', 'nasa-core');
        $this->widget_id = 'nasa_product_groups_sc';
        $this->widget_name = esc_html__('Nasa Product Groups SC', 'nasa-core');
        $this->settings = array(
            'style' => array(
                'type' => 'select',
                'std' => 'hoz',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    'hoz' => esc_html__('Horizontal', 'nasa-core'),
                    'ver' => esc_html__('Vertical', 'nasa-core')
                )
            ),
            
            'hide_empty' => array(
                'type' => 'select',
                'std' => '0',
                'label' => esc_html__('Hide Empty', 'nasa-core'),
                'options' => $this->array_bool_number()
            ),
            
            'count_items' => array(
                'type' => 'select',
                'std' => '0',
                'label' => esc_html__('Show Count products', 'nasa-core'),
                'options' => $this->array_bool_number()
            ),
            
            'deep_level' => array(
                'type' => 'select',
                'std' => 3,
                'label' => esc_html__('Deep Levels', 'nasa-core'),
                'options' => $this->array_numbers(3)
            ),
            
            'button_text' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Filter Text', 'nasa-core')
            ),
            
            'redirect_to' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Submit Redirect To (Input Slug of a Category you want, Default redirect to Shop page or Home page)', 'nasa-core')
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
