<?php
$blocks = nasa_get_blocks_options();
            
if (is_object($term) && $term) {
    $selected = get_term_meta($term->term_id, $this->_cat_footer_content, true);

    if (!isset($selected)) {
        $selected = add_term_meta($term->term_id, $this->_cat_footer_content, '', true);
    }

    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_footer_content; ?>"><?php esc_html_e('Bottom Content', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            if ($blocks) {
                echo '<p><select id="' . $this->_cat_footer_content . '" name="' . $this->_cat_footer_content . '">';
                foreach ($blocks as $slug => $name) {
                    echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
                }
                echo '</select></p>';
            }
            ?>
            <p class="description"><?php esc_html_e('Please create Static Blocks and select here.', 'nasa-core'); ?></p>
        </td>
    </tr>
    <?php
} else {
    ?>
    <div class="form-field term-cat_header-wrap">
        <label for="<?php echo $this->_cat_footer_content; ?>"><?php esc_html_e('Bottom Content', 'nasa-core'); ?></label>
        <?php
        if ($blocks) {
            echo '<p><select id="' . $this->_cat_footer_content . '" name="' . $this->_cat_footer_content . '">';
            foreach ($blocks as $slug => $name) {
                echo '<option value="' . $slug . '">' . $name . '</option>';
            }
            echo '</select></p>';
        }
        ?>
        <p class="description"><?php esc_html_e('Please create Static Blocks and select here.', 'nasa-core'); ?></p>
    </div>
    <?php
}