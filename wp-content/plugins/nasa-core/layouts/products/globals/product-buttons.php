<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$productId = $product->get_id();
$products_cats = wc_get_product_category_list($productId);
list($fistpart) = explode(',', $products_cats);
$classTip = $toltip ? ' nasa-tip' : '';
$nasa_compare = (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare']) ? true : false;

?>
<div class="nasa-product-grid">
    <?php if (defined('YITH_WCWL')):?>
        <div class="btn-wishlist<?php echo $classTip;?>" data-prod="<?php echo (int) $productId; ?>" data-tip="<?php esc_html_e('Wishlist', 'nasa-core'); ?>" title="<?php esc_html_e('Wishlist', 'nasa-core'); ?>">
            <div class="btn-link ">
                <div class="wishlist-icon">
                    <span class="pe-icon pe-7s-like"></span>
                    <span class="hidden-tag nasa-icon-text">
                        <?php esc_html_e('Wishlist', 'nasa-core'); ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif;?>

    <span class="hidden-tag nasa-seperator"></span>

    <?php if (defined('YITH_WOOCOMPARE')):?>
        <div class="btn-compare<?php echo $classTip;?><?php echo $nasa_compare ? ' nasa-compare' : ''; ?>" data-prod="<?php echo (int) $productId; ?>" data-tip="<?php esc_html_e('Compare', 'nasa-core'); ?>" title="<?php esc_html_e('Compare', 'nasa-core'); ?>">
            <div class="btn-link">
                <div class="compare-icon">
                    <span class="pe-icon pe-7s-repeat"></span>
                    <span class="nasa-icon-text">
                        <?php esc_html_e('Compare', 'nasa-core'); ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif;?>

    <div class="btn-gift-link<?php echo esc_attr($classTip); ?>" data-prod="<?php echo (int) $productId; ?>" data-tip="<?php esc_html_e('Gift', 'nasa-core'); ?>" title="<?php esc_html_e('Gift', 'nasa-core'); ?>">
        <div class="btn-link">
            <div class="gift-icon">
                <span class="pe-icon pe-7s-gift"></span>
                <span class="hidden-tag nasa-icon-text">
                    <?php esc_html_e('Gift', 'nasa-core'); ?>
                </span>
            </div>
        </div>
    </div>

    <div class="add-to-link hidden-tag">
        <?php echo defined('YITH_WCWL') ? do_shortcode('[yith_wcwl_add_to_wishlist]') : ''; ?>
        <?php if (!$nasa_compare) : ?>
            <div class="woocommerce-compare-button">
                <?php echo defined('YITH_WOOCOMPARE') ? do_shortcode('[yith_compare_button]') : ''; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="clear"></div>
</div>
