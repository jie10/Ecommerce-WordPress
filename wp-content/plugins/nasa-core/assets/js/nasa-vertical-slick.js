/**
 * Document nasa-core ready
 */
jQuery(document).ready(function($) {
    "use strict";
    
    /**
     * Render
     */
    loading_slick_vertical_categories($);
    
    $('body').on('nasa_before_ajax_funcs', function() {
        loading_slick_vertical_categories($);
    });
    
    $('body').on('nasa_rendered_template', function() {
        loading_slick_vertical_categories($);
    });
});

/**
 * Load categories vertical slide
 * Slick slider - Vertical slider
 */
function loading_slick_vertical_categories($) {
    if ($('.nasa-vertical-slider').length > 0){
        
        $('body').trigger('nasa_compatible_jetpack');
        
        $('.nasa-vertical-slider').each(function(){
            var _this = $(this);
            if (!$(_this).hasClass('slick-initialized')) {
                var _show = parseInt($(_this).attr('data-show')),
                    _change = parseInt($(_this).attr('data-scroll')),
                    _speed = parseInt($(_this).attr('data-speed')),
                    _delay = parseInt($(_this).attr('data-delay')),
                    _autoplay = $(_this).attr('data-autoplay') === 'true' ? true : false,
                    _dot = $(_this).attr('data-dot') === 'true' ? true : false,
                    _arrows = $(_this).attr('data-arrows') === 'true' ? true : false;

                var _show = _show ? _show : 1,
                    _delay = _delay ? _delay : 6000,
                    _speed = _speed ? _speed : 300,
                    _change = _change ? _change : 1;
                    

                var _setting = {
                    vertical: true,
                    verticalSwiping: true,
                    slidesToShow: _show,
                    slidesToScroll: _change,
                    autoplay: _autoplay,
                    infinite: _autoplay,
                    autoplaySpeed: _delay,
                    speed: _speed,
                    dots: _dot,
                    arrows: _arrows
                };

                $(_this).slick(_setting);
            }
        });
    }
}
