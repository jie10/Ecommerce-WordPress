<?php
/**
 * Shortcode [nasa_share ...]
 * 
 * @global type $post
 * @global type $nasa_opt
 * @global type $wp
 * @param type $atts
 * @param string $content
 * @return string
 */
function nasa_sc_share($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'el_class' => '',
        'label' => ''
    ), $atts));
    
    global $post, $nasa_opt;
    
    if (isset($post->ID)) {
        $permalink = get_permalink($post->ID);
        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
        $featured_image_2 = isset($featured_image['0']) ? $featured_image['0'] : (isset($nasa_opt['site_logo']) ? $nasa_opt['site_logo'] : '#');
        $post_title = rawurlencode(get_the_title($post->ID));
    } else {
        global $wp;
        $permalink = home_url($wp->request);
        $featured_image_2 = isset($nasa_opt['site_logo']) ? $nasa_opt['site_logo'] : '#';
        $post_title = get_bloginfo('name', 'display');
    }
    
    $class_wrap = 'social-icons nasa-share';
    $class_wrap .= $el_class != '' ? ' ' . esc_attr($el_class) : '';
    
    $share_wrap_start = $title ? '<div class="nasa-share-title">' . $title . '</div>' : '';
    if ($label === '1') {
        $label_content = '<i class="nasa-icon pe-7s-share pe-icon"></i>&nbsp;&nbsp;' . esc_html__('Share', 'nasa-core');
        $share_wrap_start .= '<div class="nasa-share-label">' . $label_content . '</div>';
    }
    
    $share_wrap_start .= '<ul class="' . $class_wrap . '">';
    
    $share = '';
    
    /**
     * Twitter
     */
    if (isset($nasa_opt['social_icons']['twitter']) && $nasa_opt['social_icons']['twitter']) {
        $share .=
        '<li>' .
            '<a href="//twitter.com/share?url=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on Twitter', 'nasa-core') . '" rel="nofollow">' .
                '<i class="fa fa-twitter"></i>' .
            '</a>' .
        '</li>';
    }
        
    /**
     * FaceBook
     */
    if (isset($nasa_opt['social_icons']['facebook']) && $nasa_opt['social_icons']['facebook']) {
        $share .=
        '<li>' .
            '<a href="//www.facebook.com/sharer.php?u=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on Facebook', 'nasa-core') . '" rel="nofollow">' .
                '<i class="fa fa-facebook"></i>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Pinterest
     */
    if (isset($nasa_opt['social_icons']['pinterest']) && $nasa_opt['social_icons']['pinterest']) {
        $share .=
        '<li>' .
            '<a href="//pinterest.com/pin/create/button/?url=' . esc_url($permalink) . '&amp;media=' . esc_attr($featured_image_2) . '&amp;description=' . esc_attr($post_title) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Pin on Pinterest', 'nasa-core') . '" rel="nofollow">' .
                '<i class="fa fa-pinterest"></i>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Linkedin
     */
    if (isset($nasa_opt['social_icons']['linkedin']) && $nasa_opt['social_icons']['linkedin']) {
        $share .=
        '<li>' .
            '<a href="//linkedin.com/shareArticle?mini=true&amp;url=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on Linkedin', 'nasa-core') . '" rel="nofollow">' .
                '<i class="fa fa-linkedin"></i>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Telegram
     */
    if (isset($nasa_opt['social_icons']['telegram']) && $nasa_opt['social_icons']['telegram']) {
        $share .=
        '<li>' .
            '<a href="//telegram.me/share/?url=' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on Telegram', 'nasa-core') . '" rel="nofollow">' .
                '<i class="fa fa-telegram"></i>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * VK
     */
    if (isset($nasa_opt['social_icons']['vk']) && $nasa_opt['social_icons']['vk']) {
        $share .=
        '<li>' .
            '<a href="//vk.com/share.php?url=' . esc_url($permalink) . '&amp;title=' . esc_attr($post_title) . '&amp;image=' . esc_attr($featured_image_2) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Share on VK', 'nasa-core') . '" rel="nofollow">' .
                '<i class="fa fa-vk"></i>' .
            '</a>' .
        '</li>';
    }
    
    /**
     * Email
     */
    if (isset($nasa_opt['social_icons']['email']) && $nasa_opt['social_icons']['email']) {
        $share .=
        '<li>' .
            '<a href="mailto:enter-your-mail@domain-here.com?subject=' . esc_attr($post_title) . '&amp;body=Check%20this%20out:%20' . esc_url($permalink) . '" target="_blank" class="icon nasa-tip" title="' . esc_attr__('Email to your friends', 'nasa-core') . '" rel="nofollow">' .
                '<i class="fa fa-envelope-o"></i>' .
            '</a>' .
        '</li>';
    }

    $share_content = apply_filters('nasa_share_content', $share);
    $share_wrap_end = '</ul>';

    $content = $share_wrap_start . $share_content . $share_wrap_end;
    
    return $content;
}

/**
 * Shortcode [nasa_follow ...]
 * 
 * @global type $nasa_opt
 * @param type $atts
 * @param string $content
 * @return string
 */
function nasa_sc_follow($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'twitter' => '',
        'facebook' => '',
        'vk' => '',
        'pinterest' => '',
        'email' => '',
        'instagram' => '',
        'rss' => '',
        'linkedin' => '',
        'youtube' => '',
        'flickr' => '',
        'telegram' => '',
        'whatsapp' => '',
        'tumblr' => '',
        'weibo' => '',
        'amazon' => '',
        'el_class' => ''
    ), $atts));
    
    global $nasa_opt;
    $facebook = $facebook ? $facebook : (isset($nasa_opt['facebook_url_follow']) ? $nasa_opt['facebook_url_follow'] : '');
    $twitter = $twitter ? $twitter : (isset($nasa_opt['twitter_url_follow']) ? $nasa_opt['twitter_url_follow'] : '');
    $email = $email ? $email : (isset($nasa_opt['email_url_follow']) ? $nasa_opt['email_url_follow'] : '');
    $pinterest = $pinterest ? $pinterest : (isset($nasa_opt['pinterest_url_follow']) ? $nasa_opt['pinterest_url_follow'] : '');
    $instagram = $instagram ? $instagram : (isset($nasa_opt['instagram_url']) ? $nasa_opt['instagram_url'] : '');
    $rss = $rss ? $rss : (isset($nasa_opt['rss_url_follow']) ? $nasa_opt['rss_url_follow'] : '');
    $linkedin = $linkedin ? $linkedin : (isset($nasa_opt['linkedin_url_follow']) ? $nasa_opt['linkedin_url_follow'] : '');
    $youtube = $youtube ? $youtube : (isset($nasa_opt['youtube_url_follow']) ? $nasa_opt['youtube_url_follow'] : '');
    $flickr = $flickr ? $flickr : (isset($nasa_opt['flickr_url_follow']) ? $nasa_opt['flickr_url_follow'] : '');
    $telegram = $telegram ? $telegram : (isset($nasa_opt['telegram_url_follow']) ? $nasa_opt['telegram_url_follow'] : '');
    $whatsapp = $whatsapp ? $whatsapp : (isset($nasa_opt['whatsapp_url_follow']) ? $nasa_opt['whatsapp_url_follow'] : '');
    $amazon = $amazon ? $amazon : (isset($nasa_opt['amazon_url_follow']) ? $nasa_opt['amazon_url_follow'] : '');
    $tumblr = $tumblr ? $tumblr : (isset($nasa_opt['tumblr_url_follow']) ? $nasa_opt['tumblr_url_follow'] : '');
    $vk = $vk ? $vk : (isset($nasa_opt['vk_url_follow']) ? $nasa_opt['vk_url_follow'] : '');
    $weibo = $weibo ? $weibo : (isset($nasa_opt['weibo_url_follow']) ? $nasa_opt['weibo_url_follow'] : '');
    
    $follow_wrap_start = '<div class="social-icons nasa-follow' . ($el_class ? ' ' . esc_attr($el_class) : '') . '">';
    $follow_wrap_start .= $title ? '<div class="nasa-follow-title">' . $title . '</div>' : '';
    $follow_wrap_start .= '<div class="follow-icon">';
    
    $follow = '';

    /**
     * Twitter
     */
    if ($twitter) {
        $follow .= '<a href="' . esc_url($twitter) . '" target="_blank" class="icon icon_twitter nasa-tip" title="' . esc_attr__('Follow us on Twitter', 'nasa-core') . '" rel="nofollow"><i class="fa fa-twitter"></i></a>';
    }

    /**
     * FaceBook
     */
    if ($facebook) {
        $follow .= '<a href="' . esc_url($facebook) . '" target="_blank" class="icon icon_facebook nasa-tip" title="' . esc_attr__('Follow us on Facebook', 'nasa-core') . '" rel="nofollow"><i class="fa fa-facebook"></i></a>';
    }
    
    /**
     * VK
     */
    if ($vk) {
        $follow .= '<a href="' . esc_url($vk) . '" target="_blank" class="icon icon_vk nasa-tip" title="' . esc_attr__('Follow us on VK', 'nasa-core') . '" rel="nofollow"><i class="fa fa-vk"></i></a>';
    }

    /**
     * Email
     */
    if ($email) {
        $follow .= '<a href="mailto:' . $email . '" target="_blank" class="icon icon_email nasa-tip" title="' . esc_attr__('Send us an email', 'nasa-core') . '" rel="nofollow"><i class="fa fa-envelope-o"></i></a>';
    }

    /**
     * Pinterest
     */
    if ($pinterest) {
        $follow .= '<a href="' . esc_url($pinterest) . '" target="_blank" class="icon icon_pintrest nasa-tip" title="' . esc_attr__('Follow us on Pinterest', 'nasa-core') . '" rel="nofollow"><i class="fa fa-pinterest"></i></a>';
    }

    /**
     * Instagram
     */
    if ($instagram) {
        $follow .= '<a href="' . esc_url($instagram) . '" target="_blank" class="icon icon_instagram nasa-tip" title="' . esc_attr__('Follow us on Instagram', 'nasa-core') . '" rel="nofollow"><i class="fa fa-instagram"></i></a>';
    }

    /**
     * Rss
     */
    if ($rss) {
        $follow .= '<a href="' . esc_url($rss) . '" target="_blank" class="icon icon_rss nasa-tip" title="' . esc_attr__('Subscribe to RSS', 'nasa-core') . '" rel="nofollow"><i class="fa fa-rss"></i></a>';
    }

    /**
     * LinkedIn
     */
    if ($linkedin) {
        $follow .= '<a href="' . esc_url($linkedin) . '" target="_blank" class="icon icon_linkedin nasa-tip" title="' . esc_attr__('Follow us on LinkedIn', 'nasa-core') . '" rel="nofollow"><i class="fa fa-linkedin"></i></a>';
    }

    /**
     * YouTube
     */
    if ($youtube) {
        $follow .= '<a href="' . esc_url($youtube) . '" target="_blank" class="icon icon_youtube nasa-tip" title="' . esc_attr__('Follow us on YouTube', 'nasa-core') . '" rel="nofollow"><i class="fa fa-youtube-play"></i></a>';
    }

    /**
     * Flickr
     */
    if ($flickr) {
        $follow .= '<a href="' . esc_url($flickr) . '" target="_blank" class="icon icon_flickr nasa-tip" title="' . esc_attr__('Follow us on Flickr', 'nasa-core') . '" rel="nofollow"><i class="fa fa-flickr"></i></a>';
    }
    
    /**
     * Tumblr
     */
    if ($tumblr) {
        $follow .= '<a href="' . esc_url($tumblr) . '" target="_blank" class="icon icon_tumblr nasa-tip" title="' . esc_attr__('Follow us on Tumblr', 'nasa-core') . '" rel="nofollow"><i class="fa fa-tumblr"></i></a>';
    }

    /**
     * Telegram
     */
    if ($telegram) {
        $follow .= '<a href="' . esc_url($telegram) . '" target="_blank" class="icon icon_telegram nasa-tip" title="' . esc_attr__('Follow us on Telegram', 'nasa-core') . '" rel="nofollow"><i class="fa fa-telegram"></i></a>';
    }

    /**
     * Whatsapp
     */
    if ($whatsapp) {
        $follow .= '<a href="' . esc_url($whatsapp) . '" target="_blank" class="icon icon_whatsapp nasa-tip" title="' . esc_attr__('Follow us on Whatsapp', 'nasa-core') . '" rel="nofollow"><i class="fa fa-whatsapp"></i></a>';
    }
    
    /**
     * Weibo
     */
    if ($weibo) {
        $follow .= '<a href="' . esc_url($weibo) . '" target="_blank" class="icon icon_weibo nasa-tip" title="' . esc_attr__('Follow us on Weibo', 'nasa-core') . '" rel="nofollow"><i class="fa fa-weibo"></i></a>';
    }
    
    /**
     * Amazon
     */
    if ($amazon) {
        $follow .= '<a href="' . esc_url($amazon) . '" target="_blank" class="icon icon_amazon nasa-tip" title="' . esc_attr__('Follow us on Amazon', 'nasa-core') . '" rel="nofollow"><i class="fa fa-amazon"></i></a>';
    }
    
    $follow_content = apply_filters('nasa_follow_content', $follow);
    $follow_wrap_end = '</div></div>';

    $content = $follow_wrap_start . $follow_content . $follow_wrap_end;
    
    return $content;
}

/**
 * Register Params
 */
function nasa_register_share_follow(){
    $share_params = array(
        "name" => esc_html__("Share", 'nasa-core'),
        "base" => "nasa_share",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display share icon social.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "show_settings_on_create" => false,
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__('Title', 'nasa-core'),
                "param_name" => 'title'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );
    vc_map($share_params);

    // **********************************************************************// 
    // ! Register New Element: Follow
    // **********************************************************************//
    $follow = array(
        "name" => esc_html__("Follow", 'nasa-core'),
        "base" => "nasa_follow",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display Follow icon social.", 'nasa-core'),
        "content_element" => true,
        "category" => 'Nasa Core',
        "show_settings_on_create" => false,
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__('Title', 'nasa-core'),
                "param_name" => 'title'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Twitter', 'nasa-core'),
                "param_name" => 'twitter'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Facebook', 'nasa-core'),
                "param_name" => 'facebook'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Pinterest', 'nasa-core'),
                "param_name" => 'pinterest'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Email', 'nasa-core'),
                "param_name" => 'email'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Instagram', 'nasa-core'),
                "param_name" => 'instagram'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('RSS', 'nasa-core'),
                "param_name" => 'rss'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Linkedin', 'nasa-core'),
                "param_name" => 'linkedin'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Youtube', 'nasa-core'),
                "param_name" => 'youtube'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Flickr', 'nasa-core'),
                "param_name" => 'flickr'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Telegram', 'nasa-core'),
                "param_name" => 'telegram'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Whatsapp', 'nasa-core'),
                "param_name" => 'whatsapp'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Amazon', 'nasa-core'),
                "param_name" => 'amazon'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Tumblr', 'nasa-core'),
                "param_name" => 'tumblr'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            )
        )
    );

    vc_map($follow);
}
