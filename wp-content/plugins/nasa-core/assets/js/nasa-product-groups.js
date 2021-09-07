/**
 * Document nasa-core ready
 */
jQuery(document).ready(function($) {
"use strict";

/**
 * Change nasa Categories - Group products
 */
$('body').on('change', '.nasa-filter-nasa-categories', function () {
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_custom_taxomomies_child');
        var _this = $(this);
        var _form = $(_this).parents('form');
        $(_form).find('.nasa-filter-nasa-categories').attr('disabled', true);
        var _taget = $(_this).attr('data-target');

        if ($(_form).find(_taget).length) {
            var _affected = $(_form).find(_taget);
            var _slug = $(_this).val();
            var _key = $(_affected).attr('data-key');
            var _hide_empty = $(_form).attr('data-hide_empty');
            var _show_count = $(_form).attr('data-show_count');
            var _active = $(_affected).parents('.nasa-wrap-select').attr('data-active');
            var _select_text = $(_affected).attr('data-text_select');

            $.ajax({
                url : _urlAjax,
                type: 'post',
                dataType: 'json',
                data: {
                    slug: _slug,
                    key: _key,
                    hide_empty: _hide_empty,
                    show_count: _show_count,
                    actived: _active,
                    select_text: _select_text
                },
                beforeSend: function(){

                },
                success: function(res){
                    if (res.success){
                        $(_affected).html(res.content);
                        if (res.empty) {
                            $(_affected).val('').change();
                        } else {
                            if (_active && res.has_active) {
                                $(_affected).val(_active).change();
                            } else {
                                $(_affected).val('').change();
                            }
                        }
                    }

                    $(_form).find('.nasa-filter-nasa-categories').attr('disabled', false);

                    nasa_init_filter_nasa_categories($);
                }
            });
        } else {
            $(_form).find('.nasa-filter-nasa-categories').attr('disabled', false);
        }
    }
});

$('body').on('click', '.nasa-submit-form', function() {
    var _form = $(this).parents('form');
    var _changed = false;
    for (var _key = 2; _key >= 0; _key--) {
        if ($(_form).find('.nasa-filter-nasa-categories.nasa-select-' + _key).length && $(_form).find('.nasa-filter-nasa-categories.nasa-select-' + _key).val() !== '') {
            var _val = $(_form).find('.nasa-filter-nasa-categories.nasa-select-' + _key).val();
            $(_form).find('input.nasa-input-main').val(_val);
            _changed = true;

            break;
        }
    }

    if (!_changed) {
        $(_form).find('input.nasa-input-main').remove();
    }

    setTimeout(function() {
        $(_form).submit();
    }, 10);


    return false;
});

/**
 * Init Select 2
 */
nasa_init_select2($);

/**
 * Init filter group products
 */
nasa_init_filter_nasa_categories($);

$('body').on('nasa_after_load_ajax', function() {
    /**
     * Reload Select 2
     */
    nasa_init_select2($);
    
    /**
     * Reload filter group products
     */
    nasa_init_filter_nasa_categories($);
});

/**
 * Reload filter group products
 */
$('body').on('nasa_rendered_template', function() {
    nasa_init_filter_nasa_categories($);
});

});

/**
 * init select2
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_init_select2($) {
    if ($('.nasa-select2').length && $('body').hasClass('nasa-woo-actived')) {
        $('.nasa-select2').each(function () {
            if (!$(this).hasClass('inited')) {
                $(this).addClass('inited');
                $(this).select2();
            }
        });
    }
}

/**
 * Init filter nasa categories
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_init_filter_nasa_categories($) {
    if ($('.nasa-filter-nasa-categories').length) {
        $('.nasa-filter-nasa-categories').each(function() {
            var _this = $(this);
            var _key = $(_this).attr('data-key');
            if (_key !== '0' && $(_this).find('option').length === 1) {
                $(_this).attr('disabled', true);
            } else {
                $(_this).attr('disabled', false);
            }
        });
    }
}
