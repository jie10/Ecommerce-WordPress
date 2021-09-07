<?php
/**
 * Override Template for Yith Bundles Plugin
 * 
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 4.8.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) :
    exit;
endif;

/** @var WC_Product_Yith_Bundle $product */

global $product;

if (!$product->is_purchasable()) :
    return;
endif;

if ($product->is_in_stock()) :
    do_action('woocommerce_before_add_to_cart_form');
    ?>

    <form class="cart" method="post" enctype='multipart/form-data'>
        <?php
        do_action('woocommerce_before_add_to_cart_button');
        if (!$product->is_sold_individually()) :
            woocommerce_quantity_input(array(
                'min_value' => apply_filters('woocommerce_quantity_input_min', 1, $product),
                'max_value' => apply_filters('woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product)
            ));
        endif;
        ?>

        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"/>
        <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_attr($product->single_add_to_cart_text()); ?></button>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </form>

    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php
endif;
