<?php
/**
 * Loop Add to Cart
 * 
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

$title = $product->add_to_cart_text();
$attributes = isset($attributes) ?
    $attributes : (isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '');

echo apply_filters(
    'woocommerce_loop_add_to_cart_link',
    sprintf(
        '<a href="%s" data-quantity="%s" class="%s product_type_%s" title="%s" %s>' .
            '<span class="add_to_cart_text">%s</span>' .
            '<i class="%s"></i>' .
        '</a>',
        esc_url($product->add_to_cart_url()), //link
        isset($quantity) ? esc_attr($quantity) : esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
        isset($class_button) ? esc_attr($class_button) : esc_attr(isset($args['class']) ? $args['class'] : 'add-to-cart-grid btn-link nasa-tip'),
        esc_attr($product->get_type()), //product type
        esc_attr($title),
        $attributes,
        $title,
        isset($icon_class) ? esc_attr($icon_class) : 'nasa-df-plus'
    ),
    $product
);
