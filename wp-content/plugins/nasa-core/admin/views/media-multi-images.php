<?php
defined('ABSPATH') or die();
$gallery_images = $inputval ? explode(',', trim($inputval, ',')) : [];
?>

<div class="form-row nasa-gallery-wrapper">
    <h4>
        <?php echo wp_kses_post($field['label']); ?>
    </h4>
    
    <div class="nasa-gallery-images-container">
        <input type="hidden"
            class="nasa-gallery-images-input"
            id="<?php echo esc_attr($field['id']); ?>" 
            name="<?php echo esc_attr($field['name']); ?>" 
            value="<?php echo $gallery_images ? esc_attr(implode(',', $gallery_images)) : ''; ?>" />
        
        <ul class="nasa-gallery-images-list">
            <?php
            if (is_array($gallery_images) && !empty($gallery_images)) :
                foreach ($gallery_images as $image_id):
                    $image = wp_get_attachment_image_src($image_id); ?>
                    <li class="image" data-attachment_id="<?php echo $image_id; ?>">
                        <?php if (isset($image[0])) : ?>
                            <img src="<?php echo esc_url($image[0]) ?>" />
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
    
    <p class="nasa-add-gallery-wrapper hide-if-no-js">
        <a
            href="javascript:void(0);" 
            class="button nasa-add-gallery" 
            data-choose="<?php echo esc_attr__('Add Gallery', 'nasa-core'); ?>" 
            data-update="<?php echo esc_attr__('Add to gallery', 'nasa-core'); ?>" 
            data-delete="<?php echo esc_attr__('Delete image', 'nasa-core'); ?>" 
            data-text="<?php echo esc_attr__('Delete', 'nasa-core'); ?>">
            <?php esc_html_e('Add Gallery Images', 'nasa-core'); ?>
        </a>
    </p>
</div>
