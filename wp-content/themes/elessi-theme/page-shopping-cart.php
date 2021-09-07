<?php
/*
  Template name: Page Shopping cart
 */

get_header();
?>

<div class="container-wrap page-shopping-cart">
    <div class="order-steps">
        <div class="row">
            <div class="large-12 columns">
                <?php if (function_exists('is_wc_endpoint_url')) : ?>
                    <?php if (!is_wc_endpoint_url('order-received')) : ?>
                        <div class="checkout-breadcrumb rtl-text-right">
                            <div class="title-cart">
                                <h3 class="hide-for-small hide-for-medium ct-1st">01</h3>
                                <h4 class="ct-2nd"><?php esc_html_e('Shopping Cart', 'elessi-theme'); ?></h4>
                                <p class="hide-for-small ct-3th"><?php esc_html_e('Manage Your Items List', 'elessi-theme'); ?></p>
                            </div>

                            <div class="title-checkout">
                                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" title="<?php esc_attr_e('Checkout details', 'elessi-theme'); ?>">
                                    <h3 class="hide-for-small hide-for-medium ct-1st">02</h3>
                                    <h4 class="ct-2nd"><?php esc_html_e('Checkout Details', 'elessi-theme'); ?></h4>
                                    <p class="hide-for-small ct-3th"><?php esc_html_e('Checkout Your Items List', 'elessi-theme'); ?></p>
                                </a>
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
    <div class="row nasa-cart-content">
        <div class="columns large-12">
            <?php
            if (shortcode_exists('woocommerce_cart')):
                global $post;
                echo !isset($post->post_content) || !has_shortcode($post->post_content, 'woocommerce_cart') ? do_shortcode('[woocommerce_cart]') : '';
            endif;

            while (have_posts()) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
