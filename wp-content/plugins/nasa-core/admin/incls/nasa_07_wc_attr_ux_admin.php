<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Instantiate Class
 */
add_action('init', array('Nasa_WC_Attr_UX_Admin', 'getInstance'));

/**
 * @class 		Nasa_WC_Attr_UX_Admin
 * @version		1.0
 * @author 		nasaTheme
 */
class Nasa_WC_Attr_UX_Admin extends Nasa_Abstract_WC_Attr_UX {

    private static $_instance = null;
    
    public $attribute_hide_in_loop = 'attribute_hide_in_loop';

    /*
     * Intance start contructor
     */
    public static function getInstance() {
        if (!NASA_WOO_ACTIVED) {
            return null;
        }
        
        global $nasa_opt;
        if (isset($nasa_opt['enable_nasa_variations_ux']) && !$nasa_opt['enable_nasa_variations_ux']) {
            return null;
        }
        
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /*
     * Contructor
     */
    public function __construct() {
        parent::__construct();

        add_action('admin_init', array($this, 'init_attribute_hooks'));
        add_action('admin_print_scripts', array($this, 'enqueue_scripts'));
        add_action('woocommerce_product_option_terms', array($this, 'product_option_terms'), 10, 2);

        // Display attribute fields
        add_action('nasa_attr_ux_product_attribute_field', array($this, 'attribute_fields'), 10, 3);

        // ajax add attribute
        add_action('wp_ajax_nasa_attr_ux_add_new_attribute', array($this, 'add_new_attribute_ajax'));

        add_action('admin_footer', array($this, 'add_attribute_term_template'));
    }

    /**
     * Add extra attribute types
     * Add color, image and label type
     *
     * @param array $types
     *
     * @return array
     */
    public function add_attribute_types($types) {
        $new_types = array_merge($types, $this->types);

        return $new_types;
    }

    /**
     * Init hooks for adding fields to attribute screen
     * Save new term meta
     * Add thumbnail column for attribute term
     */
    public function init_attribute_hooks() {
        global $pagenow;
        
        $postType = isset($_GET['post_type']) ? $_GET['post_type'] : null;
        $page = isset($_GET['page']) ? $_GET['page'] : null;
        
        if ($pagenow == 'edit.php' && $postType == 'product' && $page == 'product_attributes') {
            add_filter('product_attributes_type_selector', array($this, 'add_attribute_types'));
        }
        
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if (empty($attribute_taxonomies)) {
            return;
        }

        foreach ($attribute_taxonomies as $tax) {
            add_action('pa_' . $tax->attribute_name . '_add_form_fields', array($this, 'add_attribute_fields'));
            add_action('pa_' . $tax->attribute_name . '_edit_form_fields', array($this, 'edit_attribute_fields'), 10, 2);

            add_filter('manage_edit-pa_' . $tax->attribute_name . '_columns', array($this, 'add_attribute_columns'));
            add_filter('manage_pa_' . $tax->attribute_name . '_custom_column', array($this, 'add_attribute_column_content'), 10, 3);
        }

        add_action('created_term', array($this, 'save_term_meta'), 10, 2);
        add_action('edit_term', array($this, 'save_term_meta'), 10, 2);
        add_action('edit_term', 'nasa_del_cache_variations', 999);
    }

    /**
     * Load stylesheet and scripts in edit product attribute screen
     */
    public function enqueue_scripts() {
        $screen = get_current_screen();
        if (strpos($screen->id, 'edit-pa_') === false && strpos($screen->id, 'product') === false) {
            return;
        }

        wp_enqueue_script('nasa_attr_ux-admin', NASA_CORE_PLUGIN_URL . 'admin/assets/nasa-attr-ux.js', array('jquery', 'wp-color-picker', 'wp-util'), false, true);
    }

    /**
     * Create hook to add fields to add attribute term screen
     *
     * @param string $taxonomy
     */
    public function add_attribute_fields($taxonomy) {
        $attr = self::get_tax_attribute($taxonomy);

        do_action('nasa_attr_ux_product_attribute_field', $attr->attribute_type, '', 'add');
    }

    /**
     * Create hook to fields to edit attribute term screen
     *
     * @param object $term
     * @param string $taxonomy
     */
    public function edit_attribute_fields($term, $taxonomy) {
        $attr = self::get_tax_attribute($taxonomy);
        $value = get_term_meta($term->term_id, $attr->attribute_type, true);

        do_action('nasa_attr_ux_product_attribute_field', $attr->attribute_type, $value, 'edit');
    }

    /**
     * Print HTML of custom fields on attribute term screens
     *
     * @param $type
     * @param $value
     * @param $form
     */
    public function attribute_fields($type, $value, $form) {
        // Return if this is a default attribute type
        if (!in_array($type, array_keys($this->types))) {
            return;
        }

        // Print the open tag of field container
        printf(
            '<%s class="form-field">%s<label for="term-%s">%s</label>%s',
            'edit' == $form ? 'tr' : 'div',
            'edit' == $form ? '<th>' : '',
            esc_attr($type),
            $this->types[$type],
            'edit' == $form ? '</th><td>' : ''
        );

        switch ($type) {
            case self::_NASA_IMAGE :
                $image = $this->get_image_preview($value, 'nasa-attr-img-view');
                $style = $value ? ' style="display: inline-block;"' : '';
                ?>
                
                <div id="breadcrumb_bg_thumbnail" style="float: left; margin-right: 10px;"><?php echo $image; ?></div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="term-<?php echo esc_attr($type) ?>" name="<?php echo esc_attr($type) ?>" value="<?php echo esc_attr($value) ?>" />
                    <button type="button" class="upload_image-tax button"><?php echo esc_html_e('Upload/Add image', 'nasa-core'); ?></button>
                    <button data-no_img="<?php echo self::$no_image; ?>" type="button" class="remove_image-tax button hidden-tag"<?php echo $style; ?>><?php echo esc_html_e('Remove Image', 'nasa-core'); ?></button>
                </div>
                <?php
                break;
            
            default: ?>
                <input type="text" id="term-<?php echo esc_attr($type) ?>" name="<?php echo esc_attr($type) ?>" value="<?php echo esc_attr($value) ?>" />
                <?php
                break;
        }

        // Print the close tag of field container
        echo 'edit' == $form ? '</td></tr>' : '</div>';
    }

    /**
     * Save term meta
     *
     * @param int $term_id
     * @param int $tt_id
     */
    public function save_term_meta($term_id, $tt_id) {
        foreach ($this->types as $type => $label) {
            if (isset($_POST[$type])) {
                update_term_meta($term_id, $type, $_POST[$type]);
            }
        }
    }

    /**
     * Add selector for extra attribute types
     *
     * @param $taxonomy
     * @param $index
     */
    public function product_option_terms($taxonomy, $index) {
        if (!array_key_exists($taxonomy->attribute_type, $this->types)) {
            return;
        }

        $taxonomy_name = wc_attribute_taxonomy_name($taxonomy->attribute_name);
        global $thepostid;
        ?>

        <select multiple="multiple" data-placeholder="<?php esc_attr_e('Select terms', 'nasa-core'); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo $index; ?>][]">
        <?php
        $all_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array('taxonomy' => $taxonomy_name, 'orderby' => 'name', 'hide_empty' => false)));
        if ($all_terms) {
            foreach ($all_terms as $term) {
                echo '<option value="' . esc_attr($term->term_id) . '" ' . selected(has_term(absint($term->term_id), $taxonomy_name, $thepostid), true, false) . '>' . esc_attr(apply_filters('woocommerce_product_attribute_term_name', $term->name, $term)) . '</option>';
            }
        }
        ?>
        </select>
        <button class="button plus select_all_attributes"><?php esc_html_e('Select all', 'nasa-core'); ?></button>
        <button class="button minus select_no_attributes"><?php esc_html_e('Select none', 'nasa-core'); ?></button>
        <button class="button fr plus nasa-attr-ux_add_new_attribute" data-type="<?php echo $taxonomy->attribute_type ?>"><?php esc_html_e('Add New', 'nasa-core'); ?></button>

        <?php
    }

    /**
     * Add thumbnail column to column list
     *
     * @param array $columns
     *
     * @return array
     */
    public function add_attribute_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['thumb'] = '';
        unset($columns['cb']);

        return array_merge($new_columns, $columns);
    }

    /**
     * Render thumbnail HTML depend on attribute type
     *
     * @param $columns
     * @param $column
     * @param $term_id
     */
    public function add_attribute_column_content($columns, $column, $term_id) {
        $attr = self::get_tax_attribute($_REQUEST['taxonomy']);
        $value = get_term_meta($term_id, $attr->attribute_type, true);

        switch ($attr->attribute_type) {
            case self::_NASA_COLOR:
                printf('<div class="nasa-attr-ux-preview nasa-attr-ux-color" style="background-color:%s;"></div>', esc_attr($value));
                break;

            case self::_NASA_LABEL:
                $value = $value ? $value : get_term_field('name', $term_id);
                printf('<div class="nasa-attr-ux-preview nasa-attr-ux-label">%s</div>', esc_html($value));
                break;
            
            case self::_NASA_IMAGE:
                $image = $this->get_image_preview($value);
                printf('<div class="nasa-attr-ux-preview nasa-attr-ux-image">%s</div>', $image);
                break;
        }
    }

    /**
     * Print HTML of modal at admin footer and add js templates
     */
    public function add_attribute_term_template() {
        global $pagenow, $post;

        if ($pagenow != 'post.php' || (isset($post) && get_post_type($post->ID) != 'product')) {
            return;
        }
        ?>

        <div id="nasa-attr-ux-modal-container" class="nasa-attr-ux-modal-container">
            <div class="nasa-attr-ux-modal">
                <button type="button" class="button-link media-modal-close nasa-attr-ux-modal-close">
                    <span class="media-modal-icon"></span>
                </button>
                
                <div class="nasa-attr-ux-modal-header">
                    <h2><?php esc_html_e('Add new term', 'nasa-core'); ?></h2>
                </div>
                
                <div class="nasa-attr-ux-modal-content">
                    <p class="nasa-attr-ux-term-name">
                        <label>
                            <?php esc_html_e('Name', 'nasa-core'); ?>
                            <input type="text" class="widefat nasa-attr-ux-input" name="name" />
                        </label>
                    </p>
                    
                    <p class="nasa-attr-ux-term-slug">
                        <label>
                            <?php esc_html_e('Slug', 'nasa-core'); ?>
                            <input type="text" class="widefat nasa-attr-ux-input" name="slug" />
                        </label>
                    </p>
                    
                    <div class="nasa-attr-ux-term-val"></div>
                    <div class="hidden nasa-attr-ux-term-tax"></div>

                    <input type="hidden" class="nasa-attr-ux-input" name="nonce" value="<?php echo wp_create_nonce('_nasa_attr_ux_create_attribute'); ?>" />
                </div>
                
                <div class="nasa-attr-ux-modal-footer">
                    <button class="button button-secondary nasa-attr-ux-modal-close"><?php esc_html_e('Cancel', 'nasa-core'); ?></button>
                    <button class="button button-primary nasa-attr-ux-new-attribute-submit"><?php esc_html_e('Add New', 'nasa-core'); ?></button>
                    <span class="message"></span>
                    <span class="spinner"></span>
                </div>
            </div>
            <div class="nasa-attr-ux-modal-backdrop media-modal-backdrop"></div>
        </div>

        <script type="text/template" id="tmpl-nasa-attr-ux-input-color">
            <label><?php esc_html_e('Color', 'nasa-core') ?></label><br />
            <input type="text" class="nasa-attr-ux-input nasa-attr-ux-input-color" name="nasa_attr_ux" />
        </script>

        <script type="text/template" id="tmpl-nasa-attr-ux-input-label">
            <label>
                <?php esc_html_e('Label', 'nasa-core') ?>
                <input type="text" class="widefat nasa-attr-ux-input nasa-attr-ux-input-label" name="nasa_attr_ux" />
            </label>
        </script>
        
        <script type="text/template" id="tmpl-nasa-attr-ux-input-image">
            <label>
                <?php esc_html_e('Image', 'nasa-core') ?>
                <input type="hidden" class="widefat nasa-attr-ux-input nasa-attr-ux-input-image" name="nasa_attr_ux" />
            </label>
        </script>

        <script type="text/template" id="tmpl-nasa-attr-ux-input-tax">
            <input type="hidden" class="nasa-attr-ux-input" name="taxonomy" value="{{data.tax}}" />
            <input type="hidden" class="nasa-attr-ux-input" name="type" value="{{data.type}}" />
        </script>
        <?php
    }

    /**
     * Ajax function to handle add new attribute term
     */
    public function add_new_attribute_ajax() {
        $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
        $tax = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
        $nasa_attr_ux = isset($_POST['nasa_attr_ux']) ? $_POST['nasa_attr_ux'] : '';

        if (!wp_verify_nonce($nonce, '_nasa_attr_ux_create_attribute')) {
            wp_send_json_error(esc_html__('Wrong request', 'nasa-core'));
        }

        if (empty($name) || empty($nasa_attr_ux) || empty($tax) || empty($type)) {
            wp_send_json_error(esc_html__('Not enough data', 'nasa-core'));
        }

        if (!taxonomy_exists($tax)) {
            wp_send_json_error(esc_html__('Taxonomy is not exists', 'nasa-core'));
        }

        if (term_exists($_POST['name'], $_POST['tax'])) {
            wp_send_json_error(esc_html__('This term is exists', 'nasa-core'));
        }

        $term = wp_insert_term($name, $tax, array('slug' => $slug));

        if (is_wp_error($term)) {
            wp_send_json_error($term->get_error_message());
        } else {
            $term = get_term_by('id', $term['term_id'], $tax);
            update_term_meta($term->term_id, $type, $nasa_attr_ux);
        }

        wp_send_json_success(
            array(
                'msg' => esc_html__('Added successfully', 'nasa-core'),
                'id' => $term->term_id,
                'slug' => $term->slug,
                'name' => $term->name,
            )
        );
    }
}
