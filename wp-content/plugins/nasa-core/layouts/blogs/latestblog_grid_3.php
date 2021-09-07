<?php
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
?>
<div class="row nasa-blog-sc blog-grid blog-grid-style">
    <?php
    $k = 0;
    $count = wp_count_posts()->publish;
    if ($count > 0) {
        while ($recentPosts->have_posts()) {
            $recentPosts->the_post();
            $title_item = get_the_title();
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

            $class_item = 'small-12 medium-6 large-6 columns margin-bottom-40 wow fadeInUp nasa-item-blog-grid nasa-item-blog-grid-3';
            
            $class_item .= $k == 0 ? ' rtl-right padding-right-40 mobile-padding-right-10 rtl-padding-right-10 rtl-padding-left-40 rtl-mobile-padding-left-10' : ' rtl-left padding-left-40 mobile-padding-left-10 rtl-padding-left-10 rtl-padding-right-40 rtl-mobile-padding-right-10';

            echo '<div class="' . $class_item . '" data-wow-duration="1s" data-wow-delay="' . esc_attr($_delay) . 'ms">';

            if ($k == 0 && trim($title) !== '') : ?>
                <div class="nasa-title margin-bottom-50">
                    <h3 class="nasa-title-heading nasa-bold-800 margin-bottom-5">
                        <?php echo esc_attr($title); ?>
                    </h3>

                    <?php if (trim($title_desc) != '') :
                        echo '<p class="nasa-title-desc">' . esc_html($title_desc) . '</p>';
                    endif; ?>
                </div>
            <?php endif; ?>
            
            <a class="entry-blog" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title_item); ?>">
                <div class="blog-image-fullwidth">
                    <?php
                    if (has_post_thumbnail()):
                        the_post_thumbnail('nasa-medium', array(
                            'alt' => esc_attr($title_item)
                        ));
                    else:
                        echo '<img src="' . NASA_CORE_PLUGIN_URL . 'assets/images/placeholder.png" alt="' . esc_attr($title_item) . '" />';
                    endif;
                    ?>
                </div>
            </a>

            <div class="nasa-blog-info nasa-blog-img-top">
                <div class="nasa-blog-info-wrap margin-top-20">
                    <?php echo ($cats_enable == 'yes') ? '<div class="nasa-post-cats-wrap">' . $categories . '</div>' : ''; ?>
                    <a class="nasa-blog-title" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title_item); ?>"><?php echo $title_item; ?></a>

                    <div class="nasa-info-short"><?php the_excerpt(); ?></div>

                    <div class="nasa-date-author-wrap nasa-post-date-author-wrap">
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
                </div>
            </div>
            <?php

            echo '</div>';
            $k++;
            $_delay += $_delay_item;
        }

        wp_reset_postdata();
    }
    ?>
</div>

<?php
if ($page_blogs == 'yes') : ?>
    <div class="text-center margin-top-40 margin-bottom-40">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" title="<?php echo esc_html__('All Blogs', 'nasa-core'); ?>" class="nasa-view-more button">
            <?php echo esc_html__('All Blogs', 'nasa-core'); ?>
        </a>
    </div>
<?php
endif;
