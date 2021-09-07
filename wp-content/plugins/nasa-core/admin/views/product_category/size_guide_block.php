<?php
$blocks = nasa_get_blocks_options();
            
if (is_object($term) && $term) {
    $selected = get_term_meta($term->term_id, $this->_cat_size_guide_block, true);

    if (!isset($selected)) {
        $selected = add_term_meta($term->term_id, $this->_cat_size_guide_block, '', true);
    }

    ?>
    <tr class="form-field nasa-term-root hidden-tag term-cat_size_guide_block-wrap">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_size_guide_block; ?>"><?php esc_html_e('Size Guide Content', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            if ($blocks) {
                echo '<p><select id="' . $this->_cat_size_guide_block . '" name="' . $this->_cat_size_guide_block . '">';
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
    <div class="form-field term-cat_size_guide_block-wrap nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_size_guide_block; ?>"><?php esc_html_e('Bottom Content', 'nasa-core'); ?></label>
        <?php
        if ($blocks) {
            echo '<p><select id="' . $this->_cat_size_guide_block . '" name="' . $this->_cat_size_guide_block . '">';
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