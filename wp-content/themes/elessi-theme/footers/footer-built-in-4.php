<?php if (is_active_sidebar('footer-dark-1-1')) : ?>
    <div class="section-element footer-dark desktop-padding-top-60 mobile-padding-top-20 padding-bottom-20">
        <?php
        // No.1
        dynamic_sidebar('footer-dark-1-1'); ?>
    </div>
<?php endif; ?>

<?php if (is_active_sidebar('footer-dark-1-2')) : ?>
    <div class="section-element footer-dark padding-top-30 padding-bottom-30">
        <div class="row">
            <div class="large-12 nasa-col columns">
                <?php
                // No.2
                dynamic_sidebar('footer-dark-1-2'); ?>
            </div>
        </div>
    </div>
<?php
endif;
