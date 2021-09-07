<?php
global $product;
$products = $nasa_compare->get_products_list();
$fields = $nasa_compare->fields();
?>
<div class="nasa-wrap-table-compare">
    <?php
    if ($products) :
        $add_to_cart = array(); ?>
        <table class="nasa-table-compare">
            <?php 
            foreach ($fields as $field => $name) :
                if ($field == 'title') :
                    continue;
                endif;
                ?>
                <tr class="<?php echo esc_attr($field); ?>">
                    <th>
                        <?php echo ($field == 'image') ? esc_html__('Product', 'elessi-theme') : $name; ?>
                        <?php echo ($field == 'image') ? '<div class="fixed-th"></div>' : ''; ?>
                    </th>

                    <?php
                    $index = 0;
                    foreach ($products as $product_id => $product) :
                        $product_class = ($index % 2 == 0 ? 'odd' : 'even') . ' nasa-compare-view-product_' . $product_id;
                        ?>
                        <td class="<?php echo esc_attr($product_class); ?>">
                            <?php
                            switch ($field) :
                                case 'image':
                                    $nasa_title = isset($product->fields['title']) ? $product->fields['title'] : '';
                                    $href = get_permalink($product_id);
                                    echo '<a href="' . esc_url($href) . '" title="' . esc_attr($product->fields['title']) . '">';

                                    echo '<div class="image-wrap">' . $product->get_image('thumbnail', array('alt' => esc_attr($nasa_title))) . '</div>';
                                    echo ($nasa_title != '') ? '<h5 class="compare-product-title">' . $nasa_title . '</h5>' : '';
                                    echo '</a>';
                                    
                                    break;

                                case 'title':

                                    break;

                                case 'add-to-cart':
                                    $add_to_cart[$product_id] = elessi_product_group_button('popup');
                                    echo $add_to_cart[$product_id] ? '<div class="nasa-group-btns">' . $add_to_cart[$product_id] . '</div>' : '';
                                    
                                    break;

                                default:
                                    echo empty($product->fields[$field]) ? '&nbsp;' : $product->fields[$field];
                                    break;
                            endswitch;
                            ?>
                        </td>
                        <?php
                        ++$index;
                    endforeach;
                    ?>

                </tr>

            <?php endforeach; ?>

            <?php if (get_option('yith_woocompare_price_end') == 'yes' && isset($fields['price'])) : ?>
                <tr class="price repeated">
                    <th><?php echo ($fields['price']); ?></th>

                    <?php
                    $index = 0;
                    foreach ($products as $product_id => $product) :
                        $product_class = ($index % 2 == 0 ? 'odd' : 'even') . ' nasa-compare-view-product_' . $product_id
                        ?>
                        <td class="<?php echo esc_attr($product_class); ?>">
                            <?php echo ($product->fields['price']); ?>
                        </td>
                        <?php
                        ++$index;
                    endforeach;
                    ?>

                </tr>
            <?php endif; ?>

            <?php if (get_option('yith_woocompare_add_to_cart_end') == 'yes' && isset($fields['add-to-cart'])) : ?>
                <tr class="add-to-cart repeated">
                    <th><?php echo ($fields['add-to-cart']); ?></th>
                    <?php
                    $index = 0;
                    foreach ($products as $product_id => $product) :
                        $product_class = ($index % 2 == 0 ? 'odd' : 'even') . ' nasa-compare-view-product_' . $product_id
                        ?>
                        <td class="<?php echo ($product_class); ?> nasa-group-btns">
                            <?php
                            if (isset($add_to_cart[$product_id])) :
                                echo '<div class="nasa-group-btns">' . $add_to_cart[$product_id] . '</div>';
                            else:
                                woocommerce_template_loop_add_to_cart();
                            endif;
                            ?>
                        </td>
                        <?php
                        ++$index;
                    endforeach;
                    ?>
                </tr>
            <?php endif; ?>
            <tr class="remove-item">
                <th>&nbsp;</th>

                <?php
                $index = 0;
                foreach ($products as $product_id => $product) :
                    $product_class = ($index % 2 == 0 ? 'odd' : 'even') . ' nasa-compare-view-product_' . $product_id
                    ?>
                    <td class="<?php echo esc_attr($product_class); ?>">
                        <a href="javascript:void(0);" class="nasa-remove-compare" data-prod="<?php echo esc_attr($product_id); ?>" rel="nofollow"><?php echo esc_html__('Remove', 'elessi-theme'); ?></a>
                    </td>
                    <?php
                    ++$index;
                endforeach;
                ?>
            </tr>
        </table>
    <?php
    else:
        echo '<p class="text-center padding-top-30"><i class="nasa-empty-icon icon-nasa-refresh"></i></p>';
        echo '<h5 class="text-center margin-bottom-30 empty woocommerce-compare__empty-message">' . esc_html__('No product added to compare !', 'elessi-theme') . '</h5>';
        echo '<p class="text-center"><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" class="button nasa-sidebar-return-shop" title="' . esc_attr__('RETURN TO SHOP', 'elessi-theme') . '">' . esc_html__('RETURN TO SHOP', 'elessi-theme') . '</a></p>';
    endif;
    ?>
</div>