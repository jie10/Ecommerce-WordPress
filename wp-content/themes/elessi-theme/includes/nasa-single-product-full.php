<?php
if (!isset($nasa_opt)) {
    global $nasa_opt;
}

$dots = isset($nasa_opt['product_slide_dot']) && $nasa_opt['product_slide_dot'] ? 'true' : 'false';
$num_main = apply_filters('nasa_number_main_single_product_gallery_full', 3);
?>

<div id="product-<?php echo (int) $product->get_id(); ?>" <?php post_class(); ?>>
    <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
        <div class="nasa-toggle-layout-side-sidebar nasa-sidebar-single-product <?php echo esc_attr($nasa_sidebar); ?>">
            <div class="li-toggle-sidebar">
                <a class="toggle-sidebar-shop" href="javascript:void(0);" rel="nofollow">
                    <i class="nasa-icon pe7-icon pe-7s-menu"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="nasa-product-details-page nasa-layout-full padding-top-10">
        <div class="<?php echo esc_attr($main_class); ?> padding-left-0 padding-right-0" data-num_main="<?php echo (int) $num_main; ?>" data-num_thumb="0" data-speed="300" data-dots="<?php echo $dots; ?>">
            <div class="nasa-row row-fullwidth">
                <div class="large-12 columns product-gallery nasa-gallery-full">
                    <?php do_action('woocommerce_before_single_product_summary'); ?>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns summary entry-summary product-info text-center">
                    <div class="nasa-product-info-wrap">
                        <?php do_action('woocommerce_single_product_summary'); ?>
                    </div>
                </div>
            </div>
            
            <?php do_action('woocommerce_after_single_product_summary'); ?>
        </div>

        <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
            <div class="<?php echo esc_attr($bar_class); ?>">     
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'elessi-theme'); ?>" class="hidden-tag nasa-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'elessi-theme'); ?>
                </a>
                
                <div class="nasa-sidebar-off-canvas">
                    <?php dynamic_sidebar('product-sidebar'); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
    
    <div class="nasa-clear-both"></div>
</div>
