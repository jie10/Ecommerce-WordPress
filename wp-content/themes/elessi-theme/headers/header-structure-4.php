<div class="<?php echo esc_attr($header_classes); ?>">
    <?php
    /**
     * Hook - top bar header
     */
    do_action('nasa_topbar_header');
    ?>
    <div class="sticky-wrapper">
        <div id="masthead" class="site-header">
            <?php do_action('nasa_mobile_header'); ?>
            
            <div class="row nasa-hide-for-mobile">
                <div class="large-12 columns nasa-wrap-event-search">
                    <div class="nasa-header-flex nasa-elements-wrap">
                        <!-- Logo -->
                        <div class="logo-wrapper">
                            <?php echo elessi_logo(); ?>
                        </div>

                        <!-- Search form in header -->
                        <div class="fgr-2 nasa-header-search-wrap nasa-search-relative">
                            <?php echo elessi_search('full'); ?>
                        </div>
                        
                        <!-- Group icon header -->
                        <div class="icons-wrapper">
                            <?php echo $nasa_header_icons; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main menu -->
            <div class="nasa-elements-wrap nasa-elements-wrap-main-menu nasa-hide-for-mobile nasa-elements-wrap-bg">
                <div class="row">
                    <div class="large-12 columns">
                        <div class="wide-nav nasa-wrap-width-main-menu nasa-bg-wrap<?php echo esc_attr($menu_warp_class); ?>">
                            <div class="nasa-menus-wrapper nasa-menus-wrapper-reponsive nasa-loading" data-padding_x="<?php echo (int) $data_padding_x; ?>">
                                <div id="nasa-menu-vertical-header" class="nasa-menu-vertical-header rtl-right">
                                    <?php elessi_get_vertical_menu(); ?>
                                </div>
                                
                                <?php elessi_get_main_menu(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
