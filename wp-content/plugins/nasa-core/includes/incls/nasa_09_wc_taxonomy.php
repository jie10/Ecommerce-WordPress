<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Instantiate Class Nasa_WC_Taxonomy
 */
add_action('init', array('Nasa_WC_Taxonomy', 'getInstance'));
    
/**
 * Class Nasa Woocommerce Custom Categories - Groups product
 */
class Nasa_WC_Taxonomy {

    /**
     * instance of the class
     */
    protected static $instance = null;

    /**
     * Taxonomy slug
     */
    public static $nasa_taxonomy = 'nasa_product_cat';

    /**
     * Rewrite for Nasa categories
     *
     * @var string
     */
    public static $nasa_rewrite = false;

    /**
     * Instance
     */
    public static function getInstance() {
        global $nasa_opt;

        if (!isset($nasa_opt['enable_nasa_custom_categories']) || !$nasa_opt['enable_nasa_custom_categories']) {
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
        add_action('woocommerce_product_meta_end', array($this, 'single_product_custom_categories'));
    }

    /**
     * Register taxonomy for nasa product cat
     *
     * @return void
     */
    public function register_taxonomy() {
        self::$nasa_taxonomy = apply_filters('nasa_taxonomy_custom_cateogory', self::$nasa_taxonomy);

        $labels = array(
            'name' => _x('Groups', 'taxonomy general name', 'nasa-core'),
            'singular_name' => _x('Group', 'taxonomy singular name', 'nasa-core'),
            'search_items' => esc_html__('Search Groups', 'nasa-core'),
            'all_items' => esc_html__('All Groups', 'nasa-core'),
            'parent_item' => esc_html__('Parent Group', 'nasa-core'),
            'parent_item_colon' => esc_html__('Parent Group:', 'nasa-core'),
            'edit_item' => esc_html__('Edit', 'nasa-core'),
            'update_item' => esc_html__('Update', 'nasa-core'),
            'add_new_item' => esc_html__('Add New', 'nasa-core'),
            'new_item_name' => esc_html__('New Group', 'nasa-core'),
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
            'update_count_callback' => '_wc_term_recount',
            'rewrite' => self::$nasa_rewrite
        ));
    }
    
    /**
     * Show in Single product page
     */
    public function single_product_custom_categories() {
        global $product;
        
        if (!$product) {
            return;
        }
        
        $taxLabel = esc_html__('Groups: ', 'nasa-core');
        
        $before = apply_filters('nasa_before_custom_categories', '<span class="posted_in">' . $taxLabel);
        $sep = apply_filters('nasa_sep_custom_categories', ', ');
        $after = apply_filters('nasa_after_custom_categories', '</span>');
        
        $terms = get_the_term_list($product->get_id(), self::$nasa_taxonomy, $before, $sep, $after);
        
        echo $terms ? $terms : '';
    }

}
