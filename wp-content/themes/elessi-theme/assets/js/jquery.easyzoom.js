(function (root, factory) {
    'use strict';
    if(typeof define === 'function' && define.amd) {
        define(['jquery'], function($){
            factory($);
        });
    } else if(typeof module === 'object' && module.exports) {
        module.exports = (root.EasyZoom = factory(require('jquery')));
    } else {
        root.EasyZoom = factory(root.jQuery);
    }
}(this, function ($) {
    'use strict';

    var zoomImgOverlapX;
    var zoomImgOverlapY;
    var ratioX;
    var ratioY;
    var pointerPositionX;
    var pointerPositionY;

    var defaults = {

        // The text to display within the notice box while loading the zoom image.
        loadingNotice: 'Loading image',

        // The text to display within the notice box if an error occurs when loading the zoom image.
        errorNotice: 'The image could not be loaded',

        // The time (in milliseconds) to display the error notice.
        errorDuration: 2500,

        // Attribute to retrieve the zoom image URL from.
        linkAttribute: 'href',

        // Prevent clicks on the zoom image link.
        preventClicks: true,

        // Callback function to execute before the flyout is displayed.
        beforeShow: $.noop,

        // Callback function to execute before the flyout is removed.
        beforeHide: $.noop,

        // Callback function to execute when the flyout is displayed.
        onShow: $.noop,

        // Callback function to execute when the flyout is removed.
        onHide: $.noop,

        // Callback function to execute when the cursor is moved while over the image.
        onMove: $.noop

    };

    /**
     * EasyZoom
     * @constructor
     * @param {Object} target
     * @param {Object} options (Optional)
     */
    function EasyZoom(target, options) {
        this.$target = $(target);
        this.opts = $.extend({}, defaults, options, this.$target.data());

        this.isOpen === undefined && this._init();
    }

    /**
     * Init
     * @private
     */
    EasyZoom.prototype._init = function() {
        this.$link   = this.$target.find('a');
        this.$image  = this.$target.find('img');

        this.$flyout = $('<div class="easyzoom-flyout" />');
        this.$notice = $('<div class="easyzoom-notice" />');

        this.$target.on({
            'mousemove.easyzoom touchmove.easyzoom': $.proxy(this._onMove, this),
            'mouseleave.easyzoom touchend.easyzoom': $.proxy(this._onLeave, this),
            'mouseenter.easyzoom touchstart.easyzoom': $.proxy(this._onEnter, this)
        });

        this.opts.preventClicks && this.$target.on('click.easyzoom', function(e) {
            e.preventDefault();
        });
    };

    /**
     * Show
     * @param {MouseEvent|TouchEvent} e
     * @param {Boolean} testMouseOver (Optional)
     */
    EasyZoom.prototype.show = function(e, testMouseOver) {
        var self = this;

        if (this.opts.beforeShow.call(this) === false) return;

        if (!this.isReady) {
            return this._loadImage(this.$link.attr(this.opts.linkAttribute), function() {
                if (self.isMouseOver || !testMouseOver) {
                    self.show(e);
                }
            });
        }

        this.$target.append(this.$flyout);

        var targetWidth = this.$target.outerWidth();
        var targetHeight = this.$target.outerHeight();

        var flyoutInnerWidth = this.$flyout.width();
        var flyoutInnerHeight = this.$flyout.height();

        var zoomImgWidth = this.$zoom.width();
        var zoomImgHeight = this.$zoom.height();

        zoomImgOverlapX = zoomImgWidth - flyoutInnerWidth;
        zoomImgOverlapY = zoomImgHeight - flyoutInnerHeight;

        // For when the zoom image is smaller than the flyout element.
        if (zoomImgOverlapX < 0) zoomImgOverlapX = 0;
        if (zoomImgOverlapY < 0) zoomImgOverlapY = 0;

        ratioX = zoomImgOverlapX / targetWidth;
        ratioY = zoomImgOverlapY / targetHeight;

        this.isOpen = true;

        this.opts.onShow.call(this);

        e && this._move(e);
    };

    /**
     * On enter
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._onEnter = function(e) {
        var touches = e.originalEvent.touches;

        this.isMouseOver = true;

        if (!touches || touches.length == 1) {
            e.preventDefault();
            this.show(e, true);
        }
    };

    /**
     * On move
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._onMove = function(e) {
        if (!this.isOpen) return;

        e.preventDefault();
        this._move(e);
    };

    /**
     * On leave
     * @private
     */
    EasyZoom.prototype._onLeave = function() {
        this.isMouseOver = false;
        this.isOpen && this.hide();
    };

    /**
     * On load
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._onLoad = function(e) {
        // IE may fire a load event even on error so test the image dimensions
        if (!e.currentTarget.width) return;

        this.isReady = true;

        this.$notice.detach();
        this.$flyout.html(this.$zoom);
        this.$target.removeClass('is-loading').addClass('is-ready');

        e.data.call && e.data();
    };

    /**
     * On error
     * @private
     */
    EasyZoom.prototype._onError = function() {
        var self = this;

        this.$notice.text(this.opts.errorNotice);
        this.$target.removeClass('is-loading').addClass('is-error');

        this.detachNotice = setTimeout(function() {
            self.$notice.detach();
            self.detachNotice = null;
        }, this.opts.errorDuration);
    };

    /**
     * Load image
     * @private
     * @param {String} href
     * @param {Function} callback
     */
    EasyZoom.prototype._loadImage = function(href, callback) {
        var zoom = new Image();

        this.$target
            .addClass('is-loading')
            .append(this.$notice.text(this.opts.loadingNotice));

        this.$zoom = $(zoom)
            .on('error', $.proxy(this._onError, this))
            .on('load', callback, $.proxy(this._onLoad, this));

        zoom.style.position = 'absolute';
        zoom.src = href;
    };

    /**
     * Move
     * @private
     * @param {Event} e
     */
    EasyZoom.prototype._move = function(e) {

        if (e.type.indexOf('touch') === 0) {
            var touchlist = e.touches || e.originalEvent.touches;
            pointerPositionX = touchlist[0].pageX;
            pointerPositionY = touchlist[0].pageY;
        } else {
            pointerPositionX = e.pageX || pointerPositionX;
            pointerPositionY = e.pageY || pointerPositionY;
        }

        var targetOffset  = this.$target.offset();
        var relativePositionX = pointerPositionY - targetOffset.top;
        var relativePositionY = pointerPositionX - targetOffset.left;
        var moveX = Math.ceil(relativePositionX * ratioY);
        var moveY = Math.ceil(relativePositionY * ratioX);

        // Close if outside
        if (moveY < 0 || moveX < 0 || moveY > zoomImgOverlapX || moveX > zoomImgOverlapY) {
            this.hide();
        } else {
            var top = moveX * -1;
            var left = moveY * -1;

            this.$zoom.css({
                top: top,
                left: left
            });

            this.opts.onMove.call(this, top, left);
        }

    };

    /**
     * Hide
     */
    EasyZoom.prototype.hide = function() {
        if (!this.isOpen) return;
        if (this.opts.beforeHide.call(this) === false) return;

        this.$flyout.detach();
        this.isOpen = false;

        this.opts.onHide.call(this);
    };

    /**
     * Swap
     * @param {String} standardSrc
     * @param {String} zoomHref
     * @param {String|Array} srcset (Optional)
     */
    EasyZoom.prototype.swap = function(standardSrc, zoomHref, srcset) {
        this.hide();
        this.isReady = false;

        this.detachNotice && clearTimeout(this.detachNotice);

        this.$notice.parent().length && this.$notice.detach();

        this.$target.removeClass('is-loading is-ready is-error');

        this.$image.attr({
            src: standardSrc,
            srcset: Array.isArray(srcset) ? srcset.join() : srcset
        });

        this.$link.attr(this.opts.linkAttribute, zoomHref);
    };

    /**
     * Teardown
     */
    EasyZoom.prototype.teardown = function() {
        this.hide();

        this.$target
            .off('.easyzoom')
            .removeClass('is-loading is-ready is-error');

        this.detachNotice && clearTimeout(this.detachNotice);

        delete this.$link;
        delete this.$zoom;
        delete this.$image;
        delete this.$notice;
        delete this.$flyout;

        delete this.isOpen;
        delete this.isReady;
    };

    // jQuery plugin wrapper
    $.fn.easyZoom = function(options) {
        return this.each(function() {
            var api = $.data(this, 'easyZoom');

            if (!api) {
                $.data(this, 'easyZoom', new EasyZoom(this, options));
            } else if (api.isOpen === undefined) {
                api._init();
            }
        });
    };

    return EasyZoom;
}));

/**
 * Ready init easyZoom
 * @type type
 */
var iOS = check_iOS();
jQuery(document).ready(function($) {
    "use strict";
    
    var _zoom = $('body').hasClass('product-zoom') ? true : false;

    /**
     * Disabled easyZoom in ipad
     */
    if (_zoom && !/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) && !iOS) {
        $('body').on('touchstart', '*', function() {
            if ($('.product-zoom .easyzoom').length > 0) {
                $('.product-zoom .easyzoom').each(function() {
                    var _easyZoom = $(this);
                    if (!$(_easyZoom).hasClass('nasa-disabled-touchstart')) {
                        var _easyZoom_init = $(_easyZoom).easyZoom();
                        var api_easyZoom = _easyZoom_init.data('easyZoom');
                        api_easyZoom.teardown();

                        $(_easyZoom).addClass('nasa-disabled-touchstart');
                    }
                });
            }
        });
    }
    
    $('body').on('nasa_before_changed_src_main_img', function() {
        if (_zoom && $('.product-zoom .easyzoom').length) {
            if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) && !iOS && $('.product-zoom .easyzoom .nasa-disabled-touchstart').length <= 0) {
                $('.product-zoom .easyzoom').easyZoom();
            }
        }
    });
    
    $('body').on('nasa_after_changed_src_main_img', function(ev, image_large, image_link) {
        // var _zoom = $('body').hasClass('product-zoom') ? true : false;
        var _api_easyZoom = false;

        if (_zoom && $('.product-zoom .easyzoom').length) {
            if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) && !iOS && $('.product-zoom .easyzoom .nasa-disabled-touchstart').length <= 0) {
                var _api_easyZoom = $('.product-zoom .easyzoom').data('easyZoom');
            }
        }
        
        if (_api_easyZoom) {
            _api_easyZoom.swap(image_large, image_link);
            var _imgChange = $('.main-images .nasa-item-main-image-wrap[data-key="0"] img');
            if ($(_imgChange).hasClass('jetpack-lazy-image')) {
                $(_imgChange).attr('src', image_large);

                $(_imgChange)
                    .removeAttr('srcset')
                    .removeAttr('data-lazy-src');
            }
        }
        
        ev.preventDefault();
    });
    
    $('body').on('nasa_changed_gallery_variable_single', function() {
        reset_easy_zoom($);
    });
    
    $('body').on('nasa_product_gallery_remove_crazy', function() {
        reset_easy_zoom($);
    });
});

/**
 * Reset easyZoom
 * 
 * @param {type} $
 * @returns {undefined}
 */
function reset_easy_zoom($) {
    var _zoom = $('body').hasClass('product-zoom') ? true : false;
    if (_zoom && !/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) && !iOS && $('.product-zoom .easyzoom .nasa-disabled-touchstart').length <= 0) {
        if ($('.product-zoom .easyzoom').length > 0) {
            $('.product-zoom .easyzoom').each(function() {
                var _this = $(this);
                if (!$(_this).hasClass('nasa-loaded')) {
                    if ($(_this).find('> a').attr('href') === '') {
                        var _href = $(_this).find('> a').attr('data-o_href');
                        if (_href) {
                            $(_this).find('> a').attr('href', _href);
                        }
                    }

                    $(_this).addClass('nasa-loaded');
                }
            });
        }

        $('.product-zoom .easyzoom').easyZoom();
    }
}

/**
 * Check iOS
 * @returns {Boolean}
 */
function check_iOS() {
    var iDevices = [
        'iPad Simulator',
        'iPhone Simulator',
        'iPod Simulator',
        'iPad',
        'iPhone',
        'iPod'
    ];
    while (iDevices.length) {
        if (navigator.platform === iDevices.pop()) {
            return true;
        }
    }
    return false;
}
