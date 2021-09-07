jQuery(document).ready(function ($) {
    'use strict';
    $('body').on('click', '.nasa-media-upload-button', function (e) {
        e.preventDefault();
        var _id = $(this).attr('data-id');
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open().on('select', function (e) {
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            var image_Id = uploaded_image.toJSON().id;
            $('#' + _id).val(image_Id);
            $('.imgmega.' + _id).html('<img src="' + image_url + '" />');
        });
    });

    $('body').on('click', '.nasa-media-remove-button', function (e) {
        e.preventDefault();
        var _id = $(this).attr('data-id');
        $('#' + _id).val('');
        $('.imgmega.' + _id + ' img').remove();
    });

    $('.edit-menu-item-image_mega_enable').each(function () {
        var _check = $(this).find('input[type="checkbox"]');
        var _id = $(_check).attr('data-id');

        if ($(_check).is(':checked')) {
            $('.menu-field-media-' + _id).show();
            $('.additional-menu-field-position_image_mega.select-field-' + _id).show();
            $('.additional-menu-field-disable_title_image_mega.select-field-' + _id).show();
        }
    });

    $('body').on('click', '.edit-menu-item-image_mega_enable', function () {
        var _id = $(this).attr('data-id');

        if ($(this).is(':checked')) {
            $('.menu-field-media-' + _id).fadeIn(200);
            $('.additional-menu-field-position_image_mega.select-field-' + _id).fadeIn(200);
            $('.additional-menu-field-disable_title_image_mega.select-field-' + _id).fadeIn(200);
        } else {
            $('.menu-field-media-' + _id).fadeOut(200);
            $('.additional-menu-field-position_image_mega.select-field-' + _id).fadeOut(200);
            $('.additional-menu-field-disable_title_image_mega.select-field-' + _id).fadeOut(200);
        }
    });
});
