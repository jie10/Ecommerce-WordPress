var nasa_ajax_setup = true;
var nasa_iOS = nasa_check_iOS(),
    _nasa_event = (nasa_iOS) ? 'click, mousemove' : 'click';
var nasa_countdown_init = '0';
var changeDVnasa = 768;
var img_loaded;
var img_loaded_array = [];

/**
 * Document nasa-core ready
 */
jQuery(document).ready(function($) {
"use strict";

/**
 * Optimize Mega Menu
 */
$('body').on('nasa_render_template', function(e, _this) {
    if ($(_this).find('template').length) {
        $(_this).find('template').each(function() {
            var _tmpl = $(this).html();
            $(this).replaceWith(_tmpl);
        });
    }
});

$('body').on('mouseover', '.nasa-has-tmpl', function() {
    var _this = $(this);
    $('body').trigger('nasa_render_template', [_this]);
});

$('body').on('nasa_before_init_menu_mobile', function() {
    if ($('.nasa-has-tmpl').length) {
        $('.nasa-has-tmpl').each(function() {
            $('body').trigger('nasa_render_template', [this]);
        });
    }
});

/**
 * Countdown
 */
if (typeof nasa_countdown_l10n !== 'undefined') {
    $.countdown.regionalOptions[''] = {
        labels: [
            nasa_countdown_l10n.years,
            nasa_countdown_l10n.months,
            nasa_countdown_l10n.weeks,
            nasa_countdown_l10n.days,
            nasa_countdown_l10n.hours,
            nasa_countdown_l10n.minutes,
            nasa_countdown_l10n.seconds
        ],
        labels1: [
            nasa_countdown_l10n.year,
            nasa_countdown_l10n.month,
            nasa_countdown_l10n.week,
            nasa_countdown_l10n.day,
            nasa_countdown_l10n.hour,
            nasa_countdown_l10n.minute,
            nasa_countdown_l10n.second
        ],
        compactLabels: ['y', 'm', 'w', 'd'],
        whichLabels: null,
        digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
        timeSeparator: ':',
        isRTL: true
    };

    $.countdown.setDefaults($.countdown.regionalOptions['']);
}

load_count_down($);

/* Carousel - Slick Slider */
loading_slick_element($);

/**
 * Init variable product grid
 */
init_variables_products($);

/**
 * Tag clouds
 */
nasa_render_tags_cloud($);

/**
 * Trigger after load ajax
 */
$('body').on('nasa_after_load_ajax', function(){
    /**
     * 
     * Slick slider
     */
    loading_slick_element($);

    /**
     * 
     * Tags Cloud
     */
    nasa_render_tags_cloud($);

    /**
     * Compatible Jetpack
     */
    nasa_compatible_jetpack($);

    /**
     * Countdown
     */
    load_count_down($);

    /**
     * init variations product
     * 
     * @returns {undefined}
     */
    setTimeout(function () {
        init_variables_products($);

        if ($('.nasa-product-content-variable-warp').length) {
            $('.nasa-product-content-variable-warp').each(function() {
                var _this = $(this);
                if (!$(_this).hasClass('nasa-inited')) {
                    $(_this).addClass('nasa-inited');
                    change_image_content_product_variable($, _this, false);
                }
            });
        }
    }, 100);
});

$('body').on('nasa_after_load_ajax_timeout', function() {
    nasa_load_ajax_funcs($);
});

/**
 * Trigger Before load ajax function
 */
$('body').on('nasa_before_ajax_funcs', function() {
    loading_slick_element($);
    
    load_count_down($);
    
    nasa_render_tags_cloud($);
    
    nasa_height_fullwidth_to_side($);
});

/**
 * Click Variants toggle variations product in grid
 */
$('body').on('click', '.nasa-variants-before-click', function() {
    var _click = $(this);
    var _wrap = $(_click).parents('.product-item');

    if (!$(_click).hasClass('loading')) {
        $(_click).addClass('loading');

        if ($(_wrap).find('.nasa-variations-ux-after').length) {
            if ($(_wrap).find('.product-info-wrap').length && !$(_wrap).find('.product-info-wrap').hasClass('nasa-static-focus')) {
                $(_wrap).find('.product-info-wrap').addClass('nasa-static-focus');
            }
            
            if (
                typeof nasa_ajax_params !== 'undefined' &&
                typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
            ) {
                var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_call_variations_product');

                var _pid = $(_click).attr('data-product_id');

                if (_pid) {
                    $.ajax({
                        url : _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            'pid': _pid
                        },
                        beforeSend: function() {
                            if ($(_wrap).length && $(_wrap).find('.nasa-loader').length <= 0) {
                                $(_wrap).append('<div class="nasa-light-fog"></div><div class="nasa-loader"></div>');
                            }
                        },
                        success: function(res) {
                            if (typeof res.empty !== 'undefined' && res.empty === '0') {
                                var _variants_content = '<div class="nasa-fog-variants"></div><div class="nasa-toggle-variants"><a class="nasa-close-variants" href="javascript:void(0);"></a>' + res.variable_str + '</div>';
                                $('.nasa-variations-ux-after.nasa-product-' + _pid).replaceWith(_variants_content);

                                if ($('.nasa-product-content-variable-warp').length) {
                                    $('.nasa-product-content-variable-warp').each(function() {
                                        var _this = $(this);
                                        if (!$(_this).hasClass('nasa-inited')) {
                                            $(_this).addClass('nasa-inited');
                                            change_image_content_product_variable($, _this, false);
                                        }
                                    });
                                }
                            }

                            var _variants = $(_wrap).find('.nasa-toggle-variants');
                            if ($(_variants).length) {
                                if (!$(_variants).hasClass('nasa-open')) {
                                    $(_variants).addClass('nasa-open');
                                }
                            }

                            var _fog = $(_wrap).find('.nasa-fog-variants');
                            if ($(_fog).length) {
                                if (!$(_fog).hasClass('nasa-open')) {
                                    $(_fog).addClass('nasa-open');
                                }
                            }

                            $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                            $(_click).removeClass('loading');
                        },
                        error: function() {
                            $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                            $(_click).removeClass('loading');
                        }
                    });
                }
            }
        } else {
            var _variants = $(_wrap).find('.nasa-toggle-variants');
            if ($(_variants).length) {
                if (!$(_variants).hasClass('nasa-open')) {
                    $(_variants).addClass('nasa-open');
                }
            }

            var _fog = $(_wrap).find('.nasa-fog-variants');
            if ($(_fog).length) {
                if (!$(_fog).hasClass('nasa-open')) {
                    $(_fog).addClass('nasa-open');
                }
            }

            $(_click).removeClass('loading');
        }
    } else {
        return false;
    }
});

/**
 * Close Variants
 */
$('body').on('click', '.nasa-close-variants', function() {
    var _wrap = $(this).parents('.product-item');

    if ($(_wrap).length) {
        var _variants = $(_wrap).find('.nasa-toggle-variants');
        if ($(_variants).length) {
            $(_variants).removeClass('nasa-open');
        }

        var _fog = $(_wrap).find('.nasa-fog-variants');
        if ($(_fog).length) {
            $(_fog).removeClass('nasa-open');
        }
    }
});

/**
 * Click Select Options Load variations product in grid
 */
$('body').on('nasa_after_click_select_option', function(e, _btn) {
    e.preventDefault();

    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_call_variations_product');

        var _pid = $(_btn).attr('data-product_id');

        if (_pid) {
            var _wrap = $(_btn).parents('.product-item');

            $.ajax({
                url : _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    'pid': _pid
                },
                beforeSend: function() {
                    if ($(_wrap).length && $(_wrap).find('.nasa-loader').length <= 0) {
                        $(_wrap).append('<div class="nasa-light-fog"></div><div class="nasa-loader"></div>');
                    }
                },
                success: function(res) {
                    if (typeof res.empty !== 'undefined' && res.empty === '0') {
                        $('.nasa-variations-ux-after.nasa-product-' + _pid).replaceWith(res.variable_str);

                        if ($('.nasa-product-content-variable-warp').length) {
                            $('.nasa-product-content-variable-warp').each(function() {
                                var _this = $(this);
                                if (!$(_this).hasClass('nasa-inited')) {
                                    $(_this).addClass('nasa-inited');
                                    change_image_content_product_variable($, _this, false);
                                }
                            });
                        }

                        $(_btn).removeClass('nasa-before-click');
                    }

                    $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                },
                error: function() {
                    $(_btn).removeClass('nasa-before-click');
                    $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                }
            });
        }
    }
});

/**
 * Nodes Popup
 */
$('body').on('click', '.nasa-node-popup', function() {
    var _target = $(this).attr('data-target');
    if ($(_target).length) {
        /**
         * Close old Magnific
         */
        $.magnificPopup.close();

        /**
         * Open current Magnific
         */
        $.magnificPopup.open({
            mainClass: 'my-mfp-slide-bottom nasa-mfp-max-width',
            items: {
                src: _target,
                type: 'inline'
            },

            closeMarkup: '<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="' + $('input[name="nasa-close-string"]').val() + '"></a>',
            callbacks: {
                beforeClose: function() {
                    this.st.removalDelay = 350;
                },
                afterClose: function() {

                }
            }
        });
        
        $('body').trigger('init_nasa_tabs_not_set');
    }
});

/**
 * Adding info product to contact form 7 ask a question
 * 
 * @type type
 */
if ($('.nasa-popup-content-contact').length) {
    $('.nasa-popup-content-contact').each(function() {
        var _this = $(this);
        if ($(_this).find('.nasa-info-add-form').length && $(_this).find('form.wpcf7-form').length) {
            $(_this).find('form.wpcf7-form').prepend($(_this).find('.nasa-info-add-form').html());
            $(_this).find('.nasa-info-add-form').remove();
        }
    });
}

if ($('.nasa-static-group-btn > a[data-target]').length) {
    $('.nasa-static-group-btn > a[data-target]').each(function() {
        var _this = $(this);
        var _target = $(_this).attr('data-target');

        if ($(_target).length) {
            $(_this).removeClass('hidden-tag');
        } else {
            $(_this).remove();
        }
    });
}

/**
 * Full width to side
 * @type type
 */
var height_fullwidth_to_side = setTimeout(function() {
    /**
     * Fix height for full width to side
     */
    nasa_height_fullwidth_to_side($);
}, 100);

var _load_equal_height_columns = setTimeout(function() {
    /**
     * Equal height columns
     */
    row_equal_height_columns($);
}, 100);

/**
 * Trigger Resize
 */
$(window).on('resize', function() {
    /**
     * Fix height for full width to side
     */
    clearTimeout(height_fullwidth_to_side);
    height_fullwidth_to_side = setTimeout(function() {
        nasa_height_fullwidth_to_side($);
    }, 1100);
    
    /**
     * Equal height columns
     */
    clearTimeout(_load_equal_height_columns);
    _load_equal_height_columns = setTimeout(function() {
        row_equal_height_columns($, false);
    }, 1150);
});

/**
 * Trigger Scroll
 */
var _load_equal_height_columns_scroll;
$(window).on('scroll', function() {
    /**
     * Equal height columns
     */
    clearTimeout(_load_equal_height_columns_scroll);
    _load_equal_height_columns_scroll = setTimeout(function() {
        row_equal_height_columns($, true);
    }, 100);
});

// Next | Prev slider
/**
 * Slick Element
 */
$('body').on('click', '.nasa-nav-icon-slider', function(){
    var _this = $(this);
    var _wrap = $(_this).parents('.nasa-slider-wrap');
    var _slider = $(_wrap).find('.nasa-slick-slider');
    if ($(_slider).length) {
        var _do = $(_this).attr('data-do');
        switch (_do) {
            case 'next':
                $(_slider).find('.slick-next').trigger('click');
                break;
            case 'prev':
                $(_slider).find('.slick-prev').trigger('click');
                break;
            default: break;
        }
    }
});

/**
 * Slick
 */
$('body').on('click', '.nasa-nav-icon-slick', function(){
    var _this = $(this);
    var _wrap = $(_this).parents('.nasa-slider-wrap');
    var _slider = $(_wrap).find('.nasa-nav-out');
    if ($(_slider).length) {
        var _do = $(_this).attr('data-do');
        switch (_do) {
            case 'next':
                $(_slider).find('.slick-arrow.slick-next').trigger('click');
                break;
            case 'prev':
                $(_slider).find('.slick-arrow.slick-prev').trigger('click');
                break;
            default: break;
        }
    }
});

/**
 * Color | Label | Image variations products
 */
$.fn.nasa_attr_ux_variation_form = function() {
    var selected;
    
    return this.each(function() {
        var _form = $(this);
        selected = [];
        
        $(_form).on('click', '.nasa-attr-ux', function(e) {
            e.preventDefault();

            var _el = $(this),
                _select = $(_el).closest('.variation').length ?
                    $(_el).closest('.variation').find('select') : $(_el).closest('.value').find('select'),
                attribute_name = $(_select).data('attribute_name') || $(_select).attr('name'),
                value = $(_el).data('value');

            if ($(_el).hasClass('nasa-disable') || $(_el).hasClass('nasa-processing') || $(_el).hasClass('nasa-processing-deal')) {
                return false;
            }

            else {
                $(_select).trigger('focusin');

                // Check if this combination is available
                if (!$(_select).find('option[value="' + value + '"]').length) {
                    $(_el).siblings('.nasa-attr-ux').removeClass('selected');
                    $(_select).val('').trigger('change');
                    $(_form).trigger('nasa_no_matching_variations', [_el]);
                    return;
                }

                if (selected.indexOf(attribute_name) === -1) {
                    selected.push(attribute_name);
                }

                if ($(_el).hasClass('selected')) {
                    $(_select).val('');
                    $(_el).removeClass('selected');

                    delete selected[selected.indexOf(attribute_name)];
                } else {
                    $(_el).addClass('selected').siblings('.selected').removeClass('selected');
                    $(_select).val(value);
                }

                $(_select).trigger('change');
            }

        }).on('click', '.reset_variations', function() {
            $(this).closest('.variations_form').find('.nasa-attr-ux.selected').removeClass('selected');
            selected = [];
        }).on('nasa_no_matching_variations', function() {
            var text_nomatch = (typeof wc_add_to_cart_variation_params !== 'undefined') ?
                wc_add_to_cart_variation_params.i18n_no_matching_variations_text :
                $('input[name="nasa_no_matching_variations"]').val();
            window.alert(text_nomatch);
        }).on('woocommerce_update_variation_values', function() {
            nasa_refresh_attrs($, _form);
        });
    });
};

$('body').on('before_init_variations_form', function() {
    if ($('.cart').length) {
        $('.cart').each(function() {
            var _cart = $(this);
            var _type = $(_cart).attr('data-type');
            if ((_type === 'variable' || _type === 'variable-subscription') && !$(_cart).hasClass('variations_form')) {
                $(_cart).addClass('variations_form');
                $(_cart).addClass('variations_form-3rd');
                $(_cart).wc_variation_form();
                
                nasa_refresh_attrs($, _cart);
            }
        });
    }
});

/**
 * Init variation forms
 */
$('body').on('nasa_init_ux_variation_form', function() {
    if ($('.variations_form').length) {
        $('.variations_form').each(function() {
            var _form = $(this);
            if (!$(_form).hasClass('nasa-attr-ux-form')) {
                $(_form).addClass('nasa-attr-ux-form');
                $(_form).nasa_attr_ux_variation_form();
                
                nasa_refresh_attrs($, _form);
            }
        });
    }
});

/**
 * Show label attribute when select vatiation
 */
$('body.nasa-label-attr-single').on('check_variations', function() {
    if ($('.nasa-attr-ux-form').length) {
        $('.nasa-attr-ux-form').each(function () {
            var _form = $(this);

            if ($(_form).find('table.variations tr').length) {
                $(_form).find('table.variations tr').each(function() {
                    var _this = $(this);

                    var _label = $(_this).find('td.label label');
                    var _find = $(_this).find('td.value select');

                    var _value = $(_find).val();
                    var _text = false;

                    if (_value) {
                        _text = $(_find).find('option[value="' + _value + '"]').length ? $(_find).find('option[value="' + _value + '"]').text() : _text;
                    }

                    if (_text) {
                        if ($(_label).find('.label-tip').length <= 0) {
                            $(_label).append('<span class="label-tip"></span>');
                        }

                        $(_label).find('.label-tip').html(_text);
                    } else {
                        $(_label).find('.label-tip').remove();
                    }
                });
            }
        });
    }
}).on('reset_data', function () {
    if ($('.nasa-attr-ux-form').length) {
        $('.nasa-attr-ux-form').each(function () {
            $(this).find('td.label label .label-tip').remove();
        });
    }
});

if ($('.nasa-product-content-variable-warp').length) {
    $('.nasa-product-content-variable-warp').each(function() {
        var _this = $(this);
        if (!$(_this).hasClass('nasa-inited')) {
            $(_this).addClass('nasa-inited');
            change_image_content_product_variable($, _this, false);
        }
    });
}

/**
 * Click Variation in Grid
 */
$('body').on('click', '.nasa-attr-ux-item', function() {
    nasa_img_clear_loaded($);
    
    var _this = $(this),
        _wrap = $(_this).parents('.nasa-product-content-child'),
        _act = $(_this).attr('data-act');

    if (!$(_this).hasClass('nasa-disable')) {
        $(_wrap).find('.nasa-attr-ux-item').removeClass('nasa-active').attr('data-act', '0');
        if (_act === '0') {
            $(_this).addClass('nasa-active').attr('data-act', '1');
        }

        var _variations_warp = $(_this).parents('.nasa-product-content-variable-warp');
        if (!$(_variations_warp).hasClass('nasa-inited')) {
            $(_variations_warp).addClass('nasa-inited');
        }

        change_image_content_product_variable($, _variations_warp, true);
        
        setTimeout(function() {
            $('body').trigger('nasa_after_attr_ux_item_click', [_this]);
        }, 100);
    }
});

/**
 * Toggle attribute Select - Custom in Grid
 */
$('body').on('click', '.nasa-toggle-attr-select', function() {
    var _this = $(this);

    if ($(_this).hasClass('nasa-show')) {
        $(_this).removeClass('nasa-show');
        $(_this).parents('.nasa-product-content-child').find('.nasa-toggle-content-attr-select').slideUp(200);
    } else {
        $(_this).addClass('nasa-show');
        $(_this).parents('.nasa-product-content-child').find('.nasa-toggle-content-attr-select').slideDown(200);
    }
});

/**
 * Show viewed sidebar
 */
var _viewed_init = false;
$('body').on('click', '#nasa-init-viewed', function() {
    if (
        !_viewed_init &&
        $('#nasa-viewed-sidebar-content').length &&
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _viewed_init = true;

        var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_viewed_sidebar_content');

        $.ajax({
            url : _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {},
            success: function(res){
                if (typeof res.success !== 'undefined' && res.success === '1') {
                    $('#nasa-viewed-sidebar-content').replaceWith(res.content);

                    if ($('#nasa-viewed-sidebar').find('.item-product-widget').length) {
                        $('#nasa-viewed-sidebar').find('.nasa-sidebar-tit').removeClass('text-center');
                    }
                }
            },
            error: function() {

            }
        });
    }
});

/**
 * After changed Tab content
 */
$('body').on('nasa_after_changed_tab_content', function(ev, currentTab) {
    
});

/**
 * After Slick inited
 */
$('body').on('nasa_inited_slick', function(ev, _this) {
    /**
     * CountDown in Slick
     */
    load_count_down($);
    
    /**
     * Ux variation in slick
     */
    if ($(_this).find('.nasa-product-content-variable-warp').length) {
        $(_this).find('.nasa-product-content-variable-warp').each(function() {
            var _this = $(this);
            if (!$(_this).hasClass('nasa-inited')) {
                $(_this).addClass('nasa-inited');
                change_image_content_product_variable($, _this, false);
            }
        });
    }
    
    /**
     * Banner in slick
     */
    if ($(_this).find('.nasa-banner-image').length) {
        $(_this).on('afterChange', function(_ev, slick, currentSlide) {
            $(_this).find('.slick-slide').each(function(){
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
                        }, 200);
                    }
                }
            });
        });
    }
    
    ev.preventDefault();
});

/**
 * Compatible jetpack
 */
$('body').on('nasa_compatible_jetpack', function() {
    nasa_compatible_jetpack($);
});

/**
 * Before pin banners
 */
$('body').on('nasa_before_pin_banners', function() {
    nasa_compatible_jetpack($);
});

$('body').on('nasa_load_slick_slider', function() {
    loading_slick_element($);
});

$('body').on('nasa_reload_slick_slider', function() {
    loading_slick_element($, true);
});

$('body').on('nasa_unslick', function(ev, _slick) {
    if ($(_slick).hasClass('slick-initialized')) {
        $(_slick).slick('unslick');
    }
});

$('body').on('nasa_after_quickview_timeout', function() {
    loading_slick_element($);
});

$('body').on('nasa_rendered_template', function() {
    nasa_compatible_jetpack($);
    loading_slick_element($);
    load_count_down($);
});

$('body').on('nasa_after_quickview', function() {
    load_count_down($);
});

$('body').on('nasa_load_countdown', function() {
    load_count_down($);
});

/**
 * After push filter categories
 */
$('body').on('nasa_after_push_cats_timeout', function() {
    if ($('.nasa-products-page-wrap .nasa-slick-slider').length) {
        $('.nasa-products-page-wrap .nasa-slick-slider').each(function() {
            var _this = $(this);
            $('body').trigger('nasa_unslick', [_this]);
        });
        
        $('body').trigger('nasa_load_slick_slider');
    }
    
    $(window).trigger('resize');
});

$('body').on('nasa_before_click_single_add_to_cart', function(ev, _form) {
    var _disable = false;
    var _first = false;
    if ($(_form).find('.nasa-ct-fields-toggle').length && $(_form).find('.nasa-ct-fields-toggle').hasClass('nasa-active')) {
        if ($(_form).find('.nasa-ct-field .nasa-require').length) {
            $(_form).find('.nasa-ct-field .nasa-require').removeClass('nasa-error-first');
            $(_form).find('.nasa-ct-field .nasa-require').removeClass('nasa-error');
            $(_form).find('.nasa-ct-field .nasa-require').each(function() {
                var _this = $(this);
                if ($(_this).val() === '') {
                    _disable = true;
                    $(_this).addClass('nasa-error');
                    
                    if (!_first) {
                        _first = true;
                        $(_this).addClass('nasa-error-first');
                    }
                }
            });
        }
        
        if (_disable) {
            if (!$(_form).find('.single_add_to_cart_button').hasClass('nasa-ct-disabled')) {
                $(_form).find('.single_add_to_cart_button').addClass('nasa-ct-disabled');
            }
            
            setTimeout(function() {
                $(_form).find('.nasa-error-first').parents('.nasa-ct-field').find('label').trigger('click');
            }, 100);
        } else {
            $(_form).find('.single_add_to_cart_button').removeClass('nasa-ct-disabled');
        }
    } else {
        $(_form).find('.single_add_to_cart_button').removeClass('nasa-ct-disabled');
    }
    
    ev.preventDefault();
});

/**
 * Customize this item in single product
 */
$('body').on('click', '.nasa-ct-fields-toggle', function() {
    if ($('.nasa-ct-fields-wrap').length) {
        if (!$(this).hasClass('nasa-active')) {
            $(this).addClass('nasa-active');
            $('.nasa-ct-fields-wrap').addClass('nasa-active');
            $('input[name="nasa-ct-fields-check"]').prop('checked', true);
            $('.nasa-ct-fields-wrap').slideDown(200);
        } else {
            $(this).removeClass('nasa-active');
            $('.nasa-ct-fields-wrap').removeClass('nasa-active');
            $('input[name="nasa-ct-fields-check"]').prop('checked', false);
            $('.nasa-ct-fields-wrap').slideUp(200);
        }
    }
});

/**
 * Customize this item in single product simple
 */
if ($('.nasa-ct-fields-add-to-cart').length && $('#nasa-single-product-custom-fields').length) {
    var _html = $('#nasa-single-product-custom-fields').html();
    $('.nasa-ct-fields-add-to-cart').replaceWith(_html);
}

/**
 * Customize this item in Quick view product simple
 */
$('body').on('nasa_after_quickview', function() {
    var _cfs = $('.product-lightbox form.cart .nasa-ct-fields-add-to-cart');
    if ($(_cfs).length) {
        var _html = $('#nasa-single-product-custom-fields').html();
        $(_cfs).replaceWith(_html);
    }
    
    if ($('.product-lightbox .nasa-sa-brands').length) {
        if ($('.product-lightbox .star-rating').length) {
            $('.product-lightbox .star-rating').addClass('nasa-has-sa-brands');
        } else {
            $('.product-lightbox .nasa-sa-brands').addClass('margin-top-10');
        }

        $('.product-lightbox .nasa-sa-brands').addClass('nasa-inited');
    }
});

/**
 * Found variation
 */
var _nasa_custom_fields = [];
var _nasa_bulk_dsct = [];
$('body').on('show_variation', function(ev, variation) {
    var _form = typeof nasa_quick_viewimg !== 'undefined' && nasa_quick_viewimg ? $('.product-lightbox form.variations_form') : $('.product-page form.variations_form');
    
    /**
     * Save old html Custom design
     */
    if ($(_form).find('.nasa-ct-fields-add-to-cart').length) {
        var _old_variation_id = parseInt($(_form).find('.nasa-ct-fields-add-to-cart').attr('data-variation'));
        if (_old_variation_id) {
            var _custom_fields_clone = $(_form).find('.nasa-ct-fields-add-to-cart').clone();
            _nasa_custom_fields[_old_variation_id] = _custom_fields_clone;
        }
    }
    
    if (
        $(_form).length &&
        typeof variation.nasa_custom_fields !== 'undefined' &&
        typeof variation.nasa_custom_fields.nasa_personalize !== 'undefined' &&
        variation.nasa_custom_fields.nasa_personalize === 'yes'
    ) {
        if (typeof _nasa_custom_fields[variation.variation_id] === 'undefined') {
            _nasa_custom_fields[variation.variation_id] = '';
            
            if ($('#nasa-single-product-custom-fields').length) {
                var _html = $('#nasa-single-product-custom-fields').html();
                
                _nasa_custom_fields[variation.variation_id] = _html;
            }
        }
        
        if ($(_form).find('.nasa-ct-fields-add-to-cart').length) {
            $(_form).find('.nasa-ct-fields-add-to-cart').replaceWith(_nasa_custom_fields[variation.variation_id]);
            $(_form).find('.nasa-ct-fields-add-to-cart').attr('data-variation', variation.variation_id);
        }
        
        else if($(_form).find('table.variations').length) {
            $(_form).find('table.variations').after(_nasa_custom_fields[variation.variation_id]);
            $(_form).find('.nasa-ct-fields-add-to-cart').attr('data-variation', variation.variation_id);
        }
    }
    
    else {
        $(_form).find('.nasa-ct-fields-add-to-cart').remove();
    }
    
    /**
     * Bulk Discount for Variation
     */
    if (
        $(_form).length &&
        typeof variation.nasa_custom_fields !== 'undefined' &&
        typeof variation.nasa_custom_fields.dsct_allow !== 'undefined' &&
        variation.nasa_custom_fields.dsct_allow === '1'
    ) {
        var _wrap = $(_form).parents('.product-info');
        var _tmp = $(_wrap).find('.nasa-variation-bulk-dsct');
        if ($(_tmp).length) {
            /**
             * Ajax Call
             */
            if (typeof _nasa_bulk_dsct[variation.variation_id] === 'undefined') {
                if (
                    typeof nasa_ajax_params !== 'undefined' &&
                    typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
                ) {
                    var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_render_bulk_dsct_variation');

                    $.ajax({
                        url : _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {product_id: variation.variation_id},
                        success: function(res){
                            if (typeof res.success !== 'undefined' && res.success === '1') {
                                _nasa_bulk_dsct[variation.variation_id] = res.content;
                                $(_tmp).html(res.content);
                                $(_tmp).fadeIn();
                                
                                $(_wrap).find('input[name="quantity"]').trigger('change');
                            }
                        },
                        error: function() {

                        }
                    });
                }
            } else {
                $(_tmp).html(_nasa_bulk_dsct[variation.variation_id]);
                $(_tmp).fadeIn();
                $(_wrap).find('input[name="quantity"]').trigger('change');
            }
        }
    }
    
    ev.preventDefault();
    
}).on('reset_data', function () {
    var _form = typeof nasa_quick_viewimg !== 'undefined' && nasa_quick_viewimg ? $('.product-lightbox form.variations_form') : $('.product-page form.variations_form');
    
    /**
     * Save old html Custom design
     */
    if ($(_form).find('.nasa-ct-fields-add-to-cart').length) {
        var _old_variation_id = parseInt($(_form).find('.nasa-ct-fields-add-to-cart').attr('data-variation'));
        if (_old_variation_id) {
            var _custom_fields_clone = $(_form).find('.nasa-ct-fields-add-to-cart').clone();
            _nasa_custom_fields[_old_variation_id] = _custom_fields_clone;
        }
    }
    
    $(_form).find('.nasa-ct-fields-add-to-cart').remove();
    
    /**
     * Bulk Discount for Variation
     */
    var _wrap = $(_form).parents('.product-info');
    var _tmp = $(_wrap).find('.nasa-variation-bulk-dsct');
    if ($(_tmp).length) {
        $(_tmp).fadeOut();
        $(_tmp).html('');
    }
    
    $(_wrap).find('.price.nasa-bulk-price').remove();
    $(_wrap).find('.price.nasa-single-product-price').show();
});

/**
 * nasa-tabs-not-set
 */
nasa_tabs_not_set($);
$('body').on('init_nasa_tabs_not_set', function() {
    nasa_tabs_not_set($);
});

/**
 * Nasa Tooltip
 */
$('body').on('mouseover', '.nasa-tip', function() {
    var tip = $(this);
    if (!$(tip).hasClass('nasa-tiped')) {
        $(tip).addClass('nasa-tiped');
        
        var _inMobile = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;

        if (!_inMobile) {
            
            var _content = $(tip).attr('data-tip') || $(tip).attr('title');

            if (!$(tip).hasClass('add-to-cart-grid')) {
                if (_content) {
                    $(tip).append('<span class="nasa-tip-content">' + _content + '</span>');

                    if ($(tip).parents('.nasa-hoz-buttons').length || $(tip).parents('.nasa-masonry-item').length) {
                        $(tip).removeClass('nasa-tip-left');
                        $(tip).removeClass('nasa-tip-right');
                        $(tip).removeClass('nasa-tip-bottom');
                    }
                }
            } else {
                if ($(tip).parents('.nasa-hoz-buttons').length || $(tip).parents('.nasa-masonry-item').length) {
                    if (_content) {
                        $(tip).append('<span class="nasa-tip-content">' + _content + '</span>');

                        $(tip).removeClass('nasa-tip-left');
                        $(tip).removeClass('nasa-tip-right');
                        $(tip).removeClass('nasa-tip-bottom');
                    }
                }
            }

            $(tip).removeAttr('title');
        }
    }
});

/**
 * Click Go to position 0
 */
$('body').on('slick_go_to_0', function(e, _this) {
    if ($(_this).hasClass('slick-initialized')) {
        $(_this).slick('slickGoTo', 0);
    }
});

/**
 * Bulk Discount
 */
var _old_variation_price = [];
$('body').on('click', '.ev-dsc-qty', function() {
    if (!$(this).hasClass('actived')) {
        var _this = $(this);
        $('.ev-dsc-qty').removeClass('actived');
        var qty = $(_this).attr('data-qty');
        var _wrap = $(_this).parents('.product-info');
        $(_wrap).find('input[name="quantity"]').val(qty).trigger('change');
    }
});

$('body').on('change', 'input[name="quantity"]', function() {
    var _this = $(this);
    var _wrap = $(_this).parents('.product-info');

    if ($(_wrap).find('.ev-dsc-qty').length) {
        var _val = parseFloat($(_this).val());

        var _arr_qty = [];
        $(_wrap).find('.ev-dsc-qty').each(function() {
            _arr_qty.push(parseFloat($(this).attr('data-qty')));
        });

        if (_arr_qty.length) {
            _arr_qty.sort(function (a, b) {
                return a - b;
            }).reverse();

            for (var i = 0; i < _arr_qty.length; i++) {
                if (_arr_qty[i] <= _val) {
                    _val = _arr_qty[i];
                    break;
                }
            }
        }

        $(_wrap).find('.ev-dsc-qty').removeClass('actived');

        var _tmp = '';
        if ($(_wrap).find('.ev-dsc-qty[data-qty="' + _val + '"]').length) {
            $(_wrap).find('.ev-dsc-qty[data-qty="' + _val + '"]').addClass('actived');

            _tmp = $(_wrap).find('.ev-dsc-qty[data-qty="' + _val + '"] .tmp-content').html();
        }

        // With variation price
        if ($(_wrap).find('.woocommerce-variation-price>.price').length) {
            var _variation_id = $(_wrap).find('input[name="variation_id"]').val();
            if (typeof _old_variation_price[_variation_id] === 'undefined') {
                _old_variation_price[_variation_id] = $(_wrap).find('.woocommerce-variation-price>.price').html();
            }

            if (_tmp) {
                $(_wrap).find('.woocommerce-variation-price>.price').html(_tmp);
            } else {
                $(_wrap).find('.woocommerce-variation-price>.price').html(_old_variation_price[_variation_id]);
            }
        }

        // Not variation price
        else if ($(_wrap).find('.price.nasa-single-product-price').length) {
            if (_tmp) {
                $(_wrap).find('.price.nasa-single-product-price').hide();
                
                if ($(_wrap).find('.price.nasa-bulk-price').length <= 0) {
                    $(_wrap).find('.price.nasa-single-product-price').after('<p class="price nasa-bulk-price"></p>');
                }
                
                $(_wrap).find('.price.nasa-bulk-price').html(_tmp);
            } else {
                $(_wrap).find('.price.nasa-bulk-price').remove();
                $(_wrap).find('.price.nasa-single-product-price').show();
            }
        }
    }
});
/* End Document nasa-core ready */
});
