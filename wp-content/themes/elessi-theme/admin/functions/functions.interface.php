<?php

/**
 * SMOF Interface
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */

/**
 * Admin Init
 *
 * @uses wp_verify_nonce()
 * @uses header()
 *
 * @since 1.0.0
 */
function optionsframework_admin_init() {
    // Rev up the Options Machine
    global $of_options, $options_machine, $smof_data, $smof_details;
    if (!isset($options_machine)) {
        $options_machine = new Options_Machine($of_options);
    }

    do_action('optionsframework_admin_init_before', array(
        'of_options' => $of_options,
        'options_machine' => $options_machine,
        'smof_data' => $smof_data
    ));

    if (empty($smof_data['smof_init'])) { // Let's set the values if the theme's already been active
        of_save_options($options_machine->Defaults);
        of_save_options(date('r'), 'smof_init');
        $smof_data = of_get_options();
        $options_machine = new Options_Machine($of_options);
    }

    do_action('optionsframework_admin_init_after', array(
        'of_options' => $of_options,
        'options_machine' => $options_machine,
        'smof_data' => $smof_data
    ));
}

/**
 * Create Options page
 *
 * @uses add_theme_page()
 * @uses add_action()
 *
 * @since 1.0.0
 */
function optionsframework_add_admin() {
    $titleOption = esc_html__('NasaTheme Options', 'elessi-theme');
    $of_page = add_theme_page(ELESSI_ADMIN_THEMENAME, $titleOption, 'edit_theme_options', 'optionsframework', 'optionsframework_options_page');

    // Add framework functionaily to the head individually
    add_action("admin_print_scripts-$of_page", 'of_load_only');
    add_action("admin_print_styles-$of_page", 'of_style_only');
}

/**
 * Build Options page
 *
 * @since 1.0.0
 */
function optionsframework_options_page() {

    global $options_machine;
    include_once ELESSI_ADMIN_PATH . 'front-end/options.php';
}

/**
 * Create Options page
 *
 * @uses wp_enqueue_style()
 *
 * @since 1.0.0
 */
function of_style_only() {
    wp_enqueue_style('nasa-theme-admin-style', ELESSI_ADMIN_DIR_URI . 'assets/css/admin-style.css');
    wp_enqueue_style('jquery-ui-custom-admin', ELESSI_ADMIN_DIR_URI . 'assets/css/jquery-ui-custom.css');

    if (!wp_style_is('wp-color-picker', 'registered')) {
        wp_register_style('wp-color-picker', ELESSI_ADMIN_DIR_URI . 'assets/css/color-picker.min.css');
    }
    wp_enqueue_style('wp-color-picker');
    do_action('of_style_only_after');
}

/**
 * Create Options page
 *
 * @uses add_action()
 * @uses wp_enqueue_script()
 *
 * @since 1.0.0
 */
function of_load_only() {
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('jquery-ui-slider');
    // wp_enqueue_script('modernizr', ELESSI_ADMIN_DIR_URI . 'assets/js/modernizr.js', array('jquery'));
    wp_enqueue_script('jquery-input-mask', ELESSI_ADMIN_DIR_URI . 'assets/js/jquery.maskedinput-1.2.2.js', array('jquery'));
    // wp_enqueue_script('tipsy', ELESSI_ADMIN_DIR_URI . 'assets/js/jquery.tipsy.js', array('jquery'));
    wp_enqueue_script('cookie', ELESSI_ADMIN_DIR_URI . 'assets/js/cookie.js', array('jquery'));
    wp_enqueue_script('smof', ELESSI_ADMIN_DIR_URI . 'assets/js/smof.js', array('jquery'));


    // Enqueue colorpicker scripts for versions below 3.5 for compatibility
//    if (!wp_script_is('wp-color-picker', 'registered')) {
//        wp_register_script('iris', ELESSI_ADMIN_DIR_URI . 'assets/js/iris.min.js', array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), false, 1);
//        wp_register_script('wp-color-picker', ELESSI_ADMIN_DIR_URI . 'assets/js/color-picker.min.js', array('jquery', 'iris'));
//    }
    // wp_enqueue_script('wp-color-picker');

    /**
     * Enqueue scripts for file uploader
     */
    if (function_exists('wp_enqueue_media')) {
        wp_enqueue_media();
    }

    do_action('of_load_only_after');
}

/**
 * Ajax Save Options
 *
 * @uses get_option()
 *
 * @since 1.0.0
 */
function of_ajax_callback() {
    global $options_machine, $of_options;

    $nonce = $_POST['security'];

    if (!wp_verify_nonce($nonce, 'of_ajax_nonce')) {
        die('-1');
    }

    //get options array from db
    $all = of_get_options();

    $save_type = $_POST['type'];

    switch ($save_type) {
        case 'upload':
            $clickedID = $_POST['data']; // Acts as the name
            $filename = $_FILES[$clickedID];
            $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

            $override['test_form'] = false;
            $override['action'] = 'wp_handle_upload';
            $uploaded_file = wp_handle_upload($filename, $override);

            // $upload_tracking[] = $clickedID;

            // update $options array w/ image URL
            // preserve current data
            $upload_image = $all;

            $upload_image[$clickedID] = $uploaded_file['url'];
            of_save_options($upload_image);
            
            // Is the Response
            echo !empty($uploaded_file['error']) ? 
                'Upload Error: ' . $uploaded_file['error'] : $uploaded_file['url'];
            break;
        
        case 'image_reset':
            $id = $_POST['data']; // Acts as the name

            $delete_image = $all; //preserve rest of data
            $delete_image[$id] = ''; //update array key with empty value	 
            of_save_options($delete_image);
            break;
        
        case 'backup_options':
            $backup = $all;
            $backup['backup_log'] = date('r');

            of_save_options($backup, ELESSI_ADMIN_BACKUPS);
            nasa_theme_rebuilt_css_dynamic();
            elessi_save_option_woo_customize();
            
            die('1');
            break;
        
        case 'restore_options':
            $smof_data = of_get_options(ELESSI_ADMIN_BACKUPS);
            of_save_options($smof_data);
            nasa_theme_rebuilt_css_dynamic();
            elessi_save_option_woo_customize();
            
            die('1');
            break;
        
        case 'import_options':
            $smof_data = json_decode($_POST['data'], true);
            of_save_options($smof_data);
            nasa_theme_rebuilt_css_dynamic();
            elessi_save_option_woo_customize();
            
            die('1');
            break;
        
        case 'save':
            wp_parse_str(stripslashes($_POST['data']), $smof_data);
            unset($smof_data['security']);
            unset($smof_data['of_save']);
            of_save_options($smof_data);
            nasa_theme_rebuilt_css_dynamic();
            elessi_save_option_woo_customize();

            die('1');
            break;
        
        case 'reset':
            of_save_options($options_machine->Defaults);
            nasa_theme_rebuilt_css_dynamic();
            elessi_save_option_woo_customize();
            
            die('1'); //options reset
            break;
        
        default:
            die();
    }
}

/**
 * Rebuilt dynamic style site
 * @global type $wp_filesystem
 */
function nasa_theme_rebuilt_css_dynamic() {
    global $wp_filesystem, $nasa_upload_dir;
    
    if (!isset($nasa_upload_dir)) {
        $nasa_upload_dir = wp_upload_dir();
        $GLOBALS['nasa_upload_dir'] = $nasa_upload_dir;
    }
    
    $dynamic_path = $nasa_upload_dir['basedir'] . '/nasa-dynamic';
    
    // Initialize the WP filesystem, no more using 'file-put-contents' function
    if (empty($wp_filesystem)) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }
            
    if (!$wp_filesystem->is_dir($dynamic_path)) {
        if (!wp_mkdir_p($dynamic_path)){
            return true;
        }
    }
    // get the upload directory and make a dynamic.css file
    $filename = $dynamic_path . '/dynamic.css';
    
    $data = get_theme_mods();
    $css = elessi_get_content_custom_css($data);
    if (!defined('FS_CHMOD_FILE')) {
        define('FS_CHMOD_FILE', (fileperms(ABSPATH . 'index.php') & 0777 | 0644));
    }
    if (!$wp_filesystem->put_contents($filename, $css, FS_CHMOD_FILE)) {
        return true;
    }
    
    set_theme_mod('nasa_dynamic_t', NASA_TIME_NOW);
    
    return false;
}

/**
 * Save Woo Customize
 * @return type
 */
function elessi_save_option_woo_customize() {
    if (!NASA_WOO_ACTIVED) {
        return;
    }
    $columns = get_option('woocommerce_catalog_columns', 4);
    
    $data = get_theme_mods();
    if (isset($data['products_per_row']) && (int) $data['products_per_row'] != $columns) {
        update_option('woocommerce_catalog_columns', (int) $data['products_per_row']);
    }
}

/**
 * After save Customize sync theme options
 */
add_action('customize_save_after', 'elessi_sync_option_theme');
function elessi_sync_option_theme() {
    if (!NASA_WOO_ACTIVED) {
        return;
    }
    $columns = get_option('woocommerce_catalog_columns', 4);
    $data = get_theme_mods();
    if (!isset($data['products_per_row']) || (int) $data['products_per_row'] != $columns) {
        set_theme_mod('products_per_row', $columns . '-cols');
    }
}
