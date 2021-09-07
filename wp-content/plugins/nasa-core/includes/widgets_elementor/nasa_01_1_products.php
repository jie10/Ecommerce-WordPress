<?php
/**
 * Widget for Elementor
 */
class Nasa_Products_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_products';
        $this->widget_cssclass = 'woocommerce nasa_products_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Products', 'nasa-core');
        $this->widget_id = 'nasa_products_sc';
        $this->widget_name = esc_html__('Nasa Products', 'nasa-core');
        $this->settings = array(
            'title_shortcode' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title (Only using for Style is Slider, Simple Slide.)', 'nasa-core')
            ),
            
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
            
            'style' => array(
                'type' => 'select',
                'std' => 'grid',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'nasa-core'),
                    'carousel' => esc_html__('Slider', 'nasa-core'),
                    'slide_slick' => esc_html__('Simple Slider', 'nasa-core'),
                    'slide_slick_2' => esc_html__('Simple Slider 2', 'nasa-core'),
                    'infinite' => esc_html__('Ajax Infinite', 'nasa-core'),
                    'list' => esc_html__('List - Widget Items', 'nasa-core'),
                    'list_carousel' => esc_html__('Slider - Widget Items', 'nasa-core')
                )
            ),
            
            'style_viewmore' => array(
                'type' => 'select',
                'std' => '1',
                'label' => esc_html__('Style View More', 'nasa-core'),
                'options' => array(
                    '1' => esc_html__('Type 1 - No Border', 'nasa-core'),
                    '2' => esc_html__('Type 2 - Border - Top - Bottom', 'nasa-core'),
                    '3' => esc_html__('Type 3 - Button - Radius - Dash', 'nasa-core')
                )
            ),
            
            'style_row' => array(
                'type' => 'select',
                'std' => '1',
                'label' => esc_html__('Rows of Slide', 'nasa-core'),
                'options' => array(
                    '1' => esc_html__('1 Row', 'nasa-core'),
                    '2' => esc_html__('2 Rows', 'nasa-core'),
                    '3' => esc_html__('3 Rows', 'nasa-core')
                )
            ),
            
            'pos_nav' => array(
                'type' => 'select',
                'std' => 'top',
                'label' => esc_html__('Position Title | Navigation (The Top Only use for Style is Carousel)', 'nasa-core'),
                'options' => array(
                    'top' => esc_html__('Top - for Carousel 1 Row', 'nasa-core'),
                    'left' => esc_html__('Side', 'nasa-core'),
                    'both' => esc_html__('Side Classic', 'nasa-core')
                )
            ),
            
            'title_align' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Title align (Only use for Style is Carousel)', 'nasa-core'),
                'options' => array(
                    'left' => esc_html__('Left', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'shop_url' => array(
                'type' => 'select',
                'std' => '0',
                'label' => esc_html__('Shop URL (Only use for Style is Carousel)', 'nasa-core'),
                'options' => $this->array_bool_number()
            ),
            
            'arrows' => array(
                'type' => 'select',
                'std' => '1',
                'label' => esc_html__('Arrows (Only use for Style is Carousel or Simple Slide)', 'nasa-core'),
                'options' => $this->array_bool_number()
            ),
            
            'dots' => array(
                'type' => 'select',
                'std' => 'false',
                'label' => esc_html__('Dots (Only use for Style is Carousel or Simple Slide 2)', 'nasa-core'),
                'options' => $this->array_bool_str()
            ),
            
            'auto_slide' => array(
                'type' => 'select',
                'std' => 'false',
                'label' => esc_html__('Slide Auto', 'nasa-core'),
                'options' => $this->array_bool_str() 
            ),
            
            'number' => array(
                'type' => 'text',
                'std' => '8',
                'label' => esc_html__('Limit', 'nasa-core')
            ),
            
            'auto_delay_time' => array(
                "type" => "text",
                "std" => '6',
                "label" => esc_html__("Delay Time (s)", 'nasa-core')
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
                'options' => $this->array_numbers(3)
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
            
            'cat' => array(
                'type' => 'product_categories',
                'std' => '',
                'label' => esc_html__('Product Category (Use slug of Category)', 'nasa-core')
            ),
            
            'not_in' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Excludes Product Ids', 'nasa-core')
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
