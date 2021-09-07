<?php
/**
 * Checkout Form: Layout - Modern
 */
if (!defined('ABSPATH')) {
    exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) :
    /**
     * Hook Login form
     */
    do_action('woocommerce_before_checkout_form', $checkout);
    
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', esc_html__('You must be logged in to checkout.', 'elessi-theme'));
    return;
endif;
?>

<!-- Checkout BG -->
<div class="checkout-modern-bg hide-for-mobile">
    <div class="checkout-modern-bg-left"></div>
    <div class="checkout-modern-bg-right"></div>
</div>

<div class="row">
    
    <!-- Checkout Wrap -->
    <div class="checkout-modern-wrap large-12 columns">
        
        <!-- Checkout Left -->
        <div class="checkout-modern-left-wrap">
            <!-- Checkout Logo -->
            <div class="mobile-text-center">
                <?php echo elessi_logo(); ?>
            </div>
            
            <!-- Checkout Mobile Your Order -->
            <a href="javascript:void(0);" class="hidden-tag your-order-mobile" rel="nofollow">
                <span class="your-order-title">
                    <i class="nasa-icon icon-nasa-cart-3 margin-right-10 rtl-margin-right-0 rtl-margin-left-10"></i><?php echo esc_html__('Your Order', 'elessi-theme'); ?><i class="nasa-icon icon-nasa-icons-10 margin-left-10 rtl-margin-left-0 rtl-margin-right-10"></i>
                </span>
                <span class="your-order-price"></span>
            </a>
            
            <!-- Checkout Breadcrumb -->
            <nav class="nasa-bc-modern">
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php echo esc_attr__('CART', 'elessi-theme'); ?>"><?php echo esc_html__('CART', 'elessi-theme'); ?></a>
                <i class="nasa-bc-modern-sp"></i>
                <a href="javascript:void(0);" title="<?php echo esc_attr__('INFORMATION', 'elessi-theme'); ?>" rel="nofollow" class="nasa-billing-step active"><?php echo esc_html__('INFORMATION', 'elessi-theme'); ?></a>
                <i class="nasa-bc-modern-sp"></i>
                <a href="javascript:void(0);" title="<?php echo esc_attr__('SHIPPING', 'elessi-theme'); ?>" rel="nofollow" class="nasa-shipping-step"><?php echo esc_html__('SHIPPING', 'elessi-theme'); ?></a>
                <i class="nasa-bc-modern-sp"></i>
                <a href="javascript:void(0);" title="<?php echo esc_attr__('PAYMENT', 'elessi-theme'); ?>" rel="nofollow" class="nasa-payment-step"><?php echo esc_html__('PAYMENT', 'elessi-theme'); ?></a>
            </nav>

            <?php do_action('woocommerce_before_checkout_form', $checkout); ?>
            
            <!-- Checkout Form -->
            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
                <?php if ($checkout->get_checkout_fields()) : ?>
                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <div class="checkout-group woo-billing">
                        <div class="col2-set" id="customer_details">
                            <div class="col-1">
                                <?php do_action('woocommerce_checkout_billing'); ?>
                            </div>

                            <div class="col-2">
                                <?php do_action('woocommerce_checkout_shipping'); ?>
                            </div>
                        </div>
                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                <?php endif; ?>
            </form>

            <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
        </div>

        <!-- Checkout Right -->
        <div class="checkout-modern-right-wrap">
            <a href="javascript:void(0);" class="hidden-tag close-your-order-mobile nasa-stclose" rel="nofollow"></a>
            <?php
            /**
             * Custom action
             */
            do_action('nasa_checkout_before_order_review');
            ?>

            <div class="order-review order-review-modern">
                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                <h3 id="order_review_heading" class="order_review-heading">
                    <?php esc_html_e('Your order', 'elessi-theme'); ?>
                </h3>

                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>

            <?php
            /**
             * Custom action
             */
            do_action('nasa_checkout_after_order_review');
            ?>
        </div>
    </div>
</div>
