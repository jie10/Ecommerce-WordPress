<?php
$image_size = 'medium';
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
$auto_slide = isset($auto_slide) ? $auto_slide : 'false';
$dots = isset($dots) ? $dots : 'false';
$arrows = isset($arrows) ? $arrows : 1;

$cats_enable = $author_enable = $date_enable = $date_author = $des_enable = 'no';

$class_slide = 'nasa-blog-carousel nasa-slider-items-margin nasa-slick-slider';
$class_slide .= $arrows == 1 ? ' nasa-slick-nav nasa-nav-top' : '';

$columns_number_small = isset($nasa_opt['relate_blogs_columns_small']) && (int) $nasa_opt['relate_blogs_columns_small'] ? (int) $nasa_opt['relate_blogs_columns_small'] : 1;
$columns_number_tablet = isset($nasa_opt['relate_blogs_columns_tablet']) && (int) $nasa_opt['relate_blogs_columns_tablet'] ? (int) $nasa_opt['relate_blogs_columns_tablet'] : 2;
$columns_number = isset($nasa_opt['relate_blogs_columns_desk']) && (int) $nasa_opt['relate_blogs_columns_desk'] ? (int) $nasa_opt['relate_blogs_columns_desk'] : 3;
?>

<div class="nasa-blogs-relate nasa-relative nasa-slide-style-blogs nasa-slider-wrap">
    <h3 class="nasa-shortcode-title-slider text-center">
        <?php esc_html_e('Related posts', 'nasa-core'); ?>
    </h3>
    
    <div
        class="<?php echo esc_attr($class_slide); ?>"
        data-columns="<?php echo esc_attr($columns_number); ?>"
        data-columns-small="<?php echo esc_attr($columns_number_small); ?>"
        data-columns-tablet="<?php echo esc_attr($columns_number_tablet); ?>"
        data-switch-tablet="<?php echo nasa_switch_tablet(); ?>"
        data-switch-desktop="<?php echo nasa_switch_desktop(); ?>">
        <?php
        foreach ($relate as $post_relate) :
            $title = $post_relate->post_title;
            $link = get_the_permalink($post_relate);
            $postId = $post_relate->ID;
            $categories = ($cats_enable == 'yes') ? get_the_category_list(esc_html__(', ', 'nasa-core')) : '';

            if ($author_enable == 'yes') :
                $author = get_the_author();
                $author_id = get_the_author_meta('ID');
                $link_author = get_author_posts_url($author_id);
            endif;

            if ($date_enable == 'yes') :
                $day = get_the_time('d', $postId);
                $month = get_the_time('m', $postId);
                $year = get_the_time('Y', $postId);
                $link_date = get_day_link($year, $month, $day);
                $date_post = get_the_time('d F', $postId);
            endif;

            ?>
            <div class="blog-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms">
                <div class="nasa-content-group">
                    <?php if (has_post_thumbnail($post_relate)): ?>
                        <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                            <div class="blog-image-attachment">
                                <?php echo get_the_post_thumbnail($post_relate, $image_size, array(
                                    'alt' => trim(strip_tags(get_the_title()))
                                )); ?>
                            </div>
                        </a>
                    <?php endif; ?>
                    <div class="nasa-blog-info-slider">
                        <?php echo ($cats_enable == 'yes') ? '<div class="nasa-post-cats-wrap">' . $categories . '</div>' : ''; ?>
                        <a class="nasa-blog-title" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                            <?php echo ($title); ?>
                        </a>

                        <?php if ($date_author == 'top') : ?>
                            <div class="nasa-post-date-author-wrap">
                                <?php if ($date_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_html__('Posts at ', 'nasa-core') . esc_attr($date_post); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-timer"></i>
                                            <?php echo $date_post; ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($author_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_html__('Posted By ', 'nasa-core') . esc_attr($author); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author nasa-post-author">
                                            <i class="pe-7s-user"></i>
                                            <?php echo ($author); ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($readmore == 'yes') : ?>
                                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html__('Read more', 'nasa-core'); ?>" class="nasa-post-date-author-link hide-for-mobile nasa-post-read-more">
                                        <span class="nasa-post-date-author nasa-post-author">
                                            <i class="pe-7s-more margin-right-5"></i>
                                            <?php echo esc_html__('Read more', 'nasa-core'); ?>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($des_enable == 'yes') : ?>
                            <div class="nasa-info-short">
                                <?php echo get_the_excerpt($post_relate); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($date_author == 'bot') : ?>
                            <div class="nasa-post-date-author-wrap">
                                <?php if ($date_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_html__('Posts at ', 'nasa-core') . esc_attr($date_post); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author bottom">
                                            <i class="pe-7s-timer"></i>
                                            <?php echo ($date_post); ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($author_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_html__('Posted By ', 'nasa-core') . esc_attr($author); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author nasa-post-author bottom">
                                            <i class="pe-7s-user"></i>
                                            <?php echo ($author); ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($readmore == 'yes') : ?>
                                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html__('Read more', 'nasa-core'); ?>" class="nasa-post-date-author-link hide-for-mobile nasa-post-read-more">
                                        <span class="nasa-post-date-author nasa-post-author bottom">
                                            <i class="pe-7s-more margin-right-5"></i>
                                            <?php echo esc_html__('Read more', 'nasa-core'); ?>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php $_delay += $_delay_item; ?>
        <?php endforeach; ?>
    </div>
</div>
