/**
 * Document ready
 * 
 * Checkout Product Page
 */
var _apply_coupon = false;
jQuery(document).ready(function ($) {
    "use strict";

    if ($('#main-content .form-row input, #main-content .form-row select, #main-content .form-row textarea').length) {
        $('#main-content .form-row input, #main-content .form-row select, #main-content .form-row textarea').each(function () {
            var _this = $(this);
            var _form_acc = $(_this).parents('form.woocommerce-EditAccountForm').length ? true : false;
            var _wrap = $(_this).parents('.form-row');

            var _this_val = $(_this).val();

            /**
             * Add * required to placeholder
             */
            if ($(_wrap).length && $(_wrap).hasClass('validate-required') && $(_wrap).find('label[for]').length) {
                var _palace_holder = $(_this).attr('placeholder');

                if (_palace_holder) {
                    var _rq = $(_wrap).find('label[for] .required').length ? $(_wrap).find('label[for] .required').text() : '*';
                    $(_this).attr('placeholder', _palace_holder + ' ' + _rq);
                }
            }

            /**
             * Check actived
             */
            if (_this_val !== '' || _form_acc) {
                if ($(_wrap).length && $(_wrap).find('label[for]').length) {
                    var _for = $(_wrap).find('label[for]').attr('for');
                    if ($(_wrap).find('input[type="hidden"]#' + _for + ', input[type="radio"]#' + _for + ', input[type="checkbox"]#' + _for).length <= 0) {
                        if (!$(_wrap).hasClass('nasa-actived')) {
                            $(_wrap).addClass('nasa-actived');
                        }
                    } else {
                        if (!$(_wrap).hasClass('nasa-dffr')) {
                            $(_wrap).addClass('nasa-dffr');
                        }
                    }
                }
            }
        });
    }

    $('body').on('keyup', '#main-content .form-row input, #main-content .form-row textarea', function () {
        var _this = $(this);
        var _wrap = $(_this).parents('.form-row');

        if ($(_wrap).length && !$(_wrap).hasClass('nasa-dffr') && $(_wrap).find('label[for]').length) {
            if ($(_this).val() !== '') {
                if (!$(_wrap).hasClass('nasa-actived')) {
                    $(_wrap).addClass('nasa-actived');
                }
                if ($(_wrap).find('.nasa-error').length) {
                    $(_wrap).find('.nasa-error').remove();
                }
            } else {
                var _form_acc = $(_this).parents('form.woocommerce-EditAccountForm').length ? true : false;
                if (!_form_acc) {
                    $(_wrap).removeClass('nasa-actived');
                }
            }
        }
    });

    $('body').on('change', '#main-content .form-row select', function () {
        var _this = $(this);
        var _wrap = $(_this).parents('.form-row');

        if ($(_wrap).length && !$(_wrap).hasClass('nasa-dffr') && $(_wrap).find('label[for]').length) {
            if ($(_this).val() !== '') {
                if (!$(_wrap).hasClass('nasa-actived')) {
                    $(_wrap).addClass('nasa-actived');
                }

                if ($(_wrap).find('.nasa-error').length) {
                    $(_wrap).find('.nasa-error').remove();
                }
            } else {
                var _form_acc = $(_this).parents('form.woocommerce-EditAccountForm').length ? true : false;
                if (!_form_acc) {
                    $(_wrap).removeClass('nasa-actived');
                }
            }
        }
    });

    nasa_move_valiate_notices($);

    $('body').on('checkout_error', function () {
        nasa_move_valiate_notices($);
    });

    $('body').on('applied_coupon_in_checkout', function () {
        nasa_move_valiate_notices($);
        if ($('.shipping-wrap-modern').length) {
            $('.woocommerce-error, .woocommerce-message').hide();
            _apply_coupon = true;
        }
    });
    
    $('body').on('removed_coupon_in_checkout', function () {
        if ($('.shipping-wrap-modern').length) {
            $('.woocommerce-error, .woocommerce-message').hide();
            _apply_coupon = true;
        }
    });

    $('body').on('click', '.showcoupon', function () {
        if ($('.woocommerce-error').length) {
            $('.woocommerce-error').hide();
        }
    });

    $('body').on('click', '.nasa-shipping-step', function () {
        if (!$('.nasa-bc-modern .nasa-shipping-step').hasClass('active')) {
            $('body').trigger('nasa_update_custommer_info');
            
            var _valid = nasa_validate_form_checkout($);

            if (_valid) {
                $('body').trigger('nasa_update_custommer_info');
                
                $('.woocommerce-additional-fields').fadeIn(200);
                $('#nasa-billing-info').fadeIn(200);
                $('#nasa-shipping-methods').fadeIn(200);
                $('#nasa-step_payment').fadeIn(200);

                $('.woo-billing').hide();
                $('#nasa-step_billing').hide();
                $('#nasa-payment-wrap').hide();
                
                if ($('.woocommerce-form-login-toggle').length) {
                    $('.woocommerce-form-login-toggle').hide();
                    $('.woocommerce-form-login').hide();
                }
                
                $('.nasa-bc-modern .nasa-billing-step').removeClass('active');
                $('.nasa-bc-modern .nasa-shipping-step').addClass('active');
                $('.nasa-bc-modern .nasa-payment-step').removeClass('active');
            }
        }
    });
    
    $('body').on('click', '.nasa-payment-step', function() {
        if (!$('.nasa-bc-modern .nasa-payment-step').hasClass('active')) {
            var _valid = nasa_validate_form_checkout($);

            if (_valid) {
                $('body').trigger('nasa_update_custommer_info');
                
                $('#nasa-payment-wrap').fadeIn(200);
                $('#nasa-billing-info').fadeIn(200);
                
                $('.woocommerce-additional-fields').hide();
                $('.woo-billing').hide();
                $('#nasa-shipping-methods').hide();
                $('#nasa-step_payment').hide();
                $('#nasa-step_billing').hide();
                
                if ($('.woocommerce-form-login-toggle').length) {
                    $('.woocommerce-form-login-toggle').hide();
                    $('.woocommerce-form-login').hide();
                }
                
                $('#nasa-billing-info .customer-info').removeClass('hidden-tag');
                
                $('.nasa-bc-modern .nasa-billing-step').removeClass('active');
                $('.nasa-bc-modern .nasa-shipping-step').removeClass('active');
                $('.nasa-bc-modern .nasa-payment-step').addClass('active');
            }
        }
    });
    
    $('body').on('click', '.nasa-billing-step', function() {
        if (!$('.nasa-bc-modern .nasa-billing-step').hasClass('active')) {
            $('body').trigger('nasa_update_custommer_info');

            $('.woo-billing').fadeIn(200);
            $('#nasa-step_billing').fadeIn(200);
            
            if ($('.woocommerce-form-login-toggle').length) {
                $('.woocommerce-form-login-toggle').fadeIn(200);
            }

            $('.woocommerce-additional-fields').hide();
            $('#nasa-billing-info').hide();
            $('#nasa-shipping-methods').hide();
            $('#nasa-step_payment').hide();
            $('#nasa-payment-wrap').hide();

            $('.nasa-bc-modern .nasa-billing-step').addClass('active');
            $('.nasa-bc-modern .nasa-shipping-step').removeClass('active');
            $('.nasa-bc-modern .nasa-payment-step').removeClass('active');
        }
    });
    
    $('body').on('click', '.showcoupon-clone', function() {
        $('.coupon-clone-wrap').toggleClass('hidden-tag');
        $('.coupon-clone-wrap').find(':input:eq(0)').trigger('focus');
    });
    
    $('body').on('click', '#apply_coupon_clone', function() {
        if ($('input[name="coupon_code_clone"]').length && $('form.checkout_coupon input[name="coupon_code"]').length) {
            $('.woocommerce-error, .woocommerce-message').hide();
            var _coupon = $('input[name="coupon_code_clone"]').val();
            $('form.checkout_coupon input[name="coupon_code"]').val(_coupon).change();
            $('form.checkout_coupon').trigger('submit');
            $('.woocommerce-checkout-review-order').addClass('processing');
        }
    });
    
    $('body').on('change', 'select.shipping_method, input[name^="shipping_method"], #ship-to-different-address input, .update_totals_on_change select, .update_totals_on_change input[type="radio"], .update_totals_on_change input[type="checkbox"]', function() {
        if ($('.checkout-modern-wrap').length && !$('.woocommerce-checkout-review-order').hasClass('processing')) {
            $('.woocommerce-checkout-review-order').addClass('processing');
        }
    });
    
    $('body').on('nasa_update_custommer_info', function() {
        $('body').trigger('update_checkout');
        
        if ($('#nasa-billing-info').length) {
            var _email = $('input[name="billing_email"]').val();
            $('#nasa-billing-info .customer-info-email .customer-info-right').html(_email);
        }
    });
    
    $('body').on('update_checkout', function() {
        // $('.woocommerce-checkout-review-order').addClass('processing');
    });
    
    $('body').on('updated_checkout', function() {
        if ($('.checkout-modern-wrap').length) {
            $('.processing').removeClass('processing');

            nasa_update_shipping_methods($);

            if ($('.checkout-modern-wrap .woocommerce-additional-fields').length && $('#nasa-shipping-methods').length) {
                var _note = $('.checkout-modern-wrap .woocommerce-additional-fields').clone();

                $('.checkout-modern-wrap .woocommerce-additional-fields').remove();
                $('#nasa-shipping-methods').after(_note);
            }
            
            if (_apply_coupon) {
                nasa_clone_notices_coupon($);
            

                /**
                 * Render Coupon
                 */
                if ($('.woocommerce-error').length && $('.coupon-clone-wrap').length) {
                    $('.coupon-clone-wrap').find(':input:eq(0)').trigger('focus');
                }
            }

            _apply_coupon = false;
        }
    });
    
    $('body').on('click', '.your-order-mobile', function() {
        if ($('.checkout-modern-right-wrap').length && !$('.checkout-modern-right-wrap').hasClass('nasa-active')) {
            $('.checkout-modern-right-wrap').addClass('nasa-active');
        }
    });
    
    $('body').on('click', '.close-your-order-mobile', function() {
        if ($('.checkout-modern-right-wrap').length) {
            $('.checkout-modern-right-wrap').removeClass('nasa-active');
        }
    });
    
    nasa_render_shipping_in_cart($);
    $('body').on('updated_wc_div', function() {
        nasa_render_shipping_in_cart($);
    });

    /* End Document Ready */
});

/**
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_render_shipping_in_cart($) {
    if ($('#shipping_method.hide-check-shipping li').length) {
        $('#shipping_method.hide-check-shipping li').each(function() {
            var _method = $(this);
            if (!$(_method).hasClass('active') && $(_method).find('select.shipping_method, input[name^="shipping_method"][type="radio"]:checked, input[name^="shipping_method"][type="hidden"]').length) {
                $(_method).addClass('active');
            }
        });
    }
}

/**
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_update_shipping_methods($) {
    if ($('.shipping-wrap-modern').length && $('.order-shipping-modern').length) {
        var _shipping = '';
        var _available = false;
        var _avai_html = '';
        $('.shipping-wrap-modern').each(function() {
            var _this = $(this);
            if ($(_this).find('#shipping_method').length) {
                var _p_name = $(_this).find('.shipping-package-name').html();

                _shipping += '<tr class="woocommerce-shipping-totals shipping">';

                /**
                 * Shipping Pagckage Name
                 */
                _shipping += '<th>' + _p_name + '</th>';

                _shipping += '<td>';
                /**
                 * Shipping Methods
                 */
                _shipping += '<ul id="shipping_method_clone" class="woocommerce-shipping-methods-clone">';

                $(_this).find('#shipping_method li').each(function() {
                    var _method = $(this);
                    if ($(_method).find('select.shipping_method, input[name^="shipping_method"][type="radio"]:checked, input[name^="shipping_method"][type="hidden"]').length) {
                        var _used = _method.clone();
                        $(_used).find('select.shipping_method, input[name^="shipping_method"][type="radio"]:checked, input[name^="shipping_method"][type="hidden"]').remove();
                        _avai_html = $(_used).html();
                        _shipping += '<li>' + _avai_html + '</li>';

                        _available = true;
                    }
                });

                _shipping += '</ul>';

                _shipping += '</td></tr>';
            } else {
                $('#nasa-billing-info .customer-info-method').remove();
            }
        });
        
        if (_available) {
            $('.order-shipping-modern').replaceWith(_shipping);
            $('#nasa-billing-info .customer-info-method .customer-info-right').html(_avai_html);
        }
    }
    
    $('.woocommerce-checkout-review-order-table').addClass('nasa-loaded');
}

/**
 * Move validate notices
 * 
 * @param {type} $
 * @returns {String}
 */
function nasa_move_valiate_notices($) {
    var _billing = false;
    if ($('.woocommerce-error li').length) {
        $('.woocommerce-error li').each(function () {
            var _li = $(this);
            var _this = $(_li).attr('data-id');
            if (typeof _this !== 'undefined' && $('#' + _this).length) {
                var _wrap = $('#' + _this).parents('.form-row');
                if ($(_wrap).length) {
                    var _appent = $(_li).html();
                    if ($(_wrap).find('.nasa-error').length) {
                        $(_wrap).find('.nasa-error').html(_appent);
                    } else {
                        $('#' + _this).after('<span class="nasa-error">' + _appent + '</span>');
                    }

                    if (!$(_wrap).hasClass('woocommerce-invalid')) {
                        $(_wrap).removeClass('woocommerce-validated');
                        $(_wrap).addClass('woocommerce-invalid');
                    }

                    $(_li).remove();
                    
                    _billing = true;
                }
            }
        });

        if ($('.woocommerce-error li').length) {
            $('.woocommerce-error').show();
        } else {
            $('.woocommerce-error').hide();
        }
        
        if (_billing && $('.nasa-bc-modern .nasa-billing-step').length) {
            $('.nasa-bc-modern .nasa-billing-step').trigger('click');
        }
    }
}

/**
 * 
 * @param {type} $
 * @returns {Boolean}
 */
function nasa_validate_form_checkout($) {
    var _form = $('form.checkout');

    if ($(_form).length <= 0) {
        return false;
    }
    
    var _diffirent = $(_form).find('[name="ship_to_different_address"]').is(':checked') ? true : false;
    
    var _wrap = !_diffirent ? $(_form).find('.woocommerce-billing-fields') : $(_form).find('#customer_details');

    $(_wrap).find('.form-row').each(function () {
        nasa_validate_field($, this);
    });
    
    return $(_wrap).find('.nasa-invalid, .nasa-error').length ? false : true;
}

/**
 * 
 * @param {type} $
 * @param {type} _form_row
 * @returns {Boolean}
 */
function nasa_validate_field($, _form_row) {
    var $this = $(_form_row).find('.input-text, select, input:checkbox'),
        validated = true,
        validate_required = $(_form_row).is('.validate-required'),
        validate_email = $(_form_row).is('.validate-email'),
        validate_phone = $(_form_row).is('.validate-phone'),
        pattern = '',
        _note = '';

    $(_form_row).removeClass('nasa-invalid');
        
    if (validate_required) {
        if ('checkbox' === $this.attr('type') && !$this.is(':checked')) {
            $(_form_row).removeClass('woocommerce-validated').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            validated = false;
            
            if ($(_form_row).find('.nasa-error').length <= 0) {
                _note = $('.nasa-require-notice').html();
                $($this).after('<span class="nasa-error">' + _note + '</span>');
            }
        } else if ($this.val() === '') {
            $(_form_row).removeClass('woocommerce-validated').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            validated = false;
            
            if ($(_form_row).find('.nasa-error').length <= 0) {
                _note = $('.nasa-require-notice').html();
                $($this).after('<span class="nasa-error">' + _note + '</span>');
            }
        }
    }

    if (validate_email) {
        if ($this.val()) {
            /* https://stackoverflow.com/questions/2855865/jquery-validate-e-mail-address-regex */
            pattern = new RegExp(/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[0-9a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i); // eslint-disable-line max-len

            if (!pattern.test($this.val())) {
                $(_form_row).removeClass('woocommerce-validated').addClass('woocommerce-invalid woocommerce-invalid-email woocommerce-invalid-phone'); // eslint-disable-line max-len
                validated = false;
                
                if ($(_form_row).find('.nasa-error').length <= 0) {
                    _note = $('.nasa-email-notice').html();
                    $($this).after('<span class="nasa-error">' + _note + '</span>');
                }
            }
        }
    }

    if (validate_phone) {
        pattern = new RegExp(/[\s\#0-9_\-\+\/\(\)\.]/g);

        if (0 < $this.val().replace(pattern, '').length) {
            $(_form_row).removeClass('woocommerce-validated').addClass('woocommerce-invalid woocommerce-invalid-phone');
            validated = false;
            
            if ($(_form_row).find('.nasa-error').length <= 0) {
                _note = $('.nasa-phone-notice').html();
                $($this).after('<span class="nasa-error">' + _note + '</span>');
            }
        }
    }

    if (validated) {
        $(_form_row).removeClass('woocommerce-invalid woocommerce-invalid-required-field woocommerce-invalid-email woocommerce-invalid-phone').addClass('woocommerce-validated'); // eslint-disable-line max-len
    } else {
        $(_form_row).addClass('nasa-invalid');
    }

    return validated;
}

/**
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_clone_notices_coupon($) {
    var _notice = $('.woocommerce-error, .woocommerce-message');
    if ($(_notice).length) {
        $('.woocommerce-error, .woocommerce-message').each(function() {
            var _this = $(this);
            $('.coupon-clone-wrap').after(_this);
        });
        
        $('.woocommerce-error, .woocommerce-message').show();
    }
}
