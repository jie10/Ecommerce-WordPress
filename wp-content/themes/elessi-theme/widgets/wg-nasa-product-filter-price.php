<?php
defined('ABSPATH') or die(); // Exit if accessed directly

if (NASA_WOO_ACTIVED) {

    add_action('widgets_init', 'elessi_product_filter_price_widget');
    function elessi_product_filter_price_widget() {
        register_widget('Elessi_WC_Widget_Price_Filter');
    }

    /**
     * Price Filter Widget and related functions
     *
     * Generates a range slider to filter products by price.
     *
     * @author   NasaThemes
     * @category Widgets
     * @version  1.0.0
     * @extends  WC_Widget
     */
    class Elessi_WC_Widget_Price_Filter extends WC_Widget {

        /**
         * Constructor
         */
        public function __construct() {
            $this->widget_cssclass = 'woocommerce widget_price_filter nasa-price-filter-slide nasa-widget-has-active';
            $this->widget_description = esc_html__('Shows a price filter slider in a widget which lets you narrow down the list of shown products when viewing product categories.', 'elessi-theme');
            $this->widget_id = 'nasa_woocommerce_price_filter';
            $this->widget_name = esc_html__('Nasa Product Price Filter', 'elessi-theme');
            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => esc_html__('Filter by price', 'elessi-theme'),
                    'label' => esc_html__('Title', 'elessi-theme')
                ),
                'btn_filter' => array(
                    'type' => 'checkbox',
                    'std' => 0,
                    'label' => esc_html__('Enable Button Filter', 'elessi-theme')
                ),
            );
            
            $pluginURL = WC()->plugin_url();
            $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
            wp_register_script('accounting', $pluginURL . '/assets/js/accounting/accounting' . $suffix . '.js', array('jquery'), '0.4.2');
            wp_register_script('wc-jquery-ui-touchpunch', $pluginURL . '/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch' . $suffix . '.js', array('jquery-ui-slider'), WC_VERSION, true);
            wp_register_script('wc-price-slider', $pluginURL . '/assets/js/frontend/price-slider' . $suffix . '.js', array('jquery-ui-slider', 'wc-jquery-ui-touchpunch', 'accounting'), WC_VERSION, true);
            wp_localize_script('wc-price-slider', 'woocommerce_price_slider_params', array(
                'min_price' => isset($_REQUEST['min_price']) ? esc_attr($_REQUEST['min_price']) : '',
                'max_price' => isset($_REQUEST['max_price']) ? esc_attr($_REQUEST['max_price']) : '',
                'currency_format_num_decimals' => 0,
                'currency_format_symbol' => get_woocommerce_currency_symbol(),
                'currency_format_decimal_sep' => esc_attr(wc_get_price_decimal_separator()),
                'currency_format_thousand_sep' => esc_attr(wc_get_price_thousand_separator()),
                'currency_format' => esc_attr(str_replace(array('%1$s', '%2$s'), array('%s', '%v'), get_woocommerce_price_format())),
            ));
            
            if (is_customize_preview()) {
                wp_enqueue_script('wc-price-slider');
            }

            parent::__construct();
        }

        /**
         * Output the html at the start of a widget.
         *
         * @param  array $args
         * @return string
         */
        public function current_widget_start($args, $instance) {
            echo $args['before_widget'];
        }

        /**
         * Output the html at the end of a widget.
         *
         * @param  array $args
         * @return string
         */
        public function current_widget_end($args) {
            parent::widget_end($args);
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
            if (!is_shop() && !is_product_taxonomy()) {
                return;
            }
            
            wp_enqueue_script('wc-price-slider');
            
            $this->current_widget_start($args, $instance);
            
            $_title = isset($instance['title']) ? $instance['title'] : esc_html__('Price', 'elessi-theme');
            $_btn_filter = isset($instance['btn_filter']) ? $instance['btn_filter'] : 0;

            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

            $min_price = isset($_REQUEST['min_price']) ? esc_attr($_REQUEST['min_price']) : '';
            $max_price = isset($_REQUEST['max_price']) ? esc_attr($_REQUEST['max_price']) : '';
            $hasPrice = ($min_price !== '' && $max_price !== '' && ($min_price >= 0 || $max_price >= $min_price)) ? '1' : '0';
            $class_reset = $hasPrice == '1' ? '' : ' hidden-tag';

            // Remember current filters/search
            $fields = ($search_query = get_search_query()) ? '<input type="hidden" name="s" value="' . $search_query . '" />' : '';

            $fields .= !empty($_REQUEST['post_type']) ? '<input type="hidden" name="post_type" value="' . esc_attr($_REQUEST['post_type']) . '" />' : '';

            $fields .= !empty($_REQUEST['product_cat']) ? '<input type="hidden" name="product_cat" value="' . esc_attr($_REQUEST['product_cat']) . '" />' : '';

            $fields .= !empty($_REQUEST['product_tag']) ? '<input type="hidden" name="product_tag" value="' . esc_attr($_REQUEST['product_tag']) . '" />' : '';

            $fields .= !empty($_REQUEST['orderby']) ? '<input type="hidden" name="orderby" value="' . esc_attr($_REQUEST['orderby']) . '" />' : '';
            
            // Filter Status
            if (class_exists('Elessi_WC_Widget_Status_Filter')) {
                foreach (Elessi_WC_Widget_Status_Filter::$_status as $status) {
                    if (isset($_REQUEST[$status]) && $_REQUEST[$status] === '1') {
                        $fields .= '<input type="hidden" name="' . esc_attr($status) . '" value="1" />';
                    }
                }
            }

            if ($_chosen_attributes) {
                foreach ($_chosen_attributes as $attribute => $data) {
                    $attr_name = 0 === strpos($attribute, 'pa_') ? substr($attribute, 3) : $attribute;
                    $taxonomy_filter = 'filter_' . $attr_name;
                    $fields .= '<input type="hidden" name="' . esc_attr($taxonomy_filter) . '" value="' . esc_attr(implode(',', $data['terms'])) . '" />';

                    if ('or' == $data['query_type']) {
                        $query_filter = 'query_type_' . $attr_name;
                        $fields .= '<input type="hidden" name="' . esc_attr($query_filter) . '" value="or" />';
                    }
                }
            }
            
            $fields .= !empty($_REQUEST['product-tags']) ? '<input type="hidden" name="product-tags" value="' . esc_attr($_REQUEST['product-tags']) . '" />' : '';

            // Find min and max price in current result set
            $prices     = elessi_get_filtered_price();
            $min        = $prices->min_price;
            $max        = $prices->max_price;
            
            $step = max(apply_filters('woocommerce_price_filter_widget_step', 10), 1);

            if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && !wc_prices_include_tax()) {
                $tax_classes = array_merge(array(''), WC_Tax::get_tax_classes());
                $class_max = $max;

                foreach ($tax_classes as $tax_class) {
                    if ($tax_rates = WC_Tax::get_rates($tax_class)) {
                        $class_max = $max + WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($max, $tax_rates));
                    }
                }

                $max = $class_max;
            }
            
            $min = apply_filters('woocommerce_price_filter_widget_min_amount', floor($min / $step) * $step);
            $max = apply_filters('woocommerce_price_filter_widget_max_amount', ceil($max / $step) * $step);
            
            $min_price = isset($_REQUEST['min_price']) ? floor(floatval(wp_unslash($_REQUEST['min_price'])) / $step) * $step : $min; // WPCS: input var ok, CSRF ok.
            $max_price = isset($_REQUEST['max_price']) ? ceil(floatval(wp_unslash($_REQUEST['max_price'])) / $step) * $step : $max; // WPCS: input var ok, CSRF ok.

            if ($min_price < $min) {
                $min = $min_price;
            }

            if ($max_price > $max) {
                $max = $max_price;
            }

            if ($min == $max) {
                echo '<div id="' . $args['widget_id'] . '-ajax-wrap" class="nasa-hide-price nasa-filter-price-widget-wrap">' .
                    $args['before_title'] . $_title . $args['after_title'] .
                '</div>';
                
                $this->current_widget_end($args);
                
                return;
            }

            $res = '<div id="' . $args['widget_id'] . '-ajax-wrap" class="nasa-filter-price-widget-wrap">';

            if ($_title != '') {
                $res .= $args['before_title'] . $_title . $args['after_title'];
            }

            /**
             * Round one more time
             */
            $data_min = floor($min);
            $data_max = ceil($max);
            
            $form_action = elessi_get_origin_url();

            $res .=
                '<form method="get" action="' . esc_url($form_action) . '">' .
                    '<div class="price_slider_wrapper">' .
                        '<div class="price_slider"></div>' .
                        '<div class="price_slider_amount">' .
                            '<input type="text" id="min_price" name="min_price" value="' . esc_attr($min_price) . '" data-min="' . esc_attr($data_min) . '" placeholder="' . esc_attr__('Min price', 'elessi-theme') . '" />' .
                            '<input type="text" id="max_price" name="max_price" value="' . esc_attr($max_price) . '" data-max="' . esc_attr($data_max) . '" placeholder="' . esc_attr__('Max price', 'elessi-theme') . '" />' .
                            '<div class="price_label">' .
                                esc_html__('Price:', 'elessi-theme') . ' <span class="from"></span> &mdash; <span class="to"></span>' .
                                '<a href="javascript:void(0);" class="reset_price' . esc_attr($class_reset) . '" rel="nofollow">' . esc_html__('Reset', 'elessi-theme') . '</a>' .
                            '</div>' .
                            $fields .
                            ($_btn_filter ? '<button type="submit" class="button nasa-transition right rtl-left nasa-filter-price-btn">' . esc_html__('Filter', 'elessi-theme') . '</button>' : '') .
                        '</div>' .
                    '</div>' .
                    '<input type="hidden" class="nasa_hasPrice" name="nasa_hasPrice" value="' . esc_attr($hasPrice) . '" />' .
                '</form>';

            $res .= '</div>';

            echo $res;
            
            $this->current_widget_end($args);
        }
    }
}
