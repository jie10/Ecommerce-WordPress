/**
 * Document ready
 * 
 * Filter Ajax in store
 */
var shop_load = false,
    archive_page = 1,
    infinitiAjax = false,
    _scroll_to_top = false,
    _queue_trigger = {};
    
if (typeof _cookie_live === 'undefined') {
    var _cookie_live = 7;
}
    
jQuery(document).ready(function($) {
"use strict";

/**
 * Crazy Loading
 */
if ($('.nasa-crazy-load.crazy-loading').length) {
    $('.nasa-crazy-load.crazy-loading').removeClass('crazy-loading');
}

/**
 * Scroll load more
 */
$(window).scroll(function() {
    var scrollTop = $(this).scrollTop();
    
    if (
        $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').length &&
        $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').find('.nasa-archive-loadmore').length === 1
    ) {
        var infinitiOffset = $('#nasa-wrap-archive-loadmore').offset();
        
        if (!infinitiAjax) {
            if (scrollTop + $(window).height() >= infinitiOffset.top) {
                infinitiAjax = true;
                $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').find('.nasa-archive-loadmore').trigger('click');
            }
        }
    }
});

/**
 * Clone group btn for list layout
 */
clone_group_btns_product_item($);
$('body').on('nasa_store_changed_layout_list', function() {
    clone_group_btns_product_item($);
});

/**
 * Top filter actived
 */
if ($('.nasa-products-page-wrap').length) {
    if ($('.nasa-products-page-wrap .nasa-actived-filter').length <= 0) {
        $('.nasa-products-page-wrap').prepend('<div class="nasa-actived-filter hidden-tag"></div>');
    }
    
    var _actived_filter = get_top_filter_actived($);
    if (_actived_filter) {
        $('.nasa-actived-filter').replaceWith(_actived_filter);
    }
    
    $('body').on('price_slider_updated', function() {
        if ($('.nasa-actived-filter .nasa-price-active-init').length) {
            if ($('.nasa-products-page-wrap .nasa-actived-filter').length <= 0) {
                $('.nasa-products-page-wrap').prepend('<div class="nasa-actived-filter hidden-tag"></div>');
            }
            
            var _act_content = get_top_filter_actived($);
            if (_act_content) {
                $('.nasa-actived-filter').replaceWith(_act_content);
            }
        }
    });
}

$('body').on('nasa_after_load_ajax_first', function() {
    /**
     * Topbar Actived filters
     */
    load_active_topbar($);
    
    /**
     * Toggle Sidebar classic
     */
    load_toggle_sidebar_classic($);
    
    /**
     * Clone Group Btn for listview
     */
    clone_group_btns_product_item($);
});

/**
 * Reload class for .nasa-top-row-filter a.nasa-tab-filter-topbar
 */
$('body').on('nasa_after_load_ajax', function() {
    if ($('.nasa-push-cat-filter.nasa-push-cat-show').length) {
        var _this = $('.nasa-top-row-filter a.nasa-tab-filter-topbar');
        if ($(_this).length && !$(_this).hasClass('nasa-push-cat-show')) {
            $(_this).addClass('nasa-push-cat-show');
        }
    }
    
    // Ordering
    if ($('.woocommerce-ordering').length) {
        var _order = $('.woocommerce-ordering').html();
        $('.woocommerce-ordering').replaceWith('<div class="woocommerce-ordering">' + _order + '</div>');
    }
    
    /**
     * Change layout
     * 
     * @type String
     */
    if ($('.nasa-change-layout').length) {
        var _cookie_change_layout_name = $('input[name="nasa_archive_grid_view"]').length ? $('input[name="nasa_archive_grid_view"]').val() : 'nasa_archive_grid_view';
        var _cookie_change_layout = $.cookie(_cookie_change_layout_name);
        if (typeof _cookie_change_layout !== 'undefined' && $('.nasa-change-layout.' + _cookie_change_layout).length) {
            $('.nasa-change-layout.' + _cookie_change_layout).trigger('click');
        }
    }
});

/**
 * INIT nasa-change-layout Change layout
 */
setTimeout(function() {
    var _cookie_change_layout_name = $('input[name="nasa_archive_grid_view"]').length ? $('input[name="nasa_archive_grid_view"]').val() : 'nasa_archive_grid_view';
    var _cookie_change_layout = $.cookie(_cookie_change_layout_name);
    if (typeof _cookie_change_layout !== 'undefined' && $('.nasa-change-layout.' + _cookie_change_layout).length) {
        $('.nasa-change-layout.' + _cookie_change_layout).trigger('click');
    }
}, 50);

/**
 * Even change layout
 */
$('body').on('click', '.nasa-change-layout', function() {
    var _this = $(this);
    if ($(_this).hasClass('active')) {
        return false;
    } else {
        change_layout_shop_page($, _this);
    }
});

/**
 * Igrone variation item filter
 */
$('body').on('click', '.nasa-ignore-variation-item', function() {
    var term_id = $(this).attr('data-term_id');
    if ($('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').length) {
        if ($('.nasa-has-filter-ajax').length < 1) {
            window.location.href = $('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').attr('href');
        } else {
            $('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').trigger('click');
        }
    }
});

/**
 * Igrone price filter
 */
$('body').on('click', '.nasa-ignore-price-item', function() {
    if ($('.reset_price').length) {
        $('.reset_price').trigger('click');
    }
    
    return false;
});

/**
 * Igrone price list filter
 */
$('body').on('click', '.nasa-ignore-price-item-list', function() {
    if ($('.nasa-all-price .nasa-filter-by-price-list').length) {
        $('.nasa-all-price .nasa-filter-by-price-list').trigger('click');
    }
    
    return false;
});

/* 
 * custom widget top bar
 * 
 */
init_nasa_top_sidebar($);
$('body').on('click', '.nasa-tab-filter-topbar-categories', function() {
    var _this = $(this);
    $('.filter-cat-icon-mobile').trigger('click');

    if ($(_this).attr('data-top_icon') === '0') {
        var _obj = $(_this).attr('data-widget');
        var _wrap_content = $('.nasa-top-sidebar');

        var _act = $(_obj).hasClass('nasa-active') ? true : false;
        $(_this).parents('.nasa-top-row-filter').find('> li').removeClass('nasa-active');
        $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').slideUp(300);

        if (!_act) {
            $(_obj).addClass('nasa-active').slideDown(300);
            $(_this).parents('li').addClass('nasa-active');
        }
    }

    else {
        $('.site-header').find('.filter-cat-icon').trigger('click');
        if ($('.nasa-header-sticky').length <= 0 || ($('.sticky-wrapper').length && !$('.sticky-wrapper').hasClass('fixed-already'))) {
            $('html, body').animate({scrollTop: 0}, 700);
        }
    }
    
    $('body').trigger('nasa_init_topbar_categories');
});

/**
 * Top sidebar
 */
$('body').on('click', '.nasa-top-row-filter a.nasa-tab-filter-topbar', function() {
    var _this = $(this);
    top_filter_click($, _this, 'animate');
});

/**
 * Top sidebar type 2
 */
$('body').on('click', '.nasa-toggle-top-bar-click', function() {
    var _this = $(this);
    top_filter_click_2($, _this, 'animate');
});

/**
 * Toggle Sidebar classic
 */
load_toggle_sidebar_classic($);
$('body').on('click', '.nasa-toogle-sidebar-classic', function() {
    if ($('.nasa-with-sidebar-classic').length) {
        var _this = $(this);
        var _show = $(_this).hasClass('nasa-hide') ? 'show' : 'hide';
        
        /**
         * Set cookie in _cookie_live days
         */
        $.cookie('toggle_sidebar_classic', _show, {expires: _cookie_live, path: '/'});
        
        /**
         * Show sidebar
         */
        if (_show === 'show') {
            $(_this).removeClass('nasa-hide');
            $('.nasa-with-sidebar-classic').removeClass('nasa-with-sidebar-hide');
        }
        
        /**
         * Hide sidebar
         */
        else {
            $(_this).addClass('nasa-hide');
            $('.nasa-with-sidebar-classic').addClass('nasa-with-sidebar-hide');
        }
        
        /**
         * Refresh Carousel
         */
        if (typeof _refresh_carousel !== 'undefined') {
            clearTimeout(_refresh_carousel);
        }
        
        var _refresh_carousel = setTimeout(function() {
            $('body').trigger('nasa_before_refresh_carousel');
            $('body').trigger('nasa_reload_slick_slider');
            $('body').trigger('nasa_refresh_sliders');
        }, 500);
    }
    
    return false;
});

/**
 * Filters Ajax Store
 * 
 * @type Number|min
 */
if (
    $('.nasa-widget-store.nasa-price-filter-slide').length &&
    $('.nasa-widget-store.nasa-price-filter-slide').find('.nasa-hide-price').length &&
    !$('.nasa-widget-store.nasa-price-filter-slide').hasClass('hidden-tag')
) {
    $('.nasa-widget-store.nasa-price-filter-slide').addClass('hidden-tag');
}

/**
 * After Load Ajax Complete
 */
$('body').on('nasa_after_loaded_ajax_complete', function() {
    if (
        $('.nasa-widget-store.nasa-price-filter-slide').length &&
        $('.nasa-widget-store.nasa-price-filter-slide').find('.nasa-hide-price').length &&
        !$('.nasa-widget-store.nasa-price-filter-slide').hasClass('hidden-tag')
    ) {
        $('.nasa-widget-store.nasa-price-filter-slide').addClass('hidden-tag');
    }
    
    if ($('.nasa-sort-by-action').length && $('.nasa-sort-by-action select[name="orderby"]').length <= 0) {
        $('.nasa-sort-by-action').addClass('hidden-tag');
    }
    
    /**
     * Compatible with Contact Form 7
     */
    if (typeof wpcf7 !== 'undefined' && $('.wpcf7 > form').length) {
        document.querySelectorAll(".wpcf7 > form").forEach(function (e) {
            return wpcf7.init(e);
        });
    }
});

var min_price = 0, max_price = 0, hasPrice = '0';
if ($('.price_slider_wrapper').length) {
    $('.price_slider_wrapper').find('input').attr('readonly', true);
    min_price = parseFloat($('.price_slider_wrapper').find('input[name="min_price"]').val()),
    max_price = parseFloat($('.price_slider_wrapper').find('input[name="max_price"]').val());
    hasPrice = ($('.nasa_hasPrice').length) ? $('.nasa_hasPrice').val() : '0';

    if (hasPrice === '1') {
        if ($('.reset_price').length) {
            $('.reset_price').attr('data-has_price', "1").show();
        }
        
        if ($('.price_slider_wrapper').find('button').length) {
            $('.price_slider_wrapper').find('button').show();
        }
    }
}

if ($('input[name="min-price-list"]').length) {
    min_price = parseFloat($('input[name="min-price-list"]').val());
    hasPrice = '1';
}

if ($('input[name="max-price-list"]').length) {
    max_price = parseFloat($('input[name="max-price-list"]').val());
    hasPrice = '1';
}

$('body').on('click', '.price_slider_wrapper button', function(e) {
    e.preventDefault();
    if (hasPrice === '1' && $('.nasa-has-filter-ajax').length < 1) {
        var _obj = $(this).parents('form');
        $('input[name="nasa_hasPrice"]').remove();
        $(_obj).submit();
    }
});

// Filter by Price Slide
$('body').on("slidestop", ".price_slider", function() {
    var _obj = $(this).parents('form');
    
    if ($('.nasa-has-filter-ajax').length <= 0) {
        if ($(_obj).find('.nasa-filter-price-btn').length <= 0) {
            $(_obj).submit();
        }
    } else {
        if (!shop_load) {
            if ($(_obj).find('.nasa-filter-price-btn').length) {
                $(_obj).find('.nasa-filter-price-btn').show();
            }
            
            if ($(_obj).find('.nasa-filter-price-btn').length <= 0) {
                shop_load = true;
                
                $('.nasa-value-gets input[name="min_price"]').remove();
                $('.nasa-value-gets input[name="max_price"]').remove();

                var min = parseFloat($(_obj).find('input[name="min_price"]').val()),
                    max = parseFloat($(_obj).find('input[name="max_price"]').val());
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }

                if (min != min_price || max != max_price) {
                    min_price = min;
                    max_price = max;
                    hasPrice = '1';
                    if ($('.nasa_hasPrice').length) {
                        $('.nasa_hasPrice').val('1');
                        $('.reset_price').attr('data-has_price', "1").fadeIn(200);
                    }

                    // Call filter by price
                    var _this = $('.current-tax-item > .nasa-filter-by-tax'),
                        _order = $('select[name="orderby"]').val(),
                        _page = false,
                        _taxid = null,
                        _taxonomy = '',
                        _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();

                    if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                        _taxid = $(_this).attr('data-id');
                        _taxonomy = $(_this).attr('data-taxonomy');
                        _url = $(_this).attr('href');
                    }

                    var _variations = nasa_set_variations($, [], []);
                    var _hasSearch = ($('input#nasa_hasSearch').length && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
                    var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

                    if ($(_obj).find('.nasa-filter-price-btn').length <= 0) {
                        _scroll_to_top = false;
                        nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
                    }
                } else {
                    shop_load = false;
                }
            }
        }

        return false;
    }
});

/**
 * Click price filter button
 */
$('body').on('click', '.nasa-filter-price-btn', function() {
    var _obj = $(this).parents('form');
    
    if ($('.nasa-has-filter-ajax').length <= 0) {
        $(_obj).submit();
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.nasa-value-gets input[name="min_price"]').remove();
            $('.nasa-value-gets input[name="max_price"]').remove();

            var min = parseFloat($(_obj).find('input[name="min_price"]').val()),
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            if (min < 0) {
                min = 0;
            }
            if (max < min) {
                max = min;
            }

            if (min != min_price || max != max_price) {
                min_price = min;
                max_price = max;
                hasPrice = '1';
                if ($('.nasa_hasPrice').length) {
                    $('.nasa_hasPrice').val('1');
                    $('.reset_price').attr('data-has_price', "1").fadeIn(200);
                }

                // Call filter by price
                var _this = $('.current-tax-item > .nasa-filter-by-tax'),
                    _order = $('select[name="orderby"]').val(),
                    _page = false,
                    _taxid = null,
                    _taxonomy = '',
                    _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();

                if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                    _taxid = $(_this).attr('data-id');
                    _taxonomy = $(_this).attr('data-taxonomy');
                    _url = $(_this).attr('href');
                }

                var _variations = nasa_set_variations($, [], []);
                var _hasSearch = ($('input#nasa_hasSearch').length && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
                var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

                _scroll_to_top = false;
                nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
            } else {
                shop_load = false;
            }
        }

        return false;
    }
});

// Reset filter price
$('body').on('click', '.reset_price', function() {
    if ($('.nasa_hasPrice').length && $('.nasa_hasPrice').val() === '1') {
        var _obj = $(this).parents('form');
        if ($('.nasa-has-filter-ajax').length < 1) {
            $('#min_price').remove();
            $('#max_price').remove();
            $('input[name="nasa_hasPrice"]').remove();
            $(_obj).append('<input type="hidden" name="reset-price" value="true" />');
            $(_obj).submit();
        } else {
            if (!shop_load) {
                shop_load = true;
                
                $('.nasa-value-gets input[name="min_price"]').remove();
                $('.nasa-value-gets input[name="max_price"]').remove();
                
                var _min = $('#min_price').attr('data-min');
                var _max = $('#max_price').attr('data-max');
                $('.price_slider').slider('values', 0, _min);
                $('.price_slider').slider('values', 1, _max);
                $('#min_price').val(_min);
                $('#max_price').val(_max);

                var currency_pos = $('input[name="nasa_currency_pos"]').val(),
                    full_price_min = _min,
                    full_price_max = _max;
                switch (currency_pos) {
                    case 'left':
                        full_price_min = woocommerce_price_slider_params.currency_format_symbol + _min;
                        full_price_max = woocommerce_price_slider_params.currency_format_symbol + _max;
                        break;
                    case 'right':
                        full_price_min = _min + woocommerce_price_slider_params.currency_format_symbol;
                        full_price_max = _max + woocommerce_price_slider_params.currency_format_symbol;
                        break;
                    case 'left_space' :
                        full_price_min = woocommerce_price_slider_params.currency_format_symbol + ' ' + _min;
                        full_price_max = woocommerce_price_slider_params.currency_format_symbol + ' ' + _max;
                        break;
                    case 'right_space' :
                        full_price_min = _min + ' ' + woocommerce_price_slider_params.currency_format_symbol;
                        full_price_max = _max + ' ' + woocommerce_price_slider_params.currency_format_symbol;
                        break;
                }

                $('.price_slider_amount .price_label span.from').html(full_price_min);
                $('.price_slider_amount .price_label span.to').html(full_price_max);

                var min = 0,
                    max = 0;

                hasPrice = '0';
                if ($('.nasa_hasPrice').length) {
                    $('.nasa_hasPrice').val('0');
                    $('.reset_price').attr('data-has_price', "0").fadeOut(200);
                }

                // Call filter by price
                var _this = $('.current-tax-item > .nasa-filter-by-tax'),
                    _order = $('select[name="orderby"]').val(),
                    _page = false,
                    _taxid = null,
                    _taxonomy = '',
                    _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();

                if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                    _taxid = $(_this).attr('data-id');
                    _taxonomy = $(_this).attr('data-taxonomy');
                    _url = $(_this).attr('href');
                }

                var _variations = nasa_set_variations($, [], []);
                var _hasSearch = ($('input#nasa_hasSearch').length && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
                var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

                _scroll_to_top = false;
                nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
            }
        }
    
        return false;
    }
});

// Filter price list
$('body').on('click', '.nasa-filter-by-price-list', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.nasa-value-gets input[name="min_price"]').remove();
            $('.nasa-value-gets input[name="max_price"]').remove();
            
            var _url = $(this).attr('href');
            var min = $(this).attr('data-min') ? $(this).attr('data-min') : null,
                max = $(this).attr('data-max') ? $(this).attr('data-max') : null;
                
            if (min < 0) {
                min = 0;
            }
            if (max < min) {
                max = min;
            }

            if (min != min_price || max != max_price) {
                hasPrice = '1';
            }
            
            // Call filter by price
            var _this = $('.current-tax-item > .nasa-filter-by-tax'),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _taxid = null,
                _taxonomy = '';

            if ($(_this).length) {
                _taxid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
            }
            
            var _variations = [];
            
            var _s = $('input#nasa_hasSearch').val(),
                _hasSearch = _s ? 1 : 0;
            
            _scroll_to_top = false;
            nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false);
        } else {
            _queue_trigger 
        }
        
        return false;
    }
});

// Reset filter
$('body').on('click', '.nasa-reset-filters-btn', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.nasa-value-gets input').remove();
            $('input[name="nasa_loadmore_style"]').remove();
            
            var _this = $(this),
            _taxid = $(_this).attr('data-id'),
            _taxonomy = $(_this).attr('data-taxonomy'),
            _order = false,
            _url = $(_this).attr('href'),
            _page = false;
            
            var _variations = [];
            var min = null,
                max = null;
            $('input#nasa_hasSearch').val('');
            hasPrice = '0';
            
            _scroll_to_top = false;
            nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max,  0, '', _this, _taxonomy, false, false, true);
        }
        
        return false;
    }
});

// Filter by Taxonomy - Category
$('body').on('click', '.nasa-filter-by-tax', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            if (!$(this).hasClass('nasa-disable') && !$(this).hasClass('nasa-active')) {
                shop_load = true;
                
                $('.nasa-value-gets input').remove();
                if ($('input.nasa-custom-cat').length) {
                    $('input.nasa-custom-cat').val('');
                }
                
                var _this = $(this),
                    _taxid = $(_this).attr('data-id'),
                    _taxonomy = $(_this).attr('data-taxonomy'),
                    _order = $('select[name="orderby"]').val(),
                    _url = $(_this).attr('href'),
                    _page = false;

                if (_taxid) {
                    var _variations = [];
                    $('.nasa-filter-by-variations').each(function() {
                        if ($(this).hasClass('nasa-filter-var-chosen')) {
                            $(this).parent().removeClass('chosen nasa-chosen');
                            $(this).removeClass('nasa-filter-var-chosen');
                        }
                    });

                    var min = null,
                        max = null;
                    $('input#nasa_hasSearch').val('');
                    hasPrice = '0';
                    /**
                     * Fix filter cat push in mobile.
                     */
                    if ($('.black-window-mobile.nasa-push-cat-show').width()) {
                        $('.black-window-mobile.nasa-push-cat-show').trigger('click');
                    }
                    
                    _scroll_to_top = false;
                    nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max,  0, '', _this, _taxonomy);

                    if (
                        $(_this).parents('.nasa-filter-cat-no-top-icon').length === 1 &&
                        $('.nasa-tab-filter-topbar-categories').length
                    ) {
                        $('.nasa-tab-filter-topbar-categories').trigger('click');
                    }
                }
            } else {
                shop_load = false;
            }
        }

        return false;
    }
});

// Ordering
if ($('.woocommerce-ordering').length && $('.nasa-has-filter-ajax').length) {
   var _order = $('.woocommerce-ordering').html();
   $('.woocommerce-ordering').replaceWith('<div class="woocommerce-ordering">' + _order + '</div>');
}

// Filter by ORDER BY
$('body').on('change', 'select[name="orderby"]', function() {
    if ($('.nasa-has-filter-ajax').length <= 0) {
        $(this).parents('form').submit();
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.nasa-value-gets input[name="orderby"]').remove();
            
            var _this = $('.current-tax-item > .nasa-filter-by-tax'),
                _order = $(this).val(),
                _page = false,
                _taxid = null,
                _taxonomy = '',
                _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();

            if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                _taxid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_set_variations($, [], []);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }
            
            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';
            
            _scroll_to_top = false;
            nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
        }

        return false;
    }
});

// Filter by Paging
$('body').on('click', '.nasa-pagination-ajax .page-numbers', function() {
    if ($(this).hasClass('nasa-current')) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            var _this = $('.current-tax-item > .nasa-filter-by-tax'),
                _order = $('select[name="orderby"]').val(),
                _page = $(this).attr('data-page'),
                _taxid = null,
                _taxonomy = '',
                _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();
            if (_page === '1') {
                _page = false;
            }
            if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                _taxid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_set_variations($, [], []);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }
            
            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            _scroll_to_top = true;
            nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
        }

        return false;
    }
});

// Filter by Loadmore
$('body').on('click', '.nasa-archive-loadmore', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            $(this).addClass('nasa-disabled');
            archive_page = archive_page + 1;
            
            var _this = $('.current-tax-item > .nasa-filter-by-tax'),
                _order = $('select[name="orderby"]').val(),
                _page = archive_page,
                _taxid = null,
                _taxonomy = '',
                _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();
            
            if (_page == 1) {
                _page = false;
            }
            
            if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                _taxid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_set_variations($, [], []);
            
            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }
            
            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            _scroll_to_top = false;
            nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, true);
        }

        return false;
    }
});

// Filter by variations
$('body').on('click', '.nasa-filter-by-variations', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.nasa-value-gets input[name^="filter_"]').remove();
            $('.nasa-value-gets input[name^="query_type_"]').remove();
            
            var _this = $('.current-tax-item > .nasa-filter-by-tax'),
                _current = $(this),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _taxid = null,
                _taxonomy = '',
                _url = $(_current).attr('href');
            
            var _variations = nasa_set_variations($, [], [], _current);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }
            
            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            _scroll_to_top = false;
            nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false);
        }

        return false;
    }
});

/**
 * Filter By Status
 */
$('body').on('click', '.nasa-filter-status', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
                
            var _this = $(this),
                _taxid = null,
                _taxonomy = '',
                _order = $('select[name="orderby"]').val(),
                _url = $(_this).attr('href'),
                _page = false,
                _data_status = $(_this).attr('data-filter');
            
            if ($('.nasa-value-gets input[name="' + _data_status + '"]').length) {
                $('.nasa-value-gets input[name="' + _data_status + '"]').remove();
            }

            $(_this).toggleClass('nasa-active');

            var _variations = nasa_set_variations($, [], []);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }

            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';
            _scroll_to_top = false;
            nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false);
        }

        return false;
    }
});

/**
 * Filter By Multi Tags
 */
$('body').on('click', '.nasa-filter-tag', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
                
            var _this = $(this),
                _taxid = null,
                _taxonomy = '',
                _order = $('select[name="orderby"]').val(),
                _url = $(_this).attr('href'),
                _page = false;
            
            if ($('.nasa-value-gets input[name="product-tags"]').length) {
                $('.nasa-value-gets input[name="product-tags"]').remove();
            }

            $(_this).toggleClass('nasa-active');

            var _variations = nasa_set_variations($, [], []);

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1') {
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            } else {
                hasPrice = '0';
                if ($('input[name="min-price-list"]').length) {
                    min = parseFloat($('input[name="min-price-list"]').val());
                    hasPrice = '1';
                }
                if ($('input[name="max-price-list"]').length) {
                    max = parseFloat($('input[name="max-price-list"]').val());
                    hasPrice = '1';
                }
            }

            if (min !== null && max !== null) {
                if (min < 0) {
                    min = 0;
                }
                if (max < min) {
                    max = min;
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';
            _scroll_to_top = false;
            nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false);
        }

        return false;
    }
});

// Back url with Ajax Call
$(window).on('popstate', function() {
    if ($('.nasa-has-filter-ajax').length) {
        location.reload(true);
    }
});

/* End Document Ready */
});

/**
 * Functions
 */
/**
 * Shop Ajax
 * 
 * @param {type} $
 * @param {type} _url
 * @param {type} _page
 * @param {type} _taxid
 * @param {type} _order
 * @param {type} _variations
 * @param {type} _hasPrice
 * @param {type} _min
 * @param {type} _max
 * @param {type} _hasSearch
 * @param {type} _s
 * @param {type} _this
 * @param {type} _taxonomy
 * @param {type} loadMore
 * @returns {undefined}
 */
function nasa_ajax_filter($, _url, _page, _taxid, _order, _variations, _hasPrice, _min, _max, _hasSearch, _s, _this, _taxonomy, loadMore, buildUrl, reset) {
    var _reset = typeof reset === 'undefined' ? false : reset;
    var _more = typeof loadMore === 'undefined' ? false : loadMore;
    var _style_loadmore = $('#nasa-wrap-archive-loadmore').length ? true : false;
    var _scroll_loadmore = false;
    if (_style_loadmore && $('#nasa-wrap-archive-loadmore').hasClass('nasa-infinite-shop')) {
        _scroll_loadmore = true;
    }
    
    var _push_cat_show = $('.nasa-push-cat-filter.nasa-push-cat-show').length ? '1' : '0';
    if (_push_cat_show === '1' && $('.nasa-check-reponsive.nasa-mobile-check').length && $('.nasa-check-reponsive.nasa-mobile-check').width()) {
        _push_cat_show = '0';
    }
    
    var _data = _push_cat_show === '1' ? {
        'categories-filter-show': _push_cat_show
    } : {};
    
    if ($('input[name="categories-filter-show"]').length) {
        $('input[name="categories-filter-show"]').remove();
    }
    
    var _paging_style = false;
    if (_more || _style_loadmore || $('input[name="nasa_loadmore_style"]').length) {
        _paging_style = $('input[name="nasa_loadmore_style"]').length ? $('input[name="nasa_loadmore_style"]').val() : '';
    }
    
    /**
     * Built URL
     */
    if (_url === '' && $('input[name="nasa_current-slug"]').length) {
        _url = $('input[name="nasa_current-slug"]').val();
    }
    $('#nasa-hidden-current-tax').attr({
        'href': _url,
        'data-id': _taxid,
        'data-taxonomy': _taxonomy
    });
    
    buildUrl = typeof buildUrl === 'undefined' ? true : buildUrl;
    var _h = false;
    
    if (buildUrl) {
        if (_url === '') {
            if (_hasSearch === 0) {
                _url = $('input[name="nasa-shop-page-url"]').val();
            } else if (_hasSearch === 1) {
                _url = $('input[name="nasa-base-url"]').val();
            }
        }

        if (_hasSearch != 1) {
            var patt = /\?/g;
            _h = patt.test(_url);
        }
        
        var pagestring = '';
        var _friendly = $('input[name="nasa-friendly-url"]').length === 1 && $('input[name="nasa-friendly-url"]').val() === '1' ? true : false;
        
        /**
         * Page request
         */
        if (_page) {
            if (_hasSearch == 1 || !_friendly) {
                pagestring = 'paged=' + _page;
            } else {
                // Paging change (friendly Url)
                var lenUrl = _url.length;
                _url += (_url.length && _url.substring(lenUrl - 1, lenUrl) !== '/') ? '/' : '';
                _url += 'page/' + _page + '/';
            }
        }
        
        $('.nasa-value-gets input[name="paged"]').remove();
        
        /**
         * Nasa Custom Categories
         */
        if (!_reset) {
            var _custom_cat = null;
            if ($('input.nasa-custom-cat').length && $('input.nasa-custom-cat').val()) {
                _custom_cat = $('input.nasa-custom-cat').attr('name');
                var _val = encodeURI($('input.nasa-custom-cat').val());
                _url = _url.replace('&' + _custom_cat + '=' + _val, '');
                _url = _url.replace('&' + _custom_cat + '=' + _val, '');
                _url += _h ? '&' : '?';
                _url += _custom_cat + '=' + _val;
                _h = true;

                $('.nasa-value-gets input[name="' + _custom_cat + '"]').remove();
            }
        }

        // Search change
        if (_hasSearch == 1) {
            _url += _h ? '&' : '?';
            _url += 's=' + encodeURI(_s) + '&post_type=product';
            
            _h = true;
            
            $('.nasa-value-gets input[name="s"]').remove();
            $('.nasa-value-gets input[name="page"]').remove();
            $('.nasa-value-gets input[name="post_type"]').remove();
        } else {
            if ($('.nasa-results-blog-search').length) {
                $('.nasa-results-blog-search').remove();
            }
            if ($('input[name="hasSearch"]').length) {
                $('input[name="hasSearch"]').remove();
            }
        }

        // Variations change
        if (_variations.length) {
            var l = _variations.length;
            
            for (var i = 0; i < l; i++) {
                var _qtype = (_variations[i].type === 'or') ? '&query_type_' + _variations[i].taxonomy + '=' + _variations[i].type : '';
                _url += _h ? '&' : '?';
                _url += 'filter_' + _variations[i].taxonomy + '=' + (_variations[i].slug).toString() + _qtype;
                _h = true;
            }
            
            $('.nasa-value-gets input[name^="filter_"]').remove();
            $('.nasa-value-gets input[name^="query_type_"]').remove();
        }

        // Price change
        if (_hasPrice == 1) {
            _url += _h ? '&' : '?';
            _min = _min ? _min : 0;
            _max = _max ? _max : _min;
            _url += 'min_price=' + _min + '&max_price=' + _max;
            
            _h = true;
            
            $('.nasa-value-gets input[name="min_price"]').remove();
            $('.nasa-value-gets input[name="max_price"]').remove();
        }
        
        // Status
        if ($('.nasa-filter-status.nasa-active').length) {
            $('.nasa-filter-status.nasa-active').each(function() {
                var _data_status = $(this).attr('data-filter');
                _url += _h ? '&' : '?';
                _url += _data_status + '=1';
                _h = true;
                
                $('.nasa-value-gets input[name="' + _data_status + '"]').remove();
            });
        }
        
        // multi tags
        if ($('.nasa-filter-tag.nasa-active').length) {
            _url += _h ? '&' : '?';
            _h = true;
            _url += 'product-tags=';
            
            var _values_filter = '';
            var _f = 0;
            $('.nasa-filter-tag.nasa-active').each(function() {
                var _data_filter = $(this).attr('data-filter');
                _values_filter += _f === 0 ? _data_filter : '%2C' + _data_filter;
                _f++;
            });
            
            _url += _values_filter;
            
            $('.nasa-value-gets input[name="product-tags"]').remove();
        }

        // Order change
        if (_order) {
            var _dfSort = $('input[name="nasa_default_sort"]').val();
            if (_order !== _dfSort) {
                _url += _h ? '&' : '?';
                _url += 'orderby=' + _order;
                _h = true;
            }
            
            $('.nasa-value-gets input[name="orderby"]').remove();
        }

        // Get Sidebar
        if ($('input[name="nasa_getSidebar"]').length === 1) {
            var _sidebar = $('input[name="nasa_getSidebar"]').val();
            _url += _h ? '&' : '?';
            _url += 'sidebar=' + _sidebar;
            _h = true;
            
            $('.nasa-value-gets input[name="sidebar"]').remove();
        }
        
        /**
         * Paged with not friendly URL
         */
        if (pagestring !== '') {
            _url += _h ? '&' : '?';
            _url += pagestring;
        }
    } else {
        $('.nasa-value-gets').remove();
    }
    
    if (_paging_style && _paging_style !== '') {
        if (!_h && _url) {
            var patt2 = /\?/g;
            _h = patt2.test(_url);
        }
        
        _url += _h ? '&' : '?';
        _url += 'paging-style=' + _paging_style;
        _h = true;
        
        $('.nasa-value-gets input[name="paging-style"]').remove();
    }
    
    if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
        $('.nasa-value-gets').find('input').each(function() {
            var _key = $(this).attr('name');
            var _val = $(this).val();
            _data[_key] = _val;
        });
    }
    
    var _pos_top_2 = 0;
    if ($('.nasa-top-sidebar-2.nasa-slick-slider .slick-current').length) {
        _pos_top_2 = $('.nasa-top-sidebar-2.nasa-slick-slider .slick-current').attr('data-slick-index');
    }
    
    if ($('.wcfmmp-product-geolocate-search-form').length) {
        window.location.href = _url;
    } else {
        var $crazy_load = $('#nasa-ajax-store').length && $('#nasa-ajax-store').hasClass('nasa-crazy-load') && $('.nasa-archive-loadmore').length <= 0 ? true : false;
        
        $.ajax({
            url: _url,
            type: 'get',
            dataType: 'html',
            data: _data,
            cache: true,
            beforeSend: function() {
                $('body').trigger('nasa_before_load_ajax');
                
                if (!$crazy_load) {
                    if (!_scroll_loadmore && !_more) {
                        $('.nasa-content-page-products').append('<div class="opacity-shop"></div>');
                    } else {
                        if ($('#nasa-wrap-archive-loadmore').length && $('#nasa-wrap-archive-loadmore').find('.nasa-loader').length <= 0) {
                            $('#nasa-wrap-archive-loadmore').append('<div class="nasa-loader"></div>');
                        }
                    }
                } else {
                    if (!$('#nasa-ajax-store').hasClass('crazy-loading')) {
                        $('#nasa-ajax-store').addClass('crazy-loading');
                    }
                }

                if ($('.nasa-progress-bar-load-shop').length === 1) {
                    $('.nasa-progress-bar-load-shop .nasa-progress-per').removeClass('nasa-loaded');
                    $('.nasa-progress-bar-load-shop').addClass('nasa-loading');
                }

                if ($('.col-sidebar').length) {
                    $('.col-sidebar').append('<div class="opacity-2"></div>');
                    $('.black-window').trigger('click');
                }

                $('.nasa-filter-by-tax').addClass('nasa-disable').removeClass('nasa-active');

                if ($(_this).parents('ul.children').length) {
                    $(_this).parents('ul.children').show();
                }

                var _totop = _scroll_to_top;
                _scroll_to_top = false;
                if (_totop && ($('.category-page').length || $('.nasa-content-page-products').length)) {
                    var _pos_obj = $('.category-page').length ? $('.category-page') : $('.nasa-content-page-products');
                    animate_scroll_to_top($, _pos_obj, 700);
                }
            },
            success: function (res) {
                var _act_widget = $('.nasa-top-row-filter li.nasa-active > a');

                var _act_widget_2 = false;
                if ($('.nasa-toggle-top-bar-click').length) {
                    _act_widget_2 = $('.nasa-toggle-top-bar-click').hasClass('nasa-active') ? true : false;
                }

                var $html = $.parseHTML(res);

                var $mainContent = $('#nasa-ajax-store', $html);

                /**
                 * 
                 * @type Load Paging
                 */
                if (!_more) {
                    if ($('#header-content').length) {
                        /**
                         * Replace Header
                         */
                        var $headContent = $('#header-content', $html);
                        $('#header-content').replaceWith($headContent);
                    } else if ($('#nasa-breadcrumb-site').length) {
                        /**
                         * Replace Breadcrumb
                         */
                        var $breadcrumb = $('#nasa-breadcrumb-site', $html);
                        $('#nasa-breadcrumb-site').replaceWith($breadcrumb);
                    }
                    
                    /**
                     * Replace Archive
                     */
                    $('#nasa-ajax-store').replaceWith($mainContent);
                    
                    /**
                     * Replace Footer
                     */
                    if ($('#nasa-footer').length) {
                        var $footContent = $('#nasa-footer', $html);
                        $('#nasa-footer').replaceWith($footContent);
                    }
                    
                    if ($('#nasa-mobile-cat-filter').length) {
                        var _top_filter = $('#nasa-mobile-cat-filter', $html);
                        $('#nasa-mobile-cat-filter').replaceWith(_top_filter);
                    }
                    
                    archive_page = 1;
                }

                /**
                 * 
                 * @type Load More
                 */
                else {
                    _eventMore = true;
                    var _append_content = $($mainContent).find('.nasa-content-page-products ul.products').html();

                    if ($('#nasa-ajax-store').find('.nasa-products-masonry-isotope').length && $('.nasa-products-masonry-isotope ul.products.grid').length) {
                        $('body').trigger('nasa_store_insert_content_isotope', [_append_content]);
                    } else {
                        $('#nasa-ajax-store').find('.nasa-content-page-products ul.products').append(_append_content);
                    }

                    var $moreBtn = $('#nasa-wrap-archive-loadmore', $html);
                    $('#nasa-wrap-archive-loadmore').replaceWith($moreBtn);

                    if ($('.nasa-content-page-products').find('.opacity-shop').length) {
                        $('.nasa-content-page-products').find('.opacity-shop').remove();
                    }

                    if ($('.col-sidebar').length && $('.col-sidebar').find('.opacity-2').length) {
                        $('.col-sidebar').find('.opacity-2').remove();
                    }

                    if ($('.nasa-progress-bar-load-shop').length) {
                        $('.nasa-progress-bar-load-shop').removeClass('nasa-loading');
                    }

                    if ($('#nasa-wrap-archive-loadmore').length && $('#nasa-wrap-archive-loadmore').find('.nasa-loader').length) {
                        $('#nasa-wrap-archive-loadmore').find('.nasa-loader').remove();
                    }
                }

                $('.nasa-filter-by-tax').removeClass('nasa-disable');

                if (_more && $('.woocommerce-result-count').length) {
                    $('.woocommerce-result-count').html($(res).find('.woocommerce-result-count').html());
                }

                /**
                 * Build Actived Filter
                 */
                if ($('.nasa-products-page-wrap').length) {
                    if ($('.nasa-products-page-wrap .nasa-actived-filter').length <= 0) {
                        $('.nasa-products-page-wrap').prepend('<div class="nasa-actived-filter hidden-tag"></div>');
                    }

                    var _actived_filter = get_top_filter_actived($);
                    if (_actived_filter) {
                        $('.nasa-actived-filter').replaceWith(_actived_filter);
                    }
                }

                /**
                 * Re-build Top Sidebar Type 1
                 */
                if ($('.nasa-top-sidebar').length && !_more) {
                    init_nasa_top_sidebar($);

                    if ($(_act_widget).length) {
                        var _old_id = $(_act_widget).attr('data-old_id');
                        if ($('.nasa-top-row-filter li > a[data-old_id="' + _old_id + '"]').length) {
                            var _click = $('.nasa-top-row-filter li > a[data-old_id="' + _old_id + '"]');
                            top_filter_click($, _click, 'showhide');
                        } else {
                            var _key = $(_act_widget).attr('data-key');
                            if ($('.nasa-top-row-filter li > a[data-key="' + _key + '"]').length) {
                                var _click = $('.nasa-top-row-filter li > a[data-key="' + _key + '"]');
                                top_filter_click($, _click, 'showhide');
                            }
                        }
                    }
                }

                /**
                 * Re-build Top Sidebar Type 2
                 */
                if ($('.nasa-top-sidebar-2').length && !_more) {
                    if (_act_widget_2) {
                        var _click = $('.nasa-toggle-top-bar-click');
                        $('.nasa-top-bar-2-content').hide();
                        top_filter_click_2($, _click, 'showhide', _pos_top_2);
                    }
                }

                /**
                 * Reload Price Slide
                 */
                if ($('.price_slider').length && !_more) {
                    var min_price = $('.price_slider_amount #min_price').data('min'),
                        max_price = $('.price_slider_amount #max_price').data('max'),
                        current_min_price = parseInt(min_price, 10),
                        current_max_price = parseInt(max_price, 10);

                    if (_hasPrice == 1) {
                        current_min_price = _min ? _min : 0;
                        current_max_price = _max ? _max : current_min_price;
                    }

                    $('.price_slider').slider({
                        range: true,
                        animate: true,
                        min: min_price,
                        max: max_price,
                        values: [current_min_price, current_max_price],
                        create: function() {
                            $('.price_slider_amount #min_price').val(current_min_price);
                            $('.price_slider_amount #max_price').val(current_max_price);
                            $(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
                        },
                        slide: function(event, ui) {
                            $('input#min_price').val(ui.values[0]);
                            $('input#max_price').val(ui.values[1]);

                            $(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
                        },
                        change: function(event, ui) {
                            $(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
                        }
                    });

                    if (_hasPrice == 1) {
                        $('.reset_price').attr('data-has_price', "1").show();
                        if ($('.price_slider_wrapper').find('button').length) {
                            $('.price_slider_wrapper').find('button').show();
                        }
                    }

                    $('.price_slider, .price_label').show();
                }

                var _destroy_masonry = false;
                $('body').trigger('nasa_after_loaded_ajax_complete', [_destroy_masonry]);

                shop_load = false;
                infinitiAjax = false;
                
                /**
                 * Run _queue_trigger
                 */
                $('body').trigger('nasa_after_shop_load_status', [_queue_trigger]);

                /**
                 * 
                 * Title Page
                 */
                var matches = res.match(/<title>(.*?)<\/title>/);
                var _title = typeof matches[1] !== 'undefined' ? matches[1] : '';
                if (_title) {
                    $('title').html(_title);
                }
                
                $('#nasa-ajax-store').removeClass('crazy-loading');
                
                /**
                 * Fix lazy load
                 */
                setTimeout(function() {
                    if ($('img[data-lazy-src]').length) {
                        $('img[data-lazy-src]').each(function() {
                            var _this = $(this);
                            var _src_real = $(_this).attr('data-lazy-src');
                            var _srcset = $(_this).attr('data-lazy-srcset');
                            var _size = $(_this).attr('data-lazy-sizes');
                            $(_this).attr('src', _src_real);
                            $(_this).removeAttr('data-lazy-src');

                            if (_srcset) {
                                $(_this).attr('srcset', _srcset);
                                $(_this).removeAttr('data-lazy-srcset');
                            }

                            if (_size) {
                                $(_this).attr('sizes', _size);
                                $(_this).removeAttr('data-lazy-sizes');
                            }
                        });
                    }
                }, 100);
            },
            error: function () {
                $('.opacity-2').remove();
                $('.nasa-filter-by-tax').removeClass('nasa-disable');
                $('#nasa-ajax-store').removeClass('crazy-loading');

                shop_load = false;
                infinitiAjax = false;
            }
        });

        if (!_more) {
            window.history.pushState(_url, '', _url);
        }
    }
}

/**
 * Set variaions
 * 
 * @param {type} $
 * @param {type} variations
 * @param {type} keys
 * @param {type} current
 * @returns {unresolved}
 */
function nasa_set_variations($, variations, keys, current) {
    var _current = typeof current !== 'undefined' ? current : null;
    if (_current) {
        var _tax = $(_current).attr('data-attr');
        var _slug = $(_current).attr('data-term_slug');
        
        if ($(_current).hasClass('nasa-filter-var-chosen')){
            $('.nasa-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').parent().removeClass('chosen nasa-chosen').show();
            $('.nasa-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').removeClass('nasa-filter-var-chosen');
        } else {
            $('.nasa-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').parent().addClass('chosen nasa-chosen');
            $('.nasa-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').addClass('nasa-filter-var-chosen');
        }
    }
    
    $('.nasa-filter-var-chosen').each(function() {
        var _attr = $(this).attr('data-attr'),
            _attrVal = $(this).attr('data-term_id'),
            _attrSlug = $(this).attr('data-term_slug'),
            _attrType = $(this).attr('data-type');
        var l = variations.length;
        if (keys.indexOf(_attr) === -1) {
            variations.push({
                taxonomy: _attr,
                values: [_attrVal],
                slug: [_attrSlug],
                type: _attrType
            });
            keys.push(_attr);
        } else {
            for (var i = 0; i < l; i++) {
                if (variations[i].taxonomy.length && variations[i].taxonomy === _attr) {
                    if ((variations[i].slug).indexOf(_attrSlug) === -1) {
                        variations[i].values.push(_attrVal);
                        variations[i].slug.push(_attrSlug);
                        break;
                    }
                }
            }
        }
    });

    return variations;
}

/**
 * _act_content
 * @param {type} $
 * @returns {String}
 */
function get_top_filter_actived($) {
    var _act_content = '<div class="nasa-actived-filter">';
    var _hasActive = false;
    
    if ($('.nasa-widget-has-active').length) {
        $('.nasa-widget-has-active').each(function() {
            var _this = $(this);
            var _title = $(_this).find('.widget-title').length ? $(_this).find('.widget-title').html() : '';
            
            // variations
            var _widget_act = $(_this).find('.nasa-filter-var-chosen').length ? true : false;
            if (_widget_act) {
                _hasActive = true;
                
                _act_content += '<div class="nasa-wrap-active-top">';
                _act_content += _title ? '<span class="nasa-active-title">' + _title + '</span>' : '';
                
                $(_this).find('.nasa-filter-var-chosen').each(function() {
                    var term_id = $(this).attr('data-term_id');
                    var term_slug = $(this).attr('data-term_slug');
                    var _attr = $(this).attr('data-attr');
                    var _type = $(this).attr('data-type');
                    
                    var _class_item = 'nasa-ignore-variation-item';
                    _class_item += $(this).hasClass('nasa-filter-color') ? ' nasa-ignore-color-item' : '';
                    _class_item += $(this).hasClass('nasa-filter-image') ? ' nasa-ignore-image-item' : '';
                    _class_item += $(this).hasClass('nasa-filter-brand-item') ? ' nasa-ignore-brand-item' : '';
                    
                    var _item = '<a href="javascript:void(0);" class="' + _class_item + '" data-term_id="' + term_id + '" data-term_slug="' + term_slug + '" data-attr="' + _attr + '" data-type="' + _type + '">' + $(this).html() + '</a>';
                    _act_content += '<span class="nasa-active-item">' + _item + '</span>';
                });
                
                _act_content += '</div>';
            }
            
            // Filter Status
            var _filter_act = $(_this).find('.nasa-filter-status.nasa-active').length ? true : false;
            if (_filter_act) {
                _hasActive = true;

                _act_content += '<div class="nasa-wrap-active-top">';
                _act_content += _title ? '<span class="nasa-active-title">' + _title + '</span>' : '';
                
                $(_this).find('.nasa-filter-status.nasa-active').each(function() {
                    var _href = $(this).attr('href');
                    var _data_filter = $(this).attr('data-filter');
                    
                    var _item = '<a href="' + _href + '" class="nasa-ignore-filter-global nasa-filter-status nasa-ignore-filter-status" data-filter="' + _data_filter + '">' + $(this).html() + '</a>';
                    
                    _act_content += '<span class="nasa-active-item">' + _item + '</span>';
                });

                _act_content += '</div>';
            }
            
            // Nasa Price Slide
            var _price_act = $(_this).find('.nasa_hasPrice[name="nasa_hasPrice"]').length ? true : false;
            if (_price_act && $(_this).find('.nasa_hasPrice[name="nasa_hasPrice"]').val() === '1') {
                _hasActive = true;
                
                var _price_label = '';
                if ($(_this).find('.price_label .from').length) {
                    _price_label += $(_this).find('.price_label .from').html();
                }
                
                if ($(_this).find('.price_label .to').length) {
                    _price_label += _price_label !== '' ? ' &mdash; ' : '';
                    _price_label += $(_this).find('.price_label .to').html();
                }
                
                var _class_price = _price_label !== '' ? 'nasa-wrap-active-top' : 'nasa-price-active-init hidden-tag';
                
                _act_content += '<div class="' + _class_price + '">';
                
                if (_price_label !== '') {
                    _act_content += _title ? '<span class="nasa-active-title">' + _title + '</span>' : '';

                    var _item = '<a href="javascript:void(0);" class="nasa-ignore-price-item">' + _price_label + '</a>';
                    _act_content += '<span class="nasa-active-item">' + _item + '</span>';
                }
                
                _act_content += '</div>';
            }
            
            // Filter List
            if ($(_this).find('.nasa-price-filter-list .nasa-active').length) {
                
                var _active_price_list = $(_this).find('.nasa-price-filter-list .nasa-active');
                
                if (!$(_active_price_list).hasClass('nasa-all-price')) {
                    _hasActive = true;

                    _act_content += '<div class="nasa-wrap-active-top">';

                    var _price_label = $(_this).find('.nasa-price-filter-list .nasa-active').find('.nasa-filter-price-text').html();

                    _act_content += _title ? '<span class="nasa-active-title">' + _title + '</span>' : '';

                    var _item = '<a href="javascript:void(0);" class="nasa-ignore-price-item-list">' + _price_label + '</a>';
                    _act_content += '<span class="nasa-active-item">' + _item + '</span>';

                    _act_content += '</div>';
                }
            }
            
            // Filter Tags
            if ($(_this).find('.nasa-filter-tag.nasa-active').length) {
                _hasActive = true;

                _act_content += '<div class="nasa-wrap-active-top">';
                _act_content += _title ? '<span class="nasa-active-title">' + _title + '</span>' : '';
                
                $(_this).find('.nasa-filter-tag.nasa-active').each(function() {
                    var _href = $(this).attr('href');
                    var _data_filter = $(this).attr('data-filter');
                    
                    var _item = '<a href="' + _href + '" class="nasa-ignore-filter-global nasa-filter-tag nasa-ignore-filter-tags" data-filter="' + _data_filter + '">' + $(this).html() + '</a>';
                    
                    _act_content += '<span class="nasa-active-item">' + _item + '</span>';
                });

                _act_content += '</div>';
            }
        });
    }
    
    // Reset btn
    if (_hasActive && $('.nasa-widget-has-active .nasa-reset-filters-btn').length) {
        _act_content += '<div class="nasa-wrap-active-top">';
        
        $('.nasa-widget-has-active .nasa-reset-filters-btn').addClass('nasa-reset-filters-top');
        $('.nasa-widget-has-active .nasa-reset-filters-btn').wrap('<div class="nasa-reset-filters-btn-wrap"></div>');
        
        var _reset_text = $('.nasa-widget-has-active .nasa-reset-filters-btn-wrap').html();
        _act_content += _reset_text;
        _act_content += '</div>';
    }
    
    _act_content += '</div>';
    
    return _hasActive ? _act_content : '';
}

/**
 * Check have items active filter topbar type 1
 * @param {type} $
 * @param {type} _widget
 * @returns {Boolean}
 */
function active_topbar_check($, _widget) {
    if (
        $(_widget).find('.nasa-act-filter-item').length ||
        $(_widget).find('.nasa-filter-var-chosen').length ||
        $(_widget).find('.nasa-filter-status.nasa-active').length ||
        $(_widget).find('.nasa-price-filter-list .nasa-active').length ||
        $(_widget).find('.nasa-filter-tag.nasa-active').length ||
        ($(_widget).find('input[name="nasa_hasPrice"]').length && $(_widget).find('input[name="nasa_hasPrice"]').val() === '1')
    ) {
        return true;
    }
    
    return false;
}

/**
 * Active Topbar
 * @param {type} $
 * @returns {undefined}
 */
function load_active_topbar($) {
    if ($('.nasa-tab-filter-topbar').length) {
        $('.nasa-tab-filter-topbar').each(function() {
            var _this = $(this);
            var _widget = $(_this).attr('data-widget');
            if ($(_widget).length) {
                if (active_topbar_check($, _widget)) {
                    if (!$(_this).hasClass('nasa-active')) {
                        $(_this).addClass('nasa-active');
                    }
                } else {
                    $(_this).removeClass('nasa-active');
                }
            }
        });
    }
    
    $('.nasa-tranparent-filter').trigger('click');
    $('.transparent-mobile').trigger('click');
}

/**
 * Toggle Sidebar classic
 * @param {type} $
 * @returns {undefined}
 */
function load_toggle_sidebar_classic($) {
    if ($('.nasa-with-sidebar-classic').length && $('.nasa-toogle-sidebar-classic').length) {
        var toggle_show = $.cookie('toggle_sidebar_classic');
        if (toggle_show === 'hide') {
            $('.nasa-toogle-sidebar-classic').addClass('nasa-hide');
            $('.nasa-with-sidebar-classic').addClass('nasa-with-sidebar-hide');
        } else {
            $('.nasa-toogle-sidebar-classic').removeClass('nasa-hide');
            $('.nasa-with-sidebar-classic').removeClass('nasa-with-sidebar-hide');
        }

        setTimeout(function() {
            $('body').trigger('nasa_after_toggle_sidebar_classic_timeout');
        }, 500);
    }
    
    if ($('.nasa-with-sidebar-classic').length) {
        if ($('.nasa-with-sidebar-classic .nasa-filter-wrap > .columns').length && $('.nasa-with-sidebar-classic .col-sidebar.right').length) {
            $('.nasa-with-sidebar-classic .nasa-filter-wrap > .columns').each(function() {
                if (!$(this).hasClass('right')) {
                    $(this).addClass('right');
                }
            });
        }
        
        if (!$('.nasa-with-sidebar-classic').hasClass('nasa-inited')) {
            $('.nasa-with-sidebar-classic').addClass('nasa-inited');
        }
    }
}

/**
 * Render top bar shop page
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_nasa_top_sidebar($) {
    if ($('.nasa-top-sidebar').length) {
        
        $('body').trigger('before_init_nasa_topsidebar');
        
        var wk = 0;

        var top_row = '<ul class="nasa-top-row-filter">';

        if ($('input[name="nasa-labels-filter-text"]').length && $('input[name="nasa-labels-filter-text"]').val() !== '') {
            top_row += '<li><span class="nasa-labels-filter-text">' + $('input[name="nasa-labels-filter-text"]').val() + '</span></li>';
        }

        var rows = '';
        if ($('.nasa-top-sidebar').find('.nasa-close-sidebar-wrap').length) {
            rows += $('.nasa-top-sidebar').find('.nasa-close-sidebar-wrap').html();
        }
        rows += '<div class="row nasa-show nasa-top-sidebar-off-canvas">';
        var _title, _rss;
        var _stt = 1;
        var _limit = $('input[name="nasa-limit-widgets-show-more"]').length ? parseInt($('input[name="nasa-limit-widgets-show-more"]').val()) : false;
        _limit = (!_limit || _limit < 0) ? 999999 : _limit;
        var _show_more = false;
        
        $('.nasa-top-sidebar').find('>.widget').each(function() {
            var _this = $(this);
            
            var _widget_act = active_topbar_check($, _this);

            var _class_act = _widget_act ? ' nasa-active' : '';
            
            if ($(_this).find('.widget-title').length) {
                _title = $(_this).find('.widget-title').html();
                _rss = '';
                if ($(_this).find('.widget-title').find('a').length) {
                    _title = '';
                    $(_this).find('.widget-title').find('a').each(function() {
                        if ($(this).find('img').length) {
                            _rss += $(this).html();
                        } else {
                            _title += $(this).html();
                        }
                    });
                }
            } else {
                _title = '...';
            }

            var _widget_key = 'nasa-widget-key-' + wk.toString();
            var _old_id = $(_this).attr('id');
            var _class_row = '';
            var _filter_push_cat = false;

            var _li_class = _stt <= _limit ? ' nasa-widget-show' : ' nasa-widget-show-less';

            if ($(_this).find('.nasa-widget-filter-cats-topbar').length) {
                if ($('.nasa-push-cat-filter').length === 1) {
                    _filter_push_cat = true;
                    _class_act += ' nasa-tab-push-cats';
                    _li_class += ' nasa-widget-categories';
                    $('.nasa-push-cat-filter').html($(_this).wrap('<div>').parent().html());
                } else {
                    _class_act += ' nasa-tab-filter-cats';
                    _class_row += ' nasa-widget-cat-wrap';
                }
            }

            var _icon_before = _filter_push_cat ? '<i class="pe-7s-note2"></i>' : '';
            var _icon_after = !_filter_push_cat ? '<i class="pe-7s-angle-down"></i>' : '';

            var _reset_btn = $(_this).find('.nasa-reset-filters-btn').length ? true : false;
            if (_reset_btn) {
                _li_class += ' nasa-widget-reset-filter nasa-widget-has-active';
                _stt = _stt-1;
            }

            top_row += '<li class="nasa-widget-toggle' + _li_class + '">';
            if (!_reset_btn) {
                top_row += '<a class="nasa-tab-filter-topbar' + _class_act + '" href="javascript:void(0);" title="' + _title + '" data-widget="#' + _widget_key + '" data-key="' + wk + '" data-old_id="' + _old_id + '">' + _icon_before + _rss + _title + _icon_after + '</a>';
            }
            else {
                top_row += $(_this).find('.nasa-reset-filters-btn').wrap('<div>').parent().html();
            }
            top_row += '</li>';

            if (!_filter_push_cat && $(_this).find('.nasa-reset-filters-btn').length <= 0) {
                rows += '<div class="large-12 columns nasa-widget-wrap' + _class_row + '" id="' + _widget_key + '" data-old_id="' + _old_id + '">';
                rows += $(_this).wrap('<div>').parent().html();
                rows += '</div>';
            }

            if (_stt > _limit) {
                _show_more = true;
            }

            wk++;
            _stt++;
        });

        if (_show_more) {
            top_row += '<li class="nasa-widget-show-more">';
            top_row += '<a class="nasa-widget-toggle-show" href="javascript:void(0);" data-show="0">' + $('input[name="nasa-widget-show-more-text"]').val() + '</a>';
            top_row += '</li>';
        }

        if ($('.showing_info_top').length) {
            top_row += '<li class="last">';
            top_row += '<div class="showing_info_top">';
            top_row += $('.showing_info_top').html();
            top_row += '</div></li>';
        }

        top_row += '</ul>';
        rows += '</div>';
        
        $('.nasa-top-sidebar').html(rows).removeClass('hidden-tag');
        $('.nasa-labels-filter-accordion').html(top_row);
        $('.nasa-labels-filter-accordion').addClass('nasa-inited');

        /**
         * Show | Hide price filter
         */
        if ($('.nasa-top-sidebar .nasa-filter-price-widget-wrap').length) {
            $('.nasa-top-sidebar .nasa-filter-price-widget-wrap').each(function() {
                var _wrap_price_hide = $(this).parents('.nasa-widget-wrap');
                
                if ($(this).hasClass('nasa-hide-price')) {
                    if ($(_wrap_price_hide).length) {
                        var _tabtop = $(_wrap_price_hide).attr('id');
                        if ($('.nasa-tab-filter-topbar[data-widget="#' + _tabtop + '"]').parents('.nasa-widget-toggle').length) {
                            $('.nasa-tab-filter-topbar[data-widget="#' + _tabtop + '"]').parents('.nasa-widget-toggle').hide();
                        }
                        
                        $(_wrap_price_hide).addClass('hidden-tag');
                    }
                }
            });
        }
    }
}

/**
 * Click top filter
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} type
 * @returns {undefined}
 */
function top_filter_click($, _this, type) {
    if (!$(_this).hasClass('nasa-tab-push-cats')) {
        var _obj = $(_this).attr('data-widget');
        var _wrap_content = $('.nasa-top-sidebar');

        var _act = $(_obj).hasClass('nasa-active') ? true : false;
        $(_this).parents('.nasa-top-row-filter').find('> li').removeClass('nasa-active');
        $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').slideUp(350);
        if (type === 'animate') {
            $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').slideUp(350);
        } else {
            $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').hide();
        }

        if (!_act) {
            if (type === 'animate') {
                $(_obj).addClass('nasa-active').slideDown(350);
            } else {
                $(_obj).addClass('nasa-active').show();
            }
            $(_this).parents('li').addClass('nasa-active');
        }

        if ($(_this).hasClass('nasa-tab-filter-cats')) {
            $('body').trigger('nasa_init_topbar_categories');
        }
    } else {
        $(_this).toggleClass('nasa-push-cat-show');
        $('.nasa-push-cat-filter').toggleClass('nasa-push-cat-show');
        $('.nasa-products-page-wrap').toggleClass('nasa-push-cat-show');
        $('.black-window-mobile').toggleClass('nasa-push-cat-show');
        
        setTimeout(function() {
            $('body').trigger('nasa_after_push_cats_timeout');
        }, 1000);
    }
}

/**
 * Render top bar 2 shop page
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_nasa_top_sidebar_2($, _start) {
    var start = typeof _start !== 'undefined' && _start ? _start : false;
    
    if ($('.nasa-top-sidebar-2').length) {
        var _wrap = $('.nasa-top-sidebar-2');
        
        if (!$(_wrap).hasClass('nasa-slick-slider')) {
            $(_wrap).addClass('nasa-slick-slider');
            $(_wrap).addClass('nasa-slick-nav');
        }
        
        $(_wrap).attr('data-autoplay', 'false');
        $(_wrap).attr('data-switch-custom', '480');
        
        var _width = $(window).width();
        var _tab = parseInt($(_wrap).attr('data-switch-tablet'));
        var _desk = parseInt($(_wrap).attr('data-switch-desktop'));
        _tab = !_tab ? 768 : _tab;
        _desk = !_desk ? 1130 : _desk;
        
        var _cols = parseInt($(_wrap).attr('data-columns'));
        var _cols_tab = parseInt($(_wrap).attr('data-columns-tablet'));
        var _cols_small = parseInt($(_wrap).attr('data-columns-small'));
        
        _cols = !_cols ? 4 : _cols;
        _cols_tab = !_cols_tab ? 3 : _cols_tab;
        _cols_small = !_cols_small ? 2 : _cols_small;
        
        var _count = $(_wrap).find('.nasa-widget-store').length;
        
        /**
         * Check start in Desktop
         */
        if (_width >= _desk && _count <= _cols) {
            start = 0;
        }
        
        /**
         * Check start in Tablet
         */
        if (_width < _desk && _width >= _cols_tab && _count <= _cols_tab) {
            start = 0;
        }
        
        /**
         * Check start in Mobile
         */
        if (_width < _cols_tab && _count <= _cols_small) {
            start = 0;
        }
        
        /**
         * Set start
         */
        if (start) {
            $(_wrap).attr('data-start', start);
        }
        
        /**
         * init Slick Slider
         */
        $('body').trigger('nasa_load_slick_slider');
    }
}

/**
 * Toggle Top Side bar type 2
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} type
 * @returns {undefined}
 */
function top_filter_click_2($, _this, type, _start) {
    if ($('.nasa-top-bar-2-content').length) {
        var _act = $(_this).hasClass('nasa-active') ? true : false;
        
        if (!_act) {
            var start = typeof _start !== 'undefined' && _start ? _start : false;
            
            if (type === 'animate') {
                $('.nasa-top-bar-2-content').addClass('nasa-active').slideDown(350);
                
                setTimeout(function() {
                    init_nasa_top_sidebar_2($, start);
                }, 350);
            } else {
                $('.nasa-top-bar-2-content').addClass('nasa-active').show();
                init_nasa_top_sidebar_2($, start);
                
                setTimeout(function() {
                    $(window).trigger('resize');
                }, 10);
            }
                
            $(_this).addClass('nasa-active');
        }
        
        else {
            if (type === 'animate') {
                $('.nasa-top-bar-2-content').removeClass('nasa-active').slideUp(350);
            } else {
                $('.nasa-top-bar-2-content').removeClass('nasa-active').fadeOut(350);
            }
            
            $(_this).removeClass('nasa-active');
        }
    }
}


/**
 * Change layout Grid | List shop page
 * 
 * @param {type} $
 * @param {type} _this
 * @returns {undefined}
 */
function change_layout_shop_page($, _this) {
    var value_cookie, item_row, class_items;
    var _cookie_name = $('input[name="nasa_archive_grid_view"]').length ? $('input[name="nasa_archive_grid_view"]').val() : 'nasa_archive_grid_view';
    var _old_cookie = $.cookie(_cookie_name);
    var _destroy = _old_cookie !== 'list' ? false : true;
    if ($(_this).hasClass('productList')) {
        value_cookie = 'list';
        _destroy = true;
        $('.nasa-content-page-products .products').removeClass('grid').addClass('list');
        
        $('body').trigger('nasa_store_changed_layout_list');
    } else {
        var columns = $(_this).attr('data-columns');
        class_items = 'products grid';

        switch (columns) {
            case '2' :
                item_row = 2;
                value_cookie = 'grid-2';
                class_items += ' large-block-grid-2';
                break;
            case '3' :
                item_row = 3;
                value_cookie = 'grid-3';
                class_items += ' large-block-grid-3';
                break;
            
            case '5' :
                item_row = 5;
                value_cookie = 'grid-5';
                class_items += ' large-block-grid-5';
                break;
                
            case '6' :
                item_row = 5;
                value_cookie = 'grid-6';
                class_items += ' large-block-grid-6';
                break;
                
            case '4' :
            default :
                item_row = 4;
                value_cookie = 'grid-4';
                class_items += ' large-block-grid-4';
                break;
        }

        var count = $('.nasa-content-page-products .products').find('.product-warp-item').length;
        if (count > 0) {
            var _wrap_all = $('.nasa-content-page-products .products');
            var _col_small = $(_wrap_all).attr('data-columns_small');
            var _col_medium = $(_wrap_all).attr('data-columns_medium');
            
            switch (_col_small) {
                case '2' :
                    class_items += ' small-block-grid-2';
                    break;
                case '1' :
                default :
                    class_items += ' small-block-grid-1';
                    break;
            }
            
            switch (_col_medium) {
                case '3' :
                    class_items += ' medium-block-grid-3';
                    break;
                case '4' :
                    class_items += ' medium-block-grid-4';
                    break;
                case '2' :
                default :
                    class_items += ' medium-block-grid-2';
                    break;
            }
            
            $('.nasa-content-page-products .products').attr('class', class_items);
        }
        
        $('body').trigger('nasa_store_changed_layout_grid', [columns, class_items]);
    }

    $(".nasa-change-layout").removeClass("active");
    $(_this).addClass("active");
    $.cookie(_cookie_name, value_cookie, {expires: _cookie_live, path: '/'});
    
    $('body').trigger('nasa_before_change_view');
    
    setTimeout(function() {
        $('body').trigger('nasa_before_change_view_timeout', [_destroy]);
    }, 500);
}

/**
 * clone group btn loop products
 * 
 * @param {type} $
 * @returns {undefined}
 */
function clone_group_btns_product_item($) {
    var _list = $('.products').length && $('.products').hasClass('list') ? true : false;
    
    if (_list && $('.nasa-content-page-products .product-item').length) {
        $('.nasa-content-page-products .product-item').each(function() {
            var _wrap = $(this);
            var _this = $(_wrap).find('.nasa-btns-product-item');
            
            if (!$(_wrap).hasClass('nasa-list-cloned')) {
                $(_wrap).addClass('nasa-list-cloned');
                
                if ($(_wrap).find('.group-btn-in-list').length <= 0) {
                    $(_wrap).append('<div class="group-btn-in-list nasa-group-btns hidden-tag"></div>');
                }
                    
                var _place = $(_wrap).find('.group-btn-in-list');
                var _html = '';
                var _price = '';
                if ($(_wrap).find('.price-wrap').length) {
                    _price = $(_wrap).find('.price-wrap').html();
                } else if ($(_wrap).find('.price').length) {
                    _price = $(_wrap).find('.price').clone().wrap('<div class="price-wrap"></div>').parent().html();
                }

                _html += _price !== '' ? '<div class="price-wrap">' + _price + '</div>' : '';

                if ($(_wrap).find('.nasa-list-stock-wrap').length) {
                    _html += $(_wrap).find('.nasa-list-stock-wrap').html();
                    $(_wrap).find('.nasa-list-stock-wrap').remove();
                }
                
                if ($(_this).length && $(_place).length) {
                    _html += $(_this).html();
                    $(_place).html(_html);
                    if ($(_place).find('.btn-link').length) {
                        $(_place).find('.btn-link').each(function() {
                            if (
                                $(this).find('.nasa-icon-text').length <= 0 &&
                                $(this).find('.nasa-icon').length &&
                                $(this).attr('data-icon-text')
                            ) {
                                $(this).find('.nasa-icon').after(
                                    '<span class="nasa-icon-text">' +
                                        $(this).attr('data-icon-text') +
                                    '</span>'
                                );
                            }
                        });
                    }
                }
            }
        }); 
    }
}
