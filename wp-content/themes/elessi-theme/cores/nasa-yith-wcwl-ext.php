<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Compatible with Yith WooCommerce Wishlist
 */
if (NASA_WISHLIST_ENABLE && class_exists('YITH_WCWL_Shortcode')) :

    class ELESSI_YITH_WCWL_Shortcode extends YITH_WCWL_Shortcode {

        /**
         * Init Class
         */
        public static function init() {
            if (!NASA_WISHLIST_NEW_VER) {
                add_shortcode('nasa_yith_wcwl_wishlist', array('ELESSI_YITH_WCWL_Shortcode', 'wishlist'));
            } else {
                add_shortcode('nasa_yith_wcwl_wishlist', array('ELESSI_YITH_WCWL_Shortcode', 'wishlist_new'));
            }
            
            add_filter('yith_wcwl_localize_script', array('ELESSI_YITH_WCWL_Shortcode', 'nasa_yith_wcwl_localize_script'));
        }
        
        /**
         * 
         * @param type $localize_script
         * @return type
         */
        public static function nasa_yith_wcwl_localize_script($localize_script) {
            if (isset($localize_script['labels']['added_to_cart_message'])) {
                
                $localize_script['labels']['added_to_cart_message'] = sprintf(
                    '<div class="woocommerce-message text-center" role="alert">%s</div>',
                    apply_filters(
                        'yith_wcwl_added_to_cart_message',
                        esc_html__('Product added to cart successfully!', 'elessi-theme')
                    )
                );
            }
            
            return $localize_script;
        }

        /**
         * Wishlist Sidebar OLD Version 2.x
         */
        public static function wishlist($atts = array(), $content = null) {
            global $yith_wcwl_is_wishlist, $yith_wcwl_wishlist_token;

            $atts = shortcode_atts(array(
                'per_page' => 5,
                // 'pagination' => 'no',
                'wishlist_id' => false,
                'action_params' => get_query_var(YITH_WCWL()->wishlist_param, false)
            ), $atts);

            $available_views = apply_filters('yith_wcwl_available_wishlist_views', array('view', 'user'));

            extract($atts);
            
            $pagination = 'no';

            // retrieve options from query string
            $action_params = explode('/', apply_filters('yith_wcwl_current_wishlist_view_params', $action_params));
            $action = (isset($action_params[0])) ? $action_params[0] : 'view';

            $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : false;

            // init params needed to load correct tempalte
            $additional_params = array();
            $template_part = 'view';

            /* === WISHLIST TEMPLATE === */
            if (
                empty($action) ||
                (!empty($action) && ( $action == 'view' || $action == 'user' ) ) ||
                (!empty($action) && ( $action == 'manage' || $action == 'create' ) && get_option('yith_wcwl_multi_wishlist_enable', false) != 'yes' ) ||
                (!empty($action) && !in_array($action, $available_views) ) ||
                !empty($user_id)
            ) {
                /*
                 * someone is requesting a wishlist
                 * -if user is not logged in..
                 *  -and no wishlist_id is passed, cookie wishlist is loaded
                 *  -and a wishlist_id is passed, checks if wishlist is public or shared, and shows it only in this case
                 * -if user is logged in..
                 *  -and no wishlist_id is passed, default wishlist is loaded
                 *  -and a wishlist_id is passed, checks owner of the wishlist
                 *   -if wishlist is of the logged user, shows it
                 *   -if wishlist is of another user, checks if wishlist is public or shared, and shows it only in this case (if user is admin, can see all wishlists)
                 */

                if (empty($wishlist_id)) {
                    if (!empty($action) && $action == 'user') {
                        $user_id = isset($action_params[1]) ? $action_params[1] : false;
                        $user_id = (!$user_id) ? get_query_var($user_id, false) : $user_id;
                        $user_id = (!$user_id) ? get_current_user_id() : $user_id;

                        $wishlists = YITH_WCWL()->get_wishlists(array('user_id' => $user_id, 'is_default' => 1));

                        if (!empty($wishlists) && isset($wishlists[0])) {
                            $wishlist_id = $wishlists[0]['wishlist_token'];
                        } else {
                            $wishlist_id = false;
                        }
                    } else {
                        $wishlist_id = isset($action_params[1]) ? $action_params[1] : false;
                        $wishlist_id = (!$wishlist_id) ? get_query_var('wishlist_id', false) : $wishlist_id;
                    }
                }

                $is_user_owner = false;
                $query_args = array();

                if (!empty($user_id)) {
                    $query_args['user_id'] = $user_id;
                    $query_args['is_default'] = 1;

                    if (get_current_user_id() == $user_id) {
                        $is_user_owner = true;
                    }
                } elseif (!is_user_logged_in()) {
                    if (empty($wishlist_id)) {
                        $query_args['wishlist_id'] = false;
                        $is_user_owner = true;
                    } else {
                        $is_user_owner = false;

                        $query_args['wishlist_token'] = $wishlist_id;
                        $query_args['wishlist_visibility'] = 'visible';
                    }
                } else {
                    if (empty($wishlist_id)) {
                        $query_args['user_id'] = get_current_user_id();
                        $query_args['is_default'] = 1;
                        $is_user_owner = true;
                    } else {
                        $wishlist = YITH_WCWL()->get_wishlist_detail_by_token($wishlist_id);
                        $is_user_owner = $wishlist['user_id'] == get_current_user_id();

                        $query_args['wishlist_token'] = $wishlist_id;

                        if (!empty($wishlist) && $wishlist['user_id'] != get_current_user_id()) {
                            $query_args['user_id'] = false;
                            if (!current_user_can(apply_filters('yith_wcwl_view_wishlist_capability', 'manage_options'))) {
                                $query_args['wishlist_visibility'] = 'visible';
                            }
                        }
                    }
                }

                // counts number of elements in wishlist for the user
                $count = YITH_WCWL()->count_products($wishlist_id);

                // sets current page, number of pages and element offset
                $current_page = max(1, get_query_var('paged'));

                // sets variables for pagination, if shortcode atts is set to yes
                if ($pagination == 'yes' && $count > 1) {
                    $pages = ceil($count / $per_page);

                    if ($current_page > $pages) {
                        $current_page = $pages;
                    }

                    $offset = ($current_page - 1) * $per_page;

                    if ($pages > 1) {
                        $page_links = paginate_links(array(
                            'base' => esc_url(add_query_arg(array('paged' => '%#%'), YITH_WCWL()->get_wishlist_url('view' . '/' . $wishlist_id))),
                            'format' => '?paged=%#%',
                            'current' => $current_page,
                            'total' => $pages,
                            'show_all' => true
                        ));
                    }

                    $query_args['limit'] = $per_page;
                    $query_args['offset'] = $offset;
                }

                if (empty($wishlist_id) && is_user_logged_in()) {
                    $wishlists = YITH_WCWL()->get_wishlists(array('user_id' => get_current_user_id(), 'is_default' => 1));
                    if (!empty($wishlists)) {
                        $wishlist_id = $wishlists[0]['wishlist_token'];
                    }
                }

                $yith_wcwl_wishlist_token = $wishlist_id;

                // retrieve items to print
                $wishlist_items = YITH_WCWL()->get_products($query_args);

                // retrieve wishlist information
                $wishlist_meta = YITH_WCWL()->get_wishlist_detail_by_token($wishlist_id);
                $is_default = $wishlist_meta['is_default'] == 1;
                $wishlist_token = !empty($wishlist_meta['wishlist_token']) ? $wishlist_meta['wishlist_token'] : false;

                // retireve wishlist title
                $default_wishlist_title = get_option('yith_wcwl_wishlist_title');

                $wishlist_title = $is_default ? $default_wishlist_title : $wishlist_meta['wishlist_name'];

                // retrieve estimate options
                $show_ask_estimate_button = get_option('yith_wcwl_show_estimate_button') == 'yes';
                $ask_estimate_url = false;
                if ($show_ask_estimate_button) {
                    $ask_estimate_url = esc_url(wp_nonce_url(
                        add_query_arg(
                            'ask_an_estimate', !empty($wishlist_token) ? $wishlist_token : 'false', YITH_WCWL()->get_wishlist_url('view' . (!$is_default ? '/' . $wishlist_token : '' ))
                        ), 'ask_an_estimate', 'estimate_nonce'
                    ));
                }
                
                $show_date_added = get_option('yith_wcwl_show_dateadded') == 'yes';
                $show_add_to_cart = get_option('yith_wcwl_add_to_cart_show' ) == 'yes';

                $additional_params = array(
                    // wishlist items
                    'count' => $count,
                    'wishlist_items' => $wishlist_items,
                    // wishlist data
                    'wishlist_meta' => $wishlist_meta,
                    'is_default' => $is_default,
                    'is_custom_list' => !$is_default && $is_user_owner,
                    'wishlist_token' => $wishlist_token,
                    'wishlist_id' => $wishlist_meta['ID'],
                    'is_private' => $wishlist_meta['wishlist_privacy'] == 2,
                    //page data
                    'page_title' => $wishlist_title,
                    'default_wishlsit_title' => $default_wishlist_title,
                    'current_page' => $current_page,
                    'page_links' => isset($page_links) ? $page_links : false,
                    // user data
                    'is_user_logged_in' => is_user_logged_in(),
                    'is_user_owner' => $is_user_owner,
                    // view data
                    'show_price' => get_option('yith_wcwl_price_show') == 'yes',
                    'show_dateadded' => $show_date_added,
                    'show_ask_estimate_button' => $show_ask_estimate_button,
                    'ask_estimate_url' => $ask_estimate_url,
                    'show_stock_status' => get_option('yith_wcwl_stock_show') == 'yes',
                    'show_add_to_cart' => $show_add_to_cart,
                    'add_to_cart_text' => get_option('yith_wcwl_add_to_cart_text'),
                    'price_excl_tax' => get_option('woocommerce_tax_display_cart') == 'excl',
                    'show_cb' => false,
                    
                    // template data
                    'template_part' => $template_part,
                    'additional_info' => false,
                    'available_multi_wishlist' => false,
                    'users_wishlists' => array(),
                    'form_action' => esc_url(YITH_WCWL()->get_wishlist_url('view' . (!$is_default ? '/' . $wishlist_token : '' )))
                );
            }

            $additional_params = apply_filters('yith_wcwl_wishlist_params', $additional_params, $action, $action_params, $pagination, $per_page);
            $additional_params['template_part'] = isset($additional_params['template_part']) ? $additional_params['template_part'] : $template_part;

            $atts = array_merge(
                $atts, $additional_params
            );
            
            extract($atts);

            // sets that we're in the wishlist template
            $yith_wcwl_is_wishlist = true;

            ob_start();
            $template = ELESSI_CHILD_PATH . '/includes/nasa-sidebar-wishlist_content.php';
            include is_file($template) ? $template : ELESSI_THEME_PATH . '/includes/nasa-sidebar-wishlist_content.php';
            $content_wishlist = ob_get_clean();

            // we're not in wishlist template anymore
            $yith_wcwl_is_wishlist = false;
            $yith_wcwl_wishlist_token = null;

            return apply_filters('nasa_yith_wcwl_wishlisth_html', $content_wishlist, array(), true);
        }
        
        /**
         * For Yith_WooCommerce_Wishlist 3.0 or Higher
         */
        public static function wishlist_new($atts = array(), $content = null) {
            global $yith_wcwl_is_wishlist, $yith_wcwl_wishlist_token;

            $atts = shortcode_atts(array(
                'per_page' => 5,
                'wishlist_id' => false,
                'action_params' => get_query_var(YITH_WCWL()->wishlist_param, false),
                'no_interactions' => 'no',
                'layout' => ''
            ), $atts);

            /**
             * @var $per_page int
             * @var $wishlist_id int
             * @var $action_params array
             * @var $no_interactions string
             * @var $layout string
             */
            extract($atts);
            
            $pagination = 'no';

            // retrieve options from query string
            $action_params = explode('/', apply_filters('yith_wcwl_current_wishlist_view_params', $action_params));
            $action = (isset($action_params[0])) ? $action_params[0] : 'view';

            // retrieve options from db
            $default_wishlist_title = get_option('yith_wcwl_wishlist_title');
            $show_price = get_option('yith_wcwl_price_show') == 'yes';
            $show_stock = get_option('yith_wcwl_stock_show') == 'yes';
            $show_date_added = get_option('yith_wcwl_show_dateadded') == 'yes';
            $show_add_to_cart = get_option('yith_wcwl_add_to_cart_show') == 'yes';
            $show_remove_product = get_option('yith_wcwl_show_remove', 'yes') == 'yes';
            $show_variation = get_option('yith_wcwl_variation_show') == 'yes';
            $repeat_remove_button = get_option('yith_wcwl_repeat_remove_button') == 'yes';
            $add_to_cart_label = get_option('yith_wcwl_add_to_cart_text', __('Add to cart', 'yith-woocommerce-wishlist'));
            $price_excluding_tax = get_option('woocommerce_tax_display_cart') == 'excl';
            $ajax_loading = get_option('yith_wcwl_ajax_enable', 'no');

            // icons
            $icon = get_option('yith_wcwl_add_to_wishlist_icon');
            $custom_icon = get_option('yith_wcwl_add_to_wishlist_custom_icon');

            if ('custom' == $icon){
                $heading_icon = '<img src="' . $custom_icon . '" width="32" />';
            }
            else {
                $heading_icon = !empty($icon) ? '<i class="fa ' . $icon . '"></i>' : '';
            }

            // init params needed to load correct template
            $template_part = 'view';
            $no_interactions = $no_interactions == 'yes';
            $additional_params = array(
                // wishlist data
                'wishlist' => false,
                'is_default' => true,
                'is_custom_list' => false,
                'wishlist_token' => '',
                'wishlist_id' => false,
                'is_private' => false,

                // wishlist items
                'count' => 0,
                'wishlist_items' => array(),

                //page data
                'page_title' => $default_wishlist_title,
                'default_wishlsit_title' => $default_wishlist_title,
                'current_page' => 1,
                'page_links' => false,
                'layout' => $layout,

                // user data
                'is_user_logged_in' => is_user_logged_in(),
                'is_user_owner' => true,

                // view data
                'no_interactions' => $no_interactions,
                'show_price' => $show_price,
                'show_dateadded' => $show_date_added,
                'show_stock_status' => $show_stock,
                'show_add_to_cart' => $show_add_to_cart && !$no_interactions,
                'show_remove_product' => $show_remove_product && !$no_interactions,
                'add_to_cart_text' => $add_to_cart_label,
                'show_ask_estimate_button' => false,
                'ask_estimate_url' => '',
                'price_excl_tax' => $price_excluding_tax,
                'show_cb' => false,
                'show_quantity' => false,
                'show_variation' => $show_variation,
                'show_price_variations' => false,
                'show_update' => false,
                'enable_drag_n_drop' => false,
                'enable_add_all_to_cart' => false,
                'move_to_another_wishlist' => false,

                // wishlist icon
                'heading_icon' => $heading_icon,

                // share data
                'share_enabled' => false,

                // template data
                'template_part' => $template_part,
                'additional_info' => false,
                'available_multi_wishlist' => false,
                'users_wishlists' => array(),
                'form_action' => esc_url(YITH_WCWL()->get_wishlist_url('view'))
            );

            $wishlist = YITH_WCWL_Wishlist_Factory::get_current_wishlist($atts);

            if ($wishlist){
                // set global wishlist token
                $yith_wcwl_wishlist_token = $wishlist->get_token();

                // retrieve wishlist params
                $is_user_owner = $wishlist->is_current_user_owner();
                $count = $wishlist->count_items();
                $offset = 0;

                // sets current page, number of pages and element offset
                $current_page = max(1, get_query_var('paged'));

                // sets variables for pagination, if shortcode atts is set to yes
                if ($pagination == 'yes' && ! $no_interactions && $count > 1){
                    $pages = ceil($count / $per_page);

                    if ($current_page > $pages){
                        $current_page = $pages;
                    }

                    $offset = ($current_page - 1) * $per_page;

                    if ($pages > 1){
                        $page_links = paginate_links(array(
                            'base' => esc_url(add_query_arg(array('paged' => '%#%'), $wishlist->get_url())),
                            'format' => '?paged=%#%',
                            'current' => $current_page,
                            'total' => $pages,
                            'show_all' => true
                        ));
                    }
                }
                else{
                    $per_page = 0;
                }

                // retrieve items to print
                $wishlist_items = $wishlist->get_items( $per_page, $offset );

                // retrieve wishlist information
                $is_default = $wishlist->get_is_default();
                $wishlist_token = $wishlist->get_token();
                $wishlist_title = $wishlist->get_formatted_name();

                $additional_params = wp_parse_args(array(
                    // wishlist items
                    'count' => $count,
                    'wishlist_items' => $wishlist_items,

                    // wishlist data
                    'wishlist' => $wishlist,
                    'is_default' => $is_default,
                    'is_custom_list' => $is_user_owner && ! $no_interactions,
                    'wishlist_token' => $wishlist_token,
                    'wishlist_id' => $wishlist->get_id(),
                    'is_private' => $wishlist->get_privacy() == 2,
                    'ajax_loading' => $ajax_loading,

                    //page data
                    'page_title' => $wishlist_title,
                    'current_page' => $current_page,
                    'page_links' => isset($page_links) && !$no_interactions ? $page_links : false,

                    // user data
                    'is_user_owner' => $is_user_owner,

                    // view data
                    'show_remove_product' => $show_remove_product && $is_user_owner && ! $no_interactions,
                    'repeat_remove_button' => $repeat_remove_button && $is_user_owner && ! $no_interactions,

                    // template data
                    'form_action' => $wishlist->get_url()
                ), $additional_params);
            }

            // filter params
            $additional_params = apply_filters('yith_wcwl_wishlist_params', $additional_params, $action, $action_params, $pagination, $per_page);

            $atts = array_merge(
                $atts,
                $additional_params
            );

            $atts['fragment_options'] = YITH_WCWL_Frontend()->format_fragment_options($atts, 'wishlist');
            extract($atts);
            
            ob_start();
            $template = ELESSI_CHILD_PATH . '/includes/nasa-sidebar-wishlist_content.php';
            include is_file($template) ? $template : ELESSI_THEME_PATH . '/includes/nasa-sidebar-wishlist_content.php';
            $content_wishlist = ob_get_clean();

            return apply_filters('nasa_yith_wcwl_wishlisth_html', $content_wishlist, array(), true);
        }

    }

    ELESSI_YITH_WCWL_Shortcode::init();
endif;
