<?php
defined('ABSPATH') or die(); // Exit if accessed directly
/**
 * Get term description
 * 
 * Outdate from 2.1.4
 */
if (!function_exists('elessi_term_description')) :
    function elessi_term_description($term_id, $type_taxonomy) {
        if (!NASA_WOO_ACTIVED) {
            return '';
        }
        
        if ((int) $term_id < 1) {
            $shop_page = get_post(wc_get_page_id('shop'));
            $desc = $shop_page ? wc_format_content($shop_page->post_content) : '';
        } else {
            $term = get_term($term_id, $type_taxonomy);
            $desc = isset($term->description) ? $term->description : '';
        }
        
        return trim($desc) != '' ? '<div class="page-description">' . do_shortcode($desc) . '</div>' : '';
    }
endif;

/**
 * Get cat header content
 * 
 * Outdate from 2.1.4
 */
if (!function_exists('elessi_get_cat_header')):
    function elessi_get_cat_header($catId = null) {
        global $nasa_opt;
        
        if (isset($nasa_opt['enable_cat_header']) && $nasa_opt['enable_cat_header'] != '1') {
            return '';
        }

        $content = '<div class="cat-header nasa-cat-header padding-top-20">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $shortcode = function_exists('get_term_meta') ? get_term_meta($catId, 'cat_header', false) : get_woocommerce_term_meta($catId, 'cat_header', false);
            $do_content = isset($shortcode[0]) ? do_shortcode($shortcode[0]) : '';
        }

        if (trim($do_content) === '') {
            if (isset($nasa_opt['cat_header']) && $nasa_opt['cat_header'] != '') {
                $do_content = do_shortcode($nasa_opt['cat_header']);
            }
        }

        if (trim($do_content) === '') {
            return '';
        }

        $content .= $do_content . '</div>';

        return $content;
    }
endif;

/**
 * Deprecated
 * 
 * Language Flags
 */
if (!function_exists('elessi_language_flages')) :
    function elessi_language_flages() {
        global $nasa_opt;
        
        if (!isset($nasa_opt['switch_lang']) || $nasa_opt['switch_lang'] != 1) {
            return;
        }
        
        $language_output = '<div class="nasa-select-languages">';
        $mainLang = '';
        $selectLang = '<ul class="nasa-list-languages">';
        
        if (function_exists('icl_get_languages')) {
            $current = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : get_option('WPLANG');
            
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            if (!empty($languages)) {
                foreach ($languages as $lang) {
                    
                    /**
                     * Current Language
                     */
                    if ($current == $lang['language_code']) {
                        $mainLang .= '<a href="javascript:void(0);" class="nasa-current-lang" rel="nofollow">';
                        
                        if (isset($lang['country_flag_url'])) {
                            $mainLang .= '<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang['native_name']) . '" />';
                        }
                        
                        $mainLang .= $lang['native_name'];
                        $mainLang .= '</a>';
                    }
                    
                    /**
                     * Select Languages
                     */
                    else {
                        $selectLang .= '<li class="nasa-item-lang"><a href="' . esc_url($lang['url']) . '" title="' . esc_attr($lang['native_name']) . '" rel="nofollow">';

                        if (isset($lang['country_flag_url'])) {
                            $selectLang .= '<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang['native_name']) . '" />';
                        }

                        $selectLang .= $lang['native_name'];
                        $selectLang .= '</a></li>';
                    }
                }
            }
        }
        
        /**
         * have not installs WPML
         */
        else {
            $mainLang .= '<a href="javascript:void(0);" class="nasa-current-lang" rel="nofollow">';
            $mainLang .= '<img src="' . esc_url(ELESSI_THEME_URI . '/assets/images/en.png') . '" alt="' . esc_attr__('English', 'elessi-theme') . '" />';
            $mainLang .= esc_html__('Requires WPML', 'elessi-theme');
            $mainLang .= '</a>';
            
            /**
             * Select Languages
             */
            // English
            $selectLang .= '<li class="nasa-item-lang"><a href="#" title="' . esc_attr__('English', 'elessi-theme') . '">';
            $selectLang .= '<img src="' . esc_url(ELESSI_THEME_URI . '/assets/images/en.png') . '" alt="' . esc_attr__('English', 'elessi-theme') . '" />';

            $selectLang .= esc_html__('English', 'elessi-theme');
            $selectLang .= '</a></li>';
            
            // German
            $selectLang .= '<li class="nasa-item-lang"><a href="#" title="' . esc_attr__('Deutsch', 'elessi-theme') . '">';
            $selectLang .= '<img src="' . esc_url(ELESSI_THEME_URI . '/assets/images/de.png') . '" alt="' . esc_attr__('Deutsch', 'elessi-theme') . '" />';

            $selectLang .= esc_html__('Deutsch', 'elessi-theme');
            $selectLang .= '</a></li>';
            
            // French
            $selectLang .= '<li class="nasa-item-lang"><a href="#" title="' . esc_attr__('Français', 'elessi-theme') . '">';
            $selectLang .= '<img src="' . esc_url(ELESSI_THEME_URI . '/assets/images/fr.png') . '" alt="' . esc_attr__('Français', 'elessi-theme') . '" />';

            $selectLang .= esc_html__('Français', 'elessi-theme');
            $selectLang .= '</a></li>';
        }
        
        $selectLang .= '</ul>';
        
        $language_output .= $mainLang . $selectLang . '</div>';

        echo '<ul class="header-switch-languages left rtl-right desktop-margin-right-30 rtl-desktop-margin-right-0 rtl-desktop-margin-left-30"><li>' . $language_output . '</li></ul>';
    }
endif;

/**
 * Change elessi_product_video_btn_function => elessi_product_video_btn
 */
if (function_exists('elessi_product_video_btn_function')) {
    remove_action('nasa_single_buttons', 'elessi_product_video_btn', 25);
    add_action('nasa_single_buttons', 'elessi_product_video_btn_function', 25);
}

/**
 * Change elessi_footer_layout_style_function => elessi_footer_layout
 */
if (function_exists('elessi_footer_layout_style_function')) {
    remove_action('nasa_footer_layout_style', 'elessi_footer_output');
    add_action('nasa_footer_layout_style', 'elessi_footer_layout_style_function');
}

/**
 * Change elessi_get_custom_field_value => elessi_get_product_meta_value
 */
if (!function_exists('elessi_get_custom_field_value')) :
    function elessi_get_custom_field_value($post_id, $field_id) {
        return elessi_get_product_meta_value($post_id, $field_id);
    }
endif;
