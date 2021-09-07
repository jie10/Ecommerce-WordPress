<?php
if (wc_get_loop_prop('total')) :
    global $nasa_opt;

    $_delay = $count = 0;
    $_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
    
    $wrapper_class = '';
    if (isset($nasa_opt['loop_layout_buttons']) && $nasa_opt['loop_layout_buttons'] != '') {
        $wrapper_class = 'nasa-' . $nasa_opt['loop_layout_buttons'];
    }

    while (have_posts()) :
        the_post();
        
        wc_get_template(
            'content-product.php',
            array(
                '_delay' => $_delay,
                'wrapper' => 'li',
                'wrapper_class' => $wrapper_class
            )
        );
        $_delay += $_delay_item;
        $count++;
    endwhile;
    
endif;
