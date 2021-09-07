<?php
/**
 * Post type portfolio
 */
add_action('init', 'nasa_portfolio_init');
function nasa_portfolio_init() {
    global $nasa_opt;
    if (isset($nasa_opt['enable_portfolio']) && !$nasa_opt['enable_portfolio']) {
        return;
    }
    
    $labels = array(
        'name' => _x('Projects', 'post type general name', 'nasa-core'),
        'singular_name' => _x('Portfolio', 'post type singular name', 'nasa-core'),
        'add_new' => _x('Add New', 'project', 'nasa-core'),
        'add_new_item' => esc_html__('Add New Project', 'nasa-core'),
        'edit_item' => esc_html__('Edit Project', 'nasa-core'),
        'new_item' => esc_html__('New Project', 'nasa-core'),
        'view_item' => esc_html__('View Project', 'nasa-core'),
        'search_items' => esc_html__('Search Projects', 'nasa-core'),
        'not_found' => esc_html__('No projects found', 'nasa-core'),
        'not_found_in_trash' => esc_html__('No projects found in Trash', 'nasa-core'),
        'parent_item_colon' => '',
        'menu_name' => 'Portfolio'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 6,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => array('title', 'slug', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'rewrite' => true,
        'menu_icon' => 'dashicons-portfolio'
    );

    register_post_type('portfolio', $args);

    $labels = array(
        'name' => _x('Tags', 'taxonomy general name', 'nasa-core'),
        'singular_name' => _x('Tag', 'taxonomy singular name', 'nasa-core'),
        'search_items' => esc_html__('Search Types', 'nasa-core'),
        'all_items' => esc_html__('All Tags', 'nasa-core'),
        'parent_item' => esc_html__('Parent Tag', 'nasa-core'),
        'parent_item_colon' => esc_html__('Parent Tag:', 'nasa-core'),
        'edit_item' => esc_html__('Edit Tags', 'nasa-core'),
        'update_item' => esc_html__('Update Tag', 'nasa-core'),
        'add_new_item' => esc_html__('Add New Tag', 'nasa-core'),
        'new_item_name' => esc_html__('New Tag Name', 'nasa-core'),
    );

    $labels2 = array(
        'name' => _x('Categories', 'taxonomy general name', 'nasa-core'),
        'singular_name' => _x('Category', 'taxonomy singular name', 'nasa-core'),
        'search_items' => esc_html__('Search Types', 'nasa-core'),
        'all_items' => esc_html__('All Categories', 'nasa-core'),
        'parent_item' => esc_html__('Parent Category', 'nasa-core'),
        'parent_item_colon' => esc_html__('Parent Category:', 'nasa-core'),
        'edit_item' => esc_html__('Edit Categories', 'nasa-core'),
        'update_item' => esc_html__('Update Category', 'nasa-core'),
        'add_new_item' => esc_html__('Add New Category', 'nasa-core'),
        'new_item_name' => esc_html__('New Category Name', 'nasa-core'),
    );

    register_taxonomy('portfolio_category', array('portfolio'), array(
        'hierarchical' => true,
        'labels' => $labels2,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio-category'),
    ));
}

add_action('template_redirect', 'nasa_portfolio_template_redirect', 9999);
function nasa_portfolio_template_redirect() {
    if (is_post_type_archive('portfolio') || is_tax('portfolio_category')) {
        nasa_template('portfolio/portfolio-archive.php');
        exit();
    }
}

/**
 * Style
 */
add_action('wp_enqueue_scripts', 'nasa_portfolio_enqueue', 999);
function nasa_portfolio_enqueue() {
    if (
        is_post_type_archive('portfolio') ||
        is_tax('portfolio_category') ||
        is_singular('portfolio')
    ) {
        wp_enqueue_style('nasa-portfolio', NASA_CORE_PLUGIN_URL . 'assets/css/portfolio.css');
        wp_enqueue_script('nasa-portfolio', NASA_CORE_PLUGIN_URL . 'assets/js/min/nasa-portfolio.min.js', array('jquery'), null, true);
    }
}

/**
 * Masonry isotope
 */
add_action('nasa_before_archive_portfolio', 'nasa_portfolio_scripts');
function nasa_portfolio_scripts() {
    wp_enqueue_script('jquery-masonry-isotope', NASA_CORE_PLUGIN_URL . 'assets/js/min/jquery.masonry-isotope.min.js', array('jquery'), null, true);
}

/**
 * Recent Works
 */
add_shortcode('portfolio', 'nasa_portfolio_shortcode');
function nasa_portfolio_shortcode($atts) {
    global $nasa_opt;
    if (isset($nasa_opt['enable_portfolio']) && !$nasa_opt['enable_portfolio']) {
        return '';
    }
    
    $a = shortcode_atts(array(
        'title' => esc_html__('Recent Works', 'nasa-core'),
        'limit' => apply_filters('nasa_limit_recent_portfolio', 12)
    ), $atts);

    return nasa_get_recent_portfolio($a['limit'], $a['title']);
}

function nasa_get_recent_portfolio($limit = 0, $title = 'Recent Works', $not_in = array()) {
    global $nasa_opt;
    if (isset($nasa_opt['enable_portfolio']) && !$nasa_opt['enable_portfolio']) {
        return '';
    }
    
    $args = array(
        'post_type' => 'portfolio',
        'order' => 'DESC',
        'orderby' => 'date',
        'posts_per_page' => $limit
    );
    
    if (!empty($not_in)) {
        $args['post__not_in'] = $not_in;
    }

    return nasa_create_portfolio_recent($args, $title);
}

function nasa_create_portfolio_recent($args = array(), $title = false, $width = 540, $height = 340, $crop = true) {
    global $nasa_opt;
    if (isset($nasa_opt['enable_portfolio']) && !$nasa_opt['enable_portfolio']) {
        return '';
    }
    
    $box_id = rand(1000, 10000);
    $multislides = new WP_Query($args);
    $result = '';
    
    if ($multislides->have_posts()) :
        ob_start();
        
        $title_output = '';
        if ($title) {
            $title_output = 
            '<div class="title-block text-left rtl-text-right">' .
                '<h3 class="nasa-bold-700">' . $title . '</h3>' .
            '</div>';
        }
        
        echo '<div class="slider-container carousel-area">' .
            $title_output .
            '<div class="items-slide items-slider-portfolio slider-' . $box_id . '">' .
                '<div class="nasa-slider-items-margin nasa-slick-slider nasa-slick-nav recentPortfolio" data-columns="3" data-columns-small="2" data-columns-tablet="3">';
                    $delay = 0;
                    $delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
                    while ($multislides->have_posts()) :
                        $multislides->the_post();
                        
                        $nasa_args = array(
                            'delay' => $delay
                        );
                        nasa_template('portfolio/portfolio-recent.php', $nasa_args);
                        
                        $delay += $delay_item;
                    endwhile;
                echo '</div><!-- slider -->' .
            '</div><!-- products-slider -->' .
        '</div><!-- slider-container -->';
        
        $result = ob_get_clean();
    endif;
    wp_reset_query();

    return $result;
}

/**
 * Categories of Porfolio
 */
function nasa_print_item_cats($id) {
    global $nasa_opt;
    if (isset($nasa_opt['enable_portfolio']) && !$nasa_opt['enable_portfolio']) {
        return;
    }
    
    // Returns Array of Term Names for "categories"
    $term_list = wp_get_post_terms($id, 'portfolio_category');
    $_i = 0;
    $count = count($term_list);
    if ($count) {
        foreach ($term_list as $value) {
            $_i++;
            echo '<a href="' . get_term_link($value) . '" title="' . $value->name . '">' . $value->name . '</a>';
            echo $_i != $count ? ', ' : '';
        }
    }
}

add_action('wp_ajax_get_more_portfolio', 'nasa_get_more_portfolio');
add_action('wp_ajax_nopriv_get_more_portfolio', 'nasa_get_more_portfolio');
function nasa_get_more_portfolio() {
    global $nasa_opt;
    
    if (isset($nasa_opt['enable_portfolio']) && !$nasa_opt['enable_portfolio']) {
        die(array('success' => false));
    }

    $page = (isset($_POST['page']) && (int) $_POST['page']) ? (int) $_POST['page'] : 1;
    $limit = (isset($nasa_opt['portfolio_count']) && (int) $nasa_opt['portfolio_count']) ? (int) $nasa_opt['portfolio_count'] : 20;
    $cat = (isset($_POST['category']) && (int) $_POST['category']) ? (int) $_POST['category'] : 0;

    $args = array(
        'post_type' => 'portfolio',
        'paged' => $page,
        'posts_per_page' => $limit,
        'tax_query' => !empty($cat) ? array(array(
            'taxonomy' => 'portfolio_category',
            'field' => 'id',
            'terms' => $cat
        )) : array()
    );

    $loop = new WP_Query($args);
    
    $result = array(
        'success' => false,
        'result' => '',
        'max' => 0,
        'alert' => esc_html__('No portfolio were found!', 'nasa-core')
    );
    
    if ($loop->post_count) {
        ob_start();
        while ($loop->have_posts()) {
            $loop->the_post();
            
            nasa_template('portfolio/portfolio-content.php');
        }
        
        $result['result'] = ob_get_clean();
        $result['max'] = $loop->max_num_pages;
        $result['success'] = true;
        $result['alert'] = $page >= $loop->max_num_pages ?
            esc_html__('ALL PORTFOLIOS LOADED', 'nasa-core') : esc_html__('LOAD MORE', 'nasa-core');
    } 
    
    die(json_encode($result));
}

// **********************************************************************//
// ! Project links
// **********************************************************************//
add_shortcode('project_links', 'nasa_project_links');
function nasa_project_links($atts = array(), $content = null) {
    global $nasa_opt;
    if (isset($nasa_opt['enable_portfolio']) && !$nasa_opt['enable_portfolio']) {
        return;
    }
    
    $next_post = get_next_post();
    $prev_post = get_previous_post();
    ?>
    <div class="portfolio-navigation">
        <?php if (!empty($prev_post)) : ?>
            <div class="pull-left prev-portfolio">
                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="btn border-grey btn-xmedium portfolio-nav"><?php esc_html_e('Prev', 'nasa-core'); ?></a>
                <div class="hide-info">
            <?php echo get_the_post_thumbnail($prev_post->ID, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail')); ?>
                    <span class="price"><?php echo get_the_title($prev_post->ID); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!empty($next_post)) : ?>
            <div class="pull-right next-portfolio">
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="btn border-grey btn-xmedium portfolio-nav"><?php esc_html_e('Next', 'nasa-core'); ?></a>
                <div class="hide-info">
                    <span class="price"><?php echo get_the_title($next_post->ID); ?></span>
                    <?php echo get_the_post_thumbnail($next_post->ID, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail')); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php
}

// **********************************************************************// 
// ! Function to get post image
// **********************************************************************//
function nasa_get_image($attachment_id = 0, $width = null, $height = null, $crop = true, $post_id = null, $get_sizes = false) {
    if (!$attachment_id) {
        if (!$post_id) {
            global $post;
            $post_id = $post->ID;
        }
        if (has_post_thumbnail($post_id)) {
            $attachment_id = get_post_thumbnail_id($post_id);
        } else {
            $attached_images = (array) get_posts(array(
                'post_type' => 'attachment',
                'numberposts' => 1,
                'post_status' => null,
                'post_parent' => $post_id,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            $attachment_id = !empty($attached_images) ? $attached_images[0]->ID : 0;
        }
    }

    return !$attachment_id ? NASA_CORE_PLUGIN_URL . 'assets/images/placeholder.png' : nasa_get_resized_url($attachment_id, $width, $height, $crop, $get_sizes);
}

function nasa_get_resized_url($id, $width, $height, $crop, $get_sizes) {
    if (function_exists("gd_info") && ($width >= 10 && $height >= 10) && ($width <= 1024 && $height <= 1024)) {
        $vt_image = nasa_vt_resize($id, '', $width, $height, $crop);
        $image_url = $vt_image ? ($get_sizes ? $vt_image : $vt_image['url']) : false;
    } else {
        $full_image = wp_get_attachment_image_src($id, 'full');
        $image_url = !empty($full_image[0]) ? $full_image[0] : false;
    }

    if (is_ssl() && !strstr($image_url, 'https')) {
        $image_url = str_replace('http://', 'https://', $image_url);
    }

    return $image_url ? $image_url : NASA_CORE_PLUGIN_URL . 'assets/images/placeholder.png';
}

function nasa_vt_resize($attach_id, $img_url, $width, $height, $crop) {
    // this is an attachment, so we have the ID
    if ($attach_id) {
        $image_src = wp_get_attachment_image_src($attach_id, 'full');
        $file_path = get_attached_file($attach_id);

        // this is not an attachment, let's use the image url
    } else if ($img_url) {
        $file_path = parse_url($img_url);
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
        $orig_size = getimagesize($file_path);

        $image_src[0] = $img_url;
        $image_src[1] = $orig_size[0];
        $image_src[2] = $orig_size[1];
    }

    $file_info = pathinfo($file_path);

    // check if file exists
    $base_file = $file_info['dirname'] . '/' . $file_info['filename'] . '.' . $file_info['extension'];
    if (!file_exists($base_file)) {
        return;
    }

    $extension = '.' . $file_info['extension'];

    // the image path without the extension
    $no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

    // checking if the file size is larger than the target size
    // if it is smaller or the same size, stop right here and return
    if ($image_src[1] > $width || $image_src[2] > $height) {
        if ($crop == true) {
            $cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

            // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
            if (file_exists($cropped_img_path)) {
                $cropped_img_url = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);

                return array(
                    'url' => $cropped_img_url,
                    'width' => $width,
                    'height' => $height
                );
            }
        } elseif ($crop == false) {
            // calculate the size proportionaly
            $proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
            $resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

            // checking if the file already exists
            if (file_exists($resized_img_path)) {
                $resized_img_url = str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);

                return array(
                    'url' => $resized_img_url,
                    'width' => $proportional_size[0],
                    'height' => $proportional_size[1]
                );
            }
        }

        // check if image width is smaller than set width
        $img_size = getimagesize($file_path);
        if ($img_size[0] <= $width)
            $width = $img_size[0];

        // no cache files - let's finally resize it
        //$new_img_path = image_resize( $file_path, $width, $height, $crop );

        $image = wp_get_image_editor($file_path);
        if (!is_wp_error($image)) {
            $image->resize($width, $height, $crop);
            $new_img_path = $image->save();
            $new_img_path = $new_img_path['path'];
        } else {
            $new_img_path = $file_path;
        }

        $new_img_size = getimagesize($new_img_path);
        $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);

        // resized output
        return array(
            'url' => $new_img,
            'width' => $new_img_size[0],
            'height' => $new_img_size[1]
        );
    }

    // default output - without resizing
    return array(
        'url' => $image_src[0],
        'width' => $image_src[1],
        'height' => $image_src[2]
    );
}
