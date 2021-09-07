<?php
$post_type = get_post_type();
$post_blog = 'post' == $post_type ? true : false;
$show_comment = $show_comment_info && comments_open() ? true : false;
?>

<article id="post-<?php echo (int) $postId; ?>" <?php post_class(); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="entry-image nasa-blog-img">
            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>">
                <?php the_post_thumbnail('large'); ?>
                <div class="image-overlay"></div>
            </a>
        </div>
    <?php endif; ?>

    <header class="entry-header">
        <?php
        $categories_list = $post_blog && $show_cat_info ? get_the_category_list(esc_html__(', ', 'elessi-theme')) : false;
        if ($categories_list) : ?>
            <!-- Categories item -->
            <span class="cat-links-archive nasa-archive-info">
                <?php echo $categories_list; ?>
            </span>
        <?php endif; ?>
        
        <!-- Title -->
        <h3 class="entry-title nasa-archive-info">
            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>" rel="bookmark">
                <?php echo $title; ?>
            </a>
        </h3>

        <?php if ($show_author_info || $show_date_info || $show_comment) : ?>
            <div class="text-left info-wrap nasa-archive-info">
                <?php if ($show_author_info) : ?>
                    <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_attr__('By ', 'elessi-theme') . esc_attr($author); ?>">
                        <span class="meta-author meta-item inline-block">
                            <i class="pe-7s-user"></i>
                            <?php esc_html_e('By ', 'elessi-theme'); ?><?php echo $author; ?>
                        </span>
                    </a>
                <?php endif; ?>

                <?php if ($show_date_info) : ?>
                    <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_attr__('Posts in ', 'elessi-theme') . esc_attr($date_post); ?>">
                        <span class="post-date meta-item inline-block">
                            <i class="pe-7s-date"></i>
                            <?php echo $date_post; ?>
                        </span>
                    </a>
                <?php endif; ?>
                
                <?php if ($show_comment) :
                    $count_comments = get_comments_number();
                    $class_number = 'nasa-comment-count';
                    $class_number .= !$count_comments ? ' nasa-empty' : '';
                    ?>
                    <a href="<?php echo esc_url($link); ?>#respond" title="<?php echo esc_attr__('Comments', 'elessi-theme'); ?>">
                        <span class="post-comment-count meta-item inline-block">
                            <i class="pe-7s-comment"></i>
                            <span class="<?php echo esc_attr($class_number); ?>"><?php echo $count_comments; ?></span>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($post_type !== 'page' && $show_desc_blog) : ?>
            <div class="entry-summary nasa-archive-info"><?php the_excerpt(); ?></div>
        <?php endif; ?>

        <?php if ($show_readmore) : ?>
            <div class="entry-readmore nasa-archive-info">
                <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr__('CONTINUE READING  &#10142;', 'elessi-theme'); ?>">
                    <?php echo esc_html__('CONTINUE READING  &#10142;', 'elessi-theme'); ?>
                </a>
            </div>
        <?php endif; ?>
    </header>
    
    <?php
    $tags_list = $post_blog && $show_tag_info ? get_the_tag_list('', esc_html__(', ', 'elessi-theme')) : false;
    if ($tags_list) : ?>
        <footer class="entry-meta nasa-archive-info">
            <!-- Tagged -->
            <span class="tags-links">
                <?php printf(esc_html__('Tagged %1$s', 'elessi-theme'), $tags_list); ?>
            </span>
        </footer>
    <?php endif; ?>
</article>
