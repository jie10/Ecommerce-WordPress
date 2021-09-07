<?php
add_action('init', 'elessi_promo_popup_heading');
if (!function_exists('elessi_promo_popup_heading')) {

    function elessi_promo_popup_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }

        $of_options[] = array(
            "name" => esc_html__("Newsletter Popup", 'elessi-theme'),
            "target" => 'promo-popup',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Newsletter", 'elessi-theme'),
            "id" => "promo_popup",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hide in Mobile (width site small less 640px OR Mobile Layout)", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "disable_popup_mobile",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Only Display 1 Time", 'elessi-theme'),
            "id" => "promo_popup_1_time",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Width", 'elessi-theme'),
            "id" => "pp_width",
            "std" => "734",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Height", 'elessi-theme'),
            "id" => "pp_height",
            "std" => "501",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Content", 'elessi-theme'),
            "id" => "pp_content",
            "std" => '<h3>Newsletter</h3><p>Be the first to know about our new arrivals, exclusive offers and the latest fashion update.</p>',
            "type" => "textarea"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Select Contact Form", 'elessi-theme'),
            "id" => "pp_contact_form",
            "type" => "select",
            'override_numberic' => true,
            "options" => elessi_get_contact_form7()
        );
        
        $of_options[] = array(
            "name" => esc_html__("Content Width", 'elessi-theme'),
            "id" => "pp_style",
            "std" => "simple",
            "type" => "select",
            "options" => array(
                "simple" => esc_html__("50%", 'elessi-theme'),
                "full" => esc_html__("Full Width", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Background Color", 'elessi-theme'),
            "id" => "pp_background_color",
            "std" => "#fff",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Background", 'elessi-theme'),
            "id" => "pp_background_image",
            "std" => ELESSI_THEME_URI . '/assets/images/newsletter_bg.jpg',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Delay time to show (seconds)", 'elessi-theme'),
            "id" => "delay_promo_popup",
            "std" => 0,
            "type" => "text"
        );
    }
}

/**
 * Get list Contact Form 7
 * @return type
 */
function elessi_get_contact_form7() {
    $contacts_form = function_exists('nasa_get_contact_form7') ? nasa_get_contact_form7() : array();
    $contacts = array('default' => esc_html__('Select the Contact Form', 'elessi-theme'));
    
    if (!empty($contacts_form)) {
        foreach ($contacts_form as $id => $form) {
            if ($id) {
                $contacts[$id] = $form;
            }
        }
    }
    
    return $contacts;
}
