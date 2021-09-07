<div class="wrap" id="of_container">

    <div id="of-popup-save" class="of-save-popup">
        <div class="of-save-save"><?php echo esc_html__("Options Updated", 'elessi-theme'); ?></div>
    </div>

    <div id="of-popup-reset" class="of-save-popup">
        <div class="of-save-reset"><?php echo esc_html__("Options Reset", 'elessi-theme'); ?></div>
    </div>

    <div id="of-popup-fail" class="of-save-popup">
        <div class="of-save-fail"><?php echo esc_html__("Error!", 'elessi-theme'); ?></div>
    </div>

    <span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
    <input type="hidden" id="reset" value="<?php echo isset($_REQUEST['reset']) ? esc_attr($_REQUEST['reset']) : ''; ?>" />
    <input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />

    <form id="of_form" method="post" action="" enctype="multipart/form-data">
        <h2 style="display: none;"><?php esc_html_e('Theme Options', 'elessi-theme'); ?></h2>

        <div class="running-import">
            <div class="bg-success"></div>
            <span class="result-import"><span class="success-import">0</span>%</span>
        </div>

        <div class="mess-reponse-import"></div>

        <div class="updated error importer-notice importer-notice-1" style="display: none;"><p><strong><?php echo sprintf(esc_html__('Seems like an error has occured. Please double check the imported data. If incorrect, please use %s and try again', 'elessi-theme'), '<a href="' . admin_url('plugin-install.php?tab=plugin-information&amp;plugin=wordpress-reset&amp;TB_iframe=true&amp;width=830&amp;height=472') . '" class="thickbox" title="' . esc_attr__('Reset WordPress plugin', 'elessi-theme') . '">' . esc_html__('Reset WordPress plugin', 'elessi-theme') . '</a>'); ?> </strong></p></div>

        <div class="updated importer-notice importer-notice-2" style="display: none;"><p><strong><?php echo sprintf(esc_html__('Demo data successfully imported. Please refresh your site and Click Save All Changes NasaTheme options.', 'elessi-theme')); ?></strong></p></div>

        <div class="updated error importer-notice importer-notice-3" style="display: none;"><p><strong><?php esc_html_e('Sorry but your import failed. Most likely, it cannot work with your webhost. You will have to ask your webhost to increase your PHP max_execution_time (or any other webserver timeout to at least 300 secs) and memory_limit (to at least 196M) temporarily.', 'elessi-theme'); ?></strong></p></div>

        <div id="header">
            <div class="logo">
                <h2>
                    <?php esc_html_e('Elessi Theme Options', 'elessi-theme'); ?>
                    <a href="<?php echo esc_url(ELESSI_ADMIN_SUPPORT_FORUMS); ?>" target="_blank" style="text-decoration: none; margin-left: 10px;">
                        <?php esc_html_e('Click Here To View Online Documentation', 'elessi-theme'); ?>
                    </a>
                </h2>
            </div>
            
            <div id="js-warning"><?php echo esc_html__("Warning- This options panel will not work properly without javascript!", 'elessi-theme'); ?></div>
            <div class="icon-option"></div>
            <div class="clear"></div>
        </div>

        <div id="info_bar">
            <a href="javascript:void(0);" id="expand_options" class="expand"></a>

            <img style="display:none" src="<?php echo ELESSI_ADMIN_DIR_URI; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php echo esc_attr__("Working...", 'elessi-theme'); ?>" />

            <button type="button" class="button-primary nasa-of_save">
                <?php esc_html_e('Save All Changes', 'elessi-theme'); ?>
            </button>

        </div><!--.info_bar--> 	

        <div id="main">

            <div id="of-nav">
                <ul>
                    <?php echo ($options_machine->Menu); ?>
                </ul>
            </div>

            <div id="content">
                <?php echo ($options_machine->Inputs); /* Settings */ ?>
            </div>

            <div class="clear"></div>

        </div>

        <div class="save_bar">
            <img style="display:none" src="<?php echo ELESSI_ADMIN_DIR_URI; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php esc_attr_e('Working...', 'elessi-theme'); ?>" />
            <button type="button" class="button-primary nasa-of_save"><?php esc_html_e('Save All Changes', 'elessi-theme'); ?></button>			
            <button id ="of_reset" type="button" class="button submit-button reset-button"><?php esc_html_e('Options Reset', 'elessi-theme'); ?></button>
            <img style="display:none" src="<?php echo ELESSI_ADMIN_DIR_URI; ?>assets/images/loading-bottom.gif" class="ajax-reset-loading-img ajax-loading-img-bottom" alt="<?php esc_attr_e('Working...', 'elessi-theme'); ?>" />

        </div><!--.save_bar--> 

    </form>

</div><!--wrap-->
