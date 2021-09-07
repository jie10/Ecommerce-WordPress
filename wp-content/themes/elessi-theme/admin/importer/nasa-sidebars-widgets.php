<?php
function elessi_sidebars_widgets_import() {
    $results = array(
        'sidebars_widgets' => array(
            'wp_inactive_widgets' => array(),
            
            'blog-sidebar' => array(
                0 => 'search-2',
                1 => 'recent-posts-2',
                2 => 'categories-2',
                3 => 'archives-2',
                4 => 'meta-2'
            ),
            
            'shop-sidebar' => array(
                0 => 'nasa_product_categories-2',
                1 => 'nasa_woocommerce_filter_variations-2',
                2 => 'nasa_woocommerce_filter_variations-3',
                3 => 'nasa_woocommerce_price_filter-2',
                4 => 'nasa_woocommerce_status_filter-2',
                5 => 'nasa_woocommerce_reset_filter-2',
            ),
            
            'product-sidebar' => array(
                0 => 'nasa_product_categories-3',
                1 => 'nasa_tag_cloud-2'
            )
        ),
        
        'widgets' => array(
            'widget_search' => array(
                2 => array(
                    'title' => 'Search'
                ),
                '_multiwidget' => 1
            ),
            
            'widget_recent-posts' => array(
                2 => array(
                    'title' => 'Recent'
                ),
                '_multiwidget' => 1
            ),
            
            'widget_categories' => array(
                2 => array(
                    'title' => 'Categories',
                    'count' => 0,
                    'hierarchical' => 0,
                    'dropdown' => 0,
                ),
                '_multiwidget' => 1
            ),
            
            'widget_archives' => array(
                2 => array(
                    'title' => 'Archives',
                    'count' => 0,
                    'dropdown' => 0,
                ),
                '_multiwidget' => 1
            ),
            
            'widget_meta' => array(
                2 => array(
                    'title' => 'Meta',
                ),
                '_multiwidget' => 1
            ),
            
            'widget_nasa_product_categories' => array(
                2 => array(
                    'title' => 'Categories',
                    'orderby' => 'order',
                    'count' => 0,
                    'hierarchical' => 1,
                    'show_children_only' => 0,
                    'accordion' => 1,
                    'show_items' => 'All',
                    'toggle' => '',
                ),
                3 => array(
                    'title' => 'Categories',
                    'orderby' => 'order',
                    'count' => 0,
                    'hierarchical' => 1,
                    'show_children_only' => 0,
                    'accordion' => 1,
                    'show_items' => 'All',
                    'toggle' => '',
                ),
                '_multiwidget' => 1
            ),
            
            'widget_nasa_woocommerce_filter_variations' => array(
                2 => array(
                    'title' => 'Color',
                    'attribute' => 'color',
                    'query_type' => 'or',
                    'show_items' => 'All',
                    'effect' => 'slide',
                    'hide_empty' => 0,
                    'count' => 0,
                ),
                3 => array(
                    'title' => 'Size',
                    'attribute' => 'size',
                    'query_type' => 'or',
                    'show_items' => 'All',
                    'effect' => 'slide',
                    'hide_empty' => 0,
                    'count' => 0,
                ),
                '_multiwidget' => 1
            ),
            
            'widget_nasa_woocommerce_price_filter' => array(
                2 => array(
                    'title' => 'Price',
                    'btn_filter' => 0,
                ),
                '_multiwidget' => 1
            ),
            
            'widget_nasa_woocommerce_status_filter' => array(
                2 => array(
                    'title' => 'Status',
                    'filter_onsale' => 1,
                    'filter_featured' => 1,
                    'filter_instock' => 1,
                    'filter_onbackorder' => 1
                ),
                '_multiwidget' => 1
            ),
            
            'widget_nasa_woocommerce_reset_filter' => array(
                2 => array(
                    'title' => 'Clear Filters'
                ),
                '_multiwidget' => 1
            ),
            
            'widget_nasa_tag_cloud' => array(
                2 => array(
                    'title' => 'Tags',
                    'taxonomy' => 'product_tag',
                    'show_items' => 'All',
                ),
                '_multiwidget' => 1
            ),
        )
    );
    
    defined('NASA_ELEMENTOR_ACTIVE') or define('NASA_ELEMENTOR_ACTIVE', defined('ELEMENTOR_PATH') && ELEMENTOR_PATH);
    if (NASA_ELEMENTOR_ACTIVE) {
        /**
         * Light 1
         */
        $results['sidebars_widgets']['footer-light-1-1'] = array(
            0 => 'nasa_image-2',
            1 => 'custom_html-2',
            2 => 'nasa_follow-2',
        );
        
        $results['sidebars_widgets']['footer-light-1-2'] = array(
            0 => 'custom_html-3',
            1 => 'nasa_menu_sc-3'
        );
        
        $results['sidebars_widgets']['footer-light-1-3'] = array(
            0 => 'custom_html-4',
            1 => 'nasa_menu_sc-2'
        );
        
        $results['sidebars_widgets']['footer-light-1-4'] = array(
            0 => 'custom_html-5',
            1 => 'custom_html-6',
            2 => 'custom_html-7'
        );
        
        $results['sidebars_widgets']['footer-light-1-5'] = array(
            0 => 'custom_html-8'
        );
        
        $results['sidebars_widgets']['footer-light-1-6'] = array(
            0 => 'nasa_menu_sc-4'
        );
        
        /**
         * Light 2
         */
        $results['sidebars_widgets']['footer-light-2-1'] = array(
            0 => 'nasa_image-3',
            1 => 'custom_html-10'
        );
        
        $results['sidebars_widgets']['footer-light-2-2'] = array(
            0 => 'nasa_follow-3',
            1 => 'nasa_menu_sc-5'
        );
        
        $results['sidebars_widgets']['footer-light-2-3'] = array(
            0 => 'custom_html-11'
        );
        
        $results['sidebars_widgets']['footer-light-2-4'] = array(
            0 => 'nasa_menu_sc-6'
        );
        
        $results['sidebars_widgets']['footer-light-2-5'] = array(
            0 => 'custom_html-12',
            1 => 'nasa_image-7'
        );
        
        $results['sidebars_widgets']['footer-light-2-6'] = array(
            0 => 'custom_html-13'
        );
        
        $results['sidebars_widgets']['footer-light-2-7'] = array(
            0 => 'nasa_menu_sc-7'
        );
        
        /**
         * Light 3
         */
        $results['sidebars_widgets']['footer-light-3-1'] = array(
            0 => 'custom_html-14'
        );
        
        $results['sidebars_widgets']['footer-light-3-2'] = array(
            0 => 'nasa_image-4',
            1 => 'text-2',
            2 => 'nasa_follow-4',
            3 => 'nasa_menu_sc-8',
            3 => 'text-3',
        );
        
        /**
         * Dark
         */
        $results['sidebars_widgets']['footer-dark-1-1'] = array(
            0 => 'custom_html-15'
        );
        
        $results['sidebars_widgets']['footer-dark-1-2'] = array(
            0 => 'nasa_image-5',
            1 => 'text-4',
            2 => 'nasa_follow-5',
            3 => 'nasa_menu_sc-9'
        );
        
        /**
         * Mobile
         */
        $results['sidebars_widgets']['footer-mobile'] = array(
            0 => 'nasa_image-6',
            0 => 'custom_html-9'
        );
        
        $results['widgets']['widget_nasa_image'] = array(
            2 => array(
                'alt' => 'Logo Footer',
                'link_text' => '#',
                'link_target' => '',
                'image' => '1703',
                'align' => '',
                'el_class' => '',
            ),
            3 => array(
                'alt' => 'Logo Footer',
                'link_text' => '#',
                'link_target' => '',
                'image' => '1703',
                'align' => '',
                'el_class' => '',
            ),
            4 => array(
                'alt' => 'Logo Footer',
                'link_text' => '#',
                'link_target' => '',
                'image' => '1703',
                'align' => 'center',
                'el_class' => '',
            ),
            5 => array(
                'alt' => 'Logo Footer',
                'link_text' => '#',
                'link_target' => '',
                'image' => '2185',
                'align' => 'center',
                'el_class' => '',
            ),
            6 => array(
                'alt' => 'Logo Footer',
                'link_text' => '#',
                'link_target' => '',
                'image' => '1703',
                'align' => 'center',
                'el_class' => 'margin-top-30',
            ),
            7 => array(
                'alt' => 'Payments Accepted',
                'link_text' => '',
                'link_target' => '',
                'image' => '1698',
                'align' => 'right',
                'el_class' => '',
            ),
            '_multiwidget' => 1
        );
        
        $results['widgets']['widget_nasa_follow'] = array(
            2 => array(
                'title' => '',
                'twitter' => '',
                'facebook' => '',
                'pinterest' => '',
                'email' => '',
                'instagram' => '',
                'rss' => '',
                'linkedin' => '',
                'youtube' => '',
                'flickr' => '',
                'telegram' => '',
                'whatsapp' => '',
                'amazon' => '',
                'tumblr' => '',
                'el_class' => '',
            ),
            3 => array(
                'title' => '',
                'twitter' => '',
                'facebook' => '',
                'pinterest' => '',
                'email' => '',
                'instagram' => '',
                'rss' => '',
                'linkedin' => '',
                'youtube' => '',
                'flickr' => '',
                'telegram' => '',
                'whatsapp' => '',
                'amazon' => '',
                'tumblr' => '',
                'el_class' => '',
            ),
            4 => array(
                'title' => '',
                'twitter' => '',
                'facebook' => '',
                'pinterest' => '',
                'email' => '',
                'instagram' => '',
                'rss' => '',
                'linkedin' => '',
                'youtube' => '',
                'flickr' => '',
                'telegram' => '',
                'whatsapp' => '',
                'amazon' => '',
                'tumblr' => '',
                'el_class' => 'padding-top-20 padding-bottom-20',
            ),
            5 => array(
                'title' => '',
                'twitter' => '',
                'facebook' => '',
                'pinterest' => '',
                'email' => '',
                'instagram' => '',
                'rss' => '',
                'linkedin' => '',
                'youtube' => '',
                'flickr' => '',
                'telegram' => '',
                'whatsapp' => '',
                'amazon' => '',
                'tumblr' => '',
                'el_class' => 'text-center padding-top-20',
            ),
            '_multiwidget' => 1
        );
        
        $results['widgets']['widget_nasa_menu_sc'] = array(
            2 => array(
                'title' => '',
                'menu' => 'customer-care',
                'el_class' => '',
            ),
            3 => array(
                'title' => '',
                'menu' => 'information',
                'el_class' => '',
            ),
            4 => array(
                'title' => '',
                'menu' => 'footer-menu',
                'el_class' => '',
            ),
            5 => array(
                'title' => '',
                'menu' => 'information',
                'el_class' => '',
            ),
            6 => array(
                'title' => '',
                'menu' => 'customer-care',
                'el_class' => '',
            ),
            7 => array(
                'title' => '',
                'menu' => 'footer-menu',
                'el_class' => '',
            ),
            8 => array(
                'title' => '',
                'menu' => 'footer-menu',
                'el_class' => 'nasa-menu-inline text-center',
            ),
            9 => array(
                'title' => '',
                'menu' => 'footer-menu',
                'el_class' => 'nasa-menu-inline text-center',
            ),
            '_multiwidget' => 1
        );
        
        $results['widgets']['widget_text'] = array(
            2 => array(
                'title' => '',
                'text' => '<p class="text-center padding-left-80 padding-right-80 padding-top-50">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>',
                'filter' => true,
                'visual' => true,
            ),
            3 => array(
                'title' => '',
                'text' => '<p class="margin-bottom-0">© 2020 <strong>Nasatheme</strong> - All Right reserved!</p>',
                'filter' => true,
                'visual' => true,
            ),
            4 => array(
                'title' => '',
                'text' => '<p class="text-center padding-left-80 padding-right-80 padding-top-50">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>',
                'filter' => true,
                'visual' => true,
            ),
            '_multiwidget' => 1
        );
        
        $results['widgets']['widget_custom_html'] = array(
            2 => array(
                'title' => '',
                'content' => '<ul class="contact-information"><li class="media"><div class="contact-text">Cecilia Chapman 711-2880 Nulla St</div></li><li class="media"><div class="contact-text">(+01)-800-3456-88</div></li><li class="media"><div class="contact-text"><a href="mailto:youremail@yourdomain.com" title="Email">youremail@yourdomain.com</a></div></li><li class="media"><div class="contact-text"><a href="http://yourdomain.com" title="www.yourdomain.com">www.yourdomain.com</a></div></li></ul>',
            ),
            3 => array(
                'title' => '',
                'content' => '<h4>Information</h4>',
            ),
            4 => array(
                'title' => '',
                'content' => '<h4>Need Help</h4>',
            ),
            5 => array(
                'title' => '',
                'content' => '<h4>Newsletter</h4>',
            ),
            6 => array(
                'title' => '',
                'content' => '<p class="nasa-contact-text">Get instant updates about our new products and special promos!</p>',
            ),
            7 => array(
                'title' => '',
                'content' => '[contact-form-7 id="210" title="Elessi Newsletter Form Footer"]',
            ),
            8 => array(
                'title' => '',
                'content' => '<p>© 2020 <strong>Nasatheme</strong> - All Right reserved!</p>',
            ),
            9 => array(
                'title' => '',
                'content' => '<ul class="contact-information text-center margin-bottom-0 margin-top-20"><li class="media"><div class="contact-text">Calista Wise 7292 Dictum Av.Antonio, Italy.</div></li><li class="media"><div class="contact-text">(+01)-800-3456-88</div></li><li class="media"><div class="contact-text"><a href="mailto:youremail@yourdomain.com" title="Email">youremail@yourdomain.com</a></div></li><li class="media"><div class="contact-text"><a href="http://www.yourdomain.com" title="www.yourdomain.com">www.yourdomain.com</a></div></li></ul><p class="text-center padding-top-10 padding-bottom-10">© 2020 <strong>Nasatheme</strong> - All Right reserved!</p>',
            ),
            10 => array(
                'title' => '',
                'content' => '<ul class="contact-information"><li class="media"><div class="contact-text">Cecilia Chapman 711-2880 Nulla St</div></li><li class="media"><div class="contact-text">(+01)-800-3456-88</div></li><li class="media"><div class="contact-text"><a href="mailto:youremail@yourdomain.com" title="Email">youremail@yourdomain.com</a></div></li><li class="media"><div class="contact-text"><a href="http://yourdomain.com" title="www.yourdomain.com">www.yourdomain.com</a></div></li></ul>',
            ),
            11 => array(
                'title' => '',
                'content' => '[contact-form-7 id="210" title="Elessi Newsletter Form Footer"]',
            ),
            12 => array(
                'title' => '',
                'content' => '<ul class="nasa-opening-time"><li><span class="nasa-day-open">Monday - Friday</span><span class="nasa-time-open">08:00 - 20:00</span></li><li><span class="nasa-day-open">Saturday</span><span class="nasa-time-open">09:00 - 21:00</span></li><li><span class="nasa-day-open">Sunday</span><span class="nasa-time-open">13:00 - 22:00</span></li></ul>',
            ),
            13 => array(
                'title' => '',
                'content' => '<p>© 2020 <strong>Nasatheme</strong> - All Right reserved!</p>',
            ),
            14 => array(
                'title' => '',
                'content' => '<div class="row">
	<div class="large-3 nasa-service-footer nasa-col columns">
		[nasa_service_box service_icon="pe-7s-plane" service_title="Free Shipping" service_desc="Free shipping for all US order" service_style="style-4" service_hover="buzz_effect"]
	</div>
	<div class="large-3 nasa-service-footer nasa-col columns">
		[nasa_service_box service_icon="pe-7s-headphones" service_title="Support 24/6" service_desc="We support 24 hours a day" service_style="style-4" service_hover="buzz_effect"]
	</div>
	<div class="large-3 nasa-service-footer nasa-col columns">
		[nasa_service_box service_icon="pe-7s-refresh-2" service_title="100% Money Back" service_desc="You have 30 days to return" service_style="style-4" service_hover="buzz_effect"]
	</div>
	<div class="large-3 nasa-service-footer nasa-col columns">
		[nasa_service_box service_icon="pe-7s-gift" service_title="Payment Secure" service_desc="We ensure secure payment" service_style="style-4" service_hover="buzz_effect"]
	</div>
</div>',
            ),
            15 => array(
                'title' => '',
                'content' => '<div class="row">
	<div class="large-3 nasa-service-footer nasa-col columns">
		[nasa_service_box service_icon="pe-7s-plane" service_title="Free Shipping" service_desc="Free shipping for all US order" service_style="style-4" service_hover="buzz_effect"]
	</div>
	<div class="large-3 nasa-service-footer nasa-col columns">
		[nasa_service_box service_icon="pe-7s-headphones" service_title="Support 24/6" service_desc="We support 24 hours a day" service_style="style-4" service_hover="buzz_effect"]
	</div>
	<div class="large-3 nasa-service-footer nasa-col columns">
		[nasa_service_box service_icon="pe-7s-refresh-2" service_title="100% Money Back" service_desc="You have 30 days to return" service_style="style-4" service_hover="buzz_effect"]
	</div>
	<div class="large-3 nasa-service-footer nasa-col columns">
		[nasa_service_box service_icon="pe-7s-gift" service_title="Payment Secure" service_desc="We ensure secure payment" service_style="style-4" service_hover="buzz_effect"]
	</div>
</div>',
            ),
            '_multiwidget' => 1
        );
    }
    
    $results['sidebars_widgets']['array_version'] = 3;
    
    return $results;
}
