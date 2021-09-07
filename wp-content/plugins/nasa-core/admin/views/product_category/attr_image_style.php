<?php
$display_type = array(
    "" => esc_html__("Default", 'nasa-core'),
    "round" => esc_html__("Round", 'nasa-core'),
    "square" => esc_html__("Square", 'nasa-core')
);

if (is_object($term) && $term) {
    $cat_attr_display_type = get_term_meta($term->term_id, $this->_cat_attr_image_style, true);
    if (!isset($cat_attr_display_type)) {
        $cat_attr_display_type = add_term_meta($term->term_id, $this->_cat_attr_image_style, '', true);
    }
    ?>
    <tr class="form-field nasa-term-root hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_attr_image_style; ?>"><?php esc_html_e('Attribule Image Style', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_attr_display_type) ? $cat_attr_display_type : '';
            echo '<p><select id="' . $this->_cat_attr_image_style . '" name="' . $this->_cat_attr_image_style . '">';
            foreach ($display_type as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
<?php } else { ?>
    <div class="form-field nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_attr_image_style; ?>"><?php esc_html_e('Attribule Image Style', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_attr_image_style . '" name="' . $this->_cat_attr_image_style . '">';
        foreach ($display_type as $slug => $name) {
            echo '<option value="' . $slug . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <?php
}
