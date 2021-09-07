<?php
/**
 * The template for displaying search forms mobile in nasatheme
 *
 * @package     nasatheme
 * @version     1.0.0
 */

$url = home_url('/');
$post_type = apply_filters('nasa_mobile_search_post_type', 'product');
$class_input = 'search-field search-input';
$place_holder = esc_attr__("Start typing ...", 'elessi-theme');
$class_wrap = 'nasa-search-form';
if ($post_type === 'product') {
    $class_input .= ' live-search-input';
    $class_wrap = 'nasa-ajax-search-form';
    $place_holder = esc_attr__("I'm shopping for ...", 'elessi-theme');
}
$has_post_type = apply_filters('nasa_searh_form_has_post_type', (bool) $post_type);
?>

<div class="warpper-mobile-search hidden-tag"></div>
<script type="text/template" id="tmpl-nasa-mobile-search">
    <div class="search-wrapper <?php echo esc_attr($class_wrap); ?>-container">
        <form method="get" class="<?php echo esc_attr($class_wrap); ?>" action="<?php echo esc_url($url); ?>">
            <label for="nasa-input-mobile-search" class="hidden-tag">
                <?php esc_html_e('Search here', 'elessi-theme'); ?>
            </label>

            <input id="nasa-input-mobile-search" type="text" class="<?php echo esc_attr($class_input); ?>" value="<?php echo get_search_query();?>" name="s" placeholder="<?php echo $place_holder; ?>" />

            <div class="nasa-vitual-hidden">
                <?php if ($has_post_type) : ?>
                    <input type="submit" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
                <?php else: ?>
                    <input type="submit" name="submit" value="<?php esc_attr_e('search', 'elessi-theme'); ?>" />
                <?php endif; ?>
            </div>
        </form>
    </div>
</script>
