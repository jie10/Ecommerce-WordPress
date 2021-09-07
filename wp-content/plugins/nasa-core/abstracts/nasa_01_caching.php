<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Nasa Cache Files
 */
class Nasa_Caching {
    
    public static $instance = null;
    
    protected $_cache_mode = '';

    protected $_live_time = 36000;
    
    protected $_subkey = '';
    
    protected $_file_ext = '.html';

    /**
     * Instance
     */
    public static function getInstance() {
        global $nasa_opt;
        
        if (isset($nasa_opt['enable_nasa_cache']) && !$nasa_opt['enable_nasa_cache']) {
            return null;
        }

        if (null == self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    /**
     * 
     */
    public function __construct() {
        global $nasa_opt;
        
        /**
         * Cache Mode
         */
        $this->_cache_mode = isset($nasa_opt['nasa_cache_mode']) && $nasa_opt['nasa_cache_mode'] == 'transient' ? 'transient' : 'file';
        
        /**
         * $this->_subkey
         */
        $this->_subkey = '_folder_';
        
        /**
         * Live time cache files
         */
        if (isset($nasa_opt['nasa_cache_expire']) && (int) $nasa_opt['nasa_cache_expire']) {
            $this->_live_time = (int) $nasa_opt['nasa_cache_expire'];
        }
    }
    
    /**
     * Get Cache
     * 
     * @param type $key
     * @param type $folder
     */
    public function get_content($key, $folder) {
        /**
         * Get Transient data
         */
        if ($this->_cache_mode == 'transient') {
            return $this->_get_content_transient($key, $folder);
        }
        
        /**
         * Get File data
         */
        return $this->_get_content_file($key, $folder);
    }
    
    /**
     * Get Transient data
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    protected function _get_content_transient($key, $folder) {
        $key_name = 'nasa_cache_' . md5($key) . $this->_subkey . md5($folder);
        
        $transient = get_transient($key_name);
        
        if ($transient) {
            $jsonData = json_decode($transient);
            
            return ($jsonData && isset($jsonData->data)) ? $jsonData->data : null;
        }
        
        return false;
    }
    
    /**
     * Get File data
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    protected function _get_content_file($key, $folder) {
        global $wp_filesystem, $nasa_cache_dir;

        if (!isset($nasa_cache_dir) || !$nasa_cache_dir) {
            $upload_dir = wp_upload_dir();
            $nasa_cache_dir = $upload_dir['basedir'] . '/nasa-cache';

            $GLOBALS['nasa_cache_dir'] = $nasa_cache_dir;
        }

        // Initialize the WP filesystem, no more using 'file-put-contents' function
        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $filename = $nasa_cache_dir . '/' . $folder . '/' . md5($key) . $this->_file_ext;
        if (!is_file($filename)) {
            return false;
        }

        $time = filemtime($filename);
        if ($time + $this->_live_time < NASA_TIME_NOW) {
            return false;
        }
        
        return $wp_filesystem->get_contents($filename);
    }

    /**
     * Set Cache
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    public function set_content($key, $content, $folder) {
        $content = $this->minifier($content);
        
        /**
         * Set Transient
         */
        if ($this->_cache_mode == 'transient') {
            return $this->_set_content_transient($key, $content, $folder);
        }
        
        /**
         * Set File
         */
        return $this->_set_content_file($key, $content, $folder);
    }
    
    /**
     * Set Transient data
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    protected function _set_content_transient($key, $content, $folder) {
        $data = wp_json_encode(array('data' => $content));
        $key_name = 'nasa_cache_' . md5($key) . $this->_subkey . md5($folder);
        
        return set_transient($key_name, $data, $this->_live_time);
    }
    
    /**
     * Set File data
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    protected function _set_content_file($key, $content, $folder) {
        global $wp_filesystem, $nasa_cache_dir;

        if (!isset($nasa_cache_dir) || !$nasa_cache_dir) {
            $upload_dir = wp_upload_dir();
            $nasa_cache_dir = $upload_dir['basedir'] . '/nasa-cache';

            $GLOBALS['nasa_cache_dir'] = $nasa_cache_dir;
        }

        // Initialize the WP filesystem, no more using 'file-put-contents' function
        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        if (!defined('FS_CHMOD_FILE')) {
            define('FS_CHMOD_FILE', (fileperms(ABSPATH . 'index.php') & 0777 | 0644));
        }

        /**
         * Create new root cache
         */
        if (!$wp_filesystem->is_dir($nasa_cache_dir)) {
            if (!wp_mkdir_p($nasa_cache_dir)){
                return false;
            }
        }

        $folder_cache = $nasa_cache_dir . '/' . $folder;
        if (!$wp_filesystem->is_dir($folder_cache)) {   
            /**
             * Create folder cache products
             */
            if (!wp_mkdir_p($folder_cache)){
                return false;
            }
        }

        /**
         * Create htaccess file
         */
        $htaccess = $folder_cache . '/.htaccess';
        if (!is_file($htaccess)) {
            if (!$wp_filesystem->put_contents($htaccess, 'Deny from all', FS_CHMOD_FILE)) {
                return false;
            }
        }

        /**
         * Set cache file
         */
        $filename = $folder_cache . '/' . md5($key) . $this->_file_ext;
        if (!$wp_filesystem->put_contents($filename, $content, FS_CHMOD_FILE)) {
            return false;
        }

        return true;
    }
    
    /**
     * Delete cache by key
     * 
     * @global string $nasa_cache_dir
     * @param type $key
     * @param type $folder
     * @return boolean
     */
    public function delete_cache_by_key($key, $folder) {
        try {
            /**
             * Set Transient
             */
            if ($this->_cache_mode == 'transient') {
                $this->_delete_transient_by_key($key, $folder);
            }

            /**
             * Set File
             */
            $this->_delete_file_by_key($key, $folder);
            
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }
    
    /**
     * Delete Transient data by key
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    protected function _delete_transient_by_key($key, $folder) {
        global $wpdb;
        
        $key_name = 'nasa_cache_' . md5($key) . $this->_subkey . md5($folder);
    
        return $wpdb->query('DELETE FROM ' . $wpdb->options . ' WHERE `option_name` LIKE "_transient_' . $key_name . '%" OR `option_name` LIKE "_transient_timeout_' . $key_name . '%"');
    }
    
    /**
     * Delete File data by key
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    protected function _delete_file_by_key($key, $folder) {
        global $nasa_cache_dir;

        if (!isset($nasa_cache_dir) || !$nasa_cache_dir) {
            $upload_dir = wp_upload_dir();
            $nasa_cache_dir = $upload_dir['basedir'] . '/nasa-cache';

            $GLOBALS['nasa_cache_dir'] = $nasa_cache_dir;
        }

        $file = $nasa_cache_dir . '/' . $folder . '/' . md5($key) . $this->_file_ext;
        if (is_file($file)) {
            wp_delete_file($file);
            
            return true;
        }

        return false;
    }

    /**
     * Delete all cache in any folder
     * 
     * @param type $folder
     */
    public function delete_cache($folder) {
        /**
         * Set Transient
         */
        if ($this->_cache_mode == 'transient') {
            return $this->_delete_transients($folder);
        }
        
        /**
         * Set File
         */
        return $this->_delete_files($folder);
    }
    
    /**
     * Delete Transient data by key
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    protected function _delete_transients($folder) {
        global $wpdb;
        
        $key_name = 'nasa_cache_%' . $this->_subkey . md5($folder);
    
        return $wpdb->query('DELETE FROM ' . $wpdb->options . ' WHERE `option_name` LIKE "_transient_' . $key_name . '%" OR `option_name` LIKE "_transient_timeout_' . $key_name . '%"');
    }
    
    /**
     * Delete File data by key
     * 
     * @param type $key
     * @param type $content
     * @param type $folder
     */
    protected function _delete_files($folder) {
        global $wp_filesystem, $nasa_cache_dir;

        if (!isset($nasa_cache_dir) || !$nasa_cache_dir) {
            $upload_dir = wp_upload_dir();
            $nasa_cache_dir = $upload_dir['basedir'] . '/nasa-cache';

            $GLOBALS['nasa_cache_dir'] = $nasa_cache_dir;
        }

        // Initialize the WP filesystem, no more using 'file-put-contents' function
        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $folder_cache = $nasa_cache_dir . '/' . $folder;
        if (is_dir($folder_cache)) {
            return $wp_filesystem->rmdir($folder_cache, true);
        }

        return false;
    }
    
    /**
     * Minifier content
     * 
     * @param type $code
     * @return string
     */
    protected function minifier($code) {
        if (trim($code) == '') {
            return '';
        }
        
        $search = array(
            '/\>[^\S ]+/s', // Remove whitespaces after tags
            '/[^\S ]+\</s', // Remove whitespaces before tags
            '/(\s)+/s', // Remove multiple whitespace sequences 
            '/<!--(.|\s)*?-->/' // Removes comments
        );
        
        $replace = array('>', '<', '\\1');
        
        return preg_replace($search, $replace, $code);
    } 
}

/**
 * Nasa Caching
 * 
 * @return type
 */
function nasa_cache_obj() {
    return Nasa_Caching::getInstance();
}

/**
 * Build key short-code
 * 
 * @param type $shortcode
 * @param type $dfAtts
 * @param type $atts
 * @return type
 */
function nasa_key_shortcode($shortcode, $dfAtts, $atts) {
    global $nasa_opt;
    
    $string = $shortcode;
    
    foreach ($dfAtts as $key => $value) {
        /**
         * For Atts
         */
        if (isset($atts[$key])) {
            $string .= '_' . $atts[$key];
        }
        
        /**
         * For Default Atts
         */
        elseif ($value) {
            $string .= '_' . $value;
        }
    }
    
    /**
     * Support for multi language
     */
    $lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : get_option('WPLANG');
    
    $string .= $lang ? '_' . $lang : '';
    
    /**
     * Support for multi currencies
     */
    if (function_exists('get_woocommerce_currency')) {
        $string .= '_' . get_woocommerce_currency();
    }
    
    $string .= isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? '_mobile' : '';
    
    return $string ? $string : '';
}

/**
 * Set Cache for short-code
 * 
 * @param type $key
 * @param type $content
 * @return type
 */
function nasa_set_cache_shortcode($key = false, $content = '') {
    global $nasa_opt;
    
    if (!$key || !isset($nasa_opt['nasa_cache_shortcodes']) || !$nasa_opt['nasa_cache_shortcodes']) {
        return false;
    }
    
    $cache_obj = nasa_cache_obj();
    
    return null !== $cache_obj ? $cache_obj->set_content($key, $content, 'shortcodes') : false;
}

/**
 * Set Cache for short-code
 * 
 * @param type $key
 * @return type
 */
function nasa_get_cache_shortcode($key = false) {
    if (!$key) {
        return false;
    }
    
    $cache_obj = nasa_cache_obj();
    
    return null !== $cache_obj ? $cache_obj->get_content($key, 'shortcodes') : false;
}

/**
 * Set Cache with subkey ~ dir
 * 
 * @param type $key
 * @param type $subkey
 * @param type $content
 * @return type
 */
function nasa_set_cache($key = false, $subkey = false, $content = '') {
    if (!$key || !$subkey) {
        return false;
    }
    
    $cache_obj = nasa_cache_obj();
    
    return null !== $cache_obj ? $cache_obj->set_content($key, $content, $subkey) : false;
}

/**
 * Set Cache with subkey ~ dir
 * 
 * @param type $key
 * @param type $subkey
 * @return type
 */
function nasa_get_cache($key = false, $subkey = false) {
    if (!$key || !$subkey) {
        return false;
    }
    
    $cache_obj = nasa_cache_obj();
    
    return null !== $cache_obj ? $cache_obj->get_content($key, $subkey) : false;
}

/**
 * Delete cache shortcodes
 * @return boolean
 */
add_action('save_post', 'nasa_del_cache_shortcodes');
function nasa_del_cache_shortcodes() {
    $cache_obj = nasa_cache_obj();
    return null !== $cache_obj ? $cache_obj->delete_cache('shortcodes') : false;
}

/**
 * Delete cache variations
 * @return boolean
 */
function nasa_del_cache_variations() {
    $cache_obj = nasa_cache_obj();
    return null !== $cache_obj ? $cache_obj->delete_cache('products') : false;
}

/**
 * Delete cache Quick view
 * @return boolean
 */
function nasa_del_cache_quickview() {
    $cache_obj = nasa_cache_obj();
    return null !== $cache_obj ? $cache_obj->delete_cache('nasa-quickview') : false;
}

/**
 * Delete cache by product id
 * 
 * @param type $id
 * @return type
 */
function nasa_del_cache_by_product_id($id) {
    nasa_clear_transients_products_deal_ids();
    
    try {
        $cache_obj = nasa_cache_obj();
        if (null !== $cache_obj) {
            $currencies = function_exists('get_woocommerce_currencies') ? get_woocommerce_currencies() : null;
            if (!empty($currencies)) {
                foreach ($currencies as $key => $value) {
                    $key_cache = $id . '_' . $key;

                    /**
                     * Cache variations ux in Grid
                     */
                    $cache_obj->delete_cache_by_key($key_cache, 'products');

                    /**
                     * Cache Quick view Siebar
                     */
                    $key_cache_sb = $id  . '_sidebar_' . $key;
                    $cache_obj->delete_cache_by_key($key_cache_sb, 'nasa-quickview');

                    /**
                     * Cache Quick view Popup
                     */
                    $key_cache_pp = $id  . '_popup_' . $key;
                    $cache_obj->delete_cache_by_key($key_cache_pp, 'nasa-quickview');
                }
            }
        }
        
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Clear Transients deal ids
 * 
 * @global type $wpdb
 */
function nasa_clear_transients_products_deal_ids() {
    global $wpdb;
    
    $wpdb->query('DELETE FROM ' . $wpdb->options . ' WHERE `option_name` LIKE "_transient_nasa_products_deal%" OR `option_name` LIKE "_transient_timeout_nasa_products_deal%"');
}
