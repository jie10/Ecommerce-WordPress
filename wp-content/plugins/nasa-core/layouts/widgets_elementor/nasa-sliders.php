<?php
$text_align = isset($instance['align']) ? 'text-' . $instance['align'] : 'text-left';
$title = isset($instance['title']) ? $instance['title'] : '';

$bullets = isset($instance['bullets']) ? $instance['bullets'] : 'true';
$navigation = isset($instance['navigation']) ? $instance['navigation'] : 'true';
$paginationspeed = isset($instance['paginationspeed']) ? $instance['paginationspeed'] : '800';
$autoplay = isset($instance['autoplay']) ? $instance['autoplay'] : 'false';

$column_number = isset($instance['column_number']) ? $instance['column_number'] : 1;
$column_number_small = isset($instance['column_number_small']) ? $instance['column_number_small'] : 1;
$column_number_tablet = isset($instance['column_number_tablet']) ? $instance['column_number_tablet'] : 1;

$bullets_pos = isset($instance['bullets_pos']) ? $instance['bullets_pos'] : '';
$bullets_align = isset($instance['bullets_align']) ? $instance['bullets_align'] : 'center';

$padding_item = isset($instance['padding_item']) ? $instance['padding_item'] : '';
$padding_item_small = isset($instance['padding_item_small']) ? $instance['padding_item_small'] : '';
$padding_item_medium = isset($instance['padding_item_medium']) ? $instance['padding_item_medium'] : '';

$el_class = isset($instance['el_class']) ? $instance['el_class'] : '';
    
$class_wrap = 'nasa-sc-carousel-main';
$class_wrap .= $bullets_pos == 'inside' ? ' nasa-bullets-inside' : '';
$class_wrap .= $bullets_pos == 'none' ? ' nasa-bullets-inherit' : '';
$class_wrap .= $bullets_align ? ' nasa-bullets-' . $bullets_align : '';
$class_wrap .= $el_class != '' ? ' ' . $el_class : '';

$padding_array = array();
if ($padding_item) {
    $padding_array[] = 'data-padding="' . esc_attr($padding_item) . '"';
}

if ($padding_item_small) {
    $padding_array[] = 'data-padding-small="' . esc_attr($padding_item_small) . '"';
}

if ($padding_item_medium) {
    $padding_array[] = 'data-padding-medium="' . esc_attr($padding_item_medium) . '"';
}

$padding_str = !empty($padding_array) ? ' ' . implode(' ', $padding_array) : '';

$class_slider = 'nasa-slick-slider nasa-not-elementor-style';
$class_slider .= $navigation === 'true' ? ' nasa-slick-nav' : '';
?>

<div class="<?php echo esc_attr($class_wrap); ?>">
    <?php if ($title): ?>
        <h3 class="section-title <?php echo esc_attr($text_align); ?>">
            <?php echo esc_attr($title); ?>
        </h3>
    <?php endif; ?>
    <div 
        class="<?php echo $class_slider; ?>"
        data-autoplay="<?php echo esc_attr($autoplay); ?>"
        data-speed="<?php echo esc_attr($paginationspeed); ?>"
        data-dot="<?php echo esc_attr($bullets); ?>"
        data-columns="<?php echo esc_attr($column_number); ?>"
        data-columns-small="<?php echo esc_attr($column_number_small); ?>"
        data-columns-tablet="<?php echo esc_attr($column_number_tablet); ?>"
        data-switch-tablet="<?php echo nasa_switch_tablet(); ?>"
        data-switch-desktop="<?php echo nasa_switch_desktop(); ?>"
        <?php echo $padding_str; ?>>
        <?php
        foreach ($instance['sliders'] as $key => $args) :
            $_this->render_shortcode_text($args);
        endforeach;
        ?>
    </div>
</div>
