<?php
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;

$height_auto = !isset($height_auto) ? 'false' : $height_auto;
$auto_slide = isset($auto_slide) ? $auto_slide : 'false';

$auto_delay_time = isset($auto_delay_time) && (int) $auto_delay_time ? (int) $auto_delay_time * 1000 : 6000;

$style_row = (!isset($style_row) || !in_array((int) $style_row, array(1, 2, 3))) ? 1 : (int) $style_row;
$arrows = isset($arrows) ? $arrows : 0;

$pos_nav_set = isset($pos_nav) ? $pos_nav : 'top';
$pos_nav = in_array($pos_nav_set, array('top', 'both')) ? $pos_nav_set : 'top';
$dots = isset($dots) ? $dots : 'false';

$slider_class = 'nasa-slider-items-margin nasa-slick-slider';
$slider_class .= $arrows == 1 ? ' nasa-slick-nav' : '';
$slider_class .= $pos_nav == 'top' && $arrows == 1 ? ' nasa-nav-top-list' : '';
$slider_class .= $pos_nav == 'both' && $arrows == 1 ? ' nasa-nav-radius' : '';
$slider_class .= $style_row > 1 ? ' nasa-slide-double-row' : '';

/**
 * Attributes sliders
 */
$data_attrs = array();
$data_attrs[] = 'data-columns="' . esc_attr($columns_number) . '"';
$data_attrs[] = 'data-columns-small="' . esc_attr($columns_number_small) . '"';
$data_attrs[] = 'data-columns-tablet="' . esc_attr($columns_number_tablet) . '"';
$data_attrs[] = 'data-autoplay="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-slides-all="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-delay="' . esc_attr($auto_delay_time) . '"';
$data_attrs[] = 'data-height-auto="' . esc_attr($height_auto) . '"';
$data_attrs[] = 'data-dot="' . esc_attr($dots) . '"';
$data_attrs[] = 'data-switch-tablet="' . nasa_switch_tablet() . '"';
$data_attrs[] = 'data-switch-desktop="' . nasa_switch_desktop() . '"';

$attrs_str = !empty($data_attrs) ? ' ' . implode(' ', $data_attrs) : '';
?>

<div class="nasa-relative nasa-slider-wrap nasa-slide-style-product-carousel nasa-product-list-carousel">
    <div
        class="<?php echo $slider_class; ?>"<?php echo $attrs_str; ?>>
        <?php
        $k = 0;
        echo $style_row > 1 ? '<div class="nasa-wrap-column">' : '';
        while ($loop->have_posts()) :
            $loop->the_post();
        
            global $product;
            if (empty($product) || !$product->is_visible()) :
                continue;
            endif;
        
            echo ($k && $style_row > 1 && ($k%$style_row == 0)) ? '<div class="nasa-wrap-column">' : '';

            wc_get_template(
                'content-widget-product.php', 
                array(
                    'wapper' => 'div',
                    'delay' => $_delay,
                    '_delay_item' => $_delay_item
                )
            );

            if ($k && $style_row > 1 && (($k+1)%$style_row == 0)) :
                $_delay += $_delay_item;
                echo '</div>';
            endif;

            if ($style_row == 1) :
                $_delay += $_delay_item;
            endif; 

            $k++;
        endwhile;
        echo ($k && $style_row > 1 && $k%$style_row != 0) ? '</div>' : '';

        wp_reset_postdata();
        ?>
    </div>
</div>
