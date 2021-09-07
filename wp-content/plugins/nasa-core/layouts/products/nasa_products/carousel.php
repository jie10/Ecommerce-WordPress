<?php
$layout_buttons_class = '';
if (isset($nasa_opt['loop_layout_buttons']) && $nasa_opt['loop_layout_buttons'] != '') {
    $layout_buttons_class = ' nasa-' . $nasa_opt['loop_layout_buttons'];
}

$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;

$cat_info = apply_filters('nasa_loop_categories_show', false);
$description_info = apply_filters('nasa_loop_short_description_show', false);

$height_auto = !isset($height_auto) ? 'false' : $height_auto;
$auto_slide = isset($auto_slide) ? $auto_slide : 'false';

$auto_delay_time = isset($auto_delay_time) && (int) $auto_delay_time ? (int) $auto_delay_time * 1000 : 6000;
$style_row = (!isset($style_row) || !in_array((int) $style_row, array(1, 2, 3))) ? 1 : (int) $style_row;

$is_deals = $type == 'deals' ? true : false;
$shop_url = isset($shop_url) ? $shop_url : false;
$arrows = isset($arrows) ? $arrows : 0;
$dots = isset($dots) ? $dots : 'false';

$term = (isset($cat) && (int)$cat) ? get_term_by('id', (int) $cat, 'product_cat') : null;
$link_shortcode = null;
$parent_term = null;
$parent_term_link = '#';
if ($shop_url == 1) {
    if ($term) {
        $parent_term = $term->parent ? get_term_by("id", $term->parent, "product_cat") : $parent_term;
        $parent_term_link = $parent_term ? get_term_link($parent_term, 'product_cat') : $parent_term_link;
        $link_shortcode = get_term_link($term, 'product_cat');
    } else {
        $permalinks = get_option('woocommerce_permalinks');
        $shop_page_id = wc_get_page_id('shop');
        $shop_page = get_post($shop_page_id);

        $shop_page_url = get_permalink($shop_page_id);
        $shop_page_title = get_the_title($shop_page_id);
        // If permalinks contain the shop page in the URI prepend the breadcrumb with shop
        if ($shop_page_id > 0 && strstr($permalinks['product_base'], '/' . $shop_page->post_name) && get_option('page_on_front') !== $shop_page_id) {
            $link_shortcode = get_permalink($shop_page);
        }
    }
}

$catName = isset($term->name) ? ' ' . $term->name : '';
$pos_nav_set = isset($pos_nav) ? $pos_nav : 'top';
$pos_nav = in_array($pos_nav_set, array('top', 'left', 'both')) ? $pos_nav_set : 'top';

$columns_small = $columns_number_small_slider == '1.5' ? '1' : $columns_number_small_slider;

/**
 * Attributes sliders
 */
$data_attrs = array();
$data_attrs[] = 'data-columns="' . esc_attr($columns_number) . '"';
$data_attrs[] = 'data-columns-small="' . esc_attr($columns_small) . '"';
$data_attrs[] = 'data-columns-tablet="' . esc_attr($columns_number_tablet) . '"';
$data_attrs[] = 'data-autoplay="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-slides-all="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-delay="' . esc_attr($auto_delay_time) . '"';
$data_attrs[] = 'data-height-auto="' . esc_attr($height_auto) . '"';
$data_attrs[] = 'data-dot="' . esc_attr($dots) . '"';
$data_attrs[] = 'data-switch-tablet="' . nasa_switch_tablet() . '"';
$data_attrs[] = 'data-switch-desktop="' . nasa_switch_desktop() . '"';

if ($columns_number_small_slider == '1.5') {
    $data_attrs[] = 'data-padding-small="20%"';
}

$attrs_str = !empty($data_attrs) ? ' ' . implode(' ', $data_attrs) : '';

if ($pos_nav == 'left' && $style_row == 1) :
    if ((!isset($title_shortcode) || trim($title_shortcode) == '') && $pos_nav == 'left') {
        switch ($type):
            case 'best_selling':
                $title_shortcode = esc_html__('Best Selling', 'nasa-core');
                break;
            case 'featured_product':
                $title_shortcode = esc_html__('Featured', 'nasa-core');
                break;
            case 'top_rate':
                $title_shortcode = esc_html__('Top Rate', 'nasa-core');
                break;
            case 'on_sale':
                $title_shortcode = esc_html__('On Sale', 'nasa-core');
                break;
            case 'recent_review':
                $title_shortcode = esc_html__('Recent Review', 'nasa-core');
                break;
            case 'deals':
                $title_shortcode = esc_html__('Deals', 'nasa-core');
                break;
            case 'recent_product':
            default:
                $title_shortcode = esc_html__('Recent', 'nasa-core');
                break;
        endswitch;

        $title_shortcode = $catName != '' ? $title_shortcode . ' ' . $catName : $title_shortcode;
    }
    
    $slider_class = 'nasa-slider-items-margin nasa-slick-slider products grid' . $layout_buttons_class;
    ?>
    <div class="row nasa-slider-wrap nasa-warp-slide-nav-side">
        <div class="large-3 columns nasa-rtl">
            <div class="nasa-slide-left-info-wrap">
                <?php if ($parent_term) : ?>
                    <h4 class="nasa-shortcode-parent-term">
                        <a href="<?php echo esc_url($parent_term_link); ?>" title="<?php echo esc_attr($parent_term->name); ?>">
                            <?php echo $parent_term->name; ?>
                        </a>
                    </h4>
                <?php endif; ?>
                
                <h3 class="nasa-shortcode-title-slider">
                    <?php echo $title_shortcode; ?>
                </h3>

                <?php if ($arrows == 1) : ?>
                    <div class="nasa-nav-carousel-wrap nasa-clear-both">
                        <a class="nasa-nav-icon-slider icon-nasa-left-arrow" href="javascript:void(0);" data-do="prev" rel="nofollow"></a>
                        <a class="nasa-nav-icon-slider icon-nasa-right-arrow" href="javascript:void(0);" data-do="next" rel="nofollow"></a>
                    </div>
                <?php endif; ?>
                
                <?php if ($link_shortcode) : ?>
                    <a href="<?php echo esc_url($link_shortcode); ?>" title="<?php echo esc_html__('View More', 'nasa-core') . ($catName != '' ? ' ' . esc_attr($catName) : ''); ?>" class="nasa-view-more-slider">
                        <?php echo esc_html__('View More', 'nasa-core'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="large-9 columns">
            <div class="<?php echo esc_attr($slider_class); ?>"<?php echo $attrs_str; ?>>
                <?php
                while ($loop->have_posts()) :
                    $loop->the_post();
                    
                    global $product;
                    if (empty($product) || !$product->is_visible()) :
                        continue;
                    endif;
                    
                    wc_get_template('content-product.php', array(
                        'is_deals' => $is_deals,
                        '_delay' => $_delay,
                        '_delay_item' => $_delay_item,
                        'wrapper' => 'div',
                        'show_in_list' => false,
                        'cat_info' => $cat_info,
                        'description_info' => $description_info
                    ));
                    
                    $_delay += $_delay_item;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
<?php else :
    $slider_class = 'nasa-slider-items-margin nasa-slick-slider products grid' . $layout_buttons_class;
    $slider_class .= $arrows == 1 ? ' nasa-slick-nav' : '';
    $slider_class .= $pos_nav == 'top' && $arrows == 1 ? ' nasa-nav-top' : '';
    $slider_class .= isset($nav_radius) && $nav_radius && $arrows == 1 ? ' nasa-nav-top-radius' : '';
    $slider_class .= $pos_nav == 'both' && $arrows == 1 ? ' nasa-nav-radius' : '';
    $slider_class .= $style_row > 1 ? ' nasa-slide-double-row' : '';
    
    $title_align = isset($title_align) && $title_align ? $title_align : 'left';
    if (isset($title_shortcode) && $title_shortcode != '') : ?>
        <div class="margin-bottom-15 nasa-warp-slide-nav-top<?php echo ' title-align-' . $title_align; ?>">
            <div class="nasa-title">
                <h3 class="nasa-heading-title">
                    <?php if ($parent_term) : ?>
                        <span class="hidden-tag nasa-parent-cat">
                            <a href="<?php echo esc_url($parent_term_link); ?>" title="<?php echo esc_attr($parent_term->name); ?>"><?php echo $parent_term->name; ?></a>
                        </span>
                    <?php endif; ?>
                    
                    <?php echo $title_shortcode; ?>
                </h3>
                <hr class="nasa-separator" />
            </div>
        </div>
    <?php endif; ?>

    <div class="nasa-relative nasa-slider-wrap nasa-slide-style-product-carousel nasa-warp-slide-nav-top<?php echo ' title-align-' . $title_align; ?>">
        <?php if ($link_shortcode) : ?>
            <div class="nasa-sc-product-btn">
                <a href="<?php echo esc_url($link_shortcode); ?>" title="<?php echo esc_html__('Shop all', 'nasa-core') . ($catName != '' ? ' ' . esc_attr($catName) : ''); ?>" class="nasa-view-more-slider">
                    <?php echo esc_html__('Shop all', 'nasa-core') . ($catName != '' ? ' ' . esc_attr($catName) : ''); ?>
                </a>
            </div>
        <?php endif; ?>
        
        <div class="<?php echo esc_attr($slider_class); ?>"<?php echo $attrs_str; ?>>
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

                wc_get_template('content-product.php', array(
                    'is_deals' => $is_deals,
                    '_delay' => $_delay,
                    '_delay_item' => $_delay_item,
                    'wrapper' => 'div',
                    'show_in_list' => false,
                    'cat_info' => $cat_info,
                    'description_info' => $description_info
                ));

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
<?php
endif;
