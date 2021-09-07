<?php
$displays = array(
    "" => esc_html__("Default", 'nasa-core'),
    "show" => esc_html__("Enable", 'nasa-core'),
    "hide" => esc_html__("Disable", 'nasa-core')
);

if (is_object($term) && $term) {
    $custom_tax = get_term_meta($term->term_id, $this->_custom_tax, true);
    if (!isset($custom_tax)) {
        $custom_tax = add_term_meta($term->term_id, $this->_custom_tax, '', true);
    }
    ?>
    <!-- Filter Custom Taxonomies -->
    <tr class="form-field nasa-term-root hidden-tag term-custom_tax-wrap">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_custom_tax; ?>"><?php esc_html_e('Show Filter Custom Taxonomies', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($custom_tax) ? $custom_tax : '';
            echo '<p><select id="' . $this->_custom_tax . '" name="' . $this->_custom_tax . '">';
            foreach ($displays as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <?php
} else {
    ?>
    <!-- Filter Custom Taxonomies -->
    <div class="form-field term-custom_tax-wrap nasa-term-root hidden-tag">
        <label for="<?php echo $this->_custom_tax; ?>"><?php esc_html_e('Show Filter Custom Taxonomies', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_custom_tax . '" name="' . $this->_custom_tax . '">';
            foreach ($displays as $slug => $name) {
                echo '<option value="' . $slug . '">' . $name . '</option>';
            }
            echo '</select></p>';
        ?>
    </div>
    <?php
}
