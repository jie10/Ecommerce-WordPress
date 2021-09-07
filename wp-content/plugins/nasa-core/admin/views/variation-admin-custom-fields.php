<?php
defined('ABSPATH') or die();

$variation_id = absint($variation->ID);
do_action('nasa_before_custom_fields_variation_admin', $variation_id);
?>

<?php if (!empty($this->_variation_custom_fields)) : ?>
<div class="form-row form-row-full nasa-variation-custom-fields-wrapper nasa-clf">
    <h4 class="first-headling">
        <?php esc_html_e('Variation Custom Fields', 'nasa-core') ?>
    </h4>
    
    <div class="nasa-variation-custom-fields-container">
        <?php
        foreach ($this->_variation_custom_fields as $key => $field) :
            $this->wc_variation_data_custom_fields($variation_id, $key, $field);
        endforeach;
        ?>
    </div>
</div>
<?php endif; ?>

<?php
do_action('nasa_after_custom_fields_variation_admin', $variation_id);

