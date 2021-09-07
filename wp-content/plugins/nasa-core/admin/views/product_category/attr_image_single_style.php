<?php
$display_type = array(
    "" => esc_html__("Default - Theme Options", 'nasa-core'),
    "extends" => esc_html__("Extends from Attribule Image Style", 'nasa-core'),
    "square-caption" => esc_html__("Square has Caption", 'nasa-core'),
);

if (is_object($term) && $term) {
    $cat_attr_display_type = get_term_meta($term->term_id, $this->_cat_attr_image_single_style, true);
    if (!isset($cat_attr_display_type)) {
        $cat_attr_display_type = add_term_meta($term->term_id, $this->_cat_attr_image_single_style, '', true);
    }
    ?>
    <tr class="form-field nasa-term-root hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_attr_color_style; ?>"><?php esc_html_e('Attribule Image Style - Single | Quickview', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_attr_display_type) ? $cat_attr_display_type : '';
            echo '<p><select id="' . $this->_cat_attr_image_single_style . '" name="' . $this->_cat_attr_image_single_style . '">';
            foreach ($display_type as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
<?php } else { ?>
    <div class="form-field nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_attr_image_single_style; ?>"><?php esc_html_e('Attribule Image Style - Single | Quickview', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_attr_image_single_style . '" name="' . $this->_cat_attr_image_single_style . '">';
        foreach ($display_type as $slug => $name) {
            echo '<option value="' . $slug . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <?php
}
