<?php
if (is_object($term) && $term) {
    $primary_color = get_term_meta($term->term_id, $this->_cat_primary_color, true);
    if (!isset($primary_color)) {
        $primary_color = add_term_meta($term->term_id, $this->_cat_primary_color, '', true);
    }
    ?>
    <tr class="form-field nasa-term-root nasa-term-primary_color hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_primary_color; ?>"><?php _e('Override Primary Color', 'nasa-core'); ?></label>
        </th>
        <td>
            <div class="nasa_p_color">
                <input type="text" class="widefat nasa-color-field" id="<?php echo $this->_cat_primary_color; ?>" name="<?php echo $this->_cat_primary_color; ?>" value="<?php echo isset($primary_color) ? esc_attr($primary_color) : ''; ?>" />
            </div>
       </td>
    </tr>
<?php } else { ?>
    <div class="form-field nasa-term-root nasa-term-primary_color hidden-tag">
        <label for="<?php echo $this->_cat_primary_color; ?>"><?php _e('Override Primary Color', 'nasa-core'); ?></label>
        <div class="nasa_p_color">
            <input type="text" class="widefat nasa-color-field" id="<?php echo $this->_cat_primary_color; ?>" name="<?php echo $this->_cat_primary_color; ?>" value="" />
        </div>
    </div>
<?php
}
