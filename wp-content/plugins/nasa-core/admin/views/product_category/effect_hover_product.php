<?php
$effect_type = nasa_product_hover_effect_types();
            
if (is_object($term) && $term) {
    $cat_effect_type = get_term_meta($term->term_id, $this->_cat_effect_hover, true);
    if (!isset($cat_effect_type)) {
        $cat_effect_type = add_term_meta($term->term_id, $this->_cat_effect_hover, '', true);
    }
    ?>
    <tr class="form-field nasa-term-root hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_effect_hover; ?>"><?php esc_html_e('Override effect hover product', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_effect_type) ? $cat_effect_type : '';
            echo '<p><select id="' . $this->_cat_effect_hover . '" name="' . $this->_cat_effect_hover . '">';
            foreach ($effect_type as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
<?php } else { ?>
    <div class="form-field nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_effect_hover; ?>"><?php esc_html_e('Override effect hover product', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_effect_hover . '" name="' . $this->_cat_effect_hover . '">';
        foreach ($effect_type as $slug => $name) {
            echo '<option value="' . $slug . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <?php
}
