<?php
add_action('init', 'elessi_breadcrumb_heading');
if (!function_exists('elessi_breadcrumb_heading')) {
    function elessi_breadcrumb_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Breadcrumb", 'elessi-theme'),
            "target" => 'breadcumb',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Enable", 'elessi-theme'),
            "id" => "breadcrumb_show",
            "std" => 1,
            "type" => "switch",
            'class' => 'nasa-breadcrumb-flag-option'
        );

        $of_options[] = array(
            "name" => esc_html__("Layout", 'elessi-theme'),
            "desc" => esc_html__("Layout Single or Double rows.", 'elessi-theme'),
            "id" => "breadcrumb_row",
            "std" => "multi",
            "type" => "select",
            "options" => array(
                "multi" => esc_html__("Double Rows", 'elessi-theme'),
                "single" => esc_html__("Single Row", 'elessi-theme')
            ),
        );
        
        $of_options[] = array(
            "name" => esc_html__("Type", 'elessi-theme'),
            "desc" => esc_html__("With or Without Background.", 'elessi-theme'),
            "id" => "breadcrumb_type",
            "std" => "has-background",
            "type" => "select",
            "options" => array(
                "default" => esc_html__("Without Background - Default use Background Color", 'elessi-theme'),
                "has-background" => esc_html__("With Background", 'elessi-theme')
            ),
        );

        $of_options[] = array(
            "name" => esc_html__("Background Image", 'elessi-theme'),
            "id" => "breadcrumb_bg",
            "std" => ELESSI_ADMIN_DIR_URI . 'assets/images/breadcrumb-bg.jpg',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Background Image - Mobile Layout Mode", 'elessi-theme'),
            "id" => "breadcrumb_bg_m",
            "std" => '',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Background Parallax", 'elessi-theme'),
            "id" => "breadcrumb_bg_lax",
            "std" => 0,
            "type" => "switch"
        );

        $of_options[] = array(
            "name" => esc_html__("Background Color", 'elessi-theme'),
            "id" => "breadcrumb_bg_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Text Color", 'elessi-theme'),
            "id" => "breadcrumb_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Text Align", 'elessi-theme'),
            "id" => "breadcrumb_align",
            "std" => "text-center",
            "type" => "select",
            "options" => array(
                "text-center" => esc_html__("Center", 'elessi-theme'),
                "text-left" => esc_html__("Left", 'elessi-theme'),
                "text-right" => esc_html__("Right", 'elessi-theme')
            ),
        );

        $of_options[] = array(
            "name" => esc_html__("Height", 'elessi-theme'),
            "desc" => esc_html__("Default - 130px", 'elessi-theme'),
            "id" => "breadcrumb_height",
            "std" => "130",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Height For Mobile", 'elessi-theme'),
            "id" => "breadcrumb_height_m",
            "std" => "",
            "type" => "text"
        );
    }
}
