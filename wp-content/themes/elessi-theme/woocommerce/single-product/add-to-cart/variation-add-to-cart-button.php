<?php
/**
 * Single variation cart button
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.4.0
 */
if (!defined('ABSPATH')) :
    exit;
endif;

global $nasa_opt, $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
    <?php
    do_action('woocommerce_before_add_to_cart_button');

    /**
     * @since 3.0.0.
     */
    do_action('woocommerce_before_add_to_cart_quantity');

    if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) :
        woocommerce_quantity_input(array(
            'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
            'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
            'input_value' => isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : $product->get_min_purchase_quantity(),
        ));
    endif;

    /**
     * @since 3.0.0.
     */
    do_action('woocommerce_after_add_to_cart_quantity');

    if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) :
        $product_id = $product->get_id();
        ?>
        <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
        <input type="hidden" name="add-to-cart" value="<?php echo absint($product_id); ?>" />
        <input type="hidden" name="product_id" value="<?php echo absint($product_id); ?>" />
        <input type="hidden" name="variation_id" class="variation_id" value="0" />
        <?php
    endif;

    do_action('woocommerce_after_add_to_cart_button');
    ?>
</div>
