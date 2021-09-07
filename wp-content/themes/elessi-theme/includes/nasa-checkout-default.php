<?php
/**
 * Checkout Form: Layout - Default
 */
if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) :
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', esc_html__('You must be logged in to checkout.', 'elessi-theme'));
    return;
endif;
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
    <div class="row">
        <?php
        $class_order_review = 'large-12 columns';
        if ($checkout->get_checkout_fields()) :
            $class_order_review = 'large-5 columns';
            
            ?>
            <div class="large-7 columns">
                
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
                
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($class_order_review); ?>">
            
            <?php
            /**
             * Custom action
             */
            do_action('nasa_checkout_before_order_review');
            ?>
            
            <div class="order-review">
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
</form>

<?php
do_action('woocommerce_after_checkout_form', $checkout);
