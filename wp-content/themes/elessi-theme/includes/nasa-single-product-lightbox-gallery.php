<div
    class="main-image-slider nasa-slick-slider nasa-slick-nav"
    data-columns="<?php echo esc_attr($show_images); ?>"
    data-columns-small="<?php echo esc_attr($show_images); ?>"
    data-columns-tablet="<?php echo esc_attr($show_images); ?>"
    data-items="<?php echo esc_attr($show_images); ?>"
    data-autoplay="false"
    data-delay="6000"
    data-height-auto="false"
    data-dot="false">
    <?php
    /**
     * Main image
     */
    echo $hasThumb ? $imageMain : '<img class="nasa-first" src="' . wc_placeholder_img_src() . '" />';
    
    if (count($attachment_ids)) :
        foreach ($attachment_ids as $attachment_id) :
            $image_link = wp_get_attachment_url($attachment_id);

            if (!$image_link) :
                continue;
            endif;

            $image = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'));
            
            printf('%s', wp_get_attachment_image($attachment_id, apply_filters('single_product_large_thumbnail_size', 'shop_single')), wp_get_attachment_url($attachment_id));
        endforeach;
    endif;
    ?>
</div>
