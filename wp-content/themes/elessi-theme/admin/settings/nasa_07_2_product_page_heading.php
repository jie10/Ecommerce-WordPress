<?php
add_action('init', 'elessi_product_page_heading');
if (!function_exists('elessi_product_page_heading')) {
    function elessi_product_page_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Archive Products Page", 'elessi-theme'),
            "target" => 'product-page',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Shop Sidebar Layout", 'elessi-theme'),
            "id" => "category_sidebar",
            "std" => "top",
            "type" => "select",
            "options" => array(
                "top" => esc_html__("Top Bar", 'elessi-theme'),
                "top-2" => esc_html__("Top Bar Type 2", 'elessi-theme'),
                "left" => esc_html__("Left Sidebar - Off-canvas", 'elessi-theme'),
                "right" => esc_html__("Right Sidebar - Off-canvas", 'elessi-theme'),
                "left-classic" => esc_html__("Left Sidebar - Classic", 'elessi-theme'),
                "right-classic" => esc_html__("Right Sidebar - Classic", 'elessi-theme'),
                "no" => esc_html__("No Sidebar", 'elessi-theme'),
            ),
            
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Toggle Sidebar", 'elessi-theme'),
            "id" => "toggle_sidebar_classic",
            "std" => "1",
            "type" => "switch",
            'class' => 'nasa-category_sidebar nasa-category_sidebar-left-classic nasa-category_sidebar-right-classic nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Top Bar Label", 'elessi-theme'),
            "id" => "top_bar_archive_label",
            "std" => "Filter by:",
            "type" => "text",
            'class' => 'nasa-category_sidebar nasa-category_sidebar-top nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Top Bar Limit widgets to Show More", 'elessi-theme'),
            "id" => "limit_widgets_show_more",
            "desc" => esc_html__('Limit widgets to show more. (Input "All" will be show all widgets)', 'elessi-theme'),
            "std" => "4",
            "type" => "text",
            'class' => 'nasa-category_sidebar nasa-category_sidebar-top nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Position filter categories", 'elessi-theme'),
            "id" => "top_bar_cat_pos",
            "std" => "left-bar",
            "type" => "select",
            "options" => array(
                "top" => esc_html__("Top", 'elessi-theme'),
                "left-bar" => esc_html__("Left bar", 'elessi-theme')
            ),
            'class' => 'nasa-category_sidebar nasa-category_sidebar-top nasa-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Columns", 'elessi-theme'),
            "id" => "products_per_row",
            "std" => "4-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'elessi-theme'),
                "3-cols" => esc_html__("3 columns", 'elessi-theme'),
                "4-cols" => esc_html__("4 columns", 'elessi-theme'),
                "5-cols" => esc_html__("5 columns", 'elessi-theme'),
                "6-cols" => esc_html__("6 columns", 'elessi-theme'),
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Mobile Columns", 'elessi-theme'),
            "id" => "products_per_row_small",
            "std" => "1-col",
            "type" => "select",
            "options" => array(
                "1-cols" => esc_html__("1 column", 'elessi-theme'),
                "2-cols" => esc_html__("2 columns", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tablet Columns", 'elessi-theme'),
            "id" => "products_per_row_tablet",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'elessi-theme'),
                "3-cols" => esc_html__("3 columns", 'elessi-theme'),
                "4-cols" => esc_html__("4 columns", 'elessi-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Limit Products Per Page", 'elessi-theme'),
            "id" => "products_pr_page",
            "std" => "16",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Default Type View", 'elessi-theme'),
            "id" => "products_type_view",
            "std" => "grid",
            "type" => "select",
            "options" => array(
                "grid" => esc_html__("Grid view default", 'elessi-theme'),
                "list" => esc_html__("List view default", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Results info in top", 'elessi-theme'),
            "id" => "showing_info_top",
            "desc" => esc_html__("Note: don't using for Sidebar Off-canvas and Toggle Sidebar Classic", 'elessi-theme'),
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Change View As (Only Desktop Mode)", 'elessi-theme'),
            "id" => "enable_change_view",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Option 2 Columns", 'elessi-theme'),
            "id" => "option_2_cols",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Option 6 Columns", 'elessi-theme'),
            "id" => "option_6_cols",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Layout Style", 'elessi-theme'),
            "id" => "products_layout_style",
            "std" => "grid_row",
            "type" => "select",
            "options" => array(
                "grid-row" => esc_html__("Grid row", 'elessi-theme'),
                "masonry-isotope" => esc_html__("Masonry Isotope", 'elessi-theme')
            ),
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Isotope Layout Mode", 'elessi-theme'),
            "id" => "products_masonry_mode",
            "std" => "masonry",
            "type" => "select",
            "options" => array(
                "masonry" => esc_html__("Masonry", 'elessi-theme'),
                "fitRows" => esc_html__("Fit Rows", 'elessi-theme')
            ),
            
            'class' => 'nasa-products_layout_style nasa-products_layout_style-masonry-isotope nasa-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Pagination Layout", 'elessi-theme'),
            "id" => "pagination_style",
            "std" => 'style-2',
            "type" => "select",
            "options" => array(
                "style-2" => esc_html__("Simple", 'elessi-theme'),
                "style-1" => esc_html__("Full", 'elessi-theme'),
                "infinite" => esc_html__("Infinite - Only using for Ajax", 'elessi-theme'),
                "load-more" => esc_html__("Load More - Only using for Ajax", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Ajax Shop", 'elessi-theme'),
            "id" => "disable_ajax_product",
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "std" => 0,
            "type" => "checkbox"
        );

        $of_options[] = array(
            "name" => esc_html__("Show Title In Line", 'elessi-theme'),
            "id" => "cutting_product_name",
            "desc" => esc_html__("Only show title product on one line if it is too long.", 'elessi-theme'),
            "std" => "1",
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Top - Bottom Content Products Page", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Top - Bottom Content Products Page", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $arr_blocks = elessi_admin_get_static_blocks();

        $of_options[] = array(
            "name" => esc_html__("Category top content", 'elessi-theme'),
            "id" => "cat_header_content",
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'elessi-theme'),
            "type" => "select",
            "options" => $arr_blocks
        );
        
        $of_options[] = array(
            "name" => esc_html__("Category bottom content", 'elessi-theme'),
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'elessi-theme'),
            "id" => "cat_footer_content",
            "type" => "select",
            "options" => $arr_blocks
        );
    }
}
