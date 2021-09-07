<?php
/**
 * Login form
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.6.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (is_user_logged_in()) {
    return;
}
?>
<form class="woocommerce-form woocommerce-form-login login" method="post" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>

    <?php do_action('woocommerce_login_form_start'); ?>

    <?php echo ($message) ? wpautop(wptexturize($message)) : ''; // @codingStandardsIgnoreLine ?>

    <p class="form-row form-row-first">
        <label for="username"><?php esc_html_e('Username or email', 'elessi-theme'); ?>&nbsp;<span class="required">*</span></label>
        <input type="text" class="input-text" name="username" id="username" autocomplete="username" />
    </p>
    <p class="form-row form-row-last">
        <label for="password"><?php esc_html_e('Password', 'elessi-theme'); ?>&nbsp;<span class="required">*</span></label>
        <input class="input-text" type="password" name="password" id="password" autocomplete="current-password" />
    </p>
    <div class="clear"></div>

    <?php do_action('woocommerce_login_form'); ?>

    <p class="form-row submit_wrap">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'elessi-theme'); ?></span>
        </label>
        <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
        <input type="hidden" name="redirect" value="<?php echo esc_url($redirect) ?>" />
        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('Login', 'elessi-theme'); ?>"><?php esc_html_e('Login', 'elessi-theme'); ?></button>
    </p>
    <p class="lost_password">
        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'elessi-theme'); ?></a>
    </p>

    <div class="clear"></div>

    <?php do_action('woocommerce_login_form_end'); ?>

</form>
