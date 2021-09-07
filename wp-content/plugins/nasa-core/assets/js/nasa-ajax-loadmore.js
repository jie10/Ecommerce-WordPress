var product_load_flag = false;

/**
 * Document nasa-core ready
 */
jQuery(document).ready(function($) {
"use strict";

/* AJAX PRODUCTS LOAD MORE */
$('body').on('click', '.load-more-btn', function () {
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_more_product');

        if (product_load_flag) {
            return;
        } else {
            product_load_flag = true;
            var _this = $(this),
                _wrap = $(_this).parents('.nasa-products-infinite-wrap'),
                _infinite = $(_wrap).find('.nasa-products-infinite'),
                _type = $(_infinite).attr('data-product-type'),
                _page = parseInt($(_infinite).attr('data-next-page')),
                _cat = $(_infinite).attr('data-cat'),
                _style = $(_infinite).attr('data-style-item'),
                _post_per_page = parseInt($(_infinite).attr('data-post-per-page')),
                _post_per_row = parseInt($(_infinite).attr('data-post-per-row')),
                _post_per_row_medium = parseInt($(_infinite).attr('data-post-per-row-medium')),
                _post_per_row_small = parseInt($(_infinite).attr('data-post-per-row-small')),
                _max_pages = parseInt($(_infinite).attr('data-max-pages'));
            _cat = !_cat ? null : _cat;

            $.ajax({
                url: _urlAjax,
                type: 'post',
                cache: false,
                data: {
                    page: _page,
                    type: _type,
                    cat: _cat,
                    style: _style,
                    post_per_page: _post_per_page,
                    columns_number: _post_per_row,
                    columns_number_medium: _post_per_row_medium,
                    columns_number_small: _post_per_row_small,
                    nasa_load_ajax: '1'
                },
                beforeSend: function () {
                    $(_this).before('<div class="nasa-loader" id="nasa-loader-product-infinite"></div>');
                    if (!$(_this).find('.load-more-content').hasClass('nasa-visibility-hidden')) {
                        $(_this).find('.load-more-content').addClass('nasa-visibility-hidden');
                    }
                },
                success: function (res) {
                    if (typeof res.success !== 'undefined' && res.success === '1') {
                        var _content = res.content;
                        $(_infinite).find('.nasa-row-child-clear-none').append(_content).fadeIn(1000);
                        $(_infinite).attr('data-next-page', _page + 1);
                        $('#nasa-loader-product-infinite').remove();
                        $(_this).find('.load-more-content').removeClass('nasa-visibility-hidden');

                        if (_page == _max_pages) {
                            $(_this).addClass('end-product');
                            $(_this).html('<span class="nasa-end-content">' + $(_this).attr('data-nodata') + '</span>').removeClass('load-more-btn');
                        }

                        product_load_flag = false;

                        $('body').trigger('nasa_after_load_ajax');
                        
                        setTimeout(function(){
                            $('body').trigger('nasa_after_load_ajax_timeout');
                        }, 1000);
                    }
                }
            });

            return false;
        }
    }
});
});
