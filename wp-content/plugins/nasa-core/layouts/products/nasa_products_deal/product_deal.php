<?php if (isset($title) && $title != '') : ?>
    <div class="nasa-dft nasa-title clearfix hr-type-none text-center">
        <h3 class="nasa-heading-title"><?php echo esc_attr($title); ?></h3>
    </div>
<?php endif; ?>

<div class="price price-wrap nasa-block">
    <?php echo $product->get_price_html();?>
</div>

<a class="name inline-block" href="<?php echo esc_url($product_link); ?>" title="<?php echo esc_attr($product_name); ?>">
    <?php echo $product_name;?>
</a>

<?php if ($product->time_sale) : ?>
    <div class="product-deal-countdown nasa-single-deal-countdown">
        <?php echo nasa_time_sale($product->time_sale); ?>
    </div>
<?php endif;?>

<?php if ($stock_available) : ?>
    <div class="product-deal-special-progress">
        <div class="deal-stock-label">
            <span class="stock-available text-left"><?php echo esc_html__('Available:', 'nasa-core');?> <strong><?php echo esc_html($stock_available); ?></strong></span>
            <span class="stock-sold text-right"><?php echo esc_html__('Already Sold:', 'nasa-core');?> <strong><?php echo esc_html($stock_sold); ?></strong></span>
        </div>
        <div class="deal-progress">
            <span class="deal-progress-bar" style="<?php echo esc_attr('width:' . $percentage . '%'); ?>"><?php echo $percentage; ?></span>
        </div>
    </div>
<?php endif; ?>

<?php
if ($btn_url != '') : ?>
    <a class="nasa-product-deal-btn button inline-block nasa-clearfix" href="<?php echo esc_url($btn_url); ?>" title="<?php echo esc_attr($btn_text); ?>">
        <?php echo $btn_text; ?>
    </a>
<?php
endif;

