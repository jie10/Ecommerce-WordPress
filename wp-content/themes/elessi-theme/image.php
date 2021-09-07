<?php
/**
 *
 * @package nasatheme
 */
get_header();

$allowed_html = array(
    'span' => array('class' => array()),
    'time' => array('class' => array(), 'datetime' => array()),
    'a' => array('class' => array(), 'href' => array(), 'title' => array(), 'rel' => array())
);
?>
<div id="primary" class="content-area image-attachment container-wrap">
    <div id="content" class="site-content">
        <div class="row">
            <div class="large-12 columns">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>

                            <div class="entry-meta">
                                <?php
                                $metadata = wp_get_attachment_metadata();
                                printf(wp_kses(__('Published <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>', 'elessi-theme'), $allowed_html), esc_attr(get_the_date('c')), esc_html(get_the_date()), wp_get_attachment_url(), $metadata['width'], $metadata['height'], get_permalink($post->post_parent), esc_attr(strip_tags(get_the_title($post->post_parent))), get_the_title($post->post_parent));
                                edit_post_link(esc_html__('Edit', 'elessi-theme'), '<span class="sep"> | </span> <span class="edit-link">', '</span>');
                                ?>
                            </div>
                        </header>

                        <div class="entry-content">

                            <div class="entry-attachment">
                                <div class="attachment">
                                    <?php
                                    $attachments = array_values(get_children(array(
                                        'post_parent' => $post->post_parent,
                                        'post_status' => 'inherit',
                                        'post_type' => 'attachment',
                                        'post_mime_type' => 'image',
                                        'order' => 'ASC',
                                        'orderby' => 'menu_order ID'
                                    )));
                                    foreach ($attachments as $k => $attachment) :
                                        if ($attachment->ID == $post->ID) :
                                            break;
                                        endif;
                                    endforeach;
                                    $k++;
                                    if (count($attachments) > 1) :
                                        if (isset($attachments[$k])) :
                                            $next_attachment_url = get_attachment_link($attachments[$k]->ID);
                                        else :
                                            $next_attachment_url = get_attachment_link($attachments[0]->ID);
                                        endif;
                                    else :
                                        $next_attachment_url = wp_get_attachment_url();
                                    endif;
                                    ?>

                                    <a href="<?php echo esc_url($next_attachment_url); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
                                    <?php
                                    $attachment_size = apply_filters('elessi_attachment_size', array(1200, 1200)); // Filterable image size.
                                    echo wp_get_attachment_image($post->ID, $attachment_size);
                                    ?>
                                    </a>
                                </div>

                                <?php if (!empty($post->post_excerpt)) : ?>
                                    <div class="entry-caption">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php the_content(); ?>
                            <?php
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'elessi-theme'),
                                'after' => '</div>'
                            ));
                            ?>
                        </div>

                        <footer class="entry-meta">
                            <?php if (comments_open() && pings_open()) : ?>
                                <?php printf(wp_kses(__('<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'elessi-theme'), $allowed_html), get_trackback_url()); ?>
                            <?php elseif (!comments_open() && pings_open()) : ?>
                                <?php printf(wp_kses(__('Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'elessi-theme'), $allowed_html), get_trackback_url()); ?>
                            <?php elseif (comments_open() && !pings_open()) : ?>
                                <?php echo wp_kses(__('Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'elessi-theme'), $allowed_html); ?>
                            <?php elseif (!comments_open() && !pings_open()) : ?>
                                <?php esc_html_e('Both comments and trackbacks are currently closed.', 'elessi-theme'); ?>
                            <?php endif; ?>
                            <?php edit_post_link(esc_html__('Edit', 'elessi-theme'), ' <span class="edit-link">', '</span>'); ?>
                        </footer>
                        
                        <nav role="navigation" id="image-navigation" class="navigation-image">
                            <div class="nav-previous"><?php previous_image_link(false, wp_kses(__('<span class="meta-nav">&larr;</span> Previous', 'elessi-theme'), $allowed_html)); ?></div>
                            <div class="nav-next"><?php next_image_link(false, wp_kses(__('Next <span class="meta-nav">&rarr;</span>', 'elessi-theme'), $allowed_html)); ?></div>
                        </nav>
                    </article>
                    <?php
                    if (comments_open() || '0' != get_comments_number()) :
                        comments_template();
                    endif; ?>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
