/* Document ready */
jQuery(document).ready(function($) {
"use strict";
loading_slick_element($);
});

/**
 * Slick slider element
 * 
 * @param {type} $
 * @param {type} restart
 * @returns {undefined}
 */
function loading_slick_element($, restart) {
    if ($('.nasa-slick-slider').length) {
        
        nasa_compatible_jetpack($);
        
        var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
        var _restart = typeof restart === 'undefined' ? false : restart;
        
        $('.nasa-slick-slider').each(function() {
            var _this = $(this);
            
            /**
             * Restart
             */
            if (_restart) {
                $(_this).slick('unslick');
            }
            
            /**
             * Remove slick item
             */
            if ($(_this).find('.nasa-slick-remove').length) {
                $(_this).find('.nasa-slick-remove').remove();
            }
            
            if (!$(_this).hasClass('slick-initialized')){
                var _cols = parseInt($(_this).attr('data-columns')),
                    _cols_small = parseInt($(_this).attr('data-columns-small')),
                    _cols_medium = parseInt($(_this).attr('data-columns-tablet')),
                    
                    _autoplay = $(_this).attr('data-autoplay') === 'true' ? true : false,
                    
                    _speed = parseInt($(_this).attr('data-speed')),
                    _delay = parseInt($(_this).attr('data-delay')),
                    
                    _dots = $(_this).attr('data-dot') === 'true' || $(_this).attr('data-dots') === 'true' ?
                        true : false,
                    
                    /**
                     * Height auto only for 1 column
                     */
                    _height_auto = $(_this).attr('data-height-auto') === 'true' ? true : false,
                    
                    _padding = $(_this).attr('data-padding'),
                    _padding_small = $(_this).attr('data-padding-small'),
                    _padding_medium = $(_this).attr('data-padding-medium'),
                    
                    _drag = $(_this).attr('data-disable-drag') === 'true' ? false : true,
                    _slide_all = $(_this).attr('data-slides-all') === 'true' ? true : false,
                    _start = parseInt($(_this).attr('data-start'));
                    
                _cols = !_cols ? 4 : _cols;
                _cols_small = !_cols_small ? 2 : _cols_small;
                _cols_medium = !_cols_medium ? 3 : _cols_medium;
                    
                var _scroll = _slide_all ? _cols : 1,
                    _scroll_small = _slide_all ? _cols_small : 1,
                    _scroll_medium = _slide_all ? _cols_medium : 1;
                    
                _speed = !_speed ? 300: _speed;
                _delay = !_delay ? 6000: _delay;
                    
                _start = !_start ? 0 : _start;
                    
                var _setting = {
                    rtl: _rtl,
                    slidesToShow: _cols,
                    slidesToScroll: _scroll,
                    autoplay: _autoplay,
                    infinite: _autoplay,
                    autoplaySpeed: _delay,
                    speed: _speed,
                    initialSlide: _start,
                    adaptiveHeight: _height_auto,
                    dots: _dots,
                    swipe: _drag,
                    draggable: _drag,
                    pauseOnHover: true,
                    arrows: true,
                    touchThreshold: 10,
                    cssEase: 'ease-out',
                    prevArrow: '<a class="nasa-nav-arrow slick-prev" href="javascript:void(0);"></a>',
                    nextArrow: '<a class="nasa-nav-arrow slick-next" href="javascript:void(0);"></a>'
                };
                
                if (!_rtl) {
                    _setting.swipeToSlide = true;
                }
                
                var _switchTablet = 768;
                var _switchDesktop = 1130;
                
                if ($(_this).attr('data-switch-tablet')) {
                    _switchTablet = parseInt($(_this).attr('data-switch-tablet'));
                }
                
                if ($(_this).attr('data-switch-desktop')) {
                    _switchDesktop = parseInt($(_this).attr('data-switch-desktop'));
                }
                
                var _setting_medium = {
                    slidesToShow: _cols_medium,
                    slidesToScroll: _scroll_medium
                };
                
                var _setting_small = {
                    slidesToShow: _cols_small,
                    slidesToScroll: _scroll_small
                };
                
                if (_padding) {
                    _setting.centerMode = true;
                    _setting.centerPadding = _padding;
                    _setting.infinite = true;
                    
                    if (!$(_this).hasClass('nasa-center-mode')) {
                        $(_this).addClass('nasa-center-mode');
                    }
                }
                
                if (_padding_small) {
                    _setting_small.centerMode = true;
                    _setting_small.centerPadding = _padding_small;
                    _setting_small.infinite = true;
                    
                    if (!$(_this).hasClass('nasa-small-center-mode')) {
                        $(_this).addClass('nasa-small-center-mode');
                    }
                } else {
                    _setting_small.centerMode = false;
                }
                
                if (_padding_medium) {
                    _setting_medium.centerMode = true;
                    _setting_medium.centerPadding = _padding_medium;
                    _setting_medium.infinite = true;
                    
                    if (!$(_this).hasClass('nasa-medium-center-mode')) {
                        $(_this).addClass('nasa-medium-center-mode');
                    }
                } else {
                    _setting_medium.centerMode = false;
                }
                
                var _responsive = [
                    {
                        breakpoint: _switchDesktop, // => Tablet Mode
                        settings: _setting_medium
                    },
                    {
                        breakpoint: _switchTablet, // => Mobile Mode
                        settings: _setting_small
                    }
                ];
                
                if ($(_this).attr('data-switch-custom')) {
                    var _switchCustom = parseInt($(_this).attr('data-switch-custom'));
                    
                    var _settingCustom = {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    };
                }
                
                if (_switchCustom) {
                    _responsive.push({
                        breakpoint: _switchCustom,
                        settings: _settingCustom
                    });
                }
                
                _setting.responsive = _responsive;
                
                $(_this).slick(_setting);
                
                /**
                 * Init Banner transition
                 */
                if ($(_this).find('.nasa-banner-image').length) {
                    $(_this).find('.slick-slide').each(function() {
                        var _item = $(this);
                        if ($(_item).find('.banner-inner').length > 0){
                            var _banner = $(_item).find('.banner-inner');
                            var animation = $(_banner).attr('data-animation');
                            $(_banner).removeClass('animated').removeClass(animation).removeAttr('style');
                            if ($(_item).hasClass('slick-active')){
                                setTimeout(function(){
                                    $(_banner).show();
                                    $(_banner).addClass('animated').addClass(animation).css({
                                        'visibility': 'visible',
                                        'animation-duration': '1s',
                                        'animation-delay': '0ms',
                                        'animation-name': animation
                                    });
                                }, 1000);
                            }
                        }
                    });
                }
                
                setTimeout(function() {
                    $('body').trigger('nasa_inited_slick', [_this]);
                }, 100);
            }
        });
    }
}

/**
 * support jetpack-lazy-image
 * @type type
 */
function nasa_compatible_jetpack($) {
    if ($('.jetpack-lazy-image').length) {
        $('.jetpack-lazy-image')
        .removeAttr('srcset')
        .removeAttr('data-lazy-src')
        .removeClass('jetpack-lazy-image');
    }
}
