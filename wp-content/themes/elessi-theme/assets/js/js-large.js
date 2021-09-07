/* Document ready */
jQuery(document).ready(function($) {
"use strict";

/**
 * Fix vertical mega menu
 */
var width_default = 200;
$('body').on('mousemove', '.vertical-menu-container .nasa-megamenu', function() {
    var _wrap = $(this).parents('.vertical-menu-wrapper');
    var _h_vertical = $(_wrap).outerHeight();

    $(_wrap).find('.nasa-megamenu').removeClass('nasa-curent-hover');
    $(_wrap).addClass('nasa-curent-hover');

    /**
     * For WPBakery
     */
    var _row = $(_wrap).parents('.row').length ? $(_wrap).parents('.row') : $(_wrap).parents('.nasa-row');
    
    /**
     * For Elementor
     */
    if ($(_row).length <= 0) {
        _row = $(_wrap).parents('.elementor-container');
    }
    
    var _w_mega, _w_mega_df, _w_ss;
    var total_w = $(_row).length ? $(_row).width() : 900;

    $(_wrap).find('.nasa-megamenu').each(function() {
        var _this = $(this);

        var current_w = $(_this).outerWidth();
        _w_mega = _w_mega_df = total_w - current_w;

        if ($(_this).hasClass('cols-5') || $(_this).hasClass('fullwidth')) {
            _w_mega = _w_mega - 20;
        } else {
            if ($(_this).hasClass('cols-2')) {
                _w_mega = _w_mega / 5 * 2 + 50;
                _w_ss = width_default * 2;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
            else if ($(_this).hasClass('cols-3')) {
                _w_mega = _w_mega / 5 * 3 + 50;
                _w_ss = width_default * 3;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
            else if ($(_this).hasClass('cols-4')) {
                _w_mega = _w_mega / 5 * 4 + 50;
                _w_ss = width_default * 4;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
        }

        $(_this).find('>.nav-dropdown').css({'width': _w_mega});
        if ($(_this).find('>.nav-dropdown >.sub-menu').length) {
            $(_this).find('>.nav-dropdown >.sub-menu').css({'min-height': _h_vertical});
        }
    });
});

$('body').on('mouseover', '.vertical-menu-wrapper .menu-item-has-children.default-menu', function() {
    var _wrap = $(this).parents('.vertical-menu-wrapper');
    $(this).find('> .nav-dropdown > .sub-menu').css({'width': width_default});

    /**
     * For WPBakery
     */
    var _row = $(_wrap).parents('.row').length ? $(_wrap).parents('.row') : $(_wrap).parents('.nasa-row');
    
    /**
     * For Elementor
     */
    if ($(_row).length <= 0) {
        _row = $(_wrap).parents('.elementor-container');
    }

    var _w_mega, _w_mega_df, _w_ss;
    var total_w = $(_row).length ? $(_row).width() : 900;

    $(_wrap).find('.nasa-megamenu').each(function() {
        var _this = $(this);

        var current_w = $(_this).outerWidth();
        _w_mega = _w_mega_df = total_w - current_w;

        if ($(_this).hasClass('cols-5') || $(_this).hasClass('fullwidth')) {
            _w_mega = _w_mega - 20;
        } else {
            if ($(_this).hasClass('cols-2')) {
                _w_mega = _w_mega / 5 * 2 + 50;
                _w_ss = width_default * 2;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
            else if ($(_this).hasClass('cols-3')) {
                _w_mega = _w_mega / 5 * 3 + 50;
                _w_ss = width_default * 3;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
            else if ($(_this).hasClass('cols-4')) {
                _w_mega = _w_mega / 5 * 4 + 50;
                _w_ss = width_default * 4;
                _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
            }
        }

        $(_this).find('>.nav-dropdown').css({'width': _w_mega});
    });
});

/**
 * Header Responsive
 */
init_header_responsive($);

/**
 * Fix width menu vertical
 */
resize_megamenu_vertical($);

var _loadingBeforeResize = setTimeout(function() {
    /**
     * Main menu Reponsive
     */
    load_responsive_main_menu($);
}, 5);

$(window).on('resize', function() {
    /* Fix width menu vertical */
    if ($('.wide-nav .nasa-vertical-header').length) {
        var _v_width = $('.wide-nav .nasa-vertical-header').width();
        _v_width = _v_width < 280 ? 280: _v_width;
        $('.wide-nav .vertical-menu-container').css({'width': _v_width});
    }
    
    if ($('.nasa-modern-layout.nasa-show').length) {
        var _form_search = $('.nasa-modern-layout.nasa-show');
        $('body').trigger('search_icon_position', [_form_search]);
    }
    
    /**
     * Header Responsive
     */
    init_header_responsive($);
    
    /**
     * Active Filter cat top
     */
    init_top_categories_filter($);
    
    clearTimeout(_loadingBeforeResize);
    _loadingBeforeResize = setTimeout(function() {
        /**
         * Main menu Reponsive
         */
        load_responsive_main_menu($);
    }, 1100);
});

$('body').on('nasa_init_topbar_categories', function() {
    init_top_categories_filter($);
});

/**
 * nasa-top-cat-filter
 */
init_top_categories_filter($);

/**
 * hover top categories filter
 */
$('body').on('mouseover', '.nasa-top-cat-filter .root-item', function() {
    var _obj = $(this),
        _wrap = $(_obj).parents('.nasa-top-cat-filter');

    $(_wrap).find('.root-item').removeClass('nasa-current-top');
    $(_obj).addClass('nasa-current-top');

    var _pos = $(_obj).position();
    var _note_act = $(_wrap).find('> .nasa-current-note');

    $(_note_act).css({
        width: $(_obj).width(),
        left: _pos.left,
        top: ($(_obj).height() - 1)
    });

    return false;
});

/**
 * hover top child categories filter
 */
$('body').on('mouseover', '.nasa-top-cat-filter .children .cat-item', function() {
    var _obj = $(this),
        _wrap = $(_obj).parent('.children');
    var _note_act = $(_wrap).find('>.nasa-current-note');

    if ($(_note_act).length <= 0) {
        $(_wrap).prepend('<li class="nasa-current-note"></li>');
        _note_act = $(_wrap).find('>.nasa-current-note');
    }

    $(_wrap).find('.cat-item').removeClass('nasa-current-child');
    $(_obj).addClass('nasa-current-child');

    var _pos = $(_obj).position();
    $(_note_act).css({
        width: $(_obj).width(),
        left: _pos.left,
        top: ($(_obj).height() - 1)
    });

    return false;
});

/**
 * In Desktop Search
 * @type Boolean
 */
var _hotkeyInit = false;
$('body').on('click', '.desk-search', function(e) {
    var _this_click = $(this);
    var _root_search = $(_this_click).parents('.nasa-wrap-event-search');
    if ($(_root_search).find('.nasa-tmpl-search').length) {
        var _content = $(_root_search).find('.nasa-tmpl-search').html();
        $(_root_search).find('.nasa-tmpl-search').replaceWith(_content);
    }
    
    if (!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        
        setTimeout(function() {
            var _focus_input = $(_this_click).parents('.nasa-wrap-event-search').find('.nasa-show-search-form');
            var _opened = $(_this_click).attr('data-open');

            if (_opened === '0') {
                $('#header-content').find('.nasa-show-search-form').after('<div class="nasa-tranparent" />');
            } else {
                $('#header-content').find('.nasa-tranparent').remove();
            }
            
            $('body').trigger('search_icon_position', [_focus_input]);

            $('.desk-search').each(function() {
                var _this = $(this);
                var _root_wrap = $(_this).parents('.nasa-wrap-event-search');
                var _elements = $(_root_wrap).find('.nasa-elements-wrap');

                var _search = $(_root_wrap).find('.nasa-show-search-form');

                if (typeof _opened === 'undefined' || _opened === '0') {
                    $(_this).attr('data-open', '1');
                    if (!$(_search).hasClass('nasa-show')) {
                        $(_search).addClass('nasa-show');
                    }
                    
                    if (!$(_search).hasClass('nasa-modern-layout')) {
                        $(_elements).addClass('nasa-invisible');
                    }
                } else {
                    $(_this).attr('data-open', '0');
                    if ($(_search).hasClass('nasa-show')) {
                        $(_search).removeClass('nasa-show');
                    }

                    $(_elements).removeClass('nasa-invisible');
                }
            });

            if (_hotkeyInit) {
                setTimeout(function() {
                    $(_this_click).removeClass('nasa-disable');

                    if ($(_focus_input).find('label').length) {
                        $(_focus_input).find('label').trigger('click');
                    }
                }, 1000);
            } else {
                $(_this_click).removeClass('nasa-disable');

                /**
                 * Hot keywords search
                 */
                setTimeout(function() {
                    _hotkeyInit = true;
                    var _oldStr = '';

                    if ($(_focus_input).find('input[name="s"]').length) {
                        var _inputCurrent = $(_focus_input).find('input[name="s"]');
                        _oldStr = $(_inputCurrent).val();

                        if (_oldStr !== '') {
                            $(_inputCurrent).val(_oldStr);
                        }

                        auto_fill_input_placeholder($, _inputCurrent);

                        if ($(_focus_input).find('label').length) {
                            $(_focus_input).find('label').trigger('click');
                        }
                    }
                }, 1000);
            }
        }, 10);
    }
    
    e.preventDefault();
});

$('body').on('search_icon_position', function(e, _form_input) {
    if ($(_form_input).hasClass('nasa-modern-layout')) {
        if ($('#header-content .nasa-tranparent').length && !$('#header-content .nasa-tranparent').hasClass('bg-black')) {
            $('#header-content .nasa-tranparent').addClass('bg-black');
        }
        
        if ($('#wpadminbar').length) {
            var _top = $('#wpadminbar').height();
            $(_form_input).css({'top': _top});
        }

        if ($(_form_input).find('.nasa-icon-submit-page').length) {
            var _icon = $(_form_input).find('.nasa-icon-submit-page');
            var _input_off = $(_form_input).find('input[name="s"]').offset();
            var _width = $('body').hasClass('nasa-rtl') ? 0 : $(_form_input).find('input[name="s"]').width() - $(_icon).width();
            $(_icon).css({
                left: _input_off.left + _width,
                right: 'auto',
                visibility: 'visible',
                opacity: '0.3'
            });
        }
    }
});

/**
 * nasa-top-cat-filter
 */
$('body').on('click', '.filter-cat-icon', function() {
    var _this_click = $(this);
    
    if (!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        
        if ($('#nasa-main-cat-filter .nasa-tmpl').length) {
            var _content = $('#nasa-main-cat-filter .nasa-tmpl').html();
            $('#nasa-main-cat-filter .nasa-tmpl').replaceWith(_content);
            
            if ($('#nasa-main-cat-filter .current-cat').length) {
                $('#nasa-main-cat-filter').find('.current-cat-parent, .current-cat').trigger('mouseover');
            } else {
                $('#nasa-main-cat-filter .root-item:first-child').trigger('mouseover');
            }
        }
        
        $('.nasa-elements-wrap').addClass('nasa-invisible');
        $('#header-content .nasa-top-cat-filter-wrap').addClass('nasa-show');
        if ($('.nasa-has-filter-ajax').length <= 0) {
            $('#header-content .nasa-top-cat-filter-wrap').before('<div class="nasa-tranparent-filter nasa-hide-for-mobile" />');
        }
        
        setTimeout(function() {
            $(_this_click).removeClass('nasa-disable');
        }, 600);
    }
});

$('body').on('mouseover', '.product-item', function() {
    var _this = $(this);
    var _toggle = $('input[name="nasa-toggle-width-product-content"]').length ? parseInt($('input[name="nasa-toggle-width-product-content"]').val()) : 180;
    
    if ($(_this).outerWidth() < _toggle) {
        if (
            $(_this).find('.add-to-cart-grid').length &&
            !$(_this).find('.add-to-cart-grid').hasClass('nasa-disabled-hover')
        ) {
            $(_this).find('.add-to-cart-grid').addClass('nasa-disabled-hover');
        }
        
        if (
            $(_this).find('.nasa-sc-pdeal-countdown')  &&
            !$(_this).find('.nasa-sc-pdeal-countdown').hasClass('nasa-countdown-small')) {
            $(_this).find('.nasa-sc-pdeal-countdown').addClass('nasa-countdown-small');
        }
    } else {
        if ($(_this).find('.add-to-cart-grid').length) {
            $(_this).find('.add-to-cart-grid').removeClass('nasa-disabled-hover');
        }
        
        if ($(_this).find('.nasa-sc-pdeal-countdown')) {
            $(_this).find('.nasa-sc-pdeal-countdown').removeClass('nasa-countdown-small');
        }
    }
});

/**
 * For Header Type 5
 */
$('body').on('click', '.nasa-menu-off', function() {
    init_header_responsive($);
    
    if ($('#nasa-menu-sidebar-content').length && !$('#nasa-menu-sidebar-content').hasClass('all-screen')) {
        $('#nasa-menu-sidebar-content').addClass('all-screen');
    }
    
    if ($('.nasa-mobile-menu_toggle').length) {
        $('.nasa-mobile-menu_toggle').trigger('click');
    }
});

/**
 * After loaded ajax store
 */
$('body').on('nasa_after_loaded_ajax_complete', function(e) {
    init_header_responsive($);
    resize_megamenu_vertical($);
    load_responsive_main_menu($);
});

/* End Document Ready */
});

/**
 * Main menu Reponsive
 * 
 * @param {type} $
 * @returns {undefined}
 */
function load_responsive_main_menu($) {
    var _disable = $('body').hasClass('disable-flexible-menu') ? true : false;
    
    if (!_disable) {
        var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;

        if (!_mobileView && !_inMobile && $('.nasa-menus-wrapper-reponsive').length) {
            var _wwin = $(window).width();

            $('.nasa-menus-wrapper-reponsive').each(function() {

                var _this = $(this);

                var _tl = _wwin/1200;
                if (_tl < 1) {
                    var _x = $(_this).attr('data-padding_x');
                    var _params = {'font-size': (100*_tl).toString() + '%'};

                    if (!$('body').hasClass('nasa-rtl')) {
                        _params['margin-right'] = (_tl*_x).toString() + 'px';
                        _params['margin-left'] = '0';
                    } else {
                        _params['margin-left'] = (_tl*_x).toString() + 'px';
                        _params['margin-right'] = '0';
                    }

                    $(_this).find('.header-nav > li > a').css(_params);

                    if ($(_this).find('.nasa-title-vertical-menu').length) {
                        $(_this).find('.nasa-title-vertical-menu').css({
                            'font-size': (100*_tl).toString() + '%'
                        });
                    }
                } else {
                    $(_this).find('.header-nav > li > a').removeAttr('style');
                    if ($(_this).find('.nasa-title-vertical-menu').length) {
                        $(_this).find('.nasa-title-vertical-menu').removeAttr('style');
                    }
                }

                $(_this).removeClass('nasa-loading');
            });
        }
    }
}

/**
 * Resize Menu Vertical
 * 
 * @param {type} $
 * @returns {undefined}
 */
function resize_megamenu_vertical($) {
    if ($('.wide-nav .nasa-vertical-header').length) {
        var _v_width = $('.wide-nav .nasa-vertical-header').width();
        _v_width = _v_width < 280 ? 280: _v_width;
        $('.wide-nav .vertical-menu-container').css({'width': _v_width});
        if ($('.wide-nav .vertical-menu-container.nasa-allways-show').length) {
            $('.wide-nav .vertical-menu-container.nasa-allways-show').addClass('nasa-active');
        }
    }
}

/**
 * Top categories filter
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_top_categories_filter($) {
    if ($('.nasa-top-cat-filter').length) {
        var _act;
        var _obj;

        $('.nasa-top-cat-filter').each(function() {
            var _this_filter = $(this);
            var _root_item = $(_this_filter).find('.root-item');
            _act = false;
            _obj = null;
            if ($(_root_item).length) {

                $(_root_item).each(function() {
                    var _this = $(this);
                    if ($(_this).hasClass('active')) {
                        $(_this).addClass('nasa-current-top');
                        _obj =  $(_this);
                        _act = true;
                    }
                    
                    $(_this).find('.children .nasa-current-note').remove();
                });

                if (!_act) {
                    $(_root_item).each(function() {
                        var _this = $(this);
                        if ($(_this).hasClass('cat-parent') && !_act) {
                            $(_this).addClass('nasa-current-top');
                            _obj =  $(_this);
                            _act = true;
                        }
                    });
                }

                if (_obj !== null) {
                    var init_width = $(_obj).width();
                    if (init_width) {
                        var _pos = $(_obj).position();
                        var _note_act = $(_obj).parents('.nasa-top-cat-filter').find('.nasa-current-note');
                        $(_note_act).css({
                            // visibility: 'visible',
                            width: init_width,
                            left: _pos.left,
                            top: ($(_obj).height() - 1)
                        });
                    }
                }
            }
        });
    }
}

/**
 * init Header Responsive
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_header_responsive($) {
    if ($('#tmpl-nasa-responsive-header').length && ($('.nasa-menu-off').length || ($('.nasa-mobile-check').length && $('.nasa-mobile-check').width()))) {
        if ($('#masthead').length && $('#masthead').find('.header-responsive').length <= 0) {
            var _header = $('#tmpl-nasa-responsive-header').html();
            if (_header !== '') {
                $('#masthead').prepend(_header);
            }
        }
    }
}

/**
 * Auto fill text to input
 * 
 * @param {type} $
 * @param {type} _input
 * @param {type} index
 * @returns {undefined}
 */
function auto_fill_input_placeholder($, _input, index) {
    var _index = typeof index !== 'undefined' ? index : 0;
    if (_index === 0) {
        $(_input).trigger('focus');
    }
    
    if (!$(_input).hasClass('nasa-placeholder')) {
        $(_input).addClass('nasa-placeholder');
        var _place = $(_input).attr('placeholder');
        $(_input).attr('data-placeholder', _place);
    }
    
    var str = $(_input).attr('data-suggestions');
    
    if (str && _index <= str.length) {
        if (!$(_input).hasClass('nasa-filling')) {
            $(_input).addClass('nasa-filling');
        }
        
        $(_input).attr('placeholder', str.substr(0, _index++));
        
        setTimeout(function() {
            auto_fill_input_placeholder($, _input, _index);
        }, 90);
    } else {
        if (!$(_input).hasClass('nasa-done')) {
            $(_input).addClass('nasa-done');
        }
        
        $(_input).removeClass('nasa-filling');
        
        setTimeout(function() {
            reverse_fill_input_placeholder($, _input);
        }, 400);
    }
}

/**
 * Reverse fill text to input
 * 
 * @param {type} $
 * @param {type} _input
 * @param {type} index
 * @returns {undefined}
 */
function reverse_fill_input_placeholder($, _input, index) {
    var _str = $(_input).attr('data-suggestions');
    var _index = typeof index !== 'undefined' ? index : (_str ? _str.length : 0);
    if (_index > 0) {
        $(_input).attr('placeholder', _str.substr(0, _index--));
        
        setTimeout(function() {
            reverse_fill_input_placeholder($, _input, _index);
        }, 20);
    } else {
        var _place = $(_input).attr('data-placeholder');
        $(_input).attr('placeholder', _place);
    }
}
