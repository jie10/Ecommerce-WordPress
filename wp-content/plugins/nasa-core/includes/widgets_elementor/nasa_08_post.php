<?php
/**
 * Widget for Elementor
 */
class Nasa_Posts_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_post';
        $this->widget_cssclass = 'nasa_post_wgsc';
        $this->widget_description = esc_html__('Displays Post Blogs', 'nasa-core');
        $this->widget_id = 'nasa_post_sc';
        $this->widget_name = esc_html__('Nasa Post Blogs', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'title_desc' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Description', 'nasa-core')
            ),
            
            'show_type' => array(
                'type' => 'select',
                'std' => 'slide',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    'slide' => esc_html__('Slider', 'nasa-core'),
                    'grid' => esc_html__('Grid 1', 'nasa-core'),
                    'grid_2' => esc_html__('Grid 2', 'nasa-core'),
                    'grid_3' => esc_html__('Grid 3 - Only show 2 posts', 'nasa-core'),
                    'list' => esc_html__('List', 'nasa-core'),
                )
            ),
            
            'auto_slide' => array(
                'type' => 'select',
                'std' => 'false',
                'label' => esc_html__('Slide Auto', 'nasa-core'),
                'options' => $this->array_bool_str()
            ),
            
            'arrows' => array(
                'type' => 'select',
                'std' => '0',
                'label' => esc_html__('Arrows', 'nasa-core'),
                'options' => $this->array_bool_number()
            ),
            
            'dots' => array(
                'type' => 'select',
                'std' => 'false',
                'label' => esc_html__('Dots', 'nasa-core'),
                'options' => $this->array_bool_str()
            ),
            
            'posts' => array(
                'type' => 'text',
                'std' => '8',
                'label' => esc_html__('Posts number - Not use with Grid 3', 'nasa-core')
            ),
            
            'columns_number' => array(
                'type' => 'select',
                'std' => 3,
                'label' => esc_html__('Columns Number', 'nasa-core'),
                'options' => $this->array_numbers(6)
            ),
            
            'columns_number_small' => array(
                'type' => 'select',
                'std' => 1,
                'label' => esc_html__('Columns Number Small', 'nasa-core'),
                'options' => $this->array_numbers(2)
            ),
            
            'columns_number_small_slider' => array(
                'type' => 'select',
                'std' => '1',
                'label' => esc_html__('Columns Number Small for Slider', 'nasa-core'),
                'options' => $this->array_numbers_half()
            ),
            
            'columns_number_tablet' => array(
                'type' => 'select',
                'std' => 2,
                'label' => esc_html__('Columns Number Tablet', 'nasa-core'),
                'options' => $this->array_numbers(4)
            ),
            
            'category' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Categories (Input categories slug Divide with "," Ex: slug-1, slug-2 ...)', 'nasa-core')
            ),
            
            'cats_enable' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Show Categories of post', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'date_enable' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Show date post', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'author_enable' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Show author post', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'readmore' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Show read more', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'date_author' => array(
                'type' => 'select',
                'std' => 'bot',
                'label' => esc_html__('Date/Author/Readmore position with description', 'nasa-core'),
                'options' => array(
                    'bot' => esc_html__('Bottom', 'nasa-core'),
                    'top' => esc_html__('Top', 'nasa-core')
                )
            ),
            
            'des_enable' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Show description', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'page_blogs' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Show button page blogs', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'info_align' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Info Align - With List Style', 'nasa-core'),
                'options' => array(
                    'left' => esc_html__('Left (RTL - Right)', 'nasa-core'),
                    'right' => esc_html__('Right (RTL - Left)', 'nasa-core')
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
