<?php
global $nasa_opt, $product;

$attachment_ids = $product->get_gallery_image_ids();
$style_quickview = isset($style_quickview) ? $style_quickview : 'sidebar';

$class = $style_quickview == 'sidebar' ? 'large-12 columns padding-left-0 padding-right-0' : 'large-6 columns padding-left-0 padding-right-0 rtl-right';

$column_thumbs = isset($nasa_opt['quick_view_item_thumb']) ? (int) $nasa_opt['quick_view_item_thumb'] : 1;
$show_images = ($style_quickview == 'sidebar' && $attachment_ids && count($attachment_ids)) ?
    apply_filters('nasa_quickview_number_imgs', $column_thumbs) : 1;

$hasThumb = has_post_thumbnail();
$thumbNailId = get_post_thumbnail_id();
$image_link = wp_get_attachment_url($thumbNailId);
$image_large = wp_get_attachment_image_src($thumbNailId, 'shop_single');
$src_large = isset($image_large[0]) ? $image_large[0] : $image_link;

$attrs_main_img = apply_filters('nasa_attrs_main_img_qv', array('class' => 'nasa-first attachment-shop_single size-shop_single'));
$imageMain = $product->get_image(apply_filters('single_product_large_thumbnail_size', 'shop_single'), $attrs_main_img);

$link = $product->get_permalink();
$title = $product->get_name();
?>
<div class="row">
    <?php do_action('woocommerce_single_product_lightbox_before'); ?>
    
    <div class="<?php echo esc_attr($class); ?> product-quickview-img">
        <div class="product-img nasa-product-gallery-lightbox" data-o_href="<?php echo $src_large; ?>">
            <?php
            $file = ELESSI_CHILD_PATH . '/includes/nasa-single-product-lightbox-gallery.php';
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-single-product-lightbox-gallery.php';
            ?>
        </div>
        
        <a class="nasa-quickview-view-detail" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
            <?php echo esc_html__('VIEW DETAIL', 'elessi-theme'); ?>
        </a>
    </div>
    
    <div class="<?php echo esc_attr($class); ?> product-quickview-info">
        <div class="product-lightbox-inner product-info summary entry-summary">
            <h1 class="entry-title">
                <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                    <?php echo $title; ?>
                </a>
            </h1>
            
            <?php do_action('woocommerce_single_product_lightbox_summary'); ?>
        </div>
    </div>
    
    <?php do_action('woocommerce_single_product_lightbox_after'); ?>
</div>
