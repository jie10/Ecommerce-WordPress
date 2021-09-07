<?php
$image_link = $main_id ? wp_get_attachment_url($main_id) : wc_placeholder_img_src();
$image_large = wp_get_attachment_image_src($main_id, 'shop_single');
$src_large = $image_link;
$dimention = ' class="attachment-shop_single size-shop_single"';
if (isset($image_large[0])) {
    $src_large = $image_large[0];
    $dimention .= 'width="' . $image_large[1] . '" height="' . $image_large[2] . '" ';
}
?>
<div class="main-images nasa-single-product-main-image nasa-main-image-default">
    <div class="item-wrap first">
        <div class="nasa-item-main-image-wrap" id="nasa-main-image-0" data-key="0">
            <div class="easyzoom first">
                <?php echo apply_filters(
                    'woocommerce_single_product_image_html',
                    sprintf(
                        '<a href="%s" class="woocommerce-main-image product-image"><img src="%s" %s/></a>',
                        $image_link,
                        $src_large,
                        $dimention
                    ),
                    $productId
                ); ?>
            </div>
        </div>
    </div>
    <?php
    $_i = 0;
    if ($attachment_count > 0) :
        foreach ($gallery_id as $id) :
            $_i++;
            ?>
            <div class="item-wrap">
                <div class="nasa-item-main-image-wrap" id="nasa-main-image-<?php echo (int) $_i; ?>" data-key="<?php echo (int) $_i; ?>">
                    <div class="easyzoom">
                        <?php
                        $image_link = wp_get_attachment_url($id);
                        $image = wp_get_attachment_image_src($id, 'shop_single');
                        $src_large = $image_link;
                        $dimention = '';
                        if (isset($image[0])) {
                            $src_large = $image[0];
                            $dimention .= 'width="' . $image[1] . '" height="' . $image[2] . '" ';
                        }
                        
                        echo sprintf(
                            '<a href="%s" class="woocommerce-additional-image product-image"><img src="%s" %s/></a>',
                            $image_link,
                            $src_large,
                            $dimention
                        );
                        ?>
                    </div>
                </div>
            </div>
            <?php
        endforeach;
    endif;
    ?>
</div>