<?php
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
$_delay = 0;
?>
<div class="row">
    <?php /* Main products */?>
    <div class="large-4 columns margin-bottom-20 rtl-right">
        <div class="product_list_widget nasa_product_list_widget_main_list">
            <?php
            while ($main->have_posts()) : 
                $main->the_post();
            
                global $product;
                if (empty($product) || !$product->is_visible()) :
                    continue;
                endif;
                
                wc_get_template(
                    'content-widget-product.php', 
                    array(
                        'show_category'=> false,
                        'wapper' => 'div',
                        'delay' => $_delay,
                        '_delay_item' => $_delay_item,
                        'list_type' => 'list_main'
                    )
                );
                $_delay += $_delay_item;
            endwhile;
            ?>
        </div>
    </div>
    
    <?php /* Extra products */?>
    <?php if ($others->post_count) : ?>
        <div class="large-8 columns rtl-right">
            <div class="product_list_widget row">
                <?php
                while ($others->have_posts()) : 
                    $others->the_post();
                    
                    global $product;
                    if (empty($product) || !$product->is_visible()) :
                        continue;
                    endif;
                    
                    echo '<div class="large-6 medium-6 small-12 columns">';
                    wc_get_template(
                        'content-widget-product.php', 
                        array(
                            'show_category'=> false,
                            'wapper' => 'div',
                            'delay' => $_delay,
                            '_delay_item' => $_delay_item,
                            'list_type' => 'list_extra'
                        )
                    );
                    echo '</div>';
                    
                    $_delay += $_delay_item;
                endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php
wp_reset_postdata();
