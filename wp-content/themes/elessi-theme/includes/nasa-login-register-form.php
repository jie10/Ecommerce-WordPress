<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}

do_action('nasa_init_login_register_form');

$loginAjax = (bool) $prefix;
$prefix = $prefix ? 'nasa_' : '';

$nasa_keyUserName = $prefix . 'username';
$nasa_keyPass = $prefix . 'password';
$nasa_keyEmail = $prefix . 'email';
$nasa_keyLogin = $prefix . 'login';
$nasa_keyRememberme = $prefix . 'rememberme';

$nasa_keyRegUsername = $prefix . 'reg_username';
$nasa_keyRegEmail = $prefix . 'reg_email';
$nasa_keyRegPass = $prefix . 'reg_password';
$nasa_keyReg = $prefix . 'register';

$nasa_register = get_option('woocommerce_enable_myaccount_registration') == 'yes' ? true : false;

$styleRegister = $styleLogin = '';
if (isset($_REQUEST['register'])) {
    $styleRegister = ' style="left: 0px; position: relative;"';
    $styleLogin = ' style="left: -100%; position: absolute;"';
}
?>

<div class="row" id="<?php echo esc_attr($prefix); ?>customer_login">
    <div class="large-12 columns <?php echo esc_attr($prefix); ?>login-form"<?php echo $styleLogin; ?>>
        <span class="nasa-form-title">
            <?php esc_html_e('Great to have you back!', 'elessi-theme'); ?>
        </span>
        
        <form method="post" class="woocommerce-form woocommerce-form-login login">
            <?php do_action('woocommerce_login_form_start'); ?>

            <p class="form-row form-row-wide">
                <span>
                    <label for="<?php echo esc_attr($nasa_keyUserName); ?>" class="inline-block left rtl-right">
                        <?php esc_html_e('Username or email', 'elessi-theme'); ?> <span class="required">*</span>
                    </label>

                    <!-- Remember -->
                    <label for="<?php echo esc_attr($nasa_keyRememberme); ?>" class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline-block right rtl-left">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="<?php echo esc_attr($nasa_keyRememberme); ?>" type="checkbox" id="<?php echo esc_attr($nasa_keyRememberme); ?>" value="forever" /> <?php esc_html_e('Remember', 'elessi-theme'); ?>
                    </label>
                </span>
                
                <!-- Username -->
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="<?php echo esc_attr($nasa_keyUserName); ?>" id="<?php echo esc_attr($nasa_keyUserName); ?>" autocomplete="username" value="<?php echo (!empty($_POST[$nasa_keyUserName])) ? esc_attr(wp_unslash($_POST[$nasa_keyUserName])) : ''; ?>" />
            </p>
            
            <p class="form-row form-row-wide">
                <span>
                    <label for="<?php echo esc_attr($nasa_keyPass); ?>" class="inline-block left rtl-right">
                        <?php esc_html_e('Password', 'elessi-theme'); ?> <span class="required">*</span>
                    </label>
                    <a class="lost_password inline-block right rtl-left" href="<?php echo esc_url(wc_lostpassword_url()); ?>"><?php esc_html_e('Lost?', 'elessi-theme'); ?></a>
                </span>
                
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="<?php echo esc_attr($nasa_keyPass); ?>" id="<?php echo esc_attr($nasa_keyPass); ?>" autocomplete="current-password" />
            </p>

            <?php do_action('woocommerce_login_form'); ?>

            <p class="form-row row-submit">
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit nasa-fullwidth margin-top-10" name="<?php echo esc_attr($nasa_keyLogin); ?>" value="<?php esc_attr_e('SIGN IN TO YOUR ACCOUNT', 'elessi-theme'); ?>"><?php esc_html_e('SIGN IN TO YOUR ACCOUNT', 'elessi-theme'); ?></button>
            </p>

            <?php do_action('woocommerce_login_form_end'); ?>
        </form>
        
        <?php if ($nasa_register) : ?>
            <p class="nasa-switch-form">
                <?php esc_html_e('New here? ', 'elessi-theme'); ?>
                <a class="nasa-switch-register" href="javascript:void(0);" rel="nofollow">
                    <?php esc_html_e('Create an account', 'elessi-theme'); ?>
                </a>
            </p>
        <?php endif; ?>
    </div>

    <?php if ($nasa_register) : ?>
        <div class="large-12 columns <?php echo esc_attr($prefix); ?>register-form"<?php echo $styleRegister; ?>>

            <span class="nasa-form-title">
                <?php esc_html_e('Great to see you here!', 'elessi-theme'); ?>
            </span>
            
            <form method="post" class="woocommerce-form woocommerce-form-register register">
                
                <?php do_action('woocommerce_register_form_start'); ?>
                
                <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                    <p class="form-row form-row-wide">
                        <label for="<?php echo esc_attr($nasa_keyRegUsername); ?>" class="left rtl-right">
                            <?php esc_html_e('Username', 'elessi-theme'); ?> <span class="required">*</span>
                        </label>
                        
                        <!-- Username -->
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="<?php echo esc_attr($nasa_keyUserName); ?>" id="<?php echo esc_attr($nasa_keyRegUsername); ?>" autocomplete="username" value="<?php echo (!empty($_POST[$nasa_keyUserName])) ? esc_attr(wp_unslash($_POST[$nasa_keyUserName])) : ''; ?>" />
                    </p>

                <?php endif; ?>

                <p class="form-row form-row-wide">
                    <label for="<?php echo esc_attr($nasa_keyRegEmail); ?>" class="left rtl-right">
                        <?php esc_html_e('Email address', 'elessi-theme'); ?> <span class="required">*</span>
                    </label>
                    
                    <!-- Email -->
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="<?php echo esc_attr($nasa_keyEmail); ?>" id="<?php echo esc_attr($nasa_keyRegEmail); ?>" autocomplete="email" value="<?php echo (!empty($_POST[$nasa_keyEmail]) ) ? esc_attr(wp_unslash($_POST[$nasa_keyEmail])) : ''; ?>" />
                </p>

                <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
                    <p class="form-row form-row-wide">
                        <label for="<?php echo esc_attr($nasa_keyRegPass); ?>" class="left rtl-right">
                            <?php esc_html_e('Password', 'elessi-theme'); ?> <span class="required">*</span>
                        </label>
                        
                        <!-- Password -->
                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="<?php echo esc_attr($nasa_keyPass); ?>" id="<?php echo esc_attr($nasa_keyRegPass); ?>" autocomplete="new-password" />
                    </p>
                    
                <?php else : ?>
                    
                    <p class="form-row form-row-wide">
                        <?php esc_html_e( 'A password will be sent to your email address.', 'elessi-theme' ); ?>
                    </p>
                    
                <?php endif; ?>

                <?php do_action('woocommerce_register_form'); ?>

                <p class="form-row">
                    <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                    
                    <!-- Submit button -->
                    <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit nasa-fullwidth" name="<?php echo esc_attr($nasa_keyReg); ?>" value="<?php esc_attr_e('SETUP YOUR ACCOUNT', 'elessi-theme'); ?>"><?php esc_html_e('SETUP YOUR ACCOUNT', 'elessi-theme'); ?></button>
                </p>

                <?php do_action('woocommerce_register_form_end'); ?>
                
            </form>
            
            <p class="nasa-switch-form">
                <?php esc_html_e('Already got an account? ', 'elessi-theme'); ?>
                <a class="nasa-switch-login" href="javascript:void(0);" rel="nofollow">
                    <?php esc_html_e('Sign in here', 'elessi-theme'); ?>
                </a>
            </p>
            
        </div>
    <?php endif; ?>
</div>
