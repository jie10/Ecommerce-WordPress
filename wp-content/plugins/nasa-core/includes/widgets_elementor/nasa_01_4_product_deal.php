<?php
/**
 * Widget for Elementor
 */
class Nasa_Product_Deal_WGSC extends Nasa_Elementor_Widget {

    /**
     * 
     * Contructor
     */
    function __construct() {
        $this->shortcode = 'nasa_product_deal';
        $this->widget_cssclass = 'woocommerce nasa_product_deal_wgsc';
        $this->widget_description = esc_html__('Displays Shortcode Nasa Product Deal', 'nasa-core');
        $this->widget_id = 'nasa_product_deal_sc';
        $this->widget_name = esc_html__('Nasa Product Deal', 'nasa-core');
        $this->settings = array(
            'id' => array(
                'type' => 'id_deal',
                'std' => '',
                'label' => esc_html__('Product Selected', 'nasa-core')
            ),
            
            'title' => array(
                'type' => 'text',
                'std' => 'Deal for',
                'label' => esc_html__('Title', 'nasa-core')
            ),
            
            'btn_shop_now' => array(
                'type' => 'select',
                'std' => 'yes',
                'label' => esc_html__('Button Store', 'nasa-core'),
                'options' => $this->array_bool_YN() 
            ),
            
            'btn_text' => array(
                'type' => 'text',
                'std' => 'SHOP NOW',
                'label' => esc_html__('Text Button', 'nasa-core')
            ),
            
            'btn_url' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('URL button (default shop page)', 'nasa-core')
            ),
            
            'el_class' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Extra class name', 'nasa-core')
            )
        );
        
        add_action('nasa_widget_field_id_deal', array($this, 'id_deal_content'), 10, 4);

        parent::__construct();
    }
    
    /**
     * Tabs content
     */
    public function id_deal_content($key, $value, $setting, $instance) {
        $data_id = $this->get_field_id($key);
        $data_name = $this->get_field_name($key);
        $product = $value ? wc_get_product($value) : null;
        ?>
        <div class="nasa-id-deal-wrap nasa-root-wrap">
            <span for="<?php echo esc_attr($data_id); ?>"><?php echo $setting['label']; ?></span>
            <input class="id-selected" type="hidden" id="<?php echo esc_attr($data_id); ?>" name="<?php echo esc_attr($data_name); ?>" value="<?php echo esc_attr($value); ?>" />
            
            <div class="info-selected" data-no-selected="<?php echo esc_html__('There is not product selected.', 'nasa-core'); ?>">
                <?php if($product) : ?>
                    <div class="product-img">
                        <?php echo $product->get_image('thumbnail'); ?>
                    </div>
                    <p class="product-name">
                        <?php echo $product->get_name(); ?>
                    </p>
                    
                    <a href="javascript:void(0);" class="nasa-remove-selected-deal"></a>
                <?php else: ?>
                    <p class="no-product-selected">
                        <?php echo esc_html__('There is not product selected.', 'nasa-core'); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <a class="select-product-deal" href="javascript:void(0);"><?php echo esc_html__('Click here to select Deal ...', 'nasa-core'); ?></a>
            <div class="list-items-wrap" data-list="0">
                <input type="text" class="nasa-input-search" name="nasa-input-search" placeholder="<?php echo esc_attr('Search ...', 'nasa-core'); ?>" />
                <div class="list-items"></div>
            </div>
        </div>
        <?php
    }
}
