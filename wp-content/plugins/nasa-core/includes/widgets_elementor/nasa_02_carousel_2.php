<?php
/**
 * Widget for Elementor
 */
class Nasa_Sliders_2_WGSC extends Nasa_Elementor_Widget {
    
    /**
     * Settings tab
     * 
     * @var type 
     */
    public $settings_item = array();

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_banner_2';
        $this->widget_cssclass = 'woocommerce nasa_sliders_2_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Sliders with Banner v2', 'nasa-core');
        $this->widget_id = 'nasa_sliders_2_sc';
        $this->widget_name = esc_html__('Nasa Sliders v2', 'nasa-core');
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
                'type' => 'sliders_2',
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
                'std' => '800',
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
            'img_src' => array(
                'type' => 'attach_image',
                'std' => '',
                'label' => esc_html__('Banner Image', 'nasa-core')
            ),
            
            'link' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Link', 'nasa-core')
            ),
            
            'content_width' => array(
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
            
            'text_align' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Text Alignment', 'nasa-core'),
                'options' => array(
                    'text-left' => esc_html__('Left', 'nasa-core'),
                    'text-center' => esc_html__('Center', 'nasa-core'),
                    'text-right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'content' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => esc_html__('Banner Text', 'nasa-core')
            ),
            
            'effect_text' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Effect Content', 'nasa-core'),
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
                    '100ms' => esc_html__('100ms', 'nasa-core'),
                    '200ms' => esc_html__('200ms', 'nasa-core'),
                    '300ms' => esc_html__('300ms', 'nasa-core'),
                    '400ms' => esc_html__('400ms', 'nasa-core'),
                    '500ms' => esc_html__('500ms', 'nasa-core'),
                    '600ms' => esc_html__('600ms', 'nasa-core'),
                    '700ms' => esc_html__('700ms', 'nasa-core'),
                    '800ms' => esc_html__('800ms', 'nasa-core'),
                )
            ),
            
            'hover' => array(
                'type' => 'select',
                'std' => 'left',
                'label' => esc_html__('Effect Image', 'nasa-core'),
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
        
        add_action('nasa_widget_field_sliders_2', array($this, 'sliders_content'), 10, 4);

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
                
                case 'sliders_2':
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
                 * Set image field
                 */
                case 'attach_image':
                    $class_wrap = 'nasa-wrap-attach-img admin-text-center';

                    $image_src = false;
                    if ($value) :
                        $image = wp_get_attachment_image_src($value, 'thumbnail', false);
                        $image_src = isset($image[0]) ? esc_url($image[0]) : false;
                    endif;

                    if (!$image_src) :
                        $image_src = nasa_no_image(true);
                        $class_wrap .= ' nasa-wrap-no-img';
                    endif;
                    ?>

                    <div class="<?php echo esc_attr($class_wrap); ?>" id="wrap_<?php echo esc_attr($data_id); ?>">
                        <label for="<?php echo esc_attr($data_id); ?>">
                            <?php echo wp_kses_post($setting['label']); ?>
                        </label>

                        <input class="hidden-tag attach-img-id" id="input_<?php echo esc_attr($data_id); ?>" name="<?php echo esc_attr($data_name); ?>" type="hidden" value="<?php echo esc_attr($value); ?>" />

                        <div class="nasa-attach-img" id="img_<?php echo esc_attr($data_id); ?>">
                            <img src="<?php echo $image_src; ?>" />
                        </div>

                        <button type="button" class="nasa_upload_img button" data-choose-text="<?php esc_attr_e("Choose an image", "nasa-core"); ?>" data-use-text="<?php esc_attr_e("Use image", "nasa-core"); ?>" data-id="<?php echo esc_attr($data_id); ?>">
                            <?php echo esc_html__('Upload/Add image', 'nasa-core'); ?>
                        </button>

                        <button type="button" class="nasa_remove_img button" data-id="<?php echo esc_attr($data_id); ?>" data-no-image="<?php echo nasa_no_image(true); ?>">
                            <?php echo esc_html__('Remove Image', 'nasa-core'); ?>
                        </button>
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
