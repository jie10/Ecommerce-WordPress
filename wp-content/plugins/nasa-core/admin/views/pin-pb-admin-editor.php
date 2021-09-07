<?php defined('ABSPATH') or die(); ?>

<style>
    .composer-switch,
    #wpb_visual_composer,
    .wp-editor-expand {
        display: none !important;
    }
    
    .nasa_pin_pb_image_wrap {
        position: relative;
        text-align: center;
        width: 100%;
    }
    
    .nasa-wrap-relative-image {
        display: inline-block;
    }
    
    .nasa-wrap-relative-image img.nasa_pin_pb_image,
    .select2-container {
        display: block;
    }
    
    .select2-container.inited {
        margin-top: 10px;
    }
    
    .select2-container.inited .select2-choice .select2-arrow {
        background: none;
        border: none;
    }
    
    .easy-delete {
        z-index: 9999;
    }
    
    .easy-submit {
        display: block;
        width: 100%;
        margin: 20px auto 10px;
        cursor: pointer;
    }
    
    .container-wrap-nasa-pin-pb{
        text-align: left;
    }
    
    #nasa_media_manager{
        margin: 10px auto;
        width: 200px;
        cursor: pointer;
    }
    
    .nasa-media-btn {
        text-align: center;
    }
</style>
<input type="hidden" id="nasa_pin_slug" name="nasa_pin_slug" value="<?php echo esc_attr($post->post_name); ?>" />
<script>
    var nasa_pin_pb = {
        'url_search': "<?php echo admin_url('admin-ajax.php?action=woocommerce_json_search_products_and_variations'); ?>",
        '_nonce': "<?php echo wp_create_nonce('search-products'); ?>"
    };
    
    function initSelect2($, _obj) {
        if (!$(_obj).hasClass('inited')) {
            
            $(_obj).select2({
                minimumInputLength: 3,
                ajax: {
                    url: nasa_pin_pb.url_search,
                    dataType: 'json',
                    delay: 250,
                    data: function(terms) {
                        return {
                            term: terms,
                            security: nasa_pin_pb._nonce
                        };
                    },
                    results: function(data) {
                        var results = [];

                        for (var id in data) {
                            results.push({
                                id: id,
                                text: data[id].replace('&ndash;', ' - ')
                            });
                        }

                        return {
                            results: results
                        };
                    }
                },
                initSelection: function(element, callback) {
                    var id = $(element).val();

                    if (id !== '') {
                        $.ajax(nasa_pin_pb.url_search + '&term=' + id + '&security=' + nasa_pin_pb._nonce, {
                            dataType: 'json'
                        }).done(function(data) {
                            callback(data);
                        });
                    }
                }
            });

            $(_obj).addClass('inited');
            
            $(_obj).change(function() {
                var theText = $(_obj).select2('data').text;
                var _textarea = theText;
                $(_obj).parents('.modalContext').find('textarea').val(_textarea);
            });
        }
    }
    
    jQuery(document).ready(function ($) {
        $('#post-body-content').append($('#wrap-nasa-pin-pb').html());
        $('#wpb_visual_composer').remove();
        $('.composer-switch').hide();

        var _instance = null;
        if (!$('.nasa_pin_pb_image').hasClass('no-image')) {
            _instance = $('.nasa_pin_pb_image').easypin({
                init: <?php echo $_init; ?>,
                markerSrc: '<?php echo NASA_CORE_PLUGIN_URL . 'assets/images/plus-marker.png'; ?>',
                editSrc: '<?php echo NASA_CORE_PLUGIN_URL . 'assets/images/edit.png'; ?>',
                deleteSrc: '<?php echo NASA_CORE_PLUGIN_URL . 'assets/images/remove.png'; ?>',
                modalWidth: 400,
                
                /**
                 * Fixed position when drop
                 */
                drop: function(x, y, element) {
                    x = x + 15;
                    y = y + 48;
                    element.attr('data-x', x);
                    element.attr('data-y', y);
                },
                        
                done: function() {
                    return true;
                }
            });
        }
        
        $('.nasa_pin_pb_image_wrap').on('click', '.easy-edit', function () {
            $('.nasa-wrap-relative-image .select_product').each(function() {
                initSelect2($, this);
            });
        });
        
        $('body').on('click', '#publishing-action input', function(e) {
            _instance.easypin.event("get.coordinates", function(_instance, data, params) {
                var options = JSON.parse(data);

                if (options !== null && typeof options.nasa_pin_pb !== 'undefined') {
                    var _key;
                    var _pins = [];
                    for(_key in options.nasa_pin_pb) {
                        if (_key !== 'canvas') {
                            _pins.push(options.nasa_pin_pb[_key]);
                        } else {
                            $('#nasa_image_width').val(options.nasa_pin_pb[_key].width);
                            $('#nasa_image_height').val(options.nasa_pin_pb[_key].height);
                        }
                    }

                    $('#nasa_options_pin').val(JSON.stringify(_pins));
                } else {
                    $('#nasa_image_width').val('');
                    $('#nasa_image_height').val('');
                    $('#nasa_options_pin').val('');
                }
            });
            
            _instance.easypin.fire("get.coordinates", {}, function(data) {
                return JSON.stringify(data);
            });
        });

        if (typeof wp !== 'undefined') {
            $('body').on('click', 'input#nasa_media_manager', function (e) {
                e.preventDefault();
                var image = wp.media({ 
                    title: 'Upload Image',
                    // mutiple: true if you want to upload multiple files at once
                    multiple: false
                }).open()
                .on('select', function(e){
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_image = image.state().get('selection').first();
                    // We convert uploaded_image to a JSON object to make accessing it easier
                    // Output to the console uploaded_image
                    var imgObj = uploaded_image.toJSON();
                    
                    // Let's assign the url value to the input field
                    $('#nasa_image_url').val(imgObj.id);
                    $('.nasa_pin_pb_image_wrap .nasa-wrap-relative-image').html('<img class="nasa_pin_pb_image" src="' + imgObj.url + '" data-easypin_id="nasa_pin_pb" />');
                    _instance = $('.nasa_pin_pb_image').easypin({
                        init: '{}',
                        markerSrc: '<?php echo NASA_CORE_PLUGIN_URL . 'assets/images/plus-marker.png'; ?>',
                        editSrc: '<?php echo NASA_CORE_PLUGIN_URL . 'assets/images/edit.png'; ?>',
                        deleteSrc: '<?php echo NASA_CORE_PLUGIN_URL . 'assets/images/remove.png'; ?>',
                        modalWidth: 400,
                        /**
                         * Fixed position when drop
                         */
                        drop: function(x, y, element) {
                            x = x + 15;
                            y = y + 48;
                            element.attr('data-x', x);
                            element.attr('data-y', y);
                        },
                        
                        done: function() {
                            return true;
                        }
                    });
                });
            });
        }
    });
</script>

<script id="wrap-nasa-pin-pb" type="text/template">
<div class="container-wrap-nasa-pin-pb">
    <input id="nasa_image_url" type="hidden" name="nasa_pin_pb_image_url" value="<?php echo (int) $attachment_id; ?>" />
    <input id="nasa_image_width" type="hidden" name="nasa_pin_pb_image_width" value="<?php echo (int) $_width; ?>" />
    <input id="nasa_image_height" type="hidden" name="nasa_pin_pb_image_height" value="<?php echo (int) $_height; ?>" />
    <input id="nasa_options_pin" type="hidden" name="nasa_pin_pb_options" value="<?php echo esc_attr($_options); ?>" />
    <div class="nasa-media-btn">
        <input type="button" id="nasa_media_manager" value="Media" />
    </div>
    
    <div class="nasa_pin_pb_image_wrap">
        <span class="nasa-wrap-relative-image">
            <img class="nasa_pin_pb_image<?php echo $no_image ? ' no-image' : ''; ?>" src="<?php echo esc_url($image_src); ?>" data-easypin_id="nasa_pin_pb" />
        </span>
        
        <div class="easy-modal" style="display:none;" modal-position="free">
            <?php echo esc_html__('Find product', 'nasa-core'); ?>
            <textarea name="content" class="hidden-tag"></textarea>
            <input class="select_product" name="product_id" type="text" value="" />
                
            <p><?php echo esc_html__('Display Position', 'nasa-core'); ?></p>
            <select name="position_show" style="display: block; width: 100%;">
                <option value="top"><?php echo esc_html__('Top of Pin', 'nasa-core'); ?></option>
                <option value="left"><?php echo esc_html__('Left of Pin', 'nasa-core'); ?></option>
                <option value="right"><?php echo esc_html__('Right of Pin', 'nasa-core'); ?></option>
                <option value="bottom"><?php echo esc_html__('Bottom of Pin', 'nasa-core'); ?></option>
            </select>
            
            <input type="button" value="Save" class="easy-submit" />
        </div>
        
        <!-- popover -->
        <div style="display:none; width: 200px;" shadow="true" popover>
            <div style="width:100%;text-align:center;">{[content]}</div>
        </div>
    </div>
</div>
</script>
