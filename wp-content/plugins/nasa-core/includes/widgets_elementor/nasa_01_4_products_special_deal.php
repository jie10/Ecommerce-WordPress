<?php
/**
 * Widget for Elementor
 */
class Nasa_Products_Special_Deal_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_products_special_deal';
        $this->widget_cssclass = 'woocommerce nasa_products_special_deal_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Products Special Deal', 'nasa-core');
        $this->widget_id = 'nasa_products_special_deal_sc';
        $this->widget_name = esc_html__('Nasa Products Special Deal', 'nasa-core');
        $this->settings = array(
            'limit' => array(
                'type' => 'text',
                'std' => '4',
                'label' => esc_html__('Limit products', 'nasa-core')
            ),
            
            'cat' => array(
                'type' => 'product_categories',
                'std' => '',
                'label' => esc_html__('Product Category (Use slug of Category)', 'nasa-core')
            ),
            
            'style' => array(
                'type' => 'select',
                'std' => 'simple',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    'simple' => esc_html__('No Nav Items', 'nasa-core'),
                    'multi' => esc_html__('Has Nav 2 Items', 'nasa-core'),
                    'multi-2' => esc_html__('Has Nav 4 Items', 'nasa-core'),
                    'for_time' => esc_html__('Deal Before Time', 'nasa-core')
                )
            ),
            
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title - Not Use for Nav 2 Items', 'nasa-core')
            ),
            
            'desc_shortcode' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Description for Deal Before Time', 'nasa-core')
            ),
            
            'date_sc' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('End date show deals (yyyy-mm-dd | yyyy/mm/dd) for Deal Before Time', 'nasa-core')
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
                'options' => $this->array_numbers_half()
            ),
            
            'columns_number_tablet' => array(
                'type' => 'select',
                'std' => 3,
                'label' => esc_html__('Columns Number Tablet', 'nasa-core'),
                'options' => $this->array_numbers(4)
            ),
            
            'statistic' => array(
                'type' => 'select',
                'std' => '1',
                'label' => esc_html__('Show Available - Sold', 'nasa-core'),
                'options' => $this->array_bool_number()
            ),
            
            'arrows' => array(
                'type' => 'select',
                'std' => '1',
                'label' => esc_html__('Arrows', 'nasa-core'),
                'options' => $this->array_bool_number()
            ),
            
            'auto_slide' => array(
                'type' => 'select',
                'std' => 'true',
                'label' => esc_html__('Auto Slide', 'nasa-core'),
                'options' => $this->array_bool_str() 
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
