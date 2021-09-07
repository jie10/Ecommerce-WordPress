<?php
/**
 * Widget for Elementor
 */
class Nasa_Pin_Products_Carousel_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_pin_products_banner';
        $this->widget_cssclass = 'nasa_pin_products_carousel_wgsc';
        $this->widget_description = esc_html__('Displays Carousel Shortcode Nasa Pin Products Banner', 'nasa-core');
        $this->widget_id = 'nasa_pin_products_banner_carousel_sc';
        $this->widget_name = esc_html__('Nasa Pin Products Carousel', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'class' => 'first',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'align' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Alignment', 'nasa-core'),
                'options' => array(
                    'center' => esc_html__('Center', 'nasa-core'),
                    'left' => esc_html__('Left', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'sliders' => array(
                'type' => 'sliders_pin_pb',
                'std' => array(),
                'label' => esc_html__('Slider Items', 'nasa-core')
            ),
            
            'bullets' => array(
                'type' => 'select',
                'std' => 'true',
                'label' => esc_html__('Bullets', 'nasa-core'),
                'options' => $this->array_bool_str()
            ),
            
            'bullets_pos' => array(
                'type' => 'select',
                'std' => '',
                'label' => esc_html__('Bullets Postition', 'nasa-core'),
                'options' => array(
                    '' => esc_html__('Outside', 'nasa-core'),
                    'inside' => esc_html__('Inside', 'nasa-core'),
                    'none' => esc_html__('Not Set', 'nasa-core')
                )
            ),
            
            'bullets_align' => array(
                'type' => 'select',
                'std' => 'center',
                'label' => esc_html__('Bullets Align', 'nasa-core'),
                'options' => array(
                    'center' => esc_html__('Center', 'nasa-core'),
                    'left' => esc_html__('Left', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'navigation' => array(
                'type' => 'select',
                'std' => 'true',
                'label' => esc_html__('Arrows', 'nasa-core'),
                'options' => $this->array_bool_str()
            ),
            
            'column_number' => array(
                'type' => 'select',
                'std' => 1,
                'label' => esc_html__('Columns Number', 'nasa-core'),
                'options' => $this->array_numbers(6)
            ),
            
            'column_number_small' => array(
                'type' => 'select',
                'std' => 1,
                'label' => esc_html__('Columns Number Small', 'nasa-core'),
                'options' => $this->array_numbers(6)
            ),
            
            'column_number_tablet' => array(
                'type' => 'select',
                'std' => 1,
                'label' => esc_html__('Columns Number Tablet', 'nasa-core'),
                'options' => $this->array_numbers(6)
            ),
            
            'padding_item' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Item Padding (px || %)', 'nasa-core')
            ),
            
            'padding_item_small' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Item Padding in Mobile (px || %)', 'nasa-core')
            ),
            
            'padding_item_medium' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Item Padding in Tablet (px || %)', 'nasa-core')
            ),
            
            'autoplay' => array(
                'type' => 'select',
                'std' => 'false',
                'label' => esc_html__('Auto Play', 'nasa-core'),
                'options' => $this->array_bool_str()
            ),
            
            'paginationspeed' => array(
                'type' => 'select',
                'std' => '600',
                'label' => esc_html__('Speed Slider', 'nasa-core'),
                'options' => array(
                    '300'   => esc_html__('0.3s', 'nasa-core'),
                    '400'   => esc_html__('0.4s', 'nasa-core'),
                    '500'   => esc_html__('0.5s', 'nasa-core'),
                    '600'   => esc_html__('0.6s', 'nasa-core'),
                    '700'   => esc_html__('0.7s', 'nasa-core'),
                    '800'   => esc_html__('0.8s', 'nasa-core'),
                    '900'   => esc_html__('0.9s', 'nasa-core'),
                    '1000'  => esc_html__('1.0s', 'nasa-core'),
                    '1100'  => esc_html__('1.1s', 'nasa-core'),
                    '1200'  => esc_html__('1.2s', 'nasa-core'),
                    '1300'  => esc_html__('1.3s', 'nasa-core'),
                    '1400'  => esc_html__('1.4s', 'nasa-core'),
                    '1500'  => esc_html__('1.5s', 'nasa-core'),
                    '1600'  => esc_html__('1.6s', 'nasa-core'),
                )
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );
        
        $this->settings_item = array(
            'pin_slug' => array(
                'type' => 'pin_slug',
                'std' => '',
                'label' => esc_html__('Slug Pin', 'nasa-core')
            ),
            
            'marker_style' => array(
                'type' => 'select',
                'std' => 'price',
                'label' => esc_html__('Marker Style', 'nasa-core'),
                'options' => array(
                    'price' => esc_html__('Price icon', 'nasa-core'),
                    'plus' => esc_html__('Plus icon', 'nasa-core')
                )
            ),
            
            'full_price_icon' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Marker Full Price', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'price_rounding' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Price Rounding', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'show_img' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Show Image', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'show_price' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Show Price', 'nasa-core'),
                'options' => $this->array_bool_YN()
            ),
            
            'pin_effect' => array(
                'type' => 'select',
                'std' => 'no',
                'label' => esc_html__('Effect icons', 'nasa-core'),
                'options' => array(
                    'default' => esc_html__('Default', 'nasa-core'),
                    'yes' => esc_html__('Yes', 'nasa-core'),
                    'no' => esc_html__('No', 'nasa-core')
                )
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );
        
        add_action('nasa_widget_field_sliders_pin_pb', array($this, 'sliders_content'), 10, 4);

        parent::__construct();
    }
    
    /**
     * Updates a particular instance of a widget.
     *
     * @see    WP_Widget->update
     * @param  array $new_instance New instance.
     * @param  array $old_instance Old instance.
     * @return array
     */
    public function update($new_instance, $old_instance) {

        $instance = $old_instance;

        if (empty($this->settings)) {
            return $instance;
        }

        // Loop settings and get values to save.
        foreach ($this->settings as $key => $setting) {
            if (!isset($setting['type'])) {
                continue;
            }

            // Format the value based on settings type.
            switch ($setting['type']) {
                case 'textarea':
                    $instance[$key] = wp_kses(trim(wp_unslash($new_instance[$key])), wp_kses_allowed_html('post'));
                    break;

                case 'checkbox':
                    $instance[$key] = empty($new_instance[$key]) ? 0 : 1;
                    break;
                
                case 'sliders_pin_pb':
                    $instance[$key] = isset($new_instance[$key]) ? $new_instance[$key] : $setting['std'];
                    break;

                default:
                    $instance[$key] = isset($new_instance[$key]) ? sanitize_text_field($new_instance[$key]) : $setting['std'];
                    break;
            }

            /**
             * Sanitize the value of a setting.
             */
            $instance[$key] = apply_filters('nasa_widget_settings_sanitize_option', $instance[$key], $new_instance, $key, $setting);
        }

        return $instance;
    }
    
    /**
     * Slide content
     */
    public function sliders_content($key, $value, $setting, $instance) {
        $data_id = $this->get_field_id($key);
        $data_name = $this->get_field_name($key);
        ?>
        <div class="nasa-sliders-content nasa-wrap-items">
            <span for="<?php echo esc_attr($data_id); ?>"><?php echo $setting['label']; ?></span>
            
            <div class="nasa-sliders-content-wrap nasa-appent-wrap" data-id="<?php echo esc_attr($data_id); ?>">
                <?php
                if (!empty($value)) {
                    foreach ($value as $order => $slide) {
                        include NASA_CORE_PLUGIN_PATH . 'admin/views/widgets_elementor/slider-item.php';
                    }
                }
                ?>
            </div>
            
            <a href="javascript:void(0);" class="nasa-add-item">
                <?php echo esc_html__('Add New Slide', 'nasa-core'); ?>
            </a>
            
            <?php /* Template new tab */ ?>
            <script type="text/template" class="tmpl-nasa-content">
                <?php
                $order = '{{order}}';
                $slide = array();
                include NASA_CORE_PLUGIN_PATH . 'admin/views/widgets_elementor/slider-item.php';
                ?>
            </script>
        </div>

        <?php
    }
    
    /**
     * Outputs the settings update form.
     *
     * @see   WP_Widget->form
     *
     * @param array $instance Instance.
     */
    public function form_slide($instance, $name_root, $id_root, $order) {
        if (empty($this->settings_item)) {
            return;
        }

        foreach ($this->settings_item as $key => $setting) {
            if (!isset($setting['std'])) {
                $setting['std'] = '';
            }

            $class = isset($setting['class']) ? $setting['class'] : '';
            $value = isset($instance[$key]) ? $instance[$key] : $setting['std'];
            $data_id = $id_root . '-' . $order . '-' . $key;
            $data_name = $name_root . '[' . $order . '][' . $key . ']';

            switch ($setting['type']) {

                case 'text':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr($data_id); ?>">
                            <?php echo wp_kses_post($setting['label']); ?>
                        </label>
                        
                        <input class="widefat <?php echo esc_attr($class); ?>" id="<?php echo esc_attr($data_id); ?>" name="<?php echo esc_attr($data_name); ?>" type="text" value="<?php echo esc_attr($value); ?>" />
                    </p>
                    <?php
                    break;

                case 'select':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr($data_id); ?>">
                            <?php echo wp_kses_post($setting['label']); ?>
                        </label>
                        
                        <select class="widefat <?php echo esc_attr($class); ?>" id="<?php echo esc_attr($data_id); ?>" name="<?php echo esc_attr($data_name); ?>">
                            <?php foreach ($setting['options'] as $option_key => $option_value) : ?>
                                <option value="<?php echo esc_attr($option_key); ?>" <?php selected($option_key, $value); ?>><?php echo esc_html($option_value); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <?php
                    break;
                    
                case 'textarea':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr($data_id); ?>"><?php echo wp_kses_post($setting['label']); ?></label>
                        <textarea class="widefat <?php echo esc_attr($class); ?>" id="<?php echo esc_attr($data_id); ?>" name="<?php echo esc_attr($data_name); ?>" cols="20" rows="5"><?php echo esc_textarea($value); ?></textarea>
                        <?php if (isset($setting['desc'])) : ?>
                            <small><?php echo esc_html($setting['desc']); ?></small>
                        <?php endif; ?>
                    </p>
                    <?php
                    break;
                    
                /**
                 * Set pin slug field
                 */
                case 'pin_slug':
                    $pin_type = 'nasa_pin_pb';
                    $args_pin = array(
                        'name'        => $value,
                        'post_type'   => $pin_type,
                        'post_status' => 'publish',
                        'numberposts' => 1
                    );
                    $pin_array = $value ? get_posts($args_pin) : null;
                    $pin = $pin_array && isset($pin_array[0]) ? $pin_array[0] : null;
                    ?>

                    <div class="nasa-pins-wrap nasa-root-wrap">
                        <span for="<?php echo esc_attr($data_id); ?>"><?php echo $setting['label']; ?></span>
                        <input class="slug-selected" type="hidden" id="<?php echo esc_attr($data_id); ?>" name="<?php echo esc_attr($data_name); ?>" value="<?php echo esc_attr($value); ?>" />

                        <div class="info-selected" data-no-selected="<?php echo esc_html__('There is not Pin selected.', 'nasa-core'); ?>">
                            <?php if ($pin) : ?>
                                <p class="pin-name">
                                    <?php echo $pin->post_title; ?> ( <?php echo $pin->post_name; ?> )
                                </p>
                                <a href="javascript:void(0);" class="nasa-remove-selected"></a>
                            <?php else: ?>
                                <p class="no-selected">
                                    <?php echo esc_html__('There is not Pin selected.', 'nasa-core'); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <a class="select-pin-item" data-type="<?php echo esc_attr($pin_type); ?>" href="javascript:void(0);">
                            <?php echo esc_html__('Click here to select Pin...', 'nasa-core'); ?>
                        </a>
                        <div class="list-items-wrap" data-list="0">
                            <input type="text" class="nasa-input-search" name="nasa-input-search" placeholder="<?php echo esc_attr('Search ...', 'nasa-core'); ?>" />
                            <div class="list-items"></div>
                        </div>
                    </div>

                    <?php
                    break;

                // Default: run an action.
                default:
                    
                    break;
            }
        }
    }
    
    /**
     * 
     * @param type $args
     * @param type $instance
     */
    public function widget($args, $instance) {
        if (empty($instance['sliders'])) {
            return;
        }
        
        nasa_template('widgets_elementor/nasa-sliders.php', array('instance' => $instance, '_this' => $this));
    }
}
