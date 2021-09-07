var top_bar_left_df = '';
var content_custom_df = '';

jQuery(document).ready(function($){
    "use strict";
    loadListIcons($);
    
    var text_now = $('textarea#topbar_left').val();
    $('body').on('click', '.reset_topbar_left', function(){
        if ($('textarea#topbar_left').val() !== top_bar_left_df){
            var _confirm = confirm('Are you sure to reset top bar left ?');

            if (_confirm){
                $('textarea#topbar_left').val(top_bar_left_df);
            }
        }
        
        return false;
    });
    
    $('body').on('click', '.restore_topbar_left', function(){
        if (text_now !== $('textarea#topbar_left').val()){
            var _confirm = confirm('Are you sure to restore top bar left ?');

            if (_confirm){
                $('textarea#topbar_left').val(text_now);
            }
        }
        
        return false;
    });
    
    var text_content_now = $('textarea#content_custom').val();
    $('body').on('click', '.reset_content_custom', function(){
        if ($('textarea#content_custom').val() !== content_custom_df){
            var _confirm = confirm('Are you sure to reset your content custom ?');

            if (_confirm){
                $('textarea#content_custom').val(content_custom_df);
            }
        }
        
        return false;
    });
    
    $('body').on('click', '.restore_content_custom', function(){
        if (text_content_now !== $('textarea#content_custom').val()){
            var _confirm = confirm('Are you sure to restore your content custom ?');

            if (_confirm){
                $('textarea#content_custom').val(text_content_now);
            }
        }
        
        return false;
    });
    
    $('body').on('click', '.toggle-choose-icon-btn', function() {
        $(this).parents('.widget-content').find('.toggle-choose-icon').toggleClass('hidden-tag');
    });
    
    $('body').on('click', '.nasa-chosen-icon', function() {
        var _fill = $(this).attr('data-fill');
        if (_fill) {
            if ($('.nasa-list-icons-select').length < 1) {
                $.ajax({
                    url: ajaxurl,
                    type: 'get',
                    dataType: 'html',
                    data: {
                        action: 'nasa_list_fonts_admin',
                        fill: _fill
                    },
                    success: function(res){
                        $('body').append(res);
                        $('body').append('<div class="nasa-tranparent" />');
                        $('.nasa-list-icons-select').animate({right: 0}, 300);
                    }
                });
            } else {
                $('body').append('<div class="nasa-tranparent" />');
                $('.nasa-list-icons-select').attr('data-fill', _fill);
                $('.nasa-list-icons-select').animate({right: 0}, 300);
            }
        }
        
        return false;
    });
    
    $('body').on('click', '.nasa-tranparent', function (){
        if ($('.nasa-list-icons-select').length) {
            $('.nasa-list-icons-select').animate({right: '-500px'}, 300);
        }
        $(this).remove();
    });
    
    // Search icons
    $('body').on('keyup', '.nasa-input-search-icon', function (){
        searchIcons($);
    });
    
    $('body').on('click', '.nasa-fill-icon', function (){
        var _val = $(this).attr('data-val');
        var _fill = $(this).parent().attr('data-fill');
        
        if ($('#'+_fill).length) {
            $('#'+_fill).val(_val);
        }
        
        if ($('input[name="'+_fill+'"]').length) {
            $('input[name="'+_fill+'"]').val(_val);
        }
        
        if ($('#ico-'+_fill).length){
            $('#ico-'+_fill).html('<i class="' + _val + '"></i><a href="javascript:void(0);" class="nasa-remove-icon" data-id="' + _fill + '"><i class="fa fa-remove"></i></a>');
        }
        
        $('.nasa-tranparent').click();
    });
    
    $('body').on('click', '.nasa-remove-icon', function(){
        var _fill = $(this).attr('data-id');
        
        if ($('#'+_fill).length) {
            $('#'+_fill).val('');
        }
        
        if ($('input[name="'+_fill+'"]').length) {
            $('input[name="'+_fill+'"]').val('');
        }
        
        if ($('#ico-'+_fill).length) {
            $('#ico-'+_fill).html('');
        }
    });
    
    loadColorPicker($);
    $('.widget-control-save').ajaxComplete(function(){
        loadColorPicker($);
    });
    
    $(document).ajaxComplete(function(){
        if ($('input[name="section_nasa_icon"]').length) {
            $('input[name="section_nasa_icon"]').attr('readonly', true);
        }
    });
    
    $('body').on('change', '.nasa-select-attr', function(){
        var _warp = $(this).parents('.widget-content');
        if ($(_warp).find('.nasa-vari-type').val() === '1') {
            var taxonomy = $(this).val(),
                num = $(this).attr('data-num'),
                instance = $(_warp).find('.nasa-widget-instance').attr('data-instance');
            loadColorDefault($, _warp, taxonomy, num, instance, false);
        }
        
        return true;
    });
    
    $('body').on('change', '.nasa-vari-type', function() {
        var _warp = $(this).parents('.widget-content'),
            taxonomy = $(_warp).find('.nasa-select-attr').val(),
            num = $(_warp).find('.nasa-select-attr').attr('data-num'),
            instance = $(_warp).find('.nasa-widget-instance').attr('data-instance');
        if ($(this).val() === '1') {  
            loadColorDefault($, _warp, taxonomy, num, instance, true);
        } else {
            unloadColor($, _warp);
        }
        
        return true;
    });
    
    // Option Breadcrumb
    if ($('.nasa-breadcrumb-flag-option input[type="checkbox"]').is(':checked')){
	$('.nasa-breadcrumb-type-option').show();
        $('.nasa-breadcrumb-align-option').show();
	if ($('.nasa-breadcrumb-type-option').find('select').val() === 'has-background'){
	    $('.nasa-breadcrumb-bg-option').show();
            // $('.nasa-breadcrumb-bg-lax').show();
	    loadImgOpBreadcrumb($);
	}
    }
    
    $('body').on('change', '.nasa-breadcrumb-flag-option input[type="checkbox"]', function(){
	if ($(this).is(':checked')){
	    $('.nasa-breadcrumb-type-option').fadeIn(200);
            $('.nasa-breadcrumb-align-option').fadeIn(200);
	    if ($('.nasa-breadcrumb-type-option').find('select').val() === 'has-background'){
		$('.nasa-breadcrumb-bg-option').fadeIn(200);
                // $('.nasa-breadcrumb-bg-lax').fadeIn(200);
		loadImgOpBreadcrumb($);
	    }
	} else {
	    $('.nasa-breadcrumb-type-option').fadeOut(200);
	    $('.nasa-breadcrumb-bg-option').fadeOut(200);
            // $('.nasa-breadcrumb-bg-lax').fadeOut(200);
            $('.nasa-breadcrumb-align-option').fadeOut(200);
	}
    });
    
    $('body').on('change', '.nasa-breadcrumb-type-option select', function() {
	if ($(this).val() === 'has-background') {
	    $('.nasa-breadcrumb-bg-option').fadeIn(200);
	    $('.nasa-breadcrumb-color-option').fadeIn(200);
            // $('.nasa-breadcrumb-bg-lax').fadeIn(200);
	    $('.nasa-breadcrumb-height-option').fadeIn(200);
            $('.nasa-breadcrumb-text-option').fadeIn(200);
	    loadImgOpBreadcrumb($);
	} else {
	    $('.nasa-breadcrumb-bg-option').fadeOut(200);
	    $('.nasa-breadcrumb-color-option').fadeOut(200);
            // $('.nasa-breadcrumb-bg-lax').fadeOut(200);
	    $('.nasa-breadcrumb-height-option').fadeOut(200);
	    $('.nasa-breadcrumb-text-option').fadeOut(200);
	}
    });
    
    if ($('.type_promotion select').length) {
        var val_promotion = $('.type_promotion select').val();
        if (val_promotion === 'custom') {
            $('.nasa-custom_content').show();
        } else if (val_promotion === 'list-posts') {
            $('.nasa-list_post').show();
        }
        $('body').on('change', '.type_promotion select', function() {
            var val_promotion = $(this).val();
            if (val_promotion === 'custom'){
                $('.nasa-custom_content').fadeIn(200);
                $('.nasa-list_post').fadeOut(200);
            } else if (val_promotion === 'list-posts') {
                $('.nasa-custom_content').fadeOut(200);
                $('.nasa-list_post').fadeIn(200);
            }
        });
    }
    
    if ($('.nasa-header-type-select input[type="radio"][name="header-type"]').length > 0) {
        var _val_header = $('.nasa-header-type-select input[type="radio"][name="header-type"]:checked').val();
        $('.nasa-header-type-select-' + _val_header).slideDown(200);
        
        $('body').on('click', '.nasa-header-type-select img.of-radio-img-img', function() {
            var _val_header = $('.nasa-header-type-select input[type="radio"][name="header-type"]:checked').val();
            $('.nasa-header-type-select-' + _val_header).slideDown(200);
            $('.nasa-header-type-child').each(function() {
                if (!$(this).hasClass('nasa-header-type-select-' + _val_header)) {
                    $(this).slideUp(200);
                }
            });
        });
    }
    
    if ($('.nasa-type-font select').length) {
        var _val_font = $('.nasa-type-font select').val();
        $('.nasa-type-font-' + _val_font).slideDown(200);
        
        $('body').on('change', '.nasa-type-font select', function() {
            var _val_font = $(this).val();
            $('.nasa-type-font-glb').slideUp(200);
            $('.nasa-type-font-' + _val_font).slideDown(200);
        });
    }
    
    $('.nasa-theme-option-parent select').each(function() {
        var _val = $(this).val();
        var _id = $(this).attr('id');
        $('.nasa-' + _id + '.nasa-theme-option-child').hide();
        $('.nasa-' + _id + '-' + _val + '.nasa-theme-option-child').show();
    });
    $('body').on('change', '.nasa-theme-option-parent select', function() {
        var _val = $(this).val();
        var _id = $(this).attr('id');
        $('.nasa-' + _id + '.nasa-theme-option-child').slideUp(200);
        $('.nasa-' + _id + '-' + _val + '.nasa-theme-option-child').slideDown(200);
    });
    
    if ($('.nasa-topbar_toggle input[type="checkbox"]').is(':checked')) {
	$('.nasa-topbar_df-show').show();
    }
    
    $('body').on('change', '.nasa-topbar_toggle input[type="checkbox"]', function() {
	if ($(this).is(':checked')) {
	    $('.nasa-topbar_df-show').slideDown(200);
	} else {
	    $('.nasa-topbar_df-show').slideUp(200);
	}
    });
    
    $('body').on('click', '.nasa-check-intagram', function() {
        var _wrap = $(this).parents('.section');
        var _token = $(_wrap).find('input.nasa_instagram').val();
        if (_token) {
            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'nasa_check_instagram_token',
                    access_token: _token
                },
                success: function(res) {
                    if (res.error === '0') {
                        $(_wrap).find('.of-intagram-acc').html(res.output);
                        $(_wrap).find('input.nasa_instagram_info').val(res.info);
                        $(_wrap).find('.nasa-remove-intagram').removeClass('hidden-tag');
                        $(_wrap).find('.nasa-check-intagram, .nasa-get-intagram, input.nasa_instagram').addClass('hidden-tag');
                    }
                }
            });
        } else {
            alert('Please Get and Enter Instagram Access Token!');
        }
    });
    
    $('body').on('click', '.nasa-remove-intagram', function() {
        var _wrap = $(this).parents('.section');
        $(_wrap).find('input.nasa_instagram').val('');
        $(_wrap).find('input.nasa_instagram_info').val('');
        $(_wrap).find('.of-intagram-acc').html('');
        $(this).addClass('hidden-tag');
        $(_wrap).find('.nasa-check-intagram, .nasa-get-intagram, input.nasa_instagram').removeClass('hidden-tag');
    });
    
    /* =============== End document ready !!! ================== */
});

function loadImgOpBreadcrumb($){
    if ($('.nasa-breadcrumb-bg-option .screenshot').length && $('.nasa-breadcrumb-bg-option #breadcrumb_bg_upload').val() !== '') {
	if ($('.nasa-breadcrumb-bg-option .screenshot').html() === '') {
	    $('.nasa-breadcrumb-bg-option .screenshot').html('<img class="of-option-image" src="' + $('.nasa-breadcrumb-bg-option #breadcrumb_bg_upload').val() + '" />');
	    $('.upload_button_div .remove-image').removeClass('hide').show();
	}
    }
}

function loadColorDefault($, _warp, _taxonomy, _num, _instance, _check){
    if (_check && $(_warp).find('.nasa_p_color').length){
        var _this = $(_warp).find('.nasa_p_color');
        $(_this).find('input').prop('disabled', false);
        $(_this).show();
    }else{
        _instance = _instance.toLocaleString();
        $.ajax({
	    url: ajaxurl,
	    type: 'post',
	    dataType: 'html',
	    data: {
		action: 'nasa_list_colors_admin',
                taxonomy: _taxonomy,
		num: _num,
                instance: _instance
	    },
	    success: function(res) {
                $(_warp).find('.nasa_p_color').remove();
		$(_warp).append(res);
                loadColorPicker($);
	    }
	});
    }
}

function unloadColor($, _warp){
    var _this = $(_warp).find('.nasa_p_color');
    $(_this).find('input').prop('disabled', true);
    $(_this).hide();
}

function loadColorPicker($){
    $('.nasa-color-field').each(function(){
        if ($(this).parents('.wp-picker-container').length < 1) {
            $(this).wpColorPicker();
        }
    });
};

function loadListIcons($) {
    if ($('.nasa-list-icons-select').length < 1) {
	$.ajax({
	    url: ajaxurl,
	    type: 'get',
	    dataType: 'html',
	    data: {
		action: 'nasa_list_fonts_admin',
		fill: ''
	    },
	    success: function(res){
		$('body').append(res);
	    }
	});
    }
};

function searchIcons($){
    var _textsearch = $.trim($('.nasa-input-search-icon').val());
    if (_textsearch === '') {
        $('.nasa-font-icons').fadeIn(200);
    } else {
        var patt = new RegExp(_textsearch);
        $('.nasa-font-icons').each(function (){
            var _sstext = $(this).attr('data-text');
            if (patt.test(_sstext)) {
                $(this).fadeIn(200);
            } else {
                $(this).fadeOut(200);
            }
        });
    }
}
