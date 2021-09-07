<?php
/**
 * Widget for Elementor
 */
class Nasa_Products_Masonry_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_products_masonry';
        $this->widget_cssclass = 'woocommerce nasa_products_masonry_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Products Masonry', 'nasa-core');
        $this->widget_id = 'nasa_products_masonry_sc';
        $this->widget_name = esc_html__('Nasa Products Masonry', 'nasa-core');
        $this->settings = array(
            'type' => array(
                'type' => 'select',
                'std' => 'recent_product',
                'label' => esc_html__('Type Show', 'nasa-core'),
                'options' => array(
                    'recent_product' => esc_html__('Recent Products', 'nasa-core'),
                    'best_selling' => esc_html__('Best Selling', 'nasa-core'),
                    'featured_product' => esc_html__('Featured Products', 'nasa-core'),
                    'top_rate' => esc_html__('Top Rate', 'nasa-core'),
                    'on_sale' => esc_html__('On Sale', 'nasa-core'),
                    'recent_review' => esc_html__('Recent Review', 'nasa-core'),
                    'deals' => esc_html__('Product Deals')
                )
            ),
            
            'layout' => array(
                'type' => 'select',
                'std' => 'grid',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    '1' => esc_html__('Layout type 1 (Limit 18 items)', 'nasa-core'),
                    '2' => esc_html__('Layout type 2 (Limit 16 items)', 'nasa-core')
                )
            ),
            
            'loadmore' => array(
                'type' => 'select',
                'std' => '1',
                'label' => esc_html__('Style View More', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'cat' => array(
                'type' => 'product_categories',
                'std' => '',
                'label' => esc_html__('Product Category (Use slug of Category)', 'nasa-core')
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
