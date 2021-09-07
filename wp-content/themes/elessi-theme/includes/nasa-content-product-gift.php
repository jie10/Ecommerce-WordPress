<?php
/**
 *
 * The template for displaying product gifts content within loops
 */
global $nasa_opt;

/**
 * Hover effect products in grid
 */
$nasa_animated_products = isset($nasa_opt['animated_products']) && $nasa_opt['animated_products'] ? $nasa_opt['animated_products'] : '';

$product_gift = $bundle_item->product;

if (!$product_gift->is_visible() && (!isset($_REQUEST['nasa_load_ajax']) || !$_REQUEST['nasa_load_ajax'])) :
    return;
endif;

$post_gift = get_post($product_gift->get_id());
$productId = $product_gift->get_id();

$time_sale = (isset($is_deals) && $is_deals) ? get_post_meta($productId, '_sale_price_dates_to', true) : false;
$main_img = $product_gift->get_image(apply_filters('single_product_archive_thumbnail_size', 'shop_catalog'));

$nasa_title = get_the_title($post_gift); // Title
$nasa_link = get_permalink($post_gift); // permalink

$product_category = function_exists('wc_get_product_category_list') ? wc_get_product_category_list($productId, ', ') : $product_gift->get_categories(', '); // Categories list

$class_wrap = 'wow fadeInUp product-item grid';

$attachment_ids = $nasa_animated_products != '' ? $product_gift->get_gallery_image_ids() : false;
$class_wrap .= $nasa_animated_products ? ' ' . $nasa_animated_products : '';

$stock_status = $product_gift->get_stock_status();
$class_wrap .= $stock_status == "outofstock" ? ' out-of-stock' : '';

echo '<div class="' . esc_attr($class_wrap) . '" data-wow-duration="1s" data-wow-delay="' . esc_attr($_delay) . 'ms" data-wow="fadeInUp">';
?>

<div class="<?php echo ($time_sale) ? ' product-deals' : ''; ?> nasa-title-bottom">
    <div class="product-inner">
        <div class="product-img">
            <a href="<?php echo esc_url($nasa_link); ?>" title="<?php echo esc_attr($nasa_title); ?>">
                <div class="main-img"><?php echo ($main_img); ?></div>
                <?php if ($attachment_ids) :
                    foreach ($attachment_ids as $attachment_id) :
                        $image_link = wp_get_attachment_url($attachment_id);
                        if (!$image_link):
                            continue;
                        endif;
                        printf('<div class="back-img back">%s</div>', wp_get_attachment_image($attachment_id, apply_filters('single_product_archive_thumbnail_size', 'shop_catalog')));
                        break;
                    endforeach;
                endif; ?>
            </a>

            <?php if ($stock_status == "outofstock"): ?>
                <div class="badge out-of-stock-label">
                    <?php esc_html_e('Sold out', 'elessi-theme'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="info nasa-combo-info-item">
            <div class="name nasa-name text-center">
                <a href="<?php echo esc_url($nasa_link); ?>" title="<?php echo esc_attr($nasa_title); ?>">
                    <?php echo $nasa_title; ?>
                </a>
            </div>
        </div>

        <?php echo elessi_time_sale($time_sale); ?>
    </div>
</div>
<?php

echo '</div>';
