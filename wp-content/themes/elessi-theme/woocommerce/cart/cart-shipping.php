<?php
/**
 * Shipping Methods Display
 * 
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * 
 * @version 3.6.0
 */
defined('ABSPATH') || exit;

$is_cart = is_cart();
$class_shipping = 'woocommerce-shipping-methods';

if ($is_cart) :
    global $nasa_opt;
    
    $hide_in_cart = defined('NASA_CHECKOUT_LAYOUT') && NASA_CHECKOUT_LAYOUT == 'modern' && (!isset($nasa_opt['cart_1_shiping']) || $nasa_opt['cart_1_shiping']) ? true : false;
    $no_check_shipping_in_cart = apply_filters('nasa_no_check_shipping_in_cart', $hide_in_cart);
    
    $class_shipping .= $no_check_shipping_in_cart ? ' hide-check-shipping' : '';
endif;

$formatted_destination = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping = !empty($has_calculated_shipping);
$show_shipping_calculator = !empty($show_shipping_calculator);
$calculator_text = '';
?>

<?php if ($is_cart || !defined('NASA_CHECKOUT_LAYOUT') || NASA_CHECKOUT_LAYOUT != 'modern') : ?>
    <tr class="woocommerce-shipping-totals shipping">
        <th><?php echo wp_kses_post($package_name); ?></th>
        <td data-title="<?php echo esc_attr($package_name); ?>">
<?php else: ?>
    <div class="shipping-wrap-modern">
        <h5 class="shipping-package-name hidden-tag"><?php echo wp_kses_post($package_name); ?></h5>
<?php endif; ?>
        <?php if ($available_methods) : ?>
            <ul id="shipping_method" class="<?php echo $class_shipping; ?>">
                <?php foreach ($available_methods as $method) : ?>
                    <li>
                        <?php
                        if (1 < count($available_methods)) {
                            printf('<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false)); // WPCS: XSS ok.
                        } else {
                            printf('<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id)); // WPCS: XSS ok.
                        }
                        printf('<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr(sanitize_title($method->id)), wc_cart_totals_shipping_method_label($method)); // WPCS: XSS ok.
                        do_action('woocommerce_after_shipping_rate', $method, $index);
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <?php if ($is_cart) : ?>
                <p class="woocommerce-shipping-destination">
                    <?php
                    if ($formatted_destination) {
                        // Translators: $s shipping destination.
                        printf(esc_html__('Shipping to %s.', 'elessi-theme') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>');
                        $calculator_text = esc_html__('Change address', 'elessi-theme');
                    } else {
                        echo wp_kses_post(apply_filters('woocommerce_shipping_estimate_html', __('Shipping options will be updated during checkout.', 'elessi-theme')));
                    }
                    ?>
                </p>
            <?php endif; ?>

        <?php elseif (!$has_calculated_shipping || !$formatted_destination) :
            if ($is_cart && 'no' === get_option('woocommerce_enable_shipping_calc')) {
                echo wp_kses_post(apply_filters('woocommerce_shipping_not_enabled_on_cart_html', __('Shipping costs are calculated during checkout.', 'elessi-theme')));
            } else {
                echo wp_kses_post(apply_filters('woocommerce_shipping_may_be_available_html', __('Enter your address to view shipping options.', 'elessi-theme')));
            }
        elseif (!$is_cart) :
            echo wp_kses_post(apply_filters('woocommerce_no_shipping_available_html', __('There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'elessi-theme')));
        else :
            // Translators: $s shipping destination.
            echo wp_kses_post(apply_filters('woocommerce_cart_no_shipping_available_html', sprintf(esc_html__('No shipping options were found for %s.', 'elessi-theme') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>')));
            $calculator_text = esc_html__('Enter a different address', 'elessi-theme');
        endif;
        ?>

        <?php if ($show_package_details) : ?>
            <?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html($package_details) . '</small></p>'; ?>
        <?php endif; ?>

        <?php if ($show_shipping_calculator) : ?>
            <?php woocommerce_shipping_calculator($calculator_text); ?>
        <?php endif; ?>

<?php if ($is_cart || !defined('NASA_CHECKOUT_LAYOUT') || NASA_CHECKOUT_LAYOUT != 'modern') : ?>
        </td>
    </tr>
<?php else : ?>
    </div>
<?php
endif;
