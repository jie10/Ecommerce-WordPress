<?php
/**
 * Archive Products Page
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.4.0
 */
if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}

global $nasa_opt, $wp_query;

$nasa_ajax_product = isset($nasa_opt['disable_ajax_product']) && $nasa_opt['disable_ajax_product'] ? false : true;
defined('NASA_AJAX_SHOP') or define('NASA_AJAX_SHOP', $nasa_ajax_product);

/**
 * Override cat side-bar layout
 */
$root_cat_id = elessi_get_root_term_id();
if ($root_cat_id) {
    $sidebar_style = get_term_meta($root_cat_id, 'cat_sidebar_layout', true);
    if ($sidebar_style != '') {
        $nasa_opt['category_sidebar'] = $sidebar_style;
    }
}

$type_view = !isset($nasa_opt['products_type_view']) ?
    'grid' : ($nasa_opt['products_type_view'] == 'list' ? 'list' : 'grid');

$nasa_opt['products_per_row'] = isset($nasa_opt['products_per_row']) && (int) $nasa_opt['products_per_row'] ?
    (int) $nasa_opt['products_per_row'] : 4;
$nasa_opt['products_per_row'] = $nasa_opt['products_per_row'] > 6 || $nasa_opt['products_per_row'] < 2 ? 4 : $nasa_opt['products_per_row'];

$nasa_change_view = !isset($nasa_opt['enable_change_view']) || $nasa_opt['enable_change_view'] ? true : false;
$grid_cookie_name = 'archive_grid_view';
$siteurl = get_option('siteurl');
$grid_cookie_name .= $siteurl ? '_' . md5($siteurl) : '';
$type_show = $type_view == 'grid' ? ($type_view . '-' . ((int) $nasa_opt['products_per_row'])) : 'list';
$type_show = $nasa_change_view && isset($_COOKIE[$grid_cookie_name]) ? $_COOKIE[$grid_cookie_name] : $type_show;

$nasa_cat_obj = $wp_query->get_queried_object();
$nasa_term_id = 0;
$nasa_type_page = 'product_cat';
$nasa_href_page = '';
if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
    $nasa_term_id = (int) $nasa_cat_obj->term_id;
    $nasa_type_page = $nasa_cat_obj->taxonomy;
    $nasa_href_page = esc_url(get_term_link($nasa_cat_obj, $nasa_type_page));
}

$nasa_sidebar = isset($nasa_opt['category_sidebar']) ? $nasa_opt['category_sidebar'] : 'left-classic';
$nasa_has_get_sidebar = false;

if (isset($_REQUEST['sidebar']) && defined('NASATHEME_DEMO') && NASATHEME_DEMO):
    $nasa_has_get_sidebar = true;
endif;

$hasSidebar = true;
$topSidebar = false;
$topSidebar2 = false;
$topbarWrap_class = 'row filters-container nasa-filter-wrap';
$attr = 'nasa-products-page-wrap ';
$class_wrap_archive = 'row fullwidth category-page';
switch ($nasa_sidebar):
    case 'right':
    case 'left':
        $attr .= 'large-12 columns has-sidebar';
        break;
    
    case 'right-classic':
        $attr .= 'large-9 columns left has-sidebar';
        $class_wrap_archive .= ' nasa-with-sidebar-classic';
        break;
    
    case 'no':
        $hasSidebar = false;
        $attr .= 'large-12 columns no-sidebar';
        break;
    
    case 'top':
        $hasSidebar = false;
        $topSidebar = true;
        $topbarWrap_class .= ' top-bar-wrap-type-1';
        $attr .= 'large-12 columns no-sidebar top-sidebar';
        $class_wrap_archive .= ' nasa-top-sidebar-style';
        break;
    
    case 'top-2':
        $hasSidebar = false;
        $topSidebar2 = true;
        $topbarWrap_class .= ' top-bar-wrap-type-2';
        $attr .= 'large-12 columns no-sidebar top-sidebar-2';
        break;
    
    case 'left-classic':
    default :
        $attr .= 'large-9 columns right has-sidebar';
        $class_wrap_archive .= ' nasa-with-sidebar-classic';
        break;
endswitch;

$nasa_recom_pos = isset($nasa_opt['recommend_product_position']) ? $nasa_opt['recommend_product_position'] : 'bot';

$layout_style = '';
if (isset($nasa_opt['products_layout_style']) && $nasa_opt['products_layout_style'] == 'masonry-isotope') :
    $layout_style = ' nasa-products-masonry-isotope';
    $layout_style .= isset($nasa_opt['products_masonry_mode']) ? ' nasa-mode-' . $nasa_opt['products_masonry_mode'] : '';
endif;

/**
 * Header Shop
 */
get_header('shop');

/**
 * Hook Before Main content
 */
do_action('woocommerce_before_main_content');
?>
<div class="<?php echo esc_attr($class_wrap_archive); ?>">
    <div class="nasa_shop_description-wrap large-12 columns">
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="woocommerce-products-header__title page-title text-center margin-top-50">
                <?php woocommerce_page_title(); ?>
            </h1>
	<?php endif; ?>
        
        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action('woocommerce_archive_description');
        ?>
    </div>
    
    <?php
    /**
     * Hook: nasa_before_archive_products.
     */
    do_action('nasa_before_archive_products');
    ?>
    
    <div class="large-12 columns">
        <div class="<?php echo esc_attr($topbarWrap_class); ?>">
            <?php
            /**
             * Top Side bar Type 1
             */
            if ($topSidebar) :
                $topSidebar_wrap = $nasa_change_view ? 'large-10 medium-12 ' : 'large-12 ';

                if (!isset($nasa_opt['showing_info_top']) || $nasa_opt['showing_info_top']) :
                    echo '<div class="showing_info_top hidden-tag">';
                    do_action('nasa_shop_category_count');
                    echo '</div>';
                endif;
                ?>

                <div class="<?php echo esc_attr($topSidebar_wrap); ?>columns nasa-topbar-filter-wrap">
                    <div class="row">
                        <div class="large-10 medium-10 columns nasa-filter-action">
                            <div class="nasa-labels-filter-top">
                                <input name="nasa-labels-filter-text" type="hidden" value="<?php echo (!isset($nasa_opt['top_bar_archive_label']) || $nasa_opt['top_bar_archive_label'] == 'Filter by:') ? esc_attr__('Filter by:', 'elessi-theme') : esc_attr($nasa_opt['top_bar_archive_label']); ?>" />
                                <input name="nasa-widget-show-more-text" type="hidden" value="<?php echo esc_attr__('More +', 'elessi-theme'); ?>" />
                                <input name="nasa-widget-show-less-text" type="hidden" value="<?php echo esc_attr__('Less -', 'elessi-theme'); ?>" />
                                <input name="nasa-limit-widgets-show-more" type="hidden" value="<?php echo (!isset($nasa_opt['limit_widgets_show_more']) || (int) $nasa_opt['limit_widgets_show_more'] < 0) ? '2' : (int) $nasa_opt['limit_widgets_show_more']; ?>" />
                                <a class="toggle-topbar-shop-mobile hidden-tag" href="javascript:void(0);" rel="nofollow">
                                    <i class="pe-7s-filter"></i><?php echo esc_attr__('&nbsp;Filters', 'elessi-theme'); ?>
                                </a>
                                <span class="nasa-labels-filter-accordion"></span>
                            </div>
                        </div>
                        
                        <div class="large-2 medium-2 columns nasa-sort-by-action right rtl-left">
                            <ul class="sort-bar nasa-float-none margin-top-0">
                                <li class="sort-bar-text nasa-order-label hidden-tag">
                                    <?php esc_html_e('Sort by', 'elessi-theme'); ?>
                                </li>
                                <li class="nasa-filter-order filter-order">
                                    <?php woocommerce_catalog_ordering(); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php if ($nasa_change_view) : ?>
                    <div class="large-2 hide-for-medium columns nasa-topbar-change-view-wrap">
                        <?php
                        /**
                         * Change view ICONS
                         */
                        $type_sidebar = (!isset($nasa_opt['top_bar_cat_pos']) || $nasa_opt['top_bar_cat_pos'] == 'left-bar') ? 'top-push-cat' : 'no';
                        do_action('nasa_change_view', $nasa_change_view, $type_show, $type_sidebar); ?>
                    </div>
                <?php endif; ?>

                <?php
                /**
                 * Sidebar TOP
                 */
                do_action('nasa_top_sidebar_shop');
                
            /**
             * Top Side bar type 2
             */
            elseif ($topSidebar2) :
                ?>
                <div class="large-12 columns">
                    <div class="row">
                        <div class="large-4 medium-6 small-6 columns nasa-toggle-top-bar rtl-right">
                            <a class="nasa-toggle-top-bar-click" href="javascript:void(0);" rel="nofollow">
                                <?php esc_html_e('Filters', 'elessi-theme'); ?>
                            </a>
                        </div>
                        
                        <div class="large-4 columns nasa-topbar-change-view-wrap hide-for-medium hide-for-small text-center rtl-right">
                            <?php if ($nasa_change_view) : ?>
                                <?php
                                /**
                                 * Change view ICONS
                                 */
                                do_action('nasa_change_view', $nasa_change_view, $type_show); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="large-4 medium-6 small-6 columns nasa-sort-by-action nasa-clear-none text-right rtl-text-left">
                            <ul class="sort-bar nasa-float-none margin-top-0">
                                <li class="nasa-filter-order filter-order">
                                    <?php woocommerce_catalog_ordering(); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="large-12 columns nasa-top-bar-2-content hidden-tag">
                    <?php do_action('nasa_top_sidebar_shop', '2'); ?>
                </div>
            
            <?php
            /**
             * TOGGLE Side bar in side (Off-Canvas)
             */
            elseif ($hasSidebar && in_array($nasa_sidebar, array('left', 'right'))) : ?>
                <div class="large-4 medium-6 small-6 columns nasa-toggle-layout-side-sidebar">
                    <div class="li-toggle-sidebar">
                        <a class="toggle-sidebar-shop" href="javascript:void(0);" rel="nofollow">
                            <i class="pe-7s-filter"></i><?php esc_html_e('&nbsp;Filters', 'elessi-theme'); ?>
                        </a>
                    </div>
                </div>
                
                <div class="large-4 columns hide-for-medium hide-for-small nasa-change-view-layout-side-sidebar nasa-min-height">
                    <?php
                    /**
                     * Change view ICONS
                     */
                    do_action('nasa_change_view', $nasa_change_view, $type_show); ?>
                </div>
            
                <div class="large-4 medium-6 small-6 columns nasa-sort-bar-layout-side-sidebar nasa-clear-none nasa-min-height">
                    <ul class="sort-bar">
                        <li class="sort-bar-text nasa-order-label hidden-tag">
                            <?php esc_html_e('Sort by: ', 'elessi-theme'); ?>
                        </li>
                        <li class="nasa-filter-order filter-order">
                            <?php woocommerce_catalog_ordering(); ?>
                        </li>
                    </ul>
                </div>
            <?php
            
            /**
             * No | left-classic | right-classic side bar
             */
            else : ?>
                <div class="large-4 medium-6 columns hide-for-small text-left">
                    <?php
                        $toggle_sidebar = !isset($nasa_opt['toggle_sidebar_classic']) || $nasa_opt['toggle_sidebar_classic'] ? true : false;
                        if (!$toggle_sidebar) :
                            if (!isset($nasa_opt['showing_info_top']) || $nasa_opt['showing_info_top']) :
                                echo '<div class="showing_info_top">';
                                do_action('nasa_shop_category_count');
                                echo '</div>';
                            else :
                                echo '&nbsp;';
                            endif;
                        else :
                            echo '<a href="javascript:void(0);" class="nasa-toogle-sidebar-classic nasa-hide-in-mobile rtl-text-right" rel="nofollow">' . esc_html__('Filters', 'elessi-theme') . '</a>';
                        endif;
                    ?>
                </div>
                
                <div class="large-4 columns hide-for-medium hide-for-small nasa-change-view-layout-side-sidebar nasa-min-height">
                    <?php
                    /**
                     * Change view ICONS
                     */
                    do_action('nasa_change_view', $nasa_change_view, $type_show, $nasa_sidebar);
                    ?>
                </div>
            
                <div class="large-4 medium-6 small-12 columns nasa-clear-none nasa-sort-bar-layout-side-sidebar">
                    <ul class="sort-bar">
                        <?php if ($hasSidebar): ?>
                            <li class="li-toggle-sidebar">
                                <a class="toggle-sidebar" href="javascript:void(0);" rel="nofollow">
                                    <i class="pe-7s-filter"></i> <?php esc_html_e('Filters', 'elessi-theme'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="sort-bar-text nasa-order-label hidden-tag">
                            <?php esc_html_e('Sort by: ', 'elessi-theme'); ?>
                        </li>
                        <li class="nasa-filter-order filter-order">
                            <?php woocommerce_catalog_ordering(); ?>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="nasa-archive-product-content">
        <?php if ($topSidebar && (!isset($nasa_opt['top_bar_cat_pos']) || $nasa_opt['top_bar_cat_pos'] == 'left-bar')) :
            $attr .= ' nasa-has-push-cat';
            $class_cat_top = 'nasa-push-cat-filter';
            if (isset($_REQUEST['categories-filter-show']) && $_REQUEST['categories-filter-show']) :
                $class_cat_top .= ' nasa-push-cat-show';
                $attr .= ' nasa-push-cat-show';
            endif; ?>
            
            <div class="<?php echo esc_attr($class_cat_top); ?>"></div>
        <?php endif; ?>
        
        <div class="<?php echo esc_attr($attr); ?>">

            <?php if ($nasa_recom_pos !== 'bot' && defined('NASA_CORE_ACTIVED') && NASA_CORE_ACTIVED) : ?>
                <?php do_action('nasa_recommend_product', $nasa_term_id); ?>
            <?php endif; ?>

            <div class="nasa-archive-product-warp<?php echo esc_attr($layout_style); ?>">
                <?php
                if (woocommerce_product_loop()) :
                    /**
                     * Before Shop Loop
                     */
                    do_action('woocommerce_before_shop_loop');
                    
                    /**
                     * Content products in shop
                     */
                    if (NASA_WOO_ACTIVED && version_compare(WC()->version, '3.3.0', "<")) :
                        do_action('nasa_archive_get_sub_categories');
                    endif;
                    
                    woocommerce_product_loop_start();
                    do_action('nasa_get_content_products', $nasa_sidebar);
                    woocommerce_product_loop_end();
                    
                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');
                else :
                    echo '<div class="row"><div class="large-12 columns nasa-archive-no-result">';
                    do_action('woocommerce_no_products_found');
                    echo '</div></div>';
                endif;
                ?>
            </div>

            <?php if ($nasa_recom_pos == 'bot' && defined('NASA_CORE_ACTIVED') && NASA_CORE_ACTIVED) :?>
                <?php do_action('nasa_recommend_product', $nasa_term_id); ?>
            <?php endif; ?>
        </div>

        <?php
        /**
         * Sidebar LEFT | RIGHT
         */
        if ($hasSidebar && !$topSidebar && !$topSidebar2) :
            do_action('nasa_sidebar_shop', $nasa_sidebar);
        endif;
        
        ?>
    </div>
    
    <?php
    /**
     * Ajax enable
     */
    if ($nasa_ajax_product) :
        ?>
        <div class="nasa-has-filter-ajax hidden-tag">
            <div class="current-tax-item hidden-tag">
                <a data-id="<?php echo (int) $nasa_term_id; ?>" href="<?php echo esc_url($nasa_href_page); ?>" class="nasa-filter-by-tax" id="nasa-hidden-current-tax" data-taxonomy="<?php echo esc_attr($nasa_type_page); ?>" data-sidebar="<?php echo esc_attr($nasa_sidebar); ?>"></a>
            </div>
            
            <p><?php esc_html_e('No products were found matching your selection.', 'elessi-theme'); ?></p>
            
            <?php if ($s = get_search_query()): ?>
                <input type="hidden" name="nasa_hasSearch" id="nasa_hasSearch" value="<?php echo esc_attr($s); ?>" />
            <?php endif; ?>
            
            <?php if ($nasa_has_get_sidebar) : ?>
                <input type="hidden" name="nasa_getSidebar" id="nasa_getSidebar" value="<?php echo esc_attr($nasa_sidebar); ?>" />
            <?php endif; ?>

            <?php
            // <!-- Current URL -->
            $slug_nopaging = elessi_nopaging_url();
            echo $slug_nopaging ? '<input type="hidden" name="nasa_current-slug" id="nasa_current-slug" value="' . esc_url($slug_nopaging) . '" />' : '';

            /**
             * Default Sorting
             */
            $default_sort = wc_get_loop_prop('is_search') ? 'relevance' : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', 'menu_order'));
            
            echo '<input type="hidden" name="nasa_default_sort" id="nasa_default_sort" value="' . esc_attr($default_sort) . '" />';
            
            /**
             * Links
             */
            $shop_url   = wc_get_page_permalink('shop');
            $base_url   = home_url('/');
            $friendly   = preg_match('/\?post_type\=/', $shop_url) ? '0' : '1';
            if (preg_match('/\?page_id\=/', $shop_url)){
                $friendly = '0';
                $shop_url = $base_url . '?post_type=product';
            }

            echo '<input type="hidden" name="nasa-shop-page-url" value="' . esc_url($shop_url) . '" />';
            echo '<input type="hidden" name="nasa-base-url" value="' . esc_url($base_url) . '" />';
            echo '<input type="hidden" name="nasa-friendly-url" value="' . esc_attr($friendly) . '" />';

            if (isset($_GET) && !empty($_GET)) {
                echo '<div class="hidden-tag nasa-value-gets">';
                foreach ($_GET as $key => $value) {
                    if (!in_array($key, array('add-to-cart'))) {
                        echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
                    }
                }
                echo '</div>';
            }
            ?>
        </div>
        <?php
    endif;
    ?>
</div>

<?php
/**
 * Hook After Main content
 */
do_action('woocommerce_after_main_content');

/**
 * Footer Shop
 */
get_footer('shop');
