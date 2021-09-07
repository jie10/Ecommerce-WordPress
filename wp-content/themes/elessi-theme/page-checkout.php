<?php
/*
  Template name: Page Checkout
 */
defined('NASA_CHECKOUT_LAYOUT') or define('NASA_CHECKOUT_LAYOUT', 'default');
$order_revice = is_wc_endpoint_url('order-received');

/* Modern Checkout */
if (!$order_revice && NASA_CHECKOUT_LAYOUT == 'modern') :
    get_header('modern');

    do_action('nasa_before_checkout_modern');
    ?>
    <div class="page-checkout-modern">
        <?php
        if (shortcode_exists('woocommerce_checkout')):
            global $post;
            echo !isset($post->post_content) || !has_shortcode($post->post_content, 'woocommerce_checkout') ? do_shortcode('[woocommerce_checkout]') : '';
        endif;

        while (have_posts()) :
            the_post();
            the_content();
        endwhile;

        wp_reset_postdata();
        ?>
    </div>
    <?php
    do_action('nasa_after_checkout_modern');
    
    get_footer('modern');
    
else :
    /* Default Checkout || Order revice */
    get_header();
    ?>

    <div class="container-wrap page-checkout">
        <?php if (NASA_CHECKOUT_LAYOUT != 'modern') : ?>
            <div class="order-steps">
                <div class="row">
                    <div class="large-12 columns">
                        <?php if (function_exists('is_wc_endpoint_url')) : ?>
                            <?php if (!$order_revice) : ?>
                                <div class="checkout-breadcrumb rtl-text-right">
                                    <div class="title-cart">
                                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('Shopping Cart', 'elessi-theme'); ?>">
                                            <h3 class="hide-for-small hide-for-medium ct-1st">01</h3>
                                            <h4 class="ct-2nd"><?php esc_html_e('Shopping Cart', 'elessi-theme'); ?></h4>
                                            <p class="hide-for-small ct-3th"><?php esc_html_e('Manage Your Items List', 'elessi-theme'); ?></p>
                                        </a>
                                    </div>

                                    <div class="title-checkout">
                                        <h3 class="hide-for-small hide-for-medium ct-1st">02</h3>
                                        <h4 class="ct-2nd"><?php esc_html_e('Checkout Details', 'elessi-theme'); ?></h4>
                                        <p class="hide-for-small ct-3th"><?php esc_html_e('Checkout Your Items List', 'elessi-theme'); ?></p>
                                    </div>

                                    <div class="title-thankyou">
                                        <h3 class="hide-for-small hide-for-medium ct-1st">03</h3>
                                        <h4 class="ct-2nd"><?php esc_html_e('Order Complete', 'elessi-theme'); ?></h4>
                                        <p class="hide-for-small ct-3th"><?php esc_html_e('Review Your Order', 'elessi-theme'); ?></p>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="checkout-breadcrumb rtl-text-right">
                                    <div class="title-cart">
                                        <h3 class="hide-for-small hide-for-medium ct-1st">01</h3>
                                        <h4 class="ct-2nd"><?php esc_html_e('Shopping Cart', 'elessi-theme'); ?></h4>
                                        <p class="hide-for-small ct-3th"><?php esc_html_e('Manage Your Items List', 'elessi-theme'); ?></p>
                                    </div>
                                    <div class="title-checkout">
                                        <h3 class="hide-for-small hide-for-medium ct-1st">02</h3>
                                        <h4 class="ct-2nd"><?php esc_html_e('Checkout Details', 'elessi-theme'); ?></h4>
                                        <p class="hide-for-small ct-3th"><?php esc_html_e('Checkout Your Items List', 'elessi-theme'); ?></p>
                                    </div>
                                    <div class="title-thankyou nasa-complete">
                                        <h3 class="hide-for-small hide-for-medium ct-1st">03</h3>
                                        <h4 class="ct-2nd"><?php esc_html_e('Order Complete', 'elessi-theme'); ?></h4>
                                        <p class="hide-for-small ct-3th"><?php esc_html_e('Review Your Order', 'elessi-theme'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?> 
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div id="content" class="large-12 columns">
                <?php
                if (shortcode_exists('woocommerce_checkout')):
                    global $post;
                    echo !isset($post->post_content) || !has_shortcode($post->post_content, 'woocommerce_checkout') ? do_shortcode('[woocommerce_checkout]') : '';
                endif;

                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;

                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>

    <?php
    get_footer();
endif;
