<?php
/**
 * Popup after add to cart
 * Your Order Popup
 */

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;
do_action('popup_woocommerce_before_cart');
?>

<h3 class="nasa-title-after-add-to-cart text-center">
    <?php echo esc_html__('Your Order', 'elessi-theme'); ?>
</h3>

<form class="after-add-to-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('popup_woocommerce_before_cart_table'); ?>

    <div class="nasa-table-wrap">
        <table class="after-add-to-cart-shop_table responsive woocommerce-cart-form__contents">
            <thead>
                <tr>
                    <th class="product-name" colspan="3"><?php esc_html_e('Product', 'elessi-theme'); ?></th>
                    <th class="product-price hide-for-small"><?php esc_html_e('Price', 'elessi-theme'); ?></th>
                    <th class="product-quantity"><?php esc_html_e('Quantity', 'elessi-theme'); ?></th>
                    <th class="product-subtotal hide-for-small"><?php esc_html_e('Total', 'elessi-theme'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php do_action('popup_woocommerce_before_cart_contents'); ?>
                <?php
                foreach ($cart_items as $cart_item_key => $cart_item) :
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :

                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

                        $priceProduct = apply_filters(
                            'woocommerce_cart_item_price',
                            $nasa_cart->get_product_price($_product),
                            $cart_item,
                            $cart_item_key
                        );

                        ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                            <td class="product-remove remove-product">
                                <?php echo apply_filters(
                                    'woocommerce_cart_item_remove_link',
                                    sprintf('<a href="%s" class="remove_from_cart_popup nasa-stclose" title="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
                                        esc_url(function_exists('wc_get_cart_remove_url') ? wc_get_cart_remove_url($cart_item_key) : $nasa_cart->get_remove_url($cart_item_key)),
                                        esc_attr__('Remove', 'elessi-theme'),
                                        esc_attr($product_id),
                                        esc_attr($_product->get_sku()),
                                        esc_html__('Remove', 'elessi-theme')
                                    ), $cart_item_key
                                ); ?>
                            </td>
                            <td class="product-thumbnail">
                                <?php
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', str_replace(array('http:', 'https:'), '', $_product->get_image()), $cart_item, $cart_item_key);
                                if (!$product_permalink) :
                                    echo $thumbnail;
                                else :
                                    printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                endif;
                                ?>
                            </td>

                            <td class="product-name" data-title="<?php esc_attr_e('Product', 'elessi-theme'); ?>">
                                <?php
                                if (!$product_permalink):
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;');
                                else:
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                endif;

                                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                // Meta data
                                echo function_exists('wc_get_formatted_cart_item_data') ? wc_get_formatted_cart_item_data($cart_item) : $nasa_cart->get_item_data($cart_item);

                                // Backorder notification
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) :
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'elessi-theme') . '</p>', $product_id));
                                endif;
                                ?>
                                <div class="mobile-price show-for-small" data-title="<?php esc_attr_e('Price', 'elessi-theme'); ?>">
                                    <?php echo $priceProduct; ?>
                                </div>
                            </td>

                            <td class="product-price hide-for-small" data-title="<?php esc_attr_e('Price', 'elessi-theme'); ?>">
                                <?php echo $priceProduct; ?>
                            </td>

                            <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'elessi-theme'); ?>">
                                <?php
                                if ($_product->is_sold_individually()) :
                                    $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                else :
                                    $product_quantity = woocommerce_quantity_input(
                                        array(
                                            'input_name'   => "cart[{$cart_item_key}][qty]",
                                            'input_value'  => $cart_item['quantity'],
                                            'max_value'    => $_product->get_max_purchase_quantity(),
                                            'min_value'    => '0',
                                            'product_name' => $_product->get_name(),
                                        ),
                                        $_product,
                                        false
                                    );
                                endif;
                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                ?>
                            </td>

                            <td class="product-subtotal hide-for-small" data-title="<?php esc_attr_e('Total', 'elessi-theme'); ?>">
                                <?php
                                    echo apply_filters('woocommerce_cart_item_subtotal', $nasa_cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                ?>
                            </td>
                        </tr>
                        <?php
                    endif;
                endforeach;

                do_action('popup_woocommerce_cart_contents');

                do_action('popup_woocommerce_after_cart_contents');
                ?>
            </tbody>
        </table>
    </div>

    <?php do_action('popup_woocommerce_after_cart_table'); ?>

    <div class="nasa-after-add-to-cart-subtotal text-center">
        <span class="nasa-after-add-to-cart-subtotal-title">
            <?php esc_html_e('Subtotal&nbsp;&nbsp;&nbsp;', 'elessi-theme'); ?>
        </span>
        <span class="nasa-after-add-to-cart-subtotal-price">
            <?php wc_cart_totals_subtotal_html(); ?>
        </span>
    </div>

    <?php do_action('nasa_subtotal_free_shipping'); ?>

    <div class="nasa-after-add-to-cart-buttons margin-top-20">
        <a class="button nasa-disable nasa-update-cart-popup left rtl-right" href="javascript:void(0);" title="<?php esc_attr_e('Update Cart', 'elessi-theme'); ?>" rel="nofollow">
            <?php esc_html_e('Update Cart', 'elessi-theme'); ?>
        </a>

        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-button button alt wc-forward right rtl-left" title="<?php esc_attr_e('Proceed to checkout', 'elessi-theme'); ?>">
            <?php esc_html_e('Proceed to checkout', 'elessi-theme'); ?>
        </a>
    </div>

    <div class="clearfix"></div>

    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
</form>

<?php
do_action('popup_woocommerce_after_cart');
