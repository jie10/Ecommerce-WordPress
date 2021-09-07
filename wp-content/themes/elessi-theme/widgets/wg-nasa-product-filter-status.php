<?php
defined('ABSPATH') or die(); // Exit if accessed directly

if (NASA_WOO_ACTIVED) {

    add_action('widgets_init', 'elessi_product_filter_status_widget');

    function elessi_product_filter_status_widget() {
        register_widget('Elessi_WC_Widget_Status_Filter');
    }

    class Elessi_WC_Widget_Status_Filter extends WC_Widget {
        
        public static $_status = array('on-sale', 'featured', 'in-stock', 'on-backorder');
        
        protected $_tax_query = array();
        protected $_meta_query = array();
        protected $_query = null;

        /**
         * Constructor
         */
        public function __construct() {
            $this->widget_cssclass = 'woocommerce widget_status_filter nasa-any-filter nasa-widget-has-active';
            $this->widget_description = esc_html__('Display a list of status to filter products.', 'elessi-theme');
            $this->widget_id = 'nasa_woocommerce_status_filter';
            $this->widget_name = esc_html__('Nasa Product Filter Status', 'elessi-theme');
            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => esc_html__('Filter by status', 'elessi-theme'),
                    'label' => esc_html__('Title', 'elessi-theme')
                ),
                
                'filter_onsale' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('On Sale', 'elessi-theme')
                ),
                
                'filter_featured' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('Featured', 'elessi-theme')
                ),
                
                'filter_instock' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('In Stock', 'elessi-theme')
                ),
                
                'filter_onbackorder' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('On Backorder', 'elessi-theme')
                ),
            );
            
            add_action('woocommerce_product_query', array($this, 'filter_status_product_query'));

            parent::__construct();
        }
        
        /**
         * Get ids On Sale
         */
        protected function _ids_on_sale() {
            $ids_on_sale = wc_get_product_ids_on_sale();
            
            return empty($ids_on_sale) ? array(0) : $ids_on_sale;
        }
        
        /**
         * Filter by status product
         * 
         * @param type $q
         */
        public function filter_status_product_query($q){
            /**
             * On sale
             */
            if (isset($_REQUEST['on-sale']) && $_REQUEST['on-sale'] === '1') {
                $q->set('post__in', $this->_ids_on_sale());
            }

            /**
             * Featured
             */
            if (isset($_REQUEST['featured']) && $_REQUEST['featured'] === '1') {
                $this->build_tax_query($q);
                $this->_tax_query[] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'name',
                    'terms' => 'featured'
                );
            }

            /**
             * In stock
             */
            if (isset($_REQUEST['in-stock']) && $_REQUEST['in-stock'] === '1') {
                $visibility_terms = wc_get_product_visibility_term_ids();
                $terms_not_in = array($visibility_terms['exclude-from-catalog']);
                $terms_not_in[] = $visibility_terms['outofstock'];

                if (!empty($terms_not_in)) {
                    $this->build_tax_query($q);
                    $this->_tax_query[] = array(
                        'taxonomy' => 'product_visibility',
                        'field' => 'term_taxonomy_id',
                        'terms' => $terms_not_in,
                        'operator' => 'NOT IN',
                    );
                }
            }
            
            /**
             * On Backorder
             */
            if (isset($_REQUEST['on-backorder']) && $_REQUEST['on-backorder'] === '1') {
                $this->build_meta_query($q);
                $this->_meta_query[] = array(
                    'key' => '_backorders',
                    'value' => 'yes'
                );
            }

            /**
             * Set Tax Query
             */
            if (!empty($this->_tax_query)) {
                $q->set('tax_query', $this->_tax_query);
            }
            
            /**
             * Set Meta Query
             */
            if (!empty($this->_meta_query)) {
                $q->set('meta_query', $this->_meta_query);
            }
        }
        
        /**
         * 
         * @param type $q
         * @param type $query
         */
        protected function build_tax_query($q) {
            $this->_tax_query = empty($this->_tax_query) ? $q->get('tax_query') : $this->_tax_query;
            return empty($this->_tax_query) ? array() : $this->_tax_query;
        }
        
        /**
         * 
         * @param type $q
         * @param type $query
         */
        protected function build_meta_query($q) {
            $this->_meta_query = empty($this->_meta_query) ? $q->get('meta_query') : $this->_meta_query;
            return empty($this->_meta_query) ? array() : $this->_meta_query;
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
            
            $onsale = isset($instance['filter_onsale']) ? $instance['filter_onsale'] : $this->settings['filter_onsale']['std'];
            $featured = isset($instance['filter_featured']) ? $instance['filter_featured'] : $this->settings['filter_featured']['std'];
            $instock = isset($instance['filter_instock']) ? $instance['filter_instock'] : $this->settings['filter_instock']['std'];
            $onbackorder = isset($instance['filter_onbackorder']) ? $instance['filter_onbackorder'] : $this->settings['filter_onbackorder']['std'];
            
            if (!$onsale && !$featured && !$instock && $onbackorder) {
                return;
            }
            
            extract($args);
            $link = elessi_get_origin_url();
            
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (!in_array($key, self::$_status)) {
                        $link = add_query_arg($key, esc_attr($value), $link);
                    }
                }
            }

            if ($_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes()) {
                foreach ($_chosen_attributes as $attribute => $data) {
                    $attr_name = 0 === strpos($attribute, 'pa_') ? substr($attribute, 3) : $attribute;
                    $taxonomy_filter = 'filter_' . $attr_name;
                    $link = add_query_arg(esc_attr($taxonomy_filter), esc_attr(implode(',', $data['terms'])), $link);

                    if ('or' == $data['query_type']) {
                        $link = add_query_arg(esc_attr(str_replace('pa_', 'query_type_', $attribute)), 'or', $link);
                    }
                }
            }
            
            $output = '<ul class="nasa-product-status-widget small-block-grid-1 medium-block-grid-4 large-block-grid-6">';
            
            $onsale_filtered = isset($_GET['on-sale']) && $_GET['on-sale'] === '1' ? true : false;
            $featured_filtered = isset($_GET['featured']) && $_GET['featured'] === '1' ? true : false;
            $instock_filtered = isset($_GET['in-stock']) && $_GET['in-stock'] === '1' ? true : false;
            $onbackorder_filtered = isset($_GET['on-backorder']) && $_GET['on-backorder'] === '1' ? true : false;
            
            /**
             * On sale
             */
            if ($onsale) {
                $link_onsale = $onsale_filtered ? $link : add_query_arg('on-sale', '1', $link);
                $link_onsale = $featured_filtered ? add_query_arg('featured', '1', $link_onsale) : $link_onsale;
                $link_onsale = $instock_filtered ? add_query_arg('in-stock', '1', $link_onsale) : $link_onsale;
                $link_onsale = $onbackorder_filtered ? add_query_arg('on-backorder', '1', $link_onsale) : $link_onsale;
                $class = 'nasa-filter-status nasa-filter-onsale';
                $class .= $onsale_filtered ? ' nasa-active' : '';
                
                $output .= '<li><a class="' . esc_attr($class) . '" href="' . esc_url($link_onsale) . '" title="' . esc_attr__('On Sale', 'elessi-theme') . '" data-filter="on-sale">' . esc_html__('On Sale', 'elessi-theme') . '</a></li>';
            }
            
            /**
             * Featured
             */
            if ($featured) {
                $link_featured = $onsale_filtered ? add_query_arg('on-sale', '1', $link) : $link;
                $link_featured = $featured_filtered ? $link_featured : add_query_arg('featured', '1', $link_featured);
                $link_featured = $instock_filtered ? add_query_arg('in-stock', '1', $link_featured) : $link_featured;
                $link_featured = $onbackorder_filtered ? add_query_arg('on-backorder', '1', $link_featured) : $link_featured;
                $class = 'nasa-filter-status nasa-filter-feature';
                $class .= $featured_filtered ? ' nasa-active' : '';

                $output .= '<li><a class="' . esc_attr($class) . '" href="' . esc_url($link_featured) . '" title="' . esc_attr__('Featured', 'elessi-theme') . '" data-filter="featured">' . esc_html__('Featured', 'elessi-theme') . '</a></li>';
            }
            
            /**
             * In Stock
             */
            if ($instock) {
                $link_instock = $onsale_filtered ? add_query_arg('on-sale', '1', $link) : $link;
                $link_instock = $featured_filtered ? add_query_arg('featured', '1', $link_instock) : $link_instock;
                $link_instock = $instock_filtered ? $link_instock : add_query_arg('in-stock', '1', $link_instock);
                $link_instock = $onbackorder_filtered ? add_query_arg('on-backorder', '1', $link_instock) : $link_instock;
                $class = 'nasa-filter-status nasa-filter-instock';
                $class .= $instock_filtered ? ' nasa-active' : '';
                
                $output .= '<li><a class="' . esc_attr($class) . '" href="' . esc_url($link_instock) . '" title="' . esc_attr__('In Stock', 'elessi-theme') . '" data-filter="in-stock">' . esc_html__('In Stock', 'elessi-theme') . '</a></li>';
            }
            
            /**
             * On Backorder
             */
            if ($onbackorder) {
                $link_onbackorder = $onsale_filtered ? add_query_arg('on-sale', '1', $link) : $link;
                $link_onbackorder = $featured_filtered ? add_query_arg('featured', '1', $link_onbackorder) : $link_onbackorder;
                $link_onbackorder = $instock_filtered ? add_query_arg('in-stock', '1', $link_onbackorder) : $link_onbackorder;
                $link_onbackorder = $onbackorder_filtered ? $link_onbackorder : add_query_arg('on-backorder', '1', $link_onbackorder);
                $class = 'nasa-filter-status nasa-filter-onbackorder';
                $class .= $onbackorder_filtered ? ' nasa-active' : '';
                
                $output .= '<li><a class="' . esc_attr($class) . '" href="' . esc_url($link_onbackorder) . '" title="' . esc_attr__('On Backorder', 'elessi-theme') . '" data-filter="on-backorder">' . esc_html__('On Backorder', 'elessi-theme') . '</a></li>';
            }
            
            $output .= '</ul>';

            $this->widget_start($args, $instance);
            echo $output;
            $this->widget_end($args);
        }
    }
}
