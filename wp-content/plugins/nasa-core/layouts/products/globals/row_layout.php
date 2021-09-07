<?php
$_delay = $count = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
$is_deals = isset($is_deals) ? $is_deals : false;
$columns_number = isset($columns_number) ? $columns_number : 5;
$columns_tablet = isset($columns_number_tablet) ? $columns_number_tablet : 2;
$columns_small = isset($columns_number_small) ? $columns_number_small : 1;
$class_item = 'columns';

$cat_info = apply_filters('nasa_loop_categories_show', false);
$description_info = apply_filters('nasa_loop_short_description_show', false);

// desktop columns
switch ($columns_number):
    case '2':
        $class_item .= ' large-6';
        break;
    case '3':
        $class_item .= ' large-4';
        break;
    case '4':
        $class_item .= ' large-3';
        break;
    case '6':
        $class_item .= ' large-2';
        break;
    case '5':
    default:
        $columns_number = 5;
        $class_item .= ' nasa-large-5-col-1';
        break;
endswitch;

// Tablet columns
switch ($columns_tablet):
    case '1':
        $class_item .= ' medium-12';
        break;
    case '3':
        $class_item .= ' medium-4';
        break;
    case '4':
        $class_item .= ' medium-3';
        break;
    case '2':
    default:
        $class_item .= ' medium-6';
        break;
endswitch;

// Small columns
switch ($columns_small):
    case '3':
        $class_item .= ' small-4';
        break;
    case '2':
        $class_item .= ' small-6';
        break;
    case '1':
    default:
        $class_item .= ' small-12';
        break;
endswitch;

if (isset($nasa_opt['loop_layout_buttons']) && $nasa_opt['loop_layout_buttons'] != '') {
    $class_item .= ' nasa-' . $nasa_opt['loop_layout_buttons'];
}

$class_item .= (isset($classDeal3) && $classDeal3) ? ' nasa-less-right nasa-less-left' : '';

$start_row = !isset($start_row) ? '<div class="row nasa-row-child-clear-none mobile-padding-left-5 mobile-padding-right-5">' : '';
$end_row = !isset($end_row) ? '</div>' : '';

echo $start_row;

while ($loop->have_posts()) :
    $loop->the_post();
    
    global $product;
    if (empty($product) || !$product->is_visible()) :
        continue;
    endif;
    
    echo '<div class="product-warp-item ' . esc_attr($class_item) . '">';
    wc_get_template(
        'content-product.php',
        array(
            'is_deals' => $is_deals,
            '_delay' => $_delay,
            'wrapper' => 'div',
            'show_in_list' => false,
            'cat_info' => $cat_info,
            'description_info' => $description_info
        )
    );
    echo '</div>';
    $_delay += $_delay_item;
    $count++;
endwhile;

echo $end_row;

wp_reset_postdata();
