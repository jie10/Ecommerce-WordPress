<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Content Nasa Widget Filter Price - Slide
 */
if (!function_exists('elessi_get_content_widget_price')) :

    function elessi_get_content_widget_price($args = array(), $instance = array(), $show = true) {
        $args = array(
            'widget_id' => $args['widget_id'],
            'before_title' => str_replace('\\', '', $args['before_title']),
            'after_title' => str_replace('\\', '', $args['after_title'])
        );

        $instance = array(
            'title' => isset($instance['title']) ? $instance['title'] : esc_html__('Price', 'elessi-theme'),
            'btn_filter' => isset($instance['btn_filter']) ? $instance['btn_filter'] : 0
        );

        $classWrap = !$show ? ' hidden-tag' : '';

        if (!is_shop() && !is_product_taxonomy()) {
            return 
                '<div id="' . $args['widget_id'] . '-ajax-wrap" class="nasa-hide-price nasa-filter-price-widget-wrap' . esc_attr($classWrap) . '">' .
                    $args['before_title'] . $instance['title'] . $args['after_title'] .
                '</div>';
        }

        global $wp;
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

        $min_price = isset($_REQUEST['min_price']) ? esc_attr($_REQUEST['min_price']) : '';
        $max_price = isset($_REQUEST['max_price']) ? esc_attr($_REQUEST['max_price']) : '';
        $hasPrice = ($min_price !== '' && $max_price !== '' && ($min_price >= 0 || $max_price >= $min_price)) ? '1' : '0';
        $class_reset = $hasPrice == '1' ? '' : ' hidden-tag';

        // Remember current filters/search
        $fields = ($search_query = get_search_query()) ? '<input type="hidden" name="s" value="' . $search_query . '" />' : '';

        $fields .= !empty($_REQUEST['post_type']) ? '<input type="hidden" name="post_type" value="' . esc_attr($_REQUEST['post_type']) . '" />' : '';

        $fields .= !empty($_REQUEST['product_cat']) ? '<input type="hidden" name="product_cat" value="' . esc_attr($_REQUEST['product_cat']) . '" />' : '';

        $fields .= !empty($_REQUEST['product_tag']) ? '<input type="hidden" name="product_tag" value="' . esc_attr($_REQUEST['product_tag']) . '" />' : '';

        $fields .= !empty($_REQUEST['orderby']) ? '<input type="hidden" name="orderby" value="' . esc_attr($_REQUEST['orderby']) . '" />' : '';

        if ($_chosen_attributes) {
            foreach ($_chosen_attributes as $attribute => $data) {
                $attr_name = 0 === strpos($attribute, 'pa_') ? substr($attribute, 3) : $attribute;

                $taxonomy_filter = 'filter_' . $attr_name;
                $fields .= '<input type="hidden" name="' . esc_attr($taxonomy_filter) . '" value="' . esc_attr(implode(',', $data['terms'])) . '" />';

                if ('or' == $data['query_type']) {
                    $query_filter = 'query_type_' . $attr_name;
                    $fields .= '<input type="hidden" name="' . esc_attr($query_filter) . '" value="or" />';
                }
            }
        }
        
        // Find min and max price in current result set
        $prices = elessi_get_filtered_price();
        $min = floor($prices->min_price);
        $max = ceil($prices->max_price);

        if ('' == get_option('permalink_structure')) {
            $form_action = remove_query_arg(array('page', 'paged'), add_query_arg($wp->query_string, '', home_url($wp->request)));
        } else {
            $form_action = preg_replace('%\/page/[0-9]+%', '', home_url(trailingslashit($wp->request)));
        }

        if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && !wc_prices_include_tax()) {
            $tax_classes = array_merge(array(''), WC_Tax::get_tax_classes());
            $class_max = $max;

            foreach ($tax_classes as $tax_class) {
                if ($tax_rates = WC_Tax::get_rates($tax_class)) {
                    $class_max = $max + WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($max, $tax_rates));
                }
            }

            $max = $class_max;
        }
        
        $min_price = isset($_REQUEST['min_price']) ? esc_attr($_REQUEST['min_price']) : apply_filters('woocommerce_price_filter_widget_min_amount', $min);
        $max_price = isset($_REQUEST['max_price']) ? esc_attr($_REQUEST['max_price']) : apply_filters('woocommerce_price_filter_widget_max_amount', $max);
        
        if ($min_price < $min) {
            $min = floor($min_price);
        }
        
        if ($max_price > $max) {
            $max = ceil($max_price);
        }

        if ($min == $max) {
            return '<div id="' . $args['widget_id'] . '-ajax-wrap" class="nasa-hide-price nasa-filter-price-widget-wrap' . esc_attr($classWrap) . '">' .
                $args['before_title'] . $instance['title'] . $args['after_title'] .
            '</div>';
        }

        $res = '<div id="' . $args['widget_id'] . '-ajax-wrap" class="nasa-filter-price-widget-wrap' . esc_attr($classWrap) . '">';

        if ($instance['title'] != '') {
            $res .= $args['before_title'] . $instance['title'] . $args['after_title'];
        }

        /**
         * Round one more time
         */
        $data_min = floor($min);
        $data_max = ceil($max);

        $res .=
            '<form method="get" action="' . esc_url($form_action) . '">' .
                '<div class="price_slider_wrapper">' .
                    '<div class="price_slider"></div>' .
                    '<div class="price_slider_amount">' .
                        '<input type="text" id="min_price" name="min_price" value="' . esc_attr($min_price) . '" data-min="' . esc_attr($data_min) . '" placeholder="' . esc_attr__('Min price', 'elessi-theme') . '" />' .
                        '<input type="text" id="max_price" name="max_price" value="' . esc_attr($max_price) . '" data-max="' . esc_attr($data_max) . '" placeholder="' . esc_attr__('Max price', 'elessi-theme') . '" />' .
                        '<div class="price_label">' .
                            esc_html__('Price:', 'elessi-theme') . ' <span class="from"></span> &mdash; <span class="to"></span>' .
                        '</div>' .
                        $fields .
                        '<a href="javascript:void(0);" class="reset_price' . esc_attr($class_reset) . '" rel="nofollow">' . esc_html__('Reset', 'elessi-theme') . '</a>' .
                        '<div class="nasa-clear-both"></div>' .
                        ($instance['btn_filter'] ? '<button type="submit" class="button">' . esc_html__('Filter', 'elessi-theme') . '</button>' : '') .
                    '</div>' .
                '</div>' .
                '<input type="hidden" class="nasa_hasPrice" name="nasa_hasPrice" value="' . esc_attr($hasPrice) . '" />' .
            '</form>';
        
        $res .= '</div>';

        return $res;
    }

endif;

/**
 * Get Role Filter Price
 */
if (!function_exists('elessi_get_filtered_price')) :
    function elessi_get_filtered_price() {
        global $wpdb;

        $args       = WC()->query->get_main_query()->query_vars;
        $tax_query  = isset($args['tax_query']) ? $args['tax_query'] : array();
        $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

        if (!is_post_type_archive('product') && !empty($args['taxonomy']) && !empty($args['term'])) {
            $tax_query[] = WC()->query->get_main_tax_query();
        }

        foreach ($meta_query + $tax_query as $key => $query) {
            if (!empty($query['price_filter']) || ! empty($query['rating_filter'])) {
                unset($meta_query[$key]);
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query  = new WP_Tax_Query($tax_query);
        $search     = WC_Query::get_main_search_query_sql();

        $meta_query_sql   = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql    = $tax_query->get_sql($wpdb->posts, 'ID');
        $search_query_sql = $search ? ' AND ' . $search : '';

        $sql = "
            SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
            FROM {$wpdb->wc_product_meta_lookup}
            WHERE product_id IN (
                SELECT ID FROM {$wpdb->posts}
                " . $tax_query_sql['join'] . $meta_query_sql['join'] . "
                WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
                AND {$wpdb->posts}.post_status = 'publish'
                " . $tax_query_sql['where'] . $meta_query_sql['where'] . $search_query_sql . '
            )';

        $sql = apply_filters('woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql);

        return $wpdb->get_row($sql); // WPCS: unprepared SQL ok.
    }
endif;

/**
 * Variation content widget
 */
if (!function_exists('elessi_get_content_widget_variation')) :
    function elessi_get_content_widget_variation($args, $instance) {
        $args = array('widget_id' => $args['widget_id']);

        $hide_widget = false;
        $hide_empty = isset($instance['hide_empty']) && $instance['hide_empty'] ? true : false;
        $var_exist = $hide_empty ? false : true;

        $taxonomy = isset($instance['attribute']) ? wc_attribute_taxonomy_name($instance['attribute']) : '';

        if (!taxonomy_exists($taxonomy)) {
            $hide_widget = true;
            return array('hide_widget' => $hide_widget, 'content' => '');
        }

        $content = '<div id="' . esc_attr($args['widget_id']) . '-ajax-wrap" class="nasa-filter-variations-widget-wrap">';

        $query_type = isset($instance['query_type']) ? $instance['query_type'] : 'or';
        $terms_args = array('taxonomy' => $taxonomy, 'hide_empty' => $hide_empty);
        $orderby = wc_attribute_orderby($taxonomy);

        switch ($orderby) {
            case 'name' :
                $terms_args['orderby'] = 'name';
                $terms_args['menu_order'] = false;
                break;
            case 'id' :
                $terms_args['orderby'] = 'id';
                $terms_args['order'] = 'ASC';
                $terms_args['menu_order'] = false;
                break;
            case 'menu_order' :
            default:
                $terms_args['menu_order'] = 'ASC';
                break;
        }

        $terms = get_terms(apply_filters('woocommerce_product_attribute_terms', $terms_args));

        $hasResult = false;
        $count_terms = $terms ? count($terms) : 0;
        if (0 < $count_terms) {
            $term_counts = elessi_get_filtered_term_product_counts(wp_list_pluck($terms, 'term_id'), $taxonomy, $query_type);

            $attr_name = 0 === strpos($taxonomy, 'pa_') ? substr($taxonomy, 3) : $taxonomy;
            $filter_name = 'filter_' . $attr_name;
            $current_filter = array();
            if (isset($_REQUEST[$filter_name]) && $_REQUEST[$filter_name] != '') {
                $current_filter = is_array($_REQUEST[$filter_name]) ?
                    $_REQUEST[$filter_name] : explode(',', wc_clean($_REQUEST[$filter_name]));
            }

            $current_filter = array_map('sanitize_title', $current_filter);
            $vari_type = 'default';
            $taxonomyObj = null;
            $color_size = true;

            $color_switch = 'color';
            $label_switch = 'label';
            $image_switch = 'image';
            if ($nasa_attr_ux_exist = class_exists('Nasa_Abstract_WC_Attr_UX')) {
                $taxonomyObj = Nasa_Abstract_WC_Attr_UX::get_tax_attribute($taxonomy);
                $color_switch = Nasa_Abstract_WC_Attr_UX::_NASA_COLOR;
                $label_switch = Nasa_Abstract_WC_Attr_UX::_NASA_LABEL;
                $image_switch = Nasa_Abstract_WC_Attr_UX::_NASA_IMAGE;
            }

            $class_ul = ' small-block-grid-1 medium-block-grid-4 large-block-grid-5';
            
            $brand_items = false;
            
            if ($taxonomyObj && isset($taxonomyObj->attribute_type)) {
                switch ($taxonomyObj->attribute_type) {
                    case $color_switch:
                        $vari_type = 'color';
                        $class_ul = ' small-block-grid-1 medium-block-grid-4 large-block-grid-7';
                        break;

                    case $label_switch:
                        $vari_type = 'size';
                        $class_ul = ' small-block-grid-1 medium-block-grid-4 large-block-grid-7';
                        break;

                    case $image_switch:
                        $vari_type = 'image';
                        
                        global $nasa_opt;
                        
                        $nasa_brands = isset($nasa_opt['attr_brands']) && !empty($nasa_opt['attr_brands']) ? $nasa_opt['attr_brands'] : array();
                        $brands = array();
                        if (!empty($nasa_brands)) {
                            foreach ($nasa_brands as $key => $val) {
                                if ($val === '1') {
                                    $brands[] = $key;
                                }
                            }
                        }
                        if (!empty($brands) && in_array($attr_name, $brands)) {
                            $class_ul = ' nasa-variation-filters-brands small-block-grid-2 medium-block-grid-4 large-block-grid-6';
                            $brand_items = true;
                        }
                        
                        break;

                    default :
                        $color_size = false;
                        break;
                }
            }

            $show_items = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;

            // Current term
            $queryObj = get_queried_object();
            $current_term_slug = absint((is_tax() && isset($queryObj->slug)) ? $queryObj->slug : 0);

            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            $content_li = '';
            foreach ($terms as $k => $term) {
                $count = isset($term_counts[$term->term_id]) ? $term_counts[$term->term_id] : 0;
                $term_meta = $color_size ? get_term_meta($term->term_id, $taxonomyObj->attribute_type, true) : null;
                $vari_txt = ($vari_type == 'size' && trim($term_meta) != '') ? $term_meta : $term->name;
                
                $content_text = '<span class="nasa-text-variation nasa-text-variation-' . $vari_type . '">';
                $content_text .= $vari_txt;
                $content_text .= '</span>';

                /**
                 * Link
                 */
                $current_filter_term = $current_filter;
                $current_values = isset($_chosen_attributes[$taxonomy]['terms']) ? $_chosen_attributes[$taxonomy]['terms'] : array();
                $option_is_set = in_array($term->slug, $current_values);

                if (!in_array($term->slug, $current_filter_term)) {
                    $current_filter_term[] = $term->slug;
                }
                
                $link = elessi_get_page_base_url($taxonomy);

                // Add current filters to URL.
                foreach ($current_filter_term as $key => $value) {
                    // Exclude query arg for current term archive term
                    if ($value === $current_term_slug) {
                        unset($current_filter_term[$key]);
                    }

                    // Exclude self so filter can be unset on click.
                    if ($option_is_set && $value === $term->slug) {
                        unset($current_filter_term[$key]);
                    }
                }

                if (!empty($current_filter_term)) {
                    $link = add_query_arg($filter_name, implode(',', $current_filter_term), $link);

                    // Add Query type Arg to URL
                    if ('or' === $query_type && !(1 === sizeof($current_filter_term) && $option_is_set)) {
                        $attr_name = 0 === strpos($taxonomy, 'pa_') ? substr($taxonomy, 3) : $taxonomy;
                        $link = add_query_arg('query_type_' . sanitize_title($attr_name), 'or', $link);
                    }
                }

                if ($count > 0 || $option_is_set) {
                    $link = esc_url(apply_filters('woocommerce_layered_nav_link', $link, $term, $taxonomy));
                }

                /**
                 * Current Filter = this widget
                 */
                if (isset($current_filter) && is_array($current_filter) && in_array($term->slug, $current_filter)) {
                    $class = ' chosen nasa-chosen';
                    $aclass = ' nasa-filter-var-chosen';
                } else {
                    $class = $aclass = '';
                }

                $countClss = 'count';
                if ($vari_type != '') {
                    $class .= ' nasa-li-filter-' . $vari_type;
                    $aclass .= ' nasa-filter-' . $vari_type;
                    $countClss .= ' nasa-count-filter-' . $vari_type;
                }
                
                $aclass .= $brand_items ? ' nasa-filter-brand-item' : '';

                if ($count) {
                    $hasResult = true;
                    $var_exist = true;
                } else if (!$count && $hide_empty) {
                    $class .= ' nasa-empty-hidden';
                    $show_items = $show_items > 0 ? $show_items += 1 : $show_items;
                }

                $attr_name = 0 === strpos($term->taxonomy, 'pa_') ? substr($term->taxonomy, 3) : $term->taxonomy;
                $attr = esc_attr(sanitize_title($attr_name));
                $liClass = ($k % 2 == 0) ? 'nasa-odd' : 'nasa-even';

                $liClass .= ' no-hidden';
                $style = ($vari_type == 'color') ? ' style="background:' . esc_attr($term_meta) . '"' : '';

                $liClass .= ($show_items > 0 && $k >= $show_items) ? ' nasa-show-less' : '';

                $content_li .= '<li class="' . $liClass . $class . ' nasa-attr-' . $attr . ' nasa_' . $attr . '_' . esc_attr($term->term_id) . '">';

                $content_li .= 
                '<a ' .
                    'class="nasa-filter-by-variations' . $aclass . '" ' .
                    'title="' . esc_attr($vari_txt) . '" ' .
                    'data-term_id="' . esc_attr($term->term_id) . '" ' .
                    'data-term_slug="' . esc_attr($term->slug) . '" ' .
                    'data-attr="' . $attr . '" ' .
                    'data-type="' . esc_attr($query_type) . '" ' .
                    'href="' . ($link ? esc_attr($link) : 'javascript:void(0);') . '"' .
                '>';

                $content_li .= $vari_type == 'color' ? '<span class="nasa-filter-color-span" ' . $style . '></span>' : '';

                if ($vari_type == 'image' && $nasa_attr_ux_exist) {
                    if (class_exists('Nasa_Abstract_WC_Attr_UX')) {
                        $image_size = $brand_items ? 'full' : 28;
                        $img_html = Nasa_Abstract_WC_Attr_UX::get_image_preview($term_meta, false, $image_size, 28, $vari_txt);
                    } else {
                        $img_html = wp_get_attachment_image($term_meta, 'thumbnail', false, array('alt' => $vari_txt, 'class' => 'attr-image-preview'));
                    }
                    
                    $img_html = $img_html ? $img_html : wc_placeholder_img();
                    
                    $content_li .= '<span class="nasa-filter-image-span">' . $img_html . '</span>';
                }

                $content_li .= $content_text;
                
                if (isset($instance['count']) && $instance['count']) {
                    $content_li .= isset($instance['count']) && $instance['count'] ? ' <span class="' . $countClss . '">' . $count . '</span>' : '';
                }
                
                $content_li .= '</a>';
                
                $content_li .= '</li>';
            }

            $hide_widget = !$hasResult && $hide_empty ? true : false;
            if (!$hide_widget && !$var_exist) {
                $hide_widget = true;
            }

            if ($hide_widget) {
                return array('hide_widget' => $hide_widget, 'content' => '');
            }

            $content_ul = '<ul class="nasa-variation-filters nasa-variations-' . $vari_type . $class_ul . '">';

            $fadeIn = (isset($instance['effect']) && $instance['effect'] == 'fade') ? '1' : '0';
            $content_li .= ($show_items && ($count_terms > $show_items)) ?
                '<li class="nasa_show_manual" data-fadein="' . $fadeIn . '">' .
                    '<a data-show="1" class="nasa-show-more" href="javascript:void(0);" data-text="' . esc_attr__('- Show less', 'elessi-theme') . '" rel="nofollow">' .
                        esc_html__('+ Show more', 'elessi-theme') .
                    '</a>' .
                '</li>' : '';

            $content .= $content_ul . $content_li . '</ul></div>';

            return array('hide_widget' => $hide_widget, 'content' => $content);
        }

        return array('hide_widget' => true, 'content' => '');
    }
endif;

/*
 * Get term count variations
 */
if (!function_exists('elessi_get_filtered_term_product_counts')) :
    function elessi_get_filtered_term_product_counts($term_ids, $taxonomy, $query_type) {
        global $wpdb;

        $meta_query = WC_Query::get_main_meta_query();
        $tax_query = WC_Query::get_main_tax_query();

        if ('or' === $query_type) {
            foreach ($tax_query as $key => $query) {
                if (isset($query['taxonomy']) && $taxonomy === $query['taxonomy']) {
                    unset($tax_query[$key]);
                }
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query = new WP_Tax_Query($tax_query);
        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

        // Generate query
        $query = array();
        $query['select'] = 'SELECT COUNT(DISTINCT ' . $wpdb->posts . '.ID) as term_count, terms.term_id as term_count_id';

        $query['from'] = 'FROM ' . $wpdb->posts;

        $query['join'] = 'INNER JOIN ' . $wpdb->term_relationships . ' AS term_relationships ON ' . $wpdb->posts . '.ID = term_relationships.object_id ' .
            'INNER JOIN ' . $wpdb->term_taxonomy . ' AS term_taxonomy USING(term_taxonomy_id) ' .
            'INNER JOIN ' . $wpdb->terms . ' AS terms USING(term_id) ' .
            $tax_query_sql['join'] . $meta_query_sql['join'];

        $query['where'] = 'WHERE ' . $wpdb->posts . '.post_type LIKE "product" ' .
            'AND ' . $wpdb->posts . '.post_status LIKE "publish" ' .
            $tax_query_sql['where'] . $meta_query_sql['where'] . ' ' .
            'AND terms.term_id IN (' . implode(',', array_map('absint', $term_ids)) . ')';

        // For search case
        if (isset($_GET['s']) && $_GET['s']) {
            $s = esc_sql(str_replace(array("\r", "\n"), '', stripslashes($_GET['s'])));

            $query['where'] .= ' AND (' . $wpdb->posts . '.post_title LIKE "%' . $s . '%" OR ' . $wpdb->posts . '.post_excerpt LIKE "%' . $s . '%" OR ' . $wpdb->posts . '.post_content LIKE "%' . $s . '%")';
        }

        $query['group_by'] = "GROUP BY terms.term_id";
        $queryString = implode(' ', apply_filters('woocommerce_get_filtered_term_product_counts_query', $query));
        $results = $wpdb->get_results($queryString);

        return wp_list_pluck($results, 'term_count', 'term_count_id');
    }
endif;

/**
 * Return the currently viewed term slug.
 * @return int
 */
if (!function_exists('elessi_get_current_term_slug')) :
    function elessi_get_current_term_slug() {
        return absint(is_tax() ? get_queried_object()->slug : 0);
    }
endif;

/**
 * Get current page URL for layered nav items.
 * @return string
 */
if (!function_exists('elessi_get_page_base_url')) :
    function elessi_get_page_base_url($taxonomy) {
        if (defined('SHOP_IS_ON_FRONT')) {
            $link = home_url('/');
        } elseif (is_post_type_archive('product') || is_page(wc_get_page_id('shop'))) {
            $link = get_post_type_archive_link('product');
        } elseif (is_product_category()) {
            $link = get_term_link(get_query_var('product_cat'), 'product_cat');
        } elseif (is_product_tag()) {
            $link = get_term_link(get_query_var('product_tag'), 'product_tag');
        } else {
            $queried_object = get_queried_object();
            $link = get_term_link($queried_object, $queried_object->taxonomy);
        }

        /**
         * Custom taxonomy
         */
        if (class_exists('Nasa_WC_Taxonomy')) {
            $nasa_taxonomy = apply_filters('nasa_taxonomy_custom_cateogory', Nasa_WC_Taxonomy::$nasa_taxonomy);
            if (isset($_REQUEST[$nasa_taxonomy])) {
                $link = add_query_arg($nasa_taxonomy, wc_clean(wp_unslash($_REQUEST[$nasa_taxonomy])), $link);
            }
        }

        // Min
        if (isset($_REQUEST['min_price'])) {
            $link = add_query_arg('min_price', wc_clean(wp_unslash($_REQUEST['min_price'])), $link);
        }

        // Max
        if (isset($_REQUEST['max_price'])) {
            $link = add_query_arg('max_price', wc_clean(wp_unslash($_REQUEST['max_price'])), $link);
        }

        // Orderby
        if (isset($_REQUEST['orderby'])) {
            $link = add_query_arg('orderby', wc_clean(wp_unslash($_REQUEST['orderby'])), $link);
        }

        /**
         * Search Arg.
         * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
         */
        if (get_search_query()) {
            $link = add_query_arg('s', rawurlencode(wp_specialchars_decode(get_search_query())), $link);
        }

        // Post Type Arg
        if (isset($_REQUEST['post_type'])) {
            $link = add_query_arg('post_type', wc_clean(wp_unslash($_REQUEST['post_type'])), $link);
            
            // Prevent post type and page id when pretty permalinks are disabled.
            if ( is_shop() ) {
                $link = remove_query_arg('page_id', $link);
            }
        }

        // Min Rating Arg
        if (isset($_REQUEST['rating_filter'])) {
            $link = add_query_arg('rating_filter', wc_clean(wp_unslash($_REQUEST['rating_filter'])), $link);
        }
        
        // Filter Status
        if (class_exists('Elessi_WC_Widget_Status_Filter')) {
            foreach (Elessi_WC_Widget_Status_Filter::$_status as $status) {
                if (isset($_REQUEST[$status]) && $_REQUEST[$status] === '1') {
                    $link = add_query_arg($status, '1', $link);
                }
            }
        }
        
        // Filter Multi Tags
        if (class_exists('Elessi_WC_Widget_Tags_Filter')) {
            if (isset($_REQUEST[Elessi_WC_Widget_Tags_Filter::$_request_name]) && !empty($_REQUEST[Elessi_WC_Widget_Tags_Filter::$_request_name])) {
                $link = add_query_arg(Elessi_WC_Widget_Tags_Filter::$_request_name, rawurlencode(wc_clean($_REQUEST[Elessi_WC_Widget_Tags_Filter::$_request_name])), $link);
            }
        }

        // All current filters
        if ($_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes()) {
            $taxonomy = wc_attribute_taxonomy_slug($taxonomy);
            
            foreach ($_chosen_attributes as $name => $data) {
                $filter_name = wc_attribute_taxonomy_slug($name);
                if ($taxonomy == $filter_name) {
                    continue;
                }
                
                if (!empty($data['terms'])) {
                    $link = add_query_arg('filter_' . $filter_name, implode(',', $data['terms']), $link);
                }
                if ('or' === $data['query_type']) {
                    $link = add_query_arg('query_type_' . $filter_name, 'or', $link);
                }
            }
        }
        
        return apply_filters('nasa_page_base_url', $link);
    }
endif;

/**
 * Get current page URL Origin Not Request GET.
 * @return string
 */
if (!function_exists('elessi_get_origin_url')) :
    function elessi_get_origin_url() {
        global $wp, $nasa_origin_url;
        
        if (!isset($nasa_origin_url)) {
            $nasa_origin_url = get_option('permalink_structure') == '' ?
                remove_query_arg(array('page', 'paged'), add_query_arg($wp->query_string, '', home_url($wp->request . '/'))) :
                preg_replace('%\/page/[0-9]+%', '', home_url($wp->request . '/'));

            $GLOBALS['nasa_origin_url'] = $nasa_origin_url;
        }
        
        return apply_filters('nasa_origin_url', $nasa_origin_url);
    }
endif;

/**
 * Get current page URL Origin Not Request GET But Has Paged.
 * @return string
 */
if (!function_exists('elessi_get_origin_url_paging')) :
    function elessi_get_origin_url_paging() {
        global $wp, $nasa_origin_url_paging;
        
        if (!isset($nasa_origin_url_paging)) {
            $nasa_origin_url_paging = get_option('permalink_structure') == '' ?
                add_query_arg($wp->query_string, '', home_url($wp->request . '/')) :
                home_url($wp->request . '/');

            $GLOBALS['nasa_origin_url_paging'] = $nasa_origin_url_paging;
        }
        
        return apply_filters('nasa_origin_url_paging', $nasa_origin_url_paging);
    }
endif;

/**
 * Remove defaults widgets of Woocommerce
 */
// add_action('init', 'elessi_remove_default_wg_woo');
if (!function_exists('elessi_remove_default_wg_woo')) :
    function elessi_remove_default_wg_woo() {
        global $nasa_opt;

        if ((!isset($nasa_opt['disable_ajax_product']) || !$nasa_opt['disable_ajax_product'])) {
            unregister_widget('WC_Widget_Price_Filter');
            unregister_widget('WC_Widget_Layered_Nav');
            unregister_widget('WC_Widget_Layered_Nav_Filters');
            unregister_widget('WC_Widget_Rating_Filter');
            unregister_widget('WC_Widget_Product_Search');
        }
    }
endif;
