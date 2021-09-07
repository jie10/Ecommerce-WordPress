<?php

/* RTL Mode */
define('NASA_RTL', apply_filters('nasa_rtl_mode', (function_exists('is_rtl') && is_rtl())));

/* Check if WooCommerce active */
defined('NASA_WOO_ACTIVED') or define('NASA_WOO_ACTIVED', (bool) function_exists('WC'));

/* Check if Elementor active */
defined('NASA_ELEMENTOR_ACTIVE') or define('NASA_ELEMENTOR_ACTIVE', defined('ELEMENTOR_PATH') && ELEMENTOR_PATH);

/**
 * Check Header, Footers Builder support
 */
defined('NASA_HF_BUILDER') or define('NASA_HF_BUILDER', NASA_ELEMENTOR_ACTIVE && function_exists('hfe_init'));

/* Check if DOKAN active */
defined('NASA_DOKAN_ACTIVED') or define('NASA_DOKAN_ACTIVED', (bool) function_exists('dokan'));

defined('NASA_WISHLIST_ENABLE') or define('NASA_WISHLIST_ENABLE', (bool) defined('YITH_WCWL'));

$wishlist_loop = NASA_WISHLIST_ENABLE ? true : false;
$wishlist_new = false;
if (NASA_WISHLIST_ENABLE && defined('YITH_WCWL_VERSION')) {
    if (version_compare(YITH_WCWL_VERSION, '3.0', ">=")) {
        $wishlist_loop = get_option('yith_wcwl_show_on_loop') !== 'yes' ? false : true;
        $wishlist_new = true;
    }
}
define('NASA_WISHLIST_NEW_VER', $wishlist_new);
define('NASA_WISHLIST_IN_LIST', $wishlist_loop);

/* Check if nasa-core is active */
defined('NASA_CORE_ACTIVED') or define('NASA_CORE_ACTIVED', function_exists('nasa_setup'));
defined('NASA_CORE_IN_ADMIN') or define('NASA_CORE_IN_ADMIN', is_admin());

/* user info */
defined('NASA_CORE_USER_LOGGED') or define('NASA_CORE_USER_LOGGED', is_user_logged_in());

/* bundle type product */
defined('NASA_COMBO_TYPE') or define('NASA_COMBO_TYPE', 'yith_bundle');

/* Nasa theme prefix use for nasa-core */
defined('NASA_THEME_PREFIX') or define('NASA_THEME_PREFIX', 'elessi');

/* Time now */
defined('NASA_TIME_NOW') or define('NASA_TIME_NOW', time());

/**
 * $nasa_loadmore_style 
 */
$GLOBALS['nasa_loadmore_style'] = array('infinite', 'load-more');

/**
 * Cache plugin support
 */
function elessi_plugins_cache_support() {
    /**
     * Check WP Super Cache active
     */
    global $super_cache_enabled;
    $super_cache_enabled = isset($super_cache_enabled) ? $super_cache_enabled : false;
    
    $plugin_cache_support = (
        /**
         * Check WP_ROCKET active
         */
        (defined('WP_ROCKET_SLUG') && WP_ROCKET_SLUG) ||
        
        /**
         * Check W3 Total Cache active
         */
        (defined('W3TC') && W3TC) ||
            
        /**
         * Check WP Fastest Cache
         */
        class_exists('WpFastestCache') ||
            
        /**
         * Check WP Super Cache active
         */
        (defined('WP_CACHE') && WP_CACHE && $super_cache_enabled) ||
        
        /**
         * Check SG_CachePress
         */
        class_exists('SG_CachePress') ||
        
        /**
         * Check LiteSpeed Cache
         */
        class_exists('LiteSpeed_Cache') ||
            
        /**
         * Check WP Optimize Cache
         */
        class_exists('WP_Optimize') ||

        /**
         * Check AutoptimizeCache active
         */
        class_exists('autoptimizeCache')
    );
    
    return apply_filters('elessi_plugins_cache_support', $plugin_cache_support);
}

/**
 * init Theme Options - $nasa_opt
 */
add_action('nasa_set_options', 'elessi_get_options');
function elessi_get_options() {
    $options = get_theme_mods();
    
    if (!empty($options)) {
        foreach ($options as $key => $value) {
            if (is_string($value)) {
                $options[$key] = str_replace(
                    array(
                        '[site_url]', 
                        '[site_url_secure]',
                    ),
                    array(
                        site_url('', 'http'),
                        site_url('', 'https'),
                    ),
                    $value
                );
            }
        }
    }
    
    /**
     * Check Mobile Detect
     */
    $options['nasa_in_mobile'] = false;
    if (defined('NASA_IS_PHONE') && NASA_IS_PHONE && (!isset($options['enable_nasa_mobile']) || $options['enable_nasa_mobile'])) {
        /**
         * Option detect Mobile device
         */
        $options['nasa_in_mobile'] = true;
        
        /**
         * Force Disable Showing info top
         */
        $options['showing_info_top'] = false;
        
        /**
         * Force Disable Changeview
         */
        $options['enable_change_view'] = false;
        
        /**
         * Force breadcrumb single row
         */
        $options['breadcrumb_row'] = 'single';
        
        /**
         * Force Disable WOW animated
         */
        $options['disable_wow'] = true;
    }
    
    /**
     * Not support Optimize html when de-active Nasa Core
     */
    if (!NASA_CORE_ACTIVED) {
        $options['tmpl_html'] = false;
    }
    
    /**
     * Check Cache plugin active
     */
    if (!defined('NASA_PLG_CACHE_ACTIVE') && elessi_plugins_cache_support()) {
        define('NASA_PLG_CACHE_ACTIVE', true);
    }
    
    if (defined('NASA_PLG_CACHE_ACTIVE') && NASA_PLG_CACHE_ACTIVE) {
        /**
         * Disable optimized speed
         */
        $options['enable_optimized_speed'] = '0';
    }
    
    $GLOBALS['nasa_opt'] = apply_filters('nasa_theme_options', $options);
}

/**
 * Define NASA_CHECKOUT_LAYOUT ['modern', 'default']
 */
add_action('nasa_set_options', 'elessi_checkout_layout_conts');
function elessi_checkout_layout_conts() {
    global $nasa_opt;
    
    if (!defined('NASA_CHECKOUT_LAYOUT')) {
        $checkout_layout = isset($nasa_opt['checkout_layout']) && $nasa_opt['checkout_layout'] ?
        $nasa_opt['checkout_layout'] : 'default';

        define('NASA_CHECKOUT_LAYOUT', $checkout_layout);
    }
}

/**
 * @param $str
 * @return mixed
 */
function elessi_remove_protocol($str = null) {
    return $str ? str_replace(array('https://', 'http://'), '//', $str) : $str;
}

/**
 * Convert css content
 * 
 * @param type $css
 * @return type
 */
function elessi_convert_css($css) {
    $css = strip_tags($css);
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

    return $css;
}
/**
 * Darken - Lighten color hex
 * 
 * @param type $hex
 * @param type $percent
 * @return type
 */
function elessi_pattern_color($hex, $percent) {
    $hash = '';
    
    if (stristr($hex, '#')) {
        $hex = str_replace('#', '', $hex);
        $hash = '#';
    }
    
    // HEX TO RGB
    $rgb = array(
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2))
    );
    
    // CALCULATE
    for ($i = 0; $i < 3; $i++) {
        // Lighter
        if ($percent > 0) {
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
        }
        
        // Darker
        else {
            $positivePercent = $percent - ($percent * 2);
            $rgb[$i] = round($rgb[$i] * (1 - $positivePercent));
        }
        
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    
    // RBG to Hex
    $hex_new = '';
    
    for ($i = 0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        
        // Add a leading zero if necessary
        if (strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        
        // Append to the hex string
        $hex_new .= $hexDigit;
    }
    
    return $hash . $hex_new;
}

/**
 * wp-admin loading
 */
if (NASA_CORE_IN_ADMIN){
    /**
     *
     * @global type $GLOBALS['nasa_opt']
     * @name $nasa_opt 
     */
    if (!did_action('nasa_set_options')) {
        do_action('nasa_set_options');
    }
    
    require ELESSI_THEME_PATH . '/admin/theme-admin.php';
}

/**
 * Main Style and RTL Style
 */
add_action('wp_enqueue_scripts', 'elessi_enqueue_style', 998);
function elessi_enqueue_style() {
    global $nasa_opt;
    
    $themeVersion = isset($nasa_opt['css_theme_version']) && $nasa_opt['css_theme_version'] ? NASA_VERSION : null;
    
    $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
    
    /**
     * MAIN CSS
     */
    wp_enqueue_style('elessi-style', get_stylesheet_uri());
    
    /**
     * CSS ELEMENTOR
     */
    if (NASA_ELEMENTOR_ACTIVE) {
        
        /**
         * Disable Animate - Elementor
         */
        wp_deregister_style('e-animations');
        wp_dequeue_style('e-animations');
        
        wp_enqueue_style('elessi-style-elementor', ELESSI_THEME_URI . '/style-elementor.css', array('elessi-style'), $themeVersion);
        
        if ($inMobile && isset($_REQUEST['elementor-preview']) && $_REQUEST['elementor-preview']) {
            wp_enqueue_style('elessi-style-large', ELESSI_THEME_URI . '/assets/css/style-large.css', array('elessi-style'), $themeVersion);
        }
    }
    
    if (!$inMobile) {
        /**
         * CSS Animate
         */
        wp_enqueue_style('e-animations', ELESSI_THEME_URI . '/assets/css/animate.min.css', array('elessi-style'), $themeVersion);
        
        /**
         * Style Large
         */
        wp_enqueue_style('elessi-style-large', ELESSI_THEME_URI . '/assets/css/style-large.css', array('elessi-style'), $themeVersion);
    }
    
    /**
     * RTL CSS
     */
    if (NASA_RTL) {
        wp_enqueue_style('elessi-style-rtl', ELESSI_THEME_URI . '/style-rtl.css', array('elessi-style'), $themeVersion);
    }
    
    /**
     * WPBakery Frontend Editor
     */
    if (isset($_REQUEST['vc_editable']) && 'true' == $_REQUEST['vc_editable']) {
        wp_enqueue_style('elessi-wpbakery-frontend-editor', ELESSI_THEME_URI . '/wpbakery-frontend-editor.css', array('elessi-style'), $themeVersion);
    }
    
    /**
     * Compatible with Yith WC Product Bundle plugin
     */
    if (defined('YITH_WCPB')) {
        wp_enqueue_style('elessi-style-yith_bundle', ELESSI_THEME_URI . '/assets/css/style-yith_bundle.css', array('elessi-style'), $themeVersion);
    }
    
    /**
     * Posts
     */
    if (elessi_check_blog_page()) {
        wp_enqueue_style('elessi-style-posts', ELESSI_THEME_URI . '/assets/css/style-posts.css', array('elessi-style'), $themeVersion);
    }
    
    /**
     * Store page and not mobile
     */
    if (NASA_WOO_ACTIVED) {
        
        /**
         * Dokan
         */
        if (NASA_DOKAN_ACTIVED) {
            wp_enqueue_style('elessi-style-dokan-store', ELESSI_THEME_URI . '/assets/css/style-dokan-store.css', array('elessi-style'), $themeVersion);
        }
        
        /**
         * Enqueue store CSS
         */
        if (is_shop() || is_product_taxonomy()) {
            if (!$inMobile) {
                wp_enqueue_style('elessi-style-products-list', ELESSI_THEME_URI . '/assets/css/style-products-list.css', array('elessi-style'), $themeVersion);
            }
            
            wp_enqueue_style('elessi-style-archive-products', ELESSI_THEME_URI . '/assets/css/style-archive-products.css', array('elessi-style'), $themeVersion);
        }
        
        /**
         * Enqueue Single Product CSS
         */
        if (is_product()) {
            wp_enqueue_style('elessi-style-signle-product', ELESSI_THEME_URI . '/assets/css/style-single-product.css', array('elessi-style'), $themeVersion);
        }
        
        /**
         * Shopping Cart - Checkout - Thank you pages
         */
        if (is_checkout() || is_cart() || (NASA_CORE_USER_LOGGED && is_account_page())) {
            wp_enqueue_style('elessi-style-woo-pages', ELESSI_THEME_URI . '/assets/css/style-woo-pages.css', array('elessi-style'), $themeVersion);
        }
        
        /**
         * Css Off Canvas
         */
        if (isset($nasa_opt['css_canvas']) && $nasa_opt['css_canvas'] == 'sync') {
            wp_enqueue_style('elessi-style-off-canvas', ELESSI_THEME_URI . '/assets/css/style-off-canvas.css', array('elessi-style'), $themeVersion);
        }
    }
}

/**
 * Preload Fonts Icons
 */
add_action('wp_head', 'elessi_preload_fonts_icon', 2);
function elessi_preload_fonts_icon() {
    global $nasa_opt;
    if (isset($nasa_opt['preload_font_icons']) && !$nasa_opt['preload_font_icons']) {
        return;
    }
    
    $href = elessi_remove_protocol(ELESSI_THEME_URI . '/assets');
    if (!isset($nasa_opt['minify_font_icons']) || $nasa_opt['minify_font_icons']) {
        $href .= '/minify-font-icons';
    }
    
    echo '<link rel="preload" href="' . $href . '/font-nasa-icons/nasa-font.woff" as="font" type="font/woff" crossorigin />';
    echo '<link rel="preload" href="' . $href . '/font-pe-icon-7-stroke/Pe-icon-7-stroke.woff" as="font" type="font/woff" crossorigin />';
    echo '<link rel="preload" href="' . $href . '/font-awesome-4.7.0/fontawesome-webfont.woff2" as="font" type="font/woff2" crossorigin />';
}

/**
 * Font Nasa Icons
 * Font Awesome
 * Font Pe-icon-7-stroke
 */
add_action('wp_enqueue_scripts', 'elessi_add_fonts_style');
function elessi_add_fonts_style() {
    global $nasa_opt;
    
    /**
     * Minify
     * Include: Font Nasa Icons, Font Awesome, Font Pe-icon-7-stroke
     */
    if (!isset($nasa_opt['minify_font_icons']) || $nasa_opt['minify_font_icons']) {
        wp_enqueue_style('elessi-fonts-icons', ELESSI_THEME_URI . '/assets/minify-font-icons/fonts.min.css');
    }
    
    /**
     * No Minify
     */
    else {
        /**
         * Add Nasa Font
         */
        wp_enqueue_style('elessi-fonts-icons', ELESSI_THEME_URI . '/assets/font-nasa/nasa-font.css');

        /**
         * Add FontAwesome 4.7.0
         */
        wp_enqueue_style('elessi-font-awesome-style', ELESSI_THEME_URI . '/assets/font-awesome-4.7.0/css/font-awesome.min.css', array('elessi-fonts-icons'));

        /**
         * Add Font Pe7s
         */
        wp_enqueue_style('elessi-font-pe7s-style', ELESSI_THEME_URI . '/assets/font-pe-icon-7-stroke/css/pe-icon-7-stroke.css', array('elessi-fonts-icons'));
    }

    /**
     * Add Font Awesome 5.0.13
     */
    if (isset($nasa_opt['include_font_awesome_new']) && $nasa_opt['include_font_awesome_new']) {
        wp_enqueue_style('elessi-font-awesome-5-free-style', ELESSI_THEME_URI . '/assets/font-awesome-5.0.13/css/fontawesome-all.min.css', array('elessi-fonts-icons'));
    }
}

/**
 * enqueue scripts
 */
add_action('wp_enqueue_scripts', 'elessi_enqueue_scripts', 998);
function elessi_enqueue_scripts() {
    global $nasa_opt;
    
    $themeVersion = isset($nasa_opt['js_theme_version']) && $nasa_opt['js_theme_version'] ? NASA_VERSION : null;
    
    $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
    
    wp_enqueue_script('jquery-cookie', ELESSI_THEME_URI . '/assets/js/min/jquery.cookie.min.js', array('jquery'), $themeVersion, true);
    
    /**
     * magnific popup
     */
    if (!wp_script_is('jquery-magnific-popup')) {
        wp_enqueue_script('jquery-magnific-popup', ELESSI_THEME_URI . '/assets/js/min/jquery.magnific-popup.js', array('jquery'), $themeVersion, true);
    }
    
    /**
     * Wow js
     */
    if (!isset($nasa_opt['disable_wow']) || !$nasa_opt['disable_wow']) {
        wp_enqueue_script('wow', ELESSI_THEME_URI . '/assets/js/min/wow.min.js', array('jquery'), $themeVersion, true);
    }
    
    /**
     * Live search Products
     */
    $enable_live_search = isset($nasa_opt['enable_live_search']) ? $nasa_opt['enable_live_search'] : true;
    if ($enable_live_search && NASA_WOO_ACTIVED) {
        wp_enqueue_script('nasa-typeahead-js', ELESSI_THEME_URI . '/assets/js/min/typeahead.bundle.min.js', array('jquery'), $themeVersion, true);
        wp_enqueue_script('nasa-handlebars', ELESSI_THEME_URI . '/assets/js/min/handlebars.min.js', array('jquery'), $themeVersion, true);
        
        $search_options = array(
            'template' =>
                '<div class="item-search">' .
                    '<a href="{{url}}" class="nasa-link-item-search" title="{{title}}">' .
                        '{{{image}}}' .
                        '<div class="nasa-item-title-search rtl-right rtl-text-right">' .
                            '<p class="nasa-title-item">{{title}}</p>' .
                            '<div class="price text-left rtl-text-right">{{{price}}}</div>' .
                        '</div>' .
                    '</a>' .
                '</div>',
            
            'view_all' => '<div class="hidden-tag nasa-search-all-wrap"><a href="javascript:void(0);" class="nasa-search-all button">' . esc_html__('View All', 'elessi-theme') . '</a></div>',
            
            'empty_result' => esc_html__('Sorry. No results match your search.', 'elessi-theme'),
            
            'limit' => (isset($nasa_opt['limit_results_search']) && (int) $nasa_opt['limit_results_search'] > 0) ? (int) $nasa_opt['limit_results_search'] : 5,
            
            'url' => apply_filters('nasa_live_search_url', WC_AJAX::get_endpoint('nasa_search_products'))
        );

        $search_js_inline = 'var search_options=' . json_encode($search_options) . ';';
        wp_add_inline_script('nasa-typeahead-js', $search_js_inline, 'before');
    }
    
    /**
     * Theme js
     */
    wp_enqueue_script('elessi-functions-js', ELESSI_THEME_URI . '/assets/js/min/functions.min.js', array('jquery'), $themeVersion, true);
    wp_enqueue_script('elessi-js', ELESSI_THEME_URI . '/assets/js/min/main.min.js', array('jquery'), $themeVersion, true);
    
    if (!$inMobile) {
        wp_enqueue_script('elessi-js-large', ELESSI_THEME_URI . '/assets/js/min/js-large.min.js', array('jquery'), $themeVersion, true);
    }
    
    /**
     * Define ajax options
     */
    if (!defined('NASA_AJAX_OPTIONS')) {
        define('NASA_AJAX_OPTIONS', true);
        
        $ajax_params_options = array(
            'ajax_url' => esc_url(admin_url('admin-ajax.php'))
        );

        if (NASA_WOO_ACTIVED) {
            $ajax_params_options['wc_ajax_url'] = WC_AJAX::get_endpoint('%%endpoint%%');
        }
        
        $ajax_params = 'var nasa_ajax_params=' . json_encode($ajax_params_options) . ';';
        wp_add_inline_script('elessi-functions-js', $ajax_params, 'before');
    }
    
    /**
     * Enqueue store ajax, single product js, quickview
     */
    if (NASA_WOO_ACTIVED) {
        /**
         * For Quick view Product
         */
        if ((!isset($nasa_opt['disable-quickview']) || !$nasa_opt['disable-quickview'])) {
            wp_enqueue_script('wc-add-to-cart-variation');
            wp_enqueue_script('nasa-quickview', ELESSI_THEME_URI . '/assets/js/min/nasa-quickview.min.js', array('jquery'), $themeVersion, true);

            $params_variations = array(
                'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
                'i18n_no_matching_variations_text' => esc_attr__('Sorry, no products matched your selection. Please choose a different combination.', 'elessi-theme'),
                'i18n_make_a_selection_text' => esc_attr__('Please select some product options before adding this product to your cart.', 'elessi-theme'),
                'i18n_unavailable_text' => esc_attr__('Sorry, this product is unavailable. Please choose a different combination.', 'elessi-theme')
            );

            wp_add_inline_script('nasa-quickview', 'var nasa_params_quickview=' . json_encode($params_variations) . ';', 'before');
        }
        
        /**
         * Shopping Cart - Checkout - Thank you pages
         */
        if (is_checkout() || is_cart() || (NASA_CORE_USER_LOGGED && is_account_page())) {
            wp_enqueue_script('nasa-woo-pages', ELESSI_THEME_URI . '/assets/js/min/woo-pages.min.js', array('jquery'), $themeVersion, true);
        }
        
        /**
         * Enqueue store ajax js
         */
        if (is_shop() || is_product_taxonomy()) {
            wp_enqueue_script('elessi-store-ajax', ELESSI_THEME_URI . '/assets/js/min/store-ajax.min.js', array('jquery'), $themeVersion, true);
        }
        
        /**
         * Enqueue Easy zoom js - single product js
         */
        if (is_product()) {
            if (!$inMobile) {
                wp_enqueue_script('jquery-easyzoom', ELESSI_THEME_URI . '/assets/js/min/jquery.easyzoom.min.js', array('jquery'), $themeVersion, true);
            }
            
            wp_enqueue_script('elessi-single-product', ELESSI_THEME_URI . '/assets/js/min/single-product.min.js', array('jquery'), $themeVersion, true);
        }
    }
    
    /**
     * Add css comment reply
     */
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    /**
     * Dokan
     */
    if (NASA_DOKAN_ACTIVED) {
        if (!NASA_CORE_USER_LOGGED) {
            dokan()->scripts->load_form_validate_script();
            wp_enqueue_script('dokan-form-validate');
        }
        
        wp_enqueue_script('elessi-dokan-store', ELESSI_THEME_URI . '/assets/js/min/dokan-store.min.js', array('jquery'), $themeVersion, true);
    }
}

/**
 * Dequeue scripts and styles
 */
add_action('wp_enqueue_scripts', 'elessi_dequeue_scripts', 9999);
function elessi_dequeue_scripts() {
    global $nasa_opt;
    
    /**
     * Ignore css
     */
    if (NASA_WOO_ACTIVED && !NASA_CORE_IN_ADMIN) {
        wp_deregister_style('woocommerce-layout');
        wp_deregister_style('woocommerce-smallscreen');
        wp_deregister_style('woocommerce-general');
    }
    
    /**
     * Dequeue vc_woocommerce-add-to-cart
     */
    if (class_exists('Vc_Manager')) {
        wp_deregister_script('vc_woocommerce-add-to-cart-js');
        wp_dequeue_script('vc_woocommerce-add-to-cart-js');
    }
    
    /**
     * Dequeue contact-form-7 css
     */
    if (function_exists('wpcf7_style_is') && wpcf7_style_is()) {
        wp_dequeue_style('contact-form-7');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Compare colorbox css
     */
    if (class_exists('YITH_Woocompare_Frontend') && (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare'])) {
        wp_dequeue_style('jquery-colorbox');
        wp_dequeue_script('jquery-colorbox');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Wishlist css
     */
    if (NASA_WISHLIST_ENABLE && !defined('YITH_WCWL_PREMIUM')) {
        wp_deregister_style('jquery-selectBox');
        wp_deregister_style('yith-wcwl-font-awesome');
        wp_deregister_style('yith-wcwl-font-awesome-ie7');
        wp_deregister_style('yith-wcwl-main');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Bundles css
     */
    if (defined('YITH_WCPB')) {
        wp_deregister_style('yith_wcpb_bundle_frontend_style');
    }
    
    /**
     * WPC Product Bundles for WooCommerce Plugin
     */
    if (function_exists('WPCleverWoosb') && !is_product()) {
        wp_deregister_style('woosb-frontend');
        wp_deregister_script('woosb-frontend');
    }
    
    /**
     * Dequeue Css files from NasaTheme Options
     */
    if (!NASA_CORE_IN_ADMIN && !empty($nasa_opt['css_files'])) {
        foreach ($nasa_opt['css_files'] as $handle => $val) {
            if ($val == 1) {
                continue;
            }
            
            /**
             * Continue if Css Preview Elementor
             */
            if (
                isset($_REQUEST['elementor-preview']) &&
                $_REQUEST['elementor-preview'] &&
                in_array($handle, array('elementor-icons'))
            ) {
                continue;
            }
            
            /**
             * Continue if Css Preview WPBakery
             */
            if (
                isset($_REQUEST['vc_editable']) &&
                $_REQUEST['vc_editable'] == 'true' &&
                in_array($handle, array('js_composer_front', 'vc_animate-css'))
            ) {
                continue;
            }
            
            /**
             * Deregister and Dequeue CSS file
             */
            wp_deregister_style($handle);
            wp_dequeue_style($handle);
        }
    }
}

/**
 * List CSS files Call
 * @return type
 */
function elessi_get_list_css_files_call() {
    $list_css = array(
        'e-animations' => esc_html__("Theme Animation", 'elessi-theme'),
        'wp-block-library' => esc_html__("WordPress Block Style", 'elessi-theme')
    );

    /**
     * WooCommerce
     */
    if (NASA_WOO_ACTIVED) {
        $list_css['wc-block-style'] = esc_html__("WooCommerce Block Style", 'elessi-theme');
        $list_css['wc-blocks-vendors-style'] = esc_html__("WooCommerce Blocks Vendors Style", 'elessi-theme');
        $list_css['wc-blocks-style'] = esc_html__("WooCommerce Blocks Style", 'elessi-theme');
    }

    /**
     * Elementor active
     */
    if (NASA_ELEMENTOR_ACTIVE) {
        $list_css['elementor-icons'] = esc_html__("Elementor Icons", 'elessi-theme');
        // $list_css['e-animations'] = esc_html__("Elementor Animate", 'elessi-theme');
    }

    /**
     * WPBakery active
     */
    if (class_exists('Vc_Manager')) {
        $list_css['js_composer_front'] = esc_html__("WPBakery Front-End", 'elessi-theme');
        $list_css['vc_animate-css'] = esc_html__("WPBakery Animate", 'elessi-theme');
    }

    /**
     * Back in Stock Notifier
     */
    if (class_exists('CWG_Instock_Notifier')) {
        $list_css['cwginstock_frontend_css'] = esc_html__("Back In Stock Notifier Front-End", 'elessi-theme');
        $list_css['cwginstock_bootstrap'] = esc_html__("Back In Stock Notifier Bootstrap", 'elessi-theme');
    }
    
    return apply_filters('nasa_list_files_css_called', $list_css);
}

/**
 * Default Widgets Area
 */
add_action('widgets_init', 'elessi_widgets_sidebars_init');
function elessi_widgets_sidebars_init() {
    // Sidebar - Blog
    register_sidebar(array(
        'name' => esc_html__('Blog Sidebar', 'elessi-theme'),
        'id' => 'blog-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
        'after_widget'  => '</div>'
    ));
    
    // Sidebar - Shop
    register_sidebar(array(
        'name' => esc_html__('Shop Sidebar', 'elessi-theme'),
        'id' => 'shop-sidebar',
        'before_widget' => '<div id="%1$s" class="widget nasa-widget-store %2$s">',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
        'after_widget'  => '</div>'
    ));
    
    // Sidebar Single Product
    register_sidebar(array(
        'name' => esc_html__('Product Sidebar', 'elessi-theme'),
        'id' => 'product-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
        'after_widget'  => '</div>'
    ));
    
    // Footer Light 1
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.1 )', 'elessi-theme'),
        'id' => 'footer-light-1-1',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.2 )', 'elessi-theme'),
        'id' => 'footer-light-1-2',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.3 )', 'elessi-theme'),
        'id' => 'footer-light-1-3',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.4 )', 'elessi-theme'),
        'id' => 'footer-light-1-4',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.5 )', 'elessi-theme'),
        'id' => 'footer-light-1-5',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 1 ( No.6 )', 'elessi-theme'),
        'id' => 'footer-light-1-6',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    // Footer Light 2
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.1 )', 'elessi-theme'),
        'id' => 'footer-light-2-1',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.2 )', 'elessi-theme'),
        'id' => 'footer-light-2-2',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.3 )', 'elessi-theme'),
        'id' => 'footer-light-2-3',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.4 )', 'elessi-theme'),
        'id' => 'footer-light-2-4',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.5 )', 'elessi-theme'),
        'id' => 'footer-light-2-5',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.6 )', 'elessi-theme'),
        'id' => 'footer-light-2-6',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 2 ( No.7 )', 'elessi-theme'),
        'id' => 'footer-light-2-7',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    // Footer Light 3
    register_sidebar(array(
        'name' => esc_html__('Footer Light 3 ( No.1 )', 'elessi-theme'),
        'id' => 'footer-light-3-1',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Light 3 ( No.2 )', 'elessi-theme'),
        'id' => 'footer-light-3-2',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    // Footer Dark
    register_sidebar(array(
        'name' => esc_html__('Footer Dark ( No.1 )', 'elessi-theme'),
        'id' => 'footer-dark-1-1',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    register_sidebar(array(
        'name' => esc_html__('Footer Dark ( No.2 )', 'elessi-theme'),
        'id' => 'footer-dark-1-2',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
    
    // Footer Mobile
    register_sidebar(array(
        'name' => esc_html__('Footer Mobile', 'elessi-theme'),
        'id' => 'footer-mobile',
        'before_widget' => '',
        'before_title'  => '',
        'after_title'   => '',
        'after_widget'  => ''
    ));
}
