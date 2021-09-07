<div class="<?php echo esc_attr($header_classes); ?>">
    <?php
    /**
     * Hook - top bar header
     */
    do_action('nasa_topbar_header_mobile');
    ?>
    <div class="sticky-wrapper">
        <div id="masthead" class="site-header">
            
            <!-- Icons Left -->
            <div class="mini-icon-mobile left-icons elements-wrapper rtl-text-right">
                <a href="javascript:void(0);" class="nasa-icon nasa-mobile-menu_toggle mobile_toggle nasa-mobile-menu-icon pe-7s-menu" rel="nofollow"></a>
                <a class="nasa-icon icon pe-7s-search mobile-search" href="javascript:void(0);" rel="nofollow"></a>
            </div>

            <!-- Logo -->
            <div class="logo-wrapper elements-wrapper text-center">
                <?php echo elessi_logo(); ?>
            </div>

            <!-- Icons Right -->
            <div class="right-icons elements-wrapper text-right rtl-text-left">
                <?php
                /**
                 * product_cat: false
                 * cart: true
                 * compare: false
                 * wishlist: true
                 * search: false
                 */
                echo elessi_header_icons(false, true, false, false, false); ?>
            </div>
        </div>
    </div>
</div>

<!-- Menu site -->
<div class="hidden-tag">
    <?php
    elessi_get_main_menu();
    if ($vertical) :
        elessi_get_vertical_menu();
    endif;
    ?>
</div>
