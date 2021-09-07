<?php
if (!class_exists('TGM_Plugin_Activation')) {
    require_once ELESSI_ADMIN_PATH . 'classes/class-tgm-plugin-activation.php';
}
class Elessi_Auto_Install_Plugins extends TGM_Plugin_Activation {
    protected $slug_plg = '';

    public function __construct($plugin = array()) {
        $defaults = array(
            'name' => '', // String
            'slug' => '', // String
            'source' => 'repo', // String
            'required' => false, // Boolean
            'version' => '', // String
            'force_activation' => false, // Boolean
            'force_deactivation' => false, // Boolean
            'external_url' => '', // String
            'is_callable' => '', // String|Array.
        );

        // Prepare the received data.
        $plugin_info = wp_parse_args($plugin, $defaults);
        $plugin_info['file_path'] = $this->_get_plugin_basename_from_slug($plugin_info['slug']);
        $plugin_info['source_type'] = $this->get_plugin_source_type($plugin_info['source']);

        $this->slug_plg = $plugin_info['slug'];
        $this->plugins[$this->slug_plg] = $plugin_info;
    }
    
    /**
     * Install Plugin
     * 
     * @return type
     */
    public function nasa_plugin_install() {
        /**
         * Check plugin installed
         */
        if ($this->is_plugin_installed($this->slug_plg)) {
            return $this->nasa_plugin_active();
        }
        
        $extra = array();
        $extra['slug'] = $this->slug_plg; // Needed for potentially renaming of directory name.
        $source = $this->get_download_url($this->slug_plg);
        $api = ('repo' === $this->plugins[$this->slug_plg]['source_type']) ?
            $this->get_plugins_api($this->slug_plg) : null;
        $api = (false !== $api) ? $api : null;

        $url = add_query_arg(
            array(
                'action' => 'install-plugin',
                'plugin' => urlencode($this->slug_plg),
            ), 'update.php'
        );

        if (!class_exists('Plugin_Upgrader')) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        }
        
        $skin_args = array(
            'type' => ('bundled' !== $this->plugins[$this->slug_plg]['source_type']) ? 'web' : 'upload',
            'title' => esc_html__('Installing Plugin', 'elessi-theme'),
            'url' => esc_url_raw($url),
            'nonce' => 'install-plugin_' . $this->slug_plg,
            'plugin' => '',
            'api' => $api,
            'extra' => $extra,
        );
        
        $skin = new Plugin_Installer_Skin($skin_args);

        // Create a new instance of Plugin_Upgrader.
        $upgrader = new Plugin_Upgrader($skin);
        
        ob_start();
        $result = $upgrader->install($source);
        ob_end_clean();
        
        return $result ? $this->nasa_plugin_active() : false;
    }
    
    /**
     * Active Plugin
     */
    public function nasa_plugin_active() {
        if ($this->is_plugin_active($this->slug_plg)) {
            return true;
        }
        
        $file_path = $this->plugins[$this->slug_plg]['file_path'];
        $activate = activate_plugin($file_path);
        
        return is_wp_error($activate) ? false : true;
    }
}
