<?php
/**
 * Widget for Elementor
 */
class Nasa_Instagram_Feed_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_instagram_feed';
        $this->widget_cssclass = 'nasa_instagram_feed_wgsc';
        $this->widget_description = esc_html__('Displays Nasa Instagram Feed', 'nasa-core');
        $this->widget_id = 'nasa_instagram_feed_sc';
        $this->widget_name = esc_html__('Nasa Instagram Feed', 'nasa-core');
        $this->settings = array(
            'username_show' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('User name for display show', 'nasa-core')
            ),
            
            'instagram_link' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Link Follow', 'nasa-core')
            ),
            
            'img_size' => array(
                'type' => 'select',
                'std' => 'full',
                'label' => esc_html__('Image Size', 'nasa-core'),
                'options' => array(
                    'full' => esc_html__('Large', 'nasa-core'),
                    'medium' => esc_html__('Medium', 'nasa-core'),
                    'thumb' => esc_html__('Thumbnail', 'nasa-core')
                )
            ),
            
            'disp_type' => array(
                'type' => 'select',
                'std' => 'defalut',
                'label' => esc_html__('Display type', 'nasa-core'),
                'options' => array(
                    'default' => esc_html__('Grid', 'nasa-core'),
                    'slide' => esc_html__('Slider', 'nasa-core'),
                    'zz' => esc_html__('Zic Zac', 'nasa-core')
                )
            ),
            
            'auto_slide' => array(
                'type' => 'select',
                'std' => 'false',
                'label' => esc_html__('Slide Auto', 'nasa-core'),
                'options' => $this->array_bool_str()
            ),
            
            'limit_items' => array(
                'type' => 'text',
                'std' => '6',
                'label' => esc_html__('Photos Limit', 'nasa-core')
            ),
            
            'columns_number' => array(
                'type' => 'select',
                'std' => 6,
                'label' => esc_html__('Show on DeskTop', 'nasa-core'),
                'options' => $this->array_numbers(10, 4)
            ),
            
            'columns_number_tablet' => array(
                'type' => 'select',
                'std' => 2,
                'label' => esc_html__('Show on Tablet', 'nasa-core'),
                'options' => $this->array_numbers(6)
            ),
            
            'columns_number_small' => array(
                'type' => 'select',
                'std' => 1,
                'label' => esc_html__('Show on Mobile', 'nasa-core'),
                'options' => $this->array_numbers(6)
            ),
            
            'el_class_img' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra Class Image', 'nasa-core')
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
