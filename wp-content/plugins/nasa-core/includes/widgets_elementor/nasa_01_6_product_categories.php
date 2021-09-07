<?php
/**
 * Widget for Elementor
 */
class Nasa_Product_Categories_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_product_categories';
        $this->widget_cssclass = 'woocommerce nasa_product_categories_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Product Categories', 'nasa-core');
        $this->widget_id = 'nasa_product_categories_sc';
        $this->widget_name = esc_html__('Nasa Product Categories SC', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'list_cats' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Categories Included List (ID or Slug, separated by ",". Ex: 1, 2 or slug-1, slug-2)', 'nasa-core')
            ),
            
            'number' => array(
                'type' => 'text',
                'std' => '0',
                'label' => esc_html__('Categories number for display', 'nasa-core')
            ),
            
            'disp_type' => array(
                'type' => 'select',
                'std' => 'Horizontal4',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    'Horizontal1' => esc_html__('Horizontal 1', 'nasa-core'),
                    'Horizontal2' => esc_html__('Horizontal 2', 'nasa-core'),
                    'Horizontal3' => esc_html__('Horizontal 3', 'nasa-core'),
                    'Horizontal4' => esc_html__('Horizontal 4', 'nasa-core'),
                    'Horizontal5' => esc_html__('Horizontal 5', 'nasa-core'),
                    'Horizontal6' => esc_html__('Horizontal 6', 'nasa-core'),
                    'Vertical' => esc_html__('Vertical', 'nasa-core'),
                    'grid' => esc_html__('Grid', 'nasa-core')
                )
            ),
            
            'parent' => array(
                'type' => 'select',
                'std' => 'true',
                'label' => esc_html__('Only Show top level', 'nasa-core'),
                'options' => $this->array_bool_str()
            ),
            
            'root_cat' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Only show child of (Product category id or slug)', 'nasa-core')
            ),
            
            'hide_empty' => array(
                'type' => 'select',
                'std' => '1',
                'label' => esc_html__('Hide empty categories', 'nasa-core'),
                'options' => $this->array_bool_number()
            ),
            
            'columns_number' => array(
                'type' => 'select',
                'std' => 4,
                'label' => esc_html__('Columns Number', 'nasa-core'),
                'options' => $this->array_numbers(10, 2)
            ),
            
            'columns_number_small' => array(
                'type' => 'select',
                'std' => 2,
                'label' => esc_html__('Columns Number Small', 'nasa-core'),
                'options' => $this->array_numbers(3)
            ),
            
            'columns_number_tablet' => array(
                'type' => 'select',
                'std' => 4,
                'label' => esc_html__('Columns Number Tablet', 'nasa-core'),
                'options' => $this->array_numbers(4)
            ),
            
            'number_vertical' => array(
                'type' => 'select',
                'std' => 4,
                'label' => esc_html__('Items show in Vertical', 'nasa-core'),
                'options' => $this->array_numbers(4)
            ),
            
            'auto_slide' => array(
                'type' => 'select',
                'std' => 'true',
                'label' => esc_html__('Slide Auto', 'nasa-core'),
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
