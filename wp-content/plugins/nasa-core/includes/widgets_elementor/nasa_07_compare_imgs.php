<?php
/**
 * Widget for Elementor
 */
class Nasa_Compare_Imgs_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_compare_imgs';
        $this->widget_cssclass = 'nasa_compare_imgs_wgsc';
        $this->widget_description = esc_html__('Displays Compare IMGS', 'nasa-core');
        $this->widget_id = 'nasa_compare_imgs_sc';
        $this->widget_name = esc_html__('Nasa Compare IMGS', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'link' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Link', 'nasa-core')
            ),
            
            'desc_text' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Description', 'nasa-core')
            ),
            
            'align_text' => array(
                'type' => 'select',
                'std' => 'center',
                'label' => esc_html__('Alignment', 'nasa-core'),
                'options' => array(
                    'center' => esc_html__('Center', 'nasa-core'),
                    'left' => esc_html__('Left', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'before_image' => array(
                'type' => 'attach_image',
                'std' => '',
                'label' => esc_html__('Image Before', 'nasa-core')
            ),
            
            'after_image' => array(
                'type' => 'attach_image',
                'std' => '',
                'label' => esc_html__('Image After', 'nasa-core')
            ),
            
            'el_class_img' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class for Images', 'nasa-core')
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
