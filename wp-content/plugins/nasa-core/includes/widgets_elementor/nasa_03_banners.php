<?php
/**
 * Widget for Elementor
 */
class Nasa_Banner_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_banner';
        $this->widget_cssclass = 'nasa_banner_wgsc';
        $this->widget_description = esc_html__('Display Banner', 'nasa-core');
        $this->widget_id = 'nasa_banner_sc';
        $this->widget_name = esc_html__('Nasa Banner', 'nasa-core');
        $this->settings = array(
            'img_src' => array(
                'type' => 'attach_image',
                'std' => '',
                'label' => esc_html__('Banner Image', 'nasa-core')
            ),
            
            'height' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Banner Height', 'nasa-core')
            ),
            
            'width' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Banner Width', 'nasa-core')
            ),
            
            'link' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Link', 'nasa-core')
            ),
            
            'content-width' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Content Width (%)', 'nasa-core')
            ),
            
            'align' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Horizontal Alignment', 'nasa-core'),
                'options' => array(
                    'left' => esc_html__('Left', 'nasa-core'),
                    'center' => esc_html__('Center', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'move_x' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Move Horizontal a distance (%)', 'nasa-core')
            ),
            
            'valign' => array(
                'type' => 'select',
                'std' => 'top',
                'label' => esc_html__('Vertical Alignment', 'nasa-core'),
                'options' => array(
                    'top' => esc_html__('Top', 'nasa-core'),
                    'middle' => esc_html__('Middle', 'nasa-core'),
                    'bottom' => esc_html__('Bottom', 'nasa-core')
                )
            ),
            
            'text-align' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Text Alignment', 'nasa-core'),
                'options' => array(
                    'text-left' => esc_html__('Left', 'nasa-core'),
                    'text-center' => esc_html__('Center', 'nasa-core'),
                    'text-right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'banner_responsive' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Responsive', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'content' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_html__('Banner Text', 'nasa-core')
            ),
            
            'effect_text' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Effect Banner Content', 'nasa-core'),
                'options' => array(
                    'none' => esc_html__('None', 'nasa-core'),
                    'fadeIn' => esc_html__('fadeIn', 'nasa-core'),
                    'fadeInDown' => esc_html__('fadeInDown', 'nasa-core'),
                    'fadeInUp' => esc_html__('fadeInUp', 'nasa-core'),
                    'fadeInLeft' => esc_html__('fadeInLeft', 'nasa-core'),
                    'fadeInRight' => esc_html__('fadeInRight', 'nasa-core'),
                    'slideInDown' => esc_html__('slideInDown', 'nasa-core'),
                    'slideInUp' => esc_html__('slideInUp', 'nasa-core'),
                    'slideInLeft' => esc_html__('slideInLeft', 'nasa-core'),
                    'slideInRight' => esc_html__('slideInRight', 'nasa-core'),
                    'flipInX' => esc_html__('flipInX', 'nasa-core'),
                    'flipInY' => esc_html__('flipInY', 'nasa-core'),
                    'lightSpeedIn' => esc_html__('lightSpeedIn', 'nasa-core'),
                    'rotateInDownLeft' => esc_html__('rotateInDownLeft', 'nasa-core'),
                    'rotateInDownRight' => esc_html__('rotateInDownRight', 'nasa-core'),
                    'rotateInUpLeft' => esc_html__('rotateInUpLeft', 'nasa-core'),
                    'rotateInUpRight' => esc_html__('rotateInUpRight', 'nasa-core'),
                    'zoomIn' => esc_html__('zoomIn', 'nasa-core'),
                    'zoomInDown' => esc_html__('zoomInDown', 'nasa-core'),
                    'zoomInLeft' => esc_html__('zoomInLeft', 'nasa-core'),
                    'zoomInRight' => esc_html__('zoomInRight', 'nasa-core'),
                    'zoomInUp' => esc_html__('zoomInUp', 'nasa-core'),
                    'bounceIn' => esc_html__('bounceIn', 'nasa-core'),
                    'bounceInDown' => esc_html__('bounceInDown', 'nasa-core'),
                    'bounceInLeft' => esc_html__('bounceInLeft', 'nasa-core'),
                    'bounceInRight' => esc_html__('bounceInRight', 'nasa-core'),
                    'bounceInUp' => esc_html__('bounceInUp', 'nasa-core')
                )
            ),
            
            'data_delay' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Animation Delay', 'nasa-core'),
                'options' => array(
                    '' => esc_html__('None', 'nasa-core'),
                    '100ms' => esc_html__('0.1s', 'nasa-core'),
                    '200ms' => esc_html__('0.2s', 'nasa-core'),
                    '300ms' => esc_html__('0.3s', 'nasa-core'),
                    '400ms' => esc_html__('0.4s', 'nasa-core'),
                    '500ms' => esc_html__('0.5s', 'nasa-core'),
                    '600ms' => esc_html__('0.6s', 'nasa-core'),
                    '700ms' => esc_html__('0.7s', 'nasa-core'),
                    '800ms' => esc_html__('0.8s', 'nasa-core'),
                    '900ms' => esc_html__('0.9s', 'nasa-core'),
                    '1000ms' => esc_html__('1s', 'nasa-core')
                )
            ),
            
            'hover' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Effect Banner Hover', 'nasa-core'),
                'options' => array(
                    '' => esc_html__('None', 'nasa-core'),
                    'zoom' => esc_html__('Zoom', 'nasa-core'),
                    'reduction' => esc_html__('Zoom Out', 'nasa-core'),
                    'fade' => esc_html__('Fade', 'nasa-core')
                )
            ),
            
            'border_inner' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Border Inner', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'border_outner' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Border Outner', 'nasa-core'),
                'options' => $this->array_bool_YN()
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
