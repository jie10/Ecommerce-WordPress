<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

$nasa_gdpr_policies = isset($nasa_opt['nasa_gdpr_policies']) && $nasa_opt['nasa_gdpr_policies'] ? $nasa_opt['nasa_gdpr_policies'] : false;
?>

<div class="nasa-cookie-notice-container">
    <div class="nasa-cookie-notice-centent">
        <span class="nasa-notice-text">
            <?php echo esc_html__('We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.', 'elessi-theme'); ?>
        </span>

        <?php if ($nasa_gdpr_policies) : ?>
            <a href="<?php echo esc_url($nasa_gdpr_policies); ?>" target="_blank" class="nasa-policies-cookie" title="<?php echo esc_attr__('Privacy Policy', 'elessi-theme'); ?>"><?php echo esc_html__('Privacy Policy', 'elessi-theme'); ?></a>
        <?php endif; ?>

        <a href="javascript:void(0);" class="nasa-accept-cookie" title="<?php echo esc_attr__('Accept', 'elessi-theme'); ?>" class="button" rel="nofollow"><?php echo esc_html__('Accept', 'elessi-theme'); ?></a>
    </div>
</div>