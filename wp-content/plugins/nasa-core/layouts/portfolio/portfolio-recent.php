<?php 
$postId = get_the_ID();
$categories = wp_get_post_terms($postId, 'categories');
$catsClass = 'wow nasa-slider-item slider-item portfolio-item';
if (!is_wp_error($categories)) {
    foreach ($categories as $category) {
        $catsClass .= ' sort-' . $category->slug;
    }
}

if (!isset($delay)) {
    $delay = 0;
}

$lightbox = (!isset($nasa_opt['portfolio_lightbox']) || $nasa_opt['portfolio_lightbox']) ? true : false;
?>

<div class="<?php echo esc_attr($catsClass); ?>" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($delay); ?>ms">
    <div class="portfolio-image">
        <?php if (has_post_thumbnail($postId)): ?>
            
            <?php $image = nasa_get_image(get_post_thumbnail_id($postId), 400, 350, true); ?>
            <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>" />
            
            <div class="zoom">
                <div class="btn_group">
                    
                    <?php if ($lightbox): ?>
                        <a href="javascript:void(0);" class="btn portfolio-image-view" data-src="<?php echo nasa_get_image(get_post_thumbnail_id($postId)); ?>">
                            <span><?php esc_html_e('View large', 'nasa-core'); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php the_permalink(); ?>" class="btn portfolio-link">
                        <span><?php esc_html_e('More details', 'nasa-core'); ?></span>
                    </a>
                    
                </div>
                <i class="bg"></i>
            </div>
        <?php endif; ?>
    </div>
</div>
