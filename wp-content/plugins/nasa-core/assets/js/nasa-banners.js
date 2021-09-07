/**
 * Document nasa-core ready
 */
jQuery(document).ready(function($) {
"use strict";
    
/**
 * Reponsive Banners
 * 
 * @type type
 */
var reponsiveMobile = setTimeout(function() {
    nasa_responsive_banners($);
}, 50);

$(window).on('resize', function () {
    clearTimeout(reponsiveMobile);
    reponsiveMobile = setTimeout(function() {
        nasa_responsive_banners($);
    }, 1000);
});

/**
 * Trigger After load ajax function
 */
$('body').on('nasa_after_ajax_funcs', function() {
    nasa_responsive_banners($);
});

$('body').on('nasa_rendered_template', function() {
    nasa_responsive_banners($);
});

});

/**
 * Responsive for Banners
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_responsive_banners($) {
    if ($('.nasa-banner-image').length > 0) {
        $('.nasa-banner-image').each(function() {
            var _this = $(this);
            if (!$(_this).hasClass('banner-img')) {
                var _parent = $(_this).parent();

                if (!$(_parent).hasClass('nasa-not-responsive')) {
                    var _defH = parseInt($(_this).attr('data-height'));
                    var _defW = parseInt($(_this).attr('data-width'));
                    var _realWidth = $(_this).outerWidth();
                    var _ratio = _realWidth / _defW;
                    var _realHeight = _defH * _ratio;

                    if (_ratio !== 1) {
                        $(_parent).height(_realHeight);
                        $(_parent).find('.nasa-banner-content').css({
                            'font-size': (_ratio * 100).toString() + '%'
                        });
                    } else {
                        $(_parent).height(_defH);
                        $(_parent).find('.nasa-banner-content').css({
                            'font-size': '100%'
                        });
                    }
                }
            }
        });
    }
}
