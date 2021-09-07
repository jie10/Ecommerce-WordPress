<?php
$postId = get_the_ID();
$categories = wp_get_post_terms($postId, 'portfolio_category');
$catsClass = '';
foreach ($categories as $category) {
    $catsClass .= ' sort-'.$category->slug;
}
$lightbox = (!isset($nasa_opt['portfolio_lightbox']) || $nasa_opt['portfolio_lightbox']) ? true : false;
	
$width = 500;
$height = 500;
$crop = true;
?>
<li class="nasa-collapse portfolio-item<?php echo $catsClass; ?>">       
    <?php if (has_post_thumbnail($postId)): ?>
        <div class="portfolio-image">
            <?php $imgSrc = nasa_get_image(get_post_thumbnail_id($postId), $width, $height, $crop); ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $imgSrc; ?>" alt="<?php the_title(); ?>" /></a>
            <div class="zoom">
                <div class="btn_group">
                    <?php if ($lightbox): ?>
                        <a href="javascript:void(0);" class="btn portfolio-image-view" data-src="<?php echo nasa_get_image(get_post_thumbnail_id($postId)); ?>"><span><?php esc_html_e('View large', 'nasa-core'); ?></span></a>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="btn portfolio-link"><span><?php esc_html_e('More details', 'nasa-core'); ?></span></a>
                </div>
                <i class="bg"></i>
            </div>
        </div>
    <?php endif; ?>
    <div class="portfolio-description text-center">
        <?php if (!isset($nasa_opt['project_name']) || $nasa_opt['project_name']): ?>
            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
        <?php endif; ?>
        
        <?php if (!isset($nasa_opt['project_byline']) || $nasa_opt['project_byline']): ?>
            <span class="portfolio-cat"><?php nasa_print_item_cats($postId); ?></span> 
        <?php endif; ?>
    </div>
</li>
