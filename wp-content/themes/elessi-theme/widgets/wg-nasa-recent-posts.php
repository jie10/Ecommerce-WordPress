<?php
defined('ABSPATH') or die(); // Exit if accessed directly

if (class_exists('WP_Widget')) {
    
    add_action('widgets_init', 'elessi_posts_widget');
    function elessi_posts_widget() {
        register_widget('Elessi_Post_Widget');
    }

    class Elessi_Post_Widget extends WP_Widget {

        /**
         * 
         * Contructor
         */
        function __construct() {
            $widget_ops = array('classname' => 'widget_nasa_posts', 'description' => esc_html__('Nasa widget displays recent posts', 'elessi-theme'));
            parent::__construct('nasa_posts', esc_html__('Nasa Posts', 'elessi-theme'), $widget_ops);
        }

        /**
         * 
         * Render widget content
         */
        function widget($args, $instance) {
            if (!isset($args['widget_id'])) {
                $args['widget_id'] = $this->id;
            }

            $title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Recent Posts', 'elessi-theme') : $instance['title'], $instance, $this->id_base);
            $number = !empty($instance['number']) && (int) $instance['number'] ? (int) $instance['number'] : 5;

            $r = new WP_Query(apply_filters('widget_posts_args', array(
                'posts_per_page'      => $number,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
            ), $instance));

            if ($r->have_posts()) :
                echo ($args['before_widget']);
                echo ($title) ? $args['before_title'] . $title . $args['after_title'] : ''; ?>
                <ul>
                    <?php
                    while ($r->have_posts()) :
                        $r->the_post();
                        $title_post = get_the_title();
                        $link_post = get_the_permalink();
                        $categories = get_the_category_list(esc_html__(', ', 'elessi-theme'));
                        $class_col = 'large-12 columns';
                        ?>
                        <li class="nasa-recent-posts-li">
                            <div class="row">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="large-4 medium-4 small-4 columns nasa-thumbnail-post rtl-right">
                                        <a href="<?php echo esc_url($link_post); ?>" title="<?php echo esc_attr($title_post); ?>">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </a>
                                    </div>
                                    <?php
                                    $class_col = 'large-8 medium-8 small-8 columns rtl-right';
                                endif; ?>
                                <div class="<?php echo esc_attr($class_col); ?> nasa-info-post">
                                    <div class="nasa-post-cats-wrap"><?php echo $categories; ?></div>
                                    <a class="nasa-wg-recent-post-title" href="<?php echo esc_url($link_post); ?>" title="<?php echo esc_attr($title_post); ?>">
                                        <?php echo $title_post; ?>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <?php
                echo ($args['after_widget']);

                wp_reset_postdata();
            endif;
        }

        /**
         * 
         * Update instance
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['number'] = (int) $new_instance['number'];

            return $instance;
        }

        /**
         * 
         * Render widget form dashboard
         */
        function form($instance) {
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            $number = isset($instance['number']) ? absint($instance['number']) : 5;
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'elessi-theme'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts to show:', 'elessi-theme'); ?></label>
                <input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" />
            </p>
            <?php
        }
    }
}
