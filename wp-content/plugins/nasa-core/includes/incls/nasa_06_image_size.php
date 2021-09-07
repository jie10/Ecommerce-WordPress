<?php
defined('ABSPATH') or die(); // Exit if accessed directly

// Custom image size
add_image_size('380x380', 380, 380, true);
add_image_size('480x900', 480, 900, true);
add_image_size('280x150', 280, 150, true);
add_image_size('590x320', 590, 320, true);
add_image_size('nasa-medium', 450, '', false);
add_image_size('nasa-large', 595, '', false);

// Remove SRCSET imgs
// add_action('init', 'nasa_remove_srcset_img');
function nasa_remove_srcset_img() {
    add_filter('wp_calculate_image_srcset', '__return_false');
}

/**
 * CDN For Images site - SRC
 */
function nasa_cdn_attachment_url($url) {
    global $nasa_opt;
    
    if ($url && isset($nasa_opt['enable_nasa_cdn_images']) && $nasa_opt['enable_nasa_cdn_images'] && isset($nasa_opt['nasa_cname_images']) && trim($nasa_opt['nasa_cname_images']) !== '') {
        $url = str_replace(site_url(), $nasa_opt['nasa_cname_images'], $url);
    }
    
    return $url;
}

/**
 * CDN For Images site - SRCSET
 */
function nasa_cdn_attachment_image_srcset($sources) {
    global $nasa_opt;

    if ($sources && isset($nasa_opt['enable_nasa_cdn_images']) && $nasa_opt['enable_nasa_cdn_images'] && isset($nasa_opt['nasa_cname_images']) && trim($nasa_opt['nasa_cname_images']) !== '') {
        $siteUrl = site_url();
        foreach ($sources as $key => $source) {
            if (isset($sources[$key]['url'])) {
                $sources[$key]['url'] = str_replace($siteUrl, $nasa_opt['nasa_cname_images'], $sources[$key]['url']);
            }
        }
    }

    return $sources;
}

/**
 * Check In Admin ?
 */
if (!NASA_CORE_IN_ADMIN) {
    add_filter('wp_get_attachment_url', 'nasa_cdn_attachment_url');
    add_filter('wp_calculate_image_srcset', 'nasa_cdn_attachment_image_srcset');
}
