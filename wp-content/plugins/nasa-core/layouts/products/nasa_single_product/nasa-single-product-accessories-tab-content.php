<?php
$link_main = $product->get_permalink();
$class_title = 'name';
$class_title .= (!isset($nasa_opt['cutting_product_name']) || $nasa_opt['cutting_product_name'] == '1') ? ' nasa-show-one-line' : '';
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
$total_price = $product->get_price();
?>
<div class="row nasa-relative nasa-bought-together-wrap">
    <div class="large-12 columns hidden-tag nasa-message-error"></div>
    <div class="large-9 columns rtl-right">
        <div class="nasa-accessories-wrap row">
            <!-- Current product -->
            <div class="nasa-large-5-col-1 small-6 medium-4 columns desktop-padding-left-25 desktop-padding-right-25 nasa-current-product wow fadeInUp product-item grid rtl-right" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms" data-wow="fadeInUp">
                <!-- Thumbnail -->
                <div class="product-img">
                    <?php echo $product->get_image(); ?>
                </div>

                <div class="info">
                    <?php /*!-- Categories -->
                    <div class="nasa-list-category">
                        <?php echo wc_get_product_category_list($product->get_id(), ', '); ?>
                    </div */?>

                    <!-- Title -->
                    <span class="<?php echo esc_attr($class_title); ?>">
                        <?php echo $product->get_name(); ?>
                    </span>

                    <!-- Price -->
                    <?php do_action('woocommerce_after_shop_loop_item_title'); ?>
                </div>
            </div>

            <!-- Accessories of the Current Product -->
            <?php
            $call_ajax = defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT ? ' nasa-ajax-call' : '';
            
            $_delay += $_delay_item;
            foreach ($accessories as $acc) :
                
                if (empty($acc) || !$acc->is_visible()) :
                    continue;
                endif;
                
                $product_id = $acc->get_id();
                $price_html = $acc->get_price_html();
                ?>
                <div class="nasa-large-5-col-1 small-6 medium-4 columns desktop-padding-right-25 desktop-padding-left-25 nasa-accessories-product wow fadeInUp product-item grid nasa-accessories-<?php echo (int) $product_id; ?> rtl-right" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms" data-wow="fadeInUp">
                    <!-- Thumbnail -->
                    <div class="product-img">
                        <a class="product-link<?php echo $call_ajax; ?>" href="<?php echo esc_url($acc->get_permalink()); ?>" title="<?php echo esc_attr($acc->get_name()); ?>">
                            <?php echo $acc->get_image(); ?>
                        </a>
                    </div>

                    <div class="info">
                        <?php /*!-- Categories -->
                        <div class="nasa-list-category">
                            <?php echo wc_get_product_category_list($product_id, ', '); ?>
                        </div */?>

                        <!-- Title -->
                        <a class="<?php echo esc_attr($class_title); ?><?php echo $call_ajax; ?>" href="<?php echo esc_url($acc->get_permalink()); ?>" title="<?php echo esc_attr($acc->get_name()); ?>">
                            <?php echo $acc->get_name(); ?>
                        </a>

                        <!-- Price -->
                        <?php if ($price_html) : ?>
                            <div class="price-wrap">
                                <span class="price">
                                    <?php echo $price_html; ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                $total_price += $acc->get_price();
                $_delay += $_delay_item;
            endforeach; ?>
        </div>
        
        <div class="nasa-accessories-check nasa-block nasa-relative margin-top-20 mobile-margin-bottom-20">
            <?php $price = $product->get_price(); ?>
            <span class="nasa-block nasa-accessories-item-check nasa-accessories-item-check-main">
                <input type="checkbox" value="<?php echo (int) $product->get_id(); ?>" checked disabled class="nasa-check-main-product inline-block" id="product-accessories-<?php echo (int) $product->get_id(); ?>" data-price="<?php echo esc_attr($price); ?>" />&nbsp;&nbsp;
                <label class="inline-block" for="product-accessories-<?php echo (int) $product->get_id(); ?>">
                    <?php
                    echo '<strong>' . esc_html__('This product: ', 'nasa-core') . '</strong>' . $product->get_name();
                    echo '<span class="nasa-accessories-price price">&nbsp;&nbsp;(' . wc_price($price) . ')</span>';
                    ?>
                </label>
            </span>
            
            <?php foreach ($accessories as $acc) :
                if (empty($acc) || !$acc->is_visible()) :
                    continue;
                endif;
                
                $price = $acc->get_price();
                ?>
                <span class="nasa-block nasa-accessories-item-check">
                    <input type="checkbox" value="<?php echo (int) $acc->get_id(); ?>" checked class="nasa-check-accessories-product inline-block" id="product-accessories-<?php echo (int) $acc->get_id(); ?>" data-price="<?php echo esc_attr($price); ?>" />&nbsp;&nbsp;
                    <label class="inline-block" for="product-accessories-<?php echo (int) $acc->get_id(); ?>">
                        <?php
                        echo $acc->get_name();
                        echo '<span class="nasa-accessories-price price">&nbsp;&nbsp;(' . wc_price($acc->get_price()) . ')</span>';
                        ?>
                    </label>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="large-3 columns mobile-margin-bottom-20 rtl-left text-right rtl-text-left mobile-text-left rtl-mobile-text-right">
        <div class="nasa-accessories-total-price">
            <?php echo esc_html__('Total Price: ', 'nasa-core') . '<span class="price">' . wc_price($total_price) . '</span>'; ?>
        </div>
        
        <?php if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) : ?>
            <div class="nasa-accessories-add-to-cart margin-top-15">
                <a href="javascript:void(0)" rel="nofollow" class="add_to_cart_accessories button" title="<?php echo esc_attr__('All add to Cart', 'nasa-core'); ?>"><?php echo esc_html__('Add all to Cart', 'nasa-core'); ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>
