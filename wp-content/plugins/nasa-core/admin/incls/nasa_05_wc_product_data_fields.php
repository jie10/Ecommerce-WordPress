<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Instantiate Class
 */
add_action('init', array('Nasa_WC_Product_Data_Fields', 'getInstance'), 0);

/**
 * @class 		Nasa_WC_Product_Data_Fields
 * @version		1.0
 * @author 		nasaTheme
 */
class Nasa_WC_Product_Data_Fields {

    protected static $_instance = null;
    
    public static $meta_name = 'wc_productdata_options';
    public static $meta_name_var = 'wc_variation_custom_fields';

    public $options_data = null;
    protected $_custom_fields = array();

    public $variation_data = null;
    protected $_variation_custom_fields = array();
    
    protected $_personalize = true;
    
    protected $_bulk_dsct = true;
    
    public $bulk_dsct_types = array();

    public $deleted_cache_post = false;
    
    protected $_exclude = array(
        '_bulk_dsct_rules'
    );
    
    protected $_exclude_var = array(
        '_bulk_dsct_rules',
        'bulk_dsct_rules'
    );

    public static function getInstance() {
        if (!NASA_WOO_ACTIVED) {
            return null;
        }

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Gets things started by adding an action to initialize this plugin once
     * WooCommerce is known to be active and initialized
     */
    public function __construct() {
        global $nasa_opt;
        
        $this->bulk_dsct_types = array(
            'flat' => esc_html__('Flat Discount', 'nasa-core'),
            'per' => esc_html__('Percentage Discount', 'nasa-core')
        );
        
        if (isset($nasa_opt['bulk_dsct']) && !$nasa_opt['bulk_dsct']) {
            $this->_bulk_dsct = false;
        }
        
        if (isset($nasa_opt['enable_personalize']) && !$nasa_opt['enable_personalize']) {
            $this->_personalize = false;
            $this->_exclude[] = '_personalize';
        }

        $this->_init_custom_fields();
        $this->_init_variation_custom_fields();

        add_action('woocommerce_init', array(&$this, 'init'));
    }
    
    /**
     * Init Custom Fields
     */
    protected function _init_custom_fields() {
        $custom_fields = array();

        /**
         * Additional
         */
        $custom_fields['key'][0] = array(
            'tab_name'    => esc_html__('Additional', 'nasa-core'),
            'tab_id'      => 'additional'
        );

        $custom_fields['value'][0][] = array(
            'id'          => '_bubble_hot',
            'type'        => 'text',
            'label'       => esc_html__('Custom Badge', 'nasa-core'),
            'placeholder' => esc_html__('HOT', 'nasa-core'),
            'class'       => 'large',
            'style'       => 'width: 100%;',
            'description' => esc_html__('Enter badge label (NEW, HOT etc...).', 'nasa-core')
        );

        $custom_fields['value'][0][] = array(
            'id'          => '_product_video_link',
            'type'        => 'text',
            'placeholder' => 'https://www.youtube.com/watch?v=link-test',
            'label'       => esc_html__('Product Video Link', 'nasa-core'),
            'style'       => 'width:100%;',
            'description' => esc_html__('Enter a Youtube or Vimeo Url of the product video here.', 'nasa-core')
        );

        $custom_fields['value'][0][] = array(
            'id'          => '_product_video_size',
            'type'        => 'text',
            'label'       => esc_html__('Product Video Size', 'nasa-core'),
            'placeholder' => esc_html__('800x800', 'nasa-core'),
            'class'       => 'large',
            'style'       => 'width:100%;',
            'description' => esc_html__('Default is 800x800. (Width x Height)', 'nasa-core')
        );

        $custom_fields['value'][0][] = array(
            'id'          => '_product_image_simple_slide',
            'type'        => 'nasa_media',
            'label'       => esc_html__('Image Simple Slide', 'nasa-core'),
            'class'       => 'large',
            'style'       => 'width:100%;',
            'description' => esc_html__('Image show in Product Element with Style is Simple Slide', 'nasa-core')
        );

        /**
         * Specifications 
         */
        $custom_fields['key'][1] = array(
            'tab_name'    => esc_html__('Specifications', 'nasa-core'),
            'tab_id'      => 'specifications'
        );

        $custom_fields['value'][1][] = array(
            'id'          => 'nasa_specifications',
            'type'        => 'editor',
            'label'       => esc_html__('Technical Specifications', 'nasa-core')
        );

        /**
         * Layout
         */
        $layouts = nasa_single_product_layouts();
        $imageLayouts = nasa_single_product_images_layout();
        $imageStyles = nasa_single_product_images_style();
        $thumbStyles = nasa_single_product_thumbs_style();
        $tabsStyles = nasa_single_product_tabs_style();

        $custom_fields['key'][2] = array(
            'tab_name'    => esc_html__('Layout', 'nasa-core'),
            'tab_id'      => 'layout'
        );

        $custom_fields['value'][2][] = array(
            'id'          => 'nasa_layout',
            'type'        => 'select',
            'options'     => $layouts,
            'label'       => esc_html__('Layout', 'nasa-core'),
            'class'       => 'select short nasa-select-main'
        );

        $custom_fields['value'][2][] = array(
            'id'          => 'nasa_image_layout',
            'type'        => 'select',
            'options'     => $imageLayouts,
            'label'       => esc_html__('Images Layout', 'nasa-core'),
            'class'       => 'select short nasa-v-new nasa-select-child'
        );

        $custom_fields['value'][2][] = array(
            'id'          => 'nasa_image_style',
            'type'        => 'select',
            'options'     => $imageStyles,
            'label'       => esc_html__('Images Style', 'nasa-core'),
            'class'       => 'select short nasa-v-new nasa-select-child'
        );

        $custom_fields['value'][2][] = array(
            'id'          => 'nasa_thumb_style',
            'type'        => 'select',
            'options'     => $thumbStyles,
            'label'       => esc_html__('Thumbnails Style', 'nasa-core'),
            'class'       => 'select short nasa-v-classic nasa-select-child'
        );

        $custom_fields['value'][2][] = array(
            'id'          => 'nasa_tab_style',
            'type'        => 'select',
            'options'     => $tabsStyles,
            'label'       => esc_html__('Tabs Style', 'nasa-core')
        );

        /**
         * 360 degree
         */
        if (!isset($nasa_opt['product_360_degree']) || $nasa_opt['product_360_degree']) {
            $custom_fields['key'][3] = array(
                'tab_name'    => esc_html__('360&#176; Viewer', 'nasa-core'),
                'tab_id'      => '360_degree'
            );

            $custom_fields['value'][3][] = array(
                'id'          => '_product_360_degree',
                'type'        => 'nasa_media_multi',
                'label'       => esc_html__('Gallery 360&#176; Viewer', 'nasa-core'),
                'class'       => 'large',
                'style'       => 'width:100%;',
                'description' => esc_html__('Add Gallery 360&#176; Viewer', 'nasa-core')
            );
        }
        
        if ($this->_bulk_dsct) {
            $custom_fields['key'][4] = array(
                'tab_name'  => esc_html__("Bulk Discount", 'nasa-core'),
                'tab_id'    => 'bulk_dsct',
                'class'     => 'show_if_simple'
            );

            $custom_fields['value'][4][] = array(
                'id'    => '_bulk_dsct',
                'type'  => 'checkbox',
                'cbvalue' => '1',
                'label' => esc_html__('Allow Bulk Discount', 'nasa-core')
            );
            
            $custom_fields['value'][4][] = array(
                'id'          => '_bulk_dsct_type',
                'type'        => 'select',
                'options'     => $this->bulk_dsct_types,
                'label'       => esc_html__('Discount Type', 'nasa-core')
            );
            
            $custom_fields['value'][4][] = array(
                'id'    => '_bulk_dsct_rules',
                'type'  => 'nasa_bulk_dsct'
            );
        }
        
        if ($this->_personalize) {
            $custom_fields['key'][5] = array(
                'tab_name'  => esc_html__("Personalize", 'nasa-core'),
                'tab_id'    => 'personalize',
                'class'     => 'show_if_simple'
            );

            $custom_fields['value'][5][] = array(
                'id'    => '_personalize',
                'type'  => 'checkbox',
                'label' => esc_html__('Personalize', 'nasa-core'),
                'description' => esc_html__('Allow Customized by Customer', 'nasa-core')
            );
        }

        $this->_custom_fields = apply_filters('nasa_product_custom_fields', $custom_fields);
    }
    
    /**
     * Init Variation Custom Fields
     */
    protected function _init_variation_custom_fields() {
        /**
         * Variation custom fields
         */
        $variation_custom_fields = array();
        
        /**
         * Bulk Discount
         */
        if ($this->_bulk_dsct) {
            $variation_custom_fields['bulk_dsct_allow'] = array(
                'type'  => 'checkbox',
                'cbvalue' => '1',
                'label' => esc_html__('Allow Bulk Discount', 'nasa-core')
            );
            
            $variation_custom_fields['bulk_dsct_type'] = array(
                'type' => 'select',
                'options' => $this->bulk_dsct_types,
                'label' => esc_html__('Discount Type', 'nasa-core')
            );
            
            $variation_custom_fields['bulk_dsct_rules'] = array(
                'type'  => 'nasa_bulk_dsct',
                'meta_key' => '_bulk_dsct_rules'
            );
        }
        
        /**
         * Personalize variation
         */
        if ($this->_personalize) {
            $variation_custom_fields['nasa_personalize'] = array(
                'type' => 'checkbox',
                'label' => esc_html__('Personalize (Allow Customized by Customer)', 'nasa-core'),
            );
        }
        
        $this->_variation_custom_fields = apply_filters('nasa_custom_variation_fields', $variation_custom_fields);
    }

    /**
     * Init WooCommerce Custom Product Data Fields extension once we know WooCommerce is active
     */
    public function init() {
        global $nasa_opt;

        add_action('woocommerce_product_write_panel_tabs', array($this, 'product_write_panel_tab'));
        add_action('woocommerce_product_data_panels', array($this, 'product_write_panel'));
        add_action('woocommerce_process_product_meta', array($this, 'product_save_data'), 10, 2);

        /**
         * For variable product
         */
        if (!isset($nasa_opt['gallery_images_variation']) || $nasa_opt['gallery_images_variation']) {
            add_action('woocommerce_save_product_variation', array($this, 'nasa_save_variation_gallery'), 10, 1);
            add_action('woocommerce_product_after_variable_attributes', array($this, 'nasa_variation_gallery_admin_html'), 10, 3);
        }

        add_action('woocommerce_save_product_variation', array($this, 'nasa_save_variation_custom_fields'), 10, 1);
        add_action('woocommerce_product_after_variable_attributes', array($this, 'nasa_variation_custom_fields_admin_html'), 10, 3);

        /**
         * Bought together
         */
        add_action('woocommerce_product_options_related', array($this, 'nasa_accessories_product'));
    }

    /**
     * Variation gallery images
     * 
     * @param type $loop
     * @param type $variation_data
     * @param type $variation
     */
    public function nasa_variation_gallery_admin_html($loop, $variation_data, $variation) {
        include NASA_CORE_PLUGIN_PATH . 'admin/views/variation-admin-gallery-images.php';
    }

    /**
     * custom fields variation product
     * 
     * @param type $loop
     * @param type $variation_data
     * @param type $variation
     */
    public function nasa_variation_custom_fields_admin_html($loop, $variation_data, $variation) {
        include NASA_CORE_PLUGIN_PATH . 'admin/views/variation-admin-custom-fields.php';
    }

    /**
     * Adds a new tab to the Product Data postbox in the admin product interface
     */
    public function product_write_panel_tab() {
        $fields = $this->_custom_fields;
        foreach ($fields['key'] as $field) {
            $class = 'wc_productdata_options_tab';
            $class .= isset($field['class']) ? ' ' . $field['class'] : '';
            echo '<li class="' . $class . '"><a href="#wc_tab_' . $field['tab_id'] . '"><span>' . $field['tab_name'] . '</span></a></li>';
        }
    }

    /**
     * Adds the panel to the Product Data postbox in the product interface
     */
    public function product_write_panel() {
        global $post;
        
        // Pull the field data out of the database
        $available_fields = array();
        $available_fields[] = maybe_unserialize(get_post_meta($post->ID, self::$meta_name, true));

        if ($available_fields) {
            $fields = $this->_custom_fields;

            // Display fields panel
            foreach ($available_fields as $available_field) {
                foreach ($fields['value'] as $key => $values) {
                    echo '<div id="wc_tab_' . $fields['key'][$key]['tab_id'] . '" class="panel woocommerce_options_panel">';

                    foreach ($values as $value) {
                        $this->wc_product_data_options_fields($value);
                    }

                    echo '</div>';
                }
            }
        }
    }

    /**
     * Create Fields
     */
    public function wc_product_data_options_fields($field) {
        global $thepostid, $post;

        $fieldtype = isset($field['type']) ? $field['type'] : 'text';
        $field_id = isset($field['id']) ? $field['id'] : '';
        $thepostid = empty($thepostid) ? $post->ID : $thepostid;

        if (!$this->options_data) {
            $this->options_data = maybe_unserialize(get_post_meta($thepostid, self::$meta_name, true));
        }

        $options_data = $this->options_data;

        $inputval = '';
        if (isset($options_data[0][$field_id])) {
            $inputval = $options_data[0][$field_id];
        } elseif (isset($field['std'])) {
            $inputval = $field['std'];
        }

        $field['name'] = isset($field['name']) ? $field['name'] : $field_id;
        $field['placeholder'] = isset($field['placeholder']) ? $field['placeholder'] : '';
        $field['class'] = isset($field['class']) ? $field['class'] : 'short';
        $field['wrapper_class'] = isset($field['wrapper_class']) ? $field['wrapper_class'] : '';

        switch ($fieldtype) {
            case 'number':
                echo
                '<p class="form-field ' . esc_attr($field_id) . '_field ' . esc_attr($field['wrapper_class']) . '">' .
                    '<label for="' . esc_attr($field_id) . '">' . 
                        wp_kses_post($field['label']) . 
                    '</label>' .
                    '<input ' .
                        'type="number" ' .
                        'class="' . esc_attr($field['class']) . '" ' .
                        'name="' . esc_attr($field['name']) . '" ' .
                        'id="' . esc_attr($field_id) . '" ' .
                        'value="' . esc_attr($inputval) . '" ' .
                        'placeholder="' . esc_attr($field['placeholder']) . '"' . 
                        (isset($field['style']) ? ' style="' . $field['style'] . '"' : '') .
                    ' /> ';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }

                echo '</p>';
                break;

            case 'textarea' :
                echo '<p class="form-field ' . $field_id . '_field"><label for="' . $field_id . '">' . $field['label'] . '</label><textarea class="' . $field['class'] . '" name="' . $field_id . '" id="' . $field_id . '" placeholder="' . $field['placeholder'] . '" rows="2" cols="20"' . (isset($field['style']) ? ' style="' . $field['style'] . '"' : '') . '">' . esc_textarea($inputval) . '</textarea>';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }
                echo '</p>';
                break;

            case 'editor' :
                $height = isset($field['height']) && (int) $field['height'] ? (int) $field['height'] : 200;
                wp_editor($inputval, $field_id, array('editor_height' => $height));
                break;

            case 'checkbox':
                $field['class'] = trim('nasa-checkbox ' . str_replace('short', '', $field['class']));
                $field['cbvalue'] = isset($field['cbvalue']) ? $field['cbvalue'] : 'yes';
                echo '<p class="form-field ' . esc_attr($field_id) . '_field ' . esc_attr($field['wrapper_class']) . '"><input type="checkbox" class="' . esc_attr($field['class']) . '" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field_id) . '" value="' . esc_attr($field['cbvalue']) . '" ' . checked($inputval, $field['cbvalue'], false) . ' /><label for="' . esc_attr($field_id) . '">' . wp_kses_post($field['label']) . '</label> ';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }
                echo '</p>';
                break;

            case 'select':
                $field['class'] = isset($field['class']) ? $field['class'] : 'select short';

                echo '<p class="form-field ' . esc_attr($field_id) . '_field ' . esc_attr($field['wrapper_class']) . '"><label for="' . esc_attr($field_id) . '">' . wp_kses_post($field['label']) . '</label><select id="' . esc_attr($field_id) . '" name="' . esc_attr($field_id) . '" class="' . esc_attr($field['class']) . '">';

                foreach ($field['options'] as $key => $value) {
                    echo '<option value="' . esc_attr($key) . '" ' . selected(esc_attr($inputval), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
                }

                echo '</select> ';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }
                echo '</p>';
                break;

            case 'radio':
                $field['class'] = isset($field['class']) ? $field['class'] : 'select short';

                echo '<fieldset class="form-field ' . esc_attr($field_id) . '_field ' . esc_attr($field['wrapper_class']) . '"><legend style="float:left; width:150px;">' . wp_kses_post($field['label']) . '</legend><ul class="wc-radios" style="width: 25%; float:left;">';
                foreach ($field['options'] as $key => $value) {
                    echo '<li style="padding-bottom: 3px; margin-bottom: 0;"><label style="float:none; width: auto; margin-left: 0;"><input name="' . esc_attr($field['name']) . '" value="' . esc_attr($key) . '" type="radio" class="' . esc_attr($field['class']) . '" ' . checked(esc_attr($inputval), esc_attr($key), false) . ' /> ' . esc_html($value) . '</label></li>';
                }
                echo '</ul>';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }

                echo '</fieldset>';
                break;

            case 'hidden':
                $field['class'] = isset($field['class']) ? $field['class'] : '';

                echo '<input type="hidden" class="' . esc_attr($field['class']) . '" name="' . esc_attr($field_id) . '" id="' . esc_attr($field_id) . '" value="' . esc_attr($inputval) . '" /> ';

                break;

            /**
             * Image
             */
            case 'nasa_media':
                include NASA_CORE_PLUGIN_PATH . 'admin/views/media-image.php';

                break;

            /**
             * Images multi
             */
            case 'nasa_media_multi':
                include NASA_CORE_PLUGIN_PATH . 'admin/views/media-multi-images.php';

                break;
            
            /**
             * Bulk Discount
             */
            case 'nasa_bulk_dsct':
                $field_name = $field_id;
                $bulk_discounts_arr = get_post_meta($thepostid, $field_name, true);
                $bulk_discounts = isset($bulk_discounts_arr['rules']) ? $bulk_discounts_arr['rules'] : array();
                
                $discount_rules_val = !empty($bulk_discounts_arr) ? $this->render_bulk_data_to_input_value($bulk_discounts_arr) : '';
                include NASA_CORE_PLUGIN_PATH . 'admin/views/bulk-dsct.php';

                break;

            /**
             * Text | Default
             */
            case 'text':
            default :
                echo '<p class="form-field ' . esc_attr($field_id) . '_field ' . esc_attr($field['wrapper_class']) . '"><label for="' . esc_attr($field_id) . '">' . wp_kses_post($field['label']) . '</label><input type="text" class="' . esc_attr($field['class']) . '" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field_id) . '" value="' . esc_attr($inputval) . '" placeholder="' . esc_attr($field['placeholder']) . '"' . (isset($field['style']) ? ' style="' . $field['style'] . '"' : '') . ' /> ';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }
                echo '</p>';
                break;
        }
    }

    /**
     * Create Custom Fields for Variation
     */
    public function wc_variation_data_custom_fields($variation_id, $key, $field) {
        $fieldtype = isset($field['type']) ? $field['type'] : 'text';
        $field_id = $key;

        if (!isset($this->variation_data[$variation_id])) {
            $this->variation_data[$variation_id] = maybe_unserialize(get_post_meta($variation_id, self::$meta_name_var, true));
        }

        $options_data = $this->variation_data[$variation_id];

        $inputval = '';
        if (isset($options_data[$field_id])) {
            $inputval = $options_data[$field_id];
        } elseif (isset($field['std'])) {
            $inputval = $field['std'];
        }

        $field['id'] = isset($field['id']) ? $field['id'] . '-' . $variation_id : 'variation-' . $variation_id . '-' . $key;
        $field['placeholder'] = isset($field['placeholder']) ? $field['placeholder'] : '';
        $field['class'] = isset($field['class']) ? $field['class'] : 'short';
        $field['wrapper_class'] = isset($field['wrapper_class']) ? $field['wrapper_class'] : '';
        $field_name = $key . '[' . $variation_id . ']';

        switch ($fieldtype) {
            case 'number':
                echo
                '<p class="form-field form-row form-row-full ' . esc_attr($field['id']) . '_field ' . esc_attr($field['wrapper_class']) . '">' .
                    '<label for="' . esc_attr($field['id']) . '">' . 
                        wp_kses_post($field['label']) . 
                    '</label>' .
                    '<input ' .
                        'type="' . esc_attr($field['type']) . '" ' .
                        'class="' . esc_attr($field['class']) . '" ' .
                        'name="' . esc_attr($field_name) . '[' . $variation_id . ']" ' .
                        'id="' . esc_attr($field['id']) . '" ' .
                        'value="' . esc_attr($inputval) . '" ' .
                        'placeholder="' . esc_attr($field['placeholder']) . '"' . 
                        (isset($field['style']) ? ' style="' . $field['style'] . '"' : '') .
                    ' /> ';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }

                echo '</p>';
                break;

            case 'textarea' :
                echo '<p class="form-field form-row form-row-full ' . $field['id'] . '_field"><label for="' . $field['id'] . '">' . $field['label'] . '</label><textarea class="' . $field['class'] . '" name="' . $field_name . '" id="' . $field['id'] . '" placeholder="' . $field['placeholder'] . '" rows="2" cols="20"' . (isset($field['style']) ? ' style="' . $field['style'] . '"' : '') . '">' . esc_textarea($inputval) . '</textarea>';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }
                echo '</p>';
                break;

            case 'checkbox':
                $field['cbvalue'] = isset($field['cbvalue']) ? $field['cbvalue'] : 'yes';

                echo '<p class="form-field form-row form-row-full ' . esc_attr($field['id']) . '_field ' . esc_attr($field['wrapper_class']) . '"><input type="checkbox" class="' . esc_attr($field['class']) . '" name="' . esc_attr($field_name) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($field['cbvalue']) . '" ' . checked($inputval, $field['cbvalue'], false) . ' /><label for="' . esc_attr($field['id']) . '">' . wp_kses_post($field['label']) . '</label> ';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }
                echo '</p>';
                break;

            case 'select':
                $field['class'] = isset($field['class']) ? $field['class'] : 'select short';

                echo '<p class="form-field form-row form-row-full ' . esc_attr($field['id']) . '_field ' . esc_attr($field['wrapper_class']) . '"><label for="' . esc_attr($field['id']) . '">' . wp_kses_post($field['label']) . '</label><select id="' . esc_attr($field['id']) . '" name="' . esc_attr($field_name) . '" class="' . esc_attr($field['class']) . '">';

                foreach ($field['options'] as $key => $value) {
                    echo '<option value="' . esc_attr($key) . '" ' . selected(esc_attr($inputval), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
                }

                echo '</select> ';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }
                echo '</p>';
                break;

            case 'radio':
                $field['class'] = isset($field['class']) ? $field['class'] : 'select short';

                echo '<fieldset class="form-field form-row form-row-full ' . esc_attr($field['id']) . '_field ' . esc_attr($field['wrapper_class']) . '"><legend style="float:left; width:150px;">' . wp_kses_post($field['label']) . '</legend><ul class="wc-radios" style="width: 25%; float:left;">';
                foreach ($field['options'] as $key => $value) {
                    echo '<li style="padding-bottom: 3px; margin-bottom: 0;"><label style="float:none; width: auto; margin-left: 0;"><input name="' . esc_attr($field_name) . '" value="' . esc_attr($key) . '" type="radio" class="' . esc_attr($field['class']) . '" ' . checked(esc_attr($inputval), esc_attr($key), false) . ' /> ' . esc_html($value) . '</label></li>';
                }
                echo '</ul>';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }

                echo '</fieldset>';
                break;
                
            /**
             * Bulk Discount
             */
            case 'nasa_bulk_dsct':
                $bulk_discounts_arr = get_post_meta($variation_id, $field['meta_key'], true);
                $bulk_discounts = isset($bulk_discounts_arr['rules']) ? $bulk_discounts_arr['rules'] : array();
                
                $discount_rules_val = !empty($bulk_discounts_arr) ? $this->render_bulk_data_to_input_value($bulk_discounts_arr) : '';
                include NASA_CORE_PLUGIN_PATH . 'admin/views/bulk-dsct.php';

                break;

            case 'text':
            default :
                echo '<p class="form-field form-row form-row-full ' . esc_attr($field['id']) . '_field ' . esc_attr($field['wrapper_class']) . '"><label for="' . esc_attr($field['id']) . '">' . wp_kses_post($field['label']) . '</label><input type="text" class="' . esc_attr($field['class']) . '" name="' . esc_attr($field_name) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($inputval) . '" placeholder="' . esc_attr($field['placeholder']) . '"' . (isset($field['style']) ? ' style="' . $field['style'] . '"' : '') . ' /> ';

                if (!empty($field['description'])) {
                    echo (isset($field['desc_tip']) && false !== $field['desc_tip']) ?
                        '<img class="help_tip" data-tip="' . esc_attr($field['description']) . '" src="' . esc_url(WC()->plugin_url()) . '/assets/images/help.png" height="16" width="16" />' :
                        '<span class="description">' . wp_kses_post($field['description']) . '</span>';
                }
                echo '</p>';
                break;
        }
    }

    /**
     * Bought together
     * 
     * @global type $post
     * @global type $thepostid
     */
    public function nasa_accessories_product() {
        global $post, $thepostid;
        $product_ids = $this->get_accessories_ids($thepostid);
        
        include NASA_CORE_PLUGIN_PATH . 'admin/views/html-accessories-product.php';
    }

    /**
     * Bought together Post ids
     * 
     * @param type $post_id
     * @return type
     */
    protected function get_accessories_ids($post_id) {
        $ids = get_post_meta($post_id, '_accessories_ids', true);

        return $ids;
    }
    
    /**
     * 
     * @param type $string
     * @return string
     */
    protected function _build_bulk_discount_data($string) {
        $str = stripslashes($string);
        
        $data = array();
        $tmp = array();
        
        try {
            $array = json_decode($str);
            if (!empty($array)) {
                foreach ($array as $item) {
                    $item = (array) $item;
                    if (isset($item['max'])) {
                        $data['max'] = $item['max'];
                    } else {
                        $tmp[$item['qty']] = $item;
                    }
                }
                
                if (!empty($tmp)) {
                    ksort($tmp);
                    
                    foreach ($tmp as $item) {
                        if (!isset($data['rules'])) {
                            $data['rules'] = array();
                        }
                        
                        $data['rules'][] = $item;
                    }
                }
            }
            
        } catch (Exception $exc) {
            echo $exc->getMessage();
            
            return 'error';
        }

        return empty($data) ? null : $data;
    }
    
    /**
     * 
     * @param type $data
     * @return string
     */
    public function render_bulk_data_to_input_value($data) {
        if (empty($data)) {
            return '';
        }
        
        $result = array();
        
        if (isset($data['rules'])) {
            foreach ($data['rules'] as $rule) {
                $result[] = $rule;
            }
        }
        
        if (isset($data['max'])) {
            $result[] = array('max' => $data['max']);
        }
        
        return esc_attr(json_encode($result));
    }

    /**
     * Saves the data inputed into the product boxes, as post meta data
     * identified by the name 'wc_productdata_options'
     *
     * @param int $post_id the post (product) identifier
     * @param stdClass $post the post (product)
     */
    public function product_save_data($post_id, $post) {
        /** field name in pairs array * */
        $data_args = array();
        $fields = $this->_custom_fields;

        foreach ($fields['value'] as $key => $datas) {
            foreach ($datas as $k => $data) {
                if (isset($data['id'])) {
                    if (in_array($data['id'], $this->_exclude)) {
                        continue;
                    }
                    
                    $data_args[$data['id']] = stripslashes($_POST[$data['id']]);
                }
            }
        }

        $options_value = array($data_args);

        // save the data to the database
        update_post_meta($post_id, self::$meta_name, $options_value);

        /**
         * Accessories for product
         */
        if (isset($_POST['accessories_ids'])) {
            update_post_meta($post_id, '_accessories_ids', $_POST['accessories_ids']);
        } else {
            update_post_meta($post_id, '_accessories_ids', null);
        }
        
        /**
         * Bulk Discounts
         */
        if (isset($_POST['_bulk_dsct_rules'])) {
            $buld_dsct_data = $this->_build_bulk_discount_data($_POST['_bulk_dsct_rules']);
            
            if ($buld_dsct_data !== 'error') {
                update_post_meta($post_id, '_bulk_dsct_rules', $buld_dsct_data);
            }
        } else {
            delete_post_meta($post_id, '_bulk_dsct_rules');
        }

        /**
         * Delete cache by post id
         */
        if (!$this->deleted_cache_post) {
            nasa_del_cache_by_product_id($post_id);
            $this->deleted_cache_post = true;
        }
    }

    /**
     * Save variation gallery
     * 
     * @param type $variation_id
     * return void
     */
    public function nasa_save_variation_gallery($variation_id) {
        if (isset($_POST['nasa_variation_gallery_images'])) {

            if (!$this->deleted_cache_post) {
                global $nasa_product_parent;

                /**
                 * Delete cache by post id
                 */
                if (!$nasa_product_parent) {
                    $parent_id = wp_get_post_parent_id($variation_id);
                    $nasa_product_parent = $parent_id ? wc_get_product($parent_id) : null;
                    $GLOBALS['nasa_product_parent'] = $nasa_product_parent;
                }

                if ($nasa_product_parent) {
                    $productId = $nasa_product_parent->get_id();
                    nasa_del_cache_by_product_id($productId);
                }

                $this->deleted_cache_post = true;
            }

            /**
             * Save gallery for variation
             */
            if (isset($_POST['nasa_variation_gallery_images'][$variation_id])) {
                $galery = trim($_POST['nasa_variation_gallery_images'][$variation_id], ',');
                update_post_meta($variation_id, 'nasa_variation_gallery_images', $galery);

                return;
            }
        }

        delete_post_meta($variation_id, 'nasa_variation_gallery_images');
    }

    /**
     * Save variation gallery
     * 
     * @param type $variation_id
     * return void
     */
    public function nasa_save_variation_custom_fields($variation_id) {
        if (empty($this->_variation_custom_fields)) {
            return;
        }

        if (!$this->deleted_cache_post) {
            global $nasa_product_parent;

            /**
             * Delete cache by post id
             */
            if (!$nasa_product_parent) {
                $parent_id = wp_get_post_parent_id($variation_id);
                $nasa_product_parent = $parent_id ? wc_get_product($parent_id) : null;
                $GLOBALS['nasa_product_parent'] = $nasa_product_parent;
            }

            if ($nasa_product_parent) {
                $productId = $nasa_product_parent->get_id();
                nasa_del_cache_by_product_id($productId);
            }

            $this->deleted_cache_post = true;
        }

        /**
         * Build custom fields data save for variation
         */
        $data_save = array();
        foreach ($this->_variation_custom_fields as $key => $field) {
            if (isset($_POST[$key][$variation_id])) {
                if (in_array($key, $this->_exclude_var)) {
                    continue;
                }
                
                $data_save[$key] = stripslashes($_POST[$key][$variation_id]);
            }
        }
        
        /**
         * Bulk Discounts
         */
        if (isset($_POST['bulk_dsct_rules'][$variation_id])) {
            $buld_dsct_data = $this->_build_bulk_discount_data($_POST['bulk_dsct_rules'][$variation_id]);
            
            if ($buld_dsct_data !== 'error') {
                update_post_meta($variation_id, '_bulk_dsct_rules', $buld_dsct_data);
            }
        } else {
            delete_post_meta($variation_id, '_bulk_dsct_rules');
        }

        /**
         * Save Custom field for variation
         */
        if (!empty($data_save)) {
            update_post_meta($variation_id, self::$meta_name_var, $data_save);
        } else {
            delete_post_meta($variation_id, self::$meta_name_var);
        }
    }
}
