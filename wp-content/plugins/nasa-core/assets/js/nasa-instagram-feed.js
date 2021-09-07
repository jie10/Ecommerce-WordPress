/**
 * Document nasa-core ready
 */
jQuery(document).ready(function($) {
    "use strict";
    
    /**
     * Render instagram Feed
     */
    nasa_instagram_feed_init($);
    $('body').on('nasa_init_elementor_events', function() {
        nasa_instagram_feed_init($);
    });
    
    $('body').on('nasa_rendered_template', function() {
        nasa_instagram_feed_init($);
    });
});

/**
 * Render instagram Feed
 */
function nasa_instagram_feed_init($) {
    if ($('.nasa-from-instagram-feed .sbi_item').length) {
        $('.nasa-from-instagram-feed').each(function() {
            if (!$(this).hasClass('nasa-inited')) {
                $(this).addClass('nasa-inited');
                
                var _wrap = $(this).parents('.nasa-intagram-wrap');

                if ($(_wrap).length && $(_wrap).find('.sbi_item').length) {

                    var _type = $(_wrap).attr('data-layout');

                    if ($(_wrap).find('.nasa-instagram-' + _type).length) {
                        var _k = 0;
                        $(_wrap).find('.sbi_item a').each(function() {
                            var _this = $(this);

                            if ($(_wrap).find('.nasa-instagram-link[data-index="' + _k + '"]').length) {
                                var _notset = $(_wrap).find('.nasa-instagram-link[data-index="' + _k + '"]');
                                var _img = $(_notset).find('img.nasa-instagram-img');

                                /**
                                 * href a
                                 */
                                $(_notset).attr('href', $(_this).attr('href'));

                                /**
                                 * set src image
                                 */
                                var _size = $(_wrap).attr('data-size');
                                var _srcset_text = $(_this).attr('data-img-src-set');
                                var _src = $(_this).attr('data-full-res');
                                if (_srcset_text) {
                                    var _srcset = JSON.parse(_srcset_text);
                                    if (_srcset && typeof _srcset[_size] !== 'undefined') {
                                        var _src = _srcset[_size];
                                    }
                                }

                                if (_src) {
                                    $(_img).attr('src', _src);
                                }

                                $(_img).attr('alt', $(_this).find('img').attr('alt'));

                                $(_notset).find('.nasa-not-set').removeClass('nasa-not-set');
                            }

                            _k++;
                        });

                        if ($(_wrap).find('.nasa-not-set').length) {
                            $(_wrap).find('.nasa-not-set').each (function() {
                                var _item = $(this).parents('.nasa-instagram-item');
                                if ($(_item).length) {
                                    $(_item).remove();
                                }
                            });
                        }
                    }

                    /**
                     * remove default
                     */
                    $(_wrap).find('.nasa-from-instagram-feed').remove();

                    if (_type === 'slider') {
                        $(_wrap).find('.nasa-instagram-slider-wrap').addClass('nasa-slick-slider nasa-slick-nav');
                        $('body').trigger('nasa_load_slick_slider');
                    }

                    $('body').trigger('nasa_instagram_inited', [_wrap]);
                }
            }
        });
    }
}
