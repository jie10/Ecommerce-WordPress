<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Instantiate Class
 */
add_action('init', array('Nasa_WC_Term_Data_Fields', 'getInstance'), 0);

/**
 * @class 		Nasa_WC_Term_Data_Fields
 * @version		1.0
 * @author 		nasaTheme
 */
class Nasa_WC_Term_Data_Fields {

    /**
     * Nasa Dark version in top category
     */
    private $_cat_bg_dark = 'cat_bg_dark';

    /**
     * Nasa Content in top category
     */
    private $_cat_header = 'cat_header';

    /**
     * Nasa Content in bottom category
     */
    private $_cat_footer_content = 'cat_footer_content';

    /**
     * Nasa Enable breadcrumb category
     */
    private $_cat_bread_enable = 'cat_breadcrumb';

    /**
     * Nasa Background breadcrumb category
     */
    private $_cat_bread_bg = 'cat_breadcrumb_bg';
    
    /**
     * Nasa Background breadcrumb category in Mobile
     */
    private $_cat_bread_bg_m = 'cat_breadcrumb_bg_m';

    /**
     * Nasa Text color breadcrumb category
     */
    private $_cat_bread_text = 'cat_breadcrumb_text_color';

    /**
     * Nasa Sidebar category
     */
    private $_cat_sidebar = 'cat_sidebar_override';

    /**
     * Nasa Sidebar category
     */
    private $_cat_sidebar_layout = 'cat_sidebar_layout';

    /**
     * Nasa Primary Color category
     */
    private $_cat_primary_color = 'cat_primary_color';

    /**
     * Nasa Logo category Flag
     */
    private $_cat_logo_flag = 'cat_logo_flag';
    
    /**
     * Nasa Logo category
     */
    private $_cat_logo = 'cat_logo';

    /**
     * Nasa Logo retina category
     */
    private $_cat_logo_retina = 'cat_logo_retina';

    /**
     * Nasa Logo sticky category
     */
    private $_cat_logo_sticky = 'cat_logo_sticky';
    
    /**
     * Nasa Logo mobile category
     */
    private $_cat_logo_m = 'cat_logo_m';

    /**
     * Nasa Header type category
     */
    private $_cat_header_type = 'cat_header_type';

    /**
     * Nasa Header builder category
     */
    private $_cat_header_builder = 'cat_header_builder';

    /**
     * Nasa Header type category
     */
    private $_cat_header_vertical_menu = 'cat_header_vertical_menu';

    /**
     * Nasa Footer mode category
     */
    private $_cat_footer_mode = 'cat_footer_mode';

    /**
     * Nasa Footer Build-in category
     */
    private $_cat_footer_build_in = 'cat_footer_build_in';

    /**
     * Nasa Footer Build-in Mobile category
     */
    private $_cat_footer_build_in_mobile = 'cat_footer_build_in_mobile';

    /**
     * Nasa Footer Builder category
     */
    private $_cat_footer_type = 'cat_footer_type';

    /**
     * Nasa Footer Builder for Mobile category
     */
    private $_cat_footer_mobile = 'cat_footer_mobile';

    /**
     * Nasa Footer Builder Elementor category
     */
    private $_cat_footer_builder_e = 'cat_footer_builder_e';

    /**
     * Nasa Footer Builder Elementor Mobile category
     */
    private $_cat_footer_builder_e_mobile = 'cat_footer_builder_e_mobile';

    /**
     * Nasa hover effect product category
     */
    private $_cat_effect_hover = 'cat_effect_hover';

    /**
     * Attribute Image Style
     */
    private $_cat_attr_image_style = 'cat_attr_image_style';

    /**
     * Attribute Image Style for Single - Quick view
     */
    private $_cat_attr_image_single_style = 'cat_attr_image_single_style';

    /**
     * Attribute Color Style
     */
    private $_cat_attr_color_style = 'cat_attr_color_style';

    /**
     * Attribute Label Style
     */
    private $_cat_attr_label_style = 'cat_attr_label_style';

    /**
     * Size Guide Block
     */
    private $_cat_size_guide_block = 'cat_size_guide_block';

    /**
     * Type Font Default | Custom | Google
     */
    private $_type_font = 'type_font';

    /**
     * H1 H2 H3 H4 H5 H6 Font Google
     */
    private $_headings_font = 'headings_font';

    /**
     * paragraphs, etc Font Google
     */
    private $_texts_font = 'texts_font';

    /**
     * Menu navigation Font Google
     */
    private $_nav_font = 'nav_font';

    /**
     * Banner Font Google
     */
    private $_banner_font = 'banner_font';

    /**
     * Price Font Google
     */
    private $_price_font = 'price_font';

    /**
     * Custom Font uploaded
     */
    private $_custom_font = 'custom_font';

    /**
     * Single Product layout
     */
    private $_product_layout = 'single_product_layout';

    /**
     * Single Product Image layout
     */
    private $_product_image_layout = 'single_product_image_layout';

    /**
     * Single Product Image style
     */
    private $_product_image_style = 'single_product_image_style';

    /**
     * Single Product Thumbnail style
     */
    private $_product_thumbs_style = 'single_product_thumbs_style';

    /**
     * Single Product Tabs style
     */
    private $_product_tabs_style = 'single_product_tabs_style';

    /**
     * Enable Custom Tax
     */
    private $_custom_tax = 'nasa_custom_tax';

    /**
     * Enable Custom Tax
     */
    private $_loop_layout_buttons = 'nasa_loop_layout_buttons';

    /**
     * Nasa init Object category
     */
    private static $_instance = null;

    /**
     * templates
     */
    protected $_template = NASA_CORE_PLUGIN_PATH . 'admin/views/product_category/';

    /**
     * Intance start contructor
     */
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
     * Contructor
     */
    public function __construct() {
        /**
         * Cat Background Dark
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_cat_bg_dark'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_cat_bg_dark'), 10, 1);

        /**
         * Cat top content
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_cat_header'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_cat_header'), 10, 1);

        /**
         * Cat bot content
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_cat_footer_content'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_cat_footer_content'), 10, 1);

        /**
         * Cat Logo => Only for Root Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_logo_create'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_logo_edit'), 10, 1);

        /**
         * Cat breadcrumb
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_background_breadcrumb_create'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_background_breadcrumb_edit'), 10, 1);

        /**
         * Override sidebar for Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_cat_sidebar'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_cat_sidebar'), 10, 1);

        /**
         * Override sidebar Layout for Category => Only for Root Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_cat_sidebar_layout'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_cat_sidebar_layout'), 10, 1);

        /**
         * Override primary for Category => Only for Root Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_primary_color'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_primary_color'), 10, 1);

        /**
         * Override Font for Category => Only for Root Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_font_style'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_font_style'), 10, 1);

        /**
         * Override Layout Single product for Category => Only for Root Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_single_product'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_single_product'), 10, 1);

        /**
         * Override Header & Footer => Only for Root Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_cat_header_footer_type'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_cat_header_footer_type'), 10, 1);

        /**
         * Override Effect hover product => Only for Root Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_effect_hover_product'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_effect_hover_product'), 10, 1);

        /**
         * Override Enable Nasa Custom Taxonomy
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_custom_tax'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_custom_tax'), 10, 1);

        /**
         * Override Loop layout buttons
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_loop_layout_buttons'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_loop_layout_buttons'), 10, 1);

        /**
         * Override Attribute Image display Style
         * Round | Square
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_attr_image_style'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_attr_image_style'), 10, 1);

        /**
         * Override Attribute Image display Style in Single | Quick view
         * extends - from attr_image_style
         * Square - Caption
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_attr_image_single_style'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_attr_image_single_style'), 10, 1);

        /**
         * Override Attribute Color display Style
         * Radio Style - Tooltip
         * Round Wrapper - Tooltip
         * Small Square
         * Big Square
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_attr_color_style'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_attr_color_style'), 10, 1);

        /**
         * Override Attribute Label display Style
         * Radio Style
         * Round Wrapper
         * Small Square
         * Big Square
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_attr_label_style'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_attr_label_style'), 10, 1);

        /**
         * Cat Size Guide Block => Only for Root Category
         */
        add_action('product_cat_add_form_fields', array($this, 'taxonomy_size_guide_block'), 10, 1);
        add_action('product_cat_edit_form_fields', array($this, 'taxonomy_size_guide_block'), 10, 1);

        /**
         * Save or Edit Term
         */
        add_action('created_term', array($this, 'save_taxonomy_custom_fields'), 10, 3);
        add_action('edit_term', array($this, 'save_taxonomy_custom_fields'), 10, 3);
    }

    /**
     * Create custom Override Category Sidebar Layout
     */
    public function taxonomy_custom_tax($term = null) {
        global $nasa_opt;

        if (!isset($nasa_opt['enable_nasa_custom_categories']) || !$nasa_opt['enable_nasa_custom_categories']) {
            return;
        }

        include $this->_template . 'custom_tax.php';
    }

    /**
     * Background Dark
     */
    public function taxonomy_cat_bg_dark($term = null) {
        include $this->_template . 'cat_bg_dark.php';
    }

    /**
     * Create custom Override Category Sidebar Layout
     */
    public function taxonomy_loop_layout_buttons($term = null) {
        include $this->_template . 'loop_layout_buttons.php';
    }

    /**
     * Create custom Override Category Sidebar Layout
     */
    public function taxonomy_cat_sidebar_layout($term = null) {
        include $this->_template . 'cat_sidebar_layout.php';
    }

    /**
     * Create custom attr image style
     */
    public function taxonomy_attr_image_style($term = null) {
        include $this->_template . 'attr_image_style.php';
    }

    /**
     * Create custom attr image single style - Single | Quick view
     */
    public function taxonomy_attr_image_single_style($term = null) {
        include $this->_template . 'attr_image_single_style.php';
    }

    /**
     * Create custom attr Color style - Single | Quick view
     */
    public function taxonomy_attr_color_style($term = null) {
        include $this->_template . 'attr_color_style.php';
    }

    /**
     * Create custom attr Label style - Single | Quick view
     */
    public function taxonomy_attr_label_style($term = null) {
        include $this->_template . 'attr_label_style.php';
    }

    /**
     * Create custom Override effect hover product
     */
    public function taxonomy_effect_hover_product($term = null) {
        include $this->_template . 'effect_hover_product.php';
    }

    /**
     * Create custom Override Header & Footer Type
     */
    public function taxonomy_cat_header_footer_type($term = null) {
        include $this->_template . 'cat_header_footer_type.php';
    }

    /**
     * _cat_primary_color
     * 
     * Custom primary color
     * @param type $term
     * Only use with Root Category
     */
    public function taxonomy_primary_color($term = null) {
        include $this->_template . 'primary_color.php';
    }

    /**
     * _type_font
     * 
     * Custom Font style
     * @param type $term
     * 
     * Only use with Root Category
     */
    public function taxonomy_font_style($term = null) {
        include $this->_template . 'font_style.php';
    }

    /**
     * _product_layout
     * 
     * Custom Single product layout
     * @param type $term
     * 
     * Only use with Root Category
     */
    public function taxonomy_single_product($term = null) {
        include $this->_template . 'single_product.php';
    }

    /**
     * Create custom Override sidebar
     */
    public function taxonomy_cat_sidebar($term = null) {
        include $this->_template . 'cat_sidebar.php';
    }

    /**
     * Create custom cat header
     */
    public function taxonomy_cat_header($term = null) {
        include $this->_template . 'cat_header.php';
    }

    /**
     * Custom Footer content
     */
    public function taxonomy_cat_footer_content($term = null) {
        include $this->_template . 'cat_footer_content.php';
    }

    /**
     * Create custom logo
     * Case create category
     */
    public function taxonomy_logo_create() {
        include $this->_template . 'logo_create.php';
    }

    /**
     * Edit custom logo
     * Case edit category
     */
    public function taxonomy_logo_edit($term = null) {
        include $this->_template . 'logo_edit.php';
    }

    /**
     * Create custom breadcrumb
     * Case create category
     */
    public function taxonomy_background_breadcrumb_create() {
        include $this->_template . 'background_breadcrumb_create.php';
    }

    /**
     * Edit custom breadcrumb
     * Case edit category
     */
    public function taxonomy_background_breadcrumb_edit($term = null) {
        include $this->_template . 'background_breadcrumb_edit.php';
    }

    /**
     * Size guide Block
     */
    public function taxonomy_size_guide_block($term = null) {
        include $this->_template . 'size_guide_block.php';
    }

    /**
     * Save taxonomy custom fields
     */
    public function save_taxonomy_custom_fields($term_id, $tt_id = '', $taxonomy = '') {
        if ('product_cat' == $taxonomy) {

            /**
             * BG Dark
             */
            if (isset($_POST[$this->_cat_bg_dark])) {
                update_term_meta($term_id, $this->_cat_bg_dark, $_POST[$this->_cat_bg_dark]);
            }

            /**
             * Top Content
             */
            if (isset($_POST[$this->_cat_header])) {
                update_term_meta($term_id, $this->_cat_header, $_POST[$this->_cat_header]);
            }

            /**
             * Bottom Content
             */
            if (isset($_POST[$this->_cat_footer_content])) {
                update_term_meta($term_id, $this->_cat_footer_content, $_POST[$this->_cat_footer_content]);
            }

            /**
             * Logo Flag
             */
            if (isset($_POST[$this->_cat_logo_flag])) {
                update_term_meta($term_id, $this->_cat_logo_flag, $_POST[$this->_cat_logo_flag]);
            }
            
            /**
             * Logo
             */
            if (isset($_POST[$this->_cat_logo])) {
                update_term_meta($term_id, $this->_cat_logo, $_POST[$this->_cat_logo]);
            }

            /**
             * Logo retina
             */
            if (isset($_POST[$this->_cat_logo_retina])) {
                update_term_meta($term_id, $this->_cat_logo_retina, $_POST[$this->_cat_logo_retina]);
            }

            /**
             * Logo Sticky
             */
            if (isset($_POST[$this->_cat_logo_sticky])) {
                update_term_meta($term_id, $this->_cat_logo_sticky, $_POST[$this->_cat_logo_sticky]);
            }
            
            /**
             * Logo Sticky
             */
            if (isset($_POST[$this->_cat_logo_m])) {
                update_term_meta($term_id, $this->_cat_logo_m, $_POST[$this->_cat_logo_m]);
            }

            /**
             * Breadcrumb type
             */
            if (isset($_POST[$this->_cat_bread_enable])) {
                update_term_meta($term_id, $this->_cat_bread_enable, absint($_POST[$this->_cat_bread_enable]));
            }

            /**
             * Breadcrumb Background
             */
            if (isset($_POST[$this->_cat_bread_bg])) {
                update_term_meta($term_id, $this->_cat_bread_bg, absint($_POST[$this->_cat_bread_bg]));
            }
            
            /**
             * Breadcrumb Background - Mobile
             */
            if (isset($_POST[$this->_cat_bread_bg_m])) {
                update_term_meta($term_id, $this->_cat_bread_bg_m, absint($_POST[$this->_cat_bread_bg_m]));
            }

            /**
             * Breadcrumb text color
             */
            if (isset($_POST[$this->_cat_bread_text])) {
                update_term_meta($term_id, $this->_cat_bread_text, $_POST[$this->_cat_bread_text]);
            }

            /**
             * Header type
             */
            if (isset($_POST[$this->_cat_header_type])) {
                update_term_meta($term_id, $this->_cat_header_type, $_POST[$this->_cat_header_type]);
            }

            /**
             * Header Builder
             */
            if (isset($_POST[$this->_cat_header_type]) && $_POST[$this->_cat_header_type] == 'nasa-custom' && isset($_POST[$this->_cat_header_builder])) {
                update_term_meta($term_id, $this->_cat_header_builder, $_POST[$this->_cat_header_builder]);
            } else {
                update_term_meta($term_id, $this->_cat_header_builder, '');
            }

            /**
             * Vertical Menu
             */
            $arrayHeader = array('4'); // Header use Vertical Menu
            if (isset($_POST[$this->_cat_header_type]) && in_array($_POST[$this->_cat_header_type], $arrayHeader) && isset($_POST[$this->_cat_header_vertical_menu])) {
                update_term_meta($term_id, $this->_cat_header_vertical_menu, $_POST[$this->_cat_header_vertical_menu]);
            } else {
                update_term_meta($term_id, $this->_cat_header_vertical_menu, '');
            }

            /**
             * Footer mode
             */
            if (isset($_POST[$this->_cat_footer_mode])) {
                update_term_meta($term_id, $this->_cat_footer_mode, $_POST[$this->_cat_footer_mode]);
            }

            /**
             * Footer Build-in
             */
            if (isset($_POST[$this->_cat_footer_build_in])) {
                update_term_meta($term_id, $this->_cat_footer_build_in, $_POST[$this->_cat_footer_build_in]);
            }

            /**
             * Footer Build-in Mobile
             */
            if (isset($_POST[$this->_cat_footer_build_in_mobile])) {
                update_term_meta($term_id, $this->_cat_footer_build_in_mobile, $_POST[$this->_cat_footer_build_in_mobile]);
            }

            /**
             * Footer type
             */
            if (isset($_POST[$this->_cat_footer_type])) {
                update_term_meta($term_id, $this->_cat_footer_type, $_POST[$this->_cat_footer_type]);
            }

            /**
             * Footer Mobile
             */
            if (isset($_POST[$this->_cat_footer_mobile])) {
                update_term_meta($term_id, $this->_cat_footer_mobile, $_POST[$this->_cat_footer_mobile]);
            }

            /**
             * Footer Builder Elementor
             */
            if (isset($_POST[$this->_cat_footer_builder_e])) {
                update_term_meta($term_id, $this->_cat_footer_builder_e, $_POST[$this->_cat_footer_builder_e]);
            }

            /**
             * Footer Builder Elementor Mobile
             */
            if (isset($_POST[$this->_cat_footer_builder_e_mobile])) {
                update_term_meta($term_id, $this->_cat_footer_builder_e_mobile, $_POST[$this->_cat_footer_builder_e_mobile]);
            }

            /**
             * Primary color
             */
            if (isset($_POST[$this->_cat_primary_color])) {
                update_term_meta($term_id, $this->_cat_primary_color, $_POST[$this->_cat_primary_color]);
            }

            /**
             * Font Style
             */
            if (isset($_POST[$this->_type_font])) {
                update_term_meta($term_id, $this->_type_font, $_POST[$this->_type_font]);
            }

            /**
             * Headings Font
             */
            if (isset($_POST[$this->_headings_font])) {
                update_term_meta($term_id, $this->_headings_font, $_POST[$this->_headings_font]);
            }

            /**
             * Texts Font
             */
            if (isset($_POST[$this->_texts_font])) {
                update_term_meta($term_id, $this->_texts_font, $_POST[$this->_texts_font]);
            }

            /**
             * Navigation Font
             */
            if (isset($_POST[$this->_nav_font])) {
                update_term_meta($term_id, $this->_nav_font, $_POST[$this->_nav_font]);
            }

            /**
             * Banner Font
             */
            if (isset($_POST[$this->_banner_font])) {
                update_term_meta($term_id, $this->_banner_font, $_POST[$this->_banner_font]);
            }

            /**
             * Price Font
             */
            if (isset($_POST[$this->_price_font])) {
                update_term_meta($term_id, $this->_price_font, $_POST[$this->_price_font]);
            }

            /**
             * Custom Font
             */
            if (isset($_POST[$this->_custom_font])) {
                update_term_meta($term_id, $this->_custom_font, $_POST[$this->_custom_font]);
            }

            /**
             * Single Product layout
             */
            if (isset($_POST[$this->_product_layout])) {
                update_term_meta($term_id, $this->_product_layout, $_POST[$this->_product_layout]);
            }

            /**
             * Single Product Image Layout
             */
            if (isset($_POST[$this->_product_image_layout])) {
                update_term_meta($term_id, $this->_product_image_layout, $_POST[$this->_product_image_layout]);
            }

            /**
             * Single Product Image Style
             */
            if (isset($_POST[$this->_product_image_style])) {
                update_term_meta($term_id, $this->_product_image_style, $_POST[$this->_product_image_style]);
            }

            /**
             * Single Product Thumbnail Style
             */
            if (isset($_POST[$this->_product_thumbs_style])) {
                update_term_meta($term_id, $this->_product_thumbs_style, $_POST[$this->_product_thumbs_style]);
            }

            /**
             * Single Product Tabs Style
             */
            if (isset($_POST[$this->_product_tabs_style])) {
                update_term_meta($term_id, $this->_product_tabs_style, $_POST[$this->_product_tabs_style]);
            }

            /**
             * Effect hover product
             */
            if (isset($_POST[$this->_cat_effect_hover])) {
                update_term_meta($term_id, $this->_cat_effect_hover, $_POST[$this->_cat_effect_hover]);
            }

            /**
             * Effect hover product
             */
            if (isset($_POST[$this->_custom_tax])) {
                update_term_meta($term_id, $this->_custom_tax, $_POST[$this->_custom_tax]);
            } else {
                update_term_meta($term_id, $this->_custom_tax, '');
            }

            /**
             * Loop Layout buttons
             */
            if (isset($_POST[$this->_loop_layout_buttons])) {
                update_term_meta($term_id, $this->_loop_layout_buttons, $_POST[$this->_loop_layout_buttons]);
            } else {
                update_term_meta($term_id, $this->_loop_layout_buttons, '');
            }

            /**
             * Attribute Image Style
             */
            if (isset($_POST[$this->_cat_attr_image_style])) {
                update_term_meta($term_id, $this->_cat_attr_image_style, $_POST[$this->_cat_attr_image_style]);
            }

            /**
             * Attribute Image Style
             * Only use Single - Quick view
             */
            if (isset($_POST[$this->_cat_attr_image_single_style])) {
                update_term_meta($term_id, $this->_cat_attr_image_single_style, $_POST[$this->_cat_attr_image_single_style]);
            }

            /**
             * Attribute Color Style
             * Only use Single - Quick view
             */
            if (isset($_POST[$this->_cat_attr_color_style])) {
                update_term_meta($term_id, $this->_cat_attr_color_style, $_POST[$this->_cat_attr_color_style]);
            }

            /**
             * Attribute Label Style
             * Only use Single - Quick view
             */
            if (isset($_POST[$this->_cat_attr_label_style])) {
                update_term_meta($term_id, $this->_cat_attr_label_style, $_POST[$this->_cat_attr_label_style]);
            }

            /**
             * Size Guide Block
             */
            if (isset($_POST[$this->_cat_size_guide_block])) {
                update_term_meta($term_id, $this->_cat_size_guide_block, $_POST[$this->_cat_size_guide_block]);
            } else {
                update_term_meta($term_id, $this->_cat_size_guide_block, '');
            }

            /**
             * Sidebar Layout
             */
            if (isset($_POST[$this->_cat_sidebar_layout])) {
                update_term_meta($term_id, $this->_cat_sidebar_layout, $_POST[$this->_cat_sidebar_layout]);
            } else {
                update_term_meta($term_id, $this->_cat_sidebar_layout, '');
            }

            /**
             * Override side bar
             */
            $value = isset($_POST[$this->_cat_sidebar]) && $_POST[$this->_cat_sidebar] == '1' ? '1' : '0';
            update_term_meta($term_id, $this->_cat_sidebar, $value);

            $term = get_term($term_id , 'product_cat');
            if ($term) {
                $sidebar_cats = get_option('nasa_sidebars_cats');
                $sidebar_cats = empty($sidebar_cats) ? array() : $sidebar_cats;

                if ($value === '1' && !isset($sidebar_cats[$term->slug])) {
                    $sidebar_cats[$term->slug] = array(
                        'slug' => $term->slug,
                        'name' => $term->name
                    );
                }

                if ($value === '0' && isset($sidebar_cats[$term->slug])) {
                    unset($sidebar_cats[$term->slug]);
                }

                update_option('nasa_sidebars_cats', $sidebar_cats);
            }

            /**
             * Clear Transients deal ids
             */
            nasa_clear_transients_products_deal_ids();

            /**
             * Delete old side bar
             */
            $this->delete_sidebar_cats();
        }
    }

    /**
     * Check term and delete sidebar category not exist
     */
    protected function delete_sidebar_cats() {
        $sidebar_cats = get_option('nasa_sidebars_cats');

        if (!empty($sidebar_cats)) {
            foreach ($sidebar_cats as $sidebar) {
                if (!term_exists($sidebar['slug'])) {
                    unset($sidebar_cats[$sidebar['slug']]);
                }
            }

            update_option('nasa_sidebars_cats', $sidebar_cats);
        }
    }
}
