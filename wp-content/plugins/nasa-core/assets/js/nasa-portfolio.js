/**
 * Document nasa-core ready
 */
jQuery(document).ready(function($) {
"use strict";
/**
 * Portfolio popup image
 */
$('body').on('click', '.portfolio-image-view', function (e) {
    var _src = $(this).attr('data-src');
    $.magnificPopup.open({
        closeOnContentClick: true,
        closeMarkup: '<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="' + $('input[name="nasa-close-string"]').val() + '"></a>',
        items: {
            src: '<div class="portfolio-lightbox"><img src="' + _src + '" /></div>',
            type: 'inline'
        }
    });
    $('.nasa-loader, .color-overlay').remove();
    e.preventDefault();
});
});
