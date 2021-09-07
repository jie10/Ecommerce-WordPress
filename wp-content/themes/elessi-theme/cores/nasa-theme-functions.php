<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Render Time sale Countdown
 */
if (!function_exists('elessi_time_sale')) :
    function elessi_time_sale($time_sale = null, $gmt = true) {
        return function_exists('nasa_time_sale') ? nasa_time_sale($time_sale, $gmt, true) : '';
    }
endif;

/**
 * Get custom style by post id
 */
if (!function_exists('elessi_get_custom_style')) :
    function elessi_get_custom_style($post_id) {
        return function_exists('nasa_get_custom_style') ? nasa_get_custom_style($post_id) : '';
    }
endif;

/**
 * get Nasa Block
 */
if (!function_exists('elessi_get_block')):
    function elessi_get_block($slug) {
        return function_exists('nasa_get_block') ? nasa_get_block($slug) : '';
    }
endif;

/**
 * Clear Both
 */
if (!function_exists('elessi_clearboth')) :
    function elessi_clearboth() {
        echo '<div class="nasa-clear-both nasa-min-height"></div>';
    }
endif;

/**
 * Single hr
 */
if (!function_exists('elessi_single_hr')) :
    function elessi_single_hr() {
        echo '<hr class="nasa-single-hr" />';
    }
endif;

/**
 * Switch Tablet
 */
if (!function_exists('elessi_switch_tablet')) :
    function elessi_switch_tablet() {
        return function_exists('nasa_switch_tablet') ? nasa_switch_tablet() : apply_filters('nasa_switch_tablet', '767');
    }
endif;

/**
 * Switch Desktop
 */
if (!function_exists('elessi_switch_desktop')) :
    function elessi_switch_desktop() {
        return function_exists('nasa_switch_desktop') ? nasa_switch_desktop() : apply_filters('nasa_switch_desktop', '1024');
    }
endif;

/**
 * Get logo
 */
if (!function_exists('elessi_logo')) :
    function elessi_logo() {
        global $nasa_logo;
        
        if (!isset($nasa_logo) || !$nasa_logo) {
            global $nasa_opt, $wp_query;
            
            $logo_link = isset($nasa_opt['site_logo']) ? $nasa_opt['site_logo'] : '';
            $logo_retina = isset($nasa_opt['site_logo_retina']) ? $nasa_opt['site_logo_retina'] : '';
            $logo_sticky = isset($nasa_opt['site_logo_sticky']) ? $nasa_opt['site_logo_sticky'] : '';
            $logo_m = isset($nasa_opt['site_logo_m']) ? $nasa_opt['site_logo_m'] : '';
            $logo_link_overr = $logo_retina_overr = $logo_sticky_overr = $logo_m_overr = false;
            
            $page_id = false;
            $root_term_id = elessi_get_root_term_id();
            
            /**
             * For Page
             */
            if (!$root_term_id) {
                /*
                 * Override Header
                 */
                $is_shop = $pageShop = $is_product_taxonomy = false;
                if (NASA_WOO_ACTIVED) {
                    $is_shop = is_shop();
                    $is_product_taxonomy = is_product_taxonomy();
                    $pageShop = wc_get_page_id('shop');
                }

                if (($is_shop || $is_product_taxonomy) && $pageShop > 0) {
                    $page_id = $pageShop;
                }

                /**
                 * Page
                 */
                if (!$page_id) {
                    $page_id = $wp_query->get_queried_object_id();
                }
                
                if ($page_id) {
                    $logo_flag_overr = get_post_meta($page_id, '_nasa_logo_flag', true);
                    if ($logo_flag_overr === 'on') {
                        $logo_link_overr = get_post_meta($page_id, '_nasa_custom_logo', true);
                        $logo_retina_overr = get_post_meta($page_id, '_nasa_custom_logo_retina', true);
                        $logo_sticky_overr = get_post_meta($page_id, '_nasa_custom_logo_sticky', true);
                        $logo_m_overr = get_post_meta($page_id, '_nasa_custom_logo_m', true);
                    }
                }
            }
            
            /**
             * For Root Category
             */
            else {
                $logo_cat_flag = get_term_meta($root_term_id, 'cat_logo_flag', true);
                if ($logo_cat_flag === 'on') {
                    $logo_id = get_term_meta($root_term_id, 'cat_logo', true);
                    $logo_retina_id = get_term_meta($root_term_id, 'cat_logo_retina', true);
                    $logo_sticky_id = get_term_meta($root_term_id, 'cat_logo_sticky', true);
                    $logo_m_id = get_term_meta($root_term_id, 'cat_logo_m', true);

                    $logo_link_overr = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : $logo_link_overr;
                    $logo_retina_overr = $logo_retina_id ? wp_get_attachment_image_url($logo_retina_id, 'full') : $logo_retina_overr;
                    $logo_sticky_overr = $logo_sticky_id ? wp_get_attachment_image_url($logo_sticky_id, 'full') : $logo_sticky_overr;
                    $logo_m_overr = $logo_m_id ? wp_get_attachment_image_url($logo_m_id, 'full') : $logo_m_overr;
                }
            }
            
            $logo_link = $logo_link_overr ? $logo_link_overr : $logo_link;
            $logo_retina = $logo_retina_overr ? $logo_retina_overr : ($logo_retina ? $logo_retina : false);
            $logo_sticky = $logo_sticky_overr ? $logo_sticky_overr : ($logo_sticky ? $logo_sticky : false);
            $logo_m = $logo_m_overr ? $logo_m_overr : ($logo_m ? $logo_m : false);
            
            $logo_class = 'header_logo';
            $logo_class = apply_filters('nasa_logo_classes', $logo_class);
            
            $site_title = esc_attr(get_bloginfo('name', 'display'));
            
            $class_wrap = 'logo nasa-logo-retina';
            $content_logo = '';
            
            if ($logo_link) {
                $img_attrs = array(
                    'src="' . esc_url($logo_link) . '"',
                    'alt="' . $site_title . '"',
                    'class="' . esc_attr($logo_class) . '"'
                );

                if ($logo_retina) {
                    $img_attrs[] = 'data-src-retina="' . esc_url($logo_retina) . '"';
                }
                
                if (isset($nasa_opt['logo_width']) && (int) $nasa_opt['logo_width']) {
                    $img_attrs[] = 'width="' . ((int) $nasa_opt['logo_width']) . '"';
                }
                
                if (isset($nasa_opt['logo_height']) && (int) $nasa_opt['logo_height']) {
                    $img_attrs[] = 'height="' . ((int) $nasa_opt['logo_height']) . '"';
                }
                
                /**
                 * Main Logo
                 */
                $content_logo .= '<img ' . implode(' ', $img_attrs) . ' />';
                
                /**
                 * Sticky Logo
                 */
                if ($logo_sticky) {
                    $logo_sticky_class = 'header_logo logo_sticky';
                    $logo_sticky_class = apply_filters('nasa_logo_sticky_classes', $logo_sticky_class);
                    $img_sticky_attrs = array(
                        'src="' . esc_url($logo_sticky) . '"',
                        'alt="' . $site_title . '"',
                        'class="' . esc_attr($logo_sticky_class) . '"'
                    );
                    
                    if (isset($nasa_opt['logo_sticky_width']) && (int) $nasa_opt['logo_sticky_width']) {
                        $img_sticky_attrs[] = 'width="' . ((int) $nasa_opt['logo_sticky_width']) . '"';
                    }

                    if (isset($nasa_opt['logo_sticky_height']) && (int) $nasa_opt['logo_sticky_height']) {
                        $img_sticky_attrs[] = 'height="' . ((int) $nasa_opt['logo_sticky_height']) . '"';
                    }
                    
                    $content_logo .= '<img ' . implode(' ', $img_sticky_attrs) . ' />';
                    $class_wrap .= ' nasa-has-sticky-logo';
                }
                
                /**
                 * Mobile Logo
                 */
                if ($logo_m) {
                    $logo_m_class = 'header_logo logo_mobile';
                    $logo_m_class = apply_filters('nasa_logo_mobile_classes', $logo_m_class);
                    $img_m_attrs = array(
                        'src="' . esc_url($logo_m) . '"',
                        'alt="' . $site_title . '"',
                        'class="' . esc_attr($logo_m_class) . '"'
                    );
                    
                    if (isset($nasa_opt['logo_width_mobile']) && (int) $nasa_opt['logo_width_mobile']) {
                        $img_m_attrs[] = 'width="' . ((int) $nasa_opt['logo_width_mobile']) . '"';
                    }

                    if (isset($nasa_opt['logo_height_mobile']) && (int) $nasa_opt['logo_height_mobile']) {
                        $img_m_attrs[] = 'height="' . ((int) $nasa_opt['logo_height_mobile']) . '"';
                    }
                    
                    $content_logo .= '<img ' . implode(' ', $img_m_attrs) . ' />';
                    $class_wrap .= ' nasa-has-mobile-logo';
                }
            
            /**
             * Default Text without Logo IMG
             */
            } else {
                $content .= get_bloginfo('name', 'display');
            }
            
            /**
             * Output Logo Site
             */
            $content = '<a class="' . $class_wrap . '" href="' . esc_url(home_url('/')) . '" title="' . $site_title . ' - ' . esc_attr(get_bloginfo('description', 'display')) . '" rel="' . esc_attr__('Home', 'elessi-theme') . '">' . $content_logo . '</a>';
            
            $GLOBALS['nasa_logo'] = $content;
            
            return $content;
        }
        
        return $nasa_logo;
    }
endif;

/**
 * Get search Product Post_type search mobile form
 */
add_filter('nasa_mobile_search_post_type', 'elessi_mobile_search_form_post_type');
if (!function_exists('elessi_mobile_search_form_post_type')) :
    function elessi_mobile_search_form_post_type($post_type) {
        global $nasa_opt;

        if (isset($nasa_opt['anything_search']) && $nasa_opt['anything_search']) {
            return false;
        }

        return $post_type;
    }
endif;

/**
 * Get search Product Post_type search
 */
if (!function_exists('elessi_search_form_product')) :
    function elessi_search_form_product($post_type) {
        global $nasa_opt;
        
        if (isset($nasa_opt['anything_search']) && $nasa_opt['anything_search']) {
            return false;
        }
        
        return 'product';
    }
endif;

/**
 * Get search Post Post_type search
 */
if (!function_exists('elessi_search_form_post')) :
    function elessi_search_form_post($post_type) {
        global $nasa_opt;
        
        if (isset($nasa_opt['anything_search']) && $nasa_opt['anything_search']) {
            return false;
        }
        
        return 'post';
    }
endif;

/**
 * Get header search
 */
if (!function_exists('elessi_search')) :
    function elessi_search($search_type = 'icon', $return = true) {
        global $nasa_opt;
        
        add_filter('nasa_search_post_type', 'elessi_search_form_product');
        
        $class_wrap = ' nasa_search_' . $search_type;
        
        // Icon - Full
        $class = $search_type == 'icon' ? ' nasa-over-hide' : ' nasa-search-relative';
        
        // Effect Classic
        $class .= isset($nasa_opt['search_effect']) && $nasa_opt['search_effect'] ? ' nasa-' . $nasa_opt['search_effect'] : '';
        
        // Modern
        $class .= isset($nasa_opt['search_layout']) && $nasa_opt['search_layout'] == 'modern' ? ' nasa-modern-layout' : '';
        
        $tmpl = $search_type == 'icon' && isset($nasa_opt['tmpl_html']) && $nasa_opt['tmpl_html'] ? true : false;
        
        $search = '';
        $search .= $tmpl ? '<template class="nasa-tmpl-search">' : '';
        $search .= '<div class="nasa-search-space' . esc_attr($class_wrap) . '">';
        $search .= '<div class="nasa-show-search-form' . $class . '">';
        $search .= get_search_form(false);
        $search .= '</div>';
        $search .= '</div>';
        $search .= $tmpl ? '</template>' : '';
        
        add_filter('nasa_search_post_type', 'elessi_search_form_post');
        
        if ($return) {
            return $search;
        }
        
        echo $search;
    }
endif;

/**
 * Get Main-menu
 */
if (!function_exists('elessi_get_main_menu')) :
    function elessi_get_main_menu($return = false) {
        $mega = class_exists('Nasa_Nav_Menu');
        $walker = $mega ? new Nasa_Nav_Menu() : new Walker_Nav_Menu();
        
        if (has_nav_menu('primary')) {
            $depth = apply_filters('nasa_max_depth_main_menu', 3);

            $nasa_main_menu = wp_nav_menu(array(
                'echo' => false,
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '%3$s',
                'depth' => (int) $depth,
                'walker' => $walker
            ));
        } else {
            $allowed_html = array(
                'li' => array(),
                'b' => array()
            );

            $nasa_main_menu = wp_kses(__('<li>Please Define menu in <b>Apperance > Menus</b></li>', 'elessi-theme'), $allowed_html);
        }
        
        $class = 'header-nav nasa-to-menu-mobile';
        $class .= $mega ? '' : ' nasa-wp-simple-nav-menu';
        
        $result = '';
        
        $result .= '<div class="nav-wrapper main-menu-warpper">';
        $result .= '<ul id="site-navigation" class="' . $class . '">';
        $result .= $nasa_main_menu;
        $result .= '</ul>';
        $result .= '</div><!-- nav-wrapper -->';
        
        if ($return) {
            return $result;
        }
        
        echo $result;
    }
endif;

/**
 * Get Menu
 */
if (!function_exists('elessi_get_menu')) :
    function elessi_get_menu($menu_location = '', $class = "", $depth = 3) {
        if ($menu_location != '' && has_nav_menu($menu_location)) {
            $depth = apply_filters('nasa_max_depth_menu', $depth);
            
            $mega = class_exists('Nasa_Nav_Menu');
            $walker = $mega ? new Nasa_Nav_Menu() : new Walker_Nav_Menu();
            $classes = $mega ? 'nasa-nav-menu' : 'nasa-wp-simple-nav-menu';
            $classes .= $class != '' ? ' ' . $class : '';
            
            echo '<ul class="' . esc_attr($classes) . '">';
            
            wp_nav_menu(array(
                'theme_location' => $menu_location,
                'container' => false,
                'items_wrap' => '%3$s',
                'depth' => (int) $depth,
                'walker' => $walker
            ));
            
            echo '</ul>';
        }
    }
endif;

/**
 * Get Vertical-menu
 */
if (!function_exists('elessi_get_vertical_menu')) :
    function elessi_get_vertical_menu() {
        global $nasa_vertical_menu;

        if (!$nasa_vertical_menu) {
            global $nasa_opt, $wp_query;
            
            $page_id = $menu_overr = false;
            $menu = isset($nasa_opt['vertical_menu_selected']) ? $nasa_opt['vertical_menu_selected'] : false;
            
            $rootCatId = elessi_get_root_term_id();
            if (!$rootCatId) {
                $is_shop = $pageShop = $is_product_taxonomy = false;
                
                if (NASA_WOO_ACTIVED) {
                    $is_shop = is_shop();
                    $is_product_taxonomy = is_product_taxonomy();
                    $pageShop = wc_get_page_id('shop');
                }

                if (($is_shop || $is_product_taxonomy) && $pageShop > 0) {
                    $page_id = $pageShop;
                }

                /**
                 * Page
                 */
                if (!$page_id) {
                    $page_id = $wp_query->get_queried_object_id();
                }

                /**
                 * Switch footer
                 */
                if ($page_id) {
                    $menu_overr = get_post_meta($page_id, '_nasa_vertical_menu_selected', true);
                }
            }
            
            /**
             * For Root Category
             */
            else {
                $menu_overr = get_term_meta($rootCatId, 'cat_header_vertical_menu', true);
            }
            
            if ($menu_overr) {
                $menu = $menu_overr;
            }

            if (!$menu) {
                $locations = get_theme_mod('nav_menu_locations');
                $menu = isset($locations['vetical-menu']) && $locations['vetical-menu'] ? $locations['vetical-menu'] : null;
            }

            if ($menu && $menu != '-1') {
                $show = $page_id ? get_post_meta($page_id, '_nasa_vertical_menu_allways_show', true) : false;
                $nasa_wrap = 'vertical-menu nasa-vertical-header';
                $nasa_class = $show ? ' nasa-allways-show' : '';
                $nasa_wrap .= $show ? ' nasa-allways-show-warp' : '';
                $nasa_wrap .= NASA_RTL ? ' nasa-menu-ver-align-right' : ' nasa-menu-ver-align-left';
                $nasa_wrap .= isset($nasa_opt['order_mobile_menus']) && $nasa_opt['order_mobile_menus'] == 'v-focus' ? ' nasa-focus-menu' : '';

                $mega = class_exists('Nasa_Nav_Menu');
                $walker = $mega ? new Nasa_Nav_Menu() : new Walker_Nav_Menu();
                $class = $mega ? '' : ' nasa-wp-simple-nav-menu';
                
                $depth = apply_filters('nasa_max_depth_vertical_menu', 3);
                
                ob_start();
                ?>
                <div class="<?php echo esc_attr($nasa_wrap); ?>">
                    <h5 class="section-title nasa-title-vertical-menu">
                        <?php echo esc_html__('Browse Categories', 'elessi-theme'); ?>
                    </h5>
                    <div class="vertical-menu-container<?php echo esc_attr($nasa_class); ?>">
                        <ul class="vertical-menu-wrapper<?php echo esc_attr($class); ?>">
                            <?php
                            wp_nav_menu(array(
                                'menu' => $menu,
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'depth' => (int) $depth,
                                'walker' => $walker
                            ));
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
                
                $nasa_vertical_menu = ob_get_clean();
                $GLOBALS['nasa_vertical_menu'] = $nasa_vertical_menu;
            }
        }
        
        echo $nasa_vertical_menu ? $nasa_vertical_menu : '';
    }
endif;

/**
 * Back URL by javascript
 */
if (!function_exists('elessi_back_to_page')) :
    function elessi_back_to_page() {
        echo '<a class="back-history" href="javascript: history.go(-1)">';
        echo esc_html__('Return to Previous Page', 'elessi-theme');
        echo '</a>';
    }
endif;

/**
 * Add body class
 */
add_filter('body_class', 'elessi_body_classes');
if (!function_exists('elessi_body_classes')) :
    function elessi_body_classes($classes) {
        global $nasa_opt;

        $classes[] = 'antialiased';
        if (is_multi_author()) {
            $classes[] = 'group-blog';
        }

        if (isset($nasa_opt['site_layout']) && $nasa_opt['site_layout'] == 'boxed') {
            $classes[] = 'boxed';
        }

        if (isset($nasa_opt['promo_popup']) && $nasa_opt['promo_popup'] == 1) {
            $classes[] = 'open-popup';
        }

        if (NASA_WOO_ACTIVED) {
            if (!in_array('nasa-woo-actived', $classes)) {
                $classes[] = 'nasa-woo-actived';
            }
            
            if (is_product()) {
                if (isset($nasa_opt['product-zoom']) && $nasa_opt['product-zoom']) {
                    $classes[] = 'product-zoom';
                }

                if (isset($nasa_opt['product-image-lightbox']) && !$nasa_opt['product-image-lightbox']) {
                    $classes[] = 'nasa-disable-lightbox-image';
                }
            }
            
            if (!isset($nasa_opt['disable-quickview']) || !$nasa_opt['disable-quickview']) {
                $classes[] = 'nasa-quickview-on';
            }
            
            if (isset($nasa_opt['enable_focus_main_image']) && $nasa_opt['enable_focus_main_image'] == 1) {
                $classes[] = 'nasa-focus-main-image';
            }
        }
        
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
            $classes[] = 'nasa-in-mobile';
        }
        
        if (isset($nasa_opt['toggle_widgets']) && !$nasa_opt['toggle_widgets']) {
            $classes[] = 'nasa-disable-toggle-widgets';
        }
        
        if ((!isset($nasa_opt['disable_wow']) || !$nasa_opt['disable_wow'])) {
            $classes[] = 'nasa-enable-wow';
        }
        
        if ((isset($nasa_opt['flexible_menu']) && !$nasa_opt['flexible_menu'])) {
            $classes[] = 'disable-flexible-menu';
        }
        
        if (NASA_RTL) {
            $classes[] = 'nasa-rtl';
        }

        return $classes;
    }
endif;

/**
 * Check BG Dark
 */
add_action('wp_enqueue_scripts', 'elessi_bg_dark');
if (!function_exists('elessi_bg_dark')) :
    function elessi_bg_dark() {
        global $post, $nasa_opt;

        $dark_version = isset($nasa_opt['site_bg_dark']) && $nasa_opt['site_bg_dark'] ? true : false;
        $dark_version_overr = '';
        $page_id = false;

        /**
         * Override Header
         */
        $root_term_id = elessi_get_root_term_id();
        
        if (!$root_term_id) {
            $is_shop = $page_shop = $is_product_taxonomy = $is_product = false;
            
            if (NASA_WOO_ACTIVED) {
                $is_shop = is_shop();
                $is_product_taxonomy = is_product_taxonomy();
                $page_shop = wc_get_page_id('shop');
            }
            
            /**
             * Store Page
             */
            if (($is_shop || $is_product_taxonomy) && $page_shop > 0) {
                $page_id = $page_shop;
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
                $dark_version_overr = get_post_meta($page_id, '_nasa_site_bg_dark', true);
            }
        }

        else {
            /**
             * For Root category (parent = 0)
             */
            $dark_version_overr = get_term_meta($root_term_id, 'cat_bg_dark', true);
        }

        $dark_version = $dark_version_overr !== '' ? $dark_version_overr : $dark_version;
        $dark_version = $dark_version === '-1' ? false : $dark_version;
        
        if ($dark_version) {
            add_filter('body_class', 'elessi_bg_dark_classes');
            wp_enqueue_style('elessi-dark-version', ELESSI_THEME_URI . '/assets/css/style-dark.css', array('elessi-style'));
        }
    }
endif;

/**
 * Add Class Dark version
 */
if (!function_exists('elessi_bg_dark_classes')) :
    function elessi_bg_dark_classes($classes) {
        $classes[] = 'nasa-dark';
        
        return $classes;
    }
endif;

/**
 * Comments
 */ 
if (!function_exists('elessi_comment')) :
    function elessi_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' : ?>
                <li class="post pingback">
                    <p><?php esc_html_e('Pingback:', 'elessi-theme'); ?> <?php comment_author_link(); ?><?php edit_comment_link(esc_html__('Edit', 'elessi-theme'), '<span class="edit-link">', '<span>'); ?></p>
                <?php
                break;
            default : ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment-inner">
                        <div class="comment-author left padding-right-15 rtl-right rtl-padding-right-0 rtl-padding-left-15">
                            <?php echo get_avatar($comment, 80); ?>
                        </div>
                        
                        <div class="comment-info">
                            <?php printf('<cite class="fn">%s</cite>', get_comment_author_link()); ?>
                            <div class="comment-meta">
                                <i class="fa fa-clock-o"></i>
                                <time datetime="<?php comment_time('c'); ?>">
                                    <?php printf(_x('%1$s at %2$s', '1: date, 2: time', 'elessi-theme'), get_comment_date(), get_comment_time()); ?>
                                </time>
                                <?php edit_comment_link(esc_html__('Edit', 'elessi-theme'), '<span class="edit-link">', '<span>'); ?>
                            </div>
                            
                            <div class="reply">
                                <?php
                                comment_reply_link(array_merge($args, array(
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth'],
                                )));
                                ?>
                            </div>
                            
                            <?php if ($comment->comment_approved == '0') : ?>
                                <em>
                                    <?php esc_html_e('Your comment is awaiting moderation.', 'elessi-theme'); ?>
                                </em><br />
                            <?php endif; ?>

                            <div class="comment-content">
                                <?php comment_text(); ?>
                            </div>
                        </div>
                    </article>
                <?php
                break;
        endswitch;
    }
endif;

/**
 * Post meta top
 */  
if (!function_exists('elessi_posted_on')) :
    function elessi_posted_on() {
        $allowed_html = array(
            'span' => array('class' => array()),
            'strong' => array(),
            'a' => array('class' => array(), 'href' => array(), 'title' => array(), 'rel' => array()),
            'time' => array('class' => array(), 'datetime' => array())
        );
        
        $day = get_the_date('d');
        $month = get_the_date('m');
        $year = get_the_date('Y');
        $author = get_the_author();
        printf(
            wp_kses(
                __('<span class="meta-author">By <a class="url fn n nasa-bold" href="%5$s" title="%6$s" rel="author">%7$s</a>.</span> Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date nasa-bold" datetime="%3$s">%4$s</time></a>', 'elessi-theme'), $allowed_html
            ),
            esc_url(get_day_link($year, $month, $day)),
            esc_attr(get_the_time()),
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_attr(
                sprintf(
                    esc_html__('View all posts by %s', 'elessi-theme'),
                    $author
                )
            ),
            $author
        );
    }
endif;

/**
 * Promo Popup
 */
add_action('wp_footer', 'elessi_promo_popup');
if (!function_exists('elessi_promo_popup')) :
    function elessi_promo_popup() {
        global $nasa_opt;
        if (!isset($nasa_opt['promo_popup']) || !$nasa_opt['promo_popup']) {
            return;
        }
        
        $popup_closed = isset($_COOKIE['nasa_popup_closed']) ? $_COOKIE['nasa_popup_closed'] : '';
        if ($popup_closed === 'do-not-show') {
            return;
        }
        
        $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        
        // Disable popup on mobile
        $disableMobile = (isset($nasa_opt['disable_popup_mobile']) && (int) $nasa_opt['disable_popup_mobile']) ? 'true' : 'false';
        if ($disableMobile === 'true' && $inMobile) {
            return;
        }
        
        $one_time = isset($nasa_opt['promo_popup_1_time']) && $nasa_opt['promo_popup_1_time'] ? '1' : '0';
        
        $delay = (!isset($nasa_opt['delay_promo_popup']) || (int) $nasa_opt['delay_promo_popup'] <= 0) ? 0 : (int) $nasa_opt['delay_promo_popup'];
        
        echo '<a class="nasa-popup open-click popup_link hidden-tag" href="#nasa-popup" data-delay="' . esc_attr($delay) . '" data-disable_mobile="' . esc_attr($disableMobile) . '" data-one_time="' . esc_attr($one_time) . '">' . esc_html__('Newsletter', 'elessi-theme') . '</a>';
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-promo-popup.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-promo-popup.php';
    }
endif;

/**
 * Add parent class to menu item
 */
add_filter('wp_nav_menu_objects', 'elessi_add_menu_parent_class');
if (!function_exists('elessi_add_menu_parent_class')) :
    function elessi_add_menu_parent_class($items) {
        $parents = array();
        foreach ($items as $item) {
            if ($item->menu_item_parent && $item->menu_item_parent > 0) {
                $parents[] = $item->menu_item_parent;
            }
        }

        foreach ($items as $item) {
            if (in_array($item->ID, $parents)) {
                $item->classes[] = 'menu-parent-item';
            }
        }

        return $items;
    }
endif;

/**
 * Multi Languages Flags + Multi Currencies
 */
add_action('nasa_topbar_menu', 'elessi_multi_languages', 10);
add_action('nasa_mobile_topbar_menu', 'elessi_multi_languages', 10);
add_action('nasa_multi_lc', 'elessi_multi_languages');
if (!function_exists('elessi_multi_languages')) :
    function elessi_multi_languages() {
        global $nasa_opt;

        $outputHtml = '';
        
        /**
         * Multi Languages
         */
        if (isset($nasa_opt['switch_lang']) && $nasa_opt['switch_lang']) {
            $language_output = '<li class="nasa-select-languages left rtl-right desktop-margin-right-30 rtl-desktop-margin-right-0 rtl-desktop-margin-left-30 menu-item-has-children root-item li_accordion">';
            $mainLang = '';
            $selectLang = '<ul class="nasa-list-languages sub-menu">';

            if (function_exists('icl_get_languages')) {
                $current = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : get_option('WPLANG');

                $languages = icl_get_languages('skip_missing=0&orderby=code');
                if (!empty($languages)) {
                    foreach ($languages as $lang) {
                        /**
                         * Current Language
                         */
                        if ($current == $lang['language_code']) {
                            $mainLang .= '<a href="javascript:void(0);" class="nasa-current-lang" rel="nofollow">';

                            if (isset($lang['country_flag_url'])) {
                                $mainLang .= '<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang['native_name']) . '" width="18" height="12" />';
                            }

                            $mainLang .= $lang['native_name'];
                            $mainLang .= '</a>';
                        }

                        /**
                         * Select Languages
                         */
                        else {
                            $selectLang .= '<li class="nasa-item-lang"><a href="' . esc_url($lang['url']) . '" title="' . esc_attr($lang['native_name']) . '">';

                            if (isset($lang['country_flag_url'])) {
                                $selectLang .= '<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang['native_name']) . '" width="18" height="12" />';
                            }

                            $selectLang .= $lang['native_name'];
                            $selectLang .= '</a></li>';
                        }
                    }
                }
            }

            /**
             * have not installs WPML
             */
            else {
                $mainLang .= '<a href="javascript:void(0);" class="nasa-current-lang" title="' . esc_attr__('English', 'elessi-theme') . '" rel="nofollow">';
                $mainLang .= '<img src="' . esc_url(ELESSI_THEME_URI . '/assets/images/en.png') . '" alt="' . esc_attr__('English', 'elessi-theme') . '" width="18" height="12" />';
                $mainLang .= esc_html__('English', 'elessi-theme');
                $mainLang .= '</a>';

                /**
                 * Select Languages
                 */
                // Deutsch
                $selectLang .= '<li class="nasa-item-lang"><a href="#" title="' . esc_attr__('Deutsch', 'elessi-theme') . '">';
                $selectLang .= '<img src="' . esc_url(ELESSI_THEME_URI . '/assets/images/de.png') . '" alt="' . esc_attr__('Deutsch', 'elessi-theme') . '" width="18" height="12" />';

                $selectLang .= esc_html__('Deutsch', 'elessi-theme');
                $selectLang .= '</a></li>';

                // Français
                $selectLang .= '<li class="nasa-item-lang"><a href="#" title="' . esc_attr__('Français', 'elessi-theme') . '">';
                $selectLang .= '<img src="' . esc_url(ELESSI_THEME_URI . '/assets/images/fr.png') . '" alt="' . esc_attr__('Français', 'elessi-theme') . '" width="18" height="12" />';

                $selectLang .= esc_html__('Français', 'elessi-theme');
                $selectLang .= '</a></li>';
                
                // Requires WPML
                $selectLang .= '<li class="nasa-item-lang"><a href="#" title="' . esc_attr__('Requires WPML', 'elessi-theme') . '">';
                $selectLang .= esc_html__('&nbsp;Requires WPML', 'elessi-theme');
                $selectLang .= '</a></li>';
            }

            $selectLang .= '</ul>';

            $language_output .= $mainLang . $selectLang . '</li>';
            
            $outputHtml .= $language_output;
        }
        
        /**
         * Multi Currencies
         */
        if (isset($nasa_opt['switch_currency']) && $nasa_opt['switch_currency']) {
            $format = (!isset($nasa_opt['switch_currency_format']) || trim($nasa_opt['switch_currency_format']) === '') ? '(%symbol%) %code%' : $nasa_opt['switch_currency_format'];
            
            $currency_output = '';
            
            /**
             * WPML + WooCommerce Multilingual
             */
            if (shortcode_exists('currency_switcher')) {
                $currency_output .= do_shortcode('[currency_switcher switcher_style="wcml-dropdown" format="' . esc_attr($format) . '"]');
            }
            
            /**
             * For Demo
             */
            else {
                $currency_output .=
                '<div class="wcml-dropdown product wcml_currency_switcher">' .
                    '<ul>' .
                        '<li class="wcml-cs-active-currency">' .
                            '<a href="#" class="wcml-cs-item-toggle" title="Requires package of WPML">US Dollar</a>' .
                            '<ul class="wcml-cs-submenu">' .
                                '<li><a href="#">Euro (EUR)</a></li>' .
                                '<li><a href="#">Indian Rupee (INR)</a></li>' .
                                '<li><a href="#">Requires WPML</a></li>' .
                            '</ul>' .
                        '</li>' .
                    '</ul>' .
                '</div>';
            }
            
            $outputHtml .= trim($currency_output) ? '<li class="nasa-select-currencies left rtl-right desktop-margin-right-30 rtl-desktop-margin-right-0 rtl-desktop-margin-left-30">' . $currency_output . '</li>' : '';
        }

        echo $outputHtml ? '<ul class="header-multi-languages left rtl-right">' . $outputHtml . '</ul>' : '';
    }
endif;

/**
 * Blog post navigation
 */
if (!function_exists('elessi_content_nav')) :
    function elessi_content_nav($nav_id) {
        global $wp_query, $post;
        
        $allowed_html = array(
            'span' => array('class' => array())
        );
        
        $is_single = is_single();

        if ($is_single) {
            $previous = (is_attachment()) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
            $next = get_adjacent_post(false, '', false);

            if (!$next && !$previous) {
                return;
            }
        }

        if ($wp_query->max_num_pages < 2 && (is_home() || is_archive() || is_search())) {
            return;
        }

        $nav_class = $is_single ? 'navigation-post' : 'navigation-paging';
        ?>
        <nav role="navigation" id="<?php echo esc_attr($nav_id); ?>" class="<?php echo esc_attr($nav_class); ?>">
            <?php
            if ($is_single) {
                previous_post_link('<div class="nav-previous left">%link</div>', '<span class="fa fa-caret-left">' . _x('', 'Previous post link', 'elessi-theme') . '</span> %title');
                next_post_link('<div class="nav-next right">%link</div>', '%title <span class="fa fa-caret-right">' . _x('', 'Next post link', 'elessi-theme') . '</span>');
            } elseif ($wp_query->max_num_pages > 1 && (is_home() || is_archive() || is_search())) {
                // navigation links for home, archive, and search pages
                if (get_next_posts_link()) {
                    ?>
                    <div class="nav-previous"><?php next_posts_link(wp_kses(__('Next <span class="fa fa-caret-right"></span>', 'elessi-theme'), $allowed_html)); ?></div>
                    <?php
                }
                if (get_previous_posts_link()) {
                    ?>
                    <div class="nav-next"><?php previous_posts_link(wp_kses(__('<span class="fa fa-caret-left"></span> Previous', 'elessi-theme'), $allowed_html)); ?></div>
                    <?php
                }
            }
            ?>
        </nav>
        <?php
    }
endif;

/**
 * Add shortcode Top bar Promotion news
 */
if (!function_exists('elessi_promotion_recent_post')):
    function elessi_promotion_recent_post() {
        global $nasa_opt;

        if (isset($nasa_opt['enable_post_top']) && !$nasa_opt['enable_post_top']) {
            return '';
        }

        $content = '';
        $posts = null;

        if (!isset($nasa_opt['type_display']) || $nasa_opt['type_display'] == 'custom') {
            $content = isset($nasa_opt['content_custom']) ? $nasa_opt['content_custom'] : '';
        }
        else {
            if (!isset($nasa_opt['category_post']) || !$nasa_opt['category_post']) {
                $nasa_opt['category_post'] = null;
            }

            if (!isset($nasa_opt['number_post']) || !$nasa_opt['number_post']) {
                $nasa_opt['number_post'] = 4;
            }

            $args = array(
                'post_status' => 'publish',
                'post_type' => 'post',
                'orderby' => 'date',
                'order' => 'DESC',
                'category' => ((int) $nasa_opt['category_post'] != 0) ? (int) $nasa_opt['category_post'] : null,
                'posts_per_page' => $nasa_opt['number_post']
            );

            $posts = get_posts($args);
        }

        $file = ELESSI_CHILD_PATH . '/includes/nasa-blog-promotion.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-blog-promotion.php';
    }
endif;

/**
 * Before load effect site
 */
add_action('nasa_theme_before_load', 'elessi_theme_before_load');
if (!function_exists('elessi_theme_before_load')):
    function elessi_theme_before_load() {
        global $nasa_opt;

        if (!isset($nasa_opt['effect_before_load']) || $nasa_opt['effect_before_load'] == 1) {
            echo 
            '<div id="nasa-before-load">' .
                '<div class="nasa-loader"></div>' .
            '</div>';
        }
    }
endif;

/**
 * Compatible with Plugin Nextend Social Login
 */
add_action('woocommerce_login_form_end', 'elessi_social_login');
if (!function_exists('elessi_social_login')) :
    function elessi_social_login() {
        if (shortcode_exists('nextend_social_login') && !NASA_CORE_USER_LOGGED) :
            echo '<div class="nasa-social-login-title"><h5>' . esc_html__('Or Login With', 'elessi-theme') . '</h5></div>';
            echo '<div class="form-row row-submit-login-social text-center">';
            echo do_shortcode('[nextend_social_login]');
            echo '</div>';
        endif;
    }
endif;

/**
 * Prev | Next Post in single post
 */
add_action('nasa_after_content_single_post', 'elessi_prev_next_post', 10, 1);
if (!function_exists('elessi_prev_next_post')) :
    function elessi_prev_next_post() {
        $prevPost = get_previous_post(true);
        $nextPost = get_next_post(true);
        
        $hasPrevPost = is_a($prevPost, 'WP_Post');
        $hasNextPost = is_a($nextPost, 'WP_Post');
        
        if (!$hasPrevPost && !$hasNextPost) {
            return;
        }
        
        $html = '<div class="nasa-post-navigation">';
        
        $html .= '<div class="nasa-post-prev nasa-post-navigation-item">';
        if ($hasPrevPost) {
            $title = get_the_title($prevPost->ID);
            $link = get_the_permalink($prevPost->ID);
            $html .= '<a href="' . esc_url($link) . '" title="' . esc_attr($title) .'">';
            $html .= '<span class="nasa-post-label">' . esc_html__('PREVIOUS', 'elessi-theme') . '</span>';
            $html .= '<span class="nasa-post-title hide-for-mobile">' . $title . '</span>';
            $html .= '</a>';
        }
        $html .= '</div>';
        
        $archiveLink = get_permalink(get_option('page_for_posts'));
        $archiveLink = $archiveLink ? $archiveLink : home_url('/');
        $html .= '<div class="nasa-post-archive nasa-post-navigation-item">';
        $html .= '<a href="' . esc_url($archiveLink) . '" title="' . esc_attr__('Back to Blog', 'elessi-theme') .'">';
        $html .= '<span class="nasa-icon icon-nasa-icons-19"></span>';
        $html .= '</a>';
        $html .= '</div>';
        
        $html .= '<div class="nasa-post-next nasa-post-navigation-item">';
        if ($hasNextPost) {
            $title = get_the_title($nextPost->ID);
            $link = get_the_permalink($nextPost->ID);
            $html .= '<a href="' . esc_url($link) . '" title="' . esc_attr($title) .'">';
            $html .= '<span class="nasa-post-label">' . esc_html__('NEXT', 'elessi-theme') . '</span>';
            $html .= '<span class="nasa-post-title hide-for-mobile">' . $title . '</span>';
            $html .= '</a>';
        }
        $html .= '</div>';
        
        $html .= '</div>';
        
        echo $html;
    }
endif;

/**
 * Get contact form 7 Newsletter
 */
if (!function_exists('elessi_get_newsletter_form')) :
    function elessi_get_newsletter_form($id) {
        if (!shortcode_exists('contact-form-7') || !$id) {
            return '';
        }
        
        /**
         * Filter id with multi languages
         */
        $lang_id = false;
        if (function_exists('icl_object_id') && class_exists('WPCF7_ContactForm')) {
            $lang_id = icl_object_id($id, WPCF7_ContactForm::post_type, true);
        }
        
        $contact_id = $lang_id ? $lang_id : $id;
        
        return do_shortcode('[contact-form-7 id="' . esc_attr($contact_id) . '"]');
    }
endif;

/**
 * Check Blog Page
 */
if (!function_exists('elessi_check_blog_page')) :
    function elessi_check_blog_page() {
        global $nasa_blog_page;
        
        if (!isset($nasa_blog_page)) {
            global $post;
            
            $nasa_blog_page = (
                (isset($post->post_type) &&
                $post->post_type == 'post' &&
                (
                    is_home() ||
                    is_search() ||
                    is_front_page() ||
                    is_archive() ||
                    is_category() ||
                    is_tag() ||
                    is_date() ||
                    is_author() ||
                    is_single()
                )) ||
                (is_search() && (!isset($_REQUEST['post_type']) || !$_REQUEST['post_type']))
            ) ? true : false;
            
            $GLOBALS['nasa_blog_page'] = $nasa_blog_page;
        }
        
        return $nasa_blog_page;
    }
endif;
