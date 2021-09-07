<?php
$countItems = count($wishlist_items);
?>

<!-- WISHLIST TABLE -->
<table class="shop_table wishlist_table wishlist-fragment">
    <tbody>
        <?php if ($countItems > 0) :
            foreach ($wishlist_items as $item) :
                global $product;
                $product = wc_get_product($item);
                
                if (empty($product)) :
                    continue;
                endif;
                
                $productId = $product->get_id();
                $status = $product->get_status();
                $title_product = apply_filters('woocommerce_in_cartproduct_obj_title', $product->get_name(), $product);
                
                if (!$product->is_visible() || $status != 'publish') : ?>
                    <tr class="nasa-tr-wishlist-item hidden-tag item-invisible" id="nasa-wishlist-row-<?php echo (int) $productId; ?>" data-row-id="<?php echo (int) $productId; ?>">
                        <td class="product-remove" colspan="2">
                            <a href="javascript:void(0);" class="remove nasa-remove_from_wishlist btn-wishlist btn-nasa-wishlist nasa-added" title="<?php esc_attr_e('Remove this product', 'elessi-theme'); ?>" data-prod="<?php echo (int) $productId; ?>" rel="nofollow">
                                <?php esc_html_e('Remove', 'elessi-theme') ?>
                            </a>
                        </td>
                    </tr>
                    <?php
                    continue;
                endif;

                $availability = $product->get_availability();
                $stock_status = isset($availability['class']) ? $availability['class'] : 'in-stock';
                ?>
                <tr class="nasa-tr-wishlist-item" id="nasa-wishlist-row-<?php echo (int) $productId; ?>" data-row-id="<?php echo (int) $productId; ?>">
                    <td class="product-wishlist-info">
                        <div class="wishlist-item">
                            <div class="image-wishlist left rtl-right">
                                <a href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $productId))); ?>" title="<?php echo esc_attr($title_product); ?>">
                                    <?php echo $product->get_image('thumbnail'); ?>
                                </a>
                            </div>

                            <div class="info-wishlist left rtl-right padding-left-15 rtl-padding-left-0 rtl-padding-right-15">
                                <a class="nasa-wishlist-title" href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $productId))); ?>" title="<?php echo esc_attr($title_product); ?>">
                                    <?php echo $title_product; ?>
                                </a>

                                <div class="wishlist-price">
                                    <span class="price">
                                        <?php echo $product->get_price_html(); ?>
                                    </span>

                                    <?php
                                    if (!empty($availability['availability'])) :
                                        if ($stock_status == 'out-of-stock') :
                                            echo '<span class="wishlist-out-of-stock"> - ' . $availability['availability'] . '</span>';
                                        else :
                                            echo '<span class="wishlist-in-stock"> - ' . $availability['availability'] . '</span>';
                                        endif;
                                    endif;
                                    ?>
                                </div>

                                <?php
                                if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) :
                                    if ($stock_status != 'out-of-stock'):
                                        echo '<div class="add-to-cart-wishlist nasa-relative inline-block">';
                                        echo elessi_add_to_cart_in_wishlist();
                                        echo '</div>';
                                    endif;
                                endif;
                                ?>
                            </div>
                        </div>
                    </td>
                    
                    <td class="product-remove">
                        <a href="javascript:void(0);" class="remove nasa-remove_from_wishlist btn-wishlist btn-nasa-wishlist nasa-stclose nasa-added" title="<?php esc_attr_e('Remove', 'elessi-theme'); ?>" data-prod="<?php echo (int) $productId; ?>" rel="nofollow">
                            <?php esc_html_e('Remove', 'elessi-theme') ?>
                        </a>
                    </td>
                </tr>
                
            <?php endforeach;
        else: ?>
            <tr>
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
