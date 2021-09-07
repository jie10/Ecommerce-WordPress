<?php
/**
 * Plugin Name: Nasa Core
 * Plugin URI: https://nasatheme.com
 * Description: Shortcodes, custom post types and more for NasaTheme (ELESSI - THEME)
 * Version: 4.5.9.1
 * Author: NasaTheme
 * Author URI: https://elessi.nasatheme.com
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: nasa-core
 * Domain Path: /languages
 */

/**
 * Define CONST
 */
defined('NASA_CORE_ACTIVED') or define('NASA_CORE_ACTIVED', true);

defined('NASA_CORE_IN_ADMIN') or define('NASA_CORE_IN_ADMIN', is_admin());
defined('NASA_TIME_NOW') or define('NASA_TIME_NOW', time());

define('NASA_CORE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('NASA_CORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('NASA_CORE_LAYOUTS', NASA_CORE_PLUGIN_PATH . 'layouts/');
define('NASA_THEME_PATH', get_template_directory());
define('NASA_THEME_CHILD_PATH', get_stylesheet_directory());
define('NASA_COOKIE_VIEWED', 'woocommerce_recently_viewed');

/**
 * Auto-load
 */
require_once NASA_CORE_PLUGIN_PATH . 'nasa-autoloader.php';

/**
 * Languages
 */
add_action('plugins_loaded', 'nasa_core_load_textdomain');
function nasa_core_load_textdomain() {
    $locale = apply_filters('plugin_locale', get_locale(), 'nasa-core');
    load_textdomain('nasa-core', NASA_CORE_PLUGIN_PATH . 'languages/nasa-core-' . $locale . '.mo');
    load_plugin_textdomain('nasa-core', false, NASA_CORE_PLUGIN_PATH . 'languages/');
}
