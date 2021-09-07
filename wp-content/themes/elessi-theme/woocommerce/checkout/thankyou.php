<?php
/**
 * Thankyou page
 * 
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.7.0
 */

defined('ABSPATH') or exit;

echo '<div class="woocommerce-order">';

if ($order) :
    do_action('woocommerce_before_thankyou', $order->get_id());
    ?>
    <div class="row nasa-order-received">
        <div class="large-12 columns nasa-order-received-left">
            <div class="nasa-warper-order margin-bottom-20">
                <?php if ($order->has_status('failed')) : ?>
                    <p class="woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'elessi-theme'); ?></p>

                    <p class="woocommerce-thankyou-order-failed-actions">
                        <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php esc_html_e('Pay', 'elessi-theme') ?></a>
                        <?php if (NASA_CORE_USER_LOGGED) : ?>
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php esc_html_e('My Account', 'elessi-theme'); ?></a>
                        <?php endif; ?>
                    </p>
                <?php else : ?>
                    <p class="woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'elessi-theme'), $order); ?></p>
                    <ul class="woocommerce-thankyou-order-details order_details">
                        <li class="order">
                            <?php esc_html_e('Order Number', 'elessi-theme'); ?>
                            <strong><?php echo (int) $order->get_order_number(); ?></strong>
                        </li>
                        <li class="date">
                            <?php esc_html_e('Date', 'elessi-theme'); ?>
                            <strong><?php echo wc_format_datetime($order->get_date_created()); ?></strong>
                        </li>
                        <li class="total">
                            <?php esc_html_e('Total', 'elessi-theme'); ?>
                            <strong><?php echo ($order->get_formatted_order_total()); ?></strong>
                        </li>
                        <?php if ($order->get_payment_method_title()) : ?>
                            <li class="method">
                                <?php esc_html_e('Payment Method', 'elessi-theme'); ?>
                                <strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="clear"></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="large-12 columns nasa-order-received-right">
            <div class="nasa-warper-order">
                <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
                <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <p class="woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'elessi-theme'), null); ?></p>
<?php
endif;

echo '</div>';
