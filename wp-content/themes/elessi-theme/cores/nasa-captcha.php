<?php
defined('ABSPATH') or die(); // Exit if accessed directly
/**
 * Captcha image
 */
class Nasa_Captcha {
    private $img_width = 120;
    private $img_height = 30;
    private $font_path = ELESSI_THEME_PATH . '/assets/captcha-fonts'; // Path file text
    private $fonts = array();
    private $font_size = 15;
    private $char_set = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    private $char_length = 5;
    private $char_color = "#880000,#008800,#000088,#888800,#880088,#008888,#000000";
    private $char_colors = array();
    private $line_count = 10;
    private $line_color = "#DD6666,#66DD66,#6666DD,#DDDD66,#DD66DD,#66DDDD,#666666";
    private $line_colors = array();
    private $bg_color = '#FFFFFF';
    
    public function __construct($length = 5, $width = 120, $height = 30) {
        $this->char_length = $length;
        $this->img_width = $width;
        $this->img_height = $height;
    }

    // Init Setting
    // return code and Show Img
    public function get_and_show_image($override = array()) {
        
        // Override default config
        if (is_array($override)) {
            foreach ($override as $key => $value) {
                if (isset($this->$key)) {
                    $this->$key = $value;
                }
            }
        }

        // Create list colors to Array
        $this->line_colors = preg_split("/,\s*?/", $this->line_color);
        $this->char_colors = preg_split("/,\s*?/", $this->char_color);

        // Get fonts font_path
        $this->fonts = $this->collect_files($this->font_path, "ttf");

        // Init IMG
        $img = imagecreatetruecolor($this->img_width, $this->img_height);
        imagefilledrectangle($img, 0, 0, $this->img_width - 1, $this->img_height - 1, $this->gd_color($this->bg_color));

        // Draw random
        for ($i = 0; $i < $this->line_count; $i++) {
            imageline($img, rand(0, $this->img_width - 1), rand(0, $this->img_height - 1), rand(0, $this->img_width - 1), rand(0, $this->img_height - 1), $this->gd_color($this->line_colors[rand(0, count($this->line_colors) - 1)])
            );
        }

        // Draw code
        $code = "";
        $y = ($this->img_height / 2) + ( $this->font_size / 2);

        for ($i = 0; $i < $this->char_length; $i++) {
            $color = $this->gd_color($this->char_colors[rand(0, count($this->char_colors) - 1)]);
            $angle = rand(-30, 30);
            $char = substr($this->char_set, rand(0, strlen($this->char_set) - 1), 1);

            $sel_font = $this->fonts[rand(0, count($this->fonts) - 1)];

            $font = $this->font_path . "/" . $sel_font;

            $x = (intval(( $this->img_width / $this->char_length) * $i) + ( $this->font_size / 2));
            $code .= $char;

            imagettftext($img, $this->font_size, $angle, $x, $y, $color, $font, $char);
        }

        // Show image
        header('content-type: image/jpg');

        imagejpeg($img);

        return strtolower($code);
    }

    // Change color
    protected function gd_color($html_color) {
        return preg_match('/^#?([\dA-F]{6})$/i', $html_color, $rgb) ? hexdec($rgb[1]) : false;
    }

    // get list files (ext)
    protected function collect_files($dir, $ext) {
        if (false !== ($dir = opendir($dir))) {
            $files = array();

            while (false !== ($file = readdir($dir))) {
                if (preg_match("/\\.$ext\$/i", $file)) {
                    $files[] = $file;
                }
            }
            
            return $files;
        }
        
        return false;
    }

}
