<?php
$class_slide = 'nasa-slider-items-margin nasa-slick-slider nasa-slick-nav nasa-slick-nav-outside nasa-category-horizontal-3';

/**
 * Attributes sliders
 */
$data_attrs = array();
$data_attrs[] = 'data-columns="' . esc_attr($columns_number) . '"';
$data_attrs[] = 'data-columns-small="' . esc_attr($columns_number_small) . '"';
$data_attrs[] = 'data-columns-tablet="' . esc_attr($columns_number_tablet) . '"';
$data_attrs[] = 'data-autoplay="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-slides-all="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-switch-tablet="' . nasa_switch_tablet() . '"';
$data_attrs[] = 'data-switch-desktop="' . nasa_switch_desktop() . '"';

$attrs_str = !empty($data_attrs) ? ' ' . implode(' ', $data_attrs) : '';
?>

<div class="category-slider nasa-category-slider-horizontal<?php echo $el_class; ?>">
    <div class="<?php echo esc_attr($class_slide); ?>"<?php echo $attrs_str; ?>>
        <?php
        foreach ($product_categories as $category) : ?>
            <div class="product-category nasa-slider-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($delay_animation_product); ?>ms">
                <a class="nasa-cat-link nasa-transition" href="<?php echo get_term_link($category, 'product_cat'); ?>" title="<?php echo esc_attr($category->name); ?>">
                    <div class="nasa-cat-thumb">
                        <?php nasa_category_thumbnail($category, '380x380'); ?>
                    </div>
                    <h3 class="header-title"><?php echo $category->name; ?></h3>
                    <?php do_action('woocommerce_after_subcategory_title', $category); ?>
                </a>
            </div>
        <?php
            $delay_animation_product += $_delay_item;
        endforeach; ?>
    </div> 
</div>