<?php
echo '<div class="hidden-tag">';

/**
 * Main Menu
 */
echo '<-- Main Menu Mobile -->';
elessi_get_main_menu();

/**
 * Vertical Menu
 */
if (defined('NASA_MENU_VERTICAL_IN_MOBILE') && NASA_MENU_VERTICAL_IN_MOBILE) :
    echo '<-- Vertical Menu Mobile -->';
    elessi_get_vertical_menu();
endif;

echo '</div>';