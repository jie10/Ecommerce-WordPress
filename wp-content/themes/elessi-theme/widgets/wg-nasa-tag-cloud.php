<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Register Widget
 */
add_action('widgets_init', 'elessi_tag_cloud_widget');
function elessi_tag_cloud_widget() {
    register_widget('Elessi_Widget_Tag_Cloud');
}

/**
 * Tags Cloud Widget
 */
class Elessi_Widget_Tag_Cloud extends WP_Widget {

    /**
     * Sets up a new Ace Tag Cloud widget instance.
     */
    public function __construct() {
        $widget_ops = array(
            'description' => esc_html__('A cloud of your most used tags.', 'elessi-theme'),
            'customize_selective_refresh' => true,
            'title' => esc_html__('Tags', 'elessi-theme'),
            'show_items' => 'All'
        );
        
        parent::__construct('nasa_tag_cloud', esc_html__('Nasa Tag Cloud', 'elessi-theme'), $widget_ops);
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance) {
        $class = $data_taxonomy = '';
        
        if (isset($instance['taxonomy']) && in_array($instance['taxonomy'], array('product_cat', 'product_tag'))) {
            $class = ' nasa-tag-cloud';
            $class .= $instance['taxonomy'] == 'product_tag' ? ' nasa-tag-products-cloud' : '';
            $data_taxonomy = ' data-taxonomy="' . esc_attr($instance['taxonomy']) . '"';
        }
        
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        $title_widget = (!empty($instance['title'])) ? $instance['title'] : ('post_tag' == $current_taxonomy ? esc_html__('Tags', 'elessi-theme') : get_taxonomy($current_taxonomy)->labels->name);

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters('widget_title', $title_widget, $instance, $this->id_base);

        echo $args['before_widget'];
        echo $title ? $args['before_title'] . $title . $args['after_title'] : '';
        echo '<div class="tagcloud' . $class . '"' . $data_taxonomy . '>';

        $show_items = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;
        
        $tags = wp_tag_cloud(apply_filters('widget_tag_cloud_args', array(
            'taxonomy' => $current_taxonomy,
            'format' => 'array'
        )));
        
        if ($tags) {
            echo '<ul class="nasa-tag-cloud-ul">';
            
            foreach ($tags as $k => $tag) {
                $class = ($show_items && $k+1 > $show_items) ? ' class="nasa-show-less"' : '';
                echo '<li' . $class . '>' . $tag . '</li>';
            }

            if ($show_items) {
                echo 
                '<li class="nasa_show_manual" data-delay="500" data-fadein="1">' .
                    '<a data-show="1" class="nasa-show" href="javascript:void(0);" data-text="' . esc_attr__('- Show less', 'elessi-theme') . '" rel="nofollow">' .
                        esc_html__('+ Show more', 'elessi-theme') .
                    '</a>' .
                '</li>';
            }
            
            echo '</ul>';
        }

        echo "</div>\n";
        echo $args['after_widget'];
    }

    /**
     * Handles updating settings for the current Tag Cloud widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Settings to save or bool false to cancel saving.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
        $instance['show_items'] = sanitize_text_field($new_instance['show_items']);
        
        return $instance;
    }

    /**
     * Outputs the Tag Cloud widget settings form.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form($instance) {
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        $title_id = esc_attr($this->get_field_id('title'));
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';

        echo 
        '<p>' .
            '<label for="' . $title_id . '">' . esc_html__('Title:', 'elessi-theme') . '</label>' .
            '<input type="text" class="widefat" id="' . $title_id . '" name="' . esc_attr($this->get_field_name('title')) . '" value="' . $title . '" />' .
        '</p>';

        $taxonomies = get_taxonomies(array('show_tagcloud' => true), 'object');
        $id = esc_attr($this->get_field_id('taxonomy'));
        $name = esc_attr($this->get_field_name('taxonomy'));
        $input = '<input type="hidden" id="' . $id . '" name="' . $name . '" value="%s" />';

        switch (count($taxonomies)) {
            // No tag cloud supporting taxonomies found, display error message
            case 0:
                echo '<p>' . esc_html__('The tag cloud will not be displayed since there are no taxonomies that support the tag cloud widget.', 'elessi-theme') . '</p>';
                printf($input, '');
                break;

            // Just a single tag cloud supporting taxonomy found, no need to display options
            case 1:
                $keys = array_keys($taxonomies);
                $taxonomy = reset($keys);
                printf($input, esc_attr($taxonomy));
                break;

            // More than one tag cloud supporting taxonomy found, display options
            default:
                printf(
                    '<p><label for="%1$s">%2$s</label>' .
                    '<select class="widefat" id="%1$s" name="%3$s">', $id, esc_html__('Taxonomy:', 'elessi-theme'), $name
                );

                foreach ($taxonomies as $taxonomy => $tax) {
                    printf(
                        '<option value="%s"%s>%s</option>', esc_attr($taxonomy), selected($taxonomy, $current_taxonomy, false), $tax->labels->name
                    );
                }

                echo '</select></p>';
        }

        $show_items = $this->get_field_id('show_items');
        $val_show = (isset($instance['show_items']) && is_numeric($instance['show_items']) ? $instance['show_items'] : esc_attr__('All', 'elessi-theme'));
        echo 
        '<p>' .
            '<label for="' . esc_attr($show_items) . '">' . esc_html__('Show items (0 ~ All)', 'elessi-theme') . '</label>' .
            '<input type="text" class="widefat" id="' . esc_attr($show_items) . '" name="' . esc_attr($this->get_field_name('show_items')) . '" value="' . $val_show . '" />' .
        '</p>';
    }

    /**
     * Retrieves the taxonomy for the current Tag cloud widget instance.
     *
     * @since 4.4.0
     * @access public
     *
     * @param array $instance Current settings.
     * @return string Name of the current taxonomy if set, otherwise 'post_tag'.
     */
    public function _get_current_taxonomy($instance) {
        if (!empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy'])) {
            return $instance['taxonomy'];
        }

        return 'post_tag';
    }
}
