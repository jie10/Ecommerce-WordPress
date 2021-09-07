<?php
$layout_buttons_class = '';
if (isset($nasa_opt['loop_layout_buttons']) && $nasa_opt['loop_layout_buttons'] != '') {
    $layout_buttons_class = ' nasa-' . $nasa_opt['loop_layout_buttons'];
}

$arrows = isset($arrows) ? $arrows : 0;
$auto_slide = isset($auto_slide) ? $auto_slide : 'true';

$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;

$height_auto = !isset($height_auto) ? 'true' : $height_auto;

$dots = isset($dots) ? $dots : 'false';

$cat_info = apply_filters('nasa_loop_categories_show', false);
$description_info = apply_filters('nasa_loop_short_description_show', false);

$class_slide = 'nasa-slider-items-margin nasa-slick-slider products grid' . $layout_buttons_class;

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

<div class="nasa-warp-slide-nav-top nasa-slider-wrap">
    <div class="nasa-title">
        <h3 class="nasa-title-heading">
            <?php echo $title; ?>
        </h3>

        <?php if ($arrows == 1) : ?>
            <div class="nasa-nav-carousel-wrap">
                <a class="nasa-nav-icon-slider nasa-transition pe-7s-angle-left" href="javascript:void(0);" data-do="prev" rel="nofollow"></a>
                <a class="nasa-nav-icon-slider nasa-transition pe-7s-angle-right" href="javascript:void(0);" data-do="next" rel="nofollow"></a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($desc_shortcode) : ?>
        <p class="nasa-desc">
            <?php echo $desc_shortcode; ?>
        </p>
    <?php endif; ?>

    <div class="nasa-deal-for-time">
        <div class="nasa-sc-pdeal-countdown">
            <?php echo nasa_time_sale($deal_time, false); ?>
        </div>
    </div>
        
    <div class="nasa-slide-special-product-deal-for-time">
        <div class="<?php echo esc_attr($class_slide); ?>"<?php echo $attrs_str; ?>>
            <?php
            while ($specials->have_posts()) :
                $specials->the_post();
                
                global $product;
                if (empty($product) || !$product->is_visible()) :
                    continue;
                endif;
                
                wc_get_template(
                    'content-product.php',
                    array(
                        'is_deals' => false,
                        '_delay' => $_delay,
                        'wrapper' => 'div',
                        'show_in_list' => false,
                        'cat_info' => $cat_info,
                        'description_info' => $description_info
                    )
                );

                $_delay += $_delay_item;
            endwhile;
            
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>
