<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$el_class = (trim($el_class) != '') ? ' ' . $el_class : '';
$el_class .= isset($accordion_hide_first) && $accordion_hide_first ? ' nasa-accodion-first-hide' : '';
$el_class .= isset($accordion_layout) && $accordion_layout ? ' nasa-' . $accordion_layout : ' nasa-has-border';
$el_class .= isset($accordion_icon) && $accordion_icon ? ' nasa-' . $accordion_icon : ' nasa-plus';
if (isset($accordion_show_multi) && $accordion_show_multi) {
    $el_class .= ' nasa-no-global';
}
$output = $this->getTemplateVariable('title');
$output .= '<div class="nasa-wrap-all nasa-accordions-content' . $el_class . '">';
    $output .= $prepareContent;
$output .= '</div>';

echo $output;
