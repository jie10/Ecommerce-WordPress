<?php
$columns_large = isset($columns_number) ? $columns_number : 3;
$columns_small = isset($columns_number_small) ? $columns_number_small : 2;
$columns_medium = isset($columns_number_tablet) ? $columns_number_tablet : 2;
?>

<ul class="large-block-grid-<?php echo esc_attr($columns_large); ?> small-block-grid-<?php echo esc_attr($columns_small); ?> medium-block-grid-<?php echo esc_attr($columns_medium); ?>">
    <?php
    foreach ($product_categories as $category) :
        $href = get_term_link($category, 'product_cat');
        $childTerms = get_terms( 
            array(
                'taxonomy' => 'product_cat',
                'parent' => $category->term_id,
                'hide_empty' => $hide_empty
            )
        );
    ?>
        <li class="grid-product-category wow fadeInUp" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($delay_animation_product); ?>ms">
            <div class="nasa-item-wrap">
                <div class="nasa-cat-info left rtl-right">
                    <a class="nasa-block nasa-title nasa-transition" href="<?php echo esc_url($href); ?>" title="<?php echo esc_attr($category->name); ?>"><?php echo $category->name; ?></a>
                    
                    <?php if ($childTerms) : ?>
                        <div class="nasa-child-categories">
                            <?php
                            $k = 1;
                            foreach ($childTerms as $term) :
                                $hrefChild = get_term_link($term, 'product_cat');
                                ?>
                                <a class="nasa-block nasa-transition nasa-child-category-item" href="<?php echo esc_url($hrefChild); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo $term->name; ?></a>
                            <?php
                                if ($k == 3) :
                                    break;
                                endif;
                                $k++;
                            endforeach; ?>
                        </div>
                    <?php else: ?>
                        <?php echo apply_filters('woocommerce_subcategory_count_html', ' <span class="count nasa-block">' . $category->count . ' ' . esc_html__('items', 'nasa-core') . '</span>', $category); ?>
                    <?php endif; ?>
                    
                    <a class="nasa-block nasa-view-more nasa-transition" href="<?php echo esc_url($href); ?>" title="<?php echo esc_attr__('Shop All', 'nasa-core'); ?>">
                        <?php echo esc_html__('Shop All', 'nasa-core'); ?><i class="fa fa-arrow-circle-right nasa-only-ltr margin-left-10"></i><i class="fa fa-arrow-circle-left nasa-only-rtl margin-right-10"></i>
                    </a>
                </div>
                
                <div class="nasa-cat-thumb right rtl-left">
                    <a href="<?php echo esc_url($href); ?>" title="<?php echo esc_attr($category->name); ?>"><?php nasa_category_thumbnail($category, '380x380'); ?></a>
                </div>
            </div>
        </li>
    <?php
        $delay_animation_product += $_delay_item;
    endforeach;
    ?>
</ul>
