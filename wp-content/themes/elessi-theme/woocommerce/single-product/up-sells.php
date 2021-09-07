<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.0.0
 */
if (!defined('ABSPATH')) :
    exit;
endif;

if ($upsells) :
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
    $class_slider = 'nasa-slider-items-margin nasa-slick-slider nasa-slick-nav nasa-nav-top nasa-nav-top-radius products grid' . $layout_buttons_class;
    ?>

    <div class="row related-product nasa-slider-wrap related up-sell products grid nasa-relative margin-bottom-50">
        
        <div class="large-12 columns">
            <h3 class="nasa-title-relate text-center">
                <?php esc_html_e('You may also like&hellip;', 'elessi-theme'); ?>
            </h3>
        </div>
        
        <div class="large-12 columns">
            <?php
            $crazy_load = !isset($nasa_opt['crazy_load']) || $nasa_opt['crazy_load'] ? true : false;
            echo $crazy_load ? '<div class="crazy-load-slider"></div>' : '';
            ?>
            
            <div class="<?php echo esc_attr($class_slider); ?>"<?php echo $attrs_str; ?>>
                <?php
                foreach ($upsells as $upsell):
                    $post_object = get_post($upsell->get_id());
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
    </div>
    <?php
endif;

wp_reset_postdata();
