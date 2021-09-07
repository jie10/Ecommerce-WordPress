<?php
/**
 * Widget for Elementor
 */
class Nasa_Products_By_Ids_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_products_byids';
        $this->widget_cssclass = 'nasa_products_byids_wgsc';
        $this->widget_description = esc_html__('Displays Products By Ids', 'nasa-core');
        $this->widget_id = 'nasa_products_byids_sc';
        $this->widget_name = esc_html__('Nasa Products By Ids', 'nasa-core');
        $this->settings = array(
            'ids' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Product Ids', 'nasa-core')
            ),
            
            'style' => array(
                'type' => 'select',
                'std' => 'grid',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'nasa-core'),
                    'carousel' => esc_html__('Slider', 'nasa-core')
                )
            ),
            
            'columns_number' => array(
                'type' => 'select',
                'std' => 4,
                'label' => esc_html__('Columns Number', 'nasa-core'),
                'options' => $this->array_numbers(6)
            ),
            
            'columns_number_small' => array(
                'type' => 'select',
                'std' => 2,
                'label' => esc_html__('Columns Number Small', 'nasa-core'),
                'options' => $this->array_numbers(2)
            ),
            
            'columns_number_small_slider' => array(
                'type' => 'select',
                'std' => 2,
                'label' => esc_html__('Columns Number Small for Carousle', 'nasa-core'),
                'options' => $this->array_numbers_half()
            ),
            
            'columns_number_tablet' => array(
                'type' => 'select',
                'std' => 3,
                'label' => esc_html__('Columns Number Tablet', 'nasa-core'),
                'options' => $this->array_numbers(4)
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
