<?php
// Exit if accessed directly
if (!defined('ABSPATH')) :
    exit;
endif;

if (!$product->is_purchasable()) :
    return;
endif;

$bundled_items = $product->get_bundled_items();
if ($bundled_items) : ?>
    <hr class="nasa-single-hr">
    <h3 class="nasa-gift-label"><?php echo esc_html__('Bundle product for ', 'elessi-theme'); ?><span class="nasa-gift-count">(<?php echo count($bundled_items) . ' ' . esc_html__('items', 'elessi-theme'); ?>)</span></h3>
    <div
        id="nasa-slider-gifts-product-quickview"
        class="nasa-slider-items-margin nasa-slick-slider"
        data-columns="3"
        data-columns-small="2"
        data-columns-tablet="3"
        data-switch-tablet="<?php echo elessi_switch_tablet(); ?>"
        data-switch-desktop="<?php echo elessi_switch_desktop(); ?>">
        
        <?php foreach ($bundled_items as $bundled_item) :
            $bundled_product = $bundled_item->get_product();
            $bundled_post = get_post(yit_get_base_product_id($bundled_product));
            $quantity = $bundled_item->get_quantity();
            ?>
            <div class="nasa-gift-product-quickview-item nasa-slider-item">
                <a href="<?php echo esc_url($bundled_product->get_permalink()); ?>" title="<?php echo esc_attr($bundled_product->get_title()); ?>">
                    <div class="nasa-bundled-item-image"><?php echo ($bundled_product->get_image()); ?></div>
                    <h5><?php echo ($quantity . ' x ' . $bundled_product->get_title()); ?></h5>
                </a>
                
                <?php
                if ($bundled_product->has_enough_stock($quantity) && $bundled_product->is_in_stock()) :
                    echo '<div class="nasa-label-stock nasa-item-instock">' . esc_html__('In stock', 'elessi-theme') . '</div>';
                else :
                    echo '<div class="nasa-label-stock nasa-item-outofstock">' . esc_html__('Out of stock', 'elessi-theme') . '</div>';
                endif;
                ?>
            </div>
        <?php endforeach; ?>
        
    </div>
<?php endif;