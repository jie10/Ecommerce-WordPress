<?php
add_action('init', 'elessi_product_compare_heading');
if (!function_exists('elessi_product_compare_heading')) {
    function elessi_product_compare_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Compare and Wishlist", 'elessi-theme'),
            "target" => 'product-compare-wishlist',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Compare Options", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Compare Options", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        global $yith_woocompare;
        if ($yith_woocompare) {
            $of_options[] = array(
                "name" => esc_html__("Nasa compare products Extends Yith Plugin Compare", 'elessi-theme'),
                "id" => "nasa-product-compare",
                "std" => 1,
                "type" => "switch"
            );
            
            $of_options[] = array(
                "name" => esc_html__("Page view compare products", 'elessi-theme'),
                "id" => "nasa-page-view-compage",
                "type" => "select",
                "options" => get_pages_temp_compare()
            );

            $of_options[] = array(
                "name" => esc_html__("Max products compare", 'elessi-theme'),
                "id" => "max_compare",
                "std" => "4",
                "type" => "select",
                "options" => array("2" => "2", "3" => "3", "4" => "4")
            );
        } else {
            $of_options[] = array(
                "name" => esc_html__("Please Install Yith Plugin Compare", 'elessi-theme'),
                "std" => '<h4 style="color: red">' . esc_html__("Please, Install Yith Plugin Compare!", 'elessi-theme') . "</h4>",
                "type" => "info"
            );
        }
        
        /**
         * Wishlist
         */
        $of_options[] = array(
            "name" => esc_html__("Wishlist Options", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Wishlist Options", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        if (NASA_WISHLIST_ENABLE) {
            $of_options[] = array(
                "name" => esc_html__("Optimize Yith Wishlist HTML", 'elessi-theme'),
                "id" => "optimize_wishlist_html",
                "std" => 1,
                "type" => "switch"
            );
        }
        
        /**
         * Nasa Wishlist
         */
        else {
            $of_options[] = array(
                "name" => esc_html__("NasaTheme Wishlist Feature", 'elessi-theme'),
                "id" => "enable_nasa_wishlist",
                "std" => 1,
                "type" => "switch"
            );
        }
    }
}
