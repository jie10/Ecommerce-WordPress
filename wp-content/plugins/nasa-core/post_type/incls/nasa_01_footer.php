<?php
/**
 * Post type footer
 */
add_action('init', 'nasa_register_footer');
function nasa_register_footer() {
    $labels = array(
        'name' => esc_html__('Footer', 'nasa-core'),
        'singular_name' => esc_html__('Footer', 'nasa-core'),
        'add_new' => esc_html__('Add New Footer', 'nasa-core'),
        'add_new_item' => esc_html__('Add New Footer', 'nasa-core'),
        'edit_item' => esc_html__('Edit Footer', 'nasa-core'),
        'new_item' => esc_html__('New Footer', 'nasa-core'),
        'view_item' => esc_html__('View Footer', 'nasa-core'),
        'search_items' => esc_html__('Search Footers', 'nasa-core'),
        'not_found' => esc_html__('No Footers found', 'nasa-core'),
        'not_found_in_trash' => esc_html__('No Footers found in Trash', 'nasa-core'),
        'parent_item_colon' => esc_html__('Parent Footer:', 'nasa-core'),
        'menu_name' => esc_html__('Footer Builder', 'nasa-core'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => esc_html__('List Footer', 'nasa-core'),
        'supports' => array('title', 'editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'menu_icon' => 'dashicons-editor-underline'
    );
    register_post_type('footer', $args);

    if ($options = get_option('wpb_js_content_types')) {
        $check = true;
        foreach ($options as $value) {
            if ($value == 'footer') {
                $check = false;
                break;
            }
        }
        if ($check) {
            $options[] = 'footer';
        }
    } else {
        $options = array('page', 'footer');
    }
    update_option('wpb_js_content_types', $options);
}
