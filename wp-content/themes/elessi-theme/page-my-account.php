<?php
/*
  Template name: My Account
  This templates add Account menu to the sidebar.
 */
get_header(); ?>

<div class="page-wrapper my-account">
    <div class="row">
        <div id="content" class="large-12 columns">
            <?php if (NASA_CORE_USER_LOGGED) : ?>
                <div class="nasa-my-acc-content">
                    <h4 class="heading-title hidden-tag">
                        <?php echo get_the_title(); ?>
                    </h4>

                    <?php
                    if (shortcode_exists('woocommerce_my_account')):
                        global $post;
                        echo !isset($post->post_content) || !has_shortcode($post->post_content, 'woocommerce_my_account') ? do_shortcode('[woocommerce_my_account]') . '<div class="nasa-clear-both"></div>' : '';
                    endif;

                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile; // end of the loop.
                    ?>
                </div>
            <?php else : ?>
                <h1 class="nasa-title-my-account-page margin-top-20 text-center">
                    <?php echo esc_html__('Login/Register', 'elessi-theme'); ?>
                </h1>
                
                <?php
                if (shortcode_exists('woocommerce_my_account')):
                    global $post;
                    echo !isset($post->post_content) || !has_shortcode($post->post_content, 'woocommerce_my_account') ? do_shortcode('[woocommerce_my_account]') . '<div class="nasa-clear-both"></div>' : '';
                endif;
                
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile; // end of the loop.
                ?>
            <?php endif; ?>

        </div><!-- end #content large-12 -->
    </div><!-- end row -->
</div><!-- end page-right-sidebar container -->

<?php
wp_reset_postdata();
get_footer();
