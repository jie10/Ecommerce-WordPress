<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Admin Pin Products Banner
 */
add_action('admin_head', 'nasa_pin_products_banner_scripts');
function nasa_pin_products_banner_scripts() {
    global $typenow;
    if ('nasa_pin_pb' == $typenow) {
        ?>
        <script>
            jQuery(document).ready(function ($) {
                <?php if (isset($_GET["post"]) && $_GET["post"]): ?>
                    var item_slug = $('input#nasa_pin_slug').val();
                    if ($('#original_post_status').val() === 'publish') {
                        $('#submitpost #minor-publishing').append('<div class="misc-pub-section shortcode-info"><span><i class="fa fa-code" style="font-size: 1.2em; margin-right: 5px;"></i> Shortcode: <b>[nasa_pin_products_banner pin_slug="' + item_slug + '" marker_style="price|plus"]</b></span></div>');
                    }
                <?php endif; ?>
                if ($('#posts-filter').length) {
                    if ($('input[name="post_status"]').val() !== 'trash') {
                        $('#posts-filter table.wp-list-table thead tr').append('<td scope="col" id="shortcode" class="manage-column" style="width: 170px;"><span>Shortcode</span></td>');
                        $('#posts-filter table.wp-list-table tfoot tr').append('<td scope="col" id="shortcode" class="manage-column"><span>Shortcode</span></td>');

                        $('#posts-filter table.wp-list-table tbody tr').each(function () {
                            if ($(this).hasClass('status-publish')) {
                                var _post_slug = $(this).find('.post_name').html();
                                $(this).append('<td data-colname="Shortcode"><b>[nasa_pin_products_banner pin_slug="' + _post_slug + '"]</b></td>');
                            } else {
                                $(this).append('<td></td>');
                            }
                        });
                    }
                }
            });
        </script>
        <?php
    }
}

// Script nasa-core
add_action('admin_enqueue_scripts', 'nasa_pin_pb_scripts_libs', 15);
function nasa_pin_pb_scripts_libs() {
    global $pagenow, $post_type, $post;
    // Get current post type.
    if (!isset($post_type)) {
        $post_type = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : null;
    }

    if (empty($post_type) && (isset($post) || isset($_REQUEST['post']))) {
        $post_type = isset($post) ? $post->post_type : get_post_type($_REQUEST['post']);
    }
    
    if ('nasa_pin_pb' == $post_type) {
        if (in_array($pagenow, array('post.php', 'post-new.php'))) {
            if (!isset($_REQUEST['action']) || 'trash' != $_REQUEST['action']) {
                wp_enqueue_script('nasa_pin_easing', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.easing.min.js');
                wp_enqueue_script('nasa_pin_easypin', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.easypin.min.js');

                wp_dequeue_script('select2');
                wp_dequeue_style('select2');
                wp_enqueue_style('nasa-select2', NASA_CORE_PLUGIN_URL . 'admin/assets/select2/select2.min.css');
                wp_enqueue_script('nasa-select2', NASA_CORE_PLUGIN_URL . 'admin/assets/select2/select2.min.js');
            }
        }
    }
}

add_action('init', 'init_nasa_pin_pb');
function init_nasa_pin_pb() {
    add_action('admin_footer', 'nasa_pin_pb_admin_editor');
    add_action('save_post_nasa_pin_pb', 'nasa_pin_pb_admin_save_post');
}

function nasa_pin_pb_admin_editor() {
    global $pagenow, $post_type, $post;

    // Get current post type.
    if (!isset($post_type)) {
        $post_type = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : null;
    }

    if (empty($post_type) && (isset($post) || isset($_REQUEST['post']))) {
        $post_type = isset($post) ? $post->post_type : get_post_type($_REQUEST['post']);
    }

    if ('nasa_pin_pb' == $post_type) {
        if (in_array($pagenow, array('post.php', 'post-new.php'))) {
            if (!isset($_REQUEST['action']) || 'trash' != $_REQUEST['action']) {
                $no_image = true;
                $_width = $_height = 0;
                $_options = '';
                $_init = '{}';
                $image_src = NASA_CORE_PLUGIN_URL . 'assets/images/placeholder.png';
                // Get current image.
                $attachment_id = get_post_meta($post->ID, 'nasa_pin_pb_image_url', true);
                
                if ($attachment_id) {
                    // Get image source.
                    $image_src = wp_get_attachment_url($attachment_id);
                    $no_image = false;
                    
                    $_width = get_post_meta($post->ID, 'nasa_pin_pb_image_width', true);
                    $_height = get_post_meta($post->ID, 'nasa_pin_pb_image_height', true);
                    $_options = get_post_meta($post->ID, 'nasa_pin_pb_options', true);
                    $_optionsArr = json_decode($_options);
                    
                    if (is_array($_optionsArr)) {
                        $_optionsArr['canvas'] = array(
                            'src' => $image_src,
                            'width' => $_width,
                            'height' => $_height
                        );
                        
                        $_init = json_encode(array("nasa_pin_pb" => $_optionsArr));
                    }
                }
                
                // Load template file.
                include_once NASA_CORE_PLUGIN_PATH . 'admin/views/pin-pb-admin-editor.php';
            }
        }
    }
}

/**
 * Save post nasa_pin_pb
 */
function nasa_pin_pb_admin_save_post($id) {
    if (isset($_POST['nasa_pin_pb_image_url'])) {
        update_post_meta($id, 'nasa_pin_pb_image_url', absint($_POST['nasa_pin_pb_image_url']));
    }
    
    if (isset($_POST['nasa_pin_pb_image_width'])) {
        update_post_meta($id, 'nasa_pin_pb_image_width', absint($_POST['nasa_pin_pb_image_width']));
    }
    
    if (isset($_POST['nasa_pin_pb_image_height'])) {
        update_post_meta($id, 'nasa_pin_pb_image_height', absint($_POST['nasa_pin_pb_image_height']));
    }
    
    if (isset($_POST['nasa_pin_pb_options'])) {
        update_post_meta($id, 'nasa_pin_pb_options', $_POST['nasa_pin_pb_options']);
    }
}

// Register Ajax actions / filters.
// add_filter('woocommerce_json_search_found_products', 'nasa_search_products');
function nasa_search_products($found_products) {
    // Check if term is a number.
    $id = (string) wc_clean(stripslashes($_GET['term']));

    if (preg_match('/^\d+$/', $id)) {
        // Get product.
        $product = wc_get_product((int) $id);
        if ($product) {
            $found_products = array(
                'id' => $id,
                'text' => rawurldecode(str_replace('&ndash;', ' - ', $product->get_formatted_name())),
            );
        }
    }

    return $found_products;
}
