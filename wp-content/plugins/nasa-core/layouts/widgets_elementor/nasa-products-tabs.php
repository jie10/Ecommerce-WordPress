<?php
$title_top = isset($instance['title']) ? $instance['title'] : '';
$class_title = false;

$alignment = isset($instance['alignment']) && in_array($instance['alignment'], array('center', 'left', 'right')) ? $instance['alignment'] : 'center';

$class_wrap = 'nasa-tabs-content nasa-not-elementor-style';
$class_wrap .= isset($instance['el_class']) && $instance['el_class'] ? ' ' . $instance['el_class'] : '';

$class_tabable = 'nasa-tabs-wrap';
$margin_tabable = ' margin-bottom-15';
$class_tabable .= ' text-' . $alignment;
$class_ul_tab = 'nasa-tabs';

$tabs_type = !isset($instance['style']) ? '2d-no-border' : $instance['style'];

/**
 * Optimize html
 */
$tmpl = isset($nasa_opt['tmpl_html']) && $nasa_opt['tmpl_html'] ? true : false;

/**
 * Tabs Slide
 */
if ($tabs_type == 'slide') :
    $class_ul_tab .= ' nasa-slide-style';

/**
 * Tabs Classic
 */
else:
    switch ($tabs_type) :
        case '2d':
            $tabs_type_class = ' nasa-classic-2d';
            break;

        case '3d':
            $tabs_type_class = ' nasa-classic-3d';
            break;

        case '2d-has-bg':
            $class_title = 'nasa-has-padding';
            
            if ($title_top) {
                if ($alignment !== 'center') {
                    $class_title .= ' nasa-title-absolute';
                    $class_title .= $alignment == 'left' ? ' text-right' : ' text-left';
                }
            }

            $tabs_type_class = ' nasa-classic-2d nasa-tabs-no-border nasa-tabs-has-bg';
            $margin_tabable = ' margin-bottom-10';
            $class_tabable .= $alignment == 'left' ? ' mobile-text-right' : ' mobile-text-left';

            $title_top = $class_title ? '<div class="' . esc_attr($class_title) . '"><h3>' . $title_top . '</h3></div>' : $title_top;

            break;

        case '2d-radius':
            $tabs_type_class = ' nasa-classic-2d nasa-tabs-no-border nasa-tabs-radius';
            break;

        case '2d-radius-dashed':
            $tabs_type_class = ' nasa-classic-2d nasa-tabs-radius-dashed';
            break;

        case '2d-no-border':
        default:
            $tabs_type_class = ' nasa-classic-2d nasa-tabs-no-border';
            break;

    endswitch;
    
    $class_ul_tab .= ' nasa-classic-style' . $tabs_type_class;
endif;

$class_tabable .= $margin_tabable;

/**
 * Build array tabs
 */
$tabs_heading = $tabs_content = array();
$tabs_content_first = true;
foreach ($instance['tabs'] as $key => $tab) :
    /**
     * Headings
     */
    $tabs_heading[$key] = $tab['tab_title'];
    unset($tab['tab_title']);
    
    /**
     * Contents
     */
    $tabs_content[$key] = $tab;
endforeach;

/**
 * Title Tabs
 */
if ($title_top) {
    $title_description = !$class_title && isset($instance['desc']) && $instance['desc'] ? '<p class="nasa-title-desc">' . $instance['desc'] . '</p>' : '';
    echo !$class_title ? '<div class="nasa-dft nasa-title clearfix hr-type-none text-' . $alignment . '"><h3 class="nasa-heading-title">' . $title_top . '</h3>' . $title_description . '</div>' : $title_top;
}

/**
 * Start Content Tabs
 */
echo '<div class="' . esc_attr($class_wrap) . '">';
echo '<div class="' . esc_attr($class_tabable) . '">';
echo '<ul class="' . esc_attr($class_ul_tab) . '">';

/**
 * Headings
 */
$total = count($tabs_heading);
$stt = 1;
foreach ($tabs_heading as $k => $heading) :
    $class = 'nasa-tab';
    $class .= $stt == 1 ? ' first active' : '';
    $class .= $stt == $total ? ' last' : '';
    
    echo '<li class="' . esc_attr($class) . '">';
    echo '<a href="javascript:void(0);" data-index="nasa-section-' . $k . '" class="nasa-a-tab" rel="nofollow">';
    echo $heading;
    echo '</a>';
    echo '</li>';

    $stt++;
endforeach;

echo '</ul>';
echo '</div>';

echo '<div class="nasa-panels">';

/**
 * Contents
 */
foreach ($tabs_content as $k => $content_args) :
    $class = 'nasa-panel hidden-tag';
    $class .= $tabs_content_first ? ' active first' : '';
    $class .= ' nasa-section-' . $k;
    
    echo '<div class="' . esc_attr($class) . '">';
    echo $tmpl && !$tabs_content_first ? '<template class="nasa-tmpl">' : '';
    $_this->render_shortcode_text($content_args);
    echo $tmpl && !$tabs_content_first ? '</template>' : '';
    echo '</div>';
    
    $tabs_content_first = false;
endforeach;

echo '</div>';
echo '</div>';
