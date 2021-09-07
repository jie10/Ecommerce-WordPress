<?php
$auto_slide = isset($auto_slide) ? $auto_slide : 'false';
$dots = isset($dots) ? $dots : 'false';
?>

<div
    class="nasa-slick-slider nasa-product-simple-2 products grid"
    data-columns="1"
    data-columns-small="1"
    data-columns-tablet="1"
    data-autoplay="<?php echo esc_attr($auto_slide); ?>"
    data-dot="<?php echo esc_attr($dots); ?>"
    data-height-auto="true"
    data-switch-tablet="<?php echo nasa_switch_tablet(); ?>"
    data-switch-desktop="<?php echo nasa_switch_desktop(); ?>">
    <?php
    $k = 0;
    while ($loop->have_posts()) :
        $loop->the_post();
        global $product;

        if (empty($product) || !$product->is_visible()) :
            continue;
        endif;

        $product_id = $product->get_id();

        $nasa_cats = '<div class="nasa-list-category">';
        $nasa_cats .= wc_get_product_category_list($product_id, ', ');
        $nasa_cats .= '</div>';

        $nasa_link = $product->get_permalink();

        $nasa_title = $product->get_name();
        $attach_id = nasa_get_product_meta_value($product_id, '_product_image_simple_slide');
        $image = false;
        if ((int) $attach_id) :
            $image_object = wp_get_attachment_image_src((int) $attach_id, 'full');
            $image = isset($image_object[0]) ? 
                '<img src="' . esc_url($image_object[0]) . '" alt="' . esc_attr($nasa_title) . '" width="' . esc_attr($image_object[1]) . '" height="' . esc_attr($image_object[2]) . '" />' : false;
        endif;

        global $post;
        $post_object = get_post($product_id);
        setup_postdata($GLOBALS['post'] =& $post_object);
        $post_excerpt = apply_filters('woocommerce_short_description', $post->post_excerpt);
        $short_desc = $post_excerpt ? '<div class="info_main product-des-wrap product-des">' . $post_excerpt . '</div>' : '';
    ?>

        <div class="nasa-product-item-wrap">
            <div class="row nasa-flex">
                <div class="image-wrap large-6 columns rtl-right mobile-margin-bottom-30">
                    <?php echo !$image ? $product->get_image('large') : $image; ?>
                </div>

                <div class="product-info-wrap info rtl-right large-6 columns padding-left-50 mobile-padding-left-10 rtl-padding-right-50 rtl-padding-left-10 rtl-mobile-padding-right-10">
                    <div class="nasa-inner-wrap">
                        <?php echo $nasa_cats; ?>

                        <a class="name" title="<?php echo esc_attr($nasa_title); ?>" href="<?php echo esc_url($nasa_link); ?>">
                            <?php echo $nasa_title; ?>
                        </a>

                        <?php echo wp_kses_post(wc_get_rating_html($product->get_average_rating())); ?>

                        <?php echo $short_desc; ?>

                        <div class="wrap-price-btn">
                            <span class="price left rtl-right margin-right-50 rtl-margin-right-0 rtl-margin-left-50">
                                <?php echo $product->get_price_html(); ?>
                            </span>

                            <a class="button" title="<?php echo esc_attr__('Shop now', 'nasa-core'); ?>" href="<?php echo esc_url($nasa_link); ?>"><?php echo esc_html__('Shop now', 'nasa-core'); ?></a>
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
