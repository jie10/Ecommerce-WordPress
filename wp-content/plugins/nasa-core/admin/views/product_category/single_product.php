<?php
$layouts = nasa_single_product_layouts();
$imageLayouts = nasa_single_product_images_layout();
$imageStyles = nasa_single_product_images_style();
$thumbStyles = nasa_single_product_thumbs_style();
$tabsStyles = nasa_single_product_tabs_style();

if (is_object($term) && $term) {
    $selected = get_term_meta($term->term_id, $this->_product_layout, true);
    if (!isset($selected)) {
        $selected = add_term_meta($term->term_id, $this->_product_layout, '', true);
    }
    ?>

    <tr class="form-field nasa-term-root hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_product_layout; ?>">
                <?php _e('Single Product Layout', 'nasa-core'); ?>
            </label>
        </th>
        <td>
            <div class="nasa_single_layout">
                <?php
                echo '<p><select id="' . $this->_product_layout . '" name="' . $this->_product_layout . '">';
                foreach ($layouts as $slug => $name) {
                    echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
                }
                echo '</select></p>';
                ?>
            </div>
       </td>
    </tr>

    <!-- Images layout for New -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_product_layout . ' nasa-term-' . $this->_product_layout . '-new'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_product_image_layout; ?>">
                <?php _e('Image Layout', 'nasa-core'); ?>
            </label>
        </th>
        <td>
            <div class="nasa_single_layout">
                <?php
                $selected = get_term_meta($term->term_id, $this->_product_image_layout, true);
                if (!isset($selected)) {
                    $selected = add_term_meta($term->term_id, $this->_product_image_layout, '', true);
                }

                echo '<p><select id="' . $this->_product_image_layout . '" name="' . $this->_product_image_layout . '">';
                foreach ($imageLayouts as $slug => $name) {
                    echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
                }
                echo '</select></p>';
                ?>
            </div>
       </td>
    </tr>

    <!-- Images Style for New -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_product_layout . ' nasa-term-' . $this->_product_layout . '-new'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_product_image_style; ?>">
                <?php _e('Image Style', 'nasa-core'); ?>
            </label>
        </th>
        <td>
            <div class="nasa_single_layout">
                <?php
                $selected = get_term_meta($term->term_id, $this->_product_image_style, true);

                if (!isset($selected)) {
                    $selected = add_term_meta($term->term_id, $this->_product_image_style, '', true);
                }

                echo '<p><select id="' . $this->_product_image_style . '" name="' . $this->_product_image_style . '">';
                foreach ($imageStyles as $slug => $name) {
                    echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
                }
                echo '</select></p>';
                ?>
            </div>
       </td>
    </tr>

    <!-- Thumbnail Style for New -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_product_layout . ' nasa-term-' . $this->_product_layout . '-classic'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_product_thumbs_style; ?>">
                <?php _e('Thumbnail Style', 'nasa-core'); ?>
            </label>
        </th>
        <td>
            <div class="nasa_single_layout">
                <?php
                $selected = get_term_meta($term->term_id, $this->_product_thumbs_style, true);

                if (!isset($selected)) {
                    $selected = add_term_meta($term->term_id, $this->_product_thumbs_style, '', true);
                }

                echo '<p><select id="' . $this->_product_thumbs_style . '" name="' . $this->_product_thumbs_style . '">';
                foreach ($thumbStyles as $slug => $name) {
                    echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
                }
                echo '</select></p>';
                ?>
            </div>
       </td>
    </tr>

    <!-- Tab style -->
    <tr class="form-field nasa-term-root hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_product_tabs_style; ?>">
                <?php _e('Single Product Tabs', 'nasa-core'); ?>
            </label>
        </th>
        <td>
            <div class="nasa_single_tab_style">
                <?php
                $selected = get_term_meta($term->term_id, $this->_product_tabs_style, true);
                echo '<p><select id="' . $this->_product_tabs_style . '" name="' . $this->_product_tabs_style . '">';
                foreach ($tabsStyles as $slug => $name) {
                    echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
                }
                echo '</select></p>';
                ?>
            </div>
       </td>
    </tr>

<?php } else { ?>

    <div class="form-field nasa-term-root hidden-tag">
        <label for="<?php echo $this->_product_layout; ?>">
            <?php _e('Single Product Layout', 'nasa-core'); ?>
        </label>
        <div class="nasa_single_layout">
            <select name="<?php echo $this->_product_layout; ?>" id="<?php echo $this->_product_layout; ?>" class="postform">
                <?php
                foreach ($layouts as $slug => $name) {
                    echo '<option value="' . $slug . '">' . $name . '</option>';
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Image Layout for New -->
    <div class="form-field nasa-term-root-child <?php echo $this->_product_layout . ' nasa-term-' . $this->_product_layout . '-new'; ?> hidden-tag">
        <label for="<?php echo $this->_product_image_layout; ?>">
            <?php _e('Image Layout', 'nasa-core'); ?>
        </label>
        <div class="nasa_single_layout">
            <?php
            echo '<select id="' . $this->_product_image_layout . '" name="' . $this->_product_image_layout . '">';
            foreach ($imageLayouts as $slug => $name) {
                echo '<option value="' . $slug . '">' . $name . '</option>';
            }
            echo '</select>';
            ?>
        </div>
    </div>

    <!-- Image Style for New -->
    <div class="form-field nasa-term-root-child <?php echo $this->_product_layout . ' nasa-term-' . $this->_product_layout . '-new'; ?> hidden-tag">
        <label for="<?php echo $this->_product_image_style; ?>">
            <?php _e('Image Style', 'nasa-core'); ?>
        </label>
        <div class="nasa_single_layout">
            <?php
            echo '<select id="' . $this->_product_image_style . '" name="' . $this->_product_image_style . '">';
            foreach ($imageStyles as $slug => $name) {
                echo '<option value="' . $slug . '">' . $name . '</option>';
            }
            echo '</select>';
            ?>
        </div>
    </div>

    <!-- Thumbnail Style for New -->
    <div class="form-field nasa-term-root-child <?php echo $this->_product_layout . ' nasa-term-' . $this->_product_layout . '-classic'; ?> hidden-tag">
        <label for="<?php echo $this->_product_thumbs_style; ?>">
            <?php _e('Thumnail Style', 'nasa-core'); ?>
        </label>
        <div class="nasa_single_layout">
            <?php
            echo '<select id="' . $this->_product_thumbs_style . '" name="' . $this->_product_thumbs_style . '">';
            foreach ($thumbStyles as $slug => $name) {
                echo '<option value="' . $slug . '">' . $name . '</option>';
            }
            echo '</select>';
            ?>
        </div>
    </div>

    <!-- Tab style -->
    <div class="form-field nasa-term-root hidden-tag">
        <label for="<?php echo $this->_product_tabs_style; ?>">
            <?php _e('Single Product Tabs', 'nasa-core'); ?>
        </label>
        <div class="nasa_single_layout">
            <select name="<?php echo $this->_product_tabs_style; ?>" id="<?php echo $this->_product_tabs_style; ?>" class="postform">
                <?php
                foreach ($tabsStyles as $slug => $name) {
                    echo '<option value="' . $slug . '">' . $name . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
<?php
}
