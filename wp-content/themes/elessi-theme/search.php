<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package nasatheme
 */
$nasa_sidebar = isset($nasa_opt['blog_layout']) ? $nasa_opt['blog_layout'] : 'left';
if (!is_active_sidebar('blog-sidebar')) :
    $nasa_sidebar = 'no';
endif;

$hasSidebar = true;
$left = false;
switch ($nasa_sidebar):
    case 'right':
        $attr = 'large-9 left columns';
        break;
    
    case 'no':
        $hasSidebar = false;
        $attr = 'large-12 columns';
        break;
    
    case 'left':
    default:
        $left = true;
        $attr = 'large-9 right columns';
        break;
endswitch;

if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) :
    $attr .= ' nasa-blog-in-mobile';
endif;

$class_wrap = 'container-wrap page-' . $nasa_sidebar . '-sidebar';
$headling = !isset($nasa_opt['blog_heading']) || $nasa_opt['blog_heading'] ? true : false;

get_header();

/**
 * Hook: nasa_before_archive_blog.
 */
do_action('nasa_before_archive_blogs');
?>
<div class="<?php echo esc_attr($class_wrap); ?>">

    <?php if ($hasSidebar): ?>
        <div class="div-toggle-sidebar nasa-blog-sidebar center">
            <a class="toggle-sidebar" href="javascript:void(0);" rel="nofollow">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    <?php endif; ?>

    <div class="row">
        <div id="content" class="<?php echo esc_attr($attr); ?>">
            <div class="page-inner margin-bottom-50">
                <?php if (have_posts()) : ?>
                    <?php if ($headling) : ?>
                        <header class="page-header">
                            <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'elessi-theme'), '<span>' . get_search_query() . '</span>'); ?></h1>
                        </header>
                    <?php endif; ?>
                <?php
                    get_template_part('content', get_post_format());
                    elessi_content_nav('nav-below');
                else :
                    get_template_part('no-results', 'search');
                endif;
                ?>
            </div>
        </div>

        <?php if ($nasa_opt['blog_layout'] == 'left' || $nasa_opt['blog_layout'] == 'right'): ?>
            <div class="large-3 columns <?php echo ($left) ? 'left desktop-padding-right-20' : 'right desktop-padding-left-20'; ?> col-sidebar">
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'elessi-theme'); ?>" class="hidden-tag nasa-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'elessi-theme'); ?>
                </a>
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

    </div>	
</div>

<?php
get_footer();
