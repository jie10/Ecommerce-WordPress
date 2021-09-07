jQuery(document).ready(function ($) {
    'use strict';
    if (typeof wp === 'undefined') {
        var wp = window.wp;
    }

    $('#term-nasa_color').wpColorPicker();

    // Toggle add new attribute term modal
    var $modal = $('#nasa-attr-ux-modal-container'),
        $spinner = $modal.find('.spinner'),
        $msg = $modal.find('.message'),
        $metabox = null;

    $('body').on('click', '.nasa-attr-ux_add_new_attribute', function (e) {
        e.preventDefault();
        var $button = $(this),
            taxInputTemplate = wp.template('nasa-attr-ux-input-tax'),
            data = {
                type: $button.data('type'),
                tax: $button.closest('.woocommerce_attribute').data('taxonomy')
            };

        // Insert input
        $modal.find('.nasa-attr-ux-term-val').html($('#tmpl-nasa-attr-ux-input-' + data.type).html());
        $modal.find('.nasa-attr-ux-term-tax').html(taxInputTemplate(data));

        if ('nasa_color' === data.type) {
            $modal.find('input.nasa-attr-ux-input-color').wpColorPicker();
        }

        $metabox = $button.closest('.woocommerce_attribute.wc-metabox');
        $modal.show();
    }).on('click', '.nasa-attr-ux-modal-close, .nasa-attr-ux-modal-backdrop', function (e) {
        e.preventDefault();
        closeModal();
    });

    // Send ajax request to add new attribute term
    $('body').on('click', '.nasa-attr-ux-new-attribute-submit', function (e) {
        e.preventDefault();

        var $button = $(this),
            type = $button.data('type'),
            error = false,
            data = {};

        // Validate
        $modal.find('.nasa-attr-ux-input').each(function () {
            var $this = $(this);

            if ($this.attr('name') !== 'slug' && !$this.val()) {
                $this.addClass('error');
                error = true;
            } else {
                $this.removeClass('error');
            }

            data[$this.attr('name')] = $this.val();
        });

        if (error) {
            return;
        }

        // Send ajax request
        $spinner.addClass('is-active');
        $msg.hide();
        wp.ajax.send('nasa_attr_ux_add_new_attribute', {
            data: data,
            error: function (res) {
                $spinner.removeClass('is-active');
                $msg.addClass('error').text(res).show();
            },
            success: function (res) {
                $spinner.removeClass('is-active');
                $msg.addClass('success').text(res.msg).show();

                $metabox.find('select.attribute_values').append('<option value="' + res.id + '" selected="selected">' + res.name + '</option>');
                $metabox.find('select.attribute_values').change();

                closeModal();
            }
        });
    });

    /**
     * Close modal
     */
    function closeModal() {
        $modal.find('.nasa-attr-ux-term-name input, .nasa-attr-ux-term-slug input').val('');
        $spinner.removeClass('is-active');
        $msg.removeClass('error success').hide();
        $modal.hide();
    }

    /**
     * Image - Media
     */
    if (typeof wp !== 'undefined') {
        $('body').on('click', 'button.upload_image-tax', function (e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Image',
                // mutiple: true if you want to upload multiple files at once
                multiple: false
            }).open().on('select', function () {
                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get('selection').first();
                // We convert uploaded_image to a JSON object to make accessing it easier
                // Output to the console uploaded_image
                var imgObj = uploaded_image.toJSON();
                // imgObj.url, imgObj.id

                // Let's assign the url value to the input field
                $('#term-nasa_image').val(imgObj.id);
                $('#nasa-attr-img-view').attr('src', imgObj.url);
                $('.remove_image-tax').show();
            });
        });

        $('body').on('click', 'button.remove_image-tax', function (e) {
            e.preventDefault();
            $('#term-nasa_image').val('');
            $('#nasa-attr-img-view').attr('src', $(this).attr('data-no_img'));
            $(this).hide();
        });

        /**
         * Custom upload
         */
        $('body').on('click', '.nasa-custom-upload', function (e) {
            var _this = $(this);
            if (!$(_this).hasClass('nasa-remove')) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Image',
                    // mutiple: true if you want to upload multiple files at once
                    multiple: false
                }).open().on('select', function () {
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_image = image.state().get('selection').first();
                    // We convert uploaded_image to a JSON object to make accessing it easier
                    // Output to the console uploaded_image
                    var imgObj = uploaded_image.toJSON();
                    // imgObj.url, imgObj.id

                    // Let's assign the url value to the input field
                    $(_this).find('input').val(imgObj.id);
                    $(_this).find('img').attr('src', imgObj.sizes.thumbnail.url);
                    $(_this).addClass('nasa-remove');
                });
            } else if (confirm($(_this).attr('data-confirm_remove'))) {
                $(_this).find('input').val('');
                $(_this).find('img').attr('src', $(_this).attr('data-no_img'));
                $(_this).removeClass('nasa-remove');
            }
        });
    }

    /**
     * Variation Product gallery file uploads.
     */
    $('body').on('click', '.nasa-add-variation-gallery-image-wrapper a', function (event) {
        var $el = $(this);

        event.preventDefault();

        var _woo_variation = $el.parents('.woocommerce_variation');
        var product_gallery_frame;
        var _variation_id = $el.attr('data-product_variation_id');
        var $image_gallery_ids = $('#nasa_variation_gallery_images-' + _variation_id);
        var $product_images = $('#nasa-variation_gallery-' + _variation_id);

        // If the media frame already exists, reopen it.
        if (product_gallery_frame) {
            product_gallery_frame.open();
            return;
        }

        // Create the media frame.
        product_gallery_frame = wp.media.frames.product_gallery = wp.media({
            // Set the title of the modal.
            title: $el.data('choose'),
            button: {
                text: $el.data('update')
            },
            states: [
                new wp.media.controller.Library({
                    title: $el.data('choose'),
                    filterable: 'all',
                    multiple: true
                })
            ]
        });

        // When an image is selected, run a callback.
        product_gallery_frame.on('select', function () {
            var selection = product_gallery_frame.state().get('selection');
            var attachment_ids = $image_gallery_ids.val();

            selection.map(function (attachment) {
                attachment = attachment.toJSON();

                if (attachment.id) {
                    attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                    var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                    $product_images.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="javascript:void(0);" class="delete">' + $el.data('text') + '</a></li></ul></li>');
                }
            });

            $image_gallery_ids.val(attachment_ids);

            $(_woo_variation).addClass('variation-needs-update');
            $('button.cancel-variation-changes, button.save-variation-changes').removeAttr('disabled');
            $('#variable_product_options').trigger('woocommerce_variations_input_changed');
        });

        // Finally, open the modal.
        product_gallery_frame.open();
    });

    $('#woocommerce-product-data').on('woocommerce_variations_loaded', function () {
        nasaGalleryVariation($);
    }).on('woocommerce_variations_added', function () {
        nasaGalleryVariation($);
    });

    // Remove Image
    $('body').on('click', '.nasa-variation-gallery-images .actions a.delete', function () {
        var _this = $(this);
        var _woo_variation = $(_this).parents('.woocommerce_variation');
        var _wrap = $(_this).parents('.nasa-variation-gallery-images');
        var _variation_id = $(_wrap).attr('data-variation_id');
        $(_this).parents('li.image').remove();

        var attachment_ids = '';

        $(_wrap).find('li.image').each(function () {
            var attachment_id = $(this).attr('data-attachment_id');
            attachment_ids = attachment_ids + attachment_id + ',';
        });

        $('#nasa_variation_gallery_images-' + _variation_id).val(attachment_ids);

        $(_woo_variation).addClass('variation-needs-update');
        $('button.cancel-variation-changes, button.save-variation-changes').removeAttr('disabled');
        $('#variable_product_options').trigger('woocommerce_variations_input_changed');

        return false;
    });
});

function nasaGalleryVariation($) {
    if ($('.woocommerce_variation').length) {
        $('.woocommerce_variation').each(function () {
            var _this = $(this);
            var _gallery = $(_this).find('.nasa-variation-gallery-wrapper').wrap('<div>').parent().html();
            $(_this).find('.nasa-variation-gallery-wrapper').remove();
            $(_this).find('.upload_image').after(_gallery);
        });
    }

    $('.nasa-variation-gallery-images').each(function () {
        var _this = $(this);
        var _variation_id = $(_this).attr('data-variation_id');
        var _woo_variation = $(_this).parents('.woocommerce_variation');
        _this.sortable({
            items: 'li.image',
            cursor: 'move',
            scrollSensitivity: 40,
            forcePlaceholderSize: true,
            forceHelperSize: false,
            helper: 'clone',
            opacity: 0.65,
            placeholder: 'wc-metabox-sortable-placeholder',
            start: function (event, ui) {
                ui.item.css('background-color', '#f6f6f6');
            },
            stop: function (event, ui) {
                ui.item.removeAttr('style');
            },
            update: function () {
                var attachment_ids = '';

                $(_this).find('li.image').css('cursor', 'default').each(function () {
                    var attachment_id = $(this).attr('data-attachment_id');
                    attachment_ids = attachment_ids + attachment_id + ',';
                });

                $('#nasa_variation_gallery_images-' + _variation_id).val(attachment_ids);

                $(_woo_variation).addClass('variation-needs-update');
                $('button.cancel-variation-changes, button.save-variation-changes').removeAttr('disabled');
                $('#variable_product_options').trigger('woocommerce_variations_input_changed');
            }
        });
    });
}
