<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Initialize Class Nasa_WC_Custom_Fields_Add_To_Cart
 */
add_action('init', array('Nasa_WC_Custom_Fields_Add_To_Cart', 'getInstance'));
    
/**
 * Class Nasa_WC_Custom_Fields_Add_To_Cart
 */
class Nasa_WC_Custom_Fields_Add_To_Cart {
    /**
     * instance of the class
     */
    protected static $instance = null;

    /**
     * Instance
     */
    public static function getInstance() {
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
        
        if (isset($nasa_opt['enable_personalize']) && !$nasa_opt['enable_personalize']) {
            return null;
        }
        
        /**
         * Custom fields variation
         */
        add_filter('woocommerce_available_variation', array($this, 'custom_fields_variation'));
        
        /**
         * Template variation for single or quick-view custom fields
         */
        add_action('wp_footer', array($this, 'script_template_custom_fields'));
        
        /**
         * For single product page - Simple Product
         */
        add_action('woocommerce_before_add_to_cart_button', array($this, 'customize_fields_add_to_cart'));
        
        /**
         * Filter Personalize add to cart item data
         */
        add_filter('woocommerce_add_cart_item_data', array($this, 'add_ct_fields_to_cart_item'), 10, 3);
        
        /**
         * Display Personalize in cart item data
         */
        add_filter('woocommerce_get_item_data', array($this, 'display_ct_fields_in_cart'), 10, 2);
        
        /**
         * Add Personalize to order item data
         */
        add_action('woocommerce_checkout_create_order_line_item', array($this, 'add_ct_fields_to_order_item'), 10, 4);
    }

    /**
     * Custom fields variation
     */
    public function custom_fields_variation($variation) {
        if (is_product() || (isset($_REQUEST['wc-ajax']) && $_REQUEST['wc-ajax'] === 'nasa_quick_view')) {
            $enable = nasa_get_variation_meta_value($variation['variation_id'], 'nasa_personalize');

            if ($enable && $enable == 'yes') {
                if (!isset($variation['nasa_custom_fields'])) {
                    $variation['nasa_custom_fields'] = array();
                }
                
                $variation['nasa_custom_fields']['nasa_personalize'] = $enable;
            }
        }

        return $variation;
    }
    
    /**
     * Template variation for single or quick-view custom fields
     */
    public function script_template_custom_fields() {
        nasa_template('script_tmpl/nasa-single-product-custom-fields.php');
    }
    
    /**
     * For single product page - Simple Product
     */
    public function customize_fields_add_to_cart() {
        global $product;

        if ($product->get_type() != 'simple') {
            return;
        }

        $enable = nasa_get_product_meta_value($product->get_id(), '_personalize');

        echo $enable == 'yes' ? '<div class="hidden-tag nasa-ct-fields-add-to-cart"></div>' : '';
    }
    
    /**
     * Filter Personalize add to cart item data
     */
    public function add_ct_fields_to_cart_item($cart_item_data, $product_id, $variation_id) {
        $checked = filter_input(INPUT_POST, 'nasa-ct-fields-check');

        if (empty($checked)) {
            return $cart_item_data;
        }

        $personalized = filter_input(INPUT_POST, 'nasa-ct-personalized');

        if (trim($personalized) !== '') {
            $cart_item_data['personalized-text'] = $personalized;

            $font_type = filter_input(INPUT_POST, 'nasa-ct-font-type');
            if (!empty($font_type)) {
                $cart_item_data['font-type'] = $font_type;
            }

            $font_colour = filter_input(INPUT_POST, 'nasa-ct-font-colour');
            if (!empty($font_colour)) {
                $cart_item_data['font-colour'] = $font_colour;
            }

            $font_orientation = filter_input(INPUT_POST, 'nasa-ct-font-orientation');
            if (!empty($font_orientation)) {
                $cart_item_data['font-orientation'] = $font_orientation;
            }
        }

        return $cart_item_data;
    }
    
    /**
     * Display Personalize in cart item data
     */
    public function display_ct_fields_in_cart($item_data, $cart_item) {
        if (empty($cart_item['personalized-text'])) {
            return $item_data;
        }

        $item_data[] = array(
            'key'     => esc_html__('Personalized', 'nasa-core'),
            'value'   => wc_clean($cart_item['personalized-text']),
            'display' => '',
        );

        if (!empty($cart_item['font-type'])) {
            $item_data[] = array(
                'key'     => esc_html__('Font Type', 'nasa-core'),
                'value'   => wc_clean($cart_item['font-type']),
                'display' => '',
            );
        }

        if (!empty($cart_item['font-colour'])) {
            $item_data[] = array(
                'key'     => esc_html__('Font Colour', 'nasa-core'),
                'value'   => wc_clean($cart_item['font-colour']),
                'display' => '',
            );
        }

        if (!empty($cart_item['font-orientation'])) {
            $item_data[] = array(
                'key'     => esc_html__('Font Orientation', 'nasa-core'),
                'value'   => wc_clean($cart_item['font-orientation']),
                'display' => '',
            );
        }

        return $item_data;
    }
    
    /**
     * Add Personalize to order item data
     */
    public function add_ct_fields_to_order_item($item, $cart_item_key, $values, $order) {
        if (empty($values['personalized-text'])) {
            return;
        }

        $item->add_meta_data(esc_html__('Personalized', 'nasa-core'), $values['personalized-text']);

        if (!empty($values['font-type'])) {
            $item->add_meta_data(esc_html__('Font Type', 'nasa-core'), $values['font-type']);
        }

        if (!empty($values['font-colour'])) {
            $item->add_meta_data(esc_html__('Font Colour', 'nasa-core'), $values['font-colour']);
        }

        if (!empty($values['font-orientation'])) {
            $item->add_meta_data(esc_html__('Font Orientation', 'nasa-core'), $values['font-orientation']);
        }
    }
}
