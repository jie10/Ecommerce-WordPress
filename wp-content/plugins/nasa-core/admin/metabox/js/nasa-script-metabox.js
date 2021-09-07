jQuery(document).ready(function($){
    "use strict";
    
    if ($('.nasa-breadcrumb-flag input[type="checkbox"]').is(':checked')){
	$('.nasa-breadcrumb-type').show();
	if ($('.nasa-breadcrumb-type').find('select').val() === '1'){
	    $('.nasa-breadcrumb-bg').show();
	    // $('.nasa-breadcrumb-bg-color').show();
	}
        
        $('.nasa-breadcrumb-bg-color').show();
        $('.nasa-breadcrumb-height').show();
        $('.nasa-breadcrumb-color').show();
    }
    
    $('body').on('change', '.nasa-breadcrumb-flag input[type="checkbox"]', function() {
	if ($(this).is(':checked')){
	    $('.nasa-breadcrumb-type').fadeIn(200);
	    if ($('.nasa-breadcrumb-type').find('select').val() === '1'){
		$('.nasa-breadcrumb-bg').fadeIn(200);
		// $('.nasa-breadcrumb-bg-color').fadeIn(200);
	    }
            
            $('.nasa-breadcrumb-bg-color').show();
            $('.nasa-breadcrumb-height').fadeIn(200);
            $('.nasa-breadcrumb-color').fadeIn(200);
	} else {
	    $('.nasa-breadcrumb-type').fadeOut(200);
	    $('.nasa-breadcrumb-bg').fadeOut(200);
	    $('.nasa-breadcrumb-bg-color').fadeOut(200);
	    $('.nasa-breadcrumb-height').fadeOut(200);
	    $('.nasa-breadcrumb-color').fadeOut(200);
	}
    });
    
    $('body').on('change', '.nasa-breadcrumb-type select', function(){
	if ($(this).val() === '1'){
	    $('.nasa-breadcrumb-bg').fadeIn(200);
	    // $('.nasa-breadcrumb-bg-color').fadeIn(200);
	} else {
	    $('.nasa-breadcrumb-bg').fadeOut(200);
	    // $('.nasa-breadcrumb-bg-color').fadeOut(200);
	}
    });
    
    if ($('.nasa-override-root input[type="checkbox"]').length) {
        $('.nasa-override-root input[type="checkbox"]').each(function() {
            if ($(this).is(':checked')) {
                var _target = $(this).attr('id');
                $('.nasa-override-child.' + _target).fadeIn(200);
            }
        });
    }
    $('body').on('change', '.nasa-override-root input[type="checkbox"]', function(){
        var _target = $(this).attr('id');
        
	if ($(this).is(':checked')){
	    $('.nasa-override-child.' + _target).fadeIn(200);
	} else {
	    $('.nasa-override-child.' + _target).fadeOut(200);
	}
    });
    
    if ($('.nasa-select-header-type-page select').val() === '2'){
        $('.nasa-header-type-2-menu').fadeIn(200);
        $('.nasa-select-header-type-page-2').fadeIn(200);
    }
    $('body').on('change', '.nasa-select-header-type-page select', function(){
	if ($(this).val() === '2'){
	    $('.nasa-header-type-2-menu').fadeIn(200);
            $('.nasa-select-header-type-page-2').fadeIn(200);
	} else {
	    $('.nasa-header-type-2-menu').fadeOut(200);
            $('.nasa-select-header-type-page-2').fadeOut(200);
	}
    });
    
    $('.nasa-core-option-parent select').each(function() {
        var _val = $(this).val();
        var _id = $(this).attr('id');
        $('.core' + _id + '.nasa-core-option-child').hide();
        $('.core' + _id + '-' + _val + '.nasa-core-option-child').show();
    });
    $('body').on('change', '.nasa-core-option-parent select', function(){
        var _val = $(this).val();
        var _id = $(this).attr('id');
        $('.core' + _id + '.nasa-core-option-child').hide();
        $('.core' + _id + '-' + _val + '.nasa-core-option-child').fadeIn(200);
    });
    
    /* =============== End document ready !!! ================== */
});
