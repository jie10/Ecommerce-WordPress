<?php
/**
 *
 * The template for displaying product content within loops
 *
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.6.0
 */
global $product, $nasa_opt;
if (empty($product) || !$product->is_visible()) :
    return;
endif;

$show_in_list = isset($show_in_list) ? $show_in_list : true;
if (!isset($_delay)) {
    $_delay = 0;
}

/**
 * Show Categories info
 */
$cat_info = isset($cat_info) ? $cat_info : true;

/**
 * Show Short Description info
 */
$description_info = isset($description_info) ? $description_info : true;

/**
 * Set Before - After product
 */
$before_product = $after_product = '';
if ((!isset($wrapper) || $wrapper == 'li')) :
    $wrap_item_class = 'product-warp-item';
    $wrap_item_class .= isset($wrapper_class) && $wrapper_class ? ' ' . $wrapper_class : '';
    
    $before_product = '<li class="' . esc_attr($wrap_item_class) . '">';
    $after_product = '</li>';
endif;

echo $before_product;
?>

<div <?php wc_product_class('', $product); ?> data-wow="fadeInUp" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms">

    <?php do_action('woocommerce_before_shop_loop_item'); ?>

    <div class="product-img-wrap">
        <?php do_action('woocommerce_before_shop_loop_item_title'); ?>
    </div>

    <div class="product-info-wrap info">
        <?php do_action('woocommerce_shop_loop_item_title', $cat_info); ?>
        <?php do_action('woocommerce_after_shop_loop_item_title', $description_info); ?>
    </div>

    <?php do_action('woocommerce_after_shop_loop_item', $show_in_list); ?>

</div>

<?php
echo $after_product;
