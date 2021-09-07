<?php
/**
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.5.5
 */
if (!defined('ABSPATH')) {
    exit;
}

global $product, $nasa_opt;

if (!is_a($product, 'WC_Product')) {
    return;
}

$productId = $product->get_id();
$link = $product->get_permalink();
$title = $product->get_name();
$show_rating = isset($show_rating) ? $show_rating : true;
$animation = !isset($animation) ? true : $animation;

$class = 'item-product-widget';
$class .= $animation ? ' wow fadeInUp' : '';
$class_img = 'nasa-item-img left rtl-right';
$class_info = 'nasa-item-meta left rtl-right padding-left-20 rtl-padding-left-0 rtl-padding-right-20';
$nasa_quickview = true;
if (isset($nasa_opt['disable-quickview']) && $nasa_opt['disable-quickview']) {
    $nasa_quickview = false;
}

$list_type = isset($list_type) ? $list_type : '1';
$image_size = 'thumbnail';
switch ($list_type) :
    case 'list_main':
        $class .= ' nasa-list-type-main';
        $image_size = 'shop_catalog';
        break;
    
    case 'list_extra' :
        $class .= ' nasa-list-type-extra';
        break;
    
    default:
        $list_type = '1';
        break;
endswitch;

if (!isset($delay)){
    global $delay;
    $_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
    $delay = !$delay ? 0 : $delay;
    $delay += $_delay_item;
}

$attributes = array(
    'data-wow-duration="1s"',
    'data-wow-delay="' . ((int) $delay) . 'ms"'
);

$class_warp = isset($class_column) ? ' ' . $class_column : '';
$wapper = (isset($wapper) && $wapper == 'div') ? 'div' : 'li';

$start_wapper = ($wapper == 'div') ? '<div class="' . esc_attr($class) . '" ' . implode(' ', $attributes) . '>' : '<li class="' . esc_attr($class) . '" ' . implode(' ', $attributes) . '>';

$end_warp = '</' . $wapper . '>';

echo $start_wapper;
do_action('woocommerce_widget_product_item_start', $args);
?>

<div class="<?php echo esc_attr($class_img); ?>">
    <a class="nasa-widget-img" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
        <?php echo $product->get_image($image_size); ?>
    </a>
    <?php if ($nasa_quickview): ?>
        <a href="javascript:void(0);" class="quick-view btn-link quick-view-icon" data-prod="<?php echo esc_attr($productId); ?>" title="<?php esc_attr_e('Quick View', 'elessi-theme'); ?>" rel="nofollow">
            <i class="pe-7s-expand1"></i>
        </a>
    <?php endif; ?>
</div>

<div class="<?php echo esc_attr($class_info); ?>">
    <a class="product-title nasa-widget-title nasa-transition" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
        <?php echo $title; ?>
    </a>

    <?php echo $show_rating ? wp_kses_post(wc_get_rating_html($product->get_average_rating())) : ''; ?>

    <span class="price">
        <?php echo $product->get_price_html(); ?>
    </span>
</div>

<?php
do_action('woocommerce_widget_product_item_end', $args);

echo $end_warp;
