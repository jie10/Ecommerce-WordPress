<?php
add_action('init', 'elessi_blog_heading');
if (!function_exists('elessi_blog_heading')) {
    function elessi_blog_heading() {
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Blog", 'elessi-theme'),
            "target" => 'blog',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Single Layout", 'elessi-theme'),
            "id" => "single_blog_layout",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left Sidebar", 'elessi-theme'),
                "right" => esc_html__("Right Sidebar", 'elessi-theme'),
                "no" => esc_html__("No Sidebar (Centered)", 'elessi-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Archive Layout", 'elessi-theme'),
            "id" => "blog_layout",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left Sidebar", 'elessi-theme'),
                "right" => esc_html__("Right Sidebar", 'elessi-theme'),
                "no" => esc_html__("No Sidebar (Centered)", 'elessi-theme')
            )
        );

        $of_options[] = array(
            "name" => esc_html__("Style", 'elessi-theme'),
            "id" => "blog_type",
            "std" => "blog-standard",
            "type" => "select",
            "options" => array(
                "blog-standard" => esc_html__("Standard", 'elessi-theme'),
                "blog-list" => esc_html__("List", 'elessi-theme'),
                "blog-grid" => esc_html__("Grid", 'elessi-theme'),
                "masonry-isotope" => esc_html__("Masonry isotope", 'elessi-theme')
            )
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Heading for Archive Page", 'elessi-theme'),
            "id" => "blog_heading",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Masonry isotope - Grid - Blog style", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Masonry isotope - Grid - Blog style", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in desktop", 'elessi-theme'),
            "id" => "masonry_blogs_columns_desk",
            "std" => "3-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'elessi-theme'),
                "3-cols" => esc_html__("3 columns", 'elessi-theme'),
                "4-cols" => esc_html__("4 columns", 'elessi-theme'),
                "5-cols" => esc_html__("5 columns", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in Mobile", 'elessi-theme'),
            "id" => "masonry_blogs_columns_small",
            "std" => "1-col",
            "type" => "select",
            "options" => array(
                "1-cols" => esc_html__("1 column", 'elessi-theme'),
                "2-cols" => esc_html__("2 columns", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns in Tablet", 'elessi-theme'),
            "id" => "masonry_blogs_columns_tablet",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "1-col" => esc_html__("1 column", 'elessi-theme'),
                "2-cols" => esc_html__("2 columns", 'elessi-theme'),
                "3-cols" => esc_html__("3 columns", 'elessi-theme')
            )
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Meta Info - Blog Style", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Meta info - Blog style", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Author info", 'elessi-theme'),
            "id" => "show_author_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Datetime info", 'elessi-theme'),
            "id" => "show_date_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Categories info", 'elessi-theme'),
            "id" => "show_cat_info",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tags info", 'elessi-theme'),
            "id" => "show_tag_info",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Comment Count info", 'elessi-theme'),
            "id" => "show_comment_info",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Readmore", 'elessi-theme'),
            "id" => "show_readmore_blog",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Short description (Only use for Blog Grid layout)", 'elessi-theme'),
            "id" => "show_desc_blog",
            "std" => 1,
            "type" => "switch"
        );
        
        /* ======================================================================= */
        
        $of_options[] = array(
            "name" => esc_html__("Single Page", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Single Blog page", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Main Image", 'elessi-theme'),
            "id" => "main_single_post_image",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Categories info", 'elessi-theme'),
            "id" => "single_cat_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Author - Date info", 'elessi-theme'),
            "id" => "show_author_date_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tags info", 'elessi-theme'),
            "id" => "show_tags_info",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Share icons", 'elessi-theme'),
            "id" => "show_share_icons_info",
            "std" => 1,
            "type" => "switch"
        );
        
        if (NASA_CORE_ACTIVED) {
        
            $of_options[] = array(
                "name" => esc_html__("Related", 'elessi-theme'),
                "id" => "relate_blogs",
                "std" => 1,
                "type" => "switch"
            );

            $of_options[] = array(
                "name" => esc_html__("Number for relate blog", 'elessi-theme'),
                "id" => "relate_blogs_number",
                "std" => "10",
                "type" => "text"
            );

            $of_options[] = array(
                "name" => esc_html__("Columns Relate in desktop", 'elessi-theme'),
                "id" => "relate_blogs_columns_desk",
                "std" => "3-cols",
                "type" => "select",
                "options" => array(
                    "3-cols" => esc_html__("3 columns", 'elessi-theme'),
                    "4-cols" => esc_html__("4 columns", 'elessi-theme'),
                    "5-cols" => esc_html__("5 columns", 'elessi-theme')
                )
            );

            $of_options[] = array(
                "name" => esc_html__("Columns Relate in mobile", 'elessi-theme'),
                "id" => "relate_blogs_columns_small",
                "std" => "1-col",
                "type" => "select",
                "options" => array(
                    "1-cols" => esc_html__("1 column", 'elessi-theme'),
                    "2-cols" => esc_html__("2 columns", 'elessi-theme')
                )
            );

            $of_options[] = array(
                "name" => esc_html__("Columns Relate in Tablet", 'elessi-theme'),
                "id" => "relate_blogs_columns_tablet",
                "std" => "2-cols",
                "type" => "select",
                "options" => array(
                    "1-col" => esc_html__("1 column", 'elessi-theme'),
                    "2-cols" => esc_html__("2 columns", 'elessi-theme'),
                    "3-cols" => esc_html__("3 columns", 'elessi-theme')
                )
            );
        }
    }
}
