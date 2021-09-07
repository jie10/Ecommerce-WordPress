<?php
defined('ABSPATH') or die(); // Exit if accessed directly

if (NASA_WOO_ACTIVED) {
    add_action('widgets_init', 'elessi_product_variations_widget');
    function elessi_product_variations_widget() {
        register_widget('Elessi_Product_Variations_Widget');
    }

    /**
     * Layered Navigation Widget
     *
     * @author   WooThemes
     * @category Widgets
     * @package  WooCommerce/Widgets
     * @version  2.3.0
     * @extends  WC_Widget
     */
    class Elessi_Product_Variations_Widget extends WC_Widget {

        public static $nasa_widget_id = 'nasa_woocommerce_filter_variations';

        /**
         * Constructor
         */
        public function __construct() {
            $this->widget_cssclass = 'woocommerce widget_layered_nav nasa-widget-has-active';
            $this->widget_description = esc_html__('Shows a custom attribute in a widget which lets you narrow down the list of products when viewing product categories.', 'elessi-theme');
            $this->widget_id = self::$nasa_widget_id;
            $this->widget_name = esc_html__('Nasa Product Attributes Filter', 'elessi-theme');

            parent::__construct();
        }

        /**
         * update function.
         *
         * @see WP_Widget->update
         *
         * @param array $new_instance
         * @param array $old_instance
         *
         * @return array
         */
        public function update($new_instance, $old_instance) {
            $this->init_settings($new_instance);

            return parent::update($new_instance, $old_instance);
        }

        /**
         * form function.
         *
         * @see WP_Widget->form
         *
         * @param array $instance
         */
        public function form($instance) {
            $this->init_settings($instance);
            
            if (empty($this->settings)) {
                return;
            }

            echo "<p class='nasa-widget-instance' data-instance='" . esc_attr(json_encode($instance)) . "'></p>";
            
            foreach ($this->settings as $key => $setting) {
                $value = isset($instance[$key]) ? $instance[$key] : $setting['std'];
                $clss = isset($setting['class']) ? ' ' . $setting['class'] : '';

                $_id = $this->get_field_id($key);
                $_name = $this->get_field_name($key);

                switch ($setting['type']) {

                    case 'text' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo ($setting['label']); ?></label>
                            <input class="widefat<?php echo esc_attr($clss); ?>" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="text" value="<?php echo esc_attr($value); ?>" />
                        </p>
                        <?php
                        break;

                    case 'number' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo ($setting['label']); ?></label>
                            <input class="widefat<?php echo esc_attr($clss); ?>" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="number" step="<?php echo esc_attr($setting['step']); ?>" min="<?php echo esc_attr($setting['min']); ?>" max="<?php echo esc_attr($setting['max']); ?>" value="<?php echo esc_attr($value); ?>" />
                        </p>
                        <?php
                        break;

                    case 'select' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo ($setting['label']); ?></label>
                            <select class="widefat<?php echo esc_attr($clss); ?>" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" data-num="<?php echo esc_attr($this->number); ?>">
                                <?php foreach ($setting['options'] as $option_key => $option_value) : ?>
                                    <option value="<?php echo esc_attr($option_key); ?>" <?php selected($option_key, $value); ?>><?php echo esc_html($option_value); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <?php
                        break;

                    case 'checkbox' :
                        ?>
                        <p>
                            <input class="widefat<?php echo esc_attr($clss); ?>" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="checkbox" value="1" <?php checked($value, 1); ?> />
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo ($setting['label']); ?></label>
                        </p>
                        <?php
                        break;
                }
            }
        }

        /**
         * Init settings after post types are registered
         */
        public function init_settings($instance) {
            $attribute_array = array();
            $attribute_taxonomies = wc_get_attribute_taxonomies();

            if ($attribute_taxonomies) {
                foreach ($attribute_taxonomies as $tax) {
                    if (taxonomy_exists(wc_attribute_taxonomy_name($tax->attribute_name))) {
                        $attribute_array[$tax->attribute_name] = $tax->attribute_label . '&nbsp;(&nbsp;' . $tax->attribute_name . '&nbsp;)';
                    }
                }
            }

            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => esc_html__('Filter by', 'elessi-theme'),
                    'label' => esc_html__('Title', 'elessi-theme')
                ),
                'attribute' => array(
                    'type' => 'select',
                    'class' => 'nasa-select-attr',
                    'std' => '',
                    'label' => esc_html__('Attribute', 'elessi-theme'),
                    'options' => $attribute_array
                ),
                'query_type' => array(
                    'type' => 'select',
                    'std' => 'or',
                    'label' => esc_html__('Query type', 'elessi-theme'),
                    'options' => array(
                        'or' => esc_html__('OR', 'elessi-theme'),
                        'and' => esc_html__('AND', 'elessi-theme')
                    )
                ),
                'show_items' => array(
                    'type' => 'text',
                    'std' => 'All',
                    'label' => esc_html__('Show default numbers items', 'elessi-theme')
                ),
                'effect' => array(
                    'type' => 'select',
                    'std' => 'slide',
                    'label' => esc_html__('Effect for show more and show less', 'elessi-theme'),
                    'options' => array(
                        'slide' => esc_html__('Slide Up-Down', 'elessi-theme'),
                        'fade' => esc_html__('Fade In-Out', 'elessi-theme')
                    )
                ),
                'hide_empty' => array(
                    'type' => 'checkbox',
                    'std' => 0,
                    'label' => esc_html__('Hide empty', 'elessi-theme')
                ),
                'count' => array(
                    'type' => 'checkbox',
                    'std' => 0,
                    'label' => esc_html__('Show product counts', 'elessi-theme')
                )
            );
        }

        /**
         * widget function.
         *
         * @see WP_Widget
         *
         * @param array $args
         * @param array $instance
         */
        public function widget($args, $instance) {
            if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
                return;
            }
            
            // Get widget content
            $widget_data = elessi_get_content_widget_variation($args, $instance);
            
            if (isset($widget_data['hide_widget']) && $widget_data['hide_widget']) {
                return;
            }
            
            $this->widget_start($args, $instance);
            echo $widget_data['content'];
            $this->widget_end($args);
        }
    }
}
