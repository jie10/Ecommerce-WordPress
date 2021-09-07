<?php
$select_values = array(
    '' => esc_html__('Default', 'nasa-core'),
    '1' => esc_html__('Yes', 'nasa-core'),
    '-1' => esc_html__('No', 'nasa-core')
);
            
if (is_object($term) && $term) {
    $cat_bg_dark = get_term_meta($term->term_id, $this->_cat_bg_dark, true);

    if (!isset($cat_bg_dark)) {
        $cat_bg_dark = add_term_meta($term->term_id, $this->_cat_bg_dark, '', true);
    }

    ?>
    <tr class="form-field nasa-term-root hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_bg_dark; ?>"><?php esc_html_e('Dark Version', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            echo '<p><select id="' . $this->_cat_bg_dark . '" name="' . $this->_cat_bg_dark . '">';
            foreach ($select_values as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($cat_bg_dark == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <?php
} else {
    ?>
    <div class="form-field term-cat_bg_dark-wrap nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_bg_dark; ?>"><?php esc_html_e('Dark Version', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_bg_dark . '" name="' . $this->_cat_bg_dark . '">';
        foreach ($select_values as $slug => $name) {
            echo '<option value="' . $slug . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <?php
}
