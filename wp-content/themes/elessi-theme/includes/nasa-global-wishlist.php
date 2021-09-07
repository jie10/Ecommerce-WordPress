<?php
/**
 * Global wishlist button template
 */

if (!NASA_WISHLIST_NEW_VER) :
    $label_option = get_option('yith_wcwl_add_to_wishlist_text');
    $localize_label = function_exists('icl_translate') ? icl_translate('Plugins', 'plugin_yit_wishlist_button', $label_option) : $label_option;

    $label = apply_filters('yith_wcwl_button_label', $localize_label);
    $icon = get_option('yith_wcwl_add_to_wishlist_icon') != 'none' ? '<i class="fa ' . get_option('yith_wcwl_add_to_wishlist_icon') . '"></i>' : '';

    $link_classes = get_option('yith_wcwl_use_button') == 'yes' ? 'add_to_wishlist single_add_to_wishlist button alt' : 'add_to_wishlist';

    $product_added_text = get_option('yith_wcwl_product_added_text');
    $already_in_wishslist_text = get_option('yith_wcwl_already_in_wishlist_text');
    $browse_wishlist_text = get_option('yith_wcwl_browse_wishlist_text');
    ?>
    
    <script type="text/template" id="tmpl-nasa-global-wishlist">
        <div class="yith-wcwl-add-to-wishlist add-to-wishlist-%%product_id%%">
            <div class="yith-wcwl-add-button">
                <a href="<?php echo esc_url(add_query_arg('add_to_wishlist', '%%product_id%%')); ?>" rel="nofollow" data-product-id="%%product_id%%" data-product-type="%%product_type%%" class="<?php echo $link_classes; ?>">
                    <?php echo $icon; ?>
                    <?php echo $label; ?>
                </a>
                <img src="<?php echo esc_url(YITH_WCWL_URL . 'assets/images/wpspin_light.gif'); ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />
            </div>

            <div class="yith-wcwl-wishlistaddedbrowse">
                <span class="feedback">
                    <?php echo $product_added_text; ?>
                </span>
                <a href="#" rel="nofollow">
                    <?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text); ?>
                </a>
            </div>

            <div class="yith-wcwl-wishlistexistsbrowse">
                <span class="feedback"><?php echo $already_in_wishslist_text; ?></span>
                <a href="#" rel="nofollow">
                    <?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text); ?>
                </a>
            </div>

            <div style="clear:both"></div>
            <div class="yith-wcwl-wishlistaddresponse"></div>
        </div>
    </script>
<?php
else :
    /**
     * Version 3.0 or higher
     */
    $label_option = get_option('yith_wcwl_add_to_wishlist_text');
    $icon_option = get_option('yith_wcwl_add_to_wishlist_icon');
    // button label
    $label = apply_filters('yith_wcwl_button_label', $label_option);
    // button icon
    $icon = apply_filters('yith_wcwl_button_icon', $icon_option != 'none' ? $icon_option : '');
    
    $use_custom_button = get_option('yith_wcwl_add_to_wishlist_style');
    $link_classes = apply_filters('yith_wcwl_add_to_wishlist_button_classes', in_array($use_custom_button, array('button_custom', 'button_default')) ? 'add_to_wishlist single_add_to_wishlist button alt' : 'add_to_wishlist single_add_to_wishlist');
    ?>
    <script type="text/template" id="tmpl-nasa-global-wishlist">
        <div class="yith-wcwl-add-button">
            <a href="<?php echo esc_url(add_query_arg('add_to_wishlist', '%%product_id%%')); ?>" rel="nofollow" data-product-id="%%product_id%%" data-product-type="%%product_type%%" data-original-product-id="%%original_product_id%%" class="<?php echo $link_classes; ?>" data-title="<?php echo esc_attr(apply_filters('yith_wcwl_add_to_wishlist_title', $label)); ?>">
                <?php echo $icon; ?>
                <span><?php echo $label ?></span>
            </a>
        </div>
    </script>
<?php
endif;

echo '<div id="yith-wcwl-popup-message" style="display: none;"><div id="yith-wcwl-message"></div></div>';
