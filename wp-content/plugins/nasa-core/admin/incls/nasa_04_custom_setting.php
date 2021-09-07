<?php
defined('ABSPATH') or die(); // Exit if accessed directly

add_action('init', 'nasa_custom_option_themes', 11);
function nasa_custom_option_themes() {
    global $of_options;
    if (empty($of_options)) {
        $of_options = array();
    }
    
    /**
     * Variations Swatches
     */
    $of_options = nasa_options_variation_swatches($of_options);
    
    /**
     * WooCommerce Open
     */
    $of_options = nasa_options_woo_open($of_options);
    
    /**
     * Promote Sales
     */
    $of_options = nasa_options_promote_sales($of_options);
    
    /**
     * Brand Product
     */
    $of_options = nasa_options_brand_product($of_options);
    
    /**
     * Group Product
     */
    $of_options = nasa_options_group_product($of_options);

    /**
     * Shares and follows
     */
    $of_options = nasa_options_share_follow($of_options);
    
    /**
     * Mobile Detect - Caching - etc..
     */
    $of_options = nasa_options_global_nasa_core($of_options);
}

/**
 * Color - Label (Size) - Image Swatches
 */
function nasa_options_variation_swatches($of_options = array()) {
    $of_options[] = array(
        "name" => esc_html__("Variation Swatches", 'nasa-core'),
        "target" => 'nasa-variation-swatches',
        "type" => "heading"
    );

    $of_options[] = array(
        "name" => esc_html__('Enable UX Variations (Color - Label (Size) - Image Swatches)', 'nasa-core'),
        "id" => "enable_nasa_variations_ux",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('UX Variations in Grid - Loop', 'nasa-core'),
        "id" => "nasa_variations_ux_item",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Add To Cart UX Variations in Grid', 'nasa-core'),
        "id" => "nasa_variations_ux_add_to_cart_grid",
        "std" => 1,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => esc_html__('Default Attributies With Type Select, Custom in Grid', 'nasa-core'),
        "id" => "enable_nasa_ux_select",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Show the first item - Type Select, Custom', 'nasa-core'),
        "id" => "show_nasa_ux_select_first",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Load UX Variations in Grid After Click', 'nasa-core'),
        "id" => "nasa_variations_after",
        "std" => "",
        "type" => "select",
        "options" => array(
            "" => esc_html__("None", 'nasa-core'),
            "select" => esc_html__("Select Options", 'nasa-core'),
            "badge" => esc_html__("Badge Variants", 'nasa-core')
        )
    );
    
    // limit_show num of 1 variation
    $of_options[] = array(
        "name" => esc_html__('Limit in Product Grid', 'nasa-core'),
        "desc" => esc_html__('Limit show variations/1 attribute in product grid. Empty input to show all', 'nasa-core'),
        "id" => "limit_nasa_variations_ux",
        "std" => "5",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Image Attribute Style - All", 'nasa-core'),
        "id" => "nasa_attr_image_style",
        "std" => "round",
        "type" => "select",
        "options" => array(
            "round" => esc_html__("Round", 'nasa-core'),
            "square" => esc_html__("Square", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => esc_html__("Image Attribute Style - Only use for Single or Quickview", 'nasa-core'),
        "id" => "nasa_attr_image_single_style",
        "std" => "extends",
        "type" => "select",
        "options" => array(
            "extends" => esc_html__("Extends from Image Attribute Style - All", 'nasa-core'),
            "square-caption" => esc_html__("Square has Caption", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => esc_html__("Color Attribute Style - Only use for Single or Quickview", 'nasa-core'),
        "id" => "nasa_attr_color_style",
        "std" => "radio",
        "type" => "select",
        "options" => array(
            "radio" => esc_html__("Radio Style - Tooltip", 'nasa-core'),
            "round" => esc_html__("Round Wrapper - Tooltip", 'nasa-core'),
            "small-square" => esc_html__("Small Square", 'nasa-core'),
            "big-square" => esc_html__("Big Square", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => esc_html__("Label Attribute Style - Only use for Single or Quickview", 'nasa-core'),
        "id" => "nasa_attr_label_style",
        "std" => "radio",
        "type" => "select",
        "options" => array(
            "radio" => esc_html__("Radio Style", 'nasa-core'),
            "round" => esc_html__("Round Wrapper", 'nasa-core'),
            "small-square-1" => esc_html__("Small Square 1", 'nasa-core'),
            "small-square-2" => esc_html__("Small Square 2", 'nasa-core'),
            "big-square" => esc_html__("Big Square", 'nasa-core')
        )
    );

    $of_options[] = array(
        "name" => esc_html__('Gallery for Variation', 'nasa-core'),
        "id" => "gallery_images_variation",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Label Attribute Selected - Single / Quick view Product', 'nasa-core'),
        "id" => "label_attribute_single",
        "std" => 0,
        "type" => "switch"
    );
    
    return $of_options;
}

/**
 * WooCommerce Open
 */
function nasa_options_woo_open($of_options = array()) {
    $contact_forms = nasa_get_contact_form7();
    
    $blocks = nasa_get_blocks_options();
    if (isset($blocks['-1'])) {
        unset($blocks['-1']);
    }
    
    $of_options[] = array(
        "name" => esc_html__("WooCommerce Open", 'nasa-core'),
        "target" => 'nasa-option-woo-open',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Product 360&#176; Viewer", 'nasa-core'),
        "id" => "product_360_degree",
        "std" => '1',
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("360&#176; Viewer Badge In Grid", 'nasa-core'),
        "id" => "nasa_badge_360",
        "std" => '0',
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Video Badge In Grid", 'nasa-core'),
        "id" => "nasa_badge_video",
        "std" => '0',
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Size Guide - Single Product Page", 'nasa-core'),
        "id" => "size_guide_product",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("Delivery &#38; Return - Single Product Page", 'nasa-core'),
        "id" => "delivery_return_single_product",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("Ask a Question - Single Product Page", 'nasa-core'),
        "id" => "ask_a_question",
        "type" => "select",
        'override_numberic' => true,
        "options" => $contact_forms
    );
    
    $of_options[] = array(
        "name" => esc_html__("Request a Call Back - Single Product Page", 'nasa-core'),
        "id" => "request_a_callback",
        "type" => "select",
        'override_numberic' => true,
        "options" => $contact_forms
    );
    
    $of_options[] = array(
        "name" => esc_html__("After Single Product Add To Cart Form", 'nasa-core'),
        "id" => "after_single_addtocart_form",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("After Process Checkout Button - Shopping Cart", 'nasa-core'),
        "id" => "after_process_checkout",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    // woocommerce_after_cart_table
    $of_options[] = array(
        "name" => esc_html__("After Cart Table - Shopping Cart", 'nasa-core'),
        "id" => "after_cart_table",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("After Cart Content - Shopping Cart", 'nasa-core'),
        "id" => "after_cart",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("After Customer Details - Checkout", 'nasa-core'),
        "id" => "after_checkout_customer",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("After Place Order Button - Checkout", 'nasa-core'),
        "id" => "after_place_order",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("After Review Order Payment - Checkout", 'nasa-core'),
        "id" => "after_review_order",
        "type" => "select",
        "options" => $blocks,
        "desc" => esc_html__("Please create Static Blocks and select here.", 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("Recommend In Archive Products", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Recommend In Archive Products Page", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    /**
     * Recommend - Viewed Products
     */
    $of_options[] = array(
        "name" => esc_html__("Enable Recommend Products", 'nasa-core'),
        "id" => "enable_recommend_product",
        "std" => "0",
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => esc_html__("Limit Recommended Products", 'nasa-core'),
        "id" => "recommend_product_limit",
        "std" => "9",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Desktop Columns", 'nasa-core'),
        "id" => "recommend_columns_desk",
        "std" => "5-cols",
        "type" => "select",
        "options" => array(
            "2-cols" => esc_html__("2 columns", 'nasa-core'),
            "3-cols" => esc_html__("3 columns", 'nasa-core'),
            "4-cols" => esc_html__("4 columns", 'nasa-core'),
            "5-cols" => esc_html__("5 columns", 'nasa-core'),
            "6-cols" => esc_html__("6 columns", 'nasa-core'),
        )
    );

    $of_options[] = array(
        "name" => esc_html__("Mobile Columns", 'nasa-core'),
        "id" => "recommend_columns_small",
        "std" => "2-cols",
        "type" => "select",
        "options" => array(
            "1-col" => esc_html__("1 column", 'nasa-core'),
            "1.5-cols" => esc_html__("1,5 columns", 'nasa-core'),
            "2-cols" => esc_html__("2 columns", 'nasa-core')
        )
    );

    $of_options[] = array(
        "name" => esc_html__("Tablet Columns", 'nasa-core'),
        "id" => "recommend_columns_tablet",
        "std" => "3-cols",
        "type" => "select",
        "options" => array(
            "1-col" => esc_html__("1 column", 'nasa-core'),
            "2-cols" => esc_html__("2 columns", 'nasa-core'),
            "3-cols" => esc_html__("3 columns", 'nasa-core'),
            "4-cols" => esc_html__("3 columns", 'nasa-core')
        )
    );

    $of_options[] = array(
        "name" => esc_html__("Recommend Position", 'nasa-core'),
        "id" => "recommend_product_position",
        "std" => "bot",
        "type" => "select",
        "options" => array(
            "top" => esc_html__("Top", 'nasa-core'),
            "bot" => esc_html__("Bottom", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => esc_html__("Viewed Products", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Viewed Products", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Viewed Products", 'nasa-core'),
        "id" => "enable-viewed",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Viewed Sidebar Off-Canvas", 'nasa-core'),
        "id" => "viewed_canvas",
        "std" => 1,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => esc_html__("Viewed Products Limit", 'nasa-core'),
        "id" => "limit_product_viewed",
        "std" => "12",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Icon Viewed Style", 'nasa-core'),
        "id" => "style-viewed-icon",
        "std" => "style-1",
        "type" => "select",
        "options" => array(
            'style-1' => esc_html__('Light', 'nasa-core'),
            'style-2' => esc_html__('Dark', 'nasa-core')
        )
    );

    $of_options[] = array(
        "name" => esc_html__("Viewed Sidebar Layout", 'nasa-core'),
        "id" => "style-viewed",
        "std" => "style-1",
        "type" => "select",
        "options" => array(
            'style-1' => esc_html__('Light', 'nasa-core'),
            'style-2' => esc_html__('Dark', 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => esc_html__("Personalize product", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Personalize product", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Enable", 'nasa-core'),
        "id" => "enable_personalize",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("List Font Types for Personalize product", 'nasa-core'),
        "id" => "personalize_font_types",
        "std" => 'Font One, Font Two, Font Three, Font Four',
        "type" => "textarea",
        "desc" => esc_html__('Separated by ", "', 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__("List Font Colours for Personalize product", 'nasa-core'),
        "id" => "personalize_font_colours",
        "std" => 'Black, White, Silver, Gold',
        "type" => "textarea",
        "desc" => esc_html__('Separated by ", "', 'nasa-core'),
    );
    
    return $of_options;
}

/**
 * Promote Sales
 */
function nasa_options_promote_sales($of_options = array()) {
    $of_options[] = array(
        "name" => esc_html__("Promote Sales", 'nasa-core'),
        "target" => 'nasa-option-promote-sales',
        "type" => "heading"
    );
    
    /* Bulk Discount */
    $of_options[] = array(
        "name" => esc_html__("Bulk Discounts", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Bulk Discounts Product", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Enable", 'nasa-core'),
        "id" => "bulk_dsct",
        "std" => 1,
        "type" => "switch"
    );
    
    /* Fake Sold */
    $of_options[] = array(
        "name" => esc_html__("Fake Sold", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Fake Sold", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Enable", 'nasa-core'),
        "id" => "fake_sold",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Min Fake Sold", 'nasa-core'),
        "id" => "min_fake_sold",
        "std" => "1",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Max Fake Sold", 'nasa-core'),
        "id" => "max_fake_sold",
        "std" => "20",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Min Fake Time (number hours ago)", 'nasa-core'),
        "id" => "min_fake_time",
        "std" => "1",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Max Fake Time (number hours ago)", 'nasa-core'),
        "id" => "max_fake_time",
        "std" => "20",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Live Time Fake (s)", 'nasa-core'),
        "id" => "fake_time_live",
        "std" => "36000",
        "type" => "text",
        "desc" => '<a href="javascript:void(0);" class="button-primary nasa-clear-fake-sold-cache" data-ok="' . esc_html__('Reset Fake Sold Success !', 'nasa-core') . '" data-miss="' . esc_html__('Fake Sold is Empty!', 'nasa-core') . '" data-fail="' . esc_html__('Error!', 'nasa-core') . '">' . esc_html__('Reset Fake Sold', 'nasa-core') . '</a><span class="nasa-admin-loader hidden-tag"><img src="' . NASA_CORE_PLUGIN_URL . 'admin/assets/ajax-loader.gif" /></span>',
    );
    
    /* Estimated Delivery */
    $of_options[] = array(
        "name" => esc_html__("Estimated Delivery", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Estimated Delivery", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Enable", 'nasa-core'),
        "id" => "est_delivery",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("From - Estimated Days", 'nasa-core'),
        "id" => "min_est_delivery",
        "std" => "3",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("To - Estimated Days", 'nasa-core'),
        "id" => "max_est_delivery",
        "std" => "7",
        "type" => "text"
    );
    
    /* Fake viewing */
    $of_options[] = array(
        "name" => esc_html__("Fake Viewing", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Fake Viewing", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Enable", 'nasa-core'),
        "id" => "fake_view",
        "std" => 1,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Begin - Min Counter", 'nasa-core'),
        "id" => "min_fake_view",
        "std" => "10",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Begin - Max Counter", 'nasa-core'),
        "id" => "max_fake_view",
        "std" => "50",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Change Time Delay (s)", 'nasa-core'),
        "id" => "delay_time_view",
        "std" => "15",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Max Change", 'nasa-core'),
        "id" => "max_change_view",
        "std" => "5",
        "type" => "text"
    );
    
    return $of_options;
}

/**
 * Brand Products
 */
function nasa_options_brand_product($of_options = array()) {
    $of_options[] = array(
        "name" => esc_html__("Product Brands", 'nasa-core'),
        "target" => 'nasa-option-brand-products',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Turn On Product Brand - Taxonomies", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Turn On Product Brand - Taxonomies", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Enable', 'nasa-core'),
        "id" => "enable_nasa_brands",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Using Image Attributes To Do Brands", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Using Image Attributes To Do Brands", 'nasa-core') . "</h4>",
        "type" => "info"
    );
    
    $brands = Nasa_Abstract_WC_Attr_UX::get_tax_images_to_brands();
    $of_options[] = array(
        "name" => esc_html__("Image Attributes To Do Brands", 'nasa-core'),
        "id" => "attr_brands",
        "std" => array(),
        "type" => "multicheck",
        "options" => $brands,
        'desc' => $brands ? '' : esc_html__("Please create a Product Attribute type Image to use this feature.", 'nasa-core'),
    );
    
    return $of_options;
}

/**
 * Group Products
 */
function nasa_options_group_product($of_options = array()) {
    $of_options[] = array(
        "name" => esc_html__("Product Group", 'nasa-core'),
        "target" => 'nasa-option-group-products',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Enable', 'nasa-core'),
        "id" => "enable_nasa_custom_categories",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Slug of Products Group", 'nasa-core'),
        "id" => "nasa_custom_categories_slug",
        "std" => "",
        "type" => "text",
        "desc" => esc_html__('Default is "nasa_product_cat", please input your custom slug.', 'nasa-core'),
    );
    
    $of_options[] = array(
        "name" => esc_html__('Enable in Archive Products', 'nasa-core'),
        "id" => "archive_product_nasa_custom_categories",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Max Deep in Archive Products Page", 'nasa-core'),
        "id" => "max_level_nasa_custom_categories",
        "std" => "3-levels",
        "type" => "select",
        "options" => array(
            "1-level" => esc_html__("1 level", 'nasa-core'),
            "2-levels" => esc_html__("2 levels", 'nasa-core'),
            "3-levels" => esc_html__("3 levels", 'nasa-core')
        )
    );
    
    return $of_options;
}

/**
 * Share and Follow
 */
function nasa_options_share_follow($of_options = array()) {
    $of_options[] = array(
        "name" => esc_html__("Share & Follow", 'nasa-core'),
        "target" => 'nasa-option-share-follow',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Options Shares", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Options Shares", 'nasa-core') . "</h4>",
        "type" => "info"
    );

    $of_options[] = array(
        "name" => esc_html__("Share Icons", 'nasa-core'),
        "desc" => esc_html__("Select icons to be shown on share icons on product page, blog page and [share] shortcode", 'nasa-core'),
        "id" => "social_icons",
        "std" => array(
            "facebook",
            "twitter",
            "email",
            "pinterest"
        ),
        "type" => "multicheck",
        "options" => array(
            "facebook" => esc_html__("Facebook", 'nasa-core'),
            "twitter" => esc_html__("Twitter", 'nasa-core'),
            "pinterest" => esc_html__("Pinterest", 'nasa-core'),
            "linkedin" => esc_html__("Linkedin", 'nasa-core'),
            "telegram" => esc_html__("Telegram", 'nasa-core'),
            "vk" => esc_html__("VK", 'nasa-core'),
            "email" => esc_html__("Email", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => esc_html__("Options Follows", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Options Follows", 'nasa-core') . "</h4>",
        "type" => "info"
    );

    $of_options[] = array(
        "name" => esc_html__("Facebook URL Follow", 'nasa-core'),
        "id" => "facebook_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("VK URL Follow", 'nasa-core'),
        "id" => "vk_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Twitter URL Follow", 'nasa-core'),
        "id" => "twitter_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Email URL", 'nasa-core'),
        "id" => "email_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Pinterest URL Follow", 'nasa-core'),
        "id" => "pinterest_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Instagram URL Follow", 'nasa-core'),
        "id" => "instagram_url",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("RSS URL Follow", 'nasa-core'),
        "id" => "rss_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Linkedin URL Follow", 'nasa-core'),
        "id" => "linkedin_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Youtube URL Follow", 'nasa-core'),
        "id" => "youtube_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Tumblr URL Follow", 'nasa-core'),
        "id" => "tumblr_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Flickr URL Follow", 'nasa-core'),
        "id" => "flickr_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Telegram URL Follow", 'nasa-core'),
        "id" => "telegram_url_follow",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Whatsapp URL Follow", 'nasa-core'),
        "id" => "whatsapp_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Weibo URL Follow", 'nasa-core'),
        "id" => "weibo_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Amazon URL", 'nasa-core'),
        "id" => "amazon_url_follow",
        "std" => "",
        "type" => "text"
    );
    
    return $of_options;
}

/**
 * Global Option Nasa Core
 */
function nasa_options_global_nasa_core($of_options = array()) {
    $of_options[] = array(
        "name" => esc_html__("Nasa Core Options", 'nasa-core'),
        "target" => 'nasa-option',
        "type" => "heading"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Enable Mobile Layout', 'nasa-core'),
        "id" => "enable_nasa_mobile",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Cache Files', 'nasa-core'),
        "id" => "enable_nasa_cache",
        "std" => 1,
        "type" => "switch",
        "desc" => '<strong class="red-color">' . esc_html__("Please don't turn off with this option to increase website performance", 'nasa-core') . '</strong>',
    );
    
    $of_options[] = array(
        "name" => esc_html__("Cache Mode", 'nasa-core'),
        "id" => "nasa_cache_mode",
        "std" => "file",
        "type" => "select",
        "options" => array(
            "file" => esc_html__("Files - directory uploads / nasa-caches", 'nasa-core'),
            "transient" => esc_html__("Transients - of default Wordpress", 'nasa-core')
        )
    );
    
    $of_options[] = array(
        "name" => esc_html__('Cache Shortcodes (Apply with Cache Files)', 'nasa-core'),
        "id" => "nasa_cache_shortcodes",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Cache Variable Loop Products (Apply with Cache Files)', 'nasa-core'),
        "id" => "nasa_cache_variables",
        "std" => 1,
        "type" => "switch",
        "desc" => '<strong class="red-color">' . esc_html__("Please don't turn off with this option to increase website performance", 'nasa-core') . '</strong>',
    );
    
    $of_options[] = array(
        "name" => esc_html__('Expire Time (Seconds - Expire time live file.)', 'nasa-core'),
        "desc" => '<a href="javascript:void(0);" class="button-primary nasa-clear-variations-cache" data-ok="' . esc_html__('Clear Cache Success !', 'nasa-core') . '" data-miss="' . esc_html__('Cache Empty!', 'nasa-core') . '" data-fail="' . esc_html__('Error!', 'nasa-core') . '">' . esc_html__('Clear Cache', 'nasa-core') . '</a><span class="nasa-admin-loader hidden-tag"><img src="' . NASA_CORE_PLUGIN_URL . 'admin/assets/ajax-loader.gif" /></span>',
        "id" => "nasa_cache_expire",
        "std" => '36000',
        "type" => "text"
    );
    
    $of_options[] = array(
        "name" => esc_html__('Use Smilies', 'nasa-core'),
        "id" => "enable_use_smilies",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('CDN Images Site', 'nasa-core'),
        "id" => "enable_nasa_cdn_images",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__('CDN CNAME.', 'nasa-core'),
        "desc" => esc_html__('Input CNAME. It will be replaced for home URL of images your site. (Ex: https://elessi-cdn.nasatheme.com)', 'nasa-core'),
        "id" => "nasa_cname_images",
        "std" => "",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Effect Pin Space (Pin Banner)", 'nasa-core'),
        "id" => "effect_pin_product_banner",
        "std" => 0,
        "type" => "switch"
    );
    
    $of_options[] = array(
        "name" => esc_html__("Optimize HTML", 'nasa-core'),
        "id" => "tmpl_html",
        "std" => 0,
        "type" => "switch"
    );
    
    /**
     * Site Offline
     */
    $of_options[] = array(
        "name" => esc_html__("Site Mode Options", 'nasa-core'),
        "std" => "<h4>" . esc_html__("Site Mode Options", 'nasa-core') . "</h4>",
        "type" => "info"
    );

    $of_options[] = array(
        "name" => esc_html__("Site Offline", 'nasa-core'),
        "id" => "site_offline",
        "std" => 0,
        "type" => "switch"
    );

    $of_options[] = array(
        "name" => esc_html__("Coming Soon Tittle", 'nasa-core'),
        "id" => "coming_soon_title",
        "std" => "Comming Soon",
        "type" => "text"
    );

    $of_options[] = array(
        "name" => esc_html__("Coming Soon Info", 'nasa-core'),
        "id" => "coming_soon_info",
        "std" => "Condimentum ipsum a adipiscing hac dolor set consectetur urna commodo elit parturient<br />a molestie ut nisl partu cl vallier ullamcorpe",
        "type" => "textarea"
    );

    $of_options[] = array(
        "name" => esc_html__("Coming Soon Image", 'nasa-core'),
        "id" => "coming_soon_img",
        "std" => NASA_CORE_PLUGIN_URL . "/assets/images/comming-soon.jpg",
        "type" => "media"
    );

    $of_options[] = array(
        "name" => esc_html__("Coming Soon Time", 'nasa-core'),
        "id" => "coming_soon_time",
        "desc" => esc_html__("Please enter a time to return the site to Online (YYYY/mm/dd | YYYY-mm-dd).", 'nasa-core'),
        "std" => "",
        "type" => "text"
    );
    
    return $of_options;
}
