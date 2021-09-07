<?php
$image_link = $main_id ? wp_get_attachment_url($main_id) : wc_placeholder_img_src();
$image_thumb = wp_get_attachment_image_src($main_id, 'thumbnail');

$src_thumb = $image_link;
$dimention = '';
if (isset($image_thumb[0])) {
    $src_thumb = $image_thumb[0];
    $dimention .= 'width="' . $image_thumb[1] . '" height="' . $image_thumb[2] . '" ';
}
?>

<div class="product-thumbnails images-popups-gallery nasa-single-product-thumbnails nasa-thumbnail-default">
    <?php
    echo sprintf(
        '<div class="nasa-wrap-item-thumb nasa-active" data-main="#nasa-main-image-0" data-key="0" data-thumb_org="%s"><a href="javascript:void(0);" data-current_img="%s" class="active-thumbnail" rel="nofollow"><img src="%s" %s/></a></div>',
        $src_thumb,
        $image_link,
        $src_thumb,
        $dimention
    );

    if (!empty($attachment_count)) :
        $loop = 0;

        foreach ($gallery_id as $attachment_id) :
            $key = $loop + 1;
            $classes = array('zoom');

            if ($loop == 0) :
                $classes[] = 'first';
            endif;

            if (!$image_link = wp_get_attachment_url($attachment_id)) :
                continue;
            endif;
            
            $image_class = esc_attr(implode(' ', $classes));
            $image = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'thumbnail'));

            echo '<div class="nasa-wrap-item-thumb" data-main="#nasa-main-image-' . (int) $key . '" data-key="' . (int) $key . '">';
            echo apply_filters(
                'woocommerce_single_product_image_thumbnail_html',
                sprintf('%s', $image),
                $attachment_id,
                $productId,
                $image_class
            );
            
            echo '</div>';

            $loop++;
        endforeach;
        
    endif;
    ?>
</div>
