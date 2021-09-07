<?php
/**
 * Cross-sells
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 4.4.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if ($cross_sells) :
    global $nasa_opt;

    $_delay = 0;
    $_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
    
    $layout_buttons_class = '';
    if (isset($nasa_opt['loop_layout_buttons']) && $nasa_opt['loop_layout_buttons'] != '') {
        $layout_buttons_class = ' nasa-' . $nasa_opt['loop_layout_buttons'];
    }
    
    $columns_desk = !isset($nasa_opt['relate_columns_desk']) || !(int) $nasa_opt['relate_columns_desk'] ? 3 : (int) $nasa_opt['relate_columns_desk'];
    $columns_tablet = !isset($nasa_opt['relate_columns_tablet']) || !(int) $nasa_opt['relate_columns_tablet'] ? 3 : (int) $nasa_opt['relate_columns_tablet'];
    $columns_small = isset($nasa_opt['relate_columns_small']) ? $nasa_opt['relate_columns_small'] : 2;
    $columns_small_slide = $columns_small == '1.5-cols' ? 1 : (int) $columns_small;
    
    if (!$columns_small) {
        $columns_small_slide = 2;
    }
    
    $start_row = $end_row = '';
    $class_wrap = 'related related-product cross-sells products grid nasa-slider-wrap margin-top-50';
    
    if (isset($_REQUEST['nasa_action']) && $_REQUEST['nasa_action'] === 'nasa_after_add_to_cart') {
        $columns_desk = apply_filters('nasa_columns_large_popup_cross_sells', '3');
        $columns_tablet = apply_filters('nasa_columns_medium_popup_cross_sells', '3');
        $columns_small = apply_filters('nasa_columns_small_popup_cross_sells', '2');
    } else {
        $start_row = '<div class="row">';
        $end_row = '</div>';
        $class_wrap .= ' larger-12 columns';
    }
    
    $data_attrs = array();
    $data_attrs[] = 'data-columns="' . esc_attr($columns_desk) . '"';
    $data_attrs[] = 'data-columns-small="' . esc_attr($columns_small_slide) . '"';
    $data_attrs[] = 'data-columns-tablet="' . esc_attr($columns_tablet) . '"';
    $data_attrs[] = 'data-switch-tablet="' . elessi_switch_tablet() . '"';
    $data_attrs[] = 'data-switch-desktop="' . elessi_switch_desktop() . '"';

    if ($columns_small == '1.5-cols') {
        $data_attrs[] = 'data-padding-small="20%"';
    }
    
    $attrs_str = !empty($data_attrs) ? ' ' . implode(' ', $data_attrs) : '';
    
    $heading = apply_filters('woocommerce_product_cross_sells_products_heading', esc_html__('You may be interested in&hellip;', 'elessi-theme'));
    
    $class_slider = 'nasa-slider-items-margin nasa-slick-slider products grid' . $layout_buttons_class;
    $class_slider .= ' nasa-slick-nav nasa-nav-top nasa-nav-top-radius';
    
    echo $start_row;
    ?>

    <div class="<?php echo esc_attr($class_wrap); ?>">
        <?php if ($heading) : ?>
            <div class="nasa-slide-style-product-carousel nasa-relative margin-bottom-20">
                <h3 class="nasa-shortcode-title-slider text-center">
                    <?php echo $heading; ?>
                </h3>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($class_slider); ?>"<?php echo $attrs_str; ?>>
            <?php
            foreach ($cross_sells as $cross_sell) :
                $post_object = get_post($cross_sell->get_id());
                setup_postdata($GLOBALS['post'] = & $post_object);
                
                // Product Item -->
                wc_get_template('content-product.php', array(
                    '_delay' => $_delay,
                    'wrapper' => 'div',
                    'combo_show_type' => 'popup',
                    'disable_drag' => true
                ));
                // End Product Item -->
                
                $_delay += $_delay_item;
            endforeach;
            ?>
        </div>
    </div>
    <?php
    
    echo $end_row;
endif;

wp_reset_postdata();
