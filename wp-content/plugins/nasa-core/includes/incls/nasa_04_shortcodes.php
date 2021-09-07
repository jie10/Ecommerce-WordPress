<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Init Shortcodes
 */
add_action('init', 'nasa_init_shortcodes');
function nasa_init_shortcodes() {
    /**
     * Shortcode [nasa_products]
     */
    add_shortcode('nasa_products', 'nasa_sc_products');
    
    /**
     * Shortcode [nasa_products_masonry]
     */
    add_shortcode('nasa_products_masonry', 'nasa_sc_products_masonry');
    
    /**
     * Shortcode [nasa_products_viewed]
     */
    add_shortcode('nasa_products_viewed', 'nasa_sc_products_viewed');
    
    /**
     * Shortcode [nasa_products_main]
     */
    add_shortcode('nasa_products_main', 'nasa_sc_products_main');
    
    /**
     * Shortcode [nasa_products_deal]
     */
    add_shortcode('nasa_product_deal', 'nasa_sc_product_deal');
    
    /**
     * Shortcode [nasa_products_special_deal]
     */
    add_shortcode('nasa_products_special_deal', 'nasa_sc_products_special_deal');
    
    /**
     * Shortcode [nasa_tag_cloud]
     */
    add_shortcode("nasa_tag_cloud", "nasa_sc_tag_cloud");
    
    /**
     * Shortcode [nasa_product_categories]
     */
    add_shortcode("nasa_product_categories", "nasa_sc_product_categories");
    
    /**
     * Shortcode [nasa_product_nasa_categories]
     */
    add_shortcode('nasa_product_nasa_categories', 'nasa_sc_product_nasa_categories');
    
    /**
     * Shortcode [nasa_pin_products_banner]
     */
    add_shortcode("nasa_pin_products_banner", "nasa_sc_pin_products_banner");
    
    /**
     * Shortcode [nasa_pin_material_banner]
     */
    add_shortcode("nasa_pin_material_banner", "nasa_sc_pin_material_banner");
    
    /**
     * Shortcode [nasa_products_byids]
     */
    add_shortcode('nasa_products_byids', 'nasa_sc_products_byids');
    
    /**
     * Shortcode [nasa_slider][/nasa_slider]
     */
    add_shortcode("nasa_slider", "nasa_sc_carousel");
    
    /**
     * Shortcode [nasa_banner][/nasa_banner]
     */
    add_shortcode('nasa_banner', 'nasa_sc_banners');
    
    /**
     * Shortcode [nasa_banner_2][/nasa_banner_2]
     */
    add_shortcode('nasa_banner_2', 'nasa_sc_banners_2');
    
    /**
     * Shortcode [nasa_mega_menu]
     */
    add_shortcode('nasa_mega_menu', 'nasa_sc_mega_menu');
    
    /**
     * Shortcode [nasa_menu]
     */
    add_shortcode('nasa_menu', 'nasa_sc_menu');
    
    /**
     * Shortcode [nasa_menu_vertical]
     */
    add_shortcode('nasa_menu_vertical', 'nasa_sc_menu_vertical');
    
    /**
     * Shortcode [nasa_menu_vertical]
     */
    add_shortcode('nasa_compare_imgs', 'nasa_sc_compare_imgs');
    
    /**
     * Shortcode [nasa_post]
     */
    add_shortcode("nasa_post", "nasa_sc_posts");
    
    /**
     * Shortcode [nasa_search_posts]
     */
    add_shortcode("nasa_search_posts", "nasa_sc_search_post");
    
    /**
     * Shortcode [nasa_search_posts]
     */
    add_shortcode('nasa_button', 'nasa_sc_buttons');
    
    /**
     * Shortcode [nasa_brands]
     */
    add_shortcode('nasa_brands', 'nasa_sc_brands');
    
    /**
     * Shortcode [nasa_share]
     */
    add_shortcode('nasa_share', 'nasa_sc_share');
    
    /**
     * Shortcode [nasa_follow]
     */
    add_shortcode("nasa_follow", "nasa_sc_follow");
    
    /**
     * Shortcode [nasa_get_static_block]
     */
    add_shortcode('nasa_get_static_block', 'nasa_get_static_block');
    
    /**
     * Shortcode [nasa_team_member]
     */
    add_shortcode('nasa_team_member', 'nasa_sc_team_member');
    
    /**
     * Shortcode [nasa_title]
     */
    add_shortcode('nasa_title', 'nasa_title');
    
    add_shortcode("nasa_service_box", "nasa_sc_service_box");
    add_shortcode('nasa_client', 'nasa_sc_client');
    add_shortcode('nasa_contact_us', "nasa_sc_contact_us");
    add_shortcode('nasa_opening_time', 'nasa_opening_time');
    add_shortcode('nasa_image', 'nasa_sc_image');
    add_shortcode('nasa_boot_rate', 'nasa_sc_boot_rate');
    
    add_shortcode('nasa_countdown', 'nasa_countdown_time');
    add_shortcode('nasa_separator_link', 'nasa_sc_separator_link');
    
    /**
     * Shortcode [nasa_instagram_feed]
     */
    add_shortcode('nasa_instagram_feed', 'nasa_sc_instagram_feed');
    
    /**
     * Shortcode [nasa_rev_slider]
     */
    add_shortcode('nasa_rev_slider', 'nasa_sc_rev_slider');
    
    /**
     * Register Shortcode in Backend
     */
    $bakeryActive = class_exists('WPBakeryVisualComposerAbstract') ? true : false;
    $shorcodeBackend = $bakeryActive && (NASA_CORE_IN_ADMIN || (isset($_REQUEST['action']) && $_REQUEST['action'] === 'vc_load_shortcode')) ? true : false;
    
    /**
     * Active WPBakery Page builder
     */
    if ($shorcodeBackend) {
        add_action('init', 'nasa_register_product', 999);
        add_action('init', 'nasa_register_products_masonry', 999);
        add_action('init', 'nasa_register_products_viewed', 999);
        add_action('init', 'nasa_register_products_main', 999);
        add_action('init', 'nasa_register_product_special_deals', 999);
        add_action('init', 'nasa_register_product_deal', 999);
        add_action('init', 'nasa_register_tagcloud', 999);
        add_action('init', 'nasa_register_product_categories', 999);
        add_action('init', 'nasa_register_product_nasa_categories', 999);
        add_action('init', 'nasa_register_products_banner', 999);
        add_action('init', 'nasa_register_material_banner', 999);
        add_action('init', 'nasa_register_products_byids', 999);
        add_action('init', 'nasa_register_slider', 999);
        add_action('init', 'nasa_register_banner', 999);
        add_action('init', 'nasa_register_banner_2', 999);
        add_action('init', 'nasa_register_mega_menu_shortcode', 999);
        add_action('init', 'nasa_register_menu_shortcode', 999);
        add_action('init', 'nasa_register_menuVertical', 999);
        add_action('init', 'nasa_register_compare_imgs', 999);
        add_action('init', 'nasa_register_latest_post', 999);
        add_action('init', 'nasa_register_search_posts', 999);
        add_action('init', 'nasa_register_brands', 999);
        add_action('init', 'nasa_register_share_follow', 999);
        add_action('init', 'nasa_register_static_block', 999);
        add_action('init', 'nasa_register_team_member', 999);
        add_action('init', 'nasa_register_title', 999);
        add_action('init', 'nasa_register_others', 999);
        add_action('init', 'nasa_register_instagram_feed', 999);
        add_action('init', 'nasa_register_rev_slider', 999);
    }
}

/**
 * Get Array product categories
 */
function nasa_get_cat_product_array($root = false) {
    $args = array(
        'taxonomy' => 'product_cat',
        'orderby' => 'name',
        'hide_empty' => false
    );

    if ($root) {
        $args['parent'] = 0;
    }

    $categories = get_categories($args);

    $list = array(
        esc_html__('Select category', 'nasa-core') => ''
    );

    if (!empty($categories)) {
        foreach ($categories as $v) {
            $list[$v->name . ' ( ' . $v->slug . ' )'] = $v->slug;
        }
    }

    return $list;
}

/**
 * Custom Action for short code
 */
add_action('init', 'nasa_add_custom_woo_actions');
function nasa_add_custom_woo_actions() {
    /**
     * For Product Special Deal Simple
     */
    if (function_exists('elessi_add_custom_sale_flash')) {
        add_action('nasa_special_deal_simple_action', 'elessi_add_custom_sale_flash');
    } else {
        add_action('nasa_special_deal_simple_action', 'woocommerce_show_product_loop_sale_flash');
    }
    
    if (function_exists('elessi_loop_product_content_btns')) {
        add_action('nasa_special_deal_simple_action', 'elessi_loop_product_content_btns');
    }
    
    if (function_exists('elessi_gift_featured')) {
        add_action('nasa_special_deal_simple_action', 'elessi_gift_featured');
    }
    
    if (function_exists('elessi_loop_product_content_thumbnail')) {
        add_action('nasa_special_deal_simple_action', 'elessi_loop_product_content_thumbnail');
    } else {
        add_action('nasa_special_deal_simple_action', 'woocommerce_template_loop_product_thumbnail');
    }
    
    /**
     * For product special Deal Multi
     */
    if (function_exists('elessi_add_to_cart_in_list')) {
        add_action('nasa_special_deal_multi_action', 'nasa_before_deal_multi_action');
        add_action('nasa_special_deal_multi_action', 'elessi_add_to_cart_in_list');
        add_action('nasa_special_deal_multi_action', 'nasa_after_deal_multi_action');
    }
}

/**
 * Before wrap deal
 */
function nasa_before_deal_multi_action() {
    echo '<div class="product-deal-special-buttons"><div class="nasa-product-grid">';
}

/**
 * After wrap deal
 */
function nasa_after_deal_multi_action() {
    echo '</div></div>';
}
