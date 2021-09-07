<div class="form-field nasa-term-root hidden-tag">
    <label for="<?php echo $this->_cat_logo_flag; ?>">
        <?php _e('Override Logo Mode', 'nasa-core'); ?>
    </label>
    <div class="nasa_override_logo_mode">
        <select name="<?php echo $this->_cat_logo_flag; ?>" id="<?php echo $this->_cat_logo_flag; ?>" class="postform">
            <option value=""><?php _e('Default', 'nasa-core'); ?></option>
            <option value="on"><?php _e('Yes, Please!', 'nasa-core'); ?></option>
        </select>
    </div>
</div>

<div class="form-field nasa-term-root-child <?php echo $this->_cat_logo_flag . ' nasa-term-' . $this->_cat_logo_flag . '-on'; ?> hidden-tag">
    <label><?php _e('Override Logo', 'nasa-core'); ?></label>
    <div id="nasa-logo_thumbnail" style="float: left; margin-right: 10px;">
        <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" height="60" />
    </div>

    <div style="line-height: 60px;">
        <input type="hidden" id="<?php echo $this->_cat_logo; ?>" name="<?php echo $this->_cat_logo; ?>" />
        <button type="button" class="upload_image_button_logo button"><?php _e('Upload/Add image', 'nasa-core'); ?></button>
        <button type="button" class="remove_image_button_logo button"><?php _e('Remove Image', 'nasa-core'); ?></button>
    </div>
    <div class="clear"></div>
</div>

<div class="form-field nasa-term-root-child <?php echo $this->_cat_logo_flag . ' nasa-term-' . $this->_cat_logo_flag . '-on'; ?> hidden-tag">
    <label><?php _e('Override Logo Retina', 'nasa-core'); ?></label>
    <div id="nasa-logo-retina_thumbnail" style="float: left; margin-right: 10px;">
        <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" height="60" />
    </div>

    <div style="line-height: 60px;">
        <input type="hidden" id="<?php echo $this->_cat_logo_retina; ?>" name="<?php echo $this->_cat_logo_retina; ?>" />
        <button type="button" class="upload_image_button_logo_retina button"><?php _e('Upload/Add image', 'nasa-core'); ?></button>
        <button type="button" class="remove_image_button_logo_retina button"><?php _e('Remove Image', 'nasa-core'); ?></button>
    </div>
    <div class="clear"></div>
</div>

<div class="form-field nasa-term-root-child <?php echo $this->_cat_logo_flag . ' nasa-term-' . $this->_cat_logo_flag . '-on'; ?> hidden-tag">
    <label><?php _e('Override Logo Sticky', 'nasa-core'); ?></label>
    <div id="nasa-logo-sticky_thumbnail" style="float: left; margin-right: 10px;">
        <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" height="60" />
    </div>

    <div style="line-height: 60px;">
        <input type="hidden" id="<?php echo $this->_cat_logo_sticky; ?>" name="<?php echo $this->_cat_logo_sticky; ?>" />
        <button type="button" class="upload_image_button_logo_sticky button"><?php _e('Upload/Add image', 'nasa-core'); ?></button>
        <button type="button" class="remove_image_button_logo_sticky button"><?php _e('Remove Image', 'nasa-core'); ?></button>
    </div>
    <div class="clear"></div>
</div>

<div class="form-field nasa-term-root-child <?php echo $this->_cat_logo_flag . ' nasa-term-' . $this->_cat_logo_flag . '-on'; ?> hidden-tag">
    <label><?php _e('Override Logo Mobile', 'nasa-core'); ?></label>
    <div id="nasa-logo-m_thumbnail" style="float: left; margin-right: 10px;">
        <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" height="60" />
    </div>

    <div style="line-height: 60px;">
        <input type="hidden" id="<?php echo $this->_cat_logo_m; ?>" name="<?php echo $this->_cat_logo_m; ?>" />
        <button type="button" class="upload_image_button_logo_m button"><?php _e('Upload/Add image', 'nasa-core'); ?></button>
        <button type="button" class="remove_image_button_logo_m button"><?php _e('Remove Image', 'nasa-core'); ?></button>
    </div>
    <div class="clear"></div>
</div>

<script>
    jQuery(document).ready(function ($){
        // Only show the "Remove Image" button when needed
        if (!$('#<?php echo $this->_cat_logo; ?>').val() || $('#<?php echo $this->_cat_logo; ?>').val() === '0') {
            $('.remove_image_button_logo').hide();
        }

        if (!$('#<?php echo $this->_cat_logo_retina; ?>').val() || $('#<?php echo $this->_cat_logo_retina; ?>').val() === '0') {
            $('.remove_image_button_logo_retina').hide();
        }
        
        if (!$('#<?php echo $this->_cat_logo_sticky; ?>').val() || $('#<?php echo $this->_cat_logo_sticky; ?>').val() === '0') {
            $('.remove_image_button_logo_sticky').hide();
        }
        
        if (!$('#<?php echo $this->_cat_logo_m; ?>').val() || $('#<?php echo $this->_cat_logo_m; ?>').val() === '0') {
            $('.remove_image_button_logo_m').hide();
        }

        // Uploading files
        var file_frame_logo;

        /**
         * Logo
         */
        $('body').on('click', '.upload_image_button_logo', function (event) {

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame_logo) {
                file_frame_logo.open();
                return;
            }

            // Create the media frame.
            file_frame_logo = wp.media.frames.downloadable_file = wp.media({
                title: '<?php _e("Choose an image", "nasa-core"); ?>',
                button: {
                    text: '<?php _e("Use image", "nasa-core"); ?>'
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame_logo.on('select', function () {
                var attachment = file_frame_logo.state().get('selection').first().toJSON();
                var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                $('#<?php echo $this->_cat_logo; ?>').val(attachment.id);
                $('#nasa-logo_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                $('.remove_image_button_logo').show();
            });

            // Finally, open the modal.
            file_frame_logo.open();
        });

        $('body').on('click', '.remove_image_button_logo', function () {
            $('#nasa-logo_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
            $('#<?php echo $this->_cat_logo; ?>').val('');
            $('.remove_image_button_logo').hide();
            return false;
        });

        // Uploading files retina
        var file_frame_logo_retina;

        /**
         * Logo Retina
         */
        $('body').on('click', '.upload_image_button_logo_retina', function (event) {

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame_logo_retina) {
                file_frame_logo_retina.open();
                return;
            }

            // Create the media frame.
            file_frame_logo_retina = wp.media.frames.downloadable_file = wp.media({
                title: '<?php _e("Choose an image", "nasa-core"); ?>',
                button: {
                    text: '<?php _e("Use image", "nasa-core"); ?>'
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame_logo_retina.on('select', function () {
                var attachment = file_frame_logo_retina.state().get('selection').first().toJSON();
                var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                $('#<?php echo $this->_cat_logo_retina; ?>').val(attachment.id);
                $('#nasa-logo-retina_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                $('.remove_image_button_logo_retina').show();
            });

            // Finally, open the modal.
            file_frame_logo_retina.open();
        });

        $('body').on('click', '.remove_image_button_logo_retina', function () {
            $('#nasa-logo-retina_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
            $('#<?php echo $this->_cat_logo_retina; ?>').val('');
            $('.remove_image_button_logo_retina').hide();
            return false;
        });
        
        // Uploading files sticky
        var file_frame_logo_sticky;

        /**
         * Logo Sticky
         */
        $('body').on('click', '.upload_image_button_logo_sticky', function (event) {

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame_logo_sticky) {
                file_frame_logo_sticky.open();
                return;
            }

            // Create the media frame.
            file_frame_logo_sticky = wp.media.frames.downloadable_file = wp.media({
                title: '<?php _e("Choose an image", "nasa-core"); ?>',
                button: {
                    text: '<?php _e("Use image", "nasa-core"); ?>'
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame_logo_sticky.on('select', function () {
                var attachment = file_frame_logo_sticky.state().get('selection').first().toJSON();
                var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                $('#<?php echo $this->_cat_logo_sticky; ?>').val(attachment.id);
                $('#nasa-logo-sticky_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                $('.remove_image_button_logo_sticky').show();
            });

            // Finally, open the modal.
            file_frame_logo_sticky.open();
        });

        $('body').on('click', '.remove_image_button_logo_sticky', function () {
            $('#nasa-logo-sticky_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
            $('#<?php echo $this->_cat_logo_sticky; ?>').val('');
            $('.remove_image_button_logo_sticky').hide();
            return false;
        });
        
        // Uploading files mobile
        var file_frame_logo_m;

        /**
         * Logo Mobile
         */
        $('body').on('click', '.upload_image_button_logo_m', function (event) {

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame_logo_m) {
                file_frame_logo_m.open();
                return;
            }

            // Create the media frame.
            file_frame_logo_m = wp.media.frames.downloadable_file = wp.media({
                title: '<?php _e("Choose an image", "nasa-core"); ?>',
                button: {
                    text: '<?php _e("Use image", "nasa-core"); ?>'
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame_logo_m.on('select', function () {
                var attachment = file_frame_logo_m.state().get('selection').first().toJSON();
                var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                $('#<?php echo $this->_cat_logo_m; ?>').val(attachment.id);
                $('#nasa-logo-m_thumbnail').find('img').attr('src', attachment_thumbnail.url);
                $('.remove_image_button_logo_m').show();
            });

            // Finally, open the modal.
            file_frame_logo_m.open();
        });

        $('body').on('click', '.remove_image_button_logo_m', function () {
            $('#nasa-logo-m_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
            $('#<?php echo $this->_cat_logo_m; ?>').val('');
            $('.remove_image_button_logo_m').hide();
            return false;
        });

        $(document).ajaxComplete(function (event, request, options) {
            if (request && 4 === request.readyState && 200 === request.status && options.data && 0 <= options.data.indexOf('action=add-tag')) {

                var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                if (!res || res.errors) {
                    return;
                }
                // Clear Thumbnail fields on submit
                $('#nasa-logo_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                $('#nasa-logo-retina_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                $('#nasa-logo-sticky_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                $('#nasa-logo-m_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                
                $('#<?php echo $this->_cat_logo; ?>').val('');
                $('#<?php echo $this->_cat_logo_retina; ?>').val('');
                $('#<?php echo $this->_cat_logo_sticky; ?>').val('');
                $('#<?php echo $this->_cat_logo_m; ?>').val('');
                
                $('.remove_image_button_logo').hide();
                $('.remove_image_button_logo_retina').hide();
                $('.remove_image_button_logo_sticky').hide();
                $('.remove_image_button_logo_m').hide();
                
                // Clear Display type field on submit
                $('#display_type').val('');
                return;
            }
        });
    });
</script>
