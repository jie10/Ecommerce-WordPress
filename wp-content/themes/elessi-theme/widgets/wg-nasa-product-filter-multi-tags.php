<?php
/**
 * Exit if accessed directly
 */
defined('ABSPATH') or die();

/**
 * Check WooCommerce Active
 */
if (NASA_WOO_ACTIVED) {

    add_action('widgets_init', 'elessi_product_filter_tags_widget');

    function elessi_product_filter_tags_widget() {
        register_widget('Elessi_WC_Widget_Tags_Filter');
    }

    class Elessi_WC_Widget_Tags_Filter extends WC_Widget {
        
        public static $_request_name = 'product-tags';
        
        protected $_current_filters = array();

        protected $_link = '';
        
        /**
         * Constructor
         */
        public function __construct() {
            $this->widget_cssclass = 'woocommerce widget_multi_tags_filter nasa-any-filter nasa-widget-has-active';
            $this->widget_description = esc_html__('Display a list of tags to filter products.', 'elessi-theme');
            $this->widget_id = 'nasa_woocommerce_multi_tags_filter';
            $this->widget_name = esc_html__('Nasa Product Filter Multi Tags', 'elessi-theme');
            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => esc_html__('Filter by Tags', 'elessi-theme'),
                    'label' => esc_html__('Title', 'elessi-theme')
                ),
                'number' => array(
                    'type' => 'text',
                    'std' => 45,
                    'label' => esc_html__('Number Tags', 'elessi-theme')
                ),
            );
            
            if (!empty($_REQUEST[self::$_request_name])) {
                $this->_current_filters = is_array($_REQUEST[self::$_request_name]) ?
                    $_REQUEST[self::$_request_name] : explode(',', wc_clean($_REQUEST[self::$_request_name]));
            }
            
            add_action('woocommerce_product_query', array($this, 'filter_tags_product_query'));

            parent::__construct();
        }
        
        /**
         * Filter by status product
         * 
         * @param type $q
         */
        public function filter_tags_product_query($q){
            if (empty($this->_current_filters)) {
                return;
            }
            
            $q_tax_query = $q->get('tax_query');
            $tax_query = !empty($q_tax_query) ? $q_tax_query : array();
            $tax_query[] = array(
                'taxonomy' => 'product_tag',
                'field' => 'slug',
                'terms' => $this->_current_filters,
                'operator' => 'IN'
            );

            if (!empty($tax_query)) {
                $q->set('tax_query', $tax_query);
            }
        }
        
        /**
         * Build link tag
         */
        protected function build_tag_link($tag) {
            $new_current = array();
            $class = 'nasa-filter-tag';
            if (!in_array($tag->slug, $this->_current_filters)) {
                $new_current = $this->_current_filters;
                $new_current[] = $tag->slug;
            } else {
                $class .= ' nasa-active';
                foreach ($this->_current_filters as $value) {
                    if ($value !== $tag->slug) {
                        $new_current[] = $value;
                    }
                }
            }
            
            $link_tag = !empty($new_current) ? add_query_arg(self::$_request_name, rawurlencode(wc_clean(implode(',', $new_current))), $this->_link) : $this->_link;
            
            $html = '<a title="' . esc_attr($tag->name) . '" class="' . $class . '" href="' . esc_url($link_tag) . '" data-filter="' . esc_attr($tag->slug) . '">' . esc_html($tag->name) . '</a>';
            
            return $html;
        }

        /**
         * widget function.
         *
         * @see WP_Widget
         * @param array $args
         * @param array $instance
         */
        public function widget($args, $instance) {
            if (!is_shop() && !is_product_taxonomy()) {
                return;
            }

            /**
             * Number Tags show
             */
            $number = isset($instance['number']) && (int) $instance['number'] ? (int) $instance['number'] : $this->settings['number']['std'];
            
            /**
             * Query Tags
             */
            $tags = get_terms(apply_filters('nasa_filter_tags_args', array(
		'number' => $number,
		'taxonomy' => 'product_tag',
                'orderby' => 'count',
                'order' => 'DESC'
            )));
            
            if (!$tags) {
                return;
            }
            
            extract($args);
            
            $this->_link = elessi_get_origin_url();
            
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if ($key !== self::$_request_name) {
                        $this->_link = add_query_arg($key, esc_attr($value), $this->_link);
                    }
                }
            }

            if ($_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes()) {
                foreach ($_chosen_attributes as $attribute => $data) {
                    $attr_name = 0 === strpos($attribute, 'pa_') ? substr($attribute, 3) : $attribute;
                    $taxonomy_filter = 'filter_' . $attr_name;
                    $this->_link = add_query_arg(esc_attr($taxonomy_filter), esc_attr(implode(',', $data['terms'])), $this->_link);

                    if ('or' == $data['query_type']) {
                        $this->_link = add_query_arg(esc_attr(str_replace('pa_', 'query_type_', $attribute)), 'or', $this->_link);
                    }
                }
            }
            
            $output = '<div class="nasa-filter-by-tags">';
            
            foreach ($tags as $tag) {
                $output .= $this->build_tag_link($tag);
            }
            
            $output .= '</div>';

            $this->widget_start($args, $instance);
            echo $output;
            $this->widget_end($args);
        }
    }
}
