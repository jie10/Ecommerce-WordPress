<?php
$nasa_columns = (isset($nasa_opt['portfolio_columns']) && (int)$nasa_opt['portfolio_columns']) ?
    (int) $nasa_opt['portfolio_columns'] : 5;

$cat_id = is_tax('portfolio_category') ? get_queried_object_id() : 0;

get_header();
do_action('nasa_before_archive_portfolio');
?>
<div class="row">
    <div class="large-12 columns nasa-tabs-content nasa-portfolio-wrap margin-top-25 margin-bottom-40 text-center">
        <?php if (!$cat_id) :
            $categories = get_terms('portfolio_category');
            
            if (count($categories)) : ?>
                <div class="nasa-tabs-wrap margin-bottom-15 text-left rtl-text-right">
                    <ul class="nasa-tabs portfolio-tabs nasa-classic-style nasa-classic-2d nasa-tabs-no-border">
                        <li class="description_tab nasa-tab first active">
                            <a href="javascript:void(0);" data-filter="*" class="nasa-a-tab nasa-uppercase">
                                <?php esc_html_e('Show All', 'nasa-core'); ?>
                            </a>
                        </li>
                        <?php foreach ($categories as $category) :?>
                            <li class="description_tab nasa-tab">
                                <a href="javascript:void(0);" data-filter=".sort-<?php echo esc_attr($category->slug); ?>" class="nasa-a-tab nasa-uppercase">
                                    <?php echo $category->name; ?>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <ul class="portfolio portfolio-list large-block-grid-<?php echo (int) $nasa_columns; ?> small-block-grid-2 medium-block-grid-3" data-columns="<?php echo (int) $nasa_columns; ?>">
            <!-- Loadding ... -->
        </ul>

        <a href="javascript:void(0);" class="text-center load-more loadmore-portfolio nasa-relative hidden-tag" data-category="<?php echo (int) $cat_id; ?>">
            <span class="nasa-loadmore-text"><?php esc_html_e('LOAD MORE ...', 'nasa-core'); ?></span>
        </a>
    </div>
</div>
<?php
do_action('nasa_after_archive_portfolio');
get_footer();
