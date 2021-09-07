<div class="nasa-slide-item nasa-wrap-item">
    <a href="javascript:void(0);" class="nasa-slide-title nasa-toggle-title">
        <?php echo esc_html__('Slide Item', 'nasa-core'); ?>&nbsp;#<?php echo $order; ?>
    </a>
    
    <a href="javascript:void(0);" class="nasa-slide-remove nasa-remove-item">
        <?php echo esc_html__('Remove ', 'nasa-core'); ?>
    </a>
    
    <div class="nasa-slide-options nasa-item-options">
        <?php $this->form_slide($slide, $data_name, $data_id, $order); ?>
    </div>
</div>
