// nasa_elementor_ajax => Ajax URL
jQuery(document).ready(function($) {
'use strict';

/** Begin Document Ready **/

if (typeof wp === 'undefined') {
    var wp = window.wp;
}

var _product_categories = null;
var _pins = [];
var _nav_menus = null;
var _products_deal = null;
var _revs = null;

// Uploading files
var file_frame = [];

/**
 * Open Media and select image
 */
$('body').on('click', '.nasa_upload_img', function(event) {
    event.preventDefault();
    
    var _this = $(this);
    
    var _id = $(_this).attr('data-id');
    
    var _file_frame;
    
    // If the media frame already exists, reopen it.
    if (file_frame[_id]) {
        _file_frame = file_frame[_id];
        _file_frame.open();
        return;
    }
    
    var _choose_text = $(_this).attr('data-choose-text');
    var _use_text = $(_this).attr('data-use-text');
    
    // Create the media frame.
    _file_frame = wp.media.frames.downloadable_file = wp.media({
        title: _choose_text,
        button: {
            text: _use_text
        },
        multiple: false
    });

    // When an image is selected, run a callback.
    _file_frame.on('select', function () {
        var attachment = _file_frame.state().get('selection').first().toJSON();
        var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;
        $('#wrap_' + _id).removeClass('nasa-wrap-no-img');
        $('#img_' + _id).find('img').attr('src', attachment_thumbnail.url);
        $('#input_' + _id).val(attachment.id).trigger('change');
    });

    // Finally, open the modal.
    _file_frame.open();
    
    file_frame[_id] = _file_frame;
});

/**
 * Remove Image
 */
$('body').on('click', '.nasa_remove_img', function(event) {
    event.preventDefault();
    var _src = $(this).attr('data-no-image');
    var _id = $(this).attr('data-id');
    
    if ($('#wrap_' + _id).length && $('#img_' + _id).length && $('#input_' + _id).length) {
        if (!$('#wrap_' + _id).hasClass('nasa-wrap-no-img')) {
            $('#wrap_' + _id).addClass('nasa-wrap-no-img');
        }
        
        $('#img_' + _id).find('img').attr('src', _src);
        
        $('#input_' + _id).val('').trigger('change');
    }
});

/**
 * Add Tab Item
 */
$('body').on('click', '.nasa-add-item', function() {
    var _this = $(this);
    if (!$(_this).hasClass('adding')) {
        $(_this).addClass('adding');
        
        var date = new Date();
        var _unique = date.getTime();
        
        var _wrap = $(_this).parents('.nasa-wrap-items');
        var _html = $(_wrap).find('.tmpl-nasa-content').html();
        var _new_html = _html.replace(/{{order}}/g, _unique);
        
        $(_wrap).find('.nasa-appent-wrap').append(_new_html);
        
        var _form = $(_this).parents('form');
        var _firs_input = $(_form).find('input.first');
        
        setTimeout(function() {
            $(_this).removeClass('adding');
            
            if ($(_firs_input).length) {
                $(_firs_input).trigger('change');
            }
        }, 100);
    }
});

/**
 * Remove Tab Item
 */
$('body').on('click', '.nasa-remove-item', function() {
    var _this = $(this);
    
    var _form = $(_this).parents('form');
    var _firs_input = $(_form).find('input.first');
    
    var _wrap = $(_this).parents('.nasa-wrap-item');
    if ($(_wrap).length) {
        $(_wrap).remove();
    }
    
    setTimeout(function() {
        if ($(_firs_input).length) {
            $(_firs_input).trigger('change');
        }
    }, 100);
});

/**
 * Toggle Tab Item
 */
$('body').on('click', '.nasa-toggle-title', function() {
    var _this = $(this);
    var _option = $(_this).parents('.nasa-wrap-item').find('.nasa-item-options');
    
    $(_this).toggleClass('hidden-options');
    $(_option).toggleClass('hidden-options');
});

/**
 * open list deals
 */
$('body').on('click', '.select-product-deal', function() {
    var _this = $(this);
    if (!$(_this).hasClass('processing')) {
        var _wrap = $(_this).parents('.nasa-id-deal-wrap');
        var _list = $(_wrap).find('.list-items-wrap');
        var _has_data = $(_list).attr('data-list');
        if (_has_data === '1') {
            $(_this).addClass('processing');
            
            if (!$(_list).hasClass('actived')) {
                $(_list).addClass('actived');
            }
        } else {
            if (!_products_deal) {
                // Calling ajax
                $.ajax({
                    url: nasa_elementor_ajax,
                    type: 'get',
                    dataType: 'html',
                    data: {
                        action: 'nasa_products_deal_elementor'
                    },
                    beforeSend: function() {
                        $(_this).addClass('processing');

                        if (!$(_list).hasClass('actived')) {
                            $(_list).addClass('actived');
                        }
                        
                        if (!$(_list).hasClass('loading')) {
                            $(_list).addClass('loading');
                        }
                    },
                    success: function(res){
                        $(_list).removeClass('loading');

                        if (res) {
                            $(_list).attr('data-list', '1');
                            $(_list).find('.list-items').html(res);
                            
                            _products_deal = res;
                        }
                    },
                    error: function () {
                        $(_list).removeClass('loading');
                    }
                });
            } else {
                $(_this).addClass('processing');

                if (!$(_list).hasClass('actived')) {
                    $(_list).addClass('actived');
                }
                
                $(_list).find('.list-items').html(_products_deal);
            }
        }
    }
});

/**
 * Select deal
 */
$('body').on('click', '.deal-product-item', function() {
    var _deal_id = $(this).attr('data-deal');
    var _info = $(this).find('.info-content').html();
    var _wrap = $(this).parents('.nasa-id-deal-wrap');
    var _list = $(_wrap).find('.list-items-wrap');
    var _cursor = $(_wrap).find('.select-product-deal');
    
    $(_list).removeClass('actived');
    $(_cursor).removeClass('processing');
    
    $(_wrap).find('.info-selected').html(_info + '<a href="javascript:void(0);" class="nasa-remove-selected-deal"></a>');
    $(_wrap).find('input.id-selected').val(_deal_id);
    $(_wrap).find('input.id-selected').trigger('change');
});

/**
 * Open categories
 */
$('body').on('click', '.select-cat-item', function() {
    var _this = $(this);
    if (!$(_this).hasClass('processing')) {
        var _wrap = $(_this).parents('.nasa-categories-wrap');
        var _list = $(_wrap).find('.list-items-wrap');
        var _has_data = $(_list).attr('data-list');
        if (_has_data === '1') {
            $(_this).addClass('processing');
            
            if (!$(_list).hasClass('actived')) {
                $(_list).addClass('actived');
            }
        } else {
            if (!_product_categories) {
                // Calling ajax
                $.ajax({
                    url: nasa_elementor_ajax,
                    type: 'get',
                    dataType: 'html',
                    data: {
                        action: 'nasa_product_categories_elementor'
                    },
                    beforeSend: function() {
                        $(_this).addClass('processing');

                        if (!$(_list).hasClass('actived')) {
                            $(_list).addClass('actived');
                        }
                        
                        if (!$(_list).hasClass('loading')) {
                            $(_list).addClass('loading');
                        }
                    },
                    success: function(res){
                        $(_list).removeClass('loading');

                        if (res) {
                            $(_list).attr('data-list', '1');
                            $(_list).find('.list-items').html(res);
                            
                            _product_categories = res;
                        }
                    },
                    error: function () {
                        $(_list).removeClass('loading');
                    }
                });
            } else {
                $(_list).attr('data-list', '1');
                $(_list).find('.list-items').html(_product_categories);
                
                $(_this).addClass('processing');

                if (!$(_list).hasClass('actived')) {
                    $(_list).addClass('actived');
                }
            }
        }
    }
});

/**
 * Select category
 */
$('body').on('click', '.product-cat-item', function() {
    var _cat_slug = $(this).attr('data-slug');
    var _info = $(this).html();
    var _wrap = $(this).parents('.nasa-categories-wrap');
    var _list = $(_wrap).find('.list-items-wrap');
    var _cursor = $(_wrap).find('.select-cat-item');
    
    $(_list).removeClass('actived');
    $(_cursor).removeClass('processing');
    
    $(_wrap).find('.info-selected').html(_info + '<a href="javascript:void(0);" class="nasa-remove-selected"></a>');
    $(_wrap).find('input.slug-selected').val(_cat_slug);
    $(_wrap).find('input.slug-selected').trigger('change');
});

/**
 * Open Pins
 */
$('body').on('click', '.select-pin-item', function() {
    var _this = $(this);
    if (!$(_this).hasClass('processing')) {
        var _wrap = $(_this).parents('.nasa-pins-wrap');
        var _list = $(_wrap).find('.list-items-wrap');
        var _has_data = $(_list).attr('data-list');
        var _type = $(_this).attr('data-type');
        if (_has_data === '1') {
            $(_this).addClass('processing');
            
            if (!$(_list).hasClass('actived')) {
                $(_list).addClass('actived');
            }
        } else {
            if (!_pins[_type]) {
                // Calling ajax
                $.ajax({
                    url: nasa_elementor_ajax,
                    type: 'get',
                    dataType: 'html',
                    data: {
                        action: 'nasa_pins_banner_elementor',
                        'pin_type': _type
                    },
                    beforeSend: function() {
                        $(_this).addClass('processing');

                        if (!$(_list).hasClass('actived')) {
                            $(_list).addClass('actived');
                        }
                        
                        if (!$(_list).hasClass('loading')) {
                            $(_list).addClass('loading');
                        }
                    },
                    success: function(res){
                        $(_list).removeClass('loading');

                        if (res) {
                            $(_list).attr('data-list', '1');
                            $(_list).find('.list-items').html(res);
                            
                            _pins[_type] = res;
                        }
                    },
                    error: function () {
                        $(_list).removeClass('loading');
                    }
                });
            } else {
                $(_list).attr('data-list', '1');
                $(_list).find('.list-items').html(_pins[_type]);
                
                $(_this).addClass('processing');

                if (!$(_list).hasClass('actived')) {
                    $(_list).addClass('actived');
                }
            }
        }
    }
});

/**
 * Select category
 */
$('body').on('click', '.pin-item', function() {
    var _slug = $(this).attr('data-slug');
    var _info = $(this).html();
    var _wrap = $(this).parents('.nasa-pins-wrap');
    var _list = $(_wrap).find('.list-items-wrap');
    var _cursor = $(_wrap).find('.select-pin-item');
    
    $(_list).removeClass('actived');
    $(_cursor).removeClass('processing');
    
    $(_wrap).find('.info-selected').html(_info + '<a href="javascript:void(0);" class="nasa-remove-selected"></a>');
    $(_wrap).find('input.slug-selected').val(_slug);
    $(_wrap).find('input.slug-selected').trigger('change');
});

/**
 * Open nav menus
 */
$('body').on('click', '.select-menu-item', function() {
    var _this = $(this);
    if (!$(_this).hasClass('processing')) {
        var _wrap = $(_this).parents('.nasa-menus-wrap');
        var _list = $(_wrap).find('.list-items-wrap');
        var _has_data = $(_list).attr('data-list');
        if (_has_data === '1') {
            $(_this).addClass('processing');
            
            if (!$(_list).hasClass('actived')) {
                $(_list).addClass('actived');
            }
        } else {
            if (!_nav_menus) {
                // Calling ajax
                $.ajax({
                    url: nasa_elementor_ajax,
                    type: 'get',
                    dataType: 'html',
                    data: {
                        action: 'nasa_nav_menus_elementor'
                    },
                    beforeSend: function() {
                        $(_this).addClass('processing');

                        if (!$(_list).hasClass('actived')) {
                            $(_list).addClass('actived');
                        }
                        
                        if (!$(_list).hasClass('loading')) {
                            $(_list).addClass('loading');
                        }
                    },
                    success: function(res){
                        $(_list).removeClass('loading');

                        if (res) {
                            $(_list).attr('data-list', '1');
                            $(_list).find('.list-items').html(res);
                            
                            _nav_menus = res;
                        }
                    },
                    error: function () {
                        $(_list).removeClass('loading');
                    }
                });
            } else {
                $(_list).attr('data-list', '1');
                $(_list).find('.list-items').html(_nav_menus);
                
                $(_this).addClass('processing');

                if (!$(_list).hasClass('actived')) {
                    $(_list).addClass('actived');
                }
            }
        }
    }
});

/**
 * Select category
 */
$('body').on('click', '.nasa-nav-menu', function() {
    var _cat_slug = $(this).attr('data-slug');
    var _info = $(this).html();
    var _wrap = $(this).parents('.nasa-menus-wrap');
    var _list = $(_wrap).find('.list-items-wrap');
    var _cursor = $(_wrap).find('.select-menu-item');
    
    $(_list).removeClass('actived');
    $(_cursor).removeClass('processing');
    
    $(_wrap).find('.info-selected').html(_info + '<a href="javascript:void(0);" class="nasa-remove-selected"></a>');
    $(_wrap).find('input.slug-selected').val(_cat_slug);
    $(_wrap).find('input.slug-selected').trigger('change');
});

/**
 * Open Pins
 */
$('body').on('click', '.select-rev-item', function() {
    var _this = $(this);
    if (!$(_this).hasClass('processing')) {
        $(_this).addClass('processing');
        
        var _wrap = $(_this).parents('.nasa-revs-wrap');
        var _list = $(_wrap).find('.list-items-wrap');
        
        if (!_revs) {
            // Calling ajax
            $.ajax({
                url: nasa_elementor_ajax,
                type: 'get',
                dataType: 'html',
                data: {
                    action: 'nasa_revs_elementor'
                },
                beforeSend: function() {
                    $(_this).addClass('processing');

                    if (!$(_list).hasClass('actived')) {
                        $(_list).addClass('actived');
                    }

                    if (!$(_list).hasClass('loading')) {
                        $(_list).addClass('loading');
                    }
                },
                success: function(res){
                    $(_list).removeClass('loading');

                    if (res) {
                        $(_list).attr('data-list', '1');
                        $(_list).find('.list-items').html(res);

                        _revs = res;
                    }
                },
                error: function () {
                    $(_list).removeClass('loading');
                }
            });
        } else {
            $(_list).attr('data-list', '1');
            $(_list).find('.list-items').html(_revs);

            $(_this).addClass('processing');

            if (!$(_list).hasClass('actived')) {
                $(_list).addClass('actived');
            }
        }
    }
});

/**
 * Select Rev
 */
$('body').on('click', '.rev-item', function() {
    var _slug = $(this).attr('data-slug');
    var _info = $(this).html();
    var _wrap = $(this).parents('.nasa-revs-wrap');
    var _list = $(_wrap).find('.list-items-wrap');
    var _cursor = $(_wrap).find('.select-rev-item');
    
    $(_list).removeClass('actived');
    $(_cursor).removeClass('processing');
    
    $(_wrap).find('.info-selected').html(_info + '<a href="javascript:void(0);" class="nasa-remove-selected"></a>');
    $(_wrap).find('input.slug-selected').val(_slug);
    $(_wrap).find('input.slug-selected').trigger('change');
});

/**
 * Remove Selected slug
 */
$('body').on('click', '.nasa-remove-selected', function() {
    var _wrap = $(this).parents('.nasa-root-wrap');
    var _info = $(_wrap).find('.info-selected');
    var _text = $(_info).attr('data-no-selected');
    $(_info).html('<p class="no-selected">' + _text + '</p>');
    $(_wrap).find('input.slug-selected').val('');
    $(_wrap).find('input.slug-selected').trigger('change');
});

/**
 * Remove Selected deal
 */
$('body').on('click', '.nasa-remove-selected-deal', function() {
    var _wrap = $(this).parents('.nasa-root-wrap');
    var _info = $(_wrap).find('.info-selected');
    var _text = $(_info).attr('data-no-selected');
    $(_info).html('<p class="no-selected">' + _text + '</p>');
    $(_wrap).find('input.id-selected').val('');
    $(_wrap).find('input.id-selected').trigger('change');
});

/**
 * Search item in list
 */
$('body').on('keyup', '.nasa-input-search', function() {
    var _this = $(this);
    var _list = $(_this).parents('.list-items-wrap');
    var _textsearch = $.trim($(_this).val());
    
    if(_textsearch === ''){
        $(_list).find('.nasa-item').fadeIn(200);
    } else {
        _textsearch = _textsearch.toLowerCase();
        var patt = new RegExp(_textsearch);
        $(_list).find('.nasa-item').each(function (){
            var _sstext = $(this).attr('data-name');
            if (patt.test(_sstext)) {
                $(this).fadeIn(200);
            } else {
                $(this).fadeOut(200);
            }
        });
    }
});

/** End Document Ready **/
});
