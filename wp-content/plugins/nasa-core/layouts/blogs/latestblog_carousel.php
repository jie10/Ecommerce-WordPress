<?php
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
$auto_slide = isset($auto_slide) ? $auto_slide : 'false';
$dots = isset($dots) ? $dots : 'false';
$arrows = isset($arrows) ? $arrows : 0;
$class_slider = 'nasa-blog-carousel nasa-slider-items-margin nasa-slick-slider';
$class_slider .= $arrows ? ' nasa-slick-nav nasa-nav-radius' : '';

$columns_small = $columns_number_small_slider == '1.5' ? '1' : $columns_number_small_slider;

/**
 * Attributes sliders
 */
$data_attrs = array();
$data_attrs[] = 'data-columns="' . esc_attr($columns_number) . '"';
$data_attrs[] = 'data-columns-small="' . esc_attr($columns_small) . '"';
$data_attrs[] = 'data-columns-tablet="' . esc_attr($columns_number_tablet) . '"';
$data_attrs[] = 'data-autoplay="' . esc_attr($auto_slide) . '"';
$data_attrs[] = 'data-dot="' . esc_attr($dots) . '"';
$data_attrs[] = 'data-switch-tablet="' . nasa_switch_tablet() . '"';
$data_attrs[] = 'data-switch-desktop="' . nasa_switch_desktop() . '"';

if ($columns_number_small_slider == '1.5') {
    $data_attrs[] = 'data-padding-small="20%"';
}

$attrs_str = !empty($data_attrs) ? ' ' . implode(' ', $data_attrs) : '';
?>

<div class="nasa-relative nasa-slider-wrap nasa-slide-style-blogs">
    <div
        class="<?php echo esc_attr($class_slider); ?>"<?php echo $attrs_str; ?>>
        <?php
        while ($recentPosts->have_posts()) :
            $recentPosts->the_post();
            $title = get_the_title();
            $link = get_the_permalink();
            $postId = get_the_ID();
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

                <div class="nasa-blog-item-wrap">
                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                        <div class="blog-image-attachment">
                            <?php
                            if (has_post_thumbnail()):
                                the_post_thumbnail('380x380', array(
                                    'alt' => trim(strip_tags(get_the_title()))
                                ));
                            else:
                                echo '<img src="' . NASA_CORE_PLUGIN_URL . 'assets/images/placeholder.png" alt="' . esc_attr($title) . '" />';
                            endif;
                            ?>
                        </div>
                    </a>
                    
                    <div class="nasa-blog-info-slider">
                        <?php echo ($cats_enable == 'yes') ? '<div class="nasa-post-cats-wrap">' . $categories . '</div>' : ''; ?>
                        <a class="nasa-blog-title" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>"><?php echo $title; ?></a>

                        <?php if ($date_author == 'top') : ?>
                            <div class="nasa-post-date-author-wrap">
                                <?php if ($date_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_html__('Posts at ', 'nasa-core') . esc_attr($date_post); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-date"></i>
                                            <?php echo $date_post; ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($author_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_html__('Posted By ', 'nasa-core') . esc_attr($author); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-user"></i>
                                            <?php echo $author; ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($readmore == 'yes') : ?>
                                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html__('Read more', 'nasa-core'); ?>" class="nasa-post-date-author-link hide-for-mobile nasa-post-read-more">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-news-paper"></i>
                                            <?php echo esc_html__('Read more', 'nasa-core'); ?>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($des_enable == 'yes') : ?>
                            <div class="nasa-info-short"><?php the_excerpt(); ?></div>
                        <?php endif; ?>

                        <?php if ($date_author == 'bot') : ?>
                            <div class="nasa-post-date-author-wrap">
                                <?php if ($date_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_html__('Posts at ', 'nasa-core') . esc_attr($date_post); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-date"></i>
                                            <?php echo $date_post; ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($author_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_html__('Posted By ', 'nasa-core') . esc_attr($author); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-user"></i>
                                            <?php echo $author; ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($readmore == 'yes') : ?>
                                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html__('Read more', 'nasa-core'); ?>" class="nasa-post-date-author-link hide-for-mobile nasa-post-read-more">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-news-paper"></i>
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
        <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>

<?php if ($page_blogs == 'yes') : ?>
    <div class="text-center margin-bottom-40">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" title="<?php echo esc_html__('All Blogs', 'nasa-core'); ?>" class="nasa-view-more button">
            <?php echo esc_html__('All Blogs', 'nasa-core'); ?>
        </a>
    </div>
<?php
endif;
