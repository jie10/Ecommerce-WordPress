<?php
$display_type = array(
    "" => esc_html__("Default", 'nasa-core'),
    "ver-buttons" => esc_html__("Vertical Buttons", 'nasa-core'),
    "hoz-buttons" => esc_html__("Horizontal Buttons", 'nasa-core')
);

if (is_object($term) && $term) {
    $cat_attr_display_type = get_term_meta($term->term_id, $this->_loop_layout_buttons, true);
    if (!isset($cat_attr_display_type)) {
        $cat_attr_display_type = add_term_meta($term->term_id, $this->_loop_layout_buttons, '', true);
    }
    ?>
    <tr class="form-field nasa-term-root hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_loop_layout_buttons; ?>"><?php esc_html_e('Loop Layout Buttons', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_attr_display_type) ? $cat_attr_display_type : '';
            echo '<p><select id="' . $this->_loop_layout_buttons . '" name="' . $this->_loop_layout_buttons . '">';
            foreach ($display_type as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
<?php } else { ?>
    <div class="form-field nasa-term-root hidden-tag">
        <label for="<?php echo $this->_loop_layout_buttons; ?>"><?php esc_html_e('Loop Layout Buttons', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_loop_layout_buttons . '" name="' . $this->_loop_layout_buttons . '">';
        foreach ($display_type as $slug => $name) {
            echo '<option value="' . $slug . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <?php
}
