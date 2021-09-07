<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Initialize Class Nasa_WC_Custom_Fields_Add_To_Cart
 */
add_action('init', array('Nasa_WC_Bulk_Discount', 'getInstance'));
    
/**
 * Class Nasa_WC_Bulk_Discount
 */
class Nasa_WC_Bulk_Discount {
    /**
     * instance of the class
     */
    protected static $instance = null;
    
    public $items_dsct = array();
    public $items_dsct_rules = array();

    /**
     * Instance
     */
    public static function getInstance() {
        if (!NASA_WOO_ACTIVED) {
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
        
        global $nasa_opt;
        
        if (isset($nasa_opt['bulk_dsct']) && !$nasa_opt['bulk_dsct']) {
            return null;
        }
        
        /**
         * Custom fields variation
         */
        add_filter('woocommerce_available_variation', array($this, 'custom_fields_variation'));
        
        /**
         * Single Product - Simple | Variation
         */
        add_action('woocommerce_single_product_summary', array($this, 'single_product_bulk_discount'), 28);
        add_action('woocommerce_single_product_lightbox_summary', array($this, 'single_product_bulk_discount'), 28);
        
        /**
         * Change Price in Cart - Checkout
         */
        add_action('woocommerce_before_calculate_totals', array($this, 'cart_before_calculate'), 1);
        // add_action('woocommerce_before_mini_cart_contents', array($this, 'cart_before_calculate'));
        // add_action('woocommerce_before_cart_contents', array($this, 'cart_before_calculate'));
        // add_action('woocommerce_review_order_before_cart_contents', array($this, 'cart_before_calculate'));
    }
    
    /**
     * Check allow
     * 
     * @param type $product
     * @return type
     */
    protected function _check_allow($product) {
        $product_type = $product->get_type();
        
        if (!in_array($product_type, array('simple', 'variation'))) {
            return false;
        }
        
        $product_id = $product->get_id();
        
        /**
         * Simple Product
         */
        if ($product_type == 'simple') {
            $enable = nasa_get_product_meta_value($product_id, "_bulk_dsct", true);
            
            return $enable ? true : false;
        }
        
        /**
         * Variation Product
         */
        if ($product_type == 'variation') {
            $enable = nasa_get_variation_meta_value($product_id, "bulk_dsct_allow", true);
            
            return $enable ? true : false;
        }
        
        return false;
    }
    
    /**
     * 
     * @param type $product
     * @return type
     */
    public function get_discount_type($product) {
        $product_id = $product->get_id();
        
        $discount_type = $product->get_type() == 'variation' ?
            nasa_get_variation_meta_value($product_id, "bulk_dsct_type", true) :
            nasa_get_product_meta_value($product_id, "_bulk_dsct_type", true);
        
        return in_array($discount_type, array('flat', 'per')) ? $discount_type : 'flat'; 
    }

    /**
     * Single Product Bulk Discount
     * 
     * @param type $product
     * @return void
     */
    public function single_product_bulk_discount() {
        global $product;
        
        /**
         * Return if not product
         */
        if (!$product) {
            return;
        }
        
        /**
         * Variable Product
         */
        if ($product->get_type() == 'variable') {
            echo '<div class="nasa-variation-bulk-dsct hidden-tag"></div>';
            
            return;
        }
        
        /**
         * Simple - Variation Product
         */
        if (!$this->_check_allow($product)) {
            return;
        }
        
        $product_id = $product->get_id();
        $bulk_discount = get_post_meta($product_id, '_bulk_dsct_rules', true);
        
        /**
         * Empty Rules
         */
        if (empty($bulk_discount)) {
            return;
        }
        
        /**
         * Args use in Template
         */
        $nasa_args = array(
            'product' => $product,
            'bulk_discount' => $bulk_discount,
            'discount_type' => $this->get_discount_type($product)
        );
        
        /**
         * Template view
         */
        nasa_template('products/nasa_single_product/nasa-single-product-bulk-discount.php', $nasa_args);
    }
    
    /**
     * get Price cart item
     */
    protected function _get_price_cart_item($product) {
        $price_org = floatval($product->get_price());
        
        /**
         * Compatible - Multi Currency for WooCommerce
         */
        if (function_exists('wmc_revert_price')) {
            $price_org = wmc_revert_price($price_org);
        }
        
        return $price_org;
    }

    /**
     * Custom Price for Cart - Checkout - Order
     */
    public function cart_before_calculate() {
        if (NASA_CORE_IN_ADMIN && !defined('DOING_AJAX')) {
            return;
        }
                
        if (did_action('woocommerce_before_calculate_totals') >= 2) {
            return;
        }
        
        $cart = WC()->cart;
        
        if (!$cart->is_empty()) {
            
            $variations = array();
            
            $cart_items = $cart->get_cart_contents();
            foreach ($cart_items as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                
                /**
                 * Type not support || not Allow
                 */
                if (!$_product || !$this->_check_allow($_product)) {
                    continue;
                }
                
                if ($_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    /**
                     * Variation Product
                     */
                    if ($_product->get_type() == 'variation') {
                        $variation_id = $_product->get_id();
                        
                        if (!isset($variations[$variation_id])) {
                            $variations[$variation_id] = array(
                                'product' => $_product,
                                'qty' => $cart_item['quantity'],
                                'cart_items' => array($cart_item_key => $cart_item)
                            );
                        } else {
                            $variations[$variation_id]['qty'] += $cart_item['quantity'];
                            $variations[$variation_id]['cart_items'][$cart_item_key] = $cart_item;
                        }
                    }
                    
                    /**
                     * Simple Product
                     */
                    else {
                        $bulk_discount = get_post_meta($product_id, '_bulk_dsct_rules', true);

                        $rules = isset($bulk_discount['rules']) ? $bulk_discount['rules'] : array();
                        $max = isset($bulk_discount['max']) ? $bulk_discount['max'] : false;

                        if (!$max || empty($rules)) {
                            continue;
                        }

                        $type = $this->get_discount_type($_product);

                        $count = count($rules);
                        for ($i = $count - 1; $i >= 0; $i--) {
                            if ($rules[$i]['dsct'] && $cart_item['quantity'] >= $rules[$i]['qty']) {
                                $price_org = $this->_get_price_cart_item($_product);
                                
                                $dsct = floatval($rules[$i]['dsct']);

                                if ($type == 'flat') {
                                    $price_new = $price_org - $dsct;
                                } else {
                                    $price_new = $price_org - (($price_org * $dsct) / 100);
                                }
                                
                                $_product->set_price(floatval($price_new));

                                $i = -1; // Break for
                            }
                        }
                    }
                }
            }
            
            /**
             * Reset price variation product
             */
            $this->_filter_variation_products($variations);
        }
    }
    
    /**
     * Reset price variation product
     * 
     * @param type $variations
     */
    protected function _filter_variation_products($variations) {
        if (!empty($variations)) {
            foreach ($variations as $variation_id => $variation) {
                $_product = $variation['product'];
                $quatity = $variation['qty'];
                
                $bulk_discount = get_post_meta($variation_id, '_bulk_dsct_rules', true);

                $rules = isset($bulk_discount['rules']) ? $bulk_discount['rules'] : array();
                $max = isset($bulk_discount['max']) ? $bulk_discount['max'] : false;

                if (!$max || empty($rules)) {
                    continue;
                }

                $type = $this->get_discount_type($_product);

                $count = count($rules);
                for ($i = $count - 1; $i >= 0; $i--) {
                    if ($rules[$i]['dsct'] && $quatity >= $rules[$i]['qty']) {
                        $price_org = $this->_get_price_cart_item($_product);
                        
                        $dsct = floatval($rules[$i]['dsct']);

                        if ($type == 'flat') {
                            $price_new = $price_org - $dsct;
                        } else {
                            $price_new = $price_org - ($price_org * $dsct / 100);
                        }

                        foreach ($variation['cart_items'] as $cart_item_key => $cart_item) {
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $_product->set_price($price_new);
                        }

                        $i = -1; // Break for
                    }
                }
            }
        }
    }

    /**
     * Custom fields variation
     */
    public function custom_fields_variation($variation) {
        if (is_product() || (isset($_REQUEST['wc-ajax']) && $_REQUEST['wc-ajax'] === 'nasa_quick_view')) {
            $variation_meta = nasa_get_variation_meta_value($variation['variation_id']);
            
            $enable = isset($variation_meta['bulk_dsct_allow']) && $variation_meta['bulk_dsct_allow'] ? true : false;

            if ($enable) {
                if (!isset($variation['nasa_custom_fields'])) {
                    $variation['nasa_custom_fields'] = array();
                }

                $variation['nasa_custom_fields']['dsct_allow'] = '1';
            }
        }

        return $variation;
    }
}
