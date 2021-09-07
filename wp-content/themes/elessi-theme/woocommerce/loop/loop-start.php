<?php
/**
 * Product Loop Start
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.3.0
 */
global $nasa_opt, $woocommerce_loop;

$data_columns_small = 1;
$data_columns_tablet = 2;

$grid_cookie_name = 'archive_grid_view';
$siteurl = get_option('siteurl');
$grid_cookie_name .= $siteurl ? '_' . md5($siteurl) : '';

/**
 * Loop in Shop page
 */
if (!isset($woocommerce_loop['is_shortcode']) || !$woocommerce_loop['is_shortcode']) {
    $typeView = !isset($nasa_opt['products_type_view']) ? 'grid' : $nasa_opt['products_type_view'];
    $typeShow = $typeView == 'list' ? $typeView : 'grid';
    $nasa_change_view = !isset($nasa_opt['enable_change_view']) || $nasa_opt['enable_change_view'] ? true : false;
    if ($nasa_change_view && isset($_COOKIE[$grid_cookie_name])) {
        $typeShow = $_COOKIE[$grid_cookie_name] == 'list' ? 'list' : 'grid';
    }

    if (!isset($_COOKIE[$grid_cookie_name]) || (isset($nasa_opt['enable_change_view']) && !$nasa_opt['enable_change_view'])) :
        $products_per_row = (isset($nasa_opt['products_type_view']) && $nasa_opt['products_type_view'] == 'list') ? 4 :
            (isset($nasa_opt['products_per_row']) && (int) $nasa_opt['products_per_row'] ? (int) $nasa_opt['products_per_row'] : 4);
    else:
        switch ($_COOKIE[$grid_cookie_name]) :
            case 'grid-2' :
                $products_per_row = 2;
                break;
            
            case 'grid-3' :
                $products_per_row = 3;
                break;

            case 'grid-5' :
                $products_per_row = 5;
                break;
            
            case 'grid-6' :
                $products_per_row = 6;
                break;

            case 'grid-4' :
            case 'list' :
            default:
                $products_per_row = 4;
                break;
        endswitch;
    endif;
}

/**
 * Loop in Short code
 */
else {
    $typeShow = 'grid';
    $products_per_row = isset($woocommerce_loop['columns']) ? $woocommerce_loop['columns'] : (isset($nasa_opt['products_per_row']) && (int) $nasa_opt['products_per_row'] ? (int) $nasa_opt['products_per_row'] : 4);
}

/**
 * Columns for desktop
 */
switch ($products_per_row):
    case 2:
        $typeShow .= ' large-block-grid-2';
        break;
    
    case 3:
        $typeShow .= ' large-block-grid-3';
        break;

    case 5:
        $typeShow .= ' large-block-grid-5';
        break;
    
    case 6:
        $typeShow .= ' large-block-grid-6';
        break;

    case 4:
    default:
        $typeShow .= ' large-block-grid-4';
        break;
endswitch;

/**
 * Columns for mobile
 */
$products_per_row_small = isset($nasa_opt['products_per_row_small']) && (int) $nasa_opt['products_per_row_small'] ? (int) $nasa_opt['products_per_row_small'] : 1;
switch ($products_per_row_small):
    case 2:
        $typeShow .= ' small-block-grid-2';
        $data_columns_small = '2';
        break;
    case 1:
    default:
        $typeShow .= ' small-block-grid-1';
        $data_columns_small = '1';
        break;
endswitch;

/**
 * Columns for tablet
 */
$products_per_row_tablet = isset($nasa_opt['products_per_row_tablet']) && (int) $nasa_opt['products_per_row_tablet'] ? (int) $nasa_opt['products_per_row_tablet'] : 2;
switch ($products_per_row_tablet):
    case 3:
        $typeShow .= ' medium-block-grid-3';
        $data_columns_tablet = '3';
        break;
    case 4:
        $typeShow .= ' medium-block-grid-4';
        $data_columns_tablet = '4';
        break;
    case 2:
    default:
        $typeShow .= ' medium-block-grid-2';
        $data_columns_tablet = '2';
        break;
endswitch;
?>

<div class="nasa-content-page-products">
    <ul class="products <?php echo esc_attr($typeShow); ?>" data-columns_small="<?php echo esc_attr($data_columns_small); ?>" data-columns_medium="<?php echo esc_attr($data_columns_tablet); ?>">
