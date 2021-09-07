<?php
add_action('init', 'elessi_portfolio_heading');
if (!function_exists('elessi_portfolio_heading')) {
    function elessi_portfolio_heading() {
        
        if (!defined('NASA_CORE_ACTIVED') || !NASA_CORE_ACTIVED) {
            return;
        }
        
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Portfolio", 'elessi-theme'),
            "target" => 'portfolio',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Enable Portfolio", 'elessi-theme'),
            "id" => "enable_portfolio",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Page view Portfolio", 'elessi-theme'),
            "id" => "nasa-page-view-portfolio",
            "type" => "select",
            "options" => get_pages_temp_portfolio()
        );
        
        $of_options[] = array(
            "name" => esc_html__("Recent Projects", 'elessi-theme'),
            "id" => "recent_projects",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Portfolio Comments", 'elessi-theme'),
            "id" => "portfolio_comments",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Portfolio Count", 'elessi-theme'),
            "id" => "portfolio_count",
            "std" => 10,
            "type" => "text"
        );
        $of_options[] = array(
            "name" => esc_html__("Project Category", 'elessi-theme'),
            "id" => "project_byline",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array(
            "name" => esc_html__("Project Name", 'elessi-theme'),
            "id" => "project_name",
            "std" => 1,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Portfolio Columns", 'elessi-theme'),
            "id" => "portfolio_columns",
            "std" => "5-cols",
            "type" => "select",
            "options" => array(
                "5-cols" => esc_html__("5 columns", 'elessi-theme'),
                "4-cols" => esc_html__("4 columns", 'elessi-theme'),
                "3-cols" => esc_html__("3 columns", 'elessi-theme'),
                "2-cols" => esc_html__("2 columns", 'elessi-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("portfolio Lightbox", 'elessi-theme'),
            "id" => "portfolio_lightbox",
            "std" => 1,
            "type" => "switch"
        );
    }
}
