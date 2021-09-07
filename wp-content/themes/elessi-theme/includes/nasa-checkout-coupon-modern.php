<?php
/**
 * Checkout coupon form Clone
 * 
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * Since 4.4.5
 */
defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) {
    return;
}
?>
<tr><td colspan="2" class="coupon-clone-td">
<a href="javascript:void(0);" class="showcoupon-clone" rel="nofollow"><?php echo esc_html__('Have a coupon code?', 'elessi-theme'); ?></a>
<div class="form-row form-row-first margin-top-10 coupon-clone-wrap hidden-tag">
    <div class="nasa-flex">
        <input type="text" name="coupon_code_clone" class="input-text margin-right-10 rtl-margin-right-0 rtl-margin-left-10" placeholder="<?php esc_attr_e('Coupon code', 'elessi-theme'); ?>" id="coupon_code-clone" value="" />
        <button type="submit" class="button" name="apply_coupon_clone" value="<?php esc_attr_e('Apply coupon', 'elessi-theme'); ?>" id="apply_coupon_clone"><?php esc_html_e('Apply', 'elessi-theme'); ?></button>
    </div>
</div>
</td></tr>
