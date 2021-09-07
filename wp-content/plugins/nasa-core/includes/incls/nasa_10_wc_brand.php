<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Instantiate Class
 */
add_action('init', array('Nasa_WC_Brand', 'getInstance'));

/**
 * Class Nasa Woocommerce Brand
 */
class Nasa_WC_Brand {

    /**
     * instance of the class
     */
    protected static $instance = null;

    /**
     * Taxonomy slug
     */
    public static $nasa_taxonomy = 'product_brand';
    
    /**
     * Rewrite URI
     * 
     * @var type 
     */
    public static $nasa_rewrite = 'product-brand';

    /**
     * Instance
     */
    public static function getInstance() {
        global $nasa_opt;

        if (!isset($nasa_opt['enable_nasa_brands']) || !$nasa_opt['enable_nasa_brands']) {
            return null;
        }

        if (null == self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    public function __construct() {
        if (!NASA_WOO_ACTIVED) {
            return null;
        }
        
        /**
         * Register custom taxonomy Nasa Product Categories
         */
        $this->register_taxonomy();
        
        /**
         * Show in Single Product
         */
        add_action('woocommerce_single_product_summary', array($this, 'single_product_brands_logo'), 22);
        
        /**
         * Show in Quick view
         */
        add_action('woocommerce_single_product_lightbox_summary', array($this, 'single_product_brands_logo'), 17);
        
        /**
         * Add Shortcode [nasa_product_brands ...]
         */
        add_shortcode('nasa_product_brands', array($this, 'product_brands_sc'));
    }

    /**
     * Register taxonomy for nasa product cat
     *
     * @return void
     */
    public function register_taxonomy() {
        self::$nasa_taxonomy = apply_filters('nasa_taxonomy_brand', self::$nasa_taxonomy);
        self::$nasa_rewrite = get_option('nasa_product_brand_permalink', 'product-brand');

        $labels = array(
            'name' => _x('Brands', 'taxonomy general name', 'nasa-core'),
            'singular_name' => _x('Brand', 'taxonomy singular name', 'nasa-core'),
            'search_items' => esc_html__('Search Brands', 'nasa-core'),
            'all_items' => esc_html__('All Brands', 'nasa-core'),
            'parent_item' => esc_html__('Parent Brand', 'nasa-core'),
            'parent_item_colon' => esc_html__('Parent Brand:', 'nasa-core'),
            'edit_item' => esc_html__('Edit', 'nasa-core'),
            'update_item' => esc_html__('Update', 'nasa-core'),
            'add_new_item' => esc_html__('Add New', 'nasa-core'),
            'new_item_name' => esc_html__('New Brand', 'nasa-core'),
        );

        register_taxonomy(self::$nasa_taxonomy, array('product'), array(
            'public' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'capabilities' => apply_filters('nasa_taxonomy_capabilities',
                array(
                    'manage_terms' => 'manage_product_terms',
                    'edit_terms'   => 'edit_product_terms',
                    'delete_terms' => 'delete_product_terms',
                    'assign_terms' => 'assign_product_terms',
                )
            ),
            'rewrite' => array(
                'slug'         => self::$nasa_rewrite,
                'with_front'   => apply_filters('nasa_brand_with_front', false),
                'hierarchical' => true,
            ),
            'update_count_callback' => '_wc_term_recount'
        ));
    }
    
    /**
     * Show in Single product page
     */
    public function single_product_brands_logo() {
        global $product;
        
        if (!$product) {
            return;
        }
        
        $terms = get_the_terms($product->get_id(), self::$nasa_taxonomy);
        
        if (empty($terms)) {
            return;
        }
        
        $count = count($terms);
        
        $brand_label = $count > 1 ? esc_html__('Brands:&nbsp;&nbsp;', 'nasa-core') : esc_html__('Brand:&nbsp;&nbsp;', 'nasa-core');
        
        echo '<div itemprop="brand" class="nasa-single-product-brands">';
        
        echo '<span class="nasa-single-brand-label">' . $brand_label . '</span>';
        
        foreach ($terms as $k => $term) {
            $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
            $image = $thumb_id ? wp_get_attachment_image($thumb_id, 'full') : '';
            $image_full = $image ? '<div class="nasa-p-brand-img nasa-transition">' . $image . '</div>' : '';
            
            echo '<a class="nasa-single-brand-item primary-color" title="' . esc_attr($term->name) . '" href="' . esc_url(get_term_link($term, self::$nasa_taxonomy)) . '">' . $image_full . $term->name . '</a>';
            
            if ($k < $count-1) {
                echo '<span class="nasa-brand-sep"></span>';
            }
        }
        
        echo '</div>';
    }

    /**
     * Show in Single product page
     */
    public function single_product_brands_meta() {
        global $product;
        
        if (!$product) {
            return;
        }
        
        $taxLabel = esc_html__('Brand: ', 'nasa-core');
        
        $before = apply_filters('nasa_before_custom_categories', '<span itemprop="brand" class="posted_in">' . $taxLabel);
        $sep = apply_filters('nasa_sep_custom_categories', ', ');
        $after = apply_filters('nasa_after_custom_categories', '</span>');
        
        $terms = get_the_term_list($product->get_id(), self::$nasa_taxonomy, $before, $sep, $after);
        
        echo $terms ? $terms : '';
    }
    
    /**
     * Shortcode Product Brands
     */
    public function product_brands_sc($atts = array(), $content = null) {
        $dfAttr = array(
            'columns_number' => '6',
            'columns_number_small' => '2',
            'columns_number_tablet' => '4',
            'layout' => 'carousel',
            'auto_slide' => 'false',
            'hide_empty' => 0,
            'el_class' => ''
        );
        extract(shortcode_atts($dfAttr, $atts));
        
        $brands = get_terms(
            array(
                'taxonomy'   => self::$nasa_taxonomy,
                'hide_empty' => (bool) $hide_empty,
                'menu_order' => 'asc'
            )
        );
        
        if (empty($brands)) {
            return '';
        }
        
        $placeholder_image = get_option('woocommerce_placeholder_image', 0);
        $images = array();
        $links = array();
        $show_titles = array();
        $layout = !in_array($layout, array('carousel', 'grid')) ? 'carousel' : $layout;
        foreach ($brands as $term) {
            $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
            $images[] = $thumb_id ? $thumb_id : $placeholder_image;
            $links[] = get_term_link($term);
            $names[] = $term->name;
            $show_titles[] = $thumb_id ? false : true;
        }
        
        ob_start();
        
        $nasa_args = array(
            'images' => $images,
            'layout' => $layout,
            'auto_slide' => $auto_slide,
            'columns_number' => $columns_number,
            'columns_number_small' => $columns_number_small,
            'columns_number_tablet' => $columns_number_tablet,
            'custom_links' => $links,
            'custom_names' => $names,
            'show_titles' => $show_titles
        );
        
        nasa_template('brands/' . $layout . '.php', $nasa_args);
        
        $content = ob_get_clean();
        
        return $content;
    }
}
