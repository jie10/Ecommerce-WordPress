<?php
add_action('init', 'elessi_backup_options_heading', 9999);
if (!function_exists('elessi_backup_options_heading')) {
    function elessi_backup_options_heading() {
        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Backup and Import", 'elessi-theme'),
            "target" => "backup-import",
            "type" => "heading",
        );

        $of_options[] = array(
            "name" => esc_html__("Backup and Restore Options", 'elessi-theme'),
            "id" => "of_backup",
            "std" => "",
            "type" => "backup",
            "desc" => esc_html__('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'elessi-theme'),
        );

        $of_options[] = array(
            "name" => esc_html__("Transfer Theme Options Data", 'elessi-theme'),
            "id" => "of_transfer",
            "std" => "",
            "type" => "transfer",
            "desc" => esc_html__('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'elessi-theme'),
        );
    }
}
