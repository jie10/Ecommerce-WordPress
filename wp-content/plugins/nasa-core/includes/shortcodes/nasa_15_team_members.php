<?php
/**
 * Shortcode [nasa_team_member ...]
 * 
 * @param type $atts
 * @param type $content
 * @return type
 */
function nasa_sc_team_member($atts = array(), $content = null) {
    $a = shortcode_atts(array(
        'class' => '',
        'type' => 1,
        'name' => '',
        'email' => '',
        'position' => '',
        'content' => '',
        'img' => '',
        'img_src' => '',
        'img_size' => ''
    ), $atts);

    $src = '';
    $image = '';
    $width = '';
    $height = '';
    $image_size = '';
    if ($a['img_size'] != '') {
        $img_size = explode('x', $a['img_size']);
        $width = $img_size[0];
        $height = $img_size[1];
        $image_size = 'width = "' . $width . '" height = "' . $height . '"';
    }
    if ($a['img'] != '') {
        $image = wp_get_attachment_image_src($a['img'], 'full');
        if (isset($image[0])) {
            $src = $image[0];
        }
    } elseif ($a['img_src'] != '') {
        $src = do_shortcode($a['img_src']);
    }

    if ($a['content'] != '') {
        $content = $a['content'];
    }

    $span = 12;
    $html = '<div class="team-member member-type-' . $a['type'] . ' ' . $a['class'] . '">';
    $html .= $a['type'] == 2 ? '<div class="row">' : '';
    
    if ($src != '') {
        if ($a['type'] == 2) {
            $html .= '<div class="large-6 columns">';
            $span = 6;
        }
        $html .= '<div class="member-image">';
        $html .= '<img src="' . esc_url($src) . '" alt="' . $a['name'] . '" ' . $image_size . ' />';
        $html .= '</div>';
        $html .= '<div class="clear"></div>';
        $html .= $a['type'] == 2 ? '</div>' : '';
    }
    
    $html .= $a['type'] == 2 ? '<div class="large-' . $span . ' columns">' : '';
    $html .= '<div class="member-details">';
    $html .= $a['position'] != '' ? '<h3>' . $a['name'] . '</h3>' : '';
    $html .= $a['name'] != '' ? '<h3 class="member-position">' . $a['position'] . '</h3>' : '';
    
    $html .= $a['email'] != '' ? '<p class="member-email"><span>' . esc_html__('Email:', 'nasa-core') . '</span> <a href="' . $a['email'] . '">' . $a['email'] . '</a></p>' : '';
    $html .= '<p class="member-desciption">' . do_shortcode($content) . '</p>';
    $html .= '</div>';

    $html .= $a['type'] == 2 ? '</div></div>' : '';
    $html .= '</div>';

    return $html;
}

/**
 * Register Params
 */
function nasa_register_team_member(){
    $team_member_params = array(
        'name' => 'Team member',
        'base' => 'nasa_team_member',
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Display team members project.", 'nasa-core'),
        'category' => 'Nasa Core',
        'params' => array(
            array(
                'type' => 'textfield',
                "heading" => esc_html__("Member name", 'nasa-core'),
                "param_name" => "name"
            ),
            array(
                'type' => 'textfield',
                "heading" => esc_html__("Member email", 'nasa-core'),
                "param_name" => "email"
            ),
            array(
                'type' => 'textfield',
                "heading" => esc_html__("Position", 'nasa-core'),
                "param_name" => "position"
            ),
            array(
                'type' => 'attach_image',
                "heading" => esc_html__("Avatar", 'nasa-core'),
                "param_name" => "img"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Image Size", 'nasa-core'),
                "param_name" => "img_size",
                "description" => esc_html__("Enter image size. Example in pixels: 200x100 (Width x Height).", 'nasa-core')
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Member Information", 'nasa-core'),
                "param_name" => "content",
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'nasa-core'),
                "param_name" => "class",
                "description" => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'nasa-core')
            )
        )
    );

    vc_map($team_member_params);
}
