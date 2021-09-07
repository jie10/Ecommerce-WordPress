<?php defined('ABSPATH') or die(); ?>

<style>
    .composer-switch,
    #wpb_visual_composer,
    .wp-editor-expand {
        display: none !important;
    }
    
    .nasa_pin_mb_image_wrap {
        position: relative;
        text-align: center;
        width: 100%;
    }
    
    .nasa-wrap-relative-image {
        display: inline-block;
    }
    
    .nasa-wrap-relative-image img.nasa_pin_mb_image {
        display: block;
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
    
    .container-wrap-nasa-pin-mb{
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
    
    .nasa-content-material {
        width: 100%;
        min-height: 65px;
    }
</style>
<input type="hidden" id="nasa_pin_slug" name="nasa_pin_slug" value="<?php echo esc_attr($post->post_name); ?>" />
<script>
    jQuery(document).ready(function ($) {
        $('#post-body-content').append($('#wrap-nasa-pin-mb').html());
        $('#wpb_visual_composer').remove();
        $('.composer-switch').hide();

        var _instance = null;
        if (!$('.nasa_pin_mb_image').hasClass('no-image')) {
            _instance = $('.nasa_pin_mb_image').easypin({
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
        
        $('body').on('click', '#publishing-action input', function(e) {
            _instance.easypin.event("get.coordinates", function(_instance, data, params) {
                var options = JSON.parse(data);

                if (options !== null && typeof options.nasa_pin_mb !== 'undefined') {
                    var _key;
                    var _pins = [];
                    for(_key in options.nasa_pin_mb) {
                        if (_key !== 'canvas') {
                            _pins.push(options.nasa_pin_mb[_key]);
                        } else {
                            $('#nasa_image_width').val(options.nasa_pin_mb[_key].width);
                            $('#nasa_image_height').val(options.nasa_pin_mb[_key].height);
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
                    $('.nasa_pin_mb_image_wrap .nasa-wrap-relative-image').html('<img class="nasa_pin_mb_image" src="' + imgObj.url + '" data-easypin_id="nasa_pin_mb" />');
                    _instance = $('.nasa_pin_mb_image').easypin({
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

<script id="wrap-nasa-pin-mb" type="text/template">
<div class="container-wrap-nasa-pin-mb">
    <input id="nasa_image_url" type="hidden" name="nasa_pin_mb_image_url" value="<?php echo (int) $attachment_id; ?>" />
    <input id="nasa_image_width" type="hidden" name="nasa_pin_mb_image_width" value="<?php echo (int) $_width; ?>" />
    <input id="nasa_image_height" type="hidden" name="nasa_pin_mb_image_height" value="<?php echo (int) $_height; ?>" />
    <input id="nasa_options_pin" type="hidden" name="nasa_pin_mb_options" value="<?php echo esc_attr($_options); ?>" />
    <div class="nasa-media-btn">
        <input type="button" id="nasa_media_manager" value="Media" />
    </div>
    
    <div class="nasa_pin_mb_image_wrap">
        <span class="nasa-wrap-relative-image">
            <img class="nasa_pin_mb_image<?php echo $no_image ? ' no-image' : ''; ?>" src="<?php echo esc_url($image_src); ?>" data-easypin_id="nasa_pin_mb" />
        </span>
        
        <div class="easy-modal" style="display:none;" modal-position="free">
            <?php echo esc_html__('Input Material', 'nasa-core'); ?>
            <textarea name="content" class="nasa-content-material"></textarea>

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
