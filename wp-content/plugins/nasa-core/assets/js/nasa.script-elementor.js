/**
 * Document nasa-core Elementor Preview ready
 */
jQuery(document).ready(function($) {
"use strict";

setInterval(function() {
    loading_slick_element($);
    loading_slick_vertical_categories($);
    loading_slick_extra_vertical_thumbs($);
    loading_slick_simple_item($);
    
    nasa_render_tags_cloud($);
    load_count_down($);
    
    nasa_height_fullwidth_to_side($);
    
    nasa_init_select2($);
    
    $('body').trigger('nasa_init_pins_banners');
    $('body').trigger('nasa_init_metro_products');
    $('body').trigger('nasa_layout_metro_products');
    $('body').trigger('nasa_init_compare_images');
    $('body').trigger('nasa_init_elementor_events');
}, 2000);
/* =========== End Document nasa-core Elementor Preview ready ==================== */
});
