<?php
/**
 * Post type nasa_pin_pb
 */
add_action('init', 'nasa_register_pin_products_banner');
function nasa_register_pin_products_banner() {
    $labels = array(
        'name' => esc_html__('Pin products banner', 'nasa-core'),
        'singular_name' => esc_html__('Pin products banner', 'nasa-core'),
        'add_new' => esc_html__('Add New', 'nasa-core'),
        'add_new_item' => esc_html__('Add New', 'nasa-core'),
        'edit_item' => esc_html__('Edit', 'nasa-core'),
        'new_item' => esc_html__('New', 'nasa-core'),
        'view_item' => esc_html__('View', 'nasa-core'),
        'search_items' => esc_html__('Search', 'nasa-core'),
        'not_found' => esc_html__('No items found', 'nasa-core'),
        'not_found_in_trash' => esc_html__('No items found in Trash', 'nasa-core'),
        'parent_item_colon' => esc_html__('Parent Item:', 'nasa-core'),
        'menu_name' => esc_html__('Banner Products', 'nasa-core')
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => esc_html__('List items', 'nasa-core'),
        'supports' => array('title'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 8,
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'rewrite' => false,
        'menu_icon' => 'dashicons-location-alt'
    );
    register_post_type('nasa_pin_pb', $args);

    if ($options = get_option('wpb_js_content_types')) {
        $check = true;
        foreach ($options as $key => $value) {
            if ($value == 'nasa_pin_pb') {
                $check = false;
                break;
            }
        }
        if ($check) {
            $options[] = 'nasa_pin_pb';
        }
    } else {
        $options = array('page', 'nasa_pin_pb');
    }
    update_option('wpb_js_content_types', $options);
}
