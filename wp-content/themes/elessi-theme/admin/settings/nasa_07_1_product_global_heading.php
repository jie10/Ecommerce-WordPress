<?php
add_action('init', 'elessi_product_global_heading');
if (!function_exists('elessi_product_global_heading')) {
    function elessi_product_global_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Product Global Options", 'elessi-theme'),
            "target" => 'product-global',
            "type" => "heading",
        );
        
        // Loop Group Buttons layout
        $of_options[] = array(
            "name" => esc_html__("Loop Product Buttons for Desktop", 'elessi-theme'),
            "id" => "loop_layout_buttons",
            "std" => "ver-buttons",
            "type" => "select",
            "options" => array(
                "ver-buttons" => esc_html__("Vertical Buttons", 'elessi-theme'),
                "hoz-buttons" => esc_html__("Horizontal Buttons", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hover Product Effect", 'elessi-theme'),
            "id" => "animated_products",
            "std" => "hover-fade",
            "type" => "select",
            "options" => array(
                "hover-fade" => esc_html__("Fade", 'elessi-theme'),
                "hover-zoom" => esc_html__("Zoom", 'elessi-theme'),
                "hover-to-top" => esc_html__("Move To Top", 'elessi-theme'),
                "hover-flip" => esc_html__("Flip Horizontal", 'elessi-theme'),
                "hover-bottom-to-top" => esc_html__("Bottom To Top", 'elessi-theme'),
                "hover-top-to-bottom" => esc_html__("Top To Bottom", 'elessi-theme'),
                "hover-left-to-right" => esc_html__("Left To Right", 'elessi-theme'),
                "hover-right-to-left" => esc_html__("Right To Left", 'elessi-theme'),
                "" => esc_html__("No Effect", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Back Image in Mobile Layout", 'elessi-theme'),
            "id" => "mobile_back_image",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Featured Badge", 'elessi-theme'),
            "id" => "featured_badge",
            "std" => "0",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Catalog Mode - Disable Add To Cart Feature", 'elessi-theme'),
            "id" => "disable-cart",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Add To Cart in Loop", 'elessi-theme'),
            "id" => "loop_add_to_cart",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Event After Add to Cart", 'elessi-theme'),
            "id" => "event-after-add-to-cart",
            "std" => "sidebar",
            "type" => "select",
            "options" => array(
                "sidebar" => esc_html__("Open Cart Sidebar - Not with Mobile", 'elessi-theme'),
                "popup" => esc_html__("Popup Your Order - Not with Mobile", 'elessi-theme'),
                "notice" => esc_html__("Show Notice", 'elessi-theme'),
            ),
            "desc" => esc_html__('Note: With Mobile always "Show Notice" After Added To Cart', 'elessi-theme')
        );
        
        $of_options[] = array(
            "name" => esc_html__("Icon Mini Cart in Header", 'elessi-theme'),
            "id" => "mini-cart-icon",
            "std" => "1",
            "type" => "images",
            "options" => array(
                // icon-nasa-cart-3 - default
                '1' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-1.jpg',
                // icon-nasa-cart-2
                '2' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-2.jpg',
                // icon-nasa-cart-4
                '3' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-3.jpg',
                // pe-7s-cart
                '4' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-4.jpg',
                // fa fa-shopping-cart
                '5' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-5.jpg',
                // fa fa-shopping-bag
                '6' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-6.jpg',
                // fa fa-shopping-basket
                '7' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-7.jpg'
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Icon Add To Cart in Grid", 'elessi-theme'),
            "id" => "cart-icon-grid",
            "std" => "1",
            "type" => "images",
            "options" => array(
                // fa fa-plus - default
                '1' => ELESSI_ADMIN_DIR_URI . 'assets/images/cart-plus.jpg',
                // icon-nasa-cart-3
                '2' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-1.jpg',
                // icon-nasa-cart-2
                '3' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-2.jpg',
                // icon-nasa-cart-4
                '4' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-3.jpg',
                // pe-7s-cart
                '5' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-4.jpg',
                // fa fa-shopping-cart
                '6' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-5.jpg',
                // fa fa-shopping-bag
                '7' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-6.jpg',
                // fa fa-shopping-basket
                '8' => ELESSI_ADMIN_DIR_URI . 'assets/images/mini-cart-7.jpg'
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Quantity Input - Off-Canvas Cart", 'elessi-theme'),
            "id" => "mini_cart_qty",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Compact Number - Cart, Wishlist, Compare (9+)", 'elessi-theme'),
            "id" => "compact_number",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Quick View", 'elessi-theme'),
            "id" => "disable-quickview",
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "std" => "0",
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Quickview Layout", 'elessi-theme'),
            "id" => "style_quickview",
            "std" => "sidebar",
            "type" => "select",
            "options" => array(
                'popup' => esc_html__('Popup Classical', 'elessi-theme'),
                'sidebar' => esc_html__('Off-Canvas', 'elessi-theme')
            ),
            
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Number Show Quickview Thumbnail", 'elessi-theme'),
            "id" => "quick_view_item_thumb",
            "std" => "1-item",
            "type" => "select",
            "options" => array(
                '1-item' => esc_html__('Single Thumbnail', 'elessi-theme'),
                '2-items' => esc_html__('Double Thumbnails', 'elessi-theme')
            ),
            
            'class' => 'nasa-style_quickview nasa-style_quickview-sidebar nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Cart Sidebar Layout", 'elessi-theme'),
            "id" => "style-cart",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                'style-1' => esc_html__('Light', 'elessi-theme'),
                'style-2' => esc_html__('Dark', 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Wishlist Sidebar Layout", 'elessi-theme'),
            "id" => "style-wishlist",
            "std" => "style-1",
            "type" => "select",
            "options" => array(
                'style-1' => esc_html__('Light', 'elessi-theme'),
                'style-2' => esc_html__('Dark', 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Load Css Canvas", 'elessi-theme'),
            "id" => "css_canvas",
            "std" => 'async',
            "type" => "select",
            "options" => array(
                'async' => esc_html__('Async', 'elessi-theme'),
                'sync' => esc_html__('Sync', 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Checkout Layout", 'elessi-theme'),
            "id" => "checkout_layout",
            "std" => "",
            "type" => "select",
            "options" => array(
                '' => esc_html__('Default', 'elessi-theme'),
                'modern' => esc_html__('Modern - No Header, No Footer', 'elessi-theme')
            ),
            'class' => 'nasa-theme-option-parent'
        );
        
        // Only show one Shipping Method in Cart
        $of_options[] = array(
            "name" => esc_html__("Only Show one Shipping Method in Cart Page", 'elessi-theme'),
            "id" => "cart_1_shiping",
            "std" => "1",
            "type" => "switch",
            'class' => 'nasa-checkout_layout nasa-checkout_layout-modern nasa-theme-option-child'
        );
        
        if (defined('YITH_WCPB')) {
            // Enable Gift in grid
            $of_options[] = array(
                "name" => esc_html__("Enable Promotion Gifts featured icon", 'elessi-theme'),
                "id" => "enable_gift_featured",
                "std" => 1,
                "type" => "switch"
            );
        }
        
        // Options live search products
        $of_options[] = array(
            "name" => esc_html__("Search Anything After Submit", 'elessi-theme'),
            "id" => "anything_search",
            "std" => 0,
            "type" => "switch",
            "desc" => '<span class="nasa-warning red-color">' . esc_html__("If Turn on, the live search Ajax feature will be lost", 'elessi-theme') . '</span>',
        );

        // Options live search products
        $of_options[] = array(
            "name" => esc_html__("Live Search Ajax Products", 'elessi-theme'),
            "id" => "enable_live_search",
            "std" => 1,
            "type" => "switch"
        );
        
        // limit_results_search
        $of_options[] = array(
            "name" => esc_html__("Results Ajax Search (Limit Products)", 'elessi-theme'),
            "id" => "limit_results_search",
            "std" => "5",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Suggested Keywords", 'elessi-theme'),
            "desc" => 'Please input the Suggested keywords (ex: Sweater, Jacket, T-shirt ...).',
            "id" => "hotkeys_search",
            "std" => '',
            "type" => "textarea"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Live Search Layout - (Header type 1, 2, 5)", 'elessi-theme'),
            "id" => "search_layout",
            "std" => "classic",
            "type" => "select",
            "options" => array(
                "classic" => esc_html__("Classic", 'elessi-theme'),
                "modern" => esc_html__("Modern", 'elessi-theme')
            )
        );
        // End Options live search products
        
        $of_options[] = array(
            "name" => esc_html__("Display top icon filter categories", 'elessi-theme'),
            "id" => "show_icon_cat_top",
            "std" => "show-in-shop",
            "type" => "select",
            "options" => array(
                'show-in-shop' => esc_html__('Only show in shop', 'elessi-theme'),
                'show-all-site' => esc_html__('Always show all pages', 'elessi-theme'),
                'not-show' => esc_html__('Disabled', 'elessi-theme'),
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Max Depth Level Top Filter Categories", 'elessi-theme'),
            "id" => "depth_cat_top",
            "std" => "0",
            "type" => "select",
            "options" => array(
                '0' => esc_html__('Show All', 'elessi-theme'),
                '1' => esc_html__('Max Depth 1 Level', 'elessi-theme'),
                '2' => esc_html__('Max Depth 2 Levels', 'elessi-theme'),
                '3' => esc_html__('Max Depth 3 Levels', 'elessi-theme')
            ),
            'override_numberic' => true
        );
        
        // Hide categories empty product
        $of_options[] = array(
            "name" => esc_html__("Hide categories empty product - Top Filter Categories", 'elessi-theme'),
            "id" => "hide_empty_cat_top",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable top level of categories follow current category archive (Use for Multi stores)", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "disable_top_level_cat",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Show Uncategorized", 'elessi-theme'),
            "id" => "show_uncategorized",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Crazy Loading", 'elessi-theme'),
            "id" => "crazy_load",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable ajax Progress Bar Loading", 'elessi-theme'),
            "id" => "disable_ajax_product_progress_bar",
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "std" => 0,
            "type" => "checkbox"
        );
    }
}
