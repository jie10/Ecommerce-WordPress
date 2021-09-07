<?php
add_action('init', 'elessi_header_footer_heading');
if (!function_exists('elessi_header_footer_heading')) {
    function elessi_header_footer_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $header_blocks = elessi_admin_get_static_blocks();
        
        $of_options[] = array(
            "name" => esc_html__("Header and Footer", 'elessi-theme'),
            "target" => 'header-footer',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Header Option", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Header Option", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Layout", 'elessi-theme'),
            "id" => "header-type",
            "std" => "1",
            "type" => "images",
            "options" => array(
                '1' => ELESSI_ADMIN_DIR_URI . 'assets/images/header-1.jpg',
                '2' => ELESSI_ADMIN_DIR_URI . 'assets/images/header-2.jpg',
                '3' => ELESSI_ADMIN_DIR_URI . 'assets/images/header-3.jpg',
                '4' => ELESSI_ADMIN_DIR_URI . 'assets/images/header-4.jpg',
                '5' => ELESSI_ADMIN_DIR_URI . 'assets/images/header-5.jpg',
                'nasa-custom' => ELESSI_ADMIN_DIR_URI . 'assets/images/header-builder.gif'
            ),
            
            'class' => 'nasa-header-type-select nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Flexible - Menu Resizing (Desktop and Tablet)", 'elessi-theme'),
            "id" => "flexible_menu",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-flexible_menu'
        );
        
        /**
         * Header Builder
         */
        $header_builder = elessi_admin_get_header_builder();
        $header_options = array_merge(
            array('default' => esc_html__('Select the Header Builder', 'elessi-theme')),
            $header_builder
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Builder", 'elessi-theme'),
            "id" => "header-custom",
            "type" => "select",
            'override_numberic' => true,
            "options" => $header_options,
            'std' => '',
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-nasa-custom nasa-header-custom'
        );
        
        $option_menu = elessi_admin_get_menu_options();
        
        $of_options[] = array(
            "name" => esc_html__("Vertical Menu", 'elessi-theme'),
            "id" => "vertical_menu_selected",
            "std" => "",
            "type" => "select",
            'override_numberic' => true,
            "options" => $option_menu,
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-4'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Ordering Mobile Menu", 'elessi-theme'),
            "id" => "order_mobile_menus",
            "std" => "",
            "type" => "select",
            'override_numberic' => true,
            "options" => array(
                '' => esc_html__("Main Menu > Vertical Menu", 'elessi-theme'),
                'v-focus' => esc_html__("Vertical Menu > Main Menu", 'elessi-theme'),
            ),
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-4'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Fullwidth Main Menu", 'elessi-theme'),
            "id" => "fullwidth_main_menu",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-2 nasa-header-type-select-3 nasa-fullwidth_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Transparent Header", 'elessi-theme'),
            "id" => "header_transparent",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header_transparent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("The Block Under Header", 'elessi-theme'),
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'elessi-theme'),
            "id" => "header-block",
            "type" => "select",
            "options" => $header_blocks,
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-header-block'
        );

        $of_options[] = array(
            "name" => esc_html__("Sticky", 'elessi-theme'),
            "id" => "fixed_nav",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-fixed_nav'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Search Bar Effect", 'elessi-theme'),
            "id" => "search_effect",
            "std" => "right-to-left",
            "type" => "select",
            "options" => array(
                "rightToLeft" => esc_html__("Right To Left", 'elessi-theme'),
                "fadeInDown" => esc_html__("Fade In Down", 'elessi-theme'),
                "fadeInUp" => esc_html__("Fade In Up", 'elessi-theme'),
                "leftToRight" => esc_html__("Left To Right", 'elessi-theme'),
                "fadeIn" => esc_html__("Fade In", 'elessi-theme'),
                "noEffect" => esc_html__("No Effect", 'elessi-theme')
            ),
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-search_effect'
        );

        $of_options[] = array(
            "name" => esc_html__("Toggle Top Bar", 'elessi-theme'),
            "id" => "topbar_toggle",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag nasa-topbar_toggle nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-fixed_nav'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Default Top Bar Show", 'elessi-theme'),
            "id" => "topbar_default_show",
            "std" => 1,
            "type" => "switch",
            'class' => 'hidden-tag nasa-topbar_df-show'
        );

        $of_options[] = array(
            "name" => esc_html__("Languages Switcher - Requires WPML", 'elessi-theme'),
            "id" => "switch_lang",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Currencies Switcher - Requires WPML", 'elessi-theme'),
            "id" => "switch_currency",
            "std" => 0,
            "type" => "switch"
        );
        
        //(%symbol%) %code%
        $of_options[] = array(
            "name" => esc_html__("Format Currency", 'elessi-theme'),
            "desc" => esc_html__("Default (%symbol%) %code%. You can custom for this. Ex (%name% (%symbol%) - %code%)", 'elessi-theme'),
            "id" => "switch_currency_format",
            "std" => "",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Content", 'elessi-theme'),
            "desc" => esc_html__("Please Create Static Block and Selected here to use.", 'elessi-theme'),
            "id" => "topbar_content",
            "type" => "select",
            "options" => $header_blocks,
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-topbar_content'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Toggle Header Icons - Responsive mode", 'elessi-theme'),
            "id" => "topbar_mobile_icons_toggle",
            "std" => 0,
            "type" => "switch",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-topbar_mobile_icons_toggle'
        );

        $of_options[] = array(
            "name" => esc_html__("Header Elements", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Header Elements", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Background", 'elessi-theme'),
            "id" => "bg_color_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Text color", 'elessi-theme'),
            "id" => "text_color_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Topbar Text color hover", 'elessi-theme'),
            "id" => "text_color_hover_topbar",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Background Color Header", 'elessi-theme'),
            "id" => "bg_color_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-bg_color_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Icons", 'elessi-theme'),
            "id" => "text_color_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-text_color_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Header Icons Hover", 'elessi-theme'),
            "id" => "text_color_hover_header",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-text_color_hover_header'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Main Menu Background Color", 'elessi-theme'),
            "id" => "bg_color_main_menu",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-bg_color_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Main Menu Text Color", 'elessi-theme'),
            "id" => "text_color_main_menu",
            "std" => "",
            "type" => "color",
            'class' => 'hidden-tag nasa-header-type-child nasa-header-type-select-1 nasa-header-type-select-2 nasa-header-type-select-3 nasa-header-type-select-4 nasa-text_color_main_menu'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Footer Option", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Footer Option", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $footer_mode = NASA_ELEMENTOR_ACTIVE ? "build-in" : "builder";
        $modes = array(
            "build-in" => esc_html__("Build-in", 'elessi-theme'),
            "builder" => esc_html__("Builder", 'elessi-theme')
        );
        if (NASA_ELEMENTOR_ACTIVE && NASA_HF_BUILDER) {
            $modes["builder-e"] = esc_html__("Elementor Builder", 'elessi-theme');
        }
        
        $of_options[] = array(
            "name" => esc_html__("Mode", 'elessi-theme'),
            "id" => "footer_mode",
            "std" => $footer_mode,
            "type" => "select",
            "options" => $modes,
            'class' => 'nasa-theme-option-parent'
        );
        
        /**
         * Footer Build-in Desktop
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Layout", 'elessi-theme'),
            "id" => "footer_build_in",
            "type" => "select",
            'override_numberic' => true,
            "options" => array(
                '1' => esc_html__("Build-in Light 1", 'elessi-theme'),
                '2' => esc_html__("Build-in Light 2", 'elessi-theme'),
                '3' => esc_html__("Build-in Light 3", 'elessi-theme'),
                '4' => esc_html__("Build-in Dark", 'elessi-theme')
            ),
            'std' => '2',
            'class' => 'nasa-footer_mode nasa-footer_mode-build-in nasa-theme-option-child'
        );
        
        /**
         * Footer Build-in Mobile
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Mobile Layout", 'elessi-theme'),
            "id" => "footer_build_in_mobile",
            "type" => "select",
            'override_numberic' => true,
            "options" => array(
                '' => esc_html__("Extends from Desktop", 'elessi-theme'),
                'm-1' => esc_html__("Build-in Mobile", 'elessi-theme')
            ),
            'std' => '',
            'class' => 'nasa-footer_mode nasa-footer_mode-build-in nasa-theme-option-child'
        );
        
        /**
         * Footers Builder
         */
        $footers_options = elessi_admin_get_footer_builder();
        
        $footers_desk = array_merge(
            array('default' => esc_html__('Select the Footer Type', 'elessi-theme')),
            $footers_options
        );
        $footers_mobile = array_merge(
            array('default' => esc_html__('Extends from Desktop', 'elessi-theme')),
            $footers_options
        );
        
        /**
         * Footer Desktop
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Layout", 'elessi-theme'),
            "id" => "footer-type",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_desk,
            'std' => 'default',
            'class' => 'nasa-footer_mode nasa-footer_mode-builder nasa-theme-option-child'
        );
        
        /**
         * Footer Mobile
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Mobile Layout", 'elessi-theme'),
            "id" => "footer-mobile",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_mobile,
            'std' => 'default',
            'class' => 'nasa-footer_mode nasa-footer_mode-builder nasa-theme-option-child'
        );
        
        /**
         * Footers Elementor Builder
         */
        $footers_options = elessi_admin_get_footer_elementor();
        $footers_desk = $footers_options;
        $footers_desk['0'] = esc_html__('Select the Footer Elementor', 'elessi-theme');
        $footers_mobile = $footers_options;
        $footers_mobile['0'] = esc_html__('Extends from Desktop', 'elessi-theme');
        
        /**
         * Footer Desktop
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Layout", 'elessi-theme'),
            "id" => "footer_elm",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_desk,
            'std' => 'default',
            'class' => 'nasa-footer_mode nasa-footer_mode-builder-e nasa-theme-option-child'
        );
        
        /**
         * Footer Mobile
         */
        $of_options[] = array(
            "name" => esc_html__("Footer Mobile Layout", 'elessi-theme'),
            "id" => "footer_elm_mobile",
            "type" => "select",
            'override_numberic' => true,
            "options" => $footers_mobile,
            'std' => 'default',
            'class' => 'nasa-footer_mode nasa-footer_mode-builder-e nasa-theme-option-child'
        );
    }
}
