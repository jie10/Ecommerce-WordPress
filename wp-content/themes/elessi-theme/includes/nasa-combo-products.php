<?php
/**
 * Carousel slide for gift products
 */
$id_sc = rand(0, 9999999);
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;

?>
<div class="nasa-slider-wrap nasa-warp-slide-nav-side nasa-slider-wrap-combo">
    <div class="large-2 medium-3 columns">
        <div class="nasa-slide-left-info-wrap">
            <h4 class="nasa-combo-gift"><?php echo esc_html__('Bundle product for', 'elessi-theme'); ?></h4>
            <h3><?php echo ($product->get_name()); ?><span class="nasa-count-items">(<?php echo count($combo) . ' ' . esc_html__('Items', 'elessi-theme'); ?>)</span></h3>
            <div class="nasa-nav-carousel-wrap nasa-clear-both">
                <a class="nasa-nav-icon-slider icon-nasa-left-arrow" href="javascript:void(0);" data-do="prev" rel="nofollow"></a>
                <a class="nasa-nav-icon-slider icon-nasa-right-arrow" href="javascript:void(0);" data-do="next" rel="nofollow"></a>
            </div>

            <?php if (!isset($nasa_viewmore) || $nasa_viewmore == true) : ?>
                <a class="nasa-view-more-slider" href="<?php echo esc_url($product->get_permalink()); ?>" title="<?php echo esc_attr__('View more', 'elessi-theme'); ?>"><?php echo esc_html__('View more', 'elessi-theme'); ?></a>
            <?php endif; ?>
        </div>
    </div>

    <div class="large-10 medium-9 columns">
        <div
            id="nasa-slider-<?php echo esc_attr($id_sc); ?>"
            class="nasa-slider-items-margin nasa-slick-slider nasa-combo-slider"
            data-columns="4"
            data-columns-small="2"
            data-columns-tablet="3" 
            data-switch-tablet="<?php echo elessi_switch_tablet(); ?>"
            data-switch-desktop="<?php echo elessi_switch_desktop(); ?>">
            <?php
            $file_content = ELESSI_CHILD_PATH . '/includes/nasa-content-product-gift.php';
            $file_content = is_file($file_content) ? $file_content : ELESSI_THEME_PATH . '/includes/nasa-content-product-gift.php';
            foreach ($combo as $bundle_item) :
                include $file_content;
                $_delay += $_delay_item;
            endforeach;
            ?>
        </div>
    </div>
</div>
