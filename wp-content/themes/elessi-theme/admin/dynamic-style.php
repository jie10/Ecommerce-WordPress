<?php
defined('ABSPATH') or die(); // Exit if accessed directly

function elessi_get_content_custom_css($nasa_opt = array()) {
    ob_start();
    ?><style><?php
    echo '@charset "UTF-8";' . "\n";
    
    /**
     * Start font style
     */
    $type_font_select = isset($nasa_opt['type_font_select']) ? $nasa_opt['type_font_select'] : '';
    $custom_font = isset($nasa_opt['custom_font']) ? $nasa_opt['custom_font'] : '';
    
    $type_headings = isset($nasa_opt['type_headings']) ? $nasa_opt['type_headings'] : '';
    $type_texts = isset($nasa_opt['type_texts']) ? $nasa_opt['type_texts'] : '';
    $type_nav = isset($nasa_opt['type_nav']) ? $nasa_opt['type_nav'] : '';
    $type_banner = isset($nasa_opt['type_banner']) ? $nasa_opt['type_banner'] : '';
    $type_price = isset($nasa_opt['type_price']) ? $nasa_opt['type_price'] : '';
    
    echo elessi_get_font_style(
        $type_font_select,
        $type_headings,
        $type_texts,
        $type_nav,
        $type_banner,
        $type_price,
        $custom_font
    );
    
    $type_headings_rtl = isset($nasa_opt['type_headings_rtl']) ? $nasa_opt['type_headings_rtl'] : '';
    $type_texts_rtl = isset($nasa_opt['type_texts_rtl']) ? $nasa_opt['type_texts_rtl'] : '';
    $type_nav_rtl = isset($nasa_opt['type_nav_rtl']) ? $nasa_opt['type_nav_rtl'] : '';
    $type_banner_rtl = isset($nasa_opt['type_banner_rtl']) ? $nasa_opt['type_banner_rtl'] : '';
    $type_price_rtl = isset($nasa_opt['type_price_rtl']) ? $nasa_opt['type_price_rtl'] : '';
    
    echo elessi_get_font_style_rtl(
        $type_font_select,
        $type_headings_rtl,
        $type_texts_rtl,
        $type_nav_rtl,
        $type_banner_rtl,
        $type_price_rtl,
        $custom_font
    );
    
    // End font style
    
    if (isset($nasa_opt['logo_height']) && (int) $nasa_opt['logo_height']) :
        ?>
            body .logo .header_logo
            {
                height: <?php echo (int) $nasa_opt['logo_height'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['logo_width']) && (int) $nasa_opt['logo_width']) :
        ?>
            body .logo .header_logo
            {
                width: <?php echo (int) $nasa_opt['logo_width'] . 'px'; ?>;
            }
        <?php
    else :
        ?>
            body .logo .header_logo
            {
                width: auto;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['logo_height_mobile']) && (int) $nasa_opt['logo_height_mobile']) :
        ?>
            body .mobile-menu .logo .header_logo,
            body .fixed-already .mobile-menu .logo .header_logo,
            body .nasa-login-register-warper #nasa-login-register-form .nasa-form-logo-log .header_logo,
            body .nasa-header-mobile-layout .logo .header_logo
            {
                height: <?php echo (int) $nasa_opt['logo_height_mobile'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['logo_width_mobile']) && (int) $nasa_opt['logo_width_mobile']) :
        ?>
            body .mobile-menu .logo .header_logo,
            body .fixed-already .mobile-menu .logo .header_logo,
            body .nasa-login-register-warper #nasa-login-register-form .nasa-form-logo-log .header_logo,
            body .nasa-header-mobile-layout .logo .header_logo
            {
                width: <?php echo (int) $nasa_opt['logo_width_mobile'] . 'px'; ?>;
            }
        <?php
    else :
        ?>
            body .mobile-menu .logo .header_logo,
            body .fixed-already .mobile-menu .logo .header_logo,
            body .nasa-login-register-warper #nasa-login-register-form .nasa-form-logo-log .header_logo,
            body .nasa-header-mobile-layout .logo .header_logo
            {
                width: auto;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['logo_sticky_height']) && (int) $nasa_opt['logo_sticky_height']) :
        ?>
            body .fixed-already .logo .header_logo
            {
                height: <?php echo (int) $nasa_opt['logo_sticky_height'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['logo_sticky_width']) && (int) $nasa_opt['logo_sticky_width']) :
        ?>
            body .fixed-already .logo .header_logo
            {
                width: <?php echo (int) $nasa_opt['logo_sticky_width'] . 'px'; ?>;
            }
        <?php
        
    else :
        ?>
            body .fixed-already .logo .header_logo
            {
                width: auto;
            }
        <?php
    endif;

    if (isset($nasa_opt['max_height_logo']) && (int) $nasa_opt['max_height_logo']) :
        ?>
            body .logo .header_logo
            {
                max-height: <?php echo (int) $nasa_opt['max_height_logo'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['max_height_mobile_logo']) && (int) $nasa_opt['max_height_mobile_logo']) :
        ?>
            body .mobile-menu .logo .header_logo,
            body .fixed-already .mobile-menu .logo .header_logo,
            body .nasa-login-register-warper #nasa-login-register-form .nasa-form-logo-log .header_logo,
            body .nasa-header-mobile-layout .logo .header_logo
            {
                max-height: <?php echo (int) $nasa_opt['max_height_mobile_logo'] . 'px'; ?>;
            }
        <?php
    endif;
    
    if (isset($nasa_opt['max_height_sticky_logo']) && (int) $nasa_opt['max_height_sticky_logo']) :
        ?>
            body .fixed-already .logo .header_logo
            {
                max-height: <?php echo (int) $nasa_opt['max_height_sticky_logo'] . 'px'; ?>;
            }
        <?php
    endif;

    if (isset($nasa_opt['site_layout']) && $nasa_opt['site_layout'] == 'boxed') :
        $nasa_opt['site_bg_image'] = isset($nasa_opt['site_bg_image']) && $nasa_opt['site_bg_image'] ? str_replace(
            array(
                '[site_url]',
                '[site_url_secure]',
            ), array(
                site_url('', 'http'),
                site_url('', 'https'),
            ), $nasa_opt['site_bg_image']
        ) : false;
        ?> 
            body.boxed,
            body
            {
            <?php if ($nasa_opt['site_bg_color']) : ?>
                background-color: <?php echo esc_attr($nasa_opt['site_bg_color']); ?>;
            <?php endif; ?>
            <?php if ($nasa_opt['site_bg_image']) : ?>
                background-image: url("<?php echo esc_url($nasa_opt['site_bg_image']); ?>");
                background-attachment: fixed;
            <?php endif; ?>
            }
        <?php
    endif;

    /* COLOR PRIMARY */
    if (isset($nasa_opt['color_primary'])) :
        echo elessi_get_style_primary_color($nasa_opt['color_primary']);
    endif;

    /* COLOR SUCCESS */
    if (isset($nasa_opt['color_success']) && $nasa_opt['color_success'] != '') :
        ?> 
            .woocommerce-message {
                color: #FFF !important;
                background-color: <?php echo esc_attr($nasa_opt['color_success']); ?> !important;
            }
            body .woocommerce-message,
            body .nasa-compare-list-bottom .nasa-compare-mess
            {
                border-color: <?php echo esc_attr($nasa_opt['color_success']); ?>;
            }
            body .added i.nasa-df-plus:before,
            body .added i.nasa-df-plus:after
            {
                border-color: <?php echo esc_attr($nasa_opt['color_success']) ?> !important;
            }
            .added .nasa-icon,
            .nasa-added .nasa-icon
            {
                color: <?php echo esc_attr($nasa_opt['color_success']); ?> !important;
            }
            body #nasa-content-ask-a-quetion div.wpcf7-response-output.wpcf7-mail-sent-ok
            {
                color: <?php echo esc_attr($nasa_opt['color_success']); ?>;
            }
            body #yith-wcwl-popup-message #yith-wcwl-message
            {
                background-color: <?php echo esc_attr($nasa_opt['color_success']); ?>;
            }
        <?php
    endif;

    /* COLOR SALE */
    if (isset($nasa_opt['color_sale_label']) && $nasa_opt['color_sale_label'] != '') :
        ?>
            body .badge.sale-label
            {
                background: <?php echo esc_attr($nasa_opt['color_sale_label']); ?>;
            }
        <?php
    endif;

    /* COLOR HOT */
    if (isset($nasa_opt['color_hot_label']) && $nasa_opt['color_hot_label'] != '') :
        ?>
            body .badge.hot-label
            {
                background: <?php echo esc_attr($nasa_opt['color_hot_label']); ?>;
            }
        <?php
    endif;
    
    /* COLOR Featured */
    if (isset($nasa_opt['color_featured_label']) && $nasa_opt['color_featured_label'] != '') :
        ?>
            body .badge.featured-label
            {
                background: <?php echo esc_attr($nasa_opt['color_featured_label']); ?>;
            }
        <?php
    endif;
    
    /* COLOR VIDEO */
    if (isset($nasa_opt['color_video_label']) && $nasa_opt['color_video_label'] != '') :
        ?>
            body .badge.video-label
            {
                background: <?php echo esc_attr($nasa_opt['color_video_label']); ?>;
            }
        <?php
    endif;
    
    /* COLOR 360 */
    if (isset($nasa_opt['color_360_label']) && $nasa_opt['color_360_label'] != '') :
        ?>
            body .badge.b360-label
            {
                background: <?php echo esc_attr($nasa_opt['color_360_label']); ?>;
            }
        <?php
    endif;
    
    /* COLOR DEAL */
    if (isset($nasa_opt['color_deal_label']) && $nasa_opt['color_deal_label'] != '') :
        ?>
        body .badge.deal-label
        {
            background: <?php echo esc_attr($nasa_opt['color_deal_label']); ?>;
        }
        <?php
    endif;
    
    /* COLOR SALE */
    if (isset($nasa_opt['color_variants_label']) && $nasa_opt['color_variants_label'] != '') :
        ?>
            body .badge.nasa-variants
            {
                background: <?php echo esc_attr($nasa_opt['color_variants_label']); ?>;
            }
        <?php
    endif;

    /* COLOR PRICE */
    if (isset($nasa_opt['color_price_label']) && $nasa_opt['color_price_label'] != '') :
        ?>
        body .product-price, 
        body .price.nasa-sc-p-price,
        body .price,
        body .product-item .info .price,
        body .countdown .countdown-row .countdown-amount,
        body .columns.nasa-column-custom-4 .nasa-sc-p-deal-countdown .countdown-row.countdown-show4 .countdown-section .countdown-amount,
        body .item-product-widget .product-meta .price,
        html body .nasa-after-add-to-cart-subtotal-price,
        html body .nasa-total-condition-desc .woocommerce-Price-amount,
        html body .woocommerce-table--order-details tfoot tr:last-child td > .amount
        {
            color: <?php echo esc_attr($nasa_opt['color_price_label']); ?>;
        }
        .amount,
        .nasa-total-condition-desc .woocommerce-Price-amount
        {
            color: <?php echo esc_attr($nasa_opt['color_price_label']); ?> !important;
        }
        <?php
    endif;

    /* COLOR BUTTON */
    if (isset($nasa_opt['color_button']) && $nasa_opt['color_button'] != '') :
        ?> 
            form.cart .button,
            .checkout-button,
            input#place_order,
            .btn-viewcart,
            input#submit,
            .add_to_cart,
            button,
            .button,
            body input[type="submit"].dokan-btn,
            body a.dokan-btn,
            body .dokan-btn,
            body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            input[type="submit"].dokan-btn-theme,
            a.dokan-btn-theme,
            .dokan-btn-theme
            {
                background-color: <?php echo esc_attr($nasa_opt['color_button']); ?> !important;
            }
        <?php
    endif;

    /* COLOR HOVER */
    if (isset($nasa_opt['color_hover']) && $nasa_opt['color_hover'] != '') :
        ?>
            form.cart .button:hover,
            .form-submit input:hover,
            #payment .place-order input:hover,
            input#submit:hover,
            .product-list .product-img .quick-view.fa-search:hover,
            .footer-type-2 input.button,
            button:hover,
            .button:hover,
            .checkout-button:hover,
            input#place_order:hover,
            .btn-viewcart:hover,
            input#submit:hover,
            .add_to_cart:hover
            {
                background-color: <?php echo esc_attr($nasa_opt['color_hover']); ?>!important;
            }
        <?php
    endif;

    /* COLOR BORDER BUTTON ============================================================== */
    if (isset($nasa_opt['button_border_color']) && $nasa_opt['button_border_color'] != '') :
        ?>
            #submit, 
            button, 
            .button, 
            input[type="submit"],
            .widget.woocommerce li.nasa-li-filter-size a,
            .widget.widget_categories li.nasa-li-filter-size a,
            .widget.widget_archive li.nasa-li-filter-size a
            {
                border-color: <?php echo esc_attr($nasa_opt['button_border_color']); ?> !important;
            }
            body .group-btn-in-list .add-to-cart-grid .add_to_cart_text,
            html body input[type="submit"].dokan-btn,
            html body a.dokan-btn,
            html body .dokan-btn,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme,
            body a.dokan-btn-theme,
            body .dokan-btn-theme
            {
                border-color: <?php echo esc_attr($nasa_opt['button_border_color']); ?>;
            }
        <?php
    endif;

    /* COLOR BORDER BUTTON HOVER */
    if (isset($nasa_opt['button_border_color_hover']) && $nasa_opt['button_border_color_hover'] != '') :
        ?>
            #submit:hover, 
            button:hover, 
            .button:hover, 
            input[type="submit"]:hover,
            .widget.woocommerce li.nasa-li-filter-size.chosen a,
            .widget.woocommerce li.nasa-li-filter-size.nasa-chosen a,
            .widget.woocommerce li.nasa-li-filter-size:hover a,
            .widget.widget_categories li.nasa-li-filter-size.chosen a,
            .widget.widget_categories li.nasa-li-filter-size.nasa-chosen a,
            .widget.widget_categories li.nasa-li-filter-size:hover a,
            .widget.widget_archive li.nasa-li-filter-size.chosen a,
            .widget.widget_archive li.nasa-li-filter-size.nasa-chosen a,
            .widget.widget_archive li.nasa-li-filter-size:hover a
            {
                border-color: <?php echo esc_attr($nasa_opt['button_border_color_hover']); ?> !important;
            }
            body .group-btn-in-list add-to-cart-grid:hover .add_to_cart_text,
            html body input[type="submit"].dokan-btn:hover,
            html body a.dokan-btn:hover,
            html body .dokan-btn:hover,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme:hover,
            body a.dokan-btn-theme:hover,
            body .dokan-btn-theme:hover
            {
                border-color: <?php echo esc_attr($nasa_opt['button_border_color_hover']); ?>;
            }
        <?php
    endif;

    /* COLOR TEXT BUTTON */
    if (isset($nasa_opt['button_text_color']) && $nasa_opt['button_text_color'] != '') :
        ?>
            #submit, 
            button, 
            .button, 
            input[type="submit"],
            body input[type="submit"].dokan-btn,
            body a.dokan-btn,
            body .dokan-btn,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme,
            body a.dokan-btn-theme,
            body .dokan-btn-theme
            {
                color: <?php echo esc_attr($nasa_opt['button_text_color']); ?> !important;
            }
        <?php
    endif;

    /* COLOR HOVER TEXT BUTTON */
    if (isset($nasa_opt['button_text_color_hover']) && $nasa_opt['button_text_color_hover'] != '') :
        ?>
            #submit:hover, 
            button:hover, 
            .button:hover, 
            input[type="submit"]:hover
            {
                color: <?php echo esc_attr($nasa_opt['button_text_color_hover']); ?> !important;
            }
            html body input[type="submit"].dokan-btn:hover,
            html body a.dokan-btn:hover,
            html body .dokan-btn:hover,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn:hover,
            body input[type="submit"].dokan-btn-theme:hover,
            body a.dokan-btn-theme:hover,
            body .dokan-btn-theme:hover
            {
                color: <?php echo esc_attr($nasa_opt['button_text_color_hover']); ?>;
            }
        <?php
    endif;

    if (isset($nasa_opt['button_radius'])) :
        ?>
            body .product-item .product-deal-special-buttons .nasa-product-grid .add-to-cart-grid,
            body .wishlist_table .add_to_cart,
            body .yith-wcwl-add-button > a.button.alt,
            body #submit,
            body #submit.disabled,
            body #submit[disabled],
            body button,
            body button.disabled,
            body button[disabled],
            body .button,
            body .button.disabled,
            body .button[disabled],
            body input[type="submit"],
            body input[type="submit"].disabled,
            body input[type="submit"][disabled],
            html body input[type="submit"].dokan-btn,
            html body a.dokan-btn,
            html body .dokan-btn,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme,
            body a.dokan-btn-theme,
            body .dokan-btn-theme
            {
                border-radius: <?php echo (int) $nasa_opt['button_radius']; ?>px;
                -webkit-border-radius: <?php echo (int) $nasa_opt['button_radius']; ?>px;
                -o-border-radius: <?php echo (int) $nasa_opt['button_radius']; ?>px;
                -moz-border-radius: <?php echo (int) $nasa_opt['button_radius']; ?>px;
            }
        <?php
    endif;

    if (isset($nasa_opt['button_border']) && (int) $nasa_opt['button_border']) :
        ?>
            body #submit, 
            body button, 
            body .button,
            body input[type="submit"],
            html body input[type="submit"].dokan-btn,
            html body a.dokan-btn,
            html body .dokan-btn,
            html body #dokan-store-listing-filter-form-wrap .apply-filter #apply-filter-btn,
            body input[type="submit"].dokan-btn-theme,
            body a.dokan-btn-theme,
            body .dokan-btn-theme
            {
                border-width: <?php echo (int) $nasa_opt['button_border']; ?>px;
            }
        <?php
    endif;

    if (isset($nasa_opt['input_radius'])) :
        ?>
            body textarea,
            body select,
            body input[type="text"],
            body input[type="password"],
            body input[type="date"], 
            body input[type="datetime"],
            body input[type="datetime-local"],
            body input[type="month"],
            body input[type="week"],
            body input[type="email"],
            body input[type="number"],
            body input[type="search"],
            body input[type="tel"],
            body input[type="time"],
            body input[type="url"],
            body .category-page .sort-bar .select-wrapper
            {
                border-radius: <?php echo (int) $nasa_opt['input_radius']; ?>px;
                -webkit-border-radius: <?php echo (int) $nasa_opt['input_radius']; ?>px;
                -o-border-radius: <?php echo (int) $nasa_opt['input_radius']; ?>px;
                -moz-border-radius: <?php echo (int) $nasa_opt['input_radius']; ?>px;
            }
        <?php
    endif;
    
    /* BG COLOR BUTTON BUY NOW */
    if (isset($nasa_opt['buy_now_bg_color']) && $nasa_opt['buy_now_bg_color'] != '') :
        ?>
            body .nasa-buy-now
            {
                background-color: <?php echo esc_attr($nasa_opt['buy_now_bg_color']); ?> !important;
                border-color: <?php echo esc_attr($nasa_opt['buy_now_bg_color']); ?> !important;
            }
        <?php
    endif;
    
    /* BG COLOR BUTTON HOVER BUY NOW */
    if (isset($nasa_opt['buy_now_bg_color_hover']) && $nasa_opt['buy_now_bg_color_hover'] != '') :
        ?>
            body .nasa-buy-now:hover
            {
                background-color: <?php echo esc_attr($nasa_opt['buy_now_bg_color_hover']); ?> !important;
                border-color: <?php echo esc_attr($nasa_opt['buy_now_bg_color_hover']); ?> !important;
            }
        <?php
    endif;
    
    /**
     * Color of header
     */
    $bg_color = (isset($nasa_opt['bg_color_header']) && $nasa_opt['bg_color_header']) ? $nasa_opt['bg_color_header'] : '';
    $text_color = (isset($nasa_opt['text_color_header']) && $nasa_opt['text_color_header']) ? $nasa_opt['text_color_header'] : '';
    $text_color_hover = (isset($nasa_opt['text_color_hover_header']) && $nasa_opt['text_color_hover_header']) ? $nasa_opt['text_color_hover_header'] : '';

    echo elessi_get_style_header_color($bg_color, $text_color, $text_color_hover);

    /**
     * Color of main menu
     */
    $bg_color = isset($nasa_opt['bg_color_main_menu']) ? $nasa_opt['bg_color_main_menu'] : '';
    $text_color = (isset($nasa_opt['text_color_main_menu']) && $nasa_opt['text_color_main_menu']) ? $nasa_opt['text_color_main_menu'] : '';
    $text_color_hover = (isset($nasa_opt['text_color_hover_main_menu']) && $nasa_opt['text_color_hover_main_menu']) ? $nasa_opt['text_color_hover_main_menu'] : '';

    echo elessi_get_style_main_menu_color($bg_color, $text_color, $text_color_hover);

    /**
     * Color of Top bar
     */
    if (!isset($nasa_opt['topbar_show']) || $nasa_opt['topbar_show']) {
        $bg_color = (isset($nasa_opt['bg_color_topbar']) && $nasa_opt['bg_color_topbar']) ? $nasa_opt['bg_color_topbar'] : '';
        $text_color = (isset($nasa_opt['text_color_topbar']) && $nasa_opt['text_color_topbar']) ? $nasa_opt['text_color_topbar'] : '';
        $text_color_hover = (isset($nasa_opt['text_color_hover_topbar']) && $nasa_opt['text_color_hover_topbar']) ? $nasa_opt['text_color_hover_topbar'] : '';

        echo elessi_get_style_topbar_color($bg_color, $text_color, $text_color_hover);
    }

    /**
     * Add width to site
     */
    if (isset($nasa_opt['plus_wide_width']) && (int) $nasa_opt['plus_wide_width'] > 0) :
        global $content_width;
        $content_width = !isset($content_width) ? 1200 : $content_width;
        $max_width = ($content_width + (int) $nasa_opt['plus_wide_width']);
        
        echo elessi_get_style_plus_wide_width($max_width);
    endif;
    
    /**
     * Promo Popup
     */
    if (isset($nasa_opt['promo_popup']) && $nasa_opt['promo_popup']) :
        if (!isset($nasa_opt['pp_background_image'])) :
            $nasa_opt['pp_background_image'] = ELESSI_THEME_URI . '/assets/images/newsletter_bg.jpg';
        endif;
        
        $nasa_opt['pp_background_image'] = $nasa_opt['pp_background_image'] ? str_replace(
            array(
                '[site_url]',
                '[site_url_secure]',
            ), array(
                site_url('', 'http'),
                site_url('', 'https'),
            ), $nasa_opt['pp_background_image']
        ) : false;
        ?>
            #nasa-popup
            {
                width: <?php echo isset($nasa_opt['pp_width']) ? (int) $nasa_opt['pp_width'] : 724; ?>px;
                background-color: <?php echo isset($nasa_opt['pp_background_color']) ? esc_url($nasa_opt['pp_background_color']) : 'transparent' ?>;
                <?php if ($nasa_opt['pp_background_image']) : ?>
                    background-image: url('<?php echo esc_url($nasa_opt['pp_background_image']); ?>');
                <?php endif; ?>
                background-repeat: no-repeat;
                background-size: auto;
            }
            #nasa-popup,
            #nasa-popup .nasa-popup-wrap
            {
                height: <?php echo isset($nasa_opt['pp_height']) ? (int) $nasa_opt['pp_height'] : 501; ?>px;
            }
            .nasa-pp-left
            {
                min-height: 1px;
            }
        <?php
    endif;
    
    ?></style><?php
    $css = ob_get_clean();
    
    return elessi_convert_css($css);
}
