<?php
/*
  Template name: Full Width (100%)
 */
get_header();

if (has_excerpt()) : ?>
    <div class="page-header">
        <?php the_excerpt(); ?>
    </div>
<?php
endif;

while (have_posts()) :
    the_post();
    the_content();
endwhile;
wp_reset_postdata();

get_footer();
