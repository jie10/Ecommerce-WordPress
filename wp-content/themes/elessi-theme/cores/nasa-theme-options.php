<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * VC SETUP
 */
add_action('init', 'elessi_vc_setup');
if (!function_exists('elessi_vc_setup')) :

    function elessi_vc_setup() {
        if (!class_exists('WPBakeryVisualComposerAbstract')){
            return;
        }
        
        global $nasa_opt;

        /**
         * Row (add fullwidth)
         */
        vc_add_param('vc_row', array(
            "type" => 'checkbox',
            "heading" => esc_html__("Fullwidth ?", 'elessi-theme'),
            "param_name" => "fullwidth",
            "value" => array(
                esc_html__('Yes, Please!', 'elessi-theme') => '1'
            )
        ));
        
        /**
         * Add params from tab element
         */
        vc_add_param('vc_tta_tabs', array(
            "type" => "dropdown",
            "heading" => esc_html__("Style", 'elessi-theme'),
            "param_name" => "tabs_display_type",
            "value" => array(
                esc_html__('Classic 2D - No border', 'elessi-theme') => '2d-no-border',
                esc_html__('Classic 2D - Radius', 'elessi-theme') => '2d-radius',
                esc_html__('Classic 2D - Radius - Dash', 'elessi-theme') => '2d-radius-dashed',
                esc_html__('Classic 2D - Has BG color', 'elessi-theme') => '2d-has-bg',
                esc_html__('Classic 2D', 'elessi-theme') => '2d',
                esc_html__('Classic 3D', 'elessi-theme') => '3d',
                esc_html__('Slide', 'elessi-theme') => 'slide'
            ),
            "std" => '2d-no-border'
        ));
        
        vc_add_param('vc_tta_tabs', array(
            "type" => "colorpicker",
            "heading" => esc_html__("Tabs Background color", 'elessi-theme'),
            "param_name" => "tabs_bg_color",
            "std" => '#efefef',
            "dependency" => array(
                "element" => "tabs_display_type",
                "value" => array(
                    "2d-has-bg"
                )
            )
        ));
        
        vc_add_param('vc_tta_tabs', array(
            "type" => "colorpicker",
            "heading" => esc_html__("Tabs text color", 'elessi-theme'),
            "param_name" => "tabs_text_color",
            "std" => '',
            "dependency" => array(
                "element" => "tabs_display_type",
                "value" => array(
                    "2d-has-bg"
                )
            )
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => "dropdown",
            "heading" => esc_html__("Layout", 'elessi-theme'),
            "param_name" => "accordion_layout",
            'value' => array(
                esc_html__('Border Wrapper', 'elessi-theme') => 'has-border',
                esc_html__('Without Border Wrapper', 'elessi-theme') => 'no-border'
            ),
            'std' => 'has-border',
            "description" => esc_html__('Only use for Accordion.', 'elessi-theme'),
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => "dropdown",
            "heading" => esc_html__("Toggle Icon", 'elessi-theme'),
            "param_name" => "accordion_icon",
            'value' => array(
                esc_html__('Plus', 'elessi-theme') => 'plus',
                esc_html__('Arrow', 'elessi-theme') => 'arrow'
            ),
            'std' => 'plus',
            "description" => esc_html__('Only use for Accordion.', 'elessi-theme'),
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => 'checkbox',
            "heading" => esc_html__("Hide First Section ?", 'elessi-theme'),
            "param_name" => "accordion_hide_first",
            "value" => array(
                esc_html__('Yes, Please!', 'elessi-theme') => '1'
            )
        ));
        
        vc_add_param('vc_tta_accordion', array(
            "type" => 'checkbox',
            "heading" => esc_html__("Show Multi", 'elessi-theme'),
            "param_name" => "accordion_show_multi",
            "value" => array(
                esc_html__('Yes, Please!', 'elessi-theme') => '1'
            )
        ));
        
        /**
         * Add params from section tab element
         */
        vc_add_param('vc_tta_section', array(
            "type" => "textfield",
            "heading" => esc_html__("Add Icon NasaTheme (Using for Section of Tabs)", 'elessi-theme'),
            "param_name" => "section_nasa_icon",
            "std" => '',
            'readonly' => 1,
            'description' => '<a class="nasa-chosen-icon left" data-fill="section_nasa_icon" href="javascript:void(0);">Click Here to Add Icon NasaTheme</a><a class="nasa-remove-icon right" data-id="section_nasa_icon" href="javascript:void(0);">Remove Icon NasaTheme</a><p class="nasa-clearfix"></p>'
        ));
        
        /**
         * Add param from columns element
         */
        vc_add_param('vc_column', array(
            "type" => "dropdown",
            "heading" => esc_html__("Width full side", 'elessi-theme'),
            "param_name" => "width_side",
            'value' => array(
                esc_html__('None', 'elessi-theme') => '',
                esc_html__('Full width to left', 'elessi-theme') => 'left',
                esc_html__('Full width to right', 'elessi-theme') => 'right'
            ),
            'std' => '',
            "description" => esc_html__('Only use for Visual Composer Template.', 'elessi-theme'),
        ));
        
        /**
         * For Mobile Layout
         */
        $option_mobile = !isset($nasa_opt['enable_nasa_mobile']) || $nasa_opt['enable_nasa_mobile'] ? true : false;
        
        if ($option_mobile) {
            /**
             * Hide on mobile for Row
             */
            vc_add_param('vc_row', array(
                "type" => 'checkbox',
                "heading" => esc_html__("Ignore on Mobile", 'elessi-theme'),
                "param_name" => "hide_in_mobile",
                "value" => array(
                    esc_html__('Yes, Please!', 'elessi-theme') => '1'
                )
            ));
            
            /**
             * Hide on mobile for Mobile
             */
            vc_add_param('vc_column', array(
                "type" => 'checkbox',
                "heading" => esc_html__("Ignore on Mobile", 'elessi-theme'),
                "param_name" => "hide_in_mobile",
                "value" => array(
                    esc_html__('Yes, Please!', 'elessi-theme') => '1'
                )
            ));
        }
        
        /**
         * Custom shortcode
         */
        $param_nasa_sc_icons = array(
            "name" => esc_html__("Header Icons", 'elessi-theme'),
            "base" => "nasa_sc_icons",
            'icon' => 'icon-wpb-nasatheme',
            'description' => esc_html__("Header icons Cart | Wishlist | Compare", 'elessi-theme'),
            "category" => esc_html__('Header Builder', 'elessi-theme'),
            "params" => array(

                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show Mini Cart", 'elessi-theme'),
                    "param_name" => "show_mini_cart",
                    "value" => array(
                        esc_html__('Yes', 'elessi-theme') => 'yes',
                        esc_html__('No', 'elessi-theme') => 'no'
                    ),
                    "std" => 'yes',
                    "admin_label" => true
                ),

                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show Mini Compare", 'elessi-theme'),
                    "param_name" => "show_mini_compare",
                    "value" => array(
                        esc_html__('Yes', 'elessi-theme') => 'yes',
                        esc_html__('No', 'elessi-theme') => 'no'
                    ),
                    "std" => 'yes',
                    "admin_label" => true
                ),

                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Show Mini Wishlist", 'elessi-theme'),
                    "param_name" => "show_mini_wishlist",
                    "value" => array(
                        esc_html__('Yes', 'elessi-theme') => 'yes',
                        esc_html__('No', 'elessi-theme') => 'no'
                    ),
                    "std" => 'yes',
                    "admin_label" => true
                ),

                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Extra class name", 'elessi-theme'),
                    "param_name" => "el_class",
                    "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'elessi-theme')
                )
            )
        );
        vc_map($param_nasa_sc_icons);

        /**
         * Search form in header
         */
        $param_nasa_search = array(
            "name" => esc_html__("Header Search", 'elessi-theme'),
            "base" => "nasa_sc_search_form",
            'icon' => 'icon-wpb-nasatheme',
            'description' => esc_html__("Header search form", 'elessi-theme'),
            "category" => esc_html__('Header Builder', 'elessi-theme'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Extra class name", 'elessi-theme'),
                    "param_name" => "el_class",
                    "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'elessi-theme')
                )
            )
        );
        
        vc_map($param_nasa_search);
        if (function_exists('nasa_header_icons_sc')) {
            add_shortcode('nasa_sc_icons', 'nasa_header_icons_sc');
        }
        
        if (function_exists('nasa_header_search_sc')) {
            add_shortcode('nasa_sc_search_form', 'nasa_header_search_sc');
        }
    }

endif;

/**
 * HTML Loader
 */
if (!function_exists('elessi_loader_html')) :
    function elessi_loader_html($id_attr = null, $relative = true) {
        $id = $id_attr != null ? ' id="' . esc_attr($id_attr) . '"' : '';
        $class = $relative ? ' class="nasa-relative nasa-fullsize"' : '';
        return 
            '<div' . $id . $class . '>' .
                '<div class="nasa-loader"></div>' .
            '</div>';
    }
endif;

/**
 * Start captcha
 */
if (!function_exists('elessi_start_session')) :
    function elessi_start_session() {
        if (!session_id()) {
            session_start();
        }
    }
endif;

/**
 * Captcha for Register form
 */
add_action('init', 'elessi_register_field_captcha_img');
if (!function_exists('elessi_register_field_captcha_img')) :
    function elessi_register_field_captcha_img() {
        global $nasa_opt;
        if (!isset($nasa_opt['register_captcha']) || !$nasa_opt['register_captcha']) {
            return;
        }
        
        if (isset($_REQUEST['nasa-captcha-register']) && $_REQUEST['nasa-captcha-register'] === '1') {
            require_once ELESSI_THEME_PATH . '/cores/nasa-captcha.php';

            $captcha = new Nasa_Captcha();
            $code = $captcha->get_and_show_image();

            elessi_start_session();

            // Save code session
            $_SESSION['nasa_captcha_code_' . $_REQUEST['nasa-captcha-register']] = $code;

            die();
        }

        return;
    }
endif;

/**
 * Add field captcha for Register form
 */
add_action('woocommerce_register_form', 'elessi_register_form_field_captcha');
if (!function_exists('elessi_register_form_field_captcha')) :
    function elessi_register_form_field_captcha() {
        global $nasa_opt;
        if (!isset($nasa_opt['register_captcha']) || !$nasa_opt['register_captcha']) {
            return;
        }
        
        echo '<p class="nasa-form-row-captcha hidden-tag"></p>';
    }
endif;

/**
 * Check error Captcha
 */
add_filter('woocommerce_registration_errors', 'elessi_check_captcha_registration_errors', 10, 3);
if (!function_exists('elessi_check_captcha_registration_errors')) :
    function elessi_check_captcha_registration_errors($errors) {
        global $nasa_opt;
        
        /**
         * Disable check Captcha
         */
        if (!isset($nasa_opt['register_captcha']) || !$nasa_opt['register_captcha']) {
            return $errors;
        }
        
        /**
         * Ignore when has not nonce field value
         */
        if (!isset($_REQUEST['woocommerce-register-nonce'])) {
            return $errors;
        }

        /**
         * Init check
         */
        $input = array();

        /**
         * For Ajax form
         */
        if (isset($_REQUEST['data']) && $_REQUEST['data']) {
            foreach ($_REQUEST['data'] as $values) {
                if (isset($values['name']) && isset($values['value'])) {
                    $input[$values['name']] = $values['value'];
                }
            }
        }

        /**
         * For Default form
         */
        else {
            if (isset($_REQUEST['nasa-captcha-key'])) {
                $input['nasa-captcha-key'] = $_REQUEST['nasa-captcha-key'];
            }

            if (isset($_REQUEST['nasa-input-captcha'])) {
                $input['nasa-input-captcha'] = $_REQUEST['nasa-input-captcha'];
            }
        }
        
        /**
         * Check error Captcha
         */
        elessi_start_session();
        if (
            !isset($input['nasa-captcha-key']) ||
            !isset($input['nasa-input-captcha']) ||
            !isset($_SESSION['nasa_captcha_code_' . $input['nasa-captcha-key']]) ||
            $_SESSION['nasa_captcha_code_' . $input['nasa-captcha-key']] != strtolower($input['nasa-input-captcha'])) {
            $errors->add('nasa-captcha-register', esc_html__('Captcha Error!', 'elessi-theme'));
        }

        return $errors;
    }
endif;
