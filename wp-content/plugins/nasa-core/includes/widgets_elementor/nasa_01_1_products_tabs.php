<?php
/**
 * Widget for Elementor
 */
class Nasa_Products_Tabs_WGSC extends Nasa_Elementor_Widget {
    
    /**
     * Settings tab
     * 
     * @var type 
     */
    public $settings_tab = array();

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_products';
        $this->widget_cssclass = 'woocommerce nasa_products_tabs_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Products Tabs', 'nasa-core');
        $this->widget_id = 'nasa_products_tabs_sc';
        $this->widget_name = esc_html__('Nasa Products Tabs', 'nasa-core');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'class' => 'first',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'desc' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Description', 'nasa-core')
            ),
            
            'alignment' => array(
                'type' => 'select',
                'std' => 'center',
                'label' => esc_html__('Alignment', 'nasa-core'),
                'options' => array(
                    'center' => esc_html__('Center', 'nasa-core'),
                    'left' => esc_html__('Left', 'nasa-core'),
                    'right' => esc_html__('Right', 'nasa-core')
                )
            ),
            
            'style' => array(
                'type' => 'select',
                'std' => '2d-no-border',
                'label' => esc_html__('Style', 'nasa-core'),
                'options' => array(
                    "2d-no-border"      => esc_html__("Classic 2D - No Border", 'nasa-core'),
                    "2d-radius"         => esc_html__("Classic 2D - Radius", 'nasa-core'),
                    "2d-radius-dashed"  => esc_html__("Classic 2D - Radius - Dash", 'nasa-core'),
                    "2d-has-bg"         => esc_html__("Classic 2D - Background - Gray", 'nasa-core'),
                    "2d"                => esc_html__("Classic 2D", 'nasa-core'),
                    "3d"                => esc_html__("Classic 3D", 'nasa-core'),
                    "slide"             => esc_html__("Slide", 'nasa-core'),
                )
            ),
            
            'tabs' => array(
                'type' => 'tabs',
                'std' => array(),
                'label' => esc_html__('Tabs Content', 'nasa-core')
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );
        
        $this->settings_tab = array(
            'tab_title' => array(
                'type' => 'text',
                'std' => esc_html__('TAB TITLE', 'nasa-core'),
                'label' => esc_html__('Title', 'nasa-core')
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
                'label' => esc_html__('Dots (Only use for Style is Carousel)', 'nasa-core'),
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
                'options' => $this->array_numbers(2)
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
        
        add_action('nasa_widget_field_tabs', array($this, 'tabs_content'), 10, 4);

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
                
                case 'tabs':
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
     * Tabs content
     */
    public function tabs_content($key, $value, $setting, $instance) {
        $data_id = $this->get_field_id($key);
        $data_name = $this->get_field_name($key);
        ?>
        <div class="nasa-tabs-content nasa-wrap-items">
            <span for="<?php echo esc_attr($data_id); ?>"><?php echo $setting['label']; ?></span>
            
            <div class="nasa-tabs-content-wrap nasa-appent-wrap" data-id="<?php echo esc_attr($data_id); ?>">
                <?php
                if (!empty($value)) {
                    foreach ($value as $order => $tab) {
                        include NASA_CORE_PLUGIN_PATH . 'admin/views/widgets_elementor/tab-content-products.php';
                    }
                }
                ?>
            </div>
            
            <a href="javascript:void(0);" class="nasa-add-item">
                <?php echo esc_html__('Add New Tab', 'nasa-core'); ?>
            </a>
            
            <?php /* Template new tab */ ?>
            <script type="text/template" class="tmpl-nasa-content">
                <?php
                $order = '{{order}}';
                $tab = array();
                include NASA_CORE_PLUGIN_PATH . 'admin/views/widgets_elementor/tab-content-products.php';
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
    public function form_tab($instance, $name_root, $id_root, $order) {
        if (empty($this->settings_tab)) {
            return;
        }

        foreach ($this->settings_tab as $key => $setting) {
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
                    
                /**
                 * Set categories field
                 */
                case 'product_categories':
                    $term = $value ? get_term_by('slug', $value, 'product_cat') : null;
                    ?>

                    <div class="nasa-categories-wrap nasa-root-wrap">
                        <span for="<?php echo esc_attr($data_id); ?>"><?php echo $setting['label']; ?></span>
                        <input class="slug-selected" type="hidden" id="<?php echo esc_attr($data_id); ?>" name="<?php echo esc_attr($data_name); ?>" value="<?php echo esc_attr($value); ?>" />

                        <div class="info-selected" data-no-selected="<?php echo esc_html__('There is not Category selected.', 'nasa-core'); ?>">
                            <?php if($term) : ?>
                                <p class="category-name">
                                    <?php echo $term->name; ?> ( <?php echo $term->slug; ?> )
                                </p>
                                <a href="javascript:void(0);" class="nasa-remove-selected"></a>
                            <?php else: ?>
                                <p class="no-selected">
                                    <?php echo esc_html__('There is not Category selected.', 'nasa-core'); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <a class="select-cat-item" href="javascript:void(0);"><?php echo esc_html__('Click here to select Category ...', 'nasa-core'); ?></a>
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
        if (empty($instance['tabs'])) {
            return;
        }
        
        nasa_template('widgets_elementor/nasa-products-tabs.php', array('instance' => $instance, '_this' => $this));
    }
}
