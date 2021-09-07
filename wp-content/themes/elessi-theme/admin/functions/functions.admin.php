<?php
/**
 * SMOF Admin
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */

/**
 * Head Hook
 *
 * @since 1.0.0
 */
function of_head() {
    do_action('of_head');
}

/**
 * Add default options upon activation else DB does not exist
 *
 * DEPRECATED, Class_options_machine now does this on load to ensure all values are set
 *
 * @since 1.0.0
 */
function of_option_setup() {
    global $of_options, $options_machine;
    $options_machine = new Options_Machine($of_options);

    if (!of_get_options()) {
        of_save_options($options_machine->Defaults);
    }
}

/**
 * Change activation message
 *
 * @since 1.0.0
 */
function optionsframework_admin_message() {

    //Tweaked the message on theme activate
    ?>
    <script>
        jQuery(function () {
            var message = '<p>This theme comes with an <a href="<?php echo esc_url(admin_url('admin.php?page=optionsframework')); ?>">options panel</a> to configure settings. This theme also supports widgets, please visit the <a href="<?php echo esc_url(admin_url('widgets.php')); ?>">widgets settings page</a> to configure them.</p>';
            jQuery('.themes-php #message2').html(message);
        });
    </script>
    <?php
}

/**
 * Get header classes
 *
 * @since 1.0.0
 */
function of_get_header_classes_array() {
    global $of_options;
    
    $hooks = !isset($hooks) ? array() : $hooks;
    
    foreach ($of_options as $value) {
        if ($value['type'] == 'heading') {
            $hooks[] = isset($value['target']) ? 'heading-' . str_replace(' ', '-', strtolower($value['target'])) : str_replace(' ', '', strtolower($value['name']));
        }
    }

    return $hooks;
}

/**
 * Save options to the database after processing them
 *
 * @param $data Options array to save
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @uses update_option()
 * @return void
 */
function of_save_options($data, $key = null) {
    global $smof_data;
    
    if (empty($data)) {
        return;
    }
    
    do_action('of_save_options_before', array(
        'key' => $key,
        'data' => $data
    ));
    
    $data = apply_filters('of_options_before_save', $data);
    if ($key != null) { // Update one specific value
        if ($key == ELESSI_ADMIN_BACKUPS) {
            unset($data['smof_init']); // Don't want to change this.
        }
        set_theme_mod($key, $data);
    } else {
        // Update all values in $data
        foreach ($data as $k => $v) {
            // Only write to the DB when we need to
            if (!isset($smof_data[$k]) || $smof_data[$k] != $v) {
                set_theme_mod($k, $v);
            } elseif (is_array($v)) {
                foreach ($v as $key => $val) {
                    if ($key != $k && $v[$key] == $val) {
                        set_theme_mod($k, $v);
                        break;
                    }
                }
            }
        }
    }
    
    do_action('of_save_options_after', array(
        'key' => $key,
        'data' => $data
    ));
}

/**
 * Filter URLs from uploaded media fields and replaces them with keywords.
 * This is to keep from storing the site URL in the database to make
 * migrations easier.
 * 
 * @since 1.4.0
 * @param $data Options array
 * @return array
 */
add_filter('of_options_before_save', 'of_filter_save_media_upload');
function of_filter_save_media_upload($data) {

    if (!is_array($data)) {
        return $data;
    }

    foreach ($data as $key => $value) {
        if (is_string($value)) {
            $data[$key] = str_replace(
                array(
                    site_url('', 'http'),
                    site_url('', 'https'),
                ), array(
                    '[site_url]',
                    '[site_url_secure]',
                ), $value
            );
        }
    }

    return $data;
}

/**
 * For use in themes
 *
 * @since forever
 */
$data = of_get_options();
if (!isset($smof_details)) {
    $smof_details = array();
}

/**
 * Filter URLs from uploaded media fields and replaces the site URL keywords
 * with the actual site URL.
 * 
 * @since 1.4.0
 * @param $data Options array
 * @return array
 */
add_filter('of_options_after_load', 'of_filter_load_media_upload');
function of_filter_load_media_upload($data) {

    if (!is_array($data)) {
        return $data;
    }

    foreach ($data as $key => $value) {
        if (is_string($value)) {
            $data[$key] = str_replace(
                array(
                    '[site_url]',
                    '[site_url_secure]',
                ), array(
                    site_url('', 'http'),
                    site_url('', 'https'),
                ), $value
            );
        }
    }

    return $data;
}

/**
 * Get options from the database and process them with the load filter hook.
 *
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @return array
 */
function of_get_options($key = null, $data = null) {
    global $smof_data;

    do_action('of_get_options_before', array(
        'key' => $key,
        'data' => $data
    ));
    
    $data = $key != null ? get_theme_mod($key, $data) : get_theme_mods();
    $data = apply_filters('of_options_after_load', $data);
    
    if ($key == null) {
        $smof_data = $data;
    } else {
        $smof_data[$key] = $data;
    }

    do_action('of_option_setup_before', array(
        'key' => $key,
        'data' => $data
    ));

    return $data;
}

/* ======================================================================== */
/* ================== Custom ADMIN ======================================== */
/* ======================================================================== */

/**
 * Get Menu Options
 */
function elessi_admin_get_menu_options() {
    $menus = function_exists('nasa_meta_get_list_menus') ?
        nasa_meta_get_list_menus() : array();

    if (isset($menus['-1'])) {
        unset($menus['-1']);
    }

    return $menus;
}

/**
 * Get static Blocks
 */
function elessi_admin_get_static_blocks() {
    $static_blocks = array('default' => esc_html__('Select the Static Block', 'elessi-theme'));
    
    $nasa_blocks = function_exists('nasa_get_blocks_options') ?
        nasa_get_blocks_options() : array();

    if (isset($nasa_blocks[''])) {
        unset($nasa_blocks['']);
    }

    if (isset($nasa_blocks['-1'])) {
        unset($nasa_blocks['-1']);
    }
    
    if (!empty($nasa_blocks)) {
        foreach ($nasa_blocks as $key => $value) {
            $static_blocks[$key] = $value;
        }
    }

    return $static_blocks;
}

/**
 * Get Footer Builder
 */
function elessi_admin_get_footer_builder() {
    $footers_builder = function_exists('nasa_get_footers_options') ?
        nasa_get_footers_options() : array();

    if (isset($footers_builder[''])) {
        unset($footers_builder['']);
    }

    return $footers_builder;
}

/**
 * Get Footer Elementor
 */
function elessi_admin_get_footer_elementor() {
    $footers = function_exists('nasa_get_footers_elementor') ?
        nasa_get_footers_elementor() : array();

    return $footers;
}

/**
 * Get Header Builder
 */
function elessi_admin_get_header_builder() {
    $headers_builder = function_exists('nasa_get_headers_options') ?
        nasa_get_headers_options() : array();

    if (isset($headers_builder[''])) {
        unset($headers_builder['']);
    }

    return $headers_builder;
}

/**
 * Get cats
 */
function elessi_get_cats_array() {
    $categories = get_categories(array(
        'taxonomy' => 'category',
        'orderby' => 'name'
    ));
    $list = array(
        '' => esc_html__('Select category', 'elessi-theme')
    );

    if (!empty($categories)) {
        foreach ($categories as $v) {
            $list[$v->term_id] = $v->name;
        }
    }

    return $list;
}

/**
 * Get Goolge Fonts
 */
function elessi_get_google_fonts() {
    return function_exists('nasa_get_google_fonts') ? nasa_get_google_fonts() : array();
}

if (!isset($nasa_list_icons)) {
    $nasa_list_icons = array(
        'nasa' => array(
            "icon-nasa-headphone",
            "icon-nasa-headset",
            "icon-nasa-icons-4",
            "icon-nasa-cart",
            "icon-nasa-cart-2",
            "icon-nasa-cart-3",
            "icon-nasa-cart-4",
            "icon-nasa-refresh",
            "icon-nasa-compare",
            "icon-nasa-compare-1",
            "icon-nasa-compare-2",
            "icon-nasa-compare-3",
            "icon-nasa-compare-4",
            "icon-nasa-compare-5",
            "icon-nasa-like",
            "icon-nasa-liked",
            "icon-nasa-wishlist",
            "icon-nasa-like-love-streamline",
            "icon-nasa-1column",
            "icon-nasa-2column",
            "icon-nasa-3column",
            "icon-nasa-4column",
            "icon-nasa-5column",
            "icon-nasa-6column",
            "icon-nasa-list",
            "icon-nasa-icons-17",
            "icon-nasa-icons-18",
            "icon-nasa-icons-19",
            "icon-nasa-icons-21",
            "icon-nasa-icons-menu",
            "icon-nasa-icons-1",
            "icon-nasa-icons-6",
            "icon-nasa-sale",
            "icon-nasa-sale-1",
            "icon-nasa-sale-2",
            "icon-nasa-like-hand",
            "icon-nasa-car",
            "icon-nasa-car-1",
            "icon-nasa-car-2",
            "icon-nasa-location",
            "icon-nasa-credit",
            "icon-nasa-icons-15",
            "icon-nasa-99",
            "icon-nasa-search",
            "icon-nasa-if-search",
            "icon-nasa-left-arrow",
            "icon-nasa-right-arrow",
            "icon-nasa-icons-8",
            "icon-nasa-icons-10",
            "icon-nasa-icons-11",
            "icon-nasa-icons-12-1",
            "icon-nasa-expand",
            "icon-nasa-play",
            "icon-nasa-close",
            "icon-nasa-close-1",
            "icon-nasa-close-2",
            "icon-nasa-icons-12",
            "icon-nasa-99-1",
            "icon-nasa-mouse",
            "icon-nasa-computer",
            "icon-nasa-check",
            "icon-nasa-check-1",
            "icon-nasa-icons-plus",
            "icon-nasa-icons-minus",
            "icon-nasa-fruit",
            "icon-nasa-diet",
            "icon-nasa-orange",
            "icon-nasa-parsley",
            "icon-nasa-onion",
            "icon-nasa-banana",
            "icon-nasa-potatoes",
            "icon-nasa-raspberry",
            "icon-nasa-healthy-food",
            "icon-nasa-meat",
            "icon-nasa-fish",
            "icon-nasa-fast-food",
            "icon-nasa-tomato"
        ),
        
        'fa' => array(
            "fa-glass",
            "fa-music",
            "fa-search",
            "fa-envelope-o",
            "fa-heart",
            "fa-star",
            "fa-star-o",
            "fa-user",
            "fa-film",
            "fa-th-large",
            "fa-th",
            "fa-th-list",
            "fa-check",
            "fa-remove",
            "fa-close",
            "fa-times",
            "fa-search-plus",
            "fa-search-minus",
            "fa-power-off",
            "fa-signal",
            "fa-gear",
            "fa-cog",
            "fa-trash-o",
            "fa-home",
            "fa-file-o",
            "fa-clock-o",
            "fa-road",
            "fa-download",
            "fa-arrow-circle-o-down",
            "fa-arrow-circle-o-up",
            "fa-inbox",
            "fa-play-circle-o",
            "fa-rotate-right",
            "fa-repeat",
            "fa-refresh",
            "fa-list-alt",
            "fa-lock",
            "fa-flag",
            "fa-headphones",
            "fa-volume-off",
            "fa-volume-down",
            "fa-volume-up",
            "fa-qrcode",
            "fa-barcode",
            "fa-tag",
            "fa-tags",
            "fa-book",
            "fa-bookmark",
            "fa-print",
            "fa-camera",
            "fa-font",
            "fa-bold",
            "fa-italic",
            "fa-text-height",
            "fa-text-width",
            "fa-align-left",
            "fa-align-center",
            "fa-align-right",
            "fa-align-justify",
            "fa-list",
            "fa-dedent",
            "fa-outdent",
            "fa-indent",
            "fa-video-camera",
            "fa-photo",
            "fa-image",
            "fa-picture-o",
            "fa-pencil",
            "fa-map-marker",
            "fa-adjust",
            "fa-tint",
            "fa-edit",
            "fa-pencil-square-o",
            "fa-share-square-o",
            "fa-check-square-o",
            "fa-arrows",
            "fa-step-backward",
            "fa-fast-backward",
            "fa-backward",
            "fa-play",
            "fa-pause",
            "fa-stop",
            "fa-forward",
            "fa-fast-forward",
            "fa-step-forward",
            "fa-eject",
            "fa-chevron-left",
            "fa-chevron-right",
            "fa-plus-circle",
            "fa-minus-circle",
            "fa-times-circle",
            "fa-check-circle",
            "fa-question-circle",
            "fa-info-circle",
            "fa-crosshairs",
            "fa-times-circle-o",
            "fa-check-circle-o",
            "fa-ban",
            "fa-arrow-left",
            "fa-arrow-right",
            "fa-arrow-up",
            "fa-arrow-down",
            "fa-mail-forward",
            "fa-share",
            "fa-expand",
            "fa-compress",
            "fa-plus",
            "fa-minus",
            "fa-asterisk",
            "fa-exclamation-circle",
            "fa-gift",
            "fa-leaf",
            "fa-fire",
            "fa-eye",
            "fa-eye-slash",
            "fa-warning",
            "fa-exclamation-triangle",
            "fa-plane",
            "fa-calendar",
            "fa-random",
            "fa-comment",
            "fa-magnet",
            "fa-chevron-up",
            "fa-chevron-down",
            "fa-retweet",
            "fa-shopping-cart",
            "fa-folder",
            "fa-folder-open",
            "fa-arrows-v",
            "fa-arrows-h",
            "fa-bar-chart-o",
            "fa-bar-chart",
            "fa-twitter-square",
            "fa-facebook-square",
            "fa-camera-retro",
            "fa-key",
            "fa-gears",
            "fa-cogs",
            "fa-comments",
            "fa-thumbs-o-up",
            "fa-thumbs-o-down",
            "fa-star-half",
            "fa-heart-o",
            "fa-sign-out",
            "fa-linkedin-square",
            "fa-thumb-tack",
            "fa-external-link",
            "fa-sign-in",
            "fa-trophy",
            "fa-github-square",
            "fa-upload",
            "fa-lemon-o",
            "fa-phone",
            "fa-square-o",
            "fa-bookmark-o",
            "fa-phone-square",
            "fa-twitter",
            "fa-facebook",
            "fa-github",
            "fa-unlock",
            "fa-credit-card",
            "fa-rss",
            "fa-hdd-o",
            "fa-bullhorn",
            "fa-bell",
            "fa-certificate",
            "fa-hand-o-right",
            "fa-hand-o-left",
            "fa-hand-o-up",
            "fa-hand-o-down",
            "fa-arrow-circle-left",
            "fa-arrow-circle-right",
            "fa-arrow-circle-up",
            "fa-arrow-circle-down",
            "fa-globe",
            "fa-wrench",
            "fa-tasks",
            "fa-filter",
            "fa-briefcase",
            "fa-arrows-alt",
            "fa-group",
            "fa-users",
            "fa-chain",
            "fa-link",
            "fa-cloud",
            "fa-flask",
            "fa-cut",
            "fa-scissors",
            "fa-copy",
            "fa-files-o",
            "fa-paperclip",
            "fa-save",
            "fa-floppy-o",
            "fa-square",
            "fa-navicon",
            "fa-reorder",
            "fa-bars",
            "fa-list-ul",
            "fa-list-ol",
            "fa-strikethrough",
            "fa-underline",
            "fa-table",
            "fa-magic",
            "fa-truck",
            "fa-pinterest",
            "fa-pinterest-square",
            "fa-google-plus-square",
            "fa-google-plus",
            "fa-money",
            "fa-caret-down",
            "fa-caret-up",
            "fa-caret-left",
            "fa-caret-right",
            "fa-columns",
            "fa-unsorted",
            "fa-sort",
            "fa-sort-down",
            "fa-sort-desc",
            "fa-sort-up",
            "fa-sort-asc",
            "fa-envelope",
            "fa-linkedin",
            "fa-rotate-left",
            "fa-undo",
            "fa-legal",
            "fa-gavel",
            "fa-dashboard",
            "fa-tachometer",
            "fa-comment-o",
            "fa-comments-o",
            "fa-flash",
            "fa-bolt",
            "fa-sitemap",
            "fa-umbrella",
            "fa-paste",
            "fa-clipboard",
            "fa-lightbulb-o",
            "fa-exchange",
            "fa-cloud-download",
            "fa-cloud-upload",
            "fa-user-md",
            "fa-stethoscope",
            "fa-suitcase",
            "fa-bell-o",
            "fa-coffee",
            "fa-cutlery",
            "fa-file-text-o",
            "fa-building-o",
            "fa-hospital-o",
            "fa-ambulance",
            "fa-medkit",
            "fa-fighter-jet",
            "fa-beer",
            "fa-h-square",
            "fa-plus-square",
            "fa-angle-double-left",
            "fa-angle-double-right",
            "fa-angle-double-up",
            "fa-angle-double-down",
            "fa-angle-left",
            "fa-angle-right",
            "fa-angle-up",
            "fa-angle-down",
            "fa-desktop",
            "fa-laptop",
            "fa-tablet",
            "fa-mobile-phone",
            "fa-mobile",
            "fa-circle-o",
            "fa-quote-left",
            "fa-quote-right",
            "fa-spinner",
            "fa-circle",
            "fa-mail-reply",
            "fa-reply",
            "fa-github-alt",
            "fa-folder-o",
            "fa-folder-open-o",
            "fa-smile-o",
            "fa-frown-o",
            "fa-meh-o",
            "fa-gamepad",
            "fa-keyboard-o",
            "fa-flag-o",
            "fa-flag-checkered",
            "fa-terminal",
            "fa-code",
            "fa-mail-reply-all",
            "fa-reply-all",
            "fa-star-half-empty",
            "fa-star-half-full",
            "fa-star-half-o",
            "fa-location-arrow",
            "fa-crop",
            "fa-code-fork",
            "fa-unlink",
            "fa-chain-broken",
            "fa-question",
            "fa-info",
            "fa-exclamation",
            "fa-superscript",
            "fa-subscript",
            "fa-eraser",
            "fa-puzzle-piece",
            "fa-microphone",
            "fa-microphone-slash",
            "fa-shield",
            "fa-calendar-o",
            "fa-fire-extinguisher",
            "fa-rocket",
            "fa-maxcdn",
            "fa-chevron-circle-left",
            "fa-chevron-circle-right",
            "fa-chevron-circle-up",
            "fa-chevron-circle-down",
            "fa-html5",
            "fa-css3",
            "fa-anchor",
            "fa-unlock-alt",
            "fa-bullseye",
            "fa-ellipsis-h",
            "fa-ellipsis-v",
            "fa-rss-square",
            "fa-play-circle",
            "fa-ticket",
            "fa-minus-square",
            "fa-minus-square-o",
            "fa-level-up",
            "fa-level-down",
            "fa-check-square",
            "fa-pencil-square",
            "fa-external-link-square",
            "fa-share-square",
            "fa-compass",
            "fa-toggle-down",
            "fa-caret-square-o-down",
            "fa-toggle-up",
            "fa-caret-square-o-up",
            "fa-toggle-right",
            "fa-caret-square-o-right",
            "fa-euro",
            "fa-eur",
            "fa-gbp",
            "fa-dollar",
            "fa-usd",
            "fa-rupee",
            "fa-inr",
            "fa-cny",
            "fa-rmb",
            "fa-yen",
            "fa-jpy",
            "fa-ruble",
            "fa-rouble",
            "fa-rub",
            "fa-won",
            "fa-krw",
            "fa-bitcoin",
            "fa-btc",
            "fa-file",
            "fa-file-text",
            "fa-sort-alpha-asc",
            "fa-sort-alpha-desc",
            "fa-sort-amount-asc",
            "fa-sort-amount-desc",
            "fa-sort-numeric-asc",
            "fa-sort-numeric-desc",
            "fa-thumbs-up",
            "fa-thumbs-down",
            "fa-youtube-square",
            "fa-youtube",
            "fa-xing",
            "fa-xing-square",
            "fa-youtube-play",
            "fa-dropbox",
            "fa-stack-overflow",
            "fa-instagram",
            "fa-flickr",
            "fa-adn",
            "fa-bitbucket",
            "fa-bitbucket-square",
            "fa-tumblr",
            "fa-tumblr-square",
            "fa-long-arrow-down",
            "fa-long-arrow-up",
            "fa-long-arrow-left",
            "fa-long-arrow-right",
            "fa-apple",
            "fa-windows",
            "fa-android",
            "fa-linux",
            "fa-dribbble",
            "fa-skype",
            "fa-foursquare",
            "fa-trello",
            "fa-female",
            "fa-male",
            "fa-gittip",
            "fa-sun-o",
            "fa-moon-o",
            "fa-archive",
            "fa-bug",
            "fa-vk",
            "fa-weibo",
            "fa-renren",
            "fa-pagelines",
            "fa-stack-exchange",
            "fa-arrow-circle-o-right",
            "fa-arrow-circle-o-left",
            "fa-toggle-left",
            "fa-caret-square-o-left",
            "fa-dot-circle-o",
            "fa-wheelchair",
            "fa-vimeo-square",
            "fa-turkish-lira",
            "fa-try",
            "fa-plus-square-o",
            "fa-space-shuttle",
            "fa-slack",
            "fa-envelope-square",
            "fa-wordpress",
            "fa-openid",
            "fa-institution",
            "fa-bank",
            "fa-university",
            "fa-mortar-board",
            "fa-graduation-cap",
            "fa-yahoo",
            "fa-google",
            "fa-reddit",
            "fa-reddit-square",
            "fa-stumbleupon-circle",
            "fa-stumbleupon",
            "fa-delicious",
            "fa-digg",
            "fa-pied-piper",
            "fa-pied-piper-alt",
            "fa-drupal",
            "fa-joomla",
            "fa-language",
            "fa-fax",
            "fa-building",
            "fa-child",
            "fa-paw",
            "fa-spoon",
            "fa-cube",
            "fa-cubes",
            "fa-behance",
            "fa-behance-square",
            "fa-steam",
            "fa-steam-square",
            "fa-recycle",
            "fa-automobile",
            "fa-car",
            "fa-cab",
            "fa-taxi",
            "fa-tree",
            "fa-spotify",
            "fa-deviantart",
            "fa-soundcloud",
            "fa-database",
            "fa-file-pdf-o",
            "fa-file-word-o",
            "fa-file-excel-o",
            "fa-file-powerpoint-o",
            "fa-file-photo-o",
            "fa-file-picture-o",
            "fa-file-image-o",
            "fa-file-zip-o",
            "fa-file-archive-o",
            "fa-file-sound-o",
            "fa-file-audio-o",
            "fa-file-movie-o",
            "fa-file-video-o",
            "fa-file-code-o",
            "fa-vine",
            "fa-codepen",
            "fa-jsfiddle",
            "fa-life-bouy",
            "fa-life-buoy",
            "fa-life-saver",
            "fa-support",
            "fa-life-ring",
            "fa-circle-o-notch",
            "fa-ra",
            "fa-rebel",
            "fa-ge",
            "fa-empire",
            "fa-git-square",
            "fa-git",
            "fa-hacker-news",
            "fa-tencent-weibo",
            "fa-qq",
            "fa-wechat",
            "fa-weixin",
            "fa-send",
            "fa-paper-plane",
            "fa-send-o",
            "fa-paper-plane-o",
            "fa-history",
            "fa-circle-thin",
            "fa-header",
            "fa-paragraph",
            "fa-sliders",
            "fa-share-alt",
            "fa-share-alt-square",
            "fa-bomb",
            "fa-soccer-ball-o",
            "fa-futbol-o",
            "fa-tty",
            "fa-binoculars",
            "fa-plug",
            "fa-slideshare",
            "fa-twitch",
            "fa-yelp",
            "fa-newspaper-o",
            "fa-wifi",
            "fa-calculator",
            "fa-paypal",
            "fa-google-wallet",
            "fa-cc-visa",
            "fa-cc-mastercard",
            "fa-cc-discover",
            "fa-cc-amex",
            "fa-cc-paypal",
            "fa-cc-stripe",
            "fa-bell-slash",
            "fa-bell-slash-o",
            "fa-trash",
            "fa-copyright",
            "fa-at",
            "fa-eyedropper",
            "fa-paint-brush",
            "fa-birthday-cake",
            "fa-area-chart",
            "fa-pie-chart",
            "fa-line-chart",
            "fa-lastfm",
            "fa-lastfm-square",
            "fa-toggle-off",
            "fa-toggle-on",
            "fa-bicycle",
            "fa-bus",
            "fa-ioxhost",
            "fa-angellist",
            "fa-cc",
            "fa-shekel",
            "fa-sheqel",
            "fa-ils",
            "fa-meanpath",
        ),
        'pe' => array(
            'pe-7s-album', 'pe-7s-arc', 'pe-7s-back-2', 'pe-7s-bandaid', 'pe-7s-car', 'pe-7s-diamond',
            'pe-7s-door-lock', 'pe-7s-eyedropper', 'pe-7s-female', 'pe-7s-gym', 'pe-7s-hammer',
            'pe-7s-headphones', 'pe-7s-helm', 'pe-7s-hourglass', 'pe-7s-leaf', 'pe-7s-magic-wand',
            'pe-7s-male', 'pe-7s-map-2', 'pe-7s-next-2', 'pe-7s-paint-bucket', 'pe-7s-pendrive',
            'pe-7s-photo', 'pe-7s-piggy', 'pe-7s-plugin', 'pe-7s-refresh-2', 'pe-7s-rocket', 'pe-7s-settings',
            'pe-7s-shield', 'pe-7s-smile', 'pe-7s-usb', 'pe-7s-vector', 'pe-7s-wine', 'pe-7s-cloud-upload',
            'pe-7s-cash', 'pe-7s-close', 'pe-7s-bluetooth', 'pe-7s-cloud-download', 'pe-7s-way',
            'pe-7s-close-circle', 'pe-7s-id', 'pe-7s-angle-up', 'pe-7s-wristwatch', 'pe-7s-angle-up-circle',
            'pe-7s-world', 'pe-7s-angle-right', 'pe-7s-volume', 'pe-7s-angle-right-circle',
            'pe-7s-users', 'pe-7s-angle-left', 'pe-7s-user-female', 'pe-7s-angle-left-circle',
            'pe-7s-up-arrow', 'pe-7s-angle-down', 'pe-7s-switch', 'pe-7s-angle-down-circle', 'pe-7s-scissors',
            'pe-7s-wallet', 'pe-7s-safe', 'pe-7s-volume2', 'pe-7s-volume1', 'pe-7s-voicemail',
            'pe-7s-video', 'pe-7s-user', 'pe-7s-upload', 'pe-7s-unlock', 'pe-7s-umbrella', 'pe-7s-trash',
            'pe-7s-tools', 'pe-7s-timer', 'pe-7s-ticket', 'pe-7s-target', 'pe-7s-sun', 'pe-7s-study',
            'pe-7s-stopwatch', 'pe-7s-star', 'pe-7s-speaker', 'pe-7s-signal', 'pe-7s-shuffle',
            'pe-7s-shopbag', 'pe-7s-share', 'pe-7s-server', 'pe-7s-search', 'pe-7s-film', 'pe-7s-science',
            'pe-7s-disk', 'pe-7s-ribbon', 'pe-7s-repeat', 'pe-7s-refresh', 'pe-7s-add-user',
            'pe-7s-refresh-cloud', 'pe-7s-paperclip', 'pe-7s-radio', 'pe-7s-note2', 'pe-7s-print',
            'pe-7s-network', 'pe-7s-prev', 'pe-7s-mute', 'pe-7s-power', 'pe-7s-medal', 'pe-7s-portfolio',
            'pe-7s-like2', 'pe-7s-plus', 'pe-7s-left-arrow', 'pe-7s-play', 'pe-7s-key', 'pe-7s-plane',
            'pe-7s-joy', 'pe-7s-photo-gallery', 'pe-7s-pin', 'pe-7s-phone', 'pe-7s-plug', 'pe-7s-pen',
            'pe-7s-right-arrow', 'pe-7s-paper-plane', 'pe-7s-delete-user', 'pe-7s-paint', 'pe-7s-bottom-arrow',
            'pe-7s-notebook', 'pe-7s-note', 'pe-7s-next', 'pe-7s-news-paper', 'pe-7s-musiclist',
            'pe-7s-music', 'pe-7s-mouse', 'pe-7s-more', 'pe-7s-moon', 'pe-7s-monitor', 'pe-7s-micro',
            'pe-7s-menu', 'pe-7s-map', 'pe-7s-map-marker', 'pe-7s-mail', 'pe-7s-mail-open',
            'pe-7s-mail-open-file', 'pe-7s-magnet', 'pe-7s-loop', 'pe-7s-look', 'pe-7s-lock', 'pe-7s-lintern',
            'pe-7s-link', 'pe-7s-like', 'pe-7s-light', 'pe-7s-less', 'pe-7s-keypad', 'pe-7s-junk',
            'pe-7s-info', 'pe-7s-home', 'pe-7s-help2', 'pe-7s-help1', 'pe-7s-graph3', 'pe-7s-graph2',
            'pe-7s-graph1', 'pe-7s-graph', 'pe-7s-global', 'pe-7s-gleam', 'pe-7s-glasses', 'pe-7s-gift',
            'pe-7s-folder', 'pe-7s-flag', 'pe-7s-filter', 'pe-7s-file', 'pe-7s-expand1', 'pe-7s-exapnd2',
            'pe-7s-edit', 'pe-7s-drop', 'pe-7s-drawer', 'pe-7s-download', 'pe-7s-display2', 'pe-7s-display1',
            'pe-7s-diskette', 'pe-7s-date', 'pe-7s-cup', 'pe-7s-culture', 'pe-7s-crop', 'pe-7s-credit',
            'pe-7s-copy-file', 'pe-7s-config', 'pe-7s-compass', 'pe-7s-comment', 'pe-7s-coffee', 'pe-7s-cloud',
            'pe-7s-clock', 'pe-7s-check', 'pe-7s-chat', 'pe-7s-cart', 'pe-7s-camera', 'pe-7s-call',
            'pe-7s-calculator', 'pe-7s-browser', 'pe-7s-box2', 'pe-7s-box1', 'pe-7s-bookmarks', 'pe-7s-bicycle',
            'pe-7s-bell', 'pe-7s-battery', 'pe-7s-ball', 'pe-7s-back', 'pe-7s-attention', 'pe-7s-anchor',
            'pe-7s-albums', 'pe-7s-alarm', 'pe-7s-airplay'
        )
    );
}

add_action('admin_head', 'elessi_style_script');
function elessi_style_script() {
    // echo '<script>var ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '";</script>';
    wp_enqueue_style('wp-color-picker');
    wp_register_style('elessi-style', ELESSI_THEME_URI . '/admin/assets/css/nasa-style.css');
    wp_enqueue_style('elessi-style');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('elessi-admin-script', ELESSI_THEME_URI . '/admin/assets/js/nasa-script.js', array(), null, true);
    wp_add_inline_script('elessi-admin-script', 'var ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '";', 'before');
    elessi_add_font_custom_admin();
}

// **********************************************************************// 
// ! Add Font Awesome, Font Pe7s, Font Elegant
// **********************************************************************// 
function elessi_add_font_custom_admin() {
    wp_register_style('elessi-font-awesome-style', ELESSI_THEME_URI . '/assets/font-awesome-4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('elessi-font-awesome-style');
    wp_register_style('elessi-font-pe7s-style', ELESSI_THEME_URI . '/assets/font-pe-icon-7-stroke/css/pe-icon-7-stroke.css');
    wp_enqueue_style('elessi-font-pe7s-style');
    wp_register_style('elessi-font-nasa-style', ELESSI_THEME_URI . '/assets/font-nasa/nasa-font.css');
    wp_enqueue_style('elessi-font-nasa-style');
}

add_action('wp_ajax_nasa_list_fonts_admin', 'elessi_list_fonts_admin');
function elessi_list_fonts_admin() {
    global $nasa_list_icons;
    ?>
    <div class="nasa-list-icons-select" data-fill="<?php echo esc_attr($_REQUEST['fill']); ?>">
        <input name="search-icons" value="" class="nasa-input-search-icon" placeholder="<?php echo esc_attr__('Search icon', 'elessi-theme'); ?>" />
        
        <?php do_action('nasa_before_list_icons_admin'); ?>
        
        <h3><?php echo esc_html__('Font Nasa icons', 'elessi-theme'); ?></h3>
        <?php foreach ($nasa_list_icons['nasa'] as $font) : ?>
            <a class="nasa-fill-icon nasa-font-icon nasa-font-icons" href="javascript:void(0);" data-val="nasa-icon <?php echo esc_attr($font); ?>" data-text="nasa-icon <?php echo esc_attr($font); ?>"><i class="<?php echo esc_attr($font); ?>"></i></a>
        <?php endforeach; ?>

        <hr />
        <h3><?php echo esc_html__('Fontawesome icons', 'elessi-theme'); ?></h3>
        <?php foreach ($nasa_list_icons['fa'] as $font) : ?>
            <a class="nasa-fill-icon nasa-fa-icon nasa-font-icons" href="javascript:void(0);" data-val="fa <?php echo esc_attr($font); ?>" data-text="<?php echo esc_attr($font); ?>"><i class="fa <?php echo esc_attr($font); ?>"></i></a>
        <?php endforeach; ?>
        
        <hr />
        <h3><?php echo esc_html__('Pe7s icons', 'elessi-theme'); ?></h3>
        <?php foreach ($nasa_list_icons['pe'] as $font) : ?>
            <a class="nasa-fill-icon nasa-pe7-icon nasa-font-icons" href="javascript:void(0);" data-val="pe7-icon <?php echo esc_attr($font); ?>" data-text="<?php echo esc_attr($font); ?>"><i class="<?php echo esc_attr($font); ?>"></i></a>
        <?php endforeach; ?>
            
        <?php do_action('nasa_after_list_icons_admin'); ?>
        
    </div>
    <?php
    die();
}

/**
 * Check access token Instagram
 */
add_action('wp_ajax_nasa_check_instagram_token', 'nasa_check_instagram_token');
function nasa_check_instagram_token() {
    if (!isset($_REQUEST['access_token']) || !$_REQUEST['access_token']) {
        die(json_encode(array('error' => '1')));
    }
    
    $instagrams = explode('.', $_REQUEST['access_token']);
    $acc_id = isset($instagrams[0]) ? $instagrams[0] : 0;
    $urlUser = $acc_id ? 'https://api.instagram.com/v1/users/self/?access_token=' . $_REQUEST['access_token'] : false;
    
    $args = array(
        'timeout' => 60,
        'sslverify' => false
    );
    
    $result = wp_remote_get($urlUser, $args);
    
    if (!is_wp_error($result)) {
        $data = json_decode($result['body']);
        $output = '';
        $instagramInfo = "";
        
        if (isset($data->data->id)) {
            $output .= '<img src="' . $data->data->profile_picture . '" alt="' . $data->data->username . '" width="100" height="100" />';
            $output .= '<div>' . esc_html__('Username:', 'elessi-theme') . ' <strong>' . $data->data->username . "</strong></div>";
            $instagramInfo = array(
                'id' => $data->data->id,
                'username' => esc_attr($data->data->username),
                'profile_picture' => esc_url($data->data->profile_picture)
            );
        } else {
            $output .= 'No id returned' . "\n";
            $output .= 'code: ' . $data->meta->code . "\n";
            if (isset($data->meta->error_message)) {
                $output .= 'error_message: ' . $data->meta->error_message . "\n";
            }
        }
        
        die(json_encode(array(
            'error' => '0',
            'output' => $output,
            'info' => json_encode($instagramInfo)
        )));
    }
    
    die(json_encode(array('error' => '1')));
}

/**
 * Get Template Compare
 * @return type
 */
function get_pages_temp_compare() {
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-view-compare.php'
    ));
    
    $pages_compare = array('' => esc_html__('Select page view compare', 'elessi-theme'));
    if ($pages) {
        foreach ($pages as $page) {
            $pages_compare[$page->ID . '-page'] = $page->post_title;
        }
    }
    
    return $pages_compare;
}

function get_pages_temp_portfolio() {
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'portfolio.php'
    ));
    
    $portfolio = array('' => esc_html__('Select page view Portfolio', 'elessi-theme'));
    if ($pages) {
        foreach ($pages as $page) {
            $portfolio[$page->ID . '-page'] = $page->post_title;
        }
    }
    
    return $portfolio;
}

/**
 * Get custom fonts
 */
function elessi_get_custom_fonts() {
    return function_exists('nasa_get_custom_fonts') ? nasa_get_custom_fonts() : array();
}

/**
 * Add new custom font
 */
add_action('init', 'elessi_add_new_custom_font', 1);
function elessi_add_new_custom_font() {
    $result = array('success' => false);
    
    if (!current_user_can('manage_options')) {
        $result['mess'] = esc_html__("Access denied.", 'elessi-theme');
        return $result;
    }
    
    if (!isset($_FILES['zip_packet_font'])) {
        $result['mess'] = esc_html__("Require ZIP file.", 'elessi-theme');
        return $result;
    }
    
    header('X-XSS-Protection:0');
    
    $filename = $_FILES["zip_packet_font"]["name"];
    $type = $_FILES["zip_packet_font"]["type"];
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    
    if (!in_array($type, $accepted_types)) {
        $result['mess'] = esc_html__("The file you are trying to upload is not a .zip file. Please try again.", 'elessi-theme');
        return $result;
    }

    $name = explode(".", $filename);
    if (strtolower($name[1]) != 'zip') {
        $result['mess'] = esc_html__("The file you are trying to upload is not a .zip file. Please try again.", 'elessi-theme');
        return $result;
    }
    
    global $wp_filesystem, $nasa_upload_dir;
    
    if (!isset($nasa_upload_dir)) {
        $nasa_upload_dir = wp_upload_dir();
        $GLOBALS['nasa_upload_dir'] = $nasa_upload_dir;
    }
    
    // Initialize the WP filesystem
    if (empty($wp_filesystem)) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }
    
    add_filter('upload_dir', 'elessi_base_upload_dir_zip');
    $uploadZip = wp_handle_upload($_FILES['zip_packet_font']);
    remove_filter('upload_dir', 'elessi_base_upload_dir_zip');
    
    if ($uploadZip) {
        $checkDir = $nasa_upload_dir['basedir'] . '/nasa-check-custom-fonts';
        if (!$wp_filesystem->is_dir($checkDir)) {
            if (!wp_mkdir_p($checkDir)) {
                $result['mess'] = "The dir: " . $checkDir . " don't accept create. Please try again.";
                return $result;
            }
        }
        
        $unzip_test = unzip_file($uploadZip["file"], $checkDir);
        if ($unzip_test) {
            $list_unzipfile = $wp_filesystem->dirlist($checkDir);
            $hasDir = false;
            foreach ($list_unzipfile as $key => $value) {
                if (isset($value['type']) && $value['type'] === 'd' && $key == $name[0]) {
                    $hasDir = true;
                    break;
                }
            }
            
            $font_dir = $nasa_upload_dir['basedir'] . '/nasa-custom-fonts';
            if (!$wp_filesystem->is_dir($font_dir)) {
                wp_mkdir_p($font_dir);
            }
            
            if ($wp_filesystem->is_dir($font_dir . '/' . $name[0])) {
                $wp_filesystem->rmdir($font_dir . '/' . $name[0], true);
            }
            
            if (!$hasDir) {
                $font_dir = $font_dir . '/' . $name[0];
                wp_mkdir_p($font_dir);
            }
            
            // Install font
            unzip_file($uploadZip["file"], $font_dir);

            // Remove dir, files tmp
            $wp_filesystem->rmdir($checkDir, true);
            $wp_filesystem->delete($uploadZip["file"]);
            $result['success'] = true;
            $result['mess'] = esc_html__("Upload new custom font success!", 'elessi-theme');
        }
    }
    
    return $result;
}

/**
 * Override the default upload path.
 * 
 * @param   array   $dir
 * @return  array
 */
function elessi_base_upload_dir_zip($dir) {
    return array(
        'path'   => $dir['basedir'] . '/nasatheme-tmp',
        'url'    => $dir['baseurl'] . '/nasatheme-tmp',
        'subdir' => '/nasatheme-zip',
    ) + $dir;
}

/* Remove Tabs - Accordions elements */
add_action('vc_build_admin_page', 'elessi_vc_remove_elements_default', 11);
function elessi_vc_remove_elements_default() {
    
    // remove params tabs
    vc_remove_param('vc_tta_tabs', 'css_animation');
    vc_remove_param('vc_tta_tabs', 'shape');
    vc_remove_param('vc_tta_tabs', 'style');
    vc_remove_param('vc_tta_tabs', 'color');
    vc_remove_param('vc_tta_tabs', 'autoplay');
    vc_remove_param('vc_tta_tabs', 'active_section');
    vc_remove_param('vc_tta_tabs', 'no_fill_content_area');
    vc_remove_param('vc_tta_tabs', 'spacing');
    vc_remove_param('vc_tta_tabs', 'gap');
    vc_remove_param('vc_tta_tabs', 'tab_position');
    vc_remove_param('vc_tta_tabs', 'pagination_style');
    vc_remove_param('vc_tta_tabs', 'pagination_color');
    vc_remove_param('vc_tta_tabs', 'el_id');

    // remove params accordions
    vc_remove_param('vc_tta_accordion', 'css_animation');
    vc_remove_param('vc_tta_accordion', 'style');
    vc_remove_param('vc_tta_accordion', 'shape');
    vc_remove_param('vc_tta_accordion', 'color');
    vc_remove_param('vc_tta_accordion', 'c_align');
    vc_remove_param('vc_tta_accordion', 'no_fill');
    vc_remove_param('vc_tta_accordion', 'spacing');
    vc_remove_param('vc_tta_accordion', 'gap');
    vc_remove_param('vc_tta_accordion', 'autoplay');
    vc_remove_param('vc_tta_accordion', 'c_position');
    vc_remove_param('vc_tta_accordion', 'collapsible_all');
    vc_remove_param('vc_tta_accordion', 'c_icon');
    vc_remove_param('vc_tta_accordion', 'active_section');
    vc_remove_param('vc_tta_accordion', 'el_id');

    vc_remove_element("vc_tabs");
    vc_remove_element("vc_accordion");
    vc_remove_element("vc_carousel");
    vc_remove_element("vc_images_carousel");
    vc_remove_element("vc_tour");
    vc_remove_element("vc_cta");
    vc_remove_element("vc_tta_tour");
    vc_remove_element("vc_tta_pageable");
    vc_remove_element("vc_cta_button");
    vc_remove_element("vc_cta_button2");
    vc_remove_element("vc_button");
    vc_remove_element("vc_button2");
    vc_remove_element("vc_wp_search");
    vc_remove_element("vc_wp_meta");
    vc_remove_element("vc_wp_recentcomments");
    vc_remove_element("vc_wp_calendar");
    vc_remove_element("vc_wp_posts");
    vc_remove_element("vc_wp_links");
    vc_remove_element("vc_wp_archives");
    vc_remove_element("vc_wp_rss");

    vc_remove_param("vc_row", "columns_placement");
    vc_remove_param("vc_row", "full_height");
    vc_remove_param("vc_row", "full_width");
    vc_remove_param("vc_row", "rtl_reverse");
    vc_remove_param("vc_row", "gap");
}
