<?php
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
?>

<ul class="nasa-brands margin-left-0 margin-right-0 small-block-grid-<?php echo esc_attr($columns_number_small); ?> medium-block-grid-<?php echo esc_attr($columns_number_tablet); ?> large-block-grid-<?php echo esc_attr($columns_number); ?>">
    <?php foreach ($images as $key => $image) :
        $img = wp_get_attachment_image($image, 'full');
        if ($img) :
            $link = isset($custom_links[$key]) ? esc_url($custom_links[$key]) : '#';
            $name = isset($custom_names[$key]) ? $custom_names[$key] : false;
            $attr = $name ? ' title="' . esc_attr($name) . '"' : '';
            $show_title = $name && isset($show_titles[$key]) && $show_titles[$key] ? true : false;
            
            echo '<li class="brands-item wow bounceIn text-center" data-wow-duration="1s" data-wow-delay="' . esc_attr($_delay) . 'ms">';
            
            echo '<a href="' . $link . '"' . $attr . '>' . $img . '</a>';
            echo $show_title ? '<a href="' . $link . '"' . $attr . '>' . $name . '</a>' : '';
            
            echo '</li>';
            
            $_delay += $_delay_item;
        endif;
    endforeach; ?>
</ul>
