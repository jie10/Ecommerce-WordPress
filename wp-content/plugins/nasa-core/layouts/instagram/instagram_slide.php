<?php
$ulclass = 'instagram-pics instagram-size-large nasa-instagram-slider-wrap';
$aclass = 'instagram-a nasa-instagram-link nasa-instagram-item';
$imgclass = 'instagram-img nasa-instagram-img nasa-not-set';
$imgclass .= $el_class_img ? ' ' . $el_class_img : '';

$class = 'nasa-instagram nasa-instagram-slider';
$class .= $el_class ? ' ' . $el_class : '';

echo '<div class="nasa-intagram-wrap' . ($el_class != '' ? ' ' . $el_class : '') . '" data-layout="slider" data-size="' . $width . '">';

echo '<div class="nasa-from-instagram-feed hidden-tag">' . do_shortcode($shortcode_text) . '</div>';

echo '<div class="' . $class . '">';

if ($username_show || $instagram_link) :
    echo $instagram_link ? '<a href="' . esc_url($instagram_link) . '" rel="me" target="_blank" title="' . esc_attr__('Follow us on Instagram', 'nasa-core') . '">' : '';

    echo '<div class="username-text text-center"><i class="fa fa-instagram"></i><span class="hide-for-small">' . $username_show . '</span></div>';

    echo $instagram_link ? '</a>' : '';
endif;

echo '<div class="' . esc_attr($ulclass) . '" data-columns="' . $columns_number . '" data-columns-small="' . $columns_number_small . '" data-columns-tablet="' . $columns_number_tablet . '" data-autoplay="' . esc_attr($auto_slide) . '" data-switch-tablet="' . nasa_switch_tablet() . '" data-switch-desktop="' . nasa_switch_desktop() . '">';

for ($i = 0; $i < $limit_items; $i++) :
    echo '<a href="#" target="_blank" class="' . esc_attr($aclass) . '" rel="nofollow" data-index="' . $i . '">';
        echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=" class="' . $imgclass . '" alt="Instagram Image" width="' . $width . '" height="' . $height . '" />';
    echo '</a>';
endfor;
echo '</div>';

echo '</div></div>';
