<?php
global $nasa_opt;
$countItems = count($wishlist_items);

/**
 * For Yith WooCommerce Wishlist 2.x or Lower
 */
if (!NASA_WISHLIST_NEW_VER) :
    do_action('yith_wcwl_before_wishlist_form', $wishlist_meta); ?>

    <form id="yith-wcwl-form" action="<?php echo esc_url(YITH_WCWL()->get_wishlist_url('view' . ($wishlist_meta['is_default'] != 1 ? '/' . $wishlist_meta['wishlist_token'] : ''))); ?>" method="post">

        <?php do_action('yith_wcwl_before_wishlist', $wishlist_meta); ?>

        <!-- WISHLIST TABLE -->
        <table class="shop_table wishlist_table" data-pagination="<?php echo esc_attr($pagination); ?>" data-per-page="<?php echo esc_attr($per_page); ?>" data-page="<?php echo esc_attr($current_page); ?>" data-id="<?php echo $wishlist_id; ?>" data-token="<?php echo $wishlist_token ?>">
            <tbody>
                <?php if ($countItems > 0) :
                    foreach ($wishlist_items as $item) :
                        global $product;
                        $product = wc_get_product($item['prod_id']);

                        if ($product && $product->exists()) :
                            $productId = $product->get_id();
                            $availability = $product->get_availability();
                            $stock_status = isset($availability['class']) ? $availability['class'] : 'in-stock';
                            ?>
                            <tr class="nasa-tr-wishlist-item" id="yith-wcwl-row-<?php echo (int) $productId; ?>" data-row-id="<?php echo (int) $productId; ?>">
                                <td class="product-wishlist-info">
                                    <div class="wishlist-item-warper nasa-relative">
                                        <div class="row wishlist-item">
                                            <div class="image-wishlist large-4 small-4 columns padding-left-0">
                                                <a href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $productId))); ?>">
                                                    <?php echo ($product->get_image('thumbnail')); ?>
                                                </a>
                                            </div>

                                            <div class="info-wishlist large-8 small-8 columns padding-right-0">
                                                <div class="row">
                                                    <div class="large-12 columns nasa-wishlist-title">
                                                        <a href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $productId))); ?>">
                                                            <?php echo apply_filters('woocommerce_in_cartproduct_obj_title', $product->get_name(), $product); ?>
                                                        </a>
                                                    </div>

                                                    <div class="wishlist-price large-12 columns">
                                                        <?php
                                                        if ($show_price) :?>
                                                            <span class="price"><?php echo ($product->get_price_html()); ?></span>
                                                        <?php
                                                        endif;

                                                        if ($show_stock_status && !empty($availability['availability'])) :
                                                            if ($stock_status == 'out-of-stock') :
                                                                echo '<span class="wishlist-out-of-stock"> - ' . $availability['availability'] . '</span>';
                                                            else :
                                                                echo '<span class="wishlist-in-stock"> - ' . $availability['availability'] . '</span>';
                                                            endif;

                                                        endif; ?>
                                                    </div>

                                                    <?php if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) :?>
                                                        <div class="add-to-cart-wishlist large-12 columns">
                                                            <?php 
                                                            if ($show_add_to_cart && $stock_status != 'out-of-stock'):
                                                                echo elessi_add_to_cart_in_wishlist();
                                                            endif;
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <?php if ($is_user_owner) : ?>
                                    <td class="product-remove">
                                        <a href="javascript:void(0);" class="remove nasa-remove_from_wishlist nasa-stclose" title="<?php esc_attr_e('Remove this product', 'elessi-theme'); ?>" data-logined="<?php echo (int) NASA_CORE_USER_LOGGED; ?>" data-prod_id="<?php echo (int) $productId; ?>" rel="nofollow">
                                            <?php esc_html_e('Remove', 'elessi-theme') ?>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endif;
                    endforeach;
                else: ?>
                    <tr class="pagination-row">
                        <td class="wishlist-empty"><p class="empty"><i class="nasa-empty-icon icon-nasa-like"></i><?php esc_html_e('No products in the wishlist.', 'elessi-theme') ?><a href="javascript:void(0);" class="button nasa-sidebar-return-shop" rel="nofollow"><?php echo esc_html__('RETURN TO SHOP', 'elessi-theme'); ?></a></p></td>
                    </tr>
                <?php
                endif;

                if (!empty($page_links)) : ?>
                    <tr>
                        <td colspan="6"><?php echo ($page_links); ?></td>
                    </tr>
                <?php endif ?>
            </tbody>

        </table>

        <?php wp_nonce_field('yith_wcwl_edit_wishlist_action', 'yith_wcwl_edit_wishlist'); ?>

        <?php if ($wishlist_meta['is_default'] != 1) : ?>
            <input type="hidden" value="<?php echo esc_attr($wishlist_meta['wishlist_token']); ?>" name="wishlist_id" id="wishlist_id" />
        <?php endif; ?>

        <?php do_action('yith_wcwl_after_wishlist', $wishlist_meta); ?>

    </form>

    <?php do_action('yith_wcwl_after_wishlist_form', $wishlist_meta); ?>

<?php else :
    /**
     * For Yith WooCommerce Wishlist 3.0 or Higher
     */
    ?>
    <!-- WISHLIST TABLE -->
    <table class="shop_table wishlist_table wishlist-fragment" data-pagination="<?php echo esc_attr($pagination); ?>" data-per-page="<?php echo esc_attr($per_page); ?>" data-page="<?php echo esc_attr($current_page); ?>" data-id="<?php echo $wishlist_id; ?>" data-token="<?php echo $wishlist_token ?>" data-fragment-options="<?php echo esc_attr(json_encode($fragment_options)); ?>">
        <tbody>
            <?php if ($countItems > 0) :
                foreach ($wishlist_items as $item) :
                    global $product;
                    $product = $item->get_product();

                    if ($product && $product->exists()) :
                        $productId = $product->get_id();
                    
                        $availability = $product->get_availability();
                        $stock_status = isset($availability['class']) ? $availability['class'] : 'in-stock';
                        ?>
                        <tr class="nasa-tr-wishlist-item" id="yith-wcwl-row-<?php echo (int) $productId; ?>" data-row-id="<?php echo (int) $productId; ?>">
                            <td class="product-wishlist-info">
                                <div class="wishlist-item-warper nasa-relative">
                                    <div class="row wishlist-item">
                                        <div class="image-wishlist large-4 small-4 columns padding-left-0">
                                            <a href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $productId))); ?>">
                                                <?php echo ($product->get_image('thumbnail')); ?>
                                            </a>
                                        </div>

                                        <div class="info-wishlist large-8 small-8 columns padding-right-0">
                                            <div class="row">
                                                <div class="large-12 columns nasa-wishlist-title">
                                                    <a href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $productId))); ?>">
                                                        <?php echo apply_filters('woocommerce_in_cartproduct_obj_title', $product->get_name(), $product); ?>
                                                    </a>
                                                </div>

                                                <div class="wishlist-price large-12 columns">
                                                    <?php
                                                    if ($show_price) :?>
                                                        <span class="price"><?php echo ($product->get_price_html()); ?></span>
                                                    <?php
                                                    endif;

                                                    if ($show_stock_status) :
                                                        if ($stock_status == 'out-of-stock') :
                                                            echo '<span class="wishlist-out-of-stock">' . esc_html__(' - Out of Stock', 'elessi-theme') . '</span>';
                                                        else :
                                                            echo '<span class="wishlist-in-stock">' . esc_html__(' - In Stock', 'elessi-theme') . '</span>';
                                                        endif;

                                                    endif; ?>
                                                </div>

                                                <?php if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) :?>
                                                    <div class="add-to-cart-wishlist large-12 columns">
                                                        <?php 
                                                        if ($show_add_to_cart && $stock_status != 'out-of-stock'):
                                                            echo elessi_add_to_cart_in_wishlist();
                                                        endif;
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <?php if ($is_user_owner) : ?>
                                <td class="product-remove">
                                    <a href="javascript:void(0);" class="remove nasa-remove_from_wishlist nasa-stclose" title="<?php esc_attr_e('Remove this product', 'elessi-theme'); ?>" data-logined="<?php echo (int) NASA_CORE_USER_LOGGED; ?>" data-prod_id="<?php echo (int) $productId; ?>" rel="nofollow">
                                        <?php esc_html_e('Remove', 'elessi-theme') ?>
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endif;
                endforeach;
                
                $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
                if ($wishlist_page_id) :
                    $wishlist_page_id = yith_wcwl_object_id($wishlist_page_id); ?>
                    <tr>
                        <td colspan="2">
                            <a href="<?php echo esc_url(get_permalink($wishlist_page_id)); ?>" class="button nasa-wishlist-page nasa-block margin-top-20"><?php echo esc_html__('Wishlist Page', 'elessi-theme'); ?></a>
                        </td>
                    </tr>
                <?php endif;
            else: ?>
                <tr class="pagination-row">
                    <td class="wishlist-empty">
                        <p class="empty">
                            <i class="nasa-empty-icon icon-nasa-like"></i>
                            <?php esc_html_e('No products in the wishlist.', 'elessi-theme') ?>
                            <a href="javascript:void(0);" class="button nasa-sidebar-return-shop" rel="nofollow"><?php echo esc_html__('RETURN TO SHOP', 'elessi-theme'); ?></a>
                        </p>
                    </td>
                </tr>
            <?php
            endif; ?>
        </tbody>

    </table>
<?php endif;
