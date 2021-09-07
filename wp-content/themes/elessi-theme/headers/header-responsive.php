<?php
/**
 * Header Responsive
 */
?>

<div class="mobile-menu header-responsive">
    <div class="mini-icon-mobile">
        <a href="javascript:void(0);" class="nasa-icon nasa-mobile-menu_toggle mobile_toggle nasa-mobile-menu-icon pe-7s-menu" rel="nofollow"></a>
        <a class="nasa-icon icon pe-7s-search mobile-search" href="javascript:void(0);" rel="nofollow"></a>
    </div>

    <div class="logo-wrapper">
        <?php echo elessi_logo(); ?>
    </div>

    <?php
    $show_icons = isset($nasa_opt['topbar_mobile_icons_toggle']) && $nasa_opt['topbar_mobile_icons_toggle'] ? false : true;
    $class_icons_wrap = '';
    $toggle_icon = '';

    if (!$show_icons) :
        $class_icons_wrap .= ' nasa-absolute-icons nasa-hide-icons';
        $toggle_icon .= '<a class="nasa-toggle-mobile_icons" href="javascript:void(0);" rel="nofollow"><span class="nasa-icon"></span></a>';
    endif;

    echo '<div class="nasa-mobile-icons-wrap' . $class_icons_wrap . '">';
    echo $toggle_icon;
    echo elessi_header_icons(true, true, true, true, false);
    echo '</div>';
    ?>
</div>
