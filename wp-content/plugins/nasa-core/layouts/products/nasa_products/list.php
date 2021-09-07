<?php
$class_ul = 'large-block-grid-' . ((int) $columns_number) . ' medium-block-grid-' . ((int) $columns_number_tablet) . ' small-block-grid-' . ((int) $columns_number_small);
?>
<div class="product_list_widget">
    <ul class="<?php echo esc_attr($class_ul); ?>">
        <?php
        $_delay = 0;
        $_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;

        while ($loop->have_posts()) : 
            $loop->the_post();
            
            global $product;
            if (empty($product) || !$product->is_visible()) :
                continue;
            endif;
                    
            wc_get_template(
                'content-widget-product.php', 
                array(
                    'wapper' => 'li',
                    'delay' => $_delay,
                    '_delay_item' => $_delay_item
                )
            );
            
            $_delay += $_delay_item;
        endwhile;
        wp_reset_postdata();
        ?>
    </ul>
</div>
