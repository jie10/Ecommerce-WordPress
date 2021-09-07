<?php
if (empty($brands)) {
    return;
}
?>

<div itemprop="brand" class="nasa-sa-brands nasa-transition">
<?php
foreach ($brands as $label => $brands_array) :
    $brand_label = wc_attribute_label($label);
    echo '<span class="nasa-sa-brand-label hidden-tag">' . $brand_label . '</span>';
    
    $terms = $brands_array['terms'];
    $is_link = $brands_array['is_link'];
    $attr_name = $brands_array['attr_name'];
    
    foreach ($terms as $k => $term) {
        $thumb_id = get_term_meta($term->term_id, 'nasa_image', true);
        $image = $thumb_id ? wp_get_attachment_image($thumb_id, 'full') : '';

        if ($is_link) :
            echo '<a class="nasa-sa-brand-item nasa-transition" title="' . esc_attr($term->name) . '" href="' . esc_url(get_term_link($term->term_id, $attr_name)) . '" rel="tag">' . $image . '</a>';
        else :
            echo '<span class="nasa-sa-brand-item nasa-transition">' . $image . '</span>';
        endif;
    }
endforeach;
?>
</div>
