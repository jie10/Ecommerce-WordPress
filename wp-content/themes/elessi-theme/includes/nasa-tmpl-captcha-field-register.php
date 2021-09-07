<?php
/**
 * Template field Captcha Register form
 *
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;
?>
<script type="text/template" id="tmpl-captcha-field-register">
    <p class="form-row padding-top-10">
        <img src="?nasa-captcha-register={{key}}" class="nasa-img-captcha" />
        <a class="nasa-reload-captcha" href="javascript:void(0);" title="<?php echo esc_attr__('Reload', 'elessi-theme'); ?>" data-time="0" data-key="{{key}}" rel="nofollow"><i class="nasa-icon icon-nasa-refresh"></i></a>
        <input type="text" name="nasa-input-captcha" class="nasa-text-captcha" value="" placeholder="<?php echo esc_attr__('Captcha Code', 'elessi-theme'); ?>" />
        <input type="hidden" name="nasa-captcha-key" value="{{key}}" />
    </p>
</script>