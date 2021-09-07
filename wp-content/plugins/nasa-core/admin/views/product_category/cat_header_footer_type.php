<?php
$header_builder = nasa_get_headers_options();
$footer_builder = nasa_get_footers_options();
$footer_builder_e = nasa_get_footers_elementor();
$menu_options = nasa_meta_get_list_menus();

$footer_desk = $footer_builder;
if (isset($footer_desk[''])) {
    unset($footer_desk['']);
}

if (is_object($term) && $term) {
    $cat_header_type = get_term_meta($term->term_id, $this->_cat_header_type, true);
    if (!isset($cat_header_type)) {
        $cat_header_type = add_term_meta($term->term_id, $this->_cat_header_type, '', true);
    }

    $cat_header_builder = get_term_meta($term->term_id, $this->_cat_header_builder, true);
    if (!isset($cat_header_builder)) {
        $cat_header_builder = add_term_meta($term->term_id, $this->_cat_header_builder, '', true);
    }

    $cat_header_vertical_menu = get_term_meta($term->term_id, $this->_cat_header_vertical_menu, true);
    if (!isset($cat_header_vertical_menu)) {
        $cat_header_vertical_menu = add_term_meta($term->term_id, $this->_cat_header_vertical_menu, '', true);
    }

    $cat_footer_mode = get_term_meta($term->term_id, $this->_cat_footer_mode, true);
    if (!isset($cat_footer_mode)) {
        $cat_footer_mode = add_term_meta($term->term_id, $this->_cat_footer_mode, '', true);
    }
    
    $cat_footer_build_in = get_term_meta($term->term_id, $this->_cat_footer_build_in, true);
    if (!isset($cat_footer_build_in)) {
        $cat_footer_build_in = add_term_meta($term->term_id, $this->_cat_footer_build_in, '', true);
    }

    $cat_footer_build_in_mobile = get_term_meta($term->term_id, $this->_cat_footer_build_in_mobile, true);
    if (!isset($cat_footer_build_in_mobile)) {
        $cat_footer_build_in_mobile = add_term_meta($term->term_id, $this->_cat_footer_build_in_mobile, '', true);
    }
    
    $cat_footer_type = get_term_meta($term->term_id, $this->_cat_footer_type, true);
    if (!isset($cat_footer_type)) {
        $cat_footer_type = add_term_meta($term->term_id, $this->_cat_footer_type, '', true);
    }

    $cat_footer_mobile = get_term_meta($term->term_id, $this->_cat_footer_mobile, true);
    if (!isset($cat_footer_mobile)) {
        $cat_footer_mobile = add_term_meta($term->term_id, $this->_cat_footer_mobile, '', true);
    }
    
    $cat_footer_e = get_term_meta($term->term_id, $this->_cat_footer_builder_e, true);
    if (!isset($cat_footer_e)) {
        $cat_footer_e = add_term_meta($term->term_id, $this->_cat_footer_builder_e, '', true);
    }

    $cat_footer_e_mobile = get_term_meta($term->term_id, $this->_cat_footer_builder_e_mobile, true);
    if (!isset($cat_footer_e_mobile)) {
        $cat_footer_e_mobile = add_term_meta($term->term_id, $this->_cat_footer_builder_e_mobile, '', true);
    }
    ?>
    <!-- Header type -->
    <tr class="form-field nasa-term-root hidden-tag term-cat_header-type-wrap">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_header_type; ?>"><?php esc_html_e('Override Header type', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_header_type) ? $cat_header_type : '';
            echo '<p><select id="' . $this->_cat_header_type . '" name="' . $this->_cat_header_type . '">';
            echo '<option value="">' . esc_html__("Default", 'nasa-core') . '</option>';
            echo '<option value="1"' . ($selected == '1' ? ' selected' : '') . '>' . esc_html__('Header Type 1', 'nasa-core') . '</option>';
            echo '<option value="2"' . ($selected == '2' ? ' selected' : '') . '>' . esc_html__('Header Type 2', 'nasa-core') . '</option>';
            echo '<option value="3"' . ($selected == '3' ? ' selected' : '') . '>' . esc_html__('Header Type 3', 'nasa-core') . '</option>';
            echo '<option value="4"' . ($selected == '4' ? ' selected' : '') . '>' . esc_html__('Header Type 4', 'nasa-core') . '</option>';
            echo '<option value="5"' . ($selected == '5' ? ' selected' : '') . '>' . esc_html__('Header Type 5', 'nasa-core') . '</option>';
            echo '<option value="nasa-custom"' . ($selected == 'nasa-custom' ? ' selected' : '') . '>' . esc_html__('Header Builder', 'nasa-core') . '</option>';
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <tr class="form-field term-cat_header-builder-wrap nasa-term-root-child <?php echo $this->_cat_header_type . ' nasa-term-' . $this->_cat_header_type . '-nasa-custom'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_header_builder; ?>"><?php esc_html_e('Header Builder', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_header_builder[0]) ? $cat_header_builder[0] : '';
            echo '<p><select id="' . $this->_cat_header_builder . '" name="' . $this->_cat_header_builder . '">';
            foreach ($header_builder as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Header type -->

    <!-- Vertical Menu -->
    <tr class="form-field nasa-term-root hidden-tag term-cat_header-vertical-menu-wrap">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_header_vertical_menu; ?>"><?php esc_html_e('Header Vertical Menu', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_header_vertical_menu) ? $cat_header_vertical_menu : '';
            echo '<p><select id="' . $this->_cat_header_vertical_menu . '" name="' . $this->_cat_header_vertical_menu . '">';
            foreach ($menu_options as $id => $name) {
                echo '<option value="' . $id . '"' . ($selected == $id ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Vertical Menu -->
    
    <!-- Footer Mode -->
    <tr class="form-field nasa-term-root hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_footer_mode; ?>"><?php esc_html_e('Override Footer Mode', 'nasa-core'); ?></label>
        </th>
        <td>
            <?php
            $selected = isset($cat_footer_mode) ? $cat_footer_mode : '';
            echo '<p><select id="' . $this->_cat_footer_mode . '" name="' . $this->_cat_footer_mode . '">';
            echo '<option value="">' . esc_html__("Default", 'nasa-core') . '</option>';
            echo '<option value="build-in"' . ($selected == 'build-in' ? ' selected' : '') . '>' . esc_html__('Build-in', 'nasa-core') . '</option>';
            echo '<option value="builder"' . ($selected == 'builder' ? ' selected' : '') . '>' . esc_html__('Builder', 'nasa-core') . '</option>';
            
            if (NASA_ELEMENTOR_ACTIVE && NASA_HF_BUILDER) :
                echo '<option value="builder-e"' . ($selected == 'builder-e' ? ' selected' : '') . '>' . esc_html__('Elementor Builder', 'nasa-core') . '</option>';
            endif;
            
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Footer mode -->
    
    <!-- Footer build-in -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-build-in'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_footer_build_in; ?>"><?php esc_html_e('Override Footer Build-in', 'nasa-core'); ?></label>
        </th>
        <td>
            <?php
            $selected = isset($cat_footer_build_in) ? $cat_footer_build_in : '';
            echo '<p><select id="' . $this->_cat_footer_build_in . '" name="' . $this->_cat_footer_build_in . '">';
            echo '<option value="1"' . ($selected == '1' ? ' selected' : '') . '>' . esc_html__('Build-in Light 1', 'nasa-core') . '</option>';
            echo '<option value="2"' . ($selected == '2' ? ' selected' : '') . '>' . esc_html__('Build-in Light 2', 'nasa-core') . '</option>';
            echo '<option value="3"' . ($selected == '3' ? ' selected' : '') . '>' . esc_html__('Build-in Light 3', 'nasa-core') . '</option>';
            echo '<option value="4"' . ($selected == '4' ? ' selected' : '') . '>' . esc_html__('Build-in Dark', 'nasa-core') . '</option>';
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Footer build-in -->

    <!-- Footer build-in mobile -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-build-in'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_footer_build_in_mobile; ?>"><?php esc_html_e('Override Footer Build-in Mobile', 'nasa-core'); ?></label>
        </th>
        <td>
            <?php
            $selected = isset($cat_footer_build_in_mobile) ? $cat_footer_build_in_mobile : '';
            echo '<p><select id="' . $this->_cat_footer_build_in_mobile . '" name="' . $this->_cat_footer_build_in_mobile . '">';
            echo '<option value="">' . esc_html__('Extends from Desktop', 'nasa-core') . '</option>';
            echo '<option value="m-1"' . ($selected == 'm-1' ? ' selected' : '') . '>' . esc_html__('Buil-in Mobile', 'nasa-core') . '</option>';
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Footer build-in mobile -->

    <!-- Footer Builder -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-builder'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_footer_type; ?>"><?php esc_html_e('Override Footer Builder', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_footer_type) ? $cat_footer_type : '';
            echo '<p><select id="' . $this->_cat_footer_type . '" name="' . $this->_cat_footer_type . '">';
            foreach ($footer_desk as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Footer Builder -->

    <!-- Footer Builder Mobile -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-builder'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_footer_mobile; ?>"><?php esc_html_e('Override Footer Builder Mobile', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_footer_mobile) ? $cat_footer_mobile : '';
            echo '<p><select id="' . $this->_cat_footer_mobile . '" name="' . $this->_cat_footer_mobile . '">';
            foreach ($footer_builder as $slug => $name) {
                echo '<option value="' . $slug . '"' . ($selected == $slug ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Footer Builder Mobile -->
    
    <!-- Footer Builder Elementor -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-builder-e'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_footer_builder_e; ?>"><?php esc_html_e('Override Footer Builder Elementor', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_footer_e) ? $cat_footer_e : '';
            echo '<p><select id="' . $this->_cat_footer_builder_e . '" name="' . $this->_cat_footer_builder_e . '">';
            foreach ($footer_builder_e as $fid => $name) {
                echo '<option value="' . $fid . '"' . ($selected == $fid ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Footer Builder Elementor -->

    <!-- Footer Builder Elementor Mobile -->
    <tr class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-builder-e'; ?> hidden-tag">
        <th scope="row" valign="top">
            <label for="<?php echo $this->_cat_footer_builder_e_mobile; ?>"><?php esc_html_e('Override Footer Builder Elementor Mobile', 'nasa-core'); ?></label>
        </th>
        <td>             
            <?php
            $selected = isset($cat_footer_e_mobile) ? $cat_footer_e_mobile : '';
            echo '<p><select id="' . $this->_cat_footer_builder_e_mobile . '" name="' . $this->_cat_footer_builder_e_mobile . '">';
            foreach ($footer_builder_e as $fid => $name) {
                echo '<option value="' . $fid . '"' . ($selected == $fid ? ' selected' : '') . '>' . $name . '</option>';
            }
            echo '</select></p>';
            ?>
        </td>
    </tr>
    <!-- End Footer Builder Elementor Mobile -->
    <?php
} else {
    ?>
    <!-- Header type -->
    <div class="form-field term-cat_header-type-wrap nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_header_type; ?>"><?php esc_html_e('Override Header type', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_header_type . '" name="' . $this->_cat_header_type . '">';
        echo '<option value="">' . esc_html__("Default", 'nasa-core') . '</option>';
        echo '<option value="1">' . esc_html__('Header Type 1', 'nasa-core') . '</option>';
        echo '<option value="2">' . esc_html__('Header Type 2', 'nasa-core') . '</option>';
        echo '<option value="3">' . esc_html__('Header Type 3', 'nasa-core') . '</option>';
        echo '<option value="4">' . esc_html__('Header Type 4', 'nasa-core') . '</option>';
        echo '<option value="5">' . esc_html__('Header Type 5', 'nasa-core') . '</option>';
        echo '<option value="nasa-custom">' . esc_html__('Header Builder', 'nasa-core') . '</option>';
        echo '</select></p>';
        ?>
    </div>
    <div class="form-field term-cat_header-builder-wrap nasa-term-root-child <?php echo $this->_cat_header_type . ' nasa-term-' . $this->_cat_header_type . '-nasa-custom'; ?> hidden-tag">
        <label for="<?php echo $this->_cat_header_builder; ?>"><?php esc_html_e('Header Builder', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_header_builder . '" name="' . $this->_cat_header_builder . '">';
        foreach ($header_builder as $slug => $name) {
            echo '<option value="' . $slug . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <!-- End Header type -->

    <!-- Vertical Menu -->
    <div class="form-field term-cat_header-vertical-menu-wrap nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_header_vertical_menu; ?>"><?php esc_html_e('Header Vertical Menu', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_header_vertical_menu . '" name="' . $this->_cat_header_vertical_menu . '">';
        foreach ($menu_options as $id => $name) {
            echo '<option value="' . $id . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <!-- Vertical Menu -->
    
    <!-- Footer Mode -->
    <div class="form-field nasa-term-root hidden-tag">
        <label for="<?php echo $this->_cat_footer_mode; ?>"><?php esc_html_e('Override Footer Mode', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_footer_mode . '" name="' . $this->_cat_footer_mode . '">';
        echo '<option value="">' . esc_html__("Default", 'nasa-core') . '</option>';
        echo '<option value="build-in">' . esc_html__('Build-in', 'nasa-core') . '</option>';
        echo '<option value="builder">' . esc_html__('Builder', 'nasa-core') . '</option>';
        
        if (NASA_ELEMENTOR_ACTIVE && NASA_HF_BUILDER) :
            echo '<option value="builder-e">' . esc_html__('Elementor Builder', 'nasa-core') . '</option>';
        endif;
        
        echo '</select></p>';
        ?>
    </div>
    <!-- End Footer mode -->
    
    <!-- Footer build-in -->
    <div class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-build-in'; ?> hidden-tag">
        <label for="<?php echo $this->_cat_footer_build_in; ?>"><?php esc_html_e('Override Footer Build-in', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_footer_build_in . '" name="' . $this->_cat_footer_build_in . '">';
        echo '<option value="1">' . esc_html__('Build-in Light 1', 'nasa-core') . '</option>';
        echo '<option value="2">' . esc_html__('Build-in Light 2', 'nasa-core') . '</option>';
        echo '<option value="3">' . esc_html__('Build-in Light 3', 'nasa-core') . '</option>';
        echo '<option value="4">' . esc_html__('Build-in Dark', 'nasa-core') . '</option>';
        echo '</select></p>';
        ?>
    </div>
    <!-- End Footer build-in -->

    <!-- Footer build-in mobile -->
    <div class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-build-in'; ?> hidden-tag">
        <label for="<?php echo $this->_cat_footer_build_in_mobile; ?>"><?php esc_html_e('Override Footer Build-in Mobile', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_footer_build_in_mobile . '" name="' . $this->_cat_footer_build_in_mobile . '">';
        echo '<option value="">' . esc_html__('Extends from Desktop', 'nasa-core') . '</option>';
        echo '<option value="m-1">' . esc_html__('Build-in Mobile', 'nasa-core') . '</option>';
        echo '</select></p>';
        ?>
    </div>
    <!-- End Footer build-in mobile -->

    <!-- Footer builder -->
    <div class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-builder'; ?> hidden-tag">
        <label for="<?php echo $this->_cat_footer_type; ?>"><?php esc_html_e('Override Footer Builder', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_footer_type . '" name="' . $this->_cat_footer_type . '">';
        foreach ($footer_desk as $slug => $name) {
            echo '<option value="' . $slug . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <!-- End Footer builder -->

    <!-- Footer builder mobile -->
    <div class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-builder'; ?> hidden-tag">
        <label for="<?php echo $this->_cat_footer_mobile; ?>"><?php esc_html_e('Override Footer Builder Mobile', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_footer_mobile . '" name="' . $this->_cat_footer_mobile . '">';
        foreach ($footer_builder as $slug => $name) {
            echo '<option value="' . $slug . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <!-- End Footer builder mobile -->
    
    <!-- Footer builder Elementor -->
    <div class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-builder-e'; ?> hidden-tag">
        <label for="<?php echo $this->_cat_footer_builder_e; ?>"><?php esc_html_e('Override Footer Builder Elementor', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_footer_builder_e . '" name="' . $this->_cat_footer_builder_e . '">';
        foreach ($footer_builder_e as $fid => $name) {
            echo '<option value="' . $fid . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <!-- End Footer builder -->

    <!-- Footer builder mobile -->
    <div class="form-field nasa-term-root-child <?php echo $this->_cat_footer_mode . ' nasa-term-' . $this->_cat_footer_mode . '-builder-e'; ?> hidden-tag">
        <label for="<?php echo $this->_cat_footer_builder_e_mobile; ?>"><?php esc_html_e('Override Footer Builder Elementor Mobile', 'nasa-core'); ?></label>
        <?php
        echo '<p><select id="' . $this->_cat_footer_builder_e_mobile . '" name="' . $this->_cat_footer_builder_e_mobile . '">';
        foreach ($footer_builder_e as $fid => $name) {
            echo '<option value="' . $fid . '">' . $name . '</option>';
        }
        echo '</select></p>';
        ?>
    </div>
    <!-- End Footer builder Elementor mobile -->
    <?php
}
