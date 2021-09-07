<?php
defined('ABSPATH') or die();

if (get_option('nasatheme_imported') !== 'imported') :
    ?>
    <div class="nasa-dashboard-demo-data">
        <h1 class="demo-data-heading">
            <?php esc_html_e('NasaTheme - Import Demo Data', 'nasa-core') ?>
        </h1>

        <?php if (!NASA_WOO_ACTIVED) :
            echo '<a href="' . esc_url(admin_url('themes.php?page=install-required-plugins')) . '" class="nasa-notice-install-builder-plgs">' . esc_html__('Please Install WooCommerce plugin Before Import Demo Data!!!', 'nasa-core') . '</a>';
        elseif (!NASA_WPB_ACTIVE && !NASA_ELEMENTOR_ACTIVE) :
            echo '<a href="' . esc_url(admin_url('themes.php?page=install-required-plugins')) . '" class="nasa-notice-install-builder-plgs">' . esc_html__('Please Install WPBakery or Elementor plugin Before Import Demo Data!!!', 'nasa-core') . '</a>';
        else : ?>

            <a class="nasa-start-import" href="javascript:void(0);"><?php echo esc_html__('START IMPORT DATA', 'nasa-core'); ?></a>

            <div class="nasa-select-homepage">
                <ul class="nasa-tabs-heading">
                    <?php if (NASA_WPB_ACTIVE) : ?>
                        <li>
                            <a href="javascript:void(0);" class="nasa-tab-heading" data-target=".demo-homepages-wpb">
                                <?php echo esc_html__('WPBakery - Homes', 'nasa-core'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (NASA_ELEMENTOR_ACTIVE) : ?>
                        <li>
                            <a href="javascript:void(0);" class="nasa-tab-heading" data-target=".demo-homepages-elm">
                                <?php echo esc_html__('Elementor - Homes', 'nasa-core'); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="nasa-tabs-panel">
                    <?php if (NASA_WPB_ACTIVE) : ?>
                        <div class="demo-homepages-wrap demo-homepages-wpb nasa-tab-content">
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-1" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-1.jpg" alt="Fashion 1" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-2" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-2.jpg" alt="Fashion 2" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-3" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-3.jpg" alt="Fashion 3" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-4" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-4.jpg" alt="Fashion 4" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-5" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-5.jpg" alt="Fashion 5" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-6" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-6.jpg" alt="Fashion 6" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-7" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-7.jpg" alt="Fashion 7" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-8" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-8.jpg" alt="Fashion 8" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="digital-1" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/digital-1.jpg" alt="Digital-1" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="digital-2" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/digital-2.jpg" alt="Digital-2" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="accessories" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/accessories.jpg" alt="Accessories" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="baby" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/baby.jpg" alt="Baby" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="bag" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/bag.jpg" alt="Bag" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="bike" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/bike.jpg" alt="Bike" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="cosmetic" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/cosmetic.jpg" alt="Cosmetic" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="face-mask" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/face-mask.jpg" alt="Face mask" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="furniture" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/furniture.jpg" alt="Furniture" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="jewelry" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/jewelry.jpg" alt="Jewelry" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="organic" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/organic.jpg" alt="Organic" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="retail" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/retail.jpg" alt="Retail" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="shoes" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/shoes.jpg" alt="Shoes" />
                                </a>
                            </div>
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="t-shirt" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/t-shirt.jpg" alt="T-shirt" />
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                     <?php if (NASA_ELEMENTOR_ACTIVE) : ?>
                        <div class="demo-homepages-wrap demo-homepages-elm nasa-tab-content">
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-1" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-1.jpg" alt="Fashion 1" />
                                </a>
                            </div>
                            
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-2" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-2.jpg" alt="Fashion 2" />
                                </a>
                            </div>
                            
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-3" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-3.jpg" alt="Fashion 3" />
                                </a>
                            </div>
                            
                            <div class="demo-homepage-item-wrap">
                                <a href="javascript:void(0);" data-home="fashion-5" class="demo-homepage-item">
                                    <img src="<?php echo NASA_CORE_PLUGIN_URL ; ?>admin/assets/pages/fashion-5.jpg" alt="Fashion 5" />
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="processing-demo-data">
                <p class="processing-notice-first"><?php echo esc_html__('Please waiting in a few minutes, The process is running...', 'nasa-core'); ?></p>

                <ul class="processing-steps">
                    <li class="processing-install-child-theme step-first" data-step="1">
                        <?php echo esc_html__('Install Elessi Theme - Child', 'nasa-core'); ?>
                    </li>
                    <li class="processing-data" data-step="2">
                        <?php echo esc_html__('Import Global Data (Media, Posts, Products, Categories...)', 'nasa-core'); ?>
                    </li>
                    <li class="processing-widgets" data-step="3">
                        <?php echo esc_html__('Import Widgets Sidebars', 'nasa-core'); ?>
                    </li>
                    <li class="processing-homepage" data-step="4">
                        <?php echo esc_html__('Import Homes', 'nasa-core'); ?>
                    </li>
                    <li class="processing-theme-options step-end" data-step="5">
                        <?php echo esc_html__('Global Theme Options', 'nasa-core'); ?>
                    </li>
                </ul>

                <p class="processing-notice-last"><a href="<?php echo esc_url(admin_url('options-permalink.php')); ?>"><?php echo esc_html__('COMPLETE - Please go to Dashboard > Settings > Permalinks to Re-built Permalinks your site.', 'nasa-core'); ?></a></p>
            </div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <div class="nasa-dashboard-demo-data">
        <h1 class="demo-data-heading">
            <?php esc_html_e('NasaTheme - Import Demo Data', 'nasa-core') ?>
        </h1>
        
        <p class="imported-notice"><?php echo esc_html__("Demo data was imported. If you want import demo data again, You should need reset data of your site.", 'nasa-core'); ?></p>
        
<?php
endif;
