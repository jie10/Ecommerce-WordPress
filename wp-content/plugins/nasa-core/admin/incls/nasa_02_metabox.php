<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Include and setup custom metaboxes and fields.
 *
 * @category nasa-core
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */
add_filter('cmb_meta_boxes', 'nasa_meta_boxes');

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function nasa_meta_boxes(array $meta_boxes) {
    global $nasa_opt;
    
    // Start with an underscore to hide fields from custom fields list
    $prefix = '_nasa_';
    
    /**
     * Product Categories level 0
     */
    
    $categories = null;
    if (NASA_WOO_ACTIVED) {
        $args = array(
            'taxonomy' => 'product_cat',
            'parent' => 0,
            'hierarchical' => true,
            'hide_empty' => false
        );

        if (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized']) {
            $args['exclude'] = get_option('default_product_cat');
        }
        
        $categories = get_terms(apply_filters('woocommerce_product_attribute_terms', $args));
    }
    
    $categories_options = array('' => esc_html__('Default', 'nasa-core'));
    if (!empty($categories)) {
        foreach ($categories as $value) {
            if ($value) {
                $categories_options[$value->slug] = $value->name;
            }
        }
    }
    
    $attr_image = array(
        "" => esc_html__("Default", 'nasa-core'),
        "round" => esc_html__("Round", 'nasa-core'),
        "square" => esc_html__("Square", 'nasa-core')
    );
    
    
    $custom_fonts = nasa_get_custom_fonts();
    $google_fonts = nasa_get_google_fonts();
    
    $meta_boxes['nasa_metabox_general'] = array(
        'id' => 'nasa_metabox_general',
        'title' => esc_html__('General', 'nasa-core'),
        'pages' => array('page'), // Post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => esc_html__('Custom width this page', 'nasa-core'),
                'id' => $prefix . 'plus_wide_option',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Yes', 'nasa-core'),
                    '-1' => esc_html__('No', 'nasa-core')
                ),
                'default' => '',
                'class' => 'nasa-core-option-parent'
            ),
            
            array(
                "name" => esc_html__("Add more width site (px)", 'nasa-core'),
                "desc" => esc_html__("The max-width your site will be INPUT + 1200 (pixel). Empty will use default theme option", 'nasa-core'),
                "id" => $prefix . "plus_wide_width",
                "default" => "",
                "type" => "text",
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'plus_wide_option core' . $prefix . 'plus_wide_option-1'
            ),
            
            array(
                'name' => esc_html__('Dark Version', 'nasa-core'),
                'id' => $prefix . 'site_bg_dark',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Yes', 'nasa-core'),
                    '-1' => esc_html__('No', 'nasa-core')
                ),
                'default' => ''
            ),
            
            array(
                'name' => esc_html__('Override Logo Mode', 'nasa-core'),
                'desc' => esc_html__('Yes, Please!', 'nasa-core'),
                'id' => $prefix . 'logo_flag',
                'default' => '0',
                'type' => 'checkbox',
                'class' => 'nasa-override-root'
            ),
            
            array(
                'name' => esc_html__('Override Logo', 'nasa-core'),
                'id' => $prefix . 'custom_logo',
                'allow' => false,
                'type' => 'file',
                'class' => 'hidden-tag nasa-override-child ' . $prefix . 'logo_flag'
            ),
            
            array(
                'name' => esc_html__('Override Retina Logo', 'nasa-core'),
                'id' => $prefix . 'custom_logo_retina',
                'allow' => false,
                'type' => 'file',
                'class' => 'hidden-tag nasa-override-child ' . $prefix . 'logo_flag'
            ),
            
            array(
                'name' => esc_html__('Override Sticky Logo', 'nasa-core'),
                'id' => $prefix . 'custom_logo_sticky',
                'allow' => false,
                'type' => 'file',
                'class' => 'hidden-tag nasa-override-child ' . $prefix . 'logo_flag'
            ),
            
            array(
                'name' => esc_html__('Override Mobile Logo', 'nasa-core'),
                'id' => $prefix . 'custom_logo_m',
                'allow' => false,
                'type' => 'file',
                'class' => 'hidden-tag nasa-override-child ' . $prefix . 'logo_flag'
            ),
            
            array(
                'name' => esc_html__('Override Primary Color', 'nasa-core'),
                'desc' => esc_html__('Yes, Please!', 'nasa-core'),
                'id' => $prefix . 'pri_color_flag',
                'default' => '0',
                'type' => 'checkbox',
                'class' => 'nasa-override-root'
            ),
            
            array(
                'name' => esc_html__('Primary color', 'nasa-core'),
                'id' => $prefix . 'pri_color',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'hidden-tag nasa-option-color nasa-override-child ' . $prefix . 'pri_color_flag'
            ),
            
            array(
                'name' => esc_html__('Root Product Category', 'nasa-core'),
                'desc' => esc_html__('Root Product Category. (Use for Multi stores)', 'nasa-core'),
                'id' => $prefix . 'root_category',
                'type' => 'select',
                'options' => $categories_options,
                'default' => '',
                'class' => 'nasa-core-option-parent'
            ),
            
            array(
                'name' => esc_html__('Attribule Image Style', 'nasa-core'),
                'id' => $prefix . 'attr_image_style',
                'type' => 'select',
                'options' => $attr_image,
                'default' => '',
                'class' => 'nasa-core-option-parent'
            ),
            
            array(
                'name' => esc_html__('Loop Product Buttons', 'nasa-core'),
                'id' => $prefix . 'loop_layout_buttons',
                'type' => 'select',
                'options' => array(
                    "" => esc_html__("Default", 'nasa-core'),
                    "ver-buttons" => esc_html__("Vertical Buttons", 'nasa-core'),
                    "hoz-buttons" => esc_html__("Horizontal Buttons", 'nasa-core')
                ),
                'default' => ''
            )
        )
    );
    
    $meta_boxes['nasa_metabox_font'] = array(
        'id' => 'nasa_metabox_font',
        'title' => esc_html__('Font Style', 'nasa-core'),
        'pages' => array('page'), // Post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => esc_html__('Type Font', 'nasa-core'),
                'id' => $prefix . 'type_font_select',
                'type' => 'select',
                'options' => array(
                    "" => esc_html__("Default Font", 'nasa-core'),
                    "custom" => esc_html__("Custom Font", 'nasa-core'),
                    "google" => esc_html__("Google Font", 'nasa-core')
                ),
                'default' => '',
                'class' => 'nasa-core-option-parent'
            ),
            
            array(
                'name' => esc_html__('Headings Font (H1, H2, H3, H4, H5, H6)', 'nasa-core'),
                'id' => $prefix . 'type_headings',
                'type' => 'select',
                'options' => $google_fonts,
                'default' => isset($nasa_opt['type_headings']) ? $nasa_opt['type_headings'] : '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'type_font_select core' . $prefix . 'type_font_select-google'
            ),
            
            array(
                'name' => esc_html__('Texts Font (paragraphs, etc..)', 'nasa-core'),
                'id' => $prefix . 'type_texts',
                'type' => 'select',
                'options' => $google_fonts,
                'default' => isset($nasa_opt['type_texts']) ? $nasa_opt['type_texts'] : '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'type_font_select core' . $prefix . 'type_font_select-google'
            ),
            
            array(
                'name' => esc_html__('Main Navigation Font', 'nasa-core'),
                'id' => $prefix . 'type_nav',
                'type' => 'select',
                'options' => $google_fonts,
                'default' => isset($nasa_opt['type_nav']) ? $nasa_opt['type_nav'] : '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'type_font_select core' . $prefix . 'type_font_select-google'
            ),
            
            array(
                'name' => esc_html__('Banner Font', 'nasa-core'),
                'id' => $prefix . 'type_banner',
                'type' => 'select',
                'options' => $google_fonts,
                'default' => isset($nasa_opt['type_banner']) ? $nasa_opt['type_banner'] : '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'type_font_select core' . $prefix . 'type_font_select-google'
            ),
            
            array(
                'name' => esc_html__('Price Font', 'nasa-core'),
                'id' => $prefix . 'type_price',
                'type' => 'select',
                'options' => $google_fonts,
                'default' => isset($nasa_opt['type_price']) ? $nasa_opt['type_price'] : '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'type_font_select core' . $prefix . 'type_font_select-google'
            ),
            
            array(
                'name' => esc_html__('Custom Font', 'nasa-core'),
                'id' => $prefix . 'custom_font',
                'type' => 'select',
                'options' => $custom_fonts,
                'default' => isset($nasa_opt['custom_font']) ? $nasa_opt['custom_font'] : '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'type_font_select core' . $prefix . 'type_font_select-custom'
            ),
        )
    );
    
    $meta_boxes['nasa_metabox_header'] = array(
        'id' => 'nasa_metabox_header',
        'title' => esc_html__('Header', 'nasa-core'),
        'pages' => array('page'), // Post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => esc_html__('Header Type', 'nasa-core'),
                'id' => $prefix . 'custom_header',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Header Type 1', 'nasa-core'),
                    '2' => esc_html__('Header Type 2', 'nasa-core'),
                    '3' => esc_html__('Header Type 3', 'nasa-core'),
                    '4' => esc_html__('Header Type 4', 'nasa-core'),
                    '5' => esc_html__('Header Type 5', 'nasa-core'),
                    'nasa-custom' => esc_html__('Header Builder', 'nasa-core')
                ),
                'default' => '',
                'class' => 'nasa-core-option-parent'
            ),
            
            array(
                'name' => esc_html__("Sticky", 'nasa-core'),
                'desc' => esc_html__('Header sticky (Not use for Header Builder).', 'nasa-core'),
                'id' => $prefix . 'fixed_nav',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Yes', 'nasa-core'),
                    '-1' => esc_html__('No', 'nasa-core')
                ),
                'default' => ''
            ),
            
            array(
                'name' => esc_html__('Header Builder', 'nasa-core'),
                'id' => $prefix . 'header_builder',
                'type' => 'select',
                'options' => nasa_get_headers_options(),
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-nasa-custom'
            ),
            
            array(
                'name' => esc_html__('Main Menu Fullwidth', 'nasa-core'),
                'id' => $prefix . 'fullwidth_main_menu',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Yes', 'nasa-core'),
                    '-1' => esc_html__('No', 'nasa-core')
                ),
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3 core' . $prefix . 'custom_header-4'
            ),
            
            array(
                "name" => esc_html__("Extra Class Name Header", 'nasa-core'),
                'desc' => esc_html__('Custom add more class name for header page', 'nasa-core'),
                "id" => $prefix . "el_class_header",
                "default" => '',
                "type" => "text",
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-1 core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3'
            ),
            
            array(
                'name' => esc_html__('Header Transparent', 'nasa-core'),
                'id' => $prefix . 'header_transparent',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Yes', 'nasa-core'),
                    '-1' => esc_html__('No', 'nasa-core')
                ),
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-1 core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3'
            ),
            
            array(
                'name' => esc_html__('Block Header', 'nasa-core'),
                'desc' => esc_html__('Add static block to Header', 'nasa-core'),
                'id' => $prefix . 'header_block',
                'type' => 'select',
                'options' => nasa_get_blocks_options(),
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-1 core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3 core' . $prefix . 'custom_header-4'
            ),
            
            array(
                'name' => esc_html__('Toggle Top Bar', 'nasa-core'),
                'id' => $prefix . 'topbar_toggle',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Yes', 'nasa-core'),
                    '2' => esc_html__('No', 'nasa-core')
                ),
                'default' => '',
                'class' => 'nasa-core-option-parent'
            ),
            
            array(
                'name' => esc_html__('Init Show Top Bar', 'nasa-core'),
                'desc' => esc_html__('Show Top Bar When this page loaded', 'nasa-core'),
                'id' => $prefix . 'topbar_default_show',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Yes', 'nasa-core'),
                    '2' => esc_html__('No', 'nasa-core')
                ),
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'topbar_toggle core' . $prefix . 'topbar_toggle-1'
            ),
            
            array(
                'name' => esc_html__('Header Background', 'nasa-core'),
                'id' => $prefix . 'bg_color_header',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'nasa-option-color hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-1 core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3'
            ),
            
            array(
                'name' => esc_html__('Header Text color', 'nasa-core'),
                'desc' => esc_html__('Override Text color items in header', 'nasa-core'),
                'id' => $prefix . 'text_color_header',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'nasa-option-color hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-1 core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3'
            ),
            
            array(
                'name' => esc_html__('Header Text color hover', 'nasa-core'),
                'desc' => esc_html__('Override Text color hover items in header', 'nasa-core'),
                'id' => $prefix . 'text_color_hover_header',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'nasa-option-color hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-1 core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3'
            ),
            
            array(
                'name' => esc_html__('Top Bar Background', 'nasa-core'),
                'id' => $prefix . 'bg_color_topbar',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'nasa-option-color'
            ),
            
            array(
                'name' => esc_html__('Top Bar Text Color', 'nasa-core'),
                'desc' => esc_html__('Override text color items in top bar', 'nasa-core'),
                'id' => $prefix . 'text_color_topbar',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'nasa-option-color'
            ),
            
            array(
                'name' => esc_html__('Top Bar Text Color Hover', 'nasa-core'),
                'desc' => esc_html__('Override Text color hover items in Top bar', 'nasa-core'),
                'id' => $prefix . 'text_color_hover_topbar',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'nasa-option-color'
            ),
            
            array(
                "name" => esc_html__("Vertical Menu", 'nasa-core'),
                "id" => $prefix . "vertical_menu_selected",
                "default" => "",
                "type" => "select",
                "options" => nasa_meta_get_list_menus()
            ),
            
            array(
                "name" => esc_html__("Level 2 Allways Show", 'nasa-core'),
                'desc' => esc_html__('Yes, Please!', 'nasa-core'),
                "id" => $prefix . "vertical_menu_allways_show",
                "default" => '0',
                "type" => "checkbox"
            ),
            
            array(
                'name' => esc_html__('Main Menu Background', 'nasa-core'),
                'desc' => esc_html__('Override background color for Main menu (Only use header type 2)', 'nasa-core'),
                'id' => $prefix . 'bg_color_main_menu',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'nasa-option-color hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3 core' . $prefix . 'custom_header-4'
            ),
            
            array(
                'name' => esc_html__('Main Menu Text color', 'nasa-core'),
                'desc' => esc_html__('Override text color for Main menu', 'nasa-core'),
                'id' => $prefix . 'text_color_main_menu',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'nasa-option-color hidden-tag nasa-core-option-child core' . $prefix . 'custom_header core' . $prefix . 'custom_header-1 core' . $prefix . 'custom_header-2 core' . $prefix . 'custom_header-3 core' . $prefix . 'custom_header-4'
            )
        )
    );
    
    $meta_boxes['nasa_metabox_breadcrumb'] = array(
        'id' => 'nasa_metabox_breadcrumb',
        'title' => esc_html__('Breadcrumb', 'nasa-core'),
        'pages' => array('page'), // Post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => esc_html__('Show Breadcrumb', 'nasa-core'),
                'desc' => esc_html__('Yes, Please!', 'nasa-core'),
                'id' => $prefix . 'show_breadcrumb',
                'default' => '0',
                'type' => 'checkbox',
                'class' => 'nasa-breadcrumb-flag'
            ),
            
            array(
                'name' => esc_html__('Breadcrumb Type', 'nasa-core'),
                'id' => $prefix . 'type_breadcrumb',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__('Default', 'nasa-core'),
                    '1' => esc_html__('Has breadcrumb background', 'nasa-core')
                ),
                'default' => '',
                'class' => 'hidden-tag nasa-breadcrumb-type'
            ),
            
            array(
                'name' => esc_html__('Background Image', 'nasa-core'),
                'id' => $prefix . 'bg_breadcrumb',
                'allow' => false,
                'type' => 'file',
                'class' => 'hidden-tag nasa-breadcrumb-bg'
            ),
            
            array(
                'name' => esc_html__('Background Image - Mobile', 'nasa-core'),
                'id' => $prefix . 'bg_breadcrumb_m',
                'allow' => false,
                'type' => 'file',
                'class' => 'hidden-tag nasa-breadcrumb-bg'
            ),
            
            array(
                'name' => esc_html__('Background Color', 'nasa-core'),
                'id' => $prefix . 'bg_color_breadcrumb',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'hidden-tag nasa-breadcrumb-bg-color'
            ),
            
            array(
                'name' => esc_html__('Text Color', 'nasa-core'),
                'id' => $prefix . 'color_breadcrumb',
                'type' => 'colorpicker',
                'default' => '',
                'class' => 'hidden-tag nasa-breadcrumb-color'
            ),
            
            array(
                'name' => esc_html__('Height (px)', 'nasa-core'),
                'id' => $prefix . 'height_breadcrumb',
                'type' => 'text',
                'default' => '',
                'class' => 'hidden-tag nasa-breadcrumb-height'
            ),
            
            array(
                'name' => esc_html__('Height - Mobile (px)', 'nasa-core'),
                'id' => $prefix . 'height_breadcrumb_m',
                'type' => 'text',
                'default' => '',
                'class' => 'hidden-tag nasa-breadcrumb-height'
            ),
        )
    );
    
    /* Get Footers style */
    $footers_option = nasa_get_footers_options();
    $footers_desk = $footers_option;
    if (isset($footers_desk[''])) {
        unset($footers_desk['']);
    }
    
    $footers_e = nasa_get_footers_elementor();
    
    $modes = array(
        '' => esc_html__('Default', 'nasa-core'),
        "build-in" => esc_html__("Build-in", 'nasa-core'),
        "builder" => esc_html__("Builder", 'nasa-core')
    );
    if (NASA_ELEMENTOR_ACTIVE && NASA_HF_BUILDER) {
        $modes["builder-e"] = esc_html__("Elementor Builder", 'nasa-core');
    }
    $meta_boxes['nasa_metabox_footer'] = array(
        'id' => 'nasa_metabox_footer',
        'title' => esc_html__('Footer', 'nasa-core'),
        'pages' => array('page'), // Post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => esc_html__('Footer Mode', 'nasa-core'),
                'id' => $prefix . 'footer_mode',
                'type' => 'select',
                'options' => $modes,
                'default' => '',
                'class' => 'nasa-core-option-parent'
            ),
            
            array(
                'name' => esc_html__('Footer Build-in', 'nasa-core'),
                'id' => $prefix . 'footer_build_in',
                'type' => 'select',
                'options' => array(
                    '1' => esc_html__("Build-in Light 1", 'nasa-core'),
                    '2' => esc_html__("Build-in Light 2", 'nasa-core'),
                    '3' => esc_html__("Build-in Light 3", 'nasa-core'),
                    '4' => esc_html__("Build-in Dark", 'nasa-core')
                ),
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'footer_mode core' . $prefix . 'footer_mode-build-in'
            ),
            
            array(
                'name' => esc_html__('Footer Build-in Mobile', 'nasa-core'),
                'id' => $prefix . 'footer_build_in_mobile',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__("Extends from Desktop", 'nasa-core'),
                    'm-1' => esc_html__("Build-in Mobile", 'nasa-core')
                ),
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'footer_mode core' . $prefix . 'footer_mode-build-in'
            ),
            
            array(
                'name' => esc_html__('Footer Builder', 'nasa-core'),
                'id' => $prefix . 'custom_footer',
                'type' => 'select',
                'options' => $footers_desk,
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'footer_mode core' . $prefix . 'footer_mode-builder'
            ),
            
            array(
                'name' => esc_html__('Footer Builder Mobile', 'nasa-core'),
                'id' => $prefix . 'custom_footer_mobile',
                'type' => 'select',
                'options' => $footers_option,
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'footer_mode core' . $prefix . 'footer_mode-builder'
            ),
            
            array(
                'name' => esc_html__('Elementor Builder', 'nasa-core'),
                'id' => $prefix . 'footer_builder_e',
                'type' => 'select',
                'options' => $footers_e,
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'footer_mode core' . $prefix . 'footer_mode-builder-e'
            ),
            
            array(
                'name' => esc_html__('Elementor Builder - Mobile', 'nasa-core'),
                'id' => $prefix . 'footer_builder_e_mobile',
                'type' => 'select',
                'options' => $footers_e,
                'default' => '',
                'class' => 'hidden-tag nasa-core-option-child core' . $prefix . 'footer_mode core' . $prefix . 'footer_mode-builder-e'
            )
        )
    );

    return apply_filters('nasa_page_options', $meta_boxes);
}

/**
 * Initialize the metabox class.
 */
add_action('init', 'nasa_init_meta_boxes');
function nasa_init_meta_boxes() {
    if (!class_exists('cmb_Meta_Box')){
        require_once NASA_CORE_PLUGIN_PATH . 'admin/metabox/init.php';
    }
}
