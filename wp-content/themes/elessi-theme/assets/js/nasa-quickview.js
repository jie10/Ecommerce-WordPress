/**
 * global nasa_params_quickview
 */
if (typeof _single_variations === 'undefined') {
    var _single_variations = [];
}

var _quicked_gallery = true,
    _nasa_calling_gallery = 0,
    _nasa_calling_countdown = 0,
    _lightbox_variations,
    nasa_quick_viewimg = false;
    
jQuery(document).ready(function($) {
    "use strict";
    
    var _nasa_in_mobile = $('body').hasClass('nasa-in-mobile') ? true : false;
    
    /**
     * Quick view
     */
    var quickview_html = [],
        setMaxHeightQVPU;
        
    $('body').on('click', '.quick-view', function(e) {
        $.magnificPopup.close();
        
        /**
         * Append stylesheet Off Canvas
         */
        $('body').trigger('nasa_append_style_off_canvas');

        if (
            typeof nasa_params_quickview !== 'undefined' &&
            typeof nasa_params_quickview.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = nasa_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quick_view');
            var _this = $(this);
            var _product_type = $(_this).attr('data-product_type');

            if (_product_type === 'woosb' && typeof $(_this).attr('data-href') !== 'undefined') {
                window.location.href = $(_this).attr('data-href');
            }

            else {
                var _wrap = $(_this).parents('.product-item'),
                    product_id = $(_this).attr('data-prod'),
                    _wishlist = ($(_this).attr('data-from_wishlist') === '1') ? '1' : '0';

                if ($(_wrap).length <= 0) {
                    _wrap = $(_this).parents('.item-product-widget');
                }

                if ($(_wrap).length <= 0) {
                    _wrap = $(_this).parents('.wishlist-item-warper');
                }

                if ($(_wrap).length) {
                    $(_wrap).append('<div class="nasa-light-fog"></div><div class="nasa-loader"></div>');
                }

                var _data = {
                    product: product_id,
                    nasa_wishlist: _wishlist
                };

                nasa_quick_viewimg = true;

                if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
                    $('.nasa-value-gets').find('input').each(function() {
                        var _key = $(this).attr('name');
                        var _val = $(this).val();
                        _data[_key] = _val;
                    });
                }

                var sidebar_holder = $('#nasa-quickview-sidebar').length === 1 ? true : false;
                
                if (sidebar_holder && $('#nasa-quickview-sidebar').hasClass('nasa-crazy-load')) {
                    if (!$('#nasa-quickview-sidebar').hasClass('qv-loading')) {
                        $('#nasa-quickview-sidebar').addClass('qv-loading');
                    }
                }

                _data.quickview = sidebar_holder ? 'sidebar' : 'popup';

                var _callAjax = true;

                if (typeof quickview_html[product_id] !== 'undefined') {
                    _callAjax = false;
                }

                if (_callAjax) {
                    $.ajax({
                        url : _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        data: _data,
                        cache: false,
                        beforeSend: function() {
                            if (sidebar_holder) {
                                $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html(
                                    '<div class="nasa-loader"></div>'
                                );
                                $('.black-window').fadeIn(200).addClass('desk-window');
                                $('#nasa-viewed-sidebar').removeClass('nasa-active');

                                if ($('#nasa-quickview-sidebar').length && !$('#nasa-quickview-sidebar').hasClass('nasa-active')) {
                                    $('#nasa-quickview-sidebar').addClass('nasa-active');
                                }
                            }

                            if ($('.nasa-static-wrap-cart-wishlist').length && $('.nasa-static-wrap-cart-wishlist').hasClass('nasa-active')) {
                                $('.nasa-static-wrap-cart-wishlist').removeClass('nasa-active');
                            }

                            if (typeof setMaxHeightQVPU !== 'undefined') {
                                clearInterval(setMaxHeightQVPU);
                            }
                        },
                        success: function(response) {
                            quickview_html[product_id] = response;

                            // Sidebar hoder
                            if (sidebar_holder) {
                                $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html('<div class="product-lightbox">' + response.content + '</div>');

                                setTimeout(function() {
                                    $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content .product-lightbox').addClass('nasa-loaded');
                                }, 200);
                                
                                setTimeout(function() {
                                    if ($('#nasa-quickview-sidebar').hasClass('qv-loading')) {
                                        $('#nasa-quickview-sidebar').removeClass('qv-loading');
                                    }
                                }, 700);
                            }

                            // Popup classical
                            else {
                                $.magnificPopup.open({
                                    mainClass: 'my-mfp-zoom-in',
                                    items: {
                                        src: '<div class="product-lightbox">' + response.content + '</div>',
                                        type: 'inline'
                                    },
                                    // tClose: $('input[name="nasa-close-string"]').val(),
                                    closeMarkup: '<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="' + $('input[name="nasa-close-string"]').val() + '"></a>',
                                    callbacks: {
                                        beforeClose: function() {
                                            this.st.removalDelay = 350;
                                        },
                                        afterClose: function() {
                                            if (typeof setMaxHeightQVPU !== 'undefined') {
                                                clearInterval(setMaxHeightQVPU);
                                            }
                                        }
                                    }
                                });

                                $('.black-window').trigger('click');
                            }

                            /**
                             * Init Gallery image
                             */
                            $('body').trigger('nasa_init_product_gallery_lightbox');

                            if ($(_this).hasClass('nasa-view-from-wishlist')) {
                                $('.wishlist-item').animate({opacity: 1}, 500);
                                if (!sidebar_holder) {
                                    $('.wishlist-close a').trigger('click');
                                }
                            }

                            if ($(_wrap).length) {
                                $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                            }
                            
                            $('body').trigger('before_init_variations_form');

                            var formLightBox = $('.product-lightbox').find('.variations_form');
                            
                            if ($(formLightBox).length) {
                                $(formLightBox).find('.single_variation_wrap').hide();
                                
                                $(formLightBox).each(function () {
                                    var _form_var = $(this);
                                    $('body').trigger('init_quickview_variations_form', [_form_var]);
                                    
                                    $(_form_var).find('select').trigger('change');
                                
                                    if ($(_form_var).find('.variations select option[selected="selected"]').length) {
                                        $(_form_var).find('.variations .reset_variations').css({'visibility': 'visible'}).show();
                                    }
                                });
                            }

                            var groupLightBox = $('.product-lightbox').find('.woocommerce-grouped-product-list-item');
                            if ($(groupLightBox).length) {
                                $(groupLightBox).removeAttr('style');
                                $(groupLightBox).removeClass('wow');
                            }

                            if (!sidebar_holder) {
                                setMaxHeightQVPU = setInterval(function() {
                                    var _h_l = $('.product-lightbox .product-img').outerHeight();

                                    $('.product-lightbox .product-quickview-info').css({
                                        'max-height': _h_l,
                                        'overflow-y': 'auto'
                                    });

                                    if (!$('.product-lightbox .product-quickview-info').hasClass('nasa-active')) {
                                        $('.product-lightbox .product-quickview-info').addClass('nasa-active');
                                    }

                                    if (_nasa_in_mobile) {
                                        clearInterval(setMaxHeightQVPU);
                                    }
                                }, 1000);
                            }

                            $('body').trigger('nasa_after_quickview');

                            setTimeout(function() {
                                $('body').trigger('nasa_after_quickview_timeout');
                            }, 200);
                        }
                    });
                } else {
                    var quicview_obj = quickview_html[product_id];

                    if (sidebar_holder) {
                        $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html(
                            '<div class="nasa-loader"></div>'
                        );
                        $('.black-window').fadeIn(200).addClass('desk-window');
                        $('#nasa-viewed-sidebar').removeClass('nasa-active');

                        if ($('#nasa-quickview-sidebar').length && !$('#nasa-quickview-sidebar').hasClass('nasa-active')) {
                            $('#nasa-quickview-sidebar').addClass('nasa-active');
                        }
                    }

                    if ($('.nasa-static-wrap-cart-wishlist').length && $('.nasa-static-wrap-cart-wishlist').hasClass('nasa-active')) {
                        $('.nasa-static-wrap-cart-wishlist').removeClass('nasa-active');
                    }

                    if (typeof setMaxHeightQVPU !== 'undefined') {
                        clearInterval(setMaxHeightQVPU);
                    }

                    // Sidebar hoder
                    if (sidebar_holder) {
                        $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html('<div class="product-lightbox hidden-tag">' + quicview_obj.content + '</div>');

                        setTimeout(function() {
                            $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content .product-lightbox').show();
                        }, 200);
                        
                        setTimeout(function() {
                            if ($('#nasa-quickview-sidebar').hasClass('qv-loading')) {
                                $('#nasa-quickview-sidebar').removeClass('qv-loading');
                            }
                        }, 700);
                    }

                    // Popup classical
                    else {
                        $.magnificPopup.open({
                            mainClass: 'my-mfp-zoom-in',
                            items: {
                                src: '<div class="product-lightbox">' + quicview_obj.content + '</div>',
                                type: 'inline'
                            },
                            // tClose: $('input[name="nasa-close-string"]').val(),
                            closeMarkup: '<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="' + $('input[name="nasa-close-string"]').val() + '"></a>',
                            callbacks: {
                                beforeClose: function() {
                                    this.st.removalDelay = 350;
                                },
                                afterClose: function() {
                                    if (typeof setMaxHeightQVPU !== 'undefined') {
                                        clearInterval(setMaxHeightQVPU);
                                    }
                                }
                            }
                        });

                        $('.black-window').trigger('click');
                    }

                    /**
                     * Init Gallery image
                     */
                    $('body').trigger('nasa_init_product_gallery_lightbox');

                    if ($(_this).hasClass('nasa-view-from-wishlist')) {
                        $('.wishlist-item').animate({opacity: 1}, 500);
                        if (!sidebar_holder) {
                            $('.wishlist-close a').trigger('click');
                        }
                    }

                    if ($(_wrap).length) {
                        $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                    }
                    
                    $('body').trigger('before_init_variations_form');

                    var formLightBox = $('.product-lightbox').find('.variations_form');

                    if ($(formLightBox).length) {
                        $(formLightBox).find('.single_variation_wrap').hide();

                        $(formLightBox).each(function () {
                            var _form_var = $(this);
                            $('body').trigger('init_quickview_variations_form', [_form_var]);

                            $(_form_var).find('select').trigger('change');

                            if ($(_form_var).find('.variations select option[selected="selected"]').length) {
                                $(_form_var).find('.variations .reset_variations').css({'visibility': 'visible'}).show();
                            }
                        });
                    }

                    var groupLightBox = $('.product-lightbox').find('.woocommerce-grouped-product-list-item');
                    if ($(groupLightBox).length) {
                        $(groupLightBox).removeAttr('style');
                        $(groupLightBox).removeClass('wow');
                    }

                    if (!sidebar_holder) {
                        setMaxHeightQVPU = setInterval(function() {
                            var _h_l = $('.product-lightbox .product-img').outerHeight();

                            $('.product-lightbox .product-quickview-info').css({
                                'max-height': _h_l,
                                'overflow-y': 'auto'
                            });

                            if (!$('.product-lightbox .product-quickview-info').hasClass('nasa-active')) {
                                $('.product-lightbox .product-quickview-info').addClass('nasa-active');
                            }

                            if (_nasa_in_mobile) {
                                clearInterval(setMaxHeightQVPU);
                            }
                        }, 1000);
                    }

                    $('body').trigger('nasa_after_quickview');

                    setTimeout(function() {
                        $('body').trigger('nasa_after_quickview_timeout');
                    }, 200);
                }
            }
        }

        e.preventDefault();
    });
    
    $('body').on('init_quickview_variations_form', function(e, formLightBox) {
        e.preventDefault();
        
        if ($(formLightBox).length) {
        
            $(formLightBox).wc_variation_form();
            $(formLightBox).nasa_quickview_variation_form();

            $('body').trigger('nasa_init_ux_variation_form');
        }
    });
    
    $.fn.nasa_quickview_variation_form = function() {
        return this.each(function() {
            var _form = $(this);
            
            $(_form).on('found_variation', function(e, variation) {
                e.preventDefault();
                var _this_form = $(this);
                
                if (!$(_this_form).hasClass('variations_form-3rd')) {
                    if ($(_this_form).find('.nasa-gallery-variation-supported').length) {
                        change_gallery_variable_quickview($, _this_form, variation);
                    } else {
                        setTimeout(function() {
                            change_image_variable_quickview($, _this_form, variation);
                        }, 10);
                    }
                }
            }).on('reset_data', function(e) {
                e.preventDefault();
                var _this_form = $(this);
                
                if (!$(_this_form).hasClass('variations_form-3rd')) {
                    if ($(_this_form).find('.nasa-gallery-variation-supported').length) {
                        change_gallery_variable_quickview($, _this_form, null);
                    } else {
                        setTimeout(function() {
                            change_image_variable_quickview($, _this_form, null);
                        }, 10);
                    }
                }
            });
        });
    };

    /**
     * Change gallery for variation - Quick view
     */
    $('body').on('nasa_changed_gallery_variable_quickview', function() {
        $('body').trigger('nasa_load_slick_slider');
    });
    
    /**
     * Init gallery lightbox
     */
    $('body').on('nasa_init_product_gallery_lightbox', function() {
        if ($('.product-lightbox').find('.nasa-product-gallery-lightbox').length) {
            _lightbox_variations[0] = {
                'quickview_gallery': $('.product-lightbox').find('.nasa-product-gallery-lightbox').html()
            };
        }
    });
    
    /**
     * After Close Fog Window
     */
    $('body').on('nasa_after_close_fog_window', function() {
        nasa_quick_viewimg = false;
    });
    
    /**
     * Btn add to cart select option to quick view
     */
    $('body').on('click', '.ajax_add_to_cart_variable', function(){
        if ($(this).parent().find('.quick-view').length) {
            $(this).parent().find('.quick-view').trigger('click');
            
            return false;
        } else {
            return;
        }
    });
});

/**
 * Support for Quick-view
 */
var _timeout_quickviewGallery;
function change_gallery_variable_quickview($, _form, variation) {
    /**
     * Change galleries images
     */
    if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
        var _countSelect = $(_form).find('.variations .value select').length;
        var _selected = 0;
        if (_countSelect) {
            $(_form).find('.variations .value select').each(function() {
                if ($(this).val() !== '') {
                    _selected++;
                }
            });
        }

        if (_countSelect && _selected === _countSelect) {
            _quicked_gallery = false;
            
            if (typeof _lightbox_variations[variation.variation_id] === 'undefined') {
                if (
                    typeof nasa_params_quickview !== 'undefined' &&
                    typeof nasa_params_quickview.wc_ajax_url !== 'undefined'
                ) {
                    var _urlAjax = nasa_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quickview_gallery_variation');
                    
                    _nasa_calling_gallery = 1;

                    var _data = {
                        'variation_id': variation.variation_id,
                        'is_purchasable': variation.is_purchasable,
                        'is_in_stock': variation.is_in_stock,
                        'main_id': typeof variation.image_id !== 'undefined' ? variation.image_id : 0,
                        'gallery': typeof variation.nasa_gallery_variation !== 'undefined' ?
                            variation.nasa_gallery_variation : [],
                        'show_images': $('.product-lightbox').find('.main-image-slider').attr('data-items')
                    };

                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            data: _data
                        },
                        beforeSend: function () {
                            if (!$(_form).hasClass('nasa-processing')) {
                                $(_form).addClass('nasa-processing');
                            }

                            $('.nasa-quickview-product-deal-countdown').html('');
                            $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');

                            if ($('#nasa-quickview-sidebar.nasa-crazy-load').length) {
                                if (!$('.nasa-product-gallery-lightbox').hasClass('crazy-loading')) {
                                    $('.nasa-product-gallery-lightbox').addClass('crazy-loading');
                                }
                            } else {
                                if ($('.nasa-product-gallery-lightbox').find('.nasa-loading').length <= 0) {
                                    $('.nasa-product-gallery-lightbox').append('<div class="nasa-loading"></div>');
                                }

                                if ($('.nasa-product-gallery-lightbox').find('.nasa-loader').length <= 0) {
                                    $('.nasa-product-gallery-lightbox').append('<div class="nasa-loader" style="top:45%"></div>');
                                }
                            }

                            $('.nasa-product-gallery-lightbox').css({'min-height': $('.nasa-product-gallery-lightbox').outerHeight()});
                        },
                        success: function (result) {
                            _nasa_calling_gallery = 0;

                            $(_form).removeClass('nasa-processing');

                            _lightbox_variations[variation.variation_id] = result;

                            /**
                             * Deal
                             */
                            if (typeof result.deal_variation !== 'undefined') {
                                $('.nasa-quickview-product-deal-countdown').html(result.deal_variation);

                                if (result.deal_variation !== '') {
                                    /**
                                     * Trigger after changed Countdown
                                     */
                                    $('body').trigger('nasa_load_countdown');

                                    if (!$('.nasa-quickview-product-deal-countdown').hasClass('nasa-show')) {
                                        $('.nasa-quickview-product-deal-countdown').addClass('nasa-show');
                                    }
                                }

                                else {
                                    $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                                }
                            } else {
                                $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                            }

                            /**
                             * Main image
                             */
                            if (typeof result.quickview_gallery !== 'undefined') {
                                $('.nasa-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
                            }

                            if (typeof _timeout_quickviewGallery !== 'undefined') {
                                clearTimeout(_timeout_quickviewGallery);
                            }

                            _timeout_quickviewGallery = setTimeout(function (){
                                $('.nasa-product-gallery-lightbox').find('.nasa-loading, .nasa-loader').remove();
                                $('.nasa-product-gallery-lightbox').removeClass('crazy-loading');
                                $('.nasa-product-gallery-lightbox').css({'min-height': 'auto'});
                            }, 200);

                            /**
                             * Trigger after changed gallery
                             */
                            $('body').trigger('nasa_changed_gallery_variable_quickview');
                        },
                        error: function() {
                            _nasa_calling_gallery = 0;
                            $(_form).removeClass('nasa-processing');
                            $('.nasa-product-gallery-lightbox').find('.nasa-loading, .nasa-loader').remove();
                            $('.nasa-product-gallery-lightbox').removeClass('crazy-loading');
                        }
                    });
                }
            } else {
                var result = _lightbox_variations[variation.variation_id];

                /**
                 * Deal
                 */
                if (typeof result.deal_variation !== 'undefined') {
                    $('.nasa-quickview-product-deal-countdown').html(result.deal_variation);

                    if (result.deal_variation !== '') {
                        $('body').trigger('nasa_load_countdown');

                        if (!$('.nasa-quickview-product-deal-countdown').hasClass('nasa-show')) {
                            $('.nasa-quickview-product-deal-countdown').addClass('nasa-show');
                        }
                    }

                    else {
                        $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                    }
                } else {
                    $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                }

                /**
                 * Main image
                 */
                if (typeof result.quickview_gallery !== 'undefined') {
                    if ($('#nasa-quickview-sidebar.nasa-crazy-load').length) {
                        if (!$('.nasa-product-gallery-lightbox').hasClass('crazy-loading')) {
                            $('.nasa-product-gallery-lightbox').addClass('crazy-loading');
                        }
                    } else {
                        if ($('.nasa-product-gallery-lightbox').find('.nasa-loading').length <= 0) {
                            $('.nasa-product-gallery-lightbox').append('<div class="nasa-loading"></div>');
                        }

                        if ($('.nasa-product-gallery-lightbox').find('.nasa-loader').length <= 0) {
                            $('.nasa-product-gallery-lightbox').append('<div class="nasa-loader" style="top:45%"></div>');
                        }
                    }

                    $('.nasa-product-gallery-lightbox').css({'min-height': $('.nasa-product-gallery-lightbox').height()});

                    $('.nasa-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
                    if (typeof _timeout_quickviewGallery !== 'undefined') {
                        clearTimeout(_timeout_quickviewGallery);
                    }

                    _timeout_quickviewGallery = setTimeout(function() {
                        $('.nasa-product-gallery-lightbox').find('.nasa-loader, .nasa-loading').remove();
                        $('.nasa-product-gallery-lightbox').removeClass('crazy-loading');
                        $('.nasa-product-gallery-lightbox').css({'min-height': 'auto'});
                    }, 200);
                }

                _nasa_calling_gallery = 0;

                /**
                 * Trigger after changed gallery
                 */
                $('body').trigger('nasa_changed_gallery_variable_quickview');
            }
        }
    }
    
    /**
     * Default
     */
    else {
        if(!_quicked_gallery && typeof _lightbox_variations[0] !== 'undefined') {
            _quicked_gallery = true;
            var result = _lightbox_variations[0];

            /**
             * Main image
             */
            if(typeof result.quickview_gallery !== 'undefined') {
                $('.nasa-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
            }
            
            /**
             * Trigger after changed gallery
             */
            $('body').trigger('nasa_changed_gallery_variable_quickview');
        }
        
        /**
         * Hide Countdown
         */
        $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
    }
}

/**
 * Change image variable Single product
 * 
 * @param {type} $
 * @param {type} _form
 * @param {type} variation
 * @returns {undefined}
 */
function change_image_variable_quickview($, _form, variation) {
    /**
     * Change gallery for single product variation
     */
    if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
        var _countSelect = $(_form).find('.variations .value select').length;
        var _selected = 0;
        if (_countSelect) {
            $(_form).find('.variations .value select').each(function() {
                if ($(this).val() !== '') {
                    _selected++;
                }
            });
        }

        if (_countSelect && _selected === _countSelect) {
            var src_thumb = false;

            /**
             * Support Bundle product
             */
            if ($('.product-lightbox .woosb-product').length) {
                if (variation.image.thumb_src !== 'undefined' || variation.image.gallery_thumbnail_src !== 'undefined') {
                    src_thumb = variation.image.gallery_thumbnail_src ? variation.image.gallery_thumbnail_src :  variation.image.thumb_src;
                }

                if (src_thumb) {
                    $(_form).parents('.woosb-product').find('.woosb-thumb-new').html('<img src="' + src_thumb + '" />');
                    $(_form).parents('.woosb-product').find('.woosb-thumb-ori').hide();
                    $(_form).parents('.woosb-product').find('.woosb-thumb-new').show();
                }
            }

            else {
                var _src_large = typeof variation.image_single_page !== 'undefined' ?
                    variation.image_single_page : variation.image.url;

                $('.main-image-slider img.nasa-first').attr('src', _src_large).removeAttr('srcset');
            }
        }

    } else {
        /**
         * Support Bundle product
         */
        if ($('.product-lightbox .woosb-product').length) {
            $(_form).parents('.woosb-product').find('.woosb-thumb-ori').show();
            $(_form).parents('.woosb-product').find('.woosb-thumb-new').hide();
        } else {
            var image_large = $('.nasa-product-gallery-lightbox').attr('data-o_href');
            $('.main-image-slider img.nasa-first').attr('src', image_large).removeAttr('srcset');
        }
    }
    
    if ($('body').hasClass('nasa-focus-main-image')) {
        var _main_slide = $('.main-image-slider');
        $('body').trigger('slick_go_to_0', [_main_slide]);
    }

    /**
     * deal time
     */
    if ($('.nasa-quickview-product-deal-countdown').length) {
        if (variation && variation.variation_id && variation.is_in_stock && variation.is_purchasable) {
            if (typeof _single_variations[variation.variation_id] === 'undefined' && _nasa_calling_countdown == 0) {
                _nasa_calling_countdown = 1;

                if (
                    typeof nasa_params_quickview !== 'undefined' &&
                    typeof nasa_params_quickview.wc_ajax_url !== 'undefined'
                ) {
                    var _urlAjax = nasa_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_get_deal_variation');

                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        cache: false,
                        data: {
                            pid: variation.variation_id
                        },
                        beforeSend: function () {
                            if (!$(_form).hasClass('nasa-processing-countdown')) {
                                $(_form).addClass('nasa-processing-countdown');
                            }

                            $('.nasa-quickview-product-deal-countdown').html('');
                            $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                        },
                        success: function (res) {
                            _nasa_calling_countdown = 0;

                            $(_form).removeClass('nasa-processing-countdown');

                            if(typeof res.success !== 'undefined' && res.success === '1') {
                                _single_variations[variation.variation_id] = res.content;
                            } else {
                                _single_variations[variation.variation_id] = '';
                            }
                            $('.nasa-quickview-product-deal-countdown').html(_single_variations[variation.variation_id]);

                            if(_single_variations[variation.variation_id] !== '') {
                                /**
                                 * Trigger after changed Countdown
                                 */
                                $('body').trigger('nasa_load_countdown');

                                if(!$('.nasa-quickview-product-deal-countdown').hasClass('nasa-show')) {
                                    $('.nasa-quickview-product-deal-countdown').addClass('nasa-show');
                                }
                            }

                            else {
                                $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                            }
                        },
                        error: function() {
                            $(_form).removeClass('nasa-processing-countdown');
                        }
                    });
                }
            } else {
                $('.nasa-quickview-product-deal-countdown').html(_single_variations[variation.variation_id]);
                if(_single_variations[variation.variation_id] !== '') {

                    /**
                     * Trigger after changed Countdown
                     */
                    $('body').trigger('nasa_load_countdown');

                    if(!$('.nasa-quickview-product-deal-countdown').hasClass('nasa-show')) {
                        $('.nasa-quickview-product-deal-countdown').addClass('nasa-show');
                    }
                }

                else {
                    $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                }

                _nasa_calling_countdown = 0;
            }
        }

        else {
            $('.nasa-quickview-product-deal-countdown').html('');
            $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
        }
    }
}
