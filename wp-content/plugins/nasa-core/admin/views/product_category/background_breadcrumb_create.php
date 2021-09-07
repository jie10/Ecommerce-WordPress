<div class="form-field term-breadcrumb_type-wrap">
    <label><?php _e('Breadcrumb type', 'nasa-core'); ?></label>
    <div class="nasa_breadcrumb_type">
        <select name="<?php echo $this->_cat_bread_enable; ?>" id="<?php echo $this->_cat_bread_enable; ?>" class="postform">
            <option value=""><?php echo esc_html__('Default', 'nasa-core'); ?></option>
            <option value="1"><?php echo esc_html__('Has breadcrumb background', 'nasa-core'); ?></option>
        </select>
    </div>
    <div class="clear"></div>
</div>

<div class="form-field term-breadcrumb_bg-wrap with-breadcrumb_type">
    <label><?php _e('Background Breadcrumb', 'nasa-core'); ?></label>
    <div id="breadcrumb_bg_thumbnail" style="float: left; margin-right: 10px;">
        <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" height="60" />
    </div>

    <div style="line-height: 60px;">
        <input type="hidden" id="<?php echo $this->_cat_bread_bg; ?>" name="<?php echo $this->_cat_bread_bg; ?>" />
        <button type="button" class="upload_image_button_bread button"><?php _e('Upload/Add image', 'nasa-core'); ?></button>
        <button type="button" class="remove_image_button_bread button"><?php _e('Remove Image', 'nasa-core'); ?></button>
    </div>
    <div class="clear"></div>
</div>

<div class="form-field term-breadcrumb_bg-wrap with-breadcrumb_type">
    <label><?php _e('Background Breadcrumb - Mobile', 'nasa-core'); ?></label>
    <div id="breadcrumb_bg_thumbnail_m" style="float: left; margin-right: 10px;">
        <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" height="60" />
    </div>

    <div style="line-height: 60px;">
        <input type="hidden" id="<?php echo $this->_cat_bread_bg_m; ?>" name="<?php echo $this->_cat_bread_bg_m; ?>" />
        <button type="button" class="upload_image_button_bread_m button"><?php _e('Upload/Add image', 'nasa-core'); ?></button>
        <button type="button" class="remove_image_button_bread_m button"><?php _e('Remove Image', 'nasa-core'); ?></button>
    </div>
    <div class="clear"></div>
</div>

<div class="form-field term-breadcrumb_text_color-wrap with-breadcrumb_type">
    <label><?php _e('Text color breadcrumb', 'nasa-core'); ?></label>
    <div class="nasa_p_color">
        <input type="text" class="widefat nasa-color-field" id="<?php echo $this->_cat_bread_text; ?>" name="<?php echo $this->_cat_bread_text; ?>" value="" />
    </div>
    <div class="clear"></div>
</div>

<script>
    jQuery(document).ready(function ($){
        if ('' === $('#<?php echo $this->_cat_bread_enable; ?>').val()) {
            $('.with-breadcrumb_type').hide();
        }

        $('body').on('change', '#<?php echo $this->_cat_bread_enable; ?>', function() {
            if ('' === $(this).val()) {
                $('.with-breadcrumb_type').fadeOut(200);
            } else {
                $('.with-breadcrumb_type').fadeIn(200);
            }
        });

        // Only show the "Remove Image" button when needed
        if (!$('#<?php echo $this->_cat_bread_bg; ?>').val()) {
            $('.remove_image_button_bread').hide();
        }

        // Uploading files
        var file_frame_bread;

        $('body').on('click', '.upload_image_button_bread', function (event) {

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame_bread) {
                file_frame_bread.open();
                return;
            }

            // Create the media frame.
            file_frame_bread = wp.media.frames.downloadable_file = wp.media({
                title: '<?php _e("Choose an image", "nasa-core"); ?>',
                button: {
                    text: '<?php _e("Use image", "nasa-core"); ?>'
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame_bread.on('select', function () {
                var attachment = file_frame_bread.state().get('selection').first().toJSON();
                var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                $('#<?php echo $this->_cat_bread_bg; ?>').val(attachment.id);
                $('#breadcrumb_bg_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                $('.remove_image_button_bread').show();
            });

            // Finally, open the modal.
            file_frame_bread.open();
        });

        $('body').on('click', '.remove_image_button_bread', function () {
            $('#breadcrumb_bg_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
            $('#<?php echo $this->_cat_bread_bg; ?>').val('');
            $('.remove_image_button_bread').hide();
            return false;
        });
        
        // Only show the "Remove Image" button when needed
        if (!$('#<?php echo $this->_cat_bread_bg_m; ?>').val()) {
            $('.remove_image_button_bread_m').hide();
        }

        // Uploading files
        var file_frame_bread_m;

        $('body').on('click', '.upload_image_button_bread_m', function (event) {

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame_bread) {
                file_frame_bread.open();
                return;
            }

            // Create the media frame.
            file_frame_bread_m = wp.media.frames.downloadable_file = wp.media({
                title: '<?php _e("Choose an image", "nasa-core"); ?>',
                button: {
                    text: '<?php _e("Use image", "nasa-core"); ?>'
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame_bread_m.on('select', function () {
                var attachment = file_frame_bread_m.state().get('selection').first().toJSON();
                var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                $('#<?php echo $this->_cat_bread_bg_m; ?>').val(attachment.id);
                $('#breadcrumb_bg_thumbnail_m').find('img').attr('src', attachment_thumbnail.url);
                $('.remove_image_button_bread_m').show();
            });

            // Finally, open the modal.
            file_frame_bread_m.open();
        });

        $('body').on('click', '.remove_image_button_bread_m', function () {
            $('#breadcrumb_bg_thumbnail_m').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
            $('#<?php echo $this->_cat_bread_bg_m; ?>').val('');
            $('.remove_image_button_bread_m').hide();
            
            return false;
        });

        $(document).ajaxComplete(function (event, request, options) {
            if (request && 4 === request.readyState && 200 === request.status && options.data && 0 <= options.data.indexOf('action=add-tag')) {

                var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                if (!res || res.errors) {
                    return;
                }
                
                // Clear Thumbnail fields on submit
                $('#breadcrumb_bg_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                $('#breadcrumb_bg_thumbnail_m').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                $('#<?php echo $this->_cat_bread_bg; ?>').val('');
                $('#<?php echo $this->_cat_bread_bg_m; ?>').val('');
                $('.remove_image_button_bread').hide();
                $('.remove_image_button_bread_m').hide();
                // Clear Display type field on submit
                $('#display_type').val('');
                return;
            }
        });
    });
</script>