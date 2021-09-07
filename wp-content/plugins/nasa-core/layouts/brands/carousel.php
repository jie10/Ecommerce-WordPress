<?php
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
?>

<div
    class="nasa-brands nasa-slider-items-margin nasa-slick-slider nasa-slick-nav"
    data-autoplay="<?php echo esc_attr($auto_slide); ?>"
    data-columns="<?php echo esc_attr($columns_number); ?>"
    data-columns-small="<?php echo esc_attr($columns_number_small); ?>"
    data-columns-tablet="<?php echo esc_attr($columns_number_tablet); ?>"
    data-switch-tablet="<?php echo nasa_switch_tablet(); ?>"
    data-switch-desktop="<?php echo nasa_switch_desktop(); ?>">
    <?php foreach ($images as $key => $image) :
        $img = wp_get_attachment_image($image, 'full');
        if ($img) :
            $link = isset($custom_links[$key]) ? esc_url($custom_links[$key]) : '#';
            
            $name = isset($custom_names[$key]) ? $custom_names[$key] : false;
            $attr = $name ? ' title="' . esc_attr($name) . '"' : '';
            $show_title = $name && isset($show_titles[$key]) && $show_titles[$key] ? true : false;
            $img .= $show_title ? '<p class="nasa-block">' . $name . '</p>' : '';
            
            echo '<a href="' . $link . '" class="brands-item wow bounceIn text-center nasa-block" data-wow-duration="1s" data-wow-delay="' . esc_attr($_delay) . 'ms"' . $attr . '>' . $img . '</a>';
            
            $_delay += $_delay_item;
        endif;
    endforeach; ?>
</div>
