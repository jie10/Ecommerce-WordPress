<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Add Block header
 */
if (!function_exists('elessi_block_header')):
    function elessi_block_header() {
        global $nasa_opt, $wp_query;
        
        $object = $wp_query->get_queried_object();
        $pageOption = isset($object->post_type) && $object->post_type == 'page' ? true : false;
        $objectId = $pageOption ? $object->ID : 0;

        $custom_header = $objectId ? get_post_meta($objectId, '_nasa_custom_header', true) : '';
        
        if (!isset($nasa_opt['header-block'])) {
            $nasa_opt['header-block'] = 'default';
        }
        
        $header_block = ($custom_header !== '' && $objectId) ? get_post_meta($objectId, '_nasa_header_block', true) : $nasa_opt['header-block'];

        if ($header_block == '-1' || $header_block == 'default') {
            return;
        }
        
        $header_block = $header_block == '' ? ($nasa_opt['header-block'] != 'default' ? $nasa_opt['header-block'] : false) : $header_block;
        $header_block = $header_block ? $header_block : false;
        
        echo $header_block ? elessi_get_block($header_block) : '';
    }
endif;

/**
 * Add action header
 */
add_action('init', 'elessi_add_action_header');
if (!function_exists('elessi_add_action_header')):
    function elessi_add_action_header() {
        /* Header Promotion */
        add_action('nasa_before_header_structure', 'elessi_promotion_recent_post', 1);
        
        /* Header Default */
        add_action('nasa_header_structure', 'elessi_get_header_structure', 10);
        add_action('nasa_header_structure', 'elessi_block_header', 100);
        
        /* Breadcrumb site */
        add_action('nasa_after_header_structure', 'elessi_get_breadcrumb', 999);
        
        /* Add Breadcrumb for Header Elementor-Pro */
        if (function_exists('elementor_pro_load_plugin')) {
            add_action('elementor/theme/after_do_header', 'elessi_open_elm_breadcrumb', 80);
            add_action('elementor/theme/after_do_header', 'elessi_get_breadcrumb', 90);
            add_action('elementor/theme/after_do_header', 'elessi_close_elm_breadcrumb', 100);
        }
        
        /* Topbar */
        add_action('nasa_topbar_header', 'elessi_header_topbar');
        
        /* Topbar Mobile */
        add_action('nasa_topbar_header_mobile', 'elessi_header_topbar_mobile');
        
        /**
         * Deprecated from 4.2.6
         * Header - Responsive
         */
        if (function_exists('elessi_mobile_header')) {
            add_action('nasa_mobile_header', 'elessi_mobile_header');
        }
    }
endif;

/**
 * Get header structure
 */
if (!function_exists('elessi_get_header_structure')):
    function elessi_get_header_structure() {
        global $nasa_opt, $post;
        
        $has_vertical = array(4);
        $has_search_icon = array(3, 4, 5);
        $full_rule_headers = array('2', '3');

        $hstructure = isset($nasa_opt['header-type']) ? $nasa_opt['header-type'] : '1';
        $page_id = false;
        $header_override = false;
        $header_slug = isset($nasa_opt['header-custom']) && $nasa_opt['header-custom'] != 'default' ? $nasa_opt['header-custom'] : false;
        $header_slug_ovrride = false;
        $fixed_nav_header = '';
        
        $is_shop = $pageShop = $is_product_taxonomy = $is_product = false;
        if (NASA_WOO_ACTIVED) {
            $is_shop = is_shop();
            $is_product = is_product();
            $is_product_taxonomy = is_product_taxonomy();
            $pageShop = wc_get_page_id('shop');
        }
        
        /**
         * Override Header
         */
        $root_term_id = elessi_get_root_term_id();
        if (!$root_term_id) {
            /**
             * Store Page
             */
            if (($is_shop || $is_product_taxonomy) && $pageShop > 0) {
                $page_id = $pageShop;
            }

            /**
             * Page
             */
            if (!$page_id && isset($post->post_type) && $post->post_type == 'page') {
                $page_id = $post->ID;
            }
            
            /**
             * Blog
             */
            if (!$page_id && elessi_check_blog_page()) {
                $page_id = get_option('page_for_posts');
            }

            /**
             * Swith header structure
             */
            if ($page_id) {
                $custom_header = get_post_meta($page_id, '_nasa_custom_header', true);
                if (!empty($custom_header)) {
                    $hstructure = $custom_header;
                    $header_slug_ovrride = get_post_meta($page_id, '_nasa_header_builder', true);
                }

                $fixed_nav_header = get_post_meta($page_id, '_nasa_fixed_nav', true);
                $fixed_nav_header = $fixed_nav_header == '-1' ? false : $fixed_nav_header;
            }
        }
        
        else {
            /**
             * For Root category (parent = 0)
             */
            $header_override = get_term_meta($root_term_id, 'cat_header_type', true);
            
            if ($header_override == 'nasa-custom') {
                $hstructure = $header_override;
                $header_slug_ovrride = get_term_meta($root_term_id, 'cat_header_builder', true);
            } else {
                $hstructure = $header_override ? $header_override : $hstructure;
            }
        }
        
        /**
         * Apply to override header structure
         */
        $hstructure = apply_filters('nasa_header_structure_type', $hstructure);
        
        if ($fixed_nav_header === '') {
            $fixed_nav_header = (!isset($nasa_opt['fixed_nav']) || $nasa_opt['fixed_nav']);
        }
        
        /**
         * Apply to fixed header
         */
        $fixed_nav = apply_filters('nasa_header_sticky', $fixed_nav_header);
        
        /**
         * Header builder
         */
        if ($hstructure == 'nasa-custom') {
            remove_action('nasa_header_structure', 'elessi_block_header', 100);
            
            $header_slug = $header_slug_ovrride ? $header_slug_ovrride : $header_slug;
            if ($header_slug) {
                elessi_header_builder($header_slug);
            }
            
            return;
        }
        
        $header_classes = array();
        
        /**
         * Transparent header
         */
        $header_transparent = $page_id ? get_post_meta($page_id, '_nasa_header_transparent', true) : '';
        $header_transparent = $header_transparent == '-1' ? '0' : $header_transparent;
        $header_transparent = $header_transparent == '' ? ((!isset($nasa_opt['header_transparent']) || !$nasa_opt['header_transparent']) ? false : true) : (bool) $header_transparent;
        if ($header_transparent) {
            $header_classes[] = 'nasa-header-transparent';
        }
        
        /**
         * Mobile Detect
         */
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
            $header_classes[] = 'nasa-header-mobile-layout';
            if ($fixed_nav) {
                $header_classes[] = 'nasa-header-sticky';
            }
            
            $vertical = in_array($hstructure, $has_vertical) ? true : false;
            $header_classes = !empty($header_classes) ? implode(' ', $header_classes) : '';
            $header_classes = apply_filters('nasa_header_classes', $header_classes);
            
            defined('NASA_TOP_FILTER_CATS') or define('NASA_TOP_FILTER_CATS', apply_filters('nasa_top_filter_cats_state', true));
            
            $file = ELESSI_CHILD_PATH . '/headers/header-mobile.php';
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/headers/header-mobile.php';
            
            return;
        }
        
        /**
         * Init vars
         */
        $menu_warp_class = array();
        $header_classes[] = 'header-wrapper header-type-' . $hstructure;
        
        /**
         * Extra class name
         */
        $el_class_header = $page_id ? get_post_meta($page_id, '_nasa_el_class_header', true) : '';
        if ($el_class_header != '') {
            $header_classes[] = $el_class_header;
        }
        
        /**
         * Main menu style
         */
        $menu_warp_class[] = 'nasa-nav-style-1';
        $data_padding_y = apply_filters('nasa_responsive_y_menu', 15);
        $data_padding_x = apply_filters('nasa_responsive_x_menu', 35);
        
        $menu_warp_class = !empty($menu_warp_class) ? ' ' . implode(' ', $menu_warp_class) : '';
        
        /**
         * Full width main menu
         */
        $fullwidth_main_menu = (isset($nasa_opt['fullwidth_main_menu']) && !$nasa_opt['fullwidth_main_menu']) ? false : true;
        
        if (in_array($hstructure, $full_rule_headers)) {
            $fullwidth_ovr = $page_id ? get_post_meta($page_id, '_nasa_fullwidth_main_menu', true) : $fullwidth_main_menu;
            
            if ($fullwidth_ovr !== '') {
                $fullwidth_main_menu = $fullwidth_ovr === '-1' ? false : $fullwidth_ovr;
            }
        }
        
        /**
         * Top filter cats
         */
        $show_icon_cat_top = isset($nasa_opt['show_icon_cat_top']) ? $nasa_opt['show_icon_cat_top'] : 'show-in-shop';
        switch ($show_icon_cat_top) :
            case 'show-all-site':
                $show_cat_top_filter = true;
                break;

            case 'not-show':
                $show_cat_top_filter = false;
                break;

            case 'show-in-shop':
            default:
                $show_cat_top_filter = ($is_shop || $is_product_taxonomy || $is_product) ? true : false;
                break;
        endswitch;
        
        defined('NASA_TOP_FILTER_CATS') or define('NASA_TOP_FILTER_CATS', apply_filters('nasa_top_filter_cats_state', $show_cat_top_filter));
        
        $show_product_cat = true;
        $show_cart = true;
        $show_compare = true;
        $show_wishlist = true;
        $icon_search = in_array($hstructure, $has_search_icon) ? false : true;
        $show_search = apply_filters('nasa_search_icon_header', $icon_search);
        $nasa_header_icons = elessi_header_icons($show_product_cat, $show_cart, $show_compare, $show_wishlist, $show_search);
        
        /**
         * Sticky header
         */
        if ($fixed_nav) {
            $header_classes[] = 'nasa-header-sticky';
        }
        
        /**
         * $header_classes to string
         */
        $header_classes = !empty($header_classes) ? implode(' ', $header_classes) : '';
        $header_classes = apply_filters('nasa_header_classes', $header_classes);
        
        /**
         * Main header include
         */
        $file = ELESSI_CHILD_PATH . '/headers/header-structure-' . ((int) $hstructure) . '.php';
        if (is_file($file)) {
            include $file;
        } else {
            $file = ELESSI_THEME_PATH . '/headers/header-structure-' . ((int) $hstructure) . '.php';
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/headers/header-structure-1.php';
        }
    }
endif;

/**
 * Group header icons
 */
if (!function_exists('elessi_header_icons')) :
    function elessi_header_icons($product_cat = true, $cart = true, $compare = true, $wishlist = true, $search = true) {
        global $nasa_opt;
        
        $icons = '';
        $first = false;
        
        /**
         * Add Account icon
         */
        $account_icon = (isset($nasa_opt['acc_pos']) && $nasa_opt['acc_pos'] == 'group') ? true : false;
        
        if (
            !$account_icon &&
            isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] &&
            (!isset($nasa_opt['hide_tini_menu_acc']) || !$nasa_opt['hide_tini_menu_acc']) &&
            (!isset($nasa_opt['main_screen_acc_mobile']) || $nasa_opt['main_screen_acc_mobile'])
        ) {
            $account_icon = true;
        }
        
        if ($account_icon) {
            $title_acc = !NASA_CORE_USER_LOGGED ? esc_attr__('Login / Register', 'elessi-theme') : esc_attr__('My Account', 'elessi-theme');

            $login_ajax = !NASA_CORE_USER_LOGGED && (!isset($nasa_opt['login_ajax']) || $nasa_opt['login_ajax'] == 1) ? '1' : '0';
            
            $links = elessi_link_account();
            
            $icon = apply_filters('nasa_mini_icon_account', '<i class="nasa-icon pe7-icon pe-7s-user"></i>');

            $nasa_icon_account = 
            '<a class="nasa-login-register-ajax inline-block" data-enable="' . $login_ajax . '" href="' . esc_url($links) . '" title="' . $title_acc . '">' .
                $icon .
            '</a>';

            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="' . $class . 'nasa-icon-account-mobile">' . $nasa_icon_account . '</li>';
        }
        
        /**
         * List Product Categories icons
         */
        if (NASA_WOO_ACTIVED && $product_cat) {
            $show_icon_cat_top = isset($nasa_opt['show_icon_cat_top']) ? $nasa_opt['show_icon_cat_top'] : 'show-in-shop';
            
            switch ($show_icon_cat_top) {
                case 'show-all-site':
                    $show_icon = true;
                    break;
                
                case 'not-show':
                    $show_icon = false;
                    break;
                
                case 'show-in-shop':
                default:
                    $show_icon = (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) ? false : true;
                    break;
            }
            
            if ($show_icon) {
                $icon = apply_filters('nasa_mini_icon_filter_cats', '<i class="nasa-icon pe-7s-keypad"></i>');
                
                $nasa_icon_cat = 
                    '<a class="filter-cat-icon inline-block nasa-hide-for-mobile" href="javascript:void(0);" title="' . esc_attr__('Product Categories', 'elessi-theme') . '" rel="nofollow">' .
                        $icon .
                    '</a>' .
                    '<a class="filter-cat-icon-mobile inline-block" href="javascript:void(0);" title="' . esc_attr__('Product Categories', 'elessi-theme') . '" rel="nofollow">' .
                        $icon .
                    '</a>';
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'nasa-icon-filter-cat">' . $nasa_icon_cat . '</li>';
            }
        }
        
        if ($cart) {
            $nasa_mini_cart = elessi_mini_cart();
            if ($nasa_mini_cart != '') {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'nasa-icon-mini-cart">' . $nasa_mini_cart . '</li>';
            }
        }
        
        if ($wishlist) {
            $nasa_icon_wishlist = elessi_icon_wishlist();
            if ($nasa_icon_wishlist != '') {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'nasa-icon-wishlist">' . $nasa_icon_wishlist . '</li>';
            }
        }
        
        if ($compare && (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare'])) {
            $nasa_icon_compare = elessi_icon_compare();
            if ($nasa_icon_compare != '') {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'nasa-icon-compare">' . $nasa_icon_compare . '</li>';
            }
        }
        
        if ($search) {
            $icon = apply_filters('nasa_mini_icon_search', '<i class="nasa-icon nasa-search icon-nasa-search"></i>');
            
            $search_icon = 
            '<a class="search-icon desk-search inline-block" href="javascript:void(0);" data-open="0" title="' . esc_attr__('Search', 'elessi-theme') . '" rel="nofollow">' .
                $icon .
            '</a>';
            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="' . $class . 'nasa-icon-search nasa-hide-for-mobile">' . $search_icon . '</li>';
        }
        
        $icons_wrap = ($icons != '') ? '<div class="nasa-header-icons-wrap"><ul class="header-icons">' . $icons . '</ul></div>' : '';
        
        return apply_filters('nasa_header_icons', $icons_wrap);
    }
endif;

/**
 * Get header builder custom
 */
if (!function_exists('elessi_header_builder')) :
    function elessi_header_builder($header_slug) {
        if (!function_exists('nasa_get_header')) {
            return;
        }

        $header_builder = nasa_get_header($header_slug);
        
        $file = ELESSI_CHILD_PATH . '/headers/header-builder.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/headers/header-builder.php';
    }
endif;

/**
 * Topbar
 */
if (!function_exists('elessi_header_topbar')) :
    function elessi_header_topbar($mobile = false) {
        global $wp_query, $nasa_opt;
        
        $queryObjId = $wp_query->get_queried_object_id();
        
        /**
         * Top bar Toggle
         */
        $topbar_toggle = get_post_meta($queryObjId, '_nasa_topbar_toggle', true);
        $topbar_df_show = $topbar_toggle == 1 ? get_post_meta($queryObjId, '_nasa_topbar_default_show', true) : '';

        $topbar_toggle_val = $topbar_toggle == '' ? (isset($nasa_opt['topbar_toggle']) && $nasa_opt['topbar_toggle'] ? true : false) : ($topbar_toggle == 1 ? true : false);
        $topbar_df_show_val = $topbar_df_show == '' ? (!isset($nasa_opt['topbar_default_show']) || $nasa_opt['topbar_default_show'] ? true : false) : ($topbar_df_show == 1 ? true : false);

        $class_topbar = $topbar_toggle_val ? ' nasa-topbar-toggle' : '';
        $class_topbar .= $topbar_df_show_val ? '' : ' nasa-topbar-hide';
        
        /**
         * Top bar content
         */
        $topbar_left = '';
        if (isset($nasa_opt['topbar_content']) && $nasa_opt['topbar_content']) {
            $topbar_left = elessi_get_block($nasa_opt['topbar_content']);
        }
        
        /**
         * Old data
         */
        elseif (isset($nasa_opt['topbar_left']) && $nasa_opt['topbar_left'] != '') {
            $topbar_left = do_shortcode($nasa_opt['topbar_left']);
        }
        
        $file = ELESSI_CHILD_PATH . '/headers/top-bar.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/headers/top-bar.php';
    }
endif;

/**
 * Topbar mobile
 */
if (!function_exists('elessi_header_topbar_mobile')) :
    function elessi_header_topbar_mobile() {
        elessi_header_topbar(true);
    }
endif;

/**
 * Topbar menu
 */
add_action('nasa_topbar_menu', 'elessi_topbar_menu', 15);
add_action('nasa_mobile_topbar_menu', 'elessi_topbar_menu', 15);
if (!function_exists('elessi_topbar_menu')) :
    function elessi_topbar_menu() {
        elessi_get_menu('topbar-menu', 'nasa-topbar-menu', 1);
    }
endif;

/**
 * Topbar Account
 */
add_action('nasa_topbar_menu', 'elessi_topbar_account', 20);
if (!function_exists('elessi_topbar_account')) :
    function elessi_topbar_account() {
        global $nasa_opt;
        
        echo (!isset($nasa_opt['acc_pos']) || $nasa_opt['acc_pos'] == 'top') ?
            elessi_tiny_account(true) : '';
    }
endif;

/**
 * Mobile account menu
 */
if (!function_exists('elessi_mobile_account')) :
    function elessi_mobile_account() {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-mobile-account.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-mobile-account.php';
    }
endif;

/**
 * Short code group icons header
 */
add_shortcode('nasa_sc_icons', 'elessi_header_icons_sc');
if (!function_exists('elessi_header_icons_sc')) :
    function elessi_header_icons_sc($atts = array(), $content = null) {
        $dfAttr = array(
            'show_mini_cart' => 'yes',
            'show_mini_compare' => 'yes',
            'show_mini_wishlist' => 'yes',
            'el_class' => ''
        );
        extract(shortcode_atts($dfAttr, $atts));

        $cart = $show_mini_cart == 'yes' ? true : false;
        $compare = $show_mini_compare == 'yes' ? true : false;
        $wishlist = $show_mini_wishlist == 'yes' ? true : false;
        
        $class = 'nasa-header-icons-wrap';
        $class .= $el_class != '' ? ' ' . $el_class : '';
        
        $content = '<div class="' . esc_attr($class) . '">' .
            elessi_header_icons(false, $cart, $compare, $wishlist, false) .
        '</div>';
        
        return $content;
    }
endif;

/**
 * Short code header search
 */
add_shortcode('nasa_sc_search_form', 'elessi_header_search_sc');
if (!function_exists('elessi_header_search_sc')) :
    function elessi_header_search_sc($atts = array(), $content = null) {
        $dfAttr = array(
            'el_class' => ''
        );
        extract(shortcode_atts($dfAttr, $atts));
        
        $class = 'nasa-header-search-wrap';
        $class .= $el_class != '' ? ' ' . $el_class : '';
        
        $content = '<div class="' . esc_attr($class) . '">' .
            elessi_search('full') .
        '</div>';
        
        return $content;
    }
endif;

/**
 * Get breadcrumb
 */
if (!function_exists('elessi_get_breadcrumb')) :
    function elessi_get_breadcrumb() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }

        global $wp_query, $post, $nasa_opt, $nasa_root_term_id;
        
        $enable = isset($nasa_opt['breadcrumb_show']) && !$nasa_opt['breadcrumb_show'] ? false : true;
        $is_product = is_product();
        $is_product_cat = is_product_category();
        $is_product_taxonomy = is_product_taxonomy();
        $is_shop = is_shop();
        
        $mobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        
        $override = false;

        // Theme option
        $has_bg = isset($nasa_opt['breadcrumb_type']) && $nasa_opt['breadcrumb_type'] == 'has-background' ?
            true : false;
        
        $bg_key = $mobile ? 'breadcrumb_bg_m' : 'breadcrumb_bg';

        $bg = isset($nasa_opt[$bg_key]) && trim($nasa_opt[$bg_key]) != '' ?
            $nasa_opt[$bg_key] : false;

        $bg_cl = isset($nasa_opt['breadcrumb_bg_color']) && $nasa_opt['breadcrumb_bg_color'] ?
            $nasa_opt['breadcrumb_bg_color'] : false;
        
        $txt_color = isset($nasa_opt['breadcrumb_color']) && $nasa_opt['breadcrumb_color'] ?
            $nasa_opt['breadcrumb_color'] : false;

        $h_key = $mobile ? 'breadcrumb_height_m' : 'breadcrumb_height';
        $h_bg = isset($nasa_opt[$h_key]) && (int) $nasa_opt[$h_key] ?
            (int) $nasa_opt[$h_key] : false;
        
        $bg_lax = isset($nasa_opt['breadcrumb_bg_lax']) && $nasa_opt['breadcrumb_bg_lax'] ?
            true : false;

        /*
         * Override breadcrumb BG
         */
        if ($is_shop || $is_product_cat || $is_product_taxonomy || $is_product) {
            $pageShop = wc_get_page_id('shop');

            if ($pageShop > 0) {
                $show_breadcrumb = get_post_meta($pageShop, '_nasa_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                if (!$enable) {
                    return;
                }
            }

            $term_id = false;

            /**
             * Check Single product
             */
            if ($is_product) {
                if (!$nasa_root_term_id) {
                    $product_cats = get_the_terms($wp_query->get_queried_object_id(), 'product_cat');
                    if ($product_cats) {
                        foreach ($product_cats as $cat) {
                            $term_id = $cat->term_id;
                            break;
                        }
                    }
                } else {
                    $term_id = $nasa_root_term_id;
                }
            }

            /**
             * Check Archive product
             */
            elseif ($is_product_cat) {
                $query_obj = get_queried_object();
                $term_id = isset($query_obj->term_id) ? $query_obj->term_id : false;
            }

            if ($term_id) {
                $bg_cat_enable = get_term_meta($term_id, 'cat_breadcrumb', true);

                if (!$bg_cat_enable) {
                    if ($nasa_root_term_id) {
                        $term_id = $nasa_root_term_id;
                    } else {
                        $ancestors = get_ancestors($term_id, 'product_cat');
                        $term_id = $ancestors ? end($ancestors) : 0;
                        $GLOBALS['nasa_root_term_id'] = $term_id;
                    }

                    if ($term_id) {
                        $bg_cat_enable = get_term_meta($term_id, 'cat_breadcrumb', true);
                    }
                }

                if ($bg_cat_enable) {
                    $bg_key = $mobile ? 'cat_breadcrumb_bg_m' : 'cat_breadcrumb_bg';
                    $bg_id = get_term_meta($term_id, $bg_key, true);
                    if ($bg_id) {
                        $bg = wp_get_attachment_image_url($bg_id, 'full');
                        $has_bg = true;
                    }

                    $text_color_cat = get_term_meta($term_id, 'cat_breadcrumb_text_color', true);
                    $txt_color = $text_color_cat != '' ? $text_color_cat : $txt_color;
                }
            }

            /**
             * Breadcrumb shop page
             */
            elseif ($is_shop && $pageShop > 0) {
                $queryObj = $pageShop;
                $override = true;
            }
        }

        else {
            $pageBlog = get_option('page_for_posts');
            /**
             * Check page
             */
            if (isset($post->ID) && $post->post_type == 'page') {
                $queryObj = $post->ID;
                $show_breadcrumb = get_post_meta($queryObj, '_nasa_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                $override = true;
            }

            /**
             * Check Blog | archive post | single post
             */
            elseif ($pageBlog && isset($post->post_type) && $post->post_type == 'post' && (is_category() || is_tag() || is_date() || is_home() || is_single())) {
                $show_breadcrumb = get_post_meta($pageBlog, '_nasa_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                $queryObj = $pageBlog;
                $override = true;
            }

            if (!$enable) {
                return;
            }
        }
        
        // Override
        if ($override) {

            $type_bg = get_post_meta($queryObj, '_nasa_type_breadcrumb', true);

            $bg_key = $mobile ? '_nasa_bg_breadcrumb_m' : '_nasa_bg_breadcrumb';
            $bg_override = get_post_meta($queryObj, $bg_key, true);

            $bg_cl_override = get_post_meta($queryObj, '_nasa_bg_color_breadcrumb', true);
            $color_override = get_post_meta($queryObj, '_nasa_color_breadcrumb', true);

            $h_key = $mobile ? '_nasa_height_breadcrumb_m' : '_nasa_height_breadcrumb';
            $h_override = get_post_meta($queryObj, $h_key, true);


            if ($type_bg == '1') {
                $bg = $bg_override ? $bg_override : $bg;
            }

            $bg_cl = $bg_cl_override ? $bg_cl_override : $bg_cl;
            $txt_color = $color_override ? $color_override : $txt_color;
            $h_bg = (int) $h_override ? (int) $h_override : $h_bg;
        }

        // set style by option breadcrumb
        $style_custom = '';
        if ($has_bg && $bg) {
            $style_custom .= 'background:url(' . esc_url($bg) . ')';
            $style_custom .= $bg_lax ? ' center center repeat-y;' : ';background-size:cover;';
        }

        $style_custom .= $bg_cl ? 'background-color:' . $bg_cl . ';' : '';
        $style_custom .= $txt_color ? 'color:' . $txt_color . ';' : '';
        $style_height = $h_bg ? 'height:' . $h_bg . 'px;' : 'height:auto;';
        
        $parallax = ($has_bg && $bg && $bg_lax) ? true : false;
        $bread_align = !isset($nasa_opt['breadcrumb_align']) ? 'text-center' : $nasa_opt['breadcrumb_align'];
        
        $class_all = array('bread nasa-breadcrumb');
        $attr_all = array('id="nasa-breadcrumb-site"');
        if ($has_bg) {
            $class_all[] = 'nasa-breadcrumb-has-bg';
        }
        
        if ($parallax) {
            $class_all[] = 'nasa-parallax nasa-parallax-stellar';
            $attr_all[] = 'data-stellar-background-ratio="0.6"';
            
            // jquery-migrate
            wp_enqueue_script('jquery-migrate', ELESSI_THEME_URI . '/assets/js/min/jquery-migrate.min.js', array('jquery'), null);
            
            // Parallax - js
            wp_enqueue_script('jquery-stellar', ELESSI_THEME_URI . '/assets/js/min/jquery.stellar.min.js', array('jquery'), null, true);
        }
        
        if ($style_custom) {
            $attr_all[] = 'style="' . esc_attr($style_custom) . '"';
        }
        
        $class_all_string = !empty($class_all) ? implode(' ', $class_all) : '';
        if ($class_all_string) {
            $attr_all[] = 'class="' . esc_attr($class_all_string) . '"';
        }
        
        $attr_all_string = !empty($attr_all) ? ' ' . implode(' ', $attr_all) : '';
        
        $defaults = apply_filters('nasa_breadcrumb_args', array(
            'delimiter' => '<span class="fa fa-angle-right"></span>',
            'wrap_before' => '<span class="breadcrumb">',
            'wrap_after' => '</span>',
            'before' => '',
            'after' => '',
            'home' => esc_html__('Home', 'elessi-theme'),
        ));
        
        $args = apply_filters('woocommerce_breadcrumb_defaults', $defaults);
        
        $wc_breadcrumbs = new WC_Breadcrumb();

        if (!empty($args['home'])) {
            $wc_breadcrumbs->add_crumb(
                $args['home'],
                apply_filters('woocommerce_breadcrumb_home_url', home_url('/'))
            );
        }
        
        $args['breadcrumb'] = $wc_breadcrumbs->generate();
        do_action('woocommerce_breadcrumb', $wc_breadcrumbs, $args);
        ?>
        <div<?php echo $attr_all_string; ?>>
            <div class="row">
                <div class="large-12 columns nasa-display-table">
                    <nav class="breadcrumb-row <?php echo esc_attr($bread_align); ?>"<?php echo $style_height ? ' style="' . esc_attr($style_height).'"' : ''; ?>>
                        <?php wc_get_template('global/breadcrumb.php', $args); ?>
                    </nav>
                </div>
            </div>
        </div>

        <?php
    }
endif;

/**
 * Build breadcrumb Portfolio
 */
if (!function_exists('elessi_rebuilt_breadcrumb_portfolio')) :
    function elessi_rebuilt_breadcrumb_portfolio($orgBreadcrumb = array(), $single = true) {
        global $nasa_opt, $post;
        
        $breadcrumb = isset($orgBreadcrumb[0]) ? array($orgBreadcrumb[0]) : array();
        
        $portfolio = null;
        if (isset($nasa_opt['nasa-page-view-portfolio']) && (int) $nasa_opt['nasa-page-view-portfolio']) {
            $portfolio = get_post((int) $nasa_opt['nasa-page-view-portfolio']);
        } else {
            $pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'portfolio.php'
            ));

            if ($pages) {
                foreach ($pages as $page) {
                    $portfolio = get_post((int) $page->ID);
                    break;
                }
            }
        }

        if ($portfolio) {
            $breadcrumb[] = array(
                0 => $portfolio->post_title,
                1 => get_permalink($portfolio)
            );
        }

        $terms = wp_get_post_terms(
            $post->ID,
            'portfolio_category',
            array(
                'orderby' => 'parent',
                'order' => 'DESC'
            )
        );

        if ($terms) {
            $main_term = $terms[0];
            $ancestors = get_ancestors($main_term->term_id, 'portfolio_category');
            $ancestors = array_reverse($ancestors);
            if (count($ancestors)) {
                foreach ($ancestors as $ancestor) {
                    $ancestor = get_term($ancestor, 'portfolio_category');

                    if ($ancestor) {
                        $breadcrumb[] = array(
                            0 => $ancestor->name,
                            1 => get_term_link($ancestor, 'portfolio_category')
                        );
                    }
                }
            }

            if ($single) {
                $breadcrumb[] = array(
                    0 => $main_term->name,
                    1 => get_term_link($main_term, 'portfolio_category')
                );
            }
        }

        return $breadcrumb;
    }
endif;

/**
 * Open wrap Breadcrumb for Elementor Pro - Header Builder
 */
if (!function_exists('elessi_open_elm_breadcrumb')) :
    function elessi_open_elm_breadcrumb() {
        echo '<!-- Begin Breadcrumb for Elementor Pro - Header Builder --><div class="nasa-breadcrumb-wrap">';
    }
endif;

/**
 * Close wrap Breadcrumb for Elementor Pro - Header Builder
 */
if (!function_exists('elessi_close_elm_breadcrumb')) :
    function elessi_close_elm_breadcrumb() {
        echo '</div><!-- End Breadcrumb for Elementor Pro - Header Builder -->';
    }
endif;
