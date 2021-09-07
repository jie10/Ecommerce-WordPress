<?php
/**
 * Importer NasaTheme
 * 
 * Since 4.0
 * 
 */
defined('ABSPATH') or die();

defined('ELESSI_IMPORT_TOTAL') or define('ELESSI_IMPORT_TOTAL', '25');

/**
 * Menu Importer Dashboard
 */
add_action('admin_menu', 'elessi_data_importer_menu', 99);
function elessi_data_importer_menu() {
    if (current_user_can('manage_options')) {
        $args = array(
            'parent_slug' => 'themes.php', // Parent Menu slug.
            'page_title' => esc_html__('Theme Setup', 'elessi-theme'),
            'menu_title' => esc_html__('Theme Setup', 'elessi-theme'),
            'capability' => 'edit_theme_options', // Capability.
            'menu_slug' => 'nasa-install-demo-data', // Menu slug.
            'function' => 'elessi_import_demo_data_output', // Callback.
        );

        add_theme_page(
            $args['page_title'],
            $args['menu_title'],
            $args['capability'],
            $args['menu_slug'],
            $args['function']
        );
    }
}

/**
 * Page Nasa Importer
 */
function elessi_import_demo_data_output() {
    wp_enqueue_script('nasa_back_end-script-demo-data', ELESSI_THEME_URI . '/admin/assets/js/nasa-core-demo-data.js');
    $nasa_core_js = 'var ajax_admin_demo_data="' . esc_url(admin_url('admin-ajax.php')) . '";';
    wp_add_inline_script('nasa_back_end-script-demo-data', $nasa_core_js, 'before');
    
    include ELESSI_ADMIN_PATH . 'importer/tpl-import-demo-data.php';
}

/**
 * Install Child Theme
 */
add_action('wp_ajax_nasa_install_child_theme', 'elessi_install_child_theme');
function elessi_install_child_theme() {
    global $wp_filesystem;
    
    // Initialize the WP filesystem
    if (empty($wp_filesystem)) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }
    
    $zip = ELESSI_ADMIN_PATH . 'importer/theme-child/theme-child.zip';
    if (!$wp_filesystem->is_file($zip)) {
        die('0');
    }
    
    try {
        // unzip child-theme
        $theme_root = ELESSI_THEME_PATH . '/../';
        $pathArrayString = str_replace(array('/', '\\'), '|', ELESSI_THEME_PATH);
        $themeNameArray = explode('|', $pathArrayString);
        $theme_name = end($themeNameArray);
        $theme_child = $theme_name . '-child';

        if (!$wp_filesystem->is_dir($theme_root . $theme_child)) {
            wp_mkdir_p($theme_root . $theme_child);
            unzip_file($zip, $theme_root . $theme_child);
        }

        // Active Child Theme
        if (is_dir($theme_root . $theme_child)) {
            switch_theme($theme_child);
        }
    } catch (Exception $exc) {
        die('0');
    }
    
    die('1');
}

/**
 * Install Plugin
 */
add_action('wp_ajax_nasa_install_plugin', 'elessi_install_plugin');
function elessi_install_plugin() {
    $plugin_slug = isset($_REQUEST['plg']) ? $_REQUEST['plg'] : null;
    $plugin_info = null;
    
    $res = array(
        'mess' => '',
        'status' => '1'
    );
    
    if (trim($plugin_slug) !== '') {
        $plugins = elessi_list_required_plugins();
        
        foreach ($plugins as $plugin) {
            if (isset($plugin['auto']) && $plugin['auto'] && $plugin['slug'] === $plugin_slug) {
                $plugin_info = $plugin;
                break;
            }
        }
        
        if (!class_exists('Elessi_Auto_Install_Plugins')) {
            require_once ELESSI_ADMIN_PATH . 'importer/auto-install-plugins.php';
        }
        
        $auto_install = new Elessi_Auto_Install_Plugins($plugin_info);
        
        $res['mess'] = $plugin_info['name'];
        $res['status'] = $auto_install->nasa_plugin_install() ? '1' : '0';
        
        die(json_encode($res));
    }
    
    die(json_encode($res));
}

/**
 * Import demo data
 */
add_action('wp_ajax_nasa_import_contents', 'elessi_import_contents');
function elessi_import_contents() {
    set_time_limit(0);
    header('X-XSS-Protection:0');
    $partial = $_POST['file'];
    $partial = $partial ? str_replace('data', '', $partial) : '';
    $res = array('nofile' => 'false');
    if (current_user_can('manage_options')) {
        if (!defined('WP_LOAD_IMPORTERS')) {
            define('WP_LOAD_IMPORTERS', true); // we are loading importers
        }

        if (!class_exists('WP_Import')) { // if WP importer doesn't exist
            $wp_import = ELESSI_ADMIN_PATH . 'importer/wordpress-importer.php';
            require_once $wp_import;
        }

        if (class_exists('WP_Importer') && class_exists('WP_Import')) {
            if (!isset($_SESSION['nasa_import']) || $partial == 1) {
                $_SESSION['nasa_import'] = array();
            }
            
            /* Import Woocommerce if WooCommerce Exists */
            if (class_exists('WooCommerce')) {
                $partial = $partial < 10 ? '0' . $partial : $partial;
                
                $theme_xml = ELESSI_ADMIN_PATH . 'importer/data-import/datas/data_Part_0' . $partial . '_of_' . ELESSI_IMPORT_TOTAL . '.xml';
                if (is_file($theme_xml)) {
                    $importer = new WP_Import();

                    $importer->fetch_attachments = true;
                    ob_start();
                    $importer->import($theme_xml);
                    $res['mess'] = ob_get_clean();
                } else {
                    $res['mess'] = '<p class="nasa-error">';
                    $res['mess'] .= 'file: ' . ELESSI_ADMIN_PATH . 'importer/data-import/datas/data_Part_0' . $partial . '_of_' . ELESSI_IMPORT_TOTAL . '.xml is not exists';
                    $res['mess'] .= '</p>';
                    $res['nofile'] = 'true';
                }

                $res['end'] = 1;
                die(json_encode($res));
            }
        }
    }

    $res['mess'] = '';
    $res['end'] = 0;

    die(json_encode($res));
}

/**
 * Import Widgets Sidebar
 */
if (isset($_REQUEST['action']) && 'nasa_import_widgets_sidebar' == $_REQUEST['action']) {
    require_once ELESSI_ADMIN_PATH . 'importer/nasa-sidebars-widgets.php';
}
add_action('wp_ajax_nasa_import_widgets_sidebar', 'elessi_import_widgets_sidebar');
function elessi_import_widgets_sidebar() {
    try {
        $widget_data = elessi_sidebars_widgets_import();
    
        /**
         * Sidebars Widgets
         */
        update_option('sidebars_widgets', $widget_data['sidebars_widgets'], true);

        /**
         * Setting Widgets
         */
        foreach ($widget_data['widgets'] as $key => $value) {
            update_option($key, $value, true);
        }
    } catch (Exception $exc) {
        die('0');
    }
    
    die('1');
}

/**
 * Import Homes
 */
add_action('wp_ajax_nasa_import_homes', 'elessi_import_homes');
function elessi_import_homes() {
    $elm_pages = $_POST['elm'];
    $wpb_pages = $_POST['wpb'];
    
    if (!class_exists('Elessi_DF_Page_Importer')) {
        require_once ELESSI_ADMIN_PATH . 'importer/nasa-default-page.php';
    }
    
    try {
        /**
         * Push data Elementor pages
         */
        if (!empty($elm_pages)) {
            $elm_pages[] = 'contact-us';
            $elm_pages[] = 'about-us';
            
            foreach ($elm_pages as $file) {
                $file = trim($file);
                Elessi_DF_Page_Importer::nasa_push_data_from_file('elm', $file);
            }
        }

        /**
         * Push data WPBakery page
         */
        if (!empty($wpb_pages)) {
            foreach ($wpb_pages as $file) {
                $file = trim($file);
                Elessi_DF_Page_Importer::nasa_push_data_from_file('wpb', $file);
            }
        }
    } catch (Exception $exc) {
        echo $exc->getMessage();
        die('0');
    }

    die('1');
}

/**
 * Import Revslider
 */
add_action('wp_ajax_nasa_import_revsliders', 'elessi_import_revsliders');
function elessi_import_revsliders() {
    if (!class_exists('RevSliderSliderImport')) {
        die('0');
    }
    
    $zips = glob(ELESSI_ADMIN_PATH . 'importer/data-import/revsliders/*.zip');
    
    if (empty($zips)) {
        die('0');
    }
    
    try {
        foreach ($zips as $zip) {
            $import = new RevSliderSliderImport();
            $import->import_slider(true, $zip, false, false, true, true);
        }
    } catch (Exception $exc) {
        echo $exc->getMessage();
        die('0');
    }

    die('1');
}

/**
 * Global Options
 */
add_action('wp_ajax_nasa_global_options', 'elessi_global_options');
function elessi_global_options() {
    /**
     * Setting Main Menu
     */
    $locations = get_theme_mod('nav_menu_locations'); // registered menu locations in theme
    $menus = wp_get_nav_menus(); // registered menus

    if ($menus) {
        foreach ($menus as $menu) {
            switch ($menu->name) {
                /**
                 * Main Menu
                 */
                case 'Main Menu':
                    $locations['primary'] = $menu->term_id;
                    break;
                
                /**
                 * Vertical Menu
                 */
                case 'Vertical Menu':
                    $locations['vetical-menu'] = $menu->term_id;
                    break;

                default: break;
            }
        }
    }

    set_theme_mod('nav_menu_locations', $locations); // set menus to locations
    
    /**
     * Setting for WooCommerce
     */
    if (class_exists('WooCommerce')) {
        // Set pages
        $woopages = array(
            'woocommerce_shop_page_id' => 'Shop',
            'woocommerce_cart_page_id' => 'Shopping cart',
            'woocommerce_checkout_page_id' => 'Checkout',
            'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
            'woocommerce_thanks_page_id' => 'Order Received',
            'woocommerce_myaccount_page_id' => 'My Account',
            'woocommerce_edit_address_page_id' => 'Edit My Address',
            'woocommerce_view_order_page_id' => 'View Order',
            'woocommerce_change_password_page_id' => 'Change Password',
            'woocommerce_logout_page_id' => 'Logout',
            'woocommerce_lost_password_page_id' => 'Lost Password'
        );

        foreach ($woopages as $woo_page_name => $woo_page_title) {
            $woopage = get_page_by_title($woo_page_title);
            if ($woopage && isset($woopage->ID)) {
                update_option($woo_page_name, $woopage->ID); // Front Page
            }
        }

        // Woo Image sizes
        $catalog = array(
            'width' => '450', // px
            'height' => '', // px
            'crop' => 0   // false
        );

        $single = array(
            'width' => '595', // px
            'height' => '', // px
            'crop' => 0   // false
        );

        $thumbnail = array(
            'width' => '120', // px
            'height' => '150', // px
            'crop' => 1   // false
        );

        update_option('shop_catalog_image_size', $catalog);   // Product category thumbs
        update_option('shop_single_image_size', $single);   // Single product image
        update_option('shop_thumbnail_image_size', $thumbnail);  // Image gallery thumbs

        // Wordpress Media Setting
        update_option('medium_size_w', 450);
        update_option('large_size_w', 595);

        // For Woo 3.3.x
        update_option('woocommerce_single_image_width', 595);       // Single product image
        update_option('woocommerce_thumbnail_image_width', 450);    // Product category thumbs
        update_option('woocommerce_thumbnail_cropping', 'uncropped');    // Option crop

        // default sorting
        update_option('woocommerce_default_catalog_orderby', 'menu_order');

        // Number decimals
        update_option('woocommerce_price_num_decimals', '0');

        // We no longer need to install pages
        delete_option('_wc_needs_pages');
        delete_transient('_wc_activation_redirect');
        
        /**
         * Update Looup tables
         */
        wc_update_product_lookup_tables();
    }
    
    /**
     * Blog page
     */
    update_option('show_on_front', 'page');
    $blog_id = get_page_by_title('Blog');
    update_option('page_for_posts', $blog_id->ID);
    
    /**
     * Update UX Attributes
     */
    elessi_update_ux_attrs();
    
    /**
     * Set Default Options
     */
    elessi_theme_set_options_default();
    
    die('1');
}

/**
 * Attributes Color, Size;
 */
function elessi_update_ux_attrs() {
    global $wpdb;
    
    /**
     * Attribute Table
     */
    $attrs_table = $wpdb->prefix . 'woocommerce_attribute_taxonomies';
    
    /**
     * Update Attribute Label - Size
     */
    $wpdb->update(
        $attrs_table,
        array('attribute_type' => 'nasa_label', 'attribute_public' => 0),
        array('attribute_name' => 'size')
    );
    
    /**
     * Update Attribute Color
     */
    $wpdb->update(
        $attrs_table,
        array('attribute_type' => 'nasa_color', 'attribute_public' => 0),
        array('attribute_name' => 'color')
    );
    
    /**
     * Update Color for terms
     */
    $terms = get_terms(array(
        'taxonomy' => 'pa_color',
        'hide_empty' => false
    ));
    
    $codes = array(
        'black' => '#000000',
        'blue' => '#1e73be',
        'green' => '#81d742',
        'orange' => '#dd9933',
        'pink' => '#ffc0cb',
        'red' => '#dd3333',
        'yellow' => '#eeee22'
    );
    
    if (!empty($terms)) {
        foreach ($terms as $term) {
            $color_code = isset($codes[$term->slug]) ? $codes[$term->slug] : $term->slug;
            update_term_meta($term->term_id, 'nasa_color', $color_code);
        }
    }
    
    /**
     * Update Options wc_attribute_taxonomies
     */
    $attrs = $wpdb->get_results('SELECT * FROM ' . $attrs_table);
    if ($attrs) {
        update_option('_transient_wc_attribute_taxonomies', $attrs, true);
    }
}

/**
 * Set Default Options
 */
function elessi_theme_set_options_default() {
    defined('NASA_ELEMENTOR_ACTIVE') or define('NASA_ELEMENTOR_ACTIVE', defined('ELEMENTOR_PATH') && ELEMENTOR_PATH);
    
    set_theme_mod('type_font_select', 'google');
    set_theme_mod('type_headings', 'Nunito Sans');
    set_theme_mod('type_texts', 'Nunito Sans');
    set_theme_mod('type_nav', 'Nunito Sans');
    set_theme_mod('type_alt', 'Nunito Sans');
    set_theme_mod('type_banner', 'Nunito Sans');
    
    set_theme_mod('header-type', '1');
    set_theme_mod('topbar_content', 'topbar');
    
    if (NASA_ELEMENTOR_ACTIVE) {
        set_theme_mod('footer_mode', 'build-in');
        set_theme_mod('footer_build_in', '2');
        set_theme_mod('footer_build_in_mobile', 'm-1');
    } else {
        set_theme_mod('footer_mode', 'builder');
        set_theme_mod('footer-type', 'footer-light-2');
        set_theme_mod('footer-mobile', 'footer-mobile');
    }
    
    set_theme_mod('style_quickview', 'sidebar');
    set_theme_mod('quick_view_item_thumb', '2-items');
    set_theme_mod('hotkeys_search', 'Sweater, Jacket, T-shirt ...');
    set_theme_mod('show_icon_cat_top', 'show-in-shop');
    
    set_theme_mod('featured_badge', '1');
    set_theme_mod('category_sidebar', 'top');
    set_theme_mod('limit_widgets_show_more', '5');
    set_theme_mod('products_per_row', '4-cols');
    set_theme_mod('products_per_row_tablet', '3-cols');
    set_theme_mod('products_per_row_small', '2-cols');
    
    set_theme_mod('product_image_style', 'scroll');
    set_theme_mod('label_attribute_single', '1');
    
    set_theme_mod('button_radius', '0');
    set_theme_mod('button_border', '1');
    set_theme_mod('input_radius', '0');
    
    set_theme_mod('facebook_url_follow', '#');
    set_theme_mod('twitter_url_follow', '#');
    set_theme_mod('pinterest_url_follow', '#');
    set_theme_mod('instagram_url', '#');
    
    set_theme_mod('enable_portfolio', '1');
    set_theme_mod('portfolio_columns', '5-cols');
    
    set_theme_mod('enable_nasa_mobile', '1');
    set_theme_mod('single_product_mobile', '1');
    
    set_theme_mod('effect_before_load', '0');
    
    set_theme_mod('nasa_cache_mode', 'file');
    set_theme_mod('nasa_cache_expire', '36000'); // Cache live 10 hours
    
    update_option('yith_woocompare_compare_button_in_products_list', 'yes');
    update_option('woocommerce_enable_myaccount_registration', 'yes');
    
    if (function_exists('nasa_theme_rebuilt_css_dynamic')) {
        nasa_theme_rebuilt_css_dynamic();
    }
    
    /**
     * Rewite Rule URL
     */
    update_option('permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', true);
    $wc_permalink = array(
        'product_base' => 'product',
        'category_base' => 'product-category',
        'tag_base' => 'product-tag',
        'use_verbose_page_rules' => false
    );
    update_option('woocommerce_permalinks', $wc_permalink, true);
    
    flush_rewrite_rules();
    
    /**
     * Clear transient onsale and deal products
     */
    delete_transient('_wc_products_onsale');
    delete_transient('_nasa_products_deal');
    
    update_option('nasatheme_imported', 'imported');
}
