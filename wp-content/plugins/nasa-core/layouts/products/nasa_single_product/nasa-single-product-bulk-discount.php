<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Optimize html
 */
$tmpl = isset($nasa_opt['tmpl_html']) && $nasa_opt['tmpl_html'] ? 'template' : 'div';

$max_qty = isset($bulk_discount['max']) ? $bulk_discount['max'] : 0;
$rules = isset($bulk_discount['rules']) ? $bulk_discount['rules'] : array();

if ($max_qty && !empty($rules)) :
    $suffix = $product->get_price_suffix();
    
    $price_org = floatval(wc_get_price_to_display($product));
    $price_org_html = wc_price($price_org) . $suffix;
    
    $allowed_html = array(
        'i' => array()
    );

    $shows = array();
    
    foreach ($rules as $rule) :
        $qty = floatval($rule['qty']);
        $dsct = floatval($rule['dsct']);
        
        if ($discount_type == 'flat') :
            $new_price = $price_org - $dsct;
            $new_price_html = wc_price($new_price) . $suffix;
            
            $dsct_txt = sprintf(esc_html__('%s&nbsp;each', 'nasa-core'), $new_price_html);
            
            if ($qty > 1) :
                
                $tmp = '<' . $tmpl . ' class="tmp-content hidden-tag">';
                
                $tmp .= '<span class="bulk-price">';
                
                $tmp .= $new_price_html . '<span class="bulk-after-price">' . esc_html__('&nbsp;each', 'nasa-core') . '</span>&nbsp;<del class="old-price-note">' . $price_org_html . '</del>';
                
                $save_per = floor($dsct / $price_org * 100);
                
                $tmp .= '<span class="bulk-desc">';
                
                $tmp .= '<span class="save-note">' .
                    sprintf(
                        wp_kses(__('Save&nbsp;%s&nbsp;<i>(%s&#37;&nbsp;OFF)</i>', 'nasa-core'), $allowed_html),
                        wc_price($dsct),
                        $save_per
                    ) .
                '</span>';
                
                $tmp .= '</span>';
                $tmp .= '</span>';
                
                $tmp .= '</' . $tmpl . '>';

                $dsct_txt .= $tmp;
            endif;
            
        else :
            
            $dsct_txt = sprintf(esc_html__('Discount&nbsp;%s&#37;', 'nasa-core'), $dsct);
            
            if ($qty > 1) :
                $new_price = $price_org - ($price_org * $dsct / 100);
                $new_price_html = wc_price($new_price) . $suffix;
                
                $tmp = '<' . $tmpl . ' class="tmp-content hidden-tag">';

                $tmp .= '<span class="bulk-price">';
                
                $tmp .= $new_price_html . '<span class="bulk-after-price">' . esc_html__('&nbsp;each', 'nasa-core') . '</span>&nbsp;<del class="old-price-note">' . $price_org_html . '</del>';

                $save_per = $dsct;
                
                $tmp .= '<span class="bulk-desc">';
                
                $tmp .= '<span class="save-note">' .
                    sprintf(
                        wp_kses(__('Save&nbsp;%s&nbsp;<i>(%s&#37;&nbsp;OFF)</i>', 'nasa-core'), $allowed_html),
                        wc_price($price_org - $new_price),
                        $save_per
                    ) .
                '</span>';
                
                $tmp .= '</span>';
                $tmp .= '</span>';
                
                $tmp .= '</' . $tmpl . '>';
                
                $dsct_txt .= $tmp;
            endif;
        endif;

        $shows[] = [
            'qty' => $qty,
            'dsct' => $dsct_txt
        ];
        
    endforeach;

    if (!empty($shows)) :
        $allowed_html = array(
            'strong' => array()
        );
        ?>
        <div class="dsc-label">
            <i class="nasa-icon pe-7s-piggy pe7-icon"></i>&nbsp;&nbsp;
            <?php echo wp_kses(__('<strong>Bulk Savings</strong>&nbsp;(Buy more get more)', 'nasa-core'), $allowed_html); ?>
        </div>
        
        <div class="dsc-flex-row nasa-crazy-box">
            <?php foreach ($shows as $show) :
                $text = esc_html__('BUY&nbsp;', 'nasa-core') . $show['qty'];
                $text .= $max_qty == $show['qty'] ? '&nbsp;' . esc_html__('or more', 'nasa-core') : '';
                ?>
                <div class="dsc-flex-column">
                    <a href="javascript:void(0);" data-qty="<?php echo esc_attr($show['qty']); ?>" class="ev-dsc-qty">
                        <?php echo $text . '<br />' . $show['dsct']; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
    endif;
endif;
