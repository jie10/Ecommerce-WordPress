<?php
/**
 * Widget for Elementor
 */

/**
 * Nasa Share
 */
class Nasa_Share_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_share';
        $this->widget_cssclass = 'nasa_share_wgsc';
        $this->widget_description = esc_html__('Displays Nasa Share', 'nasa-core');
        $this->widget_id = 'nasa_share_sc';
        $this->widget_name = esc_html__('Nasa Share', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'nasa-core')
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

/**
 * Nasa Follow
 */
class Nasa_Follow_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_follow';
        $this->widget_cssclass = 'nasa_follow_wgsc';
        $this->widget_description = esc_html__('Displays Nasa Follow', 'nasa-core');
        $this->widget_id = 'nasa_follow';
        $this->widget_name = esc_html__('Nasa Follow', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'twitter' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Twitter', 'nasa-core')
            ),
            
            'facebook' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Facebook', 'nasa-core')
            ),
            
            'pinterest' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Pinterest', 'nasa-core')
            ),
            
            'email' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Email', 'nasa-core')
            ),
            
            'instagram' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Instagram', 'nasa-core')
            ),
            
            'rss' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('RSS', 'nasa-core')
            ),
            
            'linkedin' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Linkedin', 'nasa-core')
            ),
            
            'youtube' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Youtube', 'nasa-core')
            ),
            
            'flickr' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Flickr', 'nasa-core')
            ),
            
            'telegram' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Telegram', 'nasa-core')
            ),
            
            'whatsapp' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Whatsapp', 'nasa-core')
            ),
            
            'amazon' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Amazon', 'nasa-core')
            ),
            
            'tumblr' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Tumblr', 'nasa-core')
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
