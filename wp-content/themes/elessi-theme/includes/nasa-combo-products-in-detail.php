<?php
/**
 * Carousel slide for gift products
 */
$id_sc = rand(0, 9999999);
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
$file_content = ELESSI_CHILD_PATH . '/includes/nasa-content-product-gift.php';
$file_content = is_file($file_content) ? $file_content : ELESSI_THEME_PATH . '/includes/nasa-content-product-gift.php';

?>
<div class="row nasa-slider-wrap nasa-warp-slide-nav-side nasa-slider-wrap-combo">
    <div class="large-12 columns">
        <div
            class="nasa-slider-items-margin nasa-slick-slider nasa-slick-nav nasa-combo-slider"
            data-columns="4"
            data-columns-small="2"
            data-columns-tablet="3"
            data-switch-tablet="<?php echo elessi_switch_tablet(); ?>"
            data-switch-desktop="<?php echo elessi_switch_desktop(); ?>">
            <?php
            foreach ($combo as $bundle_item) :
                include $file_content;
                $_delay += $_delay_item;
            endforeach;
            ?>
        </div>
    </div>
</div>
