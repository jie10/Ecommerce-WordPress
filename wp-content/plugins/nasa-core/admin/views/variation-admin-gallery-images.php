<?php
defined('ABSPATH') or die();

$variation_id = absint($variation->ID);
$gallerys = get_post_meta($variation_id, 'nasa_variation_gallery_images', true);
$gallery_images = $gallerys && is_string($gallerys) ? explode(',', $gallerys) : $gallerys;
?>

<div class="form-row form-row-full nasa-variation-gallery-wrapper">
    <h4>
        <?php esc_html_e('Variation Image Gallery', 'nasa-core') ?>
    </h4>
    
    <div class="nasa-variation-gallery-image-container">
        <input type="hidden"
            id="nasa_variation_gallery_images-<?php echo absint($variation->ID); ?>" 
            name="nasa_variation_gallery_images[<?php echo $variation_id ?>]" 
            value="<?php echo $gallery_images ? esc_attr(implode(',', $gallery_images)) : ''; ?>" />
        
        <ul class="nasa-variation-gallery-images" id="nasa-variation_gallery-<?php echo absint($variation->ID); ?>" data-variation_id="<?php echo absint($variation->ID); ?>">
            <?php
                if (is_array($gallery_images) && !empty($gallery_images)) :
                    foreach ($gallery_images as $image_id) :
                        $image = wp_get_attachment_image_src($image_id); ?>
                        <li class="image" data-attachment_id="<?php echo absint($image_id); ?>">
                            <?php if (isset($image[0])) : ?>
                                <img src="<?php echo esc_url($image[0]); ?>" />
                            <?php endif; ?>
                            <ul class="actions">
                                <li>
                                    <a href="javascript:void(0);" class="delete">
                                        <?php echo esc_html__('Delete', 'nasa-core'); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php

                    endforeach;
                endif;
            ?>
        </ul>
    </div>
    <p class="nasa-add-variation-gallery-image-wrapper hide-if-no-js">
        <a
            href="javascript:void(0);" 
            data-product_variation_id="<?php echo absint($variation->ID); ?>"
            class="button nasa-add-variation-gallery-image" 
            data-choose="<?php echo esc_attr__('Add images to variation gallery', 'nasa-core'); ?>" 
            data-update="<?php echo esc_attr__('Add to gallery', 'nasa-core'); ?>" 
            data-delete="<?php echo esc_attr__('Delete image', 'nasa-core'); ?>" 
            data-text="<?php echo esc_attr__('Delete', 'nasa-core'); ?>">
            <?php esc_html_e('Add Gallery Images', 'nasa-core'); ?>
        </a>
    </p>
</div>
