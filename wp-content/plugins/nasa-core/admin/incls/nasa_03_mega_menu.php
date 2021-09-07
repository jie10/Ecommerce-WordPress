<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Call Walker_Nav_Menu_Edit
 */
if (!class_exists('Walker_Nav_Menu_Edit')) {
    require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
}

/**
 * Init Admin Brand
 */
add_action('init', array('Nasa_Nav_Menu_Item_Custom_Fields', 'setup_fields'));

/**
 * Custom class Nasa_Nav_Menu_Item_Custom_Fields
 * Custom fields mega menu
 */
class Nasa_Nav_Menu_Item_Custom_Fields {
    
    /**
     * meta key menu item
     *
     * @var type 
     */
    public static $menu_item_key = '_nasa_menu_item';
    
    /**
     * check new menu
     */
    protected static $_new_menu = false;

    /**
     * Template
     * 
     * @var type 
     */
    public static $options = array(
        'item_tpl' =>
            '<p class="additional-menu-field-{name} description description-{type_show}">
                <label for="edit-menu-item-{name}-{id}">
                    {label}<br />
                    <input
                        type="{input_type}"
                        id="edit-menu-item-{name}-{id}"
                        class="widefat code edit-menu-item-{name}"
                        name="menu-item-{name}[{id}]"
                        value="{value}" />
                </label>
            </p>',
        
        'checkbox' =>
            '<p class="additional-menu-field-{name} description description-{type_show}">
                <label for="edit-menu-item-{name}-{id}"><br />
                    <input
                        type="checkbox"
                        id="edit-menu-item-{name}-{id}"
                        class="widefat code edit-menu-item-{name}"
                        name="menu-item-{name}[{id}]"
                        data-id="{id}"
                        value="1"{checked} />{label}
                </label>
            </p>'
    );

    /**
     * Setup Fields
     * 
     * @global type $nasa_opt
     * @return type
     */
    public static function setup_fields() {
        global $nasa_opt;
        
        /**
         * Return if empty fields
         */
        $new_fields = apply_filters('nasa_nav_menu_item_fields', array());
        if (empty($new_fields)) {
            return;
        }
        
        /**
         * Since 4.2.0
         * Check New version of Mega menu
         */
        if (!isset($nasa_opt['sync_nasa_menu'])) {
            $sync_nasa_menu = get_option('sync_nasa_menu', '');
            $nasa_opt['sync_nasa_menu'] = $sync_nasa_menu;
            set_theme_mod('sync_nasa_menu', $sync_nasa_menu);
        }
        
        if (!$nasa_opt['sync_nasa_menu']) {
            self::upgrade_sync_nasa_menu();
            $nasa_opt['sync_nasa_menu'] = '1';
            set_theme_mod('sync_nasa_menu', $nasa_opt['sync_nasa_menu']);
        }
        
        /**
         * Since 4.2.0
         * New version of Mega menu
         */
        self::$_new_menu = $nasa_opt['sync_nasa_menu'];
        
        /**
         * replace fields
         */
        self::$options['fields'] = self::get_fields_schema($new_fields);
        
        /**
         * Custom data
         */
        add_filter('wp_edit_nav_menu_walker', array(__CLASS__, 'walker_nav_menu_edit'));
        
        /**
         * Save data old version
         */
        add_action('save_post', array(__CLASS__, 'save_meta_menu'), 10, 2);
        
        /**
         * Since 4.2.0
         * Save data new version
         */
        add_action('save_post', array(__CLASS__, 'save_data_menu'), 10, 2);
        
        /**
         * Enqueue script
         */
        add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_script'));
    }
    
    /**
     * Admin Reggister JS megamenu
     */
    public static function admin_script() {
        wp_enqueue_script('nasa-admin-megamenu', NASA_CORE_PLUGIN_URL . 'admin/assets/nasa-mega-menu.js');
    }
    
    /**
     * Get Class Name ADMIN Nasa Mega menu
     */
    public static function walker_nav_menu_edit() {
        return 'Nasa_Walker_Nav_Menu_Edit';
    }

    /**
     * Get schema New fields
     * 
     * @param type $new_fields
     * @return type
     */
    public static function get_fields_schema($new_fields) {
        $schema = array();
        
        foreach ($new_fields as $name => $field) {
            $field['name'] = empty($field['name']) ? $name : $field['name'];
            $schema[] = $field;
        }

        return $schema;
    }

    /**
     * Get meta key
     * 
     * @param type $name
     * @return type
     */
    public static function get_menu_item_postmeta_key($name) {
        return '_menu_item_nasa_' . $name;
    }
    
    /**
     * replace field
     * 
     * @param type $field
     * @param type $default
     * @return type
     */
    protected static function render_field($field, $default) {
        foreach ($field as $key => $value) {
            $default = str_replace('{' . $key . '}', $value, $default);
        }
        
        return $default;
    }

    /**
     * get field
     * 
     * @param type $item
     * @return type
     */
    public static function get_field($item) {
        $new_fields = '';
        $hidden = true;
        
        $data = self::$_new_menu ? get_post_meta($item->ID, self::$menu_item_key, true) : null;
        
        foreach (self::$options['fields'] as $field) {
            $field['value'] = $data && isset($data[$field['name']]) ? $data[$field['name']] : get_post_meta($item->ID, self::get_menu_item_postmeta_key($field['name']), true);
            
            $field['id'] = $item->ID;
            if ($field['name'] == 'image_mega_enable' && $field['value'] == 1) {
                $hidden = false;
            }

            switch ($field['input_type']) {
                case 'select-widget':
                    $new_fields .= self::getWidgets($field);
                    break;

                case 'select':
                    $new_fields .= self::getSelect($field);
                    break;

                case 'select_position':
                    $new_fields .= self::getSelectPosition($field, $hidden);
                    break;

                case 'image':
                    $new_fields .= self::getMedia($field, $hidden);
                    break;

                case 'checkbox':
                    $field['checked'] = ($field['value'] == 1) ? ' checked' : '';
                    $default = self::render_field($field, self::$options['checkbox']);
                    $new_fields .= $default;

                    break;

                case 'icons':
                    $new_fields .= self::getIcons($field);
                    break;

                default:
                    $default = self::render_field($field, self::$options['item_tpl']);
                    $new_fields .= $default;
                    break;
            }
        }

        return $new_fields;
    }

    /**
     * Get icons
     * 
     * @param array $field
     * @return type
     */
    public static function getIcons($field) {
        $field['icon'] = (trim($field['value']) != '') ?
            '<span id="ico-edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' .
                '<i class="' . $field['value'] . '"></i>' .
                '<a href="javascript:void(0);" class="nasa-remove-icon" data-id="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' .
                    '<i class="fa fa-remove"></i>' .
                '</a>' .
            '</span>' : '<span id="ico-edit-menu-item-' . $field['name'] . '-' . $field['id'] . '"></span>';

        return
            '<p class="additional-menu-field-' . $field['name'] . ' description description-' . $field['type_show'] . '">' .
                '<label for="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' .
                    '<a class="nasa-chosen-icon" data-fill="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' . $field['label'] . '</a>' . $field['icon'] .
                    '<input
                        type="hidden"
                        id="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '"
                        class="widefat code edit-menu-item-' . $field['name'] . '"
                        name="menu-item-' . $field['name'] . '[' . $field['id'] . ']"
                        value="' . $field['value'] . '" />' .
                '</label>' .
            '</p>';
    }

    /**
     * Select field
     * 
     * @param type $field
     * @return string
     */
    public static function getSelect($field) {
        $select = '<p class="additional-menu-field-' . $field['name'] . ' description description-' . $field['type_show'] . ' select-field-' . $field['id'] . '">' .
            '<label for="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' .
                $field['label'] . '<br />' .
                '<select id="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '" class="widefat code edit-menu-item-' . $field['name'] . '" name="menu-item-' . $field['name'] . '[' . $field['id'] . ']">';

        $select .= (!isset($field['default']) || $field['default'] == true) ? '<option value="0">' . $field['label'] . '</option>' : '';
        
        if (!empty($field['values']) && is_array($field['values'])) {
            foreach ($field['values'] as $k => $v) {
                $select .= '<option value="' . esc_attr($k) . '" ' . selected($field['value'], $k, false) . '>' . esc_html($v) . '</option>';
            }
        }
        
        $select .= '</select>' .
            '</lable>' .
        '</p>';

        return $select;
    }

    /**
     * 
     * @param type $field
     * @param type $hide
     * @return string
     */
    public static function getSelectPosition($field = array(), $hide = false) {
        $hidden = $hide ? 'hidden-tag ' : '';

        $select = '<p class="' . $hidden . 'additional-menu-field-' . $field['name'] . ' description description-' . $field['type_show'] . ' select-field-' . $field['id'] . '">' .
            '<label for="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' .
            $field['label'] . '<br />' .
            '<select id="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '" class="widefat code edit-menu-item-' . $field['name'] . '" name="menu-item-' . $field['name'] . '[' . $field['id'] . ']">';
        $select .= (!isset($field['default']) || $field['default'] == true) ? '<option value="0">' . $field['label'] . '</option>' : '';
    
        if (!empty($field['values']) && is_array($field['values'])) {
            foreach ($field['values'] as $k => $v) {
                $select .= '<option value="' . esc_attr($k) . '" ' . selected($field['value'], $k, false) . '>' . esc_html($v) . '</option>';
            }
        }
        
        $select .= '</select>' .
            '</lable>' .
        '</p>';

        return $select;
    }

    /**
     * 
     * @global type $wp_registered_sidebars
     * @param type $field
     * @return string
     */
    public static function getWidgets($field) {
        global $wp_registered_sidebars;

        $select = '<p class="additional-menu-field-' . $field['name'] . ' description description-' . $field['type_show'] . '">' .
            '<label for="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' .
            $field['label'] . '<br />' .
            '<select id="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '" class="widefat code edit-menu-item-' . $field['name'] . '" name="menu-item-' . $field['name'] . '[' . $field['id'] . ']">' .
            '<option value="0">' . esc_html__('Select Widget Area', 'nasa-core') . '</option>';
        
        if (!empty($wp_registered_sidebars) && is_array($wp_registered_sidebars)) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $select .= '<option value="' . esc_attr($sidebar['id']) . '" ' . selected($field['value'], $sidebar['id'], false) . '>' . esc_html($sidebar['name']) . '</option>';
            }
        }
        
        $select .= '</select>' .
            '</lable>' .
        '</p>';

        return $select;
    }

    /**
     * Get Media item
     * 
     * @param type $field
     * @param type $hide
     * @return string
     */
    public static function getMedia($field = array(), $hide = false) {
        $img = '';
        
        if (isset($field['value']) && $field['value']) {
            if (is_numeric($field['value'])) {
                $image = wp_get_attachment_image_src($field['value'], 'full');
                if (isset($image[0])) {
                    $img .= '<img src="' . esc_url($image[0]) . '" />';
                }
            } else {
                $img .= '<img src="' . $field['value'] . '" />';
            }
        }
        
        $hidden = $hide ? 'hidden-tag ' : '';
        $media = '<p class="' . $hidden . 'additional-menu-field-' . $field['name'] . ' description description-' . $field['type_show'] . ' menu-field-media-' . $field['id'] . '">' .
            $field['label'] .
            '<input type="hidden" id="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '" name="menu-item-' . $field['name'] . '[' . $field['id'] . ']" value="' . $field['value'] . '" />' .
            '<a href="javascript:void(0);" class="button nasa-media-upload-button menu_upload_button" data-id="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' . esc_html__('Upload', 'nasa-core') . '</a>' .
            '<a href="javascript:void(0);" class="button nasa-media-remove-button media_remove_button" data-id="edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' . esc_html__('Remove', 'nasa-core') . '</a>' .
            '<span class="imgmega edit-menu-item-' . $field['name'] . '-' . $field['id'] . '">' . $img . '</span>' .
        '</p>';

        return $media;
    }

    /**
     * Save the newly submitted fields
     * @hook {action} save_post
     */
    public static function save_meta_menu($post_id, $post) {
        if ($post->post_type !== 'nav_menu_item') {
            return $post_id; // prevent weird things from happening
        }

        if (!self::$_new_menu) {
            foreach (self::$options['fields'] as $field_schema) {
                $form_field_name = 'menu-item-' . $field_schema['name'];
                if ($field_schema['input_type'] == 'checkbox' && !isset($_POST[$form_field_name][$post_id])) {
                    $_POST[$form_field_name][$post_id] = false;
                }

                if (isset($_POST[$form_field_name][$post_id])) {
                    $key = self::get_menu_item_postmeta_key($field_schema['name']);
                    $value = stripslashes($_POST[$form_field_name][$post_id]);
                    update_post_meta($post_id, $key, $value);
                }
            }
        }
    }
    
    /**
     * New version
     * 
     * Since 4.2.0
     * Save the newly submitted fields
     * @hook {action} save_post
     */
    public static function save_data_menu($post_id, $post) {
        if ($post->post_type !== 'nav_menu_item') {
            return $post_id;
        }
        
        if (self::$_new_menu) {
            $data = array();

            foreach (self::$options['fields'] as $field_schema) {
                $form_field_name = 'menu-item-' . $field_schema['name'];
                if ($field_schema['input_type'] == 'checkbox' && !isset($_POST[$form_field_name][$post_id])) {
                    $_POST[$form_field_name][$post_id] = false;
                }

                if (isset($_POST[$form_field_name][$post_id])) {
                    $key = $field_schema['name'];
                    $value = stripslashes($_POST[$form_field_name][$post_id]);
                    $data[$key] = $value;
                }
            }

            if (!empty($data)) {
                update_post_meta($post_id, self::$menu_item_key, $data);
            } else {
                delete_post_meta($post_id, self::$menu_item_key);
            }
        }
    }
    
    /**
     * upgrade sync nasa menu
     */
    public static function upgrade_sync_nasa_menu() {
        $menus = get_posts(array(
            'post_type' => 'nav_menu_item',
            'numberposts' => '-1'
        ));
        
        if ($menus) {
            foreach ($menus as $menu) {
                $data = array();
                $meta_datas = get_post_meta($menu->ID);
                
                if ($meta_datas) {
                    foreach ($meta_datas as $meta_key => $meta_data) {
                        if (0 === strpos($meta_key, '_menu_item_nasa_')) {
                            $key = substr($meta_key, 16);
                            $data[$key] = $meta_data[0];
                        }
                    }
                }
                
                if (!empty($data)) {
                    update_post_meta($menu->ID, self::$menu_item_key, $data);
                }
            }
            
        }
        
        update_option('sync_nasa_menu', '1');
    }
}

/**
 * Custom class Nasa_Walker_Nav_Menu_Edit
 */
class Nasa_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {

    /**
     * Override start_el
     * 
     * @param type $output
     * @param type $item
     * @param type $depth
     * @param type $args
     * @param type $id
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $item_output = '';
        
        parent::start_el($item_output, $item, $depth, $args, $id);

        $new_fields = Nasa_Nav_Menu_Item_Custom_Fields::get_field($item);
        
        if ($new_fields) :
            $item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $new_fields, $item_output);
        endif;
        
        $output .= $item_output;
    }

}

// Config more custom fields 
add_filter('nasa_nav_menu_item_fields', 'nasa_menu_item_additional_fields');
function nasa_menu_item_additional_fields() {
    $add_fields = array(
        'nasa_megamenu' => array(
            'name' => 'enable_mega',
            'label' => esc_html__('Mega Menu', 'nasa-core'),
            'container_class' => 'enable-widget',
            'input_type' => 'checkbox',
            'type_show' => 'thin'
        ),
        
        'nasa_fullwidth' => array(
            'name' => 'enable_fullwidth',
            'label' => esc_html__('Full Width', 'nasa-core'),
            'container_class' => 'enable-fullwidth',
            'input_type' => 'checkbox',
            'type_show' => 'thin'
        ),
        
        'nasa_icon' => array(
            'name' => 'icon_menu',
            'label' => esc_html__('Icon Menu ', 'nasa-core'),
            'container_class' => 'icon-menu',
            'input_type' => 'icons',
            'type_show' => 'wide'
        ),
        
        'nasa_select_width' => array(
            'name' => 'columns_mega',
            'label' => esc_html__('Number Columns Mega Menu', 'nasa-core'),
            'container_class' => 'select-columns',
            'input_type' => 'select',
            'values' => array(
                '2' => '2 Columns',
                '3' => '3 Columns',
                '4' => '4 Columns',
                '5' => '5 Columns',
            ),
            'default' => false,
            'type_show' => 'wide'
        ),
        
        'nasa_megamenu_image' => array(
            'name' => 'image_mega_enable',
            'label' => esc_html__('Image Megamenu', 'nasa-core'),
            'container_class' => 'enable-widget',
            'input_type' => 'checkbox',
            'type_show' => 'wide'
        ),
        
        'nasa_megamenu_image_btn' => array(
            'name' => 'image_mega',
            'label' => esc_html__('', 'nasa-core'),
            'container_class' => 'enable-widget',
            'input_type' => 'image',
            'type_show' => 'wide'
        ),
        
        'nasa_select_position_image' => array(
            'name' => 'position_image_mega',
            'label' => esc_html__('Position', 'nasa-core'),
            'container_class' => 'select-position',
            'input_type' => 'select_position',
            'values' => array(
                'before' => 'Before title',
                'after' => 'After title',
                'bg' => 'Background menu',
            ),
            'default' => false,
            'type_show' => 'wide'
        ),
        
        'nasa_select_disable_title' => array(
            'name' => 'disable_title_image_mega',
            'label' => esc_html__('Show Title', 'nasa-core'),
            'container_class' => 'select-position',
            'input_type' => 'select_position',
            'values' => array(
                '0' => 'Enable',
                '1' => 'Disable',
            ),
            'default' => false,
            'type_show' => 'wide'
        ),
        
        'nasa_el_class' => array(
            'name' => 'el_class',
            'label' => esc_html__('Custom Class', 'nasa-core'),
            'container_class' => 'enable-widget',
            'input_type' => 'text',
            'values' => '',
            'default' => '',
            'type_show' => 'wide'
        )
    );
    
    return apply_filters('nasa_add_megamenu_fields', $add_fields);
}
