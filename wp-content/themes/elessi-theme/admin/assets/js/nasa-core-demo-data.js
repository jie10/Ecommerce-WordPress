/**
 * Total XML files
 * @type Number
 */
var _total = 25;
var _act = 1;
var _run = false;
var _time_out;
var _clear_time_out;
var _installing = false;

var _processing = false;
var _clicking = false;

/**
 * Document Ready
 * 
 * @type type
 */
jQuery(document).ready(function ($) {
'use strict';

/**
 * INIT Tab WPB - ELM
 * 
 * @returns {undefined}
 */
setTimeout(function() {
    if ($('.nasa-tabs-heading').find('.nasa-tab-heading').length) {
        $('.nasa-tabs-heading').find('li:first-child .nasa-tab-heading').trigger('click');
    }
    
    if ($('.recommend-plugins').length <= 0) {
        $('.main-demo-data').show();
    }
    
    if ($('.builder-plugin').length <= 0) {
        $('.confirm-selected-plugins').removeClass('nasa-disabled');
    } else {
        if ($('.builder-plugin').length === 2 && $('.builder-plugin.selected').length <= 0) {
            if (!$('.confirm-selected-plugins').hasClass('nasa-disabled')) {
                $('.confirm-selected-plugins').addClass('nasa-disabled');
            }
        } else {
            $('.confirm-selected-plugins').removeClass('nasa-disabled');
        }
    }
}, 100);

/**
 * Select Home to import
 */
$('body').on('click', '.demo-homepage-item', function() {
    $(this).toggleClass('selected');
    setTimeout(function() {
        if ($('.demo-homepage-item.selected').length) {
            if (!$('.nasa-start-import').hasClass('selected')) {
                $('.nasa-start-import').addClass('selected');
            }
        } else {
            $('.nasa-start-import').removeClass('selected');
        }
    }, 10);
});

/**
 * Recommend Plugins
 */
$('body').on('click', '.recommend-plugin', function() {
    if (!$(this).hasClass('required-plugin')) {
        $(this).toggleClass('selected');
        
        if ($('.builder-plugin').length <= 0) {
            $('.confirm-selected-plugins').removeClass('nasa-disabled');
        } else {
            if ($('.builder-plugin').length === 2 && $('.builder-plugin.selected').length <= 0) {
                if (!$('.confirm-selected-plugins').hasClass('nasa-disabled')) {
                    $('.confirm-selected-plugins').addClass('nasa-disabled');
                }
            } else {
                $('.confirm-selected-plugins').removeClass('nasa-disabled');
            }
        }
    }
});

/**
 * Confirm plugins selected
 */
$('body').on('click', '.confirm-selected-plugins', function() {
    var _this = $(this);
    if (!$(_this).hasClass('nasa-disabled')) {
        $('.recommend-plugins').hide();
        if ($('.builder-plugin').length) {
            $('.builder-plugin').each(function() {
                var _slug = $(this).attr('data-slug');
                var _selected = $(this).hasClass('selected') ? true : false;
                
                if (!_selected) {
                    $('.tab-heading-' + _slug).remove();
                    $('.tab-content-' + _slug).remove();
                }
            });
        }
        
        $('.main-demo-data').show();
        
        $('.nasa-tabs-heading').find('li:first-child .nasa-tab-heading').trigger('click');
    }
});

/**
 * Tabs WPB - ELM
 */
$('body').on('click', '.nasa-tab-heading', function() {
    var _this = $(this);
    
    if (!_clicking && !$(_this).hasClass('selected')) {
        _clicking = true;
        var _target = $(_this).attr('data-target');
        $('.nasa-tabs-heading').find('.nasa-tab-heading').removeClass('selected');
        $('.nasa-tabs-panel').find('.demo-homepage-item-wrap').removeClass('nasa-active');
        
        $('.nasa-tabs-panel .nasa-tab-content').removeClass('nasa-show');
        if ($('.nasa-tabs-panel').find(_target).length) {
            $('.nasa-tabs-panel').find(_target).addClass('nasa-show');
            $(_this).addClass('selected');
            
            setTimeout(function() {
                $('.nasa-tabs-panel').find(_target + ' .demo-homepage-item-wrap').addClass('nasa-active');
                _clicking = false;
            }, 300);
        }
    }
});

/**
 * Confirm unload window when process runing.
 */
$(window).on('beforeunload', function(){
    if (_processing) {
        return 'Are you sure you want to leave?';
    }
});

/**
 * Click Demo Data
 */
$('body').on('click', '.nasa-start-import.selected', function() {
    if (!$(this).hasClass('processing')) {
        _processing = true;
            
        $(this).addClass('processing');
        $('.runing-hide').hide();
        $('.nasa-select-homepage').hide();
        $('.nasa-start-import').hide();
        $('.main-demo-data-notice').hide();
        $('.processing-demo-data').show();
        $('.processing-steps li.step-first').addClass('runing');

        if ($('.process-bar-loading').length) {
            $('.process-bar-loading').addClass('loading');
        }

        if ($('.recommend-plugin.selected').length) {
            $('.recommend-plugin.selected').each(function() {
                var _this = $(this);
                var _text = $(_this).attr('data-name');
                var _slug = $(_this).attr('data-slug');
                $('.plugins-installed').append('<li class="nasa-label-plg nasa-wait plg-' + _slug + '">' + _text + '</li>');
            });
        }

        _time_out = setInterval(function () {
            if (!_run) {
                nasa_import_demo_data($);

                _run = true;

                if ($('.process-bar-finished').length) {
                    var _total_steps = $('.processing-steps li.step').length;
                    var _finished = $('.processing-steps li.step.finished').length;

                    var text_per = Math.round(_finished / _total_steps * 100);

                    $('.process-bar-finished').css({width: text_per + '%'});
                    $('.process-bar-finished').html(text_per + '%');
                }
            }
        }, 1000);

        _clear_time_out = setInterval(function () {
            if ($('.processing-steps li.step-end.step.finished').length || $('.processing-steps li.step.step-end.fail').length) {
                clearInterval(_time_out);
                clearInterval(_clear_time_out);
                $('.processing-notice-first').hide();
                $('.processing-notice-last').show();

                _processing = false;
            }
        }, 1000);
    }
});
});

/**
 * Step 1
 * Install Child Theme
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_install_child_theme($) {
    $.ajax({
        url: ajax_admin_demo_data,
        type: 'post',
        timeout: 600000,
        data: {
            action: 'nasa_install_child_theme'
        },
        success: function (res) {
            if (res === '1') {
                $('.processing-steps li[data-step="1"]').removeClass('runing');
                $('.processing-steps li[data-step="1"]').addClass('finished');
                $('.processing-steps li[data-step="2"]').addClass('runing');
            } else {
                $('.processing-steps li[data-step="1"]').removeClass('runing');
                $('.processing-steps li[data-step="1"]').addClass('fail');
                $('.processing-steps li[data-step="2"]').addClass('runing');
            }
            
            _run = false;
        },
        error: function() {
            $('.processing-steps li[data-step="1"]').removeClass('runing');
            $('.processing-steps li[data-step="1"]').addClass('fail');
            $('.processing-steps li[data-step="2"]').addClass('runing');
            
            _run = false;
        }
    });
}

/**
 * Step 2
 * Install Plugins
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_install_plugins($) {
    if (!_installing) {
        _installing = true;
        var _this = $('.recommend-plugin.selected').first();
        var _slug = $(_this).attr('data-slug');
        if ($('.plugins-installed').find('.plg-' + _slug).length) {
            $('.plugins-installed').find('.plg-' + _slug).removeClass('nasa-wait');
            $('.plugins-installed').find('.plg-' + _slug).addClass('loading');
        }
        $.ajax({
            url: ajax_admin_demo_data,
            type: 'post',
            dataType: 'json',
            timeout: 300000,
            data: {
                action: 'nasa_install_plugin',
                plg: _slug
            },
            success: function (res) {
                $(_this).remove();
                
                if (typeof res.status !== 'undefined' && res.status === '1') {
                    if ($('.plugins-installed').find('.plg-' + _slug).length) {
                        $('.plugins-installed').find('.plg-' + _slug).removeClass('loading');
                        $('.plugins-installed').find('.plg-' + _slug).addClass('ins-sccess');
                    }
                } else {
                    if ($('.plugins-installed').find('.plg-' + _slug).length) {
                        $('.plugins-installed').find('.plg-' + _slug).removeClass('loading');
                        $('.plugins-installed').find('.plg-' + _slug).addClass('ins-error');
                    }
                }
                
                _installing = false;
                _run = false;
            },
            error: function() {
                _installing = false;
                _run = false;
            }
        });
        
        if ($('.recommend-plugin.selected').length <= 0) {
            $('.processing-steps li[data-step="2"]').removeClass('runing');
            $('.processing-steps li[data-step="2"]').addClass('finished');
            $('.processing-steps li[data-step="3"]').addClass('runing');
            _installing = false;
            _run = false;
        }
    }
}

/**
 * Step 3
 * Import Demo data
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_import_data($) {
    var _file = 'data' + (_act.toString());
    
    $.ajax({
        url: ajax_admin_demo_data,
        type: 'post',
        dataType: 'json',
        timeout: 300000,
        data: {
            'action': 'nasa_import_contents',
            'file': _file
        },
        success: function (res) {
            if (_act >= _total) {
                $('.processing-steps li[data-step="3"]').removeClass('runing');
                $('.processing-steps li[data-step="3"]').addClass('finished');
                $('.processing-steps li[data-step="4"]').addClass('runing');
            }
            
            if (_act <= _total) {
                $('.statistic-data').html(_act.toString() + '/' + _total.toString());
            }
            
            _act += 1;
            _run = false;
        },
        error: function () {
            _act += 1;
            _run = false;
        }
    });
}

/**
 * Step 4
 * Import Widgets Sidebar
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_import_widgets_sidebar($) {
    $.ajax({
        url: ajax_admin_demo_data,
        type: 'post',
        timeout: 300000,
        data: {
            action: 'nasa_import_widgets_sidebar'
        },
        success: function (res) {
            if (res === '1') {
                $('.processing-steps li[data-step="4"]').removeClass('runing');
                $('.processing-steps li[data-step="4"]').addClass('finished');
                $('.processing-steps li[data-step="5"]').addClass('runing');
            } else {
                $('.processing-steps li[data-step="4"]').removeClass('runing');
                $('.processing-steps li[data-step="4"]').addClass('fail');
                $('.processing-steps li[data-step="5"]').addClass('runing');
            }
            
            _run = false;
        },
        error: function() {
            $('.processing-steps li[data-step="4"]').removeClass('runing');
            $('.processing-steps li[data-step="4"]').addClass('fail');
            $('.processing-steps li[data-step="5"]').addClass('runing');
            
            _run = false;
        }
    });
}

/**
 * Step 5
 * Import HOME
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_import_homes($) {
    var _home_wpb = [];
    var _home_elm = [];
    
    if ($('.demo-homepages-wpb .demo-homepage-item.selected').length) {
        $('.demo-homepages-wpb .demo-homepage-item.selected').each(function() {
            var _slug = $(this).attr('data-home');
            _home_wpb.push(_slug);
        });
    }
    
    if ($('.demo-homepages-elm .demo-homepage-item.selected').length) {
        $('.demo-homepages-elm .demo-homepage-item.selected').each(function() {
            var _slug = $(this).attr('data-home');
            _home_elm.push(_slug);
        });
    }
    
    $.ajax({
        url: ajax_admin_demo_data,
        type: 'post',
        timeout: 300000,
        data: {
            action: 'nasa_import_homes',
            wpb: _home_wpb,
            elm: _home_elm
        },
        success: function (res) {
            if (res === '1') {
                $('.processing-steps li[data-step="5"]').removeClass('runing');
                $('.processing-steps li[data-step="5"]').addClass('finished');
                $('.processing-steps li[data-step="6"]').addClass('runing');
            } else {
                $('.processing-steps li[data-step="5"]').removeClass('runing');
                $('.processing-steps li[data-step="5"]').addClass('fail');
                $('.processing-steps li[data-step="6"]').addClass('runing');
            }
            
            _run = false;
        },
        error: function() {
            $('.processing-steps li[data-step="5"]').removeClass('runing');
            $('.processing-steps li[data-step="5"]').addClass('fail');
            $('.processing-steps li[data-step="6"]').addClass('runing');
            
            _run = false;
        }
    });
}

/**
 * Step 6
 * Import RevSliders
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_import_revsliders($) {
    $.ajax({
        url: ajax_admin_demo_data,
        type: 'post',
        timeout: 300000,
        data: {
            action: 'nasa_import_revsliders'
        },
        success: function (res) {
            if (res === '1') {
                $('.processing-steps li[data-step="6"]').removeClass('runing');
                $('.processing-steps li[data-step="6"]').addClass('finished');
                $('.processing-steps li[data-step="7"]').addClass('runing');
            } else {
                $('.processing-steps li[data-step="6"]').removeClass('runing');
                $('.processing-steps li[data-step="6"]').addClass('fail');
                $('.processing-steps li[data-step="7"]').addClass('runing');
            }
            
            _run = false;
        },
        error: function() {
            $('.processing-steps li[data-step="6"]').removeClass('runing');
            $('.processing-steps li[data-step="6"]').addClass('fail');
            $('.processing-steps li[data-step="7"]').addClass('runing');
            
            _run = false;
        }
    });
}

/**
 * Step 6
 * Global Options
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_global_options($) {
    $.ajax({
        url: ajax_admin_demo_data,
        type: 'post',
        timeout: 300000,
        data: {
            action: 'nasa_global_options'
        },
        success: function (res) {
            if (res === '1') {
                var permalink_url = $('.nasa-start-import.selected').attr('data-permalink-option');
                $.ajax({
                    url: permalink_url,
                    type: 'get',
                    cache: false,
                    data: {},
                    success: function(res) {
                        var $html = $.parseHTML(res);
                        var _back_menu = $('#adminmenu', $html);
                        
                        if ($('#adminmenu').length) {
                            $('#adminmenu').replaceWith(_back_menu);
                            
                            if ($('#menu-settings').length) {
                                $('#menu-settings').removeClass('wp-menu-open');
                                $('#menu-settings').removeClass('wp-has-current-submenu');
                                $('#menu-settings').addClass('wp-not-current-submenu');
                                $('#menu-settings').find('a.menu-top').removeClass('wp-has-current-submenu').addClass('wp-not-current-submenu');
                            }
                            
                            if ($('#menu-appearance').length){
                                $('#menu-appearance').removeClass('wp-not-current-submenu');
                                $('#menu-appearance').addClass('wp-has-current-submenu');
                                $('#menu-appearance').addClass('wp-menu-open');
                                $('#menu-appearance').find('a.menu-top').removeClass('wp-not-current-submenu').addClass('wp-has-current-submenu');
                            }
                        }
                        
                        $('.processing-steps li[data-step="7"]').removeClass('runing');
                        $('.processing-steps li[data-step="7"]').addClass('finished');
                        
                        _run = false;
                    },
                    error: function() {
                        $('.processing-steps li[data-step="7"]').removeClass('runing');
                        $('.processing-steps li[data-step="7"]').addClass('finished');
                        
                        _run = false;
                    }
                });
            } else {
                $('.processing-steps li[data-step="7"]').removeClass('runing');
                $('.processing-steps li[data-step="7"]').addClass('fail');
                
                _run = false;
            }
        },
        error: function() {
            $('.processing-steps li[data-step="7"]').removeClass('runing');
            $('.processing-steps li[data-step="7"]').addClass('fail');
            
            _run = false;
        }
    });
}

/**
 * All Steps
 * Step Install Demo Data
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_import_demo_data($) {
    var _step = $('.processing-steps li.runing').attr('data-step');
    if (_step) {
        switch (_step) {
            case '1':
                nasa_install_child_theme($);
                break;
                
            case '2':
                nasa_install_plugins($);
                break;
                
            case '3':
                nasa_import_data($);
                break;
                
            case '4':
                nasa_import_widgets_sidebar($);
                break;
                
            case '5':
                nasa_import_homes($);
                break;
                
            case '6':
                nasa_import_revsliders($);
                break;
                
            case '7':
                nasa_global_options($);
                break;
                
            default:
                
                break;
        }
    }
}
