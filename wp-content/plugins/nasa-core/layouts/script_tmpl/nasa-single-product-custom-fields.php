<?php
/**
 * Font types
 */
$font_types = array('Font One', 'Font Two', 'Font Three', 'Font Four');
if (isset($nasa_opt['personalize_font_types']) && trim($nasa_opt['personalize_font_types']) != '') {
    $font_types = explode(',', $nasa_opt['personalize_font_types']);
}

$font_types = apply_filters('nasa_product_font_types_custom_fields', $font_types);

/**
 * Font colours
 */
$font_colours = array('Black', 'White', 'Silver', 'Gold');
if (isset($nasa_opt['personalize_font_colours']) && trim($nasa_opt['personalize_font_colours']) != '') {
    $font_colours = explode(',', $nasa_opt['personalize_font_colours']);
}

$font_colours = apply_filters('nasa_product_font_colours_custom_fields', $font_colours);

/**
 * Font Orientations
 */
$orientations = apply_filters('nasa_product_font_orientations_custom_fields', array(
    esc_html__('Portrait', 'nasa-core'),
    esc_html__('Landscape', 'nasa-core')
));
?>

<script type="text/template" id="nasa-single-product-custom-fields">
    <div class="nasa-ct-fields-add-to-cart nasa-not-in-sticky">
        <a href="javascript:void(0);" class="nasa-ct-fields-toggle" rel="nofollow">
            <input class="hidden-tag" type="checkbox" name="nasa-ct-fields-check" value="1" />
            <?php echo esc_html__('Customize this item?', 'nasa-core'); ?>
        </a>
        
        <div class="hidden-tag nasa-ct-fields-wrap">
            <?php
            /**
             * Font Types
             */
            if (!empty($font_types)) : ?>
                <div class="nasa-ct-field">
                    <label for="nasa-ct-font-type">
                        <?php echo esc_html__("Font Type", 'nasa-core'); ?>
                    </label>
                    <select id="nasa-ct-font-type" name="nasa-ct-font-type">
                        <?php
                        foreach ($font_types as $font_type) :
                            $font_type = trim($font_type);
                            echo '<option value="' . esc_attr($font_type). '">' . $font_type . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            <?php endif; ?>
                
            <?php
            /**
             * Font Colours
             */
            if (!empty($font_colours)) : ?>
                <div class="nasa-ct-field">
                    <label for="nasa-ct-font-colour">
                        <?php echo esc_html__("Font Colour", 'nasa-core'); ?>
                    </label>
                    <select id="nasa-ct-font-colour" name="nasa-ct-font-colour">
                        <?php
                        foreach ($font_colours as $font_colour) :
                            $font_colour = trim($font_colour);
                            echo '<option value="' . esc_attr($font_colour). '">' . $font_colour . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            <?php endif; ?>
            
            <?php
            /**
             * Font Orientation
             */
            if (!empty($orientations)) : ?>
                <div class="nasa-ct-field">
                    <label for="nasa-ct-font-orientation">
                        <?php echo esc_html__("Font Orientation", 'nasa-core'); ?>
                    </label>
                    <select id="nasa-ct-font-orientation" name="nasa-ct-font-orientation">
                        <?php
                        foreach ($orientations as $orientation) :
                            echo '<option value="' . esc_attr($orientation). '">' . $orientation . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            <?php endif; ?>
        
            <?php
            /**
             * Personalized Text
             */
            ?>
            <div class="nasa-ct-field">
                <label for="nasa-ct-personalized">
                    <?php echo esc_html__("Enter personalized text", 'nasa-core'); ?>
                </label>
                <textarea class="nasa-require" id="nasa-ct-personalized" name="nasa-ct-personalized"></textarea>
            </div>
        </div>
    </div>
</script>
