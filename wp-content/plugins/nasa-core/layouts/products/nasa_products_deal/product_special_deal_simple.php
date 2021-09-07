<?php
/**
 * Hover effect products in grid
 */
$nasa_animated_products = isset($nasa_opt['animated_products']) ? $nasa_opt['animated_products'] : '';

$layout_buttons_class = '';
if (isset($nasa_opt['loop_layout_buttons']) && $nasa_opt['loop_layout_buttons'] != '') {
    $layout_buttons_class = ' nasa-' . $nasa_opt['loop_layout_buttons'];
}

$arrows = isset($arrows) ? $arrows : 0;
$auto_slide = isset($auto_slide) ? $auto_slide : 'true';

$class_slide = 'nasa-slider-items-margin nasa-slick-slider products grid' . $layout_buttons_class;
$class_slide .= $arrows == 1 ? ' nasa-slick-nav nasa-nav-top-right' : '';

$columns_small = $columns_number_small == '1.5' ? '1' : $columns_number_small;

/**
 * Attributes sliders
 */
$data_attrs = array();
$data_attrs[] = 'data-columns="' . esc_attr($columns_number) . '"';
$data_attrs[] = 'data-columns-small="' . esc_attr($columns_small) . '"';
$data_attrs[] = 'data-columns-tablet="' . esc_attr($columns_number_tablet) . '"';
$data_attrs[] = 'data-autoplay="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-slides-all="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-switch-tablet="' . nasa_switch_tablet() . '"';
$data_attrs[] = 'data-switch-desktop="' . nasa_switch_desktop() . '"';

if ($columns_number_small == '1.5') {
    $data_attrs[] = 'data-padding-small="20%"';
}

$attrs_str = !empty($data_attrs) ? ' ' . implode(' ', $data_attrs) : '';
?>

<?php if (isset($title) && $title != '') : ?>
    <div class="nasa-title">
        <h3 class="nasa-heading-title">
            <?php echo esc_attr($title); ?>
        </h3>
    </div>
<?php endif; ?>

<div class="nasa-relative nasa-slider-wrap nasa-slide-style-product-deal nasa-slide-special-product-deal padding-top-10">
    <div class="<?php echo esc_attr($class_slide); ?>"<?php echo $attrs_str; ?>>
    <?php
    while ($specials->have_posts()) :
        $specials->the_post();
        
        global $product;
        if (empty($product) || !$product->is_visible()) :
            continue;
        endif;

        $product_error = false;
        $productId = $product->get_id();
        $productType = $product->get_type();
        $postId = $productType == 'variation' ? wp_get_post_parent_id($productId) : $productId;
        if (!$postId) {
            $product_error = true;
        }

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

        $product_link = $product_error ? '#' : get_the_permalink();
        $product_name = get_the_title() . ($product_error ? esc_html__(' - Has been an error. You need to rebuild this product.', 'nasa-core') : '');
        ?>
        <div class="nasa-special-deal-item">
            <div class="wow fadeInUp product-deals product-item<?php echo $nasa_animated_products ? ' ' . esc_attr($nasa_animated_products) : ''; ?>" data-wow-duration="1s" data-wow-delay="0ms">
                <div class="product-special-deals">
                    <div class="product-img-wrap">
                        <?php do_action('nasa_special_deal_simple_action'); ?>
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

                    <a class="product-deal-special-title" href="<?php echo esc_url($product_link); ?>" title="<?php echo esc_attr($product_name); ?>">
                        <?php echo $product_name; ?>
                    </a>

                    <div class="product-deal-special-price price">
                        <?php echo $product->get_price_html(); ?>
                    </div>

                    <div class="product-deal-special-countdown text-center margin-bottom-20">
                        <?php echo nasa_time_sale($time_sale); ?>
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
