<?php
/**
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

do_action('nasa_single_product_layout');

do_action('woocommerce_after_single_product');
