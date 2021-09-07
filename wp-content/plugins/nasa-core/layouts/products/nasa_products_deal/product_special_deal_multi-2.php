<?php
$in_mobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
/**
 * Hover effect products in grid
 */
$nasa_animated_products = isset($nasa_opt['animated_products']) ? $nasa_opt['animated_products'] : '';

$backImageMobile = isset($nasa_opt['mobile_back_image']) && $nasa_opt['mobile_back_image'] ? true : false;
$backImage = false;

/**
 * Mobile detect
 */
if (
    !in_array($nasa_animated_products, array('', 'hover-zoom', 'hover-to-top')) && 
    (!$in_mobile || ($nasa_opt['nasa_in_mobile'] && $backImageMobile))
) {
    $backImage = true;
}

$arrows = isset($arrows) ? $arrows : 0;
$auto_slide = isset($auto_slide) ? $auto_slide : 'true';
$title = !isset($title) || trim($title) == '' ? esc_html__('Deal of the Day', 'nasa-core') : $title;
?>

<div class="nasa-flex-wrap">
    <div class="nasa-main-wrap desktop-padding-right-10 rtl-desktop-padding-right-0 rtl-desktop-padding-left-10">
        <div class="main-border-wrap">
            <div class="nasa-main-special nasa-slider-wrap">
                <div class="nasa-main-top">
                    <h3 class="nasa-sc-title">
                        <?php echo $title; ?>
                    </h3>

                    <?php if ($arrows == 1) : ?>
                        <div class="nasa-nav-slick-wrap nasa-transition nasa-invisible-loading" data-id="#nasa-slider-slick-<?php echo esc_attr($sc); ?>">
                            <a class="nasa-nav-icon-slick nasa-nav-prev" href="javascript:void(0);" data-do="prev" rel="nofollow">
                                <span class="nasa-icon pe-7s-angle-left"></span><span class="nasa-text hide-for-small"><?php echo esc_html__('Prev Deal', 'nasa-core'); ?></span>
                            </a>
                            <a class="nasa-nav-icon-slick nasa-nav-next" href="javascript:void(0);" data-do="next" rel="nofollow">
                                <span class="nasa-text hide-for-small"><?php echo esc_html__('Next Deal', 'nasa-core'); ?></span><span class="nasa-icon pe-7s-angle-right"></span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <hr class="nasa-separator margin-bottom-30" />
                </div>

                <div class="nasa-special-deal-style-multi-wrap nasa-type-2">
                    <div
                        id="nasa-slider-slick-<?php echo esc_attr($sc); ?>"
                        class="nasa-nav-out slider products-group nasa-slider-deal-has-vertical products grid"
                        data-autoplay="<?php echo esc_attr($auto_slide); ?>"
                        data-nav_items="4"
                        data-speed="600"
                        data-delay="3000"
                        data-id="<?php echo esc_attr($sc); ?>">
                        <?php 
                        $vertical_product = array();
                        while ($specials->have_posts()) :
                            $specials->the_post();

                            global $product;
                            if (empty($product) || !$product->is_visible()) :
                                continue;
                            endif;

                            $product_error = false;
                            $productId = $product->get_id();
                            $productType = $product->get_type();
                            $postId = $productType == 'variation' ?
                                wp_get_post_parent_id($productId) : $productId;

                            if (!$postId) {
                                $product_error = true;
                            }

                            $vertical_product[] = array('product' => $product);

                            /* Rating reviews */
                            $productRating = $productType == 'variation' ? wc_get_product($postId) : $product;
                            $average = !$product_error ? $productRating->get_average_rating() : 0;
                            $count = !$product_error ? $productRating->get_review_count() : 0;
                            $rating_html = wc_get_rating_html($average, $count);

                            $stock_available = false;
                            if (isset($statistic) && $statistic == '1') :
                                $manager_product = get_post_meta($postId, '_manage_stock', 'no');
                                $real_id = $postId;

                                if ($productType == 'variation') :
                                    $manager = get_post_meta($productId, '_manage_stock', 'no');

                                    if ($manager === 'yes') :
                                        $manager_product = $manager;
                                        $real_id = $productId;
                                    endif;
                                endif;

                                if ($manager_product === 'yes') :
                                    $total_sales = get_post_meta($real_id, 'total_sales', true);
                                    $stock_sold = $total_sales ? round($total_sales) : 0;

                                    $stock = get_post_meta($real_id, '_stock', true);
                                    $stock_available = $stock ? round($stock) : 0;

                                    $percentage = $stock_available > 0 ?
                                        round($stock_sold/($stock_available + $stock_sold) * 100) : 0;
                                endif;
                            endif;

                            $time_sale = get_post_meta($productId, '_sale_price_dates_to', true);

                            $attachment_ids = $backImage ? $product->get_gallery_image_ids() : false;

                            $product_link = $product_error ? '#' : get_the_permalink();
                            $product_name = $product->get_name() . ($product_error ? esc_html__(' - Has been an error. You need to rebuild this product.', 'nasa-core') : '');
                            ?>
                            <div class="nasa-special-deal-item nasa-special-deal-style-multi-2">
                                <div class="wow fadeInUp product-item<?php echo $nasa_animated_products ? ' ' . esc_attr($nasa_animated_products) : ''; ?>" data-wow-duration="1s" data-wow-delay="0ms">
                                    <div class="row product-special-deals">
                                        <div class="large-5 medium-5 columns rtl-right">
                                            <div class="product-img">
                                                <a href="<?php echo esc_url($product_link); ?>" title="<?php echo esc_attr($product_name); ?>">
                                                    <div class="main-img">
                                                        <?php echo $product->get_image('shop_catalog'); ?>
                                                    </div>
                                                    <?php
                                                    if ($attachment_ids) :
                                                        $loop = 0;
                                                        foreach ($attachment_ids as $attachment_id) :
                                                            $image_link = wp_get_attachment_url($attachment_id);
                                                            if (!$image_link):
                                                                continue;
                                                            endif;
                                                            $loop++;
                                                            printf('<div class="back-img back">%s</div>', wp_get_attachment_image($attachment_id, 'shop_catalog'));
                                                            if ($loop == 1):
                                                                break;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </a>

                                                <?php
                                                /*
                                                 * Nasa Gift icon
                                                 */
                                                do_action('nasa_gift_featured');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="large-7 medium-7 columns rtl-left">
                                            <div class="product-deal-special-wrap-info mobile-margin-top-30">
                                                <?php
                                                echo '<div class="nasa-list-category">';
                                                echo wc_get_product_category_list($postId, ', ');
                                                echo '</div>';
                                                ?>

                                                <div class="product-deal-special-title">
                                                    <a href="<?php echo esc_url($product_link); ?>" title="<?php echo esc_attr($product_name); ?>">
                                                        <?php echo $product_name; ?>
                                                    </a>
                                                </div>

                                                <?php echo $rating_html ? $rating_html : ''; ?>

                                                <div class="product-deal-special-price price">
                                                    <?php echo $product->get_price_html(); ?>
                                                </div>

                                                <div class="product-deal-special-countdown">
                                                    <?php echo nasa_time_sale($time_sale); ?>
                                                </div>

                                                <?php if ($stock_available) :?>
                                                    <div class="product-deal-special-progress">
                                                        <div class="deal-stock-label">
                                                            <span class="stock-available text-left"><?php echo esc_html__('Available:', 'nasa-core');?> <strong><?php echo esc_html($stock_available); ?></strong></span>
                                                            <span class="stock-sold text-right"><?php echo esc_html__('Already Sold:', 'nasa-core');?> <strong><?php echo esc_html($stock_sold); ?></strong></span>
                                                        </div>
                                                        <div class="deal-progress">
                                                            <span class="deal-progress-bar" style="<?php echo esc_attr('width:' . $percentage . '%'); ?>"><?php echo $percentage; ?></span>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php
                                                /**
                                                 * Group buttons
                                                 */
                                                do_action('nasa_special_deal_multi_action');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="nasa-extra-wrap padding-left-10 rtl-desktop-padding-left-0 rtl-desktop-padding-right-10 hide-for-mobile">
        <div class="extra-border-wrap">
            <div class="nasa-slider-deal-vertical-extra-switcher nasa-slider-deal-vertical-extra-<?php echo esc_attr($sc); ?> wow fadeInUp<?php echo $nasa_animated_products ? ' ' . esc_attr($nasa_animated_products) : ''; ?> nasa-nav-4-items" data-wow-duration="1s" data-wow-delay="0ms" data-count="<?php echo count($vertical_product); ?>">
                <?php foreach ($vertical_product as $extra) :
                    $product_thumb = $extra['product'];
                    ?>
                    <div class="item-slick">
                        <div class="item-deal-thumb nasa-transition">
                            <div class="nasa-slick-img left padding-right-10 rtl-padding-right-0 rtl-padding-left-10 rtl-right">
                                <?php echo $product_thumb->get_image('shop_catalog'); ?>
                            </div>
                            <div class="nasa-slick-info left padding-left-10 rtl-padding-left-0 rtl-padding-right-10 rtl-left">
                                <p class="nasa-product-title"><?php echo $product_thumb->get_name(); ?></p>
                                <p class="nasa-product-price price"><?php echo $product_thumb->get_price_html();  ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
