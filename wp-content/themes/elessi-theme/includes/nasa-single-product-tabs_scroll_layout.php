<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

$wrap_desc = !isset($nasa_opt['desc_product_wrap']) || $nasa_opt['desc_product_wrap'] ? true : false;

$scroll_title_class = 'nasa-scroll-titles';
$scroll_title_class .= isset($nasa_opt['tab_align_info']) ? ' text-' . $nasa_opt['tab_align_info'] : ' text-center';
$tabs_titles = array();
    
foreach ($tabs as $key => $tab) :
    if (!isset($tab['title']) || !isset($tab['callback'])) :
        continue;
    endif;

    $tabs_titles[$key] = apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key);
endforeach;

foreach ($tabs as $key => $tab) :
    if (!isset($tab['title']) || !isset($tab['callback'])) :
        continue;
    endif;
    ?>

    <div class="row">
        <div class="large-12 columns">
            <div class="<?php echo esc_attr($scroll_title_class); ?>" id="nasa-anchor-<?php echo esc_attr($key); ?>">
                <?php foreach ($tabs_titles as $k => $title):
                    $anchor_href = '#nasa-anchor-' . $k;
                    $anchor_class = 'nasa-anchor nasa-transition';
                    $anchor_class .= $k == $key ? ' active' : '';
                    ?>
                    <a class="<?php echo esc_attr($anchor_class); ?>" data-target="#nasa-anchor-<?php echo esc_attr($k); ?>" href="#nasa-anchor-<?php echo esc_attr($k); ?>">
                        <?php echo $title; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="nasa-scroll-content nasa-content-<?php echo esc_attr($key); ?><?php echo $wrap_desc ? ' nasa-desc-wrap' : ' nasa-desc-no-wrap'; ?>" id="nasa-scroll-<?php echo esc_attr($key); ?>">
        <?php
        echo ($wrap_desc || $key !== 'description') ? '<div class="row"><div class="large-12 columns nasa-content-panel">' : '';
        call_user_func($tab['callback'], $key, $tab);
        echo ($wrap_desc || $key !== 'description') ? '</div></div>' : '';
        ?>
    </div>

    <?php
endforeach;
