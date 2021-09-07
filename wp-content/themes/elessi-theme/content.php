<?php
/**
 * @package nasatheme
 */

global $nasa_opt;

$show_author_info = (!isset($nasa_opt['show_author_info']) || $nasa_opt['show_author_info']) ? true : false;
$show_date_info = (!isset($nasa_opt['show_date_info']) || $nasa_opt['show_date_info']) ? true : false;
$show_cat_info = (isset($nasa_opt['show_cat_info']) && $nasa_opt['show_cat_info']) ? true : false;
$show_tag_info = (isset($nasa_opt['show_tag_info']) && $nasa_opt['show_tag_info']) ? true : false;
$show_comment_info = (isset($nasa_opt['show_comment_info']) && $nasa_opt['show_comment_info']) ? true : false;
$show_readmore = (!isset($nasa_opt['show_readmore_blog']) || $nasa_opt['show_readmore_blog']) ? true : false;
$show_desc_blog = (!isset($nasa_opt['show_desc_blog']) || $nasa_opt['show_desc_blog']) ? true : false;

$k = 0;
while (have_posts()) :
    the_post();

    $allowed_html = array(
        'strong' => array()
    );

    $postId = get_the_ID(); 
    $title = get_the_title();
    $link = get_the_permalink();

    if ($show_author_info) {
        $author = get_the_author();
        $author_id = get_the_author_meta('ID');
        $link_author = get_author_posts_url($author_id);
    }

    if ($show_date_info) {
        $day = get_the_time('d', $postId);
        $month = get_the_time('m', $postId);
        $year = get_the_time('Y', $postId);
        $link_date = get_day_link($year, $month, $day);
        $date_post = get_the_time('F n, Y', $postId);
    }
    if (!isset($nasa_opt['blog_type']) || $nasa_opt['blog_type'] == 'masonry-isotope') :
        $file = ELESSI_CHILD_PATH . '/includes/nasa-blog-masonry-isotope.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-blog-masonry-isotope.php';
    elseif ($nasa_opt['blog_type'] == 'blog-grid') :
        $file = ELESSI_CHILD_PATH . '/includes/nasa-blog-grid.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-blog-grid.php';
    elseif ($nasa_opt['blog_type'] == 'blog-standard') :
        $file = ELESSI_CHILD_PATH . '/includes/nasa-blog-standard.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-blog-standard.php';
    elseif ($nasa_opt['blog_type'] == 'blog-list') :
        $file = ELESSI_CHILD_PATH . '/includes/nasa-blog-list.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-blog-list.php';
    endif;
    $k++;
endwhile;

echo (!isset($nasa_opt['blog_type']) || in_array($nasa_opt['blog_type'], array('masonry-isotope', 'blog-grid'))) ? '</ul>' : '';
?>

<div class="large-12 columns navigation-container nasa-blog-paging">
    <?php echo paginate_links(array(
        'prev_text' => '<span class="fa fa-caret-left"></span>',
        'next_text' => '<span class="fa fa-caret-right"></span>',
        'type' => 'list',
        'end_size' => 1,
        'mid_size' => 1
    )); ?>
</div>
<?php
wp_reset_postdata();
