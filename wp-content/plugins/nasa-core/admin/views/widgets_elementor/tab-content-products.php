<div class="nasa-tab-content nasa-wrap-item">
    <a href="javascript:void(0);" class="nasa-tab-title nasa-toggle-title">
        <?php echo esc_html__('Tab', 'nasa-core'); ?>&nbsp;#<?php echo $order; ?>
    </a>
    
    <a href="javascript:void(0);" class="nasa-tab-remove nasa-remove-item">
        <?php echo esc_html__('Remove ', 'nasa-core'); ?>
    </a>
    
    <div class="nasa-tab-options nasa-item-options">
        <?php $this->form_tab($tab, $data_name, $data_id, $order); ?>
    </div>
</div>
