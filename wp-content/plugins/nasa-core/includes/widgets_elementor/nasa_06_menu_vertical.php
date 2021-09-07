<?php
/**
 * Widget for Elementor
 */
class Nasa_Menu_Vertical_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_menu_vertical';
        $this->widget_cssclass = 'woocommerce nasa_menu_vertical_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Menu Vertical', 'nasa-core');
        $this->widget_id = 'nasa_menu_vertical_sc';
        $this->widget_name = esc_html__('Nasa Menu Vertical', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'menu' => array(
                'type' => 'menu_list',
                'std' => '',
                'label' => esc_html__('Select Menu (Use slug of Menu)', 'nasa-core')
            ),
            
            'menu_align' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Alignment', 'nasa-core'),
                'options' => array(
                    'left' => esc_html__('Left', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
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
