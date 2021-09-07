<?php
add_action('init', 'elessi_general_heading');
if (!function_exists('elessi_general_heading')) {
    function elessi_general_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("General", 'elessi-theme'),
            "target" => 'general',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Site Layout", 'elessi-theme'),
            "id" => "site_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                "wide" => esc_html__("Wide", 'elessi-theme'),
                "boxed" => esc_html__("Boxed", 'elessi-theme')
            ),
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Add more width site (px)", 'elessi-theme'),
            "desc" => esc_html__("The max-width of your site will be INPUT + 1200 (pixel).", 'elessi-theme'),
            "id" => "plus_wide_width",
            "std" => "",
            "type" => "text"
        );

        $of_options[] = array(
            "name" => esc_html__("Site Background Color - Boxed Layout", 'elessi-theme'),
            "id" => "site_bg_color",
            "std" => "#eee",
            "type" => "color",
            'class' => 'nasa-site_layout nasa-site_layout-boxed nasa-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Site Background Image - Boxed Layout", 'elessi-theme'),
            "id" => "site_bg_image",
            "std" => ELESSI_THEME_URI . "/assets/images/bkgd1.jpg",
            "type" => "media",
            'class' => 'nasa-site_layout nasa-site_layout-boxed nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Dark Version", 'elessi-theme'),
            "id" => "site_bg_dark",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Login/Register Menu in Topbar", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "hide_tini_menu_acc",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Login/Register by Ajax form", 'elessi-theme'),
            "id" => "login_ajax",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Position Account Icon", 'elessi-theme'),
            "id" => "acc_pos",
            "std" => "top",
            "type" => "select",
            "options" => array(
                "top" => esc_html__("In Topbar - Header", 'elessi-theme'),
                "group" => esc_html__("In Group Icons - Header", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Account On Main Screen - Mobile Layout", 'elessi-theme'),
            "id" => "main_screen_acc_mobile",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Captcha For Register Form", 'elessi-theme'),
            "id" => "register_captcha",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Mobile Menu Layout", 'elessi-theme'),
            "id" => "mobile_menu_layout",
            "std" => "light-new",
            "type" => "select",
            "options" => array(
                "light-new" => esc_html__("Light - Default", 'elessi-theme'),
                "light" => esc_html__("Light - 2", 'elessi-theme'),
                "dark" => esc_html__("Dark", 'elessi-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Disable Transition Loading", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "disable_wow",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Delay Overlay (ms)", 'elessi-theme'),
            "id" => "delay_overlay",
            "std" => "100",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Effect Before Load Site", 'elessi-theme'),
            "id" => "effect_before_load",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Toggle Widgets Content", 'elessi-theme'),
            "id" => "toggle_widgets",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Include Theme Version when call css files", 'elessi-theme'),
            "id" => "css_theme_version",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Include Theme Version when call Main js", 'elessi-theme'),
            "id" => "js_theme_version",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Refill - Contact Form 7", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "disable_wpcf7_refill",
            "std" => 0,
            "type" => "checkbox"
        );
        
        // The block editor from managing widgets
        global $wp_version;
        if (isset($wp_version) && version_compare($wp_version, '5.8', ">=")) {
            $of_options[] = array(
                "name" => esc_html__("The block editor from managing widgets", 'elessi-theme'),
                "id" => "block_editor_widgets",
                "std" => 0,
                "type" => "switch"
            );
        }
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Options", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("GDPR Options", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Notice", 'elessi-theme'),
            "id" => "nasa_gdpr_notice",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Policies Link", 'elessi-theme'),
            "id" => "nasa_gdpr_policies",
            "std" => "https://policies.google.com",
            "type" => "text"
        );
        
        $list_css = elessi_get_list_css_files_call();
        if (!empty($list_css)) {
            $actived = array();
            foreach ($list_css as $key => $value) {
                $actived[$key] = 1;
            }
            
            $of_options[] = array(
                "name" => esc_html__("CSS Files Manager", 'elessi-theme'),
                "std" => "<h4>" . esc_html__("CSS Files Manager", 'elessi-theme') . "</h4>",
                "type" => "info"
            );

            $of_options[] = array(
                "name" => esc_html__("List Files CSS Called", 'elessi-theme'),
                "desc" => esc_html__("You could uncheck if you don't want your site call it.", 'elessi-theme'),
                "id" => "css_files",
                "std" => $actived,
                "type" => "multicheck",
                "options" => $list_css,
            );
        }
    }
}
