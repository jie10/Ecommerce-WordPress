<?php
$ulclass = 'instagram-pics instagram-size-large';
$liclass = 'instagram-li nasa-instagram-item';
$aclass = 'instagram-a nasa-instagram-link';
$imgclass = 'instagram-img nasa-instagram-img nasa-not-set';
$imgclass .= $el_class_img ? ' ' . $el_class_img : '';

$class = 'nasa-instagram nasa-instagram-grid';
$class .= ' items-' . $columns_number;
$class .= ' items-tablet-' . $columns_number_tablet;
$class .= ' items-mobile-' . $columns_number_small;
$class .= $el_class ? ' ' . $el_class : '';

echo '<div class="nasa-intagram-wrap' . ($el_class != '' ? ' ' . $el_class : '') . '" data-layout="grid" data-size="' . $width . '">';

echo '<div class="nasa-from-instagram-feed hidden-tag">' . do_shortcode($shortcode_text) . '</div>';

echo '<div class="' . $class . '">';

if ($username_show || $instagram_link) :
    echo $instagram_link ? '<a href="' . esc_url($instagram_link) . '" rel="me" target="_blank" title="' . esc_attr__('Follow us on Instagram', 'nasa-core') . '">' : '';

    echo '<div class="username-text text-center"><i class="fa fa-instagram"></i><span class="hide-for-small">' . $username_show . '</span></div>';

    echo $instagram_link ? '</a>' : '';
endif;

echo '<ul class="' . esc_attr($ulclass) . '">';
for ($i = 0; $i < $limit_items; $i++) :
    echo '<li class="' . esc_attr($liclass) . '">';
        echo '<a href="#" target="_blank" class="' . esc_attr($aclass) . '" rel="nofollow" data-index="' . $i . '">';
            echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=" class="' . $imgclass . '" alt="" width="' . $width . '" height="' . $height . '" />';
        echo '</a>';
    echo '</li>';
endfor;
echo '</ul>';

echo '</div></div>';
