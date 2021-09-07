var doc = document.documentElement;
doc.setAttribute('data-useragent', navigator.userAgent);

var fullwidth = 1200,
    _lightbox_variations = [],
    _count_wishlist_items = 0,
    searchProducts = null,
    _nasa_cart = {};

if (typeof _cookie_live === 'undefined') {
    var _cookie_live = 7;
}
    
/* Document ready */
jQuery(document).ready(function($) {
"use strict";

/**
 * Before Load site
 */
if ($('#nasa-before-load').length) {
    $('#nasa-before-load').fadeOut(100);
    
    setTimeout(function() {
        $('#nasa-before-load').remove();
    }, 100);
}

/**
 * Site Loaded
 */
if (!$('body').hasClass('nasa-body-loaded')) {
    setTimeout(function() {
        $('body').addClass('nasa-body-loaded');
    }, 100);
}

var _hash = location.hash || null;
if (_hash) {
    if ($('a[href="' + _hash + '"], a[data-id="' + _hash + '"], a[data-target="' + _hash + '"]').length) {
        setTimeout(function() {
            $('a[href="' + _hash + '"], a[data-id="' + _hash + '"], a[data-target="' + _hash + '"]').trigger('click');
        }, 500);
    }
    
    if ($(_hash).length) {
        setTimeout(function() {
            $('body').trigger('nasa_animate_scroll_to_top', [$, _hash, 500]);
        }, 1000);
    }
}

/**
 * Off Canvas Menu
 */
$('body').on('nasa_after_load_mobile_menu', function() {
    if ($('.nasa-off-canvas').length) {
        $('.nasa-off-canvas').remove();
    }
});

/**
 * Init menu mobile
 */
$('body').on('click', '.nasa-mobile-menu_toggle', function() {
    init_menu_mobile($);
    
    if ($('#mobile-navigation').length) {
        if ($('#mobile-navigation').attr('data-show') !== '1') {
            if ($('#nasa-menu-sidebar-content').hasClass('nasa-dark')) {
                $('.black-window').addClass('nasa-transparent');
            }
            
            $('.black-window').show().addClass('desk-window');
            
            if ($('#nasa-menu-sidebar-content').length && !$('#nasa-menu-sidebar-content').hasClass('nasa-active')) {
                $('#nasa-menu-sidebar-content').addClass('nasa-active');
            }
            
            $('#mobile-navigation').attr('data-show', '1');
        } else {
            $('.black-window').trigger('click');
        }
    }
});

$('body').on('click', '.nasa-close-menu-mobile, .nasa-close-sidebar', function() {
    $('.black-window').trigger('click');
});

/**
 * Accordion Mobile Menu
 */
$('body').on('click', '.nasa-menu-accordion .li_accordion > a.accordion', function(e) {
    e.preventDefault();
    var ths = $(this).parent();
    var cha = $(ths).parent();
    if (!$(ths).hasClass('active')) {
        var c = $(cha).children('li.active');
        $(c).removeClass('active').children('.nav-dropdown-mobile').css({height:'auto'}).slideUp(300);
        $(ths).children('.nav-dropdown-mobile').slideDown(300).parent().addClass('active');
    } else {
        $(ths).find('>.nav-dropdown-mobile').slideUp(300).parent().removeClass('active');
    }
    return false;
});

/**
 * Accordion Element
 */
$('body').on('click', '.nasa-accordion .li_accordion > a.accordion', function() {
    var _current = $(this);

    var _this = $(_current).parent();
    var _parent = $(_this).parent();

    if (!$(_this).hasClass('active')) {
        $(_parent).removeClass('nasa-current-tax-parent').removeClass('current-tax-item');
        var act = $(_parent).children('li.active');
        $(act).removeClass('active').children('.children').slideUp(300);
        $(_this).addClass('active').children('.children').slideDown(300);
    }

    else {
        $(_this).removeClass('active').children('.children').slideUp(300);
    }

    return false;
});

/**
 * Accordions
 */
$('body').on('click', '.nasa-accordions-content .nasa-accordion-title a', function() {
    var _this = $(this);
    var warp = $(_this).parents('.nasa-accordions-content');
    $('body').trigger('nasa_check_template', [warp]);
    var _global = $(warp).hasClass('nasa-no-global') ? true : false;
    $(warp).removeClass('nasa-accodion-first-show');
    var _id = $(_this).attr('data-id');
    var _index = false;
    if (typeof _id === 'undefined' || !_id) {
        _index = $(_this).attr('data-index');
    }
    
    var _current = _index ? $(warp).find('.' + _index) : $(warp).find('#nasa-section-' + _id);

    if (!$(_this).hasClass('active')) {
        if (!_global) {
            $(warp).find('.nasa-accordion-title a').removeClass('active');
            $(warp).find('.nasa-panel.active').removeClass('active').slideUp(200);
        }
        
        $(_this).addClass('active');
        if ($(_current).length) {
            $(_current).addClass('active').slideDown(200);
        }
    } else {
        $(_this).removeClass('active');
        if ($(_current).length) {
            $(_current).removeClass('active').slideUp(200);
        }
    }

    return false;
});

/**
 * Window Scroll
 */
var headerHeight = $('#header-content').length ? $('#header-content').height() : 0;
var timeOutFixedHeader;
$(window).on('scroll', function() {
    var scrollTop = $(this).scrollTop();
    
    if ($('body').find('.nasa-header-sticky').length && $('.sticky-wrapper').length) {
        var fix_top = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
        var _heightFixed = $('.sticky-wrapper').outerHeight();
        
        if (scrollTop > headerHeight) {
            if (typeof timeOutFixedHeader !== 'undefined') {
                clearTimeout(timeOutFixedHeader);
            }
            
            if (!$('.sticky-wrapper').hasClass('fixed-already')) {
                $('.sticky-wrapper').addClass('fixed-already');
                $('.nasa-header-sticky').css({'margin-bottom': _heightFixed});
                if (fix_top > 0) {
                    $('.sticky-wrapper').css({top: fix_top});
                }
            }
        } else {
            $('.sticky-wrapper').removeClass('fixed-already');
            $('.nasa-header-sticky').removeAttr('style');
            $('.sticky-wrapper').removeAttr('style');
            
            if ($('body').hasClass('rtl')) {
                $('.sticky-wrapper').css({'overflow': 'hidden'});
            
                timeOutFixedHeader = setTimeout(function() {
                    $('.sticky-wrapper').css({'overflow': 'unset'});
                }, 10);
            }
            
            _heightFixed = $('.sticky-wrapper').outerHeight();
        }
    }
    
    if ($('.nasa-nav-extra-warp').length) {
        if (scrollTop > headerHeight) {
            if (!$('.nasa-nav-extra-warp').hasClass('nasa-show')) {
                $('.nasa-nav-extra-warp').addClass('nasa-show');
            }
        } else {
            if ($('.nasa-nav-extra-warp').hasClass('nasa-show')) {
                $('.nasa-nav-extra-warp').removeClass('nasa-show');
            }
        }
    }
    
    /* Back to Top */
    if ($('#nasa-back-to-top').length) {
        if (typeof intervalBTT !== 'undefined' && intervalBTT) {
            clearInterval(intervalBTT);
        }
        
        var intervalBTT = setInterval(function() {
            var _height_win = $(window).height() / 2;
            if (scrollTop > _height_win) {
                if (!$('#nasa-back-to-top').hasClass('nasa-show')) {
                    $('#nasa-back-to-top').addClass('nasa-show');
                }
            } else {
                $('#nasa-back-to-top').removeClass('nasa-show');
            }
            
            clearInterval(intervalBTT);
        }, 100);
    }
});

/**
 * Window Resize
 */
$(window).on('resize', function() {
    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;

    // Fix Sidebar Mobile, Search Mobile display switch to desktop
    var desk = $('.black-window').hasClass('desk-window');
    if (!_mobileView && !desk && !_inMobile) {
        if ($('.col-sidebar').length) {
            $('.col-sidebar').removeClass('nasa-active');
        }
        if ($('.warpper-mobile-search').length && !$('.warpper-mobile-search').hasClass('show-in-desk')) {
            $('.warpper-mobile-search').removeClass('nasa-active');
        }
        if ($('.black-window').length) {
            $('.black-window').hide();
        }
    }
    
    var _height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
    if (_height_adminbar > 0 && $('#mobile-navigation').length) {
        $('#nasa-menu-sidebar-content').css({'top': _height_adminbar});
        
        if ($('#mobile-navigation').attr('data-show') === '1' && !_mobileView && $('.nasa-menu-off').length <= 0) {
            var _scrollTop = $(window).scrollTop();
            var _headerHeight = $('#header-content').height() + 50;
            if (_scrollTop <= _headerHeight) {
                $('.black-window').trigger('click');
            }
        }
    }
    
    /**
     * Tabs Slide
     */
    if ($('.nasa-slide-style').length) {
        $('.nasa-slide-style').each(function() {
            var _this = $(this);
            nasa_tab_slide_style($, _this, 500);
        });
    }
    
    clearTimeout(_positionMobileMenu);
    _positionMobileMenu = setTimeout(function() {
        position_menu_mobile($);
    }, 100);
});

var _positionMobileMenu = setTimeout(function() {
    position_menu_mobile($);
}, 100);

/**
 * Check template
 */
$('body').on('nasa_check_template', function(e, _panels) {
    if ($(_panels).find('.nasa-panel .nasa-tmpl').length) {
        $(_panels).find('.nasa-panel').each(function() {
            $('body').trigger('nasa_render_template', [this]);
        });
        
        $('body').trigger('nasa_rendered_template');
    }
});

/**
 * After Quick view
 */
$('body').on('nasa_after_quickview_timeout', function() {
    init_accordion($);
    
    /**
     * VC Progress bar
     */
    if ($('.product-lightbox .vc_progress_bar .vc_bar').length) {
        $('.product-lightbox .vc_progress_bar .vc_bar').each(function() {
            var _this = $(this);
            var _per = $(_this).attr('data-percentage-value');
            $(_this).css({'width': _per + '%'});
        });
    }
});

/**
 * Tabs Content
 */
$('body').on('click', '.nasa-tabs a', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    
    var _root = $(_this).parents('.nasa-tabs-content');
    $('body').trigger('nasa_check_template', [_root]);
    
    if (!$(_this).parent().hasClass('active')) {
        var _nasa_tabs = $(_root).find('.nasa-tabs');
        
        var currentTab = $(_this).attr('data-id');
        if (typeof currentTab === 'undefined' || !currentTab) {
            var _index = $(_this).attr('data-index');
            currentTab = $(_root).find('.' + _index);
        }
        
        $(_root).find('.nasa-tabs > li').removeClass('active');
        $(_this).parent().addClass('active');
        $(_root).find('.nasa-panel').removeClass('active').hide();
        
        if ($(currentTab).length) {
            $(currentTab).addClass('active').show();
        }

        if ($(_nasa_tabs).hasClass('nasa-slide-style')) {
            nasa_tab_slide_style($, _nasa_tabs, 500);
        }
        
        $('body').trigger('nasa_after_changed_tab_content', [currentTab]);
    }
});

/*********************************************************************
// ! Promo popup
/ *******************************************************************/
var et_popup_closed = $.cookie('nasa_popup_closed');
if (et_popup_closed !== 'do-not-show' && $('.nasa-popup').length && $('body').hasClass('open-popup')) {
    var _delayremoVal = parseInt($('.nasa-popup').attr('data-delay'));
    _delayremoVal = !_delayremoVal ? 300 : _delayremoVal * 1000;
    var _disableMobile = $('.nasa-popup').attr('data-disable_mobile') === 'true' ? true : false;
    var _one_time = $('.nasa-popup').attr('data-one_time');
    
    $('.nasa-popup').magnificPopup({
        items: {
            src: '#nasa-popup',
            type: 'inline'
        },
        closeMarkup: '<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="' + $('input[name="nasa-close-string"]').val() + '"></a>',
        removalDelay: 300,
        fixedContentPos: true,
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = 'my-mfp-slide-bottom';
            },
            beforeClose: function() {
                var showagain = $('#showagain:checked').val();
                if (showagain === 'do-not-show' || _one_time === '1') {
                    $.cookie('nasa_popup_closed', 'do-not-show', {expires: _cookie_live, path: '/'});
                }
            }
        },
        disableOn: function() {
            if (_disableMobile && $(window).width() <= 767) {
                return false;
            }
            
            return true;
        }
    });
    
    setTimeout(function() {
        $('.nasa-popup').magnificPopup('open');
    }, _delayremoVal);
    
    $('body').on('click', '#nasa-popup input[type="submit"]', function() {
        $(this).ajaxSuccess(function(event, request, settings) {
            if (typeof request === 'object' && request.responseJSON.status === 'mail_sent') {
                $('body').append('<div id="nasa-newsletter-alert" class="hidden-tag"><div class="wpcf7-response-output wpcf7-mail-sent-ok">' + request.responseJSON.message + '</div></div>');

                $.cookie('nasa_popup_closed', 'do-not-show', {expires: _cookie_live, path: '/'});
                $.magnificPopup.close();

                setTimeout(function() {
                    $('#nasa-newsletter-alert').fadeIn(300);

                    setTimeout(function() {
                        $('#nasa-newsletter-alert').fadeOut(500);
                    }, 2000);
                }, 300);
            }
        });
    });
}

/**
 * Compare products
 */
$('body').on('click', '.btn-compare', function() {
    var _this = $(this);
    if (!$(_this).hasClass('nasa-compare')) {
        var _button = $(_this).parent();
        if ($(_button).find('.compare-button .compare').length) {
            $(_button).find('.compare-button .compare').trigger('click');
        }
    } else {
        var _id = $(_this).attr('data-prod');
        if (_id) {
            add_compare_product(_id, $);
        }
    }
    
    return false;
});

/**
 * Remove item from Compare
 */
$('body').on('click', '.nasa-remove-compare', function() {
    var _id = $(this).attr('data-prod');
    if (_id) {
        remove_compare_product(_id, $);
    }
    
    return false;
});

/**
 * Remove All items from Compare
 */
$('body').on('click', '.nasa-compare-clear-all', function() {
    remove_all_compare_product($);
    
    return false;
});

/**
 * Show Compare
 */
$('body').on('click', '.nasa-show-compare', function() {
    load_compare($);
    
    if (!$(this).hasClass('nasa-showed')) {
        show_compare($);
    } else {
        hide_compare($);
    }
    
    return false;
});

/**
 * Wishlist products
 */
$('body').on('click', '.btn-wishlist', function() {
    var _this = $(this);
    if (!$(_this).hasClass('nasa-disabled')) {
        $('.btn-wishlist').addClass('nasa-disabled');
        
        /**
         * NasaTheme Wishlist
         */
        if ($(_this).hasClass('btn-nasa-wishlist')) {
            var _pid = $(_this).attr('data-prod');
            
            if (!$(_this).hasClass('nasa-added')) {
                $(_this).addClass('nasa-added');
                nasa_process_wishlist($, _pid, 'nasa_add_to_wishlist');
            } else {
                $(_this).removeClass('nasa-added');
                nasa_process_wishlist($, _pid, 'nasa_remove_from_wishlist');
            }
        }
        
        /**
         * Yith WooCommerce Wishlist
         */
        else {
            if (!$(_this).hasClass('nasa-added')) {
                $(_this).addClass('nasa-added');

                if ($('#tmpl-nasa-global-wishlist').length) {
                    var _pid = $(_this).attr('data-prod');
                    var _origin_id = $(_this).attr('data-original-product-id');
                    var _ptype = $(_this).attr('data-prod_type');
                    var _wishlist_tpl = $('#tmpl-nasa-global-wishlist').html();
                    if ($('.nasa-global-wishlist').length <= 0) {
                        $('body').append('<div class="nasa-global-wishlist"></div>');
                    }

                    _wishlist_tpl = _wishlist_tpl.replace(/%%product_id%%/g, _pid);
                    _wishlist_tpl = _wishlist_tpl.replace(/%%product_type%%/g, _ptype);
                    _wishlist_tpl = _wishlist_tpl.replace(/%%original_product_id%%/g, _origin_id);

                    $('.nasa-global-wishlist').html(_wishlist_tpl);
                    $('.nasa-global-wishlist').find('.add_to_wishlist').trigger('click');
                } else {
                    var _button = $(_this).parent();
                    if ($(_button).find('.add_to_wishlist').length) {
                        $(_button).find('.add_to_wishlist').trigger('click');
                    }
                }
            } else {
                var _pid = $(_this).attr('data-prod');
                if (_pid && $('#yith-wcwl-row-' + _pid).length && $('#yith-wcwl-row-' + _pid).find('.nasa-remove_from_wishlist').length) {
                    $(_this).removeClass('nasa-added');
                    $(_this).addClass('nasa-unliked');
                    $('#yith-wcwl-row-' + _pid).find('.nasa-remove_from_wishlist').trigger('click');

                    setTimeout(function() {
                        $(_this).removeClass('nasa-unliked');
                    }, 1000);
                } else {
                    $('.btn-wishlist').removeClass('nasa-disabled');
                }
            }
        }
    }
    
    return false;
});

/* ADD PRODUCT WISHLIST NUMBER */
$('body').on('added_to_wishlist', function() {
    if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
        var _data = {};
        _data.action = 'nasa_update_wishlist';
        _data.added = true;

        if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
            $('.nasa-value-gets').find('input').each(function() {
                var _key = $(this).attr('name');
                var _val = $(this).val();
                _data[_key] = _val;
            });
        }
        
        $.ajax({
            url: nasa_ajax_params.ajax_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: _data,
            beforeSend: function() {

            },
            success: function(res) {
                $('.wishlist_sidebar').replaceWith(res.list);
                var _sl_wishlist = (res.count).toString().replace('+', '');
                var sl_wislist = parseInt(_sl_wishlist);
                $('.nasa-mini-number.wishlist-number').html(res.count);

                if (sl_wislist > 0) {
                    $('.nasa-mini-number.wishlist-number').removeClass('nasa-product-empty');
                } else if (sl_wislist === 0 && !$('.nasa-mini-number.wishlist-number').hasClass('nasa-product-empty')) {
                    $('.nasa-mini-number.wishlist-number').addClass('nasa-product-empty');
                }

                if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                    if ($('.nasa-close-notice').length) {
                        $('.nasa-close-notice').trigger('click');
                    }

                    $('#yith-wcwl-popup-message').html(res.mess);

                    $('#yith-wcwl-popup-message').fadeIn();
                    setTimeout( function() {
                        $('#yith-wcwl-popup-message').fadeOut();
                    }, 2000);
                }

                setTimeout(function() {
                    init_wishlist_icons($, true);
                    $('.btn-wishlist').removeClass('nasa-disabled');
                }, 350);
            },
            error: function() {
                $('.btn-wishlist').removeClass('nasa-disabled');
            }
        });
    }
});

/* REMOVE PRODUCT WISHLIST NUMBER */
$('body').on('click', '.nasa-remove_from_wishlist', function() {
    if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
        var _wrap_item = $(this).parents('.nasa-tr-wishlist-item');
        if ($(_wrap_item).length) {
            $(_wrap_item).css({opacity: 0.3});
        }

        /**
         * Support Yith WooCommercen Wishlist
         */
        if (!$(this).hasClass('btn-nasa-wishlist')) {
            var _data = {};
            _data.action = 'nasa_remove_from_wishlist';

            if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
                $('.nasa-value-gets').find('input').each(function() {
                    var _key = $(this).attr('name');
                    var _val = $(this).val();
                    _data[_key] = _val;
                });
            }

            var _pid = $(this).attr('data-prod_id');
            _data.remove_from_wishlist = _pid;
            _data.wishlist_id = $('.wishlist_table').attr('data-id');
            _data.pagination = $('.wishlist_table').attr('data-pagination');
            _data.per_page = $('.wishlist_table').attr('data-per-page');
            _data.current_page = $('.wishlist_table').attr('data-page');

            $.ajax({
                url: nasa_ajax_params.ajax_url,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: _data,
                beforeSend: function() {
                    $.magnificPopup.close();
                },
                success: function(res) {
                    if (res.error === '0') {
                        $('.wishlist_sidebar').replaceWith(res.list);
                        var _sl_wishlist = (res.count).toString().replace('+', '');
                        var sl_wislist = parseInt(_sl_wishlist);
                        $('.nasa-mini-number.wishlist-number').html(res.count);
                        if (sl_wislist > 0) {
                            $('.wishlist-number').removeClass('nasa-product-empty');
                        } else if (sl_wislist === 0 && !$('.nasa-mini-number.wishlist-number').hasClass('nasa-product-empty')) {
                            $('.nasa-mini-number.wishlist-number').addClass('nasa-product-empty');
                            $('.black-window').trigger('click');
                        }

                        if ($('.btn-wishlist[data-prod="' + _pid + '"]').length) {
                            $('.btn-wishlist[data-prod="' + _pid + '"]').removeClass('nasa-added');

                            if ($('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').length) {
                                $('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').removeClass('added');
                            }
                        }

                        if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                            if ($('.nasa-close-notice').length) {
                                $('.nasa-close-notice').trigger('click');
                            }

                            $('#yith-wcwl-popup-message').html(res.mess);

                            $('#yith-wcwl-popup-message').fadeIn();
                            setTimeout( function() {
                                $('#yith-wcwl-popup-message').fadeOut();
                            }, 2000);
                        }
                    }

                    $('.btn-wishlist').removeClass('nasa-disabled');
                },
                error: function() {
                    $('.btn-wishlist').removeClass('nasa-disabled');
                }
            });
        }
    }
    
    return false;
});

// Target quantity inputs on product pages
$('body').find('input.qty:not(.product-quantity input.qty)').each(function() {
    var min = parseFloat($(this).attr('min'));
    if (min && min > 0 && parseFloat($(this).val()) < min) {
        $(this).val(min);
    }
});

$('body').on('click', '.plus, .minus', function() {
    // Get values
    var $qty = $(this).parents('.quantity').find('.qty'),
        form = $(this).parents('.cart'),
        button_add = $(form).length ? $(form).find('.single_add_to_cart_button') : false,
        currentVal = parseFloat($qty.val()),
        max = parseFloat($qty.attr('max')),
        min = parseFloat($qty.attr('min')),
        step = $qty.attr('step');
        
    var _old_val = $qty.val();
    $qty.attr('data-old', _old_val);
        
    // Format values
    currentVal = !currentVal ? 0 : currentVal;
    max = !max ? '' : max;
    min = !min ? 1 : min;
    if (
        step === 'any' ||
        step === '' ||
        typeof step === 'undefined' ||
        parseFloat(step) === 'NaN'
    ) {
        step = 1;
    }
    
    // Change the value Plus
    if ($(this).hasClass('plus')) {
        if (max && (max == currentVal || currentVal > max)) {
            $qty.val(max);
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', max);
            }
        } else {
            $qty.val(currentVal + parseFloat(step));
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', currentVal + parseFloat(step));
            }
        }
    }
    
    // Change the value Minus
    else {
        if (min && (min == currentVal || currentVal < min)) {
            $qty.val(min);
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', min);
            }
        } else if (currentVal > 0) {
            $qty.val(currentVal - parseFloat(step));
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', currentVal - parseFloat(step));
            }
        }
    }
    // Trigger change event
    $qty.trigger('change');
});

/**
 * Ajax search Products
 */
if (typeof search_options !== 'undefined' && typeof search_options.url !== 'undefined') {
    $('body').on('focus', '.live-search-input', function() {
        var _this = $(this);
        if (!$(_this).hasClass('nasa-inited')) {
            $(_this).addClass('nasa-inited');
            $('body').trigger('nasa_live_search_products', _this);
        }
    });
    
    $('body').on('nasa_live_search_products', function(e, _this) {
        if (typeof search_options !== 'undefined') {
            var _urlAjax = search_options.url;
            var searchProducts = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: _urlAjax,
                limit: search_options.limit,
                remote: {
                    url: _urlAjax + '&s=%QUERY',
                    wildcard: '%QUERY'
                }
            });

            $(_this).typeahead({
                minLength: 3,
                hint: true,
                highlight: true,
                backdrop: {
                    "opacity": 0.8,
                    "filter": "alpha(opacity=80)",
                    "background-color": "#eaf3ff"
                },
                searchOnFocus: true,
                callback: {
                    onInit: function() {
                        searchProducts.initialize();
                    },
                    onSubmit: function(node, form, item, event) {
                        form.submit();
                    }
                }
            },
            {
                name: 'search',
                source: searchProducts,
                display: 'title',
                displayKey: 'value',
                limit: search_options.limit * 2,
                templates: {
                    empty : '<p class="empty-message nasa-notice-empty">' + search_options.empty_result + '</p>',
                    suggestion: Handlebars.compile(search_options.template),
                    footer: search_options.view_all,
                    pending: function(query) {
                        return '<div class="nasa-loader nasa-live-search-loader"></div>';
                    }
                }
            });
        }

        $(_this).trigger('focus');
    });

    $('body').on('click', '.nasa-search-all, .nasa-icon-submit-page', function() {
        var _form = $(this).parents('form');
        if ($(_form).length) {
            $(_form).trigger('submit');
        }
    });
} else {
    setTimeout(function() {
        $('.nasa-modern-layout').removeClass('nasa-modern-layout');
    }, 100);
}

/**
 * Mobile Search
 */
$('body').on('click', '.mobile-search', function() {
    $('.black-window').fadeIn(200);
    
    /**
     * Build content search form
     */
    if ($('#tmpl-nasa-mobile-search').length) {
        var _content = $('#tmpl-nasa-mobile-search').html();
        $('.warpper-mobile-search').html(_content);
        $('#tmpl-nasa-mobile-search').remove();
    }
    
    var height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
    
    if (height_adminbar > 0) {
        $('.warpper-mobile-search').css({top: height_adminbar});
    }
    
    if (!$('.warpper-mobile-search').hasClass('nasa-active')) {
        $('.warpper-mobile-search').addClass('nasa-active');
    }
    
    /**
     * Focus input
     * @returns {undefined}
     */
    setTimeout(function() {
        if ($('.warpper-mobile-search').find('label').length) {
            $('.warpper-mobile-search').find('label').trigger('click');
        }
    }, 1000);
});

$('body').on('click', '.nasa-close-search, .nasa-tranparent', function() {
    $(this).parents('.nasa-wrap-event-search').find('.desk-search').trigger('click');
});

$('body').on('click', '.toggle-sidebar-shop', function() {
    $('.transparent-window').fadeIn(200);
    if (!$('.nasa-side-sidebar').hasClass('nasa-show')) {
        $('.nasa-side-sidebar').addClass('nasa-show');
    }
});

/**
 * For topbar type 1 Mobile
 */
$('body').on('click', '.toggle-topbar-shop-mobile', function() {
    $('.transparent-mobile').fadeIn(200);
    if (!$('.nasa-top-sidebar').hasClass('nasa-active')) {
        $('.nasa-top-sidebar').addClass('nasa-active');
    }
});

$('body').on('click', '.toggle-sidebar', function() {
    $('.black-window').fadeIn(200);
    if ($('.col-sidebar').length && !$('.col-sidebar').hasClass('nasa-active')) {
        $('.col-sidebar').addClass('nasa-active');
    }
});

if ($('input[name="nasa_cart_sidebar_show"]').length && $('input[name="nasa_cart_sidebar_show"]').val() === '1') {
    setTimeout(function() {
        $('.cart-link').trigger('click');
    }, 300);
}

/**
 * Show mini Cart sidebar
 */
$('body').on('click', '.cart-link', function() {
    if ($('form.nasa-shopping-cart-form').length || $('form.woocommerce-checkout').length) {
        return false;
    } else {
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
            $('#cart-sidebar').addClass('nasa-active');

            if ($('#cart-sidebar').find('input[name="nasa-mini-cart-empty-content"]').length) {
                $('#cart-sidebar').append('<div class="nasa-loader"></div>');

                reload_mini_cart($);
            }
            
            /**
             * notification free shipping
             */
            else {
                init_shipping_free_notification($);
            }
        }
    }
    
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }
});

/**
 * Compatible elementor toggle button cart sidebar
 */
$('body').on('click', '#elementor-menu-cart__toggle_button', function() {
    if ($('.elementor-menu-cart__container .elementor-menu-cart__main').length) {
        $('.elementor-menu-cart__container').remove();
    }
    
    if (!$(this).hasClass('cart-link')) {
        $(this).addClass('cart-link');
        $(this).trigger('click');
    }
});

/**
 * Wishlist icon open sidebar
 */
$('body').on('click', '.wishlist-link', function() {
    /**
     * Append stylesheet Off Canvas
     */
    $('body').trigger('nasa_append_style_off_canvas');
    
    if ($(this).hasClass('wishlist-link-premium')) {
        return;
    } else {
        if ($(this).hasClass('nasa-wishlist-link')) {
            load_wishlist($);
        }
        
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#nasa-wishlist-sidebar').length && !$('#nasa-wishlist-sidebar').hasClass('nasa-active')) {
            $('#nasa-wishlist-sidebar').addClass('nasa-active');
        }
    }
});

$('body').on('nasa_processed_wishlish', function() {
    if ($('.nasa-tr-wishlist-item').length <= 0) {
        $('.black-window').trigger('click');
    }
});

$('body').on('click', '#nasa-init-viewed', function() {
    $('.black-window').fadeIn(200).addClass('desk-window');
    
    if ($('#nasa-viewed-sidebar').length && !$('#nasa-viewed-sidebar').hasClass('nasa-active')) {
        $('#nasa-viewed-sidebar').addClass('nasa-active');
    }
});

/**
 * Close by fog window
 */
$('body').on('click', '.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .nasa-close-mini-compare, .nasa-sidebar-close a, .nasa-sidebar-return-shop, .login-register-close', function() {
    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;
    
    $('.black-window').removeClass('desk-window');
    
    if ($('#mobile-navigation').length && $('#mobile-navigation').attr('data-show') === '1') {
        if ($('#nasa-menu-sidebar-content').length) {
            $('#nasa-menu-sidebar-content').removeClass('nasa-active');
        }
        
        $('#mobile-navigation').attr('data-show', '0');
        setTimeout(function() {
            $('.black-window').removeClass('nasa-transparent');
        }, 1000);
    }
    
    if ($('.warpper-mobile-search').length) {
        $('.warpper-mobile-search').removeClass('nasa-active');
        if ($('.warpper-mobile-search').hasClass('show-in-desk')) {
            setTimeout(function() {
                $('.warpper-mobile-search').removeClass('show-in-desk');
            }, 600);
        }
    }
    
    /**
     * Close sidebar
     */
    if ($('.col-sidebar').length && (_mobileView || _inMobile)) {
        $('.col-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close Dokan sidebar
     */
    if ($('.dokan-store-sidebar').length) {
        $('.dokan-store-sidebar').removeClass('nasa-active');
    }

    /**
     * Close cart sidebar
     */
    if ($('#cart-sidebar').length) {
        $('#cart-sidebar').removeClass('nasa-active');
    }

    /**
     * Close wishlist sidebar
     */
    if ($('#nasa-wishlist-sidebar').length) {
        $('#nasa-wishlist-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close viewed sidebar
     */
    if ($('#nasa-viewed-sidebar').length) {
        $('#nasa-viewed-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close quick view sidebar
     */
    if ($('#nasa-quickview-sidebar').length) {
        $('#nasa-quickview-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close filter categories sidebar in mobile
     */
    if ($('.nasa-top-cat-filter-wrap-mobile').length) {
        $('.nasa-top-cat-filter-wrap-mobile').removeClass('nasa-show');
    }
    
    /**
     * Close sidebar
     */
    if ($('.nasa-side-sidebar').length) {
        $('.nasa-side-sidebar').removeClass('nasa-show');
    }
    
    if ($('.nasa-top-sidebar').length) {
        $('.nasa-top-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close login or register
     */
    if ($('.nasa-login-register-warper').length) {
        $('.nasa-login-register-warper').removeClass('nasa-active');
    }
    
    /**
     * Languages
     */
    if ($('.nasa-current-lang').length) {
        var _wrapLangs = $('.nasa-current-lang').parents('.nasa-select-languages');
        if ($(_wrapLangs).length) {
            $(_wrapLangs).removeClass('nasa-active');
        }
    }
    
    /**
     * Currencies
     */
    if ($('.wcml-cs-item-toggle').length) {
        var _wrapCurrs = $('.wcml-cs-item-toggle').parents('.nasa-select-currencies');
        if ($(_wrapCurrs).length) {
            $(_wrapCurrs).removeClass('nasa-active');
        }
    }
    
    /**
     * Hide compare product
     */
    hide_compare($);
    
    $('body').trigger('nasa_after_close_fog_window');

    $('.black-window, .white-window, .transparent-mobile, .transparent-window, .transparent-desktop').fadeOut(1000);
});

/**
 * ESC from keyboard
 */
$(document).on('keyup', function(e) {
    if (e.keyCode === 27) {
        $('.nasa-tranparent').trigger('click');
        $('.nasa-tranparent-filter').trigger('click');
        $('.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .nasa-close-mini-compare, .nasa-sidebar-close a, .login-register-close, .nasa-transparent-topbar, .nasa-close-filter-cat').trigger('click');
        $.magnificPopup.close();
    }
});

$('body').on('click', '.add_to_cart_button', function() {
    if (!$(this).hasClass('product_type_simple')) {
        var _href = $(this).attr('href');
        window.location.href = _href;
    }
});

/**
 * Single add to cart from wishlist
 */
$('body').on('click', '.nasa_add_to_cart_from_wishlist', function() {
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if (_id && !$(_this).hasClass('loading')) {
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _data_wishlist = {};
            
        if ($('.wishlist_table').length && $('.wishlist_table').find('#yith-wcwl-row-' + _id).length) {
            _data_wishlist = {
                from_wishlist: '1',
                wishlist_id: $('.wishlist_table').attr('data-id'),
                pagination: $('.wishlist_table').attr('data-pagination'),
                per_page: $('.wishlist_table').attr('data-per-page'),
                current_page: $('.wishlist_table').attr('data-page')
            };
        }
        
        $('body').trigger('nasa_single_add_to_cart', [_this, _id, _quantity, _type, null, null, _data_wishlist]);
    }
    
    return false;
});

/**
 * Add to cart in quick-view Or single product
 */
$('body').on('click', 'form.cart .single_add_to_cart_button', function() {
    $('.nasa-close-notice').trigger('click');
    
    var _flag_adding = true;
    var _this = $(this);
    var _form = $(_this).parents('form.cart');
    
    $('body').trigger('nasa_before_click_single_add_to_cart', [_form]);
    
    if ($(_form).find('#yith_wapo_groups_container').length) {
        $(_form).find('input[name="nasa-enable-addtocart-ajax"]').remove();
        
        if ($(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').length) {
            $(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').val('1');
        } else {
            $(_form).find('.nasa-custom-fields').append('<input type="hidden" name="nasa_cart_sidebar" value="1" />');
        }
    }
    
    var _enable_ajax = $(_form).find('input[name="nasa-enable-addtocart-ajax"]');
    if ($(_enable_ajax).length <= 0 || $(_enable_ajax).val() !== '1') {
        _flag_adding = false;
        return;
    } else {
        var _disabled = $(_this).hasClass('disabled') || $(_this).hasClass('nasa-ct-disabled') ? true : false;
        var _id = !_disabled ? $(_form).find('input[name="data-product_id"]').val() : false;
        if (_id && !$(_this).hasClass('loading')) {
            var _type = $(_form).find('input[name="data-type"]').val(),
                _quantity = $(_form).find('.quantity input[name="quantity"]').val(),
                _variation_id = $(_form).find('input[name="variation_id"]').length ? parseInt($(_form).find('input[name="variation_id"]').val()) : 0,
                _variation = {},
                _data_wishlist = {},
                _from_wishlist = (
                    $(_form).find('input[name="data-from_wishlist"]').length === 1 &&
                    $(_form).find('input[name="data-from_wishlist"]').val() === '1'
                ) ? '1' : '0';
                
            if (_type === 'variable' && !_variation_id) {
                _flag_adding = false;
                return false;
            } else {
                if (_variation_id > 0 && $(_form).find('.variations').length) {
                    $(_form).find('.variations').find('select').each(function() {
                        _variation[$(this).attr('name')] = $(this).val();
                    });
                    
                    if ($('.wishlist_table').length && $('.wishlist_table').find('tr#yith-wcwl-row-' + _id).length) {
                        _data_wishlist = {
                            from_wishlist: _from_wishlist,
                            wishlist_id: $('.wishlist_table').attr('data-id'),
                            pagination: $('.wishlist_table').attr('data-pagination'),
                            per_page: $('.wishlist_table').attr('data-per-page'),
                            current_page: $('.wishlist_table').attr('data-page')
                        };
                    }
                }
            }
            
            if (_flag_adding) {
                $('body').trigger('nasa_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
            }
        }
        
        return false;
    }
});

/**
 * Click bundle add to cart
 */
$('body').on('click', '.nasa_bundle_add_to_cart', function() {
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if (_id) {
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _variation_id = 0,
            _variation = {},
            _data_wishlist = {};
        
        $('body').trigger('nasa_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
    }
    
    return false;
});

/**
 * Click to variation add to cart
 */
$('body').on('click', '.product_type_variation.add-to-cart-grid', function() {
    var _this = $(this);
    if (!$(_this).hasClass('nasa-disable-ajax')) {
        if (!$(_this).hasClass('loading')) {
            var _id = $(_this).attr('data-product_id');
            if (_id) {
                var _type = 'variation',
                    _quantity = $(_this).attr('data-quantity'),
                    _variation_id = 0,
                    _variation = null,
                    _data_wishlist = {};
                    
                    if (typeof $(_this).attr('data-variation_id') !== 'undefined') {
                        _variation_id = $(_this).attr('data-variation_id');
                    }

                    if (typeof $(_this).attr('data-variation') !== 'undefined') {
                        _variation = JSON.parse($(_this).attr('data-variation'));
                    }
                    
                if (_variation) {
                    $('body').trigger('nasa_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
                } else {
                    var _href = $(_this).attr('href');
                    window.location.href = _href;
                }
            }
        }

        return false;
    }
});

/**
 * Click select option
 */
$('body').on('click', '.product_type_variable', function() {
    if ($('body').hasClass('nasa-quickview-on')) {
        var _this = $(this);
        
        if (!$(_this).hasClass('add-to-cart-grid')) {
            var _href = $(_this).attr('href');
            if (_href) {
                window.location.href = _href;
            }

            return;
        }
        
        else {
            if ($(_this).parents('.compare-list').length) {
                return;
            }

            else {
                if (!$(_this).hasClass('btn-from-wishlist')) {
                    
                    if ($(_this).hasClass('nasa-before-click')) {
                        $('body').trigger('nasa_after_click_select_option', [_this]);
                    }
                    
                    else {
                        var _parent = $(_this).parents('.nasa-group-btns');
                        $(_parent).find('.quick-view').trigger('click');
                    }
                }
                
                /**
                 * From Wishlist
                 */
                else {
                    var _parent = $(_this).parents('.add-to-cart-wishlist');
                    if ($(_parent).length && $(_parent).find('.quick-view').length) {
                        $(_parent).find('.quick-view').trigger('click');
                    }
                }

                return false;
            }
        }
    } else {
        return;
    }
});

/**
 * After remove cart item in mini cart
 */
$('body').on('wc_fragments_loaded', function() {
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length <= 0) {
        $('.black-window').trigger('click');
    }
});
// $('body').on('wc_fragments_refreshed', function() {});

$('body').on('updated_wc_div', function() {
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
    
    init_nasa_notices($);
});

/**
 * Before Add To Cart
 */
var _nasa_clear_added_to_cart;
$('body').on('adding_to_cart', function() {
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }

    if (typeof _nasa_clear_added_to_cart !== 'undefined') {
        clearTimeout(_nasa_clear_added_to_cart);
    }
});

/**
 * After Add To Cart
 */
$('body').on('added_to_cart', function(ev, fragments) {
    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;
    
    /**
     * Close quick-view
     */
    if ($('.nasa-after-add-to-cart-popup').length <= 0) {
        $.magnificPopup.close();
    }
    
    var _event_add = $('input[name="nasa-event-after-add-to-cart"]').length && $('input[name="nasa-event-after-add-to-cart"]').val();
    
    /* Loading content After Add To Cart - Popup your order */
    if (_event_add === 'popup' && $('form.nasa-shopping-cart-form').length <= 0 && $('form.woocommerce-checkout').length <= 0) {
        after_added_to_cart($);
    }
    
    /**
     * Only show Notice in cart or checkout page or Mobile
     */
    if ($('form.nasa-shopping-cart-form').length || $('form.woocommerce-checkout').length || _mobileView || _inMobile) {
        _event_add = 'notice';
    }
   
    /**
     * Show Mini Cart Sidebar
     */
    if (_event_add === 'sidebar') {
        $('#nasa-quickview-sidebar').removeClass('nasa-active');
        $('#nasa-wishlist-sidebar').removeClass('nasa-active');
        
        setTimeout(function() {
            $('.black-window').fadeIn(200).addClass('desk-window');
            $('#nasa-wishlist-sidebar').removeClass('nasa-active');
            
            if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
                $('#cart-sidebar').addClass('nasa-active');
            }
            
            /**
             * notification free shipping
             */
            init_shipping_free_notification($);
        }, 200);
    }
    
    /**
     * Show notice
     */
    if (_event_add === 'notice' && typeof fragments['.woocommerce-message'] !== 'undefined') {
        if ($('.nasa-close-notice').length) {
            $('.nasa-close-notice').trigger('click');
        }
        
        set_nasa_notice($, fragments['.woocommerce-message']);
        
        if (typeof _nasa_clear_added_to_cart !== 'undefined') {
            clearTimeout(_nasa_clear_added_to_cart);
        }
        
        _nasa_clear_added_to_cart = setTimeout(function() {
            if ($('.nasa-close-notice').length) {
                $('.nasa-close-notice').trigger('click');
            }
        }, 5000);
    }
    
    ev.preventDefault();
});

$('body').on('click', '.nasa-close-magnificPopup, .nasa-mfp-close', function() {
    $.magnificPopup.close();
});

$('body').on('change', '.nasa-after-add-to-cart-popup input.qty', function() {
    $('.nasa-after-add-to-cart-popup .nasa-update-cart-popup').removeClass('nasa-disable');
});

$('body').on('click', '.remove_from_cart_popup', function() {
    if (!$(this).hasClass('loading')) {
        $(this).addClass('loading');
        nasa_block($('.nasa-after-add-to-cart-wrap'));
        
        var _id = $(this).attr('data-product_id');
        if ($('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').length) {
            $('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').trigger('click');
        } else {
            window.location.href = $(this).attt('href');
        }
    }
    
    return false;
});

$('body').on('removed_from_cart', function() {
    if ($('.nasa-after-add-to-cart-popup').length) {
        after_added_to_cart($);
    }
    
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
                    
    return false;
});

/**
 * Update cart in popup
 */
$('body').on('click', '.nasa-update-cart-popup', function() {
    var _this = $(this);
    if ($('.nasa-after-add-to-cart-popup').length && !$(_this).hasClass('nasa-disable')) {
        var _form = $(this).parents('form');
        if ($(_form).find('input[name=""]').length <= 0) {
            $(_form).append('<input type="hidden" name="update_cart" value="Update Cart" />');
        }
        $.ajax({
            type: $(_form).attr('method'),
            url: $(_form).attr('action'),
            data: $(_form).serialize(),
            dataType: 'html',
            beforeSend: function() {
                nasa_block($('.nasa-after-add-to-cart-wrap'));
            },
            success: function(res) {
                $(_form).find('input[name="update_cart"]').remove();
                $(_this).addClass('nasa-disable');
            },
            complete: function() {
                reload_mini_cart($);
                after_added_to_cart($);
            }
        });
    }
    
    return false;
});

if ($('.nasa-promotion-close').length) {
    var height = $('.nasa-promotion-news').outerHeight();
    
    if ($.cookie('promotion') !== 'hide') {
        setTimeout(function() {
            $('.nasa-position-relative').animate({'height': height + 'px'}, 500);
            $('.nasa-promotion-news').fadeIn(500);
            
            if ($('.nasa-promotion-news').find('.nasa-post-slider').length) {
                $('.nasa-promotion-news').find('.nasa-post-slider').addClass('nasa-slick-slider');
                $('body').trigger('nasa_load_slick_slider');
            }
        }, 1000);
    } else {
        $('.nasa-promotion-show').show();
    }
    
    $('body').on('click', '.nasa-promotion-close', function() {
        $.cookie('promotion', 'hide', {expires: _cookie_live, path: '/'});
        $('.nasa-promotion-show').show();
        $('.nasa-position-relative').animate({'height': '0'}, 500);
        $('.nasa-promotion-news').fadeOut(500);
    });
    
    $('body').on('click', '.nasa-promotion-show', function() {
        $.cookie('promotion', 'show', {expires: _cookie_live, path: '/'});
        $('.nasa-promotion-show').hide();
        $('.nasa-position-relative').animate({'height': height + 'px'}, 500);
        $('.nasa-promotion-news').fadeIn(500);
        
        if ($('.nasa-promotion-news').find('.nasa-post-slider').length && !$('.nasa-promotion-news').find('.nasa-post-slider').hasClass('nasa-slick-slider')) {
            $('.nasa-promotion-news').find('.nasa-post-slider').addClass('nasa-slick-slider');
            $('body').trigger('nasa_load_slick_slider');
        }
        
        setTimeout(function() {
            $(window).trigger('resize');
        }, 1000);
    });
};

// Logout click
$('body').on('click', '.nasa_logout_menu a', function() {
    if ($('input[name="nasa_logout_menu"]').length) {
        window.location.href = $('input[name="nasa_logout_menu"]').val();
    }
});

// Show more | Show less
$('body').on('click', '.nasa_show_manual > a', function() {
    var _this = $(this),
        _val = $(_this).attr('data-show'),
        _li = $(_this).parent(),
        _delay = $(_li).attr('data-delay') ? parseInt($(_li).attr('data-delay')) : 100,
        _fade = $(_li).attr('data-fadein') === '1' ? true : false,
        _text_attr = $(_this).attr('data-text'),
        _text = $(_this).text();
        
    $(_this).html(_text_attr);
    $(_this).attr('data-text', _text);
    
    if (_val === '1') {
        $(_li).parent().find('.nasa-show-less').each(function() {
            if (!_fade) {
                $(this).slideDown(_delay);
            } else {
                $(this).fadeIn(_delay);
            }
        });
        
        $(_this).attr('data-show', '0');
    } else {
        $(_li).parent().find('.nasa-show-less').each(function() {
            if (!$(this).hasClass('nasa-chosen') && !$(this).find('.nasa-active').length) {
                if (!_fade) {
                    $(this).slideUp(_delay);
                } else {
                    $(this).fadeOut(_delay);
                }
            }
        });
        
        $(_this).attr('data-show', '1');
    }
});

// Login Register Form
$('body').on('click', '.nasa-switch-register', function() {
    $('#nasa-login-register-form .nasa-message').html('');
    $('.nasa_register-form, .register-form').animate({'left': '0'}, 350);
    $('.nasa_login-form, .login-form').animate({'left': '-100%'}, 350);
    
    setTimeout(function() {
        $('.nasa_register-form, .register-form').css({'position': 'relative'});
        $('.nasa_login-form, .login-form').css({'position': 'absolute'});
    }, 350);
});

/**
 * Switch Login | Register forms
 */
$('body').on('click', '.nasa-switch-login', function() {
    $('#nasa-login-register-form .nasa-message').html('');
    $('.nasa_register-form, .register-form').animate({'left': '100%'}, 350);
    $('.nasa_login-form, .login-form').animate({'left': '0'}, 350);
    
    setTimeout(function() {
        $('.nasa_register-form, .register-form').css({'position': 'absolute'});
        $('.nasa_login-form, .login-form').css({'position': 'relative'});
    }, 350);
});

if ($('.nasa-login-register-ajax').length) {
    $('body').on('click', '.nasa-login-register-ajax', function() {
        if ($('#nasa-login-register-form').length <= 0) {
            var _content = $('#tmpl-nasa-register-form').html();
            $('.nasa-login-register-warper').html(_content);
            $('#tmpl-nasa-register-form').remove();
            
            $('body').trigger('nasa_login_register_ajax_inited');
        }
        
        if ($(this).attr('data-enable') === '1' && $('#customer_login').length <= 0) {
            $('#nasa-menu-sidebar-content').removeClass('nasa-active');
            $('#mobile-navigation').attr('data-show', '0');
            
            $('.black-window').fadeIn(200).removeClass('nasa-transparent').addClass('desk-window');
            
            if (!$('.nasa-login-register-warper').hasClass('nasa-active')) {
                $('.nasa-login-register-warper').addClass('nasa-active');
            }
            
            return false;
        }
    });
    
    /**
     * Must login to login Ajax Popup
     */
    if ($('.must-log-in > a').length) {
        $('body').on('click', '.must-log-in > a', function() {
            if ($('.nasa-login-register-ajax').length) {
                $('.nasa-login-register-ajax').trigger('click');
                return false;
            }
        });
    }
    
    /**
     * Login Ajax
     */
    $('body').on('click', '.nasa_login-form .button[type="submit"][name="nasa_login"]', function(e) {
        e.preventDefault();
        
        if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
            var _form = $(this).parents('form.login');

            var _validate = true;
            $(_form).find('.form-row').each(function() {
                var _inputText = $(this).find('input.input-text');
                var _require = $(this).find('.required');
                if ($(_inputText).length) {
                    $(_inputText).removeClass('nasa-error');
                    if ($(_require).length && $(_require).height() && $(_require).width() && $(_inputText).val().trim() === '') {
                        _validate = false;

                        $(_inputText).addClass('nasa-error');
                    }
                }
            });

            if (_validate) {
                var _data = $(_form).serializeArray();
                $.ajax({
                    url: nasa_ajax_params.ajax_url,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        'action': 'nasa_process_login',
                        'data': _data,
                        'login': true
                    },
                    beforeSend: function() {
                        $('#nasa-login-register-form #nasa_customer_login').css({opacity: 0.3});
                        $('#nasa-login-register-form #nasa_customer_login').after('<div class="nasa-loader"></div>');
                    },
                    success: function(res) {
                        $('#nasa-login-register-form #nasa_customer_login').css({opacity: 1});
                        $('#nasa-login-register-form').find('.nasa-loader').remove();
                        var _warning = (res.error === '0') ? 'nasa-success' : 'nasa-error';
                        $('#nasa-login-register-form .nasa-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                        if (res.error === '0') {
                            $('#nasa-login-register-form .nasa-form-content').remove();
                            window.location.href = res.redirect;
                        } else {
                            if (res._wpnonce === 'error') {
                                setTimeout(function() {
                                    var _href = false;
                                    if ($('.nasa-login-register-ajax').length) {
                                        _href = $('.nasa-login-register-ajax').attr('href');
                                    }
                                    
                                    if (_href) {
                                        window.location.href = _href;
                                    } else {
                                        window.location.reload();
                                    }
                                }, 2000);
                            }
                        }

                        $('body').trigger('nasa_after_process_login');
                    }
                });
            } else {
                $(_form).find('.nasa-error').first().focus();
            }
        }
        
        return false;
    });

    /**
     * Register Ajax
     */
    $('body').on('click', '.nasa_register-form .button[type="submit"][name="nasa_register"]', function(e) {
        e.preventDefault();
        
        if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
            var _form = $(this).parents('form.register');
            var _validate = true;
            $(_form).find('.form-row').each(function() {
                var _inputText = $(this).find('input.input-text');
                var _require = $(this).find('.required');
                if ($(_inputText).length) {
                    $(_inputText).removeClass('nasa-error');
                    if ($(_require).length && $(_require).height() && $(_require).width() && $(_inputText).val().trim() === '') {
                        _validate = false;

                        $(_inputText).addClass('nasa-error');
                    }
                }
            });

            if (_validate) {
                var _data = $(_form).serializeArray();
                $.ajax({
                    url: nasa_ajax_params.ajax_url,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        'action': 'nasa_process_register',
                        'data': _data,
                        'register': true
                    },
                    beforeSend: function() {
                        $('#nasa-login-register-form #nasa_customer_login').css({opacity: 0.3});
                        $('#nasa-login-register-form #nasa_customer_login').after('<div class="nasa-loader"></div>');
                    },
                    success: function(res) {
                        $('#nasa-login-register-form #nasa_customer_login').css({opacity: 1});
                        $('#nasa-login-register-form').find('.nasa-loader').remove();
                        var _warning = (res.error === '0') ? 'nasa-success' : 'nasa-error';
                        $('#nasa-login-register-form .nasa-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                        if (res.error === '0') {
                            $('#nasa-login-register-form .nasa-form-content').remove();
                            window.location.href = res.redirect;
                        } else {
                            if (res._wpnonce === 'error') {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        }

                        $('body').trigger('nasa_after_process_register');
                    }
                });
            } else {
                $(_form).find('.nasa-error').first().focus();
            }
        }
        
        return false;
    });
    
    $('body').on('keyup', '#nasa-login-register-form input.input-text.nasa-error', function() {
        if ($(this).val() !== '') {
            $(this).removeClass('nasa-error');
        }
    });
}

$('body').on('click', '.btn-combo-link', function() {
    var _width = $(window).outerWidth();
    var _this = $(this);
    var show_type = $(_this).attr('data-show_type');
    var wrap_item = $(_this).parents('.products.list');
    if (_width < 768 || $(wrap_item).length === 1) {
        show_type = 'popup';
    }
    
    switch (show_type) {
        default :
            load_combo_popup($, _this);
            break;
    }
    
    return false;
});

/**
 * Event nasa git featured
 */
$('body').on('click', '.nasa-gift-featured-event', function() {
    var _wrap = $(this).parents('.product-item');
    if ($(_wrap).find('.nasa-product-grid .btn-combo-link').length === 1) {
        $(_wrap).find('.nasa-product-grid .btn-combo-link').trigger('click');
    } else {
        if ($(_wrap).find('.nasa-product-list .btn-combo-link').length === 1) {
            $(_wrap).find('.nasa-product-list .btn-combo-link').trigger('click');
        }
    }
});

/**
 * Change language
 */
$('body').on('click', '.nasa-current-lang', function() {
    var _wrap = $(this).parents('.nasa-select-languages');
    if ($(_wrap).length) {
        if ($(_wrap).parents('#nasa-menu-sidebar-content').length === 0) {
            if ($('.transparent-desktop').length <= 0) {
                $('body').append('<div class="transparent-desktop"></div>');
            }

            $('.transparent-desktop').fadeIn(200);
        }
        $(_wrap).toggleClass('nasa-active');
        $('.nasa-select-currencies').removeClass('nasa-active');
    }

    return false;
});

/**
 * Change Currencies
 */
$('body').on('click', '.wcml-cs-item-toggle', function() {
    var _wrap = $(this).parents('.nasa-select-currencies');
    if ($(_wrap).length) {
        if ($(_wrap).parents('#nasa-menu-sidebar-content').length === 0) {
            if ($('.transparent-desktop').length <= 0) {
                $('body').append('<div class="transparent-desktop"></div>');
            }

            $('.transparent-desktop').fadeIn(200);
        }
        $(_wrap).toggleClass('nasa-active');
        $('.nasa-select-languages').removeClass('nasa-active');
    }

    return false;
});

/**
 * Scroll tabs
 */
$('body').on('click', '.nasa-anchor', function() {
    var _target = $(this).attr('data-target');
    if ($(_target).length) {
        animate_scroll_to_top($, _target, 1000);
    }
    
    return false;
});

/**
 * Animate Scroll To Top
 */
$('body').on('nasa_animate_scroll_to_top', function(ev, $, _dom, _ms) {
    ev.preventDefault();
    animate_scroll_to_top($, _dom, _ms);
});

$('body').on('click', '.filter-cat-icon-mobile', function() {
    var _this_click = $(this);
    
    if (!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        
        if ($('#nasa-mobile-cat-filter .nasa-tmpl').length) {
            var _content = $('#nasa-mobile-cat-filter .nasa-tmpl').html();
            $('#nasa-mobile-cat-filter .nasa-tmpl').replaceWith(_content);
        }
        
        $('.nasa-top-cat-filter-wrap-mobile').addClass('nasa-show');
        $('.transparent-mobile').fadeIn(300);
        
        setTimeout(function() {
            $(_this_click).removeClass('nasa-disable');
        }, 600);
    }
});

$('body').on('click', '.nasa-close-filter-cat, .nasa-tranparent-filter', function() {
    $('.nasa-elements-wrap').removeClass('nasa-invisible');
    $('#header-content .nasa-top-cat-filter-wrap').removeClass('nasa-show');
    $('.nasa-tranparent-filter').remove();
    $('.transparent-mobile').trigger('click');
});

/**
 * Show coupon in shopping cart
 */
$('body').on('click', '.nasa-show-coupon', function() {
    if ($('.nasa-coupon-wrap').length === 1) {
        $('.nasa-coupon-wrap').toggleClass('nasa-active');
        setTimeout(function() {
            $('.nasa-coupon-wrap.nasa-active input[name="coupon_code"]').trigger('focus');
        }, 100);
    }
});

/**
 * Topbar toggle
 */
$('body').on('click', '.nasa-topbar-wrap .nasa-icon-toggle', function() {
    var _wrap = $(this).parents('.nasa-topbar-wrap');
    $(_wrap).toggleClass('nasa-topbar-hide');
});

$('body').on('click', '.black-window-mobile', function() {
    $(this).removeClass('nasa-push-cat-show');
    $('.nasa-push-cat-filter').removeClass('nasa-push-cat-show');
    $('.nasa-products-page-wrap').removeClass('nasa-push-cat-show');
});

$('body').on('click', '.nasa-widget-show-more a.nasa-widget-toggle-show', function() {
    var _showed = $(this).attr('data-show');
    var _text = '';
    
    if (_showed === '0') {
        _text = $('input[name="nasa-widget-show-less-text"]').length ? $('input[name="nasa-widget-show-less-text"]').val() : 'Less -';
        $(this).attr('data-show', '1');
        $('.nasa-widget-toggle.nasa-widget-show-less').addClass('nasa-widget-show');
    } else {
        _text = $('input[name="nasa-widget-show-more-text"]').length ? $('input[name="nasa-widget-show-more-text"]').val() : 'More +';
        $(this).attr('data-show', '0');
        $('.nasa-widget-toggle.nasa-widget-show-less').removeClass('nasa-widget-show');
    }
    
    $(this).html(_text);
});

$('body').on('click', '.nasa-mobile-icons-wrap .nasa-toggle-mobile_icons', function() {
    $(this).parents('.nasa-mobile-icons-wrap').toggleClass('nasa-hide-icons');
});

/**
 * Buy Now for Quick view and single product page
 */
$('body').on('click', 'form.cart .nasa-buy-now', function() {
    if (!$(this).hasClass('nasa-waiting')) {
        $(this).addClass('nasa-waiting');
        
        var _form = $(this).parents('form.cart');
        if ($(_form).find('.single_add_to_cart_button.disabled').length) {
            $(this).removeClass('nasa-waiting');
            $(_form).find('.single_add_to_cart_button.disabled').trigger('click');
        } else {
            if ($(_form).find('input[name="nasa_buy_now"]').length) {
                if ($('input[name="nasa-enable-addtocart-ajax"]').length) {
                    $('input[name="nasa-enable-addtocart-ajax"]').val('0');
                }
                $(_form).find('input[name="nasa_buy_now"]').val('1');
                $(_form).find('.single_add_to_cart_button').trigger('click');
            }
        }
    }
    
    return false;
});

/**
 * Toggle Widget
 */
$('body').on('click', '.nasa-toggle-widget', function() {
    var _this = $(this);
    var _widget = $(_this).parents('.widget');
    var _key = $(_widget).attr('id');
    
    if ($(_widget).length && $(_widget).find('.nasa-open-toggle').length) {
        var _hide = $(_this).hasClass('nasa-hide');
        if (!_hide) {
            $(_this).addClass('nasa-hide');
            $(_widget).find('.nasa-open-toggle').slideUp(200);
            $.cookie(_key, 'hide', {expires: 7, path: '/'});
        } else {
            $(_this).removeClass('nasa-hide');
            $(_widget).find('.nasa-open-toggle').slideDown(200);
            $.cookie(_key, 'show', {expires: 7, path: '/'});
        }
    }
});

$('body').on('click', '.woocommerce-notices-wrapper .nasa-close-notice', function() {
    var _this = $(this).parents('.woocommerce-notices-wrapper');
    $(_this).html('');
});

/**
 * Bar icons bottom in mobile detect
 */
if ($('.nasa-bottom-bar-icons').length) {
    if ($('.top-bar-wrap-type-1').length) {
        $('body').addClass('nasa-top-bar-in-mobile');
    }
    
    if ($('.toggle-topbar-shop-mobile, .nasa-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar').length || ($('.dokan-single-store').length && $('.dokan-store-sidebar').length)) {
        $('.nasa-bot-item.nasa-bot-item-sidebar').removeClass('hidden-tag');
    } else {
        $('.nasa-bot-item.nasa-bot-item-search').removeClass('hidden-tag');
    }
    
    var col = $('.nasa-bottom-bar-icons .nasa-bot-item').length - $('.nasa-bottom-bar-icons .nasa-bot-item.hidden-tag').length;;
    if (col) {
        $('.nasa-bottom-bar-icons').addClass('nasa-' + col.toString() + '-columns');
    }
    
    $('.nasa-bottom-bar-icons').addClass('nasa-active');
    
    $('body').css({'padding-bottom': $('.nasa-bottom-bar-icons').outerHeight()});
    
    /**
     * Event sidebar in bottom mobile layout
     */
    $('body').on('click', '.nasa-bot-icon-sidebar', function() {
        $('.toggle-topbar-shop-mobile, .nasa-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar, .toggle-sidebar-dokan').trigger('click');
    });
    
    /**
     * Event cart sidebar in bottom mobile layout
     */
    $('body').on('click', '.botbar-cart-link', function() {
        if ($('.cart-link').length) {
            $('.cart-link').trigger('click');
        }
    });
    
    /**
     * Event search in bottom mobile layout
     */
    $('body').on('click', '.botbar-mobile-search', function() {
        if ($('.mobile-search').length) {
            $('.mobile-search').trigger('click');
        }
    });
    
    /**
     * Event Wishlist sidebar in bottom mobile layout
     */
    $('body').on('click', '.botbar-wishlist-link', function() {
        if ($('.wishlist-link').length) {
            $('.wishlist-link').trigger('click');
        }
    });
}

/**
 * notification free shipping
 */
setTimeout(function() {
    init_shipping_free_notification($);
}, 1000);

/**
 * Hover product-item in Mobile
 */
$('body').on("touchstart", '.product-item', function() {
    $('.product-item').removeClass('nasa-mobile-hover');
    if (!$(this).hasClass('nasa-mobile-hover')) {
        $(this).addClass('nasa-mobile-hover');
    }
});

/**
 * GDPR Notice
 */
// $.cookie('nasa_gdpr_notice', '0', {expires: 30, path: '/'});
if ($('.nasa-cookie-notice-container').length) {
    var nasa_gdpr_notice = $.cookie('nasa_gdpr_notice');
    if (typeof nasa_gdpr_notice === 'undefined' || !nasa_gdpr_notice || nasa_gdpr_notice === '0') {
        setTimeout(function() {
            $('.nasa-cookie-notice-container').addClass('nasa-active');
        }, 1000);
    }
    
    $('body').on('click', '.nasa-accept-cookie', function() {
        $.cookie('nasa_gdpr_notice', '1', {expires: 30, path: '/'});
        $('.nasa-cookie-notice-container').removeClass('nasa-active');
    });
}

/**
 * Remove title attribute of menu item
 */
$('body').on('mousemove', '.menu-item > a', function() {
    if ($(this).attr('title')) {
        $(this).removeAttr('title');
    }
});

/**
 * Captcha register form
 */
if ($('#tmpl-captcha-field-register').length) {
    $('body').on('click', '.nasa-reload-captcha', function() {
        var _time = $(this).attr('data-time');
        var _key = $(this).attr('data-key');
        _time = parseInt(_time) + 1;
        $(this).attr('data-time', _time);
        var _form = $(this).parents('form');
        $(_form).find('.nasa-img-captcha').attr('src', '?nasa-captcha-register=' + _key + '&time=' + _time);
    });

    var _count_captcha;
    if ($('.nasa-reload-captcha').length) {
        _count_captcha = parseInt($('.nasa-reload-captcha').first().attr('data-key'));
    } else {
        _count_captcha = 0;
    }
    var _captcha_row = $('#tmpl-captcha-field-register').html();
    if (_captcha_row) {
        $('.nasa-form-row-captcha').each(function() {
            _count_captcha = _count_captcha + 1;
            var _row = _captcha_row.replace(/{{key}}/g, _count_captcha);
            $(this).replaceWith(_row);
        });
    }

    $('body').on('nasa_after_load_static_content', function() {
        if ($('.nasa-form-row-captcha').length) {
            if ($('.nasa-reload-captcha').length) {
                _count_captcha = parseInt($('.nasa-reload-captcha').first().attr('data-key'));
            } else {
                _count_captcha = 0;
            }
            $('.nasa-form-row-captcha').each(function() {
                _count_captcha = _count_captcha + 1;
                var _row = _captcha_row.replace(/{{key}}/g, _count_captcha);
                $(this).replaceWith(_row);
            });
        }
    });

    $('body').on('nasa_after_process_register', function() {
        if ($('.nasa_register-form').find('.nasa-error').length) {
            $('.nasa_register-form').find('.nasa-reload-captcha').trigger('click');
            $('.nasa_register-form').find('.nasa-text-captcha').val('');
        }
    });
}

/**
 * Back to Top
 */
$('body').on('click', '#nasa-back-to-top', function() {
    $('html, body').animate({scrollTop: 0}, 800);
});

/**
 * After loaded ajax store
 */
$('body').on('nasa_after_loaded_ajax_complete', function(e, destroy_masonry) {
    e.preventDefault();
    after_load_ajax_list($, destroy_masonry);
    init_accordion($);
    init_menu_mobile($, true);
});

/**
 * Single Product Add to cart
 */
$('body').on('nasa_single_add_to_cart', function(_ev, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist) {
    nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist);
    
    _ev.preventDefault();
});

/**
 * Change Countdown for variation - Quick view
 */
$('body').on('nasa_changed_countdown_variable_single', function() {
    $('body').trigger('nasa_load_countdown');
});

/**
 * Update Quantity mini cart
 */
$('body').on('change', '.mini-cart-item .qty', function() {
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quantity_mini_cart');
        var _input = $(this);
        var _wrap = $(_input).parents('.mini-cart-item');
        var _hash = $(_input).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
        var _max = parseFloat($(_input).attr('max'));
        if (!_max) {
            _max = false;
        }
        
        var _quantity = parseFloat($(_input).val());
        
        var _old_val = parseFloat($(_input).attr('data-old'));
        if (!_old_val) {
            _old_val = _quantity;
        }
        
        if (_max > 0 && _quantity > _max) {
            $(_input).val(_max);
            _quantity = _max;
        }
        
        if (_old_val !== _quantity) {
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    hash: _hash,
                    quantity: _quantity
                },
                beforeSend: function () {
                    if (!$(_wrap).hasClass('nasa-loading')) {
                        $(_wrap).addClass('nasa-loading');
                    }

                    if ($(_wrap).find('nasa-loader').length <= 0) {
                        $(_wrap).append('<div class="nasa-loader"></div>');
                    }
                },
                success: function (data) {
                    if (data && data.fragments) {

                        $.each(data.fragments, function(key, value) {
                            if ($(key).length) {
                                $(key).replaceWith(value);
                            }
                        });

                        if (typeof $supports_html5_storage !== 'undefined' && $supports_html5_storage) {
                            sessionStorage.setItem(
                                wc_cart_fragments_params.fragment_name,
                                JSON.stringify(data.fragments)
                            );
                            set_cart_hash(data.cart_hash);

                            if (data.cart_hash) {
                                set_cart_creation_timestamp();
                            }
                        }

                        $(document.body).trigger('wc_fragments_refreshed');

                        /**
                         * notification free shipping
                         */
                        init_shipping_free_notification($);
                    }

                    $('#cart-sidebar').find('.nasa-loader').remove();
                },
                error: function () {
                    $(document.body).trigger('wc_fragments_ajax_error');
                    $('#cart-sidebar').find('.nasa-loader').remove();
                    $('#cart-sidebar').find('.nasa-loading').removeClass('nasa-loading');
                }
            });
        }
    }
});

if ($('.nasa-trigger-click').length) {
    setTimeout(function() {
        $('.nasa-trigger-click').trigger('click');
    }, 100);
}

/**
 * For Header Builder Icon menu mobile switcher
 */
if ($('.header-type-builder').length && $('.nasa-nav-extra-warp').length <= 0) {
    $('body').append('<div class="nasa-nav-extra-warp nasa-show"><div class="desktop-menu-bar"><div class="mini-icon-mobile"><a href="javascript:void(0);" class="nasa-mobile-menu_toggle bar-mobile_toggle"><span class="fa fa-bars"></span></a></div></div></div>');
}

/**
 * Append Style Off Canvas
 */
$('body').on('nasa_append_style_off_canvas', function() {
    if ($('#nasa-style-off-canvas').length && $('#elessi-style-off-canvas-css').length <= 0) {
        var _link_style = $('#nasa-style-off-canvas').html();
        $('head').append(_link_style);
        $('#nasa-style-off-canvas').remove();
    }
});

/**
 * Delay Click yith wishlist
 */
if ($('.nasa_yith_wishlist_premium-wrap').length && $('.nasa-wishlist-count.wishlist-number').length) {
    $(document).ajaxComplete(function() {
        setTimeout(function() {
            $('.nasa_yith_wishlist_premium-wrap').each(function() {
                var _this = $(this);
                if (!$(_this).parents('.wishlist_sidebar').length) {
                    var _countWishlist = $(_this).find('.wishlist_table tbody tr .wishlist-empty').length ? '0' : $(_this).find('.wishlist_table tbody tr').length;
                    $('.nasa-mini-number.wishlist-number').html(_countWishlist);

                    if (_countWishlist === '0') {
                        $('.nasa-mini-number.wishlist-number').addClass('nasa-product-empty');
                    }
                }
            });
        }, 300);
    }).ajaxError(function() {
        console.log('Error with wishlist premium.');
    });
}

/**
 * Load Content Static Blocks
 */
if (
    typeof nasa_ajax_params !== 'undefined' &&
    typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
) {
    var _urlAjaxStaticContent = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_ajax_static_content');

    var _data_static_content = {};
    var _call_static_content = false;

    if ($('input[name="nasa_yith_wishlist_actived"]').length) {
        _data_static_content['reload_yith_wishlist'] = '1';
        _call_static_content = true;
    }

    if ($('input[name="nasa-caching-enable"]').length && $('input[name="nasa-caching-enable"]').val() === '1') {
        if ($('.nasa-login-register-ajax').length) {
            _data_static_content['reload_my_account'] = '1';
            _call_static_content = true;
        }

        if ($('.nasa-hello-acc').length) {
            _data_static_content['reload_login_register'] = '1';
            _call_static_content = true;
        }
    }

    if (_call_static_content) {
        if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
            $('.nasa-value-gets').find('input').each(function() {
                var _key = $(this).attr('name');
                var _val = $(this).val();
                _data_static_content[_key] = _val;
            });
        }

        $.ajax({
            url: _urlAjaxStaticContent,
            type: 'post',
            data: _data_static_content,
            cache: false,
            success: function(result) {
                if (typeof result !== 'undefined' && result.success === '1') {
                    $.each(result.content, function(key, value) {
                        if ($(key).length) {
                            $(key).replaceWith(value);

                            if (key === '#nasa-wishlist-sidebar-content') {
                                init_wishlist_icons($);
                            }
                        }
                    });
                }

                $('body').trigger('nasa_after_load_static_content');
            }
        });
    }
}

/**
 * Fix vertical mega menu
 */
if ($('.vertical-menu-wrapper').length) {
    $('.vertical-menu-wrapper').attr('data-over', '0');

    $('.vertical-menu-container').each(function() {
        var _this = $(this);
        var _h_vertical = $(_this).height();
        $(_this).find('.nasa-megamenu >.nav-dropdown').each(function() {
            $(this).find('>.sub-menu').css({'min-height': _h_vertical});
        });
    });
}

$(".gallery a[href$='.jpg'], .gallery a[href$='.jpeg'], .featured-item a[href$='.jpeg'], .featured-item a[href$='.gif'], .featured-item a[href$='.jpg'], .page-featured-item .slider > a, .page-featured-item .page-inner a > img, .gallery a[href$='.png'], .gallery a[href$='.jpeg'], .gallery a[href$='.gif']").parent().magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: '<div class="nasa-loader"></div>',
    tClose: $('input[name="nasa-close-string"]').val(),
    mainClass: 'my-mfp-zoom-in',
    gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1]
    },
    image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    }
});

/**
 * Accordions
 */
init_accordion($);

/**
 * Tabs Slide
 */
if ($('.nasa-tabs.nasa-slide-style').length) {
    $('.nasa-slide-style').each(function() {
        var _this = $(this);
        nasa_tab_slide_style($, _this, 500);
    });
}

if ($('.nasa-active').length) {
    $('.nasa-active').each(function() {
        if ($(this).parents('.nasa-show-less').length) {
            $(this).parents('.nasa-show-less').show();
        }
    });
}

/**
 * Retina logo
 */
if ($('.nasa-logo-retina').length) {
    var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
    if (pixelRatio > 1) {
        var _image_width, _image_height;
        var _src_retina = '';

        var _init_retina = setInterval(function() {
            $('.nasa-logo-retina img').each(function() {
                var _this = $(this);

                if (!$(_this).hasClass('nasa-inited') && !$(_this).hasClass('logo_sticky') && !$(_this).hasClass('logo_mobile') && $(_this).width() && $(_this).height()) {
                    if (typeof _src_retina === 'undefined' || _src_retina === '') {
                        _src_retina = $(_this).attr('data-src-retina');
                    }

                    if (typeof _src_retina !== 'undefined' && _src_retina !== '') {
                        var _fix_size = $(_this).parents('.nasa-no-fix-size-retina').length === 1 ? false : true;
                        _image_width = _image_height = 'auto';

                        if (_fix_size) {
                            var _w = parseInt($(_this).attr('width'));
                            _image_width = _w ? _w : $(_this).width();

                            var _h = parseInt($(this).attr('height'));
                            _image_height = _h ? _h : $(_this).height();
                        }

                        if ((_image_width && _image_height) || _image_width === 'auto') {
                            $(_this).css("width", _image_width);
                            $(_this).css("height", _image_height);

                            $(_this).attr('src', _src_retina);
                            $(_this).removeAttr('srcset');
                        }

                        $(_this).addClass('nasa-inited');
                    }
                }

                if ($('.nasa-logo-retina img').length === $('.nasa-logo-retina img.nasa-inited').length) {
                    clearInterval(_init_retina);
                }
            });
        }, 50);
    }
}

/**
 * init Mini wishlist icon
 */
init_mini_wishlist($);

/**
 * init wishlist icon
 */
init_wishlist_icons($);

/**
 * init Compare icons
 */
init_compare_icons($, true);

/**
 * init Widgets
 */
init_widgets($);

/**
 * Recount group icons in Header
 */
$('body').on('nasa_before_load_ajax', function() {
    if ($('.cart-inner').length) {
        $('.cart-inner').each(function() {
            _nasa_cart['.cart-inner'] = $(this);
            
            return true;
        });
    }
});

$('body').on('nasa_after_load_ajax', function() {
    /**
     * Refress Cart icon
     */
    if (typeof _nasa_cart['.cart-inner'] !== 'undefined') {
        $('.cart-inner').replaceWith(_nasa_cart['.cart-inner']);
    }
    
    /**
     * init Mini wishlist icon
     */
    init_mini_wishlist($);
    
    /**
     * init Compare icons
     */
    init_compare_icons($, true);
});

/**
 * Notice Woocommerce
 */
if (!$('body').hasClass('woocommerce-cart')) {
    $('.woocommerce-notices-wrapper').each(function() {
        var _this = $(this);
        setTimeout(function() {
            if ($(_this).find('a').length <= 0) {
                $(_this).html('');
            }

            if ($(_this).find('.woocommerce-message').length) {
                $(_this).find('.woocommerce-message').each(function() {
                    if ($(this).find('a').length <= 0) {
                        $(this).fadeOut(200);
                    }
                });
            }
        }, 3000);
    });
}

init_nasa_notices($);

/**
 * Check wpadminbar
 */
if ($('#wpadminbar').length) {
    $("head").append('<style media="screen">#wpadminbar {position: fixed !important;}</style>');

    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;

    var height_adminbar = $('#wpadminbar').height();
    $('#cart-sidebar, #nasa-wishlist-sidebar, #nasa-viewed-sidebar, #nasa-quickview-sidebar, .nasa-top-cat-filter-wrap-mobile, .nasa-side-sidebar').css({'top' : height_adminbar});

    if (_mobileView || _inMobile) {
        $('.col-sidebar').css({'top' : height_adminbar});
    }

    $(window).on('resize', function() {
        _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        height_adminbar = $('#wpadminbar').height();

        $('#cart-sidebar, #nasa-wishlist-sidebar, #nasa-viewed-sidebar, #nasa-quickview-sidebar, .nasa-top-cat-filter-wrap-mobile, .nasa-side-sidebar').css({'top' : height_adminbar});

        if (_mobileView || _inMobile) {
            $('.col-sidebar').css({'top' : height_adminbar});
        }
    });
}

$(window).trigger('scroll').trigger('resize');

/**
 * Check if a node is blocked for processing.
 *
 * @param {JQuery Object} $node
 * @return {bool} True if the DOM Element is UI Blocked, false if not.
 */
var nasa_is_blocked = function($node) {
    return $node.is('.processing') || $node.parents('.processing').length;
};

/**
 * Block a node visually for processing.
 *
 * @param {JQuery Object} $node
 */
var nasa_block = function($node) {
    if (!nasa_is_blocked($node)) {
        var $color = $('body').hasClass('nasa-dark') ? '#000' : '#fff';
        
        $node.addClass('processing').block({
            message: null,
            overlayCSS: {
                background: $color,
                opacity: 0.6
            }
        });
    }
};

/**
 * Unblock a node after processing is complete.
 *
 * @param {JQuery Object} $node
 */
var nasa_unblock = function($node) {
    $node.removeClass('processing').unblock();
};

/* End Document Ready */
});
