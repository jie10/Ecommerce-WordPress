<?php
/**
 * Quantity Input
 * 
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 4.0.0
 */

defined('ABSPATH') || exit;

if ($max_value && $min_value === $max_value) :
    ?>
    <div class="quantity hidden">
        <input type="hidden" id="<?php echo esc_attr($input_id); ?>" class="qty" name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($min_value); ?>" />
    </div>
    <?php
else :
    /* translators: %s: Quantity. */
    $label = !empty($args['product_name']) ? sprintf(esc_html__('%s quantity', 'elessi-theme'), wp_strip_all_tags($args['product_name'])) : esc_html__('Quantity', 'elessi-theme');

    $classes = isset($classes) ? $classes : array('input-text', 'qty', 'text');
    ?>
    <div class="quantity buttons_added">
        <?php do_action('woocommerce_before_quantity_input_field'); ?>
        
        <label class="screen-reader-text hidden-tag" for="<?php echo esc_attr($input_id); ?>">
            <?php echo esc_attr($label); ?>
        </label>
        
        <a href="javascript:void(0)" class="plus" rel="nofollow">+</a>
        <input 
            type="number" 
            id="<?php echo esc_attr($input_id); ?>" 
            class="<?php echo esc_attr(join(' ', (array) $classes)); ?>" 
            step="<?php echo esc_attr($step); ?>" 
            min="<?php echo esc_attr($min_value); ?>" 
            max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>" 
            name="<?php echo esc_attr($input_name); ?>" 
            value="<?php echo esc_attr($input_value); ?>"
            data-old="<?php echo esc_attr($input_value); ?>"
            title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'elessi-theme'); ?>" 
            size="4" 
            placeholder="<?php echo esc_attr($placeholder); ?>" 
            inputmode="<?php echo esc_attr($inputmode); ?>" />
        <a href="javascript:void(0)" class="minus" rel="nofollow">-</a>
        
        <?php do_action('woocommerce_after_quantity_input_field'); ?>
    </div>
    <?php
endif;
