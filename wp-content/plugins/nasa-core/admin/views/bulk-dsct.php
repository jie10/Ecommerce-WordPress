<?php
defined('ABSPATH') or die();

$bulk_discounts = isset($bulk_discounts) ? $bulk_discounts : array();
$field_name = isset($field_name) ? $field_name : 'nasa_bulk_dsct';
?>

<div class="form-row nasa-wrap-inner nasa-bulk-dsct-wrapper">
    <h4 class="nasa-pd-sides">
        <?php esc_html_e('Bulk Discount Rules', 'nasa-core') ?>
    </h4>
    
    <ul class="nasa-bulk-dsct-list nasa-pd-sides">
        <?php
        if (!empty($bulk_discounts)) :
            foreach ($bulk_discounts as $key => $bulk) : ?>
                <li class="nasa-bulk-dsct-item">
                    <div class="row-flex">
                        <div class="col-flex flex-label">
                                <?php esc_html_e('Quantity', 'nasa-core'); ?>
                            </div>
                            <div class="col-flex flex-input">
                                <input type="number" class="short qty-name" name="qty_rule_<?php echo $key; ?>" value="<?php echo esc_attr($bulk['qty']); ?>" step="1" min="1" />
                            </div>
                        </div>

                        <div class="row-flex">
                            <div class="col-flex flex-label">
                                <?php esc_html_e('Discount', 'nasa-core'); ?>
                            </div>
                            <div class="col-flex flex-input">
                                <input type="number" class="short dsct-name" name="dsct_rule_<?php echo $key; ?>" value="<?php echo esc_attr($bulk['dsct']); ?>" step="any" min="0" />
                            </div>
                        </div>

                        <a href="javascript:void(0);" class="nasa-rm-bulk-dsct" title="<?php echo esc_attr__('Remove', 'nasa-core'); ?>" data-confirm="<?php echo esc_attr__('Are you sure you want to remove it?', 'nasa-core'); ?>"></a>
                </li>
            <?php
            endforeach;
        endif;
        ?>
    </ul>
    
    <input class="bulk-request-values" type="hidden" name="<?php echo esc_attr($field_name); ?>" value="<?php echo $discount_rules_val; ?>" />

    <p class="hide-if-no-js">
        <a href="javascript:void(0);" class="button nasa-add-bulk-dsct" data-name="bulk-dsct">
            <?php esc_html_e('Add New Bulk Discount', 'nasa-core'); ?>
            
            <template>
                <li class="nasa-bulk-dsct-item">
                    <div class="row-flex">
                        <div class="col-flex flex-label">
                            <?php esc_html_e('Quantity', 'nasa-core'); ?>
                        </div>
                        <div class="col-flex flex-input">
                            <input type="number" class="short qty-name" name="qty_rule" value="" step="1" min="1" />
                        </div>
                    </div>
                    
                    <div class="row-flex">
                        <div class="col-flex flex-label">
                            <?php esc_html_e('Discount', 'nasa-core'); ?>
                        </div>
                        <div class="col-flex flex-input">
                            <input type="number" class="short dsct-name" name="dsct_rule" value="" step="any" min="0" />
                        </div>
                    </div>
                    
                    <a href="javascript:void(0);" class="nasa-rm-bulk-dsct" title="<?php echo esc_attr__('Remove', 'nasa-core'); ?>" data-confirm="<?php echo esc_attr__('Are you sure you want to remove it?', 'nasa-core'); ?>"></a>
                </li>
            </template>
        </a>
    </p>
</div>
