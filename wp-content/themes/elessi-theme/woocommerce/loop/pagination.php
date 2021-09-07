<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.3.1
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

global $nasa_opt, $wp_query, $nasa_loadmore_style;

$nasa_ajax_product = (defined('NASA_AJAX_SHOP') && NASA_AJAX_SHOP) ? NASA_AJAX_SHOP : false;

$total   = isset($total) ? $total : (function_exists('wc_get_loop_prop') ? wc_get_loop_prop('total_pages') : $wp_query->max_num_pages);
$current = isset($current) ? $current : (function_exists('wc_get_loop_prop') ? wc_get_loop_prop('current_page') : max(1, get_query_var('paged')));
$base    = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format  = isset($format) ? $format : '';

$pagination_style = isset($nasa_opt['pagination_style']) ? $nasa_opt['pagination_style'] : 'style-2';

if (isset($_REQUEST['paging-style']) && in_array($_REQUEST['paging-style'], $nasa_loadmore_style)) {
    $pagination_style = $_REQUEST['paging-style'];
}

if (!$nasa_ajax_product) :
    $pagination_style = $pagination_style == 'style-2' ? 'style-2' : 'style-1';
endif;

$loadmore = in_array($pagination_style, $nasa_loadmore_style);
$loadmoreClass = 'text-center';
$loadmoreClass .= $pagination_style == 'infinite' ? ' nasa-infinite-shop' : '';

if ($total <= 1) :
    if ($loadmore) :
        echo '<div class="row nasa-paginations-warp filters-container-down"><div id="nasa-wrap-archive-loadmore" class="' . $loadmoreClass . '"></div></div>';
    endif;
    
    return;
endif;
?>

<!-- PAGINATION -->
<div class="row nasa-paginations-warp filters-container-down">
    <div class="large-12 columns">
        <?php
        if ($loadmore) :
            echo '<div id="nasa-wrap-archive-loadmore" class="' . $loadmoreClass . '">';
            if ($current >= $total) :
                echo '<p>' . esc_html__('ALL PRODUCTS LOADED !', 'elessi-theme') . '</p>';
            else :
                echo '<a class="nasa-archive-loadmore" href="javascript:void(0);" rel="nofollow">';
                echo esc_html__('LOAD MORE ...', 'elessi-theme');
                echo '</a>';
            endif;
            echo '</div>';
        elseif ($pagination_style == 'style-1') : ?>
            <div class="nasa-pagination clearfix style-1">
                <div class="page-sumary">
                    <ul>
                        <li><?php do_action('nasa_shop_category_count'); ?></li>
                    </ul>
                </div>
                <div class="page-number">
                    <?php
                    echo ($nasa_ajax_product) ?
                        elessi_get_pagination_ajax(
                            $total, // Total
                            $current, // Current
                            'list', // Type display
                            '<span class="pe7-icon pe-7s-angle-left"></span>', // Prev text
                            '<span class="pe7-icon pe-7s-angle-right"></span>', // Next text
                            1, // end_size
                            1  // mid_size
                        ) : paginate_links(apply_filters('woocommerce_pagination_args', array(
                            'base' => $base,
                            'format' => $format,
                            'current' => $current,
                            'total' => $total,
                            'prev_text' => '<span class="pe7-icon pe-7s-angle-left"></span>',
                            'next_text' => '<span class="pe7-icon pe-7s-angle-right"></span>',
                            'type' => 'list',
                            'end_size' => 1,
                            'mid_size' => 1
                        )));
                    ?>
                </div>
            </div>
        <?php elseif ($pagination_style == 'style-2') : ?>
            <div class="nasa-pagination style-2">
                <div class="page-number">
                    <?php
                    echo ($nasa_ajax_product) ?
                        elessi_get_pagination_ajax(
                            $total,
                            $current,
                            'list',
                            '<span class="pe7-icon pe-7s-angle-left"></span>', // Prev text
                            '<span class="pe7-icon pe-7s-angle-right"></span>', // Next text
                            1, // end_size
                            1  // mid_size
                        ) : paginate_links(apply_filters('woocommerce_pagination_args', array(
                            'base' => $base,
                            'format' => $format,
                            'current' => $current,
                            'total' => $total,
                            'prev_text' => '<span class="pe7-icon pe-7s-angle-left"></span>',
                            'next_text' => '<span class="pe7-icon pe-7s-angle-right"></span>',
                            'type' => 'list',
                            'end_size' => 1,
                            'mid_size' => 1
                        )));
                    ?>
                </div>
                <hr />
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
/*!-- end PAGINATION -- */
