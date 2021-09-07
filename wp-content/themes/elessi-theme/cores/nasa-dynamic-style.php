<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * CSS override PRIMARY color
 */
if (!function_exists('elessi_get_style_primary_color')) :

    function elessi_get_style_primary_color($color_primary = '', $return = true) {
        if (trim($color_primary) == '') {
            return '';
        }
        
        $color_primary_darken = elessi_pattern_color($color_primary, -0.08);
        
        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override primary color */
            body .primary-color,
            body a:hover,
            body a:focus,
            body p a:hover,
            body p a:focus,
            body .add-to-cart-grid .cart-icon strong,
            body .navigation-paging a,
            body .navigation-image a,
            body .logo a,
            body li.mini-cart .cart-icon strong,
            body .mini-cart-item .cart_list_product_price,
            body .remove:hover i,
            body .support-icon,
            body .shop_table.cart td.product-name a:hover,
            body #order_review .cart-subtotal .woocommerce-Price-amount,
            body #order_review .order-total .woocommerce-Price-amount,
            body #order_review .woocommerce-shipping-totals .woocommerce-Price-amount,
            body .cart_totals .order-total td,
            body a.shipping-calculator-button:hover,
            body .widget_layered_nav li a:hover,
            body .widget_layered_nav_filters li a:hover,
            body .copyright-footer span,
            body #menu-shop-by-category li.active.menu-parent-item .nav-top-link::after,
            body .bread.nasa-breadcrumb-has-bg .row .breadcrumb-row a:hover,
            body .bread.nasa-breadcrumb-has-bg .columns .breadcrumb-row a:hover,
            body .group-blogs .blog_info .post-date span,
            body .header-type-1 .header-nav .nav-top-link:hover,
            body .widget_layered_nav li:hover a,
            body .widget_layered_nav_filters li:hover a,
            body .remove .pe-7s-close:hover,
            body .absolute-footer .left .copyright-footer span,
            body .service-block .box .title .icon,
            body .service-block.style-3 .box .service-icon,
            body .service-block.style-2 .service-icon,
            body .service-block.style-1 .service-icon,
            body .contact-information .contact-text strong,
            body .nav-wrapper .root-item a:hover,
            body .group-blogs .blog_info .read_more a:hover,
            body #top-bar .top-bar-nav li.color a,
            body .mini-cart .cart-icon:hover:before,
            body .absolute-footer li a:hover,
            body .nasa-recent-posts li .post-date,
            body .nasa-recent-posts .read-more a,
            body .shop_table .remove-product .pe-7s-close:hover,
            body .absolute-footer ul.menu li a:hover,
            body .nasa-pagination.style-1 .page-number li span.current,
            body .nasa-pagination.style-1 .page-number li a.current,
            body .nasa-pagination.style-1 .page-number li a.nasa-current,
            body .nasa-pagination.style-1 .page-number li a:hover,
            body #vertical-menu-wrapper li.root-item:hover > a,
            body .widget.woocommerce li.cat-item a.nasa-active,
            body .widget.widget_recent_entries ul li a:hover,
            body .widget.widget_recent_comments ul li a:hover,
            body .widget.widget_meta ul li a:hover,
            body .widget.widget_categories li a.nasa-active,
            body .widget.widget_archive li a.nasa-active,
            body .nasa-filter-by-cat.nasa-active,
            body .product-info .stock.in-stock,
            body #nasa-footer .nasa-contact-footer-custom h5,
            body #nasa-footer .nasa-contact-footer-custom h5 i,
            body .group-blogs .nasa-blog-info-slider .nasa-post-date,
            body li.menu-item.nasa-megamenu > .nav-dropdown > ul > li.menu-item a:hover,
            body .nasa-tag-cloud a.nasa-active:hover,
            body .html-text i,
            body .header-nav .active .nav-top-link,
            body ul li .nav-dropdown > ul > li:hover > a,
            body ul li .nav-dropdown > ul > li:hover > a:before,
            body ul li .nav-dropdown > ul > li .nav-column-links > ul > li a:hover,
            body ul li .nav-dropdown > ul > li .nav-column-links > ul > li:hover > a:before,
            body .topbar-menu-container > ul > li > a:hover,
            body .header-account ul li a:hover,
            body .header-icons > li a:hover i,
            body .nasa-title span.nasa-first-word,
            body .nasa-sc-pdeal.nasa-sc-pdeal-block .nasa-sc-p-img .images-popups-gallery a.product-image .nasa-product-label-stock .label-stock,
            body .nasa-sc-pdeal.nasa-sc-pdeal-block .nasa-sc-p-info .nasa-sc-p-title h3 a:hover,
            body #nasa-footer .nasa-footer-contact .wpcf7-form label span.your-email:after,
            body .nasa-nav-sc-menu .menu-item a:hover,
            body .nasa-static-sidebar .nasa-wishlist-title:hover,
            body .nasa-static-sidebar .button-in-wishlist:hover,
            body .nasa-static-sidebar .mini-cart-info a:hover,
            body .nasa-login-register-warper #nasa-login-register-form .nasa-switch-form a,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a > i,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a > i,
            body .current-menu-item > a.nasa-title-menu,
            body .product-item .info .name:hover,
            body .nasa-item-meta .nasa-widget-title:hover,
            body.nasa-dark .product-item .info .name:hover,
            body.nasa-dark .nasa-item-meta .nasa-widget-title:hover,
            body .nasa-compare-list-bottom .nasa-compare-mess,
            body .nasa-labels-filter-top .nasa-labels-filter-accordion .nasa-top-row-filter > li.nasa-active a,
            body .nasa-wrap-slick-slide-products-title .nasa-slide-products-title-item.slick-current > a,
            body .nasa-accordions-content .nasa-accordion-title a.active,
            body .widget.widget_product_categories li a:hover,
            body .widget.woocommerce.widget_product_categories li a:hover,
            body .widget.widget_product_categories li.current-tax-item > a,
            body .widget.woocommerce.widget_product_categories li.current-tax-item > a,
            body .widget.widget_product_categories li.current-tax-item .children a:hover,
            body .widget.woocommerce.widget_product_categories li.current-tax-item .children a:hover,
            body .widget li a:hover,
            body .nasa-products-special-deal.nasa-products-special-deal-multi-2 .nasa-list-stock-status span,
            body .nasa-after-add-to-cart-subtotal-price,
            body .nasa-total-condition-desc .woocommerce-Price-amount,
            body .woocommerce-table--order-details tfoot tr:last-child td > .amount,
            body .woocommerce-MyAccount-navigation.nasa-MyAccount-navigation .woocommerce-MyAccount-navigation-link a:hover:before,
            body .topbar-menu-container ul ul li a:hover,
            body .shop_table tbody .product-subtotal,
            body .grid-product-category .nasa-item-wrap:hover .nasa-view-more i,
            body .nasa-slide-style li.active a,
            body #dokan-store-listing-filter-wrap .right .toggle-view .active,
            body .nasa-product-content-nasa_label-wrap .nasa-product-content-child > a:focus,
            body .nasa-product-content-nasa_label-wrap .nasa-product-content-child > a:visited,
            body .nasa-product-content-nasa_label-wrap .nasa-product-content-child > a:hover,
            body .nasa-product-content-nasa_label-wrap .nasa-product-content-child > a.nasa-active,
            body .nasa-color-small-square .nasa-attr-ux-color.selected,
            body .nasa-color-small-square .nasa-attr-ux-color:hover,
            body .nasa-label-small-square-1 .nasa-attr-ux-label.selected,
            body .nasa-label-small-square-1 .nasa-attr-ux-label:hover,
            body .nasa-labels-filter-top .nasa-top-row-filter li a.nasa-active:before,
            body .nasa-products-special-deal .product-deal-special-title:hover,
            body .nasa-tab-push-cats.nasa-push-cat-show
            {
                color: <?php echo esc_attr($color_primary); ?>;
            }
            .blog_shortcode_item .blog_shortcode_text h3 a:hover,
            .widget-area ul li a:hover,
            h1.entry-title a:hover,
            .progress-bar .bar-meter .bar-number,
            .product-item .info .name a:hover,
            .wishlist_table td.product-name a:hover,
            .product-list .info .name:hover,
            .product-info .compare:hover,
            .product-info .compare:hover:before,
            .product-info .yith-wcwl-add-to-wishlist:hover:before,
            .product-info .yith-wcwl-add-to-wishlist:hover a,
            .product-info .yith-wcwl-add-to-wishlist:hover .feedback,
            .menu-item.nasa-megamenu > .nav-dropdown > ul > li.menu-item a:hover:before,
            rev-btn.elessi-Button
            {
                color: <?php echo esc_attr($color_primary); ?> !important;
            }
            /* BACKGROUND */
            body .nasa_hotspot,
            body .label-new.menu-item a:after,
            body .text-box-primary,
            body .navigation-paging a:hover,
            body .navigation-image a:hover,
            body .next-prev-nav .prod-dropdown > a:hover,
            body .widget_product_tag_cloud a:hover,
            body .nasa-tag-cloud a.nasa-active,
            body .product-img .product-bg,
            body #submit:hover,
            body button:hover,
            body .button:hover,
            body input[type="submit"]:hover,
            body .post-item:hover .post-date,
            body .blog_shortcode_item:hover .post-date,
            body .group-slider .sliderNav a:hover,
            body .support-icon.square-round:hover,
            body .entry-header .post-date-wrapper,
            body .entry-header .post-date-wrapper:hover,
            body .comment-inner .reply a:hover,
            body .header-nav .nav-top-link::before,
            body .sliderNav a span:hover,
            body .shop-by-category h3.section-title,
            body .custom-footer-1 .nasa-hr,
            body .products.list .yith-wcwl-add-button:hover,
            body .shop-by-category .widget-title,
            body .rev_slider_wrapper .type-label-2,
            body .nasa-hr.primary-color,
            body .pagination-centered .page-numbers a:hover,
            body .pagination-centered .page-numbers span.current,
            body .nasa-mini-number,
            body .load-more::before,
            body .products-arrow .next-prev-buttons .icon-next-prev:hover,
            body .widget_price_filter .ui-slider .ui-slider-handle:after,
            body .nasa-classic-style.nasa-classic-2d.nasa-tab-primary-color li.active a,
            body .nasa-classic-style.nasa-classic-2d.nasa-tab-primary-color li:hover a,
            body .collapses.active .collapses-title a:before,
            body .title-block span:after,
            body .nasa-login-register-warper #nasa-login-register-form a.login-register-close:hover i:before,
            body .products-group.nasa-combo-slider .product-item.grid .nasa-product-bundle-btns .quick-view:hover,
            body .header-type-1 .nasa-header-icons-type-1 .header-icons > li.nasa-icon-mini-cart a .icon-nasa-cart-3,
            body .header-type-1 .nasa-header-icons-type-1 .header-icons > li.nasa-icon-mini-cart a:hover .icon-nasa-cart-3,
            body .header-type-1 .nasa-header-icons-type-1 .header-icons > li.nasa-icon-mini-cart a .icon-nasa-cart-3:hover:before,
            body .search-dropdown.nasa-search-style-3 .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page:before,
            body .nasa-search-space.nasa-search-style-3 .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page:before,
            body #cart-sidebar .btn-mini-cart .button,
            body .nasa-gift-featured-wrap .nasa-gift-featured-event:hover,
            body #nasa-popup .wpcf7 input[type="button"],
            body #nasa-popup .wpcf7 input[type="submit"],
            body .nasa-products-special-deal .product-special-deals .product-deal-special-progress .deal-progress .deal-progress-bar,
            body .nasa-product-grid .add-to-cart-grid,
            body .nasa-product-grid .add_to_cart_text,
            body .nasa-progress-bar-load-shop .nasa-progress-per,
            body #nasa-footer .footer-contact .btn-submit-newsletters,
            body #nasa-footer .footer-light-2 .footer-contact .btn-submit-newsletters,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-marker-icon-bg,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-action-effect,
            body .vertical-menu.nasa-shortcode-menu .section-title,
            body .tp-bullets.custom .tp-bullet.selected,
            body #submit.small.nasa-button-banner,
            body button.small.nasa-button-banner,
            body .button.small.nasa-button-banner,
            body input[type="submit"].small.nasa-button-banner,
            body .nasa-menu-vertical-header,
            body .nasa-single-product-stock .nasa-product-stock-progress .nasa-product-stock-progress-bar,
            body .nasa-quickview-view-detail,
            html body.nasa-in-mobile #top-bar .topbar-mobile-text,
            body .nasa-subtotal-condition,
            body .nasa-pagination.style-2 .page-numbers span.current,
            body .nasa-pagination.style-2 .page-numbers a.current,
            body .nasa-pagination.style-2 .page-numbers a.nasa-current,
            body .nasa-classic-style.nasa-classic-2d.nasa-tabs-no-border.nasa-tabs-radius li.active a,
            body .nasa-meta-categories,
            body .woocommerce-pagination ul li .page-numbers.current,
            body .slick-dots li.slick-active,
            body table.nasa-info-size-guide thead td,
            body a:hover .nasa-comment-count,
            body .nasa-close-sidebar:hover,
            body .nasa-sidebar-close a:hover,
            body .nasa-close-menu-mobile:hover,
            body .nasa-top-cat-filter-wrap-mobile .nasa-close-filter-cat:hover,
            body .nasa-item-img .quick-view:hover,
            body .widget_price_filter .price_slider_wrapper .reset_price:hover:before,
            body .nasa-product-status-widget .nasa-filter-status.nasa-active:before,
            body .nasa-ignore-filter-global:hover:before,
            html body.nasa-dark .nasa-hoz-buttons .nasa-product-grid .btn-wishlist:hover,
            html body.nasa-dark .nasa-hoz-buttons .nasa-product-grid .quick-view:hover,
            html body.nasa-dark .nasa-hoz-buttons .nasa-product-grid .btn-compare:hover,
            html body.nasa-dark .nasa-hoz-buttons .nasa-product-grid .btn-link:hover
            {
                background-color: <?php echo esc_attr($color_primary); ?>;
            }
            body #cart-sidebar .btn-mini-cart .button:hover,
            body .product-info .cart .single_add_to_cart_button:hover,
            body #cart-sidebar.style-1 a.nasa-sidebar-return-shop:hover,
            body #nasa-wishlist-sidebar.style-1 a.nasa-sidebar-return-shop:hover,
            body #nasa-popup .wpcf7 input[type="button"]:hover,
            body #nasa-popup .wpcf7 input[type="submit"]:hover,
            body #nasa-footer .footer-light-2 .footer-contact .btn-submit-newsletters:hover,
            body .nasa-hoz-buttons .nasa-product-grid .add-to-cart-grid:hover,
            body .nasa-hoz-buttons .nasa-product-grid .btn-wishlist:hover,
            body .nasa-hoz-buttons .nasa-product-grid .quick-view:hover,
            body .nasa-hoz-buttons .nasa-product-grid .btn-compare:hover,
            body .nasa-product-content-select-wrap .nasa-product-content-child .nasa-toggle-content-attr-select .nasa-attr-ux-item.nasa-active
            {
                background-color: <?php echo esc_attr($color_primary_darken); ?>;
            }
            body .product-item .nasa-product-grid .add-to-cart-grid:hover .add_to_cart_text
            {
                color: #fff;
            }
            button.primary-color,
            .newsletter-button-wrap .newsletter-button,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-marker-icon-bg:hover,
            body .nasa-hoz-buttons .nasa-product-grid .add-to-cart-grid:hover
            {
                background-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            /* BORDER COLOR */
            body .text-bordered-primary,
            body .navigation-paging a,
            body .navigation-image a,
            body .post.sticky,
            body .next-prev-nav .prod-dropdown > a:hover,
            body .iosSlider .sliderNav a:hover span,
            body .woocommerce-checkout form.login,
            body li.mini-cart .cart-icon strong,
            body .post-date,
            body .remove:hover i,
            body .support-icon.square-round:hover,
            body .widget_price_filter .ui-slider .ui-slider-handle,
            body h3.section-title span,
            body .social-icons .icon.icon_email:hover,
            body .seam_icon .seam,
            body .border_outner,
            body .pagination-centered .page-numbers a:hover,
            body .pagination-centered .page-numbers span.current,
            body .products.list .yith-wcwl-wishlistexistsbrowse a,
            body .products-arrow .next-prev-buttons .icon-next-prev:hover,
            body .search-dropdown .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page,
            body .nasa-search-space .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page,
            body .products-group.nasa-combo-slider .product-item.grid .nasa-product-bundle-btns .quick-view:hover,
            body .nasa-table-compare tr.stock td span,
            body .nasa-classic-style.nasa-classic-2d.nasa-tab-primary-color li.active a,
            body .nasa-classic-style.nasa-classic-2d.nasa-tab-primary-color li:hover a,
            body .nasa-slide-style li.nasa-slide-tab,
            body .nasa-wrap-table-compare .nasa-table-compare tr.stock td span,
            body .vertical-menu-container #vertical-menu-wrapper li.root-item:hover > a:before,
            body .vertical-menu-container .vertical-menu-wrapper li.root-item:hover > a:before,
            body #cart-sidebar .btn-mini-cart .button,
            body .nasa-gift-featured-wrap .nasa-gift-featured-event:hover,
            body .group-btn-in-list .add-to-cart-grid:hover .add_to_cart_text,
            body .nasa-title.hr-type-vertical .nasa-wrap,
            body #nasa-footer .footer-contact .btn-submit-newsletters,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-marker-icon-bg,
            body .easypin-marker > .nasa-marker-icon-wrap .nasa-marker-icon,
            body .vertical-menu.nasa-shortcode-menu .section-title,
            body .nasa-products-special-deal.nasa-products-special-deal-multi-2 .nasa-main-special,
            body .nasa-slider-deal-vertical-extra-switcher.nasa-nav-4-items .slick-slide.slick-current .item-deal-thumb,
            body .nasa-slider-deal-vertical-extra-switcher.nasa-nav-4-items .slick-slide:hover .item-deal-thumb,
            body .nasa-accordions-content .nasa-accordion-title a.active:before,
            body .nasa-accordions-content .nasa-accordion-title a.active:after,
            body .nasa-color-small-square .nasa-attr-ux-color.selected,
            body .nasa-color-small-square .nasa-attr-ux-color:hover,
            body .nasa-label-small-square-1 .nasa-attr-ux-label.selected,
            body .nasa-label-small-square-1 .nasa-attr-ux-label:hover,
            body .nasa-color-big-square .nasa-attr-ux-color.selected,
            body .nasa-label-big-square .nasa-attr-ux-label.selected,
            body .nasa-image-square-caption .nasa-attr-ux-image.selected,
            body .comment-inner .reply a:hover,
            body .nasa-close-sidebar:hover,
            body .nasa-sidebar-close a:hover,
            body .nasa-close-menu-mobile:hover,
            body .nasa-top-cat-filter-wrap-mobile .nasa-close-filter-cat:hover,
            body .nasa-item-img .quick-view:hover,
            body .nasa-anchor.active,
            body .nasa-tab-push-cats.nasa-push-cat-show i,
            body .nasa-hoz-buttons .nasa-product-grid .add-to-cart-grid:hover,
            body .nasa-hoz-buttons .nasa-product-grid .btn-wishlist:hover,
            body .nasa-hoz-buttons .nasa-product-grid .quick-view:hover,
            body .nasa-hoz-buttons .nasa-product-grid .btn-compare:hover,
            body .widget_price_filter .price_slider_wrapper .reset_price:hover:before,
            body .nasa-product-content-select-wrap .nasa-product-content-child .nasa-toggle-content-attr-select .nasa-attr-ux-item.nasa-active,
            body .nasa-product-status-widget .nasa-filter-status:hover:before,
            body .nasa-product-status-widget .nasa-filter-status.nasa-active:before,
            body .nasa-ignore-filter-global:hover:before
            {
                border-color: <?php echo esc_attr($color_primary); ?>;
            }
            body #cart-sidebar.style-1 a.nasa-sidebar-return-shop:hover,
            body #nasa-wishlist-sidebar.style-1 a.nasa-sidebar-return-shop:hover,
            body #cart-sidebar .btn-mini-cart .button:hover,
            body .product-info .cart .single_add_to_cart_button:hover
            {
                border-color: <?php echo esc_attr($color_primary_darken); ?>;
            }
            .promo .sliderNav span:hover,
            .remove .pe-7s-close:hover
            {
                border-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            .collapsing.categories.list li:hover,
            #menu-shop-by-category li.active
            {
                border-left-color: <?php echo esc_attr($color_primary); ?> !important;
            }
            body .nasa-slider-deal-vertical-extra-switcher.nasa-nav-4-items .item-slick.slick-current:before
            {
                border-right-color: <?php echo esc_attr($color_primary); ?>;
            }
            html body.nasa-rtl .nasa-slider-deal-vertical-extra-switcher.nasa-nav-4-items .item-slick.slick-current:after
            {
                border-left-color: <?php echo esc_attr($color_primary); ?>;
            }
            body button,
            body .button,
            body #submit,
            body a.button,
            body p a.button,
            body input#submit,
            body .add_to_cart,
            body .checkout-button,
            body .dokan-btn-theme,
            body a.dokan-btn-theme,
            body input#place_order,
            body form.cart .button,
            body .form-submit input,
            body input[type="submit"],
            body .btn-mini-cart .button,
            body #payment .place-order input,
            body .footer-type-2 input.button,
            body input[type="submit"].dokan-btn-theme,
            body #nasa-footer .btn-submit-newsletters,
            body .nasa-table-compare .add-to-cart-grid,
            body .nasa-static-sidebar .nasa-sidebar-return-shop,
            body .nasa-tab-primary-color .nasa-classic-style li:hover a,
            body .nasa-tab-primary-color .nasa-classic-style li.active a,
            body .product-deal-special-buttons .nasa-product-grid .add-to-cart-grid .add_to_cart_text
            {
                background-color: <?php echo esc_attr($color_primary); ?>;
                border-color: <?php echo esc_attr($color_primary); ?>;
                color: #FFF;
            }
            body button:hover,
            body .button:hover,
            body a.button:hover,
            body * button:hover,
            body * .button:hover,
            body * #submit:hover,
            body p a.button:hover,
            body input#submit:hover,
            body .add_to_cart:hover,
            body input#submit:hover,
            body .checkout-button:hover,
            body .dokan-btn-theme:hover,
            body a.dokan-btn-theme:hover,
            body input#place_order:hover,
            body form.cart .button:hover,
            body .form-submit input:hover,
            body * input[type="submit"]:hover,
            body .btn-mini-cart .button:hover,
            body #payment .place-order input:hover,
            body .footer-type-2 input.button:hover,
            body .nasa-reset-filters-top:hover:before,
            body .nasa-ignore-price-item:hover:before,
            body .nasa-ignore-variation-item:hover:before,
            body input[type="submit"].dokan-btn-theme:hover,
            body .nasa-table-compare .add-to-cart-grid:hover,
            body .nasa-static-sidebar .nasa-sidebar-return-shop:hover,
            body .product-list .product-img .quick-view.fa-search:hover,
            body .product-deal-special-buttons .nasa-product-grid .add-to-cart-grid:hover .add_to_cart_text
            {
                background-color: <?php echo esc_attr($color_primary_darken); ?>;
                border-color: <?php echo esc_attr($color_primary_darken); ?>;
                color: #FFF;
            }
            /* End Primary color =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return elessi_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for main menu
 */
if (!function_exists('elessi_get_style_main_menu_color')) :

    function elessi_get_style_main_menu_color(
        $bg_color = '',
        $text_color = '',
        $text_color_hover = '',
        $return = true
    ) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override main menu color =========================================== */
        <?php if ($bg_color != '') : ?>
                body .nasa-bg-dark,
                body .header-type-4 .nasa-elements-wrap-bg
                {
                    background-color: <?php echo ($bg_color != '') ? esc_attr($bg_color) : 'transparent'; ?>;
                }
                <?php
                $bg_color = strtolower($bg_color);
                if ($bg_color !== '#fff' && $bg_color !== '#ffffff' && $bg_color !== 'white') : ?>
                    body .header-type-4 .nasa-elements-wrap-bg
                    {
                        border-top: none;
                        border-bottom: none;
                    }
                <?php 
                endif;
            endif;

            if ($text_color != '') :
                ?>
                body .nav-wrapper .root-item > a,
                body .nav-wrapper .root-item:hover > a,
                body .nav-wrapper .root-item.current-menu-ancestor > a,
                body .nav-wrapper .root-item.current-menu-item > a,
                body .nav-wrapper .root-item:hover > a:hover,
                body .nav-wrapper .root-item.current-menu-ancestor > a:hover,
                body .nav-wrapper .root-item.current-menu-item > a:hover,
                body .nasa-bg-dark .nav-wrapper .root-item > a,
                body .nasa-bg-dark .nav-wrapper .root-item:hover > a,
                body .nasa-bg-dark .nav-wrapper .root-item.current-menu-ancestor > a,
                body .nasa-bg-dark .nav-wrapper .root-item.current-menu-item > a,
                body .nasa-bg-wrap .nasa-vertical-header h5.section-title
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                body .nav-wrapper .root-item:hover > a:after,
                body .nav-wrapper .root-item.current-menu-ancestor > a:after,
                body .nav-wrapper .root-item.current-menu-item > a:after,
                body .nasa-bg-dark .nav-wrapper .root-item:hover > a:after,
                body .nasa-bg-dark .nav-wrapper .root-item.current-menu-ancestor > a:after,
                body .nasa-bg-dark .nav-wrapper .root-item.current-menu-item > a:after
                {
                    border-color: <?php echo esc_attr($text_color); ?>;
                }
                <?php
            endif;

            if ($text_color_hover != '') : ?>

            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return elessi_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for header
 */
if (!function_exists('elessi_get_style_header_color')) :

    function elessi_get_style_header_color(
        $bg_color = '',
        $text_color = '',
        $text_color_hover = '',
        $return = true
    ) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override header color =========================================== */
            <?php if ($bg_color != '') : ?>
                body #masthead,
                body .mobile-menu .nasa-td-mobile-icons .nasa-mobile-icons-wrap.nasa-absolute-icons .nasa-header-icons-wrap,
                body .nasa-header-sticky.nasa-header-mobile-layout.nasa-header-transparent .sticky-wrapper.fixed-already #masthead
                {
                    background-color: <?php echo esc_attr($bg_color); ?>;
                }
                body .nasa-header-mobile-layout.nasa-header-transparent #masthead
                {
                    background-color: transparent;
                }
            <?php
        endif;

        if ($text_color != '') :
            ?>
                body #masthead .header-icons > li a,
                body .mini-icon-mobile .nasa-icon,
                body .nasa-toggle-mobile_icons,
                body #masthead .follow-icon a i,
                body #masthead .nasa-search-space .nasa-show-search-form .search-wrapper form .nasa-icon-submit-page:before,
                body #masthead .nasa-search-space .nasa-show-search-form .nasa-close-search,
                body #masthead .nasa-search-space .nasa-show-search-form .search-wrapper form input[name="s"]
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                .mobile-menu .nasa-td-mobile-icons .nasa-toggle-mobile_icons .nasa-icon
                {
                    border-color: transparent !important;
                }
                <?php
            endif;

            if ($text_color_hover != '') :
                ?>
                body #masthead .header-icons > li a:hover i,
                body #masthead .mini-cart .cart-icon:hover:before,
                body #masthead .follow-icon a:hover i
                {
                    color: <?php echo esc_attr($text_color_hover); ?>;
                }
            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return elessi_convert_css($css);
        }
    }

endif;

/**
 * CSS override color for TOPBAR
 */
if (!function_exists('elessi_get_style_topbar_color')) :

    function elessi_get_style_topbar_color(
        $bg_color = '',
        $text_color = '',
        $text_color_hover = '',
        $return = true
    ) {
        if ($bg_color == '' && $text_color == '' && $text_color_hover == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start override topbar color =========================================== */
            <?php if ($bg_color != '') : ?>
                body #top-bar,
                body .nasa-topbar-wrap.nasa-topbar-toggle .nasa-icon-toggle
                {
                    background-color: <?php echo esc_attr($bg_color); ?>;
                }
                body #top-bar,
                body .nasa-topbar-wrap.nasa-topbar-toggle .nasa-icon-toggle
                {
                    border-color: <?php echo esc_attr($bg_color); ?>;
                }
            <?php
            endif;

            if ($text_color != '') : ?>
                body #top-bar,
                body #top-bar .topbar-menu-container .wcml-cs-item-toggle,
                body #top-bar .topbar-menu-container > ul > li:after,
                body #top-bar .topbar-menu-container > ul > li > a,
                body #top-bar .left-text,
                body .nasa-topbar-wrap.nasa-topbar-toggle .nasa-icon-toggle
                {
                    color: <?php echo esc_attr($text_color); ?>;
                }
                <?php
            endif;

            if ($text_color_hover != '') :
                ?>
                body #top-bar .topbar-menu-container .wcml-cs-item-toggle:hover,
                body #top-bar .topbar-menu-container > ul > li > a:hover,
                body .nasa-topbar-wrap.nasa-topbar-toggle .nasa-icon-toggle:hover
                {
                    color: <?php echo esc_attr($text_color_hover); ?>;
                }
            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return elessi_convert_css($css);
        }
    }

endif;

/**
 * CSS override Add more width site
 */
if (!function_exists('elessi_get_style_plus_wide_width')) :

    function elessi_get_style_plus_wide_width($max_width = '', $return = true) {
        if ($max_width == '') {
            return '';
        }

        if ($return) {
            ob_start();
        }
        ?><style>
            /* Start Override Max-width screen site */
            <?php if ($max_width != '') : ?>
                <?php if (NASA_ELEMENTOR_ACTIVE) : ?>.elementor-section.elementor-section-boxed > .elementor-container,<?php endif; ?>
                html body .row,
                html body.boxed #wrapper,
                html body.boxed .nav-wrapper .nasa-megamenu.fullwidth > .nav-dropdown,
                html body .nav-wrapper .nasa-megamenu.fullwidth > .nav-dropdown > ul,
                body .nasa-fixed-product-variations
                {
                    max-width: <?php echo $max_width; ?>px;
                }
                html body.boxed #wrapper .row,
                html body.boxed .nav-wrapper .nasa-megamenu.fullwidth > .nav-dropdown > ul
                {
                    max-width: <?php echo $max_width - 50; ?>px;
                }
                @media only screen and (min-width: 768px) {
                    html body.dokan-store #main-content {
                        max-width: <?php echo $max_width; ?>px;
                    }
                }
            <?php endif; ?>
            /* End =========================================== */
        </style>
        <?php
        if ($return) {
            $css = ob_get_clean();
    
            return elessi_convert_css($css);
        }
    }

endif;

/**
 * CSS Override Font style
 */
if (!function_exists('elessi_get_font_style_rtl')) :
    
    function elessi_get_font_style_rtl (
        $type_font_select = '',
        $type_headings = '',
        $type_texts = '',
        $type_nav = '',
        $type_banner = '',
        $type_price = '',
        $custom_font = ''
    ) {
    
        if ($type_font_select == '') {
            return '';
        }

        ob_start();
        ?><style><?php
        
        if ($type_font_select == 'custom' && $custom_font) :
            ?>
                body.nasa-rtl,
                body.nasa-rtl p,
                body.nasa-rtl h1,
                body.nasa-rtl h2,
                body.nasa-rtl h3,
                body.nasa-rtl h4,
                body.nasa-rtl h5,
                body.nasa-rtl h6,
                body.nasa-rtl #top-bar,
                body.nasa-rtl .nav-dropdown,
                body.nasa-rtl .top-bar-nav a.nav-top-link,
                body.nasa-rtl .megatop > a,
                body.nasa-rtl .root-item > a,
                body.nasa-rtl .nasa-tabs a,
                body.nasa-rtl .service-title,
                body.nasa-rtl .price .amount,
                body.nasa-rtl .nasa-banner,
                body.nasa-rtl .nasa-banner h1,
                body.nasa-rtl .nasa-banner h2,
                body.nasa-rtl .nasa-banner h3,
                body.nasa-rtl .nasa-banner h4,
                body.nasa-rtl .nasa-banner h5,
                body.nasa-rtl .nasa-banner h6
                {
                    font-family: "<?php echo esc_attr(ucwords($custom_font)); ?>", helvetica, arial, sans-serif;
                }
            <?php
        elseif ($type_font_select == 'google') :
            if ($type_headings != '') :
                ?>
                    body.nasa-rtl .service-title,
                    body.nasa-rtl .nasa-tabs a,
                    body.nasa-rtl h1,
                    body.nasa-rtl h2,
                    body.nasa-rtl h3,
                    body.nasa-rtl h4,
                    body.nasa-rtl h5,
                    body.nasa-rtl h6
                    {
                        font-family: "<?php echo esc_attr($type_headings); ?>", helvetica, arial, sans-serif;
                    }
                <?php
            endif;
            
            if ($type_texts != '') :
                ?>
                    body.nasa-rtl,
                    body.nasa-rtl p,
                    body.nasa-rtl #top-bar,
                    body.nasa-rtl .nav-dropdown,
                    body.nasa-rtl .top-bar-nav a.nav-top-link
                    {
                        font-family: "<?php echo esc_attr($type_texts); ?>", helvetica, arial, sans-serif;
                    }
                <?php
            endif;

            if ($type_nav != '') :
                ?>
                    body.nasa-rtl .megatop > a,
                    body.nasa-rtl .root-item a,
                    body.nasa-rtl .nasa-tabs a,
                    body.nasa-rtl .topbar-menu-container .header-multi-languages a
                    {
                        font-family: "<?php echo esc_attr($type_nav); ?>", helvetica, arial, sans-serif;
                    }
                <?php
            endif;

            if ($type_banner != '') :
                ?>
                    body.nasa-rtl .nasa-banner,
                    body.nasa-rtl .nasa-banner h1,
                    body.nasa-rtl .nasa-banner h2,
                    body.nasa-rtl .nasa-banner h3,
                    body.nasa-rtl .nasa-banner h4,
                    body.nasa-rtl .nasa-banner h5,
                    body.nasa-rtl .nasa-banner h6
                    {
                        font-family: "<?php echo esc_attr($type_banner); ?>", helvetica, arial, sans-serif;
                        letter-spacing: 0px;
                    }
                <?php
            endif;

            if ($type_price != '') :
                ?>
                    body.nasa-rtl .price,
                    body.nasa-rtl .amount
                    {
                        font-family: "<?php echo esc_attr($type_price); ?>", helvetica, arial, sans-serif;
                    }
                <?php
            endif;
        endif; ?></style><?php
        $css = ob_get_clean();

        return elessi_convert_css($css);
    }
    
endif;

/**
 * CSS Override Font style
 */
if (!function_exists('elessi_get_font_style')) :
    
    function elessi_get_font_style (
        $type_font_select = '',
        $type_headings = '',
        $type_texts = '',
        $type_nav = '',
        $type_banner = '',
        $type_price = '',
        $custom_font = '',
        $imprtant = false
    ) {
    
        if ($type_font_select == '') {
            return '';
        }

        ob_start();
        ?><style>
        <?php
        if ($type_font_select == 'custom' && $custom_font) :
            ?>
                body,
                p,
                h1, h2, h3, h4, h5, h6,
                #top-bar,
                .nav-dropdown,
                .top-bar-nav a.nav-top-link,
                .megatop > a,
                .root-item > a,
                .nasa-tabs a,
                .service-title,
                .price .amount,
                .nasa-banner,
                .nasa-banner h1,
                .nasa-banner h2,
                .nasa-banner h3,
                .nasa-banner h4,
                .nasa-banner h5,
                .nasa-banner h6
                {
                    font-family: "<?php echo esc_attr(ucwords($custom_font)); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                }
            <?php
        elseif ($type_font_select == 'google') :
            if ($type_headings != '') :
                ?>
                    .service-title,
                    .nasa-tabs a,
                    h1, h2, h3, h4, h5, h6
                    {
                        font-family: "<?php echo esc_attr($type_headings); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                    }
                <?php
            endif;
            
            if ($type_texts != '') :
                ?>
                    p,
                    body,
                    #top-bar,
                    .nav-dropdown,
                    .top-bar-nav a.nav-top-link
                    {
                        font-family: "<?php echo esc_attr($type_texts); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                    }
                <?php
            endif;

            if ($type_nav != '') :
                ?>
                    .megatop > a,
                    .root-item a,
                    .nasa-tabs a,
                    .topbar-menu-container .header-multi-languages a
                    {
                        font-family: "<?php echo esc_attr($type_nav); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                    }
                <?php
            endif;

            if ($type_banner != '') :
                ?>
                    .nasa-banner,
                    .nasa-banner h1,
                    .nasa-banner h2,
                    .nasa-banner h3,
                    .nasa-banner h4,
                    .nasa-banner h5,
                    .nasa-banner h6
                    {
                        font-family: "<?php echo esc_attr($type_banner); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                        letter-spacing: 0px;
                    }
                <?php
            endif;

            if ($type_price != '') :
                ?>
                    .price,
                    .amount
                    {
                        font-family: "<?php echo esc_attr($type_price); ?>", helvetica, arial, sans-serif<?php echo $imprtant ? ' !important' : ''; ?>;
                    }
                <?php
            endif;
        endif; ?></style><?php
        $css = ob_get_clean();

        return elessi_convert_css($css);
    }
    
endif;

// **********************************************************************// 
// ! Dynamic - css
// **********************************************************************//
add_action('wp_enqueue_scripts', 'elessi_add_dynamic_css', 999);
if (!function_exists('elessi_add_dynamic_css')) :

    function elessi_add_dynamic_css() {
        global $nasa_upload_dir;
        
        if (!isset($nasa_upload_dir)) {
            $nasa_upload_dir = wp_upload_dir();
            $GLOBALS['nasa_upload_dir'] = $nasa_upload_dir;
        }
        
        $dynamic_path = $nasa_upload_dir['basedir'] . '/nasa-dynamic';
        
        if (is_file($dynamic_path . '/dynamic.css')) {
            global $nasa_opt;
            $version = isset($nasa_opt['nasa_dynamic_t']) ? $nasa_opt['nasa_dynamic_t'] : null;
            
            // Dynamic Css
            wp_enqueue_style('elessi-style-dynamic', elessi_remove_protocol($nasa_upload_dir['baseurl']) . '/nasa-dynamic/dynamic.css', array('elessi-style'), $version, 'all');
        }
    }

endif;

// **********************************************************************// 
// ! Dynamic - Page override primary color - css
// **********************************************************************//
add_action('wp_enqueue_scripts', 'elessi_page_override_style', 1000);
if (!function_exists('elessi_page_override_style')) :
    function elessi_page_override_style() {
        if (!wp_style_is('elessi-style-dynamic')) {
            return;
        }

        global $post, $nasa_opt, $content_width;
        $post_type = isset($post->post_type) ? $post->post_type : false;
        $is_page = 'page' === $post_type ? true : false;
        $object_id = $is_page ? $post->ID : false;
        
        if (!$is_page) {
            /**
             * Shop Page
             */
            if (NASA_WOO_ACTIVED) {
                $is_shop = is_shop();
                $is_product_taxonomy = is_product_taxonomy();
                $is_product_category = is_product_category();
                $object_id = ($is_shop || $is_product_taxonomy) && !$is_product_category ? wc_get_page_id('shop') : 0;

                $is_page = $object_id ? true : false;
            }
            
            /**
             * Page post
             */
            
            if (!$is_page && elessi_check_blog_page()) {
                $object_id = get_option('page_for_posts');
                $is_page = $object_id ? true : false;
            }
        }
        
        $dinamic_css = '';
        if ($is_page && $object_id) {

            /**
             * color_primary
             */
            $flag_override_color = get_post_meta($object_id, '_nasa_pri_color_flag', true);
            $color_primary_css = $page_css = '';
            if ($flag_override_color) :
                $color_primary = get_post_meta($object_id, '_nasa_pri_color', true);
                $color_primary_css = $color_primary ? elessi_get_style_primary_color($color_primary) : '';
            endif;

            /**
             * color for header
             */
            $bg_color = get_post_meta($object_id, '_nasa_bg_color_header', true);
            $text_color = get_post_meta($object_id, '_nasa_text_color_header', true);
            $text_color_hover = get_post_meta($object_id, '_nasa_text_color_hover_header', true);
            $page_css .= elessi_get_style_header_color($bg_color, $text_color, $text_color_hover);

            /**
             * color for top bar
             */
            if (!isset($nasa_opt['topbar_show']) || $nasa_opt['topbar_show']) {
                $bg_color = get_post_meta($object_id, '_nasa_bg_color_topbar', true);
                $text_color = get_post_meta($object_id, '_nasa_text_color_topbar', true);
                $text_color_hover = get_post_meta($object_id, '_nasa_text_color_hover_topbar', true);
                $page_css .= elessi_get_style_topbar_color($bg_color, $text_color, $text_color_hover);
            }

            /**
             * color for main menu
             */
            $bg_color = get_post_meta($object_id, '_nasa_bg_color_main_menu', true);
            $text_color = get_post_meta($object_id, '_nasa_text_color_main_menu', true);
            $text_color_hover = get_post_meta($object_id, '_nasa_text_color_hover_main_menu', true);
            $page_css .= elessi_get_style_main_menu_color($bg_color, $text_color, $text_color_hover);

            /**
             * Add width to site
             */
            $max_width = '';
            $plus_option = get_post_meta($object_id, '_nasa_plus_wide_option', true);
            switch ($plus_option) {
                case '1':
                    $plus_width = get_post_meta($object_id, '_nasa_plus_wide_width', true);
                    break;

                case '-1':
                    $plus_width = 0;
                    break;

                case '':
                default :
                    $plus_width = '';
                    break;
            }
            
            if ($plus_width !== '' && (int) $plus_width >= 0) {
                $content_width = !isset($content_width) ? 1200 : $content_width;
                $max_width = ($content_width + (int) $plus_width);
            }
            
            $page_css .= elessi_get_style_plus_wide_width($max_width);
            
            /**
             * Font style
             */
            $type_font_select = get_post_meta($object_id, '_nasa_type_font_select', true);
            
            $type_headings = '';
            $type_texts = '';
            $type_nav = '';
            $type_banner = '';
            $type_price = '';
            $custom_font = '';

            if ($type_font_select == 'google') {
                $type_headings = get_post_meta($object_id, '_nasa_type_headings', true);
                $type_texts = get_post_meta($object_id, '_nasa_type_texts', true);
                $type_nav = get_post_meta($object_id, '_nasa_type_nav', true);
                $type_banner = get_post_meta($object_id, '_nasa_type_banner', true);
                $type_price = get_post_meta($object_id, '_nasa_type_price', true);
            }

            if ($type_font_select == 'custom') {
                $custom_font = get_post_meta($object_id, '_nasa_custom_font', true);
            }
            
            $font_css = elessi_get_font_style(
                $type_font_select,
                $type_headings,
                $type_texts,
                $type_nav,
                $type_banner,
                $type_price,
                $custom_font,
                true
            );

            $dinamic_css = $color_primary_css . $page_css . $font_css;
        }
        
        /**
         * Override primary color for root category product
         */
        else {
            $root_cat_id = elessi_get_root_term_id();
            if ($root_cat_id) {
                $color_primary = get_term_meta($root_cat_id, 'cat_primary_color', true);
                $dinamic_css = $color_primary ? elessi_get_style_primary_color($color_primary) : '';
                
                /**
                 * Font style
                 */
                $type_font_select = get_term_meta($root_cat_id, 'type_font', true);
                
                $type_headings = '';
                $type_texts = '';
                $type_nav = '';
                $type_banner = '';
                $type_price = '';
                $custom_font = '';
                
                if ($type_font_select == 'google') {
                    $type_headings = get_term_meta($root_cat_id, 'headings_font', true);
                    $type_texts = get_term_meta($root_cat_id, 'texts_font', true);
                    $type_nav = get_term_meta($root_cat_id, 'nav_font', true);
                    $type_banner = get_term_meta($root_cat_id, 'banner_font', true);
                    $type_price = get_term_meta($root_cat_id, 'price_font', true);
                }
                
                if ($type_font_select == 'custom') {
                    $custom_font = get_term_meta($root_cat_id, 'custom_font', true);
                }
                
                $font_css = elessi_get_font_style(
                    $type_font_select,
                    $type_headings,
                    $type_texts,
                    $type_nav,
                    $type_banner,
                    $type_price,
                    $custom_font,
                    true
                );
                
                $dinamic_css .= $font_css;
            }
        }
        
        /**
         * Css inline override
         */
        if ($dinamic_css != '') {
            wp_add_inline_style('elessi-style-dynamic', $dinamic_css);
        }
    }
endif;
