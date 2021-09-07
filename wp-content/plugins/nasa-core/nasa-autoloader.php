<?php
/**
 * Auto load includes files function
 */
function nasa_includes_files($files = array(), $args = array()) {
    if (!empty($files)) {
        if (!empty($args)) {
            extract($args);
        }
        
        foreach ($files as $file) {
            require $file;
        }
    }
}

/**
 * Include Layout
 * 
 * @param type $path
 * @param type $nasa_args
 */
function nasa_template($path = '', $nasa_args = array()) {
    /**
     * Check file template in child theme
     */
    $file = NASA_THEME_CHILD_PATH . '/nasa-core/' . $path;
    if (!is_file($file)) {
        $file = NASA_CORE_LAYOUTS . $path;
    }
    
    if (is_file($file)) {
        /**
         * Extract variants
         */
        if (!empty($nasa_args)) {
            extract($nasa_args);
        }

        /**
         * Call $nasa_opt
         */
        if (!isset($nasa_opt)) {
            global $nasa_opt;
        }

        /**
         * Include file
         */
        include $file;
    }
    
    /**
     * Clear $nasa_args
     */
    unset($nasa_args);
}

/**
 * @param $str
 * @return mixed
 */
function nasa_remove_protocol($str = null) {
    return $str ? str_replace(array('https://', 'http://'), '//', $str) : $str;
}

/**
 * Abstract files
 */
nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'abstracts/nasa_*.php'));

/**
 * Only Back-end
 */
if (NASA_CORE_IN_ADMIN) {
    nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'admin/incls/nasa_*.php'));
}

/**
 * Mobile Detect
 */
require NASA_CORE_PLUGIN_PATH . 'nasa_mobile_detect.php';

/**
 * Includes Short-codes
 */
nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'includes/shortcodes/nasa_*.php'));

/**
 * After setup theme
 */
add_action('after_setup_theme', 'nasa_setup');
function nasa_setup() {
    /* Check if WooCommerce active */
    defined('NASA_WOO_ACTIVED') or define('NASA_WOO_ACTIVED', (bool) function_exists('WC'));

    /* Check if Elementor active */
    defined('NASA_ELEMENTOR_ACTIVE') or define('NASA_ELEMENTOR_ACTIVE', defined('ELEMENTOR_PATH') && ELEMENTOR_PATH);

    /* Check Header, Footers Builder support */
    defined('NASA_HF_BUILDER') or define('NASA_HF_BUILDER', NASA_ELEMENTOR_ACTIVE && function_exists('hfe_init'));

    /**
     * Check Nasa Theme Active
     */
    define('NASA_THEME_ACTIVE', function_exists('elessi_setup'));
    
    /**
     * Set Theme Options
     */
    if (NASA_THEME_ACTIVE && !did_action('nasa_set_options')) {
        do_action('nasa_set_options');
    }

    /**
     * When deactive WPBakery
     */
    if (!class_exists('Vc_Manager')) {
        nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'includes/shortcodes_vc/nasa_*.php'));
    }

    /**
     * Includes shortcode and custom
     */
    nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'includes/incls/nasa_*.php'));

    /**
     * Include custom post-type
     */
    nasa_includes_files(glob(NASA_CORE_PLUGIN_PATH . 'post_type/incls/nasa_*.php'));
}

/**
 * Main Style and RTL Style
 */
add_action('wp_enqueue_scripts', 'nasa_enqueue_styles_libs', 999);
function nasa_enqueue_styles_libs() {
    global $nasa_opt;
    
    $core_version = isset($nasa_opt['css_theme_version']) && $nasa_opt['css_theme_version'] && defined('NASA_VERSION') ? NASA_VERSION : null;
    
    /**
     * Nasa Shortcodes WooCommerce
     */
    if (NASA_WOO_ACTIVED) {
        wp_enqueue_style('nasa-sc-woo', NASA_CORE_PLUGIN_URL . 'assets/css/nasa-sc-woo.css', array(), $core_version);
    }
    
    /**
     * Nasa Shortcodes
     */
    wp_enqueue_style('nasa-sc', NASA_CORE_PLUGIN_URL . 'assets/css/nasa-sc.css', array(), $core_version);
}

/**
 * Scripts nasa-core
 */
add_action('wp_enqueue_scripts', 'nasa_core_scripts_libs', 11);
function nasa_core_scripts_libs() {
    global $nasa_opt;
    
    $core_version = isset($nasa_opt['js_theme_version']) && $nasa_opt['js_theme_version'] && defined('NASA_VERSION') ? NASA_VERSION : null;
    
    /**
     * Cookie
     */
    if (!wp_script_is('jquery-cookie')) {
        wp_enqueue_script('jquery-cookie', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.cookie.min.js', array('jquery'), $core_version, true);
    }
    
    /**
     * Magnific popup
     */
    if (!wp_script_is('jquery-magnific-popup')) {
        wp_enqueue_script('jquery-magnific-popup', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.magnific-popup.min.js', array('jquery'), $core_version, true);
    }
    
    /**
     * Countdown
     */
    if (!wp_script_is('countdown')) {
        wp_enqueue_script('countdown', NASA_CORE_PLUGIN_URL . 'assets/js/min/countdown.min.js', array('jquery'), $core_version, true);
        
        wp_localize_script(
            'countdown', 'nasa_countdown_l10n',
            array(
                'days'      => esc_html__('Days', 'nasa-core'),
                'months'    => esc_html__('Months', 'nasa-core'),
                'weeks'     => esc_html__('Weeks', 'nasa-core'),
                'years'     => esc_html__('Years', 'nasa-core'),
                'hours'     => esc_html__('Hours', 'nasa-core'),
                'minutes'   => esc_html__('Mins', 'nasa-core'),
                'seconds'   => esc_html__('Secs', 'nasa-core'),
                'day'       => esc_html__('Day', 'nasa-core'),
                'month'     => esc_html__('Month', 'nasa-core'),
                'week'      => esc_html__('Week', 'nasa-core'),
                'year'      => esc_html__('Year', 'nasa-core'),
                'hour'      => esc_html__('Hour', 'nasa-core'),
                'minute'    => esc_html__('Min', 'nasa-core'),
                'second'    => esc_html__('Sec', 'nasa-core')
            )
        );
    }
    
    /**
     * Slick slider
     */
    if (!wp_script_is('jquery-slick')) {
        wp_enqueue_script('jquery-slick', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.slick.min.js', array('jquery'), $core_version, true);
    }
}

/**
 * Masonry isotope Archive Product
 */
add_action('nasa_before_archive_products', 'nasa_masonry_isotope_archive_product');
function nasa_masonry_isotope_archive_product() {
    global $nasa_opt;
    
    if (isset($nasa_opt['products_layout_style']) && $nasa_opt['products_layout_style'] == 'masonry-isotope') {
        $core_version = isset($nasa_opt['js_theme_version']) && $nasa_opt['js_theme_version'] && defined('NASA_VERSION') ? NASA_VERSION : null;
        
        /**
         * Masonry isotope
         */
        if (!wp_script_is('jquery-masonry-isotope')) {
            wp_enqueue_script('jquery-masonry-isotope', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.masonry-isotope.min.js', array('jquery'), $core_version, true);
        }
    }
}

/**
 * Masonry isotope Blog
 */
add_action('nasa_before_archive_blogs', 'nasa_masonry_isotope_archive_blog');
function nasa_masonry_isotope_archive_blog() {
    global $nasa_opt;
    
    if (!isset($nasa_opt['blog_type']) || $nasa_opt['blog_type'] == 'masonry-isotope') {
        $core_version = isset($nasa_opt['js_theme_version']) && $nasa_opt['js_theme_version'] && defined('NASA_VERSION') ? NASA_VERSION : null;
        
        /**
         * Masonry isotope
         */
        if (!wp_script_is('jquery-masonry-isotope')) {
            wp_enqueue_script('jquery-masonry-isotope', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.masonry-isotope.min.js', array('jquery'), $core_version, true);
        }
    }
}
    
/**
 * Script nasa-core
 */
add_action('wp_enqueue_scripts', 'nasa_core_scripts_ready', 999);
function nasa_core_scripts_ready() {
    global $nasa_opt;
    
    $core_version = isset($nasa_opt['js_theme_version']) && $nasa_opt['js_theme_version'] && defined('NASA_VERSION') ? NASA_VERSION : null;
    
    wp_enqueue_script('nasa-core-functions-js', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa.functions.min.js', array('jquery'), $core_version, true);
    wp_enqueue_script('nasa-core-js', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa.script.min.js', array('jquery'), $core_version, true);
    
    /**
     * Enqueue single product js
     */
    if (NASA_WOO_ACTIVED && is_product()) {
        wp_enqueue_script('nasa-single-product', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa-single-product.min.js', array('jquery'), $core_version, true);
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
        wp_add_inline_script('nasa-core-functions-js', $ajax_params, 'before');
    }
}

/**
 * Add class woo actived for body
 * Add class nasa-core actived for body
 */
add_filter('body_class', 'nasa_add_body_classes');
function nasa_add_body_classes($classes) {
    /**
     * Add class nasa-woo-actived
     */
    if (NASA_WOO_ACTIVED && !in_array('nasa-woo-actived', $classes)) {
        $classes[] = 'nasa-woo-actived';
    }
    
    /**
     * Add class nasa-core-actived
     */
    $classes[] = 'nasa-core-actived';
    
    return $classes;
}

/**
 * Page Coming Soon
 */
add_action('init', 'nasa_offline_site');
function nasa_offline_site() {
    global $nasa_opt;
    
    /**
     * Check online site
     */
    if (!isset($nasa_opt['site_offline']) || !$nasa_opt['site_offline']) {
        return;
    }
    
    /**
     * Check is admin or logged in
     */
    if (NASA_CORE_IN_ADMIN || NASA_CORE_USER_LOGGED) {
        return;
    }
    
    /**
     * Check time
     */
    $time = false;
    if (isset($nasa_opt['coming_soon_time']) && $nasa_opt['coming_soon_time']) {
        $time = strtotime($nasa_opt['coming_soon_time']);
        if ($time && $time < NASA_TIME_NOW) {
            return;
        }
    }
    
    /**
     * Check in Login page
     */
    if ($GLOBALS['pagenow'] === 'wp-login.php') {
        return;
    }
    
    $nasa_args = array(
        'time' => $time
    );
    
    nasa_template('coming-soon/coming-soon.php', $nasa_args);
    
    die();
}
