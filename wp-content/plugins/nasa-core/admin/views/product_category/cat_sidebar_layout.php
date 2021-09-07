<?php
$sidebarLayouts = nasa_get_sidebar_layouts();
            
if (is_object($term) && $term) {
    $cat_sidebar = get_term_meta($term->term_id, $this->_cat_sidebar_layout, true);
    if (!isset($cat_sidebar)) {
        $cat_sidebar = add_term_meta($term->term_id, $this->_cat_sidebar_layout, '', true);
    }
    ?>
    <!-- Header type -->
    <tr class="form-field nasa-term-root hidden-tag term-cat_sidebar_layout-wrap">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_sidebar_layout; ?>"><?php esc_html_e('Override Sidebar Layout', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_sidebar) ? $cat_sidebar : '';
            echo '<p><select id="' . $this->_cat_sidebar_layout . '" name="' . $this->_cat_sidebar_layout . '">';
            foreach ($sidebarLayouts as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <?php
} else {
    ?>
    <!-- Header type -->
    <div class="form-field term-cat_sidebar_layout-wrap nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_sidebar_layout; ?>"><?php esc_html_e('Override Sidebar Layout', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_sidebar_layout . '" name="' . $this->_cat_sidebar_layout . '">';
            foreach ($sidebarLayouts as $slug => $name) {
                echo '<option value="' . $slug . '">' . $name . '</option>';
            }
            echo '</select></p>';
        ?>
    </div>
    <?php
}
