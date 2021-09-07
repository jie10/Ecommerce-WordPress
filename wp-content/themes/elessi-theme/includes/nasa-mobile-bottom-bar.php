<?php
$close = NASA_WOO_ACTIVED ? is_product() : false;
$is_close = apply_filters('nasa_close_mobile_bottom_bar', $close);
if ($is_close) :
    return;
endif;

$shopPageLink = NASA_WOO_ACTIVED ? wc_get_page_permalink('shop') : home_url('/');

$icon_home = apply_filters('nasa_bot_icon_home', '<i class="nasa-icon pe-7s-home"></i>');
$icon_filter = apply_filters('nasa_bot_icon_filter', '<i class="nasa-icon pe-7s-filter"></i>');
$icon_cats = apply_filters('nasa_bot_icon_filter_cats', '<i class="nasa-icon pe-7s-keypad"></i>');
$icon_search = apply_filters('nasa_bot_icon_search', '<i class="nasa-icon pe-7s-search"></i>');
?>

<ul class="nasa-bottom-bar-icons">
    <li class="nasa-bot-item">
        <a class="nasa-bot-icons nasa-bot-icon-shop" href="<?php echo esc_url($shopPageLink); ?>" title="<?php echo esc_attr__('Shop', 'elessi-theme'); ?>">
            <?php echo $icon_home; ?>
            <?php echo esc_html__('Shop', 'elessi-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item nasa-bot-item-sidebar hidden-tag">
        <a class="nasa-bot-icons nasa-bot-icon-sidebar" href="javascript:void(0);" title="<?php echo esc_attr__('Filters', 'elessi-theme'); ?>" rel="nofollow">
            <?php echo $icon_filter; ?>
            <?php echo esc_html__('Filters', 'elessi-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item">
        <a class="nasa-bot-icons nasa-bot-icon-categories filter-cat-icon-mobile" href="javascript:void(0);" title="<?php echo esc_attr__('Categories', 'elessi-theme'); ?>" rel="nofollow">
            <?php echo $icon_cats; ?>
            <?php echo esc_html__('Categories', 'elessi-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item nasa-bot-item-search hidden-tag">
        <a class="nasa-bot-icons nasa-bot-icon-search botbar-mobile-search" href="javascript:void(0);" title="<?php echo esc_attr__('Search', 'elessi-theme'); ?>" rel="nofollow">
            <?php echo $icon_search; ?>
            <?php echo esc_html__('Search', 'elessi-theme'); ?>
        </a>
    </li>
    
    <?php
    /**
     * Wishlist bottom bar
     */
    $wishlist_icons = elessi_icon_wishlist();
    if ($wishlist_icons) :
        ?>
        <li class="nasa-bot-item">
            <a class="nasa-bot-icons nasa-bot-icon-wishlist botbar-wishlist-link" href="javascript:void(0);" title="<?php echo esc_attr__('Wishlist', 'elessi-theme'); ?>" rel="nofollow">
                <i class="nasa-icon wishlist-icon icon-nasa-like"></i>
                <?php echo esc_html__('Wishlist', 'elessi-theme'); ?>
            </a>
            <?php echo $wishlist_icons; ?>
        </li>
        
    <?php else:
        
        /**
         * Cart bottom bar If Has Not Wishlist Featured
         */
        $is_cart = true;
        if (!NASA_WOO_ACTIVED || (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart'])) :
            $is_cart = false;
        endif;
        if ($is_cart) :
            $icon_class = elessi_mini_cart_icon();
            ?>
            <li class="nasa-bot-item">
                <a class="nasa-bot-icons nasa-bot-icon-cart botbar-cart-link" href="javascript:void(0);" title="<?php echo esc_attr__('Cart', 'elessi-theme'); ?>" rel="nofollow">
                    <i class="nasa-icon <?php echo $icon_class; ?>"></i>
                    <?php echo esc_html__('Cart', 'elessi-theme'); ?>
                </a>
            </li>
        <?php endif; ?>
    <?php endif; ?>
</ul>
