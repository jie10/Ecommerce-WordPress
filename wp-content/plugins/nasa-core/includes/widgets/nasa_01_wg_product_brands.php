<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Class Widget Product Brands
 */
if (NASA_WOO_ACTIVED) {
	
    /**
     * Register widget
     */
    add_action('widgets_init', 'nasa_product_brands_widget');
    function nasa_product_brands_widget() {
        global $nasa_opt;
        
        if (isset($nasa_opt['enable_nasa_brands']) && $nasa_opt['enable_nasa_brands']) {
            register_widget('Nasa_Product_Brands_Widget');
        }
    }
    
    class Nasa_Product_Brands_Widget extends WC_Widget {
        /**
         * taxonomy
         *
         * @var type 
         */
        public $nasa_tax = 'product_brand';

        /**
         * brand ancestors
         *
         * @var array
         */
        public $brand_ancestors;

        /**
         * Current brand
         *
         * @var bool
         */
        public $current_brand;

        /**
         * Constructor
         */
        public function __construct() {
            $this->nasa_tax = apply_filters('nasa_taxonomy_brand', Nasa_WC_Brand::$nasa_taxonomy);
            $this->widget_cssclass = 'woocommerce widget_product_brands';
            $this->widget_description = esc_html__('Display product brands with Accordion.', 'nasa-core');
            $this->widget_id = 'nasa_product_brands';
            $this->widget_name = esc_html__('Nasa Product Brands', 'nasa-core');
            $this->settings = array(
                'title' => array(
                    'type' => 'text',
                    'std' => esc_html__('Product Brands', 'nasa-core'),
                    'label' => esc_html__('Title', 'nasa-core')
                ),
                'orderby' => array(
                    'type' => 'select',
                    'std' => 'name',
                    'label' => esc_html__('Order by', 'nasa-core'),
                    'options' => array(
                        'order' => esc_html__('Brand Order', 'nasa-core'),
                        'name' => esc_html__('Name', 'nasa-core')
                    )
                ),
                'count' => array(
                    'type' => 'checkbox',
                    'std' => 0,
                    'label' => esc_html__('Show product counts', 'nasa-core')
                ),
                'hierarchical' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('Show hierarchy', 'nasa-core')
                ),
                'show_children_only' => array(
                    'type' => 'checkbox',
                    'std' => 0,
                    'label' => esc_html__('Only show children of the current brand', 'nasa-core')
                ),
                'hide_empty' => array(
                    'type'  => 'checkbox',
                    'std'   => 0,
                    'label' => esc_html__('Hide empty brands', 'nasa-core'),
                ),
                'accordion' => array(
                    'type' => 'checkbox',
                    'std' => 1,
                    'label' => esc_html__('Show as Accordion', 'nasa-core')
                ),
                'show_items' => array(
                    'type' => 'text',
                    'std' => 'All',
                    'label' => esc_html__('Show default numbers items', 'nasa-core')
                )
            );

            parent::__construct();
        }

        /**
         * form function.
         *
         * @see WP_Widget->form
         * @param array $instance
         */
        public function form($instance) {
            if (empty($this->settings)) {
                return;
            }

            foreach ($this->settings as $key => $setting) {
                $value = isset($instance[$key]) ? $instance[$key] : (isset($setting['std']) ? $setting['std'] : '');
                $_id = $this->get_field_id($key);
                $_name = $this->get_field_name($key);

                switch ($setting['type']) {

                    case 'text' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo ($setting['label']); ?></label>
                            <input class="widefat" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="text" value="<?php echo esc_attr($value); ?>" />
                        </p>
                        <?php
                        break;

                    case 'number' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo ($setting['label']); ?></label>
                            <input class="widefat" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="number" step="<?php echo esc_attr($setting['step']); ?>" min="<?php echo esc_attr($setting['min']); ?>" max="<?php echo esc_attr($setting['max']); ?>" value="<?php echo esc_attr($value); ?>" />
                        </p>
                        <?php
                        break;

                    case 'select' :
                        ?>
                        <p>
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo ($setting['label']); ?></label>
                            <select class="widefat" id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>">
                                <?php foreach ($setting['options'] as $o_key => $o_value): ?>
                                    <option value="<?php echo esc_attr($o_key); ?>" <?php selected($o_key, $value); ?>><?php echo esc_html($o_value); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <?php
                        break;

                    case 'checkbox' :
                        ?>
                        <p>
                            <input id="<?php echo esc_attr($_id); ?>" name="<?php echo esc_attr($_name); ?>" type="checkbox" value="1" <?php checked($value, 1); ?> />
                            <label for="<?php echo esc_attr($_id); ?>"><?php echo $setting['label']; ?></label>
                        </p>
                        <?php
                        break;
                }
            }
        }

        /**
         * widget function.
         *
         * @see WP_Widget
         *
         * @param array $args
         * @param array $instance
         *
         * @return void
         */
        public function widget($args, $instance) {
            global $wp_query, $post;

            $a = isset($instance['accordion']) ? $instance['accordion'] : $this->settings['accordion']['std'];
            $c = isset($instance['count']) ? $instance['count'] : $this->settings['count']['std'];
            $h = isset($instance['hierarchical']) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];

            $o = isset($instance['orderby']) ? $instance['orderby'] : $this->settings['orderby']['std'];
            $hide_empty = isset($instance['hide_empty']) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
            $show_items = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;

            $only_show_child = isset($instance['show_children_only']) && $instance['show_children_only'] == '1' ? true : false;

            /**
             * Show all items
             */
            $list_args = array(
                'show_count' => $c,
                'hierarchical' => $h,
                'taxonomy' => $this->nasa_tax,
                'hide_empty' => $hide_empty
            );

            // Menu Order
            $list_args['menu_order'] = false;
            if ($o == 'order') {
                $list_args['menu_order'] = 'asc';
            } else {
                $list_args['orderby'] = 'title';
            }

            // Setup Current Brand
            $this->current_brand = false;
            $this->brand_ancestors = array();
            $rootId = 0;

            if (is_tax($this->nasa_tax)) {
                $this->current_brand = $wp_query->queried_object;
                $this->brand_ancestors = get_ancestors($this->current_brand->term_id, $this->nasa_tax);
            }

            elseif (is_singular('product')) {
                $productId = isset($wp_query->queried_object->ID) ? $wp_query->queried_object->ID : $post->ID;

                $terms = wc_get_product_terms($productId, $this->nasa_tax, array(
                    'orderby' => 'parent',
                    'order'   => 'DESC'
                ));

                if ($terms) {
                    $main_term = apply_filters('woocommerce_product_brands_widget_main_term', $terms[0], $terms);
                    $this->current_brand = $main_term;
                    $this->brand_ancestors = get_ancestors($main_term->term_id, $this->nasa_tax);
                }
            }

            /**
             * Only Show Children
             */
            if ($only_show_child) {
                if ($this->current_brand && $this->current_brand->term_id) {
                    $terms_chilren = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                        'taxonomy' => $this->nasa_tax,
                        'parent' => $this->current_brand->term_id,
                        'hierarchical' => $h,
                        'hide_empty' => $hide_empty
                    )));

                    if (!$terms_chilren) {
                        $term_root = get_ancestors($this->current_brand->term_id, $this->nasa_tax);
                        $rootId = isset($term_root[0]) ? $term_root[0] : $rootId;
                    } else {
                        $rootId = $this->current_brand->term_id;
                    }
                }
            }

            $this->widget_start($args, $instance);
            $menu_brand = new Nasa_Product_Brands_List_Walker();
            $menu_brand->setIcons($instance);
            $menu_brand->setShowDefault($show_items);
            $list_args['walker'] = $menu_brand;
            $list_args['title_li'] = '';
            $list_args['pad_counts'] = 1;
            $list_args['show_option_none'] = esc_html__('No product brands exist.', 'nasa-core');
            $list_args['current_brand'] = $this->current_brand ? $this->current_brand->term_id : '';
            $list_args['current_brand_ancestors'] = $this->brand_ancestors;
            $list_args['child_of'] = $rootId;

            $accordion = $a ? ' nasa-accordion' : '';

            echo '<ul class="nasa-product-categories-widget nasa-product-brands-widget nasa-product-taxs-widget nasa-root-tax nasa-root-cat' . $accordion . '">';
            wp_list_categories(apply_filters('woocommerce_product_brands_widget_args', $list_args));

            if ($show_items && ($menu_brand->getTotalRoot() > $show_items)) {
                echo '<li class="nasa_show_manual"><a data-show="1" class="nasa-show" href="javascript:void(0);" data-text="' . esc_attr__('- Show less', 'nasa-core') . '" rel="nofollow">' . esc_html__('+ Show more', 'nasa-core') . '</a></li>';
            }

            echo '<li class="nasa-current-note"></li>';

            echo '</ul>';

            $this->widget_end($args);
        }
    }

    if (!class_exists('WC_Product_Cat_List_Walker')) {
        require_once WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php';
    }

    /**
     * Nasa_Product_Brands_List_Walker
     * 
     * Extends from WC_Product_Cat_List_Walker
     */
    class Nasa_Product_Brands_List_Walker extends WC_Product_Cat_List_Walker {

        protected $_icons = array();
        protected $_k = 0;
        protected $_show_default = 0;
        protected $_max_depth = 0;
        protected $nasa_taxonomy;

        public function __construct($max_depth = 0, $multi = false) {
            $this->_max_depth = (int) $max_depth;
            $this->tree_type = apply_filters('nasa_taxonomy_brand', Nasa_WC_Brand::$nasa_taxonomy);
        }

        public function setIcons($instance) {
            $this->_icons = $instance;
        }

        public function setShowDefault($show) {
            $this->_show_default = (int) $show;
        }

        public function getTotalRoot() {
            return $this->_k;
        }

        /**
         * @see Walker::start_el()
         * @since 2.1.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of category in reference to parents.
         * @param integer $current_object_id
         */
        public function start_el(&$output, $brand, $depth = 0, $args = array(), $current_object_id = 0) {
            $output .= '<li class="nasa-tax-item brand-item brand-item-' . $brand->term_id . ' brand-item-' . $brand->slug;
            $nasa_active = $accordion = $icon = '';
            if ($depth == 0) {
                $output .= ' root-item';
                if ($this->_show_default && ($this->_k >= $this->_show_default)) {
                    $output .= ' nasa-show-less';
                }
                $this->_k++;
            }

            if ($args['current_brand'] == $brand->term_id) {
                $output .= ' current-brand current-tax-item active';
                $nasa_active = ' nasa-active';
            }

            if ($args['has_children'] && $args['hierarchical'] && (!$this->_max_depth || $depth+ 1 < $this->_max_depth)) {
                $output .= ' brand-parent nasa-tax-parent li_accordion';
                $accordion = '<a href="javascript:void(0);" class="accordion" rel="nofollow"></a>';
            }

            if ($args['current_brand_ancestors'] && $args['current_brand'] && in_array($brand->term_id, $args['current_brand_ancestors'])) {
                $output .= ' nasa-current-tax-parent current-brand-parent active';
            }

            $output .= '">' . $accordion;

            $output .= '<a ' .
                'href="' . get_term_link($brand, $this->tree_type) . '" ' .
                'title="' . esc_attr($brand->name) . '" ' .
                'data-id="' . esc_attr((int) $brand->term_id) . '" ' .
                'data-taxonomy="' . $this->tree_type . '" ' .
                'class="nasa-filter-item nasa-filter-by-tax nasa-filter-product-brand' . $nasa_active . '">' .
                    $icon . $brand->name;

            $output .= $args['show_count'] ? ' <span class="count">' . $brand->count . '</span>' : '';

            $output .= '</a>';
        }
    }
}
