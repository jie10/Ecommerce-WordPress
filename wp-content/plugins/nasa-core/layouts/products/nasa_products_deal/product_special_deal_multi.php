<?php
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
    (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile'] || ($nasa_opt['nasa_in_mobile'] && $backImageMobile))
) {
    $backImage = true;
}

$arrows = isset($arrows) ? $arrows : 0;
$auto_slide = isset($auto_slide) ? $auto_slide : 'true';
$thumb_pos = 'right';
?>

<div class="row">
    <div class="nasa-main-special nasa-main-nav-2-items nasa-slider-wrap large-9 columns rtl-right">
        <?php if ($arrows == 1) : ?>
            <div class="nasa-nav-slick-wrap nasa-transition nasa-invisible-loading">
                <div class="nasa-nav-slick-prev nasa-nav-slick-div">
                    <a class="nasa-nav-icon-slick" href="javascript:void(0);" data-do="prev" rel="nofollow">
                        <span class="pe-7s-angle-left"></span><?php echo esc_html__('Prev Deal', 'nasa-core'); ?>
                    </a>
                </div>
                <div class="nasa-nav-slick-next nasa-nav-slick-div">
                    <a class="nasa-nav-icon-slick" href="javascript:void(0);" data-do="next" rel="nofollow">
                        <?php echo esc_html__('Next Deal', 'nasa-core'); ?><span class="pe-7s-angle-right"></span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="nasa-special-deal-style-multi-wrap">
            <div
                id="nasa-slider-slick-<?php echo esc_attr($sc); ?>"
                class="nasa-nav-out slider products-group nasa-slider-deal-has-vertical products grid"
                data-nav_items="2"
                data-autoplay="<?php echo esc_attr($auto_slide); ?>"
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
                    $product_name = get_the_title() . ($product_error ? esc_html__(' - Has been an error. You need to rebuild this product.', 'nasa-core') : '');
                    ?>
                    <div class="nasa-special-deal-item nasa-special-deal-style-multi">
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
                                    <div class="product-deal-special-wrap-info">
                                        <div class="product-deal-special-title">
                                            <a href="<?php echo esc_url($product_link); ?>" title="<?php echo esc_attr($product_name); ?>">
                                                <?php echo $product_name; ?>
                                            </a>
                                        </div>

                                        <?php echo $rating_html ? $rating_html : ''; ?>

                                        <div class="product-deal-special-price price">
                                            <?php echo $product->get_price_html(); ?>
                                        </div>

                                        <?php if ($stock_available) :?>
                                            <div class="product-deal-special-progress">
                                                <div class="deal-stock-label">
                                                    <span class="stock-available text-left"><?php echo esc_html__('Available:', 'nasa-core'); ?> <strong><?php echo esc_html($stock_available); ?></strong></span>
                                                    <span class="stock-sold text-right"><?php echo esc_html__('Already Sold:', 'nasa-core'); ?> <strong><?php echo esc_html($stock_sold); ?></strong></span>
                                                </div>
                                                <div class="deal-progress">
                                                    <span class="deal-progress-bar" style="<?php echo esc_attr('width:' . $percentage . '%'); ?>"><?php echo $percentage; ?></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="product-deal-special-countdown">
                                            <?php echo nasa_time_sale($time_sale); ?>
                                        </div>

                                        <?php
                                        /**
                                         * Group buttons
                                         */
                                        do_action('nasa_special_deal_multi_action');
                                        ?>

                                        <?php if (!$stock_available) : ?>
                                            <div class="margin-bottom-40"> </div>
                                        <?php endif; ?>
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
    <div class="large-3 columns nasa-extra-nav-2-items hide-for-small rtl-left">
        <div class="nasa-slider-deal-vertical-extra-switcher nasa-slider-deal-vertical-extra-<?php echo esc_attr($sc); ?> wow fadeInUp<?php echo $nasa_animated_products ? ' ' . esc_attr($nasa_animated_products) : ''; ?>" data-wow-duration="1s" data-wow-delay="0ms" data-count="<?php echo count($vertical_product); ?>">
            <?php foreach ($vertical_product as $extra) :
                $product_thumb = $extra['product'];
                ?>
                <div class="item-slick">
                    <div class="nasa-slick-img nasa-fullwidth nasa-border-img">
                        <?php echo $product_thumb->get_image('shop_catalog'); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
