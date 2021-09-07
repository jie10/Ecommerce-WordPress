<?php
/**
 * Post type header
 */
add_action('init', 'nasa_register_header');
function nasa_register_header() {
    $labels = array(
        'name' => esc_html__('Header', 'nasa-core'),
        'singular_name' => esc_html__('Header', 'nasa-core'),
        'add_new' => esc_html__('Add New Header', 'nasa-core'),
        'add_new_item' => esc_html__('Add New Header', 'nasa-core'),
        'edit_item' => esc_html__('Edit Header', 'nasa-core'),
        'new_item' => esc_html__('New Header', 'nasa-core'),
        'view_item' => esc_html__('View Header', 'nasa-core'),
        'search_items' => esc_html__('Search Header', 'nasa-core'),
        'not_found' => esc_html__('No Headers found', 'nasa-core'),
        'not_found_in_trash' => esc_html__('No Header found in Trash', 'nasa-core'),
        'parent_item_colon' => esc_html__('Parent Header:', 'nasa-core'),
        'menu_name' => esc_html__('Header Builder', 'nasa-core'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => esc_html__('List Headers', 'nasa-core'),
        'supports' => array('title', 'editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 4,
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'menu_icon' => 'dashicons-editor-table'
    );
    register_post_type('header', $args);

    if ($options = get_option('wpb_js_content_types')) {
        $check = true;
        foreach ($options as $value) {
            if ($value == 'header') {
                $check = false;
                break;
            }
        }
        if ($check) {
            $options[] = 'header';
        }
    } else {
        $options = array('page', 'header');
    }
    update_option('wpb_js_content_types', $options);
}
